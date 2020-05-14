<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemOption {
  
    function __construct(){
    }
    
    /*
     *  Get option
     */ 
    function get($name = '',
                 $user_id = 0,
                 $type = 'all') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = %s AND user_id = %d', array($name, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $value = $row->option_value;
            }
            
            return $value;
        }
    }
    
    /*
     *  Get option by type
     */ 
    function get_by_type($type = 'main',
                         $show = true) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $rows = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_type = %s', array($type)));
            $options = new stdClass;
            
            if($absdashboardDB->num_rows > 0) {
              
                foreach($rows as $row) {
                    
                  if($show) {
                    $options->{$row->{'option_name'}} = $row->{'option_value'};
                  } else {
                      
                      if($row->{'option_name'} != 'network_token'
                         && $row->{'option_name'} != 'use_stripe'
                         && $row->{'option_name'} != 'stripe_secret_key'
                         && $row->{'option_name'} != 'stripe_publishable_key'
                         && $row->{'option_name'} != 'use_test_stripe'
                         && $row->{'option_name'} != 'stripe_test_secret_key'
                         && $row->{'option_name'} != 'stripe_test_publishable_key') {
                        $options->{$row->{'option_name'}} = $row->{'option_value'};
                      }
                  }
                }
            }
            
            return $options;
        }
    }
    
    /*
     *  Add option
     */ 
    function add($name,
                 $value,
                 $user_id = 0,
                 $type = 'main') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = %s AND  option_type = %s AND user_id = %d', array($name, $type, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->options, array(
                    'option_value' => $value,
                    'option_date' => date('Y-m-d H:i:s')
                ), array(
                    'option_name' => $name,
                    'user_id' => $user_id,
                    'option_type' => $type
                ));
            } else {
                
                if($value != null) {
                    $absdashboardDB->insert($absdashboardDB->absd_table->options, array(
                        'option_name' => $name,
                        'option_value' => $value,
                        'user_id' => $user_id,
                        'option_type' => $type,
                        'option_date' => date('Y-m-d H:i:s')
                    ));
                }
            }
            
            return $value;
        }
    }
    
    /*
     *  Append option
     */ 
    function append($name,
                    $value,
                    $user_id = 0,
                    $type = 'main') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = %s AND  option_type = %s AND user_id = %d', array($name, $type, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $old_value = $row->option_value;
                $new_value = intval($old_value)+intval($value);
                $absdashboardDB->update($absdashboardDB->absd_table->options, array(
                    'option_value' => $new_value,
                    'option_date' => date('Y-m-d H:i:s')
                ), array(
                    'option_name' => $name,
                    'user_id' => $user_id,
                    'option_type' => $type
                ));
            } else {
                $absdashboardDB->insert($absdashboardDB->absd_table->options, array(
                    'option_name' => $name,
                    'option_value' => $value,
                    'user_id' => $user_id,
                    'option_type' => $type,
                    'option_date' => date('Y-m-d H:i:s')
                ));
            }
            
            return $value;
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