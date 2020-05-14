<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemInvoices {
  
    function __construct(){
    }
    
    /*
     *  Get own invoices
     */ 
    function own($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $results = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->invoices.' where user_id =%d ORDER by id DESC', array($user_id)));
            
            return $results;
        }
    }
  
    function save_data($invoices,
                       $user_id = 0){
        global $absdashboardclasses;
      
        // Save invoices
        foreach($invoices as $invoice) {
            
            // Save invoices
            $this->add($user_id,
                       $invoice->to_user_id,
                       $invoice->id,
                       $invoice->invoice_id,
                       $invoice->reservation_id,
                       $invoice->amount,
                       $invoice->amount_percent,
                       $invoice->vat,
                       $invoice->vat_percent,
                       $invoice->description,
                       $invoice->type,
                       $invoice->transaction_id,
                       $invoice->created_date);
        }
    }
    
    /*
     *  Add invoice
     */ 
    function add($user_id = 0,
                 $to_user_id = 0,
                 $invoice_id = 0,
                 $parent_invoice_id = 0,
                 $reservation_id = 0,
                 $amount = 0,
                 $amount_percent = 0,
                 $vat = 0,
                 $vat_percent = 0,
                 $description = '',
                 $type = 'reservation',
                 $transaction_id = '',
                 $created_date = '0000-00-00') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->invoices.' where user_id = %d AND invoice_id = %d', array($user_id, $invoice_id)));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->invoices, array(
                    'parent_invoice_id' => $parent_invoice_id,
                    'reservation_id' => $reservation_id,
                    'amount' => $amount,
                    'amount_percent' => $amount_percent,
                    'vat' => $vat,
                    'vat_percent' => $vat_percent,
                    'description' => $description,
                    'type' => $type,
                    'transaction_id' => $transaction_id,
                    'created' => $created_date
                ), array(
                    'user_id' => $user_id,
                    'invoice_id' => $invoice_id
                ));
            } else {
                $absdashboardDB->insert($absdashboardDB->absd_table->invoices, array(
                    'invoice_id' => $invoice_id,
                    'user_id' => $user_id,
                    'to_user_id' => $to_user_id,
                    'parent_invoice_id' => $parent_invoice_id,
                    'reservation_id' => $reservation_id,
                    'amount' => $amount,
                    'amount_percent' => $amount_percent,
                    'vat' => $vat,
                    'vat_percent' => $vat_percent,
                    'description' => $description,
                    'type' => $type,
                    'transaction_id' => $transaction_id,
                    'created' => $created_date
                ));
            }
        }
    }
    
    /*
     *  Delete invoice
     */ 
    function delete($user_id = 0,
                    $invoice_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->invoices, array(
                'invoice_id' => $invoice_id,
                'user_id' => $user_id
            ));
        }
    }
    
    /*
     *  Delete invoices
     */ 
    function delete_all() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $delete = $absdashboardDB->query("TRUNCATE TABLE `".$absdashboardDB->absd_table->invoices."`");
        }
    }
    
    /*
     *  Delete invoices
     */ 
    function delete_all_for($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->invoices, array(
                'user_id' => $user_id
            ));
        }
    }
}