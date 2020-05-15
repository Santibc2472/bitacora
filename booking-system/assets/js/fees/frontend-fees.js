
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/fees/frontend-fees.js
* File Version            : 1.0
* Created / Last Modified : 04 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end fees JavaScript class.
*/

var DOPBSPFrontEndFees = new function(){
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
     * Get fees.
     * 
     * @param ID (Number): calendar ID
     * @param reservationPrice (Number): reservation price
     * @param discountPrice (Number): discount price
     * @param extrasPrice (Number): extras price
     * @param ciDay (String): check in day
     * @param ciDay (String): check in day
     * @param startHour (String): start hour
     * @param endHour (String): start hour
     * @param noItems (Number): number of reserved items
     * 
     * @retun fees
     */ 
    this.get = function(ID,
                        reservationPrice,
                        discountPrice,
                        extrasPrice,
                        ciDay,
                        coDay,
                        startHour,
                        endHour,
                        noItems){
        var dataDays = DOPBSPFrontEnd.calendar[ID]['days']['data'],
        dataFees = DOPBSPFrontEnd.calendar[ID]['fees']['data'],
        dataHours = DOPBSPFrontEnd.calendar[ID]['hours']['data'],
        dataWooCommerce = DOPBSPFrontEnd.calendar[ID]['woocommerce']['data'],
        fees = dataFees['fees'],
        i,
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
                                                    
        for (i=0; i<fees.length; i++){
            fees[i]['price_total'] = this.getPrice(ID,
                                                   [fees[i]],
                                                   reservationPrice,
                                                   discountPrice,
                                                   extrasPrice,
                                                   ciDay,
                                                   coDay,
                                                   startHour,
                                                   endHour,
                                                   noItems);
        }
                
        return fees;
    };
    
    /*
     * Get fees value.
     * 
     * @param ID (Number): calendar ID
     * @param fees (Array): list of fees
     * @param reservationPrice (Number): reservation price
     * @param discountPrice (Number): discount price
     * @param extrasPrice (Number): extras price
     * @param ciDay (String): check in day
     * @param ciDay (String): check in day
     * @param startHour (String): start hour
     * @param endHour (String): start hour
     * @param noItems (Number): number of reserved items
     * 
     * @retun fees price value
     */
    this.getPrice = function(ID,
                             fees,
                             reservationPrice,
                             discountPrice,
                             extrasPrice,
                             ciDay,
                             coDay,
                             startHour,
                             endHour,
                             noItems){
        var dataDays = DOPBSPFrontEnd.calendar[ID]['days']['data'],
        dataHours = DOPBSPFrontEnd.calendar[ID]['hours']['data'],
        dataWooCommerce = DOPBSPFrontEnd.calendar[ID]['woocommerce']['data'],
        fee,
        i,
        price = 0,
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

        for (i=0; i<fees.length; i++){
            fee = fees[i];

            if (fee['included'] === 'false'){
                price += (fee['operation'] === '-' ? -1:1)
                         *(fee['price_by'] === 'once' ? 1:timeLapse)
                         *parseFloat(fee['price'])
                         *(fee['price_type'] === 'fixed' ? noItems:(reservationPrice+discountPrice+(fee['extras'] === 'true' ? extrasPrice:0)))/
                         (fee['price_type'] === 'fixed' ? 1:100);
            }
        }

        return price;
    };
    
    /*
     * Set fees details.
     * 
     * @param ID (Number): calendar ID
     * @param type (String): set where to display fees details
     *                       "reservation" display details in reservation
     *                       "cart" display details in cart
     * @param fees (Array): list of fees
     * @param reservationPrice (Number): reservation price
     * @param discountPrice (Number): discount price
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
                        type,
                        fees,
                        ciDay,
                        coDay,
                        startHour,
                        endHour){
        var dataCart = DOPBSPFrontEnd.calendar[ID]['cart']['data'],
        dataHours = DOPBSPFrontEnd.calendar[ID]['hours']['data'],
        HTML = new Array(),
        i;

        /*
         * Verify days/hours.
         */
        coDay = coDay === '' ? ciDay:coDay;
        endHour = endHour === '' ? startHour:endHour;

        if (fees.length > 0){
            HTML.push(' <tr class="dopbsp-separator">');
            HTML.push('     <td class="dopbsp-label"><div class="dopbsp-line"></div></td>');
            HTML.push('     <td class="dopbsp-value"><div class="dopbsp-line"></div></td>');
            HTML.push(' </tr>');
        }

        for (i=0; i<fees.length; i++){
            if ((type === 'reservation'
                            && (fees[i]['cart'] === 'false'
                                    || !dataCart['enabled']))
                    || (type === 'cart'
                            && fees[i]['cart'] === 'true')){
                HTML.push(' <tr>');
                HTML.push('     <td class="dopbsp-label">'+fees[i]['translation']+'</td>');
                HTML.push('     <td class="dopbsp-value">');

                /*
                 * Set fee rule.
                 */

                if (fees[i]['price_type'] !== 'fixed' 
                        || fees[i]['price_by'] !== 'once'){
                    HTML.push('         <span class="dopbsp-info-rule">&#9632;&nbsp;');

                    if (fees[i]['price_type'] === 'fixed'){
                        HTML.push(fees[i]['operation']+DOPBSPFrontEnd.setPrice(ID, fees[i]['price']));
                    }
                    else{
                        HTML.push(fees[i]['operation']+fees[i]['price']+'%');
                    }

                    if (fees[i]['price_by'] !== 'once'){
                        HTML.push('/'+(dataHours['enabled'] ? DOPBSPFrontEnd.text(ID, 'fees', 'byHour'):DOPBSPFrontEnd.text(ID, 'fees', 'byDay')));
                    }
                    HTML.push('         </span><br />');
                }
                HTML.push('         <span class="dopbsp-info-price">');

                /*
                 * Set fee value.
                 */
                if (fees[i]['included'] === 'true'){
                    HTML.push(DOPBSPFrontEnd.text(ID, 'fees', 'included'));
                }
                else{
                    HTML.push(fees[i]['operation']+'&nbsp;'+DOPBSPFrontEnd.setPrice(ID, fees[i]['price_total']));
                }
                HTML.push('         </span>');
                HTML.push('     </td>');
                HTML.push(' </tr>');
            }
        }

        return HTML.join('');
    };
    
    return this.__construct();
};