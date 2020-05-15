<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-calendar.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Calendar model PHP class.
 */

    if (!class_exists('DOTModelCalendar')){
        class DOTModelCalendar{
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
	    function get(){
		global $DOT;
		
		return $DOT->db->row('SELECT * FROM '.$DOT->tables->calendars.' WHERE id=1');
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
	     *			  data['activation_key'] (string): user activation key
	     *			  data['balance'] (float): user earnings balance
	     *			  data['date_created'] (string): the date when the account was created
	     *			  data['email'] (string): user email
	     *			  data['facebook_id'] (integer): user facebook ID
	     *			  data['google_id'] (integer): user google ID
	     *			  data['password'] (string): user password; this will always be empty
	     *			  data['referrer_id'] (integer): referrer ID
	     *			  data['reset_key'] (string): user reset key
	     *			  data['reset_date'] (string): the date when the reset key was created
	     *			  data['role'] (string): user role
	     *		          data['status'] (string): user status
	     *			  data['username'] (string): the username
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
	    function set($id,
			 $data){
		global $DOT;
		
		return $DOT->db->update($DOT->tables->calendars, $data, 
								 array('id' => $id));
	    }
        }
    }