<?php
if (!defined('ABSPATH')) exit;
global $ABookingSystemCalendarDesigner;
$ABookingSystemCalendarDesigner = array();
global $ABookingSystem;


/*
 *  Include CMS Files
 */ 
include_once 'config/requests.php';
include_once 'config/resources.php';
include_once 'config/menu.php';
include_once 'models/main.php';
include_once 'main.php';
include_once 'menuload.php';

class ABookingSystem_ext_calendar_designer {
  
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
        $absdashboardclasses->ABookingSystem_ext_calendar_designer_menu = class_exists('ABookingSystem_ext_calendar_designer_menu') ? new ABookingSystem_ext_calendar_designer_menu():'Class does not exist!'; 
        
        /*
         * Models
         */
        $abookingsystemdashboard->ABookingSystem_ext_calendar_designer_model_main = class_exists('ABookingSystem_ext_calendar_designer_model_main') ? new ABookingSystem_ext_calendar_designer_model_main():'Class does not exist!';
        
        /*
         * Main
         */
        $absdashboardclasses->ABookingSystem_ext_calendar_designer_main = class_exists('ABookingSystem_ext_calendar_designer_main') ? new ABookingSystem_ext_calendar_designer_main():'Class does not exist!';   
    
        /*
         * Load colors
         */
        add_action('aplusbooking_after_calendar_vars', array(&$this, 'loadColors'));
    
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

    function loadColors(){
        global $absdashboardclasses;
        $calendarDesignData = $absdashboardclasses->option->get('calendar-design-new-vars');

        if($calendarDesignData != '') {
            $calendarDesignData = json_decode($calendarDesignData);
        } else {
            $calendarDesignData = array();
        }

        $html = array();

        array_push($html, '<style id="Booking-Everything-Unlimited-Calendar-New-Vars-css">');
        array_push($html, ' :root{');

        foreach($calendarDesignData as $key => $value) {
            array_push($html, $key.':'.$value.' !important;');
        }

        array_push($html, ' }');
        array_push($html, '</style>');
        array_push($html, '<script type="text/javascript">');
        array_push($html, ' window.aplusbookingsystemCalendarDesignColors = [];');

        foreach($calendarDesignData as $key => $value) {
            array_push($html, 'window.aplusbookingsystemCalendarDesignColors["'.$key.'"]="'.$value.'";');
        }

        array_push($html, '</script>');

        echo implode('', $html);
    }
}