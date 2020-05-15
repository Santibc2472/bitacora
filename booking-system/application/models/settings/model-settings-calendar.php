<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-settings-calendar.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Calendar settings model PHP class.
 */

    if (!class_exists('DOTModelSettingsCalendar')){
        class DOTModelSettingsCalendar{
	    /*
	     * Public variables.
	     */
	    public $settings;
	    
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
	     *	    Set default calendar settings.
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
                $this->settings = new stdClass;
		
		$this->settings->date_type = '1';
		$this->settings->template = 'default';
		$this->settings->booking_stop = '0';
		$this->settings->months_no = '1';
		$this->settings->view_only = 'false';
		$this->settings->server_time = 'false';
		$this->settings->hide_price = 'false';
		$this->settings->hide_no_available = 'false';
		$this->settings->minimum_no_available = '1';
		$this->settings->timezone = '';
		$this->settings->max_year = date('Y'); // REMOVE AFTER UPDATE 4.0

		$this->settings->currency = 'USD';
		$this->settings->currency_position = 'before';

		// $this->settings->price_thousand_separator = ',';
		// $this->settings->price_decimal_separator = '.';
		// $this->settings->price_decimals_no = '2';

		$this->settings->days_available = 'true,true,true,true,true,true,true';
		$this->settings->days_details_from_hours = 'true';
		$this->settings->days_first = '1';
		$this->settings->days_first_displayed = '';
		$this->settings->days_morning_check_out = 'false';
		$this->settings->days_morning_check_out_check_in_time = '14:00';
		$this->settings->days_morning_check_out_check_out_time = '12:00';
		$this->settings->days_multiple_select = 'true';

		$this->settings->hours_add_last_hour_to_total_price = 'true';
		$this->settings->hours_ampm = 'false';
		$this->settings->hours_definitions = '[{"value": "00:00"}]';
		$this->settings->hours_enabled = 'false';
		$this->settings->hours_info_enabled = 'true';
		$this->settings->hours_interval_enabled = 'false';
		$this->settings->hours_interval_autobreak_enabled = 'false';
		$this->settings->hours_multiple_select = 'true';

		$this->settings->sidebar_no_items_enabled = 'true';
		$this->settings->sidebar_style = '1';

		$this->settings->rule = '0';
		$this->settings->extra = '0';
		$this->settings->cart_enabled = 'false';
		$this->settings->discount = '0';
		$this->settings->fees = '';
		$this->settings->coupon = '0';

		$this->settings->deposit = '0';
		$this->settings->deposit_type = 'percent';
		$this->settings->deposit_pay_full_amount = 'true';

		$this->settings->form = '1';

		$this->settings->terms_and_conditions_enabled = 'false';
		$this->settings->terms_and_conditions_link = '';

		$this->settings->ical_url = '';

		$this->settings->google_enabled = 'false';
		$this->settings->google_client_id = '';
		$this->settings->google_client_secret = '';
		$this->settings->google_calendar_id = '';
		$this->settings->google_feed_url = '';
		$this->settings->google_sync_time = '3600';

		$this->settings->airbnb_enabled = 'false';
		$this->settings->airbnb_feed_url = '';
		$this->settings->airbnb_sync_time = '3600';
            }
	    
            /*
             * Get calendar settings.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
	     *	    name (string): setting name
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
	     *	    Calendar settings list or setting value.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function get($calendar_id,
			 $name = ''){
		global $DOT;
		
		if ($name == ''){
		    $settings = $DOT->db->results($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_calendar.' WHERE calendar_id=%d',
								 array($calendar_id)));
		
		    foreach ($settings as $setting){
			$this->settings->{$setting->name} = $setting->value;
		    }
		
		    return $this->settings;
		}
		else{
		    $setting = $DOT->db->row($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_calendar.' WHERE calendar_id=%d AND name=%s',
							    array($calendar_id, $name)));
		    
		    return $DOT->db->rows_no > 0 ? $setting->value:$this->settings->{$name};
		}
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