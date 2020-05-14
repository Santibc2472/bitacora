<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemProtect {
  
    function __construct(){
    }
  
    function show($string){
        global $ABookingSystem;
        
        $string = $this->decode($ABookingSystem['key_one'], $string);
        $string = $this->decode($ABookingSystem['key_two'], $string);
        $string = $this->decode($ABookingSystem['key_three'], $string);
        $string = $this->decode($ABookingSystem['key_four'], $string);
      
        return $string;
    }
  
    function hide($string){
        global $ABookingSystem;
        
        $string = $this->encode($ABookingSystem['key_one'], $string);
        $string = $this->encode($ABookingSystem['key_two'], $string);
        $string = $this->encode($ABookingSystem['key_three'], $string);
        $string = $this->encode($ABookingSystem['key_four'], $string);
      
        return $string;
    }
  
    function encode( $key, $string ){	
        
        if(function_exists('mcrypt_encrypt')) {
            return rawurlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))))); 
        } else {
            return $this->encrypt_decrypt('encrypt', $string, $key);
        }
    }
  
    function decode( $key, $string ){	
        
        if(function_exists('mcrypt_decrypt')) {
            return rawurldecode( rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(rawurldecode($string)), MCRYPT_MODE_CBC, md5(md5($key))), "\0")); 
        } else {
            return $this->encrypt_decrypt('decrypt', $string, $key);
        }
    }
    
    function encrypt_decrypt($action, $string, $key) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = $key;
        $secret_iv = 'khj43jk334l34hj3663@@%@&*@HHGF@D@JKNKVHQAVC2336732ghsd263';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
  
    function post($data, 
                  $type = 'text',
                  $default = ''){
      
        if($type == 'json') {
            $value = filter_input(INPUT_POST, $data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        } else {
            $value = filter_input(INPUT_POST, $data, FILTER_SANITIZE_STRING);
        }
          
        return $this->clean_data($value, $type, $default);
    }
  
    function get($data, 
                 $type = 'text',
                 $default = ''){
      
        if($type == 'json') {
            $value = filter_input(INPUT_GET, $data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        } else {
            $value = filter_input(INPUT_GET, $data, FILTER_SANITIZE_STRING);
        }
          
        return $this->clean_data($value, $type, $default);
    }
  
    function server($data, 
                    $type = 'text',
                    $default = ''){
      
        if($data == 'HTTP_TOKEN') {
            $headers = apache_request_headers();
            $value = isset($headers['Token']) ? $headers['Token']:'';
            $value = filter_var($value, FILTER_SANITIZE_STRING);
        } else {
            if($type == 'json') {
                $value = filter_input(INPUT_SERVER, $data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            } else {
                $value = filter_input(INPUT_SERVER, $data, FILTER_SANITIZE_STRING);

                if($value == '') {
                    $value = $this->filter_server($data, FILTER_SANITIZE_STRING);
                }
            }
        }
          
        return $this->clean_data($value, $type, $default);
    }
  
    function globals($data, 
                     $type = 'text',
                     $default = ''){
        $value = $this->filter_globals($data, FILTER_SANITIZE_STRING);
          
        return $this->clean_data($value, $type, $default);
    }
  
    function cookie($data, 
                    $type = 'text',
                    $default = ''){
      
        if($type == 'json') {
            $value = filter_input(INPUT_COOKIE, $data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        } else {
            $value = filter_input(INPUT_COOKIE, $data, FILTER_SANITIZE_STRING);
        }
          
        return $this->clean_data($value, $type, $default);
    }
  
    function env($data, 
                 $type = 'text',
                 $default = ''){
      
        if($type == 'json') {
            $value = filter_input(INPUT_ENV, $data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        } else {
            $value = filter_input(INPUT_ENV, $data, FILTER_SANITIZE_STRING);
        }
          
        return $this->clean_data($value, $type, $default);
    }
  
    function data($value, 
                  $type = 'text',
                  $default = ''){
      
        if($type == 'json') {
            $value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        } else {
            $value = filter_var($value, FILTER_SANITIZE_STRING);
        }
          
        return $this->clean_data($value, $type, $default);
    }
  
    function ip(){
        
        if ($this->server('HTTP_CLIENT_IP') != '') {
            $ip = $this->server('HTTP_CLIENT_IP');
        } elseif ($this->server('HTTP_X_FORWARDED_FOR') != '') {
            $ip = $this->server('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->server('REMOTE_ADDR');
        }
      
        return $ip;
    }
    
    function filter_globals($value, $filter){
        
        if(isset($GLOBALS[$value])) {
            return filter_var($GLOBALS[$value], $filter);
        } else {
            return '';
        }
    }
    
    function filter_server($value, $filter){
        
        if(isset($_SERVER[$value])) {
            return filter_var($_SERVER[$value], $filter);
        } else {
            return '';
        }
    }
  
    function clean_data($value, 
                  $type = 'text',
                  $default = ''){
        global $ABookingSystem;
      
        $value = !isset($value) ? $default:$value;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            
            switch($type) {
              case 'text':
                $value = ($value != FALSE && $value != NULL) ? sanitize_text_field($value):$default;
                break;
              case 'email':
                $value = ($value != FALSE && $value != NULL) ? sanitize_email($value):$default;
                break;
              case 'title':
                $value = ($value != FALSE && $value != NULL) ? sanitize_title($value):$default;
                break;
              case 'url':
                $value = ($value != FALSE && $value != NULL) ? preg_replace("(^https?://)", "", esc_url($value)):$default;
                break;
              case 'id':
                $value = ($value != FALSE && $value != NULL) ? absint($value):$default;
                break;
              case 'int':
                $value = ($value != FALSE && $value != NULL) ? intval($value):$default;
                break;
              case 'float':
                $value = ($value != FALSE && $value != NULL) ? floatval($value):$default;
                break;
              default:
                $value = ($value != FALSE && $value != NULL) ? sanitize_text_field($value):$default;
                break;
            }
        }
      
        return $value;
      
    }

}