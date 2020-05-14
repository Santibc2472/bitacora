<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemInstallation {
  
    function __construct(){
    }
    
    /*
     *  Start Installation / Update database CMS
     */ 
    function start() {
        global $ABookingSystem;
        global $absdashboardclasses;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            // Install / Update Database
            $absdashboardclasses->db->installation('absd_options');
        }
    }
}