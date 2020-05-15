<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/api/class-backend-api-key.php
* File Version            : 1.0
* Created / Last Modified : 04 September 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end API key PHP class.
*/

    if (!class_exists('DOPBSPBackEndAPIKey')){
        class DOPBSPBackEndAPIKey extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Get current user API key or create one.
             * 
             * @return API key
             */
            function get(){
                global $wpdb;
                global $DOPBSP;
                
                $user_id = wp_get_current_user()->ID;
                
                $data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->api_keys.' WHERE user_id=%d ORDER BY id DESC',
                                                      $user_id));
                
                if ($wpdb->num_rows > 0){
                    return $data->api_key.'-'.$user_id;
                }
                else{
                    /*
                     * Add API key.
                     */
                    $new_api_key = $DOPBSP->classes->prototypes->getRandomString(32);
                    
                    $wpdb->insert($DOPBSP->tables->api_keys, array('user_id' => $user_id,
                                                                   'api_key' => $new_api_key));
                    return $new_api_key.'-'.$user_id;
                }
            }   
            
            /*
             * Verify the API key.
             * 
             * @param key (string): key to be verified
             * 
             * @return boolean value
             */
            function verify($key){
                global $wpdb;
                global $DOPBSP;
                
                $tokens = explode('-', $key);
                $api_key = $tokens[0];
                $user_id = $tokens[1];
                
                $control_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->api_keys.' WHERE api_key=%s AND user_id=%d ORDER BY id DESC',
                                                              $api_key, $user_id));
                
                return $wpdb->num_rows > 0 ? true:false;
            } 
            
            /*
             * Reset the API key.
             * 
             * @post user_id (integer): user ID
             * 
             * @return new key
             */
            function reset(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $user_id = $DOT->post('user_id', 'int');
                
                $new_api_key = $DOPBSP->classes->prototypes->getRandomString(32);

                $wpdb->update($DOPBSP->tables->api_keys, array('api_key' => $new_api_key),
                                                         array('user_id' => $user_id));
                echo $new_api_key.'-'.$user_id;
                    
                die();
            }
        }
    }