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

<div class="absd-left-column">
  
  <div class="absd-header">
    <h2>
      <?php echo $absdashboardtext['my_withdraws']; ?>
    </h2>
  </div>
  
  <div class="absd-left-content">
    <div class="absd-search">
      <input type="text" placeholder="<?php echo $absdashboardtext['search_payment']; ?>...">
    </div>
    
    <div class="absd-withdraws">
      <div class="absd-withdraws-holder"></div>
      
      <div class="absd-pagination">
        
      </div>
    </div>
  </div>
  
</div>

<div id="absd-withdraws-content" class="absd-right-column"></div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        window.abookingsystemdashboardAccount.list();
    });
</script>