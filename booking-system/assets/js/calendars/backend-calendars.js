
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/calendars/backend-calendars.js
* File Version            : 1.0.7
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendars JavaScript class.
*/

var DOPBSPBackEndCalendars = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
        
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Display calendars list or initialize custom post calendar.
     */
    this.display = function(){
        var post_id = DOPPrototypes.$_GET('post'),
        action = DOPPrototypes.$_GET('action');
    
        DOPBSPBackEnd.clearColumns(1);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        if (action === 'edit'){
            $('#DOPBSP-col-column1').remove();
            $('#DOPBSP-col-column-separator1').remove();
            $('#DOPBSP-column1').remove();
            $('#DOPBSP-column-separator1').remove();
            
            $.post(ajaxurl, {action: 'dopbsp_custom_posts_get',
                             post_id: post_id}, function(data){
                $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
                DOPBSPBackEndCalendar.init($.trim(data));
            }).fail(function(data){
                DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
        else{
            $.post(ajaxurl, {action: 'dopbsp_calendars_display'}, function(data){
                $('#DOPBSP-column1 .dopbsp-column-content').html(data);
                $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
		
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('CALENDARS_LOAD_SUCCESS'));
            }).fail(function(data){
                DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
    };
    
    return this.__construct();
};