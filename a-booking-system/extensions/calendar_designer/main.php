<?php
if (!defined('ABSPATH')) exit;

class ABookingSystem_ext_calendar_designer_main {
  
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
      
        /*
         *  Start requests
         */
        $this->requests();
    }
    
    /*
     *  Add requests
     */ 
    function requests() {
        global $ABookingSystem;
        global $abookingsystemdashboard;
        global $absdashboardclasses;
      
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            // Ajax requests
            foreach($ABookingSystem['requests_ext_calendar_designer'] as $request){
                add_action('wp_ajax_abookingsystemdashboard_'.$request['name'], array(&$abookingsystemdashboard->ABookingSystem_ext_calendar_designer_model_main, $request['function']));
                
                if($request['type'] == 'frontend'
                  || $request['type'] == 'both') {
                    add_action('wp_ajax_nopriv_abookingsystemdashboard_'.$request['name'], array(&$abookingsystemdashboard->ABookingSystem_ext_calendar_designer_model_main, $request['function']));
                }
            }
        }
    }
    
    /*
     *  JS Requests
     */ 
    function js_requests() {
        global $ABookingSystem;
        global $absdashboardtext;
        global $ABookingSystem;
        global $absdashboardclasses;
        
        $js_html = array();
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          
            array_push($js_html, '<script type="text/javascript">');
          
            // Ajax requests
            array_push($js_html,   'window.abookingsystemdashboard_request_ext_calendar_designer = [];');
            array_push($js_html,   'var abookingsystemdashboard_request_ext_calendar_designer = [];');
          
            foreach($ABookingSystem['requests_ext_calendar_designer'] as $request){
                array_push ($js_html, 'window.abookingsystemdashboard_request_ext_calendar_designer["'.$request['name'].'"] = "abookingsystemdashboard_'.$request['name'].'";');
            }
          
            array_push($js_html, '</script>');
          
        }
      
        echo implode('', $js_html);
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
            foreach($ABookingSystem['resources_ext_calendar_designer']['css'] as $cssLink){
                $fileName = str_replace(' ', '-', $cssLink['name']);
                
                if(($cssLink['page'] != '' && $ABookingSystem['page'] == $cssLink['page'])
                  || ($cssLink['page'] == '')
                  || $cssLink['type'] == 'both'
                  && ($cssLink['role'] == ''
                      || $cssLink['role'] == $ABookingSystem['role'])) {
                    
                    if($cssLink['type'] != 'backend') {
                        wp_register_style($fileName, ($cssLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/calendar_designer/':'').$cssLink['file']);
                        wp_enqueue_style($fileName, 9999);
                    }
                }
            }
            
            // JS FILES
            foreach($ABookingSystem['resources_ext_calendar_designer']['js'] as $jsLink){
                $fileName = str_replace(' ', '-', $jsLink['name']);
                
                if(($jsLink['page'] != '' && $ABookingSystem['page'] == $jsLink['page'])
                  || ($jsLink['page'] == '')
                  || $jsLink['type'] == 'both'
                  && ($jsLink['role'] == ''
                      || $jsLink['role'] == $ABookingSystem['role'])) {
                    
                    if($jsLink['type'] != 'backend') {
                        $jquery_needed = $ABookingSystem['page'] == 'register' ? array():array('jquery');
                        wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/calendar_designer/':'').$jsLink['file'], $jquery_needed, false, true);
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
                foreach($ABookingSystem['resources_ext_calendar_designer']['css'] as $cssLink){
                    $fileName = str_replace(' ', '-', $cssLink['name']);

                    if(($cssLink['page'] != '' && $ABookingSystem['page'] == $cssLink['page'])
                        || ($cssLink['page'] == '')
                        && ($cssLink['role'] == ''
                            || $cssLink['role'] == $ABookingSystem['role'])) {

                        if($cssLink['type'] != 'frontend') {
                            wp_register_style($fileName, ($cssLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/calendar_designer/':'').$cssLink['file']);
                            wp_enqueue_style($fileName, 9999);
                        }
                    }
                }

                // JS FILES
                foreach($ABookingSystem['resources_ext_calendar_designer']['js'] as $jsLink){
                    $fileName = str_replace(' ', '-', $jsLink['name']);

                    if(($jsLink['page'] != '' && $ABookingSystem['page'] == $jsLink['page'])
                        || ($jsLink['page'] == '')
                        && ($jsLink['role'] == ''
                            || $jsLink['role'] == $ABookingSystem['role'])) {

                        if($jsLink['type'] != 'frontend') {
                            wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/calendar_designer/':'').$jsLink['file'], array('jquery'), false, true);
                            wp_enqueue_script($fileName, 9999);
                        }
                    }
                }
            } else {
                // JS FILES
                foreach($ABookingSystem['resources_ext_calendar_designer']['js'] as $jsLink){
                    $fileName = str_replace(' ', '-', $jsLink['name']);

                    if($jsLink['page'] == ''
                        && ($jsLink['role'] == ''
                            || $jsLink['role'] == $ABookingSystem['role'])) {

                        if($jsLink['type'] != 'frontend') {
                            wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url'].'extensions/calendar_designer/':'').$jsLink['file'], array('jquery'), false, true);
                            wp_enqueue_script($fileName, 9999);
                        }
                    }
                }
            }
        }
    }
}