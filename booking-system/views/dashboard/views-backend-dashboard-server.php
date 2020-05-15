<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : views/dashboard/views-backend-dashboard-server.php
* File Version            : 1.0.8
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end dashboard server views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDashboardServer')){
        class DOPBSPViewsBackEndDashboardServer extends DOPBSPViewsBackEndDashboard{
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
                
                $server = $args['server'];
?>
            <section class="dopbsp-content-wrapper dopbsp-responsive-hidden" >
                <div class="dopbsp-box-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('DASHBOARD_SERVER_TITLE'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleBox('server')" id="DOPBSP-box-button-server" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-box-server" class="dopbsp-box-wrapper">
                    <table id="DOPBSP-server" class="dopbsp-info-table">
                        <colgroup>
                            <col />
                            <col />
                            <col />
                            <col />
                        </colgroup>
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php echo $DOPBSP->text('DASHBOARD_SERVER_REQUIRED'); ?></th>
                                <th><?php echo $DOPBSP->text('DASHBOARD_SERVER_AVAILABLE'); ?></th>
                                <th><?php echo $DOPBSP->text('DASHBOARD_SERVER_STATUS'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
<?php
                for ($i=0; $i<count($server); $i++){
?>
                            <tr class="<?php echo $i%2 == 0 ? 'dopbsp-odd':'dopbsp-even'; ?>">
                                <td><?php echo $server[$i]['title']; ?></td>
                                <td><?php echo $server[$i]['required']; ?></td>
                                <td><?php echo $server[$i]['available']; ?></td>
                                <td><span class="dopbsp-icon <?php echo $server[$i]['icon']; ?>"></span></td>
                            </tr>
<?php
                }
?>
                        </tbody>
                    </table>
                </div>
            </section>
<?php
            }
        }
    }