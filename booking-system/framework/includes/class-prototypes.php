<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-prototypes.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Prototypes PHP class.
 */

    if (!class_exists('DOTPrototypes')){
        class DOTPrototypes{
	    
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
 * Date & time.
 */
	    
            /*
             * Returns "time ago" of a date.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    date (string): the date, in format YYYY-MM-DD HH:MM:SS
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
	     *	    dot_text (array): application translation text
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
	     *	    "Time ago" date.
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
	    function ago($date){
		global $dot_text;
		
		/*
		 * Set time estimate.
		 */
		$time_estimate = time()-strtotime($date);
		
		/*
		 * Set period intervals.
		 */
		$time_intervals = array('year' => 12*30*24*60*60,
				        'month' => 30*24*60*60,
				        'week' => 7*24*60*60,
				        'day' => 24*60*60,
				        'hour' => 60*60,
				        'minute' => 60,
				        'second' => 1);
		
		/*
		 * Set labels.
		 */
		$labels = array('ago' => isset($dot_text['TIME_AGO']) ? $dot_text['TIME_AGO']:'ago',
				'year' => isset($dot_text['TIME_AGO_YEAR']) ? $dot_text['TIME_AGO_YEAR']:'year',
				'years' => isset($dot_text['TIME_AGO_YEARS']) ? $dot_text['TIME_AGO_YEARS']:'years',
				'month' => isset($dot_text['TIME_AGO_MONTH']) ? $dot_text['TIME_AGO_MONTH']:'month',
				'months' => isset($dot_text['TIME_AGO_MONTHS']) ? $dot_text['TIME_AGO_MONTHS']:'months',
				'week' => isset($dot_text['TIME_AGO_WEEK']) ? $dot_text['TIME_AGO_WEEK']:'week',
				'weeks' => isset($dot_text['TIME_AGO_WEEKS']) ? $dot_text['TIME_AGO_WEEKS']:'weeks',
				'day' => isset($dot_text['TIME_AGO_DAY']) ? $dot_text['TIME_AGO_DAY']:'day',
				'days' => isset($dot_text['TIME_AGO_DAYS']) ? $dot_text['TIME_AGO_DAYS']:'days',
				'hour' => isset($dot_text['TIME_AGO_HOUR']) ? $dot_text['TIME_AGO_HOUR']:'hour',
				'hours' => isset($dot_text['TIME_AGO_HOURS']) ? $dot_text['TIME_AGO_HOURS']:'hours',
				'minute' => isset($dot_text['TIME_AGO_MINUTE']) ? $dot_text['TIME_AGO_MINUTE']:'minute',
				'minutes' => isset($dot_text['TIME_AGO_MINUTES']) ? $dot_text['TIME_AGO_MINUTES']:'minutes',
				'second' => isset($dot_text['TIME_AGO_SECOND']) ? $dot_text['TIME_AGO_SECOND']:'second',
				'seconds' => isset($dot_text['TIME_AGO_SECONDS']) ? $dot_text['TIME_AGO_SECONDS']:'seconds');
		
		/*
		 * Return the first interval that is lower or equal with time estimate.
		 */
		foreach( $time_intervals as $label => $seconds){
		    $time_ago = $time_estimate/$seconds;

		    if ($time_ago >= 1){
			$time_ago = round($time_ago);
			
			return $time_ago.' '.($time_ago > 1 ? $labels[$label.'s']:$labels[$label]).' '.$labels['ago'];
		    }
		}
		
		/*
		 * Return if time is lower than 1 second.
		 */
		return '1 '.$labels['second'].' '.$labels['ago'];
	    }
	    
            /*
             * Returns date in requested patern.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    date (string): the date that will be returned, in format YYYY-MM-DD
             *	    patern (string): the pattern of the new date; the pattern contains some constants to display the date:
	     *		[DD] : day with leading zeros
	     *		[D] : day without leading zeros
	     *		[MM] : month with leading zeros
	     *		[M] : month without leading zeros
	     *		[mm] : month name
	     *		[m] : short month name
	     *		[YYYY] : the year
	     *		[yy] : short year
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
	     *	    dot_text (array): application translation text
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
	     *	    The date after pattern.
	     * 
	     * @return_details
	     *	    Month names are set in application translation with prefixes [MONTH_] and [MONTH_SHORT_].
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            function date($date, 
			  $patern = '[DD] [mm] [YYYY]'){
		global $dot_text;
    
		/*
		 * Default months names.
		 */
		$month_names = array(isset($dot_text['MONTH_JANUARY']) ? $dot_text['MONTH_JANUARY']:'January',
				     isset($dot_text['MONTH_FEBRUARY']) ? $dot_text['MONTH_FEBRUARY']:'February',
				     isset($dot_text['MONTH_MARCH']) ? $dot_text['MONTH_MARCH']:'March',
				     isset($dot_text['MONTH_APRIL']) ? $dot_text['MONTH_APRIL']:'April',
				     isset($dot_text['MONTH_MAY']) ? $dot_text['MONTH_MAY']:'May',
				     isset($dot_text['MONTH_JUNE']) ? $dot_text['MONTH_JUNE']:'June',
				     isset($dot_text['MONTH_JULY']) ? $dot_text['MONTH_JULY']:'July',
				     isset($dot_text['MONTH_AUGUST']) ? $dot_text['MONTH_AUGUST']:'August',
				     isset($dot_text['MONTH_SEPTEMBER']) ? $dot_text['MONTH_SEPTEMBER']:'September',
				     isset($dot_text['MONTH_OCTOBER']) ? $dot_text['MONTH_OCTOBER']:'October',
				     isset($dot_text['MONTH_NOVEMBER']) ? $dot_text['MONTH_NOVEMBER']:'November',
				     isset($dot_text['MONTH_DECEMBER']) ? $dot_text['MONTH_DECEMBER']:'December');
		$month_short_names = array(isset($dot_text['MONTH_SHORT_JANUARY']) ? $dot_text['MONTH_SHORT_JANUARY']:'Jan',
					   isset($dot_text['MONTH_SHORT_FEBRUARY']) ? $dot_text['MONTH_SHORT_FEBRUARY']:'Feb',
					   isset($dot_text['MONTH_SHORT_MARCH']) ? $dot_text['MONTH_SHORT_MARCH']:'Ma',
					   isset($dot_text['MONTH_SHORT_APRIL']) ? $dot_text['MONTH_SHORT_APRIL']:'Apr',
					   isset($dot_text['MONTH_SHORT_MAY']) ? $dot_text['MONTH_SHORT_MAY']:'May',
					   isset($dot_text['MONTH_SHORT_JUNE']) ? $dot_text['MONTH_SHORT_JUNE']:'Jun',
					   isset($dot_text['MONTH_SHORT_JULY']) ? $dot_text['MONTH_SHORT_JULY']:'Jul',
					   isset($dot_text['MONTH_SHORT_AUGUST']) ? $dot_text['MONTH_SHORT_AUGUST']:'Aug',
					   isset($dot_text['MONTH_SHORT_SEPTEMBER']) ? $dot_text['MONTH_SHORT_SEPTEMBER']:'Sep',
					   isset($dot_text['MONTH_SHORT_OCTOBER']) ? $dot_text['MONTH_SHORT_OCTOBER']:'Oct',
					   isset($dot_text['MONTH_SHORT_NOVEMBER']) ? $dot_text['MONTH_SHORT_NOVEMBER']:'Nov',
					   isset($dot_text['MONTH_SHORT_DECEMBER']) ? $dot_text['MONTH_SHORT_DECEMBER']:'Dec');
		
		/*
		 * Get date pieces.
		 */
                $date_pieces = explode('-', $date);
		$day = isset($date_pieces[2]) ? $date_pieces[2]:'01';
		$month = $date_pieces[1];
		$year = $date_pieces[0];
		
		/*
		 * Set day.
		 * DD, D
		 */
		$patern = str_replace('[DD]', $day, $patern);
		$patern = str_replace('[D]', (int)$day, $patern);
		
		/*
		 * Set month.
		 * MM, M, mm, m
		 */
		$patern = str_replace('[MM]', $month, $patern);
		$patern = str_replace('[M]', (int)$month, $patern);
		$patern = str_replace('[mm]', $month_names[(int)$month-1], $patern);
		$patern = str_replace('[m]', $month_short_names[(int)$month-1], $patern);
		
		/*
		 * Set year.
		 * YYYY, YY
		 */
		$patern = str_replace('[YYYY]', $year, $patern);
		$patern = str_replace('[YY]', substr($year, -2), $patern);
		
		return $patern;
            }
            
/*
 * String & numbers.          
 */
            
            /*
             * Parses a code type text to be displayed correctly.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    code (string): the text
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
	     *	    The parsed text.
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
	    function code($code){
		return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($code)));
	    }

	    /*
	     * Create a permalink from a string.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    string (string): the string
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
	     *	    The permalink slug.
	     * 
	     * @return_details
	     *	    All non alphanumeric characters are deleted; spaces [ ] and underscore [_] characters are replaced with hyphens [-].
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function permalink($string){
		$string = preg_replace('/[~`!@#$%^&*()+={}\[\]|\\:;"\'<,>.?\/€]/u', '', $string);
		$string = preg_replace('/[ ]/u', '-', $string);
		$string = preg_replace('/[_]/u', '-', $string);
		$string = strtolower($string);

		return $string;
	    }   
	    
            /*
             * Creates a string with random characters.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    length (integer): the length of the returned string
             *	    allowed_characters (string): the string of allowed characters; by default only alphanumeric characters are allowed
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
	     *	    Random string.
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
            function random($length,
			    $allowed_characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'){
                $random_string = '';

                for ($i=0; $i<$length; $i++){
                    $character_position = mt_rand(1, strlen($allowed_characters))-1;
                    $random_string .= $allowed_characters[$character_position];
                }
                
                return $random_string;
            }
        }
    }