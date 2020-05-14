<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;


// No Access
if($ABookingSystem['role'] != 'admin'
  && $ABookingSystem['role'] != 'owner') {
    $absdashboardclasses->display->view('no-access'); 
    exit;
}

?>

<div class="absd-left-column absd-extension-left">
  
  <div class="absd-header">
    <h2 style="margin-top: 60px !important;">
      <?php echo $absdashboardtext['extensions']; ?>
    </h2>
  </div>
  
  <div class="absd-left-content">
    <div class="absd-search">
      <input type="text" placeholder="<?php echo $absdashboardtext['search_extension']; ?>...">
    </div>
    
    <div class="absd-extensions">
      <div class="absd-pagination"></div>
    </div>
  </div>
  
</div>

<div id="absd-extensions-content" class="absd-right-column absd-gray">
    <div class="absd-extensions-holder"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        window.abookingsystemdashboardExtensions.list();
    });
</script>