<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;
global $current_user;

$email = $absdashboardclasses->option->get('email');
$password = $absdashboardclasses->option->get('password');
$user_key = $absdashboardclasses->option->get('user_key');

get_currentuserinfo();
$user_info  = get_userdata(get_current_user_id());
$first_name = isset($user_info->first_name) && $user_info->first_name != '' ? $user_info->first_name:'';
$last_name  = isset($user_info->last_name) && $user_info->last_name != '' ? $user_info->last_name:'';
$fullname   = '';
$user_email = isset($current_user->data->user_email) && $current_user->data->user_email != '' ? $current_user->data->user_email:'';

if($first_name != ''
   && $last_name != '') {
    $fullname = $first_name.' '.$last_name;
}

?>
  
<h2><?php echo $absdashboardtext['connect_to']; ?> <?php echo $absdashboardtext['service']; ?></h2>

<div class="absd-disconnected">
  <input type="text" id="absd-connection-email" class="absd-field" placeholder="Your email" value="<?php echo $email; ?>">
  <input type="password" id="absd-connection-password" class="absd-field" placeholder="Your password" value="<?php echo $password; ?>">
  <div class="absd-get-user-key">
      <input type="text" id="absd-connection-key" class="absd-field" placeholder="Your key" value="<?php echo $user_key; ?>">
      <span><?php echo $absdashboardtext['get_key_info']; ?></span>
  </div>
  <input type="checkbox" id="absd-terms-and-conditions">   <span><?php echo $absdashboardtext['i_m_agree']; ?></span>
  <br>
  <input type="button" class="absd-button absd-connect absd-half" value="Connect" onclick="javascript:abookingsystemdashboardConnection.connect();">
  <input type="button" class="absd-button absd-register absd-half" onclick="javascript:abookingsystemdashboardConnection.register_form();" value="Create one - It's free">
  <br>
<!--   <h3>OR CONNECT WITH YOUR</h3>
  <input type="button" class="absd-button absd-facebook" value="Facebook account">
  <input type="button" class="absd-button absd-wordpress" value="Wordpress account"> -->
</div>
<script type="text/javascript">
window.abookingsystem_fullname = "<?php echo $fullname; ?>";
window.abookingsystem_user_email = "<?php echo $user_email; ?>";
window.abookingsystem_countries = <?php echo json_encode($absdashboardclasses->main->countries()); ?>;

jQuery(document).ready(function(){
    window.abookingsystemdashboardConnection.detect_country();
});
</script>