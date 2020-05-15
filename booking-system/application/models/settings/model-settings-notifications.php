<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-settings-notifications.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Notifications settings model PHP class.
 */

    if (!class_exists('DOTModelSettingsNotifications')){
        class DOTModelSettingsNotifications{
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
	     *	    Set default notifications settings.
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
		
                $this->settings->templates = '1';
		$this->settings->method_admin = 'mailer';
		$this->settings->method_user = 'mailer';
		$this->settings->email = '';
                $this->settings->admin_email_sender = '';
		$this->settings->email_reply = '';
		$this->settings->email_name = '';
		$this->settings->email_cc = '';
		$this->settings->email_cc_name = '';
		$this->settings->email_bcc = '';
		$this->settings->email_bcc_name = '';

		$this->settings->smtp_host_name = '';
		$this->settings->smtp_host_port = '25';
		$this->settings->smtp_ssl = 'false';
		$this->settings->smtp_tls = 'false';
		$this->settings->smtp_user = '';
		$this->settings->smtp_password = '';

		$this->settings->smtp_host_name2 = '';
		$this->settings->smtp_host_port2 = '25';
		$this->settings->smtp_ssl2 = 'false';
		$this->settings->smtp_tls2 = 'false';
		$this->settings->smtp_user2 = '';
		$this->settings->smtp_password2 = '';

		$this->settings->send_book_admin = 'true';
		$this->settings->send_book_user = 'true';
		$this->settings->send_book_with_approval_admin = 'true';
		$this->settings->send_book_with_approval_user = 'true';
		$this->settings->send_approved = 'true';
		$this->settings->send_canceled = 'true';
		$this->settings->send_rejected = 'true';
                
                $this->settings->clickatell_account_type = '';
		$this->settings->clickatell_username = '';
		$this->settings->clickatell_password = '';
		$this->settings->clickatell_api_id = '';
		$this->settings->clickatell_from = '';
		$this->settings->phone_numbers = '';

		$this->settings->clickatell_send_book_admin = 'false';
		$this->settings->clickatell_send_book_user = 'false';
		$this->settings->clickatell_send_book_with_approval_admin = 'false';
		$this->settings->clickatell_send_book_with_approval_user = 'false';
		$this->settings->clickatell_send_approved = 'false';
		$this->settings->clickatell_send_canceled = 'false';
		$this->settings->clickatell_send_rejected = 'false';
            }
	    
            /*
             * Get notifications settings.
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
	     *	    Notifications settings list or setting value.
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
		    $settings = $DOT->db->results($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_notifications.' WHERE calendar_id=%d',
								 array($calendar_id)));
		
		    foreach ($settings as $setting){
			$this->settings->{$setting->name} = $setting->value;
		    }
		
		    return $this->settings;
		}
		else{
		    $setting = $DOT->db->row($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_notifications.' WHERE calendar_id=%d AND name=%s',
							    array($calendar_id, $name)));
		    
		    return $DOT->db->rows_no > 0 ? $setting->value:$this->settings->{$name};
		}
	    }
        }
    }