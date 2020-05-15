
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/extras/backend-extra-group-item.js
* File Version            : 1.0.6
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra group item JavaScript class.
*/

var DOPBSPBackEndExtraGroupItem = new function(){
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
     * Initialize validations.
     */
    this.init = function(){
        /*
         * Price validation.
         */
        $('.DOPBSP-input-extra-group-item-price').unbind('input propertychange');
        $('.DOPBSP-input-extra-group-item-price').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '', '0');
        });
    };
    
    /*
     * Add extra group item.
     * 
     * @param groupId (Number): group ID
     * @param language (String): extra current selected language
     */
    this.add = function(groupId,
                        language){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('EXTRAS_EXTRA_GROUP_ADD_ITEM_ADDING'));
        
        $.post(ajaxurl, {action:'dopbsp_extra_group_item_add',
                         group_id: groupId,
                         position: $('#DOPBSP-extra-group-id-'+groupId+' li.dopbsp-group-item-wrapper').size()+1,
                         language: language}, function(data){
            $('#DOPBSP-extra-group-items-'+groupId).append(data);
            
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('EXTRAS_EXTRA_GROUP_ADD_ITEM_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit extra group item.
     * 
     * @param id (Number): group item ID
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
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_extra_group_item_edit',
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_extra_group_item_edit',
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
     * Delete extra group item.
     * 
     * @param id (Number): group item ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('EXTRAS_EXTRA_GROUP_DELETE_ITEM_DELETING'));

        $.post(ajaxurl, {action:'dopbsp_extra_group_item_delete', 
                         id: id}, function(data){
            $('#DOPBSP-extra-group-item-'+id).stop(true, true)
                                             .animate({'opacity':0}, 
                                             600, function(){
                $(this).remove();
            });
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('EXTRAS_EXTRA_GROUP_DELETE_ITEM_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};