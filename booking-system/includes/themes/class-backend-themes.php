<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/themes/class-backend-themes.php
* File Version            : 1.0.2
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end themes PHP class.
*/

    if (!class_exists('DOPBSPBackEndThemes')){
        class DOPBSPBackEndThemes extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the themes page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_themes->template();
            }
            
            /*
             * Display themes.
             */
            function display(){
                global $DOPBSP;
                
                if (function_exists('curl_init')) {
                    $json = $this->file_get_contents_curl('https://pinpoint.world/wordpress/api/?data=themes');
                } else {
                    $json = file_get_contents('https://pinpoint.world/wordpress/api/?data=themes');
                }
                
                if ($json === false){
                    echo 'error';
                }
                else{
                    $themes = json_decode($json);

                    $DOPBSP->views->backend_themes_filters->template(array('themes' => $themes));
                    echo ';;;;;;;';
                    $DOPBSP->views->backend_themes_list->template(array('themes' => $themes));
                }
                
                die();
            }
        
            function file_get_contents_curl($url){
		// NOT USED. REMOVE AT A LATER DATE.
		
                curl_setopt($ch=curl_init(), CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }
        }
    }