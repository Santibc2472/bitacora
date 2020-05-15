<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.1
* File                    : includes/settings/class-backend-settings.php
* File Version            : 1.1.1
* Created / Last Modified : 25 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettings')){
        class DOPBSPBackEndSettings extends DOPBSPBackEnd{
            /*
             * Public variables.
             */
            public $default_calendar = array();
            public $default_general = array();
            public $default_notifications = array();
            public $default_payment = array();
            public $default_search = array();
                        
            /*
             * Constructor
             */
            function __construct(){
                add_action('init', array(&$this, 'init') , 9);
            }
        
            /*
             * Prints out the settings page.
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_settings->template();
            }
            
            /*
             * Initialize settings.
             */
            function init(){
                $this->default_calendar = apply_filters('dopbsp_filter_default_settings_calendar', $this->default_calendar);
                $this->default_general = apply_filters('dopbsp_filter_default_settings_general', $this->default_general);
                $this->default_notifications = apply_filters('dopbsp_filter_default_settings_notifications', $this->default_notifications);
                $this->default_payment = apply_filters('dopbsp_filter_default_settings_payment', $this->default_payment);
                $this->default_search = apply_filters('dopbsp_filter_default_settings_search', $this->default_search);
            }
            
            /*
             * Edit settings.
             * 
             * @post id (integer): calendar/search ID
             * @post settings_type (string): settings type
             * @post key (string): option key
             * @post value (combined): the value with which the option will be modified
             * 
             * @param args (array): function arguments
             *                          "id" (integer): calendar/search ID
             *                          "is_ajax" (boolean): set it to false if the function is not called using a AJAX request
             *                          "key" (string): option key
             *                          "settings_type" (string): settings type
             *                          "value" (combined): the value with which the option will be modified
             */
            function set($args = array('id' => '',
                                       'is_ajax' => true,
                                       'key' => '',
                                       'settings_type' => '',
                                       'value' => '')){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                if (!isset($args['key'])){
                    $args = array('id' => '',
                                  'is_ajax' => true,
                                  'key' => '',
                                  'settings_type' => '',
                                  'value' => '');
                }
                
                $is_ajax = $args['is_ajax'];
                $id = $is_ajax ? $DOT->post('id', 'int'):$args['id'];
                $settings_type = $is_ajax ? $DOT->post('settings_type'):$args['settings_type'];
                $key = $is_ajax ? $DOT->post('key'):$args['key'];
                $post_value = $is_ajax ? $DOT->post('value', false):$args['value'];
                $value = $key == 'hours_definitions' ? json_encode($post_value):$post_value;
                
                switch ($settings_type){
                    case 'calendar':
                        $table = $DOPBSP->tables->settings_calendar;
                        $id_type = 'calendar_id';
                        break;
                    case 'notifications':
                        $table = $DOPBSP->tables->settings_notifications;
                        $id_type = 'calendar_id';
                        break;
                    case 'payment':
                        $table = $DOPBSP->tables->settings_payment;
                        $id_type = 'calendar_id';
                        break;
                    case 'search':
                        $table = $DOPBSP->tables->settings_search;
                        $id_type = 'search_id';
                        break;
                    default:
                        $table = $DOPBSP->tables->settings;
                        $id_type = 'none';
                }
                
                /*
                 * Update settings tables.
                 */
                $control_data = $id_type == 'none' ? $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE name=%s',
                                                                                   $key)):
                                                     $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE '.$id_type.'=%d AND name=%s',
                                                                                   $id, $key));
                
                if ($wpdb->num_rows == 0){
                    $wpdb->insert($table, $id_type == 'none' ? array('name' => $key,
                                                                     'value' => $value):
                                                               array($id_type => $id,
                                                                     'name' => $key,
                                                                     'value' => $value));
                }
                else{
                    $wpdb->update($table, array('value' => $value), 
                                          $id_type == 'none' ? array('name' => $key):
                                                               array($id_type => $id,
                                                                     'name' => $key));
                }
                
		/*
		 * Update availability for some settings.
		 */
		if ($settings_type == 'calendar'
			&& ($key == 'booking_stop'
				|| $key == 'days_available'
				|| $key == 'days_morning_check_out'
				|| $key == 'hours_enabled')){
		    $DOT->models->availability->set($id);
		}
		
                /*
                 * Update calendars/searches tables.
                 */
                if ($id != 0){
                    switch ($key){
                        case 'currency':
                            if ($settings_type == 'search'){
                                $wpdb->update($DOPBSP->tables->searches, array('currency' => $value), 
                                                                         array('id' => $id));
                            }
                            break;
                        case 'currency_position':
                            if ($settings_type == 'search'){
                                $wpdb->update($DOPBSP->tables->searches, array('currency_position' => $value), 
                                                                         array('id' => $id));
                            }
                            break;
                        case 'hours_enabled':
                            if ($settings_type == 'calendar'){
                                $wpdb->update($DOPBSP->tables->calendars, array('hours_enabled' => $value), 
                                                                          array('id' => $id));
                            }
                            elseif ($settings_type == 'search'){
                                $wpdb->update($DOPBSP->tables->searches, array('hours_enabled' => $value), 
                                                                          array('id' => $id));
                            }
                            break;
                        case 'hours_interval_enabled':
                            if ($settings_type == 'calendar'){
                                $wpdb->update($DOPBSP->tables->calendars, array('hours_interval_enabled' => $value), 
                                                                          array('id' => $id));
                            }
                            break;
                    }
                }
                
                if ($is_ajax){
                    die();
                }
            }
            
            /*
             * Get options values from database.
             * 
             * @post id (integer): calendar/search ID
             * @post settings_type (integer): settings type
             * 
             * @return options values object
             */
            function values($id,
                            $settings_type){
                global $wpdb;
                global $DOPBSP;
                
                $values = new stdClass;
                
                switch ($settings_type){
                    case 'calendar':
                        $table = $DOPBSP->tables->settings_calendar;
                        $defaults = $this->default_calendar;
                        $id_type = 'calendar_id';
                        break;
                    case 'notifications':
                        $table = $DOPBSP->tables->settings_notifications;
                        $defaults = $this->default_notifications;
                        $id_type = 'calendar_id';
                        break;
                    case 'payment':
                        $table = $DOPBSP->tables->settings_payment;
                        $defaults = $this->default_payment;
                        $id_type = 'calendar_id';
                        break;
                    case 'search':
                        $table = $DOPBSP->tables->settings_search;
                        $defaults = $this->default_search;
                        $id_type = 'search_id';
                        break;
                    default:
                        $table = $DOPBSP->tables->settings;
                        $defaults = $this->default_general;
                        $id_type = 'none';
                }
                
                $settings = $id_type == 'none' ? $wpdb->get_results('SELECT name, value FROM '.$table, OBJECT_K):
                                                 $wpdb->get_results($wpdb->prepare('SELECT name, value FROM '.$table.' WHERE '.$id_type.'=%d', 
                                                                                   $id), OBJECT_K);
                $columns = $wpdb->get_results('DESCRIBE '.$table);
                
                foreach ($defaults as $key => $default){
                    $values->$key = isset($settings[$key]) ? $settings[$key]->value:(count($columns) > 5 ? $this->value($id, $settings_type, $key):$default);
                }
                
                if ($id_type != 'none'){
                    $values->$id_type = $id;
                }
                
                return $values;
            }
            
            /*
             * Get option value from database.
             * 
             * @post id (integer): calendar/search ID
             * @post settings_type (integer): settings type
             * @post key (string): option key
             * 
             * @return option value
             */
            function value($id,
                           $settings_type,
                           $key){
                global $wpdb;
                global $DOPBSP;
                
                switch ($settings_type){
                    case 'calendar':
                        $table = $DOPBSP->tables->settings_calendar;
                        $value_default = isset($this->default_calendar[$key]) ? $this->default_calendar[$key]:'Key is invalid!';
                        $id_type = 'calendar_id';
                        break;
                    case 'notifications':
                        $table = $DOPBSP->tables->settings_notifications;
                        $value_default = isset($this->default_notifications[$key]) ? $this->default_notifications[$key]:'Key is invalid!';
                        $id_type = 'calendar_id';
                        break;
                    case 'payment':
                        $table = $DOPBSP->tables->settings_payment;
                        $value_default = isset($this->default_payment[$key]) ? $this->default_payment[$key]:'Key is invalid!';
                        $id_type = 'calendar_id';
                        break;
                    case 'search':
                        $table = $DOPBSP->tables->settings_search;
                        $value_default = isset($this->default_search[$key]) ? $this->default_search[$key]:'Key is invalid!';
                        $id_type = 'search_id';
                        break;
                    default:
                        $table = $DOPBSP->tables->settings;
                        $value_default = isset($this->default_general[$key]) ? $this->default_general[$key]:'Key is invalid!';
                        $id_type = 'none';
                }
                
                if ($value_default != 'Key is invalid!'){
                    $value_data = $id_type == 'none' ? $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE name="%s"',
                                                                                     $key)):
                                                       $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE '.$id_type.'=%d AND name="%s"',
                                                                                     $id, $key));
                    
                    if ($wpdb->num_rows == 0){
                        if ($id_type != 'none'){
                            $value_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE '.$id_type.'=%d AND name=""',
                                                                        $id));
                        }
                        
                        if ($id_type != 'none'
                                && $wpdb->num_rows == 0){
                            $value = $value_default;
                        }
                        else{
                            $value = isset($value_data->$key) ? $value_data->$key:$value_default;
                        }
                    }
                    else{
                        $value = $value_data->value;
                    }
                }
                else{
                    $value = $value_default;
                }
                
                return $value;
            }  
        }
    }