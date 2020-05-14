<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemStats {
  
    function __construct(){
    }
    
    /*
     *  Get own stats
     */ 
    function own($user_id = 0, $calendar_id = 0, $type = 'users') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $results = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT data FROM '.$absdashboardDB->absd_table->stats.' where user_id =%d AND  calendar_id = %d AND type = %s ORDER by id DESC', array($user_id, $calendar_id, $type)));
            
            return $results;
        }
    }
  
    function save_data($data,
                       $user_id = 0,
                       $calendar_id = 0,
                       $type = 'users'){
      global $absdashboardclasses;
      $data = json_decode($data);
      
      
        // Save stats
        foreach($stats as $stat) {
            // Save stats
            $this->add($data,
                       $user_id,
                       $calendar_id,
                       $type,
                       '0000-00-00 00:00:00',
                       'true');
        }
    }
    
    /*
     *  Add stats
     */ 
    function add($data,
                 $user_id = 0,
                 $calendar_id = 0,
                 $type = 'users',
                 $update_time = '0000-00-00 00:00:00',
                 $update = 'false') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $update_time = date('Y-m-d H:i:s');
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->stats.' where calendar_id = %d AND user_id = %d AND type = %s', array($calendar_id, $user_id, $type)));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->stats, array(
                    'data' => json_encode($data),
                    'last_update_time' => $update_time
                ), array(
                    'calendar_id' => $calendar_id,
                    'user_id' => $user_id,
                    'type' => $type
                ));
            } else {
                $absdashboardDB->insert($absdashboardDB->absd_table->stats, array(
                    'calendar_id' => $calendar_id,
                    'user_id' => $user_id,
                    'type' => $type,
                    'data' => json_encode($data),
                    'last_update_time' => $update_time
                ));
            }
        }
    }
    
    /*
     *  Delete stat
     */ 
    function delete($user_id = 0,
                    $calendar_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->stats, array(
                'calendar_id' => $calendar_id,
                'user_id' => $user_id
            ));
        }
    }
    
    /*
     *  Delete stats
     */ 
    function delete_all() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $delete = $absdashboardDB->query("TRUNCATE TABLE `".$absdashboardDB->absd_table->stats."`");
        }
    }
    
    /*
     *  Delete stats
     */ 
    function delete_all_for($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->stats, array(
                'user_id' => $user_id
            ));
        }
    }
}