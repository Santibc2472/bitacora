
/*
 * Title                   : Pinpoint Booking System WordPress Plugin
 * File                    : assets/js/smss/backend-sms.js
 * Author                  : PINPOINT.WORLD
 * Copyright               : © 2018 PINPOINT.WORLD
 * Website                 : https://www.pinpoint.world
 * Description             : Back end sms JavaScript class.
 */

var DOPBSPBackEndSms = new function(){
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
     * Display SMS.
     * 
     * @param id (Number): SMS ID
     * @param language (String): sms current editing language
     * @param template (String): sms current editing template
     * @param clearSms (Boolean): clear sms extra data diplay
     */
    this.display = function(id,
                            language,
                            template,
                            clearSms){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-sms-language').val() === undefined ? '':$('#DOPBSP-sms-language').val()):language;
        template = template === undefined ? ($('#DOPBSP-sms-select-template').val() === undefined ? 'book_admin':$('#DOPBSP-sms-select-template').val()):template;
        clearSms = clearSms === undefined ? true:false;
        language = clearSms ? '':language;
        
        if (clearSms){
            DOPBSPBackEnd.clearColumns(2);
        }
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .dopbsp-column-content li').removeClass('dopbsp-selected');
        $('#DOPBSP-sms-ID-'+id).addClass('dopbsp-selected');
        $('#DOPBSP-sms-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_sms_display', 
                         id: id,
                         language: language,
                         template: template}, function(data){
            HTML.push('<a href="javascript:DOPBSPBackEnd.confirmation(\'SMSES_DELETE_SMS_CONFIRMATION\', \'DOPBSPBackEndSms.delete('+id+')\')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info">'+DOPBSPBackEnd.text('SMSES_DELETE_SMS_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help">');
            HTML.push(' <span class="dopbsp-info dopbsp-help">');
            HTML.push(DOPBSPBackEnd.text('SMSES_SMS_HELP')+'<br /><br />');
            HTML.push(DOPBSPBackEnd.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            $('#DOPBSP-sms-start_date').datepicker();
            $('#DOPBSP-sms-end_date').datepicker();
            
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('SMSES_SMS_LOADED'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Add sms.
     */
    this.add = function(){
        DOPBSPBackEnd.clearColumns(2);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('SMSES_ADD_SMS_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_sms_add'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('SMSES_ADD_SMS_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit SMS.
     * 
     * @param id (Number): sms ID
     * @param template (String): sms template
     * @param type (String): field type
     * @param field (String): field name
     * @param value (String): field value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         template,
                         type, 
                         field,
                         value, 
                         onBlur){
        onBlur = onBlur === undefined ? false:true;
        
        this.ajaxRequestInProgress !== undefined && !onBlur ? this.ajaxRequestInProgress.abort():'';
        this.ajaxRequestTimeout !== undefined ? clearTimeout(this.ajaxRequestTimeout):'';
        
        switch (field){
            case 'name':
                $('#DOPBSP-sms-ID-'+id+' .dopbsp-name').html(value === '' ? '&nbsp;':value);
                break;
        }
        
        if (onBlur){
            $.post(ajaxurl, {action: 'dopbsp_sms_edit',
                             id: id,
                             template: template,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-sms-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_sms_edit',
                                                              id: id,
                                                              template: template,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-sms-language').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete SMS.
     * 
     * @param id (Number): SMS ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('SMSES_DELETE_SMS_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_sms_delete', 
                         id: id}, function(data){
            DOPBSPBackEnd.clearColumns(2);

            $('#DOPBSP-sms-ID-'+id).stop(true, true)
                                      .animate({'opacity':0}, 
                                      600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .dopbsp-column-content').html('<ul><li class="dopbsp-no-data">'+DOPBSPBackEnd.text('SMSES_NO_SMSES')+'</li></ul>');
                }
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('SMSES_DELETE_SMS_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.__construct();
};