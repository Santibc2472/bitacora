<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/order/class-frontend-order.php
* File Version            : 1.0.6
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end order PHP class.
*/

    if (!class_exists('DOPBSPFrontEndOrder')){
        class DOPBSPFrontEndOrder extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get order.
             * 
             * @param settings (object): calendar settings
             * @param settings_payment (object): payment settings
             * 
             * @return data array
             */
            function get($settings,
                         $settings_payment){
                global $DOPBSP;
                
                $payment_gateways = array();
                
                $pg_list = $DOPBSP->classes->payment_gateways->get();
                
                for ($i=0; $i<count($pg_list); $i++){
                    $pg_id = $pg_list[$i];
                    $enabled_field = $pg_id.'_enabled';
                    $outward_field = $pg_id.'_outward';
                    $refund_field = $pg_id.'_refund_enabled';
                    
                    if ($settings_payment->$enabled_field == 'true'){
                        $payment_gateways[$pg_id] = array('data' => array('address_billing' => apply_filters('dopbsp_filter_payment_gateways_'.$pg_id.'_order_address_billing', array('address_first' => array('enabled' => $settings_payment->address_billing_address_first_enabled == 'true' ? true:false,
                                                                                                                                                                                                               'required' => $settings_payment->address_billing_address_first_required == 'true' ? true:false),
                                                                                                                                                                                      'address_second' => array('enabled' => $settings_payment->address_billing_address_second_enabled == 'true' ? true:false,
                                                                                                                                                                                                                'required' => $settings_payment->address_billing_address_second_required == 'true' ? true:false),
                                                                                                                                                                                      'city' => array('enabled' => $settings_payment->address_billing_city_enabled == 'true' ? true:false,
                                                                                                                                                                                                      'required' => $settings_payment->address_billing_city_required == 'true' ? true:false),
                                                                                                                                                                                      'company' => array('enabled' => $settings_payment->address_billing_company_enabled == 'true' ? true:false,
                                                                                                                                                                                                         'required' => $settings_payment->address_billing_company_required == 'true' ? true:false),
                                                                                                                                                                                      'country' => array('enabled' => $settings_payment->address_billing_country_enabled == 'true' ? true:false,
                                                                                                                                                                                                         'required' => $settings_payment->address_billing_country_required == 'true' ? true:false),
                                                                                                                                                                                      'email' => array('enabled' => $settings_payment->address_billing_email_enabled == 'true' ? true:false,
                                                                                                                                                                                                       'required' => $settings_payment->address_billing_email_required == 'true' ? true:false),
                                                                                                                                                                                      'enabled' => $settings_payment->address_billing_enabled == 'true' ? true:false,
                                                                                                                                                                                      'first_name' => array('enabled' => $settings_payment->address_billing_first_name_enabled == 'true' ? true:false,
                                                                                                                                                                                                            'required' => $settings_payment->address_billing_first_name_required == 'true' ? true:false),
                                                                                                                                                                                      'last_name' => array('enabled' => $settings_payment->address_billing_last_name_enabled == 'true' ? true:false,
                                                                                                                                                                                                           'required' => $settings_payment->address_billing_last_name_required == 'true' ? true:false),
                                                                                                                                                                                      'phone' => array('enabled' => $settings_payment->address_billing_phone_enabled == 'true' ? true:false,
                                                                                                                                                                                                       'required' => $settings_payment->address_billing_phone_required == 'true' ? true:false),
                                                                                                                                                                                      'state' => array('enabled' => $settings_payment->address_billing_state_enabled == 'true' ? true:false,
                                                                                                                                                                                                       'required' => $settings_payment->address_billing_state_required == 'true' ? true:false),
                                                                                                                                                                                      'zip_code' => array('enabled' => $settings_payment->address_billing_zip_code_enabled == 'true' ? true:false,
                                                                                                                                                                                                          'required' => $settings_payment->address_billing_zip_code_required == 'true' ? true:false))),
                                                                          'address_shipping' => apply_filters('dopbsp_filter_payment_gateways_'.$pg_id.'_order_address_shipping', array('address_first' => array('enabled' => $settings_payment->address_shipping_address_first_enabled == 'true' ? true:false,
                                                                                                                                                                                                                 'required' => $settings_payment->address_shipping_address_first_required == 'true' ? true:false),
                                                                                                                                                                                        'address_second' => array('enabled' => $settings_payment->address_shipping_address_second_enabled == 'true' ? true:false,
                                                                                                                                                                                                                  'required' => $settings_payment->address_shipping_address_second_required == 'true' ? true:false),
                                                                                                                                                                                        'city' => array('enabled' => $settings_payment->address_shipping_city_enabled == 'true' ? true:false,
                                                                                                                                                                                                        'required' => $settings_payment->address_shipping_city_required == 'true' ? true:false),
                                                                                                                                                                                        'company' => array('enabled' => $settings_payment->address_shipping_company_enabled == 'true' ? true:false,
                                                                                                                                                                                                           'required' => $settings_payment->address_shipping_company_required == 'true' ? true:false),
                                                                                                                                                                                        'country' => array('enabled' => $settings_payment->address_shipping_country_enabled == 'true' ? true:false,
                                                                                                                                                                                                           'required' => $settings_payment->address_shipping_country_required == 'true' ? true:false),
                                                                                                                                                                                        'email' => array('enabled' => $settings_payment->address_shipping_email_enabled == 'true' ? true:false,
                                                                                                                                                                                                         'required' => $settings_payment->address_shipping_email_required == 'true' ? true:false),
                                                                                                                                                                                        'enabled' => $settings_payment->address_shipping_enabled == 'true' ? true:false,
                                                                                                                                                                                        'first_name' => array('enabled' => $settings_payment->address_shipping_first_name_enabled == 'true' ? true:false,
                                                                                                                                                                                                              'required' => $settings_payment->address_shipping_first_name_required == 'true' ? true:false),
                                                                                                                                                                                        'last_name' => array('enabled' => $settings_payment->address_shipping_last_name_enabled == 'true' ? true:false,
                                                                                                                                                                                                             'required' => $settings_payment->address_shipping_last_name_required == 'true' ? true:false),
                                                                                                                                                                                        'phone' => array('enabled' => $settings_payment->address_shipping_phone_enabled == 'true' ? true:false,
                                                                                                                                                                                                         'required' => $settings_payment->address_shipping_phone_required == 'true' ? true:false),
                                                                                                                                                                                        'state' => array('enabled' => $settings_payment->address_shipping_state_enabled == 'true' ? true:false,
                                                                                                                                                                                                         'required' => $settings_payment->address_shipping_state_required == 'true' ? true:false),
                                                                                                                                                                                        'zip_code' => array('enabled' => $settings_payment->address_shipping_zip_code_enabled == 'true' ? true:false,
                                                                                                                                                                                                            'required' => $settings_payment->address_shipping_zip_code_required == 'true' ? true:false))),
                                                                          'card' => apply_filters('dopbsp_filter_payment_gateways_'.$pg_id.'_order_card', array('enabled' => $settings_payment->$outward_field == 'true' ? false:true,
                                                                                                                                                                'expiration_date_month' => array('attribute' => '',
                                                                                                                                                                                                 'enabled' => false,
                                                                                                                                                                                                 'value' => ''),
                                                                                                                                                                'expiration_date_year' => array('attribute' => '',
                                                                                                                                                                                                'enabled' => false,
                                                                                                                                                                                                'value' => ''),
                                                                                                                                                                'name' => array('attribute' => '',
                                                                                                                                                                                'enabled' => false,
                                                                                                                                                                                'value' => ''),
                                                                                                                                                                'number' => array('attribute' => '',
                                                                                                                                                                                  'enabled' => false,
                                                                                                                                                                                  'value' => ''),
                                                                                                                                                                'security_code' => array('attribute' => '',
                                                                                                                                                                                         'enabled' => false,
                                                                                                                                                                                         'value' => ''))),
                                                                          'form_addon' => apply_filters('dopbsp_filter_payment_gateways_'.$pg_id.'_form_addon', array(), $settings_payment->calendar_id),
                                                                          'refund' => $settings_payment->$refund_field == 'true' ? true:false,
                                                                          'token' => apply_filters('dopbsp_filter_payment_gateways_'.$pg_id.'_order_token', array('enabled' => false,
                                                                                                                                                                  'function' => ''), 
                                                                                                                                                            $settings_payment->calendar_id)),
                                                          'id' => $pg_id,
                                                          'text' => array('cancel' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_CANCEL'),
                                                                          'card_expiration_date' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_CARD_EXPIRATION_DATE'),
                                                                          'card_name' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_CARD_NAME'),
                                                                          'card_number' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_CARD_NUMBER'),
                                                                          'card_security_code' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_CARD_SECURITY_CODE'),
                                                                          'card_title' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_CARD_TITLE'),
                                                                          'error' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_ERROR'),
                                                                          'label' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id)),
                                                                          'success' => $DOPBSP->text('ORDER_PAYMENT_GATEWAYS_'.strtoupper($pg_id).'_SUCCESS'),
                                                                          'title' => $DOPBSP->text('ORDER_PAYMENT_METHOD_'.strtoupper($pg_id))));
                    }
                }
                
                return array('data' => array('address_billing' => array('address_first' => array('enabled' => $settings_payment->address_billing_address_first_enabled == 'true' ? true:false,
                                                                                                 'required' => $settings_payment->address_billing_address_first_required == 'true' ? true:false),
                                                                        'address_second' => array('enabled' => $settings_payment->address_billing_address_second_enabled == 'true' ? true:false,
                                                                                                  'required' => $settings_payment->address_billing_address_second_required == 'true' ? true:false),
                                                                        'city' => array('enabled' => $settings_payment->address_billing_city_enabled == 'true' ? true:false,
                                                                                        'required' => $settings_payment->address_billing_city_required == 'true' ? true:false),
                                                                        'company' => array('enabled' => $settings_payment->address_billing_company_enabled == 'true' ? true:false,
                                                                                           'required' => $settings_payment->address_billing_company_required == 'true' ? true:false),
                                                                        'country' => array('enabled' => $settings_payment->address_billing_country_enabled == 'true' ? true:false,
                                                                                           'required' => $settings_payment->address_billing_country_required == 'true' ? true:false),
                                                                        'email' => array('enabled' => $settings_payment->address_billing_email_enabled == 'true' ? true:false,
                                                                                         'required' => $settings_payment->address_billing_email_required == 'true' ? true:false),
                                                                        'enabled' => $settings_payment->address_billing_enabled == 'true' ? true:false,
                                                                        'first_name' => array('enabled' => $settings_payment->address_billing_first_name_enabled == 'true' ? true:false,
                                                                                              'required' => $settings_payment->address_billing_first_name_required == 'true' ? true:false),
                                                                        'last_name' => array('enabled' => $settings_payment->address_billing_last_name_enabled == 'true' ? true:false,
                                                                                             'required' => $settings_payment->address_billing_last_name_required == 'true' ? true:false),
                                                                        'phone' => array('enabled' => $settings_payment->address_billing_phone_enabled == 'true' ? true:false,
                                                                                         'required' => $settings_payment->address_billing_phone_required == 'true' ? true:false),
                                                                        'state' => array('enabled' => $settings_payment->address_billing_state_enabled == 'true' ? true:false,
                                                                                         'required' => $settings_payment->address_billing_state_required == 'true' ? true:false),
                                                                        'zip_code' => array('enabled' => $settings_payment->address_billing_zip_code_enabled == 'true' ? true:false,
                                                                                            'required' => $settings_payment->address_billing_zip_code_required == 'true' ? true:false)),
                                             'address_shipping' => array('address_first' => array('enabled' => $settings_payment->address_shipping_address_first_enabled == 'true' ? true:false,
                                                                                                  'required' => $settings_payment->address_shipping_address_first_required == 'true' ? true:false),
                                                                         'address_second' => array('enabled' => $settings_payment->address_shipping_address_second_enabled == 'true' ? true:false,
                                                                                                   'required' => $settings_payment->address_shipping_address_second_required == 'true' ? true:false),
                                                                         'city' => array('enabled' => $settings_payment->address_shipping_city_enabled == 'true' ? true:false,
                                                                                         'required' => $settings_payment->address_shipping_city_required == 'true' ? true:false),
                                                                         'company' => array('enabled' => $settings_payment->address_shipping_company_enabled == 'true' ? true:false,
                                                                                            'required' => $settings_payment->address_shipping_company_required == 'true' ? true:false),
                                                                         'country' => array('enabled' => $settings_payment->address_shipping_country_enabled == 'true' ? true:false,
                                                                                            'required' => $settings_payment->address_shipping_country_required == 'true' ? true:false),
                                                                         'email' => array('enabled' => $settings_payment->address_shipping_email_enabled == 'true' ? true:false,
                                                                                          'required' => $settings_payment->address_shipping_email_required == 'true' ? true:false),
                                                                         'enabled' => $settings_payment->address_shipping_enabled == 'true' ? true:false,
                                                                         'first_name' => array('enabled' => $settings_payment->address_shipping_first_name_enabled == 'true' ? true:false,
                                                                                               'required' => $settings_payment->address_shipping_first_name_required == 'true' ? true:false),
                                                                         'last_name' => array('enabled' => $settings_payment->address_shipping_last_name_enabled == 'true' ? true:false,
                                                                                              'required' => $settings_payment->address_shipping_last_name_required == 'true' ? true:false),
                                                                         'phone' => array('enabled' => $settings_payment->address_shipping_phone_enabled == 'true' ? true:false,
                                                                                          'required' => $settings_payment->address_shipping_phone_required == 'true' ? true:false),
                                                                         'state' => array('enabled' => $settings_payment->address_shipping_state_enabled == 'true' ? true:false,
                                                                                          'required' => $settings_payment->address_shipping_state_required == 'true' ? true:false),
                                                                         'zip_code' => array('enabled' => $settings_payment->address_shipping_zip_code_enabled == 'true' ? true:false,
                                                                                             'required' => $settings_payment->address_shipping_zip_code_required == 'true' ? true:false)),
                                             'countries' => $DOPBSP->classes->countries->countries,
                                             'paymentArrival' => $settings_payment->arrival_enabled == 'true' ? true:false,
                                             'paymentArrivalWithApproval' => $settings_payment->arrival_with_approval_enabled == 'true' ? true:false,
                                             'paymentGateways' => $payment_gateways,
                                             'redirect' => $settings_payment->redirect,
                                             'termsAndConditions' => $settings->terms_and_conditions_enabled == 'true' ? true:false,
                                             'termsAndConditionsLink' => $settings->terms_and_conditions_link),
                             'text' => array('addressAddressFirst' => $DOPBSP->text('ORDER_ADDRESS_ADDRESS_FIRST'),
                                             'addressAddressSecond' => $DOPBSP->text('ORDER_ADDRESS_ADDRESS_SECOND'),
                                             'addressBilling' => $DOPBSP->text('ORDER_ADDRESS_BILLING'),
                                             'addressBillingDisabled' => $DOPBSP->text('ORDER_ADDRESS_BILLING_DISABLED'),
                                             'addressCity' => $DOPBSP->text('ORDER_ADDRESS_CITY'),
                                             'addressCompany' => $DOPBSP->text('ORDER_ADDRESS_COMPANY'),
                                             'addressCountry' => $DOPBSP->text('ORDER_ADDRESS_COUNTRY'),
                                             'addressEmail' => $DOPBSP->text('ORDER_ADDRESS_EMAIL'),
                                             'addressFirstName' => $DOPBSP->text('ORDER_ADDRESS_FIRST_NAME'),
                                             'addressLastName' => $DOPBSP->text('ORDER_ADDRESS_LAST_NAME'),
                                             'addressPhone' => $DOPBSP->text('ORDER_ADDRESS_PHONE'),
                                             'addressSelectPaymentMethod' => $DOPBSP->text('ORDER_ADDRESS_SELECT_PAYMENT_METHOD'),
                                             'addressShipping' => $DOPBSP->text('ORDER_ADDRESS_SHIPPING'),
                                             'addressShippingCopy' => $DOPBSP->text('ORDER_ADDRESS_SHIPPING_COPY'),
                                             'addressShippingDisabled' => $DOPBSP->text('ORDER_ADDRESS_SHIPPING_DISABLED'),
                                             'addressState' => $DOPBSP->text('ORDER_ADDRESS_STATE'),
                                             'addressZipCode' => $DOPBSP->text('ORDER_ADDRESS_ZIP_CODE'),
                                             'book' => $DOPBSP->text('ORDER_BOOK'),
                                             'paymentArrival' => $DOPBSP->text('ORDER_PAYMENT_ARRIVAL'),
                                             'paymentArrivalWithApproval' => $DOPBSP->text('ORDER_PAYMENT_ARRIVAL_WITH_APPROVAL'),
                                             'paymentArrivalSuccess' => $DOPBSP->text('ORDER_PAYMENT_ARRIVAL_SUCCESS'),
                                             'paymentArrivalWithApprovalSuccess' => $DOPBSP->text('ORDER_PAYMENT_ARRIVAL_WITH_APPROVAL_SUCCESS'),
                                             'paymentMethod' => $DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                             'paymentFull' => $DOPBSP->text('ORDER_PAYMENT_FULL_AMOUNT'),
                                             'paymentMethodNone' => $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'),
                                             'paymentMethodArrival' => $DOPBSP->text('ORDER_PAYMENT_METHOD_ARRIVAL'),
                                             'paymentMethodTransactionID' => $DOPBSP->text('ORDER_PAYMENT_METHOD_TRANSACTION_ID'),
                                             'paymentMethodWooCommerce' => $DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE'),
                                             'paymentMethodWooCommerceOrderID' => $DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE_ORDER_ID'),
                                             'success' => $DOPBSP->text('RESERVATIONS_RESERVATION_ADD_SUCCESS'),
                                             'termsAndConditions' => $DOPBSP->text('ORDER_TERMS_AND_CONDITIONS'),
                                             'termsAndConditionsInvalid' => $DOPBSP->text('ORDER_TERMS_AND_CONDITIONS_INVALID'),
                                             'title' => $DOPBSP->text('ORDER_TITLE'),
                                             'unavailable' => $DOPBSP->text('ORDER_UNAVAILABLE'),
                                             'unavailableCoupon' => $DOPBSP->text('ORDER_UNAVAILABLE_COUPON')));
            }
        }
    }