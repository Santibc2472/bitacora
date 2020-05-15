<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/ajax/user/calendars/ajax-user-calendars.php
 * Author                  : Pinpoint World
 * Copyright               : © 2019 Pinpoint World
 * Website                 : https://pinpoint.world
 * Description             : User - Calendars AJAX PHP class.
 */

    if (!class_exists('DOTAjaxUserCalendars')){
        class DOTAjaxUserCalendars{
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
	     * Get calendar data.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    -
	     * 
	     * @post
             *	    DOT_AJAX_VAR (string): AJAX key
	     *	    calendar_id (integer): calendar ID
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
	     *	    DOT_AJAX_VAR (string): AJAX request variable
	     * 
	     * @globals
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework : post() // Get a $_POST variable.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    "true" is returned if the email was sent, "false" otherwise.
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
	    public static function data(){
		global $DOT;
		
		if ($DOT->post(DOT_AJAX_VAR)){
		    $calendar_id = $DOT->post('calendar_id', 'int');
		    
		    $data = new stdClass;
		    
		    $data->availability = $DOT->models->availability->get($calendar_id); 
                    
		    echo json_encode($data);
		}
		else{
		    echo 'false';
		}
		
		exit;
	    }
        }
    }