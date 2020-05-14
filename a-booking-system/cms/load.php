<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;
global $absdashboardclasses;
global $absdashboardDB;
global $absdashboardtext;
$absdashboardtext = array();
$absdashboardclasses = new stdClass;


/*
 *  Include CMS Files
 */ 
include_once 'http.php';
include_once 'protect.php';
include_once 'installation.php';  
include_once 'database.php';
include_once 'requests.php'; // Ajax Requests
include_once 'option.php';
include_once 'updates.php';
include_once 'calendar.php';
include_once 'listing.php';
include_once 'ticket.php';
include_once 'invoices.php';
include_once 'stats.php';
include_once 'withdraw.php';
include_once 'reply.php';

// Language
include_once 'language.php';  

include_once 'mymenu.php';    
include_once 'display.php';    
include_once 'resources.php';   
include_once 'api.php';
include_once 'main.php';
include_once 'extensions.php';


/*
 *  Start Extensions Main
 */ 

$absdashboardclasses->http         = class_exists('ABookingSystemHTTP') ? new ABookingSystemHTTP():'Class does not exist!';
$absdashboardclasses->protect      = class_exists('ABookingSystemProtect') ? new ABookingSystemProtect():'Class does not exist!';
$absdashboardclasses->installation = class_exists('ABookingSystemInstallation') ? new ABookingSystemInstallation():'Class does not exist!';
$absdashboardclasses->db           = class_exists('ABookingSystemDatabase') ? new ABookingSystemDatabase():'Class does not exist!';
$absdashboardclasses->option       = class_exists('ABookingSystemOption') ? new ABookingSystemOption():'Class does not exist!';
$absdashboardclasses->updates      = class_exists('ABookingSystemUpdates') ? new ABookingSystemUpdates():'Class does not exist!';
$absdashboardclasses->calendar     = class_exists('ABookingSystemCalendar') ? new ABookingSystemCalendar():'Class does not exist!';
$absdashboardclasses->listing      = class_exists('ABookingSystemListing') ? new ABookingSystemListing():'Class does not exist!';
$absdashboardclasses->ticket       = class_exists('ABookingSystemTicket') ? new ABookingSystemTicket():'Class does not exist!';
$absdashboardclasses->invoices     = class_exists('ABookingSystemInvoices') ? new ABookingSystemInvoices():'Class does not exist!';
$absdashboardclasses->stats        = class_exists('ABookingSystemStats') ? new ABookingSystemStats():'Class does not exist!';
$absdashboardclasses->withdraw     = class_exists('ABookingSystemWithdraw') ? new ABookingSystemWithdraw():'Class does not exist!';
$absdashboardclasses->reply        = class_exists('ABookingSystemReply') ? new ABookingSystemReply():'Class does not exist!';
$absdashboardclasses->language     = class_exists('ABookingSystemLanguage') ? new ABookingSystemLanguage():'Class does not exist!';
$absdashboardclasses->display      = class_exists('ABookingSystemDisplay') ? new ABookingSystemDisplay():'Class does not exist!';
$absdashboardclasses->menu         = class_exists('ABookingSystemMenu') ? new ABookingSystemMenu():'Class does not exist!';
$absdashboardclasses->resources    = class_exists('ABookingSystemResources') ? new ABookingSystemResources():'Class does not exist!';
$absdashboardclasses->api          = class_exists('ABookingSystemApi') ? new ABookingSystemApi():'Class does not exist!';
$absdashboardclasses->main         = class_exists('ABookingSystemMain') ? new ABookingSystemMain():'Class does not exist!';
$absdashboardclasses->extensions   = class_exists('ABookingSystemExtensions') ? new ABookingSystemExtensions():'Class does not exist!';

?>