
/*
 * Title                   : Pinpoint Booking System WordPress Plugin
 * File                    : assets/js/smss/backend-smses.js
 * Author                  : PINPOINT.WORLD
 * Copyright               : © 2018 PINPOINT.WORLD
 * Website                 : https://www.pinpoint.world
 * Description             : Back end SMSes JavaScript class.
 */

var DOPBSPBackEndSmses = new function(){
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
     * Display SMSes list.
     */
    this.display = function(){
        DOPBSPBackEnd.clearColumns(1);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        $.post(ajaxurl, {action: 'dopbsp_smses_display'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('SMSES_LOAD_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};