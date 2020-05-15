
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/translation/backend-translation.js
* File Version            : 1.0.4
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end translation JavaScript class.
*/

var DOPBSPBackEndTranslation = new function(){
    'use strict';
    
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables
     */
    this.ajaxRequestInProgress;
    this.ajaxRequestTimeout;

    /*
     * Constructor
     */
    this.__construct = function(){
    };

    /*
     * Display translation.
     */
    this.display = function(){
        $('#DOPBSP-translation-manage-translation').css('display', 'none');
        $('#DOPBSP-translation-manage-language').css('display', 'block');
        $('#DOPBSP-translation-manage-text-group').css('display', 'block');
        $('#DOPBSP-translation-manage-search').css('display', 'block');
        $('#DOPBSP-translation-manage-languages').css('display', 'block');
        $('#DOPBSP-translation-reset').css('display', 'block');
        $('#DOPBSP-translation-search').val('');
        $('#DOPBSP-translation-check').css('display', DOPBSP_DEVELOPMENT_MODE ? 'block':'none');
        
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        $('#DOPBSP-translation-content').html('');

        $.post(ajaxurl, {action: 'dopbsp_translation_display',
                         language: $('#DOPBSP-translation-language').val(),
                         text_group: $('#DOPBSP-translation-text-group').val()}, function(data){
            $('#DOPBSP-translation-content').html(data);
            $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('TRANSLATION_LOADED'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit translation.
     * 
     * @param id (Number): translation field ID
     * @param language (String): language to be translated
     * @param value (String): new translation
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         language, 
                         value, 
                         onBlur){
        onBlur = onBlur === undefined ? false:true;

        this.ajaxRequestInProgress !== undefined && !onBlur ? this.ajaxRequestInProgress.abort():'';
        this.ajaxRequestTimeout !== undefined ? clearTimeout(this.ajaxRequestTimeout):'';
        
        if (onBlur){
            $.post(ajaxurl, {action: 'dopbsp_translation_edit',
                             id: id,
                             language: language,
                             value: value}, function(data){
            }).fail(function(data){
                DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
        else{
            DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
        
            this.ajaxRequestTimeout = setTimeout(function(){
                clearTimeout(this.ajaxRequestTimeout);

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_translation_edit',
                                                              id: id,
                                                              language: language,
                                                              value: value}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };

    /*
     * Search translation fields.
     */
    this.search = function(){
        var search = $('#DOPBSP-translation-search').val().toLowerCase();

        $('#DOPBSP-translation-content tr').each(function(){
            if ($('td:first-child', this).html().toLowerCase().indexOf(search) !== -1
                || $('textarea', this).val().toLowerCase().indexOf(search) !== -1
                || search === ''){
                $(this).removeAttr('style');
            }
            else{
                $(this).css('display','none');
            }
        });
    };

    /*
     * Reset translation.
     */
    this.reset = function(){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('TRANSLATION_RESETING'));
        $('#DOPBSP-translation-content').html('');

        $.post(ajaxurl, {action: 'dopbsp_translation_reset',
                         ajax_request: true}, function(data){
            DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('TRANSLATION_RESET_SUCCESS'));

            setTimeout(function(){
                window.location.reload();
            }, 100);
        });
    };
    
    /*
     * Check if translation is used in plugin.
     */
    this.check = function(){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        $('#DOPBSP-translation-content').html('');
        
        $.post(ajaxurl, {action: 'dopbsp_translation_check'}, function(data){
            $('#DOPBSP-translation-content').addClass('dopbsp-checked')
                                            .html(data);
            DOPBSPBackEnd.toggleMessages('success', '!');
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};