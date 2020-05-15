<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/controllers/user/locations.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : User locations controller PHP class.
 */

    if (!class_exists('DOTControllerUserLocations')){
        class DOTControllerUserLocations{
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
	     * The page.
	     * 
	     * @usage
	     *	    Reserved controller function that will be interpreted by DOT framework.
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
	    public function index(){
		global $DOT;
	    }
	    
/*
 * AJAX
 */
	    
/*
 * Assets
 */	    
	    
	    /*
	     * Add CSS files specific to this page.
	     * 
	     * @usage
	     *	    Reserved controller function that will be interpreted by DOT framework.
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
	     *	    An array with the CSS files.
	     * 
	     * @return_details
	     *	    All files are loaded in page header after the content is loaded.
	     *	    The array will contain up to 3 keys each with its own array:
	     *		beta : The list of CSS files that will appear on development site.
	     *		live : The list of CSS files that will appear on live site.
	     *		page : The list of CSS files which content will appear in page header.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function css(){
		return array('beta' => array(),
			     'live' => array(),
			     'page' => array()); 
	    }
	    
	    /*
	     * Add JavaScript files specific to this page.
	     * 
	     * @usage
	     *	    Reserved controller function that will be interpreted by DOT framework.
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
	     *	    DOT (object): DOT framework main class variable.
	     *			   Use [$DOT->paths->url] variable to set the path to files for "beta" or "live" : $DOT->paths->url.'path to file'
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
	     *	    An array with the JavaScript files.
	     * 
	     * @return_details
	     *	    All files are added in page footer.
	     *	    The array will contain up to 3 keys each with its own array:
	     *		beta : The list of JavaScript files that will appear on development site.
	     *		live : The list of JavaScript files that will appear on live site (usually one minified version).
	     *		page : The list of JavaScript files which content will appear in page footer.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function js(){
		return array('beta' => array(),
			     'live' => array(),
			     'page' => array());
	    }
	}
    }