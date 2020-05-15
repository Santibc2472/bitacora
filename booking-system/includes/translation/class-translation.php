<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation.php
* File Version            : 1.1.6
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Translation PHP class.
*/

    if (!class_exists('DOPBSPTranslation')){
        class DOPBSPTranslation{
            /*
             * Public variables.
             */
            public $classes = array();
            public $text = array();
            
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize class.
                 */
                add_action('init', array(&$this, 'init'));
            }
            
            /*
             * Prints out the translation page.
             * 
             * @return translation HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_translation->template();
            }
            
            /*
             * Initialize translation.
             */
            function init(){
                $this->text = apply_filters('dopbsp_filter_translation_text', $this->text);
            }
            
            /*
             * Set PHP translation.
             * 
             * @param language (string): language code to be used, default "DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE"
             * @param use_admin_language (boolean): "true" to use the language selected in the administration area
             * 
             * @return encoded JSON
             */
            function set($language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE,
                         $use_admin_language = true,
                         $locations = array("backend",
                                            "calendar",
                                            "woocommerce_frontend",
                                            "all")){
                global $wpdb;
                global $DOPBSP;
                
                if(in_array('calendar', $locations)
                  && !in_array('all', $locations)){
                    array_push($locations, 'all');
                }
                
                /*
                 * Get back end language.
                 */
                if (is_admin()
                        && $use_admin_language){
                    $language = $DOPBSP->classes->backend_language->get();
                }
                
                if(count($locations) > 1) {
                    $locations_in = 'IN ("'.implode('","',$locations).'")';
                } else {
                    $locations_in = ' = "'.$locations[0].'"';
                } 
                
                if($language == ''){
                    $language = 'en';
                }
                
                $translation = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language.' WHERE location '.$locations_in);
                
//                if (count($this->text) != 0
//                        && count($this->text) != count($translation)){
//                     $DOPBSP->classes->backend_translation->database($language);
//                     $translation = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language.' WHERE location '.$locations_in);
//                }
                
                $DOPBSP->vars->translation_text = array();
                        
                foreach ($translation as $item){
                    $DOPBSP->vars->translation_text[$item->key_data] = str_replace('<<single-quote>>', "'", stripslashes($item->translation));
                }
            }
            
            /*
             * Set translation JSON.
             */
            function encodeJSON($key,
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
            
            /*
             * Get text from translation JSON.
             * 
             * @param json (string): JSON string
             * @param language (string): language code
             * 
             * @return translation text
             */
            function decodeJSON($json,
                                $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                $translation = json_decode($json);
                $default_language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                
                $text = isset($translation->$language) ? $translation->$language:$translation->$default_language;
                $text = utf8_decode($text);
                $text = stripslashes($text);
                $text = str_replace('<<new-line>>', "\n", $text);
                $text = str_replace('<<single-quote>>', "'", $text);
                
                return $text;
            }
            
// Check translation to see what keys are used.
            
            /*
             * Check translations keys.
             * 
             * @return HTML of unused translation keys
             */
            function check(){
                global $DOPBSP;
                
                for ($i=0; $i<count($this->text); $i++){
                    $this->text[$i]['check'] = false;
                }
                        
                $this->checkFolder($DOPBSP->paths->abs);
                
                for ($i=0; $i<count($this->text); $i++){
                    if (strpos($this->text[$i]['key'], 'PARENT_') === false){
                        if ($this->text[$i]['check'] == true){
                            // echo '<span class="dopbsp-used">'.$this->text[$i]['key'].'</span><br />';
                        }
                        else{
                            echo '<span class="dopbsp-unused">'.$this->text[$i]['key'].'</span><br />';
                        }
                    }
                }
                
                die();
            }
            
            /*
             * Check files for translation keys.
             * 
             * @param folder (string): folder to be checked
             */
            function checkFolder($folder){
                $folderData = opendir($folder);
                
                while (($file = readdir($folderData)) !== false){
                    if ($file != '.' 
                            && $file != '..'){
                        if (filetype($folder.$file) == 'file'){
                            $ext = pathinfo($folder.$file, PATHINFO_EXTENSION);
                            
                            if (($ext == 'js' 
                                            || $ext == 'php') 
                                    && strrpos($file, 'class-translation') === false){
                                $file_data = file_get_contents($folder.$file);
                                
                                for ($i=0; $i<count($this->text); $i++){
                                    if (strpos($file_data, $this->text[$i]['key']) !== false
                                            || strpos($this->text[$i]['key'], 'AUTHORIZENET') !== false
                                            || strpos($this->text[$i]['key'], 'PAYPAL') !== false
                                            || strpos($this->text[$i]['key'], 'STRIPE') !== false
                                            || strpos($this->text[$i]['key'], 'TWOCHECKOUT') !== false){
                                        $this->text[$i]['check'] = true;
                                    }
                                }
                            }
                        }
                        elseif (filetype($folder.$file) == 'dir'){
                            $this->checkFolder($folder.$file.'/');
                        }
                    }
                }
                closedir($folderData);
            }
        }
    }