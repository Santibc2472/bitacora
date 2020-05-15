
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/frontend.js
* File Version            : 1.0
* Created / Last Modified : 08 November 2015
* Author                  : Dot on Paper
* Copyright               : © 2015 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end JavaScript class.
*/

var DOPBSPFrontEnd = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables.
     */
    this.calendar = new Array();

    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Display price with currency in set format.
     * 
     * @param ID (Number): calendar ID
     * @param price (Number): price value
     * 
     * @return price with currency
     */ 
     this.setPrice = function(ID,
                              price){
        var dataCurrency = DOPBSPFrontEnd.calendar[ID]['currency']['data'],
        priceDisplayed = '';

        price = DOPPrototypes.getWithDecimals(Math.abs(price), 
                                              2);

        switch (dataCurrency['position']){
            case 'after':
                priceDisplayed =  price+dataCurrency['sign'];
                break;
            case 'after_with_space':
                priceDisplayed =  price+' '+dataCurrency['sign'];
                break;
            case 'before_with_space':
                priceDisplayed =  dataCurrency['sign']+' '+price;
                break;
            default:
                priceDisplayed =dataCurrency['sign']+price;
        }

        return priceDisplayed;
    };
    
    /*
     * Get text.
     * 
     * @param ID (Number): calendar ID
     * @param section (String): the section for which the text will be displayed
     * @param key (String): text key
     * @param plugin (String): the plugin for which the text will be displayed
     * 
     * @return a string or an array of strings
     */
    this.text = function(ID,
                         section,
                         key,
                         plugin){
        plugin = plugin === undefined ? 'calendar':plugin;
        
        switch (plugin){
            case 'calendar':                 
                return DOPBSPFrontEnd.calendar[ID][section]['text'][key];
                break;
        }
    };
    
    return this.__construct();
};