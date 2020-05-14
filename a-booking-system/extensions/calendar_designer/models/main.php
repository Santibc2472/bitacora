<?php
if (!defined('ABSPATH')) exit;

class ABookingSystem_ext_calendar_designer_model_main {
    
    function save(){
        global $absdashboardclasses;
        $calendarDesignData = $absdashboardclasses->option->get('calendar-design-new-vars');
        $key = $absdashboardclasses->protect->post('key');
        $color = $absdashboardclasses->protect->post('color');

        if($calendarDesignData != '') {
            $calendarDesignData = json_decode($calendarDesignData);
            $calendarDesignData = (array)$calendarDesignData;
        } else {
            $calendarDesignData = array();
        }

        $calendarDesignData[$key] = $color;

        $absdashboardclasses->option->add('calendar-design-new-vars', json_encode($calendarDesignData));

        echo 'success';
        exit;
    }
    
    function reset(){
        global $absdashboardclasses;
        $absdashboardclasses->option->delete('calendar-design-new-vars');
        echo 'success';
        exit;
    }

}