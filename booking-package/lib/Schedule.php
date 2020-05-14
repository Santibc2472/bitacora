<?php
    if(!defined('ABSPATH')){
    	exit;
	}
    
    class booking_package_schedule {
        
        public $prefix = null;
        
        public $pluginName = null;
        
        public $phpVersion = 0;
        
        public $automaticApprove = false;
        
        public function __construct($prefix, $pluginName){
            
            $this->prefix = $prefix;
            $this->pluginName = $pluginName;
            $this->phpVersion = floatval(phpversion());
            $this->accommodationDetails = null;
            #$this->setting = new booking_package_setting($this->prefix, $this->pluginName);
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_userPraivateData";
            #$wpdb->query("DROP TABLE IF EXISTS ".$table_name.";");
            
        }
        
        public function getPhpVersion() {
        	
        	$version = explode('.', phpversion());
    		$php = intval($version[0] . $version[1]);
    		return $php;
        	
        }
        
        public function getTimestamp(){
        	
        	$timestamp = array(
        		'unixTime' => date('U'),
        		'F' => __(date('F'), $this->pluginName),
        		'm' => date('m'),
        		'n' => date('n'),
        		'd' => date('d'),
        		'j' => date('j'),
        		'Y' => date('Y'),
        		'date' => date('Ymd'),
        	);
        	
        	return $timestamp;
        }
        
        public function setAccommodationDetails($accommodationDetails){
        	
        	$this->accommodationDetails = $accommodationDetails;
        	
        }
        
        public function getAccommodationDetails(){
        	
        	return $this->accommodationDetails;
        	
        }
        
        public function createUser($administrator = 0, $accountKey = null){
        	
        	$setting = new booking_package_setting($this->prefix, $this->pluginName);
        	$isExtensionsValid = $setting->extensionFunction(false);
        	if ($isExtensionsValid === false) {
        		
        		$response['status'] = 'error';
				$response['error_messages'] = __("Member related functions are not available", $this->pluginName);
        		return $response;
        		
        	}
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	#$activation = intval(get_option($this->prefix."activation_user", 0));
        	$activation = 0;
        	
        	if($administrator == 0){
        		
        		$this->logout();
        		if (intval(get_option($this->prefix."check_email_for_member", 0)) == 0) {
	        		
	        		$activation = 1;
	        		
	        	}
        		
        	}else{
        		
        		$activation = 1;
        		
        	}
        	
        	
        	$response = array("status" => "success", "activation" => $activation);
        	#$user_login = username_exists($_POST['user_login']);
			$user_pass = trim($_POST['user_pass']);
			$userdata = array(
				'user_login' => $_POST['user_login'],
				'user_pass' => $user_pass,
				'user_email' => $_POST['user_email'],
				'role' => $this->prefix.'member',
			);
			
			ob_start();
			$user_id = wp_insert_user($userdata);
			ob_get_clean();
			$type = gettype($user_id);
			if(is_wp_error($user_id)){
				
				$response['status'] = 'error';
				$response['error_messages'] = $user_id->get_error_message();
				
			}else{
				
				update_user_meta($user_id, 'show_admin_bar_front', 'false');
				$hash = wp_hash(sanitize_text_field($_POST['user_email']).sanitize_text_field($_POST['user_login']).date('U'));
				$response['user_id'] = $user_id;
				$this->add_user($user_id, $_POST['user_login'], $_POST['user_email'], $activation, $hash);
				
				if ($activation == 1) {
					
					$userdata = array(
						'user_login' => $_POST['user_login'],
						'user_password' => $user_pass,
						'remember' => true
					);
					
					if($administrator == 0){
						
						$user = wp_signon($userdata, true);
						if(is_wp_error($user)){
							
							$response['status'] = 'error';
							$response['error_messages'] = $user->get_error_message();
							
						}
						
					}
					
				}else{
					
					$uri = $_POST['permalink']."?mode=activation&k=".$hash."&u=".sanitize_text_field($_POST['user_login']);
					$subject = get_option($this->prefix."subject_email_for_member", "No title");
					$body = get_option($this->prefix."body_email_for_member", "No message");
					if (preg_match('/(\[activation_url\])/', $body, $matches)) {
		    			
		    			$body = preg_replace('/(\[activation_url\])/', $uri, $body);
		    			
		    		}else{
		    			
		    			$body = $uri."\n".$body;
		    			
		    		}
					$this->sendMail(sanitize_text_field($_POST['user_email']), $subject, $body, 'text', $accountKey);
					
				}
				
			}
			
        	return $response;
        	
        }
        
        public function setActivationUser($user_activation_key, $user_login, $activation = 0){
        	
        	$user = get_user_by('login', $user_login);
        	$id = null;
        	if (isset($user->ID)) {
        		
        		$id = $user->ID;
        		
        	} else {
        		
        		return array('status' => 'error', 'mode' => 'notFound', "message" => __("Your information could not be found.", $this->pluginName));
        		
        	}
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$sql = $wpdb->prepare(
        		"SELECT `status` FROM `".$table_name."` WHERE `key` = %d AND `user_activation_key` = %s;", 
        		array(intval($id), sanitize_text_field($user_activation_key))
        	);
			$row = $wpdb->get_row($sql, ARRAY_A);
			if(is_null($row)){
				
				return array('status' => 'error', 'mode' => 'notFound', "message" => __("Your information could not be found.", $this->pluginName));
				
			}else{
				
				if(intval($row['status']) == 0){
					
					$bool = $wpdb->update( 
		        		$table_name,
						array(
							'status' => 1, 
						),
						array('key' => intval($id)),
						array('%d'),
						array('%d')
					);
					
					return array('status' => 'success', 'id' => $id, 'user_login' => $user_login);
					
				}else{
					
					return array('status' => 'error', 'mode' => 'approved', "message" => __("You have already been approved.", $this->pluginName));
					
				}
				
			}
			#var_dump($row);
        	
        }
        
        
        public function updateUser($administrator = 0, $accountKey){
        	
        	$setting = new booking_package_setting($this->prefix, $this->pluginName);
        	$isExtensionsValid = $setting->extensionFunction(false);
        	if($isExtensionsValid === false){
        		
        		$response['status'] = 'error';
				$response['error_messages'] = __("Member related functions are not available", $this->pluginName);
        		return $response;
        		
        	}
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$response = array("status" => "error");
        	$userId = 0;
        	
        	$user = get_user_by('login', sanitize_text_field($_POST['user_login']));
        	$response['user'] = $user;
    		if($user === false){
    			
    			return $response;
    			
    		}else{
    			
    			$userId = $user->ID;
    			$userOldEmail = $user->user_email;
    			
    		}
        	
        	if(intval($userId) == 0){
        		
        		$response['message'] = "error login";
        		return $response;
        		
        	}else{
        		
        		$login = 0;
        		$status = 1;
        		$hash = 0;
        		$userdata = array('ID' => $userId);
				if(isset($_POST['user_email'])){
					
					$userdata['user_email'] = $_POST['user_email'];
					$hash = wp_hash(sanitize_text_field($_POST['user_email']).sanitize_text_field($_POST['user_login']).date('U'));
					if($userOldEmail != $_POST['user_email']){
						
						$status = 0;
						
					}
					
				}else{
					
					$hash = wp_hash(sanitize_text_field($userOldEmail).sanitize_text_field($_POST['user_login']).date('U'));
					
				}
				
				if(isset($_POST['user_pass'])){
					
					$login = 1;
					$userdata['user_pass'] = $_POST['user_pass'];
					
				}
				
				$user = wp_update_user($userdata);
				if(is_wp_error($user)){
					
					$response['message'] = "error update";
					return $response;
					
				}else{
					
					if($administrator == 1){
						
						#$status = 1;
						$status = intval($_POST['status']);
						
					}
					
					$bool = $this->update_profile($userId, $_POST['user_email'], $status, $hash);
					/**
					$bool = $wpdb->update( 
		        		$table_name,
						array(
							'email' => sanitize_text_field($_POST['user_email']), 
							'status' => $status,
							'user_activation_key' => $hash,
						),
						array('key' => intval($userId)),
						array('%s', '%d', '%s'),
						array('%d')
					);
					**/
					
					if($status == 0 && $administrator == 0){
						
						$this->logout();
						
						$uri = $_POST['permalink']."?mode=activation&k=".$hash."&u=".sanitize_text_field($_POST['user_login']);
						$subject = get_option($this->prefix."subject_email_for_member", "No title");
						$body = get_option($this->prefix."body_email_for_member", "No message");
						if (preg_match('/(\[activation_url\])/', $body, $matches)) {
			    			
			    			$body = preg_replace('/(\[activation_url\])/', $uri, $body);
			    			
			    		}else{
			    			
			    			$body = $uri."\n".$body;
			    			
			    		}
						$this->sendMail(sanitize_text_field($_POST['user_email']), $subject, $body, 'text', $accountKey);
						
					}
					
					if($login == 1){
						
						$userdata = array(
							'user_login' => $_POST['user_login'],
							'user_password' => $_POST['user_pass'],
							'remember' => true
						);
						#var_dump($userdata);
						#$user = wp_signon($userdata, true);
						
						
					}
					
					$response['status'] = 'success';
					$response['login'] = $status;
					return $response;
					
				}
        		
        	}
        	
        }
        
        public function update_profile($userId, $email, $status, $hash = null){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$bool = $wpdb->update( 
        		$table_name,
				array(
					'email' => sanitize_text_field($email), 
					'status' => $status,
					'user_activation_key' => $hash,
				),
				array('key' => intval($userId)),
				array('%s', '%d', '%s'),
				array('%d')
			);
			
			return $bool;
        	
        }
        
        public function update_email($userId){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$user = get_user_by('id', intval($userId));
        	$bool = $wpdb->update( 
        		$table_name,
				array(
					'email' => sanitize_text_field($user->user_email), 
				),
				array('key' => intval($userId)),
				array('%s'),
				array('%d')
			);
        	
        }
        
        public function get_users($authority, $offset, $number = null, $search = null){
        	
        	global $wpdb;
        	$limit = get_option($this->prefix."read_member_limit");
        	if ($limit === false) {
        		
        		add_option($this->prefix."read_member_limit", intval($number));
        		
        	} else {
        		
        		update_option($this->prefix."read_member_limit", intval($number));
        		
        	}
        	
        	$role = $this->prefix.'member';
        	if ($authority == 'subscriber') {
        		
        		$role = 'subscriber';
        		
        	} else if ($authority == 'contributor') {
        		
        		$role = 'contributor';
        		
        	}
        	
        	if (!isset($_POST['keywords'])) {
        		
        		$args = array(
	        		'role' => $role,
	        		'orderby' => 'ID',
	        		'order' => 'ASC',
	        		'offset' => intval($offset),
	        		'number' => intval($number),
	        		'fields' => array('ID', 'user_login', 'user_email', 'user_registered'),
	        	);
	        	
	        	if (!is_null($search)) {
	        		$args['search'] = $search;
	        	}
	        	
	        	$users = get_users($args);
	        	$table_name = $wpdb->prefix."booking_package_users";
	        	foreach ((array) $users as $key => $user) {
	        		
		        	$sql = $wpdb->prepare(
		        		"SELECT `key`, `status`, `user_login`, `subscription_list` FROM `".$table_name."` WHERE `email` = %s;", 
		        		array(sanitize_text_field($user->user_email))
		        	);
					$row = $wpdb->get_row($sql, ARRAY_A);
					$user->status = $row['status'];
					$user->subscription_list = $this->get_subscription_list_of_user($user->ID);
					if (empty($row['user_login']) || empty($row['user_registered'])) {
						
						$bool = $wpdb->update( 
			        		$table_name,
							array(
								'user_login' => $user->user_login, 
								'user_registered' => $user->user_registered,
							),
							array('key' => intval($row['key'])),
							array('%s', '%s'),
							array('%d')
						);
						
					}
	        		
	        	}
        		
        	} else {
        		
        		$queryList = array();
        		$valueList = array();
        		$keywords = $_POST['keywords'];
        		if (function_exists('mb_convert_kana')) {
        			
        			$keywords = preg_replace('/( |　)/', ' ', mb_convert_kana($keywords, 'a', 'UTF-8'));
        			
        		}
        		
        		$keywords = explode(' ', sanitize_text_field($keywords));
        		$keywords = str_replace('\\', '', $keywords);
        		for ($i = 0; $i < count($keywords); $i++) {
        			
        			array_push($queryList, "`user_login` LIKE '%%%s%%'");
        			array_push($queryList, "`email` LIKE '%%%s%%'");
        			array_push($queryList, "`value` LIKE '%%%s%%'");
        			array_push($valueList, $keywords[$i]);
        			array_push($valueList, $keywords[$i]);
        			$word = rtrim(ltrim(json_encode($keywords[$i]), '"'), '"');
        			$word = str_replace('\\', '%\\', $word);
        			array_push($valueList, $word);
        			
        		}
        		
        		array_push($valueList, intval($_POST['offset']));
        		array_push($valueList, intval($_POST['number']));
        		
        		$table_name = $wpdb->prefix."booking_package_users";
        		#$sql = "SELECT `email`, `status`, `subscription_list` FROM `".$table_name."` WHERE " . implode(" OR ", $queryList) . ";";
        		$sql = $wpdb->prepare(
	        		"SELECT `key` AS `ID`, `user_login`, `email` AS `user_email`, `status`, `subscription_list`, `user_registered` FROM `".$table_name."` WHERE " . implode(' OR ', $queryList) . " LIMIT %d, %d;", 
	        		$valueList
	        	);
	        	
	        	if (isset($_POST['meta']) && intval($_POST['meta']) == 1) {
	        		
	        		$sql = $wpdb->prepare(
		        		"SELECT `key` AS `ID`, `user_login`, `email` AS `user_email`, `status`, `subscription_list`, `user_registered`, `value` FROM `".$table_name."` WHERE " . implode(' OR ', $queryList) . " LIMIT %d, %d;", 
		        		$valueList
		        	);
	        		
	        	}
	        	
	        	$rows = $wpdb->get_results($sql, ARRAY_A);
	        	return $rows;
	        	#return array("sql" => $sql, "row" => $row);
        		
        	}
        	
        	
        	
        	return $users;
        	
        }
        
        public function login($userId, $statusCheck = true) {
        	
        	$setting = new booking_package_setting($this->prefix, $this->pluginName);
        	$isExtensionsValid = $setting->extensionFunction(false);
        	if ($isExtensionsValid === false) {
        		
        		return 0;
        		
        	}
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$sql = $wpdb->prepare(
        		"SELECT `value`,`status` FROM `".$table_name."` WHERE `key` = %d;", 
        		array(intval($userId))
        	);
			$row = $wpdb->get_row($sql, ARRAY_A);
			$value = 0;
			if (intval($row['status']) == 1) {
				
				$value = json_decode($row['value'], true);
				#update_user_meta($userId, 'show_admin_bar_front', 'true');
				
			} else {
				
				$value = 0;
				if ($statusCheck === false) {
					
					$value = json_decode($row['value'], true);
					#update_user_meta($userId, 'show_admin_bar_front', 'true');
					
				}
				
			}
			
        	return $value;
        	
        }
        
        public function add_user($userId, $user_login, $email, $activation, $hash = null){
        	
        	if (is_null($hash)) {
        		
        		$hash = wp_hash(sanitize_text_field($email).sanitize_text_field($userId).date('U'));
        		
        	}
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$wpdb->insert(
				$table_name, 
				array(
					'key' => $userId, 
					'status' => intval($activation),
					'user_login' => sanitize_text_field($user_login),
					'firstname' => "", 
					'lastname' => "", 
					'email' => sanitize_text_field($email),
					'value' => json_encode(array()),
					'user_activation_key' => $hash
				), 
				array('%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s')
			);
        	
        }
        
        public function find_users($userId, $activation, $create = false){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$sql = $wpdb->prepare("SELECT `value`,`status` FROM `".$table_name."` WHERE `key` = %d;", array(intval($userId)));
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row) && $create === true) {
				
				$user = get_user_by('id', $userId);
				#var_dump($user->user_email);
				$this->add_user($userId, $user->user_login, $user->user_email, $activation);
				
			}
        	
        }
        
        public function get_user($userId = null, $statusCheck = true){
        	
        	$pluginName = $this->pluginName;
        	$reality = false;
        	$user = null;
        	$value = null;
        	$setting = new booking_package_setting($this->prefix, $this->pluginName);
        	$memberSetting = array_merge($setting->getMemberSettingValues(), array('current_member_id' => 0, 'login' => 0));
        	$response = array("status" => 0, "message" => "", "user" => $memberSetting);
        	if (is_null($userId)) {
        		
        		$userId = get_current_user_id();
				$roleName = $this->prefix.'member';
				if ($userId != 0) {
					
					$bool = false;
					if (current_user_can($roleName) === true) {
						
						$bool = true;
						
					} else if (current_user_can("subscriber") === true && intval($memberSetting['accept_subscribers_as_users'] == 1)) {
						
						$bool = true;
						$this->find_users($userId, 1, true);
						
					} else if (current_user_can("contributor") === true && intval($memberSetting['accept_contributors_as_users'] == 1)) {
						
						$bool = true;
						$this->find_users($userId, 1, true);
						
					}/** else if (current_user_can("author") === true && intval($memberSetting['accept_authors_as_users'] == 1)) {
						
						$bool = true;
						$this->find_users($userId, 1, true);
						
					}**/
					
					#$capability = current_user_can($roleName);
					if ($bool === true) {
						
						$user = get_user_by('id', intval($userId));
						$value = $this->login($userId);
						if (!is_int($value) && is_array(array_values($value))) {
							
							$reality = true;
							/**
							$memberSetting['user_login'] = $user->user_login;
							$memberSetting['user_email'] = $user->user_email;
							$memberSetting['value'] = $value;
							$memberSetting['current_member_id'] = intval($userId);
							$memberSetting['login'] = 1;
							$memberSetting['subscription_list'] = $this->get_subscription_list_of_user($userId);
							
							$response = array("status" => 1, "user" => $memberSetting);
							**/
							
						} else {
							
							#$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => __('Your email address has not been accepted.', $pluginName), "reload" => 1)));
							$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => "", "reload" => 1)));
							
						}
						
					} else {
						
						$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => "", "reload" => 1)));
						
					}
					
				}
        		
        	} else {
        		
        		$user = get_user_by('id', intval($userId));
				$value = $this->login($userId, $statusCheck);
				if (!is_int($value) && is_array(array_values($value))) {
					
					$reality = true;
					
				} else {
					
					$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => __('Your email address has not been accepted.', $pluginName), "reload" => 1)));
					
				}
        		
        	}
        	
        	if ($reality === true) {
        		
        		$memberSetting['user_login'] = $user->user_login;
				$memberSetting['user_email'] = $user->user_email;
				$memberSetting['value'] = $value;
				$memberSetting['current_member_id'] = intval($userId);
				$memberSetting['login'] = 1;
				$memberSetting['subscription_list'] = $this->get_subscription_list_of_user($userId);
				
				$response = array("status" => 1, "message" => "", "user" => $memberSetting);
        		
        	}
        	
        	return $response;
        	
        }
        
        public function update_subscription_list_of_user($userId, $subscription_list){
        	
        	#$subscription_list = $user['user']['subscription_list'];
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	#$sql = $wpdb->prepare("UPDATE `".$table_name."` SET `` = %s WHERE `key` = %d;", array(intval($userId)));
        	
        	$bool = $wpdb->update( 
        		$table_name,
				array(
					'subscription_list' => json_encode($subscription_list), 
				),
				array('key' => intval($userId)),
				array('%s'),
				array('%d')
			);
			
			return $bool;
        	
        }
        
        public function get_subscription_list_of_user($userId){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$sql = $wpdb->prepare(
        		"SELECT `subscription_list`,`status` FROM `".$table_name."` WHERE `key` = %d;", 
        		array(intval($userId))
        	);
			$row = $wpdb->get_row($sql, ARRAY_A);
			$subscription_list = json_decode($row['subscription_list'], true);
			if(is_null($subscription_list)){
				
				$subscription_list = array();
				
			}else{
				
				$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
				$deleteKey = array();
				foreach ((array) $subscription_list as $key => $value) {
					
					$delete = false;
					if($value['period_end'] < date('U')){
						
						$value = $this->update_subscription($value);
						if(is_array($value)){
							
							$subscription_list[$key] = $value;
							
							if($value['canceled'] == 1){
								
								#var_dump($subscription_list[$key]);
								$delete = true;
								array_push($deleteKey, $key);
								unset($subscription_list[$key]);
								
							}
							
							$this->update_subscription_list_of_user($userId, $subscription_list);
							#var_dump($subscription_list[$value]);
							
						}else{
							
							array_push($deleteKey, $key);
							
						}
						
					}
					
					if($delete === false){
						
						$subscription_list[$key]['period_start_date'] = $this->dateFormat($dateFormat, $positionOfWeek, $value['period_start'], "", true, true);
						$subscription_list[$key]['period_end_date'] = $this->dateFormat($dateFormat, $positionOfWeek, $value['period_end'], "", true, true);
						
					}
					
				}
				
			}
			
        	return $subscription_list;
        	
        }
        
        public function update_subscription($subscription){
        	
        	global $wpdb;
        	$response = array("status" => 1);
    		$creditCard = new booking_package_CreditCard($this->pluginName);
    		if ($subscription['payType'] == 'stripe') {
    			
    			$secret_key = get_option($this->prefix."stripe_secret_key", null);
    			$update_subscription = $creditCard->update_subscription($secret_key, $subscription);
    			$add_subscription = $this->prepare_subscription($subscription['payType'], $update_subscription, $subscription);
    			return $add_subscription;
    			
    		}
        	
        	return false;
        	
        }
        
        public function deleteSubscription($productKey = false, $userId = null){
        	
        	global $wpdb;
        	$productKey = sanitize_text_field($productKey);
        	$response = array("status" => 1);
        	$creditCard = new booking_package_CreditCard($this->pluginName);
        	
        	if (is_null($userId)) {
        		
        		$user = $this->get_user();
        		
        	} else {
        		
        		$user = $this->get_user($userId, false);
        		
        	}
        	
        	
        	
        	if(intval($user['status']) == 1){
        		
        		$subscription_list = $user['user']['subscription_list'];
        		if(isset($subscription_list[$productKey])){
        			
        			$secret_key = get_option($this->prefix."stripe_secret_key", null);
        			$response = $creditCard->deleteSubscription($subscription_list[$productKey], $secret_key);
        			if($response['deleted'] === true){
        				
        				#unset($subscription_list[$productKey]);
        				$subscription_list[$productKey]['canceled'] = 1;
        				$bool = $this->update_subscription_list_of_user($user['user']['current_member_id'], $subscription_list);
        				$response['status'] = 1;
        				$response['bool'] = $bool;
        				#$response['user'] = $user;
        				#$response['subscription_list'] = $subscription_list;
        				
        			}else{
        				
        				if($response['code'] == 404){
        					
        					unset($subscription_list[$productKey]);
        					$bool = $this->update_subscription_list_of_user($user['user']['current_member_id'], $subscription_list);
        					$response['bool'] = $bool;
        					
        				}
        				
        				$response['status'] = 0;
        				
        			}
        			return $response;
        			
        		}else{
        			
        			$response = array("status" => 0, "reload" => 1);
        			
        		}
        		
        		return $subscription_list;
        		
        	}else{
        		
        		return $user;
        		
        	}
        	
        }
        
        public function user_login_for_frontend($user_login, $user_password, $remember) {
        	
        	$response = array('status' => 'success');
        	$creds = array('user_login' => $user_login, 'user_password' => $user_password);
        	if (intval($remember) == 1) {
        		
        		$creds['remember'] = true;
        		
        	}
        	
        	$user = wp_signon($creds, true);
        	if (is_wp_error($user)) {
        		
        		$response['status'] = 'error';
        		$response['code'] = $user->get_error_code();
        		$response['message'] = $user->get_error_message();
        		$response['user'] = $user;
        		
        	} else {
        		
        		$bool = 'false';
        		$user_toolbar = intval(get_option($this->prefix . 'user_toolbar', 0));
        		if (intval($user_toolbar) == 1) {
        			
        			$bool = 'true';
        			
        		}
        		update_user_meta($user->ID, 'show_admin_bar_front', $bool);
        		
        	}
        	
        	return $response;
        	
        	
        }
        
        public function logout(){
        	
        	wp_logout();
        	return array("status" => "success");
        	
        }
        
        public function deleteUser($administrator = 0){
        	
        	$reality = false;
        	$userId = 0;
        	if (intval($administrator) == 1) {
        		
        		$user = get_user_by('login', sanitize_text_field($_POST['user_login']));
        		if ($user !== false) {
        			
        			$reality = true;
        			
        		}
        		$userId = $user->ID;
        		
        	} else {
        		
        		$userId = get_current_user_id();
        		if ($userId != 0) {
        			
        			$reality = true;
        			
        		}
        		
        	}
        	
        	if ($reality === true) {
        		
        		$response = array("status" => "success", "userId" => $userId);
        		if (wp_delete_user($userId) === true) {
        			
        			$this->deleteForPluginUser($userId);
        			return $response;
        			
        		}
        		
        		$response['status'] = "error";
        		return $response;
        		
        	} else {
        		
        		$response = array("status" => "error", "userId" => $userId);
        		return $response;
        		
        	}
        	
        }
        
        
        public function deleteForPluginUser($user_id){
        	
        	global $wpdb;
        	
        	$creditCard = new booking_package_CreditCard($this->pluginName);
			$user = $this->get_user($user_id, false);
			if (isset($user['user']['subscription_list']) && is_null($user['user']['subscription_list']) === false) {
				
				$items = $user['user']['subscription_list'];
				foreach ((array) $items as $key => $value) {
					
					$secret_key = get_option($this->prefix."stripe_secret_key", null);
					$response = $creditCard->deleteSubscription($value, $secret_key);
					
				}
				
			}
			
        	$table_name = $wpdb->prefix."booking_package_users";
        	$wpdb->delete($table_name, array('key' => intval($user_id)), array('%d'));
        	
        }
        
        public function setUserInformation($form){
    		
    		global $wpdb;
    		$table_name = $wpdb->prefix."booking_package_users";
    		$setting = new booking_package_setting($this->prefix, $this->plugin_name);
        	$memberSetting = array_merge($setting->getMemberSettingValues(), array('current_member_id' => 0, 'login' => 0));
        	
    		$response = array("status" => "success");
    		$bool = false;
    		$userId = get_current_user_id();
			$roleName = $this->prefix.'member';
			if ($userId != 0 && current_user_can($roleName) === true) {
				
				$bool = true;
				
			} else if ($userId != 0 && current_user_can("subscriber") === true && intval($memberSetting['accept_subscribers_as_users'] == 1)) {
				
				$bool = true;
				
			} else if ($userId != 0 && current_user_can("contributor") === true && intval($memberSetting['accept_contributors_as_users'] == 1)) {
				
				$bool = true;
				
			}/** else if ($userId != 0 && current_user_can("author") === true && intval($memberSetting['accept_authors_as_users'] == 1)) {
				
				$bool = true;
				
			}**/
			
			if ($bool === true) {
				
				$sql = $wpdb->prepare("SELECT `value`,`status` FROM `".$table_name."` WHERE `key` = %d;", array(intval($userId)));
				$row = $wpdb->get_row($sql, ARRAY_A);
				if (!is_null($row)) {
					
					$values = json_decode($row['value'], true);
					for ($i = 0; $i < count($form); $i++) {
						
						$type = $form[$i]->type;
						$formId = $form[$i]->id;
						$value = $form[$i]->value;
						$array = array("id" => $formId, "value" => $value);
						if (isset($values[$type])) {
							
							$values[$type][$formId] = $array;
							
						} else {
							
							$values[$type] = array($formId => $array);
							
						}
						
					}
					
					$bool = $wpdb->update( 
						$table_name,
						array(
							'value' => sanitize_text_field(json_encode($values)), 
						),
						array('key' => intval($userId)),
						array('%s'),
						array('%d')
					);
					
					$response['values'] = $values;
					return $response;
					
				} else {
					
					$response["status"] = "error";
					return $response;
					
				}
				
			}
			
			return $response;
    		
    	}
    	
    	public function prepare_subscription($payType, $response_subscription, $subscription){
    		
    		$items = array();
			for($i = 0; $i < count($response_subscription['items']['data']); $i++){
				
				$item = $response_subscription['items']['data'][$i]['plan'];
				array_push($items, $item);
				
			}
			
			$canceled = 0;
			if($response_subscription['status'] == "active"){
				
				$canceled = 0;
				
			}else if($response_subscription['status'] == "canceled"){
				
				$canceled = 1;
				
			}
			
			$add_subscription = array(
				'product' => $subscription['product'],
				'name' => $subscription['name'],
				'customer_id_for_stripe' => $response_subscription['customer'],
				'subscription_id_for_stripe' => $response_subscription['id'],
				'period_start' => $response_subscription['current_period_start'],
				'period_end' => $response_subscription['current_period_end'],
				'booking_count' => null,
				'payType' => sanitize_text_field($payType),
				'canceled' => $canceled,
				'items' => $items,
			);
			
			return $add_subscription;
    		
    	}
    	
    	public function createCustomer(){
    		
    		$response = array("status" => 1);
    		$creditCard = new booking_package_CreditCard($this->pluginName);
    		$payment_active = 0;
    		$payment_live = 0;
    		$calendarAccount = $this->getCalendarAccount(intval($_POST['calendarAccountKey']));
    		$paymentMethod = explode(",", $calendarAccount['paymentMethod']);
    		$response['calendarAccount'] = $calendarAccount;
    		$user = $this->get_user();
    		$response['user'] = $user;
    		if(intval($user['status']) == 1){
    			
    			if(isset($_POST['payType']) && $_POST['payType'] == 'stripe'){
    				
    				#$payment_active = get_option($this->prefix."stripe_active", "0");
    				$payment_active = 0;
    				if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
    					
    					$payment_active = 1;
    					
    				}
	    			
					$secret_key = get_option($this->prefix."stripe_secret_key", null);
	    			$products = $calendarAccount["subscriptionIdForStripe"];
	    			$products = explode(",", $products);
	    			$subscription = $this->getProductForStripe($secret_key, array($products[0]));
	    			$response['subscription'] = $subscription;
	    			if(is_array($subscription)){
	    				
	    				$stripe = $creditCard->createCustomer($_POST['payType'], $public_key, $secret_key, $_POST['payToken'], $calendarAccount, $subscription, $user['user'], $payment_live, $payment_active);
	    				$response['stripe'] = $stripe;
	    				if(isset($stripe['subscription']['status']) && $stripe['subscription']['status'] == 'active'){
	    					
	    					$response_subscription = $stripe['subscription'];
	    					$subscription_list = $user['user']['subscription_list'];
	    					#$subscription_list['customer_id_for_stripe'] = $response_subscription['customer'];
	    					
	    					$add_subscription = $this->prepare_subscription($_POST['payType'], $response_subscription, $subscription);
	    					
	    					/**
	    					$items = array();
	    					for($i = 0; $i < count($response_subscription['items']['data']); $i++){
	    						
	    						$item = $response_subscription['items']['data'][$i]['plan'];
	    						array_push($items, $item);
	    						
	    					}
	    					
	    					$add_subscription = array(
	    						'product' => $subscription['product'],
	    						'name' => $subscription['name'],
	    						'customer_id_for_stripe' => $response_subscription['customer'],
	    						'subscription_id_for_stripe' => $response_subscription['id'],
	    						'period_start' => $response_subscription['current_period_start'],
	    						'period_end' => $response_subscription['current_period_end'],
	    						'booking_count' => null,
	    						'payType' => sanitize_text_field($_POST['payType']),
	    						'items' => $items,
	    					);
	    					**/
	    					
	    					$subscription_list[$subscription['product']] = $add_subscription;
	    					$user['user']['subscription_list'] = $subscription_list;
	    					$update = $this->update_subscription_list_of_user($user['user']['current_member_id'], $subscription_list);
	    					
	    					$response['update_subscription'] = $update;
	    					$response['user'] = $user;
	    					$response['subscription_list'] = $subscription_list;
	    					
	    				}else{
	    					
	    					$response["status"] = 0;
	    					
	    				}
	    				
	    			}else{
	    				
	    				$response["status"] = 0;
	    				
	    			}
	    			
	    		}else if(isset($_POST['payType']) && $_POST['payType'] == 'paypal'){
	    			
	    			#$payment_active = get_option($this->prefix."paypal_active", "0");
	    			$payment_active = 0;
    				if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
    					
    					$payment_active = 1;
    					
    				}
    				
					$payment_live = get_option($this->prefix."paypal_live", "0");
					$public_key = get_option($this->prefix."paypal_client_id", null);
					$secret_key = get_option($this->prefix."paypal_secret_key", null);
	    			
	    		}
    			
    		}else{
    			
    			$response["status"] = 0;
    			
    		}
    		
    		return $response;
    		
    	}
    	
    	public function getProductForStripe($secret, $products = array()){
    		
    		$subscriptions = array();
    		for($index = 0; $index < count($products); $index++){
    			
    			$product = $products[$index];
    			$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/plans?limit=100&product=".$product);
				curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
				curl_setopt($ch, CURLOPT_POST, 0);
				
				ob_start();
				$response = curl_exec($ch);
				$response = ob_get_contents();
				ob_end_clean();
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close ($ch);
				
				$response = json_decode($response, true);
				$name = null;
				$currency = 'usd';
				$amount = 0;
				$bool = false;
				$planKeys = array();
				$plans = array();
				for($i = 0; $i < count($response['data']); $i++){
				    
				    $data = $response['data'][$i];
				    if($data['active'] === true){
				        
				        $bool = true;
				        $name = $data['name'];
				        $currency = $data['currency'];
				        $amount += intval($data['amount']);
				        
				        array_push($planKeys, $data['id']);
	    		        array_push($plans, array(
	    		            'id' => $data['id'],
	    			        'name' => $data['name'],
	    			        'label' => $data['name'],
	    			        'amount' => $data['amount'],
	    			        'currency' => $data['currency'],
	    		        ));
				        
				    }
				    
				}
				
				if($bool === true){
					
					$subscription = array('product' => $product, 'name' => $name, 'amount' => $amount, 'currency' => $currency, 'planKeys' => $planKeys, 'plans' => $plans, 'status' => 1, 'subscribed' => 0);
		        	array_push($subscriptions, $subscription);
					
				}
    			
    		}
    		
    		if(count($subscriptions) > 0){
    			
    			return $subscriptions[0];
    			
    		}else{
    			
    			return false;
    			
    		}
    		
    	}
    	
    	public function updateRegularHolidays(){
    		
    		global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_regular_holidays";
        	
        	$sql = $wpdb->prepare(
        		"SELECT * FROM ".$table_name." WHERE `accountKey` = %s AND `day` = %d AND `month` = %d AND `year` = %d;", 
        		array(
        			sanitize_text_field($_POST['accountKey']), 
        			intval($_POST['day']),
					intval($_POST['month']),
					intval($_POST['year']),
        		)
        	);
        	
        	$unixTime = date('U', mktime(0, 0, 0, intval($_POST['month']), intval($_POST['day']), intval($_POST['year'])));
        	$row = $wpdb->get_row($sql, ARRAY_A);
        	if(!is_null($row)){
        		
        		$bool = $wpdb->update(
					$table_name,
					array(
						'status' => sanitize_text_field($_POST['status']), 
					),
					array(
						'accountKey' => sanitize_text_field($_POST['accountKey']),
						'day' => intval($_POST['day']),
						'month' => intval($_POST['month']),
						'year' => intval($_POST['year']),
					),
					array('%s'),
					array('%s', '%d', '%d', '%d')
				);
        		
        	}else{
        		
        		$wpdb->insert(
					$table_name, 
					array(
						'accountKey' => sanitize_text_field($_POST['accountKey']), 
						'day' => intval($_POST['day']), 
						'month' => intval($_POST['month']), 
						'year' => intval($_POST['year']), 
						'unixTime' => sanitize_text_field($unixTime), 
						'status' => sanitize_text_field($_POST['status']), 
						'update' => date('U'), 
					), 
					array('%s', '%d', '%d', '%d', '%s', '%s', '%s')
				);
        		
        	}
    		
    		return $this->getRegularHolidays($_POST['month_calendar'], $_POST['year_calendar'], $_POST['accountKey'], get_option('start_of_week', 0));
    		
    	}
    	
    	public function getRegularHolidays($month, $year, $accountKey = null, $startOfWeek = 0, $share = false){
    		
    		$last_day = date('t', mktime(0, 0, 0, $month, 1, $year));
			$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year)));
			$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year)));
			$date = array('startDay' => 1, 'lastDay' => $last_day, 'startWeek' => $week_start_num, 'lastWeek' => $week_last_num, 'year' => $year, 'month' => intval($month), 'day' => 1);
        	$calendar = array("date" => $date, "calendar" => array());
        	
    		global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_regular_holidays";
        	
        	/**
        	$calendarList = array();
			if(intval($week_start_num) != 0){
				
				$lastUnixTime = date('U', mktime(0, 0, 0, $month, 1, $year)) - 1;
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = intval(date('t', $lastUnixTime));
				$startDay = $endDay - intval(date('w', $lastUnixTime));
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array('startDay' => $startDay, 'lastDay' => $endDay, 'startWeek' => intval(date('w', mktime(0, 0, 0, $lastMonth, $startDay, $lastYear))), 'lastWeek' => intval(date('w', $lastUnixTime)), 'year' => $lastYear, 'month' => intval($lastMonth), 'day' => $startDay, 'lastUnixTime' => $lastUnixTime);
				
			}
			
			$calendarList[intval($year.sprintf('%02d', $month))] = $date;
			
			
			if(intval($week_last_num) != 6){
				
				$lastUnixTime = date('U', mktime(23, 60, 0, $month, $last_day, $year));
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = 7 - intval(date('w', $lastUnixTime));
				$startDay = 1;
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array('startDay' => $startDay, 'lastDay' => $endDay, 'startWeek' => intval(date('w', $lastUnixTime)), 'lastWeek' => 6, 'year' => $lastYear, 'month' => intval($lastMonth), 'day' => $startDay, 'lastUnixTime' => $lastUnixTime);
				
			}
			**/
			
			$calendarList = $this->getCalendarList($month, 1, $year, $startOfWeek);
			
			$list = array();
			foreach ((array) $calendarList as $key => $value) {
				
				for($i = $value['startDay']; $i <= $value['lastDay']; $i++){
					
					$month = $value['month'];
					$year = $value['year'];
					$key = $value['year'].sprintf("%02d%02d", $value['month'], $i);
					$week = date('w', mktime(0, 0, 0, $month, $i, $year));
					$dayArray = array('year' => $value['year'], 'month' => $value['month'], 'day' => $i, 'week' => $week, 'count' => null, 'accountKey' => $accountKey, 'status' => 0);
					$list[$key] = $dayArray;
					
					if($share === true){
						
						$sql = $wpdb->prepare(
			        		/**"SELECT * FROM ".$table_name." WHERE (`accountKey` = 'share' || `accountKey` = %s) AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY unixTime ASC;", **/
			        		"SELECT * FROM ".$table_name." WHERE `accountKey` = %s AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY unixTime ASC;", 
			        		array(
			        			sanitize_text_field($accountKey), 
			        			intval($year), 
			        			intval($month), 
			        			intval($i), 
			        		)
			        	);
						
					}else{
						
						$sql = $wpdb->prepare(
			        		"SELECT * FROM ".$table_name." WHERE `accountKey` = %s AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY unixTime ASC;", 
			        		array(
			        			sanitize_text_field($accountKey), 
			        			intval($year), 
			        			intval($month), 
			        			intval($i), 
			        		)
			        	);
						
					}
					
		        	
		        	$row = $wpdb->get_row($sql, ARRAY_A);
		        	if(!is_null($row)){
		        		
		        		$list[$key] = $row;
		        		
		        	}
					
				}
				
				
			}
			
			$calendar['calendarList'] = $calendarList;
			$calendar['calendar'] = $list;
        	
        	return $calendar;
    		
    	}
        
        public function createFirstCalendar(){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$sql = "SELECT COUNT(`key`) FROM `".$table_name."`;";
			
			$rows = $wpdb->get_results("SELECT COUNT(`key`) FROM `".$table_name."`;", ARRAY_A);
			foreach ((array) $rows as $row) {
				
				if (intval($row['COUNT(`key`)']) == 0) {
					
					$date = date('U');
					$local = get_locale();
					$startOfWeek = 0;
					if ($local == 'es_ES' || $local == 'en_GB' || $local == 'de_DE' || $local == 'it_IT' || $local == 'nl_NL' || $local == 'da_DK' || $local == 'nb_NO' || $local == 'sv_SE' || $local == 'fr_FR') {
						
						$startOfWeek = 1;
						
					}
					
					if ($local == 'ja' || $local == 'ja-jp' || $local == 'ja_jp') {
						
						$wpdb->insert(
	    					$table_name, 
	    					array(
	    						'key' => 1, 
	    						'name' => sanitize_text_field('First Calendar'), 
	    						'type' => sanitize_text_field('day'), 
	    						'status' => sanitize_text_field('open'), 
	    						'created' => sanitize_text_field($date), 
	    						'uploadDate' => sanitize_text_field($date),
	    						'displayRemainingCapacityInCalendar' => '1',
	    						'displayRemainingCapacityHasMoreThenThreshold' => '{"symbol":"panorama_fish_eye","color":"#969696"}',
	    						'displayRemainingCapacityHasLessThenThreshold' => '{"symbol":"change_history","color":"#f4e800"}',
	    						'displayRemainingCapacityHas0' => '{"symbol":"close","color":"#e24b00"}',
	    						'startOfWeek' => $startOfWeek,
	    						'icalToken' => hash('ripemd160', date('U')),
	    					), 
	    					array('%d', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d', '%s')
	    				);
						
					} else {
						
						$wpdb->insert(
	    					$table_name, 
	    					array(
	    						'key' => 1, 
	    						'name' => sanitize_text_field('First Calendar'), 
	    						'type' => sanitize_text_field('day'), 
	    						'status' => sanitize_text_field('open'), 
	    						'created' => sanitize_text_field($date), 
	    						'startOfWeek' => $startOfWeek,
	    						'icalToken' => hash('ripemd160', date('U')),
	    						'uploadDate' => sanitize_text_field($date),
	    					), 
	    					array('%d', '%s', '%s', '%s', '%s', '%d', '%s', '%s')
	    				);
						
					}
					
					
    				$wpdb->insert(
    					$table_name, 
    					array(
    						'key' => 2, 
    						'name' => sanitize_text_field('First Calendar for hotel'), 
    						'type' => sanitize_text_field('hotel'), 
    						'status' => sanitize_text_field('open'), 
    						'created' => sanitize_text_field($date), 
    						'uploadDate' => sanitize_text_field($date),
    						'numberOfRoomsAvailable' => 5,
    						'includeChildrenInRoom' => 1,
    						'startOfWeek' => $startOfWeek,
    						'icalToken' => hash('ripemd160', date('U')),
    					), 
    					array('%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s')
    				);
    				$this->addGuests(2);
    				
				}
				
				break;
				
			}
			
			$this->insertAccountSchedule(date('m'), date('d'), date('Y'));
        	
        }
        
        public function setTimeZoneInCalendarAccount($accountKey) {
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$timezone = get_option($this->prefix . "timezone", null);
			if (is_null($timezone)) {
				
				$timezone = get_option('timezone_string', '');
    			if(is_null($timezone) || strlen($timezone) == 0){
    				
    				$timezone = 'UTC';
    				
    			}
				
			}
			
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$bool = $wpdb->update(
				$table_name,
				array(
					'timezone' => sanitize_text_field($timezone), 
				),
				array('key' => intval($accountKey)),
				array('%s'),
				array('%d')
			);
			
			return $timezone;
        	
        }
        
        public function getCalendarAccountListData($columns = "*"){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$rows = $wpdb->get_results("SELECT ".$columns." FROM `".$table_name."`;", ARRAY_A);
			foreach ((array) $rows as $key => $row) {
				
				if (isset($row['icalToken']) && intval($row['icalToken']) == 0) {
					
					$this->refreshIcalToken($row['key']);
					
				}
				
				
				if (isset($row['timezone']) && $row['timezone'] == 'none') {
					
					$rows[$key]['timezone'] = $this->setTimeZoneInCalendarAccount($row['key']);
					/**
					$timezone = get_option($this->prefix . "timezone", null);
					if (is_null($timezone)) {
						
						$timezone = get_option('timezone_string', '');
		    			if(is_null($timezone) || strlen($timezone) == 0){
		    				
		    				$timezone = 'UTC';
		    				
		    			}
						
					}
					
					$rows[$key]['timezone'] = $timezone;
		        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
		        	$bool = $wpdb->update(
						$table_name,
						array(
							'timezone' => sanitize_text_field($timezone), 
						),
						array('key' => intval($row['key'])),
						array('%s'),
						array('%d')
					);
					**/
					
				}
				
			}
			
			return $rows;
        	
        }
        
        public function getCalendarAccount($accountKey = 1, $isExtensionsValid = null){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array($accountKey));
			$row = $wpdb->get_row($sql, ARRAY_A);
			
			if (is_null($row) === true) {
				
				return false;
				
			}
			
			if (strlen($row['type']) == 0) {
				
				$row['type'] = 'day';
				
			}
			
			if ($isExtensionsValid === false && $row['type'] == 'hotel') {
				
				if ($row['hotelChargeOnDayBeforeNationalHoliday'] != 0 || $row['hotelChargeOnNationalHoliday'] != 0) {
					
					$table_name = $wpdb->prefix."booking_package_calendarAccount";
					$wpdb->query("START TRANSACTION");
					$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
					try {
					
						$bool = $wpdb->update(
							$table_name,
							array(
								'hotelChargeOnDayBeforeNationalHoliday' => 0, 
								'hotelChargeOnNationalHoliday' => 0,
							),
							array('key' => intval($accountKey)),
							array(
								'%d', '%d', 
							),
							array('%d')
						);
					
						$wpdb->query('COMMIT');
						$wpdb->query('UNLOCK TABLES');
						
					} catch (Exception $e) {
						
						$wpdb->query('ROLLBACK');
						$wpdb->query('UNLOCK TABLES');
						
					}/** finally {
						
						$wpdb->query('UNLOCK TABLES');
						
					}**/
					
				}
				
			}
			
			if (isset($row['timezone']) === true && $row['timezone'] == 'none') {
				
				$row['timezone'] = $this->setTimeZoneInCalendarAccount($accountKey);
				
			}
			
			if (is_null($row['paymentMethod'])) {
				
				$row['paymentMethod'] = $this->setPaymentMethod($accountKey);
				
			}
			
			return $row;
        	
        }
        
        public function setPaymentMethod($accountKey) {
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$paymentMethod = array();
        	if (intval(get_option($this->prefix."stripe_active", 0)) == 1) {
				
				array_push($paymentMethod, "stripe");
				
			}
			
			if (intval(get_option($this->prefix."paypal_active", 0)) == 1) {
				
				array_push($paymentMethod, "paypal");
				
			}
			
			$paymentMethod = implode(",", $paymentMethod);
			$bool = $wpdb->update(
				$table_name,
				array(
					'paymentMethod' => sanitize_text_field($paymentMethod), 
				),
				array('key' => intval($accountKey)),
				array('%s'),
				array('%d')
			);
			
			return $paymentMethod;
        	
        }
        
        public function addCalendarAccount(){
        	
        	$postList = array('cost' => 0, 'numberOfRoomsAvailable' => 1, 'numberOfPeopleInRoom' => 2, 'includeChildrenInRoom' => 0);
        	foreach ((array) $postList as $key => $value) {
        		
        		if (!isset($_POST[$key])) {
        			
        			$_POST[$key] = $value;
        			
        		}
        		
        	}
        	
        	$type = "day";
        	if (isset($_POST['type'])) {
        		
        		$type = $_POST['type'];
        		
        	}
        	
        	if (!isset($_POST['timezone'])) {
        		
        		$_POST['timezone'] = "none";
        		
        	}
        	
        	if (intval($_POST['schedulesSharing']) == 1) {
    			
    			$targetCalendar = $this->getCalendarAccount($_POST['targetSchedules']);
    			if ($targetCalendar === false || $targetCalendar['type'] != $_POST['type']) {
    				
    				$_POST['schedulesSharing'] = 0;
					$_POST['targetSchedules'] = 0;
    				
    			} else {
    				
    				$_POST['timezone'] = $targetCalendar['timezone'];
    				
    			}
    			
    		}
        	
        	if (!isset($_POST['enableSubscriptionForStripe']) || $type == 'hotel') {
        		
        		$_POST['subscriptionIdForStripe'] = "";
        		$_POST['enableSubscriptionForStripe'] = 0;
        		$_POST['termsOfServiceForSubscription'] = "";
        		$_POST['enableTermsOfServiceForSubscription'] = 0;
        		$_POST['privacyPolicyForSubscription'] = "";
        		$_POST['enablePrivacyPolicyForSubscription'] = 0;
        		
        	}
        	
        	if (!isset($_POST['displayRemainingCapacityInCalendar'])) {
        		
        		$_POST['displayRemainingCapacityInCalendar'] = 0;
        		$_POST['displayThresholdOfRemainingCapacity'] = 50;
        		$_POST['displayRemainingCapacityHasMoreThenThreshold'] = "";
        		$_POST['displayRemainingCapacityHasLessThenThreshold'] = "";
        		$_POST['displayRemainingCapacityHas0'] = "";
        		
        	}
        	
        	if (!isset($_POST['cancellationOfBooking'])) {
        		
        		$_POST['cancellationOfBooking'] = 0;
        		$_POST['allowCancellationVisitor'] = 0;
        		$_POST['allowCancellationUser'] = 0;
        		$_POST['refuseCancellationOfBooking'] = "not_refuse";
        		
        	}
        	
        	if (!isset($_POST['preparationTime'])) {
        		
        		$_POST['preparationTime'] = 0;
        		$_POST['positionPreparationTime'] = 'before_after';
        		
        	}
        	
        	if (!isset($_POST['flowOfBooking'])) {
        		
        		$_POST['flowOfBooking'] = 'calendar';
        		
        	}
        	
        	$servicesPage = null;
        	if (intval($_POST['servicesPage']) != 0) {
        		
        		$servicesPage = intval($_POST['servicesPage']);
        		
        	}
        	
        	$calenarPage = null;
        	if (intval($_POST['calenarPage']) != 0) {
        		
        		$calenarPage = intval($_POST['calenarPage']);
        		
        	}
        	
        	$schedulesPage = null;
        	if (intval($_POST['schedulesPage']) != 0) {
        		
        		$schedulesPage = intval($_POST['schedulesPage']);
        		
        	}
        	
        	$visitorDetailsPage = null;
        	if (intval($_POST['visitorDetailsPage']) != 0) {
        		
        		$visitorDetailsPage = intval($_POST['visitorDetailsPage']);
        		
        	}
        	
        	$thanksPage = null;
        	if (intval($_POST['thanksPage']) != 0) {
        		
        		$thanksPage = intval($_POST['thanksPage']);
        		
        	}
        	
        	$redirectPage = null;
        	if (intval($_POST['redirectPage']) != 0) {
        		
        		$redirectPage = intval($_POST['redirectPage']);
        		
        	}
			
			if (!isset($_POST['multipleRooms'])) {
				
				$_POST['multipleRooms'] = 0;
				
			}
			
        	
        	$_POST['displayRemainingCapacityHasMoreThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasMoreThenThreshold']);
        	$_POST['displayRemainingCapacityHasLessThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasLessThenThreshold']);
        	$_POST['displayRemainingCapacityHas0'] = str_replace("\\", "", $_POST['displayRemainingCapacityHas0']);
        	
        	$setting = new booking_package_setting($this->prefix, $this->pluginName);
        	$isExtensionsValid = $setting->extensionFunction(false);
        	$hotelCharges = array(
        		'hotelChargeOnSunday', 
        		'hotelChargeOnMonday', 
        		'hotelChargeOnTuesday', 
        		'hotelChargeOnWednesday', 
        		'hotelChargeOnThursday', 
        		'hotelChargeOnFriday', 
        		'hotelChargeOnSaturday', 
        		'hotelChargeOnDayBeforeNationalHoliday', 
        		'hotelChargeOnNationalHoliday',
        	);
        	
        	for ($i = 0; $i < count($hotelCharges); $i++) {
        		
        		$holidayKey = $hotelCharges[$i];
        		if (isset($_POST[$holidayKey]) === false) {
        			
        			$_POST[$holidayKey] = $_POST['cost'];
        			
        		}
        		/** else {
					
					if (intval($_POST[$holidayKey]) == 0) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
					if (($holidayKey == 'hotelChargeOnDayBeforeNationalHoliday' || $holidayKey == 'hotelChargeOnNationalHoliday') && $isExtensionsValid === false) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
				}
        		**/
        	}
        	
        	if ($isExtensionsValid == false) {
        		
        		#$_POST['enableFixCalendar'] = 0;
        		$_POST['hasMultipleServices'] = 0;
        		$_POST['displayRemainingCapacity'] = 0;
        		$_POST['enableSubscriptionForStripe'] = 0;
        		$_POST['cancellationOfBooking'] = 0;
        		$_POST['allowCancellationVisitor'] = 0;
        		$_POST['allowCancellationUser'] = 0;
        		$_POST['refuseCancellationOfBooking'] = "not_refuse";
        		$_POST['preparationTime'] = 0;
        		$_POST['positionPreparationTime'] = 'before_after';
        		$_POST['hotelChargeOnDayBeforeNationalHoliday'] = 0;
				$_POST['hotelChargeOnNationalHoliday'] = 0;
				$_POST['maximumNights'] = 0;
				$_POST['minimumNights'] = 0;
				$_POST['schedulesSharing'] = 0;
				$_POST['targetSchedules'] = 0;
        		
        	}
        	
        	$date = date('U');
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	
			$wpdb->insert(
				$table_name, 
				array(
					'name' => sanitize_text_field($_POST['name']), 
					'type' => sanitize_text_field($type), 
					'status' => sanitize_text_field($_POST['status']), 
					'courseTitle' => sanitize_text_field($_POST['courseTitle']), 
					'courseBool' => intval($_POST['courseBool']),
					'created' => sanitize_text_field($date), 
					'uploadDate' => sanitize_text_field($date),
					'cost' => intval($_POST['cost']),
					'numberOfRoomsAvailable' => intval($_POST['numberOfRoomsAvailable']),
					'numberOfPeopleInRoom' => intval($_POST['numberOfPeopleInRoom']),
					'includeChildrenInRoom' => intval($_POST['includeChildrenInRoom']),
					'expressionsCheck' => intval($_POST['expressionsCheck']),
					'monthForFixCalendar' => intval($_POST['monthForFixCalendar']),
					'yearForFixCalendar' => intval($_POST['yearForFixCalendar']),
					'enableFixCalendar' => intval($_POST['enableFixCalendar']),
					'displayRemainingCapacity' => intval($_POST['displayRemainingCapacity']),
					'maxAccountScheduleDay' => intval($_POST['maxAccountScheduleDay']),
					'unavailableDaysFromToday' => intval($_POST['unavailableDaysFromToday']),
					'subscriptionIdForStripe' => sanitize_text_field($_POST['subscriptionIdForStripe']),
					'enableSubscriptionForStripe' => intval($_POST['enableSubscriptionForStripe']),
					'termsOfServiceForSubscription' => esc_url($_POST['termsOfServiceForSubscription']),
					'enableTermsOfServiceForSubscription' => intval($_POST['enableTermsOfServiceForSubscription']),
					'privacyPolicyForSubscription' => esc_url($_POST['privacyPolicyForSubscription']),
					'enablePrivacyPolicyForSubscription' => intval($_POST['enablePrivacyPolicyForSubscription']),
					'displayRemainingCapacityInCalendar' => intval($_POST['displayRemainingCapacityInCalendar']),
					'displayThresholdOfRemainingCapacity' => intval($_POST['displayThresholdOfRemainingCapacity']),
					'displayRemainingCapacityHasMoreThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasMoreThenThreshold']),
					'displayRemainingCapacityHasLessThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasLessThenThreshold']),
					'displayRemainingCapacityHas0' => sanitize_text_field($_POST['displayRemainingCapacityHas0']),
					'icalToken' => hash('ripemd160', date('U')),
					'cancellationOfBooking' => intval($_POST['cancellationOfBooking']),
					'allowCancellationVisitor' => intval($_POST['allowCancellationVisitor']),
					'allowCancellationUser' => intval($_POST['allowCancellationUser']),
					'refuseCancellationOfBooking' => sanitize_text_field($_POST['refuseCancellationOfBooking']),
					'preparationTime' => intval($_POST['preparationTime']),
					'positionPreparationTime' => sanitize_text_field($_POST['positionPreparationTime']),
					'displayDetailsOfCanceled' => intval($_POST['displayDetailsOfCanceled']),
					'timezone' => sanitize_text_field($_POST['timezone']),
					'displayRemainingCapacityInCalendarAsNumber' => intval($_POST['displayRemainingCapacityInCalendarAsNumber']),
					'hasMultipleServices' => intval($_POST['hasMultipleServices']),
					'flowOfBooking' => sanitize_text_field($_POST['flowOfBooking']),
					'paymentMethod' => sanitize_text_field($_POST['paymentMethod']),
					'email_from' => sanitize_text_field($_POST['email_from']),
					'email_to' => sanitize_text_field($_POST['email_to']),
					'email_from_title' => sanitize_text_field($_POST['email_from_title']),
					'servicesPage' => $servicesPage,
					'calenarPage' => $calenarPage,
					'schedulesPage' => $schedulesPage,
					'visitorDetailsPage' => $visitorDetailsPage,
					'thanksPage' => $thanksPage, 
					'redirectPage' => $redirectPage,
					'hotelChargeOnSunday' => intval($_POST['hotelChargeOnSunday']),
					'hotelChargeOnMonday' => intval($_POST['hotelChargeOnMonday']),
					'hotelChargeOnTuesday' => intval($_POST['hotelChargeOnTuesday']),
					'hotelChargeOnWednesday' => intval($_POST['hotelChargeOnWednesday']),
					'hotelChargeOnThursday' => intval($_POST['hotelChargeOnThursday']),
					'hotelChargeOnFriday' => intval($_POST['hotelChargeOnFriday']),
					'hotelChargeOnSaturday' => intval($_POST['hotelChargeOnSaturday']),
					'hotelChargeOnDayBeforeNationalHoliday' => intval($_POST['hotelChargeOnDayBeforeNationalHoliday']),
					'hotelChargeOnNationalHoliday' => intval($_POST['hotelChargeOnNationalHoliday']),
					'maximumNights' => intval($_POST['maximumNights']),
					'minimumNights' => intval($_POST['minimumNights']),
					'schedulesSharing' => intval($_POST['schedulesSharing']),
					'targetSchedules' => intval($_POST['targetSchedules']),
					'multipleRooms' => intval($_POST['multipleRooms']),
					'redirectURL' => sanitize_text_field($_POST['redirectURL']),
					'redirectMode' => sanitize_text_field($_POST['redirectMode']),
				), 
				array(
					'%s', '%s', '%s', '%s', '%d', '%s', '%s', '%d', '%d', '%d', 
					'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', 
					'%s', '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s',
					'%d', '%d', '%d', '%s', '%d', '%s', '%d', '%s', '%d', '%d',
					'%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', 
					'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
					'%d', '%d', '%d', '%d', '%d', '%s', '%s', 
				)
			);
    		
    		$accountKey = $wpdb->insert_id;
    		$this->addGuests($accountKey);
    		if($type == 'hotel'){
    			
    			$this->insertAccountSchedule(date('m'), date('d'), date('Y'), $accountKey);
    			
    		}
    		
    		return $this->getCalendarAccountListData();
        	
        }
        
        public function createCloneCalendar() {
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$tmp_table_name = $table_name."_tmp";
        	#$sql = "CREATE TEMPORARY TABLE " . $tmp_table_name . " FROM " . $table_name . " WHERE `key` = %d;";
        	$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `key` = %d;", array(intval($_POST['accountKey'])));
        	$wpdb->query($sql);
        	$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        	$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        	$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        	$accountKey = $wpdb->insert_id;
        	
        	$targetList = array(
        		'schedules' => 'booking_package_templateSchedule', 
        		'form' => 'booking_package_form', 
        		'services' => 'booking_package_courseData', 
        		'guests' => 'booking_package_guests', 
        		'taxes' => 'booking_package_taxes', 
        		'emails' => 'booking_package_emailSetting', 
        		'subscriptions' => 'booking_package_subscriptions'
        	);
        	foreach ((array) $targetList as $key => $table) {
        		
        		if (isset($_POST[$key]) && intval($_POST[$key]) == 1) {
        			
        			$table_name = $wpdb->prefix.$table;
	        		$tmp_table_name = $table_name."_tmp";
	        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
	        		$wpdb->query($sql);
	        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
	        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
	        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
	        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        			
        		}
        		
        	}
        	
        	if (isset($_POST['schedules']) && intval($_POST['schedules']) == 1) {
        		
        		#$this->insertAccountSchedule(date('m'), date('d'), date('Y'));
        		
        	}
        	
        	/**
        	if (isset($_POST['schedules']) && intval($_POST['schedules']) == 1) {
        		
        		$table_name = $wpdb->prefix."booking_package_templateSchedule";
        		$tmp_table_name = $table_name."_tmp";
        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
        		$wpdb->query($sql);
        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        		
        	}
        	
        	if (isset($_POST['form']) && intval($_POST['form']) == 1) {
        		
        		$table_name = $wpdb->prefix."booking_package_form";
        		$tmp_table_name = $table_name."_tmp";
        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
        		$wpdb->query($sql);
        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        		
        	}
        	
        	if (isset($_POST['services']) && intval($_POST['services']) == 1) {
        		
        		$table_name = $wpdb->prefix."booking_package_courseData";
        		$tmp_table_name = $table_name."_tmp";
        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
        		$wpdb->query($sql);
        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        		
        	}
        	
        	if (isset($_POST['guests']) && intval($_POST['guests']) == 1) {
        		
        		$table_name = $wpdb->prefix."booking_package_guests";
        		$tmp_table_name = $table_name."_tmp";
        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
        		$wpdb->query($sql);
        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        		
        	}
        	
        	if (isset($_POST['taxes']) && intval($_POST['taxes']) == 1) {
        		
        		$table_name = $wpdb->prefix."booking_package_taxes";
        		$tmp_table_name = $table_name."_tmp";
        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
        		$wpdb->query($sql);
        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        		
        	}
        	
        	if (isset($_POST['emails']) && intval($_POST['emails']) == 1) {
        		
        		$table_name = $wpdb->prefix."booking_package_emailSetting";
        		$tmp_table_name = $table_name."_tmp";
        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
        		$wpdb->query($sql);
        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        		
        	}
        	
        	if (isset($_POST['subscriptions']) && intval($_POST['subscriptions']) == 1) {
        		
        		$table_name = $wpdb->prefix."booking_package_subscriptions";
        		$tmp_table_name = $table_name."_tmp";
        		$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
        		$wpdb->query($sql);
        		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
        		$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
        		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
        		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
        		
        	}
        	**/
        	
        	return $this->getCalendarAccountListData();
        	
        }
        
        public function getIcalToken($accountKey){
        	
        	$calendarAccount = $this->getCalendarAccount($accountKey);
        	return array("status" => "success", "ical" => $calendarAccount['ical'], "icalToken" => $calendarAccount['icalToken'], 'home' => get_home_url());
        	
        }
        
        public function updateIcalToken(){
        	
        	if (isset($_POST['accountKey']) && isset($_POST['ical'])) {
        		
        		global $wpdb;
	        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
	        	$bool = $wpdb->update(
					$table_name,
					array(
						'ical' => intval($_POST['ical']), 
					),
					array('key' => intval($_POST['accountKey'])),
					array('%d'),
					array('%d')
				);
	            
	            return array('status' => 'success', 'key' => $_POST['accountKey']);
        		
        	} else {
        		
        		return array('status' => 'error', 'key' => $_POST['accountKey']);
        		
        	}
        	
        	
        }
        
        public function refreshIcalToken($key, $home = false){
            
            $key = intval($key);
            $token = hash('ripemd160', date('U').$key);
            global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$bool = $wpdb->update(
				$table_name,
				array(
					'icalToken' => $token, 
				),
				array('key' => $key),
				array('%s'),
				array('%d')
			);
            
            return array('status' => 'success', 'token' => $token, 'key' => $key);
            
        }
        
        public function updateCalendarAccount(){
			
			$postList = array('cost' => 0, 'numberOfRoomsAvailable' => 1, 'numberOfPeopleInRoom' => 2, 'includeChildrenInRoom' => 0);
			foreach ((array) $postList as $key => $value) {
				
				if (!isset($_POST[$key])) {
					
					$_POST[$key] = $value;
					
				}
				
			}
			
			if (!isset($_POST['timezone'])) {
				
				$_POST['timezone'] = "none";
				
			}
			
        	$olodCalendarAccount = $this->getCalendarAccount($_POST['accountKey']);
    		if ($_POST['timezone'] != 'none' && $_POST['timezone'] != $olodCalendarAccount['timezone']) {
    			
    			$this->updateUnixTimeOnBookingData($_POST['accountKey'], $_POST['timezone']);
    			
    		}
        	
        	if (!isset($_POST['enableSubscriptionForStripe'])) {
        		
        		$_POST['subscriptionIdForStripe'] = "";
        		$_POST['enableSubscriptionForStripe'] = 0;
        		$_POST['termsOfServiceForSubscription'] = "";
        		$_POST['enableTermsOfServiceForSubscription'] = 0;
        		$_POST['privacyPolicyForSubscription'] = "";
        		$_POST['enablePrivacyPolicyForSubscription'] = 0;
        		
        	}
        	
        	if (!isset($_POST['displayRemainingCapacityInCalendar'])) {
        		
        		$_POST['displayRemainingCapacityInCalendar'] = 0;
        		$_POST['displayThresholdOfRemainingCapacity'] = 50;
        		$_POST['displayRemainingCapacityHasMoreThenThreshold'] = "";
        		$_POST['displayRemainingCapacityHasLessThenThreshold'] = "";
        		$_POST['displayRemainingCapacityHas0'] = "";
        		
        	}
        	
        	if (!isset($_POST['cancellationOfBooking'])) {
        		
        		$_POST['cancellationOfBooking'] = 0;
        		$_POST['allowCancellationVisitor'] = 0;
        		$_POST['allowCancellationUser'] = 0;
        		$_POST['refuseCancellationOfBooking'] = "not_refuse";
        		
        	}
        	
        	if (!isset($_POST['preparationTime'])) {
        		
        		$_POST['preparationTime'] = 0;
        		$_POST['positionPreparationTime'] = 'before_after';
        		
        	}
        	
        	if (!isset($_POST['flowOfBooking'])) {
        		
        		$_POST['flowOfBooking'] = 'calendar';
        		
        	}
        	
        	$servicesPage = null;
        	if (intval($_POST['servicesPage']) != 0) {
        		
        		$servicesPage = intval($_POST['servicesPage']);
        		
        	}
        	
        	$calenarPage = null;
        	if (intval($_POST['calenarPage']) != 0) {
        		
        		$calenarPage = intval($_POST['calenarPage']);
        		
        	}
        	
        	$schedulesPage = null;
        	if (intval($_POST['schedulesPage']) != 0) {
        		
        		$schedulesPage = intval($_POST['schedulesPage']);
        		
        	}
        	
        	$visitorDetailsPage = null;
        	if (intval($_POST['visitorDetailsPage']) != 0) {
        		
        		$visitorDetailsPage = intval($_POST['visitorDetailsPage']);
        		
        	}
        	
        	$thanksPage = null;
        	if (intval($_POST['thanksPage']) != 0) {
        		
        		$thanksPage = intval($_POST['thanksPage']);
        		
        	}
        	
        	$redirectPage = null;
        	if (intval($_POST['redirectPage']) != 0) {
        		
        		$redirectPage = intval($_POST['redirectPage']);
        		
        	}
			
			if (!isset($_POST['multipleRooms'])) {
				
				$_POST['multipleRooms'] = 0;
				
			}
			
			$_POST['displayRemainingCapacityHasMoreThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasMoreThenThreshold']);
			$_POST['displayRemainingCapacityHasLessThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasLessThenThreshold']);
			$_POST['displayRemainingCapacityHas0'] = str_replace("\\", "", $_POST['displayRemainingCapacityHas0']);
			#var_dump($_POST['displayRemainingCapacityHasLessThenThreshold']);
			
			$setting = new booking_package_setting($this->prefix, $this->pluginName);
			$isExtensionsValid = $setting->extensionFunction(false);
			$hotelCharges = array(
				'hotelChargeOnSunday', 
				'hotelChargeOnMonday', 
				'hotelChargeOnTuesday', 
				'hotelChargeOnWednesday', 
				'hotelChargeOnThursday', 
				'hotelChargeOnFriday', 
				'hotelChargeOnSaturday', 
				'hotelChargeOnDayBeforeNationalHoliday', 
				'hotelChargeOnNationalHoliday',
			);
			
			for ($i = 0; $i < count($hotelCharges); $i++) {
				
				$holidayKey = $hotelCharges[$i];
				if (isset($_POST[$holidayKey]) === false) {
					
					$_POST[$holidayKey] = $_POST['cost'];
					
				}
				/**else {
					
					if (intval($_POST[$holidayKey]) == 0) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
					if (($holidayKey == 'hotelChargeOnDayBeforeNationalHoliday' || $holidayKey == 'hotelChargeOnNationalHoliday') && $isExtensionsValid === false) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
				}
				**/
				
			}
			
			if ($isExtensionsValid === false) {
				
				#$_POST['enableFixCalendar'] = 0;
				$_POST['hasMultipleServices'] = 0;
				$_POST['displayRemainingCapacity'] = 0;
				$_POST['enableSubscriptionForStripe'] = 0;
				$_POST['cancellationOfBooking'] = 0;
				$_POST['allowCancellationVisitor'] = 0;
				$_POST['allowCancellationUser'] = 0;
				$_POST['refuseCancellationOfBooking'] = "not_refuse";
				$_POST['preparationTime'] = 0;
				$_POST['positionPreparationTime'] = 'before_after';
				$_POST['hotelChargeOnDayBeforeNationalHoliday'] = 0;
				$_POST['hotelChargeOnNationalHoliday'] = 0;
				$_POST['maximumNights'] = 0;
				$_POST['minimumNights'] = 0;
				
			}
			
			$date = date('U');
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$wpdb->query("START TRANSACTION");
			$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
			try {
				
				$bool = $wpdb->update(
					$table_name,
					array(
						'name' => sanitize_text_field($_POST['name']), 
						'status' => sanitize_text_field($_POST['status']), 
						'courseTitle' => sanitize_text_field($_POST['courseTitle']),
						'courseBool' => intval($_POST['courseBool']),
						'uploadDate' => date('U'),
						'cost' => intval($_POST['cost']),
						'numberOfRoomsAvailable' => intval($_POST['numberOfRoomsAvailable']),
						'numberOfPeopleInRoom' => intval($_POST['numberOfPeopleInRoom']),
						'includeChildrenInRoom' => intval($_POST['includeChildrenInRoom']),
						'expressionsCheck' => intval($_POST['expressionsCheck']),
						'monthForFixCalendar' => intval($_POST['monthForFixCalendar']),
						'yearForFixCalendar' => intval($_POST['yearForFixCalendar']),
						'maxAccountScheduleDay' => intval($_POST['maxAccountScheduleDay']),
						'unavailableDaysFromToday' => intval($_POST['unavailableDaysFromToday']),
						'enableFixCalendar' => intval($_POST['enableFixCalendar']),
						'displayRemainingCapacity' => intval($_POST['displayRemainingCapacity']),
						'subscriptionIdForStripe' => sanitize_text_field($_POST['subscriptionIdForStripe']),
						'enableSubscriptionForStripe' => intval($_POST['enableSubscriptionForStripe']),
						'termsOfServiceForSubscription' => esc_url($_POST['termsOfServiceForSubscription']),
						'enableTermsOfServiceForSubscription' => intval($_POST['enableTermsOfServiceForSubscription']),
						'privacyPolicyForSubscription' => esc_url($_POST['privacyPolicyForSubscription']),
						'enablePrivacyPolicyForSubscription' => intval($_POST['enablePrivacyPolicyForSubscription']),
						'displayRemainingCapacityInCalendar' => intval($_POST['displayRemainingCapacityInCalendar']),
						'displayThresholdOfRemainingCapacity' => intval($_POST['displayThresholdOfRemainingCapacity']),
						'displayRemainingCapacityHasMoreThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasMoreThenThreshold']),
						'displayRemainingCapacityHasLessThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasLessThenThreshold']),
						'displayRemainingCapacityHas0' => sanitize_text_field($_POST['displayRemainingCapacityHas0']),
						'startOfWeek' => intval($_POST['startOfWeek']),
						'cancellationOfBooking' => intval($_POST['cancellationOfBooking']),
						'allowCancellationVisitor' => intval($_POST['allowCancellationVisitor']),
						'allowCancellationUser' => intval($_POST['allowCancellationUser']),
						'refuseCancellationOfBooking' => sanitize_text_field($_POST['refuseCancellationOfBooking']),
						'preparationTime' => intval($_POST['preparationTime']),
						'positionPreparationTime' => sanitize_text_field($_POST['positionPreparationTime']),
						'displayDetailsOfCanceled' => intval($_POST['displayDetailsOfCanceled']),
						'displayRemainingCapacityInCalendarAsNumber' => intval($_POST['displayRemainingCapacityInCalendarAsNumber']),
						'hasMultipleServices' => intval($_POST['hasMultipleServices']),
						'flowOfBooking' => sanitize_text_field($_POST['flowOfBooking']),
						'paymentMethod' => sanitize_text_field($_POST['paymentMethod']),
						'email_from' => sanitize_text_field($_POST['email_from']),
						'email_to' => sanitize_text_field($_POST['email_to']),
						'email_from_title' => sanitize_text_field($_POST['email_from_title']),
						'servicesPage' => $servicesPage,
						'calenarPage' => $calenarPage,
						'schedulesPage' => $schedulesPage,
						'visitorDetailsPage' => $visitorDetailsPage,
						'thanksPage' => $thanksPage, 
						'redirectPage' => $redirectPage, 
						'hotelChargeOnSunday' => intval($_POST['hotelChargeOnSunday']),
						'hotelChargeOnMonday' => intval($_POST['hotelChargeOnMonday']),
						'hotelChargeOnTuesday' => intval($_POST['hotelChargeOnTuesday']),
						'hotelChargeOnWednesday' => intval($_POST['hotelChargeOnWednesday']),
						'hotelChargeOnThursday' => intval($_POST['hotelChargeOnThursday']),
						'hotelChargeOnFriday' => intval($_POST['hotelChargeOnFriday']),
						'hotelChargeOnSaturday' => intval($_POST['hotelChargeOnSaturday']),
						'hotelChargeOnDayBeforeNationalHoliday' => intval($_POST['hotelChargeOnDayBeforeNationalHoliday']), 
						'hotelChargeOnNationalHoliday' => intval($_POST['hotelChargeOnNationalHoliday']),
						'maximumNights' => intval($_POST['maximumNights']),
						'minimumNights' => intval($_POST['minimumNights']),
						'multipleRooms' => intval($_POST['multipleRooms']),
						'redirectURL' => sanitize_text_field($_POST['redirectURL']),
						'redirectMode' => sanitize_text_field($_POST['redirectMode']),
					),
					array('key' => intval($_POST['accountKey'])),
					array(
						'%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
						'%d', '%d', '%d', '%d', '%s', '%d', '%s', '%d', '%s', '%d', 
						'%d', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d',
						'%d', '%s', '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', 
						'%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
						'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
						'%s', '%s', 
					),
					array('%d')
				);
				
				$wpdb->query('COMMIT');
				$wpdb->query('UNLOCK TABLES');
				
			} catch (Exception $e) {
				
				$wpdb->query('ROLLBACK');
				$wpdb->query('UNLOCK TABLES');
				
			}/** finally {
				
				$wpdb->query('UNLOCK TABLES');
				
			}**/
			
        	if($bool === 1){
        		
        		return $this->getCalendarAccountListData();
        		
        	}else{
        		
        		return array("status" => $bool);
        		
        	}
        	
        	
        }
        
        public function updateUnixTimeOnBookingData($accountKey = null, $timezone = null) {
        	
        	if (is_null($accountKey)) {
        		
        		return false;
        		
        	}
        	
        	#var_dump($timezone);
        	if (date_default_timezone_set($timezone)) {
        		
        		global $wpdb;
	        	$table_name = $wpdb->prefix."booking_package_schedule";
	        	$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `accountKey` = %d;", array($accountKey));
	        	$rows = $wpdb->get_results($sql, ARRAY_A);
				foreach ((array) $rows as $row) {
					
					$unixTime = date('U', mktime($row['hour'], $row['min'], 0, $row['month'], $row['day'], $row['year']));
					$bool = $wpdb->update( 
		        		$table_name,
						array(
							'unixTime' => intval($unixTime), 
						),
						array('key' => intval($row['key'])),
						array('%d'),
						array('%d')
					);
					
					$table_userPraivateData = $wpdb->prefix."booking_package_userPraivateData";
					$bool = $wpdb->update( 
		        		$table_userPraivateData,
						array(
							'scheduleUnixTime' => intval($unixTime), 
						),
						array('scheduleKey' => intval($row['key'])),
						array('%d'),
						array('%d')
					);
					
				}
				
				return true;
        		
        	}
        	
        	return false;
        	
        }
        
        public function updateCalendarAccountForGoogleWebhook($accountKey, $idForGoogleWebhook, $expirationForGoogleWebhook){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	
        	$bool = $wpdb->update( 
        		$table_name,
				array(
					'idForGoogleWebhook' => sanitize_text_field($idForGoogleWebhook), 
					'expirationForGoogleWebhook' => sanitize_text_field($expirationForGoogleWebhook)
				),
				array('key' => intval($accountKey)),
				array('%s', '%s', '%s'),
				array('%d')
			);
			
        	if($bool === 1){
        		
        		$key = $this->prefix."id_for_google_webhook";
        		if(get_option($key) === false){
        			
        			add_option($key, sanitize_text_field($idForGoogleWebhook));
        			
        		}else{
        			
        			update_option($key, sanitize_text_field($idForGoogleWebhook));
        			
				}
        		
        		return $this->getCalendarAccountListData();
        		
        	}else{
        		
        		return array("status" => $bool);
        		
        	}
        	
        	
        }
        
        
        
        public function lookingForGoogleCalendarId($googleCalendarId = false){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	if($googleCalendarId != false){
        		
        		$sql = $wpdb->prepare(
        			"SELECT `key`,`type`,`googleCalendarID`,`idForGoogleWebhook`,`expirationForGoogleWebhook` FROM ".$table_name." WHERE `idForGoogleWebhook` = %s;", 
        			array(sanitize_text_field($googleCalendarId))
        		);
        		$row = $wpdb->get_row($sql, ARRAY_A);
				if(strlen($row['type']) == 0 || is_null($row['type'])){
					
					$row['type'] = 'day';
					
				}
        		
        		return $row;
        		
        	}
        	
        	return null;
        	
        }
        
        public function deleteCalendarAccount(){
        	
        	global $wpdb;
        	
        	$response = array();
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `schedulesSharing` = %d AND `targetSchedules` = %d;", array(1, $_POST['accountKey']));
			$rows = $wpdb->get_results($sql, ARRAY_A);
			if (count($rows) == 0) {
				
				$table_name = $wpdb->prefix."booking_package_form";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_courseData";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_schedule";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_templateSchedule";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
	        	$wpdb->delete($table_name, array('key' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_emailSetting";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_guests";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_userPraivateData";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_taxes";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$table_name = $wpdb->prefix."booking_package_subscriptions";
	        	$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
	        	
	        	$response = $this->getCalendarAccountListData();
				
			} else {
				
				$calendarNameList = array();
				foreach ((array) $rows as $key => $row) {
					
					array_push($calendarNameList, $row['name']);
					
				}
				$calendarName = implode("\n", $calendarNameList);
				$response = array('error' => 1, 'message' => __('If you want to delete this calendar, delete the calendar sharing the schedules.', $this->pluginName) . "\n" . $calendarName);
				
			}
			
        	return $response;
        	
        }
        
        public function addGuests($accountKey){
        	
        	global $wpdb;
        	
        	$guestsList = array(
    			0 => array("number" => 1, "price" => 0, "name" => "1 adult"),
    			1 => array("number" => 2, "price" => 0, "name" => "2 adults"),
    		);
    		$table_name = $wpdb->prefix."booking_package_guests";
    		$wpdb->insert(
    			$table_name, 
    			array(
    				'accountKey' => intval($accountKey), 
    				'name' => "Number of adults", 
    				'target' => "adult",
    				'json' => json_encode($guestsList), 
    				'required' => 1,
    				'ranking' => 1
    			), 
    			array('%d', '%s', '%s', '%s', '%d')
    		);
    		
    		$guestsList = array(
    			0 => array("number" => 1, "price" => 0, "name" => "1 child"),
    			1 => array("number" => 2, "price" => 0, "name" => "2 children"),
    		);
    		$table_name = $wpdb->prefix."booking_package_guests";
    		$wpdb->insert(
    			$table_name, 
    			array(
    				'accountKey' => intval($accountKey), 
    				'name' => "Number of children", 
    				'target' => "children",
    				'json' => json_encode($guestsList), 
    				'required' => 0,
    				'ranking' => 2
    			), 
    			array('%d', '%s', '%s', '%s', '%d')
    		);
        	
        }
        
        public function getAccountScheduleData(){
        	
        	global $wpdb;
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
        	
        	$month = intval($_POST['month']);
        	$day = intval($_POST['day']);
        	$year = intval($_POST['year']);
        	
			$last_day = date('t', mktime(0, 0, 0, $month, $day, $year));
			$week_start_num = date('w', mktime(0, 0, 0, $month, $day, $year));
			$week_last_num = date('w', mktime(0, 0, 0, $month, $last_day, $year));
			
			$scheduleData = array();
			$jsonAraay = array('completeFlag' => 'accountScheduleData', 'startDay' => 1, 'lastDay' => intval($last_day), 'startWeek' => intval($week_start_num), 'lastWeek' => intval($week_last_num), 'month' => intval($month), 'year' => intval($year), 'timestamp' => date('U'));
			$scheduleData['date'] = $jsonAraay;
			/**
			$calendarList = array();
			if(intval($week_start_num) != 0){
				
				$lastUnixTime = date('U', mktime(0, 0, 0, $month, 1, $year)) - 1;
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = intval(date('t', $lastUnixTime));
				$startDay = $endDay - intval(date('w', $lastUnixTime));
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array('startDay' => $startDay, 'lastDay' => $endDay, 'startWeek' => intval(date('w', mktime(0, 0, 0, $lastMonth, $startDay, $lastYear))), 'lastWeek' => intval(date('w', $lastUnixTime)), 'year' => $lastYear, 'month' => intval($lastMonth), 'day' => $startDay);
				
			}
			
			$calendarList[intval($year.sprintf('%02d', $month))] = $jsonAraay;
			
			if(intval($week_last_num) != 6){
				
				$lastUnixTime = date('U', mktime(23, 60, 0, $month, $last_day, $year));
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = 7 - intval(date('w', $lastUnixTime));
				$startDay = 1;
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array('startDay' => $startDay, 'lastDay' => $endDay, 'startWeek' => intval(date('w', $lastUnixTime)), 'lastWeek' => 6, 'year' => $lastYear, 'month' => intval($lastMonth), 'day' => $startDay);
				
			}
			**/
			
			$calendarAccount = $this->getCalendarAccount($accountKey);
			$calendarList = $this->getCalendarList($month, $day, $year, $calendarAccount['startOfWeek']);
			
			$list = array();
			foreach ((array) $calendarList as $key => $value) {
				
				for ($i = $value['startDay']; $i <= $value['lastDay']; $i++) {
					
					$key = $value['year'].sprintf("%02d%02d", $value['month'], $i);
					$week = date('w', mktime(0, 0, 0, $value['month'], $i, $value['year']));
					$dayArray = array('year' => $value['year'], 'month' => $value['month'], 'day' => $i, 'week' => $week, 'count' => null, 'accountKey' => $accountKey, 'status' => 0);
					$list[$key] = $dayArray;
					
				}
				
				$table_name = $wpdb->prefix."booking_package_schedule";
				$sql = $wpdb->prepare(
					"SELECT year,month,day,accountKey,SUM(capacity),SUM(remainder),COUNT(day) FROM `".$table_name."` GROUP BY `year`,`month`,`day`,`holiday`,`accountKey` HAVING `accountKey` = %d AND `year` = %d AND `month` = %d AND (`day` >= %d AND `day` <= %d);", 
					array(intval($accountKey), intval($value['year']), intval($value['month']), intval($value['startDay']), intval($value['lastDay']))
				);
				$calendarList[$key]['sql'] = $sql;
				$rows = $wpdb->get_results($sql, ARRAY_A);
				foreach ((array) $rows as $row) {
					
					$key = $row['year'].sprintf("%02d%02d", $row['month'], $row['day']);
					if(isset($list[$key])){
						
						$list[$key]['status'] = 1;
						
					}
					
				}
				
			}
			
			$scheduleData['calendarList'] = $calendarList;
			$scheduleData['calendar'] = $list;
			
        	return $scheduleData;
        	
        }
        
        public function getRangeOfSchedule($accountKey = false){
			
			if ($accountKey != false) {
				
				global $wpdb;
				
				$account = $this->getCalendarAccount($accountKey);
				$table_name = $wpdb->prefix."booking_package_schedule";
				$scheduleList = array();
				for ($i = intval($_POST['start']); $i <= intval($_POST['end']); $i++) {
					
					$date = date_parse($i);
					if (!checkdate($date['month'], $date['day'], $date['year'])) {
						
						$date = date_parse($i - 1);
						$unixTime = date('U', mktime(23, 60, 0, $date['month'], $date['day'], $date['year'])) + 1;
						$i = intval(date('Ymd', $unixTime));
						$date = date_parse($i);
						
					}
					
					$sql = $wpdb->prepare(
						"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY day ASC;", 
						array(
							intval($accountKey), 
							intval($date['year']), 
							intval($date['month']), 
							intval($date['day'])
						)
					);
					$row = $wpdb->get_row($sql);
					if (is_null($row)) {
						
						$unixTime = date('U', mktime(0, 0, 0, intval($date['month']), $date['day'], intval($date['year'])));
						$week = date('w', mktime(0, 0, 0, intval($date['month']), $date['day'], intval($date['year'])));
						$scheduleList[$i] = array(
							"accountKey" => $accountKey, 
							"unixTime" => $unixTime,
							"year" => intval($date['year']), 
							"month" => intval($date['month']), 
							"day" => $date['day'], 
							"weekKey" => $week,
							"hour" => 0,
							"min" => 0,
							"title" => "",
							"stop" => "false",
							"holiday" => "false",
							"existence" => 0,
							"waitingRemainder" => 0,
							"uploadDate" => 0,
							"cost" => $account['cost'],
							"capacity" => $account['numberOfRoomsAvailable'],
							"remainder" => $account['numberOfRoomsAvailable'],
						);
						
					} else {
						
						$row->existence = 1;
						$scheduleList[$i] = $row;
						
					}
					
				}
				
				return $scheduleList;
				
			}
			
			die();
			
        }
        
        public function getPublicSchedule(){
        	
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            $calendar = array();
            
        	global $wpdb;
            $table_name = $wpdb->prefix."booking_package_schedule";
			$sql = $wpdb->prepare(
				"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY weekKey, hour, min ASC;", 
				array(intval($accountKey), intval($_POST['year']), intval($_POST['month']), intval($_POST['day']))
			);
            $rows = $wpdb->get_results($sql, ARRAY_A);
            /**
            foreach ((array) $rows as $row) {
            	
            	$key = $row['year'].sprintf("%02d%02d", $row['month'], $row['day']);
            	$calendar[$key] = $row;
            	
            }
            **/
            
            return $rows;
        	
        }
        
        public function getTemplateSchedule($weekKey){
        	
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_templateSchedule";
			$sql = $wpdb->prepare(
				"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `weekKey` = %d ORDER BY weekKey, hour, min ASC;", 
				array(intval($accountKey), intval($weekKey))
			);
            $rows = $wpdb->get_results($sql, ARRAY_A);
            
            return $rows;
            
        }
        
        public function updateRangeOfSchedule($accountKey = false){
        	
        	if ($accountKey != false && isset($_POST['json'])) {
        		
        		global $wpdb;
        		/**
        		$timezone = get_option('timezone_string');
				date_default_timezone_set($timezone);
				**/
				$updateDate = date('U');
				$account = $this->getCalendarAccount($accountKey);
            	$table_name = $wpdb->prefix."booking_package_schedule";
                    
				$jsonList = json_decode(str_replace("\\", "", $_POST['json']));
            	foreach ((array) $jsonList as $key => $value) {
            		
            		
            		if ($value->existence == 0) {
            			
            			$sql = $wpdb->prepare(
        					"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY day ASC;", 
        					array(
        						intval($accountKey), 
        						intval($value->year), 
        						intval($value->month), 
        						intval($value->day)
        					)
        				);
        				$row = $wpdb->get_row($sql);
        				if (is_null($row)) {
        					
        					/**
    						insertSchedule(	$table_name, $accountKey, $unixTime, $month, $day, $year, $week, $hour, $min, 
        					$title, $cost, $capacity, $stop, $uploadDate)
    						**/
    						
    						$this->insertSchedule(	$table_name, $accountKey, $value->unixTime, $value->month, $value->day,
    												$value->year, $value->weekKey, $value->hour, $value->min, $value->deadlineTime, $value->title,
    												$value->cost, $value->capacity, $value->stop, $updateDate);
    						
        				}
            			
            		} else {
            			
            			$sql = $wpdb->prepare(
        					"SELECT * FROM ".$table_name." WHERE `key` = %d;", 
        					array( 
        						intval($value->key)
        					)
        				);
        				$row = $wpdb->get_row($sql);
        				
        				if ($row->capacity != $value->capacity) {
        					
        					$value->remainder = $value->capacity - ($row->capacity - $row->remainder);
        					/**
        					if($row->capacity < $value->capacity){
	            				
	            				$value->remainder = $value->remainder + ($value->capacity - $row->capacity);
	            				
	        				}else{
	            				
	            				$value->remainder = $value->remainder - $value->capacity;
	            				
	        				}
        					**/
        				}
        				
        				$wpdb->update( 
        					$table_name,
							array(
								'cost' => intval($value->cost), 
								'capacity' => intval($value->capacity), 
								'remainder' => intval($value->remainder),
								'stop' => sanitize_text_field($value->stop)
							),
							array('key' => intval($value->key)),
							array('%d', '%d', '%d', '%s'),
							array('%d')
						);
            			
            		}
            		
            	}
            	
            	$_POST['accountKey'] = $accountKey;
            	$_POST['day'] = 1;
            	$response = array();
            	$response['getAccountScheduleData'] = $this->getAccountScheduleData();
            	$response['getRangeOfSchedule'] = $this->getRangeOfSchedule($accountKey);
            	
            	return $response;
            	
        	}
        	
        	die();
        	
        }
        
        public function updateAccountTemplateSchedule(){
        	
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            global $wpdb;
            $array = array('completeFlag' => 'updateAccountTemplateSchedule');
	        $sqlList = array();
	        $valueList = array();
	        $updateTime = date('U');
	        
	        $scheduleRead = array();
		    $i = 0;
		    #$sql = "SELECT * FROM `booking_package_templateSchedule` WHERE `accountKey` = ? AND `weekKey` = ? ORDER BY hour, min ASC;";
		    /**
		    $table_name = $wpdb->prefix."booking_package_templateSchedule";
		    $valueArray = array(intval($accountKey), intval($_POST['weekKey']));
			$sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `weekKey` = %d ORDER BY hour, min ASC;", array($valueArray));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            if(is_null($rows) !== false){
                
                foreach ((array) $rows as $row) {
                    
                    #var_dump($row);
                    $jsonArray = array(	'key' => $row['key'], 'weekKey' => $row['weekKey'], 'hour' => $row['hour'], 'min' => $row['min'], 
								'title' => $row['title'], 'cost' => $row['cost'], 'holiday' => $row['holiday']);
					$scheduleRead[$i] = $jsonArray;
					$i++;
                    
                }
                
            }
            **/
            
            for ($i = 0; $i < $_POST['timeCount']; $i++) {
				
				$schedule = json_decode(str_replace("\\", "", $_POST['schedule' . $i]), true);
				$deadlineTime = 0;
    			if (isset($schedule['deadlineTime'])) {
    				
    				$deadlineTime = intval($schedule['deadlineTime']);
    				
    			}
			
				#$unixTime = mktime(intval($schedule['hour']), intval($schedule['min']), 0, intval($_POST['month']), intval($_POST['day0']), intval($_POST['year']));
				$valueArray = array($accountKey, intval($schedule['hour']), intval($schedule['min']), intval($_POST['weekKey']));
				$table_name = $wpdb->prefix . "booking_package_templateSchedule";
				$sql = $wpdb->prepare(
					"SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `hour` = %d AND `min` = %d AND `weekKey` = %d;", 
					$valueArray
				);
				$row = $wpdb->get_row($sql, ARRAY_A);
				if (is_array($row)) {
					
					#var_dump($row);
					if ($schedule['delete'] == 'true') {
						
						array_push($sqlList, "DELETE FROM `".$table_name."` WHERE `key` = %d;");
						array_push($valueList, array(intval($row['key'])));
						
					} else {
						
						if ($schedule['delete'] == 'false') {
							
							$sql = "UPDATE ".$table_name." SET `hour` = %d, `min` = %d, `title` = %s, `cost` = %d, `capacity` = %d, `stop` = %s, `deadlineTime` = %d WHERE `key` = %d;";
							$value = array(	
								intval($schedule['hour']), 
								intval($schedule['min']), 
								sanitize_text_field($schedule['title']), 
								intval($schedule['cost']), 
								intval($schedule['capacity']), 
								sanitize_text_field($schedule['stop']), 
								intval($deadlineTime), 
								intval($row['key'])
							);
							
						} else {
							
							$sql = "DELETE FORM ".$table_name." WHERE `key` = %d;";
							$value = array(	
								intval($row['key'])
							);
							
						}
						
						
						array_push($sqlList, $sql);
						array_push($valueList, $value);
						
					}
					
				} else {
					
					if ($schedule['delete'] == 'true') {
						
						continue;
						
					}
					
					$sql = "INSERT INTO ".$table_name." (`accountKey`, `weekKey` ,`hour`, `min`, `title`, `cost`, `capacity`, `stop`, `holiday`, `uploadDate`, `deadlineTime`) VALUES (%d, %d, %d, %d, %s, %d, %d, %s, %s, %d, %d);";
					$value = array(
						intval($accountKey), 
						intval($_POST['weekKey']), 
						intval($schedule['hour']), 
						intval($schedule['min']), 
						sanitize_text_field($schedule['title']), 
						intval($schedule['cost']), 
						intval($schedule['capacity']), 
						sanitize_text_field($schedule['stop']), 
						'false', 
						$updateTime,
						intval($deadlineTime), 
					);
					array_push($sqlList, $sql);
					array_push($valueList, $value);
					
				}
				
			}
			
			$array['sql'] = $sqlList;
			$array['value'] = $valueList;
			
			for ($i = 0; $i < count($sqlList); $i++) {
				
				$sql = $wpdb->prepare($sqlList[$i], $valueList[$i]);
				$wpdb->query($sql);
				
			}
			
			$year = date('Y');
			$month = date('m');
			$day = date('d');
			#return array('sql' => $sqlList, 'values' => $valueList);
			$this->insertAccountSchedule($month, $day, $year, $accountKey);
            
        }
        
        public function insertSchedule($table_name, $accountKey, $unixTime, $month, $day, $year, $week, $hour, $min, $deadlineTime, $title, $cost, $capacity, $stop, $uploadDate){
        	
        	global $wpdb;
        	$wpdb->insert(
    			$table_name, 
    			array(
    				'accountKey' => intval($accountKey), 
    				'unixTime' => intval($unixTime), 
    				'year' => intval($year), 
    				'month' => intval($month), 
    				'day' => intval($day), 
    				'weekKey' => intval($week), 
    				'hour' => intval($hour), 
    				'min' => intval($min), 
    				'title' => sanitize_text_field($title), 
    				'cost' => intval($cost), 
    				'capacity' => intval($capacity), 
    				'remainder' => intval($capacity), 
    				'stop' => sanitize_text_field($stop), 
    				'holiday' => 'false', 
    				'uploadDate' => intval($uploadDate),
    				'deadlineTime' => intval($deadlineTime),
    			), 
    			array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%d', '%d')
    		);
        	
        	
        }
        
        public function updateHotelCharge($account){
        	
        	global $wpdb;
        	
			if (
				isset($account['hotelChargeOnSunday']) === true &&
				isset($account['hotelChargeOnMonday']) === true &&
				isset($account['hotelChargeOnTuesday']) === true &&
				isset($account['hotelChargeOnWednesday']) === true &&
				isset($account['hotelChargeOnThursday']) === true &&
				isset($account['hotelChargeOnFriday']) === true &&
				isset($account['hotelChargeOnSaturday']) === true &&
				isset($account['hotelChargeOnDayBeforeNationalHoliday']) === true && 
				isset($account['hotelChargeOnNationalHoliday']) === true &&
				intval($account['hotelChargeOnSunday']) == 0 &&
				intval($account['hotelChargeOnMonday']) == 0 &&
				intval($account['hotelChargeOnTuesday']) == 0 &&
				intval($account['hotelChargeOnWednesday']) == 0 &&
				intval($account['hotelChargeOnThursday']) == 0 &&
				intval($account['hotelChargeOnFriday']) == 0 &&
				intval($account['hotelChargeOnSaturday']) == 0 &&
				intval($account['hotelChargeOnDayBeforeNationalHoliday']) == 0 && 
				intval($account['hotelChargeOnNationalHoliday']) == 0
			) {
				
				$table_name = $wpdb->prefix."booking_package_calendarAccount";
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
				try {
					
					$bool = $wpdb->update(
						$table_name,
						array(
							'hotelChargeOnSunday' => intval($account['cost']),
							'hotelChargeOnMonday' => intval($account['cost']),
							'hotelChargeOnTuesday' => intval($account['cost']),
							'hotelChargeOnWednesday' => intval($account['cost']),
							'hotelChargeOnThursday' => intval($account['cost']),
							'hotelChargeOnFriday' => intval($account['cost']),
							'hotelChargeOnSaturday' => intval($account['cost']),
							'hotelChargeOnDayBeforeNationalHoliday' => 0,
							'hotelChargeOnNationalHoliday' => 0,
						),
						array('key' => intval($account['key'])),
						array(
							'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
						),
						array('%d')
					);
					
					$wpdb->query('COMMIT');
					$wpdb->query('UNLOCK TABLES');
					
				} catch (Exception $e) {
					
					$wpdb->query('ROLLBACK');
					$wpdb->query('UNLOCK TABLES');
					
				}/** finally {
					
					$wpdb->query('UNLOCK TABLES');
					
				}**/
				
				$account['hotelChargeOnSunday'] = intval($account['cost']);
				$account['hotelChargeOnMonday'] = intval($account['cost']);
				$account['hotelChargeOnTuesday'] = intval($account['cost']);
				$account['hotelChargeOnWednesday'] = intval($account['cost']);
				$account['hotelChargeOnThursday'] = intval($account['cost']);
				$account['hotelChargeOnFriday'] = intval($account['cost']);
				$account['hotelChargeOnSaturday'] = intval($account['cost']);
				$account['hotelChargeOnDayBeforeNationalHoliday'] = 0;
				$account['hotelChargeOnNatiohotelChargeOnNationalHolidaynalHoliday'] = 0;
				
			} else {
				
				//var_dump($account);
				
			}
			
			return $account;

        }
        
        public function insertAccountSchedule($month, $day, $year, $accountKey = false) {
			
			if ($accountKey === false) {
				
				return false;
				
			}
			
			global $wpdb;
			$uploadDate = date('U');
			$const_unixTime = date('U', mktime(0, 0, 0, $month, $day, $year));
			$maxAccountScheduleDay = intval(get_option($this->prefix.'maxAccountScheduleDay', 7));
			#var_dump($maxAccountScheduleDay);
			
			/** Get Holidays **/
			$nationalHolidays = array();
			$table_name = $wpdb->prefix . 'booking_package_regular_holidays';
			$sql = $wpdb->prepare(
				"SELECT `month`, `day`, `year`, `unixTime` FROM `".$table_name."` WHERE `accountKey` = 'national' AND `status` = 1 AND `unixTime` >= %d;", 
				array(intval($const_unixTime))
			);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				$nationalHolidays[$row['year'] . sprintf('%02d', $row['month']) . sprintf('%02d', $row['day'])] = $row;
				
			}
			//var_dump($nationalHolidays);
			/** Get Holidays **/
			
			$row = $this->getCalendarAccount($accountKey);
			if ($row === false) {
				
				return false;
				
			}
			$rows = array(intval($row['key']) => $row);
			#$table_name = $wpdb->prefix . "booking_package_calendarAccount";
			#$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `status` = %s;", array("open"));
			#$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				date_default_timezone_set($row['timezone']);
				$maxAccountScheduleDay = intval($row['maxAccountScheduleDay']);
				$accountKey = $row['key'];
				$accountType = $row['type'];
				if ($accountType == 'hotel') {
					
					$row = $this->updateHotelCharge($row);
					
				}
				
				$calendarAccount = $row;
				$unixTime = $const_unixTime;
				$hotelCharges = array(
					$calendarAccount['hotelChargeOnSunday'], 
					$calendarAccount['hotelChargeOnMonday'], 
					$calendarAccount['hotelChargeOnTuesday'], 
					$calendarAccount['hotelChargeOnWednesday'], 
					$calendarAccount['hotelChargeOnThursday'], 
					$calendarAccount['hotelChargeOnFriday'], 
					$calendarAccount['hotelChargeOnSaturday'], 
				);
				
				for ($i = 0; $i < $maxAccountScheduleDay; $i++) {
    				
    				$year = date('Y', $unixTime);
					$month = date('m', $unixTime);
					$day = date('d', $unixTime);
					$week = date('w', $unixTime);
					$dayBeforeUnixTime = $unixTime + (1440 * 60);
					$dayBeforeNationalHolidayKey = date('Y', $dayBeforeUnixTime) . date('m', $dayBeforeUnixTime) . date('d', $dayBeforeUnixTime);
					$nationalHolidayKey = $year . sprintf('%02d', $month) . sprintf('%02d', $day);
					#print $year."_".$month."_".$day."<br>\n";
					$unixTime += 1440 * 60;
					
					$table_name = $wpdb->prefix . "booking_package_schedule";
					$sql = "SELECT `key` FROM `".$table_name."` WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d LIMIT 0, 1;";
					$valueArray = array(intval($accountKey), intval($year), intval($month), intval($day));
					$row = $wpdb->get_row($wpdb->prepare($sql, $valueArray));
					
					if (is_null($row)) {
						
						if ($calendarAccount['type'] == 'day') {
							
							$table_name = $wpdb->prefix."booking_package_templateSchedule";
							$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `weekKey` = %d ORDER BY `weekKey`, `hour`, `min` ASC;";
							$template_rows = $wpdb->get_results($wpdb->prepare($sql, array(intval($accountKey), intval($week))), ARRAY_A);
							foreach ((array) $template_rows as $template_row) {
								
								$time = date('U', mktime($template_row['hour'], $template_row['min'], 0, $month, $day, $year));
								$table_name = $wpdb->prefix."booking_package_schedule";
								
								$this->insertSchedule(
									$table_name, $accountKey, $time, $month, $day, $year, $week, 
									$template_row['hour'], $template_row['min'], $template_row['deadlineTime'], $template_row['title'],
									$template_row['cost'], $template_row['capacity'], $template_row['stop'],
									$uploadDate
								);
								
							}
						
						} else {
							
							$cost = $calendarAccount['cost'];
							$hotelCharges = array(
								$calendarAccount['hotelChargeOnSunday'], 
								$calendarAccount['hotelChargeOnMonday'], 
								$calendarAccount['hotelChargeOnTuesday'], 
								$calendarAccount['hotelChargeOnWednesday'], 
								$calendarAccount['hotelChargeOnThursday'], 
								$calendarAccount['hotelChargeOnFriday'], 
								$calendarAccount['hotelChargeOnSaturday'], 
							);
							
							if (isset($nationalHolidays[intval($nationalHolidayKey)]) && intval($calendarAccount['hotelChargeOnNationalHoliday']) > 0) {
								
								$cost = $calendarAccount['hotelChargeOnNationalHoliday'];
								
							} else if (isset($nationalHolidays[intval($dayBeforeNationalHolidayKey)]) && intval($calendarAccount['hotelChargeOnDayBeforeNationalHoliday']) > 0) {
								
								$cost = $calendarAccount['hotelChargeOnDayBeforeNationalHoliday'];
								
							} else {
								
								$cost = $hotelCharges[intval($week)];
								
							}
							
							$capacity = $calendarAccount['numberOfRoomsAvailable'];
							$time = date('U', mktime(0, 0, 0, $month, $day, $year));
							$table_name = $wpdb->prefix."booking_package_schedule";
							
							$wpdb->insert(
								$table_name, 
								array(
									'accountKey' => intval($accountKey), 
									'unixTime' => intval($time), 
									'year' => intval($year), 
									'month' => intval($month), 
									'day' => intval($day), 
									'weekKey' => intval($week), 
									'hour' => 0, 
									'min' => 0, 
									'title' => '', 
									'cost' => intval($cost), 
									'capacity' => intval($capacity), 
									'remainder' => intval($capacity), 
									'stop' => 'false', 
									'holiday' => 'false', 
									'uploadDate' => $uploadDate
								), 
								array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%d')
							);
							
						}
						
					}
					
				}
				
			}
			
		}
		
    	public function updateAccountSchedule(){
    		
    		$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
    		
    		global $wpdb;
    		$sql = '';
    		$courseTime = 0;
    		$maintenanceTime = 0;
    		
			$array = array();
			$value_array = array();
			$rpeatList = array();
			$prepareForRpeatReservation = array();
			
			$table_name = $wpdb->prefix."booking_package_courseData";
			$sql = "SELECT `key`,max(`time`) FROM `".$table_name."` WHERE `accountKey` = %d;";
    		$row = $wpdb->get_row(
    			$wpdb->prepare(
    				$sql, 
    				array(intval($accountKey))
    			), 
    			ARRAY_A
    		);
    		if (is_null($row)) {
    			
    			$courseTime = 0;
    			
    		} else {
    			
    			$courseTime = intval($row["max(`time`)"]);
    			
    		}
    		
    		$wpdb->query("START TRANSACTION");
    		$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE, `" . $wpdb->prefix."booking_package_userPraivateData" . "` WRITE");
    		#try {
    			
    			for ($i = 0; $i < $_POST['timeCount']; $i++) {
	    			
	    			$updateBool = false;
	    			$schedule = json_decode(str_replace("\\", "", $_POST['schedule' . $i]), true);
	    			$unixTime = intval(date('U', mktime($schedule['hour'], $schedule['min'], 0, $_POST['month'], $_POST['day'], $_POST['year'])));
	    			$weekKey = intval(date('w', mktime($schedule['hour'], $schedule['min'], 0, $_POST['month'], $_POST['day'], $_POST['year'])));
	    			
	    			$deadlineTime = 0;
	    			if (isset($schedule['deadlineTime'])) {
	    				
	    				$deadlineTime = intval($schedule['deadlineTime']);
	    				
	    			}
	    			
	    			if ($schedule['key']) {
	    				
	    				$table_name = $wpdb->prefix."booking_package_schedule";
	    				$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
	    				$row = $wpdb->get_row(
	    					$wpdb->prepare($sql, array(intval($schedule['key']))), 
	    					ARRAY_A
	    				);
	    				
	    				if (!is_null($row)) {
	    					
	    					#var_dump($row);
	    					$updateBool = true;
	    					if ($schedule['delete'] == 'true') {
	    						
	    						$sql = "DELETE FROM `".$table_name."` WHERE `capacity` = `remainder` AND `key` = %d;";
	    						$updateArray = array(intval($schedule['key']));
	    						
	    					} else {
	    						
								$capacity = $schedule['capacity'];
								$remainder = $schedule['remainder'];
	    						
	    						$sql = "UPDATE `".$table_name."` SET `unixTime` = %d, `year` = %d, `month` = %d, `day` = %d, ";
								$sql .= "`hour` = %d, `min` = %d, `title` = %s, `capacity` = %d, `remainder` = %d, `stop` = %s, `cost` = %d , `deadlineTime` = %d ";
								$sql .= "WHERE `key` = %d;";
	    						$updateArray = array(
	    							$unixTime,
	    							intval($_POST['year']),
	    							intval($_POST['month']),
	    							intval($_POST['day']),
	    							intval($schedule['hour']),
	    							intval($schedule['min']),
	    							sanitize_text_field($schedule['title']),
									intval($capacity),
									intval($remainder),
									sanitize_text_field($schedule['stop']),
									intval(0),
									intval($deadlineTime),
									intval($schedule['key'])
								);
								
	    					}
	    					
	    				}
	    				
	    			} else {
	    				
	    				$remainder = $schedule['capacity'];
	    				$remainder = $schedule['remainder'];
	    				$reserveRemainder = 0;
	    				
	    				$table_name = $wpdb->prefix."booking_package_userPraivateData";
	    				$serch_sql = "SELECT * FROM `".$table_name."` WHERE `scheduleUnixTime` > %d AND `scheduleUnixTime` < %d AND `accountKey` = %d;";
						$valueArray = array(($unixTime - ($courseTime * 60) - ($maintenanceTime * 60)), $unixTime, intval($accountKey));
	    				#var_dump($valueArray);
	    				$sql = $wpdb->prepare($serch_sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $rows as $row) {
							
							$reserveUnixTime = $row['scheduleUnixTime'] + ($row['courseTime'] * 60);
							if($unixTime < $reserveUnixTime){
								$remainder--;
								$reserveRemainder++;
							}
							
						}
						
						if ($remainder < 0) {
							
							$updateBool = false;
							
						} else {
							
							$updateBool = true;
							
						}
						
						if ($updateBool == true) {
							
							if ($schedule['delete'] == 'true') {
								
								continue;
								
							}
							
							$table_name = $wpdb->prefix."booking_package_schedule";
							$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d;";
							$row = $wpdb->get_row($wpdb->prepare($sql, array(intval($accountKey), $unixTime)), ARRAY_A);
							if (is_null($row)) {
								
								$sql = "INSERT INTO `".$table_name."` (`accountKey`,`unixTime`,`year`,`month`,`day`, `weekKey`, `hour`,`min`,`title`,`capacity`,`remainder`,`stop`,`holiday`,`cost`,`deadlineTime`) ";
								$sql .= "VALUES (%d, %d, %d, %d, %d, %d, %d, %d, %s, %d, %d, %s, %s, %d, %d);";
								$updateArray = array(
									intval($accountKey),
									$unixTime,
									intval($_POST['year']),
									intval($_POST['month']),
									intval($_POST['day']),
									intval($weekKey),
									intval($schedule['hour']),
									intval($schedule['min']),
									sanitize_text_field($schedule['title']),
									intval($schedule['capacity']),
									intval($remainder),
									sanitize_text_field($schedule['stop']),
									"false",
									intval(0),
									intval($deadlineTime),
								);
								
							}
							
						}
	    				
	    				
	    			}
	    			
	    			if ($updateBool == true) {
						#var_dump($sql);
						array_push($array, $sql);
						array_push($value_array, $updateArray);
					}
	    			
	    			
	    			/**
	    			$unixTime = intval(date('U', mktime($_POST['hour'.$i], $_POST['min'.$i], 0, $_POST['month'], $_POST['day'], $_POST['year'])));
	    			$weekKey = intval(date('w', mktime($_POST['hour'.$i], $_POST['min'.$i], 0, $_POST['month'], $_POST['day'], $_POST['year'])));
	    			
	    			$deadlineTime = 0;
	    			if(isset($_POST['deadlineTime'.$i])){
	    				
	    				$deadlineTime = intval($_POST['deadlineTime'.$i]);
	    				
	    			}
	    			
	    			if($_POST['key'.$i]){
	    				
	    				$table_name = $wpdb->prefix."booking_package_schedule";
	    				$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
	    				$row = $wpdb->get_row(
	    					$wpdb->prepare($sql, array(intval($_POST['key'.$i]))), 
	    					ARRAY_A
	    				);
	    				
	    				if(!is_null($row)){
	    					
	    					#var_dump($row);
	    					$updateBool = true;
	    					if($_POST['delete'.$i] == 'true'){
	    						
	    						$sql = "DELETE FROM `".$table_name."` WHERE `capacity` = `remainder` AND `key` = %d;";
	    						$updateArray = array(intval($_POST['key'.$i]));
	    						
	    					}else{
	    						
								$capacity = $_POST['capacity'.$i];
								$remainder = $_POST['remainder'.$i];
	    						
	    						$sql = "UPDATE `".$table_name."` SET `unixTime` = %d, `year` = %d, `month` = %d, `day` = %d, ";
								$sql .= "`hour` = %d, `min` = %d, `title` = %s, `capacity` = %d, `remainder` = %d, `stop` = %s, `cost` = %d , `deadlineTime` = %d ";
								$sql .= "WHERE `key` = %d;";
	    						$updateArray = array(
	    							$unixTime,
	    							intval($_POST['year']),
	    							intval($_POST['month']),
	    							intval($_POST['day']),
	    							intval($_POST['hour'.$i]),
	    							intval($_POST['min'.$i]),
	    							sanitize_text_field($_POST['title'.$i]),
									intval($capacity),
									intval($remainder),
									sanitize_text_field($_POST['stop'.$i]),
									intval(0),
									intval($deadlineTime),
									intval($_POST['key'.$i])
								);
								
	    					}
	    					
	    				}
	    				
	    			}else{
	    				
	    				$remainder = $_POST['capacity'.$i];
	    				$remainder = $_POST['remainder'.$i];
	    				$reserveRemainder = 0;
	    				
	    				$table_name = $wpdb->prefix."booking_package_userPraivateData";
	    				$serch_sql = "SELECT * FROM `".$table_name."` WHERE `scheduleUnixTime` > %d AND `scheduleUnixTime` < %d AND `accountKey` = %d;";
						$valueArray = array(($unixTime - ($courseTime * 60) - ($maintenanceTime * 60)), $unixTime, array(intval($accountKey)));
	    				#var_dump($valueArray);
	    				$sql = $wpdb->prepare($serch_sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $rows as $row) {
							
							$reserveUnixTime = $row['scheduleUnixTime'] + ($row['courseTime'] * 60);
							if($unixTime < $reserveUnixTime){
								$remainder--;
								$reserveRemainder++;
							}
							
						}
						
						if($remainder < 0){
							
							$updateBool = false;
							
						}else{
							
							$updateBool = true;
							
						}
						
						if($updateBool == true){
							
							if ($_POST['delete' . $i] == 'true') {
								
								continue;
								
							}
							
							$table_name = $wpdb->prefix."booking_package_schedule";
							$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d;";
							$row = $wpdb->get_row($wpdb->prepare($sql, array(intval($accountKey), $unixTime)), ARRAY_A);
							if(is_null($row)){
								
								$sql = "INSERT INTO `".$table_name."` (`accountKey`,`unixTime`,`year`,`month`,`day`, `weekKey`, `hour`,`min`,`title`,`capacity`,`remainder`,`stop`,`holiday`,`cost`,`deadlineTime`) ";
								$sql .= "VALUES (%d, %d, %d, %d, %d, %d, %d, %d, %s, %d, %d, %s, %s, %d, %d);";
								$updateArray = array(
									intval($accountKey),
									$unixTime,
									intval($_POST['year']),
									intval($_POST['month']),
									intval($_POST['day']),
									intval($weekKey),
									intval($_POST['hour'.$i]),
									intval($_POST['min'.$i]),
									sanitize_text_field($_POST['title'.$i]),
									intval($_POST['capacity'.$i]),
									intval($remainder),
									sanitize_text_field($_POST['stop'.$i]),
									"false",
									intval(0),
									intval($deadlineTime),
								);
								
							}
							
						}
	    				
	    				
	    			}
	    			
	    			if($updateBool == true){
						#var_dump($sql);
						array_push($array, $sql);
						array_push($value_array, $updateArray);
					}
					
					**/
	    			
	    		}
	    		
	    		for ($i = 0; $i < count($array); $i++) {
						
					$sql = $wpdb->prepare($array[$i], $value_array[$i]);
					$wpdb->query($sql);
					
				}
				
				$wpdb->query('COMMIT');
				$wpdb->query('UNLOCK TABLES');
				
    		/**	
    		} catch (Exception $e) {
    			
    			$wpdb->query('ROLLBACK');
    			
    		} finally {
    			
    			$wpdb->query('UNLOCK TABLES');
    			
    		}**/
    		
    		
    		
    	}
    	
    	public function deleteOldDaysInSchedules(){
    		
    		global $wpdb;
    		/**
    		$timezone = get_option('timezone_string');
            date_default_timezone_set($timezone);
            **/
            $unixTime = date('U') - (14 * 24 * 3600);
            $unixTime = date('U', mktime(0, 0, 0, date('m', $unixTime), date('d', $unixTime), date('Y', $unixTime)));
            
            $table_name = $wpdb->prefix."booking_package_schedule";
            $sql = $wpdb->prepare("DELETE FROM `".$table_name."` WHERE `unixTime` < %d;", array($unixTime));
            $wpdb->query($sql);
            return $sql;
    		
    	}
    	
    	public function deletePublishedSchedules($accountKey = 1){
    		
    		$response = array("status" => "error", "request" => $_POST);
    		if (isset($_POST['deletePublishedSchedules_from_month']) && isset($_POST['deletePublishedSchedules_from_day']) && isset($_POST['deletePublishedSchedules_from_year'])) {
				
				if (
					checkdate($_POST['deletePublishedSchedules_from_month'], $_POST['deletePublishedSchedules_from_day'], $_POST['deletePublishedSchedules_from_year']) === false || 
					checkdate($_POST['deletePublishedSchedules_to_month'], $_POST['deletePublishedSchedules_to_day'], $_POST['deletePublishedSchedules_to_year']) === false
				) {
					
					return $response;
					
				}
				
				$unixTime_from = date('U', mktime(0, 0, 0, $_POST['deletePublishedSchedules_from_month'], $_POST['deletePublishedSchedules_from_day'], $_POST['deletePublishedSchedules_from_year']));
				$unixTime_to = date('U', mktime(23, 59, 0, $_POST['deletePublishedSchedules_to_month'], $_POST['deletePublishedSchedules_to_day'], $_POST['deletePublishedSchedules_to_year']));
				global $wpdb;
				$table_name = $wpdb->prefix."booking_package_schedule";
				
				if ($_POST['delete_action'] == 'delete') {
					
					$sql = $wpdb->prepare(
						"DELETE FROM `".$table_name."` WHERE `capacity`= `remainder` AND `accountKey` = %d;", 
						array($accountKey)
					);
					
					if ($_POST['period'] == 'period_after') {
						
						$sql = $wpdb->prepare(
							"DELETE FROM `".$table_name."` WHERE `capacity`= `remainder` AND `accountKey` = %d AND `unixTime` > %d;", 
							array($accountKey, intval($unixTime_from))
						);
						
					}
					
					if ($_POST['period'] == 'period_within') {
						
						$sql = $wpdb->prepare(
							"DELETE FROM `".$table_name."` WHERE `capacity`= `remainder` AND `accountKey` = %d AND (`unixTime` > %d AND `unixTime` < %d);", 
							array($accountKey, intval($unixTime_from), intval($unixTime_to))
						);
						
					}
					
					$wpdb->query($sql);
				
				} else {
					
					$wpdb->query("START TRANSACTION");
					$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE");
					try {
						
						$sql = $wpdb->prepare(
							"UPDATE `".$table_name."` SET `stop` = 'true' WHERE `accountKey` = %d;", 
							array($accountKey)
						);
						
						if ($_POST['period'] == 'period_after') {
							
							$sql = $wpdb->prepare(
								"UPDATE `".$table_name."` SET `stop` = 'true' WHERE `accountKey` = %d AND `unixTime` > %d;", 
								array($accountKey, intval($unixTime_from))
							);
							
						}
						
						if ($_POST['period'] == 'period_within') {
							
							$sql = $wpdb->prepare(
								"UPDATE `".$table_name."` SET `stop` = 'true' WHERE `accountKey` = %d AND (`unixTime` > %d AND `unixTime` < %d);", 
								array($accountKey, intval($unixTime_from), intval($unixTime_to))
							);
							
						}
						
						$wpdb->query($sql);
						$wpdb->query('COMMIT');
						$wpdb->query('UNLOCK TABLES');
						
					} catch (Exception $e) {
						
						$wpdb->query('ROLLBACK');
						$wpdb->query('UNLOCK TABLES');
						
					}/** finally {
						
						$wpdb->query('UNLOCK TABLES');
						
					}**/
					
				}
				
				$response['sql'] = $sql;
				$response['status'] = 'success';
				
			}
			
			return $response;
			
		}
		
    	public function getReservationUsersData($month, $day, $year){
    		
    		$start = date('U', mktime(0, 0, 0, $month, $day, $year));
    		$end = date('U', mktime(23, 59, 59, $month, $day, $year));
    		
    		$response = array();
    		global $wpdb;
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare(
				"SELECT `key`,`accountKey`,`status`,`scheduleUnixTime`,`courseName`,`praivateData`,`accommodationDetails` FROM `".$table_name."` WHERE `scheduleUnixTime` >= %d AND `scheduleUnixTime` <= %d ORDER BY `scheduleUnixTime` ASC;", 
				array(intval($start), intval($end))
			);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				if(!isset($response[$row['accountKey']])){
					
					$response[$row['accountKey']] = array();
					
				}
				
				$row['praivateData'] = json_decode($row['praivateData'], true);
				$row['accommodationDetails'] = json_decode($row['accommodationDetails'], true);
				array_push($response[$row['accountKey']], $row);
				
			}
			
			return $response;
			
    	}
    	
    	public function getCalendarList($month, $day, $year, $startOfWeek = 0){
    		
    		#$month = 4;
    		$weeks = array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
    		$timestamp = date('U');
    		$last_day = date('t', mktime(0, 0, 0, $month, $day, $year));
			#$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year))) - $startOfWeek;
			#$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year))) - $startOfWeek;
    		$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year)));
			$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year)));
    		
    		$calendarList = array();
			if(intval($week_start_num) != $startOfWeek){
				
				#$lastUnixTime = date('U', mktime(0, 0, 0, $month, 1, $year)) - 1;
				$lastUnixTime = intval(date('U', mktime(0, 0, 0, $month, 1, $year))) - 60;
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = intval(date('t', $lastUnixTime));
				$startDay = $endDay - intval(date('w', $lastUnixTime)) + $startOfWeek;
				#$startDay = date('j', strtotime("last ".$weeks[$startOfWeek]." of ".date('F', $lastUnixTime)." ".date('Y', $lastUnixTime)));
				for ($i = $endDay; $i > 0; $i--) {
				    
				    if (date('w', mktime(0, 0, 0, date('n', $lastUnixTime), $i, date('Y', $lastUnixTime))) == $startOfWeek) {
				        
				         $startDay = $i;
				         break;
				        
				    }
				    
				}
				
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array(
					'startDay' => $startDay, 
					'lastDay' => $endDay, 
					'startWeek' => intval(date('w', mktime(0, 0, 0, $lastMonth, $startDay, $lastYear))), 
					'lastWeek' => intval(date('w', $lastUnixTime)), 
					'year' => $lastYear, 
					'month' => intval($lastMonth), 
					'day' => $startDay, 
					'timestamp' => $timestamp
				);
				
			}
			
			$calendarList[intval($year.sprintf('%02d', $month))] = array('startDay' => 1, 'lastDay' => $last_day, 'startWeek' => $week_start_num, 'lastWeek' => $week_last_num, 'year' => $year, 'month' => intval($month), 'day' => 1, 'timestamp' => $timestamp);
			
			#if(intval($week_last_num) >= $startOfWeek){
				
				$lastUnixTime = intval(date('U', mktime(23, 60, 0, $month, $last_day, $year)));
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = 7 - intval(date('w', $lastUnixTime)) + $startOfWeek;
				#$endDay = date('j', strtotime("first ".$weeks[$startOfWeek]." of ".date('F', $lastUnixTime)." ".date('Y', $lastUnixTime))) - 1;
				$startOfWeek--;
				if ($startOfWeek < 0) {
					
					$startOfWeek = 6;
					
				}
				
				for ($i = 1; $i <= intval(date('t', $lastUnixTime)); $i++) {
					
					if (date('w', mktime(0, 0, 0, date('n', $lastUnixTime), $i, date('Y', $lastUnixTime))) == $startOfWeek) {
						
						if ($i == 7) {
							
							$endDay = 0;
							
						} else {
							
							$endDay = $i;
							
						}
						
						break;
						
					}
	                
	            }
				
				$startDay = 1;
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array(
					'startDay' => $startDay, 
					'lastDay' => $endDay, 
					'startWeek' => intval(date('w', $lastUnixTime)), 
					'lastWeek' => 6, 
					'year' => $lastYear, 
					'month' => intval($lastMonth), 
					'day' => $startDay, 
					'timestamp' => $timestamp,
				);
				
			#}
			
			return $calendarList;
    		
    	}
		
		public function fixUnixTimeShift($schedule, $timezone) {
			
			global $wpdb;
			date_default_timezone_set($timezone);
			$trueUnixTime = date('U', mktime($schedule['hour'], $schedule['min'], 0, $schedule['month'], $schedule['day'], $schedule['year']));
			if (intval($trueUnixTime) != intval($schedule['unixTime'])) {
				
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE, `" . $wpdb->prefix."booking_package_userPraivateData" . "` WRITE");
				try {
					
					$wpdb->update(
						$wpdb->prefix."booking_package_schedule", 
						array(
							'unixTime' => intval($trueUnixTime),
						),
						array('key' => intval($schedule['key'])),
						array('%d'),
						array('%d')
					);
					
					$wpdb->update(
						$wpdb->prefix."booking_package_userPraivateData", 
						array(
							'scheduleUnixTime' => intval($trueUnixTime),
						),
						array('scheduleKey' => intval($schedule['key'])),
						array('%d'),
						array('%d')
					);
					
					$wpdb->query('COMMIT');
					$wpdb->query('UNLOCK TABLES');
					$schedule['trueUnixTime'] = $trueUnixTime;
					$schedule['fixedUnixTime'] = true;
					$schedule['unixTime'] = $trueUnixTime;
					return $schedule;
					
				} catch (Exception $e) {
					
					$wpdb->query('ROLLBACK');
					$wpdb->query('UNLOCK TABLES');
					$error = json_decode($e->getMessage(), true);
					return $error;
					
				}
				/** finally {
					
					$wpdb->query('UNLOCK TABLES');
					
				}
				**/
				
			} else {
				
				return $schedule;
				
			}
			
		}
    	
    	public function getReservationData($month, $day, $year, $ical = false, $public = false){
    		
    		$accountKey = 1;
    		$accountCalendarKey = 1;
    		if(isset($_POST['accountKey'])){
    			
    			$accountKey = $_POST['accountKey'];
    			$accountCalendarKey = $_POST['accountKey'];
    			
    		}
    		
    		global $wpdb;
    		$account = $this->getCalendarAccount($accountKey);
    		if (intval($account['schedulesSharing']) == 1) {
    			
    			$accountCalendarKey = intval($account['targetSchedules']);
    			
    		}
    		
    		$reserveData = array();
    		$changeMonth = false;
    		
    		if ($ical === false) {
    			
    			if (is_null($month) && is_null($day) !== true && is_null($year)) {
    				
    				$month = date('m');
    				$day = date('d');
    				$year = date('Y');
    				
    			}
    			
    			if ($month != date('m') || $year != date('Y')) {
    				
    				$day = 1;
    				
    			} else {
    				
    				$day = date('d');
    				
    			}
    			
    			#var_dump($public);
    			if ($public !== false) {
    				
    				#$unavailableDaysFromToday = get_option($this->prefix."unavailableDaysFromToday", 0) * (1440 * 60);
    				$unavailableDaysFromToday = intval($account['unavailableDaysFromToday']) * (1440 * 60);
    				$unixTime = date('U') + $unavailableDaysFromToday;
    				
    				//if(date('U', mktime(0, 0, 0, $month, 1, $year)) < $unixTime){
    				if (date('U', mktime(0, 0, 0, date('n'), 1, date('Y'))) < $unixTime) {
    					
    					$changeMonth = true;
    					$startMonth = date('m', $unixTime);
    					$startDay = date('d', $unixTime);
    					$startYear = date('Y', $unixTime);
    					
    					if (date('U', mktime(0, 0, 0, $month, 1, $year)) < $unixTime) {
    						
    						$month = date('m', $unixTime);
	    					$day = date('d', $unixTime);
	    					$year = date('Y', $unixTime);
    						
    					}
    					
    					
    				}
    				
    			}
    			
    		} else {
    			
    			
    			
    		}
    		
    		$nationalHoliday = $this->getRegularHolidays($month, $year, 'national', $account['startOfWeek'], true);
    		$regularHoliday = $this->getRegularHolidays($month, $year, 'share', $account['startOfWeek'], true);
    		
    		$last_day = date('t', mktime(0, 0, 0, $month, $day, $year));
			$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year)));
			$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year)));
			
			$maxDeadlineDay = date('U') + (BOOKING_PACKAGE_MAX_DEADLINE_TIME * 60);
			
			if ($ical === false) {
				
				$arrayValue = array(
					'startDay' => 1, 
					'lastDay' => $last_day, 
					'startWeek' => $week_start_num, 
					'lastWeek' => $week_last_num, 
					'year' => $year, 
					'month' => intval($month), 
					'day' => 1, 
					'timestamp' => date('U'), 
					'today' => intval(date('Ymd')), 
					'maxDeadlineDay' => intval(date('Ymd', date('U') + (BOOKING_PACKAGE_MAX_DEADLINE_TIME * 60))),
					'firstMonth' => intval(date('U', mktime(0, 0, 0, $month, 1, $year))), 
					'endMonth' => intval(date('U', mktime(23, 59, 59, $month, $last_day, $year)))
				);
				$reserveData['date'] = $arrayValue;
				
				$calendarList = $this->getCalendarList($month, $day, $year, $account['startOfWeek']);
				$reserveData['calendarList'] = $calendarList;
				$days = array();
				$reservation = array();
				$reservationForHotel = array();
				$schedule = array();
				$schedule_start_day = null;
				if($public !== false && $changeMonth === true /**$month == date('n')**/){
					
					$schedule_start_day = intval(date('Ymd', mktime(0, 0, 0, $startMonth, $startDay, $startYear)));
					//$schedule_start_day = intval(date('Ymd', mktime(0, 0, 0, date('n'), date('j'), date('Y'))));
					
				}
				
				$reserveData['schedule_start_day'] = $schedule_start_day;
				
				$visitorList = array();
				$number = 0;
				foreach ((array) $calendarList as $key => $value) {
					
					for ($i = $value['startDay']; $i <= $value['lastDay']; $i++) {
						
						$calendarUnixTime = date('U', mktime(0, 0, 0, $value['month'], $i, $value['year']));
						$week = date('w', mktime(0, 0, 0, $value['month'], $i, $value['year']));
    					$scheduleKey = $value['year'] . sprintf("%02d%02d", $value['month'], $i);
    					$arrayValue = array('key' => $scheduleKey, 'number' => $number, 'year' => $value['year'], 'month' => $value['month'], 'day' => $i, 'week' => $week, 'select' => 'false');
    					$number++;
    					$days[$scheduleKey] = $arrayValue;
    					
    					$table_name = $wpdb->prefix."booking_package_schedule";
						$sql = $wpdb->prepare(
							"SELECT *, `unixTime` - (`deadlineTime` * 60) as `unixTimeDeadline` FROM `".$table_name."` WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d AND `holiday` = 'false' ORDER BY `unixTime` ASC;", 
							array(intval($accountCalendarKey), intval($value['year']), intval($value['month']), intval($i))
						);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $rows as $scheduleKey => $scheduleData) {
							
							$rows[$scheduleKey] = $this->fixUnixTimeShift($scheduleData, $account['timezone']);
							
						}
						$key = intval($value['year'].sprintf("%02d%02d", $value['month'], $i));
						$schedule[$key] = $rows;
						if (isset($regularHoliday['calendar'][$key]) && intval($regularHoliday['calendar'][$key]['status']) == 1) {
							
							if ($account['type'] == "hotel") {
								
								if (isset($rows[0])) {
									
									$schedule[$key][0]['remainder'] = 0;
									
								}
								
							} else {
								
								$schedule[$key] = array();
								
							}
							
						}
						
						if (count($rows) == 0 && $account['type'] == "hotel") {
							
							#$schedule[$key] = array('unixTime' => date('U', mktime(0, 0, 0, $value['month'], $i, $value['year'])), "remainder" => 0);
							$schedule[$key] = array();
							
						}
						
						if (!is_null($schedule_start_day) && intval(date('Ymd', mktime(0, 0, 0, $value['month'], $i, $value['year']))) < $schedule_start_day) {
							
							$schedule[$key] = array();
							
						}
						
						if ($public == false) {
							
							$startUnixTime = date('U', mktime(0, 0, 0, $value['month'], $i, $value['year']));
							$stopUnixTime = $startUnixTime + (1440 * 60);
							
							$visitorStatus = "";
							if (intval($account['displayDetailsOfCanceled']) == 0) {
								
								$visitorStatus = "`status` != 'canceled' AND ";
							}
							
							$table_name = $wpdb->prefix."booking_package_userPraivateData";
							$sql = $wpdb->prepare(
								"SELECT * FROM `" . $table_name . "` WHERE " . $visitorStatus . " `accountKey` = %d AND `scheduleUnixTime` >= %d AND `scheduleUnixTime` < %d ORDER BY `scheduleUnixTime` ASC;", 
								array(intval($accountKey), $startUnixTime, $stopUnixTime)
							);
							if($account['type'] == 'hotel'){
								
								$sql = $wpdb->prepare(
									"SELECT * FROM `" . $table_name . "` WHERE " . $visitorStatus . " `accountKey` = %d AND `checkOut` >= %d AND `checkIn` < %d ORDER BY `scheduleUnixTime` ASC;", 
									array(intval($accountKey), $startUnixTime, $stopUnixTime)
								);
								#$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `checkIn` <= %d AND `checkOut` > %d ORDER BY `scheduleUnixTime` ASC;", array(intval($accountKey), $startUnixTime, $stopUnixTime));
								
							}
							
							#$visitorsBookedList = $this->getVistorsBookedList($sql, $reservation, $reservationForHotel, $startUnixTime);
							
							$rows = $wpdb->get_results($sql, ARRAY_A);
							if(is_null($rows) === false && count($rows) != 0){
								
								$deleteList = array();
								for($row = 0; $row < count($rows); $row++){
									
									
									if(!isset($visitorList[$rows[$row]['key']])){
										
										$visitorList[$rows[$row]['key']] = 1;
										if($rows[$row]['type'] == 'hotel' && intval($rows[$row]['checkIn']) != $startUnixTime){
											
											#continue;
											array_push($deleteList, $row);
											
										}
										
									}else{
										
										$visitorList[$rows[$row]['key']]++;
										array_push($deleteList, $row);
										
									}
									
									$response = $this->getVistorsBookedList($rows[$row], $account['type'], $reservationForHotel);
									$rows[$row] = $response['bookedData'];
									$reservationForHotel = $response['reservationForHotel'];
									/**
									if (empty($rows[$row]['status'])) {
										
										$rows[$row]['status'] = 'pending';
										
									}
									
									$json = json_decode($rows[$row]['praivateData'], true);
									$rows[$row]['praivateData'] = $json;
									
									$json = json_decode($rows[$row]['options'], true);
									$rows[$row]['options'] = $json;
									
									#$rows[$row]['taxes'] = json_decode($rows[$row]['taxes'], true);
									$taxes = json_decode($rows[$row]['taxes'], true);
									if ($taxes === false || is_null($taxes)) {
										
										$rows[$row]['taxes'] = array();
										
									} else {
										
										$rows[$row]['taxes'] = $taxes;
										
									}
									
									
									$unixTime = $rows[$row]['scheduleUnixTime'];
									$rows[$row]['date'] = array(
										'month' => date('n', $unixTime), 
										'day' => date('d', $unixTime), 
										'year' => date('Y', $unixTime), 
										'week' => date('w', $unixTime), 
										'hour' => date('H', $unixTime), 
										'min' => date('i', $unixTime), 
										'timeZone' => date('e', $unixTime), 
										'checkIn' => 0, 
										'checkOut' => 0,
									);
									
									if($account['type'] == "hotel"){
										
										$rows[$row]['date']['checkIn'] = date('Ymd', $rows[$row]['checkIn']);
										$rows[$row]['date']['checkOut'] = date('Ymd', $rows[$row]['checkOut']);
										$rows[$row]['date']['checkIn_month'] = date('n', $rows[$row]['checkIn']);
										$rows[$row]['date']['checkIn_day'] = date('j', $rows[$row]['checkIn']);
										$rows[$row]['date']['checkIn_year'] = date('Y', $rows[$row]['checkIn']);
										$rows[$row]['date']['checkIn_week'] = date('w', $rows[$row]['checkIn']);
										$rows[$row]['date']['checkOut_month'] = date('n', $rows[$row]['checkOut']);
										$rows[$row]['date']['checkOut_day'] = date('j', $rows[$row]['checkOut']);
										$rows[$row]['date']['checkOut_year'] = date('Y', $rows[$row]['checkOut']);
										$rows[$row]['date']['checkOut_week'] = date('w', $rows[$row]['checkOut']);
										
										$rows[$row]['accommodationDetails'] = json_decode($rows[$row]['accommodationDetails'], true);
										if (!isset($rows[$row]['accommodationDetails']['taxesFee'])) {
											
											$rows[$row]['accommodationDetails']['taxesFee'] = 0;
											
										}
										$time = intval($rows[$row]['checkIn']);
										while($time <= intval($rows[$row]['checkOut'])){
											
											$dateKey = date('Ymd', $time);
											if(!isset($reservationForHotel[$dateKey])){
												
												$reservationForHotel[$dateKey] = array();
												
											}
											
											$reservationForHotel[$dateKey][$rows[$row]['key']] = $rows[$row];
											$time += 1440 * 60;
											
										}
										
									} else {
										
										$rows[$row] = $this->updateVistorService($rows[$row]);
										$rows[$row]['test'] = 1;
										
									}
									**/
								}
								
								arsort($deleteList);
								for($deleteKey = 0; $deleteKey < count($deleteList); $deleteKey++){
									
									unset($rows[$deleteKey]);
									
								}
								
								if(count($rows) > 0){
									
									$reservation[$key] = $rows;
									
								}
								
							}
							
						}
						
					}
					
					$table_name = $wpdb->prefix."booking_package_schedule";
					$sql = $wpdb->prepare(
						"SELECT year,month,day,accountKey,SUM(capacity),SUM(remainder),COUNT(day) FROM `".$table_name."` GROUP BY `year`,`month`,`day`,`holiday`,`accountKey` HAVING `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` >= %d AND `holiday` = 'false';", 
						array(intval($accountCalendarKey), intval($value['year']), intval($value['month']), intval($day))
					);
					
				}
				$reserveData['calendar'] = $days;
				$reserveData['schedule'] = $schedule;
				$reserveData['reservation'] = $reservation;
				$reserveData['reservationForHotel'] = $reservationForHotel;
				$reserveData['regularHoliday'] = $regularHoliday;
				$reserveData['nationalHoliday'] = $nationalHoliday;
				
				/**
				if($public == false && $account->type == "hotel"){
					
					
					
				}
				**/
				
			}else{
				
				$startUnixTime = date('U', mktime(0, 0, 0, $month, $day, $year));
				#echo $month.'/'.$day.'/'.$year."\n";
				#var_dump($startUnixTime);
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$sql = $wpdb->prepare(
					"SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `scheduleUnixTime` >= %d ORDER BY `scheduleUnixTime` ASC;", 
					array(intval($accountKey), $startUnixTime)
				);
				
				if (intval($account['displayDetailsOfCanceled']) == 0) {
					
					$sql = $wpdb->prepare(
						"SELECT * FROM `".$table_name."` WHERE `status` != 'canceled' AND `accountKey` = %d AND `scheduleUnixTime` >= %d ORDER BY `scheduleUnixTime` ASC;", 
						array(intval($accountKey), $startUnixTime)
					);
					
				}
				
				$rows = $wpdb->get_results($sql, ARRAY_A);
				if(is_null($rows) === false && count($rows) != 0){
						
					for($row = 0; $row < count($rows); $row++){
						
						$json = json_decode($rows[$row]['praivateData'], true);
						$rows[$row]['praivateData'] = $json;
						$unixTime = $rows[$row]['scheduleUnixTime'];
						$rows[$row]['date'] = array('unixTime' => $unixTime, 'month' => date('m', $unixTime), 'day' => date('d', $unixTime), 'year' => date('Y', $unixTime), 'week' => date('w', $unixTime), 'hour' => date('H', $unixTime), 'min' => date('i', $unixTime), 'timeZone' => date('e', $unixTime));
						
					}
					
					$reserveData = $rows;
					
				}
				
			}
			
			return $reserveData;
			
    	}
    	
    	public function getUsersBookedList($user_id, $offset = 0, $cancel = false) {
    		
    		global $wpdb;
    		$limit = 20;
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare(
				"SELECT * FROM `" . $table_name . "` WHERE `user_id` = %d ORDER BY `scheduleUnixTime` DESC, `key` DESC LIMIT %d, %d;", 
				array(intval($user_id), intval($offset), intval($limit))
			);
			
			$rows = $wpdb->get_results($sql, ARRAY_A);
			if(is_null($rows) === false && count($rows) != 0){
				
				$deleteList = array();
				for($row = 0; $row < count($rows); $row++){
					
					$response = $this->getVistorsBookedList($rows[$row], $rows[$row]['type'], array());
					if ($cancel === true) {
						
						$response['bookedData']['cancel'] = 0;
						$cancelFlag = $this->verifyCancellation($response['bookedData'], true, $user_id);
						if ($cancelFlag['cancel'] === true) {
							
							$response['bookedData']['cancel'] = 1;
							
						}
						
					}
					$rows[$row] = $response['bookedData'];
					
				}
				
			}
			
			$size = count(array_keys($rows));
			$next = 1;
			if ($size < $limit) {
				
				$next = 0;
				
			}
    		
    		return array('status' => 'success', 'bookedList' => $rows, 'limit' => intval($limit), 'offset' => intval($offset), 'size' => intval($size), 'next' => $next);
    		
    	}
    	
    	public function getVistorsBookedList($bookedData, $type, $reservationForHotel) {
    		
    		if (empty($bookedData['status'])) {
				
				$bookedData['status'] = 'pending';
				
			}
			
			$json = json_decode($bookedData['praivateData'], true);
			$bookedData['praivateData'] = $json;
			
			$json = json_decode($bookedData['options'], true);
			$bookedData['options'] = $json;
			
			#$bookedData['taxes'] = json_decode($bookedData['taxes'], true);
			$taxes = json_decode($bookedData['taxes'], true);
			if ($taxes === false || is_null($taxes)) {
				
				$bookedData['taxes'] = array();
				
			} else {
				
				$bookedData['taxes'] = $taxes;
				
			}
			
			
			$unixTime = $bookedData['scheduleUnixTime'];
			$bookedData['date'] = array(
				'month' => date('n', $unixTime), 
				'day' => date('d', $unixTime), 
				'year' => date('Y', $unixTime), 
				'week' => date('w', $unixTime), 
				'hour' => date('H', $unixTime), 
				'min' => date('i', $unixTime), 
				'timeZone' => date('e', $unixTime), 
				'checkIn' => 0, 
				'checkOut' => 0,
			);
			
			$timestamp = $bookedData['reserveTime'];
			$bookedData['timestamp'] = array(
				'month' => date('n', $timestamp), 
				'day' => date('d', $timestamp), 
				'year' => date('Y', $timestamp), 
				'week' => date('w', $timestamp), 
				'hour' => date('H', $timestamp), 
				'min' => date('i', $timestamp), 
				'timeZone' => date('e', $timestamp), 
			);
			
			if($type == "hotel"){
				
				$bookedData['date']['checkIn'] = date('Ymd', $bookedData['checkIn']);
				$bookedData['date']['checkOut'] = date('Ymd', $bookedData['checkOut']);
				$bookedData['date']['checkIn_month'] = date('n', $bookedData['checkIn']);
				$bookedData['date']['checkIn_day'] = date('j', $bookedData['checkIn']);
				$bookedData['date']['checkIn_year'] = date('Y', $bookedData['checkIn']);
				$bookedData['date']['checkIn_week'] = date('w', $bookedData['checkIn']);
				$bookedData['date']['checkOut_month'] = date('n', $bookedData['checkOut']);
				$bookedData['date']['checkOut_day'] = date('j', $bookedData['checkOut']);
				$bookedData['date']['checkOut_year'] = date('Y', $bookedData['checkOut']);
				$bookedData['date']['checkOut_week'] = date('w', $bookedData['checkOut']);
				
				$bookedData['accommodationDetails'] = json_decode($bookedData['accommodationDetails'], true);
				if (!isset($bookedData['accommodationDetails']['taxesFee'])) {
					
					$bookedData['accommodationDetails']['taxesFee'] = 0;
					
				}
				
				if (is_null($bookedData['accommodationDetails']['rooms'])) {
					
					$bookedData['accommodationDetails']['applicantCount'] = 1;
					$bookedData['accommodationDetails']['rooms'] = $this->createRooms($bookedData['accommodationDetails']);
					
				}
				
				
				$time = intval($bookedData['checkIn']);
				while($time <= intval($bookedData['checkOut'])){
					
					$dateKey = date('Ymd', $time);
					if(!isset($reservationForHotel[$dateKey])){
						
						$reservationForHotel[$dateKey] = array();
						
					}
					
					$reservationForHotel[$dateKey][$bookedData['key']] = $bookedData;
					$time += 1440 * 60;
					
				}
				
			} else {
				
				$bookedData = $this->updateVistorService($bookedData);
				$bookedData['test'] = 1;
				
			}
			
			return array('bookedData' => $bookedData, 'reservationForHotel' => $reservationForHotel);
			#return $bookedData;
    		
    	}
    	
    	public function createRooms($accommodationDetails) {
    		
    		$guests = array();
			$amount = 0;
			foreach ((array) $accommodationDetails['guestsList'] as $key => $guest) {
				
				$guestList = $guest['json'];
				for ($i = 0; $i < count($guestList); $i++) {
					
					$selected = intval($guestList[$i]['selected']);
					unset($guestList[$i]['selected']);
					if ($i == 0) {
						
						$guests[$key] = $guestList[$i];
						
					}
					
					if ($selected == 1) {
						
						$guests[$key] = $guestList[$i];
						$amount += intval($guestList[$i]['price']);
						break;
						
					}
					
				}
				
			}
			
			$room = array(
				'booking' => true, 
				'requiredGuests' => true, 
				'guests' => $guests, 
				'adult' => $accommodationDetails['adult'], 
				'children' => $accommodationDetails['children'], 
				'person' => $accommodationDetails['adult'] + $accommodationDetails['children'], 
				'amount' => $amount,
				'additionalFee' => $amount, 
				'guestsList' => $accommodationDetails['guestsList'],
			);
			$rooms = array($room);
			return $rooms;
    		
    	}
    	
    	public function updateVistorService($visitor) {
    		
    		if (empty($visitor['courseKey']) === false) {
    			
    			$service = array(
    				"key" => $visitor['courseKey'],
    				"accountKey" => $visitor['accountKey'],
    				"name" => $visitor['courseName'],
    				"time" => $visitor['courseTime'],
    				"cost" => $visitor['courseCost'],
    				"active" => "true",
    				"service" => 1,
    				"selected" => 1,
    				"options" => array(),
    			);
    			
    			if (count($visitor['options']) > 0) {
    				
    				$service["options"] = $visitor['options'];
    				
    			}
    			
    			$visitor['courseKey'] = null;
    			$visitor['courseName'] = null;
    			$visitor['courseTime'] = null;
    			$visitor['courseCost'] = null;
    			
    			$visitor['options'] = array($service);
    			
    		}
    		
    		if (isset($visitor['options']) === false) {
    			
    			$visitor['options'] = array();
    			
    		}
    		
    		return $visitor;
    		
    	}
    	
    	public function getDownloadCSV(){
    		
    		global $wpdb;
    		$response = array("status" => "success", "csv" => null);
    		$visitorsList = array();
    		$csv = '';
    		$calendarAccount = $this->getCalendarAccount($_POST['accountKey']);
    		$currency = get_option($this->prefix."currency", 'usd');
    		$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    		$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
    		
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
    		$startUnixTime = 0;
    		$stopUnixTime = 0;
    		if (isset($_POST['day']) && $_POST['day'] != '') {
    			
    			$startUnixTime = date('U', mktime(0, 0, 0, intval($_POST['month']), intval($_POST['day']), intval($_POST['year'])));
    			$stopUnixTime = date('U', mktime(23, 59, 59, intval($_POST['month']), intval($_POST['day']), intval($_POST['year'])));
    			
    		} else {
    			
    			$lastDay = date('t', mktime(0, 0, 0, intval($_POST['month']), 1, intval($_POST['year'])));
    			$startUnixTime = date('U', mktime(0, 0, 0, intval($_POST['month']), 1, intval($_POST['year'])));
    			$stopUnixTime = date('U', mktime(23, 59, 59, intval($_POST['month']), intval($lastDay), intval($_POST['year'])));
    			
    		}
			$sql = $wpdb->prepare(
				"SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `scheduleUnixTime` >= %d AND `scheduleUnixTime` < %d ORDER BY `key` ASC;", 
				array(intval($_POST['accountKey']), $startUnixTime, $stopUnixTime)
			);
			$response['sql'] = $sql;
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				$visitor = array(
					"key" => $row['key'],
					"status" => $row['status'],
				);
				
				if ($calendarAccount['type'] == 'day') {
					
					$visitor['scheduleDate'] = $this->dateFormat($dateFormat, $positionOfWeek, $row['scheduleUnixTime'], $row['scheduleTitle'], true, false);
					$visitor['services'] = array();
					$visitor['amount'] = 0;
					$services = json_decode($row['options'], true);
					foreach ((array) $services as $service) {
						
						array_push($visitor['services'], $service['name']);
						$visitor['amount'] += intval($service['cost']);
						foreach ((array) $service['options'] as $option) {
							
							if (intval($option['selected']) == 1) {
								
								array_push($visitor['services'], $option['name']);
								$visitor['amount'] += intval($option['cost']);
								
							}
							
						}
						
					}
					
					$visitor['services'] = implode(' ', $visitor['services']);
					$taxes = json_decode($row['taxes'], true);
					foreach ((array) $taxes as $tax) {
						
						if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
							
							$visitor['amount'] += intval($tax['taxValue']);
							
						} else if ($tax['type'] == 'surcharge') {
							
							$visitor['amount'] += intval($tax['taxValue']);
							
						}
						
					}
					
				} else {
					
					$visitor['checkIn'] = $this->dateFormat($dateFormat, $positionOfWeek, $row['checkIn'], null, false, false);
					$visitor['checkOut'] = $this->dateFormat($dateFormat, $positionOfWeek, $row['checkOut'], null, false, false);
					$accommodationDetails = json_decode($row['accommodationDetails'], true);
					$visitor['adults'] = 0;
					$visitor['children'] = 0;
					$visitor['amount'] = intval($accommodationDetails['totalCost']);
					foreach ((array) $accommodationDetails['guestsList'] as $guest) {
						
						foreach ((array) $guest['json'] as $value) {
							
							if (intval($value['selected']) == 1) {
								
								if ($guest['target'] == 'adult') {
									
									$visitor['adults'] += intval($value['number']);
									
								} else {
									
									$visitor['children'] += intval($value['number']);
									
								}
								
							}
							
						}
						
					}
					$visitor['adults'] = 'Adults: ' . $visitor['adults'];
					$visitor['children'] = 'Children: ' . $visitor['children'];
					
				}
				
				$visitor['amount'] = $this->formatCost($visitor['amount'], $currency);
				$praivateData = json_decode($row['praivateData'], true);
				for ($i = 0; $i < count($praivateData); $i++) {
					
					$id = "form_".$praivateData[$i]['id'];
					if (is_string($praivateData[$i]['value'])) {
						
						$visitor[$id] = $praivateData[$i]['value'];
						
					} else if (is_array($praivateData[$i]['value'])) {
						
						$visitor[$id] = implode(' ', $praivateData[$i]['value']);
						
					}
					
				}
				
				array_push($visitorsList, $visitor);
				$csv .= implode(",", $visitor) . "\r\n";
				
			}
			
			$temp = tmpfile();
			$path = stream_get_meta_data($temp)['uri'];
			$fp = fopen($path, 'w');
			foreach ((array) $visitorsList as $key => $value) {
				
				fputcsv($fp, $value);
				
			}
			fseek($fp, 0);
			$csv = file_get_contents($path);
			fclose($temp);
			
			
			$response['rows'] = $rows;
			$response['visitorsList'] = $visitorsList;
    		$response['calendarAccount'] = $calendarAccount;
    		$response['csv'] = $csv;
    		return $response;
    		
    	}
		
		public function serachCourse($accountKey, $key = false, $bookingYMD = null, $time = false){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_courseData";
			if ($key !== false) {
				
				$sql = $wpdb->prepare(
					"SELECT `key`, `name`, `time`, `cost`, `expirationDateStatus`, `expirationDateFrom`, `expirationDateTo` FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d LIMIT 0, 1;", 
					array(intval($accountKey), intval($key))
				);
				
			}
			
			if ($time !== false) {
				
				$sql = $wpdb->prepare(
					"SELECT `key`, `name`, `time`, `cost`, `expirationDateStatus`, `expirationDateFrom`, `expirationDateTo` FROM `".$table_name."` WHERE `accountKey` = %d AND `time` = %d LIMIT 0, 1;", 
					array(intval($accountKey), intval($time))
				);
				
			}
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				#return array('status' => 'error', 'message' => __('Service was not found', $this->pluginName));
				return array('status' => 'error', 'message' => __('%s was not found', $this->pluginName));
				
			} else {
				
				$isBooking = $this->validExpirationDate(intval($bookingYMD), intval($row['expirationDateStatus']), intval($row['expirationDateFrom']), intval($row['expirationDateTo']));
				//if (is_int($bookingYMD) && intval($row['expirationDateStatus']) == 1 && (intval($row['expirationDateFrom']) > $bookingYMD || intval($row['expirationDateTo']) < $bookingYMD)) {
				if ($isBooking === false) {
					
					return array('status' => 'error', 'message' => __('%s was not found', $this->pluginName));
					
				}
			
				return $row;
				
			}
			
		}
		
		public function validExpirationDate($bookingYMD, $expirationDateStatus, $expirationDateFrom, $expirationDateTo) {
			
			$isBooking = true;
			//if (is_int($bookingYMD) && intval($expirationDateStatus) == 1 && (intval($expirationDateFrom) > $bookingYMD || intval($expirationDateTo) < $bookingYMD)) {
			if (is_int($bookingYMD) && intval($expirationDateStatus) == 1 && $expirationDateFrom != 0 && $expirationDateTo != 0 && (($expirationDateFrom <= $bookingYMD && $expirationDateTo < $bookingYMD) || ($expirationDateFrom > $bookingYMD && $expirationDateTo >= $bookingYMD))) {
				
				$isBooking = false;
				
			}
			
			return $isBooking;
			
		}
		
		public function getStatus($userDetail = false){
			
			#$this->automaticApprove = boolval(intval(get_option($this->prefix."automaticApprove", 0)));
			$this->automaticApprove = intval(get_option($this->prefix."automaticApprove", 0));
			if ($this->automaticApprove == 0) {
				
				$this->automaticApprove = false;
				
			} else {
				
				$this->automaticApprove = true;
				
			}
			$status = "pending";
			if ($userDetail !== false) {
				
				if (isset($userDetail['status'])) {
					
					return $userDetail['status'];
					
				} else {
					
					if ($this->automaticApprove === true) {
						
						$status = "approved";
						
					}
					
				}
				
			} else {
				
				if ($this->automaticApprove === true) {
					
					$status = "approved";
					
				}
				
			}
			
			return $status;
			
		}
		
		public function serachSchedule($unixTime, $accountKey = 1){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_schedule";
			$sql = $wpdb->prepare(
				"SELECT `key`,`unixTime`,`title`,`capacity`,`remainder`,`stop` FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d LIMIT 0, 1;", 
				array(intval($accountKey), intval($unixTime))
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				return array('status' => 'error');
				
			} else {
				
				return $row;
				
			}
			
		}
		
    	public function createAccommodationDetails($calendarAccount, $json, $sql_start_unixTime, $applicantCount, $type, $accommodationDetails = null){
    		
    		global $wpdb;
    		
    		$accountKey = $calendarAccount['key'];
    		$person = 0;
    		$nights = 0;
    		$totalCost = 0;
    		$totalTax = 0;
    		if (is_null($accommodationDetails)) {
    			
    			$accommodationDetails = array("scheduleList" => array(), "guestsList" => array(), 'type' => $calendarAccount['type'], 'taxes' => array(), 'applicantCount' => $applicantCount);
    			
    		} else {
    			
    			$unixTimeEnd = $accommodationDetails['checkOut'];
				$nights = $accommodationDetails['nights'];
				$additionalFee = $accommodationDetails['additionalFee'];
    			$totalCost = $accommodationDetails['accommodationFee'];
    				
    		}
    		
    		if (is_array($json)) {
    			
    			$jsonList = $json;
    			
    		} else {
    			
    			$jsonList = json_decode(str_replace("\\", "", $json), true);
    			
    		}
    		
    		if (isset($jsonList['applicantCount'])) {
    			
    			$accommodationDetails['applicantCount'] = intval($jsonList['applicantCount']);
    			$applicantCount = intval($jsonList['applicantCount']);
    			
    		}
    		
    		
    		$scheduleList = array_values($jsonList['list']);
    		$first = null;
    		$last = null;
    		if(count($scheduleList) != 0){
    			
    			$nights = 0;
    			$totalCost = 0;
    			$first = reset($scheduleList);
    			$last = end($scheduleList);
    			$table_name = $wpdb->prefix."booking_package_schedule";
    			$sql = $wpdb->prepare(
    				"SELECT `key`,`month`,`day`,`year`,`weekKey`,`unixTime`,`cost`,`remainder` FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC;", 
    				array(intval($accountKey), intval($first['unixTime']), intval($last['unixTime']))
    			);
    			$rows = $wpdb->get_results($sql, ARRAY_A);
    			if(count($rows) != 0 && !is_null($rows)){
    				
    				$accommodationDetails['scheduleList'] = array();
    				$accommodationDetails['scheduleDetails'] = array();
    				$unixTimeList = array();
    				$i = 0;
    				foreach ((array) $rows as $row) {
            			
            			array_push($accommodationDetails['scheduleList'], $row['key']);
            			$accommodationDetails['scheduleDetails'][$row['unixTime']] = $row;
            			/**
            			if(array_search($row['key'], $accommodationDetails['scheduleList']) == false){
            				
            				array_push($accommodationDetails['scheduleList'], $row['key']);
            				
            			}
            			**/
            			
            			$date = $this->dateFormat($dateFormat, $positionOfWeek, $row['unixTime'], $row['title'], false, false);
            			if ($type == 'book' && $row['remainder'] <= 0) {
            				
            				return array("status" => "error", "message" => sprintf(__("There is no vacancy in the room on %s"), $date));
            				
            			}
            			
            			if ($row['stop'] == 'true') {
            				
            				return array("status" => "error", "message" => sprintf(__("Booking of %s is suspended."), $date));
            					
            			}
            					
            			if($i != 0){
            				
            				$time = ($row['unixTime'] - $unixTime) / 60;
            				array_push($unixTimeList, $time);
            				$unixTime = $row['unixTime'];
            				if($time < 1440){
            					
            					return array("status" => "error", "message" => __("Schedule data was not found", $this->pluginName), "sql" => $sql);
            					
            				}
            				
            			}else{
            				
            				$unixTime = $row['unixTime'];
            				
            			}
            			
            			$i++;
            			$nights++;
            			$totalCost += intval($row['cost']) * $applicantCount;
            			
            		}
					
					ksort($accommodationDetails['scheduleDetails']);
					
					$table_name = $wpdb->prefix."booking_package_schedule";
					$sql = $wpdb->prepare(
						"SELECT `key`,`month`,`day`,`year`,`weekKey`,`unixTime` FROM `".$table_name."` WHERE `key` = %d;", 
						array(intval($jsonList['checkInKey']))
					);
					$row = $wpdb->get_row($sql, ARRAY_A);
					$accommodationDetails['checkInSchedule'] = $row;
					
					$sql = $wpdb->prepare(
						"SELECT `key`,`month`,`day`,`year`,`weekKey`,`unixTime` FROM `".$table_name."` WHERE `key` = %d;", 
						array(intval($jsonList['checkOutKey']))
					);
					$row = $wpdb->get_row($sql, ARRAY_A);
					$accommodationDetails['checkOutSchedule'] = $row;
					
					$sql_max_unixTime = $sql_start_unixTime;
					for($i = 0; $i < count($unixTimeList); $i++){
						
						$sql_max_unixTime += $unixTimeList[$i] * 60;
						
					}
					
					$accommodationDetails['checkIn'] = intval($sql_start_unixTime);
					$accommodationDetails['checkOut'] = intval($sql_max_unixTime) + (1440 * 60);
					$accommodationDetails['lastUnixTime'] = intval($sql_max_unixTime);
					$accommodationDetails['nights'] = $nights;
					$accommodationDetails['accommodationFee'] = $totalCost;
					$accommodationDetails['sql_max_unixTime'] = $sql_max_unixTime;
					
					$sql_max_unixTime += $maintenanceTime * 60;
					#$sql_max_unixTime = $sql_start_unixTime + ($courseTime * 60) + ($maintenanceTime * 60);
					$table_name = $wpdb->prefix."booking_package_schedule";
					$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
					$valueArray = array(intval($accountKey), intval($sql_start_unixTime), intval($sql_max_unixTime));
					$accommodationDetails['sql'] = $account_sql;
					$accommodationDetails['valueArray'] = $valueArray;
					$jsonList['sql'] = $wpdb->prepare($account_sql, $valueArray);
					
    			}
    			
    		}
    		
    		#var_dump(count($jsonList['guestsList']));
    		
			if (count($jsonList['rooms']) != 0) {
				
				$additionalFee = 0;
				$adult = 0;
				$children = 0;
				$rooms = array();
				foreach ((array) $jsonList['rooms'] as $roomKey => $room) {
					
					$table_name = $wpdb->prefix."booking_package_guests";
					$guestsList = $room['guests'];
					foreach ((array) $guestsList as $key => $value) {
						
						$guestSql = $wpdb->prepare(
							"SELECT * FROM `".$table_name."` WHERE `key` = %d AND `accountKey` = %d;", 
							array(intval($key), intval($accountKey))
						);
						$guests_row = $wpdb->get_row($guestSql, ARRAY_A);
						$guests = array();
						$selected = false;
						$guestsArray = json_decode($guests_row['json'], true);
						for($i = 0; $i < count($guestsArray); $i++){
							
							if (intval($value['number']) == intval($guestsArray[$i]['number']) && $value['name'] == $guestsArray[$i]['name']) {
								
								$additionalFee += intval($guestsArray[$i]['price']) * $nights;
								$selected = true;
								$guestsArray[$i]['selected'] = 1;
								$person += intval($guestsArray[$i]['number']);
								if ($guests_row['target'] == 'adult') {
									
									$adult += intval($guestsArray[$i]['number']);
									
								} else {
									
									$children += intval($guestsArray[$i]['number']);
									
								}
								
							} else {
								
								$guestsArray[$i]['selected'] = 0;
								
							}
							
						}
						
						if ($selected === false) {
							
							array_unshift($guestsArray, array("number" => 0, "price" => 0, "name" => "SELECT", "selected" => 1));
							
						} else {
							
							array_unshift($guestsArray, array("number" => 0, "price" => 0, "name" => "SELECT", "selected" => 0));
							
						}
						
						$guests_row['json'] = $guestsArray;
						$room['guestsList'][$key] = $guests_row;
						
					}
					/**
					foreach ((array) $room['guests'] as $guestKey => $guestValue) {
						
						$room['guests'][$guestKey]['selected'] = 1;
						
					}
					**/
					array_push($rooms, $room);
					
				}
				
				$accommodationDetails['rooms'] = $rooms;
				$accommodationDetails['additionalFee'] = $additionalFee;
            	$accommodationDetails['adult'] = intval($adult);
            	$accommodationDetails['children'] = intval($children);
				
			} else {
    			
    			$accommodationDetails['additionalFee'] = 0;
    			
    		}
    		
    		if (count($jsonList['rooms']) == 0 && count($jsonList['guestsList']) != 0) {
    			
            	$additionalFee = 0;
            	$table_name = $wpdb->prefix."booking_package_guests";
            	$guestsList = $jsonList['guestsList'];
            	foreach ((array) $guestsList as $key => $value) {
            		
            		$guestSql = $wpdb->prepare(
            			"SELECT * FROM `".$table_name."` WHERE `key` = %d AND `accountKey` = %d;", 
            			array(intval($key), intval($accountKey))
            		);
            		$guests_row = $wpdb->get_row($guestSql, ARRAY_A);
            		$guests = array();
            		$guestsArray = json_decode($guests_row['json'], true);
            		for ($i = 0; $i < count($guestsArray); $i++) {
            			
            			if (intval($value['number']) == intval($guestsArray[$i]['number']) && $value['name'] == $guestsArray[$i]['name']) {
            				
            				$additionalFee += intval($guestsArray[$i]['price']) * $nights;
            				$guestsArray[$i]['selected'] = 1;
            				
            			} else {
            				
            				$guestsArray[$i]['selected'] = 0;
            				
            			}
            			
            		}
            		
            		array_unshift($guestsArray, array("number" => 0, "price" => 0, "name" => "SELECT", "selected" => 0));
            		$guests_row['json'] = $guestsArray;
            		$accommodationDetails['guestsList'][$key] = $guests_row;
            		
            	}
            	/**
            	$accommodationDetails['additionalFee'] = $additionalFee;
            	$accommodationDetails['adult'] = intval($jsonList['adult']);
            	$accommodationDetails['children'] = intval($jsonList['children']);
    			**/
    		} else {
    			
    			//$accommodationDetails['additionalFee'] = 0;
    			
    		}
    		
    		if (count($jsonList['taxes']) != 0) {
    			
    			#$totalTax = 0;
    			$taxList = array();
    			$table_name = $wpdb->prefix."booking_package_taxes";
	            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `active` = 'true' ORDER BY ranking ASC;", array(intval($accountKey)));
	            $rows = $wpdb->get_results($sql, ARRAY_A);
	            foreach ((array) $rows as $key => $tax) {
	            	
	            	$taxValue = 0;
		            $value = intval($tax['value']);
		            if ($tax['method'] == 'multiplication') {
		                
		                $value = floatval($tax['value']);
		                
		            }
		            
		            if ($tax['target'] == 'room') {
		                
		                if ($tax['scope'] == 'day') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = ($accommodationDetails['nights'] * $applicantCount) * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * (($accommodationDetails['accommodationFee']) + $accommodationDetails['additionalFee']);
		                        if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_inclusive') {
		                            
		                            $taxValue = (($accommodationDetails['accommodationFee']) + $accommodationDetails['additionalFee']) * ($value / (100 + $value));
		                            $taxValue = floor($taxValue);
		                            
		                        }
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'booking') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = $applicantCount * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * $applicantCount;
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'bookingEachGuests') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = $person * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * $person;
		                        
		                    }
		                    
		                }
		                
		            } else if ($tax['target'] == 'guest') {
		                
		                if ($tax['scope'] == 'day') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = ($accommodationDetails['nights'] * $person) * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * ($accommodationDetails['additionalFee'] / $accommodationDetails['nights']);
		                        if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_inclusive') {
		                            
		                            $taxValue = $accommodationDetails['additionalFee'] * ($value / (100 + $value));
		                            $taxValue = floor($taxValue);
		                            
		                        }
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'booking') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = 1 * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * 1;
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'bookingEachGuests') {
		                	
		                	if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = $person * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * $person;
		                        
		                    }
		                	
		                }
		                
		            }
		            
		            $taxValue = intval($taxValue);
		            if ($tax['tax'] == 'tax_exclusive' || ($tax['method'] == "addition" && $tax['type'] == "surcharge")) {
		            	
		            	$totalTax += $taxValue;
		            	
		            }
		            
		            #$taxValue = intval($taxValue);
		            #$totalTax += $taxValue;
		            
		            $tax['taxValue'] = $taxValue;
		            array_push($taxList, $tax);
	            	
	            }
	            
	            $accommodationDetails['taxes'] = $taxList;
	            $accommodationDetails['taxesFee'] = $totalTax;
    			
    		} else {
    			
    			$accommodationDetails['taxes'] = array();
    			$accommodationDetails['taxesFee'] = 0;
    			
    		}
				
            #$accommodationDetails['type'] = $calendarAccount['type'];
            #$accommodationDetails['additionalFee'] = $additionalFee;
            $accommodationDetails['totalCost'] = $totalCost + $additionalFee + $totalTax;
            #$accommodationDetails['adult'] = intval($jsonList['adult']);
            #$accommodationDetails['children'] = intval($jsonList['children']);
            #$this->setAccommodationDetails($accommodationDetails);
            
    		return $accommodationDetails;
    		
    		/**	
    		}else{
    			
    			return array("status" => "error", "message" => __("Schedule data was not found", $this->pluginName));
    			
    		}
    		**/
    		
    	}
    	
    	public function createTaxesDetails($accountKey, $totalCost) {
    		
    		global $wpdb;
    		$taxes = array();
    		$table_name = $wpdb->prefix."booking_package_taxes";
			$sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `active` = %s ORDER BY ranking ASC;", array(intval($accountKey), 'true'));
			#var_dump($sql);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $key => $tax) {
				
				if ($tax['method'] == 'multiplication') {
					
					$taxValue =  ($tax['value'] / 100) * $totalCost;
					if ($tax['tax'] == 'tax_inclusive') {
						
						$taxValue = $totalCost * (intval($tax['value']) / (100 + intval($tax['value'])));
						$taxValue = floor($taxValue);
						
					}
					$tax['taxValue'] = $taxValue;
					
				} else {
					
					$tax['taxValue'] = intval($tax['value']);
					
				}
				/**
				if ($tax['type'] == 'tax') {
					
					if ($tax['method'] == 'multiplication') {
						
						$taxValue =  ($tax['value'] / 100) * $totalCost;
						if ($tax['tax'] == 'tax_inclusive') {
							
							$taxValue = $totalCost * (intval($tax['value']) / (100 + intval($tax['value'])));
							$taxValue = floor($taxValue);
							
						}
						$tax['taxValue'] = $taxValue;
						
					} else {
						
						$tax['taxValue'] = intval($tax['value']);
						
					}
					
				} else {
					
					if ($tax['method'] == 'multiplication') {
						
						$taxValue =  ($tax['value'] / 100) * $totalCost;
						if ($tax['tax'] == 'tax_inclusive') {
							
							$taxValue = $totalCost * (intval($tax['value']) / (100 + intval($tax['value'])));
							$taxValue = floor($taxValue);
							
						}
						$tax['taxValue'] = $taxValue;
						
					} else {
						
						$tax['taxValue'] = intval($tax['value']);
						
					}
					
				}
				**/
				
				array_push($taxes, $tax);
				
			}
			
			return $taxes;
    		
    	}
    	
    	public function getTaxesDetailsForVisitor($bookingID, $totalCost) {
    		
    		global $wpdb;
    		$taxes = array();
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare("SELECT `taxes` FROM ".$table_name." WHERE `key` = %d;", array(intval($bookingID)));
			$row = $wpdb->get_row($sql, ARRAY_A);
			$taxes = json_decode($row['taxes'], true);
			foreach ((array) $taxes as $key => &$tax) {
				
				if ($tax['method'] == 'multiplication') {
					
					$taxValue =  ($tax['value'] / 100) * $totalCost;
					if ($tax['tax'] == 'tax_inclusive') {
						
						$taxValue = $totalCost * (intval($tax['value']) / (100 + intval($tax['value'])));
						$taxValue = floor($taxValue);
						
					}
					$tax['taxValue'] = $taxValue;
					
				} else {
					
					$tax['taxValue'] = intval($tax['value']);
					
				}
				
			}
			
			return $taxes;
    		
    	}
    	
    	public function intentForStripe() {
    		
    		global $wpdb;
    		$currency = get_option($this->prefix."currency", 'usd');
    		$secret_key = get_option($this->prefix."stripe_secret_key", null);
    		$creditCard = new booking_package_CreditCard($this->pluginName);
    		$response = $creditCard->intentForStripe($secret_key, $_POST['amount'], $currency);
    		return $response;
    		
    	}
    	
    	public function sendBooking($administrator = false) {
    		
    		$accountKey = 1;
    		$accountCalendarKey = 1;
    		if (isset($_POST['accountKey'])) {
    			
    			$accountKey = $_POST['accountKey'];
    			$accountCalendarKey = $_POST['accountKey'];
    			
    		}
    		
    		$permalink = "";
    		if (isset($_POST['permalink'])) {
    			
    			$permalink = $_POST['permalink'];
    			
    		}
    		
    		$service = null;
    		$maintenanceTime = 0;
    		$remainderTime = 0;
    		$timestamp = intval(date('U'));
    		$sendDate = date('U');
    		$totalCost = 0;
    		$courseKey = null;
    		$jsonList = null;
    		$ressponse = array();
    		$selectedOptions = array();
    		$userInformationValues = array();
    		$taxes = array();
    		$sql_start_unixTime = null;
    		$sql_max_unixTime = null;
    		$currency = get_option($this->prefix."currency", 'usd');
    		$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    		$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
    		
    		global $wpdb;
    		
    		$calendarAccount = $this->getCalendarAccount($accountKey);
    		if (intval($calendarAccount['schedulesSharing']) == 1) {
    			
    			$accountCalendarKey = intval($calendarAccount['targetSchedules']);
    			
    		}
    		$paymentMethod = explode(",", $calendarAccount['paymentMethod']);
    		$preparation = array("time" => intval($calendarAccount["preparationTime"]), "position" => $calendarAccount["positionPreparationTime"]);
    		$response_user = $this->get_user_id($administrator, $_POST['userId']);
    		
    		$form = $this->getUserValues($accountKey, $response_user['user_id']);
    		if (isset($form['status']) && $form['status'] == 'error') {
    			
    			#$wpdb->query('ROLLBACK');
    			return $form;
    			
    		}
    		
    		$visitorName = array();
    		foreach ((array) $form as $key => $value) {
    			
    			if ($value->isName == 'true') {
    				
    				array_push($visitorName, $value->value);
    				
    			}
    			
    		}
    		$visitorName = implode(" ", $visitorName);
    		
    		$table_name = $wpdb->prefix."booking_package_schedule";
    		$sql = $wpdb->prepare(
    			"SELECT *, `unixTime` - (`deadlineTime` * 60) as `unixTimeDeadline` FROM `".$table_name."` WHERE `key` = %d;", 
    			array(intval($_POST['timeKey']))
    		);
    		$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				#$wpdb->query('ROLLBACK');
				$public = false;
				if(intval($_POST['public']) == 1){
					
					$public = true;
					
				}
				
				$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
				$response['status'] = 'error';
				$response['message'] = __("Schedule data was not found", $this->pluginName);
				return $response;
				
			} else {
				
				$row = $this->fixUnixTimeShift($row, $calendarAccount['timezone']);
				if (isset($row['fixedUnixTime']) && $row['fixedUnixTime'] === true) {
					
					$table_name = $wpdb->prefix."booking_package_schedule";
					$sql = $wpdb->prepare(
						"SELECT `key`, `unixTime`, `hour`, `min`, `month`, `day`, `year` FROM `".$table_name."` WHERE `accountKey` = %d AND `year` = %d AND `month` = %d ORDER BY `unixTime` ASC;", 
						array(intval($calendarAccount['key']), intval($row['year']), intval($row['month']))
					);
					$schedules = $wpdb->get_results($sql, ARRAY_A);
					foreach ((array) $schedules as $key => $value) {
						
						$value = $this->fixUnixTimeShift($value, $calendarAccount['timezone']);
						
					}
					
				}
				
				$table_name = $wpdb->prefix."booking_package_regular_holidays";
				$sql = $wpdb->prepare(
					"SELECT `status` FROM `".$table_name."` WHERE `month` = %d AND `day` = %d AND `year` = %d AND (`accountKey` = 'share' || `accountKey` = %s);", 
					array(
						intval($row['month']), 
						intval($row['day']), 
						intval($row['year']), 
						sanitize_text_field($accountKey)
					)
				);
				$holiday = $wpdb->get_row($sql, ARRAY_A);
				if (!is_null($holiday) && intval($holiday['status']) == 1) {
					
					#$wpdb->query('ROLLBACK');
					$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
					$response['status'] = 'error';
					$response['reload'] = 0;
					$response['message'] = __("Schedule data was not found", $this->pluginName);
					return $response;
					#return array("status" => "error", "message" => __("Schedule data was not found", $this->pluginName), 'reload' => 1);
					
				}
				
				if (intval($row['unixTimeDeadline']) < $timestamp && $administrator === false) {
					
					#$wpdb->query('ROLLBACK');
					$public = false;
					if(intval($_POST['public']) == 1){
						
						$public = true;
						
					}
					
					$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
					$response['status'] = 'error';
					$response['reload'] = 0;
					$response['message'] = __("Schedule data was not found", $this->pluginName);
					return $response;
					#return array("status" => "error", "message" => __("Schedule data was not found", $this->pluginName), 'reload' => 1);
					
				}
				
				$applicantCount = intval($_POST['applicantCount']);
				$startTime = $row['unixTime'];
				$sql_start_unixTime = $row['unixTime'];
				
				$scheduleUnixTime = intval($row['unixTime']);
				$scheduleTitle = $row['title'];
				$scheduleCost = intval($row['cost']);
				$totalCost += intval($row['cost']) * $applicantCount;
				$bookingYMD = intval($row['year'] . sprintf('%02d%02d', $row['month'], $row['day']));
				if ($row['unixTime'] == $scheduleUnixTime) {
					
					if ($calendarAccount['type'] == "hotel" && isset($_POST['json'])) {
						
						$accommodationDetails = $this->createAccommodationDetails($calendarAccount, $_POST['json'], $sql_start_unixTime, $applicantCount, 'book', null);
						$applicantCount = $accommodationDetails['applicantCount'];
						$taxes = $accommodationDetails['taxes'];
						$totalCost = $accommodationDetails['totalCost'];
						$taxes = $this->createTaxesDetails($accountKey, $totalCost);
						
						if ($accommodationDetails['status'] == "error") {
							
							#$wpdb->query('ROLLBACK');
							return $accommodationDetails;
							
						} else {
							
							$account_sql = $accommodationDetails['sql'];
							$valueArray = $accommodationDetails['valueArray'];
							$sql_max_unixTime = $accommodationDetails['sql_max_unixTime'];
							unset($accommodationDetails['sql']);
							unset($accommodationDetails['valueArray']);
							unset($accommodationDetails['sql_max_unixTime']);
							$this->setAccommodationDetails($accommodationDetails);
							
						}
						
    				} else {
    					
						if (isset($_POST['courseKey']) || isset($_POST['selectedCourseList'])) {
							
							$servicesDetails = $this->getSelectedServices($_POST['selectedCourseList'], "selectedOptionsList", $applicantCount);
							$services = $servicesDetails['object'];
							foreach ((array) $services as $key => $service) {
								
								$row = $this->serachCourse($accountKey ,$service['key'], $bookingYMD);
								if ($row['status'] == 'error') {
									
									$row['message'] = sprintf($row['message'], $service['name']);
									#$wpdb->query('ROLLBACK');
									return $row;
								
								}
								
							}
							
							$courseTime += intval($servicesDetails['time']);
							$courseCost += intval($servicesDetails['cost']);
							$totalCost += intval($servicesDetails['cost']) * $applicantCount;
							$sql_max_unixTime = $sql_start_unixTime + ($courseTime * 60) + ($maintenanceTime * 60);
							$table_name = $wpdb->prefix."booking_package_schedule";
							$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC ;";
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
								
								$sql_start_unixTime -= $preparation['time'] * 60;
								
							}
								
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
								
								$sql_max_unixTime += $preparation['time'] * 60;
								
							}
								
							$valueArray = array(intval($accountCalendarKey), intval($sql_start_unixTime), intval($sql_max_unixTime));
							
							
							
							
						} else {
							
							$table_name = $wpdb->prefix."booking_package_schedule";
							$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
								
								$sql_start_unixTime = $startTime - $preparation['time'] * 60;
								
							}
							
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
								
								$sql_max_unixTime = $startTime + $preparation['time'] * 60;
								
							}
							
							$valueArray = array(intval($accountCalendarKey), intval($sql_start_unixTime), intval($sql_max_unixTime));
							
						}
						
						$taxes = $this->createTaxesDetails($accountKey, $totalCost);
						$accommodationDetails['taxes'] = $taxes;
						for ($i = 0; $i < count($taxes); $i++) {
							
							$tax = $taxes[$i];
							if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
								
								$totalCost += $tax['taxValue'];
								
							} else if ($tax['type'] == 'surcharge') {
								
								$totalCost += $tax['taxValue'];
								
							}
							
						}
						
					}
					
					$souce = array(
            			array("mode" => "increase", "sql" => $account_sql, "values" => $valueArray), 
            		);
            		$increaseSouce = $souce;
					$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
					if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
						
						$public = false;
						if (intval($_POST['public']) == 1) {
							
							$public = true;
							
						}
						
						$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
						$response['status'] = 'error';
						$response['reload'] = 0;
						$response['message'] = $updateSchedule['message'];
						return $response;
						
					}
					$status = $this->getStatus();
					$privateResponse = $this->insertPrivateData($sendDate, $_POST['permission'], $status, $_POST['timeKey'], $scheduleUnixTime, $scheduleTitle, $scheduleCost, $services, $form, $currency, $_POST['payType'], $cardToken, $accountKey, $permalink, $preparation, $taxes, $administrator, $applicantCount);
					
					#$privateResponse = $this->insertPrivateData($sendDate, $_POST['permission'], $status, $_POST['timeKey'], $scheduleUnixTime, $scheduleTitle, $scheduleCost, $courseKey, $courseName, $courseTime, $courseCost, $selectedOptions, $form, $currency, $_POST['payType'], $cardToken, $accountKey, $permalink, $preparation, $taxes, $applicantCount);
					$lastID = $privateResponse['lastID'];
					
					/** Stripe and PayPal **/
					$payment_active = 0;
					$payment_mode = 0;
					$public_key = null;
					$secret_key = null;
					$cardToken = null;
					if(isset($_POST['payToken'])){
						
						if($_POST['payType'] == 'stripe'){
							
							#$payment_active = get_option($this->prefix."stripe_active", "0");
							$payment_active = 0;
		    				if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
		    					
		    					$payment_active = 1;
		    					
		    				}
							$secret_key = get_option($this->prefix."stripe_secret_key", null);
							
						}else if($_POST['payType'] == 'paypal'){
							
							#$payment_active = get_option($this->prefix."paypal_active", "0");
							$payment_active = 0;
		    				if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
		    					
		    					$payment_active = 1;
		    					
		    				}
							$payment_live = get_option($this->prefix."paypal_live", "0");
							$public_key = get_option($this->prefix."paypal_client_id", null);
							$secret_key = get_option($this->prefix."paypal_secret_key", null);
							
						}
						
						
						$currency = get_option($this->prefix."currency", "usd");
						if(intval($payment_active) == 1 && !empty($secret_key)){
							
							$creditCard = new booking_package_CreditCard($this->pluginName);
							$payResponse = $creditCard->pay($_POST['payType'], $public_key, $secret_key, $_POST['payToken'], $payment_live, $totalCost, $currency, $lastID, $visitorName);
							if(isset($payResponse['error'])){
								
	    						$wpdb->delete(
	    							$wpdb->prefix."booking_package_userPraivateData", 
	    							array(
	    								'key' => intval($lastID)
	    							), 
	    							array('%d')
	    						);
								
								$souce = array(
			            			array("mode" => "reduce", "sql" => $account_sql, "values" => $valueArray), 
			            		);
								$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
								if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
									
									return $updateSchedule;
									
								}
								return array('status' => 'error', 'message' => $payResponse['error'], "totalCost" => $totalCost, "currency" => $currency, "totalCost" => $totalCost);
								
							}else{
								
								$cardToken = $payResponse['cardToken'];
								if ($_POST['payType'] == 'stripe') {
									
									$payId = "stripe";
									$payName = "Stripe";
									
								} else if ($_POST['payType'] == 'paypal') {
									
									$payId = "paypal";
									$payName = "PayPal";
									
								}
								
								$wpdb->update(
									$wpdb->prefix."booking_package_userPraivateData", 
									array(
										'payMode' => 'CreditCard',
										'payId' => $payId,
										'payName' => $payName,
										'payToken' => sanitize_text_field($cardToken),
									),
									array('key' => intval($lastID)),
									array('%s', '%s', '%s', '%s'),
									array('%d')
								);
								
							}
							
						}
						
					}
					/** Stripe and PayPal **/
					
					
					/**
					#$status = "pending";
					if($this->automaticApprove === true){
						
						#$status = "approved";
						$souce = array(
	            			array("mode" => "increase", "sql" => $account_sql, "values" => $valueArray), 
	            		);
						$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
						
					}
					**/
					
					$userInformation = $this->setUserInformation($form);
					if(isset($userInformation['values'])){
						
						$userInformationValues = $userInformation['values'];
						
					}
					
					$cancellationToken = $privateResponse['cancellationToken'];
					$cancellationUri = null;
					if ($administrator === false) {
						
						$cancellationUri = $this->getCancellationUri($permalink, $lastID, $cancellationToken);
						
					}
					
					/**
					if(isset($cardToken) && !is_null($cardToken) && $_POST['payType'] == 'paypal'){
						
						$creditCard = new booking_package_CreditCard($this->pluginName);
						$payResponse = $creditCard->update($_POST['payType'], $public_key, $secret_key, $_POST['payToken'], $lastID, $payment_live);
						
					}
					**/
					
				}
    			
    		}
    		
    		$mailBody = null;
    		if(intval($_POST['sendEmail']) == 1){
    			
    			$email = $this->createEmailMessage($accountKey, array('mail_new_admin'), $form, $accommodationDetails, $selectedOptions, $lastID, $scheduleUnixTime, $sendDate, $cancellationUri, $currency, $services, $payName, $payId, $scheduleTitle);
    			
    		}
    		
    		if($calendarAccount['type'] == 'hotel'){
    			
    			$sql_max_unixTime += 1440 * 60;
    			
    		}
    		
    		$setting = new booking_package_setting($this->prefix, $this->pluginName);
    		$googleCalendar = $setting->pushGC('insert', $accountKey, $calendarAccount['type'], $lastID, $calendarAccount['googleCalendarID'], $sql_start_unixTime, $sql_max_unixTime, $form);
    		$this->updateQueueForGC($lastID, $googleCalendar);
    		
    		$iCal = false;
    		$public = false;
    		if(intval($_POST['public']) == 1){
    			
    			$public = true;
    			
    		}
    		
    		$ressponse = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), $iCal, $public);
    		$ressponse['account'] = $this->getCalendarAccount($accountKey);
    		$ressponse['automaticApprove'] = $this->automaticApprove;
    		$ressponse['userInformationValues'] = $userInformationValues;
    		$ressponse['payResponse'] = $payResponse;
    		$ressponse['cancellationUri'] = $cancellationUri;
    		$ressponse['applicantCount'] = $applicantCount;
    		#$ressponse['Google_Calendar'] = $googleCalendar;
    		$ressponse['lastID'] = $lastID;
    		#$ressponse['params'] = $params;
    		#$ressponse['jsonList'] = $jsonList;
    		#$ressponse['accommodationDetails'] = $accommodationDetails;
    		$ressponse['sendVisitor'] = $email['sendVisitor'];
    		$ressponse['sendControl'] = $email['sendControl'];
    		#$ressponse['email'] = $email;
    		$ressponse['selectedOptions'] = $selectedOptions;
    		$ressponse['form'] = $form;
    		$ressponse['services'] = $services;
    		$ressponse['status'] = "success";
    		$ressponse['increaseSouce'] = $increaseSouce;
    		$ressponse['response_user'] = $response_user;
    		#$ressponse['user'] = $this->get_user();
    		#$wpdb->query('COMMIT');
    		return $ressponse;
    			
    		
    		
    		
    	}
    	
    	public function getCancellationUri($permalink, $id, $token) {
    		
    		$parse_url = parse_url($permalink);
        	if (isset($parse_url['query'])) {
        		
        		$parse_url['query'] .= "&bookingID=".$id."&bookingToken=".$token;
        		
        	} else {
        		
        		$parse_url['query'] = "bookingID=".$id."&bookingToken=".$token;
        		
        	}
        	
        	$permalink = $parse_url['scheme'].'://'.$parse_url['host'];
        	if (isset($parse_url['port'])) {
        		
        		$permalink .= ':'.$parse_url['port'];
        		
        	}
        	
        	if (isset($parse_url['path'])) {
        		
        		$permalink .= $parse_url['path'];
        		
        	}
        	
        	if (isset($parse_url['query'])) {
        		
        		$permalink .= '?'.$parse_url['query'];
        		
        	}
        	
        	if (isset($parse_url['fragment'])) {
        		
        		$permalink .= '#'.$parse_url['fragment'];
        		
        	}
        	
        	return $permalink;
    		
    	}
    	
    	public function getSelectedServices($selectedServices, $targetOptions, $applicantCount = 1){
    		
    		$time = 0;
    		$cost = 0;
    		$hasKeys = array("key" => "int", "accountKey" => "int", "name" => "string", "time" => "int", "cost" => "int", "active" => "string", "options" => "object", "selectedOptionsList" => "object", "service" => "int", "selected" => "int");
    		if (isset($selectedServices)) {
    			
    			$jsonList = $selectedServices;
    			
                if (is_string($selectedServices) === true) {
                	
                	$jsonList = json_decode(str_replace("\\", "", $selectedServices), true);
                	//$jsonList = json_decode($selectedServices, true);
                	
                }
                
                $services = array();
                if (is_array($jsonList)) {
					
					for ($i = 0; $i < count($jsonList); $i++) {
						
						$time += intval($jsonList[$i]['time']);
						$cost += intval($jsonList[$i]['cost']);
						$service = array('options' => array());
						foreach ((array) $hasKeys as $key => $value) {
							
							if (isset($jsonList[$i][$key])) {
								
								if ($value == 'object') {
									
									if ($key == $targetOptions) {
										
										$optionsDetails = $this->getSelectedOptions($jsonList[$i][$key], $applicantCount);
										//var_dump($optionsDetails);
										$service['options'] = $optionsDetails['object'];   
										$time += $optionsDetails['time'];
										$cost += $optionsDetails['cost'];
										
									}
									
								} else {
									
									$service[sanitize_text_field($key)] = sanitize_text_field($jsonList[$i][$key]);
									
								}
								
							}
							
						}
						
						array_push($services, $service);
						
					}
                	
                }
            	
			}
			
			return array("time" => $time, "cost" => $cost, "object" => $services);

    	}
    	
    	public function getSelectedOptions($selectedOptions, $applicantCount = 1){
    		
    		$time = 0;
    		$cost = 0;
    		$options = array();
            if (isset($selectedOptions)) {
                
                $jsonList = $selectedOptions;
                if (is_string($selectedOptions) === true) {
                	
                	$jsonList = json_decode(str_replace("\\", "", $selectedOptions), true);
                	//$jsonList = json_decode($selectedOptions, true);
                	
                }
                
                if (is_array($jsonList)) {
                	
					for ($i = 0; $i < count($jsonList); $i++) {
						
						$object = array();
						foreach ((array) $jsonList[$i] as $key => $value) {
							
							$object[sanitize_text_field($key)] = sanitize_text_field($value);
							
						}
						
						if (intval($object['selected']) == 1) {
							
							$time += intval($object['time']);
							$cost += intval($object['cost']) * $applicantCount;
							
						}
						
						array_push($options, $object);
						
					}
                	
                }
                
            }
            
            return array("time" => $time, "cost" => $cost, "object" => $options);
			
		}
		
		public function get_user_id($administrator = false, $request_user_id = null) {
			
			$user_id = null;
			$user_login = null;
			if ($administrator === false) {
				
				$user = $this->get_user();
				if (intval($user['status']) == 1) {
					
					$user = $user['user'];
					$user_id = intval($user['current_member_id']);
					$user_login = $user['user_login'];
					
				}
				
			} else if ($administrator === true && isset($request_user_id)) {
				
				$user = $this->get_user(intval($request_user_id), false);
				$user = $user['user'];
				$user_id = intval($user['current_member_id']);
				$user_login = $user['user_login'];
				
			}
			
			return array('user_id' => $user_id, 'user_login' => $user_login);
			
		}
    	
    	public function insertPrivateData($sendDate, $permission, $status, $timeKey, $scheduleUnixTime, $scheduleTitle, $scheduleCost, $services, $form, $currency, $payType, $cardToken, $accountKey, $permalink, $preparation, $taxes, $administrator, $applicantCount = 1){
    		
    		global $wpdb;
    		
    		$maintenanceTime = 0;
    		$remainderBool = 'false';
    		$cancellationToken = hash('ripemd160', $timeKey.$scheduleUnixTime.microtime(true));
			if(($sendDate + ($remainderTime * 60)) > $scheduleUnixTime){
				
				$remainderBool = 'true';
				
			}
			
			$courseTitle = get_option($this->prefix."courseName", "Course");
			$numberOfWeek = ceil(date('d', $scheduleUnixTime) / 7);
			
			#$courseKey = intval($_POST['courseKey']);
			if(is_null($courseKey)){
				
				$courseKey = null;
				
			}
			
			$payMode = "";
			$payId = "";
			$payName = "";
			if($cardToken != null){
				
				$payMode = "CreditCard";
				if($payType == 'stripe'){
					
					$payId = "stripe";
					$payName = "Stripe";
					
				}else if($payType == 'paypal'){
					
					$payId = "paypal";
					$payName = "PayPal";
					
				}
				
			}
			
			$type = "day";
			$checkIn = 0;
			$checkOut = 0;
			$accommodationDetails = $this->getAccommodationDetails();
			if(!is_null($accommodationDetails)){
				
				$type = "hotel";
				$checkIn = $accommodationDetails['checkIn'];
				$checkOut = $accommodationDetails['checkOut'];
				
			}
			
			$response_user = $this->get_user_id($administrator, $_POST['userId']);
			$user_id = $response_user['user_id'];
			$user_login = $response_user['user_login'];
			/**
			$user_id = null;
			$user_login = null;
			if ($administrator === false) {
				
				$user = $this->get_user();
				if (intval($user['status']) == 1) {
					
					$user = $user['user'];
					$user_id = intval($user['current_member_id']);
					$user_login = $user['user_login'];
					
				}
				
			} else if ($administrator === true && isset($_POST['userId'])) {
				
				$user = $this->get_user(intval($_POST['userId']), false);
				$user = $user['user'];
				$user_id = intval($user['current_member_id']);
				$user_login = $user['user_login'];
				
			}
			**/
			
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$valueArray = array(
				'reserveTime' => intval($sendDate), 
				'remainderTime' => 0,
				'remainderBool' => $remainderBool, 
				'maintenanceTime' => intval($maintenanceTime),
				'permission' => sanitize_text_field($permission),
				'type' => $type,
				'status' => sanitize_text_field($status),
				'accountKey' => intval($accountKey),
				'accountName' => '',
				'scheduleUnixTime' => intval($scheduleUnixTime),
				'scheduleWeek' => intval($numberOfWeek),
				'scheduleTitle' => sanitize_text_field($scheduleTitle),
				'scheduleKey' => intval($timeKey),
				'scheduleCost' => intval($scheduleCost),
				'applicantCount' => intval($applicantCount),
				'courseTitle' => sanitize_text_field($courseTitle),
				'currency' => sanitize_text_field($currency),
				'payMode' => $payMode,
				'payId' => $payId,
				'payName' => $payName,
				'payToken' => sanitize_text_field($cardToken),
				'praivateData' => json_encode($form),
				'checkIn' => intval($checkIn),
				'checkOut' => intval($checkOut),
				'accommodationDetails' => json_encode($accommodationDetails),
				'options' => json_encode($services),
				'cancellationToken' => $cancellationToken,
				'permalink' => esc_url($permalink),
				'preparation' => json_encode($preparation),
				'taxes' => json_encode($taxes),
				'user_id' => $user_id,
				'user_login' => sanitize_text_field($user_login),
			);
    		
			$bool = $wpdb->insert(	$table_name, 
    								$valueArray, 
    								array(	'%d', '%d', '%s', '%d', '%s', '%s', '%s', '%d', '%s', '%d', 
    										'%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', 
    										'%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', 
    										'%d', '%s', 
    								)
    							);
			#$ressponse['insert'] = $bool;
			$lastID = $wpdb->insert_id;
			
			$user = $this->get_user();
			if (intval($user['status']) == 1) {
				
				$user = $user['user'];
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$bool = $wpdb->update(
    				$table_name,
					array(
						'user_id' => intval($user["current_member_id"]),
						'user_login' => sanitize_text_field($user["user_login"]),
					),
					array('key' => intval($lastID)),
					array('%d', '%s'),
					array('%d')
				);
				
			}
			
			return array("lastID" => $lastID, "cancellationToken" => $cancellationToken, "cancellationUri" => "id=".$lastID."&token=".$cancellationToken);
			#return $lastID;
    		
    	}
    	
    	public function getBookingDetailsOnVisitor($key, $token) {
    		
    		global $wpdb;
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
			$sql = $wpdb->prepare(
				"SELECT * FROM `".$table_name."` WHERE `key` = %d AND `cancellationToken` = %s;", 
				array(
					intval($key), 
					sanitize_text_field($token)
				)
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
        	if (is_null($row) === false) {
        		
        		$row['scheduleMonth'] = date('n', $row['scheduleUnixTime']);
        		$row['scheduleDay'] = date('j', $row['scheduleUnixTime']);
        		$row['scheduleYear'] = date('Y', $row['scheduleUnixTime']);
        		$row['scheduleWeek'] = date('w', $row['scheduleUnixTime']);
        		$row['scheduleHour'] = date('H', $row['scheduleUnixTime']);
        		$row['scheduleMin'] = date('i', $row['scheduleUnixTime']);
        		$accommodationDetails = json_decode($row['accommodationDetails'], true);
        		if (is_null($accommodationDetails) === false && is_null($accommodationDetails['rooms'])) {
        			
        			$accommodationDetails['applicantCount'] = 1;
					$accommodationDetails['rooms'] = $this->createRooms($accommodationDetails);
					$row['accommodationDetails'] = json_encode($accommodationDetails);
        			
        		}
        		
        		
        		$row['accommodationDetailsList'] = $this->bookingDetailsForHotel(json_decode($row['accommodationDetails'], true), $row['currency'], 'object');
        		
        		return array("status" => "success", "details" => $row);
        		
        	} else {
        		
        		return array("status" => "error", "details" => null);
        		
        	}
    		
    	}
    	
    	public function verifyCancellation($bookingDetails, $isExtensionsValid = false, $user = 0) {
    		
    		$response = array("cancel" => false);
    		$calendarAccount = $this->getCalendarAccount(intval($bookingDetails['accountKey']));
    		if (intval($calendarAccount['cancellationOfBooking']) == 1) {
    			
    			$unixTime = date('U');
    			if ($isExtensionsValid === true) {
    				
    				$unixTime = $unixTime - (intval($calendarAccount['allowCancellationVisitor']) * 60);
    				
    			} else {
    				
    				$calendarAccount['refuseCancellationOfBooking'] = 'not_refuse';
    				
    			}
    			
    			if ($unixTime < intval($bookingDetails['scheduleUnixTime'])) {
    				
    				if ($calendarAccount['refuseCancellationOfBooking'] == 'not_refuse') {
    					
    					$response['cancel'] = true;
    					
    				} else if ($bookingDetails['status'] == $calendarAccount['refuseCancellationOfBooking']) {
    					
    					$response['cancel'] = true;
    					
    				}
    				
    			}
    			
    		}
    		
    		return $response;
    		
    	}
    	
    	public function cancelBookingData($deleteKey, $token, $status) {
    		
    		global $wpdb;
    		$applicantCount = 1;
    		$response = array("status" => "error", "key" => $deleteKey, "token" => $token, "cancel" => 0, "myBookingDetails" => array());
    		$bookingDetailsOnVisitor = $this->getBookingDetailsOnVisitor($deleteKey, $token);
    		$myBookingDetails = $bookingDetailsOnVisitor['details'];
    		$_POST['accountKey'] = $myBookingDetails['accountKey'];
    		$verifyCancellation = $this->verifyCancellation($myBookingDetails, true, 0);
    		if ($verifyCancellation['cancel'] === true) {
    			
    			$this->updateStatus($deleteKey, $token, $status);
    			$response['status'] = 'success';
    			$_POST['sendEmail'] = 0;
    			
    		}
    		
    		$response['myBookingDetails'] = $myBookingDetails;
    		$response['accommodationDetails'] = $accommodationDetails;
    		$response['cancel'] = $verifyCancellation['cancel'];
    		return $response;
    		
    	}
    	
    	public function deleteBookingData($deleteKey = false, $accountKey = 1, $sendGC = true, $deleteVisitorDetails = true, $sendEmail = 1){
    		
    		/**
    		$accountKey = 1;
    		$accountCalendarKey = 1;
    		if (isset($_POST['accountKey'])) {
    			
    			$accountKey = $_POST['accountKey'];
    			$accountCalendarKey = $_POST['accountKey'];
    			
    		}
    		**/
    		
    		$accountCalendarKey = $accountKey;
    		
    		global $wpdb;
    		$service = null;
    		$options = array();
    		$calendarAccount = $this->getCalendarAccount($accountKey);
    		if (intval($calendarAccount['schedulesSharing']) == 1) {
    			
    			$accountCalendarKey = intval($calendarAccount['targetSchedules']);
    			
    		}
    		$paymentMethod = explode(",", $calendarAccount['paymentMethod']);
    		if ($deleteKey !== false) {
    			
    			$currency = 'usd';
    			$unixTimeStart = 0;
    			$form = null;
    			$accommodationDetails = array();
    			$table_name = $wpdb->prefix."booking_package_userPraivateData";
    			$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
    			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array(intval($deleteKey)));
    			$row = $wpdb->get_row($sql, ARRAY_A);
            	if (is_null($row) === false) {
					
					$status = $row['status'];
					$unixTimeStart = $row['scheduleUnixTime'];
					$accountKey = $row['accountKey'];
					$iCalIDforGoogleCalendar = $row['iCalIDforGoogleCalendar'];
					$form = json_decode($row['praivateData']);
					$table_name = $wpdb->prefix."booking_package_schedule";
					$sql = null;
					$month = date('m', $row['scheduleUnixTime']);
					$year = date('Y', $row['scheduleUnixTime']);
					$applicantCount = $row['applicantCount'];
					$payName = $row['payName'];
					$payId = $row['payId'];
					$payToken = $row['payToken'];
					$scheduleTitle = $row['scheduleTitle'];
					$courseName = $row['courseName'];
					$service = array("name" => $row['courseName'], "price" => $row['courseCost'], "time" => $row["courseTime"]);
					$currency = $row['currency'];
					$options = json_decode($row['options'], true);
					$preparation = json_decode($row['preparation'], true);
					$selectedOptionsObject = $this->getSelectedOptions($row['options']);
					$servicesDetails = $this->getSelectedServices(json_decode($row['options'], true), "options", $applicantCount);
					$services = $servicesDetails['object'];
					
					if ($status != 'canceled') {
						
						if ($calendarAccount['type'] == 'hotel') {
							
							$accommodationDetails = json_decode($row['accommodationDetails'], true);
							$endKey = end($accommodationDetails['scheduleList']);
							$unixTimeStart = $row['scheduleUnixTime'];
							$unixTimeEnd = $accommodationDetails['lastUnixTime'];
							$timestampForUnixTime = $row['reserveTime'];
							$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
							$valueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
							$sql = $wpdb->prepare($account_sql, $valueArray);
							
						} else {
							
							$accommodationDetails['taxes'] = json_decode($row['taxes'], true);
							$startTime = $row['scheduleUnixTime'];
							$unixTimeStart = $row['scheduleUnixTime'];
							$timestampForUnixTime = $row['reserveTime'];
							
							$hasMultipleServices = 0;
							$servicesDetails = $this->getSelectedServices(json_decode($row['options'], true), "options", $applicantCount);
							$services = $servicesDetails['object'];
							if (is_array($services)) {
								
								foreach ((array) $services as $service) {
									
									if (isset($service['service']) && intval($service['service']) == 1) {
										
										$hasMultipleServices = 1;
										break;
										
									}
									
								}
								
							}
							
							if ($hasMultipleServices == 1) {
								
								$unixTimeEnd = $row['scheduleUnixTime'] + ($servicesDetails['time'] * 60) + ($row['maintenanceTime'] * 60);
								#return array("status" => "error", "servicesDetails" => $servicesDetails, "unixTimeEnd" => $unixTimeEnd);
								
							} else {
								
								$unixTimeEnd = $row['scheduleUnixTime'] + ($row['courseTime'] * 60) + ($row['maintenanceTime'] * 60) + ($selectedOptionsObject['time'] * 60);
								
							}
							
							$valueArray = array();
	            			if (strlen($row['courseKey']) != 0 || $hasMultipleServices == 1) {
	            				
	            				if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
	        						
	        						$unixTimeStart -= $preparation['time'] * 60;
	        						
	        					}
	        					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
	        						
	        						$unixTimeEnd += $preparation['time'] * 60;
	        						
	        					}
	        					$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC;";
	            				$valueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
	        					
	            			} else {
	            				
	            				if (isset($preparation['time']) && intval(isset($preparation['time'])) > 0) {
	            					
		        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
		        						
		        						$unixTimeStart = $startTime - ($preparation['time'] * 60);
		        						
		        					}
		        					
		        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
		        						
		        						$unixTimeEnd = $startTime + ($preparation['time'] * 60);
		        						
		        					}
		        					$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
		        					$valueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
	            					
	            				} else {
	            					
	            					$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d;";
	            					$valueArray = array(intval($accountCalendarKey), intval($row['scheduleKey']));
	            					
	            				}
	            				
	            			}
	            			
	            		}
	            		
	            		
	            		
	            		/**
	            		if($row['status'] == 'approved'){
	            			
	            			$souce = array(
		            			array("mode" => "reduce", "sql" => $sql, "values" => $valueArray), 
		            		);
	            			$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
	            			
	            		}
	            		**/
	            		
						$souce = array(
							array("mode" => "reduce", "sql" => $sql, "values" => $valueArray), 
						);
						$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
						if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
							
							return $updateSchedule;
							
						}
						
            		}
					
					if (isset($_POST['refound']) && intval($_POST['refound']) == 1) {
						
						$payment_active = 0;
						$payment_mode = 0;
						$stripe_public_key = null;
						$stripe_secret_key = null;
						if ($payId == 'stripe') {
							
							#$payment_active = get_option($this->prefix."stripe_active", "0");
							$payment_active = 0;
		    				if (!is_bool(array_search(strtolower($payId), $paymentMethod))) {
		    					
		    					$payment_active = 1;
		    					
		    				}
		    				
							$stripe_secret_key = get_option($this->prefix."stripe_secret_key", null);
							
						} else if($payId == 'paypal') {
							
							#$payment_active = get_option($this->prefix."paypal_active", "0");
							$payment_active = 0;
		    				if (!is_bool(array_search(strtolower($payId), $paymentMethod))) {
		    					
		    					$payment_active = 1;
		    					
		    				}
		    				
							$payment_live = get_option($this->prefix."paypal_live", "0");
							$stripe_public_key = get_option($this->prefix."paypal_client_id", null);
							$stripe_secret_key = get_option($this->prefix."paypal_secret_key", null);
							
						}
						
						$currency = get_option($this->prefix."currency", "usd");
						if (intval($payment_active) == 1 && !is_null($stripe_secret_key)) {
							
            				$creditCard = new booking_package_CreditCard($this->pluginName);
            				$refound = $creditCard->cancel($payId, $stripe_public_key, $stripe_secret_key, $payment_live, $payToken);
							if (isset($refound['status']) && $refound['status'] == 'error') {
								
								return $refound;
								die();
								
							}
							
						}
						
					}
					
					$mailBody = null;
					if (intval($sendEmail) == 1) {
						
						$email = $this->createEmailMessage($accountKey, array('mail_deleted'), $form, $accommodationDetails, $options, $deleteKey, intval($unixTimeStart), intval($timestampForUnixTime), null, $currency, $services, $payName, $payId, $scheduleTitle);
						
					}
					
					if ($deleteVisitorDetails === true) {
						
						$table_name = $wpdb->prefix."booking_package_userPraivateData";
						$wpdb->delete($table_name, array('key' => intval($deleteKey)), array('%d'));
						
					}
					
					if ($sendGC === true) {
						
						$setting = new booking_package_setting($this->prefix, $this->pluginName);
						$ressponse['delete'] = $setting->deleteGC($accountKey, $iCalIDforGoogleCalendar, $calendarAccount['googleCalendarID']);
						
					}
					
					$ressponse = $this->getReservationData($month, 1, $year);
					$ressponse['status'] = "success";
					$ressponse['refound'] = $refound;
					$ressponse['selectedOptions'] = $selectedOptionsObject;
					$ressponse['sql'] = $sql;
					
					return $ressponse;
					
            	} else {
            		
            		return array('error' => 'ERROR3', 'status' => 'error');
            		
            	}
    			
    		}
    		
    	}
    	
    	public function retryToSendToServer(){
    		
    		global $wpdb;
    		#$calendarAccountList = $this->getCalendarAccountListData();
    		$setting = new booking_package_setting($this->prefix, $this->pluginName);
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `resultOfGoogleCalendar` = %d;", array(0));
			$rows = $wpdb->get_results($sql, ARRAY_A);
			if(is_null($rows) === false && count($rows) != 0){
				
				for($row = 0; $row < count($rows); $row++){
					
					
					$form = json_decode($rows[$row]['praivateData']);
					$data = $rows[$row];
					$accountKey = $data['accountKey'];
					$key = $data['key'];
					$sql_start_unixTime = $data['scheduleUnixTime'];
					$sql_max_unixTime = $sql_start_unixTime + ($data['courseTime'] * 60) + ($data['maintenanceTime'] * 60);
					#var_dump($data);
					$iCalID = false;
					if(!is_null($data['iCalIDforGoogleCalendar']) && is_string($data['iCalIDforGoogleCalendar'])){
						
						$iCalID = $data['iCalIDforGoogleCalendar'];
						
					}
					
					$calendarAccount = $this->getCalendarAccount($accountKey);
					
					$googleCalendar = $setting->pushGC(
						$data['resultModeOfGoogleCalendar'], 
						$accountKey, 
						$calendarAccount['type'],
						$key, 
						$calendarAccount['googleCalendarID'],
						$sql_start_unixTime, 
						$sql_max_unixTime, 
						$form,
						$iCalID
					);
					
					$this->updateQueueForGC($key, $googleCalendar);
					
				}
				
			}
    		
    	}
    	
    	public function updateQueueForGC($key, $googleCalendar){
    		
    		global $wpdb;
    		if(isset($googleCalendar->responseStatus) && isset($googleCalendar->responseMode)){
    			
    			$valueList = array(
    				'resultOfGoogleCalendar' => intval($googleCalendar->responseStatus), 
    				'resultModeOfGoogleCalendar' => sanitize_text_field($googleCalendar->responseMode)
    			);
    			$formatList = array('%s', '%s');
    			if(isset($googleCalendar->id)){
    				
    				$valueList['iCalIDforGoogleCalendar'] = sanitize_text_field($googleCalendar->id);
    				array_push($formatList, '%s');
    				
    			}
    			
    			$table_name = $wpdb->prefix."booking_package_userPraivateData";
    			$bool = $wpdb->update(  
    				$table_name,
                    /**array('iCalIDforGoogleCalendar' => sanitize_text_field($googleCalendar->id)),**/
					$valueList,
					array('key' => intval($key)),
					$formatList,
					array('%d')
				);
    				
    		}
    		
    	}
		
		public function updateBooking($administrator){
			
			$accountKey = 1;
			$accountCalendarKey = 1;
			if (isset($_POST['accountKey'])) {
				
				$accountKey = $_POST['accountKey'];
				$accountCalendarKey = $_POST['accountKey'];
				
			}
			
			global $wpdb;
			$calendarAccount = $this->getCalendarAccount($accountKey);
			if (intval($calendarAccount['schedulesSharing']) == 1) {
				
				$accountCalendarKey = intval($calendarAccount['targetSchedules']);
				
			}
			
			$response_user = array();
			$selectedOptions = array();
			$unixTimeStart = 0;
			$unixTimeEnd = 0;
			$maintenanceTime = 0;
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array(intval($_POST['updateKey'])));
			$row = $wpdb->get_row($sql, ARRAY_A);
            if (is_null($row) === false) {
				
				$user_id = null;
				if (is_null($row['user_id']) === false) {
					
					$response_user = $this->get_user_id($administrator, $row['user_id']);
					$user_id = $response_user['user_id'];
					
				}
				
				$form = $this->getUserValues($accountKey, $user_id);
				if (isset($form['status']) && $form['status'] == 'error') {
					
					return $form;
					
				}
				
				if ($calendarAccount['type'] != 'hotel') {
					
					$row = $this->updateVistorService($row);
					
				}
				
				$applicantCount = $row['applicantCount'];
				$preparation = json_decode($row['preparation'], true);
				$iCalIDforGoogleCalendar = $row['iCalIDforGoogleCalendar'];
				$startTime = $row['scheduleUnixTime'];
				$unixTimeStart = $row['scheduleUnixTime'];
				
				
				$servicesDetails = $this->getSelectedServices(json_decode($row['options'], true), "options", $applicantCount);
				$services = $servicesDetails['object'];
				$unixTimeEnd = $row['scheduleUnixTime'] + ($servicesDetails['time'] * 60) + ($row['maintenanceTime'] * 60);
				
				#return array("status" => "error", "servicesDetails" => $servicesDetails, "unixTimeEnd" => $unixTimeEnd);
				
				/**
				if (empty($row['courseKey']) === true) {
					
					$servicesDetails = $this->getSelectedServices($row['options'], "options", $applicantCount);
					$services = $servicesDetails['object'];
					$unixTimeEnd = $row['scheduleUnixTime'] + ($servicesDetails['time'] * 60) + ($row['maintenanceTime'] * 60);
					
					return array("status" => "error", "servicesDetails" => $servicesDetails, "unixTimeEnd" => $unixTimeEnd);
					
				} else {
					
					$unixTimeEnd = $row['scheduleUnixTime'] + ($row['courseTime'] * 60) + ($row['maintenanceTime'] * 60);
					$selectedOptionsObject = $this->getSelectedOptions($row['options']);
					$selectedOptions = $selectedOptionsObject['object'];
					$unixTimeEnd += $selectedOptionsObject['time'] * 60;
					
				}
				**/
				
				if($calendarAccount['type'] == 'hotel'){
					
					$accommodationDetails = json_decode($row['accommodationDetails'], true);
    				$accommodationDetails = $this->createAccommodationDetails($calendarAccount, $_POST['json'], $unixTimeStart, $applicantCount, 'update', $accommodationDetails);
    				if($accommodationDetails['status'] == "error"){
    					
    					return $accommodationDetails;
    					
    				}else{
    					
    					$account_sql = $accommodationDetails['sql'];
    					$valueArray = $accommodationDetails['valueArray'];
    					$unixTimeEnd = $accommodationDetails['sql_max_unixTime'];
    					unset($accommodationDetails['sql']);
    					unset($accommodationDetails['valueArray']);
    					unset($accommodationDetails['sql_max_unixTime']);
    					$this->setAccommodationDetails($accommodationDetails);
    					
    				}
					
					
				}
				
            	if(isset($_POST['update_booking_date']) || isset($_POST['update_booking_course'])){
            		
            		define("COURSE_KEY", $row['courseKey']);
    				
    				$table_name = $wpdb->prefix."booking_package_schedule";
    				
    				$scheduleKey = $row['scheduleKey'];
    				$scheduleUnixTime = $row['scheduleUnixTime'];
    				$scheduleTitle = $row['scheduleTitle'];
    				$scheduleCost = $row['scheduleCost'];
    				$scheduleWeek = $row['scheduleWeek'];
    				
    				$courseKey = $row['courseKey'];
    				$courseName = $row['courseName'];
    				$courseTime = $row['courseTime'];
    				$courseCost = $row['courseCost'];
    				
    				$servicesDetails1 = $this->getSelectedServices(json_decode($row['options'], true), "options", $applicantCount);
					$services = $servicesDetails1['object'];
					$courseTime = $servicesDetails1['time'];
    				
    				$deleteSql = null;
    				$deleteValueArray = array();
    				$updateSql = null;
    				$updateValueArray = array();
    				
    				if($calendarAccount['type'] == 'hotel'){
    					
    					
    					
    				}else{
    					
    					$unixTimeStart = $scheduleUnixTime;
						$unixTimeEnd = intval($scheduleUnixTime + ($courseTime * 60) + ($row['maintenanceTime'] * 60));
						#$selectedOptionsObject1 = $this->getSelectedOptions($row['options']);
						#$selectedOptions = $selectedOptionsObject1['object'];
						#$unixTimeEnd += $selectedOptionsObject1['time'] * 60;
						#$selectedOptionsObject1['totalTime'] = $unixTimeEnd;
						$servicesDetails1['unixTimeEnd'] = $unixTimeEnd;
						$deleteValueArray = array();
            			#if(strlen(COURSE_KEY) != 0){
            			if (count($services) > 0) {
            				
            				if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
        						
        						$unixTimeStart -= $preparation['time'] * 60;
        						
        					}
        					
        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
        						
        						$unixTimeEnd += $preparation['time'] * 60;
        						
        					}
            				
            				$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC;";
            				$deleteValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
            				
            			} else {
            				
            				if (isset($preparation['time']) && intval(isset($preparation['time'])) > 0) {
            					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
	        						
	        						$unixTimeStart = $startTime - ($preparation['time'] * 60);
	        						
	        					}
	        					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
	        						
	        						$unixTimeEnd = $startTime + ($preparation['time'] * 60);
	        						
	        					}
	        					
	        					$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
	        					$deleteValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
            					
            				} else {
            					
            					$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d;";
            					$deleteValueArray = array(intval($accountCalendarKey), intval($scheduleKey));
            					
            				}
            				
            			}
            			
            			if(isset($_POST['update_booking_date'])){
    						
    						$table_name = $wpdb->prefix."booking_package_schedule";
    						$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array(intval($_POST['update_booking_date'])));
    						$rowSchedule = $wpdb->get_row($sql, ARRAY_A);
    						if(is_null($rowSchedule)){
    							
    							return array('status' => 'error', 'error' => '9016');
    							
    						}else{
    							
    							$scheduleKey = $rowSchedule['key'];
    							$scheduleUnixTime = $rowSchedule['unixTime'];
    							$scheduleTitle = $rowSchedule['title'];
    							$scheduleCost = $rowSchedule['cost'];
    							$scheduleWeek = $rowSchedule['weekKey'];
    							
    						}
    						
    					}
    					
    					$servicesDetails2 = $this->getSelectedServices($_POST['options'], "options", $applicantCount);
						$selectedServices = $servicesDetails2['object'];
						$courseTime = $servicesDetails2['time'];
						foreach ((array) $selectedServices as $service) {
							
							$rowCourse = $this->serachCourse($accountKey, $service['key']);
							if($rowCourse['status'] == 'error'){
            					
            					return array('status' => 'error', 'error' => '9020', 'servicesDetails2' => $servicesDetails2, 'rowCourse' => $rowCourse, 'accountKey' => $accountKey);
            					
            				}
							
						}
						
    					$preparation = array("time" => intval($calendarAccount["preparationTime"]), "position" => $calendarAccount["positionPreparationTime"]);
    					$startTime = $scheduleUnixTime;
    					$unixTimeStart = $scheduleUnixTime;
						$unixTimeEnd = intval($scheduleUnixTime + ($courseTime * 60) + ($row['maintenanceTime'] * 60));
						#$selectedOptionsObject2 = $this->getSelectedOptions($_POST['options']);
						#$selectedOptions = $selectedOptionsObject2['object'];
						#$unixTimeEnd += $selectedOptionsObject2['time'] * 60;
						#$selectedOptionsObject2['totalTime'] = $unixTimeEnd;
						$servicesDetails2['unixTimeEnd'] = $unixTimeEnd;
						
						#return array("status" => "error", "servicesDetails" => $servicesDetails2, "unixTimeEnd" => $unixTimeEnd);
						
						$updateValueArray = array();
    					#if(strlen(COURSE_KEY) != 0){
    					if (count($selectedServices) > 0) {
            				
            				if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
        						
        						$unixTimeStart -= $preparation['time'] * 60;
        						
        					}
        					
        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
        						
        						$unixTimeEnd += $preparation['time'] * 60;
        						
        					}
            				
            				$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC;";
            				$updateValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
            				
            			}else{
            				
            				if (isset($preparation['time']) && intval(isset($preparation['time'])) > 0) {
            					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
	        						
	        						$unixTimeStart = $startTime - ($preparation['time'] * 60);
	        						
	        					}
	        					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
	        						
	        						$unixTimeEnd = $startTime + ($preparation['time'] * 60);
	        						
	        					}
	        					
	        					$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
	        					$updateValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
            					
            				} else {
            					
            					$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d;";
            					$updateValueArray = array(intval($accountCalendarKey), intval($scheduleKey));
            					
            				}
            				
            			}
    					
    				}
    				
    				$souce = array(
            			array("mode" => "reduce", "sql" => $deleteSql, "values" => $deleteValueArray), 
            			array("mode" => "increase", "sql" => $updateSql, "values" => $updateValueArray), 
            		);
    				
            		$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
            		if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
            			
            			return $updateSchedule;
            			
            		}
            		
            		$table_name = $wpdb->prefix . "booking_package_userPraivateData";
    				$bool = $wpdb->update(
    					$table_name,
                    	array(
                    		'scheduleKey'		=> intval($scheduleKey), 
                    		'scheduleUnixTime'	=> intval($scheduleUnixTime),
                    		'scheduleTitle'		=> sanitize_text_field($scheduleTitle), 
                    		'scheduleCost'		=> intval($scheduleCost), 
                    		'scheduleWeek'		=> intval($scheduleWeek),
                    		'courseKey'			=> sanitize_text_field(""), 
                    		'courseName'		=> sanitize_text_field(""),
                    		'courseTime'		=> intval(""),
                    		'courseCost'		=> intval(""),
                    		'options'			=> json_encode($selectedServices),
                    		'preparation'		=> json_encode($preparation),
                    	),
                    	array('key' => intval($_POST['updateKey'])),
                    	array('%d', '%d', '%s', '%d', '%d', '%s', '%s', '%d', '%d', '%s', '%s'),
                    	array('%d')
					);
    				
    			}
            	
            	
				$checkIn = 0;
				$checkOut = 0;
				$accommodationDetails = $this->getAccommodationDetails();
				if(!is_null($accommodationDetails)){
					
					$checkIn = $accommodationDetails['checkIn'];
					$checkOut = $accommodationDetails['checkOut'];
					
				}
				
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$bool = $wpdb->update(
					$table_name,
					array(
						'praivateData' => json_encode($form), 
						'accommodationDetails' => json_encode($accommodationDetails), 
						'checkIn' => intval($checkIn), 
						'checkOut' => intval($checkOut)
					),
					array('key' => intval($_POST['updateKey'])),
					array('%s', '%s', '%d', '%d'),
					array('%d')
				);
				
            }
					
			$googleCalendar = array();
    		if(strlen($iCalIDforGoogleCalendar) != 0){
    			
    			if($calendarAccount['type'] == 'hotel'){
    				
    				
    				
    			}
    			
    			$setting = new booking_package_setting($this->prefix, $this->pluginName);
    			$googleCalendar = $setting->pushGC('update', $accountKey, $calendarAccount['type'], intval($_POST['updateKey']), $calendarAccount['googleCalendarID'], $unixTimeStart, $unixTimeEnd, $form, $iCalIDforGoogleCalendar);
    			$this->updateQueueForGC(intval($_POST['updateKey']), $googleCalendar);
    			
    		}else{
    			
    			$googleCalendar['error'] = "No ID";
    			
    		}
    		
    		$ressponse = $this->getReservationData(intval($_POST['month']), 1, intval($_POST['year']));
    		$ressponse['googleCalendar'] = $googleCalendar;
    		$ressponse['status'] = "success";
    		$ressponse['souce'] = $souce;
    		$ressponse['accommodationDetails'] = $accommodationDetails;
    		$ressponse['servicesDetails1'] = $servicesDetails1;
    		$ressponse['servicesDetails2'] = $servicesDetails2;
    		$ressponse['deleteValueArray'] = $deleteValueArray;
    		$ressponse['updateValueArray'] = $updateValueArray;
    		$ressponse['COURSE_KEY'] = COURSE_KEY;
    		$ressponse['resultArray'] = $resultArray;
    		$ressponse['updateSchedule'] = $updateSchedule;
    		$ressponse['response_user'] = $response_user;
            
            return $ressponse;
    		
    	}
    	
    	public function serachGoogleCalendarIdOfVisitor($googleCalendarId = false){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_userPraivateData";
        	if($googleCalendarId != false){
        		
        		$sql = $wpdb->prepare(
        			"SELECT `key`,`iCalIDforGoogleCalendar`,`resultOfGoogleCalendar`,`resultModeOfGoogleCalendar` FROM ".$table_name." WHERE `iCalIDforGoogleCalendar` = %s;", 
        			array(sanitize_text_field($googleCalendarId))
        		);
        		$row = $wpdb->get_row($sql, ARRAY_A);
				
        		return $row;
        		
        	}
        	
        	return false;
        	
        }
    	
    	public function updateICalIDforGoogleCalendar($id, $iCalIDforGoogleCalendar){
    		
    		global $wpdb;
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
    		$bool = $wpdb->update(  
    								$table_name,
    								array(
    									'iCalIDforGoogleCalendar' => sanitize_text_field($iCalIDforGoogleCalendar),
    									'resultOfGoogleCalendar' => 1
    								),
									array('key' => intval($id)),
									array('%s', '%d'),
									array('%d')
								);
    		
    	}
    	
    	public function updateStatus($bookedKey, $bookedToken, $status = 'pending'){
			
			global $wpdb;
			
			$sendEmail = $_POST['sendEmail'];
			$status = strtolower($status);
			$bookingDetailsOnVisitor = $this->getBookingDetailsOnVisitor($bookedKey, $bookedToken);
			if ($bookingDetailsOnVisitor['status'] == 'error') {
				
				return $bookingDetailsOnVisitor;
				
			}
    		$myBookingDetails = $bookingDetailsOnVisitor['details'];
			if ($status == 'canceled') {
				
				$_POST['sendEmail'] = 0;
				$this->deleteBookingData($bookedKey, $myBookingDetails['accountKey'], false, false, 0);
				
			}
			
			$currency = 'usd';
			$service = null;
			$options = array();
			$accommodationDetails = array();
			$iCalIDforGoogleCalendar = null;
			$unixTimeStart = 0;
			$unixTimeEnd = 0;
			$maintenanceTime = 0;
			$form = null;
			$cancellationUri = null;
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array(intval($bookedKey)));
			$row = $wpdb->get_row($sql, ARRAY_A);
            if(is_null($row) === false){
            	
            	$accountKey = $row['accountKey'];
            	$calendarAccount = $this->getCalendarAccount($accountKey);
            	if ($calendarAccount['type'] == 'hotel') {
            		
            		$accommodationDetails = json_decode($row['accommodationDetails'], true);
            		
            	} else {
            		
            		$accommodationDetails['taxes'] = json_decode($row['taxes'], true);
            		
            	}
            	
            	$iCalIDforGoogleCalendar = $row['iCalIDforGoogleCalendar'];
				$form = json_decode($row['praivateData']);
				$applicantCount = $row['applicantCount'];
				$scheduleTitle = $row['scheduleTitle'];
				$unixTimeStart = $row['scheduleUnixTime'];
				$timestampForUnixTime = $row['reserveTime'];
				$courseName = $row['courseName'];
				$service = array("name" => $row['courseName'], "price" => $row['courseCost'], "time" => $row["courseTime"]);
				$currency = $row['currency'];
				$payName = $row['payName'];
				$payId = $row['payId'];
				$options = json_decode($row['options'], true);
				$servicesDetails = $this->getSelectedServices(json_decode($row['options'], true), "options", $applicantCount);
				$services = $servicesDetails['object'];
				$account_sql = null;
				$valueArray = array();
				$table_name = $wpdb->prefix."booking_package_schedule";
				$unixTimeEnd = $row['scheduleUnixTime'] + ($row['courseTime'] * 60) + ($row['maintenanceTime'] * 60);
				/**
				if (strlen($row['courseKey']) != 0) {
            		
            		$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC;";
            		$valueArray = array(1, intval($unixTimeStart), intval($unixTimeEnd));
            		
            	} else {
            		
            		$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d;";
            		$valueArray = array(1, intval($row['scheduleKey']));
            		
            	}
            	**/
            	if (!empty($row['permalink']) && !empty($row['cancellationToken'])) {
            		
            		$cancellationUri = $this->getCancellationUri($row['permalink'], $row['key'], $row['cancellationToken']);
            		
            	}
            	
            	/**
            	if($_POST['status'] == "approved"){
    				
    				$souce = array(
            			array("mode" => "increase", "sql" => $account_sql, "values" => $valueArray), 
            		);
    				$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
    				
    			}else if($_POST['status'] == "pending"){
    				
    				$souce = array(
            			array("mode" => "reduce", "sql" => $account_sql, "values" => $valueArray), 
            		);
            		$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
    				
    			}
    			**/
    			
    			$table_name = $wpdb->prefix."booking_package_userPraivateData";
    			$bool = $wpdb->update(
    				$table_name,
					array('status' => sanitize_text_field($status)),
					array('key' => intval($bookedKey)),
					array('%s'),
					array('%d')
				);
            		
            }
            
            $email_id = null;
            if ($status == "pending") {
            	
            	$email_id = 'mail_pending';
            	
            } else if ($status == "approved") {
            	
            	$email_id = 'mail_approved';
            	
            } else if ($status == "canceled") {
            	
            	$email_id = 'mail_canceled_by_visitor_user';
            	$cancellationUri = null;
            	
            }
            
            $mailBody = null;
    		#if($enableEmail == 1 && intval($_POST['sendEmail']) == 1){
    		if(intval($sendEmail) == 1){
    			
    			#$to = $this->emailFormat(get_option($this->prefix."email_to", null), get_option($this->prefix."email_title_to", null));
    			#$from = $this->emailFormat(get_option($this->prefix."email_from", null), get_option($this->prefix."email_title_from", null));
    			
    			$email = $this->createEmailMessage($accountKey, array($email_id), $form, $accommodationDetails, $options, intval($bookedKey), intval($unixTimeStart), intval($timestampForUnixTime), $cancellationUri, $currency, $services, $payName, $payId, $scheduleTitle);
    			#$ressponse['email'] = $email;
    			#return $email;
    		}
    		
    		
    		$ressponse = array();
    		if(intval($_POST['reload']) == 1){
    			
    			$ressponse = $this->getReservationData(intval($_POST['month']), 1, intval($_POST['year']));
    			
    		}
    		
    		$ressponse['status'] = "success";
    		$ressponse['googleCalendar'] = $googleCalendar;
    		$ressponse['services'] = $services;
    		$ressponse['status'] = $status;
    		$ressponse['sendEmail'] = $sendEmail;
    		return $ressponse;
    		
    	}
    	
    	public function changeBookingTime($mode, $updateKey, $updateScheduleKey, $status, $applicantCount, $newTimeStart, $newTimeEnd, $oldTimeStart, $oldTimeEnd, $accommodationDetails, $accountKey = 1){
    		
    		#var_dump($mode);
    		global $wpdb;
    		$accountCalendarKey = $accountKey;
    		$calendarAccount = $this->getCalendarAccount($accountKey);
    		if (intval($calendarAccount['schedulesSharing']) == 1) {
    			
    			$accountCalendarKey = intval($calendarAccount['targetSchedules']);
    			
    		}
    		$checkIn = 0;
    		$checkOut = 0;
    		$changeBool = true;
    		$scheduleDetail = null;
    		$table_name = $wpdb->prefix."booking_package_schedule";
    		$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC ;";
			$updateValue = array(intval($accountCalendarKey), intval($newTimeStart), intval($newTimeEnd));
			if($newTimeStart == $newTimeEnd){
				
				$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d;";
				$updateValue = array(intval($accountCalendarKey), intval($newTimeStart));
				
			}
			
			if(isset($accommodationDetails['sql']) && isset($accommodationDetails['valueArray'])){
				
				$updateSql = $accommodationDetails['sql'];
				$updateValue = $accommodationDetails['valueArray'];
				
			}
			
    		$sql = $wpdb->prepare($updateSql, $updateValue);
    		#var_dump($sql);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			
			if (count($rows) == 0 || $rows[0]['unixTime'] != $newTimeStart) {
				
				return array('status' => 'error', 'event' => 'return', 'message' => 'There is no booking schedule.');
				
			}
			
			
			foreach ((array) $rows as $row) {
				
				if (!is_null($oldTimeStart) && !is_null($oldTimeEnd)) {
					
					if ($oldTimeStart != $oldTimeEnd) {
						
						if($oldTimeStart <= $row['unixTime'] && $oldTimeEnd > $row['unixTime']){
							
							$row['remainder'] += $applicantCount;
							
						}
						
					} else {
						
						if ($oldTimeStart == $row['unixTime']) {
							
							$row['remainder'] += $applicantCount;
							
						}
						
					}
					
				}
				
				$row['remainder'] -= $applicantCount;
				#print "key = ".$row['key']." unixTime = ".$row['unixTime']." time = ".$row['hour'].":".$row['min']." capacity = ".$row['capacity']." remainder = ".$row['remainder']."<br>";
				if($row['remainder'] < 0 || $row['stop'] == 'true'){
					
					$changeBool = false;
					return array('status' => 'error', 'event' => 'return', 'message' => 'There is not enough remainder in the capacity.');
					break;
					
				}else{
					
					if(is_null($scheduleDetail)){
						
						$scheduleDetail = $row;
						
					}
					
				}
				
			}
			
			
			
			if($changeBool === true){
				
				$newCourseTime = ($newTimeEnd - $newTimeStart) / 60;
				$oldCourseTime = ($oldTimeEnd - $oldTimeStart) / 60;
				#print "courseTime = ".$newCourseTime."<br>";
				#var_dump($scheduleDetail);
				
				if($mode == 'update'){
					
					$checkIn = 0;
					$checkOut = 0;
					$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC ;";
					$deleteValue = array(intval($accountCalendarKey), intval($oldTimeStart), intval($oldTimeEnd));
					if($oldTimeStart == $oldTimeEnd){
						
						$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d;";
						$deleteValue = array(intval($accountCalendarKey), intval($updateScheduleKey));
						
					}
					
					if(isset($accommodationDetails['sql']) && isset($accommodationDetails['valueArray'])){
						
						$checkIn = $accommodationDetails['checkIn'];
						$checkOut = $accommodationDetails['checkOut'];
						$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
						$deleteValue = array(intval($accountCalendarKey), intval($oldTimeStart), intval($oldTimeEnd));
						unset($accommodationDetails['sql']);
						unset($accommodationDetails['valueArray']);
						
					}
					
					$souce = array(
            			array("mode" => "delete", "sql" => $deleteSql, "values" => $deleteValue), 
            			array("mode" => "increase", "sql" => $updateSql, "values" => $updateValue), 
            		);
					$this->updateRemainderSeart($souce, $applicantCount);
					
					$updateValue = array(
                            			'scheduleUnixTime' => intval($scheduleDetail['unixTime']), 
                            			'scheduleWeek' => intval($scheduleDetail['weekKey']), 
                            			'scheduleTitle' => $scheduleDetail['title'], 
                            			'scheduleCost' => intval($scheduleDetail['cost']), 
                            			'scheduleKey' => intval($scheduleDetail['key']),
                            			'checkIn' => intval($checkIn),
                            			'checkOut' => intval($checkOut),
                            			'accommodationDetails' => json_encode($accommodationDetails)
                            		);
					
					if($newCourseTime != $oldCourseTime){
						
						$updateValue['courseKey'] = "exception";
						$updateValue['courseName'] = $newCourseTime." min";
						$updateValue['courseTime'] = intval($newCourseTime);
						
					}
					
					$table_name = $wpdb->prefix."booking_package_userPraivateData";
    				$bool = $wpdb->update(  $table_name,
                    	        			$updateValue,
                    	        			array('key' => intval($updateKey)),
                    	        			array('%d', '%d', '%s', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%d'),
                    	        			array('%d')
							);
					
				}else{
					
					return $changeBool;
					
				}
				
				
				
			}
    		
    	}
    	
    	public function updatePraivateData($id, $form){
			
			global $wpdb;
			$form = json_encode($form);
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$bool = $wpdb->update(
				$table_name,
				array(
					'praivateData' => $form
				),
				array('key' => intval($id)),
				array('%s'),
				array('%d')
			);
			
		}
		
		public function updateRemainderSeart($souce, $applicantCount = 1){
			
			global $wpdb;
			$updateSchedule = array();
			$updateList = array();
			$error = array();
			$rollback = false;
			try {
				
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE");
				
				for ($i = 0; $i < count($souce); $i++) {
					
					$mode = $souce[$i]['mode'];
					$sql = $souce[$i]['sql'];
					$valueArray = $souce[$i]['values'];
					
					if ($mode == "increase") {
						
						$sql = $wpdb->prepare($sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						$updateArray = array();
						foreach ((array) $rows as $row) {
							
							$waitingRemainder = 0;
							$remainder = $row['remainder'] - $applicantCount;
							if ($row['stop'] == 'false' && $remainder >= 0) {
								
								if (0 < $row['waitingRemainder']) {
									
									$waitingRemainder = $row['waitingRemainder'] - $applicantCount;
									
								}
								
								array_push($updateArray, array('remainder' => intval($remainder), 'waitingRemainder' => intval($waitingRemainder), 'key' => intval($row['key'])));
								
							} else {
								
								$rollback = true;
								$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity of the schedule.', $this->pluginName));
								throw new Exception(json_encode($error));
								break;
								
							}
							
						}
						
						$table_name = $wpdb->prefix."booking_package_schedule";
						for ($a = 0; $a < count($updateArray); $a++) {
							
							$data = $updateArray[$a];
							$bool = $wpdb->update(
								$table_name,
								array('remainder' => $data['remainder'], 'waitingRemainder' => $data['waitingRemainder']),
								array('key' => $data['key']),
								array('%d', '%d'),
								array('%d')
							);
							/**
							$update = array(
								'value' => array('remainder' => $data['remainder'], 'waitingRemainder' => $data['waitingRemainder']),
								'key' => array('key' => $data['key']),
								'value_type' => array('%d', '%d'),
								'key_type' => array('%d'),
							);
							array_push($updateList, $update);
							**/
							array_push($updateSchedule, $bool);
							
						}
						
					} else {
						
						$table_name = $wpdb->prefix."booking_package_schedule";
						$sql = $wpdb->prepare($sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $rows as $row) {
							
							$remainder = intval($row['remainder']) + $applicantCount;
							if (intval($row['capacity']) < $remainder) {
								
								$rollback = true;
								$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity of the schedule.', $this->pluginName), "data" => $row);
								throw new Exception(json_encode($error));
								break;
								
							}
							
							$wpdb->update(
								$table_name,
								array('remainder' => intval($remainder)),
								array('key' => intval($row['key'])),
								array('%d'),
								array('%d')
							);
							/**
							$update = array(
								'value' => array('remainder' => intval($remainder)),
								'key' => array('key' => intval($row['key'])),
								'value_type' => array('%d'),
								'key_type' => array('%d'),
							);
							array_push($updateList, $update);
							**/	
							array_push($updateSchedule, $row['hour'].":".$row['min']." ".$remainder);
							
						}
						
					}
					
				}
				
				$wpdb->query('COMMIT');
				$wpdb->query('UNLOCK TABLES');
				
			} catch (Exception $e) {
				
				$wpdb->query('ROLLBACK');
				$wpdb->query('UNLOCK TABLES');
				$error = json_decode($e->getMessage(), true);
				return $error;
				
			}
    		/** finally {
    			
    			$wpdb->query('UNLOCK TABLES');
    			
    		}
    		**/
    		
    		/**
    		if ($php >= 55) {
    			
    			$wpdb->query("START TRANSACTION");
	    		$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE");
	    		
	    		try {
					
					for ($i = 0; $i < count($souce); $i++) {
						
						$mode = $souce[$i]['mode'];
						$sql = $souce[$i]['sql'];
						$valueArray = $souce[$i]['values'];
						
						if($mode == "increase"){
							
							$sql = $wpdb->prepare($sql, $valueArray);
							$rows = $wpdb->get_results($sql, ARRAY_A);
							$valueArray = array();
							foreach ((array) $rows as $row) {
								
								$waitingRemainder = 0;
								$remainder = $row['remainder'] - $applicantCount;
								if($row['stop'] == 'false' && $remainder >= 0){
									
									if(0 < $row['waitingRemainder']){
										
										$waitingRemainder = $row['waitingRemainder'] - $applicantCount;
										
									}
									
									array_push($valueArray, array('remainder' => intval($remainder), 'waitingRemainder' => intval($waitingRemainder), 'key' => intval($row['key'])));
									
								}else{
									
									$rollback = true;
									$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity of the schedule. 0', $this->pluginName));
									throw new Exception(json_encode($error));
									break;
									
								}
								
							}
							
							$table_name = $wpdb->prefix."booking_package_schedule";
							for($i = 0; $i < count($valueArray); $i++){
								
								$data = $valueArray[$i];
								
								$bool = $wpdb->update(
									$table_name,
									array('remainder' => $data['remainder'], 'waitingRemainder' => $data['waitingRemainder']),
									array('key' => $data['key']),
									array('%d', '%d'),
									array('%d')
								);
								
								#$update = array(
								#	'value' => array('remainder' => $data['remainder'], 'waitingRemainder' => $data['waitingRemainder']),
								#	'key' => array('key' => $data['key']),
								#	'value_type' => array('%d', '%d'),
								#	'key_type' => array('%d'),
								#);
								#array_push($updateList, $update);
								
								array_push($updateSchedule, $bool);
								
							}
			    			
			    		}else{
			    			
			    			$table_name = $wpdb->prefix."booking_package_schedule";
			            	$sql = $wpdb->prepare($sql, $valueArray);
			            	$rows = $wpdb->get_results($sql, ARRAY_A);
			            	foreach ((array) $rows as $row) {
								
								$remainder = intval($row['remainder']) + $applicantCount;
								if (intval($row['capacity']) < $remainder) {
									
									$rollback = true;
									$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity of the schedule. 1', $this->pluginName), "data" => $row);
									throw new Exception(json_encode($error));
									break;
									
								}
								
								$wpdb->update(
									$table_name,
									array('remainder' => intval($remainder)),
									array('key' => intval($row['key'])),
									array('%d'),
									array('%d')
								);
								
								#$update = array(
								#	'value' => array('remainder' => intval($remainder)),
								#	'key' => array('key' => intval($row['key'])),
								#	'value_type' => array('%d'),
								#	'key_type' => array('%d'),
								#);
								#array_push($updateList, $update);
									
			            		array_push($updateSchedule, $row['hour'].":".$row['min']." ".$remainder);
			            		
			            	}
			    			
			    		}
						
					}
					
					$wpdb->query('COMMIT');
					$wpdb->query('UNLOCK TABLES');
		    		
	    		} catch (Exception $e) {
	    			
	    			$wpdb->query('ROLLBACK');
	    			$wpdb->query('UNLOCK TABLES');
	    			$error = json_decode($e->getMessage(), true);
	    			return $error;
	    			
	    		}
	    		#finally {
	    		#	
	    		#	$wpdb->query('UNLOCK TABLES');
	    		#	
	    		#}
	    		
    			
    		} else {
    			
    			for ($i = 0; $i < count($souce); $i++) {
					
					$mode = $souce[$i]['mode'];
					$sql = $souce[$i]['sql'];
					$valueArray = $souce[$i]['values'];
					
					if($mode == "increase"){
						
						$sql = $wpdb->prepare($sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						$valueArray = array();
						foreach ((array) $rows as $row) {
							
							$waitingRemainder = 0;
							$remainder = $row['remainder'] - $applicantCount;
							if($row['stop'] == 'false' && $remainder >= 0){
								
								if(0 < $row['waitingRemainder']){
									
									$waitingRemainder = $row['waitingRemainder'] - $applicantCount;
									
								}
								
								array_push($valueArray, array('remainder' => intval($remainder), 'waitingRemainder' => intval($waitingRemainder), 'key' => intval($row['key'])));
								
							}else{
								
								#$rollback = true;
								#$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity of the schedule. 0', $this->pluginName));
								#break;
								
							}
							
						}
						
						$table_name = $wpdb->prefix."booking_package_schedule";
						for($i = 0; $i < count($valueArray); $i++){
							
							$data = $valueArray[$i];
							
							$bool = $wpdb->update(
								$table_name,
								array('remainder' => $data['remainder'], 'waitingRemainder' => $data['waitingRemainder']),
								array('key' => $data['key']),
								array('%d', '%d'),
								array('%d')
							);
							array_push($updateSchedule, $bool);
							
						}
		    			
		    		}else{
		    			
		    			$table_name = $wpdb->prefix."booking_package_schedule";
		            	$sql = $wpdb->prepare($sql, $valueArray);
		            	$rows = $wpdb->get_results($sql, ARRAY_A);
		            	foreach ((array) $rows as $row) {
							
							$remainder = intval($row['remainder']) + $applicantCount;
							if (intval($row['capacity']) < $remainder) {
								
								#$rollback = true;
								#$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity of the schedule. 1', $this->pluginName), "data" => $row);
								#break;
								
							}
							
							$wpdb->update(
								$table_name,
								array('remainder' => intval($remainder)),
								array('key' => intval($row['key'])),
								array('%d'),
								array('%d')
							);
							array_push($updateSchedule, $row['hour'].":".$row['min']." ".$remainder);
							
						}
						
					}
					
				}
				
    		}
    		**/
    		
    		return $updateSchedule;
    		
    	}
    	
		public function getUserList($unixTime, $accountKey = 1){
				
			global $wpdb;
            $table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare(
				"SELECT `key`,`scheduleUnixTime`,`scheduleKey`,`courseTime`,`status`,`applicantCount`,`praivateData`,`iCalIDforGoogleCalendar`,`resultOfGoogleCalendar`,`praivateData`,`checkIn`,`checkOut`,`accommodationDetails` FROM ".$table_name." WHERE `iCalIDforGoogleCalendar` IS NOT NULL AND `accountKey` = %d AND `scheduleUnixTime` > %d ORDER BY `key` ASC;", 
				array(intval($accountKey), intval($unixTime))
			);
            $rows = $wpdb->get_results($sql, ARRAY_A);
			return $rows;
			
		}
		
		public function getUserValues($accountKey, $user_id = null) {
			
			global $wpdb;
			$visitorName = array();
			$table_name = $wpdb->prefix."booking_package_form";
			$sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
			$row = $wpdb->get_row($sql, ARRAY_A);
			#$form = json_decode($row['data']);
			$form = array();
			$data = json_decode($row['data']);
			foreach ((array) $data as $key => $value) {
				
				if (is_int($user_id) === true && isset($value->targetCustomers) && $value->targetCustomers == 'visitors') {
					
					//continue;
					$value->active = '';
					
				}
				
				if (is_null($user_id) === true && isset($value->targetCustomers) && $value->targetCustomers == 'users') {
					
					//continue;
					$value->active = '';
					
				}
				
				array_push($form, $value);
				
			}
			
			for ($i = 0; $i < count($form); $i++) {
				
				if (isset($_POST['form' . $i])) {
					
					if ($form[$i]->required == 'true' && strlen(preg_replace("/( |　)/", "", $_POST['form' . $i])) == 0) {
						
						return array('status' => 'error', "message" => 'No text or select.', 'form' => $form[$i]);
						
					} else {
						
						#if ($form[$i]->isEmail == 'true' && strlen($_POST['form'.$i]) != 0 && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['form'.$i])) {
						if ($form[$i]->isEmail == 'true' && strlen($_POST['form' . $i]) != 0 && is_email($_POST['form' . $i]) === false) {
							
							return array('status' => 'error', "message" => __('The format of the email address is incorrect.', $this->pluginName) . "\n" . $form[$i]->name, 'form' => $form[$i]);
							
						} else {
							
							$value = $_POST['form' . $i];
							if ($form[$i]->type == 'TEXTAREA') {
								
								$value = sanitize_textarea_field($value);
								
							} else if($form[$i]->type == 'CHECK') {
								
								$value = str_replace("\\\"", "\"", sanitize_text_field($value));
				                $value = str_replace("\'", "'", $value);
				                $value = json_decode($value, true);
				                if (is_null($value) || is_bool($value) === true) {
				                    
				                    $value = array();
				                    
				                }
								
							} else {
								
								$value = sanitize_text_field($value);
								
							}
							
							if ($form[$i]->isEmail == 'true') {
								
								$value = sanitize_email($value);
								
							}
							
							if ($form[$i]->isName == 'true') {
								
								array_push($visitorName, sanitize_email($value));
								
							}
							
							$form[$i]->value = $value;
							
						}
					
					}
				
				}
				
			}
			
			return $form;
			
		}
		
		public function emailFormat($email, $title = null){
			
			$value = $email;
			if (!is_null($title) && strlen($title) != 0) {
				
				$value = sprintf("%s <%s>", $title, $email);
				
			}
			return $value;
			
		}
		
    	public function dateFormat($dateFormat, $positionOfWeek, $unixTime, $title, $includingTime, $shortString = false){
    		
    		$dateFormat = intval($dateFormat);
    		$clock = get_option($this->prefix."clock", '24hours');
    		if (is_numeric($clock)) {
    			
    			if (intval($clock) == 12) {
					
					$clock = '12a.m.p.m';
					
				} else if (intval($clock) == 24) {
					
					$clock = '24hours';
					
				}
    			
    		}
    		
    		$monthList = array(__('January'), __('February'), __('March'), __('April'), __('May'), __('June'), __('July'), __('August'), __('September'), __('October'), __('November'), __('December'));
    		
    		$weekNameList = array(__('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday'));
    		$weekName = $weekNameList[date('w', $unixTime)];
    		
    		if($shortString == true){
    			
    			$monthList = array(__('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jun'), __('Jul'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec'));
    			
    			$weekNameList = array(__('Sun'), __('Mon'), __('Tue'), __('Wed'), __('Thu'), __('Fri'), __('Sat'));
    			$weekName = $weekNameList[date('w', $unixTime)];
    			
    		}
    		
    		
    		if (is_null($title)) {
    			
    			$title = '';
    			
    		}
    		
    		$date = date('d/m/Y ', $unixTime);
    		$time = date('H:i', $unixTime) . " " . $title;
    		$hour = intval(date('G', $unixTime));
    		if ($clock != '24hours') {
    			
    			$print_am_pm = 'a.m.';
    			if ($clock == '12AMPM') {
    				
    				$print_am_pm = 'AM';
    				
    			} else if ($clock == '12ampm') {
    				
    				$print_am_pm = 'am';
    				
    			}
    			
    			if ($hour >= 12) {
    				
    				$print_am_pm = 'p.m.';
    				if ($clock == '12AMPM') {
	    				
	    				$print_am_pm = 'PM';
	    				
	    			} else if ($clock == '12ampm') {
	    				
	    				$print_am_pm = 'pm';
	    				
	    			}
    				
    			}
    			
    			$time = sprintf(__('%s:%s ' . $print_am_pm, $this->pluginName), date('h', $unixTime), date('i', $unixTime)) . " " . $title;
    			
    		}
    		
    		if ($includingTime == false) {
    			
    			$time = "";
    			
    		}
    		
    		if($dateFormat == 0){
    			
        		$date = date('m/d/Y ', $unixTime);
        		
    		}else if($dateFormat == 1){
    			
		        $date = date('m-d-Y ', $unixTime);
		        
    		}else if($dateFormat == 2){
    			
        		#$date = date('F d, Y', $unixTime);
        		$date = $monthList[date('n', $unixTime) - 1].date(' d, Y', $unixTime);
        		
    		}else if($dateFormat == 3){
    			
        		$date = date('d/m/Y ', $unixTime);
        		
    		}else if($dateFormat == 4){
    			
        		$date = date('d-m-Y ', $unixTime);
        		
    		}else if($dateFormat == 5){
    			
        		#$date = date('d F, Y ', $unixTime);
        		$date = date('d ', $unixTime).$monthList[date('n', $unixTime) - 1].date(', Y', $unixTime);
        		
    		}else if($dateFormat == 6){
    			
        		$date = date('Y/m/d ', $unixTime);
        		
    		}else if($dateFormat == 7){
    			
        		$date = date('Y-m-d ', $unixTime);
        		
    		}else if($dateFormat == 8 || $dateFormat == 9){
    			
        		$date = date('d.m.Y ', $unixTime);
        		
    		}
    		
    		if($positionOfWeek == 'before'){
    			
    			$date = $weekName.' '.$date.' '.$time;
    			
    		}else{
    			
    			$date = $date.' '.$weekName.' '.$time;
    			
    		}
    		
    		return $date;
    		
    	}
		
		public function formatCost($cost = 0, $currency = 'usd'){
			
			$cost = intval($cost);
			if (strtoupper($currency) == 'USD') {
				
				$cost = 'US\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'EUR') {
				
				$cost = '€' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'JPY') {
				
				$cost = '¥' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'HUF') {
				
				$cost = 'HUF ' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'DKK') {
				
				$cost = number_format(($cost / 100), 2) . 'kr';
				
			} else if (strtoupper($currency) == 'CNY') {
				
				$cost = 'CN¥' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'TWD') {
				
				$cost = 'NT\$' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'THB') {
				
				$cost = 'TH฿' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'COP') {
				
				$cost = 'COP' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'CAD') {
				
				$cost = '\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'AUD') {
				
				$cost = '\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'GBP') {
				
				$cost = '£' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'PHP') {
				
				$cost = 'PHP ' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'CHF') {
				
				$cost = 'CHF ' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'CZK') {
				
				$cost = 'Kč' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'RUB') {
				
				$cost = number_format(($cost / 100), 2) . '₽';
				
			} else if (strtoupper($currency) == 'NZD') {
				
				$cost = 'NZ\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'HRK') {
				
				$cost = number_format(($cost / 100), 2) . ' Kn';
				
			} else if (strtoupper($currency) == 'UAH') {
				
				$cost = number_format(($cost / 100), 2) . 'грн.';
				
			}
			
			return $cost;
			
		}
    	
    	public function bookingDetailsForHotel($accommodationDetails, $currency, $mode = 'array'){
    		
    		if (is_null($accommodationDetails) || $accommodationDetails === false) {
    			
    			return array();
    			
    		}
    		
    		$applicantCount = intval($accommodationDetails['applicantCount']);
    		$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    		$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
    		$nights = __('nights', $this->pluginName);
			$lengthOfStay = $accommodationDetails['nights']." ".$nights." (".$this->formatCost($accommodationDetails['accommodationFee'], $currency).")";
			if (intval($accommodationDetails['nights']) == 1) {
				
				$nights = __('night', $this->pluginName);
				
			}
			
			$multipleRooms = false;
			$roomStr = __('room', $this->pluginName);
			if ($applicantCount > 1) {
				
				$multipleRooms = true;
				$roomStr = __('rooms', $this->pluginName);
				
			}
			
			$detailsList = array(__('Total length of stay', $this->pluginName) . ": " . $accommodationDetails['nights'] . " " . $nights . " ".$this->formatCost($accommodationDetails['accommodationFee'], $currency) . ", " . $accommodationDetails['applicantCount'] . ' ' . $roomStr);
			$objectList = array(
				'totalLengthOfStay' => array(
					'main' => $accommodationDetails['nights'] . " " . $nights . " " . $this->formatCost(($accommodationDetails['accommodationFee']), $currency), 
					'sub' => array(),
				), 
				'totalLengthOfGuests' => array(
					'main' => array(), 
					'sub' => array(),
				),
				'totalLengthOfTaxes' => array(
					'main' => array(),
					'sub' => array(),
				),
			);
			$scheduleDetails = $accommodationDetails['scheduleDetails'];
			$no = 0;
			foreach ((array) $scheduleDetails as $key => $value) {
				
				$no++;
				$details = "#".$no." ".$this->dateFormat($dateFormat, $positionOfWeek, $value['unixTime'], null, false, false)." ";
				if (intval($value['cost']) > 0) {
					
					$details .= $this->formatCost($value['cost'] * $applicantCount, $currency);
					
				}
				
				if ($multipleRooms === true) {
					
					$details .= ' (' . $this->formatCost($value['cost'], $currency) . ' * ' . $applicantCount . ' ' . $roomStr . ')';
					
				}
				
				array_push($detailsList, $details);
				array_push($objectList['totalLengthOfStay']['sub'], $details);
				
			}
			
			$people = intval($accommodationDetails['adult']) + intval($accommodationDetails['children']);
			$additionalFee = 0;
			$people = 0;
			$rooms = $accommodationDetails['rooms'];
			foreach ((array) $rooms as $room) {
				
				$additionalFee += intval($room['additionalFee']) * intval($accommodationDetails['nights']);
				$people += intval($room['person']);
				
			}
			
			if ($people == 1) {
				
				$people = $people." ".__("person", $this->pluginName)." ";
				
				
			} else {
				
				$people = $people." ".__("people", $this->pluginName)." ";
				
			}
			
			if ($additionalFee > 0) {
				
				$people .= "".$this->formatCost($additionalFee, $currency)."";
				
			}
			
			array_push($detailsList, "\n".__('Total number of guests', $this->pluginName).": ".$people);
			$objectList['totalLengthOfGuests']['main'] = $people;
			
			$roomNo = 0;
			foreach ((array) $rooms as $room) {
				
				if ($multipleRooms === true) {
					
					$roomNo++;
					array_push($detailsList, __('Room', $this->pluginName) . ': ' . $roomNo);
					array_push($objectList['totalLengthOfGuests']['sub'], __('Room', $this->pluginName) . ': ' . $roomNo);
					
				}
				$guestsList = $room['guestsList'];
				$no = 0;
				foreach ((array) $guestsList as $key => $value) {
					
					$no++;
					$name = $value['name'];
					$guests = $value['json'];
					for($i = 0; $i < count($guests); $i++){
						
						if(intval($guests[$i]['selected']) == 1){
							
							$details = "#".$no." ".$name.": ".$guests[$i]['name']." ";
							if (intval($guests[$i]['price']) > 0) {
								
								$details .= "(".$this->formatCost($guests[$i]['price'], $currency)." * ".$accommodationDetails['nights']." ".$nights.")";
								
							}
							array_push($detailsList, $details);
							array_push($objectList['totalLengthOfGuests']['sub'], $details);
							break;
							
						}
						
					}
					
				}
				
				
			}
			
			/**
			$guestsList = $accommodationDetails['guestsList'];
			$no = 0;
			foreach ((array) $guestsList as $key => $value) {
				
				$no++;
				$name = $value['name'];
				$guests = $value['json'];
				for($i = 0; $i < count($guests); $i++){
					
					if(intval($guests[$i]['selected']) == 1){
						
						$details = "#".$no." ".$name.": ".$guests[$i]['name']." ";
						if (intval($guests[$i]['price']) > 0) {
							
							$details .= "(".$this->formatCost($guests[$i]['price'], $currency)." * ".$accommodationDetails['nights']." ".$nights.")";
							
						}
						array_push($detailsList, $details);
						array_push($objectList['totalLengthOfGuests']['sub'], $details);
						break;
						
					}
					
				}
				
			}
			**/
			
			$taxes = array();
			$surcharges = array();
			$taxesList = $accommodationDetails['taxes'];
			foreach ((array) $taxesList as $key => $tax) {
				
				$details = $tax['name']." ".$this->formatCost($tax['taxValue'], $currency);
				if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_inclusive') {
					
					array_push($taxes, $details);
					
				} else if($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
					
					array_push($taxes, $details);
					
				} else if($tax['type'] == 'surcharge') {
					
					array_push($surcharges, $details);
					
				}
				
				#$details = $tax['name']." ".$this->formatCost($tax['taxValue'], $currency);
				#array_push($detailsList, $details);
				array_push($objectList['totalLengthOfTaxes']['sub'], $details);
				
			}
			
			if (count($surcharges) > 0) {
				
				array_push($detailsList, "\n".__('Surcharges', $this->pluginName));
				for ($i = 0; $i < count($surcharges); $i++) {
					
					array_push($detailsList, $surcharges[$i]);
					
				}
				
			}
			
			if (count($taxes) > 0) {
				
				array_push($detailsList, "\n".__('Taxes', $this->pluginName));
				for ($i = 0; $i < count($taxes); $i++) {
					
					array_push($detailsList, $taxes[$i]);
					
				}
				
			}
			
			if ($mode == 'array') {
				
				return $detailsList;
				
			} else {
				
				return $objectList;
				
			}
    		
    	}
    	
    	public function createEmailMessage($accountKey, $email_id, $form, $accommodationDetails, $options, $bookingID, $unixTime, $timestampForUnixTime, $cancellationUri, $currency = 'usd', $services = null, $payName = null, $payId = null, $scheduleTitle = null){
			
			global $wpdb;
			
			if (empty($payName)) {
				
				$payName = __('I will pay locally', $this->pluginName);
				
			}
			
			$calendarAccount = $this->getCalendarAccount($accountKey);
			#$to = $this->emailFormat(get_option($this->prefix."email_to", null), get_option($this->prefix."email_title_to", null));
			$to = get_option($this->prefix."email_to", null);
			$from = $this->emailFormat(get_option($this->prefix."email_from", null), get_option($this->prefix."email_title_from", null));
			if (!empty($calendarAccount['email_from'])) {
				
				$from = $this->emailFormat($calendarAccount['email_from'], $calendarAccount['email_from_title']);
				
			}
			
			$table_name = $wpdb->prefix."booking_package_emailSetting";
			for ($i = 0; $i < count($email_id); $i++) {
				
				$sql = $wpdb->prepare(
					"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `mail_id` = %s;", 
					array(intval($accountKey), $email_id[$i])
				);
				$row = $wpdb->get_row($sql, ARRAY_A);
				
				$emailSubject = $row['subject'];
				$emailBody = $row['content'];
				$emailFormat = $row['format'];
				if (empty($row['subjectForAdmin'])) {
					
					$row['subjectForAdmin'] = $row['subject'];
					
				}
				
				if (empty($row['contentForAdmin'])) {
					
					$row['contentForAdmin'] = $row['content'];
					
				}
				
				$sendEamilList = array(
					'visitor' => array("subject" => $row['subject'], 'content' => $row['content']),
					'admin' => array("subject" => $row['subjectForAdmin'], 'content' => $row['contentForAdmin']),
				);
				
				if (intval($row['enable']) == 0) {
					
					return null;
					
				}
				
			}
			
			foreach ((array) $sendEamilList as $emailKey => $target) {
				
				$emailSubject = $target['subject'];
				$emailSubject = stripslashes($emailSubject);
				$emailSubject = preg_replace('/\\\/u', "", $emailSubject);
				$emailBody = $target['content'];
				$emailBody = stripslashes($emailBody);
				$emailBody = preg_replace('/\\\/u', "", $emailBody);
				
				if (preg_match('/(\[stop_email\])/', $emailBody, $matches)) {
					
					continue;
					
				}
				
				$emailData = array('subject' => $emailSubject, 'body' => $emailBody);
				foreach ((array) $emailData as $emailDataKey => &$emailDataValue) {
					
					$site_name = get_option($this->prefix."site_name", "");
					$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
					$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
					$date = $this->dateFormat($dateFormat, $positionOfWeek, $unixTime, $scheduleTitle, true, false);
					if (preg_match('/(\[date\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[date\])/', $date, $emailDataValue);
						
					}
					
					$timestamp = $this->dateFormat($dateFormat, $positionOfWeek, $timestampForUnixTime, $scheduleTitle, true, false);
					if (preg_match('/(\[receptionDate\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[receptionDate\])/', $timestamp, $emailDataValue);
						
					}
					
					
					if (preg_match('/(\[checkIn\])/', $emailDataValue, $matches)) {
						
						$date = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkIn'], $scheduleTitle, false, false);
						$emailDataValue = preg_replace('/(\[checkIn\])/', $date, $emailDataValue);
						
					}
					
					if (preg_match('/(\[checkOut\])/', $emailDataValue, $matches)) {
						
						$date = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkOut'], $scheduleTitle, false, false);
						$emailDataValue = preg_replace('/(\[checkOut\])/', $date, $emailDataValue);
						
					}
					
					if (preg_match('/(\[bookingDetails\])/', $emailDataValue, $matches)) {
						
						$detailsList = $this->bookingDetailsForHotel($accommodationDetails, $currency, 'array');
						$emailDataValue = preg_replace('/(\[bookingDetails\])/', implode("\n", $detailsList), $emailDataValue);
						
					}
					
					if (preg_match('/(\[totalPaymentAmount\])/', $emailDataValue, $matches)) {
						
						$amount = 0;
						if ($calendarAccount['type'] == 'day') {
							
							if (is_array($services)) {
								
								foreach ((array) $services as $key => $service) {
									
									$amount += intval($service['cost']);
									foreach ((array) $service['options'] as $option) {
										
										if (intval($option['selected']) == 1) {
											
											$amount += intval($option['cost']);
											
										}
										
									}
									
								}
								
							}
							
							$taxes = $this->getTaxesDetailsForVisitor($bookingID, $amount);
							for ($i = 0; $i < count($taxes); $i++) {
								
								$tax = $taxes[$i];
								if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
									
									$amount += $tax['taxValue'];
									
								} else if ($tax['type'] == 'surcharge') {
									
									$amount += $tax['taxValue'];
									
								}
								
							}
							
							$amount = $this->formatCost($amount, $currency);
					
						} else {
							
							$amount = $this->formatCost((intval($accommodationDetails['accommodationFee']) + intval($accommodationDetails['taxesFee']) + intval($accommodationDetails['additionalFee'])), $currency);
							
						}
						
						$emailDataValue = preg_replace('/(\[totalPaymentAmount\])/', $amount, $emailDataValue);
						
					}
					
					if (preg_match('/(\[cancellationUri\])/', $emailDataValue, $matches)) {
						
						if (intval($calendarAccount['cancellationOfBooking']) == 1 && !is_null($cancellationUri)) {
							
							$emailDataValue = preg_replace('/(\[cancellationUri\])/', $cancellationUri, $emailDataValue);
							
						} else {
							
							$emailDataValue = preg_replace('/(\[cancellationUri\])/', "", $emailDataValue);
							
						}
						
					}
					
					if (preg_match('/(\[receivedUri\])/', $emailDataValue, $matches) && isset($_POST['receivedUri'])) {
						
						$emailDataValue = preg_replace('/(\[receivedUri\])/', $_POST['receivedUri'], $emailDataValue);
						
					}
					
					if (preg_match('/(\[guests\])/', $emailDataValue, $matches)) {
						
						$guestsDetails = array();
						$rooms = $accommodationDetails['rooms'];
						if (count($rooms) > 0) {
							
							foreach ((array) $rooms as $roomKey => $room) {
								
								array_push($guestsDetails, __('Room', $this->pluginName) . ': ' . ($roomKey + 1));
								$guestsList = $room['guestsList'];
								foreach ((array) $guestsList as $key => $value) {
									
									$name = $value['name'];
									$guests = $value['json'];
									for ($i = 0; $i < count($guests); $i++) {
										
										if (intval($guests[$i]['selected']) == 1) {
											
											array_push($guestsDetails, $name.": ".$guests[$i]['name']);
											break;
											
										}
										
									}
									
								}
								
							}
							
						} else {
							
							$guestsList = $accommodationDetails['guestsList'];
							foreach ((array) $guestsList as $key => $value) {
								
								$name = $value['name'];
								$guests = $value['json'];
								for($i = 0; $i < count($guests); $i++){
									
									if (intval($guests[$i]['selected']) == 1) {
										
										array_push($guestsDetails, $name.": ".$guests[$i]['name']);
										break;
										
									}
									
								}
								
							}
							
						}
						
						$guestsDetails = implode("\n", $guestsDetails);
						$emailDataValue = preg_replace('/(\[guests\])/', $guestsDetails, $emailDataValue);
						
					}
					
					if (preg_match('/(\[surcharges\])/', $emailDataValue, $matches)) {
						
						$surchargesDetails = array();
						$surcharges = $accommodationDetails['taxes'];
						#foreach ((array) $surcharges as $key => $tax) {
						for ($i = 0; $i < count($surcharges); $i++) {
							
							$tax = $surcharges[$i];
							if ($tax['type'] == 'surcharge' && $tax['active'] == 'true') {
								
								$cost = $this->formatCost($tax['taxValue'], $currency);
								array_push($surchargesDetails, $tax['name'] . ' ' . $cost);
								
							}
							
						}
						$surchargesDetails = implode("\n", $surchargesDetails);
						$emailDataValue = preg_replace('/(\[surcharges\])/', $surchargesDetails, $emailDataValue);
						
					}
					
					if (preg_match('/(\[taxes\])/', $emailDataValue, $matches)) {
						
						$taxesDetails = array();
						$taxes = $accommodationDetails['taxes'];
						#foreach ((array) $taxes as $key => $tax) {
						for ($i = 0; $i < count($taxes); $i++) {
							
							$tax = $taxes[$i];
							if ($tax['type'] == 'tax' && $tax['active'] == 'true') {
								
								$cost = $this->formatCost($tax['taxValue'], $currency);
								array_push($taxesDetails, $tax['name'] . ' ' . $cost);
								
							}
							
						}
						$taxesDetails = implode("\n", $taxesDetails);
						$emailDataValue = preg_replace('/(\[taxes\])/', $taxesDetails, $emailDataValue);
						
					}
					
					if (preg_match('/(\[id\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[id\])/', $bookingID, $emailDataValue);
						
					}
					
					if (preg_match('/(\[site_name\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[site_name\])/', $site_name, $emailDataValue);
						
					}
					
					if (preg_match('/(\[paymentMethod\])/', $emailDataValue, $matches)) {
						
						$payName = __("I will pay locally", $this->pluginName);
						if ($payId == 'stripe') {
							
							$payName = __("Pay with Credit Card", $this->pluginName);
							
						} else if ($payId == 'paypal') {
							
							$payName = __("Pay with PayPal", $this->pluginName);
							
						}
						
						$emailDataValue = preg_replace('/(\[paymentMethod\])/', $payName, $emailDataValue);
						
					}
					
					if (!is_null($services)) {
						
						if (preg_match('/(\[service\])/', $emailDataValue, $matches)) {
							#var_dump($services);
							if (is_array($services)) {
								
								$detailsList = array();
								foreach ((array) $services as $key => $service) {
									
									//if (intval($service['cost']) > 0) {
									if (is_int(intval($service['cost'])) === true && intval($service['cost']) != 0) {
										
										array_push($detailsList, $service['name']." ".$this->formatCost($service['cost'], $currency));
										
									} else {
										
										array_push($detailsList, $service['name']);
										
									}
									
									$no = 0;
									foreach ((array) $service['options'] as $option) {
										
										if (intval($option['selected']) == 1) {
											
											$no++;
											$details = "#".$no." ".$option['name']." ";
											if (intval($option['cost']) > 0) {
												
												$details .= $this->formatCost($option['cost'], $currency);
												
											}
											array_push($detailsList, $details);
											
										}
										
									}
									
								}
								
								$emailDataValue = preg_replace('/(\[service\])/', implode("\n", $detailsList), $emailDataValue);
								
							} else {
								
								$emailDataValue = preg_replace('/(\[service\])/', $service, $emailDataValue);
								
							}
							
						}
					
					}
					
					$visitorEmail = array();
					$content = "";
					for ($i = 0; $i < count($form); $i++) {
						
						if ($form[$i]->active == '') {
							
							continue;
							
						}
						
						$value = $form[$i]->value;
						if (is_array($value)) {
							
							$value = implode("\r\n", $form[$i]->value);
							
						}
						
						if ($emailFormat == "text") {
							
							$content .= $form[$i]->name . "\r\n" . $value . "\r\n";
							
						} else {
							
							$content .= '<div style="width: 100%; display: table;"><div style="width: 30%; display: table-cell; vertical-align: middle;">' . $form[$i]->name . '</div><div style="width: 70%; display: table-cell; vertical-align: middle;">' . $value . '</div></div>';
							#$content .= '<div style="width: 30%; display: table-cell; vertical-align: middle;">'.$form[$i]->name.'</div><div style="width: 70%; display: table-cell; vertical-align: middle;">'.$form[$i]->value.'</div>';
							
						}
						
						if ($form[$i]->isEmail == 'true') {
							
							array_push($visitorEmail, $form[$i]->value);
							
						}
						
					}
					
					if (preg_match('/(\[content\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[content\])/', $content, $emailDataValue);
						
					}
					
					for($i = 0; $i < count($form); $i++){
						
						$id = '\['.$form[$i]->id.'\]';
						#$value = $form[$i]->name."\n".$form[$i]->value."\n";
						#$value = $form[$i]->value."";
						$value = $form[$i]->value;
						if (is_array($value)) {
							
							$value = implode("\r\n", $form[$i]->value);
							
						}
						
						if (preg_match('/('.$id.')/', $emailDataValue, $matches)) {
							
							$emailDataValue = preg_replace('/('.$id.')/', $value, $emailDataValue);
							
						}
						
					}
					
					if ($emailDataKey == 'subject') {
						
						$emailSubject = $emailDataValue;
						
					} else {
						
						$emailBody = $emailDataValue;
						
					}
					
				}
				unset($emailDataValue);
				//$emailSubject = $emailData['subject'];
				$emailSubject = str_replace(array("\r\n", "\r", "\n"), '', $emailSubject);
				//$emailBody = $emailData['body'];
				
				$headers = array("From: ".$from."\r\n", "Return-Path: ".$from."\r\n", "Reply-To: ".$from."\r\n");
				
				if($emailFormat == "text"){
					
					$emailBody = strip_tags($emailBody);
					
				}else{
					
					array_push($headers, "Content-Type: text/html; charset=UTF-8");
					$bodyStyle = 'word-wrap: break-word; white-space: pre;';
					$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
					$header .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Booking email</title></head>';
					$header .= '<body style="'.$bodyStyle.'">';
					$emailBody = $header.$emailBody."</body></html>";
					
				}
				
				$responseList = array('body' => $emailBody, 'to' => $to, 'from' => $from, 'sendVisitor' => $sendVisitor, 'headers' => $headers, 'visitorEmail' => $visitorEmail, 'response' => array(), 'params' => array());
				if (function_exists('mb_language')) {
					
					mb_language("uni");
					
				}
				
				if (function_exists('mb_internal_encoding')) {
					
					mb_internal_encoding("UTF-8");
					
				}
				
				$mailgun_active = intval(get_option($this->prefix."mailgun_active", 0));
				if ($mailgun_active == 1) {
					
					$mailgun_aip_base_url = get_option($this->prefix."mailgun_aip_base_url", 0);
					$mailgun_api_key = get_option($this->prefix."mailgun_api_key", 0);
					//$mailgun_password = get_option($this->prefix."mailgun_password", 0);
					
					$params = array('from' => $from, 'to' => implode(",", $visitorEmail), 'subject' => $emailSubject);
					if ($emailFormat == "text") {
						
						$params['text'] = $emailBody;
						
					} else {
						
						$params['html'] = $emailBody;
						
					}
					$responseList['params']['visitor'] = $params;
					if (count($visitorEmail) != 0 && $emailKey == 'visitor') {
						
						$paramsQuery = http_build_query($params);
						#$params = json_encode($params);
						$context = array(
							'http' => array(
								'method' => 'POST', 
								'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
								"Content-Length: ".strlen($paramsQuery)."\r\n".
								"User-Agent: PHP\r\n".
								"Host: api.mailgun.net\r\n".
								"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
								'content' => $paramsQuery
							)
						);
						
						$context = stream_context_create($context);
						$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
						$responseList['response']['visitor'] = $response;
						
	    			} else if ($emailKey == 'admin') {
	    				
	    				$params['to'] = $to;
		    			$responseList['params']['admin'] = $params;
		    			$paramsQuery = http_build_query($params);
						$context = array(
							'http' => array(
								'method' => 'POST', 
								'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
								"Content-Length: ".strlen($paramsQuery)."\r\n".
								"User-Agent: PHP\r\n".
								"Host: api.mailgun.net\r\n".
								"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
								'content' => $paramsQuery
							)
						);
						
						$context = stream_context_create($context);
						$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
						$responseList['response']['admin'] = $response;
						
						if (!empty($calendarAccount['email_to'])) {
							
							$params['to'] = $calendarAccount['email_to'];
							$responseList['params']['calendarAccount'] = $params;
							$paramsQuery = http_build_query($params);
							$context = array(
								'http' => array(
									'method' => 'POST', 
									'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
									"Content-Length: ".strlen($paramsQuery)."\r\n".
									"User-Agent: PHP\r\n".
									"Host: api.mailgun.net\r\n".
									"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
									'content' => $paramsQuery
								)
							);
							
							$context = stream_context_create($context);
							$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
							$responseList['response']['calendarAccount'] = $response;
							
						}
	    				
	    			}
	    			
	    		} else {
	    			
	    			$sendVisitor = false;
	    			if (count($visitorEmail) != 0 && $emailKey == 'visitor') {
	    				
	    				$sendVisitor = wp_mail($visitorEmail, $emailSubject, $emailBody, $headers);
	    				$responseList['sendVisitor'] = $sendVisitor;
	    				
	    			} else if ($emailKey == 'admin') {
	    				
	    				$sendControl = wp_mail($to, $emailSubject, $emailBody, $headers);
		    			$responseList['sendControl'] = $sendControl;
		    			
		    			if (!empty($calendarAccount['email_to'])) {
		    				
		    				$sendAccount = wp_mail($calendarAccount['email_to'], $emailSubject, $emailBody, $headers);
		    				$responseList['sendAccount'] = $sendAccount;
		    				
		    			}
	    				
	    			}
	    			
	    		}
	    		
	    		$responseList['mailgun_active'] = $mailgun_active;
    			
    		}
    		
    		/**
    		$mailBody = stripslashes($mailBody);
    		$emailBody = preg_replace('/\\\/u', "", $emailBody);
    		
    		$site_name = get_option($this->prefix."site_name", "");
    		$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    		$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
    		$date = $this->dateFormat($dateFormat, $positionOfWeek, $unixTime, $scheduleTitle, true, false);
    		if (preg_match('/(\[date\])/', $emailBody, $matches)) {
    			
    			$emailBody = preg_replace('/(\[date\])/', $date, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[checkIn\])/', $emailBody, $matches)) {
    			
    			$date = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkIn'], $scheduleTitle, false, false);
    			$emailBody = preg_replace('/(\[checkIn\])/', $date, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[checkOut\])/', $emailBody, $matches)) {
    			
    			$date = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkOut'], $scheduleTitle, false, false);
    			$emailBody = preg_replace('/(\[checkOut\])/', $date, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[bookingDetails\])/', $emailBody, $matches)) {
    			
    			$detailsList = $this->bookingDetailsForHotel($accommodationDetails, $currency, 'array');
    			$emailBody = preg_replace('/(\[bookingDetails\])/', implode("\n", $detailsList), $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[totalPaymentAmount\])/', $emailBody, $matches)) {
    			
    			$amount = 0;
    			if ($calendarAccount['type'] == 'day') {
    				
    				if (is_array($services)) {
    					
    					foreach ((array) $services as $key => $service) {
    						
    						$amount += intval($service['cost']);
    						foreach ((array) $service['options'] as $option) {
    							
    							if (intval($option['selected']) == 1) {
    								
    								$amount += intval($option['cost']);
    								
    							}
    							
    						}
    						
    					}
    					
    				}
    				$amount = $this->formatCost($amount, $currency);
    				
    			} else {
    				
    				$amount = $this->formatCost((intval($accommodationDetails['accommodationFee']) + intval($accommodationDetails['taxesFee']) + intval($accommodationDetails['additionalFee'])), $currency);
    				
    			}
    			
    			$emailBody = preg_replace('/(\[totalPaymentAmount\])/', $amount, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[cancellationUri\])/', $emailBody, $matches)) {
    			
    			if (intval($calendarAccount['cancellationOfBooking']) == 1 && !is_null($cancellationUri)) {
    				
    				$emailBody = preg_replace('/(\[cancellationUri\])/', $cancellationUri, $emailBody);
    				
    			} else {
    				
    				$emailBody = preg_replace('/(\[cancellationUri\])/', "", $emailBody);
    				
    			}
    			
    		}
    		
    		if (preg_match('/(\[guests\])/', $emailBody, $matches)) {
    			
    			$guestsDetails = array();
    			$guestsList = $accommodationDetails['guestsList'];
    			foreach ((array) $guestsList as $key => $value) {
    				
    				$name = $value['name'];
    				$guests = $value['json'];
    				for($i = 0; $i < count($guests); $i++){
    					
    					if (intval($guests[$i]['selected']) == 1) {
    						
    						array_push($guestsDetails, $name.": ".$guests[$i]['name']);
    						break;
    						
    					}
    					
    				}
    				
    			}
    			$guestsDetails = implode("\n", $guestsDetails);
    			$emailBody = preg_replace('/(\[guests\])/', $guestsDetails, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[surcharges\])/', $emailBody, $matches)) {
    			
    			$surchargesDetails = array();
    			$surcharges = $accommodationDetails['taxes'];
    			#foreach ((array) $surcharges as $key => $tax) {
    			for ($i = 0; $i < count($surcharges); $i++) {
    				
    				$tax = $surcharges[$i];
    				if ($tax['type'] == 'surcharge' && $tax['active'] == 'true') {
    					
    					$cost = $this->formatCost($tax['taxValue'], $currency);
    					array_push($surchargesDetails, $tax['name'] . ' ' . $cost);
    					
    				}
    				
    			}
    			$surchargesDetails = implode("\n", $surchargesDetails);
    			$emailBody = preg_replace('/(\[surcharges\])/', $surchargesDetails, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[taxes\])/', $emailBody, $matches)) {
    			
    			$taxesDetails = array();
    			$taxes = $accommodationDetails['taxes'];
    			#foreach ((array) $taxes as $key => $tax) {
    			for ($i = 0; $i < count($taxes); $i++) {
    				
    				$tax = $taxes[$i];
    				if ($tax['type'] == 'tax' && $tax['active'] == 'true') {
    					
    					$cost = $this->formatCost($tax['taxValue'], $currency);
    					array_push($taxesDetails, $tax['name'] . ' ' . $cost);
    					
    				}
    				
    			}
    			$taxesDetails = implode("\n", $taxesDetails);
    			$emailBody = preg_replace('/(\[taxes\])/', $taxesDetails, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[id\])/', $emailBody, $matches)) {
    			
    			$emailBody = preg_replace('/(\[id\])/', $bookingID, $emailBody);
    			
    		}
    		
    		if (preg_match('/(\[site_name\])/', $emailBody, $matches)) {
    			
    			$emailBody = preg_replace('/(\[site_name\])/', $site_name, $emailBody);
    			
    		}
    		
    		if (!is_null($services)) {
    			
    			if (preg_match('/(\[service\])/', $emailBody, $matches)) {
    				#var_dump($services);
    				if (is_array($services)) {
    					
    					$detailsList = array();
    					foreach ((array) $services as $key => $service) {
    						
	    					if (intval($service['cost']) > 0) {
	    						
	    						array_push($detailsList, $service['name']." ".$this->formatCost($service['cost'], $currency));
	    						
	    					} else {
	    						
	    						array_push($detailsList, $service['name']);
	    						
	    					}
	    					
	    					$no = 0;
	    					foreach ((array) $service['options'] as $option) {
	    						
	    						if (intval($option['selected']) == 1) {
	    							
	    							$no++;
	    							$details = "#".$no." ".$option['name']." ";
	    							if (intval($option['cost']) > 0) {
	    								
	    								$details .= $this->formatCost($option['cost'], $currency);
	    								
	    							}
	    							array_push($detailsList, $details);
	    							
	    						}
	    						
	    					}
    						
    					}
    					
    					$emailBody = preg_replace('/(\[service\])/', implode("\n", $detailsList), $emailBody);
    					
    				} else {
    					
    					$emailBody = preg_replace('/(\[service\])/', $service, $emailBody);
    					
    				}
    				
    			}
    			
    		}
    		
    		
    		
    		$visitorEmail = array();
    		$content = "";
    		for($i = 0; $i < count($form); $i++){
    			
    			
    			if ($emailFormat == "text") {
    				
    				$content .= $form[$i]->name."\r\n".$form[$i]->value."\r\n";
    				
    			} else {
    				
    				$content .= '<div style="width: 100%; display: table;"><div style="width: 30%; display: table-cell; vertical-align: middle;">'.$form[$i]->name.'</div><div style="width: 70%; display: table-cell; vertical-align: middle;">'.$form[$i]->value.'</div></div>';
    				#$content .= '<div style="width: 30%; display: table-cell; vertical-align: middle;">'.$form[$i]->name.'</div><div style="width: 70%; display: table-cell; vertical-align: middle;">'.$form[$i]->value.'</div>';
    				
    			}
    			
    			if ($form[$i]->isEmail == 'true') {
    				
    				array_push($visitorEmail, $form[$i]->value);
    				
    			}
    			
    		}
    		
    		if (preg_match('/(\[content\])/', $emailBody, $matches)) {
    			
    			$emailBody = preg_replace('/(\[content\])/', $content, $emailBody);
    			
    		}
    		
    		for($i = 0; $i < count($form); $i++){
    			
    			$id = '\['.$form[$i]->id.'\]';
    			#$value = $form[$i]->name."\n".$form[$i]->value."\n";
    			$value = $form[$i]->value."";
    			if (preg_match('/('.$id.')/', $emailBody, $matches)) {
    				
    				$emailBody = preg_replace('/('.$id.')/', $value, $emailBody);
    			
    			}
    			
    		}
    		
    		
    		
    		$headers = array("From: ".$from."\r\n", "Return-Path: ".$from."\r\n", "Reply-To: ".$from."\r\n");
    		
    		if($emailFormat == "text"){
    			
    			$emailBody = strip_tags($emailBody);
    			
    		}else{
    			
    			array_push($headers, "Content-Type: text/html; charset=UTF-8");
    			$bodyStyle = 'word-wrap: break-word; white-space: pre;';
    			$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    			$header .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Booking email</title></head>';
    			$header .= '<body style="'.$bodyStyle.'">';
    			$emailBody = $header.$emailBody."</body></html>";
    			
    		}
    		
    		$responseList = array('body' => $emailBody, 'to' => $to, 'from' => $from, 'sendVisitor' => $sendVisitor, 'headers' => $headers, 'visitorEmail' => $visitorEmail, 'response' => array(), 'params' => array());
    		
    		if (function_exists('mb_language')) {
    			
    			mb_language("uni");
    			
    		}
    		
    		if (function_exists('mb_internal_encoding')) {
    			
    			mb_internal_encoding("UTF-8");
    			
    		}
    		
    		$mailgun_active = intval(get_option($this->prefix."mailgun_active", 0));
    		if($mailgun_active == 1){
    			
    			$mailgun_aip_base_url = get_option($this->prefix."mailgun_aip_base_url", 0);
    			$mailgun_api_key = get_option($this->prefix."mailgun_api_key", 0);
    			//$mailgun_password = get_option($this->prefix."mailgun_password", 0);
    			#var_dump($mailgun_api_key);
    			
    			$params = array('from' => $from, 'to' => implode(",", $visitorEmail), 'subject' => $emailSubject);
    			if($emailFormat == "text"){
					
					$params['text'] = $emailBody;
					
				}else{
					
					$params['html'] = $emailBody;
					
				}
				$responseList['params']['visitor'] = $params;
    			if(count($visitorEmail) != 0){
    				
					$paramsQuery = http_build_query($params);
					#$params = json_encode($params);
					$context = array(
						'http' => array(
							'method' => 'POST', 
							'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
							"Content-Length: ".strlen($paramsQuery)."\r\n".
							"User-Agent: PHP\r\n".
							"Host: api.mailgun.net\r\n".
							"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
							'content' => $paramsQuery
						)
					);
					
					$context = stream_context_create($context);
					$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
					$responseList['response']['visitor'] = $response;
					
    			}
    			
    			$params['to'] = $to;
    			$responseList['params']['admin'] = $params;
    			$paramsQuery = http_build_query($params);
				$context = array(
					'http' => array(
						'method' => 'POST', 
						'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
						"Content-Length: ".strlen($paramsQuery)."\r\n".
						"User-Agent: PHP\r\n".
						"Host: api.mailgun.net\r\n".
						"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
						'content' => $paramsQuery
					)
				);
				
				$context = stream_context_create($context);
				$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
				$responseList['response']['admin'] = $response;
				
				if (!empty($calendarAccount['email_to'])) {
					
					$params['to'] = $calendarAccount['email_to'];
					$responseList['params']['calendarAccount'] = $params;
	    			$paramsQuery = http_build_query($params);
					$context = array(
						'http' => array(
							'method' => 'POST', 
							'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
							"Content-Length: ".strlen($paramsQuery)."\r\n".
							"User-Agent: PHP\r\n".
							"Host: api.mailgun.net\r\n".
							"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
							'content' => $paramsQuery
						)
					);
					
					$context = stream_context_create($context);
					$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
					$responseList['response']['calendarAccount'] = $response;
					
				}
    			
    		}else{
    			
    			$sendVisitor = false;
    			if(count($visitorEmail) != 0){
    				
    				$sendVisitor = wp_mail($visitorEmail, $emailSubject, $emailBody, $headers);
    				$responseList['sendVisitor'] = $sendVisitor;
    				
    			}
    			
    			$sendControl = wp_mail($to, $emailSubject, $emailBody, $headers);
    			$responseList['sendControl'] = $sendControl;
    			
    			if (!empty($calendarAccount['email_to'])) {
    				
    				$sendAccount = wp_mail($calendarAccount['email_to'], $emailSubject, $emailBody, $headers);
    				$responseList['sendAccount'] = $sendAccount;
    				
    			}
    			
    		}
    		
    		$responseList['mailgun_active'] = $mailgun_active;
    		**/
    		
    		
    		return $responseList;
    		
    	}
    	
    	public function sendMail($user_email, $subject, $body, $emailFormat = 'text', $accountKey = null){
    		
    		$to = get_option($this->prefix."email_to", null);
    		$from = $this->emailFormat(get_option($this->prefix."email_from", null), get_option($this->prefix."email_title_from", null));
    		
    		if (!is_null($accountKey)) {
    			
    			$calendarAccount = $this->getCalendarAccount($accountKey);
    			if (!empty($calendarAccount['email_to'])) {
    				
    				$to = $calendarAccount['email_to'];
    				
    			}
    			
    			if (!empty($calendarAccount['email_from'])) {
    				
    				$to = $calendarAccount['email_from'];
    				$from = $this->emailFormat($calendarAccount['email_from'], $calendarAccount['email_from_title']);
    				
    			}
    			
    		}
    		
    		
    		$headers = array("From: ".$from."\r\n", "Return-Path: ".$from."\r\n", "Reply-To: ".$from."\r\n");
    		$responseList = array('body' => $body, 'to' => $to, 'from' => $from, 'sendVisitor' => $sendVisitor, 'headers' => $headers, 'visitorEmail' => $visitorEmail, 'response' => array(), 'params' => array());
    		
    		if (function_exists('mb_language')) {
    			
    			mb_language("uni");
    			
    		}
    		
    		if (function_exists('mb_internal_encoding')) {
    			
    			mb_internal_encoding("UTF-8");
    			
    		}
    		
    		$emailFormat = get_option($this->prefix."mail_approved_format", null);
    		$mailgun_active = intval(get_option($this->prefix."mailgun_active", 0));
    		if($mailgun_active == 1){
    			
    			$mailgun_aip_base_url = get_option($this->prefix."mailgun_aip_base_url", 0);
    			$mailgun_api_key = get_option($this->prefix."mailgun_api_key", 0);
    			//$mailgun_password = get_option($this->prefix."mailgun_password", 0);
    			#var_dump($mailgun_api_key);
    			
    			$params = array('from' => $from, 'to' => $user_email, 'subject' => $subject);
    			if($emailFormat == "text"){
					
					$body = strip_tags($body);
					$params['text'] = $body;
					
				}else{
					
					array_push($headers, "Content-Type: text/html; charset=UTF-8");
	    			$bodyStyle = 'word-wrap: break-word; white-space: pre;';
	    			$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	    			$header .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Booking email</title></head>';
	    			$header .= '<body style="'.$bodyStyle.'">';
	    			$body = $header.$body."</body></html>";
					$params['html'] = $body;
					
				}
				$responseList['params']['visitor'] = $params;
    			$paramsQuery = http_build_query($params);
				#$params = json_encode($params);
				$context = array(
					'http' => array(
						'method' => 'POST', 
						'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
						"Content-Length: ".strlen($paramsQuery)."\r\n".
						"User-Agent: PHP\r\n".
						"Host: api.mailgun.net\r\n".
						"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
						'content' => $paramsQuery
					)
				);
				
				$context = stream_context_create($context);
				$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
				#var_dump($response);
				$responseList['response']['visitor'] = $response;
    			
    			
    		}else{
    			
    			$sendVisitor = false;
    			$sendVisitor = wp_mail($user_email, $subject, $body, $headers);
    			$responseList['sendVisitor'] = $sendVisitor;
    			
    		}
    		
    		$responseList['mailgun_active'] = $mailgun_active;
    		return $responseList;
    		
    	}
    	
    	public function scriptError($errors){
    		
    		
    		$url = BOOKING_PACKAGE_EXTENSION_URL;
    		$response = array('status' => 'success', 'url' => $url);
    		
			$params = array(
				'mode' => 'scriptError',
				'type' => sanitize_text_field($errors['type']), 
				'url' => sanitize_text_field($errors['url']), 
				'file' => sanitize_text_field($errors['file']), 
				'msg' => sanitize_text_field($errors['msg']),
				'line' => sanitize_text_field($errors['line']), 
				'col' => sanitize_text_field($errors['col']),
				'version' => sanitize_text_field($errors['version']),
				'code' => sanitize_text_field($errors['code']),
				'browser' => sanitize_text_field($errors['browser']),
				'page' => $errors['page'],
				'error' => $errors['error'],
			);
			
			if (isset($errors['responseText'])) {
				
				$params['responseText'] = $errors['responseText'];
				
			}
			
			if (isset($params['message'])) {
				
				$params['msg'] = sanitize_text_field($errors['message']);
				
			}
			
			if (isset($errors['name'])) {
				
				$params['name'] = sanitize_text_field($errors['name']);
				
			}
			
			if (isset($errors['values'])) {
				
				$params['values'] = sanitize_text_field($errors['values']);
				
			}
			
			if (intval($params['line']) > 0 && empty($params['file']) === false) {
				
				$response['params'] = $params;
				
				$ch = curl_init();
	        	curl_setopt($ch, CURLOPT_URL, "https://saasproject.net/lib/scriptError.php");
	        	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	        	curl_setopt($ch, CURLOPT_POST, 1);
	        	
	        	ob_start();
	        	$response = curl_exec($ch);
	        	$response = ob_get_contents();
	        	ob_end_clean();
	        	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        	curl_close ($ch);
	        	$response = json_decode($response, true);
				
			}
			
    		return $params;
    		
    	}
    	
    	public function changeMaxAccountScheduleDay(){
    		
			global $wpdb;
			$maxAccountScheduleDay = get_option($this->prefix."maxAccountScheduleDay", 14);
			$unavailableDaysFromToday = get_option($this->prefix."unavailableDaysFromToday", 1);
			
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
			#$sql = $wpdb->prepare("SELECT * FROM `".$table_name."`;", array());
			$rows = $wpdb->get_results("SELECT * FROM `".$table_name."`;", ARRAY_A);
			foreach ((array) $rows as $row) {
				
				$bool = $wpdb->update(
					$table_name,
					array(
						'maxAccountScheduleDay' => intval($maxAccountScheduleDay),
						'unavailableDaysFromToday' => intval($unavailableDaysFromToday),
					),
					array('key' => intval($row['key'])),
					array('%d', '%d'),
					array('%d')
				);
				
			}
    		
    	}
        
        
    }
    
    
    
    
    
    
?>