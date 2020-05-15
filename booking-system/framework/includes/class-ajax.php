<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-ajax.php
 * Author                  : Dot on Paper
 * Copyright               : © 2019 Dot on Paper
 * Website                 : https://dotonpaper.net
 * Description             : AJAX PHP class.
 */

    if (!class_exists('DOTAjax')){
        class DOTAjax{
	    /*
	     * Private variables.
	     */
	    private $data = array(); // The data of all AJAX type classes.
	    
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
	     * Get AJAX classes.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->get
	     *	    In FILE search for function call in hooks: array(&$this, 'get')
	     *	    In PROJECT search for function call: $DOT->classes->ajax->get
	     * 
             * @params
	     *	    addon (string): the add-on from which to get AJAX classes
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
	     *	    framework/includes/class-files.php : scan() // Scan all AJAX type files.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Private variable "data" will be completed with the data about all AJAX type classes.
	     * 
	     * @return_details
	     *	    The AJAX classes are created in "application/ajax" folder. 
	     *	    The file name format will be "ajax-{section1}-{section2}-...-{sectionN}.php, with lower characters. (Example: application/ajax/ajax-shop-cart.php)
	     *	    The AJAX class name will be DOTAjax{Section1}{Section2}...{SectionN}, first character of each section being an uppercase. (Example: DOTAJAXShopCart)
	     * 
	     *	    "data" variable description:
	     *		data : array 
	     *		    data[{key}] (string): ajax key = {section1}_{section2}_..._{sectionN}
	     *		    data[{key}]->class (string): the AJAX class name
	     *		    data[{key}]->file (string): absolute path to AJAX file
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function get($addon = ''){
		global $DOT;
		
		/*
		 * Set add-on folder.
		 */
		$paths_abs = $addon == '' ? $DOT->paths->abs:str_replace('/plugins/booking-system', '/plugins/dopbsp', $DOT->paths->abs);
		$addon_folder = $addon == '' ? '':'-'.$addon;
		
		/*
		 * Scan AJAX classes in folder "application/ajax".
		 */
		$files = $DOT->classes->files->scan($paths_abs.$addon_folder.'/application/ajax/');
		
		/*
		 * Go through all files and set data.
		 */
		foreach ($files as $file){
		    /*
		     * Get AJAX file name.
		     * {section1}-{section2}-...-{sectionN}
		     */
		    $file_name = str_replace('.php', '', substr($file, strrpos($file, 'ajax-')+5));
		    
		    /*
		     * Get module file name sections.
		     * array(0 => {section1},
		     *	     1 => {section2},
		     *	     ...
		     *	     n-1 => {sectionN})	
		     */
		    $sections = explode('-', $file_name);
		    
		    /*
		     * Get module key.
		     * {section1}_{section2}_..._{sectionN}
		     */
		    $key = implode('_', $sections);
		    
		    /*
		     * Get module class name.
		     * DOTAjax{Section1}{Section2}...{SectionN}
		     */
		    $class = 'DOTAjax'.str_replace(' ', '', ucwords(implode(' ', $sections)));
		    
		    $this->data[$key] = new stdClass;
		    $this->data[$key]->class = $class;
		    $this->data[$key]->file = $paths_abs.$addon_folder.'/application/ajax/'.$file;
		}
	    }
	    
            /*
	     * Initialize AJAX classes.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->init
	     *	    In FILE search for function call in hooks: array(&$this, 'init')
	     *	    In PROJECT search for function call: $DOT->classes->ajax->init
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
	     *	    framework/dot.php : load() // Load all AJAX type files and initialize them.
	     * 
	     *	    this : get() // Get AJAX classes.
	     *	    this : set() // Set AJAX.
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
	    function init(){
		global $DOT;
		
		/*
		 * Get AJAX classes in main plugin.
		 */
		$this->get();
		
		/*
		 * Get AJAX classes in add-ons.
		 */
		foreach ($DOT->addons as $addon){
		    $this->get($addon);
		}
		
		/*
		 * Load AJAX classes.
		 */
		$DOT->load('ajax_classes',
			   $this->data);
		
		/*
		 * Set AJAX data.
		 */
		$this->set();
	    }
	    
	    /*
	     * Set AJAX.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->set
	     *	    In FILE search for function call in hooks: array(&$this, 'set')
	     *	    In PROJECT search for function call: $DOT->classes->ajax->set
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
	     *	    DOT_ID (string): unique aplication ID
	     * 
	     * @globals
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    WP : add_action() // Hooks a function on to a specific action.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Set AJAX hooks & keys.
	     * 
	     * @return_details
	     *	    ajax : object
	     *		ajax->{key} : AJAX call key
	     *		ajax->{key}->class : the class name
	     *		ajax->{key}->method : the class method (function) name
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function set(){
		global $DOT;
		
		foreach ($DOT->ajax_classes as $key => $class){
		    $methods = get_class_methods($class);
		    
		    foreach ($methods as $method){
			if ($method !== '__construct'){
			    /*
			     * Get AJAX key. Is preceded by AJAX class key.
			     * functionName -> {ajaxClass_key}_function_name
			     */
			    $method_sections = preg_split('/(?=[A-Z])/', $method);
			    $key_ajax = $key.'_'.implode('_', array_map('strtolower', $method_sections));
			    
			    $DOT->ajax->{$key_ajax} = new stdClass; 
			    $DOT->ajax->{$key_ajax}->class = $class;
			    $DOT->ajax->{$key_ajax}->method = $method;
			    
			    /*
			     * Set AJAX hooks.
			     */
			    add_action('wp_ajax_'.DOT_ID.'_'.$key_ajax, array(&$DOT->ajax->{$key_ajax}->class, $DOT->ajax->{$key_ajax}->method));
			    add_action('wp_ajax_nopriv_'.DOT_ID.'_'.$key_ajax, array(&$DOT->ajax->{$key_ajax}->class, $DOT->ajax->{$key_ajax}->method));
			}
		    }
		}
	    }
	}
    }