<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.4
* File                    : includes/settings/class-backend-settings-licences.php
* File Version            : 1.0.5
* Created / Last Modified : 07 May 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end licences settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsLicences')){
        class DOPBSPBackEndSettingsLicences extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the licences settings page.
             * 
             * @post id (integer): calendar ID
             * 
             * @return licences settings HTML
             */
            function display(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_settings_licences->template(array());
                
                die();
            }
            
            /*
             * Activate items' licences.
             * 
             * @post id (string): item ID
             * @post key (string): item licence key
             * @post email (string): item licence email
             */
            function activate(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id');
                $key = $DOT->post('key');
                $email = $DOT->post('email');
                
                if ($id == 'dopbsp'){
                    $item = 'DOPBSP';
                }
                else{
                    $item = 'DOPBSP_'.$id;
                    global $$item;
                }
                
                /*
                 * Create request url.
                 */
                $args = array();
                
                $instance = $DOPBSP->classes->backend_settings->value(0,
                                                                      'general',
                                                                      $id.'_licence_instance');
                
                if ($instance == ''){
                    $instance = $DOPBSP->classes->prototypes->getRandomString(64);
                    $DOPBSP->classes->backend_settings->set(array('id' => 0,
                                                                  'is_ajax' => false,
                                                                  'key' => $id.'_licence_instance',
                                                                  'settings_type' => 'general',
                                                                  'value' => $instance));
                }
                
		$defaults = array('wc-api' => 'am-software-api',
                                  'email' => $email,
                                  'instance' => $instance,
                                  'licence_key' => $key,
                                  'platform' => $$item->classes->update->domain,
                                  'product_id' => $$item->classes->update->product_id,
                                  'request' => 'activation',
                                  'software_version' => $$item->classes->update->software_version);
		$args = wp_parse_args($defaults, $args);
		$request_url = esc_url_raw($$item->classes->update->platform.'?'.http_build_query($args));
                
                /*
                 * Request plugin activation.
                 */
		$request = wp_remote_get($request_url,
                                         array('sslverify' => DOPBSP_CONFIG_SHOP_SSL_VERIFY));
                
		if (wp_remote_retrieve_response_code($request) != 200){
                    echo 'error_with_message;;;;;'.$DOPBSP->text('SETTINGS_LICENCES_STATUS_TIMEOUT_ERROR');
		}
		elseif (is_wp_error($request)){
                    echo 'error_with_message;;;;;'.$DOPBSP->text('SETTINGS_LICENCES_STATUS_ACTIVATED_ERROR');
		}
                else{
                    $response = json_decode(wp_remote_retrieve_body($request));
                    
                    if ((string)$response->activated == 'inactive'){
                        $message = array();

                        array_push($message, $DOPBSP->text('SETTINGS_LICENCES_STATUS_ACTIVATED_ERROR').'<br />');
                        array_push($message, 'Error: '.$response->error);
                        array_push($message, 'Code: '.$response->code);
                        
                        if(isset($response->{'additional info'})) {
                            array_push($message, 'Message: '.$response->{'additional info'});
                        }

                        echo 'error_with_message;;;;;'.implode('<br />', $message);
                    }
                    else{
                        $DOPBSP->classes->backend_settings->set(array('id' => 0,
                                                                      'is_ajax' => false,
                                                                      'key' => $id.'_licence_status',
                                                                      'settings_type' => 'general',
                                                                      'value' => 'activated'));
                        $DOPBSP->classes->backend_settings->set(array('id' => 0,
                                                                      'is_ajax' => false,
                                                                      'key' => $id.'_licence_key',
                                                                      'settings_type' => 'general',
                                                                      'value' => $key));
                        $DOPBSP->classes->backend_settings->set(array('id' => 0,
                                                                      'is_ajax' => false,
                                                                      'key' => $id.'_licence_email',
                                                                      'settings_type' => 'general',
                                                                      'value' => $email));
                        echo 'success;;;;;'.$DOPBSP->text('SETTINGS_LICENCES_STATUS_ACTIVATED_SUCCESS').'<br /><br />'.$response->message;
                    }
                }
                
                die();
            }
            
            /*
             * Deactivate items' licences.
             * 
             * @post id (string): item ID
             * @post key (string): item licence key
             * @post email (string): item licence email
             */
            function deactivate(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id');
                $key = $DOT->post('key');
                $email = $DOT->post('email');
                
                if ($id == 'dopbsp'){
                    $item = 'DOPBSP';
                }
                else{
                    $item = 'DOPBSP_'.$id;
                    global $$item;
                }
                
                /*
                 * Create request url.
                 */
                $args = array();
                
                $instance = $DOPBSP->classes->backend_settings->value(0,
                                                                      'general',
                                                                      $id.'_licence_instance');
                
		$defaults = array('wc-api' => 'am-software-api',
                                  'email' => $email,
                                  'instance' => $instance,
                                  'licence_key' => $key,
                                  'platform' => $$item->classes->update->domain,
                                  'product_id' => $$item->classes->update->product_id,
                                  'request' => 'deactivation');
		$args = wp_parse_args($defaults, $args);
		$request_url = esc_url_raw($$item->classes->update->platform.'?'.http_build_query($args));
                
                /*
                 * Request plugin activation.
                 */
		$request = wp_remote_get($request_url,
                                         array('sslverify' => DOPBSP_CONFIG_SHOP_SSL_VERIFY));
                
		if (wp_remote_retrieve_response_code($request) != 200){
                    echo 'error_with_message;;;;;'.$DOPBSP->text('SETTINGS_LICENCES_STATUS_TIMEOUT_ERROR');
		}
		elseif (is_wp_error($request)){
                    echo 'error_with_message;;;;;'.$DOPBSP->text('SETTINGS_LICENCES_STATUS_DEACTIVATED_ERROR');
		}
                else{
                    $response = json_decode(wp_remote_retrieve_body($request));
                    
                    if ((string)$response->deactivated == false){
                        $message = array();

                        array_push($message, $DOPBSP->text('SETTINGS_LICENCES_STATUS_DEACTIVATED_ERROR').'<br />');
                        array_push($message, 'Error: '.$response->error);
                        array_push($message, 'Code: '.$response->code);
                        
                        if(isset($response->{'additional info'})) {
                            array_push($message, 'Message: '.$response->{'additional info'});
                        }

                        echo 'error_with_message;;;;;'.implode('<br />', $message);
                    }
                    else{
                        $DOPBSP->classes->backend_settings->set(array('id' => 0,
                                                                      'is_ajax' => false,
                                                                      'key' => $id.'_licence_status',
                                                                      'settings_type' => 'general',
                                                                      'value' => 'deactivated'));
                        echo 'success;;;;;'.$DOPBSP->text('SETTINGS_LICENCES_STATUS_DEACTIVATED_SUCCESS').'<br /><br />'.$response->activations_remaining;
                    }
                }
                
                die();
            }
            
            /*
             * Check items' licences status.
             * 
             * @param id (string): item ID
             */
            function status($id){
                global $DOPBSP;
                
                if ($id == 'dopbsp'){
                    $item = 'DOPBSP';
                }
                else{
                    $item = 'DOPBSP_'.$id;
                    global $$item;
                }
                
                /*
                 * Create request url.
                 */
                $args = array();
                
                $email = $DOPBSP->classes->backend_settings->value(0,
                                                                   'general',
                                                                   $id.'_licence_email');
                $instance = $DOPBSP->classes->backend_settings->value(0,
                                                                      'general',
                                                                      $id.'_licence_instance');
                
                $key = $DOPBSP->classes->backend_settings->value(0,
								 'general',
								 $id.'_licence_key');
                
		$defaults = array('wc-api' => 'am-software-api',
                                  'email' => $email,
                                  'instance' => $instance,
                                  'licence_key' => $key,
                                  'platform' => $$item->classes->update->domain,
                                  'product_id' => $$item->classes->update->product_id,
                                  'request' => 'status');
		
		$args = wp_parse_args($defaults, $args);
		$request_url = esc_url_raw($$item->classes->update->platform.'?'.http_build_query($args));
                
                /*
                 * Request plugin activation.
                 */
		$request = wp_remote_get($request_url,
                                         array('sslverify' => DOPBSP_CONFIG_SHOP_SSL_VERIFY));
		
                $response = json_decode(wp_remote_retrieve_body($request));
		
		if (wp_remote_retrieve_response_code($request) == 200
			&& (!isset($response->status_check)
				|| $response->status_check != 'active')){
		    $DOPBSP->classes->backend_settings->set(array('id' => 0,
								  'is_ajax' => false,
								  'key' => $id.'_licence_status',
								  'settings_type' => 'general',
								  'value' => 'deactivated'));
		}
            }
        }
    }