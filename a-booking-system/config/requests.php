<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;

$ABookingSystem['requests'] = array();

/*
 * Requests
 */
$ABookingSystem['requests'][0] = array('name' => 'connect',
                                       'function' => 'connect',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][1] = array('name' => 'disconnect',
                                       'function' => 'disconnect',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][2] = array('name' => 'calendars',
                                       'function' => 'calendars',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][3] = array('name' => 'add_calendars',
                                       'function' => 'add_calendars',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][4] = array('name' => 'calendar_settings',
                                       'function' => 'calendar_settings',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][5] = array('name' => 'delete_calendar',
                                       'function' => 'delete_calendar',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][6] = array('name' => 'calendar_settings_save',
                                       'function' => 'calendar_settings_save',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][7] = array('name' => 'reservations',
                                       'function' => 'reservations',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][8] = array('name' => 'tickets',
                                       'function' => 'tickets',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][9] = array('name' => 'add_ticket',
                                       'function' => 'add_ticket',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][10] = array('name' => 'delete_ticket',
                                       'function' => 'delete_ticket',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][11] = array('name' => 'change_ticket',
                                       'function' => 'change_ticket',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][12] = array('name' => 'ticket',
                                       'function' => 'ticket',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][13] = array('name' => 'add_reply',
                                       'function' => 'add_reply',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][14] = array('name' => 'delete_reply',
                                       'function' => 'delete_reply',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][15] = array('name' => 'save_customer', 
                                        'function' => 'save_customer',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][16] = array('name' => 'withdraws',
                                       'function' => 'withdraws',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][17] = array('name' => 'add_withdraw',
                                       'function' => 'add_withdraw',
                                       'class' => 'main',
                                       'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][18] = array('name' => 'add_reservation',
                                        'function' => 'add_reservation',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][19] = array('name' => 'cancel_reservation_by_host',
                                        'function' => 'cancel_reservation_by_host',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][20] = array('name' => 'more_invoices',
                                        'function' => 'more_invoices',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][21] = array('name' => 'more_replies',
                                        'function' => 'more_replies',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][20] = array('name' => 'download_invoice',
                                        'function' => 'download_invoice',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][21] = array('name' => 'register',
                                        'function' => 'register',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][22] = array('name' => 'detect_country',
                                        'function' => 'detect_country',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][23] = array('name' => 'extensions',
                                        'function' => 'extensions',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][24] = array('name' => 'install_extension',
                                        'function' => 'install_extension',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][25] = array('name' => 'activate_extension',
                                        'function' => 'activate_extension',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend

$ABookingSystem['requests'][26] = array('name' => 'deactivate_extension',
                                        'function' => 'deactivate_extension',
                                        'class' => 'main',
                                        'type' => 'both'); // frontend / backend
