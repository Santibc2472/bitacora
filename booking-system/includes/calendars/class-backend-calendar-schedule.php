<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.6
* File                    : includes/calendars/class-backend-calendar-schedule.php
* File Version            : 1.1.2
* Created / Last Modified : 25 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar schedule PHP class.
*/

    if (!class_exists('DOPBSPBackEndCalendarSchedule')){
        class DOPBSPBackEndCalendarSchedule extends DOPBSPBackEndCalendar{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
	     * IS AN AJAX REQUEST.
	     * 
             * Get calendar schedule.
             * 
             * @param args (array): function arguments
             * 
             * @post id (integer): calendar ID
             * @post year (integer): year for which the data will be loaded
             * 
             * @return schedule JSON
             */
            function get($args = array()){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $schedule = array();

                $calendar_id = !empty($args) ? $args['calendar_id']:$DOT->post('id', 'int');
                $year = !empty($args) ? $args['year']:$DOT->post('year', 'int');
                $firstYear = !empty($args) ? $args['firstYear']:$DOT->post('firstYear', 'int');
                
                $year = $year == '' ? date('Y'):$year;
                
                /*
                 * Settings
                 */
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');
                
                /*
                 * Set Timezone
                 */
                if($settings_calendar->timezone != '') {
                    date_default_timezone_set($settings_calendar->timezone);
                }
                
//                if($year == date('Y')) {
//                    // Sync with iCal
//                    $this->sync($calendar_id);
//                }
                
                $schedule = $DOT->models->calendar_schedule->get($calendar_id,
								 $year);

                if (count($schedule) > 0){
                    echo json_encode($schedule);
                }

                die();
            }
        
            /*
             * Sync calendar schedule.
             * 
             * @param calendar_id (integer): calendar ID
             * 
             * @return schedule JSON
             */
            function sync($calendar_id,
                          $adding_reservation = false){
                global $wpdb;
                global $DOPBSP;
                
                /*
                 * Settings
                 */
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');
                
                /*
                 * Set Timezone
                 */
                if($settings_calendar->timezone != '') {
                    date_default_timezone_set($settings_calendar->timezone);
                }
                // Google Calendar Sync
                if($settings_calendar->google_enabled == 'true'
                  && $settings_calendar->google_feed_url != ''){
                    
                    $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                              $calendar_id));
                    $google_update = (strtotime(date('Y-m-d H:i:s'))-strtotime($calendar->last_update_google)) >= $settings_calendar->google_sync_time ? 'true':'false';
                    
                    if($adding_reservation) {
                        $google_update = 'true';
                    }
                    
                    if($google_update == 'true') {
                        // Update Google
                        $current_date = date('Y-m-d');
                        
                        $ical   = new ICal($settings_calendar->google_feed_url);
                        $events = $ical->events();
                        
                        if(!empty($events)) {
                            // Save last update time
                            $wpdb->update($DOPBSP->tables->calendars, array('last_update_google' => date('Y-m-d H:i:s')), array('id' => $calendar_id));
                            
                            $cart = array();

                            foreach($events as $event) {
                                $check_in = date('Y-m-d', strtotime($event['DTSTART']));
                                $check_out = date('Y-m-d', strtotime($event['DTEND']));
                                $start_hour = '';
                                $end_hour = '';
                                
                                
                                if($check_out >= $current_date) {

                                    if(strlen($check_in) > 8
                                       && $settings_calendar->hours_enabled == 'true') {

                                        // set hours to google timezone
                                            if($settings_calendar->timezone !== ''){
                                                $start_hour_data = new DateTime($event['DTSTART'], new DateTimeZone('UTC'));
                                                $start_hour_data->setTimeZone(new DateTimeZone($settings_calendar->timezone));
                                                $start_hour =  $start_hour_data->format('H:i');
                                                                                                
                                                $end_hour_data = new DateTime($event['DTEND'], new DateTimeZone('UTC'));
                                                $end_hour_data->setTimeZone(new DateTimeZone($settings_calendar->timezone));

                                            if($settings_calendar->hours_interval_enabled == 'false') {
                                                $end_hour_data->modify('-1 hour');
                                                $end_hour =  $end_hour_data->format('H:i');
                                            } else {
                                                $end_hour =  $end_hour_data->format('H:i');
                                            }
                                        } else {
                                            $start_hour = date('H:i', strtotime($event['DTSTART']));
                                            $end_hour = date('H:i', strtotime($event['DTEND']));
                                        }
                                    } else {
                                        if ($settings_calendar->days_morning_check_out == 'false'){
                                            // check_out - 1 day
                                            $check_out_time = new DateTime($check_out.' 00:00:00');
                                            $check_out_time->modify('-1 day');
                                            $check_out = $check_out_time->format('Y-m-d');
                                        }
                                    }

                                    if($start_hour != '') {
                                        $check_in = date('Y-m-d', strtotime($event['DTEND']));
                                        $check_out = '';
                                    }

                                    $reservation = array('check_in' => $check_in,
                                                         'check_out' => $check_out,
                                                         'start_hour' => $start_hour,
                                                         'end_hour' => $end_hour,
                                                         'no_items' => 1,
                                                         'price' => 0,
                                                         'price_total' => 0,
                                                         'extras_price' => 0,
                                                         'discount_price' => 0,
                                                         'coupon_price' => 0,
                                                         'fees_price' => 0,
                                                         'deposit_price' => 0,
                                                         'uid' => $event['UID']);

                                    array_push($cart, $reservation);
                                }
                            }
                            
                            // Save reservations
                            $DOPBSP->classes->frontend_reservations->sync($calendar_id,
                                                                          'en',
                                                                          $DOPBSP->classes->currencies->get($settings_calendar->currency),
                                                                          $settings_calendar->currency,
                                                                          $cart,
                                                                          '',
                                                                          '',
                                                                          '',
                                                                          'none',
                                                                          '',
                                                                          'google');
                            
                            // delete deleted events from google
                            $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id=%d AND reservation_from="google" and status="approved"',
                                                           $calendar_id));
                            
                            foreach($reservations as $reservation) {
                                $found = false;
                                    
                                if ($settings_calendar->days_morning_check_out == 'false'
                                    && $reservation->start_hour == ''){
                                    // $reservation->check_out + 1 day
                                    $check_out_time = new DateTime($reservation->check_out.' 00:00:00');
                                    $check_out_time->modify('+1 day');
                                    $reservation->check_out = $check_out_time->format('Y-m-d');
                                }
                                
                                foreach($events as $event) {
                                    $check_in = date('Y-m-d', strtotime($event['DTSTART']));
                                    $check_out = date('Y-m-d', strtotime($event['DTEND']));
                                    $start_hour = '';
                                    $end_hour = '';

                                    if(strlen($check_in) > 8
                                       && $settings_calendar->hours_enabled == 'true') {

//                                        if(isset($ical->cal['VCALENDAR']['X-WR-TIMEZONE'])) {
//                                            // set hours to google timezone
//                                            $start_hour_data = new DateTime($event['DTSTART'], new DateTimeZone('UTC'));
//                                            $start_hour_data->setTimeZone(new DateTimeZone($ical->cal['VCALENDAR']['X-WR-TIMEZONE']));
//                                            $start_hour =  $start_hour_data->format('H:i');
//
//                                            $end_hour_data = new DateTime($event['DTEND'], new DateTimeZone('UTC'));
//                                            $end_hour_data->setTimeZone(new DateTimeZone($ical->cal['VCALENDAR']['X-WR-TIMEZONE']));
                                        // set hours to google timezone
                                            if($settings_calendar->timezone !== ''){
                                                $start_hour_data = new DateTime($event['DTSTART'], new DateTimeZone('UTC'));
                                                $start_hour_data->setTimeZone(new DateTimeZone($settings_calendar->timezone));
                                                $start_hour =  $start_hour_data->format('H:i');
                                                                                                
                                                $end_hour_data = new DateTime($event['DTEND'], new DateTimeZone('UTC'));
                                                $end_hour_data->setTimeZone(new DateTimeZone($settings_calendar->timezone));
   
                                            if($settings_calendar->hours_interval_enabled == 'false') {
                                                $end_hour_data->modify('-1 hour');
                                                $end_hour =  $end_hour_data->format('H:i');
                                            } else {
                                                $end_hour =  $end_hour_data->format('H:i');
                                            }
                                        } else {
                                            $start_hour = date('H:i', strtotime($event['DTSTART']));
                                            $end_hour = date('H:i', strtotime($event['DTEND']));
                                        }
                                        
                                        $check_in = date('Y-m-d', strtotime($event['DTEND']));
                                        $check_out = '';
                                    }
                                    
                                    if($event['UID'] == $reservation->uid
                                      && $check_in == $reservation->check_in
                                      && $check_out == $reservation->check_out
                                      && $start_hour == $reservation->start_hour
                                      && $end_hour == $reservation->end_hour){
                                        $found = true;
                                        break;
                                    }
                                }
                                
                                if(!$found) {
                                    $DOPBSP->classes->backend_calendar_schedule->setCanceled($reservation->id);
                                    $wpdb->delete($DOPBSP->tables->reservations, array('id' => $reservation->id));
                                }
                            }
                        }
                    }
                }
                
                // Airbnb Sync
                if($settings_calendar->airbnb_enabled == 'true'
                  && $settings_calendar->airbnb_feed_url != ''){
                    
                    $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                              $calendar_id));
                    $airbnb_update = (strtotime(date('Y-m-d H:i:s'))-strtotime($calendar->last_update_airbnb)) >= $settings_calendar->airbnb_sync_time ? 'true':'false';
                    
                    if($adding_reservation) {
                        $airbnb_update = 'true';
                    }
                    
                    if($airbnb_update == 'true') {
                        // Update Airbnb
                        $current_date = date('Y-m-d');
                        
                        $ical   = new ICal($settings_calendar->airbnb_feed_url);
                        $events = $ical->events();
                        
                        if(count($events) > 0) {
                            // Delete deleted Events
                            $this->deleteDeletedEvents($calendar_id,
                                                       $settings_calendar,
                                                       $events,
                                                       'airbnb');
                            
                            $cart = array();
                            foreach($events as $event) {
                                $check_in = date('Y-m-d', strtotime($event['DTSTART']));
                                $check_out = date('Y-m-d', strtotime($event['DTEND']));
                                $start_hour = '';
                                $end_hour = '';
                                if($check_out >= $current_date) {
                                    
                                    if(strlen($check_in) > 8
                                       && $settings_calendar->hours_enabled == 'true') {
                                        $start_hour = date('H:i', strtotime($event['DTSTART']));
                                        $end_hour = date('H:i', strtotime($event['DTEND']));
                                    } else {
                                        if ($settings_calendar->days_morning_check_out == 'false'){
                                            // check_out - 1 day
                                            $check_out_time = new DateTime($check_out.' 00:00:00');
                                            $check_out_time->modify('-1 day');
                                            $check_out = $check_out_time->format('Y-m-d');
                                        }
                                    }
                                    if($start_hour != '') {
                                        $check_in = date('Y-m-d', strtotime($event['DTEND']));
                                        $check_out = '';
                                    }
                                    $reservation = array('check_in' => $check_in,
                                                         'check_out' => $check_out,
                                                         'start_hour' => $start_hour,
                                                         'end_hour' => $end_hour,
                                                         'no_items' => 1,
                                                         'price' => 0,
                                                         'price_total' => 0,
                                                         'extras_price' => 0,
                                                         'discount_price' => 0,
                                                         'coupon_price' => 0,
                                                         'fees_price' => 0,
                                                         'deposit_price' => 0,
                                                         'uid' => $event['UID']);
                                    array_push($cart, $reservation);
                                }
                            }
                            // Save reservation
                            $DOPBSP->classes->frontend_reservations->sync($calendar_id,
                                                                          'en',
                                                                          $DOPBSP->classes->currencies->get($settings_calendar->currency),
                                                                          $settings_calendar->currency,
                                                                          $cart,
                                                                          '',
                                                                          '',
                                                                          '',
                                                                          'none',
                                                                          '',
                                                                          'airbnb');
                            // Save last update time
                            $wpdb->update($DOPBSP->tables->calendars, array('last_update_airbnb' => date('Y-m-d H:i:s')), array('id' => $calendar_id));
                        }
                    }
                }
            }
            
            function deleteDeletedEvents($calendar_id,
                                         $settings_calendar,
                                         $events,
                                         $source = 'google'){
                global $wpdb;
                global $DOPBSP;
                
                // delete deleted events from airbnb
                $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id=%d AND reservation_from="%s" AND status="%s"',
                                               $calendar_id, $source, 'approved'));
                foreach($reservations as $reservation) {
                    $found = false;
                    if ($settings_calendar->days_morning_check_out == 'false'
                        && $reservation->start_hour == ''){
                        // $reservation->check_out + 1 day
                        $check_out_time = new DateTime($reservation->check_out.' 00:00:00');
                        $check_out_time->modify('+1 day');
                        $reservation->check_out = $check_out_time->format('Y-m-d');
                    }
                    foreach($events as $event) {
                        $check_in = date('Y-m-d', strtotime($event['DTSTART']));
                        $check_out = date('Y-m-d', strtotime($event['DTEND']));
                        $start_hour = '';
                        $end_hour = '';
                        
                        if($check_in == $reservation->check_in
                          && $check_out == $reservation->check_out
                          && $start_hour == $reservation->start_hour
                          && $end_hour == $reservation->end_hour){
                            $found = true;
                            break;
                        } 
                    }
                    if(!$found) {
                        $DOPBSP->classes->backend_calendar_schedule->setCanceled($reservation->id);
                        $wpdb->delete($DOPBSP->tables->reservations, array('id' => $reservation->id));
                    }
                }
            }
            
            /*	
             * Set calendar schedule.
             * 
             * @post id (integer): calendar ID
             * @post schedule (string): calendar data
             * @post hours_enabled (string): hours enabled
             */
            function set(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;

                $default_availability = $DOT->post('default_availability');
                $schedule = json_decode(stripslashes(utf8_encode($DOT->post('schedule'))));
                $id = $DOT->post('id', 'int');
                $hours_enabled = $DOT->post('hours_enabled');
                
                if($default_availability == 'false') {
                    $days = array();
                    $query_insert_values = array();
                    $schedule = (array)$schedule;

                    /*
                     * Set days data.
                     */
                    while ($data = current($schedule)){
                        $price_min  = 1000000000;
                        $price_max  = 0;
                        $min_available  = 0;

                        $day = key($schedule);
                        array_push($days, $day);
                        $day_items = explode('-', $day);

                        $control_data = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                          $id, $day));

                        if ($hours_enabled == 'true'){
                            foreach ($data->hours as $hour):
                                $price = $hour->promo == '' ? ($hour->price == '' ? 0:(float)$hour->price):(float)$hour->promo;
                                $available = $hour->available == '' && ($hour->status != 'booked' && $hour->status != 'none' && $hour->status != 'unavailable') ? ($hour->available == '' ? 0:(float)$hour->available):(float)$hour->available;

                                if ($hour->price != '0'){
                                    $price_min = $price < $price_min ? $price:$price_min;
                                    $price_max = $price > $price_max ? $price:$price_max;
                                }

                                if ($hour->available != '0'){
                                    $min_available = $available < $min_available ? $available:$min_available;
                                }
                            endforeach;
                        }
                        else{
                            $price_min = $data->promo == '' ? ($data->price == '' ? 0:(float)$data->price):(float)$data->promo;
                            $price_max = $price_min;
                            $min_available = $data->available == '' && ($data->status != 'booked' && $data->status != 'none' && $data->status != 'unavailable') ? ($data->available == '' ? 0:(float)$data->available):(float)$data->available;
                        }

                        if ($wpdb->num_rows != 0){
                            $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data),
                                                                       'min_available' => $min_available,
                                                                       'price_min' => $price_min,
                                                                       'price_max' => $price_max), 
                                                                 array('calendar_id' => $id,
                                                                       'day' => $day));
                        }
                        else{
                            array_push($query_insert_values, '(\''.$id.'_'.$day.'\', \''.$id.'\', \''.$day.'\', \''.$day_items[0].'\', \''.json_encode($data).'\', \''.$min_available.'\', \''.$price_min.'\', \''.$price_max.'\')');
                        }
                        next($schedule);                        
                    }

                    if (count($query_insert_values) > 0){
                        $wpdb->query('INSERT INTO '.$DOPBSP->tables->days.' (unique_key, calendar_id, day, year, data, min_available, price_min, price_max) VALUES '.implode(', ', $query_insert_values));
                    }

                    $this->clean();
		    $DOT->models->availability->set($id);
                } else {
                    $DOT->models->calendar_schedule_default->set($id,
                                                                 $schedule);
                }
                
                die();      
            }
            
            /*
             * Get the list between 2 hours, included.
             * 
             * @param day (String): check in day (YYYY-MM-DD)
             * @param startHour (String): start hour (HH-MM)
             * @param endHour (String): end hour (HH-MM)
             * 
             * @return array with selected hours
             */
            function getDaysHoursSelected($day,
                                          $startHour,
                                          $endHour,
                                          $calendar_id){
                global $wpdb;
                global $DOPBSP;
                $schedule = array();
                $selectedHours = array();
                
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                          $calendar_id));
                
                $default_schedule = $calendar->default_availability != '' ? $calendar->default_availability:'{"available": 1,
                                                                                                               "bind": 0,
                                                                                                               "price": 0,
                                                                                                               "promo": 0,
                                                                                                               "info":  "",
                                                                                                               "info_body": "",
                                                                                                               "info_info": "",
                                                                                                               "notes": "",
                                                                                                               "hours":{},
                                                                                                               "hours_definitions":[{"value":"00:00"}],
                                                                                                               "status": "available"}';
                $default_schedule = json_decode($default_schedule);
                $default_schedule = (array)$default_schedule;
                
                
                $day_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                $calendar_id, $day));
                if ($wpdb->num_rows != 0){
                    $day_schedule = json_decode($day_data->data);
                    $day_schedule = (array)$day_schedule;
                } else {
                    $day_schedule = $default_schedule;
                }
                
                /*
                 * Verify hours.
                 */
                $endHour = $endHour == '' ? $startHour:$endHour;
                $hours_definitions = $day_schedule['hours_definitions'];
                $found = 0;
                
                foreach($hours_definitions as $index => $hours_definition){
                    if ($startHour <= $hours_definitions[$index]->value 
                            && $hours_definitions[$index]->value <= $endHour){
                        $found++; 
                        array_push($selectedHours, $hours_definitions[$index]->value);
                    }
                }
                
//                if(($endHour == $startHour
//                        && $found < 2)
//                   || ($endHour != $startHour
//                        && $found < 1)){
//                    $selectedHours = array();
//                }
                
                return $selectedHours;
            }
            
            /*
             * Get the history (current schedule) between 2 hours, included.
             * 
             * @param day (String): check in day (YYYY-MM-DD)
             * @param startHour (String): start hour (HH-MM)
             * @param endHour (String): end hour (HH-MM)
             * 
             * @return curent schedule
             */
            function daysHoursHistory($day,
                                      $startHour,
                                      $endHour,
                                      $calendar_id){
                global $wpdb;
                global $DOPBSP;
                $history = array();
                $history_all = array();
                $selectedDays = array();
                $schedule = array();
                
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                          $calendar_id));
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');
                
                $default_schedule = $calendar->default_availability != '' ? $calendar->default_availability:'{"available": 1,
                                                                                                   "bind": 0,
                                                                                                   "price": 0,
                                                                                                   "promo": 0,
                                                                                                   "info":  "",
                                                                                                   "info_body": "",
                                                                                                   "info_info": "",
                                                                                                   "notes": "",
                                                                                                   "hours":{},
                                                                                                   "hours_definitions":[{"value":"00:00"}],
                                                                                                   "status": "available"}';
                $default_schedule = json_decode($default_schedule);
                $default_schedule = (array)$default_schedule;
                
                
                $day_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                $calendar_id, $day));
                if ($wpdb->num_rows != 0){
                    $day_schedule = json_decode($day_data->data);
                    $day_schedule = (array)$day_schedule;
                } else {
                    $day_schedule = $default_schedule;
                }

                /*
                 * Verify hours.
                 */
                $endHour = $endHour == '' ? $startHour:$endHour;

                /*
                 * Get selected hours.
                 */
                $selectedHours = $this->getDaysHoursSelected($day,
                                                             $startHour,
                                                             $endHour,
                                                             $calendar_id);
                
                if(!empty($selectedHours)){
                    $hours_length = count($selectedHours)-(!$settings_calendar->hours_multiple_select == 'true' ? true:($settings_calendar->hours_add_last_hour_to_total_price == 'true' && $settings_calendar->hours_interval_enabled == 'false' ? true:false) || ($settings_calendar->hours_multiple_select == 'false' ? false:($settings_calendar->hours_interval_enabled == 'true' ? true:false)) && ($settings_calendar->hours_multiple_select == 'true' ? true:false) ? 1:0);
                    
                    for ($i=0; $i<=$hours_length; $i++){
                        $currHour = $selectedHours[$i];

                        // Day not exist 
                        if (!array_key_exists($day, $history)) {
                            $history_all[$day] = $day_schedule;
                        }

                        if (!array_key_exists($currHour, $history_all[$day]['hours'])) {
                            $default = '{"available": 1,
                                         "bind": 0,
                                         "price": 0,
                                         "promo": 0,
                                         "info":  "",
                                         "info_body": "",
                                         "info_info": "",
                                         "notes": "",
                                         "status": "available"}';
                            $default_history = $history_all[$day]['hours'][$currHour] != '' ? $history_all[$day]['hours'][$currHour]:json_decode($default);
                            $default_history = (array)$default_history;
                        } else {
                            $default_history = $history_all[$day]['hours']->{$currHour};
                        }
                        
                        $history[$currHour] = $default_history;
                    }
                }
                return $history;
            }
            
            /*
             * Get the history (current schedule) between 2 dates, included.
             * 
             * @param ciDay (String): check in day (YYYY-MM-DD)
             * @param coDay (String): check out day (YYYY-MM-DD)
             * 
             * @return curent schedule
             */
            function daysHistory($ciDay, 
                                 $coDay,
                                 $calendar_id){
                global $DOT;
		global $wpdb;
                global $DOPBSP;
		
                $history = array();
                $selectedDays = array();
                $schedule = array();
                
                $days = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d',
                                                          $calendar_id));
                foreach ($days as $day):
                    $schedule[$day->day] = json_decode($day->data);
                    $schedule[$day->day] = (array)$schedule[$day->day];
                endforeach;
                
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                          $calendar_id));

                $default_availability = $calendar->default_availability;
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');

                /*
                 * Verify days.
                 */
                $coDay = $coDay == '' ? $ciDay:$coDay;

                /*
                 * Get selected days.
                 */
                $selectedDays = $DOT->models->days->get($ciDay,
							$coDay);

                for ($i=0; $i<count($selectedDays)- ($settings_calendar->days_morning_check_out == 'true' ? 1:0); $i++){
                    $currDay = $selectedDays[$i];

                    $history[$currDay] = $default_availability != '' ? $default_availability:'{"available": 1,
                                                                                               "bind": 0,
                                                                                               "price": 0,
                                                                                               "promo": 0,
                                                                                               "info":  "",
                                                                                               "info_body": "",
                                                                                               "info_info": "",
                                                                                               "notes": "",
                                                                                               "hours":{},
                                                                                               "hours_definitions":[{"value":"00:00"}],
                                                                                               "status": "available"}';
                    
                    $history[$currDay] = json_decode($history[$currDay]);
                    $history[$currDay] = (array)$history[$currDay];

                    if (!array_key_exists($currDay, $schedule)) {
                        $schedule[$currDay] = $history[$currDay];
                    }

                    $history[$currDay]['available'] = $schedule[$currDay]['available'];
                    $history[$currDay]['bind'] = $schedule[$currDay]['bind'];
                    $history[$currDay]['price'] = $schedule[$currDay]['price'];
                    $history[$currDay]['promo'] = $schedule[$currDay]['promo'];
                    $history[$currDay]['status'] = $schedule[$currDay]['status'];
                }
                
                if(!empty($history)) {
                    $history = json_encode($history);
                }

                return $history;
                
            }
            
            /*
             * Change schedule when reservation is approved.
             * 
             * @param reservation_id (integer): reservation ID
             */
            function setApproved($reservation_id){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $new_info_info = new stdClass;
                $new_info_body = new stdClass;
                
                $reservation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id=%d',
                                                             $reservation_id));
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($reservation->calendar_id,  
                                                                                'calendar');
                
                /*
                 * Get info data.
                 */        
                $info_info = $this->getFormInfo(json_decode($reservation->form));
                $info_body = $this->getFormInfo(json_decode($reservation->form), 'body');
                
                if ($info_info != ''){
                    $new_info_info->reservation_id = $reservation_id;
                    $new_info_info->data = $info_info;
                }
                
                if ($info_body != ''){
                    $new_info_body->reservation_id = $reservation_id;
                    $new_info_body->data = $info_body;
                }
                        
                /*
                 * Select days to be updated.
                 */
                if ($reservation->check_out == ''){
                    $day = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                         $reservation->calendar_id, $reservation->check_in));
                }
                else{
                    if ($settings_calendar->days_morning_check_out == 'true'){
                        $days = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day>="%s" AND day<"%s"',
                                                                  $reservation->calendar_id, $reservation->check_in, $reservation->check_out));
                    }
                    else{
                        $days = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day>="%s" AND day<="%s"',
                                                                  $reservation->calendar_id, $reservation->check_in, $reservation->check_out));
                    }
                }

                if ($reservation->check_out == '' 
                        && $reservation->start_hour == ''){
                /*
                 * Change single day.
                 */   
                    
                    $data = json_decode($day->data);

                    if ($data->available == '' 
                            || (int)$data->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = $data->available;
                    }

                    if ($available-$reservation->no_items == 0){
                        $data->price = '';
                        $data->promo = '';
                        $data->status = 'booked';
                    }

                    $data->available = $available-$reservation->no_items;
                    
                    if (isset($new_info_body->reservation_id)){
                        if (!isset($data->info_info)
                                || $data->info_info == null){
                            $data->info_info = array();
                        }
                        array_push($data->info_info, $new_info_info);
                    }
                    
                    if (isset($new_info_body->reservation_id)){
                        if (!isset($data->info_body)
                                || $data->info_body == null){
                            $data->info_body = array();
                        }
                        array_push($data->info_body, $new_info_body);
                    }

                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                }
                else if ($reservation->check_out != ''){    
                /*
                 * Change multiple days.
                 */ 
                    foreach ($days as $key => $day){
                        $data = json_decode($day->data);

                        if ($data->available == '' 
                                || (int)$data->available < 1){
                            $available = 1;
                        }
                        else{
                            $available = $data->available;
                        }
                        
                        if ($available-$reservation->no_items == 0){
                            $data->price = '';
                            $data->promo = '';
                            $data->status = 'booked';
                        }

                        $data->available = $available-$reservation->no_items;
                    
                        if (isset($new_info_body->reservation_id)){
                            if (!isset($data->info_info)
                                    || $data->info_info == null){
                                $data->info_info = array();
                            }
                            array_push($data->info_info, $new_info_info);
                        }

                        if (isset($new_info_body->reservation_id)){
                            if (!isset($data->info_body)
                                    || $data->info_body == null){
                                $data->info_body = array();
                            }
                            array_push($data->info_body, $new_info_body);
                        }
                        $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                             array('calendar_id' => $reservation->calendar_id, 
                                                                   'day' => $day->day));
                    }
                }
                else if ($reservation->start_hour != '' 
                            && $reservation->end_hour == ''){    
                /*
                 * Change single hour.
                 */
                    
                    $data = json_decode($day->data);
                    $start_hour = $reservation->start_hour;
                    $hour = $data->hours->$start_hour;

                    if ($hour->available == '' 
                            || (int)$hour->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = (int)$hour->available;
                    }

                    if ($available-$reservation->no_items == 0){
                        $hour->price = '';
                        $hour->promo = '';
                        $hour->status = 'booked';
                    }

                    $hour->available = $available-$reservation->no_items;
                    
                    if (isset($new_info_body->reservation_id)){
                        if (!isset($hour->info_info)
                                || $hour->info_info == null){
                            $hour->info_info = array();
                        }
                        array_push($hour->info_info, $new_info_info);
                    }
                    
                    if (isset($new_info_body->reservation_id)){
                        if (!isset($hour->info_body)
                                || $hour->info_body == null){
                            $hour->info_body = array();
                        }
                        array_push($hour->info_body, $new_info_body);
                    }

                    $data->hours->$start_hour = $hour;
                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                    
                    if ($settings_calendar->days_details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, 
                                               $day->day);
                    }
                }
                else if ($reservation->end_hour != ''){  
                /*
                 * Change multiple hour.
                 */
                    
                    $data = json_decode($day->data);

                    foreach ($data->hours as $key => $item){
                        if ($reservation->start_hour <= $key 
                                && ((($settings_calendar->hours_add_last_hour_to_total_price == 'false' 
                                                        || $settings_calendar->hours_interval_enabled == 'true') 
                                                && $key < $reservation->end_hour) || 
                                        ($settings_calendar->hours_add_last_hour_to_total_price == 'true' 
                                                        && $settings_calendar->hours_interval_enabled == 'false' 
                                                        && $key <= $reservation->end_hour))){                           
                            $hour = $data->hours->$key;

                            if ($hour->available == '' 
                                    || (int)$hour->available < 1){
                                $available = 1;
                            }
                            else{
                                $available = (int)$hour->available;
                            }

                            if ($available-$reservation->no_items == 0){
                                $hour->price = '';
                                $hour->promo = '';
                                $hour->status = 'booked';
                            }

                            $hour->available = $available-$reservation->no_items;
                            $data->available = $data->available-$reservation->no_items;

                            if ($data->available < 1){
                                $hour->price = '';
                                $hour->promo = '';
                                $hour->status = 'booked';
                            }
                    
                            if (isset($new_info_body->reservation_id)){
                                if (!isset($hour->info_info)
                                        || $hour->info_info == null){
                                    $hour->info_info = array();
                                }
                                array_push($hour->info_info, $new_info_info);
                            }

                            if (isset($new_info_body->reservation_id)){
                                if (!isset($hour->info_body)
                                        || $hour->info_body == null){
                                    $hour->info_body = array();
                                }
                                array_push($hour->info_body, $new_info_body);
                            }

                            $data->hours->$key = $hour;
                        }
                    }

                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)),
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                    
                    if ($settings_calendar->days_details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id,
                                                             $day->day);
                    }
                }
                
                $this->clean();
		$DOT->models->availability->set($reservation->calendar_id);
            }
            
           
            /*
             * Change schedule when reservation is canceled.
             * 
             * @param reservation_id (integer): reservation ID
             */
            function setCanceled($reservation_id){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $reservation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id=%d',
                                                             $reservation_id));
                $settings_calendar = $DOPBSP->classes->backend_settings->values($reservation->calendar_id,  
                                                                                'calendar');
                
                $history = str_replace('\"', '"', $reservation->days_hours_history);
                $history = str_replace('"{"', '{"', $history);
                $history = str_replace('"}}"', '"}}', $history);
                
                $history = json_decode($history);    
                
                /*
                 * Select days to be updated.
                 */
                if ($reservation->check_out == ''){
                    $day = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                         $reservation->calendar_id, $reservation->check_in));
                }
                else{
                    if ($settings_calendar->days_morning_check_out == 'true'){
                        $days = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day>="%s" AND day<"%s"',
                                                                  $reservation->calendar_id, $reservation->check_in, $reservation->check_out));
                    }
                    else{
                        $days = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day>="%s" AND day<="%s"',
                                                                  $reservation->calendar_id, $reservation->check_in, $reservation->check_out));
                    }
                }
                
                if ($reservation->check_out == '' 
                        && $reservation->start_hour == ''){ 
                /*
                 * Change single day.
                 */ 
                    $data = json_decode($day->data);
                    $day_date = $day->day;
                    
                    if ($data->status == 'booked'){
                        $data->available = $history->{$day_date}->available == '' ? 'none':$data->available+$reservation->no_items;
                        $data->bind = (int)$history->{$day_date}->bind;
                        $data->price = (float)$history->{$day_date}->price;
                        $data->promo = (float)$history->{$day_date}->promo;
                        $data->status = $history->{$day_date}->status == null ? 'none':$history->$day_date->status;
                    }
                    else{
                        if ($data->available != ''){
                            $data->available = $data->available+$reservation->no_items;
                        }
                    }
                    $data->info_info = $this->deleteFormInfo($reservation_id,
                                                             isset($data->info_info) ? $data->info_info:array());
                    $data->info_body = $this->deleteFormInfo($reservation_id,
                                                             isset($data->info_body) ? $data->info_body:array());
                    
                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day_date));
                }
                else if ($reservation->check_out != ''){  
                /*
                 * Change multiple days.
                 */                
                    foreach ($days as $key => $day){
                        $data = json_decode($day->data);
                        $day_date = $day->day;

                        if ($data->status == 'booked'){
                            $data->available = $history->{$day_date}->available == '' ? '':$data->available+$reservation->no_items;
                            $data->bind = (int)$history->{$day_date}->bind;
                            $data->price = (float)$history->{$day_date}->price;
                            $data->promo = (float)$history->{$day_date}->promo;
                            $data->status = $history->{$day_date}->status == null ? 'none':$history->$day_date->status;
                        }
                        else{
                            if ($data->available != ''){
                                $data->available = $data->available+$reservation->no_items;
                            }
                        }
                        $data->info_info = $this->deleteFormInfo($reservation_id,
                                                                 isset($data->info_info) ? $data->info_info:array());
                        $data->info_body = $this->deleteFormInfo($reservation_id,
                                                                 isset($data->info_body) ? $data->info_body:array());
                        
                        $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                             array('calendar_id' => $reservation->calendar_id, 
                                                                   'day' => $day_date));
                    }
                }
                else if ($reservation->start_hour != '' 
                            && $reservation->end_hour == ''){ 
                /*
                 * Change single hour.
                 */
                    $data = json_decode($day->data);
                    $hour_time = $reservation->start_hour;
                    $hour = $data->hours->$hour_time;
                    
                    if ($hour->status == 'booked'){
                        $hour->available = $history->{$hour_time}->available == '' ? '':$hour->available+$reservation->no_items;
                        $hour->bind = (int)$history->{$hour_time}->bind;
                        $hour->price = (float)$history->{$hour_time}->price;
                        $hour->promo = (float)$history->{$hour_time}->promo;
                        $hour->status = $history->{$hour_time}->status;
                    }
                    else{
                        if ($hour->available != ''){
                            $hour->available = $hour->available+$reservation->no_items;
                        }
                    }
                    $hour->info_info = $this->deleteFormInfo($reservation_id,
                                                             isset($data->info_info) ? $data->info_info:array());
                    $hour->info_body = $this->deleteFormInfo($reservation_id,
                                                             isset($data->info_body) ? $data->info_body:array());

                    $data->hours->$hour_time = $hour;
                    
                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                    
                    if ($settings_calendar->days_details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, 
                                               $day->day);
                    }
                }
                else if ($reservation->end_hour != ''){ 
                /*
                 * Change multiple hours.
                 */
                    $data = json_decode($day->data);

                    foreach ($data->hours as $key => $item){
                        if ($reservation->start_hour <= $key &&
                                ((($settings_calendar->hours_add_last_hour_to_total_price == 'false' 
                                                        || $settings_calendar->hours_interval_enabled == 'true') 
                                                && $key < $reservation->end_hour) || 
                                        ($settings_calendar->hours_add_last_hour_to_total_price == 'true' 
                                                        && $settings_calendar->hours_interval_enabled == 'false' 
                                                        && $key <= $reservation->end_hour))){
                            $hour_time = $key;
                            $hour = $data->hours->$hour_time;

                            if ($hour->status == 'booked'){
                                $hour->available = $history->{$hour_time}->available == '' ? '':$hour->available+$reservation->no_items;
                                $hour->bind = (int)$history->{$hour_time}->bind;
                                $hour->price = (float)$history->{$hour_time}->price;
                                $hour->promo = (float)$history->{$hour_time}->promo;
                                $hour->status = $history->{$hour_time}->status;
                            }
                            else{
                                if ($hour->available != ''){
                                    $hour->available = $hour->available+$reservation->no_items;
                                }
                            }
                            
                            $hour->info_info = $this->deleteFormInfo($reservation_id,
                                                                     isset($data->info_info) ? $data->info_info:array());
                            $hour->info_body = $this->deleteFormInfo($reservation_id,
                                                                     isset($data->info_body) ? $data->info_body:array());

                            $data->hours->{$hour_time} = $hour;
                        }

                        $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                             array('calendar_id' => $reservation->calendar_id, 
                                                                   'day' => $day->day));
                        
                        if ($settings_calendar->days_details_from_hours == 'true'){
                            $this->setDayFromHours($reservation->calendar_id,
                                                   $day->day);
                        }
                    }
                }
                
                $this->clean();
		$DOT->models->availability->set($reservation->calendar_id);
            }
            
            /*
             * Set day data from hours data.
             * 
             * @param caledar_id (integer): calendar ID
             * @param day (string): selected day in YYYY-MM-DD format
             */
            function setDayFromHours($calendar_id, 
                                     $day){
                global $wpdb;
                global $DOPBSP;
                
                $day_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                          $calendar_id, $day));
                $data = json_decode($day_data->data);
                
                $available = 0;
                $price = '';
                $status = 'none';

                foreach ($data->hours as $hour){
                    if ($hour->bind == 0 
                            || $hour->bind == 1){
                        /*
                         * Check availability.
                         */
                        if ($hour->available != ''){
                            $available += $hour->available;
                        }

                        /*
                         * Check price.
                         */
                        if ($hour->price != '' 
                                && ($price == '' 
                                        || (float)$hour->price < $price)){
                            $price = (float)$hour->price;
                        }

                        if ($hour->promo != '' 
                                && ($price == '' 
                                        || (float)$hour->promo < $price)){
                            $price = (float)$hour->promo;
                        }

                        /*
                         * Check status 
                         */
                        if ($hour->status == 'unavailable' 
                                && $status == 'none'){
                            $status = 'unavailable';
                        }

                        if ($hour->status == 'booked' 
                                && ($status == 'none' 
                                        || $status == 'unavailable')){
                            $status = 'booked';
                        }

                        if ($hour->status == 'special' 
                                && ($status == 'none' 
                                        || $status == 'unavailable' 
                                        || $status == 'booked')){
                            $status = 'special';
                        }

                        if ($hour->status == 'available'){
                            $status = 'available';
                        }
                    }
                }
                
                $data->available = $available == 0 ? '':$available;
                $data->status = $status;
                
                $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                     array('calendar_id' => $calendar_id, 
                                                           'day' => $day));
            }
            
            /*
             * Delete calendar schedule.
             * 
             * @post id (integer): calendar ID
             * @post schedule (string): calendar data
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
		
		$id = $DOT->post('id', 'int');
                $schedule = json_decode(stripslashes($DOT->post('schedule')));
                
                $days = array();
                $query = array();

                while ($data = current($schedule)){
                    $day = key($schedule);
                    array_push($days, $day);
                    array_push($query, 'day="'.$day.'"');                
                    next($schedule);                        
                }
                
                if (count($query) > 0){
                    $wpdb->query('DELETE FROM '.$DOPBSP->tables->days.' WHERE calendar_id="'.$id.'" AND ('.implode(' OR ', $query).')');
                }
                
		$DOT->models->availability->set($id);

                die();
            }
            
            /*
             * Clean database by past days data.
             */
            function clean(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->query('DELETE FROM '.$DOPBSP->tables->days.' WHERE day < "'.date('Y-m-d').'"');
            }
            
            /*
             * Check if days are available.
             * 
             * @param calendar_id (integer): calendar ID
             * @param check_in (string): check in day in "YYYY-MM-DD" format
             * @param check_out (string): check out day in "YYYY-MM-DD" format
             * @param no_items (integer): no of booked items
             * 
             * @return true/false
             */
            function validateDays($calendar_id,
                                  $check_in,
                                  $check_out,
                                  $no_items = 1){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $check_out = $check_out == '' ? $check_in:$check_out;
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');
                
                $selected_days = $DOT->models->days->get($check_in,
							 $check_out);
                
                // Default Availability
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                             $calendar_id));

                if($calendar->default_availability != '') {
                    $default_availability = json_decode($calendar->default_availability);
                }
                
                for ($i=0; $i<count($selected_days)-($settings_calendar->days_morning_check_out == 'true' ? 1:0); $i++){
                    $day = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                         $calendar_id, $selected_days[$i]));
                    
                    if($wpdb->num_rows < 1) {
                        $day_data = $default_availability;
//                        $day->data = json_encode($default_availability);
                    }
                    else{
                        $day_data = json_decode($day->data);
                    }
                    if ($day_data->status != 'available'
                            && $day_data->status != 'special'
                            || ($day_data->available != '' && $no_items > $day_data->available)
                            || ($day_data->available == '' && $no_items > 1)){
                        return false;
                    }
                }
                
                return true;
            }
            
            /*
             * Check if reservations (days) do not overlap.
             * 
             * @param calendar_id (integer): calendar ID
             * @param reservations (array): a list of reservations to be verified
             * 
             * @return true/false
             */
            function validateDaysOverlap($calendar_id,
                                         $reservations){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
		
		$days = array();
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');
		$default_schedule = json_encode($DOT->models->calendar_schedule_default->get($calendar_id));

                for ($i=0; $i<count($reservations); $i++){
                    $check_in = $reservations[$i]->check_in;
                    $check_out = $reservations[$i]->check_out == '' ? $reservations[$i]->check_in:$reservations[$i]->check_out;
                    $no_items = $reservations[$i]->no_items;
                    
                    if ($this->validateDays($calendar_id, $check_in, $check_out, $no_items)){
                        $selected_days = $DOT->models->days->get($check_in,
								 $check_out);

                        for ($j=0; $j<count($selected_days)-($settings_calendar->days_morning_check_out == 'true' ? 1:0); $j++){
                            if (!isset($days[$selected_days[$j]])){
                                $day = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                     $calendar_id, $selected_days[$j]));
                                $days[$selected_days[$j]] = isset($day->data) ? json_decode($day->data):json_decode($default_schedule);
                            }

                            $day_data = $days[$selected_days[$j]];
			    
                            if ($day_data->status != 'available'
                                    && $day_data->status != 'special'
                                    || ($day_data->available != '' && $no_items > $day_data->available)
                                    || ($day_data->available == '' && $no_items > 1)){
                                return false;
                            }
                            else{
                                if ($day_data->available == '' 
                                        || (int)$day_data->available < 1){
                                    $available = 1;
                                }
                                else{
                                    $available = $day_data->available;
                                }

                                if ($available-$no_items == 0){
                                    $days[$selected_days[$j]]->status = 'booked';
                                }
                                $days[$selected_days[$j]]->available = $available-$no_items;
                            }
                        }
                    }
                }
                
                return true;
            }
            
            /*
             * Check if hours are available.
             * 
             * @param calendar_id (integer): calendar ID
             * @param reservations (array): a list of reservations to be verified
             * 
             * @return true/false
             */
            function validateHours($calendar_id,
                                   $day,
                                   $start_hour,
                                   $end_hour,
                                   $no_items = 1){
                global $wpdb;
                global $DOPBSP;
                
                $end_hour = $end_hour == '' ? $start_hour:$end_hour;
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');
                
                // Default Availability
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                             $calendar_id));

                $default_availability = json_decode($calendar->default_availability);
                
                $day = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                     $calendar_id, $day));
                
                if($wpdb->num_rows < 1) {
                    $day = $default_availability;
                    $day->data = json_encode($default_availability);
                }
                
                $day_data = json_decode($day->data);
                
                foreach ($day_data->hours as $key => $hour){
                    if ($start_hour <= $key 
                            && ((($settings_calendar->hours_add_last_hour_to_total_price == 'false' 
                                                    || $settings_calendar->hours_interval_enabled == 'true') 
                                            && $key < $end_hour) || 
                                    ($settings_calendar->hours_add_last_hour_to_total_price == 'true' 
                                            && $settings_calendar->hours_interval_enabled == 'false' 
                                            && $key <= $end_hour) || 
                                    ($start_hour == $end_hour
                                            && $key <= $end_hour))
                            && ($hour->status != 'available'
                                    && $hour->status != 'special'
                                    || ($hour->available != '' && $no_items > $hour->available)
                                    || ($hour->available == '' && $no_items > 1))){
                        return false;
                    }
                }
                
                return true;
            }
            
            /*
             * Check if reservations (hours) do not overlap.
             * 
             * @param calendar_id (integer): calendar ID
             * @param reservations (array): a list of reservations to be verified
             * 
             * @return true/false
             */
            function validateHoursOverlap($calendar_id,
                                          $reservations){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
		
                $days = array();
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                'calendar');
		$default_schedule = json_encode($DOT->models->calendar_schedule_default->get($calendar_id));
                
                for ($i=0; $i<count($reservations); $i++){
                    $day = $reservations[$i]->check_in;
                    $start_hour = $reservations[$i]->start_hour;
                    $end_hour = $reservations[$i]->end_hour == '' ? $reservations[$i]->start_hour:$reservations[$i]->end_hour;
                    $no_items = $reservations[$i]->no_items;
                    
                    if ($this->validateHours($calendar_id, $day, $start_hour, $end_hour, $no_items)){
                        if (!isset($days[$day])){
                            $day_result = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                        $calendar_id, $day));
			    $days[$day] = isset($day_result->data) ? json_decode($day_result->data):json_decode($default_schedule);
                        }

                        $day_data = $days[$day];

                        foreach ($day_data->hours as $key => $hour){
                            if ($start_hour <= $key 
                                    && ((($settings_calendar->hours_add_last_hour_to_total_price == 'false' 
                                                            || $settings_calendar->hours_interval_enabled == 'true') 
                                                    && $key < $end_hour) || 
                                            ($settings_calendar->hours_add_last_hour_to_total_price == 'true' 
                                                            && $settings_calendar->hours_interval_enabled == 'false' 
                                                            && $key <= $end_hour))
                                    && ($hour->status != 'available'
                                            && $hour->status != 'special'
                                            || ($hour->available != '' && $no_items > $hour->available)
                                            || ($hour->available == '' && $no_items > 1))){
				return false;
                            }
                            else{
                                if ($start_hour <= $key
                                    && ((($settings_calendar->hours_add_last_hour_to_total_price == 'false' 
                                                            || $settings_calendar->hours_interval_enabled == 'true') 
                                                    && $key < $end_hour) || 
                                            ($settings_calendar->hours_add_last_hour_to_total_price == 'true' 
                                                            && $settings_calendar->hours_interval_enabled == 'false' 
                                                            && $key <= $end_hour))){
                                    if ($hour->available == '' 
                                            || (int)$hour->available < 1){
                                        $available = 1;
                                    }
                                    else{
                                        $available = (int)$hour->available;
                                    }

                                    if ($available-$no_items == 0){
                                        $hour->status = 'booked';
                                    }

                                    $hour->available = $available-$no_items;

                                    $days[$day]->hours->$key = $hour;
                                }
                            }
                        }
                    }
                    else{
                        return false;
                    }
                }
                
                return true;
            }
            
            /*
             * Get form data for info areas.
             * 
             * @param form (array): booking form data
             * @param for (string): info area
             * 
             * @return form info
             */
            function getFormInfo($form,
                                 $for = 'info'){
                $data = array();
                
                if (isset($form)
                        && $form != ''){
                    foreach ($form as $field){
                        $option = 'add_to_day_hour_'.$for;
                        
                        if ($field->$option == 'true'){
                            array_push($data, $field->value);
                        }
                    }
                }
                
                return implode(' ', $data);
            }
            
            /*
             * Delete form data from info areas.
             * 
             * @param reservation_id (integer): reservation ID
             * @param info (array): form info data
             * 
             * @return form info
             */
            function deleteFormInfo($reservation_id,
                                    $info){
                $data = array();
                
                if($info != '') {
                    for ($i=0; $i<count($info); $i++){
                        if ($info[$i]->reservation_id != $reservation_id){
                            array_push($data, $info[$i]);
                        }
                    }
                }
                
                if(empty($data)) {
                    $data = "";
                }
                
                return $data;
            }
        }
    }