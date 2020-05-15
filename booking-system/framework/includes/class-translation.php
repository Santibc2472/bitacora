<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-translation.php
 * Author                  : Dot on Paper
 * Copyright               : © 2019 Dot on Paper
 * Website                 : https://dotonpaper.net
 * Description             : Translation PHP class.
 */

    if (!class_exists('DOTTranslation')){
        class DOTTranslation{
	    /*
	     * Private variables.
	     */
	    private $data = array(); // The data about all translation files.

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
	     * Get translation.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->get
	     *	    In FILE search for function call in hooks: array(&$this, 'get')
	     *	    In PROJECT search for function call: $DOT->classes->translation->get
	     * 
             * @params
	     *	    language (string): current language ISO 639-1 code
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
	     *	    framework/includes/class-files.php : scan() // Scan all translation files.
	     *	    
	     * @hooks
	     *	    text (filter): text filter
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Private variable [data] will be completed with the data about all translation files.
	     * 
	     * @return_details
	     *	    The translation files are created in "application/translation/{language ISO 639-1 code}" folder. Each language has its own {language ISO 639-1 code} folder. (Example: application/translation/en)
	     *	    The file name format will be "text-{name}.php, with lower characters. (Example: application/translation/en/text-shop.php)
	     *	    All translation text is added to a global variable, the array [dot_languages].
	     * 
	     *	    NOTE: The files can have more words, in which case they will be separeted by the "-" character. (Example: application/translation/en/text-{word1}-{word2}-...-{wordN}.php -> application/translation/en/text-shop-cart.php)
	     * 
	     *	    [data] variable description:
	     *		data : array 
	     *		    data[{key}] (string): translation key = {word1}_{word2}_..._{wordN}
	     *		    data[{key}]->file (string): absolute path to translation file
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function get($language = 'en',
			 $addon = ''){
		global $DOT;
		
		/*
		 * Set add-on folder.
		 */
		$addon_folder = $addon == '' ? '':'-'.$addon;
		
		/*
		 * Verify if translation folder exists.
		 */
		$translation_folder = $DOT->paths->abs.$addon_folder.(file_exists($DOT->paths->abs.$addon_folder.'/application/translation/'.$language.'/') ? '/application/translation/'.$language.'/':'/application/translation/en/');
		
		/*
		 * Scan translation in folder "application/translation/{{language ISO 639-1 code}}".
		 */
		$files = $DOT->classes->files->scan($translation_folder);
		
		foreach ($files as $file){
		    /*
		     * Get translation file name.
		     * {word1}-{word2}-...-{wordN}
		     */
		    $file_name = str_replace('.php', '', substr($file, strrpos($file, 'text-')+6));
		    
		    /*
		     * Get translation file name sections.
		     * array(0 => {word1},
		     *	     1 => {word2},
		     *	     ...
		     *	     n-1 => {wordN})	
		     */
		    $sections = explode('-', $file_name);
		    
		    /*
		     * Get translation key.
		     * {word1}_{word2}_..._{wordN}
		     */
		    $key = implode('_', $sections);
		    
		    $this->data[$key] = new stdClass;
		    $this->data[$key]->file = $translation_folder.$file;
		}
	    }
	    
	    /*
	     * Initialize translation.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->init
	     *	    In FILE search for function call in hooks: array(&$this, 'init')
	     *	    In PROJECT search for function call: $DOT->classes->translation->init
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
	     *	    this : set() // Set translation.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Default text is loaded, and also current language text if it is different.
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
		 * Get default translation.
		 */
		$this->set($DOT->language_default,
			   true);
		
		/*
		 * Get current translation.
		 */
		$DOT->language_default != $DOT->language ? $this->set($DOT->language):'';
	    }
	    
	    /*
	     * Set translation.
	     * 
	     * @usage
	     *	    In FILE search for function call: $this->set
	     *	    In FILE search for function call in hooks: array(&$this, 'set')
	     *	    In PROJECT search for function call: $DOT->classes->translation->set
	     * 
             * @params
	     *	    language (string): current language ISO 639-1 code
	     *	    is_default (boolean): set default language
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
	     *	    dot_text (array): a list with all language's text
	     *	    dot_text_default (array): a list with all default language's text
	     * 
	     * @functions
	     *	    framework/dot.php : load() // Load all translation files.
	     *	    framework/includes/class-hooks.php : set() // Set a hook.
	     * 
	     *	    this : get() // Get translation.
	     *	    
	     * @hooks
	     *	    text (filter): text filter
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    "dot_text_default" & "dot_text" global variables are set.
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
	    function set($language = 'en',
			 $is_default = false){
		global $DOT;
		global $dot_text;
		global $dot_text_default;
		
		/*
		 * Reset text.
		 */
		$dot_text = array();
		
		/*
		 * Get translation in main plugin.
		 */
		$this->get($language);
		
		/*
		 * Get translation in add-ons.
		 */
		foreach ($DOT->addons as $addon){
		    $this->get($language,
			       $addon);
		}
		
		/*
		 * Load translation.
		 */
		$DOT->load('translation',
			   $this->data);
		
		/*
		 * Set default text.
		 */
		$is_default ? $dot_text_default = $dot_text:'';
		
		/*
		 * Apply filter.
		 */
		$dot_text = $DOT->hooks->set('text', 'filter', array($dot_text, $language));
	    }
	}
    }