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

<div class="absd-left-column">
  
  <div class="absd-header">
    <h2>
      <?php echo $absdashboardtext['my_tickets']; ?>
    </h2>
    <div class="absd-button absd-add-ticket-btn absd-add-ticket">
      <?php echo $absdashboardtext['ticket']; ?>
    </div>
  </div>
  
  <div class="absd-left-content">
    <div class="absd-search">
      <input type="text" placeholder="<?php echo $absdashboardtext['search_ticket']; ?>...">
    </div>
    
    <div class="absd-tickets">
      <div class="absd-tickets-holder"></div>
      
      <div class="absd-pagination">
        
      </div>
    </div>
  </div>
  
</div>

<div id="absd-tickets-content" class="absd-right-column"></div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        window.abookingsystemdashboardTickets.list();
    });
</script>