/*
 * Title                   : Pinpoint Booking System
 * File                    : application/assets/js/calendars/calendar-availability.js
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Calendar availability JavaScript class.
 */

DOT.methods.calendar_availability = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Public variables.
     */
    this.data = new Array(); // Calendar availability intervals.
    
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
     * Verify availability.
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
     *	    DOT.methods.calendar_availability.data (Array): calendar availability intervals
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
    this.verify = function(id,
			   dayStart,
			   dayEnd,
			   timeStart,
			   timeEnd){
	var availability = DOT.methods.calendar_availability.data[id],
	dateStart,
	dateEnd,
	i;

	/*
	 * Verify time values.
	 */
	timeStart = timeStart === undefined ? '00:00:00':timeStart+':00';
	timeEnd = timeEnd === undefined ? '23:59:59':DOPPrototypes.getPrevTime(timeEnd+':00', 1, 'seconds');
	
	/*
	 * Set search dates.
	 */
	dateStart = dayStart+' '+timeStart;
	dateEnd = dayEnd+' '+timeEnd;
	
	/*
	 * Verify availability in intervals.
	 */
	for (i=0; i<=availability.length-1; i++){
	    if (availability[i]['date_start'] <= dateStart
		    && availability[i]['date_end'] >= dateEnd){
		return true;
	    }
	    else if (availability[i]['date_start'] > dateEnd){
		return false;
	    }
	} 
	
	return false;
    };
    
    return this.__construct();
};