<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/class-payment-gateways.php
* File Version            : 1.0.1
* Created / Last Modified : 17 December 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Payment gateways PHP class.
*/

    if (!class_exists('DOPBSPPaymentGateways')){
        class DOPBSPPaymentGateways{
            /*
             * Private variables.
             */
            private $payment_gateways = array();
            
            /*
             * Constructor
             */
            function __construct(){
                add_action('init', array(&$this, 'init'));
            }
            
            /*
             * Set payment gateways classes.
             */
            function init(){
                /*
                 * Initialize payment gateways classes.
                 */
                $this->payment_gateways = apply_filters('dopbsp_filter_payment_gateways', $this->payment_gateways);
                sort($this->payment_gateways);
            }
            
            /*
             * Get payment gateways.
             * 
             * @return list of payment gateways
             */
            function get(){
                return $this->payment_gateways;
            }
        }
    }