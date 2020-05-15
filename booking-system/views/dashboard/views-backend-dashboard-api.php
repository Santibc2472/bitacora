<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/dashboard/views-backend-dashboard-api.php
* File Version            : 1.0.1
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end dashboard API views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDashboardAPI')){
        class DOPBSPViewsBackEndDashboardAPI extends DOPBSPViewsBackEndDashboard{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns dashboard system template.
             * 
             * @param args (array): function arguments
             *                      * api_key (array): API key data
             *                      * server (array): server data
             * 
             * @return dashboard system HTML template
             */
            function template($args = array()){
                global $DOPBSP;
                
                $api_key = $args['api_key'];
?>
            <section class="dopbsp-content-wrapper dopbsp-responsive-hidden" >
                <div class="dopbsp-box-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('DASHBOARD_API_TITLE'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleBox('api')" id="DOPBSP-box-button-api" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-box-api" class="dopbsp-box-wrapper">
                    <p id="DOPBSP-box-api-key"><?php echo $api_key; ?></p>
                    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help dopbsp-right"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('DASHBOARD_API_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    <a href="javascript:DOPBSPBackEndApi.reset(<?php echo wp_get_current_user()->ID; ?>);" target="_blank" class="dopbsp-button dopbsp-reset-api-key dopbsp-right"><span class="dopbsp-info"><?php echo $DOPBSP->text('DASHBOARD_API_RESET'); ?></span></a>
                </div>
            </section>
<?php
            }
        }
    }