<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : addons/paypal/includes/class-paypal-settings.php
* File Version            : 1.1.2
* Created / Last Modified : 04 September 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : PayPal settings PHP class.
*/

    if (!class_exists('DOPBSPPayPalSettings')){
        class DOPBSPPayPalSettings{
            /*
             * Constructor
             */
            function __construct(){
                add_filter('dopbsp_filter_default_settings_payment', array(&$this, 'set'), 10);
                add_filter('dopbsp_filter_default_settings_notifications', array(&$this, 'setNotifications'), 10);
            }
            
            /*
             * Set default payment settings for PayPal.
             * 
             * @param default_payment (array): default payment options values
             * 
             * @return default payment settings array for PayPal
             */
            function set($default_payment){
                $default_payment['paypal_enabled'] = 'false';
                $default_payment['paypal_outward'] = 'true';
                $default_payment['paypal_credit_card'] = 'false';
                $default_payment['paypal_username'] = '';
                $default_payment['paypal_password'] = '';
                $default_payment['paypal_signature'] = '';
                $default_payment['paypal_sandbox_enabled'] = 'false';
                $default_payment['paypal_sandbox_username'] = '';
                $default_payment['paypal_sandbox_password'] = '';
                $default_payment['paypal_sandbox_signature'] = '';
                $default_payment['paypal_refund_enabled'] = 'false';
                $default_payment['paypal_refund_value'] = '100';
                $default_payment['paypal_refund_type'] = 'percent';
                $default_payment['paypal_redirect'] = '';
                
                return $default_payment;
            }
            
            /*
             * Set default notifications settings for PayPal.
             * 
             * @param default_notifications (array): default notifications options values
             * 
             * @return default notifications settings array for PayPal
             */
            function setNotifications($default_notifications){
                $default_notifications['send_paypal_admin'] = 'true';
                $default_notifications['send_paypal_user'] = 'true';
                
                return $default_notifications;
            }
        }
    }