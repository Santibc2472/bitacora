<?php
if (!defined('ABSPATH')) exit;
global $ABookingSystemLiveUpdates;
$ABookingSystemLiveUpdates = array();
global $ABookingSystem;


/*
 *  Include CMS Files
 */ 
include_once 'config/resources.php';
include_once 'config/menu.php';
include_once 'main.php';
include_once 'menuload.php';

class ABookingSystem_ext_live_updates {
  
    function __construct(){
        $this->load();
    }
    
    /*
     * Autodetect & Load Extensions
     */ 
    function load() {
        global $abookingsystemdashboard;
        global $absdashboardclasses;
        
        /*
         * Language
         */
        add_action('abookinsystemplus_after_load_languages', array(&$this, 'language'));
        
        /*
         * Menu
         */
        $absdashboardclasses->ABookingSystem_ext_live_updates_menu = class_exists('ABookingSystem_ext_live_updates_menu') ? new ABookingSystem_ext_live_updates_menu():'Class does not exist!'; 

        /*
         * Main
         */
        $absdashboardclasses->ABookingSystem_ext_live_updates_main = class_exists('ABookingSystem_ext_live_updates_main') ? new ABookingSystem_ext_live_updates_main():'Class does not exist!';   
    
    }
    
    function language(){
        global $ABookingSystem;
        
        if(isset($ABookingSystem['language'])) {
            $language = 'languages/'.$ABookingSystem['language'].'.php';
            if(file_exists($language)) {
                include_once($language);
            } else {
                $language = 'languages/en.php';
                include_once($language);
            }
        }
    }
}