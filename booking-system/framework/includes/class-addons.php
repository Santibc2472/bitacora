<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-addons.php
 * Author                  : Dot on Paper
 * Copyright               : © 2019 Dot on Paper
 * Website                 : https://dotonpaper.net
 * Description             : Add-ons PHP class.
 */

    if (!class_exists('DOTAddons')){
        class DOTAddons{
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
	     * Get installed add-ons.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->get
	     *	    In FILE search for function call in hooks: array(&$this, 'get')
	     *	    In PROJECT search for function call: $DOT->classes->addons->get
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
	     *	    dot_array (array): a list with all possible add-ons
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
	     *	    Installed add-ons list is constructed.
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
	    function get(){
		global $DOT;
		global $dot_addons;
		
		foreach ($dot_addons as $addon){
		    in_array('dopbsp-'.$addon.'/dopbsp-'.$addon.'.php', apply_filters('active_plugins', get_option('active_plugins'))) ? array_push($DOT->addons, $addon):'';
		}
	    }
	}
    }