<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/dashboard/views-backend-dashboard.php
* File Version            : 1.0.5
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end dashboard views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDashboard')){
        class DOPBSPViewsBackEndDashboard extends DOPBSPViewsBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns dashboard template.
             * 
             * @param args (array): function arguments
             * 
             * @return dashboard HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!-- 
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE'), $DOPBSP->text('DASHBOARD_TITLE')); ?>

<!--
    Content
-->
        <div class="dopbsp-main dopbsp-hidden">
<?php
                /*
                 * Dashboard start template.
                 */
                $DOPBSP->views->backend_dashboard_start->template();
                
                /*
                 * Dashboard API template.
                 */
                $DOPBSP->views->backend_dashboard_api->template($args);
                
                /*
                 * Dashboard server template.
                 */
                $DOPBSP->views->backend_dashboard_server->template($args);
?>
        </div>
    </div>       
<?php
            }
        }
    }