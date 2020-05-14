<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemTicket {
  
    function __construct(){
    }
    
    /*
     *  Get own tickets
     */ 
    function own($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $results = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT title, content, user_id, tid , api_key, status, answered, closed, last_reply_user FROM '.$absdashboardDB->absd_table->tickets.' where user_id = %d ORDER by id DESC', array($user_id)));
            
            return $results;
        }
    }
    
    /*
     *  Get ticket field
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
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->tickets.' where api_key = %s AND user_id = %d', array($api_key, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $value = $row->{$name};
            }
            
            return $value;
        }
    }
    
    /*
     *  Get ticket data by field & value
     */ 
    function get_data($field,
                      $value) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->tickets.' where '.$field.' = %s', array($value)));
            
            return $row;
        }
    }
    
    /*
     *  Get ticket data
     */ 
    function get_ticket($ticket_id,
                        $api_key) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->tickets.' where tid = %d AND api_key = %s', array($ticket_id, $api_key)));
            
            return $row;
        }
    }
  
    function save_data($tickets,
                       $user_id){
      global $absdashboardclasses;
      $tickets = json_decode($tickets);
      
      // Save tickets
      foreach($tickets as $ticket) {
        $this->add($ticket->title,
                   $ticket->content,
                   $user_id,
                   $ticket->username,
                   $ticket->id,
                   $ticket->api_key,
                   $ticket->status,
                   $ticket->answered,
                   $ticket->closed,
                   $ticket->last_reply_user,
                   '0000-00-00 00:00:00',
                   'true');
      }
    }
    
    /*
     *  Get ticket field
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
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->tickets.' where '.$field.' = %s AND user_id = %d', array($value, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $return = true;
            }
            
            return $return;
        }
    }
    
    /*
     *  Add ticket
     */ 
    function add($title,
                 $content,
                 $user_id = 0,
                 $username = '',
                 $tid = 0,
                 $api_key = '',
                 $status = 'unsolved',
                 $answered = 'false',
                 $closed = 'false',
                 $last_reply_user = '',
                 $update_time = '0000-00-00 00:00:00',
                 $update = 'false') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $update_time = date('Y-m-d H:i:s');
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->tickets.' where tid = %d AND user_id = %d', array($tid, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->tickets, array(
                    'title' => $title,
                    'content' => $content,
                    'username' => $username,
                    'api_key' => $api_key,
                    'status' => $status,
                    'answered' => $answered,
                    'closed' => $closed,
                    'last_reply_user' => $last_reply_user,
                    'last_update_time' => $update_time
                ), array(
                    'tid' => $tid,
                    'user_id' => $user_id
                ));
            } else {
                $absdashboardDB->insert($absdashboardDB->absd_table->tickets, array(
                    'title' => $title,
                    'content' => $content,
                    'username' => $username,
                    'api_key' => $api_key,
                    'status' => $status,
                    'answered' => $answered,
                    'closed' => $closed,
                    'last_reply_user' => $last_reply_user,
                    'tid' => $tid,
                    'user_id' => $user_id,
                    'last_update_time' => $update_time,
                    'created_time' => $update_time
                ));
            }
            
            if($update == 'false') {
              // Save update date
              $absdashboardclasses->updates->add('tickets',
                                        '',
                                        $user_id,
                                        $update_time);
            }
        }
    }
    
    /*
     *  Delete ticket
     */ 
    function delete($tid,
                    $user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->tickets, array(
                'tid' => $tid,
                'user_id' => $user_id
            ));
        }
    }
    
    /*
     *  Delete tickets
     */ 
    function delete_all() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $delete = $absdashboardDB->query("TRUNCATE TABLE `".$absdashboardDB->absd_table->tickets."`");
        }
    }
    
    /*
     *  Delete tickets
     */ 
    function delete_all_for($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->tickets, array(
                'user_id' => $user_id
            ));
        }
    }
}