<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/tools/views-backend-tools.php
* File Version            : 1.0.3
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end tools views class.
*/

    if (!class_exists('DOPBSPViewsBackEndTools')){
        class DOPBSPViewsBackEndTools extends DOPBSPViewsBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns tools template.
             * 
             * @return tools HTML page
             */
            function template(){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE'), $DOPBSP->text('TOOLS_TITLE')); ?>

<!-- 
    Content
-->
        <div class="dopbsp-main">
            <table class="dopbsp-content-wrapper">
                <colgroup>
                    <col id="DOPBSP-col-column1" class="dopbsp-column1" />
                    <col id="DOPBSP-col-column-separator1" class="dopbsp-separator" />
                    <col id="DOPBSP-col-column2" class="dopbsp-column2" />
                </colgroup>
                <tbody>
                    <tr>
                        <td class="dopbsp-column" id="DOPBSP-column1">
                            <div class="dopbsp-column-header">
                                <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('TOOLS_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                <br class="dopbsp-clear" />
                            </div>
                            <div class="dopbsp-column-content">
                                <ul class="DOPBSP-pro-tips">
                                    <li class="dopbsp-tools-item dopbsp-repair-database-text" onclick="DOPBSPBackEndTools.toggle('repair-database-text'); DOPBSPBackEnd.confirmation('TOOLS_REPAIR_DATABASE_TEXT_CONFIRMATION', 'DOPBSPBackEndToolsRepairDatabaseText.set()', 'DOPBSPBackEndTools.toggle()', 'Are you sure you want to verify the database & the text and repair them if needed?')">
                                        <div class="dopbsp-icon"></div>
                                        <div class="dopbsp-title"><?php echo $DOPBSP->text('TOOLS_REPAIR_DATABASE_TEXT_TITLE', 'Repair database & text'); ?></div>
                                    </li>
                                    <li class="dopbsp-tools-item dopbsp-repair-calendars-settings" onclick="DOPBSPBackEndTools.toggle('repair-calendars-settings'); DOPBSPBackEnd.confirmation('TOOLS_REPAIR_CALENDARS_SETTINGS_CONFIRMATION', 'DOPBSPBackEndToolsRepairCalendarsSettings.init()', 'DOPBSPBackEndTools.toggle()')">
                                        <div class="dopbsp-icon"></div>
                                        <div class="dopbsp-title"><?php echo $DOPBSP->text('TOOLS_REPAIR_CALENDARS_SETTINGS_TITLE'); ?></div>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td id="DOPBSP-column-separator1" class="dopbsp-separator"></td>
                        <td id="DOPBSP-column2" class="dopbsp-column">
                            <div class="dopbsp-column-header">&nbsp;</div>
                            <div class="dopbsp-column-content">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>       
<?php
            }
        }
    }