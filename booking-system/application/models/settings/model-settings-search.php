<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-settings-search.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Search settings model PHP class.
 */

    if (!class_exists('DOTModelSettingsSearch')){
        class DOTModelSettingsSearch{
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
	     *	    Set default search settings.
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
		$this->settings->search_enabled = 'false';
		$this->settings->price_enabled = 'true';

		$this->settings->view_default = 'list';
		$this->settings->view_list_enabled = 'true';
		$this->settings->view_grid_enabled = 'false';
		$this->settings->view_map_enabled = 'false';
		$this->settings->view_results_page = '10';
		$this->settings->view_sidebar_position = 'left';

		$this->settings->currency = 'USD';
		$this->settings->currency_position = 'before';

		$this->settings->days_first = '1';
		$this->settings->days_multiple_select = 'true';

		$this->settings->hours_ampm = 'false';
		$this->settings->hours_definitions = '[{"value": "00:00"},{"value": "01:00"},{"value": "02:00"},{"value": "03:00"},{"value": "04:00"},{"value": "05:00"},{"value": "06:00"},{"value": "07:00"},{"value": "08:00"},{"value": "09:00"},{"value": "10:00"},{"value": "11:00"},{"value": "12:00"},{"value": "13:00"},{"value": "14:00"},{"value": "15:00"},{"value": "16:00"},{"value": "17:00"},{"value": "18:00"},{"value": "19:00"},{"value": "20:00"},{"value": "21:00"},{"value": "22:00"},{"value": "23:00"}]';
		$this->settings->hours_enabled = 'false';
		$this->settings->hours_multiple_select = 'true';

		$this->settings->availability_enabled = 'false';
		$this->settings->availability_max = '10';
		$this->settings->availability_min = '1';
            }
	    
            /*
             * Get search settings.
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
	     *	    Search settings list or setting value.
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
		    $settings = $DOT->db->results($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_search.' WHERE calendar_id=%d',
								 array($calendar_id)));
		
		    foreach ($settings as $setting){
			$this->settings->{$setting->name} = $setting->value;
		    }
		
		    return $this->settings;
		}
		else{
		    $setting = $DOT->db->row($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_search.' WHERE calendar_id=%d AND name=%s',
							    array($calendar_id, $name)));
		    
		    return $DOT->db->rows_no > 0 ? $setting->value:$this->settings->{$name};
		}
	    }
        }
    }