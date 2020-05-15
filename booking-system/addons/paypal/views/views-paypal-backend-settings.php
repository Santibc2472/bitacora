<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : addons/paypal/views/views-paypal-backend-settings.php
* File Version            : 1.0.4
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end PayPal settings views class.
*/

    if (!class_exists('DOPBSPPayPalViewsBackEndSettings')){
        class DOPBSPPayPalViewsBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
                add_action('dopbsp_action_views_settings_payment_gateways', array(&$this, 'template'));
                add_action('dopbsp_action_views_settings_notifications', array(&$this, 'templateNotifications'));
            }
            
            /*
             * Returns payment PayPal settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             *                      * settings_payment (object): payment settings
             * 
             * @return PayPal settings HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $settings_payment = $args['settings_payment'];
?>
                <div class="dopbsp-inputs-header dopbsp-last <?php echo $settings_payment->paypal_enabled == 'true' ? 'dopbsp-hide':'dopbsp-display'; ?>">
                    <h3><?php echo $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('paypal')" id="DOPBSP-inputs-button-paypal" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-paypal" class="dopbsp-inputs-wrapper dopbsp-last <?php echo $settings_payment->paypal_enabled == 'true' ? 'dopbsp-displayed':'dopbsp-hidden'; ?>">
<?php
                    /*
                     * Enable PayPal.
                     */
                    $DOPBSP->views->backend_settings->displaySwitchInput(array('id' => 'paypal_enabled',
                                                                               'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED'),
                                                                               'value' => $settings_payment->paypal_enabled,
                                                                               'settings_id' => $id,
                                                                               'settings_type' => 'payment',
                                                                               'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED_HELP'),
                                                                               'container_class' => ''));  
                    /*
                     * Enable credit card.
                     */
                    $DOPBSP->views->backend_settings->displaySwitchInput(array('id' => 'paypal_credit_card',
                                                                               'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD'),
                                                                               'value' => $settings_payment->paypal_credit_card,
                                                                               'settings_id' => $id,
                                                                               'settings_type' => 'payment',
                                                                               'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD_HELP'),
                                                                               'container_class' => '')); 
                    /*
                     * PayPal username.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_username',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME'),
                                                                             'value' => $settings_payment->paypal_username,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME_HELP')));
                    /*
                     * PayPal password.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_password',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD'),
                                                                             'value' => $settings_payment->paypal_password,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD_HELP')));
                    /*
                     * PayPal signature.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_signature',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE'),
                                                                             'value' => $settings_payment->paypal_signature,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE_HELP')));
                    /*
                     * Enable sandbox.
                     */
                    $DOPBSP->views->backend_settings->displaySwitchInput(array('id' => 'paypal_sandbox_enabled',
                                                                               'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED'),
                                                                               'value' => $settings_payment->paypal_sandbox_enabled,
                                                                               'settings_id' => $id,
                                                                               'settings_type' => 'payment',
                                                                               'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED_HELP')));  
                    /*
                     * PayPal sandbox username.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_sandbox_username',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_USERNAME'),
                                                                             'value' => $settings_payment->paypal_sandbox_username,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_USERNAME_HELP')));
                    /*
                     * PayPal sandbox password.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_sandbox_password',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_PASSWORD'),
                                                                             'value' => $settings_payment->paypal_sandbox_password,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_PASSWORD_HELP')));
                    /*
                     * PayPal sandbox signature.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_sandbox_signature',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_SIGNATURE'),
                                                                             'value' => $settings_payment->paypal_sandbox_signature,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_SIGNATURE_HELP')));
                    /*
                     * Enable refunds.
                     */
                    $DOPBSP->views->backend_settings->displaySwitchInput(array('id' => 'paypal_refund_enabled',
                                                                               'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_ENABLED'),
                                                                               'value' => $settings_payment->paypal_refund_enabled,
                                                                               'settings_id' => $id,
                                                                               'settings_type' => 'payment',
                                                                               'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_ENABLED_HELP')));  
                    /*
                     * Refund value.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_refund_value',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_VALUE'),
                                                                             'value' => $settings_payment->paypal_refund_value,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_VALUE_HELP'),
                                                                             'input_class' => 'dopbsp-small'));   
                    /*
                     * Refund type.
                     */
                    $DOPBSP->views->backend_settings->displaySelectInput(array('id' => 'paypal_refund_type',
                                                                               'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE'),
                                                                               'value' => $settings_payment->paypal_refund_type,
                                                                               'settings_id' => $id,
                                                                               'settings_type' => 'payment',
                                                                               'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE_HELP'),
                                                                               'options' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE_FIXED').';;'.$DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE_PERCENT'),
                                                                               'options_values' => 'fixed;;percent'));
                    /*
                     * PayPal redirect.
                     */
                    $DOPBSP->views->backend_settings->displayTextInput(array('id' => 'paypal_redirect',
                                                                             'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT'),
                                                                             'value' => $settings_payment->paypal_redirect,
                                                                             'settings_id' => $id,
                                                                             'settings_type' => 'payment',
                                                                             'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT_HELP'),
                                                                             'container_class' => 'dopbsp-last'));
?>
                </div>
<?php
            }
            
            /*
             * Returns notifications PayPal settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             *                      * settings_notifications (object): notifications settings
             * 
             * @return PayPal settings HTML
             */
            function templateNotifications($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $settings_notifications = $args['settings_notifications'];
                
                /*
                 * Send on PayPal payment to admin.
                 */
                $DOPBSP->views->backend_settings->displaySwitchInput(array('id' => 'send_paypal_admin',
                                                                           'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN'),
                                                                           'value' => $settings_notifications->send_paypal_admin,
                                                                           'settings_id' => $id,
                                                                           'settings_type' => 'notifications',
                                                                           'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN_HELP')));
                /*
                 * Send on PayPal payment to user.
                 */
                $DOPBSP->views->backend_settings->displaySwitchInput(array('id' => 'send_paypal_user',
                                                                           'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER'),
                                                                           'value' => $settings_notifications->send_paypal_user,
                                                                           'settings_id' => $id,
                                                                           'settings_type' => 'notifications',
                                                                           'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER_HELP')));
            }
        }
    }