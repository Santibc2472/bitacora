<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/reservations/views-backend-reservations-list.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations list views class.
*/

    if (!class_exists('DOPBSPViewsBackEndReservationsList')){
        class DOPBSPViewsBackEndReservationsList extends DOPBSPViewsBackEndReservations{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns reservations template.
             * 
             * @param args (array): function arguments
             *                      * reservations (array): reservations list
             *                      * reservations_total (array): total number of reservations
             * 
             * @return reservations HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $reservations = $args['reservations'];
                $reservations_total = $args['reservations_total'];
                
                echo $reservations_total.';;;;;;;;;;;';
?>
                <ul class="dopbsp-reservations-list">
<?php
                /*
                 * Check if reservations exist.
                 */
                if (count($reservations) > 0){
                    foreach ($reservations as $reservation){
                        $DOPBSP->views->backend_reservation->template(array('reservation' => $reservation));
                    }
                }
                else{
?>                    
                    <li class="dopbsp-no-data"><?php echo $DOPBSP->text('RESERVATIONS_NO_RESERVATIONS'); ?></li>
<?php                    
                }
?>
                </ul> 
<?php
            }
            
            /*
             * Returns reservations template.
             * 
             * @param args (array): function arguments
             *                      * reservations (array): reservations list
             *                      * reservations_total (array): total number of reservations
             * 
             * @return reservations HTML page
             */
            function templatePrint($args = array()){
                global $DOPBSP;
                
                $reservations = $args['reservations'];
                $reservations_total = $args['reservations_total'];
                
                $styles = $DOPBSP->classes->backend->getStyles();
?>
                <head>
<?php
                foreach ($styles as $style) {
                    echo $style;
                }
?>
                    <style>
                        .dopbsp-reservations-list, .dopbsp-reservations-list li{ width:100%; float:left;}
                        .DOPBSP-admin .dopbsp-main table.dopbsp-content-wrapper .dopbsp-column{ overflow: hidden;}
                        .DOPBSP-admin .dopbsp-main table.dopbsp-content-wrapper .dopbsp-reservations-list li .dopbsp-reservation-head{
                            padding: 29px 9px 9px 9px;
                        }
                        .DOPBSP-admin .dopbsp-main table.dopbsp-content-wrapper .dopbsp-reservations-list{
                            list-style: none;
                        }
                        .DOPBSP-admin .dopbsp-main table.dopbsp-content-wrapper .dopbsp-reservations-list li .dopbsp-reservation-body .dopbsp-data-module{
                            width: 288px;
                        }
                    </style>
                </head>
                <body>
                    <div class="DOPBSP-admin">
                        <div class="dopbsp-main">
                            <table class="dopbsp-content-wrapper">
                                <colgroup>
                                    <col id="DOPBSP-col-column2" class="dopbsp-column2">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td class="dopbsp-column" id="DOPBSP-column2">
                                            <ul class="dopbsp-reservations-list">
<?php
                                            /*
                                             * Check if reservations exist.
                                             */
                                            if (count($reservations) > 0){
                                                foreach ($reservations as $reservation){
                                                    $DOPBSP->views->backend_reservation->templatePrint(array('reservation' => $reservation));
                                                }
                                            }
                                            else{
?>                    
                                                <li class="dopbsp-no-data"><?php echo $DOPBSP->text('RESERVATIONS_NO_RESERVATIONS'); ?></li>
<?php                    
                                            }
?>
                                            </ul> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </body>
            <script>
                window.print();
                window.close();
            </script>
<?php
            } // to add
        }
    }