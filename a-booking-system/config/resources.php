<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;

//echo $wp_version; exit;

$ABookingSystem['resources'] = array();

/*
 * JAVASCRIPT
 */
$ABookingSystem['resources']['js'] = array();

/*
 * JAVASCRIPT LINKS
 */

/*
 * JAVASCRIPT FILES
 */

$ABookingSystem['resources']['js'][1] = array('name' => 'Booking Everything Unlimited - General Library',
                                                'file' => 'libs/js/general.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => '', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles
$ABookingSystem['resources']['js'][2] = array('name' => 'Booking Everything Unlimited - Form',
                                                'file' => 'js/form.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => '', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles
$ABookingSystem['resources']['js'][3] = array('name' => 'Booking Everything Unlimited - Popup',
                                                'file' => 'js/popup.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => '', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles
$ABookingSystem['resources']['js'][4] = array('name' => 'Booking Everything Unlimited - Connection',
                                                'file' => 'js/connection.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => 'connection', // set custom page or leave blank 
                                                'role' => 'admin'); // set admin, owner, guest, customer or leave blank for all roles
$ABookingSystem['resources']['js'][5] = array('name' => 'Booking Everything Unlimited - Calendars',
                                                'file' => 'js/calendars.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => 'calendars', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles
/*
 * Magnific Popup
 */
$ABookingSystem['resources']['js'][6] = array('name' => 'Magnific popup',
                                                'file' => 'libs/js/jquery.magnific-popup.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => '', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles
$ABookingSystem['resources']['js'][7] = array('name' => 'Momentjs',
                                                'file' => includes_url('js/dist/vendor/moment.min.js'), 
                                                'load' => 'link', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => '', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles
$ABookingSystem['resources']['js'][8] = array('name' => 'Fullcalendar',
                                                'file' => 'libs/js/fullcalendar.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => '', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles

$ABookingSystem['resources']['js'][9] = array('name' => 'Booking Everything Unlimited - Reservations',
                                                'file' => 'js/reservations.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => 'reservations', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles

$ABookingSystem['resources']['js'][10] = array('name' => 'Booking Everything Unlimited - Extensions',
                                                'file' => 'js/extensions.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => 'extensions', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles

$ABookingSystem['resources']['js'][11] = array('name' => 'Booking Everything Unlimited - Support',
                                                'file' => 'js/tickets.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => 'support', // set custom page or leave blank 
                                                'role' => 'owner'); // set admin, owner, guest, customer or leave blank for all roles

$ABookingSystem['resources']['js'][12] = array('name' => 'Booking Everything Unlimited - Account',
                                                'file' => 'js/account.js',
                                                'load' => 'file', // link, file
                                                'type' => 'both', // frontend, backend, both 
                                                'page' => 'account', // set custom page or leave blank 
                                                'role' => ''); // set admin, owner, guest, customer or leave blank for all roles

/*
 * Frontend Calendar
 */
$ABookingSystem['resources']['js'][13] = array('name' => 'Booking Everything Unlimited - GUP & Calendar',
                                        'file' => 'libs/js/calendar.min.js',
                                        'load' => 'file', // link, file
                                        'type' => 'both', // frontend, backend, both 
                                        'page' => '', // set custom page or leave blank 
                                        'role' => ''); // set admin, owner, guest, customer or leave blank for all roles



/*
 * CSS
 */
$ABookingSystem['resources']['css'] = array();

/*
 * CSS LINKS
 */

/*
 * CSS FILES
 */
$ABookingSystem['resources']['css'][0] = array('name' => 'Booking Everything Unlimited Dashboard',
                                                'file' => 'designs/'.$ABookingSystem['template'].'/'.$ABookingSystem['template'].'.design.css',
                                                'type' => 'both', // frontend, backend, both 
                                                'load' => 'file', // link, file
                                                'page' => ''); // set custom page or leave blank
$ABookingSystem['resources']['css'][1] = array('name' => 'Booking Everything Unlimited Calendar Vars',
                                                'file' => 'libs/css/calendar/calendar.vars.css',
                                                'type' => 'both', // frontend, backend, both 
                                                'load' => 'file', // link, file
                                                'page' => '',
                                                'hook_after' => 'aplusbooking_after_calendar_vars'); // set custom page or leave blank
$ABookingSystem['resources']['css'][2] = array('name' => 'Booking Everything Unlimited Calendar',
                                                'file' => 'libs/css/calendar/calendar.min.css',
                                                'type' => 'both', // frontend, backend, both 
                                                'load' => 'file', // link, file
                                                'page' => ''); // set custom page or leave blank
$ABookingSystem['resources']['css'][3] = array('name' => 'Magnific popup',
                                                'file' => 'libs/css/magnific-popup.css',
                                                'type' => 'both', // frontend, backend, both 
                                                'load' => 'file', // link, file
                                                'page' => ''); // set custom page or leave blank
$ABookingSystem['resources']['css'][4] = array('name' => 'Fullcalendar',
                                                'file' => 'libs/css/fullcalendar.css',
                                                'type' => 'both', // frontend, backend, both 
                                                'load' => 'file', // link, file
                                                'page' => ''); // set custom page or leave blank
$ABookingSystem['resources']['css'][5] = array('name' => 'jQuery UI',
                                                'file' => 'libs/css/jquery-ui.css',
                                                'type' => 'backend', // frontend, backend, both 
                                                'load' => 'file', // link, file
                                                'page' => ''); // set custom page or leave blank

