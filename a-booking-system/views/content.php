<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;

?>

<div class="absd-content">
    <?php $absdashboardclasses->display->view($ABookingSystem['page'].'/main'); ?>
</div>