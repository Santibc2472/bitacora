<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.3.8
* File                    : addons/clickatell/dopbsp-clickatell.php
* File Version            : 1.0
* Created / Last Modified : 10 November 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Clickatell PHP class.
*/

    if (!class_exists('DOPBSPClickatell')){
        class DOPBSPClickatell{
            private $SMSAPI_user     = '';
            private $SMSAPI_password = '';
            private $SMSAPI_id       = '';
            private $SMSAPI_from     = '';
            
            /*
             * Constructor
             */
            function __construct($clickatell_api){
                $this->SMSAPI_user = $clickatell_api->clickatell_username;
                $this->SMSAPI_password = $clickatell_api->clickatell_password;
                $this->SMSAPI_id = $clickatell_api->clickatell_api_id;
                $this->SMSAPI_from = $clickatell_api->clickatell_from;
            }

            /*
             * Send SMS message for Central type accounts.
             * 
             * @param phone_prefix (string): phone country prefix
             * @param phone_number (string): phone number
             * @param text (string): SMS text
             * 
             * @return boolean value if SMS was sent ot not
             */
            function send_central($phone,
                                  $text){
                $api_link = array();

                array_push($api_link, 'https://api.clickatell.com/http/sendmsg?');
                array_push($api_link, 'user='.$this->SMSAPI_user);
                array_push($api_link, '&password='.$this->SMSAPI_password);
                array_push($api_link, '&api_id='.$this->SMSAPI_id);
                array_push($api_link, '&from='.$this->SMSAPI_from);
                array_push($api_link, '&to='.$phone);
                array_push($api_link, '&text='.$text);

                $message = $this->UrlOpener(esc_url_raw(implode('', $api_link)));

                if ($message == 'ERR: 114, Cannot route message' 
                    || $message == 'ERR: 105, Invalid Destination Address'){
                    return false;
                }
                else{
                    return true;
                }
            }
            
            /*
             * Send SMS message for SMS Platform type accounts.
             * 
             * @param phone_prefix (string): phone country prefix
             * @param phone_number (string): phone number
             * @param text (string): SMS text
             * 
             * @return boolean value if SMS was sent ot not
             */
            function send_platform($phone,
                                  $text){
                $api_link = array();

                array_push($api_link, 'https://platform.clickatell.com/messages/http/send?');
                array_push($api_link, '&apiKey='.$this->SMSAPI_id);
                array_push($api_link, '&to='.$phone);
                array_push($api_link, '&content='.$text);

                $message = $this->UrlOpener(esc_url_raw(implode('', $api_link)));

                if ($message == 'ERR: 114, Cannot route message' 
                    || $message == 'ERR: 105, Invalid Destination Address'){
                    return false;
                }
                else{
                    return true;
                }
            }
            
            function UrlOpener($url){
                 global $output;

                 $ch = curl_init(); 
                 curl_setopt($ch, CURLOPT_URL, $url); 
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                 $output = curl_exec($ch); 
                 curl_close($ch);    

                 return $output;
            }
        }
    }