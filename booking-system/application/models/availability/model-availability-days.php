<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/availability/model-availability-days.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Availability for days model PHP class.
 */

    if (!class_exists('DOTModelAvailabilityDays')){
        class DOTModelAvailabilityDays{
	    /*
	     * Private variables.
	     */
	    private $default; // Calendar default schedule.
	    private $id; // Calendar ID.
	    private $schedule; // Calendar schedule.
	    private $settings; // Calendar settings.
	    private $settings_days_available; // Calendar settings.
		    
	    private $intervals = array(); // General intervals list.
	    private $intervals_no = array();  // Number intervals list.
	    private $intervals_price = array(); // Price intervals list.
	    
	    private $interval_start = ''; // General interval first day.
	    private $interval_end = ''; // General interval last day.
	    private $interval_started = false; // A general interval is constructed.
	    private $interval_no_start = ''; // Number interval first day.
	    private $interval_no_end = ''; // Number interval last day.
	    private $interval_no = 0; // The number available for the interval that is being constructed.
	    private $interval_price_start = ''; // Price interval first day.
	    private $interval_price_end = ''; // Price interval last day.
	    private $interval_price = -1; // The price for the interval that is being constructed.
	    
	    private $day_curr; // Current day that is being verified. 
	    private $no_curr; // Current number available.
	    private $price_curr; // Current price.
	    
	    private $max_year; // The top year for which the schedule is set.
	    private $no_min = -1; // The minimum set number available.
	    private $no_max = 0; // The maximum set number available.
	    private $price_min = -1; // The minimum set price.
	    private $price_max = 0; // The maximum set price.
		
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
             * Add availability.
	     * 
	     * @usage
	     *	    -
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework : db->query() // Execute a query.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Save availability intervals to database.
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
	    private function add(){
		global $DOT;
		
		/*
		 * Add general availability.
		 */
		if (count($this->intervals) > 0){
		    $query_insert_values = array();

		    foreach ($this->intervals as $interval){
			$interval_start = $interval[0];
			$interval_end = $interval[1];
			
			/*
			 * If morning checkout is enabled the interval is increased with one day.
			 */
			$this->settings->days_morning_check_out == 'true' ? $interval_end = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($interval_end))):'';
			
			array_push($query_insert_values, '('.$this->id.', \''.$interval_start.'\', \''.$interval_end.'\')');
		    }

		    $DOT->db->query('INSERT INTO '.$DOT->tables->availability.' (calendar_id, date_start, date_end) VALUES '.implode(', ', $query_insert_values));
		}
		
		/*
		 * Add number availability.
		 */
		if (count($this->intervals_no) > 0){
		    $query_insert_values = array();

		    foreach ($this->intervals_no as $interval){
			$interval_start = $interval[0];
			$interval_end = $interval[1];
			$interval_no = $interval[2];
			
			/*
			 * Get minimum & maximum number available. 
			 */
			$this->no_min = $this->no_min > $interval_no || $this->no_min == -1 ? $interval_no:$this->no_min;
			$this->no_max = $this->no_max < $interval_no ? $interval_no:$this->no_max;
			
			/*
			 * If morning checkout is enabled the interval is increased with one day.
			 */
			$this->settings->days_morning_check_out == 'true' ? $interval_end = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($interval_end))):'';
			
			array_push($query_insert_values, '('.$this->id.', '.$interval_no.', \''.$interval_start.'\', \''.$interval_end.'\')');
		    }

		    $DOT->db->query('INSERT INTO '.$DOT->tables->availability_no.' (calendar_id, no_available, date_start, date_end) VALUES '.implode(', ', $query_insert_values));
		}
		
		/*
		 * Add price availability.
		 */
		if (count($this->intervals_price) > 0){
		    $query_insert_values = array();

		    foreach ($this->intervals_price as $interval){
			$interval_start = $interval[0];
			$interval_end = $interval[1];
			$interval_price = $interval[2];
			
			/*
			 * Get minimum & maximum price. 
			 */
			$this->price_min = $this->price_min > $interval_price || $this->price_min == -1 ? $interval_price:$this->price_min;
			$this->price_max = $this->price_max < $interval_price ? $interval_price:$this->price_max;
			
			/*
			 * If morning checkout is enabled the interval is increased with one day.
			 */
			$this->settings->days_morning_check_out == 'true' ? $interval_end = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($interval_end))):'';
			
			array_push($query_insert_values, '('.$this->id.', '.$interval_price.', \''.$interval_start.'\', \''.$interval_end.'\')');
		    }

		    $DOT->db->query('INSERT INTO '.$DOT->tables->availability_price.' (calendar_id, price, date_start, date_end) VALUES '.implode(', ', $query_insert_values));
		}
	    }
	    
            /*
             * Verify if a day is available.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    day (string): the day that will be verified.
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
	     *	    "true" if the day is available, "false" otherwise
	     * 
	     * @return_details
	     *	    Rules priority: 
	     *		1. Schedule
	     *		2. Availability rules
	     *		3. Default availability
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    private function available($day){
		/*
		 * Verify if weekday is available.
		 */
		$weekday = date('N', strtotime($day));
		$weekday = $weekday == 7 ? 0:$weekday;
		
		if ($this->settings_days_available[$weekday] == 'false'){
		    $this->no_curr = 0;
		    $this->price_curr = -1;
		    
		    return false;
		}
		
		/*
		 * Verify if day is available in schedule.
		 */
		if (isset($this->schedule[$day])){
		    $day_data = json_decode($this->schedule[$day]);

		    if ($day_data->available == 0){
			$this->no_curr = 0;
			$this->price_curr = -1;
			
			return false;
		    }
		    else{
			$this->no_curr = $day_data->available;
			$this->price_curr = $day_data->promo != 0 ? $day_data->promo:$day_data->price;
			
			return true;
		    }
		}
		
		/*
		 * Verify if day is available in default schedule.
		 */
		if ($this->default->available == 0){
		    $this->no_curr = 0;
		    $this->price_curr = -1;
		    
		    return false;
		}
		else{
		    $this->no_curr = $this->default->available;
		    $this->price_curr = $this->default->promo != 0 ? $this->default->promo:$this->default->price;
		    return true;
		}
	    }
	    
            /*
             * Verify and complete intervals.
	     * 
	     * @usage
	     *	    -
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
	    private function complete(){
		/*
		 * Close intervals when default schedule is available.
		 */
		if  ($this->default->available != 0){
		    /*
		     * Close general intervals.
		     */
		    if ($this->interval_started){
			$this->interval_end = '9999-01-01 23:59:59';
		    }
		    else{
			$this->interval_start = date('Y-m-d', strtotime('+1 day', strtotime($this->day_curr))).' 00:00:00';
			$this->interval_end = '9999-01-01 23:59:59';
			$this->interval_started = true;
		    }
		    
		    /*
		     * Close number intervals.
		     */
		    if ($this->interval_no > 0){
			$this->interval_no_end = '9999-01-01 23:59:59';
		    }
		    else{
			$this->interval_no_start = date('Y-m-d', strtotime('+1 day', strtotime($this->day_curr))).' 00:00:00';
			$this->interval_no_end = '9999-01-01 23:59:59';
			$this->interval_no = $this->default->available;
		    }
		    
		    /*
		     * Close price intervals.
		     */
		    if ($this->interval_price > -1){
			$this->interval_price_end = '9999-01-01 23:59:59';
		    }
		    else{
			$this->interval_price_start = date('Y-m-d', strtotime('+1 day', strtotime($this->day_curr))).' 00:00:00';
			$this->interval_price_end = '9999-01-01 23:59:59';
			$this->interval_price = $this->default->promo != 0 ? $this->default->promo:$this->default->price;
		    }
		}
		
		/*
		 * Add last intervals.
		 */
		if ($this->interval_started){
		    array_push($this->intervals, array($this->interval_start,
						       $this->interval_end));
		}
		
		if ($this->interval_no > 0){
		    array_push($this->intervals_no, array($this->interval_no_start,
						          $this->interval_no_end,
						          $this->interval_no));
		}
		
		if ($this->interval_price > -1){
		    array_push($this->intervals_price, array($this->interval_price_start,
							     $this->interval_price_end,
							     $this->interval_price));
		}
	    }
	    
            /*
             * Set general availability intervals.
	     * 
	     * @usage
	     *	    -
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
	     *	    this : available() // Verify if a day is available.
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
	    private function general(){
		if (!$this->interval_started
			&& $this->available($this->day_curr)){
		    /*
		     * If an interval is not started and current day is available, a new interval is initialized.
		     */
		    $this->interval_start = $this->day_curr.' 00:00:00';
		    $this->interval_end = $this->day_curr.' 23:59:59';
		    $this->interval_started = true;
		}
		else if ($this->interval_started
			    && $this->available($this->day_curr)){
		    /*
		     * If an interval is started and current day is available, the interval end date is updated.
		     */
		    $this->interval_end = $this->day_curr.' 23:59:59';
		}
		else if ($this->interval_started
			    && !$this->available($this->day_curr)){
		    /*
		     * If an interval is started and current day is not available, the interval is closed and memorized.
		     */
		    array_push($this->intervals, array($this->interval_start,
						       $this->interval_end));
		    $this->interval_started = false;
		}
	    }
	    
            /*
             * Set number availability intervals.
	     * 
	     * @usage
	     *	    -
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
	    private function no(){
		if ($this->interval_no == 0
			&& $this->no_curr > 0){
		    /*
		     * If an interval is not started and the number available is greater than 0, a new interval is initialized.
		     */
		    $this->interval_no_start = $this->day_curr.' 00:00:00';
		    $this->interval_no_end = $this->day_curr.' 23:59:59';
		    $this->interval_no = $this->no_curr;
		}
		else if ($this->interval_no > 0
			    && $this->interval_no == $this->no_curr){
		    /*
		     * If an interval is started and the number available is the same, the interval end date is updated.
		     */
		    $this->interval_no_end = $this->day_curr.' 23:59:59';
		}
		else if ($this->interval_no > 0
			    && $this->interval_no != $this->no_curr){
		    /*
		     * If an interval is started and the number available is different, the interval is memorized.
		     */
		    array_push($this->intervals_no, array($this->interval_no_start,
							  $this->interval_no_end,
							  $this->interval_no));
		    
		    if ($this->no_curr > 0){
			/*
			 * If the number available is greater than 0, a new interval is initialized.
			 */
			$this->interval_no_start = $this->day_curr.' 00:00:00';
			$this->interval_no_end = $this->day_curr.' 23:59:59';
			$this->interval_no = $this->no_curr;
		    }
		    else{
			/*
			 * If the number available is 0, the interval is closed.
			 */
			$this->interval_no = 0;
		    }
		}
	    }
	    
            /*
             * Set price availability intervals.
	     * 
	     * @usage
	     *	    -
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
	    private function price(){
		if ($this->interval_price == -1
			&& $this->price_curr > -1){
		    /*
		     * If an interval is not started and the day is available, a new interval is initialized.
		     */
		    $this->interval_price_start = $this->day_curr.' 00:00:00';
		    $this->interval_price_end = $this->day_curr.' 23:59:59';
		    $this->interval_price = $this->price_curr;
		}
		else if ($this->interval_price > -1
			    && $this->interval_price == $this->price_curr){
		    /*
		     * If an interval is started and the price is the same, the interval end date is updated.
		     */
		    $this->interval_price_end = $this->day_curr.' 23:59:59';
		}
		else if ($this->interval_price > -1
			    && $this->interval_price != $this->price_curr){
		    /*
		     * If an interval is started and the price is different, the interval is memorized.
		     */
		    array_push($this->intervals_price, array($this->interval_price_start,
							     $this->interval_price_end,
							     $this->interval_price));
		    
		    if ($this->price_curr > -1){
			/*
			 * If the day is available, a new interval is initialized.
			 */
			$this->interval_price_start = $this->day_curr.' 00:00:00';
			$this->interval_price_end = $this->day_curr.' 23:59:59';
			$this->interval_price = $this->price_curr;
		    }
		    else{
			/*
			 * If the day is not available, the interval is closed.
			 */
			$this->interval_price = -1;
		    }
		}
	    }
	    
	    /*
	     * Reset private variables.
	     * 
	     * @usage
	     *	    -
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
	     *	    All private variables are reset.
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
	    private function reset(){
		$this->default = new stdClass;
		$this->id = 0;
		$this->schedule = new stdClass;
		$this->settings = new stdClass;
		$this->settings_days_available = array();

		$this->intervals = array();
		$this->intervals_no = array();
		$this->intervals_price = array();

		$this->interval_start = '';
		$this->interval_end = '';
		$this->interval_started = false;
		$this->interval_no_start = '';
		$this->interval_no_end = '';
		$this->interval_no = 0;
		$this->interval_price_start = '';
		$this->interval_price_end = '';
		$this->interval_price = -1;

		$this->day_curr = '';
		$this->no_curr = 0;
		$this->price_curr = -1;

		$this->max_year = date('Y');
		$this->no_min = -1;
		$this->no_max = 0;
		$this->price_min = -1;
		$this->price_max = 0;
	    }
	    
            /*
             * Set days availability intervals.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    calendar_id (integer): calendar ID
	     *	    calendar_settings (object): calendar settings
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
	     *	    application/models/schedule/model-calendar-schedule.php : get() // Get calendar schedule.
	     *	    application/models/schedule/model-days.php : get() // Get all days between 2 dates.
	     * 
	     *	    this : add() // Add availability.
	     *	    this : complete() // Verify and complete intervals.
	     *	    this : general() // Set general availability intervals.
	     *	    this : no() // Set number availability intervals.
	     *	    this : price() // Set price availability intervals.
	     *	    this : reset() // Reset private variables.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Availability data.
	     * 
	     * @return_details
	     *	    availability_data (object)
	     *	    availability_data->max_year (integer): the top year for which the schedule is set
	     *	    availability_data->no_min (integer): the minimum set number available
	     *	    availability_data->no_max (integer): the maximum set number available
	     *	    availability_data->price_min (integer): the minimum set price
	     *	    availability_data->price_max (integer): the maximum set price
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function set($calendar_id,
			 $calendar_settings){
		global $DOT;
		
		/*
		 * Reset data.
		 */
		$this->reset();
		
		/*
		 * Set private variables.
		 */
		$this->id = $calendar_id;
		$this->settings = $calendar_settings;
		$this->settings_days_available = explode(',', $this->settings->days_available);
		
		/*
		 * Get calendar default schedule.
		 */
		$this->default = $DOT->models->calendar_schedule_default->get($calendar_id);
		
		/*
		 * Get calendar schedule.
		 */
		$this->schedule = $DOT->models->calendar_schedule->get($this->id,
								       false);
		$schedule_keys = array_keys($this->schedule);
		$schedule_end = end($schedule_keys);
		
		/*
		 * Get top year set in schedule.
		 */
		$this->max_year = count($this->schedule) > 0 ? date('Y', strtotime($schedule_end)):date('Y');
		
		/*
		 * Get start day.
		 */
		$day_start = date('Y-m-d', mktime(1, 0, 0, date('n'), date('j'),  date('Y'))+$this->settings->booking_stop*60);
		
		/*
		 * Get last day.
		 */
		if  ($this->default->available != 0
			&& $this->settings->days_available != 'true,true,true,true,true,true,true'){
		    $day_end = date('Y-m-d', strtotime('+5 years', strtotime(count($this->schedule) > 0 ? $schedule_end:$day_start)));
		}
		elseif  ($this->default->available != 0){
		    $day_end = date('Y-m-d', strtotime('+1 day', strtotime(count($this->schedule) > 0 ? $schedule_end:$day_start)));
		}
		else{
		    $day_end = $schedule_end;
		}
		
		$day_end == '' || $day_end < $day_start ? $day_end = date('Y-m-d', strtotime('+1 day', strtotime($day_start))):'';
		
		/*
		 * Get days list.
		 */
		$days = $DOT->models->days->get($day_start,
					        $day_end);
		
		/*
		 * Process days.
		 */
		foreach ($days as $this->day_curr){
		    $this->general();
		    $this->no();
		    $this->price();
		}
		
		/*
		 * Verify and complete intervals.
		 */
		$this->complete();
		
		/*
		 * Add availability intervals to database.
		 */
		$this->add();
		
		/*
		 * Set availability data.
		 */
		$availability_data = new stdClass;
		
		$availability_data->max_year = $this->max_year;
		$availability_data->no_min = $this->no_min;
		$availability_data->no_max = $this->no_max;
		$availability_data->price_min = $this->price_min;
		$availability_data->price_max = $this->price_max;
		
		return $availability_data;
	    }
        }
    }