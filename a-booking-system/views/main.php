<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;
  
$account_type = $absdashboardclasses->option->get('account_type',
                                                  $ABookingSystem['user_id']);
$used_for = $absdashboardclasses->option->get('used_for',
                                              $ABookingSystem['user_id']);

?>
<div id="absd-wrapper">
    <div class="absd-row">
        <h1 class="absd-main-title"><?php echo $absdashboardtext['title']; ?></h1>
        <div class="absd-right-header-container">
            <ul class="absd-rght-top-menu">
                <?php $right_top_menu = isset($ABookingSystem['menu']['right_top']) ? $ABookingSystem['menu']['right_top']:array(); ?>
                <?php foreach($right_top_menu as $no => $button){ ?>
                <?php   if($button['enabled']) { ?>
                <?php       if(in_array($ABookingSystem['role'], $button['role'])) { ?>
                <?php           if(in_array($account_type, $button['account_type'])) { ?>
                <?php if(!empty($button['page'])) { ?>
                <li class="<?php echo $button['css_class']; ?>" onclick="var url = new window.URL(window.location.href); url.searchParams.set('abookingsystemdashboard_page', '<?php echo $button['page']; ?>'); location.href=url.href;"><img src="<?php echo $button['image']; ?>"></li>
                <?php } else { ?>
                <li class="<?php echo $button['css_class']; ?>"><img src="<?php echo $ABookingSystem['plugin_url'].$button['image']; ?>"></li>
                <?php } ?>
                <?php           } ?>
                <?php       } ?>
                <?php   } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
    
    <div class="absd-content-box">
        <?php $absdashboardclasses->display->view('popup'); ?>
        <?php $absdashboardclasses->display->view('header'); ?>
        <?php $absdashboardclasses->display->view('content'); ?>
    </div>
    <?php $absdashboardclasses->display->view('footer'); ?>
</div>


<?php if($ABookingSystem['page_disabled']) { 
    $language = $absdashboardclasses->option->get('language',
                                                  $ABookingSystem['user_id']);
    $language = isset($language) && $language != '' ? $language:'auto';                                      
?>
<div class="abookingsystem-demo-calendar">
    <!-- Title 	-->	
    <h1 style="text-align: center;"><?php echo $absdashboardtext['demo_booking_calendar']; ?></h1>	
    <p style="text-align: center;"><b>NOTE:</b> To use this booking calendar you need to <a href="#" style="color: #3c9909;
    text-decoration: none;" onclick="javascript:abookingsystemdashboardConnection.register_form();">create an account(It’s free)</a>. You can test the booking calendar here before you register.</p>

    <!-- Text -->
    <p></p>
    <div class="bookeucom">[bookeucom key=d3fbc8053c8cd6eed13122c58de53fd0-www language=<?php echo $language; ?>]</div>
    <p></p>
    <p></p>
</div>
<?php } ?>