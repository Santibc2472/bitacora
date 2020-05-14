<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemRequests {
  
    function __construct(){
        $this->start();
    }
    
    /*
     *  Add requests
     */ 
    function start() {
        global $ABookingSystem;
        global $abookingsystemdashboard;
        global $absdashboardclasses;
      
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          
            // Ajax requests
            foreach($ABookingSystem['requests'] as $request){
                add_action('wp_ajax_abookingsystemdashboard_'.$request['name'], array(&$abookingsystemdashboard->{$request['class']}, $request['function']));
                
                if($request['type'] == 'frontend'
                  || $request['type'] == 'both') {
                    add_action('wp_ajax_nopriv_abookingsystemdashboard_'.$request['name'], array(&$abookingsystemdashboard->{$request['class']}, $request['function']));
                }
            }
        }
    }
}