
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/deposit/frontend-deposit.js
* File Version            : 1.0
* Created / Last Modified : 08 November 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end deposit JavaScript class.
*/

var DOPBSPFrontEndDeposit = new function(){
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
     * Get deposit data.
     * 
     * @param ID (Number): calendar ID
     * 
     * @retun deposit data
     */
    this.get = function(ID){
        var dataDeposit = DOPBSPFrontEnd.calendar[ID]['deposit']['data'],
        dataWooCommerce = DOPBSPFrontEnd.calendar[ID]['woocommerce']['data'],
        deposit = {'price': 0,
                   'price_type': 'percent'};
        
        if(window.methods_reservation !== undefined) {
            
            if(window.methods_reservation['pay_full'] === true) {
                deposit['price'] = 0;
                deposit['price_type'] = dataDeposit['type'];

                return deposit;
            }
        }

        if (dataDeposit['deposit'] !== 0){
            deposit['price'] = dataDeposit['deposit'];
            deposit['price_type'] = dataDeposit['type'];
        }

        return deposit;
    };
            
    /*
     * Get deposit value.
     * 
     * @param ID (Number): calendar ID
     * @param deposit (Object): deposit data
     * @param totalPrice (Number): reservation total price
     * 
     * @retun deposit price value
     */
    this.getPrice = function(ID,
                             deposit,
                             totalPrice){
        var dataWooCommerce = DOPBSPFrontEnd.calendar[ID]['woocommerce']['data'],
        price = 0;

        price += parseFloat(deposit['price'])
                 *(deposit['price_type'] === 'fixed' ? 1:totalPrice)/
                 (deposit['price_type'] === 'fixed' ? 1:100);

        return price;
    };
            
    /*
     * Set coupon details.
     * 
     * @param ID (Number): calendar ID
     * @param deposit (Object): deposit data
     * @param totalPrice (Number): reservation total price
     * 
     * @retun HTML
     */
    this.set = function(ID,
                        deposit,
                        totalPrice){
        var HTML = new Array(),
        price = 0;

        if (deposit['price'] !== 0){
            price = DOPBSPFrontEndDeposit.getPrice(ID,
                                                   deposit,
                                                   totalPrice);

            HTML.push(' <tr class="dopbsp-deposit">');
            HTML.push('     <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'deposit', 'title')+'</td>');
            HTML.push('     <td class="dopbsp-value">'+DOPBSPFrontEnd.setPrice(ID, price)+'</td>');
            HTML.push(' </tr>');
        }

        return HTML.join('');
    };
    
    return this.__construct();
};