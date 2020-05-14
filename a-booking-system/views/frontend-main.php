<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;

?>
<div id="absd-wrapper">
    
    <div class="absd-content-box">
        <?php $absdashboardclasses->display->view('popup'); ?>
        <?php $absdashboardclasses->display->view('header-frontend'); ?>
        <?php $absdashboardclasses->display->view('content'); ?>
    </div>
    <?php $absdashboardclasses->display->view('footer'); ?>
</div>