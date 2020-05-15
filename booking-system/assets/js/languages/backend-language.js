
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/languages/backend-language.js
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end language JavaScript class.
*/

var DOPBSPBackEndLanguage = new function(){
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
     * Change back end language.
     */
    this.change = function(){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));
        
        $.post(ajaxurl, {action: 'dopbsp_language_change',
                         language: $('#DOPBSP-admin-language').val()}, function(data){
            window.location.reload();
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Set language to be used with the plugin.
     * 
     * @param language (String): language code
     */
    this.set = function(language){
        if ($('#DOPBSP-translation-language-'+language).is(':checked')){
            DOPBSPBackEndLanguage.enable(language);
        }
        else{
            DOPBSPBackEnd.confirmation('LANGUAGES_REMOVE_CONFIGURATION', "DOPBSPBackEndLanguage.enable('"+language+"')", "$('#DOPBSP-translation-language-"+language+"').attr('checked', 'checked');");
        }
    };
    
    /*
     * Enable/disable a language.
     * 
     * @param language (String): language code
     */
    this.enable = function(language){
        DOPBSPBackEnd.toggleMessages('active', $('#DOPBSP-translation-language-'+language).is(':checked') ? DOPBSPBackEnd.text('LANGUAGES_SETTING'):DOPBSPBackEnd.text('LANGUAGES_REMOVING'));

        $.post(ajaxurl, {action: 'dopbsp_language_enable',
                         language: language,
                         value: $('#DOPBSP-translation-language-'+language).is(':checked') ? 'true':'false'}, function(data){
            DOPBSPBackEnd.toggleMessages('active', $('#DOPBSP-translation-language-'+language).is(':checked') ? DOPBSPBackEnd.text('LANGUAGES_SET_SUCCESS'):DOPBSPBackEnd.text('LANGUAGES_REMOVE_SUCCESS'));
            DOPPrototypes.setCookie('DOPBSP-translation-redirect', 'languages', 1);

            setTimeout(function(){
                window.location.reload();
            }, 2000);
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};