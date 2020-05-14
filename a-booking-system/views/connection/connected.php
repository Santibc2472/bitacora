<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;

$email = $absdashboardclasses->option->get('email',
                                 $ABookingSystem['user_id']);
$password = $absdashboardclasses->option->get('password',
                                 $ABookingSystem['user_id']);
$user_key = $absdashboardclasses->option->get('user_key',
                                 $ABookingSystem['user_id']);

?>
  
<h2><?php echo $absdashboardtext['connected_to']; ?> <?php echo $absdashboardtext['service']; ?></h2>

<div class="absd-disconnected">
  <input type="text" id="absd-connection-email" class="absd-field absd-disabled" readonly="true" value="<?php echo $email; ?>">
  <input type="password" id="absd-connection-password" class="absd-field absd-disabled" readonly="true" value="<?php echo $password; ?>">
  <input type="text" id="absd-connection-key" class="absd-field absd-disabled" readonly="true" value="<?php echo $user_key; ?>">
  <input type="button" class="absd-button absd-disconnect absd-half" value="Disconnect" onclick="javascript:abookingsystemdashboardConnection.disconnect();">
</div>