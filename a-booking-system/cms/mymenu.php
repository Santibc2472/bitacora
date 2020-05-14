<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemMenu {
  
    function __construct(){
    }
    
    /*
     *  Backend CMS
     */ 
    function load() {
        global $ABookingSystem;
        global $abookingsystemdashboard;
        global $absdashboardtext;
        global $absdashboardclasses;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          
            if (function_exists('add_options_page')){
              
                if($ABookingSystem['role'] == 'admin'
                  || $ABookingSystem['role'] == 'owner') {
                    $account_type = $absdashboardclasses->option->get('account_type',
                                                             $ABookingSystem['user_id']);
                    $used_for = $absdashboardclasses->option->get('used_for',
                                                         $ABookingSystem['user_id']);
                    $main_menu = $ABookingSystem['menu']['main'];
                    
                    foreach($main_menu as $no => $button){
                        
                        if($no == 0) {
                            // Main Button
                            $main_page_admin = $button['page_admin'];
                            $main_page_owner = $button['page_owner'];
                            add_menu_page($absdashboardtext[$button['title']], $absdashboardtext[$button['title']], ($ABookingSystem['role'] == 'admin' ? 'manage_options':($ABookingSystem['role'] == 'owner' ? 'publish_posts':'read')), 'abookingsystemdashboard-'.($ABookingSystem['role'] == 'admin' ? $main_page_admin:$main_page_owner), array(&$abookingsystemdashboard->main, 'display'), $button['icon']);
                    
                            if($ABookingSystem['role'] == 'admin') {
                                add_submenu_page('abookingsystemdashboard-'.$button['page'], $absdashboardtext[$button['sub_title']], $absdashboardtext[$button['sub_title']], ($ABookingSystem['role'] == 'admin' ? 'manage_options':($ABookingSystem['role'] == 'owner' ? 'publish_posts':'read')), 'abookingsystemdashboard-'.$button['page'], array(&$abookingsystemdashboard->main, 'display'));
                            }
                        } else {
                            
                            if(!$ABookingSystem['page_disabled'] && $button['enabled']) {
                                
                                if(in_array($ABookingSystem['role'], $button['role'])) {
                                    
                                    if(in_array($account_type, $button['account_type'])) {
                                        add_submenu_page('abookingsystemdashboard-'.($ABookingSystem['role'] == 'admin' ? $main_page_admin:$main_page_owner), $absdashboardtext[$button['title'].($button['used_for'] ? $used_for:'')], $absdashboardtext[$button['title'].($button['used_for'] ? $used_for:'')], ($ABookingSystem['role'] == 'admin' ? 'manage_options':($ABookingSystem['role'] == 'owner' ? 'publish_posts':'read')), 'abookingsystemdashboard-'.$button['page'], array(&$abookingsystemdashboard->main, 'display'));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}