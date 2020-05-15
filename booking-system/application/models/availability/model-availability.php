<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/availability/model-availability.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Availability model PHP class.
 */

    if (!class_exists('DOTModelAvailability')){
        class DOTModelAvailability{
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
             * Delete availability for a calendar.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework : db->delete() // Delete rows from database.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    All availability for calendar is deleted.
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
	    function delete($calendar_id){
		global $DOT;
		
		/*
		 * Delete availability intervals.
		 */
		$DOT->db->delete($DOT->tables->availability, array('calendar_id' => $calendar_id));
		
		/*
		 * Delete availability numbers intervals.
		 */
		$DOT->db->delete($DOT->tables->availability_no, array('calendar_id' => $calendar_id));
		
		/*
		 * Delete availability prices intervals.
		 */
		$DOT->db->delete($DOT->tables->availability_price, array('calendar_id' => $calendar_id));
	    }
	    
            /*
             * Find availability.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    day_start (integer): start day in YYYY-MM-DD format
	     *	    day_end (integer): end day in YYYY-MM-DD format
	     *	    time_start (integer): start time in HH:MM format
	     *	    time_end (integer): end time in HH:MM format
	     *	    no (integer): number available
	     *	    price_min (float): minimum price
	     *	    price_max (float): maximum price
	     *	    in (string): valid calendars list
	     *	    not_in (string): invalid calendars list
	     *	    sort_by (string): sort calendars by "id", "no" or "price"
	     *	    sort_direction (string): sort calendars "ASC", "DESC"
	     *	    page (integer): page number
	     *	    page_limit (integer): number of calendars per page
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework : db->results() // Get query results.
	     *	    framework : db->safe() // Clean query string.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Available calendars IDs list.
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
	    function find($day_start = '',
			  $day_end = '',
			  $time_start = '00:00:00',
			  $time_end = '23:59:59',
			  $no = 1,
			  $price_min = -1,
			  $price_max = -1,
			  $in = '',
			  $not_in = '',
			  $sort_by = 'id',
			  $sort_direction = 'DESC',
			  $page = 1,
			  $page_limit = 10){
		global $DOT;
		
		$query = array();
		$values = array();
		
		/*
		 * If no dates are seet return false.
		 */
		if ($day_start == ''
			&& $day_end == ''){
		    return false;
		}
		
		/*
		 * Set search dates.
		 */
		$date_start = $day_start.' '.$time_start;
		$date_end = $day_end.' '.$time_end;
		
		/*
		 * Initialize tables.
		 */
		array_push($query, 'SELECT DISTINCT availability.calendar_id');
		array_push($query, ' FROM '.$DOT->tables->availability.' availability');
		array_push($query, ' JOIN '.$DOT->tables->availability_no.' availability_no ON availability.calendar_id=availability_no.calendar_id');
		array_push($query, ' JOIN '.$DOT->tables->availability_price.' availability_price ON availability.calendar_id=availability_price.calendar_id');
		
		/*
		 * Search for availability.
		 */
		if ($day_start != ''
			&& $day_end != ''){
		    array_push($query, ' WHERE availability.date_start<=%s AND availability.date_end>=%s');
		    array_push($values, $date_start, $date_end);
		    
		    /*
		     * Join number availability table.
		     */
		    array_push($query, ' AND (availability_no.date_start>=%s AND availability_no.date_start<=%s OR availability_no.date_end>=%s AND availability_no.date_end<=%s OR availability_no.date_start>=%s AND availability_no.date_end<=%s OR availability_no.date_start<=%s AND availability_no.date_end>=%s)');
		    array_push($values, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end);
		    
		    /*
		     * Join price availability table.
		     */
		    array_push($query, ' AND (availability_price.date_start>=%s AND availability_price.date_start<=%s OR availability_price.date_end>=%s AND availability_price.date_end<=%s OR availability_price.date_start>=%s AND availability_price.date_end<=%s OR availability_price.date_start<=%s AND availability_price.date_end>=%s)');
		    array_push($values, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end);
		}
		elseif ($day_start != ''
			&& $day_end == ''){
		    array_push($query, ' WHERE availability.date_end>=%s');
		    array_push($values, $date_start);
		    
		    /*
		     * Join number availability table.
		     */
		    array_push($query, ' AND availability_no.date_end>=%s');
		    array_push($values, $date_start);
		    
		    /*
		     * Join price availability table.
		     */
		    array_push($query, ' AND availability_price.date_end>=%s');
		    array_push($values, $date_start);
		}
		elseif ($day_start == ''
			&& $day_end != ''){
		    array_push($query, ' WHERE availability.date_start<=%s');
		    array_push($values, $date_end);
		    
		    /*
		     * Join number availability table.
		     */
		    array_push($query, ' AND availability_no.date_start<=%s');
		    array_push($values, $date_end);
		    
		    /*
		     * Join price availability table.
		     */
		    array_push($query, ' AND availability_price.date_start<=%s');
		    array_push($values, $date_end);
		}
		
		$in != '' ? array_push($query, ' AND availability.calendar_id IN ('.$in.')'):'';
		$not_in != '' ? array_push($query, ' AND availability.calendar_id NOT IN ('.$not_in.')'):'';
		
		/*
		 * Search for number availability.
		 */
		if ($no > 1){
		    if ($day_start != ''
			    && $day_end != ''){
			array_push($query, ' AND availability.calendar_id NOT IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_no.' WHERE no_available<%d AND (date_start>=%s AND date_start<=%s OR date_end>=%s AND date_end<=%s OR date_start>=%s AND date_end<=%s OR date_start<=%s AND date_end>=%s))');
			array_push($values, $no, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end);
		    }
		    elseif ($day_start != ''
			    && $day_end == ''){
			array_push($query, ' AND availability.calendar_id IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_no.' WHERE no_available>=%d AND date_end>=%s)');
			array_push($values, $no, $date_start);
		    }
		    elseif ($day_start == ''
			    && $day_end != ''){
			array_push($query, ' AND availability.calendar_id IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_no.' WHERE no_available>=%d AND date_start<=%s)');
			array_push($values, $no, $date_end);
		    }
		}
		
		/*
		 * Search for price availability.
		 */
		if ($price_min > -1){
		    if ($day_start != ''
			    && $day_end != ''){
			array_push($query, ' AND availability.calendar_id NOT IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_price.' WHERE price<%d AND (date_start>=%s AND date_start<=%s OR date_end>=%s AND date_end<=%s OR date_start>=%s AND date_end<=%s OR date_start<=%s AND date_end>=%s))');
			array_push($values, $price_min, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end);
		    }
		    elseif ($day_start != ''
			    && $day_end == ''){
			array_push($query, ' AND availability.calendar_id IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_price.' WHERE price>=%d AND date_end>=%s)');
			array_push($values, $price_min, $date_start);
		    }
		    elseif ($day_start == ''
			    && $day_end != ''){
			array_push($query, ' AND availability.calendar_id IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_price.' WHERE price>=%d AND date_start<=%s)');
			array_push($values, $price_min, $date_end);
		    }
		}
		
		if ($price_max > -1){
		    if ($day_start != ''
			    && $day_end != ''){
			array_push($query, ' AND availability.calendar_id NOT IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_price.' WHERE price>%d AND (date_start>=%s AND date_start<=%s OR date_end>=%s AND date_end<=%s OR date_start>=%s AND date_end<=%s OR date_start<=%s AND date_end>=%s))');
			array_push($values, $price_max, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end, $date_start, $date_end);
		    }
		    elseif ($day_start != ''
			    && $day_end == ''){
			array_push($query, ' AND availability.calendar_id IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_price.' WHERE price<=%d AND date_end>=%s)');
			array_push($values, $price_max, $date_start);
		    }
		    elseif ($day_start == ''
			    && $day_end != ''){
			array_push($query, ' AND availability.calendar_id IN (SELECT DISTINCT calendar_id FROM '.$DOT->tables->availability_price.' WHERE price<=%d AND date_start<=%s)');
			array_push($values, $price_max, $date_end);
		    }
		}
		
		/*
		 * Sort results.
		 */
		switch ($sort_by){
		    case 'no':
			array_push($query, ' ORDER BY availability_price.no_available '.$sort_direction);
			break;
		    case 'price':
			array_push($query, ' ORDER BY availability_price.price '.$sort_direction);
			break;
		    default:
			array_push($query, ' ORDER BY availability.calendar_id '.$sort_direction);
		}
		
		/*
		 * Limit results.
		 */
		array_push($query, ' LIMIT %d, %d');
		array_push($values, ($page-1)*$page_limit, $page_limit);
		
		/*
		 * Execute query.
		 */
		$calendars = $DOT->db->results($DOT->db->safe(implode('', $query),
							      $values));
		
		/*
		 * Return array.
		 */
		return array_map(function($value){
				    return $value->calendar_id;
				 }, 
				 $calendars);
	    }
	    
            /*
             * Get availability for a calendar.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework : db->results() // Get query results.
	     *	    framework : db->safe() // Clean query string.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Availability intervals list.
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
	    function get($calendar_id){
		global $DOT;
		
		return $DOT->db->results($DOT->db->safe('SELECT date_start, date_end FROM '.$DOT->tables->availability.' WHERE calendar_id=%d ORDER BY date_start ASC',
							array($calendar_id)));
	    }
            
            /*
             * Set availability for a calendar.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    application/models/availability/model-availability-days.php : set() // Set availability for days.
	     *	    application/models/availability/model-availability-hours.php : set() // Set availability for hours.
	     *	    application/models/components/calendars/model-components-calendar.php : get() // Get calendar.
	     *	    application/models/components/calendars/model-components-calendar.php : set() // Set calendar.
	     * 
	     *	    this : delete() // Delete availability.
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
            function set($calendar_id){
		global $DOT;
		
		/*
		 * Get calendar settings.
		 */
		$calendar_settings = $DOT->models->settings_calendar->get($calendar_id);
		
		/*
		 * Delete old availability intervals.
		 */
		$this->delete($calendar_id);
		
		/*
		 * Set new availability intervals & get availability data.
		 */
		$availability_data = $calendar_settings->hours_enabled == 'false' ? $DOT->models->availability_days->set($calendar_id,
															 $calendar_settings):
										    $DOT->models->availability_hours->set($calendar_id,
															  $calendar_settings);
		
		/*
		 * Set new calendar data.
		 */
		$DOT->models->calendar->set($calendar_id,
					    array('max_year' => $availability_data->max_year,
						  'min_available' => $availability_data->no_min,
						  'price_min' => $availability_data->price_min,
						  'price_max' => $availability_data->price_max));
            }
        }
    }