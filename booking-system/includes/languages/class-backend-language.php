<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/languages/class-backend-language.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end language PHP class.
*/

    if (!class_exists('DOPBSPBackEndLanguage')){
        class DOPBSPBackEndLanguage extends DOPBSPBackEndLanguages{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Change back end language.
             * 
             * @post language (string): language in which the back end translation will be changed
             */
            function change(){
		global $DOT;
		
                $user_id = wp_get_current_user()->ID;
                $language = $DOT->post('language');
                $current_backend_language = $this->get();
                
                if ($current_backend_language == ''){
                    add_user_meta($user_id, 'DOPBSP_backend_language', $language, true);
                }
                else{
                    update_user_meta($user_id, 'DOPBSP_backend_language', $language);
                }
                
                die();
            }
            
            /*
             * Enable/disable language.
             * 
             * @post language (string): language (code) to be enabled/disabled
             * @post value (string): "false" if language is to be disabled
             *                       "true" if language is to be enabled
             */
            function enable(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $language = $DOT->post('language');
                $value = $DOT->post('value');
                $current_backend_language = $this->get();
                
                $db_config = $DOPBSP->classes->database->db_config;
                $db_collation = $DOPBSP->classes->database->db_collation;
                
                $wpdb->update($DOPBSP->tables->languages, array('enabled' => $value), 
                                                          array('code' => $language));
                
                /*
                 * If language is to be enabled create the database table and add data to it.
                 */
                if ($value == 'true'){
                    require_once(str_replace('\\', '/', ABSPATH).'wp-admin/includes/upgrade.php');
                    
                    $sql_translation = "CREATE TABLE ".$DOPBSP->tables->translation."_".$language." (
                                        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                        key_data VARCHAR(128) DEFAULT '".$db_config->translation['key_data']."' COLLATE ".$db_collation." NOT NULL,
                                        parent_key VARCHAR(128) DEFAULT '".$db_config->translation['parent_key']."' COLLATE ".$db_collation." NOT NULL,
                                        text_data TEXT COLLATE ".$db_collation." NOT NULL,
                                        translation TEXT COLLATE ".$db_collation." NOT NULL,
                                        location VARCHAR(32) DEFAULT '".$db_config->translation['location']."' COLLATE ".$db_collation." NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";
                    
                    dbDelta($sql_translation);
                    
                    $DOPBSP->classes->backend_translation->database($language);
                }
                else{
                    if ($language == $current_backend_language){
                        update_user_meta(wp_get_current_user()->ID, 'DOPBSP_backend_language', DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE);
                    }
                }
                
                die();
            }
            
            /*
             * Get back end language.
             * 
             * @return backend language
             */
            function get(){
                global $wpdb;
                global $DOPBSP;
                
                $user_id = wp_get_current_user()->ID;
                        
                if (!is_network_admin() 
                        && $user_id != 0){
                    $language = get_user_meta($user_id, 'DOPBSP_backend_language', true);

                    if ($language == ''){
                        add_user_meta($user_id, 'DOPBSP_backend_language', DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE, true);
                        $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                    }
                    else{
                        $language_status = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE code="%s"',
                                                                         $language));
                        
                        if ($language_status->enabled == 'false'){
                            add_user_meta($user_id, 'DOPBSP_backend_language', DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE, true);
                            $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                        }
                    }
                }
                else{
                    $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                }
                
                return $language;
            }
        }
    }