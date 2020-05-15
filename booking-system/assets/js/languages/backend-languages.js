
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/languages/backend-languages.js
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end languages JavaScript class.
*/

var DOPBSPBackEndLanguages = new function(){
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
     * Display languages.
     */
    this.display = function(){
        $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
        $('#DOPBSP-translation-manage-translation').css('display', 'block');
        $('#DOPBSP-translation-manage-language').css('display', 'none');
        $('#DOPBSP-translation-manage-text-group').css('display', 'none');
        $('#DOPBSP-translation-manage-search').css('display', 'none');
        $('#DOPBSP-translation-manage-languages').css('display', 'none');
        $('#DOPBSP-translation-reset').css('display', 'none');
        $('#DOPBSP-translation-check').css('display', 'none');
        
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        $('#DOPBSP-translation-content').html('');

        $.post(ajaxurl, {action: 'dopbsp_languages_display'}, function(data){
            $('#DOPBSP-translation-content').html(data);
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('LANGUAGES_LOADED'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};