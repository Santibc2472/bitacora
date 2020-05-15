
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/fees/backend-fee.js
* File Version            : 1.0.8
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end fee JavaScript class.
*/

var DOPBSPBackEndFee = new function(){
    'use strict';
    
    /*
     * Private variables.
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
     * Display fee.
     * 
     * @param id (Number): fee ID
     * @param language (String): fee current editing language
     * @param clearFee (Boolean): clear fee extra data diplay
     */
    this.display = function(id,
                            language,
                            clearFee){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-fee-language').val() === undefined ? '':$('#DOPBSP-fee-language').val()):language;
        clearFee = clearFee === undefined ? true:false;
        language = clearFee ? '':language;
        
        if (clearFee){
            DOPBSPBackEnd.clearColumns(2);
        }
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .dopbsp-column-content li').removeClass('dopbsp-selected');
        $('#DOPBSP-fee-ID-'+id).addClass('dopbsp-selected');
        $('#DOPBSP-fee-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_fee_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSPBackEnd.confirmation(\'FEES_DELETE_FEE_CONFIRMATION\', \'DOPBSPBackEndFee.delete('+id+')\')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info">'+DOPBSPBackEnd.text('FEES_DELETE_FEE_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help">');
            HTML.push(' <span class="dopbsp-info dopbsp-help">');
            HTML.push(DOPBSPBackEnd.text('FEES_FEE_HELP')+'<br /><br />');
            HTML.push(DOPBSPBackEnd.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            DOPBSPBackEndFee.init();
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('FEES_FEE_LOADED'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize validations.
     */
    this.init = function(){
        /*
         * Price validation.
         */
        $('.DOPBSP-input-fee-price').unbind('input propertychange');
        $('.DOPBSP-input-fee-price').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '', '0');
        });
    };

    /*
     * Add fee.
     */
    this.add = function(){
        DOPBSPBackEnd.clearColumns(2);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('FEES_ADD_FEE_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_fee_add'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('FEES_ADD_FEE_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit fee.
     * 
     * @param id (Number): fee ID
     * @param type (String): field type
     * @param field (String): field name
     * @param value (String): field value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         type, 
                         field,
                         value, 
                         onBlur){
        onBlur = onBlur === undefined ? false:true;
        
        this.ajaxRequestInProgress !== undefined && !onBlur ? this.ajaxRequestInProgress.abort():'';
        this.ajaxRequestTimeout !== undefined ? clearTimeout(this.ajaxRequestTimeout):'';
        
        switch (field){
            case 'name':
                $('#DOPBSP-fee-ID-'+id+' .dopbsp-name').html(value === '' ? '&nbsp;':value);
                break;
        }
        
        switch (type){
            case 'switch':
                value = $('#DOPBSP-fee-'+field+'-'+id).is(':checked') ? 'true':'false';
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_fee_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-fee-language').val()}, function(data){
                if (!onBlur){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }
            }).fail(function(data){
                DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
        else{
            DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));

            this.ajaxRequestTimeout = setTimeout(function(){
                clearTimeout(this.ajaxRequestTimeout);

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_fee_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-fee-language').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete fee.
     * 
     * @param id (Number): fee ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('FEES_DELETE_FEE_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_fee_delete', 
                         id: id}, function(data){
            DOPBSPBackEnd.clearColumns(2);

            $('#DOPBSP-fee-ID-'+id).stop(true, true)
                                   .animate({'opacity':0}, 
                                   600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .dopbsp-column-content').html('<ul><li class="dopbsp-no-data">'+DOPBSPBackEnd.text('FEES_NO_FEES')+'</li></ul>');
                }
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('FEES_DELETE_FEE_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.__construct();
};