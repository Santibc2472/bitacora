
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/forms/backend-form-field.js
* File Version            : 1.0.8
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form field JavaScript class.
*/

var DOPBSPBackEndFormField = new function(){
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
     * Add form field.
     * 
     * @param formId (Number): form ID
     * @param type (String): form field type
     * @param language (String): form current selected language
     */
    this.add = function(formId,
                        type,
                        language){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('FORMS_FORM_ADD_FIELD_ADDING'));
        
        $.post(ajaxurl, {action:'dopbsp_form_field_add',
                         form_id: formId,
                         type: type,
                         position: $('#DOPBSP-form-fields li.dopbsp-field-wrapper').size()+1,
                         language: language}, function(data){
            $('#DOPBSP-form-fields').append(data);
            
            DOPPrototypes.scrollToY($('#DOPBSP-form-fields li.dopbsp-field-wrapper:last-child').offset().top-100);
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('FORMS_FORM_ADD_FIELD_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
        
    };

    /*
     * Edit form field.
     * 
     * @param id (Number): field ID
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
            case 'label':
                $('#DOPBSP-form-field-label-preview-'+id).html(value);
                break;
            case 'is_email':
                value = $('#DOPBSP-form-field-is_email-'+id).is(':checked') ? 'true':'false';
                break;
            case 'is_phone':
                value = $('#DOPBSP-form-field-is_phone-'+id).is(':checked') ? 'true':'false';
                if ($('#DOPBSP-form-field-is_phone-'+id).is(':checked') === true) {
                    $('#default_country-'+id).removeClass("hidden").addClass("visible");
                }
                else {
                    $('#default_country-'+id).removeClass("visible").addClass("hidden");
                }
                break;
            case 'default_country':
                $('#DOPBSP-form-field-default_country'+id).change(function (){
                    value = this.value;
                });
                break;
            case 'multiple_select':
                this.setSelectPreview(id);
                value = $('#DOPBSP-form-field-multiple_select-'+id).is(':checked') ? 'true':'false';
                break;
            case 'required':
                value = $('#DOPBSP-form-field-required-'+id).is(':checked') ? 'true':'false';
                $('#DOPBSP-form-field-label-preview-'+id+' .dopbsp-required').html(value === 'true' ? '*':'');
                break;
            case 'add_to_day_hour_info':
                value = $('#DOPBSP-form-field-add_to_day_hour_info-'+id).is(':checked') ? 'true':'false';
                break;
            case 'add_to_day_hour_body':
                value = $('#DOPBSP-form-field-add_to_day_hour_body-'+id).is(':checked') ? 'true':'false';
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_form_field_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-form-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_form_field_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-form-language').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };
    
    /*
     * Delete form field.
     * 
     * @param id (Number): form field ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('FORMS_FORM_DELETE_FIELD_DELETING'));

        $.post(ajaxurl, {action:'dopbsp_form_field_delete', 
                         id: id}, function(data){
            $('#DOPBSP-form-field-'+id).stop(true, true)
                                       .animate({'opacity':0}, 
                                       600, function(){
                $(this).remove();
            });
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('FORMS_FORM_DELETE_FIELD_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Toggle form field.
     * 
     * @param id (Number): form field ID
     */
    this.toggle = function(id){
        if ($('#DOPBSP-form-field-'+id).hasClass('dopbsp-displayed')){
            $('#DOPBSP-form-field-'+id).removeClass('dopbsp-displayed');
            $('#DOPBSP-form-field-'+id+' .dopbsp-preview-wrapper .dopbsp-buttons-wrapper .dopbsp-toggle .dopbsp-info').html(DOPBSPBackEnd.text('FORMS_FORM_FIELD_SHOW_SETTINGS'));
        }
        else{
            $('#DOPBSP-form-field-'+id).addClass('dopbsp-displayed');
            $('#DOPBSP-form-field-'+id+' .dopbsp-preview-wrapper .dopbsp-buttons-wrapper .dopbsp-toggle .dopbsp-info').html(DOPBSPBackEnd.text('FORMS_FORM_FIELD_HIDE_SETTINGS'));
        }
    };

    /*
     * Create select preview.
     * 
     * @param id (Number): form field ID
     */
    this.setSelectPreview = function(id){
        var HTML = new Array(),
        optionId,
        i = 0;

        HTML.push('<select name="DOPBSP-form-field-preview-'+id+'" id="DOPBSP-form-field-preview-'+id+'" value="" disabled="disabled" '+($('#DOPBSP-form-field-multiple_select-'+id).is(':checked') ? ' multiple="multiple"':'')+'>');
                            
        $('#DOPBSP-form-field-select-options-'+id+' li').each(function(){
            if (!$(this).hasClass('dopbsp-placeholder')){
                i++;
                optionId = $(this).attr('id').split('DOPBSP-form-field-select-option-')[1];
                HTML.push('<option value="'+i+'">'+$('#DOPBSP-form-field-select-option-label-'+optionId).val()+'</option>');
            }
        });
        HTML.push('</select>');
        
        $('#DOPSelect-DOPBSP-form-field-preview-'+id).replaceWith(HTML.join(''));
        $('#DOPBSP-form-field-preview-'+id).DOPSelect();
    };
    
    return this.__construct();
};