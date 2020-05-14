<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemUpdates {
  
    function __construct(){
    }
    
    /*
     *  Get option
     */ 
    function get($name,
                 $value,
                 $user_id = 0) {
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $db_last_update = '0000-00-00 00:00:00';
        $update = 'false';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = %s AND option_value = %s AND option_type = "update"', array($name, $value)));
            
            if($absdashboardDB->num_rows > 0) {
                $db_last_update = $row->option_date;
            }
              
            // Token
            $token = $absdashboardclasses->option->get('token', 
                                              $user_id);
			
            // Server
            $server = $absdashboardclasses->option->get('server',
                                               $ABookingSystem['user_id']);

            if(isset($server) 
               && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
            }
          
            $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                             "updates",
                                             ['name' => $name,
                                              'value' => $value,
                                              'last_update' => $db_last_update],
                                             ['token' => $token]);
          
            if($result->code == 200 
                || $result->code == 201) {
                $update = $result->response;
            }
            
            return $update;
        }
    }
    
    /*
     *  Add update
     */ 
    function add($name,
                 $value,
                 $user_id = 0,
                 $update_time = '') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = "'.$name.'" AND option_value = %s AND option_type = "update" AND user_id = %d', array($value, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->options, array(
                    'option_date' => $update_time
                ), array(
                    'option_name' => $name,
                    'option_value' => $value,
                    'option_type' => 'update',
                    'option_date' => $update_time == '' ? date('Y-m-d H:i:s'):$update_time,
                    'user_id' => $user_id
                ));
            } else {
                $absdashboardDB->insert($absdashboardDB->absd_table->options, array(
                    'option_name' => $name,
                    'option_value' => $value,
                    'option_type' => 'update',
                    'option_date' => $update_time == '' ? date('Y-m-d H:i:s'):$update_time,
                    'user_id' => $user_id
                ));
            }
            
            return $update_time;
        }
    }
    
    /*
     *  Delete option
     */ 
    function delete($name,
                    $user_id = 0,
                    $type = 'all') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->options, array(
                'option_name' => $name,
                'user_id' => $user_id
            ));
        }
    }
    
    /*
     *  Delete all options
     */ 
    function delete_all() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $delete = $absdashboardDB->query("TRUNCATE TABLE `".$absdashboardDB->absd_table->options."`");
        }
    }
}