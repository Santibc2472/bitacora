
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/settings/backend-settings.js
* File Version            : 1.1.5
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end settings JavaScript class.
*/

var DOPBSPBackEndSettings = new function(){
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
     * Display general settings.
     */
    this.displaySettings = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        DOPBSPBackEndSettings.toggle(id, 'settings');

        $.post(ajaxurl, {action: 'dopbsp_settings_general_display'}, function(data){
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Set settings.
     * 
     * @param id (Number): settings ID
     * @param settingsType (String): settings type
     * @param type (String): field type
     * @param key (String): option key
     * @param value (combined): field value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.set = function(id, 
                        settingsType,
                        type, 
                        key, 
                        value, 
                        onBlur){
        var i,
        daysAvailable = new Array(),
        extras = new Array(),
        fees = new Array(),
        coupons = new Array(),
        hoursDefinitions = new Array();

        onBlur = onBlur === undefined ? false:true;
        
        /*
         * Stop saving for "days_first_displayed" option if the value is not correct.
         */
        if (key === 'days_first_displayed'
                && onBlur){
            setTimeout(function(){
                if ($('#DOPBSP-settings-days_first_displayed').val() !== value){
                    DOPBSPBackEndSettings.set(id, 
                                       settingsType,
                                       type, 
                                       key, 
                                       $('#DOPBSP-settings-days_first_displayed').val());
                }
            }, 300);
            return false;
        }
        
        /*
         * Remove current option AJAX requests.
         */
        if (this.ajaxRequestInProgress !== undefined 
                && !onBlur){
            this.ajaxRequestInProgress.abort();
        }

        if (this.ajaxRequestTimeout !== undefined){
            clearTimeout(this.ajaxRequestTimeout);
        }
        
        /*
         * Special actions depending on option type.
         */
        switch (type){
            case 'select':
                value = $('#DOPBSP-settings-'+key).val();
                break;    
            case 'sidebar-style':
                $('#DOPBSP-settings-sidebar-styles li').removeClass('dopbsp-selected');
                $('#DOPBSP-settings-sidebar-style'+value).addClass('dopbsp-selected');
                break;
            case 'switch':
                value = $('#DOPBSP-settings-'+key).is(':checked') ? 'true':'false';
                break;
        }
        
        /*
         * Special actions depending on option key.
         */
        switch (key){
            case 'days_available':
                for (i=0; i<=6; i++){
                    daysAvailable.push($('#DOPBSP-settings-days-available-'+i).is(':checked') ? 'true':'false');
                }
                value = daysAvailable.join(',');
                break;
            case 'hours_definitions':
                if (value !== ''){
                    value = value.split('\n');

                    for (i=0; i<value.length; i++){
                        value[i] = value[i].replace(/\s/g, "");

                        if (value[i] !== ''){
                            hoursDefinitions.push({'value': value[i]});
                        }
                    }
                }
                else{
                    hoursDefinitions.push({'value': '00:00'});
                }
                value = hoursDefinitions;
                break;
            case 'email_cc':
                if (value !== ''){
                    value = value.replace(/\n/g, ',');
                }
                break;
            case 'email_cc_name':
                if (value !== ''){
                    value = value.replace(/\n/g, ',');
                }
                break;
            case 'email_bcc':
                if (value !== ''){
                    value = value.replace(/\n/g, ',');
                }
                break;
            case 'email_bcc_name':
                if (value !== ''){
                    value = value.replace(/\n/g, ',');
                }
                break;
            case 'fees':
                if (settingsType === 'calendar'){
                    $('#DOPBSP-settings-fees input[type=checkbox]').each(function(){
                        $(this).is(':checked') ? fees.push($(this).attr('id').split('DOPBSP-settings-fee')[1]):'';
                    });
                    value = fees.join(',');
                }
                break;
            case 'coupon':
                if (settingsType === 'calendar'){
                    $('#DOPBSP-settings-coupons input[type=checkbox]').each(function(){
                        $(this).is(':checked') ? coupons.push($(this).attr('id').split('DOPBSP-settings-coupon')[1]):'';
                    });
                    value = coupons.join(',');
                }
                break;
        }
        
        if(key.indexOf('phone_numbers') !== -1) {
            var phoneKey = parseInt(key.split('-')[1]),
                phoneType = 'phone',
                phones = $('#DOPBSP-settings-phone_numbers').val().replace(/\\/g, '');
                phones = phones.split(']"/').join(']');
                phones = phones.split('"[').join('[');
                phones = phones.split("'").join('"');
                phones = JSON.parse(phones);
            
            if(type === 'select' ) {
                phoneType = 'code';
            }
            
            for(var i = 0; i<phones.length; i++) {
                
                if(phoneKey === i) {
                    phones[i][phoneType] = value;
                }
            }
            
            key = 'phone_numbers';
            value = JSON.stringify(phones);
            $('#DOPBSP-settings-phone_numbers').val(value);
        }
        
        /*
         * AJAX requests.
         */
        if (onBlur 
                || type === 'checkbox'
                || type === 'select' 
                || type === 'sidebar-style' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_settings_set',
                             id: id,
                             settings_type: settingsType,
                             key: key,
                             value: value}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_settings_set',
                                                              id: id,
                                                              settings_type: settingsType,
                                                              key: key,
                                                              value: value}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };
    
    /*
     * Toggle buttons on settings page.
     * 
     * @param id (Number): calendar ID
     * @param button (String): button class
     */
    this.toggle = function(id,
                           button){
        if (id === 0){
            /*
             * Clear previous content.
             */
            DOPBSPBackEnd.clearColumns(2);  
                    
            /*
             * Set buttons.
             */           
            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-settings').removeClass('dopbsp-selected');
            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-calendars').removeClass('dopbsp-selected');
            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-notifications').removeClass('dopbsp-selected');
            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-payments').removeClass('dopbsp-selected');
            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-searches').removeClass('dopbsp-selected');
            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-users').removeClass('dopbsp-selected');
            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-licences').removeClass('dopbsp-selected');

            $('#DOPBSP-column1 .dopbsp-settings-item.dopbsp-'+button).addClass('dopbsp-selected');
        }
        else{
            /*
             * Clear previous content.
             */
            DOPBSPBackEnd.clearColumns(3);
            $('#DOPBSP-column2 .dopbsp-column-content').html('');
            
            button = button === 'calendars' || button === 'searches' ? 'settings':button;
            
            if (button === 'calendar'){
                $('#DOPBSP-col-column2').addClass('dopbsp-calendar');
                $('#DOPBSP-col-column-separator2').removeAttr('style');
                $('#DOPBSP-col-column3').removeAttr('style');
                $('#DOPBSP-column-separator2').removeAttr('style');
                $('#DOPBSP-column3').removeAttr('style');  
            }
            else{
                $('#DOPBSP-col-column2').removeClass('dopbsp-calendar');
                $('#DOPBSP-col-column-separator2').css('display', 'none');
                $('#DOPBSP-col-column3').css('display', 'none');
                $('#DOPBSP-column-separator2').css('display', 'none');
                $('#DOPBSP-column3').css('display', 'none');
            }
        
            /*
             * Set buttons.
             */
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-settings').removeClass('dopbsp-selected');
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-calendar').removeClass('dopbsp-selected');
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-search').removeClass('dopbsp-selected');
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-settings').removeClass('dopbsp-selected');
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-notifications').removeClass('dopbsp-selected');
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-payments').removeClass('dopbsp-selected');
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-users').removeClass('dopbsp-selected');
            
            $('#DOPBSP-column2 .dopbsp-button.dopbsp-'+button).addClass('dopbsp-selected');
        }
    };
    
    return this.__construct();
};