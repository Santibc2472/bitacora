<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/dot.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Main PHP class.
 */

    if (!class_exists('DOT')){
        class DOT{
            /*
             * Public variables.
             */
            public $addons; // A list of all activated add-ons plugins.
            public $ajax; // A list of all AJAX calls.
            public $classes; // All framework's classes.
            public $controllers;  // All controller type classes.
	    public $cookie; // Reserved framework public variable for Cookie Class.
            public $db; // Reserved framework public variable for Database Class.
            public $dv; // A list of variables that are passed from controllers to layouts.
            public $email; // Reserved framework public variable for Email Class.
            public $hooks; // Reserved framework public variable for Hooks Class.
            public $language; // Current application language.
            public $language_default; // Default application language.
            public $models; // All model type classes.
            public $paths; // Application paths.
            public $permalink; // All data collected from controllers to create the correct page permalink.
            public $tables; // A list of all database tables.
            
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
	     *	    Initialize framework's public variables.
	     * 
	     * @return_details
	     *	    Public variables type:
             *          addons : array
	     *		ajax : object
	     *		    ajax->{key} : AJAX call key
	     *		    ajax->{key}->controller : the controller class name
	     *		    ajax->{key}->method : the class method (function) name
	     * 
             *		classes : object
	     *		    classes->{key} (object): class object; {key} class key
	     * 
             *		controllers : object
	     *		    controllers->{key} (object): controller object; {key} Controller class key
	     * 
	     *		cookie : object
             *		db : object
             *		dv : array
	     *		    {variable} => {value}
	     *		    {variable} (string): variable name
	     *		    {value} (mixed): variable value
	     * 
             *		email : object
             *		hooks : object
             *		language : string
             *		language_default : string
	     *		    The first value of global variable, the array [dot_languages], is the default language.
	     * 
             *		models : object
	     *		    models->{key} (object): model object; {key} Model class key
	     * 
             *		paths : object
	     *		    paths->abs (string): absolute path
	     *		    paths->url (string): application URL
	     * 
	     *		permalink : object
	     *		    permalink->data (array): a list with all sections from the permalink
	     *		    permalink->get (string): a string with the URL syntax for $_GET variables
	     *		    permalink->page_name (string): current page name, words are separated with the "-" character
	     *		    permalink->page (string): current page, words are separated with the "_" character
	     *		    permalink->page_class (string): page class, words are separated with the "-" character
	     *		    permalink->routes (array): a list with all translated URLs keys to corresponding default URL; are used to find the correct controller
	     *			permalink->routes[{key}] => {URL}
	     *			{key} (string): translated URL key; "/" character is replaced with "_"
	     *			{URL} (string): default URL
	     *		    permalink->translation (array): all translated URLs from all permalinks functions found in controllers
	     *			permalink->translation[{URL}] => [{language ISO code}] => {translated URL}
	     *			{URL} (string): default language URL
	     *			{language ISO code} (string): language ISO 639-1 code
	     *			{translated URL} (string): translated URL
	     *		   permalink->verify (function): verify permalink data
	     * 
             *		tables : object
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            function __construct(){
                $this->addons = array();
                $this->ajax = new stdClass;
                $this->ajax_classes = new stdClass;
                $this->classes = new stdClass;
                $this->controllers = new stdClass;
                $this->cookie = new stdClass;
                $this->db = new stdClass;
                $this->dv = array();
                $this->email = new stdClass;
                $this->hooks = new stdClass;
                $this->language = '';
                $this->language_default = '';
                $this->models = new stdClass;
                $this->paths = new stdClass;
                $this->permalink = new stdClass;
                $this->tables = new stdClass;
            }
	    
	    /*
	     * Initialize API.
	     * 
	     * @usage
	     *	    index.php
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
	     *	    dot_classes (array): a list with all classes' details
	     * 
	     * @functions
             *      framework/includes/class-addons.php : get() // Get installed add-ons.
	     *	    framework/includes/class-controllers.php : init() // Initialiaze controllers.
	     *	    framework/includes/class-controller.php : init() // Display current page.
	     *	    framework/includes/class-database.php : connect() // Connect to database.
	     *	    framework/includes/class-database.php : tables() // Initialiaze database tables list.
	     *	    framework/includes/class-models.php : init() // Initialiaze models.
	     *	    framework/includes/class-session.php : secure() // Make sessions secure by saving them in cookies.
	     *	    framework/includes/class-translation.php : init() // Load language files.
	     * 
	     *	    this : load() // Load all files (classes, controllers, models, translations) and initialize them.
	     *	    this : paths() // Set application paths.
	     *	    this : timezone() // Set timezone.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Initialize API and display current page.
	     * 
	     * @return_details
	     *	    Step 1 : Set server timezone.
	     *	    Step 2 : Define application paths (absolute & URL).
	     *	    Step 3 : Load framework classes.
	     *	    Step 4 : Make sessions secure.
             *      Step 5 : Get installed add-ons.
	     *	    Step 6 : Initialize tables.
	     *	    Step 7 : Connect to database.
	     *	    Step 8 : Initialize models.
	     *	    Step 9 : Initialize controllers.
	     *	    Step 10 : Load translation.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function init(){
		global $DOT;
		global $dot_classes;
		
		/*
		 * Define paths.
		 */
                $DOT->paths();
                
                /*
                 * Initialize classes.
                 */
                $DOT->load('classes',
			   $dot_classes);
		
		/*
		 * Initialize secure session.
		 */
	//	$DOT->classes->session->secure();
            
		/*
		 * Define database tables' names.
		 */
                $DOT->db->tables();
                
                /*
		 * Get installed add-ons.
		 */
		$DOT->classes->addons->get();
		
		/*
		 * Initialize AJAX.
		 */
		$DOT->classes->ajax->init();
		
		/*
		 * Initialize models.
		 */
		$DOT->classes->models->init();
		
		/*
		 * Initialize controllers.
		 */
		$DOT->classes->controllers->init();
		
//		print_r($DOT->ajax);
//		print_r($DOT->controllers);
		/*
		 * Get translation.
		 */
//		$DOT->classes->translation->init($DOT->language);
		
		/*
		 * Display page.
		 */
//		$DOT->classes->controller->init();
	    }
		
	    /*
	     * Initialize classes.
	     * 
	     * @usage
	     *	    framework/includes/class-controllers.php : init()
	     *	    framework/includes/class-models.php : init()
	     *	    framework/includes/class-translation.php : init()
	     * 
	     *	    this : init()
	     * 
             * @params
	     *	    type (string): classes type
	     *	    data (array): classes data
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
	     *	    The classes are initialized in DOT object.
	     * 
	     * @return_details
	     *	    Controllers are initialized in DOT->controllers object.
	     *	    Models are initialized in DOT->models object.
	     *	    
	     *	    Framework classes are initialized in DOT->classes object.
	     *	    Some framework classes have their own reserved DOT object:
	     *		DOT->db : framework/includes/class-database.php
	     *		DOT->email : framework/includes/class-email.php
	     *		DOT->hooks : framework/includes/class-hooks.php
	     *		DOT->prototypes : framework/includes/class-prototypes.php
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function load($type,
				 $data){
		global $DOT;
		
		foreach ($data as $key => $class){
		    $name = isset($class->class) ? $class->class:'';
		    $file = $class->file;
		    
		    include_once($type == 'classes' ? $this->paths->abs.'/framework/includes/'.$file.'.php':$file);
		    
		    if ($name != ''){
			if (class_exists($name)){
			    if ($type == 'classes'
				    && ($key == 'db'
					    || $key == 'email'
					    || $key == 'hooks'
					    || $key == 'prototypes')){
				/*
				 * Set framework reserved classes.
				 */
				$DOT->$key = new $name();
			    }
			    else{
				$DOT->$type->$key = new $name();
			    }
			}
			else{
			    /*
			     * Add a message if there is a problem with the class.
			     */
			    switch ($type){
				case 'classes':
				    $DOT->$type->$key = 'Class does not exist!';
				    break;
				case 'controllers':
				    $DOT->$type->$key = 'Controller does not exist!';
				    break;
				case 'models':
				    $DOT->$type->$key = 'Model does not exist!';
				    break;
			    }
			}
		    }
		}
            }
            
	    /*
             * Defines paths.
	     * 
	     * @usage
	     *	    this : init()
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
	     *	    Set application URL & absolute path.
	     * 
	     * @return_details
	     *	    The paths are set in object DOT->paths object.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function paths(){
		global $DOT;
		
                /*
                 * Application URL.
                 */
                $DOT->paths->url = substr(DOT_URL, -1) != '/' ? DOT_URL:substr(DOT_URL, 0, -1);

                /*
                 * Absolute path.
                 */
                $DOT->paths->abs = substr(DOT_ABS_PATH, -1) != '/' ? DOT_ABS_PATH:substr(DOT_ABS_PATH, 0, -1);
            }
	    
/*
 * Functions used in application.
 */
	    
	    /*
	     * Displays assets files in a HTML page.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    assets (array): list of assets
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
	     *	    framework/includes/class-view.php : css() // Add CSS files.
	     *	    framework/includes/class-view.php : cssCode() // Add CSS code.
	     *	    framework/includes/class-view.php : js() // Add JavaScript files.
	     *	    framework/includes/class-view.php : jsCode() // Add JavaScript code.
	     * 
	     * @layouts
	     *	    -
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @return
	     *	    Add assests (CSS, CSS code, JavaScript, JavaScript code) to a page.
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
	    public function assets($assets){
		global $DOT;
		
		foreach ($assets as $asset){
		    switch ($asset){
			case 'css':
			    $DOT->classes->view->css();
			    break;
			case 'css_code':
			    $DOT->classes->view->cssCode();
			    break;
			case 'js':
			    $DOT->classes->view->js();
			    break;
			case 'js_code':
			    $DOT->classes->view->jsCode();
			    break;
		    }
		}
	    }
            
	    /*
	     * Get, set or delete a cookie.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    name (string): cookie name
             *	    value (string): cookie value
             *	    expire (integer): cookie lifetime in seconds
             *	    path (string): the path where the cookie is available
             *	    domain (string): the (sub)domain where the cookie is available
             *	    secure (boolean): the cookie should be available over a https connection or not
	     *	    http (boolean): the cookie should be made accessible only through the HTTP protocol
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
	     *	    DOT_COOKIE_EXPIRE (integer): default cookie expiration time in seconds
	     *	    DOT_COOKIE_PATH (string): default cookie path
	     *	    DOT_COOKIE_DOMAIN (string): default cookie (sub)domain
	     *	    DOT_COOKIE_SECURE (boolean): default cookie security
	     *	    DOT_COOKIE_HTTP (boolean): default cookie HTTP access
	     * 
	     * @globals
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework/includes/class-cookie.php : delete() // Delete a cookie.
	     *	    framework/includes/class-cookie.php : get() // Get cookie value.
	     *	    framework/includes/class-cookie.php : set() // Set cookie value.
	     * 
	     * @layouts
	     *	    -
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @return
	     *	    Return the cookie value or "false" if it does not exist, or "true" if the cookie was set.
	     * 
	     * @return_details
	     *	    If [value] is "null" the cookie will be returned, if not the cookie will be set.
		    If expiration value is "-1" the cookie will be deleted.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function cookie($name,
				   $value = null,
				   $expire = DOT_COOKIE_EXPIRE,
				   $path = DOT_COOKIE_PATH,
				   $domain = DOT_COOKIE_DOMAIN,
				   $secure = DOT_COOKIE_SECURE,
				   $http = DOT_COOKIE_HTTP){
		global $DOT;
		
		if ($expire == -1){
		    return $DOT->classes->cookie->delete($name,
							 null,
							 $expire,
							 $path,
							 $domain,
							 $secure,
							 $http);
		}
		else{
		    return $value === null ? $DOT->classes->cookie->get($name):
					     $DOT->classes->cookie->set($name,
									$value,
									$expire,
									$path,
									$domain,
									$secure,
									$http);
		}
	    }
	    
	    /*
	     * Display content.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    page (string): content (layout, HTML, JSON, ..) to be displayed
	     *	    data (array): the data that will be passed to the page 
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
	     *	    framework/includes/class-view.php : render() // Render the content.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Display minified content.
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
	    public function display($file,
				    $data = array()){
		global $DOT;
		
		$DOT->classes->view->render($DOT->paths->abs.'/application/views/'.$file.'.php',
	  			            $data);
	    }
	    
	    /*
	     * Get a $_GET variable or permalink data.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    variable (string): variable name or permalink slug index
	     *	    location (string): variable location
	     *			       "get" the value is in global $_GET
	     *			       "permalink" the value is in permalink
	     *	    redirect (string): redirect path if the permalink index does not exist
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
	     *	    framework/includes/class-permalink.php : verify() // Set permalink data to know what controller to access.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Return the variable value or "false" if it does not exist.
	     * 
	     * @return_details
	     *	    The result is trimmed.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function get($variable,
				$sanitize = 'text'){
		global $DOT;
		
                return isset($_GET[$variable]) ? $DOT->sanitize($_GET[$variable], $sanitize):false;
            }
	    
	    /*
	     * Generate a link for a page or an asset in the application.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    path (string): URL path
	     *	    permalink (boolean): generate a permalink depending on selected language
	     *	    display (boolean): display the link or return it
	     *	    get (boolean): add $_GET variables
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
	     *	    framework/includes/class-permalink.php : get() // Get permalink.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    The link.
	     * 
	     * @return_details
	     *	    If variable [display] value is:
	     *		true : The link will be "written".
	     *		false : The link will be "returned".
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function link($path,
				 $permalink = true,
				 $display = true,
				 $get = false){
		global $DOT;
		
		$link = $DOT->classes->permalink->get($path,
						      $permalink,
						      $get);
		
		/*
		 * Return or display the link.
		 */
		if ($display){
		    echo $link;
		}
		else{
		    return $link;
		}
	    }
	    
	    /*
	     * Get a $_POST variable.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    variable (string): variable name
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
	     *	    Return the variable value or "false" if it does not exist.
	     * 
	     * @return_details
	     *	    The result is trimmed.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function post($variable,
				 $sanitize = 'text'){
		global $DOT;
                
                if(isset($_POST[$variable])){
                    $_POST[$variable] = stripslashes_deep($_POST[$variable]);
                }
                return isset($_POST[$variable]) ? $DOT->sanitize($_POST[$variable], $sanitize):false;
            }
	    
	    public function sanitize($variable,
				     $type = 'text'){
		global $DOT;
		
		if (is_array($variable)){
		    foreach ($variable as $key => $item){
			$variable[$key] = $DOT->sanitize($item, $type);
		    }
		    
		    return $variable;
		}
		else{
		    switch ($type){
			case 'float':
			    $variable = floatval($variable);
			    break;
			case 'html':
			    $variable = wp_filter_post_kses($variable);
			    break;
			case 'int':
			    $variable = intval($variable);
			    break;
			case 'text':
			    $variable = sanitize_text_field($variable);
			    break;
			case 'textarea':
			    $variable = sanitize_textarea_field($variable);
			    break;
		    }
		}
		
		return $variable;
	    }
            
	    /*
	     * Get or set a session.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
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
	     *	    DOT (object): DOT framework main class variable
	     * 
	     * @functions
	     *	    framework/includes/class-session.php : get() // Get session value.
	     *	    framework/includes/class-session.php : set() // Set session value.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Return the session value or "false" if it does not exist, or "true" if the session was set.
	     * 
	     * @return_details
	     *	    If [value] is "null" the session will be returned, if not the session will be set.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function session($name,
				    $value = null){
		global $DOT;
		
		return $value === null ? $DOT->classes->session->get($name):
					 $DOT->classes->session->set($name,
								     $value);
	    }
	    
	    /*
	     * Get text.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    key (string): translation text key
             *	    fallback (string): fallback text if key is invalid
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
	     *	    dot_text (array): a list with all language's text
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
	     *	    the text
	     * 
	     * @return_details
	     *	    The text is returned based on a key. If the key does not exist you can set a fallback text (!).
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function text($key,
                                 $fallback = '!'){
		global $dot_text;
		
                return isset($dot_text[$key]) ? $dot_text[$key]:$fallback;
            }
        }
    }