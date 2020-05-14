<?php
if (!defined('ABSPATH')) exit;

class ABookingSystem_ext_calendar_designer_menu {
  
    function __construct(){
        $this->load();
    }
    
    function load(){
        add_action('aplusbookingsystem_menu_hook', array(&$this, 'menuButtons'));
    }
    
    function menuButtons(){
        global $ABookingSystem;
        global $ABookingSystemCalendarDesigner;
        
        foreach($ABookingSystemCalendarDesigner['menu'] as $menu => $buttons){
            
            foreach($buttons as $button) {
                array_push($ABookingSystem['menu'][$menu], $button);
            }
        }
    }
}