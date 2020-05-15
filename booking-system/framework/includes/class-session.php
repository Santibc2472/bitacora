<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-session.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Session PHP class.
 */

    if (!class_exists('DOTSession')){
        class DOTSession{
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
             * Check if a session is already active.
	     * 
	     * @usage
	     *	    framework/dot.php : session()
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
	     *	    True if a session is already active, false if no session is active.
	     * 
	     * @return_details
		     -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            function is_session_started(){
                if ( php_sapi_name() !== 'cli' ) {
                    if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                        return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
                    } else {
                        return session_id() === '' ? FALSE : TRUE;
                    }
                }
                return FALSE;
            }
	    /*
	     * Secure the session using a cookie.
	     * 
	     * @usage
	     *	    framework/dot.php : init()
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
	     *	    DOT_SESSION_COOKIE (string): session cookie name
	     *	    DOT_SESSION_COOKIE_SECURE (boolean): session cookie security
	     *	    DOT_SESSION_COOKIE_HTTP (boolean): session cookie security
	     * 
	     * @globals
	     *	    DOT (object): DOT framework main class variable
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
	     *	    A cookie for sessions is created.
	     * 
	     * @return_details
	     *	    The lifetime of the cookie is 1 week (604800 seconds).
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function secure(){
		global $DOT;
		
		/*
		 * Set session parameters.
		 */
		$session_name = DOT_SESSION_COOKIE;
		$secure = DOT_SESSION_COOKIE_SECURE;
		$http_only = DOT_SESSION_COOKIE_HTTP;
		if ( $this->is_session_started() === FALSE ){
		    /*
		     * Set session name.
		     */
		    session_name($session_name);
		    
		    /*
		     * Configure to save the sessions in a cookie.
		     */
		    ini_set('session.use_only_cookies', 1) === false ? exit():'';
		    
		    /*
		     * Get cookie arguments from php.ini
		     */
		    $cookie_args = session_get_cookie_params();
		    
		    /*
		     * Set session cookie.
		     */
		    session_set_cookie_params($cookie_args['lifetime'],
					      $cookie_args['path'], 
					      $cookie_args['domain'], 
					      $secure,
					      $http_only);
		}
		
		/*
		 * Start sessions.
		 */
                if( $this->is_session_started() === FALSE ){
                    session_start();
                }
		
		/*
		 * Don't regenerate session ID if an AJAX call is made.
		 */
		if (!$DOT->post('ajax')
			&& $session_name != ''){
		    session_regenerate_id(true);
		}
	    }
	    
            /*
             * Get a session variable.
	     * 
	     * @usage
	     *	    framework/dot.php : session()
	     * 
             * @params
	     *	    name (string): session name
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
	     *	    Session value or false if the session does not exist.
	     * 
	     * @return_details
		     -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function get($name){
		return isset($_SESSION[$name]) ? $_SESSION[$name]:false;
            }
	    
            /*
             * Set a session variable.
	     * 
	     * @usage
	     *	    framework/dot.php : session()
	     * 
             * @params
	     *	    name (string): session name
             *	    value (string): session value
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
	     *	    Return true after the session is set.
	     * 
	     * @return_details
		     -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function set($name,
				$value){
		$_SESSION[$name] = $value;

		return true;
            }
	}
    }