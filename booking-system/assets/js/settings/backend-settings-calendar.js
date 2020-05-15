
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/settings/backend-settings-calendar.js
* File Version            : 1.0.9
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar settings JavaScript class.
*/

var DOPBSPBackEndSettingsCalendar = new function(){
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
     * Display calendar settings.
     * 
     * @param id (Number): calendar ID
     */
    this.display = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        DOPBSPBackEndSettings.toggle(id, 'calendars');
        
        $.post(ajaxurl, {action: 'dopbsp_settings_calendar_display',
                         id: id}, function(data){
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            DOPBSPBackEndSettingsCalendar.init();
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize calendar settings.
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
                           DOPBSPBackEnd.text('SHORT_MONTH_DECEMBER')];
                               
        $('#DOPBSP-settings-days_first_displayed').datepicker('destroy');
        $('#DOPBSP-settings-days_first_displayed').datepicker({beforeShow: function(input, inst){
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
        $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');
    };
    
    return this.__construct();
};