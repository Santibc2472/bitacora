<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemLanguage {
  
    function __construct(){
        global $absdashboardlanguages;
        $absdashboardlanguages['files'] = array('en' => 'en.php',
                                                'es' => 'es.php', 
                                                'fr' => 'fr.php', 
                                                'de' => 'de.php', 
                                                'it' => 'it.php', 
                                                'jp' => 'jp.php', 
                                                'ru' => 'ru.php', 
                                                'ro' => 'ro.php');
        $absdashboardlanguages['languages'] = array('en', 'es', 'fr', 'de', 'it', 'jp', 'ru', 'ro');
        
        // Role detect
        add_action('init', array(&$this, 'load'));
        add_action('wp', array(&$this, 'load'));
    }
    
    /*
     * Autodetect & Load language
     */ 
    function load() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardlanguages;
        $language_path = $ABookingSystem['plugin_path'].'languages/';
        
        // Config
        $language = $ABookingSystem['language'];
        
        $user_id = $this->get_owner_user_id();
        
        // User language
        $user_language = $absdashboardclasses->option->get('language',
                                                  $user_id);
        
        if($user_language != "") {
            $language = $user_language;
        }
        
        // language
        $get_language = $absdashboardclasses->protect->get('lang');
        
        if(trim($get_language) != "") {
            
            // Update language
            if($user_id != 0
               && trim($get_language) != trim($user_language)) {
                $absdashboardclasses->option->add('language',
                                          $this->valid_language($get_language),
                                          $user_id,
                                          'user');
            }
            $language = $get_language;
        }
        
        // poly lang get current language
        if(function_exists('pll_current_language')) {
            $poly_language = pll_current_language('slug');
            
            // Update language
            if($user_id != 0
               && trim($poly_language) != trim($user_language)) {
                $absdashboardclasses->option->add('language',
                                          $this->valid_language($poly_language),
                                          $user_id,
                                          'user');
            }
            $language = $poly_language;
        }
        
        if(isset($ABookingSystem['shortcode_language'])) {
            $language = $ABookingSystem['shortcode_language'];
        }
        
        // language
        $bec_language = $absdashboardclasses->protect->get('bec_lang');
        
        if(trim($bec_language) != "") {
            $language = $bec_language;
        }
        
        //validate language
        $language = $this->valid_language($language);
        
        $ABookingSystem['language'] = $language;
        
        // include language file
        include($language_path.$absdashboardlanguages['files'][$language]);
        
        do_action('abookinsystemplus_after_load_languages');
    }
    
    function get_owner_user_id(){
        global $ABookingSystem;
        global $absdashboardclasses;
        $user_id = 0;
        
        if(defined('WP_CONTENT_DIR')) {
            $ABookingSystem['type'] = 'wordpress';
            
            // Load Database
            $absdashboardclasses->db->start();

            global $current_user;
            $current_user = wp_get_current_user();
            
            if(!empty($current_user)
               && isset($current_user->ID)) {
                $user_id = $current_user->ID;
            } 
            else {
                if($absdashboardclasses->protect->get('ajax_ses') != ''){
                    $user_data = $absdashboardclasses->protect->show($absdashboardclasses->protect->get('ajax_ses'));
                    $user_data = explode('@@@', $user_data);
                    $user_id = $user_data[0];
                } else if($absdashboardclasses->protect->post('ajax_ses') != ''){
                    $user_data = $absdashboardclasses->protect->show($absdashboardclasses->protect->post('ajax_ses'));
                    $user_data = explode('@@@', $user_data);
                    $user_id = $user_data[0];
                }
            }
        }
        
        return $user_id;
    }
    
    function valid_language($language){
        global $absdashboardlanguages;
        $valid_languages = $absdashboardlanguages['languages'];
        
        if(trim($language) == '') {
            $language = $valid_languages[0];
        }
        
        if(!in_array($language, $valid_languages)) {
            $language = $valid_languages[0];
        }
        
        return $language;
    }
}