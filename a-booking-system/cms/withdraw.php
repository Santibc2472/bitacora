<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemWithdraw {
  
    function __construct(){
    }
    
    /*
     *  Get own withdraws
     */ 
    function own($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $results = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT wid, api_key, to_uid, from_uid, user_id, description, owner_description, invoices, amount , currency, sign, payout, status, type, pay_date, reason FROM '.$absdashboardDB->absd_table->withdraws.' where user_id = %d ORDER by wid DESC', array($user_id)));
            
            return $results;
        }
    }
    
    /*
     *  Get withdraw field
     */ 
    function get($name,
                 $wid,
                 $api_key = '') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->withdraws.' where wid = %d AND api_key = %s', array($wid, $api_key)));
            
            if($absdashboardDB->num_rows > 0) {
                $value = $row->{$name};
            }
            
            return $value;
        }
    }
    
    /*
     *  Get withdraw data by field & value
     */ 
    function get_data($field,
                      $value) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->withdraws.' where '.$field.' = %s', array($value)));
            
            return $row;
        }
    }
    
    /*
     *  Get withdraw data
     */ 
    function get_withdraw($withdraw_id,
                          $api_key) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->withdraws.' where wid = %d AND api_key = %s', array($withdraw_id, $api_key)));
            
            return $row;
        }
    }
  
    function save_data($data,
                       $user_id = 0){
      global $absdashboardclasses;
      $data = json_decode($data);
      $withdraws = $data->withdraws;
      $stats = $data->stats;
      $invoices = isset($data->invoices) ? $data->invoices:new stdClass;
      $currency = $data->currency;
        
      // Save withdraws
      foreach($withdraws as $withdraw) {
        $this->add($withdraw->id,
                   $user_id,
                   $withdraw->api_key,
                   $withdraw->to_uid,
                   $withdraw->from_uid,
                   $withdraw->description,
                   $withdraw->owner_description,
                   $withdraw->invoices,
                   $withdraw->amount,
                   $withdraw->currency,
                   $absdashboardclasses->main->sign($withdraw->currency),
                   $withdraw->status,
                   $withdraw->type,
                   $withdraw->reason,
                   $withdraw->pay_date,
                   $withdraw->payout,
                   '0000-00-00 00:00:00',
                   'true');
      }
      
      // Save invoices
      $absdashboardclasses->invoices->save_data($invoices,
                                       $user_id);
      
      // Save stats
      $absdashboardclasses->stats->add($stats,
                              $user_id,
                              0,
                              'users',
                              '0000-00-00 00:00:00',
                              'true');
      
      // Save currency
      $absdashboardclasses->option->add('currency',
                               $currency,
                               $user_id);
    }
    
    /*
     *  Get withdraw field
     */ 
    function exist($field,
                   $value,
                   $api_key = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $return = false;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->withdraws.' where '.$field.' = %s AND api_key = %s', array($value, $api_key)));
            
            if($absdashboardDB->num_rows > 0) {
                $return = true;
            }
            
            return $return;
        }
    }
    
    /*
     *  Add withdraw
     */ 
    function add($wid = 0,
                 $user_id = 0,
                 $api_key = '',
                 $to_uid = 0,
                 $from_uid = 0,
                 $description = '',
                 $owner_description = '',
                 $invoices = '',
                 $amount = 0,
                 $currency = 'USD',
                 $sign = '$',
                 $status = 'unpaid',
                 $type = 'reservation',
                 $reason= '',
                 $pay_date = '0000-00-00',
                 $payout = '',
                 $update_time = '0000-00-00 00:00:00',
                 $update = 'false') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $update_time = date('Y-m-d H:i:s');
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->withdraws.' where wid = %d AND user_id = %d', array($wid, $user_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->withdraws, array(
                    'to_uid' => $to_uid,
                    'from_uid' => $from_uid,
                    'description' => $description,
                    'owner_description' => $owner_description,
                    'invoices' => $invoices,
                    'amount' => $amount,
                    'currency' => $currency,
                    'sign' => $sign,
                    'status' => $status,
                    'type' => $type,
                    'reason' => $reason,
                    'pay_date' => $pay_date,
                    'payout' => $payout,
                    'last_update_time' => $update_time
                ), array(
                    'wid' => $wid,
                    'api_key' => $api_key
                ));
            } else {
                $absdashboardDB->insert($absdashboardDB->absd_table->withdraws, array(
                    'wid' => $wid,
                    'user_id' => $user_id,
                    'api_key' => $api_key,
                    'to_uid' => $to_uid,
                    'from_uid' => $from_uid,
                    'description' => $description,
                    'owner_description' => $owner_description,
                    'invoices' => $invoices,
                    'amount' => $amount,
                    'currency' => $currency,
                    'sign' => $sign,
                    'status' => $status,
                    'type' => $type,
                    'reason' => $reason,
                    'pay_date' => $pay_date,
                    'payout' => $payout,
                    'last_update_time' => $update_time,
                    'created' => $update_time
                ));
            }
            
            if($update == 'false') {
              // Save update date
              $absdashboardclasses->updates->add('withdraws_or_stats',
                                        '',
                                        $user_id,
                                        $update_time);
            }
        }
    }
    
    /*
     *  Delete withdraw
     */ 
    function delete($wid,
                    $api_key = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->withdraws, array(
                'wid' => $wid,
                'api_key' => $api_key
            ));
        }
    }
    
    /*
     *  Delete withdraws
     */ 
    function delete_all() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $delete = $absdashboardDB->query("TRUNCATE TABLE `".$absdashboardDB->absd_table->withdraws."`");
        }
    }
    
    /*
     *  Delete withdraws
     */ 
    function delete_all_for($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->withdraws, array(
                'user_id' => $user_id
            ));
        }
    }
}