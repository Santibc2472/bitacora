<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/class-email.php
* File Version            : 1.0.9
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Notifications PHP class.
*/
    
    if (!class_exists('DOPBSPNotifications')){
        class DOPBSPNotifications{
            /* 
             * SETTINGS_NOTIFICATIONS_TEST_MAIL_SUBJECT
             * SETTINGS_NOTIFICATIONS_TEST_MAIL_MESSAGE
             * SETTINGS_NOTIFICATIONS_TEST_MAILER_SUBJECT
             * SETTINGS_NOTIFICATIONS_TEST_MAILER_MESSAGE
             * SETTINGS_NOTIFICATIONS_TEST_SMTP_SUBJECT
             * SETTINGS_NOTIFICATIONS_TEST_SMTP_MESSAGE
             * SETTINGS_NOTIFICATIONS_TEST_SMTP2_SUBJECT
             * SETTINGS_NOTIFICATIONS_TEST_SMTP2_MESSAGE
             * SETTINGS_NOTIFICATIONS_TEST_WP_SUBJECT
             * SETTINGS_NOTIFICATIONS_TEST_WP_MESSAGE
            */
            
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Send email.
             * 
             * @param email_to (string): receiver email
             * @param email_from (string): sender email
             * @param email_reply (string): sender reply email
             * @param email_name (string): sender name
             * @param email_cc (string): cc emails
             * @param email_cc_name (string): cc names
             * @param email_bcc (string): bcc emails
             * @param email_bcc_name (string): bcc names
             * @param subject (string): email subject
             * @param message (string): email message
             * @param smtp_host_name (string): SMTP host name
             * @param smtp_host_port (string): SMTP host port
             * @param smtp_ssl (string): SMTP use secure authentication SSL
             * @param smtp_tls (string): SMTP use secure authentication TLS
             * @param smtp_user (string): SMTP user authentication
             * @param smtp_password (string): SMTP password authentication
             * @param smtp_host_name2 (string): second SMTP host name
             * @param smtp_host_port2 (string): second SMTP host port
             * @param smtp_ssl2 (string): second SMTP use secure authentication SSL
             * @param smtp_tls2 (string): second SMTP use secure authentication TLS
             * @param smtp_user2 (string): second SMTP user authentication
             * @param smtp_password2 (string): second SMTP password authentication
             * @param method (string): the method used to send the email
             *                         "mail" send email with PHP mail function
             *                         "mailer" send email with Mailer
             *                         "smtp" send email with SMTP
             *                         "smtp2" send email with SMTP
             *                         "wp" send email with WordPress mail function
             * @param is_test (boolean): check if the email is sent for testing purposes
             */
            function send($email_to,
                          $email_from,
                          $email_reply,
                          $email_name,
                          $email_cc,
                          $email_cc_name,
                          $email_bcc,
                          $email_bcc_name,
                          $subject,
                          $message,
                          $smtp_host_name = '',
                          $smtp_host_port = 25,
                          $smtp_ssl = 'false',
                          $smtp_tls = 'false',
                          $smtp_user = '',
                          $smtp_password = '',
                          $smtp_host_name2 = '',
                          $smtp_host_port2 = 25,
                          $smtp_ssl2 = 'false',
                          $smtp_tls2 = 'false',
                          $smtp_user2 = '',
                          $smtp_password2 = '',
                          $method = 'mailer',
                          $is_test = false){
                $email_reply = $email_reply == '' ? $email_from:$email_reply;
                $email_name = $email_name == '' ? $email_reply:$email_name;
                
                switch ($method){
                    case 'mail':
                        $this->sendMail($email_to,
                                        $email_from,
                                        $email_reply,
                                        $email_name,
                                        $email_cc,
                                        $email_cc_name,
                                        $email_bcc,
                                        $email_bcc_name,
                                        $subject,
                                        $message,
                                        $is_test);
                        break;
                    case 'smtp':
                        $this->sendSMTP($email_to,
                                        $email_from,
                                        $email_reply,
                                        $email_name,
                                        $email_cc,
                                        $email_cc_name,
                                        $email_bcc,
                                        $email_bcc_name,
                                        $subject,
                                        $message,
                                        $smtp_host_name,
                                        $smtp_host_port,
                                        $smtp_ssl,
                                        $smtp_tls,
                                        $smtp_user,
                                        $smtp_password,
                                        $is_test);
                        break;
                    case 'smtp2':
                        $this->sendSMTP($email_to,
                                        $email_from,
                                        $email_reply,
                                        $email_name,
                                        $email_cc,
                                        $email_cc_name,
                                        $email_bcc,
                                        $email_bcc_name,
                                        $subject,
                                        $message,
                                        $smtp_host_name2,
                                        $smtp_host_port2,
                                        $smtp_ssl2,
                                        $smtp_tls2,
                                        $smtp_user2,
                                        $smtp_password2,
                                        $is_test);
                        break;
                    case 'wp':
                        $this->sendWPMail($email_to,
                                          $email_from,
                                          $email_reply,
                                          $email_name,
                                          $email_cc,
                                          $email_cc_name,
                                          $email_bcc,
                                          $email_bcc_name,
                                          $subject,
                                          $message,
                                          $is_test);
                        break;
                    default:
                        $this->sendMailer($email_to,
                                          $email_from,
                                          $email_reply,
                                          $email_name,
                                          $email_cc,
                                          $email_cc_name,
                                          $email_bcc,
                                          $email_bcc_name,
                                          $subject,
                                          $message,
                                          $is_test);
                }
            }
            
            /*
             * Send email with PHP mail function.
             * 
             * @param email_to (string): receiver email
             * @param email_from (string): sender email
             * @param email_reply (string): sender reply email
             * @param email_name (string): sender name
             * @param email_cc (string): cc emails
             * @param email_cc_name (string): cc names
             * @param email_bcc (string): bcc emails
             * @param email_bcc_name (string): bcc names
             * @param subject (string): email subject
             * @param message (string): email message
             * @param is_test (boolean): check if the email is sent for testing purposes
             */
            function sendMail($email_to,
                              $email_from,
                              $email_reply,
                              $email_name,
                              $email_cc,
                              $email_cc_name,
                              $email_bcc,
                              $email_bcc_name,
                              $subject,
                              $message,
                              $is_test = false){    
                global $DOPBSP;
                            
                $headers = array();
                $headers_cc = array();
                $headers_bcc = array();
                
                /*
                 * Add Cc addresses.
                 */
                $emails_cc = explode(',', $email_cc);
                $emails_cc_name = explode(',', $email_cc_name);
                
                for ($i=0; $i<count($emails_cc); $i++){
                    array_push($headers_cc, $emails_cc_name[$i].(isset($emails_cc[$i]) ? ' <'.$emails_cc[$i].'>':''));
                }
                
                /*
                 * Add Bcc addresses.
                 */
                $emails_bcc = explode(',', $email_bcc);
                $emails_bcc_name = explode(',', $email_bcc_name);
                
                for ($i=0; $i<count($emails_bcc); $i++){
                    array_push($headers_bcc, $emails_bcc_name[$i].(isset($emails_bcc[$i]) ? ' <'.$emails_bcc[$i].'>':''));
                }
                
                array_push($headers, 'Content-type: text/html; charset=utf-8'."\r\n");
                array_push($headers, 'MIME-Version: 1.1'."\r\n");
                array_push($headers, 'From: '.$email_name.' <'.$email_from.'>'."\r\n");
                array_push($headers, 'Reply-To: '.$email_name.' <'.$email_reply.'>'."\r\n");
                array_push($headers, 'Cc: '.implode(',', $headers_cc)."\r\n");
                array_push($headers, 'Bcc: '.implode(',', $headers_bcc));
        
                if (!mail($email_to, $subject, $message, implode('', $headers))){
                    if ($is_test){
                        echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_ERROR');
                        die();
                    }
                }
                else{
                    if ($is_test){
                        echo 'success';
                        die();
                    }
                }
            }
            
            /*
             * Send email with Mailer.
             * 
             * @param email_to (string): receiver email
             * @param email_from (string): sender email
             * @param email_reply (string): sender reply email
             * @param email_name (string): sender name
             * @param email_cc (string): cc emails
             * @param email_cc_name (string): cc names
             * @param email_bcc (string): bcc emails
             * @param email_bcc_name (string): bcc names
             * @param subject (string): email subject
             * @param message (string): email message
             * @param is_test (boolean): check if the email is sent for testing purposes
             */
            function sendMailer($email_to,
                                $email_from,
                                $email_reply,
                                $email_name,
                                $email_cc,
                                $email_cc_name,
                                $email_bcc,
                                $email_bcc_name,
                                $subject,
                                $message,
                                $is_test = false){
                global $DOPBSP;
                
                $php_mailer = new PHPMailer();
                
                $php_mailer->CharSet = 'utf-8';
                $php_mailer->isMail();
                
                /*
                 * Add email address.
                 */
                $php_mailer->addAddress($email_to);
                
                /*
                 * Add Cc addresses.
                 */
                $emails_cc = explode(',', $email_cc);
                $emails_cc_name = explode(',', $email_cc_name);
                
                for ($i=0; $i<count($emails_cc); $i++){
                    $php_mailer->addCC($emails_cc[$i], isset($emails_cc_name[$i]) ? $emails_cc_name[$i]:'');
                }
                
                /*
                 * Add Bcc addresses.
                 */
                $emails_bcc = explode(',', $email_bcc);
                $emails_bcc_name = explode(',', $email_bcc_name);
                
                for ($i=0; $i<count($emails_bcc); $i++){
                    $php_mailer->addBCC($emails_bcc[$i], isset($emails_bcc_name[$i]) ? $emails_bcc_name[$i]:'');
                }
                
                $php_mailer->From = $email_from;
                $php_mailer->FromName = $email_name;
                $php_mailer->addReplyTo($email_reply);
                $php_mailer->isHTML(true);

                $php_mailer->Subject = $subject;
                $php_mailer->Body = $message;

                if (!$php_mailer->send()){
                    if ($is_test){
                        echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_ERROR').'<br />';
                        echo 'Mailer error: '.$php_mailer->ErrorInfo.'<br />';
                        echo $php_mailer->ErrorInfo;
                        die();
                    }
                    else{
                        $this->sendWPMail($email_to,
                                          $email_from,
                                          $email_reply,
                                          $email_name,
                                          $email_cc,
                                          $email_cc_name,
                                          $email_bcc,
                                          $email_bcc_name,
                                          $subject,
                                          $message);
                    }
                }
                else{
                    if ($is_test){
                        echo 'success';
                        die();
                    }
                }
            }
            
            /*
             * Send email with SMTP.
             * 
             * @param email_to (string): receiver email
             * @param email_from (string): sender email
             * @param email_reply (string): sender reply email
             * @param email_name (string): sender name
             * @param email_cc (string): cc emails
             * @param email_cc_name (string): cc names
             * @param email_bcc (string): bcc emails
             * @param email_bcc_name (string): bcc names
             * @param subject (string): email subject
             * @param message (string): email message
             * @param smtp_host_name (string): SMTP host name
             * @param smtp_host_port (string): SMTP host port
             * @param smtp_ssl (string): SMTP use secure authentication SSL
             * @param smtp_ssl (string): SMTP use secure authentication TLS
             * @param smtp_user (string): SMTP user authentication
             * @param smtp_password (string): SMTP password authentication
             * @param is_test (boolean): check if the email is sent for testing purposes
             */
            function sendSMTP($email_to,
                              $email_from,
                              $email_reply,
                              $email_name,
                              $email_cc,
                              $email_cc_name,
                              $email_bcc,
                              $email_bcc_name,
                              $subject,
                              $message,
                              $smtp_host_name = '',
                              $smtp_host_port = 25,
                              $smtp_ssl = 'false',
                              $smtp_tls = 'false',
                              $smtp_user = '',
                              $smtp_password = '',
                              $is_test = false){
                global $DOPBSP;
                
                $php_mailer = new PHPMailer();
                
                $php_mailer->CharSet = 'UTF-8';
                $php_mailer->isSMTP();
                $php_mailer->Host = $smtp_host_name;
                $php_mailer->Port = $smtp_host_port;
                $php_mailer->SMTPAuth = true;
                
                if ($smtp_ssl == 'true'){
                    $php_mailer->SMTPSecure = 'ssl';
                }
                else if ($smtp_tls == 'true'){
                    $php_mailer->SMTPSecure = 'tls';
                }
                else{
                    $php_mailer->SMTPSecure = '';
                }
                $php_mailer->Username = $smtp_user;
                $php_mailer->Password = $smtp_password;
                
                /*
                 * Add email address.
                 */
                $php_mailer->addAddress($email_to);
                
                /*
                 * Add Cc addresses.
                 */
                $emails_cc = explode(',', $email_cc);
                $emails_cc_name = explode(',', $email_cc_name);
                
                for ($i=0; $i<count($emails_cc); $i++){
                    $php_mailer->addCC($emails_cc[$i], isset($emails_cc_name[$i]) ? $emails_cc_name[$i]:'');
                }
                
                /*
                 * Add Bcc addresses.
                 */
                $emails_bcc = explode(',', $email_bcc);
                $emails_bcc_name = explode(',', $email_bcc_name);
                
                for ($i=0; $i<count($emails_bcc); $i++){
                    $php_mailer->addBCC($emails_bcc[$i], isset($emails_bcc_name[$i]) ? $emails_bcc_name[$i]:'');
                }
                
                $php_mailer->From = $email_from;
                $php_mailer->FromName = $email_name;
                $php_mailer->addReplyTo($email_reply);
                $php_mailer->isHTML(true);

                $php_mailer->Subject = $subject;
                $php_mailer->Body = $message;
                
                if (!$php_mailer->send()){
                    if ($is_test){
                        echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_ERROR').'<br />';
                        echo 'Mailer error: '.$php_mailer->ErrorInfo.'<br />';
                        echo $php_mailer->ErrorInfo;
                        die();
                    }
                    else{
                        $this->sendMailer($email_to,
                                          $email_from,
                                          $email_reply,
                                          $email_name,
                                          $email_cc,
                                          $email_cc_name,
                                          $email_bcc,
                                          $email_bcc_name,
                                          $subject,
                                          $message);
                    }
                }
                else{
                    if ($is_test){
                        echo 'success';
                        die();
                    }
                }
            }
            
            /*
             * Send email with WordPress mail function.
             * 
             * @param email_to (string): receiver email
             * @param email_from (string): sender email
             * @param email_reply (string): sender reply email
             * @param email_name (string): sender name
             * @param email_cc (string): cc emails
             * @param email_cc_name (string): cc names
             * @param email_bcc (string): bcc emails
             * @param email_bcc_name (string): bcc names
             * @param subject (string): email subject
             * @param message (string): email message
             * @param is_test (boolean): check if the email is sent for testing purposes
             */
            function sendWPMail($email_to,
                                $email_from,
                                $email_reply,
                                $email_name,
                                $email_cc,
                                $email_cc_name,
                                $email_bcc,
                                $email_bcc_name,
                                $subject,
                                $message,
                                $is_test = false){
                global $DOPBSP;
                
                $headers = array();
                $headers_cc = array();
                $headers_bcc = array();
                
                /*
                 * Add Cc addresses.
                 */
                $emails_cc = explode(',', $email_cc);
                $emails_cc_name = explode(',', $email_cc_name);
                
                for ($i=0; $i<count($emails_cc); $i++){
                    array_push($headers_cc, $emails_cc_name[$i].(isset($emails_cc[$i]) ? ' <'.$emails_cc[$i].'>':''));
                }
                
                /*
                 * Add Bcc addresses.
                 */
                $emails_bcc = explode(',', $email_bcc);
                $emails_bcc_name = explode(',', $email_bcc_name);
                
                for ($i=0; $i<count($emails_bcc); $i++){
                    array_push($headers_bcc, $emails_bcc_name[$i].(isset($emails_bcc[$i]) ? ' <'.$emails_bcc[$i].'>':''));
                }
                
                array_push($headers, 'Content-type: text/html; charset=utf-8'."\r\n");
                array_push($headers, 'MIME-Version: 1.1'."\r\n");
                array_push($headers, 'From: '.$email_name.' <'.$email_from.'>'."\r\n");
                array_push($headers, 'Reply-To: '.$email_name.' <'.$email_reply.'>'."\r\n");
                array_push($headers, 'Cc: '.implode(', ', $headers_cc)."\r\n");
                array_push($headers, 'Bcc: '.implode(', ', $headers_bcc));
        
                if (!wp_mail($email_to, $subject, $message, implode('', $headers))){
                    if ($is_test){
                        echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_ERROR');
                        die();
                    }
                    else{
                        $this->sendMail($email_to,
                                        $email_from,
                                        $email_reply,
                                        $email_name,
                                        $email_cc,
                                        $email_cc_name,
                                        $email_bcc,
                                        $email_bcc_name,
                                        $subject,
                                        $message);
                    }
                }
                else{
                    if ($is_test){
                        echo 'success';
                        die();
                    }
                }
            }
            
            /*
             * Test notification methods.
             * 
             * @post id (string): calendar ID
             * @post method (string): the method used to send the email
             *                        "mail" send email with PHP mail function
             *                        "mailer" send email with Mailer
             *                        "smtp" send email with SMTP
             *                        "wp" send email with WordPress mail function
             * @post email (string): receiver email
             */
            function test(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $method = $DOT->post('method');
                $email = $DOT->post('email');
                
                $settings_notifications = $DOPBSP->classes->backend_settings->values($id,  
                                                                                     'notifications');
                
                $email_reply = $settings_notifications->email_reply == '' ? $settings_notifications->email:$settings_notifications->email_reply;
                $email_name = $settings_notifications->email_name == '' ? $settings_notifications->email_reply:$settings_notifications->email_name;
                
                $this->send($email,
                            $settings_notifications->email,
                            $email_reply,
                            $email_name,
                            $settings_notifications->email_cc,
                            $settings_notifications->email_cc_name,
                            $settings_notifications->email_bcc,
                            $settings_notifications->email_bcc_name,
                            $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_'.strtoupper($method).'_SUBJECT'),
                            $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEST_'.strtoupper($method).'_MESSAGE'),
                            $settings_notifications->smtp_host_name,
                            $settings_notifications->smtp_host_port,
                            $settings_notifications->smtp_ssl,
                            $settings_notifications->smtp_tls,
                            $settings_notifications->smtp_user,
                            $settings_notifications->smtp_password,
                            $settings_notifications->smtp_host_name2,
                            $settings_notifications->smtp_host_port2,
                            $settings_notifications->smtp_ssl2,
                            $settings_notifications->smtp_tls2,
                            $settings_notifications->smtp_user2,
                            $settings_notifications->smtp_password2,
                            $method,
                            true);
            }
        }
    }