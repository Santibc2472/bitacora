<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemDisplay {
  
    function __construct(){
    }
    
    /*
     *  View CMS
     */ 
    function view($view) {
        global $ABookingSystem;
        global $absdashboardclasses;
      
        if($view == '') {
            $view = 'main';
        }
        
        // Plugin views
        $view_path = $ABookingSystem['plugin_path'].'views/'.$view;
        
        // Extension views
        if (strpos($view, 'ext-') !== false) {
            $page_data = explode('-', $view);
            $extension = $page_data[1];
            $extension_page = $page_data[2];
            $view_path = $ABookingSystem['plugin_path'].'extensions/'.$extension.'/views/'.$extension_page;
        }
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            
            if(file_exists($view_path.'.php')) {
                include_once $view_path.'.php';
            }
        }
    }
}