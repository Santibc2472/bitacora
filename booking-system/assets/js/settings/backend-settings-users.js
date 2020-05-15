
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/settings/backend-settings-users.js
* File Version            : 1.0
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end users settings JavaScript class.
*/

var DOPBSPBackEndSettingsUsers = new function(){
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
     * Display users settings.
     * 
     * @param id (Number): calendar ID
     */
    this.display = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        DOPBSPBackEndSettings.toggle(id, 'users');

        $.post(ajaxurl, {action: 'dopbsp_settings_users_display',
                         calendar_id: id}, function(data){
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            DOPBSPBackEndSettingsUsers.get(id);
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Get users list by search parameters.
     * 
     * @param id (Number): calendar ID
     */
    this.get = function(id){
        DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_LOADING'));

        if (this.ajaxRequestInProgress !== undefined){
            this.ajaxRequestInProgress.abort();
        }
        
        this.ajaxRequestTimeout = setTimeout(function(){
            clearTimeout(this.ajaxRequestTimeout);

            this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_settings_users_get',
                                                          calendar_id: id,
                                                          number: '',
                                                          offset : '',
                                                          order: $('#DOPBSP-settings-users-permissions-filters-order').val(),
                                                          orderby: $('#DOPBSP-settings-users-permissions-filters-order-by').val(),
                                                          role: $('#DOPBSP-settings-users-permissions-filters-role').val(),
                                                          search: $('#DOPBSP-settings-users-permissions-filters-search').val()}, function(data){
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_LOADING_SUCCESS'));
                $('#DOPBSP-users-list').html(data);
            }).fail(function(data){
                DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
            });
        }, 600);
    };
    
    /*
     * Set users permissions.
     * 
     * @param id (Number): user ID (if 0 general permissions are set)
     * @param slug (String): permission slug
     * @param calendarId (Number): calendar ID
     */
    this.set = function(id,
                        slug,
                        calendarId){
        calendarId = calendarId === undefined ? 0:calendarId;
        
        DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
        
        $.post(ajaxurl, {action: 'dopbsp_settings_users_set',
                         id: id,
                         slug: slug,
                         value: $('#DOPBSP-settings-users-permissions-'+slug+(id !== 0 ? '-'+id:'')).is(':checked') ? 1:0,
                         calendar_id: calendarId}, function(data){
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};