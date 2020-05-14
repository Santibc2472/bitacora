<?php 

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;
  
$account_type = $absdashboardclasses->option->get('account_type',
                                          $ABookingSystem['user_id']);
$used_for = $absdashboardclasses->option->get('used_for',
                                    $ABookingSystem['user_id']);

?>
<div class="absd-header">
    <ul class="absd-menu">
        <?php 
            $main_menu = $ABookingSystem['menu']['main'];
        
            foreach($main_menu as $no => $button){

                if($no == 0) {
                    // Main Button
                    if($ABookingSystem['role'] == 'admin') {
        ?>
                        <li class="absd-line"></li>
                        <li class="<?php echo $ABookingSystem['page'] == $button['page'] ? 'absd-selected':''; ?>" onclick="var url = new window.URL(window.location.href); url.searchParams.set('abookingsystemdashboard_page', '<?php echo $button['page']; ?>'); location.href=url.href;"><?php echo $absdashboardtext[$button['sub_title']]; ?></li>
        <?php
                    }
                } else {
                    
                    if($button['enabled']) {

                        if(in_array($ABookingSystem['role'], $button['role'])) {

                            if(in_array($account_type, $button['account_type'])) {
        ?>
                                <li class="absd-line"></li>
                                <li class="<?php echo $ABookingSystem['page'] == $button['page'] ? 'absd-selected':''; ?><?php echo $ABookingSystem['page_disabled'] == true ? 'absd-disabled':''; ?>" onclick="var url = new window.URL(window.location.href); url.searchParams.set('abookingsystemdashboard_page', '<?php echo $button['page']; ?>'); location.href=<?php echo $ABookingSystem['page_disabled'] == true ? '#':'url.href'; ?>"><?php echo $absdashboardtext[$button['title'].($button['used_for'] ? $used_for:'')]; ?></li>
        <?php
                                
                            }
                        }
                    }
                }
            }
        ?>
    </ul>
</div>