<?php
    if(!defined('ABSPATH')){
    	exit;
	}
	
    class booking_package_CreditCard {
    
	    public $response = array();
	    
	    public $pluginName = null;
        
	    public $lang = null;
        
	    public function __construct($pluginName){
		    
		    $this->pluginName = $pluginName;
		    
	    }
	    
	    public function createCustomer($payId, $public_key, $secret, $token, $calendarAccount, $subscription, $user, $payment_live, $payment_active){
	        
	        $response = array("customer" => array(), "subscription" => array());
	        if($payId == "stripe"){
	            
	            /*
	            $createCustomer = true;
	            if(isset($user['subscription_list']['customer_id_for_stripe'])){
	                
	                $customer = $this->getCustomerForStripe($user['subscription_list']['customer_id_for_stripe'], $secret);
	                if(is_array($customer)){
	                    #var_dump($customer);
	                    $createCustomer = false;
	                    
	                }
	                
	            }
	            
	            if($createCustomer === true){
	                
	                $response = $this->createCustomerForStripe($payId, $public_key, $secret, $token, $calendarAccount, $subscription, $user);
	                
	            }else{
	                
	                $response['subscription'] = $this->createSubscriptionsForStripe($user['subscription_list']['customer_id_for_stripe'], $secret, $subscription, $user);
	                
	            }
	            **/
	            
	            $response = $this->createCustomerForStripe($payId, $public_key, $secret, $token, $calendarAccount, $subscription, $user);
	            
	        }
	        
	        return $response;
	        
	    }
	    
	    public function createCustomerForStripe($payId, $public_key, $secret, $token, $calendarAccount, $subscription, $user){
	        
	        $params = array('source' => $token, 'email' => $user['user_email'], 'description' => 'User: '.$user['user_login'].' Calendar: '.$calendarAccount['name']);
            $response = null;
            
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/customers");
			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			
			if($httpCode < 400){
			    
			    $customer = json_decode($response, true);
			    $subscription = $this->createSubscriptionsForStripe($customer['id'], $secret, $subscription, $user);
                $stripe = array("customer" => $customer, "subscription" => $subscription);
                return $stripe;
			    
			}else{
			    
			    $message = $this->httpCodeError($httpCode, $payId);
			    return $message;
			    
			}
            
	    }
	    
	    public function getCustomerForStripe($id, $secret){
	        
	        $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/customers/".$id);
			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
			#curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_POST, 0);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($httpCode < 400){
			    
			    $customer = json_decode($response, true);
			    #var_dump($customer);
			    return $customer;
			    
			}else{
			    
			    return false;
			    
			}
	        
	    }
	    
	    public function createSubscriptionsForStripe($id, $secret, $subscription, $user){
	        
	        $params = array("customer" => $id);
	        $plans = $subscription['plans'];
	        for($i = 0; $i < count($plans); $i++){
	            
	            $params["items[".$i."][plan]"] = $plans[$i]["id"];
	            
	        }
	        #var_dump($params);
	        
	        $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/subscriptions");
			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			
			if($httpCode < 400){
			    
			    $subscription = json_decode($response, true);
			    return $subscription;
			    
			}else{
			    
			    $message = $this->httpCodeError($httpCode, $payId);
			    return $message;
			    
			}
	        
	    }
	    
	    public function update_subscription($secret, $subscription){
	        
	        if($subscription['payType'] == 'stripe'){
	            
	            $ch = curl_init();
    			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/subscriptions/".$subscription['subscription_id_for_stripe']);
    			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
    			curl_setopt($ch, CURLOPT_POST, 0);
	            
	            ob_start();
    			$response = curl_exec($ch);
    			$response = ob_get_contents();
    			ob_end_clean();
    			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    			curl_close ($ch);
    			
    			if($httpCode < 400){
    			    
    			    $subscription = json_decode($response, true);
    			    #var_dump($subscription);
    			    return $subscription;
    			    
    			}else{
    			    
    			    $message = $this->httpCodeError($httpCode, $payId);
    			    #var_dump($message);
    			    return $message;
    			    
    			}
	            
	        }
	        
	    }
	    
	    public function deleteSubscription($subscription, $secret){
	        
	        $response = array("status" => 0, "reload" => 1);
	        if($subscription['payType'] == "stripe"){
	            
	            $ch = curl_init();
    			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/subscriptions/".$subscription['subscription_id_for_stripe']);
    			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
    			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	            
	            ob_start();
    			$response = curl_exec($ch);
    			$response = ob_get_contents();
    			ob_end_clean();
    			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    			curl_close ($ch);
    			
    			if($httpCode < 400){
    			    
    			    $delete = json_decode($response, true);
    			    if($delete['status'] == 'canceled'){
    			        
    			        $ch = curl_init();
            			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/customers/".$subscription['customer_id_for_stripe']);
            			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
            			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        	            
        	            ob_start();
            			$response = curl_exec($ch);
            			$response = ob_get_contents();
            			ob_end_clean();
            			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            			curl_close ($ch);
            			
            			if($httpCode < 400){
            			    
            			    $delete = json_decode($response, true);
            			    return $delete;
            			    
            			}else{
            			    
            			    $message = $this->httpCodeError($httpCode, $payId);
    			            return $message;
            			    
            			}
    			        
    			    }
    			    #return $subscription;
    			    
    			}else{
    			    
    			    $message = $this->httpCodeError($httpCode, $payId);
    			    return $message;
    			    
    			}
	            
	        }
	        
	        return $response;
	        
	    }
        
	    public function pay($payId, $public_key, $secret, $token, $payment_live, $amont, $currency, $key, $name){
            
            $response = array('error' => "8001");
		    if($payId == 'stripe'){
                
			    $response = $this->commitStripe($payId, $secret, $token, $amont, $currency, $key, $name);
                
		    }else if($payId == 'paypal'){
		        
		        $access_token = $this->getAccessTokenPayPal($public_key, $secret, $payment_live);
		        $response = $this->getPaymentDetailsPayPal($token, $access_token, $payment_live);
		        #var_dump($response);
		        
		    }
            
            $this->response = $response;
	        return $response;
            
        }
        
        public function cancel($payId, $public_key, $secret, $payment_live, $chargeId){
            
            #var_dump($payId);
            $response = array('error' => "8002");
            if($payId == 'stripe'){
                
                $response = $this->cancelStripe($payId, $secret, $chargeId);
                
            }else if($payId == 'paypal'){
                
                $access_token = $this->getAccessTokenPayPal($public_key, $secret, $payment_live);
                $response = $this->refoundPayPal($chargeId, $access_token, $payment_live);
                
            }
            
            $this->response = $response;
	        return $response;
            
        }
        
        public function update($payId, $public_key, $secret, $chargeId, $bookingId, $payment_live){
            
            $response = array('error' => "8002");
            if($payId == 'paypal'){
                
                $access_token = $this->getAccessTokenPayPal($public_key, $secret, $payment_live);
                $response = $this->updatePaymentPayPal($chargeId, $bookingId, $access_token, $payment_live);
                
            }
            
            $this->response = $response;
	        return $response;
            
        }
        
        public function intentForStripe($secret, $amont, $currency) {
            
            $params = array('amount' => $amont, 'currency' => $currency, 'metadata' => array('integration_check' => 'accept_a_payment'));
            #var_dump($params);
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/payment_intents");
			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
            
            $response = json_decode($response, true);
            return $response;
            
        }
        
        public function commitStripe($payId, $secret, $token, $amont, $currency, $key, $name){
            
            $message = array();
            #$params = array('source' => $token, 'amount' => $amont, 'currency' => $currency, 'description' => "Key: " . $key . " Name: " . $name);
            $response = null;
            $params = array('description' => "Key: " . $key . " Name: " . $name);
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/payment_intents/" . $token);
			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
            
            $response = json_decode($response, true);
            $id = $response['charges']['data'][0]['id'];
            #var_dump($response);
            
            if($httpCode < 400){
                
                if(isset($id) && $response['status'] == 'succeeded'){
                    
                    $message['cardToken'] = $id;
                    
                }else{
                    
                    if($httpCode == 400){
                        
                        $message['error'] = __("The request was unacceptable, often due to missing a required parameter.", $this->pluginName);
                        
                    }else if($httpCode == 401){
                        
                        $message['error'] = __("No valid API key provided.", $this->pluginName);
                        
                    }else if($httpCode == 402){
                        
                        $message['error'] = __("The parameters were valid but the request failed.", $this->pluginName);
                        
                    }else if($httpCode == 404){
                        
                        $message['error'] = __("The requested resource doesn't exist.", $this->pluginName);
                        
                    }else if($httpCode == 409){
                        
                        $message['error'] = "The request conflicts with another request (perhaps due to using the same idempotent key).";
                        
                    }else if($httpCode == 429){
                        
                        $message['error'] = "Too many requests hit the API too quickly. We recommend an exponential backoff of your requests.";
                        
                    }else if($httpCode == 500 || $httpCode == 502 || $httpCode == 503 || $httpCode == 504){
                        
                        $message['error'] = "Something went wrong on Stripe's end.";
                        
                    }else{
                        
                        $message['error'] = "8007";
                        
                    }
                    
                    $message['error'] = $response['message'];
                
                }
            
            }else{
                
                $message = $this->httpCodeError($httpCode, $payId);
                if (isset($response['error']) && isset($response['error']['message'])) {
                    
                    $message = array('code' => $httpCode, 'error' => $response['error']['message'], 'object' => $response);
                    
                }
                
            }
            
            return $message;
            
        }
        
        public function commitPayPal($payId, $secret, $token, $amont, $currency, $key, $name){
            
            $message = array();
            $bool = true;
            if($bool == true){
                
                $request = array(
                    'amount' => $amont, 
                    'merchantAccountId' => $currency, 
                    'paymentMethodNonce' => $token, 
                    'orderId' => $key, 
                    'options' => array(
                        'submitForSettlement' => true
                    )
                );
                $gateway = new Braintree_Gateway(array('accessToken' => $secret));
                $result = $gateway->transaction()->sale($request);
                if($result->success === true){
                    
                    $message['cardToken'] = $result->transaction->id;
                    $message['paymentId'] = $result->transaction->paypalDetails->paymentId;
                    $message['payerId'] = $result->transaction->paypalDetails->payerId;
                    
                }else{
                    
                    $message['error'] = $result->message;
                    
                }
                
                return $message;
                
            }else{
                
                return array('error' => "8020");
                
            }
            
        }
        
        public function getAccessTokenPayPal($public_key, $secret, $payment_live){
            
            $sandbox = '';
            if(intval($payment_live) == 0){
                
                $sandbox = 'sandbox.';
                
            }
            
            $url = "https://api.".$sandbox."paypal.com/v1/oauth2/token";
            $message = array();
            $headers = array('Accept: application/json', 'Accept-Language: en_US');
            $params = array('grant_type' => 'client_credentials');
            $response = null;
            
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERPWD, $public_key.":".$secret);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
            $response = json_decode($response, true);
            return $response['access_token'];
            
        }
        
        public function getPaymentDetailsPayPal($id, $token, $payment_live){
            
            $sandbox = '';
            if(intval($payment_live) == 0){
                
                $sandbox = 'sandbox.';
                
            }
            
            $url = "https://api.". $sandbox ."paypal.com/v1/payments/payment/".$id;
            $url = "https://api." . $sandbox . "paypal.com/v2/checkout/orders/" . $id;
            $message = array();
            $headers = array('content-type: application/json', 'Authorization: Bearer '.$token);
            $response = null;
            
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, 0);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
            $response = json_decode($response, true);
            
            if($response['status'] == 'COMPLETED' || $response['status'] == 'APPROVED'){
                
                #$authorization = $response['transactions'][0]['related_resources'][0]['sale'];
                $message['cardToken'] = $response['id'];
                /**
                $message['response1'] = $response;
                
                $update = array(
                    array(
                        "op" => "add",
                        "path" => "/purchase_units/@reference_id=='default'/custom_id",
                        "value" => "123123",
                    ),
                );
                $message['update'] = $update;
                
                $response['intent'] = 'AUTHORIZE';
                $headers = array('content-type: application/json', 'Authorization: Bearer '.$token);
                $url = "https://api." . $sandbox . "paypal.com/v2/checkout/orders/" . $id;
                $ch = curl_init();
    			curl_setopt($ch, CURLOPT_URL, $url);
    			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($update));
    			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    			#curl_setopt($ch, CURLOPT_POST, 1);
    			
    			ob_start();
    			$response = curl_exec($ch);
    			$response = ob_get_contents();
    			ob_end_clean();
    			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    			curl_close ($ch);
                $response = json_decode($response, true);
                $message['response'] = $response;
                **/
                
            }else{
                
                $message['error'] = $response['message'];
                $message['response'] = $response;
                
            }
            
            return $message;
            
        }
        
        public function updatePaymentPayPal($id, $bookingId, $token, $payment_live){
            
            $sandbox = '';
            if(intval($payment_live) == 0){
                
                $sandbox = 'sandbox.';
                
            }
            
            $url = "https://api.".$sandbox."paypal.com/v1/payments/payment/".$id;
            $message = array();
            $headers = array('Content-Type: application/json', 'Authorization: Bearer '.$token);
            $params = array(array('op' => 'replace', 'path' => '/transactions/0/custom', 'value' => 'Booking ID ' . $bookingId));
            $response = null;
            
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
			#curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			#curl_setopt($ch, CURLOPT_POST, 0);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			$message['httpCode'] = $httpCode;
			$message['id'] = $id;
			$message['params'] = $params;
			
			return $message;
            
        }
        
        public function refoundPayPal($id, $token, $payment_live){
            
            $sandbox = '';
            if(intval($payment_live) == 0){
                
                $sandbox = 'sandbox.';
                
            }
            
            $url = "https://api.".$sandbox."paypal.com/v1/payments/sale/".$id;
            $message = array();
            $headers = array('content-type: application/json', 'Accept: application/json', 'Authorization: Bearer '.$token);
            $response = null;
            
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, 0);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if($httpCode == 200){
			    
			    $response = json_decode($response, true);
                $url = "https://api.".$sandbox."paypal.com/v1/payments/sale/".$id."/refund";
                $headers = array('content-type: application/json', 'Accept: application/json', 'Authorization: Bearer '.$token);
                $params = array('amount' => array('currency' => $response['amount']['currency'], 'total' => $response['amount']['total']));
                $response = null;
                
                $ch = curl_init();
    			curl_setopt($ch, CURLOPT_URL, $url);
    			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    			curl_setopt($ch, CURLOPT_POST, 1);
    			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    			#curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    			
                ob_start();
                $response = curl_exec($ch);
                $response = ob_get_contents();
                ob_end_clean();
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                $response = json_decode($response, true);
                $message['response'] = $response;
                if($httpCode != 201){
                    
                    $message['status'] = 'error';
                    $message['message'] = 'Refund failed';
                    
                }
                
			}
			
			
            return $message;
            
        }
        
        public function cancelStripe($payId, $secret, $chargeId){
            
            $url = "https://api.stripe.com/v1/refunds";
            $message = array();
            $params = array('charge' => $chargeId);
            $response = null;
            
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			ob_start();
			$response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
            
            $response = json_decode($response, true);
            if($httpCode < 400){
                
                if(isset($response['id']) && $response['status'] == 'succeeded'){
                    
                    $message['cardToken'] = $response['id'];
                    
                }
                	
            }else{
                
                $message = $this->httpCodeError($httpCode, $payId);
                
            }
            
            return $message;
            
        }
        
        public function cancelPayPal($payId, $secret, $chargeId){
            
            $message = array();
            $bool = $this->payPalInclude();
            if($bool == true){
                
                $gateway = new Braintree_Gateway(array('accessToken' => $secret));
                $result = $gateway->transaction()->refund($chargeId);
                if($result->success === true){
                    
                    $message['cardToken'] = $result->transaction->id;
                    
                }else{
                    
                    $message['error'] = $result->message;
                    
                }
                
                return $message;
                
            }else{
                
                return array('error' => "8020");
                
            }
            
        }
        
        public function httpCodeError($httpCode, $payId){
            
            $message = array('code' => $httpCode);
            if($httpCode == 400){
                $message['error'] = __("The request was unacceptable, often due to missing a required parameter.", $this->pluginName);
            }else if($httpCode == 401){
                $message['error'] = __("No valid API key provided.", $this->pluginName);
            }else if($httpCode == 402){
                $message['error'] = __("The parameters were valid but the request failed.", $this->pluginName);
            }else if($httpCode == 404){
                $message['error'] = __("The requested resource doesn't exist.", $this->pluginName);
            }else if($httpCode == 409){
                $message['error'] = "The request conflicts with another request (perhaps due to using the same idempotent key).";
            }else if($httpCode == 429){
                $message['error'] = "Too many requests hit the API too quickly. We recommend an exponential backoff of your requests.";
            }else{
                $message['error'] = "Something went wrong on Stripe's end.";
            }
            
            return $message;
            
        }
        
    }
?>