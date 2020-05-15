
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/extras/backend-extra-group.js
* File Version            : 1.0.7
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra group JavaScript class.
*/

var DOPBSPBackEndExtraGroup = new function(){
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
     * Add extra group.
     * 
     * @param extraId (Number): extra ID
     * @param language (String): extra current selected language
     */
    this.add = function(extraId,
                        language){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('EXTRAS_EXTRA_ADD_GROUP_ADDING'));
        
        $.post(ajaxurl, {action:'dopbsp_extra_group_add',
                         extra_id: extraId,
                         position: $('#DOPBSP-extra-groups li.dopbsp-group-wrapper').size()+1,
                         language: language}, function(data){
            $('#DOPBSP-extra-groups').append(data);
            
            DOPPrototypes.scrollToY($('#DOPBSP-extra-groups li.dopbsp-group-wrapper:last-child').offset().top-100);
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('EXTRAS_EXTRA_ADD_GROUP_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit extra group.
     * 
     * @param id (Number): group ID
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
                $('#DOPBSP-extra-group-label-preview-'+id).html(value);
                break;
            case 'multiple_select':
                value = $('#DOPBSP-extra-group-multiple_select-'+id).is(':checked') ? 'true':'false';
                break;
            case 'required':
                value = $('#DOPBSP-extra-group-required-'+id).is(':checked') ? 'true':'false';
                $('#DOPBSP-extra-group-label-preview-'+id+' .dopbsp-required').html(value === 'true' ? '*':'');
                break;
            case 'no_items_multiply':
                value = $('#DOPBSP-extra-group-no_items_multiply-'+id).is(':checked') ? 'true':'false';
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_extra_group_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-extra-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_extra_group_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-extra-language').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };
    
    /*
     * Delete extra group.
     * 
     * @param id (Number): extra group ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('EXTRAS_EXTRA_DELETE_GROUP_DELETING'));

        $.post(ajaxurl, {action:'dopbsp_extra_group_delete', 
                         id: id}, function(data){
            $('#DOPBSP-extra-group-'+id).stop(true, true)
                                        .animate({'opacity':0}, 
                                        600, function(){
                $(this).remove();
            });
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('EXTRAS_EXTRA_DELETE_GROUP_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Toggle extra group.
     * 
     * @param id (Number): extra group ID
     */
    this.toggle = function(id){
        if ($('#DOPBSP-extra-group-'+id).hasClass('dopbsp-displayed')){
            $('#DOPBSP-extra-group-'+id).removeClass('dopbsp-displayed');
            $('#DOPBSP-extra-group-'+id+' .dopbsp-preview-wrapper .dopbsp-buttons-wrapper .dopbsp-toggle .dopbsp-info').html(DOPBSPBackEnd.text('EXTRAS_EXTRA_GROUP_SHOW_SETTINGS'));
        }
        else{
            $('#DOPBSP-extra-group-'+id).addClass('dopbsp-displayed');
            $('#DOPBSP-extra-group-'+id+' .dopbsp-preview-wrapper .dopbsp-buttons-wrapper .dopbsp-toggle .dopbsp-info').html(DOPBSPBackEnd.text('EXTRAS_EXTRA_GROUP_HIDE_SETTINGS'));
        }
    };
    
    return this.__construct();
};