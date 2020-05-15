<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/settings/views-backend-settings-payment-gateways.php
* File Version            : 1.0.9
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end payment gateways settings views class.
*/

    if (!class_exists('DOPBSPViewsBackEndSettingsPaymentGateways')){
        class DOPBSPViewsBackEndSettingsPaymentGateways extends DOPBSPViewsBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns payment gateways settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             * 
             * @return payment gateways settings HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                
                $settings_payment = $DOPBSP->classes->backend_settings->values($id,  
                                                                               'payment');
?>
                <div class="dopbsp-inputs-wrapper">
<?php            
                    /*
                     * Pay on arrival.
                     */
                    $this->displaySwitchInput(array('id' => 'arrival_enabled',
                                                    'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED'),
                                                    'value' => $settings_payment->arrival_enabled,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'payment',
                                                    'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED_HELP'),
                                                    'container_class' => ''));  
                    /*
                     * Pay on arrival with approval.
                     */
                    $this->displaySwitchInput(array('id' => 'arrival_with_approval_enabled',
                                                    'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED'),
                                                    'value' => $settings_payment->arrival_with_approval_enabled,
                                                    'settings_id' => $id,
                                                    'settings_type' => 'payment',
                                                    'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED_HELP')));
                    /*
                     * Redirect.
                     */
                    $this->displayTextInput(array('id' => 'redirect',
                                                  'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT'),
                                                  'value' => $settings_payment->redirect,
                                                  'settings_id' => $id,
                                                  'settings_type' => 'payment',
                                                  'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT_HELP'),
                                                  'container_class' => 'dopbsp-last'));
?>
                </div>
<?php
                if (current_user_can( 'manage_options' )) {
?>
                    <div class="dopbsp-inputs-header dopbsp-hide">
                        <h3><?php echo $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDONS_REDIRECT')?> <a href="?page=dopbsp-addons" style="cursor:pointer">add-ons section</a>.</h3>
                    </div>
<?php
                }
                
                $this->templateAddressBilling($id,
                                              $settings_payment);
                $this->templateAddressShipping($id,
                                               $settings_payment);
/*
 * ACTION HOOK (dopbsp_action_views_settings_payment_gateways) ***************** Add payment gateways settings.
 */
                do_action('dopbsp_action_views_settings_payment_gateways', array('id' => $id,
                                                                                 'settings_payment' => $settings_payment));
            }
            
            /*
             * Returns address billing settings template.
             * 
             * @param id (integer): calendar ID
             * @param$settings_calendar (object): payment settings data
             * 
             * @return address billing HTML
             */
            function templateAddressBilling($id,
                                            $settings_payment){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header <?php echo $settings_payment->address_billing_enabled == 'true' ? 'dopbsp-hide':'dopbsp-display'; ?>">
                    <h3><?php echo $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('payment-gateways-address-billing')" id="DOPBSP-inputs-button-payment-gateways-address-billing" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-payment-gateways-address-billing" class="dopbsp-inputs-wrapper <?php echo $settings_payment->address_billing_enabled == 'true' ? 'dopbsp-displayed':'dopbsp-hidden'; ?>">
<?php   
                /*
                 * Enable billing address.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ENABLED'),
                                                'value' => $settings_payment->address_billing_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ENABLED_HELP')));
                /*
                 * Enable first name.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_first_name_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_ENABLED'),
                                                'value' => $settings_payment->address_billing_first_name_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_ENABLED_HELP')));
                /*
                 * Require first name.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_first_name_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_REQUIRED'),
                                                'value' => $settings_payment->address_billing_first_name_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_REQUIRED_HELP')));
                /*
                 * Enable last name.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_last_name_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_ENABLED'),
                                                'value' => $settings_payment->address_billing_last_name_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_ENABLED_HELP')));
                /*
                 * Require last name.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_last_name_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_REQUIRED'),
                                                'value' => $settings_payment->address_billing_last_name_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_REQUIRED_HELP')));
                /*
                 * Enable company.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_company_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_ENABLED'),
                                                'value' => $settings_payment->address_billing_company_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_ENABLED_HELP')));
                /*
                 * Require company.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_company_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_REQUIRED'),
                                                'value' => $settings_payment->address_billing_company_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_REQUIRED_HELP')));
                /*
                 * Enable email.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_email_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_ENABLED'),
                                                'value' => $settings_payment->address_billing_email_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_ENABLED_HELP')));
                /*
                 * Require email.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_email_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_REQUIRED'),
                                                'value' => $settings_payment->address_billing_email_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_REQUIRED_HELP')));
                /*
                 * Enable phone.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_phone_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_ENABLED'),
                                                'value' => $settings_payment->address_billing_phone_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_ENABLED_HELP')));
                /*
                 * Require phone.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_phone_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_REQUIRED'),
                                                'value' => $settings_payment->address_billing_phone_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_REQUIRED_HELP')));
                /*
                 * Enable country.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_country_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_ENABLED'),
                                                'value' => $settings_payment->address_billing_country_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_ENABLED_HELP')));
                /*
                 * Require country.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_country_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_REQUIRED'),
                                                'value' => $settings_payment->address_billing_country_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_REQUIRED_HELP')));
                /*
                 * Enable address line 1.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_address_first_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_ENABLED'),
                                                'value' => $settings_payment->address_billing_address_first_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_ENABLED_HELP')));
                /*
                 * Require address line 1.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_address_first_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_REQUIRED'),
                                                'value' => $settings_payment->address_billing_address_first_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_REQUIRED_HELP')));
                /*
                 * Enable address line 2.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_address_second_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_ENABLED'),
                                                'value' => $settings_payment->address_billing_address_second_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_ENABLED_HELP')));
                /*
                 * Require address line 2.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_address_second_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_REQUIRED'),
                                                'value' => $settings_payment->address_billing_address_second_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_REQUIRED_HELP')));
                /*
                 * Enable city.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_city_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_ENABLED'),
                                                'value' => $settings_payment->address_billing_city_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_ENABLED_HELP')));
                /*
                 * Require city.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_city_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_REQUIRED'),
                                                'value' => $settings_payment->address_billing_city_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_REQUIRED_HELP')));
                /*
                 * Enable state.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_state_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_ENABLED'),
                                                'value' => $settings_payment->address_billing_state_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_ENABLED_HELP')));
                /*
                 * Require state.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_state_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_REQUIRED'),
                                                'value' => $settings_payment->address_billing_state_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_REQUIRED_HELP')));
                /*
                 * Enable zip code.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_zip_code_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_ENABLED'),
                                                'value' => $settings_payment->address_billing_zip_code_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_ENABLED_HELP')));
                /*
                 * Require zip code.
                 */
                $this->displaySwitchInput(array('id' => 'address_billing_zip_code_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_REQUIRED'),
                                                'value' => $settings_payment->address_billing_zip_code_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_REQUIRED_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php                
            }
            
            /*
             * Returns address shipping settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): payment settings data
             * 
             * @return address shipping HTML
             */
            function templateAddressShipping($id,
                                             $settings_payment){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header <?php echo $settings_payment->address_shipping_enabled == 'true' ? 'dopbsp-hide':'dopbsp-display'; ?>">
                    <h3><?php echo $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('payment-gateways-address-shipping')" id="DOPBSP-inputs-button-payment-gateways-address-shipping" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-payment-gateways-address-shipping" class="dopbsp-inputs-wrapper <?php echo $settings_payment->address_shipping_enabled == 'true' ? 'dopbsp-displayed':'dopbsp-hidden'; ?>">
<?php   
                /*
                 * Enable shipping address.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ENABLED'),
                                                'value' => $settings_payment->address_shipping_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ENABLED_HELP')));
                /*
                 * Enable first name.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_first_name_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_ENABLED'),
                                                'value' => $settings_payment->address_shipping_first_name_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_ENABLED_HELP')));
                /*
                 * Require first name.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_first_name_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_first_name_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_REQUIRED_HELP')));
                /*
                 * Enable last name.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_last_name_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_ENABLED'),
                                                'value' => $settings_payment->address_shipping_last_name_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_ENABLED_HELP')));
                /*
                 * Require last name.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_last_name_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_last_name_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_REQUIRED_HELP')));
                /*
                 * Enable company.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_company_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_ENABLED'),
                                                'value' => $settings_payment->address_shipping_company_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_ENABLED_HELP')));
                /*
                 * Require company.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_company_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_company_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_REQUIRED_HELP')));
                /*
                 * Enable email.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_email_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_ENABLED'),
                                                'value' => $settings_payment->address_shipping_email_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_ENABLED_HELP')));
                /*
                 * Require email.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_email_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_email_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_REQUIRED_HELP')));
                /*
                 * Enable phone.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_phone_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_ENABLED'),
                                                'value' => $settings_payment->address_shipping_phone_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_ENABLED_HELP')));
                /*
                 * Require phone.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_phone_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_phone_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_REQUIRED_HELP')));
                /*
                 * Enable country.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_country_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_ENABLED'),
                                                'value' => $settings_payment->address_shipping_country_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_ENABLED_HELP')));
                /*
                 * Require country.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_country_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_country_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_REQUIRED_HELP')));
                /*
                 * Enable address line 1.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_address_first_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_ENABLED'),
                                                'value' => $settings_payment->address_shipping_address_first_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_ENABLED_HELP')));
                /*
                 * Require address line 1.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_address_first_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_address_first_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_REQUIRED_HELP')));
                /*
                 * Enable address line 2.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_address_second_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_ENABLED'),
                                                'value' => $settings_payment->address_billing_address_second_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_ENABLED_HELP')));
                /*
                 * Require address line 2.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_address_second_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_address_second_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_REQUIRED_HELP')));
                /*
                 * Enable city.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_city_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_ENABLED'),
                                                'value' => $settings_payment->address_shipping_city_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_ENABLED_HELP')));
                /*
                 * Require city.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_city_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_city_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_REQUIRED_HELP')));
                /*
                 * Enable state.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_state_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_ENABLED'),
                                                'value' => $settings_payment->address_shipping_state_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_ENABLED_HELP')));
                /*
                 * Require state.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_state_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_state_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_REQUIRED_HELP')));
                /*
                 * Enable zip code.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_zip_code_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_ENABLED'),
                                                'value' => $settings_payment->address_shipping_zip_code_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_ENABLED_HELP')));
                /*
                 * Require zip code.
                 */
                $this->displaySwitchInput(array('id' => 'address_shipping_zip_code_required',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_REQUIRED'),
                                                'value' => $settings_payment->address_shipping_zip_code_required,
                                                'settings_id' => $id,
                                                'settings_type' => 'payment',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_REQUIRED_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php                
            }
        }
    }