<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/settings/class-backend-settings-payment-gateways.php
* File Version            : 1.0.4
* Created / Last Modified : 04 September 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end payment gateways settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsPaymentGateways')){
        class DOPBSPBackEndSettingsPaymentGateways extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
                add_filter('dopbsp_filter_default_settings_payment', array(&$this, 'defaults'), 9);
            }
        
            /*
             * Prints out the payment gateways settings page.
             * 
             * @post id (integer): calendar ID
             * 
             * @return payment gateway settings HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $DOPBSP->views->backend_settings_payment_gateways->template(array('id' => $DOT->post('id', 'int')));
                
                die();
            }
            
            /*
             * Set default payment settings.
             * 
             * @param default_payment (array): default payment options values
             * 
             * @return default payment settings array
             */
            function defaults($default_payment){
                $default_payment = array('arrival_enabled' => 'true',
                                         'arrival_with_approval_enabled' => 'false',
                                         'redirect' => '',

                                         'address_billing_enabled' => 'false',
                                         'address_billing_first_name_enabled' => 'true',
                                         'address_billing_first_name_required' => 'true',
                                         'address_billing_last_name_enabled' => 'true',
                                         'address_billing_last_name_required' => 'true',
                                         'address_billing_company_enabled' => 'true',
                                         'address_billing_company_required' => 'false',
                                         'address_billing_email_enabled' => 'true',
                                         'address_billing_email_required' => 'true',
                                         'address_billing_phone_enabled' => 'true',
                                         'address_billing_phone_required' => 'true',
                                         'address_billing_country_enabled' => 'true',
                                         'address_billing_country_required' => 'true',
                                         'address_billing_address_first_enabled' => 'true',
                                         'address_billing_address_first_required' => 'true',
                                         'address_billing_address_second_enabled' => 'true',
                                         'address_billing_address_second_required' => 'false',
                                         'address_billing_city_enabled' => 'true',
                                         'address_billing_city_required' => 'true',
                                         'address_billing_state_enabled' => 'true',
                                         'address_billing_state_required' => 'true',
                                         'address_billing_zip_code_enabled' => 'true',
                                         'address_billing_zip_code_required' => 'true',

                                         'address_shipping_enabled' => 'false',
                                         'address_shipping_first_name_enabled' => 'true',
                                         'address_shipping_first_name_required' => 'true',
                                         'address_shipping_last_name_enabled' => 'true',
                                         'address_shipping_last_name_required' => 'true',
                                         'address_shipping_company_enabled' => 'true',
                                         'address_shipping_company_required' => 'false',
                                         'address_shipping_email_enabled' => 'true',
                                         'address_shipping_email_required' => 'true',
                                         'address_shipping_phone_enabled' => 'true',
                                         'address_shipping_phone_required' => 'true',
                                         'address_shipping_country_enabled' => 'true',
                                         'address_shipping_country_required' => 'true',
                                         'address_shipping_address_first_enabled' => 'true',
                                         'address_shipping_address_first_required' => 'true',
                                         'address_shipping_address_second_enabled' => 'true',
                                         'address_shipping_address_second_required' => 'false',
                                         'address_shipping_city_enabled' => 'true',
                                         'address_shipping_city_required' => 'true',
                                         'address_shipping_state_enabled' => 'true',
                                         'address_shipping_state_required' => 'true',
                                         'address_shipping_zip_code_enabled' => 'true',
                                         'address_shipping_zip_code_required' => 'true',

                                         'paypal_enabled' => 'false',
                                         'paypal_username' => '',
                                         'paypal_password' => '',
                                         'paypal_signature' => '',
                                         'paypal_credit_card' => 'false',
                                         'paypal_sandbox_enabled' => 'false',
                                         'paypal_redirect' => '');
                
                return $default_payment;
            }
        }
    }