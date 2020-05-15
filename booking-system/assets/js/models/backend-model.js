
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/models/backend-model.js
* File Version            : 1.0
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end model JavaScript class.
*/

var DOPBSPBackEndModel = new function(){
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
     * Display model.
     * 
     * @param id (Number): model ID
     * @param language (String): model current editing language
     * @param clearModel (Boolean): clear model extra data diplay
     */
    this.display = function(id,
                            language,
                            clearModel){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-model-language').val() === undefined ? '':$('#DOPBSP-model-language').val()):language;
        clearModel = clearModel === undefined ? true:false;
        language = clearModel ? '':language;
        
        if (clearModel){
            DOPBSPBackEnd.clearColumns(2);
        }
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .dopbsp-column-content li').removeClass('dopbsp-selected');
        $('#DOPBSP-model-ID-'+id).addClass('dopbsp-selected');
        $('#DOPBSP-model-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_model_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSPBackEnd.confirmation(\'MODELS_DELETE_MODEL_CONFIRMATION\', \'DOPBSPBackEndModel.delete('+id+')\')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info">'+DOPBSPBackEnd.text('MODELS_DELETE_MODEL_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help">');
            HTML.push(' <span class="dopbsp-info dopbsp-help">');
            HTML.push(DOPBSPBackEnd.text('MODELS_MODEL_HELP')+'<br /><br />');
            HTML.push(DOPBSPBackEnd.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MODELS_MODEL_LOADED'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Add model.
     */
    this.add = function(){
        DOPBSPBackEnd.clearColumns(2);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MODELS_ADD_MODEL_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_model_add'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MODELS_ADD_MODEL_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit model.
     * 
     * @param id (Number): model ID
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
                $('#DOPBSP-model-ID-'+id+' .dopbsp-name').html(value === '' ? '&nbsp;':value);
                break;
        }
        
        switch (type){
            case 'switch':
                value = $('#DOPBSP-model-'+field+'-'+id).is(':checked') ? 'true':'false';
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_model_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-model-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_model_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-model-language').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete model.
     * 
     * @param id (Number): model ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MODELS_DELETE_MODEL_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_model_delete', 
                         id: id}, function(data){
            DOPBSPBackEnd.clearColumns(2);

            $('#DOPBSP-model-ID-'+id).stop(true, true)
                                     .animate({'opacity':0}, 
                                              600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .dopbsp-column-content').html('<ul><li class="dopbsp-no-data">'+DOPBSPBackEnd.text('MODELS_NO_MODELS')+'</li></ul>');
                }
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MODELS_DELETE_MODEL_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.__construct();
};