<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-controller.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Controller PHP class.
 */

    if (!class_exists('DOTController')){
        class DOTController{
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
	     * Display controller page or call an AJAX method.
	     * 
	     * @usage
	     *	    framework/dot.php : init()
	     * 
             * @params
	     *	    -
	     * 
	     * @post
	     *	    ajax (string): AJAX call key; reserved DOT framework variable
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
	     *	    DOT_STATUS (string): application status (beta, live, maintenance)
	     * 
	     * @globals
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework/includes/class-view.php : init() // Initialize CSS & JavaScript files.
	     * 
	     *	    application/controllers/{all} : index() // Display page.
	     *	    application/controllers/{all} : ajax_{function}() // Call AJAX methods.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Display a page or call an AJAX method
	     * 
	     * @return_details
	     *	    If website status is "maintenance" the maintenance page is displayed.
	     *	    If $_POST variable [ajax] exists an AJAX function is called.
	     *	    If a controller exists CSS & Javascript assets are loaded and page is displayed, otherwise 404 page will show.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function init(){
		global $DOT;
		
		$page = $DOT->permalink->page;
		
		/*
		 * Display maintenance page when status is "maintenance". 
		 */
		if (DOT_STATUS == 'maintenance'
			&& $page != 'maintenance'){
		    header('Location: '.$DOT->link('maintenance', true, false));
		    exit;
		}
		
		/*
		 * Call a method using AJAX.
		 */
		if ($DOT->post('ajax')){
		    $key_ajax = $DOT->post('ajax');
		    $controller = $DOT->ajax->$key_ajax->controller;
		    $method = $DOT->ajax->$key_ajax->method;
		    
		    $class = new $controller;
		    $class->$method();
		    exit;
		}
		
		/*
		 * Display the page if controller exists or display the 404 page.
		 */
		if (isset($DOT->controllers->$page)
			&& method_exists($DOT->controllers->$page, 'index')){
		    $DOT->classes->view->init();
		    $DOT->controllers->$page->index();
		}
		else{
		    header('Location: '.$DOT->link('404', true, false));
		    exit;
		}
	    }
	}
    }