<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/settings/views-backend-settings-emails.php
* File Version            : 1.1.1
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end emails settings views class.
*/

    if (!class_exists('DOPBSPViewsBackEndSettingsNotifications')){
        class DOPBSPViewsBackEndSettingsNotifications extends DOPBSPViewsBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns notifications settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             * 
             * @return emails settings HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                
                $settings_notifications = $DOPBSP->classes->backend_settings->values($id,  
                                                                                     'notifications');
?>
                <div class="dopbsp-inputs-wrapper">
<?php
                    /*
                     * Select templates.
                     */
                    $this->displaySelectInput(array('id' => 'templates',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEMPLATES'),
                                                    'value' => $settings_notifications->templates,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEMPLATES_HELP'),
                                                    'options' => $this->listEmails('labels'),
                                                    'options_values' => $this->listEmails('ids')));
                    /*
                     * Admin notifications method.
                     */
                    $this->displaySelectInput(array('id' => 'method_admin',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_METHOD_ADMIN'),
                                                    'value' => $settings_notifications->method_admin,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_METHOD_ADMIN_HELP'),
                                                    'options' => 'PHPMailer;;PHP mail();;SMTP;;SMTP 2;;WordPress wp_mail()',
                                                    'options_values' => 'mailer;;mail;;smtp;;smtp2;;wp'));
                    /*
                     * User notifications method.
                     */
                    $this->displaySelectInput(array('id' => 'method_user',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_METHOD_USER'),
                                                    'value' => $settings_notifications->method_user,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_METHOD_USER_HELP'),
                                                    'options' => 'PHPMailer;;PHP mail();;SMTP;;SMTP 2;;WordPress wp_mail()',
                                                    'options_values' => 'mailer;;mail;;smtp;;smtp2;;wp'));
                    /*
                     * Admin notification emails.
                     */
                    $this->displayTextInput(array('id' => 'email',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL'),
                                                  'value' => $settings_notifications->email,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_HELP')));
                    /*
                     * Admin notification reply email.
                     */
                    $this->displayTextInput(array('id' => 'email_reply',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_REPLY'),
                                                  'value' => $settings_notifications->email_reply,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_REPLY_HELP')));
                    /*
                     * Admin notification email sender.
                     */
                    $this->displayTextInput(array('id' => 'admin_email_sender',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_ADMIN_EMAIL_SENDER'),
                                                  'value' => $settings_notifications->admin_email_sender,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_ADMIN_EMAIL_SENDER_HELP')));
                    /*
                     * Client notification name.
                     */
                    $this->displayTextInput(array('id' => 'email_name',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_NAME'),
                                                  'value' => $settings_notifications->email_name,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_NAME_HELP')));
                    /*
                     * Cc notifications email.
                     */
                    $this->displayTextarea(array('id' => 'email_cc',
                                                 'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_CC'),
                                                 'value' => str_replace(',', "\n", $settings_notifications->email_cc),
                                                 'settings_id' => $id,
                                                 'settings_type' => 'notifications',
                                                 'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_CC_HELP')));
                    /*
                     * Cc notifications name.
                     */
                    $this->displayTextarea(array('id' => 'email_cc_name',
                                                 'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_CC_NAME'),
                                                 'value' => str_replace(',', "\n", $settings_notifications->email_cc_name),
                                                 'settings_id' => $id,
                                                 'settings_type' => 'notifications',
                                                 'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_CC_NAME_HELP')));
                    /*
                     * Bcc notifications email.
                     */
                    $this->displayTextarea(array('id' => 'email_bcc',
                                                 'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_BCC'),
                                                 'value' => str_replace(',', "\n", $settings_notifications->email_bcc),
                                                 'settings_id' => $id,
                                                 'settings_type' => 'notifications',
                                                 'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_BCC_HELP')));
                    /*
                     * Bcc notifications name.
                     */
                    $this->displayTextarea(array('id' => 'email_bcc_name',
                                                 'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_BCC_NAME'),
                                                 'value' => str_replace(',', "\n", $settings_notifications->email_bcc_name),
                                                 'settings_id' => $id,
                                                 'settings_type' => 'notifications',
                                                 'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_BCC_NAME_HELP'),
                                                 'container_class' => 'dopbsp-last'));
?>
                </div>
<?php
                /*
                 * SMTP configuration.
                 */
                $this->templateSMTP($id,
                                    $settings_notifications);
                
                /*
                 * Second SMTP configuration.
                 */
                $this->templateSMTP2($id,
                                     $settings_notifications);
                
                /*
                 * Send notifications.
                 */
                $this->templateSend($id,
                                    $settings_notifications);
                
                /*
                 * Test notifications.
                 */
                $this->templateTest($id,
                                    $settings_notifications);
                
                /*
                 * SMS notifications - Clickatell.com.
                 */
                $this->templateSMSClickatell($id,
                                             $settings_notifications);
            }
            
            /*
             * Returns notifications send settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_notifications (object): notifications settings
             * 
             * @return send notifications settings HTML
             */
            function templateSend($id,
                                  $settings_notifications){
                global $DOPBSP;
?>
                 <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_TITLE'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('settings-notifications-send')" id="DOPBSP-inputs-button-settings-notifications-send" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-settings-notifications-send" class="dopbsp-inputs-wrapper">
<?php
                    /*
                     * Send on book request to admin.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_admin',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN'),
                                                    'value' => $settings_notifications->send_book_admin,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN_HELP')));
                    /*
                     * Send on book request to user.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_user',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_USER'),
                                                    'value' => $settings_notifications->send_book_user,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_USER_HELP')));
                    /*
                     * Send on book with approval request to admin.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_with_approval_admin',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN'),
                                                    'value' => $settings_notifications->send_book_with_approval_admin,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN_HELP')));
                    /*
                     * Send on book with approval request to user.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_with_approval_user',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER'),
                                                    'value' => $settings_notifications->send_book_with_approval_user,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER_HELP')));
                    /*
                     * Send on approved reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'send_approved',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_APPROVED'),
                                                    'value' => $settings_notifications->send_approved,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_APPROVED_HELP')));
                    /*
                     * Send on canceled reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'send_canceled',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_CANCELED'),
                                                    'value' => $settings_notifications->send_canceled,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_CANCELED_HELP')));
                    /*
                     * Send on rejected reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'send_rejected',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_REJECTED'),
                                                    'value' => $settings_notifications->send_rejected,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_REJECTED_HELP'),
                                                    'container_class' => 'dopbsp-last'));
                    
/*
 * ACTION HOOK (dopbsp_action_views_settings_notifications) ***************** Add payment gateways settings.
 */
                    do_action('dopbsp_action_views_settings_notifications', array('id' => $id,
                                                                                  'settings_notifications' => $settings_notifications));
?>
                </div>
<?php
            }
            
            /*
             * Returns notifications SMTP settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_notifications (object): notifications settings
             * 
             * @return SMTP settings HTML
             */
            function templateSMTP($id,
                                  $settings_notifications){
                global $DOPBSP;
?>
                 <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_TITLE'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('settings-notifications-smtp')" id="DOPBSP-inputs-button-settings-notifications-smtp" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-settings-notifications-smtp" class="dopbsp-inputs-wrapper">
<?php
                    /*
                     * SMTP host name.
                     */
                    $this->displayTextInput(array('id' => 'smtp_host_name',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME'),
                                                  'value' => $settings_notifications->smtp_host_name,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME_HELP')));
                    /*
                     * SMTP host port.
                     */
                    $this->displayTextInput(array('id' => 'smtp_host_port',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT'),
                                                  'value' => $settings_notifications->smtp_host_port,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT_HELP')));
                    /*
                     * SMTP ssl.
                     */
                    $this->displaySwitchInput(array('id' => 'smtp_ssl',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_SSL'),
                                                    'value' => $settings_notifications->smtp_ssl,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_SSL_HELP')));
                    /*
                     * SMTP tls.
                     */
                    $this->displaySwitchInput(array('id' => 'smtp_tls',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_TLS'),
                                                    'value' => $settings_notifications->smtp_tls,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_TLS_HELP')));
                    /*
                     * SMTP username.
                     */
                    $this->displayTextInput(array('id' => 'smtp_user',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_USER'),
                                                  'value' => $settings_notifications->smtp_user,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_USER_HELP')));
                    /*
                     * SMTP password.
                     */
                    $this->displayTextInput(array('id' => 'smtp_password',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_PASSWORD'),
                                                  'value' => $settings_notifications->smtp_password,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_PASSWORD_HELP'),
                                                  'container_class' => 'dopbsp-last',
                                                  'is_password' => true));
?>
                </div>
<?php
            }
            
            /*
             * Returns notifications second SMTP settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_notifications (object): notifications settings
             * 
             * @return second SMTP settings HTML
             */
            function templateSMTP2($id,
                                   $settings_notifications){
                global $DOPBSP;
?>
                 <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_SECOND_TITLE'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('settings-notifications-smtp2')" id="DOPBSP-inputs-button-settings-notifications-smtp2" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-settings-notifications-smtp2" class="dopbsp-inputs-wrapper">
<?php
                    /*
                     * SMTP host name.
                     */
                    $this->displayTextInput(array('id' => 'smtp_host_name2',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME'),
                                                  'value' => $settings_notifications->smtp_host_name2,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME_HELP')));
                    /*
                     * SMTP host port.
                     */
                    $this->displayTextInput(array('id' => 'smtp_host_port2',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT'),
                                                  'value' => $settings_notifications->smtp_host_port2,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT_HELP')));
                    /*
                     * SMTP ssl.
                     */
                    $this->displaySwitchInput(array('id' => 'smtp_ssl2',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_SSL'),
                                                    'value' => $settings_notifications->smtp_ssl2,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_SSL_HELP')));
                    /*
                     * SMTP tls.
                     */
                    $this->displaySwitchInput(array('id' => 'smtp_tls2',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_TLS'),
                                                    'value' => $settings_notifications->smtp_tls2,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_TLS_HELP')));
                    /*
                     * SMTP username.
                     */
                    $this->displayTextInput(array('id' => 'smtp_user2',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_USER'),
                                                  'value' => $settings_notifications->smtp_user2,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_USER_HELP')));
                    /*
                     * SMTP password.
                     */
                    $this->displayTextInput(array('id' => 'smtp_password2',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_PASSWORD'),
                                                  'value' => $settings_notifications->smtp_password2,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_PASSWORD_HELP'),
                                                  'container_class' => 'dopbsp-last',
                                                  'is_password' => true));
?>
                </div>
<?php
            }
            
            /*
             * Returns notifications test template.
             * 
             * @param id (integer): calendar ID
             * 
             * @return notifications test HTML
             */
            function templateTest($id){
                global $DOPBSP;
?>
                 <div class="dopbsp-inputs-header dopbsp-last dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_TITLE'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('settings-notifications-test')" id="DOPBSP-inputs-button-settings-notifications-test" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-settings-notifications-test" class="dopbsp-inputs-wrapper">
                    <!--
                        Notifications test.
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-settings-notifications-test-method"><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_METHOD'); ?></label>
                        <select name="DOPBSP-settings-notifications-test-method" id="DOPBSP-settings-notifications-test-method" class="dopbsp-left">
                            <option value="mailer">PHPMailer</option>
                            <option value="mail">PHP mail()</option>
                            <option value="smtp">SMTP</option>
                            <option value="smtp2">SMTP 2</option>
                            <option value="wp">WordPress wp_mail()</option>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-settings-notifications-test-method').DOPSelect();</script>
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_METHOD_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                    
                    <!--
                        Test email.
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-settings-notifications-test-email"><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_EMAIL'); ?></label>
                        <input type="text" name="DOPBSP-settings-notifications-test-email" id="DOPBSP-settings-notifications-test-email" value="" />
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_EMAIL_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                    
                    <!--
                        Submit button.
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label>&nbsp;</label>
                        <input type="button" name="DOPBSP-settings-test-submit" id="DOPBSP-settings-test-submit" value="<?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_SUBMIT'); ?>" onclick="DOPBSPBackEndSettingsNotifications.test(<?php echo $id; ?>)" />
                    </div>
                </div>
<?php
            }
            
            /*
             * Returns SMS notifications - Clickatell.com settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_notifications (object): notifications settings
             * 
             * @return SMS notifications - Clickatell.com settings HTML
             */
            function templateSMSClickatell($id,
                                           $settings_notifications){
                global $DOPBSP;
?>
                 <div class="dopbsp-inputs-header dopbsp-last dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_TITLE'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('settings-notifications-sms-clickatell')" id="DOPBSP-inputs-button-settings-notifications-sms-clickatell" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-settings-notifications-sms-clickatell" class="dopbsp-inputs-wrapper dopbsp-last">
                    <!--
                        SMS notifications.
                    -->
<?php
                    /*
                    * Select SMS template.
                    */
                    $this->displaySelectInput(array('id' => 'sms_templates',
                                'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_TEMPLATES'),
                                'value' => $settings_notifications->sms_templates,
                                'settings_id' => $id,
                                'settings_type' => 'notifications',
                                'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_TEMPLATES_HELP'),
                                'options' => $this->listSMSes('labels'),
                                'options_values' => $this->listSMSes('ids')));

                    /*
                     * Clickatell account type.
                     */
                    $this->displaySelectInput(array('id' => 'clickatell_account_type',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ACCOUNT_TYPE'),
                                                    'value' => $settings_notifications->clickatell_account_type,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ACCOUNT_TYPE_HELP'),
                                                    'options' => 'Developer Central;;SMS Platform',
                                                    'options_values' => 'central;;platform'));
                    /*
                     * API Username.
                     */
                    $this->displayTextInput(array('id' => 'clickatell_username',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_USERNAME'),
                                                  'value' => $settings_notifications->clickatell_username,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_USERNAME_HELP')));
                    
                    /*
                     * API Password.
                     */
                    $this->displayTextInput(array('id' => 'clickatell_password',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_PASSWORD'),
                                                  'value' => $settings_notifications->clickatell_password,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_PASSWORD_HELP')));
                    
                    /*
                     * API ID.
                     */
                    $this->displayTextInput(array('id' => 'clickatell_api_id',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_API_ID'),
                                                  'value' => $settings_notifications->clickatell_api_id,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_API_ID_HELP')));
                    
                    /*
                     * FROM text.
                     */
                    $this->displayTextInput(array('id' => 'clickatell_from',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_FROM'),
                                                  'value' => $settings_notifications->clickatell_from,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_FROM_HELP')));
                    /*
                     * User notifications method.
                     */
                    $this->displayPhones(array('id' => 'phone_numbers',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ADMIN_PHONE'),
                                                    'value' => $settings_notifications->phone_numbers,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ADMIN_PHONE_HELP'),
                                                    'options' => 'Abkhazia;;Afghanistan;;Albania;;Algeria;;American Samoa;;Andorra;;Angola;;Anguilla;;Antigua and Barbuda;;Argentina;;Armenia;;Aruba;;Ascension;;Australia, Christmas Island and Cocos-Keeling Islands;;Australian External Territories;;Austria;;Azerbaijan;;Bahamas;;Bahrain;;Bangladesh;;Barbados;;Barbuda;;Belarus;;Belgium;;Belize;;Benin;;Bermuda;;Bhutan;;Bolivia;;Bosnia and Herzegovina;;Botswana;;Brazil;;British Indian Ocean Territory;;British Virgin Islands;;Brunei;;Bulgaria;;Burkina Faso;;Burundi;;Cambodia;;Cameroon;;Canada;;Cape Verde;;Cayman Islands;;Central African Republic;;Chad;;Chile;;China;;Christmas Island;;Cocos-Keeling Islands;;Colombia;;Comoros;;Congo;;Congo, Dem. Rep. of (Zaire);;Cook Islands;;Costa Rica;;Croatia;;Cuba;;Curacao;;Cyprus;;Czech Republic;;Denmark;;Diego Garcia;;Djibouti;;Dominica;;Dominican Republic;;East Timor;;Easter Island;;Ecuador;;Egypt;;El Salvador;;Equatorial Guinea;;Eritrea;;Estonia;;Ethiopia;;Falkland Islands;;Faroe Islands;;Fiji;;Finland;;France;;French Antilles;;French Guiana;;French Polynesia;;Gabon;;Gambia;;Georgia;;Germany;;Ghana;;Gibraltar;;Greece;;Greenland;;Grenada;;Guadeloupe;;Guam;;Guatemala;;Guinea;;Guinea-Bissau;;Guyana;;Haiti;;Honduras;;Hong Kong SAR China;;Hungary;;Iceland;;India;;Indonesia;;Iran;;Iraq;;Ireland;;Israel;;Italy;;Ivory Coast;;Jamaica;;Japan;;Jordan;;Kazakhstan;;Kenya;;Kiribati;;Kuwait;;Kyrgyzstan;;Laos;;Latvia;;Lebanon;;Lesotho;;Liberia;;Libya;;Liechtenstein;;Lithuania;;Luxembourg;;Macau SAR China;;Macedonia;;Madagascar;;Malawi;;Malaysia;;Maldives;;Mali;;Malta;;Marshall Islands;;Martinique;;Mauritania;;Mauritius;;Mayotte;;Mexico;;Micronesia;;Midway Island;;Moldova;;Monaco;;Mongolia;;Montenegro;;Montserrat;;Morocco;;Myanmar;;Namibia;;Nauru;;Nepal;;Netherlands;;Netherlands Antilles;;Nevis;;New Caledonia;;New Zealand;;Nicaragua;;Niger;;Nigeria;;Niue;;Norfolk Island;;North Korea;;Northern Mariana Islands;;Norway;;Oman;;Pakistan;;Palau;;Palestinian Territory;;Panama;;Papua New Guinea;;Paraguay;;Peru;;Philippines;;Poland;;Portugal;;Puerto Rico;;Qatar;;Reunion;;Romania;;Russia;;Rwanda;;Samoa;;San Marino;;Saudi Arabia;;Senegal;;Serbia;;Seychelles;;Sierra Leone;;Singapore;;Slovakia;;Slovenia;;Solomon Islands;;South Africa;;South Georgia and the South Sandwich Islands;;South Korea;;Spain;;Sri Lanka;;Sudan;;Suriname;;Swaziland;;Sweden;;Switzerland;;Syria;;Taiwan;;Tajikistan;;Tanzania;;Thailand;;Timor Leste;;Togo;;Tokelau;;Tonga;;Trinidad and Tobago;;Tunisia;;Turkey;;Turkmenistan;;Turks and Caicos Islands;;Tuvalu;;U.S. Virgin Islands;;Uganda;;Ukraine;;United Arab Emirates;;United Kingdom;;United States;;Uruguay;;Uzbekistan;;Vanuatu;;Venezuela;;Vietnam;;Wake Island;;Wallis and Futuna;;Yemen;;Zambia;;Zanzibar;;Zimbabwe',
                                                    'options_values' => '+7 840;;+93;;+355;;+213;;+1 684;;+376;;+244;;+1 264;;+1 268;;+54;;+374;;+297;;+247;;+61;;+672;;+43;;+994;;+1 242;;+973;;+880;;+1 246;;+1 268;;+375;;+32;;+501;;+229;;+1 441;;+975;;+591;;+387;;+267;;+55;;+246;;+1 284;;+673;;+359;;+226;;+257;;+855;;+237;;+1;;+238;;+ 345;;+236;;+235;;+56;;+86;;+57;;+269;;+242;;+243;;+682;;+506;;+385;;+53;;+599;;+357;;+420;;+45;;+246;;+253;;+1 767;;+1 809;;+670;;+56;;+593;;+20;;+503;;+240;;+291;;+372;;+251;;+500;;+298;;+679;;+358;;+33;;+596;;+594;;+689;;+241;;+220;;+995;;+49;;+233;;+350;;+30;;+299;;+1 473;;+590;;+1 671;;+502;;+224;;+245;;+595;;+509;;+504;;+852;;+36;;+354;;+91;;+62;;+98;;+964;;+353;;+972;;+39;;+225;;+1 876;;+81;;+962;;+7 7;;+254;;+686;;+965;;+996;;+856;;+371;;+961;;+266;;+231;;+218;;+423;;+370;;+352;;+853;;+389;;+261;;+265;;+60;;+960;;+223;;+356;;+692;;+596;;+222;;+230;;+262;;+52;;+691;;+1 808;;+373;;+377;;+976;;+382;;+1664;;+212;;+95;;+264;;+674;;+977;;+31;;+599;;+1 869;;+687;;+64;;+505;;+227;;+234;;+683;;+672;;+850;;+1 670;;+47;;+968;;+92;;+680;;+970;;+507;;+675;;+595;;+51;;+63;;+48;;+351;;+1 787;;+974;;+262;;+40;;+7;;+250;;+685;;+378;;+966;;+221;;+381;;+248;;+232;;+65;;+421;;+386;;+677;;+27;;+500;;+82;;+34;;+94;;+249;;+597;;+268;;+46;;+41;;+963;;+886;;+992;;+255;;+66;;+670;;+228;;+690;;+676;;+1 868;;+216;;+90;;+993;;+1 649;;+688;;+1 340;;+256;;+380;;+971;;+44;;+1;;+598;;+998;;+678;;+58;;+84;;+1 808;;+681;;+967;;+260;;+255;;+263'));
                    /*
                     * Send on book request to admin.
                     */
                    $this->displaySwitchInput(array('id' => 'clickatell_send_book_admin',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN'),
                                                    'value' => $settings_notifications->clickatell_send_book_admin,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_ADMIN_HELP')));
                    /*
                     * Send on book request to user.
                     */
                    $this->displaySwitchInput(array('id' => 'clickatell_send_book_user',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_USER'),
                                                    'value' => $settings_notifications->clickatell_send_book_user,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_USER_HELP')));
                    /*
                     * Send on book with approval request to admin.
                     */
                    $this->displaySwitchInput(array('id' => 'clickatell_send_book_with_approval_admin',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN'),
                                                    'value' => $settings_notifications->clickatell_send_book_with_approval_admin,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_WITH_APPROVAL_ADMIN_HELP')));
                    /*
                     * Send on book with approval request to user.
                     */
                    $this->displaySwitchInput(array('id' => 'clickatell_send_book_with_approval_user',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER'),
                                                    'value' => $settings_notifications->clickatell_send_book_with_approval_user,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_WITH_APPROVAL_USER_HELP')));
                    /*
                     * Send on approved reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'clickatell_send_approved',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_APPROVED'),
                                                    'value' => $settings_notifications->clickatell_send_approved,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_SEND_APPROVED_HELP')));
                    /*
                     * Send on canceled reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'clickatell_send_canceled',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_CANCELED'),
                                                    'value' => $settings_notifications->clickatell_send_canceled,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_SEND_CANCELED_HELP')));
                    /*
                     * Send on rejected reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'clickatell_send_rejected',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_REJECTED'),
                                                    'value' => $settings_notifications->clickatell_send_rejected,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMS_SEND_REJECTED_HELP'),
                                                    'container_class' => 'dopbsp-last'));
?>
                </div>
<?php
            }
        }
    }