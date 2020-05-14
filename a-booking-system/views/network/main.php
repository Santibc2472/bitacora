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

<div id="absd-network-content" class="absd-right-column absd-network">
    <div id="absd-network-content-box" class="absd-content-settings">
        <div class="absd-content-settings-box"></div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        window.abookingsystemdashboardNetwork.start();
    });
</script>