<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-calendar-schedule-default.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Calendar default schedule model PHP class.
 */

    if (!class_exists('DOTModelCalendarScheduleDefault')){
        class DOTModelCalendarScheduleDefault{
	    /*
	     * Public variables.
	     */
	    public $default_schedule; // Initial default schedule.
	    
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
	     *	    Set initial default schedule.
	     * 
	     * @return_details
	     *	    Default schedule data:
	     *		available (integer): the number available
	     *		bind (integer): group position
	     *				"0" individual item
	     *				"1" first item in a group
	     *				"2" middle item in a group
	     *				"3" last item in a group
	     *		info (string): day/hour info
	     *		info_body (string): extra info that will appear in day/hour body
	     *		info_tooltip (string): extra info that will appear in day/hour info tooltip 
	     *		notes (string): day/hour notes
	     *		price (float): day/hour price
	     *		promo (float): day/hour promotional price
	     *		status (string): day/hour status
	     *				 "none" no status
	     *				 "available" day/hour is available
	     *				 "booked" day/hour is booked
	     *				 "special" day/hour has special status
	     *				 "unavailable" day/hour is unavailable
	     * 
	     *		hours (object): hours schedule with same data like for day 
	     *				{HH:MM} (object)
	     *		hours_definitions (object): hours definitions list 
	     *					    "value": {HH:MM}
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            function __construct(){
		/*
		 * Set initial default schedule.
		 */
		$this->default_schedule = new stdClass;
		    
		$this->default_schedule->available = 0;
		$this->default_schedule->bind = 0;
		$this->default_schedule->hours = '{"00:00":{"available":0,"bind":0,"info":"","notes":"","price":0,"promo":0,"status":"none"}}';
		$this->default_schedule->hours_definitions = array(array('value' => '00:00'));
		$this->default_schedule->info = '';
		$this->default_schedule->notes = '';
		$this->default_schedule->price = 0;
		$this->default_schedule->promo = 0;
		$this->default_schedule->status = 'none';

		$this->default_schedule->hours = array('00:00' => new stdClass);
		$this->default_schedule->hours['00:00']->available = 0;
		$this->default_schedule->hours['00:00']->bind = 0;
		$this->default_schedule->hours['00:00']->info = '';
		$this->default_schedule->hours['00:00']->notes = '';
		$this->default_schedule->hours['00:00']->price = 0;
		$this->default_schedule->hours['00:00']->promo = 0;
		$this->default_schedule->hours['00:00']->status = 'none';
            }
	    
	    /*
             * Get default schedule.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework : db->delete() // Delete rows from database.
	     * 
	     *	    application/models/components/calendars/model-components-calendar.php : get() // Get calendar.
	     *	    application/models/components/calendars/model-components-calendar.php : set() // Set calendar.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Default schedule object.
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
	    function get($calendar_id){
		global $DOT;
		
		/*
		 * Get calendar.
		 */
		$calendar = $DOT->models->calendar->get($calendar_id);
		
		/*
		 * Verify if default schedule data exists.
		 */
		if ($calendar->default_availability == ''){
		    $DOT->models->calendar->set($calendar_id, 
						array('default_availability' => json_encode($this->default_schedule)));
		    
		    /*
		     * Delete the days that have the data like default availability.
		     */
		    $DOT->db->delete($DOT->tables->days, array('calendar_id' => $calendar_id,
							       'data' => json_encode($this->default_schedule)));
		    
		    return $this->default_schedule;
		}
		
		return json_decode($calendar->default_availability);
	    }
	    
            /*
             * Set default schedule.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
	     *	    data (object): default schedule data
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework : db->delete() // Delete rows from database.
	     *	    
	     *	    application/models/components/calendars/model-components-calendar.php : set() // Set calendar.
	     *	    application/models/availability/model-availability.php : set() // Set availability.
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
	    function set($calendar_id,
			 $data){
		global $DOT;
		
		/*
		 * Set calendar data.
		 */
		$DOT->models->calendar->set($calendar_id, 
					    array('default_availability' => json_encode($data)));
		
		/*
		 * Delete the days that have the data like default availability.
		 */
		$DOT->db->delete($DOT->tables->days, array('calendar_id' => $calendar_id,
							   'data' => json_encode($data)));
		
		/*
		 * Set availability.
		 */
		$DOT->models->availability->set($calendar_id);
	    }
        }
    }