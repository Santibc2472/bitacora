<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/tools/views-backend-tools-repair-calendars-settings.php
* File Version            : 1.0.2
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end repair calendars settings views class.
*/

    if (!class_exists('DOPBSPViewsBackEndToolsRepairCalendarsSettings')){
        class DOPBSPViewsBackEndToolsRepairCalendarsSettings extends DOPBSPViewsBackEndTools{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns calendars settings template.
             * 
             * @return calendar settings HTML
             */
            function template(){
                global $DOPBSP;
?>
                <table id="DOPBSP-tools-repair-calendars-settings" class="dopbsp-info-table">
                    <colgroup>
                        <col class="dopbsp-quarter" />
                        <col class="dopbsp-quarter" />
                        <col class="dopbsp-quarter" />
                        <col class="dopbsp-quarter" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th><?php echo $DOPBSP->text('TOOLS_REPAIR_CALENDARS_SETTINGS_CALENDARS'); ?></th>
                            <th><?php echo $DOPBSP->text('TOOLS_REPAIR_CALENDARS_SETTINGS_SETTINGS_DATABASE'); ?></th>
                            <th><?php echo $DOPBSP->text('TOOLS_REPAIR_CALENDARS_SETTINGS_NOTIFICATIONS_DATABASE'); ?></th>
                            <th><?php echo $DOPBSP->text('TOOLS_REPAIR_CALENDARS_SETTINGS_PAYMENT_DATABASE'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
<?php
            }
        }
    }