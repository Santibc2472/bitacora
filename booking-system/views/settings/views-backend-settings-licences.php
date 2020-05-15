<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/settings/views-backend-settings-licences.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end licences settings views class.
*/

    if (!class_exists('DOPBSPViewsBackEndSettingsLicences')){
        class DOPBSPViewsBackEndSettingsLicences extends DOPBSPViewsBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns licences settings template.
             * 
             * @param args (array): function arguments
             * 
             * @return licences settings HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $settings_general = $DOPBSP->classes->backend_settings->values(0,  
                                                                              'general');
?>
                <div class="dopbsp-inputs-wrapper">
                    <em><?php echo $DOPBSP->text('SETTINGS_LICENCES_HELP'); ?></em>
                </div>
<?php
    
/*
 * ACTION HOOK (dopbsp_action_views_settings_licences) ***************** Add licences settings.
 */
                do_action('dopbsp_action_views_settings_licences', array('settings_general' => $settings_general));
            }
        }
    }