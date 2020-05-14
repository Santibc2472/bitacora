<?php
if (!defined('ABSPATH')) exit;

class ABookingSystem_ext_live_updates_menu {
  
    function __construct(){
        $this->load();
    }
    
    function load(){
        add_action('aplusbookingsystem_menu_hook', array(&$this, 'menuButtons'));
    }
    
    function menuButtons(){
        global $ABookingSystem;
        global $ABookingSystemLiveUpdates;
        
        foreach($ABookingSystemLiveUpdates['menu'] as $menu => $buttons){
            
            foreach($buttons as $button) {
                if(!isset($ABookingSystem['menu'][$menu])){
                    $ABookingSystem['menu'][$menu] = array();
                }
                array_push($ABookingSystem['menu'][$menu], $button);
            }
        }
    }
}