
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/settings/backend-settings-licenses.js
* File Version            : 1.0
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end licenses settings JavaScript class.
*/

var DOPBSPBackEndSettingsLicences = new function(){
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
     * Display licences settings.
     * 
     * @param id (Number): calendar ID
     */
    this.display = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        DOPBSPBackEndSettings.toggle(id, 'licences');

        $.post(ajaxurl, {action: 'dopbsp_settings_licences_display'}, function(data){
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Set licence.
     * 
     * @param id (Number): licence ID
     * @param action (String): action type "activate" or "deactivate"
     */
    this.set = function(id, 
                        action){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action: 'dopbsp_settings_licences_'+action,
                         id: id,
                         key: $('#DOPBSP-settings-'+id+'-licence-key').val(),
                         email: $('#DOPBSP-settings-'+id+'-licence-email').val()}, function(data){
            data = $.trim(data);
            
            var result = data.split(';;;;;')[0],
            message = data.split(';;;;;')[1];
            
            if (result === 'success'){
                $('#DOPBSP-inputs-button-'+id+'-deactivate').css('display', action === 'activate' ? 'block':'none');
                $('#DOPBSP-inputs-button-'+id+'-activate').css('display', action === 'deactivate' ? 'block':'none');
                $('#DOPBSP-settings-'+id+'-licence-status').html(action === 'activate' ? DOPBSPBackEnd.text('SETTINGS_LICENCES_STATUS_ACTIVATED'):DOPBSPBackEnd.text('SETTINGS_LICENCES_STATUS_DEACTIVATED'))
                                                           .removeClass(action === 'activate' ? 'dopbsp-deactivated':'dopbsp-activated')
                                                           .addClass(action === 'activate' ? 'dopbsp-activated':'dopbsp-deactivated');
                            
                if (action === 'activate'){
                    $('#DOPBSP-settings-'+id+'-licence-key').attr('disabled', 'disabled');
                    $('#DOPBSP-settings-'+id+'-licence-email').attr('disabled', 'disabled');
                }
                else{
                    $('#DOPBSP-settings-'+id+'-licence-key').removeAttr('disabled');
                    $('#DOPBSP-settings-'+id+'-licence-email').removeAttr('disabled');
                }
                                                   
                DOPBSPBackEnd.toggleMessages('success', message);
            }
            else{
                DOPBSPBackEnd.toggleMessages('error', message);
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};