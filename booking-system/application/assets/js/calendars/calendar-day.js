/*
 * Title                   : Pinpoint Booking System
 * File                    : application/assets/js/calendars/calendar-day.js
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Calendar day JavaScript class.
 */

DOT.methods.calendar_day = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     * 
     * @usage
     *	    The constructor is called when a class instance is created.
     * 
     * @params
     *	    -
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     * 
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    -
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.__construct = function(){
    };
    
    /*
     * Get default day data.
     * 
     * @usage
     *	    -
     * 
     * @params
     *	    -
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     * 
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    Default day data.
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.default = function(){
	return {"available": 0,
		"bind": 0,
		"hours_definitions": [{"value": "00:00"}],
		"hours": {},
		"info": "",
		"info_body": "",
		"info_tooltip": "",
		"notes": "",
		"price": 0,
		"promo": 0,
		"status": "none"};
    };
    
    /*
     * Get day data.
     * 
     * @usage
     *	    -
     * 
     * @params
     *	    id (Number): calendar ID
     *	    date (String): date in "YYYY-MM-DD" format
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    DOT.methods.calendar_schedule.data (Array): calendar schedule
     * 
     * @functions
     *	    this : unavailable() // Get unavailable day data.
     *	    this : weekday() // Get weekday.
     * 
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    Day data.
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.get = function(id,
			date){
	var weekday = DOT.methods.calendar_day.weekday(date);
	
	/*
	 * Verify if weekday is available, if not return an unavailable day.
	 */
	if (!DOT.methods.calendar_days.settings[id].available[weekday]){
	    return DOT.methods.calendar_day.unavailable();
	}
		
	/*
	 * Verify if day is set in schedule, if yes return it.
	 */
	if (DOT.methods.calendar_schedule.data[id][date] !== undefined && DOT.methods.calendar_schedule.data[id][date] !== null){
	    return DOT.methods.calendar_schedule.data[id][date];
	}
		
	/*
	 * Return default schedule.
	 */
	return DOT.methods.calendar_schedule.default[id];
    };
    
    /*
     * Get unavailable day data.
     * 
     * @usage
     *	    -
     * 
     * @params
     *	    -
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     * 
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    Unavailable day data.
     * 
     * @return_details
     *	    
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.unavailable = function(){
	return {"available": 0,
		"bind": 0,
		"hours_definitions": [{"value": "00:00"}],
		"hours": {},
		"info": "",
		"info_body": "",
		"info_tooltip": "",
		"notes": "",
		"price": 0, 
		"promo": 0,
		"status": "unavailable"};
    };
    
    /*
     * Get weekday.
     * 
     * @usage
     *	    -
     * 
     * @params
     *	    date (String): date in "YYYY-MM-DD" format
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     * 
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    Weekday index.
     * 
     * @return_details
     *	    [weekday index] : [day]
     *	    
     *	    0 : Sunday
     *	    1 : Monday
     *	    2 : Tuesday
     *	    3 : Wednesday
     *	    4 : Thursday
     *	    5 : Friday
     *	    6 : Saturday
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.weekday = function(date){
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	datePieces = date.split('-'),
        year = datePieces[0],
        month = datePieces[1],
        day = datePieces[2],
        dateFull = new Date(eval('"'+day+' '+months[parseInt(month, 10)-1]+', '+year+'"'));

        return dateFull.getDay();
    };

    return this.__construct();
};