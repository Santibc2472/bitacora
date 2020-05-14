<?php
if (!defined('ABSPATH')) exit;

class ABookingSystem_ext_live_updates_main {
  
    function __construct(){
        $this->load();
    }
    
    /*
     * Autodetect & Load Extensions
     */ 
    function load() {
        global $absdashboardclasses;
      
        // Files
        $is_ajax_request = $absdashboardclasses->protect->post('is_ajax_request');
                
        if (is_admin() 
            && $is_ajax_request == ''){
                  
            // JS Requests, ...
            if (!has_action('admin_head', array (&$this, 'js_requests') )) {
                add_action('admin_head', array(&$this, 'js_requests'),10);
            }
            
            // JS files
            if (!has_action('admin_enqueue_scripts', array (&$this, 'backend') )) {
                add_action('admin_enqueue_scripts', array(&$this, 'backend'),10);
            }
        } else {
                  
            // JS Requests, ...
            if (!has_action('wp_head', array (&$this, 'js_requests') )) {
                add_action('wp_head', array(&$this, 'js_requests'),10);
            }
            
            add_action('wp_enqueue_scripts', array(&$this, 'frontend'));
        }
    }
    
    /*
     *  Frontend CMS
     */ 
    function frontend() {
        global $ABookingSystem;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          
            if (!wp_script_is('jquery', 'queue')){
                wp_enqueue_script('jquery');
            }
          
            if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                wp_enqueue_script('jquery-ui-datepicker');
            }
            
            // CSS FILES
            foreach($ABookingSystem['resources_ext_live_updates']['css'] as $cssLink){
                $fileName = str_replace(' ', '-', $cssLink['name']);
                
                if(($cssLink['page'] != '' && $ABookingSystem['page'] == $cssLink['page'])
                  || ($cssLink['page'] == '')
                  || $cssLink['type'] == 'both'
                  && ($cssLink['role'] == ''
                      || $cssLink['role'] == $ABookingSystem['role'])) {
                    
                    if($cssLink['type'] != 'backend') {
                        wp_register_style($fileName, ($cssLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/live_updates/':'').$cssLink['file']);
                        wp_enqueue_style($fileName, 9999);
                    }
                }
            }
            
            // JS FILES
            foreach($ABookingSystem['resources_ext_live_updates']['js'] as $jsLink){
                $fileName = str_replace(' ', '-', $jsLink['name']);
                
                if(($jsLink['page'] != '' && $ABookingSystem['page'] == $jsLink['page'])
                  || ($jsLink['page'] == '')
                  || $jsLink['type'] == 'both'
                  && ($jsLink['role'] == ''
                      || $jsLink['role'] == $ABookingSystem['role'])) {
                    
                    if($jsLink['type'] != 'backend') {
                        $jquery_needed = $ABookingSystem['page'] == 'register' ? array():array('jquery');
                        wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/live_updates/':'').$jsLink['file'], $jquery_needed, false, true);
                        wp_enqueue_script($fileName, 9999);
                    }
                }
            }
        }
    }
    
    /*
     *  Backend CMS
     */ 
    function backend() {
        global $ABookingSystem;
        global $absdashboardclasses;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          
            if (!wp_script_is('jquery', 'queue')){
                wp_enqueue_script('jquery');
            }
          
            if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                wp_enqueue_script('jquery-ui-datepicker');
            }
          
            if($absdashboardclasses->main->isBMpage()) {
                // CSS FILES
                foreach($ABookingSystem['resources_ext_live_updates']['css'] as $cssLink){
                    $fileName = str_replace(' ', '-', $cssLink['name']);

                    if(($cssLink['page'] != '' && $ABookingSystem['page'] == $cssLink['page'])
                        || ($cssLink['page'] == '')
                        && ($cssLink['role'] == ''
                            || $cssLink['role'] == $ABookingSystem['role'])) {

                        if($cssLink['type'] != 'frontend') {
                            wp_register_style($fileName, ($cssLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/live_updates/':'').$cssLink['file']);
                            wp_enqueue_style($fileName, 9999);
                        }
                    }
                }

                // JS FILES
                foreach($ABookingSystem['resources_ext_live_updates']['js'] as $jsLink){
                    $fileName = str_replace(' ', '-', $jsLink['name']);

                    if(($jsLink['page'] != '' && $ABookingSystem['page'] == $jsLink['page'])
                        || ($jsLink['page'] == '')
                        && ($jsLink['role'] == ''
                            || $jsLink['role'] == $ABookingSystem['role'])) {

                        if($jsLink['type'] != 'frontend') {
                            wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/live_updates/':'').$jsLink['file'], array('jquery'), false, true);
                            wp_enqueue_script($fileName, 9999);
                        }
                    }
                }
            } else {
                // JS FILES
                foreach($ABookingSystem['resources_ext_live_updates']['js'] as $jsLink){
                    $fileName = str_replace(' ', '-', $jsLink['name']);

                    if($jsLink['page'] == ''
                        && ($jsLink['role'] == ''
                            || $jsLink['role'] == $ABookingSystem['role'])) {

                        if($jsLink['type'] != 'frontend') {
                            wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/live_updates/':'').$jsLink['file'], array('jquery'), false, true);
                            wp_enqueue_script($fileName, 9999);
                        }
                    }
                }
            }
        }
    }
}