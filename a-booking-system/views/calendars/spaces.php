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
  <?php echo $absdashboardtext['my_spaces']; ?>
</h2>
<div class="absd-button absd-add-space">
  <?php echo $absdashboardtext['space']; ?>
</div>
<?php if (!$absdashboardclasses->main->is_network()) { ?>
<script type="text/javascript">
    window.abookingsystem_website_title = "<?php echo get_bloginfo('name'); ?>";
    window.abookingsystem_website_description = "<?php echo get_bloginfo('description'); ?>";
</script>
<?php } ?>