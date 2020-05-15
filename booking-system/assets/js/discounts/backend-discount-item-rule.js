
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/discounts/backend-discount-item-rule.js
* File Version            : 1.0.6
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount item rule JavaScript class.
*/

var DOPBSPBackEndDiscountItemRule = new function(){
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
     * Initialize events and validations.
     */
    this.init = function(){
        var dayNames = [DOPBSPBackEnd.text('DAY_SUNDAY'),
                        DOPBSPBackEnd.text('DAY_MONDAY'),
                        DOPBSPBackEnd.text('DAY_TUESDAY'),
                        DOPBSPBackEnd.text('DAY_WEDNESDAY'),
                        DOPBSPBackEnd.text('DAY_THURSDAY'),
                        DOPBSPBackEnd.text('DAY_FRIDAY'),
                        DOPBSPBackEnd.text('DAY_SATURDAY')],
        dayShortNames = [DOPBSPBackEnd.text('SHORT_DAY_SUNDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_MONDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_TUESDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_WEDNESDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_THURSDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_FRIDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_SATURDAY')],
        monthNames = [DOPBSPBackEnd.text('MONTH_JANUARY'),
                      DOPBSPBackEnd.text('MONTH_FEBRUARY'),
                      DOPBSPBackEnd.text('MONTH_MARCH'),
                      DOPBSPBackEnd.text('MONTH_APRIL'),
                      DOPBSPBackEnd.text('MONTH_MAY'),
                      DOPBSPBackEnd.text('MONTH_JUNE'),
                      DOPBSPBackEnd.text('MONTH_JULY'),
                      DOPBSPBackEnd.text('MONTH_AUGUST'),
                      DOPBSPBackEnd.text('MONTH_SEPTEMBER'),
                      DOPBSPBackEnd.text('MONTH_OCTOBER'),
                      DOPBSPBackEnd.text('MONTH_NOVEMBER'),
                      DOPBSPBackEnd.text('MONTH_DECEMBER')],
        monthShortNames = [DOPBSPBackEnd.text('SHORT_MONTH_JANUARY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_FEBRUARY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_MARCH'),
                           DOPBSPBackEnd.text('SHORT_MONTH_APRIL'),
                           DOPBSPBackEnd.text('SHORT_MONTH_MAY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_JUNE'),
                           DOPBSPBackEnd.text('SHORT_MONTH_JULY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_AUGUST'),
                           DOPBSPBackEnd.text('SHORT_MONTH_SEPTEMBER'),
                           DOPBSPBackEnd.text('SHORT_MONTH_OCTOBER'),
                           DOPBSPBackEnd.text('SHORT_MONTH_NOVEMBER'),
                           DOPBSPBackEnd.text('SHORT_MONTH_DECEMBER')],
        id,
        startDate,
        minDate;
                       
        $('.DOPBSP-discount-item-rule-start-date').each(function(){
            $(this).datepicker('destroy');                      
            $(this).datepicker({beforeShow: function(input, inst){
                                    $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                           .addClass('DOPBSP-admin-datepicker');
                               },
                               dateFormat: 'yy-mm-dd',
                               dayNames: dayNames,
                               dayNamesMin: dayShortNames,
                               firstDay: 1,
                               minDate: 0,
                               monthNames: monthNames,
                               monthNamesMin: monthShortNames,
                               nextText: '',
                               prevText: ''});
                           
            $(this).unbind('change');
            $(this).bind('change', function(){
                id = $(this).attr('id').split('DOPBSP-discount-item-rule-start-date-')[1];
                $('#DOPBSP-discount-item-rule-end-date-'+id).val('');
                DOPBSPBackEndDiscountItemRule.init();
            });
        });
        
        $('.DOPBSP-discount-item-rule-end-date').each(function(){
            id = $(this).attr('id').split('DOPBSP-discount-item-rule-end-date-')[1];
            startDate = $('#DOPBSP-discount-item-rule-start-date-'+id); 
            minDate = startDate.val() === '' ? 0:DOPPrototypes.getDatesDifference(DOPPrototypes.getToday(), startDate.val(), 'days', 'integer');

            $(this).datepicker('destroy');                      
            $(this).datepicker({beforeShow: function(input, inst){
                                    $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                           .addClass('DOPBSP-admin-datepicker');
                               },
                               dateFormat: 'yy-mm-dd',
                               dayNames: dayNames,
                               dayNamesMin: dayShortNames,
                               firstDay: 1,
                               minDate: minDate,
                               monthNames: monthNames,
                               monthNamesMin: monthShortNames,
                               nextText: '',
                               prevText: ''});
        });
        
        $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');
        
        /*
         * Price validation.
         */
        $('.DOPBSP-input-discount-item-rule-price').unbind('input propertychange');
        $('.DOPBSP-input-discount-item-rule-price').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '', '0');
        });
    };
    
    /*
     * Add discount item rule.
     * 
     * @param itemId (Number): item ID
     * @param language (String): discount current selected language
     */
    this.add = function(itemId,
                        language){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('DISCOUNTS_DISCOUNT_ITEM_ADD_RULE_ADDING'));
        
        $.post(ajaxurl, {action:'dopbsp_discount_item_rule_add',
                         item_id: itemId,
                         position: $('#DOPBSP-discount-item-id-'+itemId+' li.dopbsp-item-rule-wrapper').size()+1,
                         language: language}, function(data){
            $('#DOPBSP-discount-item-rules-'+itemId).append(data);
            
            DOPBSPBackEndDiscountItemRule.init();
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('DISCOUNTS_DISCOUNT_ITEM_ADD_RULE_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit discount item rule.
     * 
     * @param id (Number): discount item rule ID
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
            
            $.post(ajaxurl, {action: 'dopbsp_discount_item_rule_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-discount-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_discount_item_rule_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-discount-language').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };
    
    /*
     * Delete discount item rule.
     * 
     * @param id (Number): item rule ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_DELETING'));

        $.post(ajaxurl, {action:'dopbsp_discount_item_rule_delete', 
                         id: id}, function(data){
            $('#DOPBSP-discount-item-rule-'+id).stop(true, true)
                                               .animate({'opacity':0}, 
                                               600, function(){
                $(this).remove();
            });
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};