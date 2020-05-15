<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/schedule/model-days.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Days days model PHP class.
 */

    if (!class_exists('DOTModelDays')){
        class DOTModelDays{
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
	     *	    -
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
            }
	    
            /*
             * Get all days between 2 dates.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    day_start (string): start day in "YYYY-MM-DD" format
             *	    day_end (string): end day in "YYYY-MM-DD" format
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
	     *	    A list with all the days.
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
            function get($day_start,
			 $day_end){
                $days = array();
                
                $start_year = substr($day_start, 0, 4);
                $start_month = substr($day_start, 5, 2);
                $start_day = substr($day_start, 8, 2);
                
                $end_year = substr($day_end, 0, 4);
                $end_month = substr($day_end, 5, 2);
                $end_day = substr($day_end, 8, 2);

                $start = mktime(1, 0, 0, $start_month, $start_day, $start_year);
                $end = mktime(1, 0, 0, $end_month, $end_day, $end_year);

                if ($end >= $start){
                    /*
                     * First day.
                     */
                    array_push($days, date('Y-m-d', $start));

                    /*
                     * Create the rest of the days
                     */
                    while ($start < $end){
                        $start += 86400;
                        array_push($days, date('Y-m-d', $start));
                    }
                }
		
                return $days;
            }
        }
    }