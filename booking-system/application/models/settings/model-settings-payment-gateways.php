<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-settings-payment-gateways.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Payment gateways settings model PHP class.
 */

    if (!class_exists('DOTModelSettingsPaymentGateways')){
        class DOTModelSettingsPaymentGateways{
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
	     *	    Set default payment gateways settings.
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
                
		$this->settings->arrival_enabled = 'true';
		$this->settings->arrival_with_approval_enabled = 'false';
		$this->settings->redirect = '';

		$this->settings->address_billing_enabled = 'false';
		$this->settings->address_billing_first_name_enabled = 'true';
		$this->settings->address_billing_first_name_required = 'true';
		$this->settings->address_billing_last_name_enabled = 'true';
		$this->settings->address_billing_last_name_required = 'true';
		$this->settings->address_billing_company_enabled = 'true';
		$this->settings->address_billing_company_required = 'false';
		$this->settings->address_billing_email_enabled = 'true';
		$this->settings->address_billing_email_required = 'true';
		$this->settings->address_billing_phone_enabled = 'true';
		$this->settings->address_billing_phone_required = 'true';
		$this->settings->address_billing_country_enabled = 'true';
		$this->settings->address_billing_country_required = 'true';
		$this->settings->address_billing_address_first_enabled = 'true';
		$this->settings->address_billing_address_first_required = 'true';
		$this->settings->address_billing_address_second_enabled = 'true';
		$this->settings->address_billing_address_second_required = 'false';
		$this->settings->address_billing_city_enabled = 'true';
		$this->settings->address_billing_city_required = 'true';
		$this->settings->address_billing_state_enabled = 'true';
		$this->settings->address_billing_state_required = 'true';
		$this->settings->address_billing_zip_code_enabled = 'true';
		$this->settings->address_billing_zip_code_required = 'true';

		$this->settings->address_shipping_enabled = 'false';
		$this->settings->address_shipping_first_name_enabled = 'true';
		$this->settings->address_shipping_first_name_required = 'true';
		$this->settings->address_shipping_last_name_enabled = 'true';
		$this->settings->address_shipping_last_name_required = 'true';
		$this->settings->address_shipping_company_enabled = 'true';
		$this->settings->address_shipping_company_required = 'false';
		$this->settings->address_shipping_email_enabled = 'true';
		$this->settings->address_shipping_email_required = 'true';
		$this->settings->address_shipping_phone_enabled = 'true';
		$this->settings->address_shipping_phone_required = 'true';
		$this->settings->address_shipping_country_enabled = 'true';
		$this->settings->address_shipping_country_required = 'true';
		$this->settings->address_shipping_address_first_enabled = 'true';
		$this->settings->address_shipping_address_first_required = 'true';
		$this->settings->address_shipping_address_second_enabled = 'true';
		$this->settings->address_shipping_address_second_required = 'false';
		$this->settings->address_shipping_city_enabled = 'true';
		$this->settings->address_shipping_city_required = 'true';
		$this->settings->address_shipping_state_enabled = 'true';
		$this->settings->address_shipping_state_required = 'true';
		$this->settings->address_shipping_zip_code_enabled = 'true';
		$this->settings->address_shipping_zip_code_required = 'true';

		$this->settings->paypal_enabled = 'false';
		$this->settings->paypal_username = '';
		$this->settings->paypal_password = '';
		$this->settings->paypal_signature = '';
		$this->settings->paypal_credit_card = 'false';
		$this->settings->paypal_sandbox_enabled = 'false';
		$this->settings->paypal_redirect = '';
            }
	    
            /*
             * Get payment gateways settings.
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
	     *	    Payment gateways settings list or setting value.
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
		    $settings = $DOT->db->results($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_payment.' WHERE calendar_id=%d',
								 array($calendar_id)));
		
		    foreach ($settings as $setting){
			$this->settings->{$setting->name} = $setting->value;
		    }
		
		    return $this->settings;
		}
		else{
		    $setting = $DOT->db->row($DOT->db->safe('SELECT * FROM '.$DOT->tables->settings_payment.' WHERE calendar_id=%d AND name=%s',
							    array($calendar_id, $name)));
		    
		    return $DOT->db->rows_no > 0 ? $setting->value:$this->settings->{$name};
		}
	    }
        }
    }