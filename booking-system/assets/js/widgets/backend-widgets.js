
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/backend-widgets.js
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end widgets JavaScript class.
*/

var DOPBSPBackEndWidgets = new function(){
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
    
    this.display = function(id,
                            selection){
        $('#DOPBSP-widget-id-'+id).css('display', 'none');
        $('#DOPBSP-widget-lang-'+id).css('display', 'none');

        switch (selection){
            case 'calendar':
                $('#DOPBSP-widget-id-'+id).css('display', 'block');
                $('#DOPBSP-widget-lang-'+id).css('display', 'block');
                break;
            case 'sidebar':
                $('#DOPBSP-widget-id-'+id).css('display', 'block');
                break;
        }
    };
    
    return this.__construct();
};