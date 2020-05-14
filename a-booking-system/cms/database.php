<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemDatabase {
  
    function __construct(){
    }
    
    /*
     *  Installation / Update CMS
     */ 
    function start() {
        global $ABookingSystem;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            global $wpdb;
            $absdashboardDB = $wpdb;
          
            $absdashboardDB->absd_table = new stdClass;
            
            foreach($ABookingSystem['database'] as $key => $table) {
              $absdashboardDB->absd_table->{str_replace('bmd_', '', $key)} = $wpdb->prefix.$key;
            }
        }
      
        // wpdb similar for:
        // -> get_row *
        // -> get_results *
        // -> num_rows *
        // -> prepare
        // -> delete
    }
    
    /*
     *  Installation / Update CMS
     */ 
    function installation($table) {
        global $ABookingSystem;
        global $absdashboardclasses;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            global $wpdb;
            $table_name = $wpdb->prefix.$table;

            if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
                $i = 0;
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                foreach($ABookingSystem['database'] as $key => $table) {
                    $sql_table[$i] = array();
                    $table_name = $wpdb->prefix.$key;

                    array_push($sql_table[$i], 'CREATE TABLE '.$table_name.' (');

                    foreach($table['fields'] as $table_fields) {
                        array_push($sql_table[$i], $table_fields['name'].' '.$table_fields['type'].($table_fields['size'] != -1 ? '('.$table_fields['size'].')':'').($table_fields['unsigned'] == true ? ' unsigned':'').($table_fields['default'] != '' ? ' DEFAULT "'.$table_fields['default'].'"':'').($table_fields['null'] != true ? ' NOT NULL':'').($table_fields['auto_increment'] == true ? ' AUTO_INCREMENT':'').',');
                    }

                    foreach($table['fields'] as $table_fields) {

                        if($table_fields['key'] == true) {
                           array_push($sql_table[$i], 'PRIMARY KEY ('.$table_fields['name'].')');
                        }
                    }

                    array_push($sql_table[$i], ') '.$charset_collate.';');
                    dbDelta(implode('', $sql_table[$i]));
                    $i++;
                }
            }
        }
    }
  
    function escape_array($arr){
        global $wpdb;
        $escaped = array();
        foreach($arr as $k => $v){
            if(is_numeric($v))
                $escaped[] = $wpdb->prepare('%d', $v);
            else
                $escaped[] = $wpdb->prepare('%s', $v);
        }
        return implode(',', $escaped);
    }
}