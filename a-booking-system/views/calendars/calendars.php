<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;


// No Access
if($ABookingSystem['role'] == 'customer'
  || $ABookingSystem['role'] == 'guest') {
    $absdashboardclasses->display->view('no-access'); 
    exit;
}

?>
<h2>
  <?php echo $absdashboardtext['my_calendars']; ?>
</h2>
<div class="absd-button absd-add-calendar-btn absd-add-group">
  <?php echo $absdashboardtext['group']; ?>
</div>
<div class="absd-button absd-add-calendar-btn absd-add-calendar" data-group-id="0">
  <?php echo $absdashboardtext['calendar']; ?>
</div>