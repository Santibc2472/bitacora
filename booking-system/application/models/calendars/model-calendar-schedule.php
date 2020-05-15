<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-calendar-schedule.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Calendar schedule model PHP class.
 */

    if (!class_exists('DOTModelCalendarSchedule')){
        class DOTModelCalendarSchedule{
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
            function __construct(){
            }
	    
            /*
             * Get calendar schedule.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
	     *	    year (integer): year for which the schedule will be loaded
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
	     *	    framework : db->results() // Get query results.
	     *	    framework : db->safe() // Clean query string.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    The schedule.
	     * 
	     * @return_details
	     *	    A list of days with availability data.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function get($calendar_id,
			 $year = false){
		global $DOT;
                
                $schedule = array();
		
		/*
		 * Get schedule days.
		 */
		if ($year !== false){
		    $days = $DOT->db->results($DOT->db->safe('SELECT * FROM '.$DOT->tables->days.' WHERE calendar_id=%d AND year=%d ORDER BY day ASC',
							     array($calendar_id, $year)));
		}
		else{
		    $days = $DOT->db->results($DOT->db->safe('SELECT * FROM '.$DOT->tables->days.' WHERE calendar_id=%d ORDER BY day ASC',
							     array($calendar_id)));
		}
		
		/*
		 * Process schedule.
		 */
                foreach ($days as $day){
		    $schedule[$day->day] = $day->data;
		}
		
		return $schedule;
	    }
        }
    }