
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/settings/backend-settings-notifications.js
* File Version            : 1.0.8
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end notifications settings JavaScript class.
*/

var DOPBSPBackEndSettingsNotifications = new function(){
    'use strict';
    
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();

    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Display notifications settings.
     * 
     * @param id (Number): calendar ID
     */
    this.display = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        DOPBSPBackEndSettings.toggle(id, 'notifications');

        $.post(ajaxurl, {action: 'dopbsp_settings_notifications_display',
                         id: id}, function(data){
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Test notification method.
     * 
     * @param id (Number): calendar ID
     */
    this.test = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('SETTINGS_NOTIFICATIONS_TEST_SENDING'));
        
        $.post(ajaxurl, {action: 'dopbsp_settings_notifications_test',
                         id: id,
                         method: $('#DOPBSP-settings-notifications-test-method').val(),
                         email: $('#DOPBSP-settings-notifications-test-email').val()}, function(data){
            data = $.trim(data);
                         
            if (data === 'success'){
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('SETTINGS_NOTIFICATIONS_TEST_SUCCESS'));
            }             
            else{
                DOPBSPBackEnd.toggleMessages('error', data);
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    this.phoneAdd = function(key,
                             calendarID){
        var phones = $('#DOPBSP-settings-phone_numbers').val().replace(/\\/g, '');
            phones = phones.split(']"/').join(']');
            phones = phones.split('"[').join('[');
            phones = phones.split("'").join('"');
            phones = JSON.parse(phones);
        
            phones[phones.length] = {phone: '', code: ''};
        
        DOPBSPBackEndSettingsNotifications.phones(phones, calendarID);
        return false;
    };
    
    this.phones = function(phones,
                           calendarID){
        var HTML = new Array(),
            options_data = $('#DOPBSP-settings-phone_numbers-options').val().split(';;'),
            options_values_data = $('#DOPBSP-settings-phone_numbers-options_values').val().split(';;'),
            help = $('#DOPBSP-settings-phone_numbers-help').val();
        
        $('#DOPBSP-settings-phone_numbers').val(JSON.stringify(phones));
        
        for(var i = 0; i<phones.length; i++) {
            HTML.push('     <div class="dopbsp-phone-wrapper">');
            HTML.push('         <select name="DOPBSP-settings-phone_numbers-'+i+'" id="DOPBSP-settings-phone_numbers-'+i+'" class="dopbsp-phone dopbsp-left" onchange="DOPBSPBackEndSettings.set('+calendarID+', \'notifications\', \'select\', \'phone_numbers-'+i+'\')">');

            for (var j=0; j<options_data.length; j++){

                if (phones[i]['code'] === options_values_data[j]){
                    HTML.push('     <option value="'+options_values_data[j]+'" selected="selected">'+options_data[j]+'</option>');
                }
                else{
                    HTML.push('     <option value="'+options_values_data[j]+'">'+options_data[j]+'</option>');
                }
            }
            HTML.push('         </select>');
            HTML.push('         <input type="text" name="DOPBSP-settings-phone_numbers-'+i+'" id="DOPBSP-settings-phone_numbers-'+i+'" class="dopbsp-phone-input" value="'+phones[i]['phone']+'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndSettings.set('+calendarID+', \'notifications\', \'text\', \'phone_numbers-'+i+'\', this.value);}" onpaste="DOPBSPBackEndSettings.set('+calendarID+', \'notifications\', \'text\', \'phone_numbers-'+i+'\', this.value)" onblur="DOPBSPBackEndSettings.set('+calendarID+', \'notifications\', \'text\', \'phone_numbers-'+i+'\', this.value, true)" />');
            HTML.push('         <a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'+help+'<br /><br />'+DOPBSP_translation_text['HELP_VIEW_DOCUMENTATION']+'</span></a>');



            if(i === (phones.length-1)) {
                HTML.push('         <a href="javascript:DOPBSPBackEndSettingsNotifications.phoneAdd('+i+','+calendarID+');" id="DOPBSP-settings-phone_numbers-add-'+i+'" class="dopbsp-button dopbsp-help dopbsp-phone dopbsp-phone-add dopbsp-add"><span class="dopbsp-info dopbsp-help">'+DOPBSP_translation_text['SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ADMIN_PHONE_ADD_HELP']+'</span></a>');

            }
            HTML.push('     </div>');
        }
        
        
        $('.dopbsp-phone-wrapper').html(HTML.join(''));
        
        for(var i = 0; i<phones.length; i++) {
            $('#DOPBSP-settings-phone_numbers-'+i).DOPSelect();
        }
    };
    
    return this.__construct();
};