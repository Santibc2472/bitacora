/*
* Title                   : DOP Google Calendar (JavaScript class)
* Version                 : 1.0
* File                    : dop-google-calendar.js
* File Version            : 1.0
* Created / Last Modified : 29 November 2016
* Author                  : Dot on Paper
* Copyright               : © 2014 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : List of general functions that we use at Dot on Paper.
* Licence                 : MIT
*/

var DOPGoogleCalendar = new function(){
    /*
     * Private variables
     */
    var $ = jQuery.noConflict(),
        CLIENT_ID = '',
        CALENDAR_ID = '',
        SCOPES = ["https://www.googleapis.com/auth/calendar"];

    /*
     * Public variables
     */
        
    /*
     * Constructor
     */
    this.__construct = function(){
    };
        
    /*
     * Sync
     */
    this.sync = function(){
        CLIENT_ID = (typeof dopbspGoogleCalendar_CLIENT_ID !== 'undefined' ? dopbspGoogleCalendar_CLIENT_ID:'');
        CALENDAR_ID = (typeof dopbspGoogleCalendar_CALENDAR_ID !== 'undefined' ? dopbspGoogleCalendar_CALENDAR_ID:'');
        
        gapi.auth.authorize(
          {
            'client_id': CLIENT_ID,
            'scope': SCOPES.join(' '),
            'immediate': true
          }, DOPGoogleCalendar.init);
    };
        
    /*
     * Init
     */
    this.init = function(authResult){
        
        if (authResult && !authResult.error) {
          // Load Events from Google Calendar
          DOPGoogleCalendar.loadEvents();
        } else {
          // Authorize
          DOPGoogleCalendar.authorize();
        }
    };
        
    /*
     * Authorize
     */
    this.authorize = function(authResult){
        gapi.auth.authorize(
          {client_id: CLIENT_ID, scope: SCOPES, immediate: false},
          DOPGoogleCalendar.init);
        return false;
    };
        
    /*
     * Load Events
     */
    this.loadEvents = function(){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        gapi.client.load('calendar', 'v3', DOPGoogleCalendar.importEvents);
    };
        
    /*
     * Import Events
     */
    this.importEvents = function(){
        DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
        var request = gapi.client.calendar.events.list({
          'calendarId': 'ibp151gjujpji4h83v2p5upkog@group.calendar.google.com',
          'timeMin': (new Date()).toISOString(),
          'showDeleted': false,
          'singleEvents': true,
          'maxResults': 10,
          'orderBy': 'startTime'
        });

        request.execute(function(resp) {
          var events = resp.items;
//          appendPre('Upcoming events:');
          console.log(resp);
          if (events.length > 0) {
            for (i = 0; i < events.length; i++) {
              var event = events[i];
              var when = event.start.dateTime;
              if (!when) {
                when = event.start.date;
              }
//              appendPre(event.summary + ' (' + when + ')')
            }
          } else {
//            appendPre('No upcoming events found.');
          }
//            dopbsp_reservations_import_book
            
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));

        });
    };
        
    /*
     * Export Events
     */
    this.exportEvents = function(){
    };
    
    return this.__construct();
};