<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-view.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : View PHP class.
 */

    if (!class_exists('DOTView')){
        class DOTView{

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
	     * Initialize view files.
	     * 
	     * @usage
	     *	    framework/includes/class-controller.php : init()
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
	     *	    dot_css (array): a list with all CSS files that will be loaded on a page; the array will contain up to 3 keys each with its own array:
	     *		beta : The list of CSS files that will appear on development site.
	     *		live : The list of CSS files that will appear on live site.
	     * 
	     *	    dot_js (array): a list with all JS files that will be loaded on a page; the array will contain up to 3 keys each with its own array:
	     *		beta : The list of JavaScript files that will appear on development site.
	     *		live : The list of JavaScript files that will appear on live site (usually one minified version).
	     * 
	     * @functions
	     *	    application/controllers/{controller}.php : css()
	     *	    application/controllers/{controller}.php : js()
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Get assets files.
	     * 
	     * @return_details
	     *	    The CSS files are added to [dot_css] global variable and the JavaScript files are added to [dot_js] global variable.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function init(){
		global $DOT;
		global $dot_css;
		global $dot_js;
		
		$page = $DOT->permalink->page;
		
		if (method_exists($DOT->controllers->$page, 'css')){
		    $css = $DOT->controllers->$page->css();
		    $dot_css['beta'] = isset($css['beta']) ? array_merge($dot_css['beta'], $css['beta']):$dot_css['beta'];
		    $dot_css['live'] = isset($css['live']) ? array_merge($dot_css['live'], $css['live']):$dot_css['live'];
		}
		
		if (method_exists($DOT->controllers->$page, 'js')){
		    $js = $DOT->controllers->$page->js();
		    $dot_js['beta'] = isset($js['beta']) ? array_merge($dot_js['beta'], $js['beta']):$dot_js['beta'];
		    $dot_js['live'] = isset($js['live']) ? array_merge($dot_js['live'], $js['live']):$dot_js['live'];
		}

		if (is_admin()){
		    $DOT->hook('action', 'admin_enqueue_scripts', array(&$this, 'css'));
		    $DOT->hook('action', 'admin_enqueue_scripts', array(&$this, 'js'));
		}
		else{
		    $DOT->hook('action', 'wp_enqueue_scripts', array(&$this, 'css'));
		    $DOT->hook('action', 'wp_enqueue_scripts', array(&$this, 'js'));
		}
	    }
	    
	    /*
	     * Include CSS files in HTML page.
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
	     *	    dot_css (array): a list with all CSS files that will be loaded on a page; the array will contain up to 3 keys each with its own array:
	     *		beta : The list of CSS files that will appear on development site.
	     *		live : The list of CSS files that will appear on live site.
	     *		page : The list of CSS files which content will appear in page header.
	     * 
	     * @functions
	     *	    framework/includes/class-view.php : render() // Minifies the JavaScript code and sends the [css_file] variable to it.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    framework/assets/js/css.php : Displays the CSS files in header after all content is loaded using a Javascript function.
	     * 
	     * @return
	     *	    Displays the CSS files in header for {beta} or {live} website.
	     * 
	     * @return_details
	     *	    -
	     * 
	     * @dv
	     * 
	     * @tests
	     *	    -
             */
	    public function css(){
		global $dot_css;
                
		foreach ($dot_css[DOPP_STATUS] as $file){
		    $path_sections = explode('/', $file);
		    $file_name = str_replace('.css', '', $path_sections[count($path_sections)-1]);
		    $key = 'DOT-css-'.$file_name;
		    
		    /*
		     * Register Styles.
		     */
		    wp_register_style($key, $file);

		    /*
		     * Enqueue Styles.
		     */
		    wp_enqueue_style($key);
		}
	    }
	    
	    /*
	     * Include JavaScript files in HTML page.
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
	     *	    dot_js (array): a list with all JS files that will be loaded on a page; the array will contain up to 3 keys each with its own array:
	     *		beta : The list of JavaScript files that will appear on development site.
	     *		live : The list of JavaScript files that will appear on live site (usually one minified version).
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
	     *	    Displays JavaScript CSS files for {beta} or {live} website.
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
	    public function js(){
                global $dopp_js;
		
		/*
		 * Libraries
		 */
                !wp_script_is('jquery', 'queue') ? wp_enqueue_script('jquery'):'';
		!wp_script_is('jquery-effects-core', 'queue') ? wp_enqueue_script('jquery-effects-core'):'';
		!wp_script_is('jquery-ui-datepicker', 'queue') ? wp_enqueue_script('jquery-ui-datepicker'):'';
                !wp_script_is('jquery-ui-sortable', 'queue') ? wp_enqueue_script('jquery-ui-sortable'):'';
                
		foreach ($dopp_js[DOPP_STATUS] as $file){
		    $path_sections = explode('/', $file);
		    $file_name = str_replace('.js', '', $path_sections[count($path_sections)-1]);
		    $key = 'DOPP-'.$file_name;
		    
		    /*
		     * Register scripts.
		     */
		    wp_register_script($key, $file, array('jquery'), false, true);

		    /*
		     * Enqueue scripts.
		     */
		    wp_enqueue_script($key);
		}
	    }
	    
	    /*
	     * Render an HTML/CSS/JavaScript page/layout.
	     * 
	     * @usage
	     *	    framework/dot.php : display()
	     * 
	     *	    this : css()
	     *	    this : cssCode()
	     *	    this : jsCode()
	     * 
             * @params
	     *	    file (string): file to be rendered
	     *	    data (array): the data that will be passed to the file
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
	     *	    this : minify() // Minifies the file content.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Get file content.
	     * 
	     * @return_details
	     *	    The data that is passed to a file can be used only in this file and not in a files that are rendered inside it.
	     *	    To pass data to inner files use [DOTP->dv] framework's public variable.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function render($file,
				   $data = array()){
		/*
		 * Turn on output buffering and minify its content.
		 */
		ob_start('DOTView::minify');
		
		/*
		 * Add [DOT] global variable to be used in the file.
		 */
		global $DOT;
		
		/*
		 * Add [data] variables to be used in the file.
		 */
		extract($data, EXTR_OVERWRITE);
		
		/*
		 * Include the file.
		 */
		include($file);
		
		/*
		 * Send the output buffer.
		 */
		ob_flush();
		
		/*
		 * Display current buffer contents and delete current output buffer.
		 */
		echo ob_get_clean();
	    }
	    
	    /*
	     * Minify HTML/CSS/JavaScript code.
	     * 
	     * @usage
	     *	    this : render()
	     * 
             * @params
	     *	    code (string): page code
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
	     *	    this : block() // Block minification.
	     *	    this : unblock() // Unblock minification.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Minified file code & content.
	     * 
	     * @return_details
	     *	    Replace "dot-css-assets-url" text in CSS files with the application URL.
	     *	    Remove comments or any content inside /*{ content }* /.
	     *	    Remove empty spaces.
	     *	    Remove new lines, new rows, tabs, ...
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function minify($code){
		global $DOT;
		
		/*
		 * Block minification in <pre> & <textarea> tags.
		 */
		$code = preg_replace_callback('/>[^<]*<\\/pre/i', array(&$this, 'block'), $code);
		$code = preg_replace_callback('/>[^<]*<\\/textarea/i', array(&$this, 'block'), $code);
		
		$search = array('/dot-css-assets-url\//' => $DOT->paths->url, // Add application URL in CSS files.
				'!/\*.*?\*/!s' => '', // Remove comments.
				'/ +/' => ' ', // Remove empty spaces.
				'/<!--\{(.*?)\}-->|<!--(.*?)-->|[\t\r\n]|<!--|-->|\/\/ <!--|\/\/ -->|<!\[CDATA\[|\/\/ \]\]>|\]\]>|\/\/\]\]>|\/\/<!\[CDATA\[/' => ''); // Remove new lines, new rows, tabs, ...
		$code = preg_replace(array_keys($search), array_values($search), $code);
		
		/*
		 * Unblock minification in <pre> & <textarea> tags.
		 */
		$code = preg_replace_callback('/>[^<]*<\\/textarea/i', array(&$this, 'unblock'), $code);
		$code = preg_replace_callback('/>[^<]*<\\/pre/i', array(&$this, 'unblock'), $code);
	
		return $code;
	    }
	    
	    /*
	     * Block minification.
	     * 
	     * @usage
	     *	    this : minify()
	     * 
             * @params
	     *	    code (string): page code
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
	     *	    Replace specific [code] with specific [marker].
	     * 
	     * @return_details
	     *	    [code] : [marker]
	     *	    
	     *	    "\n" : {{{newline}}}
	     *	    "\t" : {{{tab}}}
	     *	    " " : {{{space}}}
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function block($code){
		$code = $code[0];
		
		$code = preg_replace('/\\n/', '{{{newline}}}', $code);
		$code = preg_replace('/\\t/', '{{{tab}}}', $code);
		$code = preg_replace('/\\s/', '{{{space}}}', $code);
		
		return $code;
	    }
	    
	    /*
	     * Unblock minification.
	     * 
	     * @usage
	     *	    this : minify()
	     * 
             * @params
	     *	    code (string): page code
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
	     *	    Replace specific [marker] with specific [code].
	     * 
	     * @return_details
	     *	    [marker] : [code]
	     *	    
	     *	    {{{newline}}} : "\n"
	     *	    {{{tab}}} : "\t"
	     *	    {{{space}}} : " "
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function unblock($code){
		$code = $code[0];
		
		$code = preg_replace('/{{{newline}}}/', "\n", $code);
		$code = preg_replace('/{{{tab}}}/', "\t", $code);
		$code = preg_replace('/{{{space}}}/', " ", $code);
		
		return $code;
	    }
	}
    }