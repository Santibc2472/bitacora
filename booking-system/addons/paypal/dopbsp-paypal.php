<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.3
* File                    : addons/paypal/dopbsp-paypal.php
* File Version            : 1.1.3
* Created / Last Modified : 21 April 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : PayPal PHP class.
*/

    DOPBSPErrorsHandler::start();
    
    try{
        /*
         * Views
         */
        include_once 'views/views-paypal-backend-settings.php';
        
        /*
         * Classses
         */
        include_once 'includes/class-paypal-settings.php';
        include_once 'includes/class-paypal-translation-text.php';
    }
    catch(Exception $ex){
        add_action('admin_notices', 'dopbspMissingFiles');
    }
    
    DOPBSPErrorsHandler::finish();
        

    if (!class_exists('DOPBSPPayPal')){
        class DOPBSPPayPal{
            /*
             * Private variables.
             */
            private $api_username = '';
            private $api_password = '';
            private $api_signature = '';
            private $api_end_point = '';
            private $credit_card = false;
            private $sandbox = false;
            private $refund = false;
            private $refund_value = 100;
            private $refund_type = 'percent';
            private $redirect = '';
            
            private $version = '64';
            private $sBN_code = 'PP-ECWizard';
            
            private $currency_code = '';
            private $language = 'en';
            private $payment_amount = 0;
            private $payment_type = 'Sale';
            private $url_cancel = '';
            private $url_paypal = '';
            private $url_return = '';
            
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize PayPal.
                 */
                add_filter('dopbsp_filter_payment_gateways', array(&$this, 'init'));
                
                /*
                 * Initialize PayPal settings view.
                 */
                add_filter('dopbsp_filter_views', array(&$this, 'view'));
                
                /*
                 * Pay after a booking request has been made.
                 */
                add_action('dopbsp_action_book_payment', array(&$this, 'pay'), 1);
                
                /*
                 * Refund if a reservation is canceled.
                 */
                add_action('dopbsp_action_cancel_payment', array(&$this, 'refund'));
                
                /*
                 * Initialize payment verification.
                 */
                add_action('init', array(&$this, 'verify'), 11);
                
                /*
                 * Initialize classes.
                 */
                $this->initClasses();
            }
            
            /*
             * Initialize PHP classes.
             */
            function initClasses(){
                /*
                 * Initialize settings class. This class is the 1st initialized.
                 */
                class_exists('DOPBSPPayPalSettings') ? new DOPBSPPayPalSettings():'Class does not exist!';
    
                /*
                 * Initialize translation class. This class is the 2nd initialized.
                 */
                class_exists('DOPBSPPayPalTranslationText') ? new DOPBSPPayPalTranslationText():'Class does not exist!';
            }
            
            /*
             * Initialize PayPal payment gateway.
             * 
             * @param payment_gateways (array): payment gateways list
             * 
             * @return update payment gateways list
             */
            function init($payment_gateways){
                array_push($payment_gateways, 'paypal');
                
                return $payment_gateways;
            }
            
            /*
             * Add view class.
             * 
             * @param views (array): view classes
             * 
             * @return view classes list
             */
            function view($views){
                array_push($views, array('key' => 'backend_settings_paypal',
                                         'name' => 'DOPBSPPayPalViewsBackEndSettings'));
                
                return $views;
            }
            
            /*
             * Pay with PayPal.
             * 
             * @post calendar_id (integer): calendar ID
             * @post language (string): selected language
             * @post currency (string): currency sign
             * @post currency_code (string): ISO 4217 currency code
             * @post cart_data (array): the cart, list of reservations
             * @post form (object): form data
             * @post address_billing_data (array): billing address data
             * @post address_shipping_data (array): shipping address data
             * @post payment_method (string): payment method
             * @post form_addon_data (object): form addon data
             * @post card_data (array): card data
             * @post token (string): payment token (different for payment gateways)
             * @post page_url (string): the page from were the payment is requested
             */
            function pay(){
		global $DOT;
		
                $calendar_id = $DOT->post('calendar_id', 'int');
                $language = $DOT->post('language');
                $currency_code = $DOT->post('currency_code');
                $payment_method = $DOT->post('payment_method');
                $page_url = $DOT->post('page_url');
                $extra_url = '';
                
                if (strpos($page_url, '#') !== false) {
                    $page_url_piecesNew = explode('#',$page_url);
                    $page_url = $page_url_piecesNew[0];
                    $extra_url = $page_url_piecesNew[1];
                }
                
                /*
                 * If selected payment method is PayPal access express checkout API.
                 */
                if ($payment_method == 'paypal'){
                    $this->set($calendar_id);
                    $this->expressCheckOut($calendar_id,
                                           $language,
                                           $currency_code,
                                           $page_url,
                                           $extra_url);
                }
            }
            
            /*
             * Verify if the payment has been successful.
             * 
             * @get dopbsp_pay_action (string): payment actions
             *                                  "cancel" the user canceled the transaction
             *                                  "payed" the user proceded with payment
             * @get dopbsp_payment_gateway (string): payment gateway
             * @get dopbsp_calendar_id (integer): calendar ID
             * @get dopbsp_token (string): cart token
             * @get PayerID (string): payer PayPal ID
             * @get token (string): PayPal transaction token
             */
            function verify(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                if ($DOT->get('dopbsp_payment_gateway') == 'paypal'){
                    $calendar_id = $DOT->get('dopbsp_calendar_id', 'int');
                    $extra_url = $DOT->get('extra_url');
                    $pay_action = $DOT->get('dopbsp_pay_action');
                    $token = $DOT->get('dopbsp_token') == '' ? $DOPBSP->classes->prototypes->getRandomString(64):$DOT->get('dopbsp_token');
                    
                    if($extra_url != '') {
                        $extra_url = '#'.$extra_url;
                    }
                    
                    /*
                     * Remove get variables from url.
                     */
                    $page_url = (isset($_SERVER['HTTPS']) ? 'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $page_url_pieces =  explode((strpos($page_url, '?dopbsp_pay_action') !== false ? '?':'&').'dopbsp_pay_action', $page_url.$extra_url);

                    $this->set($calendar_id);
                    
                    if ($pay_action == 'payed'){
                        /*
                         * Calculate transaction payment amount.
                         */
                        $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE token="%s" ORDER BY id', 
                                                                          $token));
                        $this->payment_amount = 0;
                        
                        foreach ($reservations as $reservation){
                            $this->payment_amount += ($reservation->deposit_price > 0 ? (float)$DOPBSP->classes->prototypes->getWithDecimals(abs($reservation->deposit_price), 2):
                                                                                        (float)$DOPBSP->classes->prototypes->getWithDecimals(abs($reservation->price_total), 2));
                            $this->currency_code = $reservation->currency_code;
                        }
                        
                        /*
                         * Confirm payment and get transaction ID.
                         */
                        $transaction_id = $this->confirm();
                        
                        if ($transaction_id != false){
                            /*
                             * Update status to approved if payment succeeded.
                             */
                            $wpdb->update($DOPBSP->tables->reservations, array('status' => 'approved',
                                                                               'payment_status' => 'paid',
                                                                               'transaction_id' => $transaction_id,
                                                                               'token' => ''), 
                                                                         array('token' => $token));
                            /*
                             * Send notifications and update availability if the transaction was successful.
                             */
                            foreach ($reservations as $reservation){
                                $DOPBSP->classes->backend_calendar_schedule->setApproved($reservation->id);
                                
                                $DOPBSP->classes->backend_reservation_notifications->send($reservation->id,
                                                                                          'paypal_admin');
                                $DOPBSP->classes->backend_reservation_notifications->send($reservation->id,
                                                                                          'paypal_user');
                            }
                    
                            /*
                             * Redirect to success page.
                             */
                            header('Location: '.($this->redirect != '' ? $this->redirect:$page_url_pieces[0].(strpos($page_url_pieces[0], '?') !== false ? '&':'?').'dopbsp_payment_success=paypal')); die();
                        }
                        else{
                            /*
                             * Delete the reservations if the payment did not succeed.
                             */
                            $wpdb->delete($DOPBSP->tables->reservations, array('token' => $token));
                            
                            /*
                             * Redirect to error page.
                             */
                            header('Location: '.$page_url_pieces[0].(strpos($page_url_pieces[0], '?') !== false ? '&':'?').'dopbsp_payment_error=paypal'); die();
                        }
                    }
                    else{
                        /*
                         * Delete the reservations if payment process has been canceled.
                         */
                        $wpdb->delete($DOPBSP->tables->reservations, array('token' => $token));
                            
                        /*
                         * Redirect to cancel page.
                         */
                        header('Location: '.$page_url_pieces[0].(strpos($page_url_pieces[0], '?') !== false ? '&':'?').'dopbsp_payment_cancel=paypal'); die();
                    }
                }
            }
            
            /*
             * Issue a refund if a reservation has been canceled.
             * 
             * @param reservation (object): reservation data   
             */
            function refund($reservation){
                global $wpdb;
                global $DOPBSP;
                
                $nvp_data = array();
                
                /*
                 * Check if selected payment method is PayPal access.
                 */
                if ($reservation->payment_method == 'paypal'){
                    $this->set($reservation->calendar_id);
                    
                    /*
                     * Check if selected refunds are enabled.
                     */
                    if ($this->refund){
                        /*
                         * Stop if a refund has been made.
                         */
                        if ($reservation->payment_status == 'partially refunded'
                                || $reservation->payment_status == 'refunded'){
                            echo 'success_with_message;;;;;'.$DOPBSP->text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS_REFUND_WARNING');
                            return false;
                        }
                        
                        $refund_value = $this->refund_type == 'fixed' ? $this->refund_value:($reservation->price_total*$this->refund_value)/100;
                        
                        array_push($nvp_data, '&TRANSACTIONID='.$reservation->transaction_id);
                        array_push($nvp_data, '&REFUNDTYPE='.($refund_value == $reservation->price_total ? 'Full':'Partial'));
                        
                        if ($refund_value == $reservation->price_total){
                            array_push($nvp_data, '&REFUNDTYPE=Full');
                        }
                        else{
                            array_push($nvp_data, '&REFUNDTYPE=Partial');
                            array_push($nvp_data, '&AMT='.$refund_value);
                            array_push($nvp_data, '&CURRENCYCODE='.$reservation->currency_code);
                        }
                        
                        /*
                         * Make the API call to PayPal.
                         */
                        $call_response = $this->call('RefundTransaction', 
                                                     implode('', $nvp_data));
                        $ack = strtoupper($call_response['ACK']);

                        if ($ack == 'SUCCESS' 
                                || $ack == 'SUCCESSWITHWARNING'){
                            $settings_calendar = $DOPBSP->classes->backend_settings->values($reservation->calendar_id,  
                                                                                            'calendar');
                            $wpdb->update($DOPBSP->tables->reservations, array('refund' => $refund_value,
                                                                               'payment_status' => $refund_value == $reservation->price_total ? 'refunded':'partially refunded'), 
                                                                         array('id' => $reservation->id));
                            
                            /*
                             * Success message.
                             */
                            echo 'success_with_message;;;;;';
                            printf($DOPBSP->text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS_REFUND'), $DOPBSP->classes->price->set($refund_value,
                                                                                                    $reservation->currency,
                                                                                                    $settings_calendar->currency_position));
                        } 
                        else{
                            /*
                             * Error message.
                             */
                            echo 'error_with_message;;;;;'.urldecode($call_response['L_LONGMESSAGE0']).'.';
                        }
                    }
                }
            }

            /*
             * Set PayPal options.
             * 
             * @param calendar_id(integer): calendar ID
             */
            function set($calendar_id){
                global $DOPBSP;
                
                $settings_payment = $DOPBSP->classes->backend_settings->values($calendar_id, 
                                                                               'payment');
                
                /*
                 * Set PayPal configuration.
                 */
                $this->credit_card = $settings_payment->paypal_credit_card == 'true' ? true:false;
                $this->sandbox = $settings_payment->paypal_sandbox_enabled == 'true' ? true:false;
                $this->api_username = $this->sandbox ? $settings_payment->paypal_sandbox_username:$settings_payment->paypal_username;
                $this->api_password = $this->sandbox ? $settings_payment->paypal_sandbox_password:$settings_payment->paypal_password;
                $this->api_signature = $this->sandbox ? $settings_payment->paypal_sandbox_signature:$settings_payment->paypal_signature;
                $this->refund = $settings_payment->paypal_refund_enabled == 'true' ? true:false;
                $this->refund_value = (float)$settings_payment->paypal_refund_value;
                $this->refund_type = $settings_payment->paypal_refund_type;
                $this->redirect = $settings_payment->paypal_redirect;
                
                /*
                 * Set links.
                 */
                if ($this->sandbox == true){
                    $this->api_end_point = 'https://api-3t.sandbox.paypal.com/nvp';
                    $this->url_paypal = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=';
                }
                else{
                    $this->api_end_point = 'https://api-3t.paypal.com/nvp';
                    $this->url_paypal = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=commit&token=';
                }
            }
            
            /*
             * Initialize PayPal express check out.
             * 
             * @param calendar_id(integer): calendar ID
             * @param language(string): selected language
             * @param currency_code(string): ISO 4217 currency code
             * @param page_url(string): the page from were the payment is requested
             * 
             * @return error or success redirect link
             */
            function expressCheckOut($calendar_id,
                                     $language,
                                     $currency_code,
                                     $page_url){
                global $DOPBSP;
                
                $error = array();
                $url_variables = array();
                
                /*
                 * Set payment details.
                 */
                $this->currency_code = $currency_code;
                $this->language = $language;
                
                /*
                 * Set cancel & return links.
                 */
                array_push($url_variables, 'dopbsp_payment_gateway=paypal');
                array_push($url_variables, 'dopbsp_calendar_id='.$calendar_id);
                array_push($url_variables, 'dopbsp_token='.$DOPBSP->vars->payment_token);
                
                $this->url_cancel = urlencode($page_url.(strpos($page_url, '?') !== false ? '&':'?').'dopbsp_pay_action=cancel&'.implode('&', $url_variables));
                $this->url_return = urlencode($page_url.(strpos($page_url, '?') !== false ? '&':'?').'dopbsp_pay_action=payed&'.implode('&', $url_variables));
                
                $call_response = $this->expressCheckOutNVP();
                $ack = strtoupper($call_response['ACK']);

                if ($ack == 'SUCCESS' 
                        || $ack == 'SUCCESSWITHWARNING'){
                    /*
                     * Redirect link.
                     */
                    echo 'success_redirect;;;;;'.$this->url_paypal.urlencode($call_response['TOKEN']);
                } 
                else{
                    /*
                     * Error message.
                     */
                    array_push($error, 'Express check out API call failed.');
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Error code:</strong>');
                    array_push($error, urldecode($call_response['L_ERRORCODE0']));
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Error severity code:</strong>');
                    array_push($error, urldecode($call_response['L_SEVERITYCODE0']));
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Detailed error message:</strong>');
                    array_push($error, urldecode($call_response['L_LONGMESSAGE0']).'.');
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Short error message:</strong>');
                    array_push($error, urldecode($call_response['L_SHORTMESSAGE0'].'.'));
                    
                    echo implode('<br />', $error);
                }
            }
            
            /*
             * Set name-value pair for PayPal express check out.
             * 
             * @return response array
             */
            function expressCheckOutNVP(){
                global $wpdb;
                global $DOPBSP;
                
                $nvp_data = array();
                
                $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE token="%s" ORDER BY id', 
                                                                  $DOPBSP->vars->payment_token));

                /*
                 * Set payment details.
                 */    
                $this->payment_amount = 0;
                $i = 0;
                        
                foreach ($reservations as $reservation){
                    $description = array();
                    
                    $this->payment_amount += (float)$reservation->deposit_price > 0 ? (float)$DOPBSP->classes->prototypes->getWithDecimals(abs((float)$reservation->deposit_price), 2):
                                                                                      (float)$DOPBSP->classes->prototypes->getWithDecimals(abs((float)$reservation->price_total), 2);
                    
                    /*
                     * Set item description.
                     */
                    array_push($description, $DOPBSP->text('SEARCH_FRONT_END_CHECK_IN').': '.$reservation->check_in);
                    array_push($description, $reservation->check_out != '' ? $DOPBSP->text('SEARCH_FRONT_END_CHECK_OUT').': '.$reservation->check_out:'');
                    array_push($description, $reservation->start_hour != '' ? $DOPBSP->text('SEARCH_FRONT_END_START_HOUR').': '.$reservation->check_out:'');
                    array_push($description, $reservation->end_hour != '' ? $DOPBSP->text('SEARCH_FRONT_END_END_HOUR').': '.$reservation->check_out:'');
                    array_push($description, '...');
                    
                    $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d', 
                                                              $reservation->calendar_id));
                    
                    array_push($nvp_data, '&L_PAYMENTREQUEST_0_NAME'.$i.'='.urlencode($calendar->name.' - '.$DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TITLE').' #'.$reservation->id));
                    array_push($nvp_data, '&L_PAYMENTREQUEST_0_DESC'.$i.'='.urlencode(implode(' ', $description)));
                    array_push($nvp_data, '&L_PAYMENTREQUEST_0_AMT'.$i.'='.((float)$reservation->deposit_price > 0 ? (float)$DOPBSP->classes->prototypes->getWithDecimals(abs((float)$reservation->deposit_price), 2):
                                                                                                                     (float)$DOPBSP->classes->prototypes->getWithDecimals(abs((float)$reservation->price_total), 2)));
                    $i++;
                }
                
                /*
                 * Set payment option.
                 */
                array_push($nvp_data, '&PAYMENTREQUEST_0_PAYMENTACTION='.$this->payment_type);
                array_push($nvp_data, '&PAYMENTREQUEST_0_AMT='.$this->payment_amount);
                array_push($nvp_data, '&PAYMENTREQUEST_0_CURRENCYCODE='.$this->currency_code);
                array_push($nvp_data, '&RETURNURL='.$this->url_return);
                array_push($nvp_data, '&CANCELURL='.$this->url_cancel);
                array_push($nvp_data, '&LOCALECODE='.$this->language);
                
                if ($this->credit_card == 'true'){
                    array_push($nvp_data, '&SOLUTIONTYPE=Sole');
                }

                /*
                 * Make the API call to PayPal.
                 */
                return $this->call('SetExpressCheckout', 
                                   implode('', $nvp_data));
            }

            /*
             * Confirm payment.
             * 
             * @get dopbsp_pay_action (string): PayPal payment actions
             *                                  "cancel" the user canceled the transaction
             *                                  "payed" the user proceded with payment
             * @get dopbsp_calendar_id (integer): calendar ID
             * @get dopbsp_token (string): cart token
             * @get PayerID (string): payer PayPal ID
             * @get token (string): PayPal transaction token
             * 
             * @return false or transaction ID 
             */
            function confirm(){
		global $DOT;
		
                $nvp_data = array();
                
                $token = urlencode($DOT->get('token', false));
                $payer_id = urlencode($DOT->get('PayerID', false));
                $server_name = urlencode($_SERVER['SERVER_NAME']);

                array_push($nvp_data, 'TOKEN='.$token);
                array_push($nvp_data, 'PAYERID='.$payer_id);
                array_push($nvp_data, 'PAYMENTREQUEST_0_PAYMENTACTION='.$this->payment_type);
                array_push($nvp_data, 'PAYMENTREQUEST_0_AMT='.$this->payment_amount);
                array_push($nvp_data, 'PAYMENTREQUEST_0_CURRENCYCODE='.$this->currency_code);
                array_push($nvp_data, 'IPADDRESS='.$server_name);
                
                $call_response = $this->call('DoExpressCheckoutPayment',
                                             '&'.implode('&', $nvp_data));
                $ack = strtoupper($call_response['ACK']);
                
                if ($ack == 'SUCCESS' 
                        || $ack == 'SUCCESSWITHWARNING'){
                    return $call_response['PAYMENTINFO_0_TRANSACTIONID'];
                }
                else{
                    return false;
                }
            }
            
            /*
             * Call PayPal API. 
             * 
             * @param method(string): call method
             * @param nvp_data(string): call data
             * 
             * @return response array
             */
            function call($method, 
                          $nvp_data){
                $nvp_req = array();

                /*
                 * Set curl parameters.
                 */
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->api_end_point);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                
                /*
                 * Add TLS
                 */
                $curl_version = curl_version();
                
                if ((float)$curl_version['version'] >= 7.34){
                    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
                    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
                    curl_setopt($ch, CURLOPT_USERAGENT, 'PayPal-PHP-SDK');
                }
                else{
                    curl_setopt($ch, CURLOPT_SSLVERSION, 1);
                }

                /*
                 * Turn off the server and peer verification (TrustManager Concept).
                 */
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                
                /*
                 * NVP request for submitting to server.
                 */
                array_push($nvp_req, 'METHOD='.urlencode($method));
                array_push($nvp_req, '&VERSION='.urlencode($this->version));
                array_push($nvp_req, '&PWD='.urlencode($this->api_password));
                array_push($nvp_req, '&USER='.urlencode($this->api_username));
                array_push($nvp_req, '&SIGNATURE='.urlencode($this->api_signature));
                array_push($nvp_req, $nvp_data);
                array_push($nvp_req, '&BUTTONSOURCE='.urlencode($this->sBN_code));

                /*
                 * Set NVP request as post field to curl.
                 */
                curl_setopt($ch, CURLOPT_POSTFIELDS, implode('', $nvp_req));

                /*
                 * Get server response.
                 */
                $nvp_response = curl_exec($ch);

                /*
                 * Convert NVP response to an associative array.
                 */
                $response = $this->convertNVPToArray($nvp_response);

                if (curl_errno($ch)){
                    echo curl_error($ch);
                } 
                else{
                    curl_close($ch);
                }

                return $response;
            }
            
            /*
             * Convert PayPal call response from string to array.
             * 
             * @param nvp_response(string): PayPal call response
             * 
             * @return response array
             */
            function convertNVPToArray($nvp_response){
                $intial=0;
                $nvp_array = array();

                while (strlen($nvp_response)){
                    /*
                     * Key postion.
                     */
                    $key_position = strpos($nvp_response, '=');
                    
                    /*
                     * Value position.
                     */
                    $value_position = strpos($nvp_response, '&') ? strpos($nvp_response, '&'):strlen($nvp_response);

                    /*
                     * Get the key and value and store them in an associative array.
                     */
                    $key_value = substr($nvp_response, $intial, $key_position);
                    $value = substr($nvp_response, $key_position+1, $value_position-$key_position-1);
                    
                    /*
                     * Decode the respose.
                     */
                    $nvp_array[urldecode($key_value)] = urldecode($value);
                    $nvp_response = substr($nvp_response, $value_position+1, strlen($nvp_response));
                }

                return $nvp_array;
            }
        }
        
        new DOPBSPPayPal();
    }