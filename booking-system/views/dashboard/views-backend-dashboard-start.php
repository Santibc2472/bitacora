<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : views/dashboard/views-backend-dashboard-start.php
* File Version            : 1.2.0
* Created / Last Modified : 15 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end dashboard views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDashboardStart')){
        class DOPBSPViewsBackEndDashboardStart extends DOPBSPViewsBackEndDashboard{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns dashboard start template.
             * 
             * @param args (array): function arguments
             * 
             * @return dashboard start HTML template
             */
            function template($args = array()){
                global $DOPBSP;
?>            
            <section class="dopbsp-content-wrapper">
                <h3><?php echo $DOPBSP->text('DASHBOARD_SUBTITLE'); ?></h3>
                <p><?php echo $DOPBSP->text('DASHBOARD_TEXT'); ?></p>
                
                <div id="DOPBSP-get-started" class="dopbsp-left">
                    <h4><?php echo $DOPBSP->text('DASHBOARD_GET_STARTED'); ?></h4>
                    <ul>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-pro'); ?>">
                                <span class="dopbsp-icon dopbsp-calendars"></span>
<?php
    if ($DOPBSP->vars->view_pro){
	echo $DOPBSP->text('DASHBOARD_GET_STARTED_CALENDARS');
?>
                                <span class="dopbsp-pro"><?php echo $DOPBSP->text('MESSAGES_PRO_TITLE'); ?></span>
<?php
    }
    else{
	echo $DOPBSP->text('DASHBOARD_GET_STARTED_CALENDARS_VIEW'); 
    }
?>
                            </a>    
                        </li>
<?php
    if ($DOPBSP->vars->view_pro){
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-pro'); ?>">
                                <span class="dopbsp-icon dopbsp-locations"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_GET_STARTED_LOCATIONS'); ?>
                                <span class="dopbsp-pro"><?php echo $DOPBSP->text('MESSAGES_PRO_TITLE'); ?></span>
                            </a>
                        </li>
<?php
    }
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-reservations'); ?>">
                                <span class="dopbsp-icon dopbsp-reservations"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_GET_STARTED_RESERVATIONS'); ?>
                            </a>
                        </li>
<?php
    if (DOPBSP_DEVELOPMENT_MODE){
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-reviews'); ?>">
                                <span class="dopbsp-icon dopbsp-reviews"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_GET_STARTED_REVIEWS').' <em>('.$DOPBSP->text('SOON').')</em>'; ?>
                            </a>
                        </li>
<?php
    }
?>
                    </ul>
                </div>
                
                <div id="DOPBSP-more-actions" class="dopbsp-left">
                    <h4><?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS'); ?></h4>
                    <ul>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-coupons'); ?>">
                                <span class="dopbsp-icon dopbsp-coupons"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_COUPONS'); ?>
			    </a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-discounts'); ?>">
                                <span class="dopbsp-icon dopbsp-discounts"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_DISCOUNTS'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-emails'); ?>">
                                <span class="dopbsp-icon dopbsp-emails"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_EMAILS'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-extras'); ?>">
                                <span class="dopbsp-icon dopbsp-extras"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_EXTRAS'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-forms'); ?>">
                                <span class="dopbsp-icon dopbsp-forms"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_FORMS'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-rules'); ?>">
                                <span class="dopbsp-icon dopbsp-rules"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_RULES'); ?>
                            </a>
                        </li>
<?php
    if ($DOPBSP->vars->view_pro){
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-pro'); ?>">
                                <span class="dopbsp-icon dopbsp-search"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_SEARCH'); ?>
                                <span class="dopbsp-pro"><?php echo $DOPBSP->text('MESSAGES_PRO_INFO'); ?></span>
                            </a>
                        </li>
<?php
    }
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-fees'); ?>">
                                <span class="dopbsp-icon dopbsp-fees"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_FEES'); ?>
                            </a>
                        </li>
<?php
    if (DOPBSP_DEVELOPMENT_MODE){
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-templates'); ?>">
                                <span class="dopbsp-icon dopbsp-templates"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_TEMPLATES').' <em>('.$DOPBSP->text('SOON').')</em>'; ?>
                            </a>
                        </li>
<?php
    }
    
    if ($DOPBSP->vars->role_action == 'manage_options'){
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-settings'); ?>">
                                <span class="dopbsp-icon dopbsp-settings"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_SETTINGS'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-translation'); ?>">
                                <span class="dopbsp-icon dopbsp-translation"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_TRANSLATION'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-tools'); ?>">
                                <span class="dopbsp-icon dopbsp-tools"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_TOOLS'); ?>
                            </a>
                        </li>
<?php
        if (DOPBSP_CONFIG_VIEW_ADDONS){
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-addons'); ?>" class="dopbsp-important">
                                <span class="dopbsp-icon dopbsp-addons"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_ADDONS'); ?>
                            </a>
                        </li>
<?php
        }

        if (DOPBSP_CONFIG_VIEW_THEMES){
?>
                        <li>
                            <a href="<?php echo admin_url('admin.php?page=dopbsp-themes'); ?>" class="dopbsp-important">
                                <span class="dopbsp-icon dopbsp-themes"></span>
                                <?php echo $DOPBSP->text('DASHBOARD_MORE_ACTIONS_THEMES'); ?>
                            </a>
                        </li>
<?php
        }
    }
?>
                    </ul>
                </div>
            </section>
<?php
            }
        }
    }