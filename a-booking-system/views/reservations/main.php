<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;


// No Access
if($ABookingSystem['role'] == 'guest') {
    $absdashboardclasses->display->view('no-access'); 
    exit;
}

?>

<div class="absd-right-column absd-reservations">
  
  <div id="bdm-reservations"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        window.abookingsystemdashboardReservations.list();
    });
</script>