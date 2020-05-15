
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.3
* File                    : assets/js/discounts/frontend-discounts.js
* File Version            : 1.0.2
* Created / Last Modified : 21 April 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end discounts JavaScript class.
*/

var DOPBSPFrontEndDiscounts = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Get discount data.
     * 
     * @param ID (Number): calendar ID
     * @param ciDay (String): check in day
     * @param ciDay (String): check in day
     * @param startHour (String): start hour
     * @param endHour (String): start hour
     * 
     * @retun discount data
     */            
    this.get = function(ID,
                        ciDay,
                        coDay,
                        startHour,
                        endHour){
        var dataDays = DOPBSPFrontEnd.calendar[ID]['days']['data'],
        dataDiscounts = DOPBSPFrontEnd.calendar[ID]['discounts']['data'],
        dataHours = DOPBSPFrontEnd.calendar[ID]['hours']['data'],
        discount = {'id': 0,
                    'rule_id': 0,
                    'operation': '-',
                    'price': 0,
                    'price_type': 'percent',
                    'price_by': 'once',
                    'start_date': '',
                    'end_date': '',
                    'start_hour': '',
                    'end_hour': '',
                    'translation': ''},
        discounts = dataDiscounts['discount'], 
        i,
        j,
        rule,
        ruleFound,
        timeLapse;

        /*
         * Verify days/hours.
         */
        coDay = coDay === '' ? ciDay:coDay;
        endHour = endHour === '' ? startHour:endHour;

        /*
         * Calculate time lapse.
         */
        timeLapse = dataHours['enabled'] ? DOPPrototypes.getHoursDifference(startHour, endHour, 'hours')+(dataHours['addLastHourToTotalPrice'] ? 0:0):
                                           DOPPrototypes.getNoDays(ciDay, coDay)-(dataDays['morningCheckOut'] ? 1:0);
        
        if(dataHours['enabled'] 
            && dataHours['interval_autobreak']) {
            
            if(timeLapse%2 === 0) {
                timeLapse = parseInt(timeLapse/2);
            } else {
                timeLapse = parseInt(timeLapse/2)+1;
            }
        }

        for (i=0; i<discounts.length; i++){
            if ((discounts[i]['start_time_lapse'] === ''
                        || parseFloat(discounts[i]['start_time_lapse']) <= timeLapse)
                    && (discounts[i]['end_time_lapse'] === ''
                        || parseFloat(discounts[i]['end_time_lapse']) >= timeLapse)){
                discount['id'] = discounts[i]['id'];
                discount['operation'] = discounts[i]['operation'];
                discount['price'] = discounts[i]['price'];
                discount['price_by'] = discounts[i]['price_by'];
                discount['price_type'] = discounts[i]['price_type'];
                discount['translation'] = discounts[i]['translation'];

                for (j=0; j<discounts[i]['rules'].length; j++){
                    rule = discounts[i]['rules'][j];
                    ruleFound = false;

                    if ((rule['start_date'] === ''
                                || rule['start_date'] <= ciDay)
                            && (rule['end_date'] === ''
                                || rule['end_date'] >= coDay)){
                        if (dataHours['enabled']){
                            if ((rule['start_hour'] === ''
                                        || rule['start_hour'] <= startHour)
                                    && (rule['end_hour'] === ''
                                        || rule['end_hour'] >= endHour)){
                                ruleFound = true;
                            }
                        }
                        else{
                            ruleFound = true;
                        }
                    }

                    if (ruleFound){
                        discount['rule_id'] = rule['id'];
                        discount['operation'] = rule['operation'];
                        discount['price'] = rule['price'];
                        discount['price_by'] = rule['price_by'];
                        discount['price_type'] = rule['price_type'];
                        discount['start_date'] = rule['start_date'];
                        discount['end_date'] = rule['end_date'];

                        break;
                    }
                }
		if (discounts[i]['rules'].length === 0
			&& discounts[i]['price'] !== 0
				|| ruleFound){
		    break;
		}
            }
        }

        return discount;
    };
            
    /*
     * Get discount value.
     * 
     * @param ID (Number): calendar ID
     * @param discount (Object): discount data
     * @param reservationPrice (Number): reservation price
     * @param extrasPrice (Number): extras price
     * @param ciDay (String): check in day
     * @param ciDay (String): check in day
     * @param startHour (String): start hour
     * @param endHour (String): start hour
     * @param noItems (Number): number of reserved items
     * 
     * @retun discount price value
     */
    this.getPrice = function(ID,
                             discount,
                             reservationPrice,
                             extrasPrice,
                             ciDay,
                             coDay,
                             startHour,
                             endHour,
                             noItems){
        var dataDays = DOPBSPFrontEnd.calendar[ID]['days']['data'],
        dataDiscounts = DOPBSPFrontEnd.calendar[ID]['discounts']['data'],
        dataHours = DOPBSPFrontEnd.calendar[ID]['hours']['data'],
        timeLapse;

        /*
         * Verify days/hours.
         */
        coDay = coDay === '' ? ciDay:coDay;
        endHour = endHour === '' ? startHour:endHour;

        /*
         * Calculate price.
         */
        timeLapse = dataHours['enabled'] ? DOPPrototypes.getHoursDifference(startHour, endHour, 'hours')+(dataHours['addLastHourToTotalPrice'] ? 1:0):
                                           DOPPrototypes.getNoDays(ciDay, coDay)-(dataDays['morningCheckOut'] ? 1:0);

        return (discount['operation'] === '-' ? -1:1)
               *(discount['price_by'] === 'once' ? 1:timeLapse)
               *discount['price']
               *(discount['price_type'] === 'fixed' ? noItems:(reservationPrice+(dataDiscounts['extras'] ? extrasPrice:0)))/
               (discount['price_type'] === 'fixed' ? 1:100);
    };
            
    /*
     * Set discount details.
     * 
     * @param ID (Number): calendar ID
     * @param discount (Object): discount data
     * @param reservationPrice (Number): reservation price
     * @param extrasPrice (Number): extras price
     * @param ciDay (String): check in day
     * @param ciDay (String): check in day
     * @param startHour (String): start hour
     * @param endHour (String): start hour
     * @param noItems (Number): number of reserved items
     * 
     * @retun HTML
     */
    this.set = function(ID,
                        discount,
                        reservationPrice,
                        extrasPrice,
                        ciDay,
                        coDay,
                        startHour,
                        endHour,
                        noItems){
        var dataHours = DOPBSPFrontEnd.calendar[ID]['hours']['data'],
        HTML = new Array(),
        price;

        /*
         * Verify days/hours.
         */
        coDay = coDay === '' ? ciDay:coDay;
        endHour = endHour === '' ? startHour:endHour;

        if (discount['price'] > 0){
            price = DOPBSPFrontEndDiscounts.getPrice(ID,
                                                     discount,
                                                     reservationPrice,
                                                     extrasPrice,
                                                     ciDay,
                                                     coDay,
                                                     startHour,
                                                     endHour,
                                                     noItems);

            HTML.push(' <tr class="dopbsp-separator">');
            HTML.push('     <td class="dopbsp-label"><div class="dopbsp-line"></div></td>');
            HTML.push('     <td class="dopbsp-value"><div class="dopbsp-line"></div></td>');
            HTML.push(' </tr>');
            HTML.push(' <tr>');
            HTML.push('     <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'discounts', 'title')+'</td>');
            HTML.push('     <td class="dopbsp-value dopbsp-info">');
            HTML.push('         '+discount['translation']+'<br />');

            if (discount['price_type'] !== 'fixed' 
                    || discount['price_by'] !== 'once'){
                HTML.push('         <span class="dopbsp-info-rule">&#9632;&nbsp;');

                if (discount['price_type'] === 'fixed'){
                    HTML.push(discount['operation']+DOPBSPFrontEnd.setPrice(ID, discount['price']));
                }
                else{
                    HTML.push(discount['operation']+discount['price']+'%');
                }

                if (discount['price_by'] !== 'once'){
                    HTML.push('/'+(dataHours['enabled'] ? DOPBSPFrontEnd.text(ID, 'discounts', 'byHour'):DOPBSPFrontEnd.text(ID, 'discounts', 'byDay')));
                }
                HTML.push('         </span><br />');
            }
            HTML.push('         <span class="dopbsp-info-price">'+discount['operation']+'&nbsp;'+DOPBSPFrontEnd.setPrice(ID, price)+'</span>');

            HTML.push('     </td>');
            HTML.push(' </tr>');
        }

        return HTML.join('');
    };
    
    return this.__construct();
};