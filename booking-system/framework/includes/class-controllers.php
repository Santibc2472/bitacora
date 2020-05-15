<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-controller.php
 * Author                  : Dot on Paper
 * Copyright               : © 2019 Dot on Paper
 * Website                 : https://dotonpaper.net
 * Description             : Controller PHP class.
 */

    if (!class_exists('DOTControllers')){
        class DOTControllers{
	    /*
	     * Private variables.
	     */
	    private $data = array(); // The data of all controller type classes.

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
	     * Get controllers.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->get
	     *	    In FILE search for function call in hooks: array(&$this, 'get')
	     *	    In PROJECT search for function call: $DOT->classes->controllers->get
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
	     *	    framework/includes/class-files.php : scan() // Scan all controller type files.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Private variable [data] will be completed with the data about all controller type classes.
	     * 
	     * @return_details
	     *	    The controllers are created in "application/controllers" folder.
	     *	    The structure of the "application/controllers" folder is the same as the sitemap: aplication/controllers/{folder}/{file}.php -> https://{domain}/{folder}/{file}. (Example: aplication/controllers/shop/cart.php -> https://{domain}/shop/cart)
	     *	    The file name will be default page link's last section: https://{domain}/{section1}/{file} -> {file}.php. (Example: https://{domain}/shop/cart -> cart.php)
	     *	    If you have a section in your site with more pages the controller file for that section's page will be named like the folder: https://{domain}/{section}/ -> aplication/controllers/{section}/{section}.php. (Example: https://{domain}/shop -> aplication/controllers/shop/shop.php)
	     *	    The controller class name will be DOTController{Folder1}{Folder2}...{FolderN}{File}, first character of each folder & file being an uppercase. (Example: DOTControllerShopCart)
	     *	    
	     *	    NOTE: The folders & files can have more words, in which case they will be separeted by the "-" character. (Example: application/controllers/shop/mobile-apps/display-app.php -> https://{domain}/shop/mobile-apps/display-app)
	     * 
	     *	    [data] variable description:
	     *		data : array 
	     *		    data[{key}] (string): model key = {folder1}_{folder2}_..._{folderN}_{file} // If a file has a "-" character, it is replaced with a "_" character.
	     *		    data[{key}]->class (string): the controller class name
	     *		    data[{key}]->file (string): absolute path to controller file
	     *		    data[{key}]->permalink (string): the controller permalink
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
		 * Scan controllers in folder "application/controllers".
		 */
		$files = $DOT->classes->files->scan($paths_abs.$addon_folder.'/application/controllers/');
		
		/*
		 * Go through all files and set data.
		 */
		foreach ($files as $file){
		    /*
		     * Get controller default permalink.
		     * {folder1}/{folder2}/.../{folderN}/{file}
		     */
		    $permalink = str_replace('.php', '', $file);
		    
		    /*
		     * Clean permalink if the last folder's name is the same as file name.
		     * {folder1}/{folder2}/.../{folderN-name-like-file}/{file} -> {folder1}/{folder2}/.../{folderN-name-like-file}
		     */
		    $sections_permalink = explode('/', $permalink);
		    $sections_permalink_no = count($sections_permalink);
		    isset($sections_permalink[$sections_permalink_no-2]) && $sections_permalink[$sections_permalink_no-1] == $sections_permalink[$sections_permalink_no-2] ? array_pop($sections_permalink):'';
		    $permalink = implode('/', $sections_permalink);

		    /*
		     * Get controller class name.
		     * DOTController{Folder1}{Folder2}...{FolderN}{File}
		     */
		    $sections_class = explode('/', str_replace('-', '/', $permalink));
		    $sections_class_no = count($sections_permalink);
		    isset($sections_class[$sections_class_no-2]) && $sections_class[$sections_class_no-1] == $sections_class[$sections_class_no-2] ? array_pop($sections_class):'';
		    $class = 'DOTController'.str_replace(' ', '', ucwords(implode(' ', $sections_class)));
		    
		    /*
		     * Get controller key.
		     * {folder1}_{folder2}_..._{folderN}_{file}
		     */
		    $key = implode('_', $sections_class);
		    
		    $this->data[$key] = new stdClass;
		    $this->data[$key]->class = $class;
		    $this->data[$key]->file = $paths_abs.$addon_folder.'/application/controllers/'.$file;
		    $this->data[$key]->permalink = $permalink;
		}
	    }
	    
	    /*
	     * Initialize controllers.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->init
	     *	    In FILE search for function call in hooks: array(&$this, 'init')
	     *	    In PROJECT search for function call: $DOT->classes->controllers->init
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
	     *	    framework/dot.php : load() // Load all controller type files and initialize them.
	     * 
	     *	    this : get() // Get controllers.
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
		 * Get controllers in main plugin.
		 */
		$this->get();
		
		/*
		 * Get controllers in add-ons.
		 */
		foreach ($DOT->addons as $addon){
		    $this->get($addon);
		}
		
		/*
		 * Load controllers.
		 */
		$DOT->load('controllers',
			   $this->data);
	    }
	}
    }