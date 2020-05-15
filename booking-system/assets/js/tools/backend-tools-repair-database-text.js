
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/settings/backend-tools-repair-database-text.js
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end repair database & text JavaScript class.
*/

var DOPBSPBackEndToolsRepairDatabaseText = new function(){
    'use strict';
    
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Set verify & repair to database & text.
     */
    this.set = function(no){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('TOOLS_REPAIR_DATABASE_TEXT_REPAIRING', 'Verifying and repairing the database & the text ...'));
        
        $.post(ajaxurl, {action: 'dopbsp_tools_repair_database_text_set',
                         dopbsp_repair_database_text: true}, function(data){
            DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('TOOLS_REPAIR_DATABASE_TEXT_SUCCESS', 'The database & the text have been verified and repaired. The page will redirect shortly to Dashboard.'));

            setTimeout(function(){
                window.location.href = $.trim(data);
            }, 300);
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};