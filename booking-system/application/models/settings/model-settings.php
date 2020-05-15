<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/settings/model-settings.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Settings model PHP class.
 */

    if (!class_exists('DOTModelSettings')){
        class DOTModelSettings{
            /*
             * Public variables.
             */
            public $default_calendar = array(); // Default calendar settings.
            public $default_general = array(); // Default general settings.
            public $default_notifications = array(); // Default notifications settings.
            public $default_payment = array(); // Default payment settings.
            public $default_search = array(); // Default search settings.
	    
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
             * Get calendar.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    id (integer): calendar ID
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
	     *	    framework : db->row() // Get one row from database.
	     *	    framework : db->safe() // Clean query string.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Calendar object.
	     * 
	     * @return_details
	     *	    Calendar object:
	     *		{calendar}->max_year (integer): the year until were the days are set
	     *		{calendar}->name (string): calendar name
	     *		{calendar}->post_id (integer): post ID
	     *		{calendar}->user_id (integer): user ID
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function get($id){
		global $DOT;
		
		return $DOT->db->results($DOT->db->safe('SELECT * FROM '.$DOT->tables->calendars.' WHERE id=%d',
							array($id)));
	    }
	    
            /*
             * Set calendar data.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    id (integer): user ID
	     *	    data (array): user data
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
	     *	    framework : db->update() // Update row fields in database.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Number of rows updated.
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
		
		return $DOT->db->update($DOT->tables->setiings_calendars, $data, 
									  array('calendar_id' => $calendar_id));
	    }
        }
    }