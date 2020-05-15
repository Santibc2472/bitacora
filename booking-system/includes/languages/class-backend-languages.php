<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/languages/class-backend-languages.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end languages PHP class.
*/

    if (!class_exists('DOPBSPBackEndLanguages')){
        class DOPBSPBackEndLanguages extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add languages to database if it does not exist.
             */
            function database(){
                global $wpdb;
                global $DOPBSP;
                
                $languages = $DOPBSP->classes->languages->languages;
                $languages_db = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' ORDER BY id ASC');
                
                for ($l=0; $l<count($languages); $l++){
                    $found = false;
                    
                    for ($l_db=0; $l_db<count($languages_db); $l_db++){
                        if ($languages[$l]['code'] == $languages_db[$l_db]->code){
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found){
                        $wpdb->insert($DOPBSP->tables->languages, array('code' => $languages[$l]['code'],
                                                                        'enabled' => 'false',
                                                                        'name' => $languages[$l]['name']));
                    }
                }
                
                for ($l_db=0; $l_db<count($languages_db); $l_db++){
                    $found = false;
                    
                    for ($l=0; $l<count($languages); $l++){
                        if ($languages[$l]['code'] == $languages_db[$l_db]->code){
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found){
                        $wpdb->delete($DOPBSP->tables->languages, array('code' => $languages_db[$l_db]->code));
                    }
                }
            }
            
            /*
             * Display languages to enable/disable them.
             * 
             * @return HTML languages list
             */
            function display(){
                global $wpdb;
                global $DOPBSP;
                
                $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' ORDER BY id ASC');
                
                if (count($languages) != count($DOPBSP->classes->languages->languages)){
                    $this->database();
                    $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' ORDER BY id ASC');
                }
                
                $DOPBSP->views->backend_languages->template(array('languages' => $languages));
                
            	die();
            }
        }
    }