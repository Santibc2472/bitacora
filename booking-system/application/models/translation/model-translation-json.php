<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/models/translation/model-translation-json.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Translation JSON model PHP class.
 */

    if (!class_exists('DOTModelTranslationJson')){
        class DOTModelTranslationJson{
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
             * Get all days between 2 dates.
	     * 
	     * @usage
	     *	    -
	     * 
             * @params
	     *	    day_start (string): start day in "YYYY-MM-DD" format
             *	    day_end (string): end day in "YYYY-MM-DD" format
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
	     *	    A list with all the days.
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
            function encode($key,
                            $text = '',
                            $pref_text = '',
                            $suff_text = ''){
                global $wpdb;
                global $DOPBSP;
                
                $json = array();
                
                $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');

                foreach ($languages as $language){
                    if ($key != ''){
                        $translation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language->code.' WHERE key_data="%s"',
                                                                     $key));
                        array_push($json, '"'.$language->code.'": "'.$pref_text.utf8_encode($translation->text_data).$suff_text.'"' );
                    }
                    else{
                        array_push($json, '"'.$language->code.'": "'.$pref_text.utf8_encode($text).$suff_text.'"' );
                    }
                }
                
                return '{'.implode(',', $json).'}';
            }
        }
    }