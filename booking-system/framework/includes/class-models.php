<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-models.php
 * Author                  : Dot on Paper
 * Copyright               : © 2019 Dot on Paper
 * Website                 : https://dotonpaper.net
 * Description             : Models PHP class.
 */

    if (!class_exists('DOTModels')){
        class DOTModels{
	    /*
	     * Private variables.
	     */
	    private $data = array(); // The data of all model type classes.

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
	     * Get models.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->get
	     *	    In FILE search for function call in hooks: array(&$this, 'get')
	     *	    In PROJECT search for function call: $DOT->classes->models->get
	     * 
             * @params
	     *	    addon (string): the add-on from which to get models
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
	     *	    framework/includes/class-files.php : scan() // Scan all model type files.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Private variable "data" will be completed with the data about all model type classes.
	     * 
	     * @return_details
	     *	    The models are created in "application/models" folder. 
	     *	    The file name format will be "model-{section1}-{section2}-...-{sectionN}.php, with lower characters. (Example: application/models/model-shop-cart.php)
	     *	    The model class name will be DOTModel{Section1}{Section2}...{SectionN}, first character of each section being an uppercase. (Example: DOTModelShopCart)
	     * 
	     *	    "data" variable description:
	     *		data : array 
	     *		    data[{key}] (string): model key = {section1}_{section2}_..._{sectionN}
	     *		    data[{key}]->class (string): the model class name
	     *		    data[{key}]->file (string): absolute path to model file
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
		 * Scan models in folder "application/models".
		 */
		$files = $DOT->classes->files->scan($paths_abs.$addon_folder.'/application/models/');
		
		/*
		 * Go through all files and set data.
		 */
		foreach ($files as $file){
		    /*
		     * Get module file name.
		     * {section1}-{section2}-...-{sectionN}
		     */
		    $file_name = str_replace('.php', '', substr($file, strrpos($file, 'model-')+6));
		    
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
		     * DOTModel{Section1}{Section2}...{SectionN}
		     */
		    $class = 'DOTModel'.str_replace(' ', '', ucwords(implode(' ', $sections)));
		    
		    $this->data[$key] = new stdClass;
		    $this->data[$key]->class = $class;
		    $this->data[$key]->file = $paths_abs.$addon_folder.'/application/models/'.$file;
		}
	    }
	    
            /*
	     * Initialize models.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->init
	     *	    In FILE search for function call in hooks: array(&$this, 'init')
	     *	    In PROJECT search for function call: $DOT->classes->models->init
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
	     *	    framework/dot.php : load() // Load all model type files and initialize them.
	     * 
	     *	    this : get() // Get models.
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
		 * Get models in main plugin.
		 */
		$this->get();
		
		/*
		 * Get models in add-ons.
		 */
		foreach ($DOT->addons as $addon){
		    $this->get($addon);
		}
		
		/*
		 * Load models.
		 */
		$DOT->load('models',
			   $this->data);
	    }
	}
    }