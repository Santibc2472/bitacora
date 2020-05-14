<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemCalendar {
  
    function __construct(){
    }
    
    /*
     *  Get own calendars
     */ 
    function own($user_id = 0,
                 $type = '') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            
            if($type == '') {
                $results = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT name, api_key, user_id, post_id, cid, group_id, is_group, entire, approved, rejected_reason FROM '.$absdashboardDB->absd_table->calendars.' where user_id = %d order by cid ASC', array($user_id)));
            } else {
                $results = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT name, api_key FROM '.$absdashboardDB->absd_table->calendars.' where user_id = %d AND group_id = %d order by cid ASC', array($user_id, 0)));
                $new_results = array();
                
                foreach($results as $key => $value) {
                    $data_result = new stdClass;
                    $data_result->name = $results[$key]->{'name'};
                    $data_result->value = $results[$key]->{'api_key'};
                    array_push($new_results, $data_result);
                }
                
                return $new_results;
            }
            
            return $results;
        }
    }
    
    /*
     *  Get calendar field
     */ 
    function get($name,
                 $api_key,
                 $user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->calendars.' where api_key = %s AND user_id = %d', array($api_key, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $value = $row->{$name};
            }
            
            return $value;
        }
    }
    
    /*
     *  Get no calendars field
     */ 
    function get_no($name,
                    $value) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $rows = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->calendars.' where '.$name.' = %s', array($value)));
            
            return $absdashboardDB->num_rows;
        }
    }
    
    /*
     *  Get calendar data by field & value
     */ 
    function get_data($field,
                      $value) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->calendars.' where '.$field.' = %s', array($value)));
            
            return $row;
        }
    }
  
    function save_data($data,
                       $user_id = 0){
        global $absdashboardclasses;
        $data = json_decode($data);
        $calendars = isset($data->data) ? $data->data:(isset($data->calendars) ? $data->calendars:array());

        // Save calendars
        if(isset($calendars)) {

            foreach($calendars as $calendar) {
                $calendar->group_id = isset($calendar->group_id) ? $calendar->group_id:0;
                $calendar->is_group = isset($calendar->is_group) ? $calendar->is_group:'false';
                $calendar->post_id = isset($calendar->post_id) ? $calendar->post_id:0;
                $entire = isset($calendar->entire) ? $calendar->entire:"false";
                
                $this->add($calendar->name,
                           $calendar->group_id,
                           $calendar->is_group,
                           $calendar->id,
                           $calendar->api_key,
                           $user_id,
                           $calendar->post_id,
                           '0000-00-00 00:00:00',
                           'true',
                           $entire,
                           $calendar->approved,
                           $calendar->rejected_reason);
            }
        }

        if(isset($data->categories)) {
          // Save Categories
          $absdashboardclasses->option->add('categories',
                                   json_encode($data->categories),
                                   '0',
                                   'calendars');
        }
    }
    
    /*
     *  Get calendar field
     */ 
    function exist($field,
                   $value,
                   $user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $return = false;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->calendars.' where '.$field.' = %s AND user_id = %d', array($value, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $return = true;
            }
            
            return $return;
        }
    }
    
    /*
     *  Add calendar
     */ 
    function add($name,
                 $group_id = 0,
                 $is_group = 'false',
                 $cid = 0,
                 $api_key = '',
                 $user_id = 0,
                 $post_id = 0,
                 $update_time = '0000-00-00 00:00:00',
                 $update = 'false',
                 $entire = 'false',
                 $approved = 'false',
                 $rejected_reason = '') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $update_time = date('Y-m-d H:i:s');
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->calendars.' where cid = %d AND user_id = %d', array($cid, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->calendars, array(
                    'name' => $name,
                    'group_id' => $group_id,
                    'is_group' => $is_group,
                    'api_key' => $api_key,
                    'entire' => $entire,
                    'approved' => $approved,
                    'rejected_reason' => $rejected_reason
                ), array(
                    'cid' => $cid,
                    'user_id' => $user_id,
                    'post_id' => $post_id
                ));
            } else {
                $absdashboardDB->insert($absdashboardDB->absd_table->calendars, array(
                    'name' => $name,
                    'group_id' => $group_id,
                    'is_group' => $is_group,
                    'api_key' => $api_key,
                    'cid' => $cid,
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    'last_update_time' => date('Y-m-d H:i:s'),
                    'created_time' => date('Y-m-d H:i:s'),
                    'entire' => $entire,
                    'approved' => $approved,
                    'rejected_reason' => $rejected_reason
                ));
            }
            
            if($update == 'false') {
              // Save update date
              $absdashboardclasses->updates->add('calendars',
                                        '',
                                        $user_id,
                                        $update_time);
            }
        }
    }
    
    /*
     *  Delete calendar
     */ 
    function delete($cid,
                    $user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            
            $absdashboardDB->delete($absdashboardDB->absd_table->calendars, array(
                'cid' => $cid,
                'user_id' => $user_id
            ));
            
            $absdashboardDB->delete($absdashboardDB->absd_table->calendars, array(
                'group_id' => $cid,
                'user_id' => $user_id
            ));
        }
    }
    
    /*
     *  Delete calendars
     */ 
    function delete_all() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $delete = $absdashboardDB->query("TRUNCATE TABLE `".$absdashboardDB->absd_table->calendars."`");
        }
    }
    
    /*
     *  Delete calendars
     */ 
    function delete_all_for($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->calendars, array(
                'user_id' => $user_id
            ));
        }
    }
}