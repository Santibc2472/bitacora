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

<div class="absd-left-column">
  
  <div class="absd-header">
    <h2>
      <?php echo $absdashboardtext['listings']; ?>
    </h2>
  </div>
  
  <div class="absd-left-content">
    <div class="absd-search">
      <input type="text" placeholder="<?php echo $absdashboardtext['search_listing']; ?>...">
    </div>
    
    <div class="absd-listings">
      <div class="absd-listings-holder"></div>
      
      <div class="absd-pagination">
        
      </div>
    </div>
  </div>
  
</div>

<div id="absd-listings-content" class="absd-right-column"></div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        window.abookingsystemdashboardListings.list();
    });
</script>