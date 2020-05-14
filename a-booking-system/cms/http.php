<?php
if (!defined('ABSPATH')) exit;

/*
 * Create HTTP Requests
 */
class ABookingSystemHTTP {
  
    function __construct(){
    }
    
    function get($url, $path, $fields = array(), $headers = array(), $type = 'form'){
        $url = $url.$path;
        $url = add_query_arg($fields, $url);
        
        $reqHeaders = array('Content-type' => $type == 'form' ? 'application/x-www-form-urlencoded':'application/json');
        
        $args = array(
            'method' => 'GET'
        );
        
        if(!empty($headers)
            && isset($headers['token'])) {
            $reqHeaders['Token'] = $headers['token'];
        }
        
        if(!empty($headers)
            && isset($headers['username'])
            && isset($headers['password'])) {
            $reqHeaders['Authorization'] = 'Basic ' . base64_encode($headers['username'].':'.$headers['password']);
        }
            
        $args['headers'] = $reqHeaders;
        
        $response = wp_remote_request( $url, $args );
        
        return $this->response($response);
    }
    
    function post($url, $path, $fields = array(), $headers = array(), $type = 'form'){
        $url = $url.$path;
        
        $reqHeaders = array('Content-type' => $type == 'form' ? 'application/x-www-form-urlencoded':'application/json');
        
        $args = array(
            'method' => 'POST',
            'body' => $type == 'form' ? $fields:json_encode($fields)
        );
        
        if(!empty($headers)
            && isset($headers['token'])) {
            $reqHeaders['Token'] = $headers['token'];
        }
        
        if(!empty($headers)
            && isset($headers['username'])
            && isset($headers['password'])) {
            $reqHeaders['Authorization'] = 'Basic ' . base64_encode($headers['username'].':'.$headers['password']);
        }
            
        $args['headers'] = $reqHeaders;
        
        $response = wp_remote_request( $url, $args );
        
        return $this->response($response);
    }
    
    function put($url, $path, $fields = array(), $headers = array(), $type = 'form'){
        $url = $url.$path;
        
        $reqHeaders = array('Content-type' => $type == 'form' ? 'application/x-www-form-urlencoded':'application/json');
        
        $args = array(
            'method' => 'PUT',
            'body' => $type == 'form' ? $fields:json_encode($fields)
        );
        
        if(!empty($headers)
            && isset($headers['token'])) {
            $reqHeaders['Token'] = $headers['token'];
        }
        
        if(!empty($headers)
            && isset($headers['username'])
            && isset($headers['password'])) {
            $reqHeaders['Authorization'] = 'Basic ' . base64_encode($headers['username'].':'.$headers['password']);
        }
            
        $args['headers'] = $reqHeaders;
        
        $response = wp_remote_request( $url, $args );
        
        return $this->response($response);
    }
    
    function delete($url, $path, $fields = array(), $headers = array(), $type = 'json'){
        $url = $url.$path;
        
        $reqHeaders = array('Content-type' => $type == 'form' ? 'application/x-www-form-urlencoded':'application/json');
        
        $args = array(
            'method' => 'DELETE',
            'body' => $type == 'form' ? $fields:json_encode($fields)
        );
        
        if(!empty($headers)
            && isset($headers['token'])) {
            $reqHeaders['Token'] = $headers['token'];
        }
        
        if(!empty($headers)
            && isset($headers['username'])
            && isset($headers['password'])) {
            $reqHeaders['Authorization'] = 'Basic ' . base64_encode($headers['username'].':'.$headers['password']);
        }
            
        $args['headers'] = $reqHeaders;
        
        $response = wp_remote_request( $url, $args );
        
        return $this->response($response);
    }
    
    function response($response){
        $new_response = new stdClass;
        
        $new_response->code = wp_remote_retrieve_response_code($response);
        $new_response->response = wp_remote_retrieve_body($response);
        
        return $new_response;
    }
}