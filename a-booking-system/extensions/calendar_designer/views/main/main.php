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

<div class="absd-right-column absd-calendar_designer">
  
  <div id="bdm-calendar_designer">
    <div class="row">
      <div class="col-sm-12 mt-3 col-xl-9 text-center">
        <h2 class="aplusbookingcalendar-designer-h2" hidden><?php echo $absdashboardtext['ext_calendar_designer_preview']; ?></h2>
      </div>
      <div class="col-sm-12 mt-3 col-xl-2 text-center">
        <h2 class="aplusbookingcalendar-designer-h2" hidden><?php echo $absdashboardtext['ext_calendar_designer_settings']; ?> <button type="button" class="btn btn-sm btn-danger aplusbookingcalendar-designer-reset"><?php echo $absdashboardtext['ext_calendar_designer_reset']; ?></button></h2>
      </div>
    </div>
    
    <div class="row mb-5">
      <div class="col-sm-12 col-xl-9 preview"></div>
      <div class="col-sm-12 col-xl-2 mt-4 settings"></div>
    </div>
  </div>

</div>