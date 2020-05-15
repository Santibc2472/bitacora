
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/tools/backend-tools.js
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end tools JavaScript class.
*/

var DOPBSPBackEndTools = new function(){
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
     * Display tools.
     */
    this.display = function(){
        $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
    };
    
    /*
     * Toggle buttons on tools page.
     * 
     * @param button (String): button class
     */
    this.toggle = function(button){
        /*
         * Clear previous content.
         */
        DOPBSPBackEnd.clearColumns(2);  

        /*
         * Set buttons.
         */           
        $('#DOPBSP-column1 .dopbsp-tools-item.dopbsp-repair-calendars-settings').removeClass('dopbsp-selected');
        $('#DOPBSP-column1 .dopbsp-tools-item.dopbsp-repair-database-text').removeClass('dopbsp-selected');
        $('#DOPBSP-column1 .dopbsp-tools-item.dopbsp-repair-search-settings').removeClass('dopbsp-selected');
        
        $('#DOPBSP-column1 .dopbsp-tools-item.dopbsp-'+button).addClass('dopbsp-selected');
    };
    
    return this.__construct();
};