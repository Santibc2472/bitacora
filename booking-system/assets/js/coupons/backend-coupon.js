
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/coupons/backend-coupon.js
* File Version            : 1.0.7
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end coupon JavaScript class.
*/

var DOPBSPBackEndCoupon = new function(){
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
     * Display coupon.
     * 
     * @param id (Number): coupon ID
     * @param language (String): coupon current editing language
     * @param clearCoupon (Boolean): clear coupon extra data diplay
     */
    this.display = function(id,
                            language,
                            clearCoupon){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-coupon-language').val() === undefined ? '':$('#DOPBSP-coupon-language').val()):language;
        clearCoupon = clearCoupon === undefined ? true:false;
        language = clearCoupon ? '':language;
        
        if (clearCoupon){
            DOPBSPBackEnd.clearColumns(2);
        }
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .dopbsp-column-content li').removeClass('dopbsp-selected');
        $('#DOPBSP-coupon-ID-'+id).addClass('dopbsp-selected');
        $('#DOPBSP-coupon-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_coupon_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSPBackEnd.confirmation(\'COUPONS_DELETE_COUPON_CONFIRMATION\', \'DOPBSPBackEndCoupon.delete('+id+')\')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info">'+DOPBSPBackEnd.text('COUPONS_DELETE_COUPON_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help">');
            HTML.push(' <span class="dopbsp-info dopbsp-help">');
            HTML.push(DOPBSPBackEnd.text('COUPONS_COUPON_HELP')+'<br /><br />');
            HTML.push(DOPBSPBackEnd.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            $('#DOPBSP-coupon-start_date').datepicker();
            $('#DOPBSP-coupon-end_date').datepicker();
            
            DOPBSPBackEndCoupon.init();
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('COUPONS_COUPON_LOADED'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize events and validations.
     */
    this.init = function(){
        /*
         * Price validation.
         */
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
        startDate,
        minDate;
        
        /*
         * Start date.
         */
        $('#DOPBSP-coupon-start_date').datepicker('destroy');                      
        $('#DOPBSP-coupon-start_date').datepicker({beforeShow: function(input, inst){
                                                        $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                                               .addClass('DOPBSP-admin-datepicker');
                                                  },
                                                  dateFormat: 'yy-mm-dd',
                                                  dayNames: dayNames,
                                                  dayNamesMin: dayShortNames,
                                                  minDate: 0,
                                                  monthNames: monthNames,
                                                  monthNamesMin: monthShortNames,
                                                  nextText: '',
                                                  prevText: ''});
                           
        $('#DOPBSP-coupon-start_date').unbind('change');
        $('#DOPBSP-coupon-start_date').bind('change', function(){
            $('#DOPBSP-coupon-end_date').val('');
            DOPBSPBackEndCoupon.init();
        });
        
        /*
         * End date.
         */
        startDate = $('#DOPBSP-coupon-start_date'); 
        minDate = startDate.val() === '' ? 0:DOPPrototypes.getDatesDifference(DOPPrototypes.getToday(), startDate.val(), 'days', 'integer');
            
        $('#DOPBSP-coupon-end_date').datepicker('destroy');                      
        $('#DOPBSP-coupon-end_date').datepicker({beforeShow: function(input, inst){
                                                    $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                                           .addClass('DOPBSP-admin-datepicker');
                                                },
                                                dateFormat: 'yy-mm-dd',
                                                dayNames: dayNames,
                                                dayNamesMin: dayShortNames,
                                                minDate: minDate,
                                                monthNames: monthNames,
                                                monthNamesMin: monthShortNames,
                                                nextText: '',
                                                prevText: ''});
        
        $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');

        /*
         * Number of coupons.
         */
        $('#DOPBSP-coupon-no_coupons').unbind('input propertychange');
        $('#DOPBSP-coupon-no_coupons').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789', '', '');
        });
        
        /*
         * Price
         */
        $('#DOPBSP-coupon-price').unbind('input propertychange');
        $('#DOPBSP-coupon-price').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '', '0');
        });
    };

    /*
     * Add coupon.
     */
    this.add = function(){
        DOPBSPBackEnd.clearColumns(2);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('COUPONS_ADD_COUPON_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_coupon_add'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('COUPONS_ADD_COUPON_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit coupon.
     * 
     * @param id (Number): coupon ID
     * @param type (String): field type
     * @param field (String): coupon field
     * @param value (String): coupon field value
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
                $('#DOPBSP-coupon-ID-'+id+' .dopbsp-name').html(value === '' ? '&nbsp;':value);
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_coupon_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-coupon-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_coupon_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-coupon-language').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };

    /*
     * Delete coupon.
     * 
     * @param id (Number): coupon ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('COUPONS_DELETE_COUPON_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_coupon_delete', 
                         id: id}, function(data){
            DOPBSPBackEnd.clearColumns(2);

            $('#DOPBSP-coupon-ID-'+id).stop(true, true)
                                      .animate({'opacity':0}, 
                                      600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .dopbsp-column-content').html('<ul><li class="dopbsp-no-data">'+DOPBSPBackEnd.text('COUPONS_NO_COUPONS')+'</li></ul>');
                }
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('COUPONS_DELETE_COUPON_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Generate coupon code.
     * 
     * @param id (Number): coupon ID
     */
    this.generateCode = function(id){
        var code = DOPPrototypes.getRandomString(16);
        
        $('#DOPBSP-coupon-code').val(code);
        DOPBSPBackEndCoupon.edit(id,
                          'text',
                          'code',
                          code);
    };

    return this.__construct();
};