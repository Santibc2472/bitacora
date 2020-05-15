<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-helper.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Helper PHP class.
 */

    if (!class_exists('DOTHelper')){
        class DOTHelper{
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
	     * Calculates the duration for PHP operations between start and end time.
	     * 
	     * @usage:
	     *	    index.php
	     * 
	     *	    $time_start = microtime(true);
	     * 
	     *      // code goes here
	     * 
	     *	    $time_end = microtime(true);
	     * 
	     *      $DOT->classes->helper->duration(array('info' => 'Total time',
	     *						  'time_start' => $time_start,
	     *						  'time_end' => microtime(true)));
	     * 
             * @param args (array): function arguments
             *                      * info (string): info text
             *                      * time_start (string): execution start time
             *                      * time_end (string): execution end time
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
	     *	    The execution duration of the PHP code.
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
	    public function duration($args = array()){
		$info = isset($args['info']) ? $args['info']:'Total duration';
		$time_start = $args['time_start'];
		$time_end = $args['time_end'];
		
		echo '<br />';
		
		echo $info.': ';
		printf('%0.21fs', $time_end-$time_start);
		echo '<br />';
	    }

	    /*
	     * Calculates the memory usage.
	     * 
	     * @usage:
	     *	    index.php
	     * 
             * @param
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
	     *	    How much memory is used.
	     * 
	     * @return_details
	     *	    The function will display:
	     *		- server total memory;
	     *		- server memory usage and percent from total memory;
	     *		- server memory usage and percent from total memory;
	     *		- PHP memory usage and percent from total memory;
	     *		- PHP memory peak usage and percent from total memory;
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function memory(){
		$exec_result = explode("\n", trim(shell_exec('free')));
		$memory_server = preg_split('/[\s]+/', $exec_result[1]);
		$memory_server_usage = $memory_server[2];
		$memory_server_total = $memory_server[1];
		
		$memory_php_usage = memory_get_usage();
		$memory_php_peak_usage = memory_get_peak_usage();
		
		echo '<br />';
		
		echo 'Server total memory: ';
		echo $memory_server_total < 1024 ? $memory_server_total.' bytes':($memory_server_total < 1048576? round($memory_server_total/1024, 2).' KB':($memory_server_total >= 1048576 ? round($memory_server_total/1048576, 2).' MB':''));
		echo '<br />';
		
		echo 'Server memory usage: ';
		echo $memory_server_usage < 1024 ? $memory_server_usage.' bytes':($memory_server_usage < 1048576? round($value/1024, 2).' KB':($memory_server_usage >= 1048576 ? round($memory_server_usage/1048576, 2).' MB':''));
		echo ' ('.round($memory_server_usage/$memory_server_total*100, 2).'%)';
		echo '<br />';
		
		echo 'PHP memory usage: ';
		echo $memory_php_usage < 1024 ? $memory_php_usage.' bytes':($memory_php_usage < 1048576? round($memory_php_usage/1024, 2).' KB':($memory_php_usage >= 1048576 ? round($memory_php_usage/1048576, 2).' MB':''));
		echo ' ('.round($memory_php_usage/$memory_server_total*100, 2).'%)';
		echo '<br />'; 

		echo 'PHP memory peak usage: ';
		echo $memory_php_peak_usage < 1024 ? $memory_php_peak_usage.' bytes':($memory_php_peak_usage < 1048576? round($value/1024, 2).' KB':($memory_php_peak_usage >= 1048576 ? round($memory_php_peak_usage/1048576, 2).' MB':''));
		echo ' ('.round($memory_php_peak_usage/$memory_server_total*100, 2).'%)';
		echo '<br />';
	    }
        }
    }