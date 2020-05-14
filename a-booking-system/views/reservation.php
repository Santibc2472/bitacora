<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;

$reservation_id = $absdashboardclasses->protect->get('id', 'id');
$api_key = $absdashboardclasses->protect->get('api_key', 'text', '');
$email = $absdashboardclasses->protect->get('email', 'email');

?>
<div id="absd-wrapper" style="margin:0px;">
    
    <div class="absd-content-box" style="margin: 0px;padding: 0px; min-height: auto;">
        <?php $absdashboardclasses->display->view('popup'); ?>
        <div class="absd-reservation-box">
          
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        window.abookingsystemdashboardReservationCancel.start({"id": "<?php echo esc_html($reservation_id); ?>",
                                              "api_key": "<?php echo esc_html($api_key); ?>",
                                              "email": "<?php echo esc_html($email); ?>"});
    });
</script>