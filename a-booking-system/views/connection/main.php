<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;


// No Access
if($ABookingSystem['role'] != 'admin') {
    $absdashboardclasses->display->view('no-access'); 
    exit;
}

?>

<div class="absd-connection">
  <?php 
  
  if($ABookingSystem['page_disabled']) {
      $absdashboardclasses->display->view('connection/disconnected');
  } else {
      $absdashboardclasses->display->view('connection/connected');
  }
  
  ?>
</div>