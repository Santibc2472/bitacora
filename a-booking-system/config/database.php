<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;

$ABookingSystem['database'] = array();

/*
 * Options
 */
$ABookingSystem['database']['bmd_options'] = array();
$ABookingSystem['database']['bmd_options']['fields'] = array();

$ABookingSystem['database']['bmd_options']['fields'][0] = array('name' => 'id',
                                                        'type' => 'bigint',
                                                        'size' => 20, // -1 infinit
                                                        'unsigned' => true, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => true, // AUTO_INCREMENT
                                                        'key' => true); 

$ABookingSystem['database']['bmd_options']['fields'][1] = array('name' => 'user_id',
                                                        'type' => 'bigint',
                                                        'size' => 20, // -1 infinit
                                                        'unsigned' => true, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => 0,
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_options']['fields'][2] = array('name' => 'version',
                                                        'type' => 'varchar',
                                                        'size' => 12, // -1 infinit
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '1.0',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_options']['fields'][3] = array('name' => 'option_name',
                                                        'type' => 'varchar',
                                                        'size' =>  256, // -1 infinit
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_options']['fields'][4] = array('name' => 'option_value',
                                                        'type' => 'longtext',
                                                        'size' =>  -1, // -1 infinit
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_options']['fields'][5] = array('name' => 'option_type',
                                                        'type' => 'varchar',
                                                        'size' =>  32, // -1 infinit
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => 'main',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_options']['fields'][6] = array('name' => 'option_date',
                                                        'type' => 'datetime',
                                                        'size' => -1, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '0000-00-00 00:00:00',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

/*
 * Calendars
 */
$ABookingSystem['database']['bmd_calendars'] = array();

$ABookingSystem['database']['bmd_calendars']['fields'][0] = array('name' => 'id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => true, // AUTO_INCREMENT
                                                          'key' => true); 

$ABookingSystem['database']['bmd_calendars']['fields'][1] = array('name' => 'name',
                                                          'type' => 'varchar',
                                                          'size' => 256, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][2] = array('name' => 'group_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, 
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][3] = array('name' => 'is_group',
                                                          'type' => 'varchar',
                                                          'size' => 6, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 'false',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][4] = array('name' => 'user_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][5] = array('name' => 'wp_user_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][6] = array('name' => 'post_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][7] = array('name' => 'cid',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][8] = array('name' => 'api_key',
                                                          'type' => 'varchar',
                                                          'size' => 256, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][9] = array('name' => 'approved',
                                                          'type' => 'varchar',
                                                          'size' => 16, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 'false',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][10] = array('name' => 'entire',
                                                          'type' => 'varchar',
                                                          'size' => 16, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 'false',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][11] = array('name' => 'rejected_reason',
                                                          'type' => 'varchar',
                                                          'size' => 512, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][12] = array('name' => 'last_update_time',
                                                          'type' => 'datetime',
                                                          'size' => -1, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '0000-00-00 00:00:00',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_calendars']['fields'][13] = array('name' => 'created_time',
                                                          'type' => 'datetime',
                                                          'size' => -1, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '0000-00-00 00:00:00',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

/*
 * Tickets
 */
$ABookingSystem['database']['bmd_tickets'] = array();

$ABookingSystem['database']['bmd_tickets']['fields'][0] = array('name' => 'id',
                                                        'type' => 'bigint',
                                                        'size' => 20, // -1 infinit
                                                        'unsigned' => true, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => true, // AUTO_INCREMENT
                                                        'key' => true); 

$ABookingSystem['database']['bmd_tickets']['fields'][1] = array('name' => 'title',
                                                        'type' => 'varchar',
                                                        'size' => 256, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][2] = array('name' => 'content',
                                                        'type' => 'longtext',
                                                        'size' => -1, // -1 infinit
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][3] = array('name' => 'user_id',
                                                        'type' => 'bigint',
                                                        'size' => 20, // -1 infinit
                                                        'unsigned' => true, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => 0,
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][4] = array('name' => 'username',
                                                        'type' => 'varchar',
                                                        'size' => 256, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][5] = array('name' => 'tid',
                                                        'type' => 'bigint',
                                                        'size' => 20, // -1 infinit
                                                        'unsigned' => true, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => 0,
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][6] = array('name' => 'api_key',
                                                        'type' => 'varchar',
                                                        'size' => 256, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][7] = array('name' => 'status',
                                                        'type' => 'varchar',
                                                        'size' => 32, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][8] = array('name' => 'replies',
                                                        'type' => 'longtext',
                                                        'size' =>  -1, // -1 infinit
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][9] = array('name' => 'answered',
                                                        'type' => 'varchar',
                                                        'size' => 6, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][10] = array('name' => 'closed',
                                                        'type' => 'varchar',
                                                        'size' => 6, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][11] = array('name' => 'last_reply_user',
                                                        'type' => 'varchar',
                                                        'size' => 256, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][12] = array('name' => 'last_update_time',
                                                        'type' => 'datetime',
                                                        'size' => -1, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false, // NOT NULL
                                                        'default' => '0000-00-00 00:00:00',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_tickets']['fields'][13] = array('name' => 'created_time',
                                                        'type' => 'datetime',
                                                        'size' => -1, 
                                                        'unsigned' => false, // UNSIGNED
                                                        'null' => false,  // NOT NULL
                                                        'default' => '0000-00-00 00:00:00',
                                                        'auto_increment' => false, 
                                                        'key' => false); // AUTO_INCREMENT

/*
 * Withdraws
 */
$ABookingSystem['database']['bmd_withdraws'] = array();

$ABookingSystem['database']['bmd_withdraws']['fields'][0] = array('name' => 'id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => true, // AUTO_INCREMENT
                                                          'key' => true); 

$ABookingSystem['database']['bmd_withdraws']['fields'][1] = array('name' => 'wid',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][2] = array('name' => 'to_uid',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][3] = array('name' => 'from_uid',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][4] = array('name' => 'user_id', 
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][5] = array('name' => 'api_key',
                                                          'type' => 'varchar',
                                                          'size' => 256, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][6] = array('name' => 'description',
                                                          'type' => 'longtext',
                                                          'size' =>  -1, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][7] = array('name' => 'owner_description',
                                                          'type' => 'longtext',
                                                          'size' =>  -1, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][8] = array('name' => 'invoices',
                                                          'type' => 'varchar',
                                                          'size' => 256, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][9] = array('name' => 'amount',
                                                          'type' => 'varchar',
                                                          'size' => 32, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][10] = array('name' => 'currency',
                                                           'type' => 'varchar',
                                                           'size' => 6, 
                                                           'unsigned' => false, // UNSIGNED
                                                           'null' => false, // NOT NULL
                                                           'default' => 'USD',
                                                           'auto_increment' => false, 
                                                           'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][11] = array('name' => 'sign',
                                                           'type' => 'varchar',
                                                           'size' => 32, 
                                                           'unsigned' => false, // UNSIGNED
                                                           'null' => false, // NOT NULL
                                                           'default' => '$',
                                                           'auto_increment' => false, 
                                                           'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][12] = array('name' => 'payout',
                                                          'type' => 'varchar',
                                                          'size' => 256, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][13] = array('name' => 'status',
                                                           'type' => 'varchar',
                                                           'size' => 32, 
                                                           'unsigned' => false, // UNSIGNED
                                                           'null' => false, // NOT NULL
                                                           'default' => 'unpaid',
                                                           'auto_increment' => false, 
                                                           'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][14] = array('name' => 'type',
                                                           'type' => 'varchar',
                                                           'size' => 32, 
                                                           'unsigned' => false, // UNSIGNED
                                                           'null' => false, // NOT NULL
                                                           'default' => 'reservation',
                                                           'auto_increment' => false, 
                                                           'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][15] = array('name' => 'pay_date',
                                                           'type' => 'date',
                                                           'size' => -1, 
                                                           'unsigned' => false, // UNSIGNED
                                                           'null' => false, // NOT NULL
                                                           'default' => '0000-00-00',
                                                           'auto_increment' => false, 
                                                           'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][16] = array('name' => 'reason',
                                                          'type' => 'varchar',
                                                          'size' => 512, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][17] = array('name' => 'last_update_time',
                                                           'type' => 'datetime',
                                                           'size' => -1, 
                                                           'unsigned' => false, // UNSIGNED
                                                           'null' => false, // NOT NULL
                                                           'default' => '0000-00-00 00:00:00',
                                                           'auto_increment' => false, 
                                                           'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_withdraws']['fields'][18] = array('name' => 'created',
                                                           'type' => 'datetime',
                                                           'size' => -1, 
                                                           'unsigned' => false, // UNSIGNED
                                                           'null' => false,  // NOT NULL
                                                           'default' => '0000-00-00 00:00:00',
                                                           'auto_increment' => false, 
                                                           'key' => false); // AUTO_INCREMENT


/*
 * Stats
 */


/*
 * Options
 */
$ABookingSystem['database']['bmd_stats'] = array();
$ABookingSystem['database']['bmd_stats']['fields'] = array();

$ABookingSystem['database']['bmd_stats']['fields'][0] = array('name' => 'id',
                                                      'type' => 'bigint',
                                                      'size' => 20, // -1 infinit
                                                      'unsigned' => true, // UNSIGNED
                                                      'null' => false, // NOT NULL
                                                      'default' => '',
                                                      'auto_increment' => true, // AUTO_INCREMENT
                                                      'key' => true); 

$ABookingSystem['database']['bmd_stats']['fields'][1] = array('name' => 'user_id',
                                                      'type' => 'bigint',
                                                      'size' => 20, // -1 infinit
                                                      'unsigned' => true, // UNSIGNED
                                                      'null' => false, // NOT NULL
                                                      'default' => 0,
                                                      'auto_increment' => false, 
                                                      'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_stats']['fields'][2] = array('name' => 'calendar_id',
                                                      'type' => 'bigint',
                                                      'size' => 20, // -1 infinit
                                                      'unsigned' => true, // UNSIGNED
                                                      'null' => false, // NOT NULL
                                                      'default' => 0,
                                                      'auto_increment' => false, 
                                                      'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_stats']['fields'][3] = array('name' => 'data',
                                                      'type' => 'longtext',
                                                      'size' =>  -1, // -1 infinit
                                                      'unsigned' => false, // UNSIGNED
                                                      'null' => false, // NOT NULL
                                                      'default' => '',
                                                      'auto_increment' => false, 
                                                      'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_stats']['fields'][4] = array('name' => 'type',
                                                      'type' => 'varchar',
                                                      'size' =>  32, // -1 infinit
                                                      'unsigned' => false, // UNSIGNED
                                                      'null' => false, // NOT NULL
                                                      'default' => 'users',
                                                      'auto_increment' => false, 
                                                      'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_stats']['fields'][5] = array('name' => 'last_update_time',
                                                      'type' => 'datetime',
                                                      'size' => -1, 
                                                      'unsigned' => false, // UNSIGNED
                                                      'null' => false, // NOT NULL
                                                      'default' => '0000-00-00 00:00:00',
                                                      'auto_increment' => false, 
                                                      'key' => false); // AUTO_INCREMENT


/*
 * Invoices
 */


/*
 * Options
 */
$ABookingSystem['database']['bmd_invoices'] = array();
$ABookingSystem['database']['bmd_invoices']['fields'] = array();

$ABookingSystem['database']['bmd_invoices']['fields'][0] = array('name' => 'id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => true, // AUTO_INCREMENT
                                                          'key' => true); 

$ABookingSystem['database']['bmd_invoices']['fields'][1] = array('name' => 'user_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][2] = array('name' => 'to_user_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][3] = array('name' => 'invoice_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][4] = array('name' => 'parent_invoice_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][5] = array('name' => 'reservation_id',
                                                          'type' => 'bigint',
                                                          'size' => 20, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][6] = array('name' => 'amount',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][7] = array('name' => 'amount_percent',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][8] = array('name' => 'vat',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][9] = array('name' => 'vat_percent',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][10] = array('name' => 'description',
                                                          'type' => 'longtext',
                                                          'size' =>  -1, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][11] = array('name' => 'type',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 'reservation',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][12] = array('name' => 'transaction_id',
                                                          'type' => 'varchar',
                                                          'size' =>  128, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_invoices']['fields'][13] = array('name' => 'created',
                                                          'type' => 'date',
                                                          'size' => -1, 
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '0000-00-00',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

/*
 * Listings
 */
$ABookingSystem['database']['bmd_listings'] = array();
$ABookingSystem['database']['bmd_listings']['fields'] = array();

$ABookingSystem['database']['bmd_listings']['fields'][0] = array('name' => 'id',
                                                         'type' => 'bigint',
                                                         'size' => 20, // -1 infinit
                                                         'unsigned' => true, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => true, // AUTO_INCREMENT
                                                         'key' => true); 

$ABookingSystem['database']['bmd_listings']['fields'][1] = array('name' => 'user_id',
                                                         'type' => 'bigint',
                                                         'size' => 20, // -1 infinit
                                                         'unsigned' => true, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => 0,
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][2] = array('name' => 'calendar_id',
                                                         'type' => 'bigint',
                                                         'size' => 20, // -1 infinit
                                                         'unsigned' => true, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => 0,
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][3] = array('name' => 'post_id',
                                                         'type' => 'bigint',
                                                         'size' => 20, // -1 infinit
                                                         'unsigned' => true, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => 0,
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][4] = array('name' => 'api_key',
                                                         'type' => 'varchar',
                                                         'size' =>  256, // -1 infinit
                                                         'unsigned' => false, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][5] = array('name' => 'cover',
                                                         'type' => 'varchar',
                                                         'size' =>  256, // -1 infinit
                                                         'unsigned' => false, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][6] = array('name' => 'title',
                                                         'type' => 'varchar',
                                                         'size' =>  256, // -1 infinit
                                                         'unsigned' => false, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][7] = array('name' => 'description',
                                                         'type' => 'varchar',
                                                         'size' =>  256, // -1 infinit
                                                         'unsigned' => false, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][8] = array('name' => 'filters',
                                                         'type' => 'varchar',
                                                         'size' =>  256, // -1 infinit
                                                         'unsigned' => false, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][9] = array('name' => 'location_name',
                                                         'type' => 'varchar',
                                                         'size' =>  256, // -1 infinit
                                                         'unsigned' => false, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][10] = array('name' => 'location_lat',
                                                         'type' => 'varchar',
                                                         'size' =>  32, // -1 infinit
                                                         'unsigned' => false, // UNSIGNED
                                                         'null' => false, // NOT NULL
                                                         'default' => '',
                                                         'auto_increment' => false, 
                                                         'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][11] = array('name' => 'location_lng',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][12] = array('name' => 'location_country',
                                                          'type' => 'varchar',
                                                          'size' =>  16, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][13] = array('name' => 'location_country_long',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][14] = array('name' => 'location_state',
                                                          'type' => 'varchar',
                                                          'size' =>  16, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][15] = array('name' => 'location_state_long',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][16] = array('name' => 'location_city',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][17] = array('name' => 'location_city_long',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][18] = array('name' => 'location_street',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][19] = array('name' => 'location_street_no',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][20] = array('name' => 'location_postal_code',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][21] = array('name' => 'address',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][22] = array('name' => 'used_for',
                                                          'type' => 'varchar',
                                                          'size' =>  32, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][23] = array('name' => 'category',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][24] = array('name' => 'cancellation',
                                                          'type' => 'int',
                                                          'size' => 6, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][25] = array('name' => 'refund',
                                                          'type' => 'int',
                                                          'size' => 4, // -1 infinit
                                                          'unsigned' => true, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => 0,
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][26] = array('name' => 'rules',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT

$ABookingSystem['database']['bmd_listings']['fields'][27] = array('name' => 'server',
                                                          'type' => 'varchar',
                                                          'size' =>  256, // -1 infinit
                                                          'unsigned' => false, // UNSIGNED
                                                          'null' => false, // NOT NULL
                                                          'default' => '',
                                                          'auto_increment' => false, 
                                                          'key' => false); // AUTO_INCREMENT
