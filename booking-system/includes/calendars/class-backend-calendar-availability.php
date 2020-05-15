<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.1
* File                    : includes/calendars/class-backend-calendar-availability.php
* File Version            : 1.0.2
* Created / Last Modified : 25 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar availability PHP class.
*/

    if (!class_exists('DOPBSPBackEndCalendarAvailability')){
        class DOPBSPBackEndCalendarAvailability extends DOPBSPBackEndCalendar{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Set default availability.
             * 
             * @param id (integer): calendar ID
             * @param schedule (array): schedule to be set
             */
            function set_default($id,
                                 $schedule = array()){
		global $DOT;
                global $DOPBSP;
                global $wpdb;
		
                if (count($schedule) == 0){
                    return false;
                }
                else {
                    // Default Availability
                    $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                             $id));
                    
                    $min_available = ($schedule->available > 0 && $schedule->status != 'booked' && $schedule->status != 'unavailable' && $schedule->status != 'none') ?  $schedule->available:0;
                    
                    $price_min  = 0;
                    $price_max  = 0;
                    
                    if ($schedule->price != '0'){
                        $price_min = $schedule->price < $calendar->price_min ? $schedule->price:$calendar->price_min;
                        $price_max = $schedule->price > $calendar->price_max ? $schedule->price:$calendar->price_max;
                    
                        if($calendar->price_min == 0) {
                            $price_min = $schedule->price;
                        }

                        if($calendar->price_max == 0) {
                            $price_max = $schedule->price;
                        }
                    }
                    
                    $wpdb->update($DOPBSP->tables->calendars, array('min_available' => $min_available,
                                                                    'price_min' => $price_min,
                                                                    'price_max' => $price_max,
                                                                    'default_availability' => json_encode($schedule)), array('id' => $id));
		    
		    $DOT->models->availability->set($id);
                }
                
                return true;
            }
        }
    }