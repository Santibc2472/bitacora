<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : views/views-backend.php
* File Version            : 1.2.2
* Created / Last Modified : 15 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end views class.
*/

    if (!class_exists('DOPBSPViewsBackEnd')){
        class DOPBSPViewsBackEnd extends DOPBSPViews{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Display default page header.
             * 
             * @param title (string): page title
             * 
             * @return default page header HTML
             */
            function displayHeader($title = '',
                                   $subtitle = '',
                                   $status = ''){
                global $DOPBSP;
                
                $complete_title = ($title != '' ? '<span class="dopbsp-phone-hidden">'.$title:'').
                                  ($subtitle != '' ? ' - </span>'.$subtitle:'</span>').
                                  ($status != '' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$status:'');
                
                if ($DOPBSP->vars->view_pro){
?>
                <!--
                    PRO tips box.
                -->
		<div id="DOPBSP-pro-remove" class="updated notice dopbsp-notice is-dismissible">
		    <p>
			<?php echo $DOPBSP->text('MESSAGES_PRO_REMOVE_TEXT1'); ?>
			<br />
			<?php printf($DOPBSP->text('MESSAGES_PRO_REMOVE_TEXT2'), '<strong>DOPBSP_CONFIG_VIEW_PRO</strong>', '<strong>false</strong>', '<em>dopbsp-config.php</em>'); ?>
		    </p>
                </div>
<?php  
                }
?>
                <h2></h2>
                <div class="dopbsp-header">
                    <h3><?php echo $complete_title?></h3>
<?php
                echo $this->getLanguages();
                
                if (DOPBSP_CONFIG_VIEW_DOCUMENTATION){
?>
                    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-tablet-hidden dopbsp-phone-hidden"><?php echo $DOPBSP->text('HELP_DOCUMENTATION'); ?></a>
<?php
                }
?>
                    <br class="dopbsp-clear" />
                </div>
                <?php $this->displayBoxes(); ?>
<?php                
            }
            
            /*
             * Display messages, confirmation & go to top boxes.
             * 
             * @return boxes HTML
             */
            function displayBoxes(){
                global $DOPBSP;
?>
                <div id="DOPBSP-messages-background"></div>
                
                <!--
                    Messages box.
                -->
                <div id="DOPBSP-messages-box">
                    <a href="javascript:DOPBSPBackEnd.toggleMessages()" class="dopbsp-close"></a>
                    <div class="dopbsp-icon-active"></div>
                    <div class="dopbsp-icon-success"></div>
                    <div class="dopbsp-icon-error"></div>
                    <div class="dopbsp-message"></div>
                </div>
                
                <!--
                    Confirmation box.
                -->
                <div id="DOPBSP-confirmation-box">
                    <div class="dopbsp-icon"></div>
                    <div class="dopbsp-message"></div>
                    <div class="dopbsp-buttons">
                        <a href="javascript:void(0)" class="dopbsp-button-yes"><?php echo $DOPBSP->text('MESSAGES_CONFIRMATION_YES'); ?></a>
                        <a href="javascript:void(0)" class="dopbsp-button-no"><?php echo $DOPBSP->text('MESSAGES_CONFIRMATION_NO'); ?></a>
                    </div>    
                </div>
                
                <!--
                    Go to top button.
                -->
                <a href="javascript:DOPPrototypes.scrollToY(0)" id="DOPBSP-go-top"></a>
<?php    
            }
            
            /*
             * Add translation to JavaScript for AJAX usage.
             */
            function getTranslation(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                if ($DOT->get('page')){
                    $current_page = $DOT->get('page');

                    switch($current_page){
                        case 'dopbsp-addons':
                            $DOPBSP_curr_page = 'Addons';
                            break;
                        case 'dopbsp-calendars':
                            $DOPBSP_curr_page = 'Calendars';
                            break;
                        case 'dopbsp-coupons':
                            $DOPBSP_curr_page = 'Coupons';
                            break;
                        case 'dopbsp-discounts':
                            $DOPBSP_curr_page = 'Discounts';
                            break;
                        case 'dopbsp-emails':
                            $DOPBSP_curr_page = 'Emails';
                            break;
                        case 'dopbsp-extras':
                            $DOPBSP_curr_page = 'Extras';
                            break;
                        case 'dopbsp-fees':
                            $DOPBSP_curr_page = 'Fees';
                            break;
                        case 'dopbsp-forms':
                            $DOPBSP_curr_page = 'Forms';
                            break;
                        case 'dopbsp-locations':
                            $DOPBSP_curr_page = 'Locations';
                            break;
                        case 'dopbsp-models':
                            $DOPBSP_curr_page = 'Models';
                            break;
                        case 'dopbsp-pro':
                            $DOPBSP_curr_page = 'PRO';
                            break;
                        case 'dopbsp-reservations':
                            $DOPBSP_curr_page = 'Reservations';
                            break;
                        case 'dopbsp-reviews':
                            $DOPBSP_curr_page = 'Reviews';
                            break;
                        case 'dopbsp-rules':
                            $DOPBSP_curr_page = 'Rules';
                            break;
                        case 'dopbsp-settings':
                            $DOPBSP_curr_page = 'Settings';
                            break;
                        case 'dopbsp-smses':
                            $DOPBSP_curr_page = 'Smses';
                            break;
                        case 'dopbsp-templates':
                            $DOPBSP_curr_page = 'Templates';
                            break;
                        case 'dopbsp-themes':
                            $DOPBSP_curr_page = 'Themes';
                            break;
                        case 'dopbsp-tools':
                            $DOPBSP_curr_page = 'Tools';
                            break;
                        case 'dopbsp-translation':
                            $DOPBSP_curr_page = 'Translation';
                            break;
                        default:
                            $DOPBSP_curr_page = 'Dashboard';
                            break;
                    }
                }
                else{
                    if ($DOT->get('action') == 'edit'){
                        $DOPBSP_curr_page = 'Calendars';
                    }
                    else{
                        $DOPBSP_curr_page = 'None';
                    }
                }
                
                if (!is_super_admin()){
                    $user_roles = array_values(wp_get_current_user()->roles);
                    $DOPBSP_user_role = $user_roles[0];
                }
                else{
                    $DOPBSP_user_role = 'administrator';
                }
                $settings_general = $DOPBSP->classes->backend_settings->values(0,  
                                                                               'general');
?>          
            <script type="text/JavaScript">
                var DOPBSP_DEVELOPMENT_MODE = <?php echo DOPBSP_DEVELOPMENT_MODE ? 'true':'false'; ?>,
                dopbspGoogleAPIkey = '<?php echo $settings_general->google_map_api_key; ?>',
                DOPBSP_CONFIG_HELP_DOCUMENTATION_URL = '<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>',
                DOPBSP_curr_page = '<?php echo $DOPBSP_curr_page; ?>',
                DOPBSP_user_ID = <?php echo wp_get_current_user()->ID; ?>,
                DOPBSP_user_role = '<?php echo $DOPBSP_user_role; ?>',
                DOPBSP_plugin_url = '<?php echo $DOPBSP->paths->url; ?>',
                DOPBSP_translation_text = new Array(),
		DOPBSP_view_pro = <?php echo $DOPBSP->vars->view_pro ? 'true':'false'; ?>;
                
<?php
                $language = $DOPBSP->classes->backend_language->get();
                $translation = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language);

                foreach ($translation as $item){
                    $text = stripslashes($item->translation);
                    $text = str_replace('<<single-quote>>', "\'", $text);
                    $text = str_replace('<script>', "", $text);
                    $text = str_replace('</script>', "", $text);
?>
                    
                    DOPBSP_translation_text['<?php echo $item->key_data; ?>'] = '<?php echo $text; ?>';
<?php                    
                }
?>
            </script>
<?php  
            }
            
            /*
             * Get languages drop down.
             * 
             * @param id (string): drop down ID
             * @param function (string): onchange function
             * @param class (string): drop down class
             * 
             * @return drop down HTML
             */
            function getLanguages($id = 'DOPBSP-admin-language', 
                                  $function = 'DOPBSPBackEndLanguage.change()', 
                                  $selected_language = '',
                                  $class = ''){
                global $wpdb;
                global $DOPBSP;
                
                $HTML = array();
                
                $languages = $DOPBSP->classes->languages->languages;
                $selected_language = $selected_language == '' ? $DOPBSP->classes->backend_language->get():$selected_language;
                
                $enabled_languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');
                
                array_push($HTML, '<select name="'.$id.'" id="'.$id.'"'.($class == '' ? '':' class="'.$class.'"').' onchange="'.$function.'">');
                
                foreach ($enabled_languages as $enabled_language){
                    for ($i=0; $i<count($languages); $i++){
                        if ($enabled_language->code == $languages[$i]['code']){
                            array_push($HTML, '<option value="'.$languages[$i]['code'].'"'.($selected_language == $languages[$i]['code'] ? ' selected="selected"':'').'>'.$languages[$i]['name'].'</option>');
                            break;
                        }
                    }
                }
                array_push($HTML, '</select>');
                array_push($HTML, '<script type="text/JavaScript">jQuery(\'#'.$id.'\').DOPSelect();</script>');
                
                return implode('', $HTML);
            }
        }
    }