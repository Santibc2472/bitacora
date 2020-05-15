<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-email.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Email PHP class.
 */

    if (!class_exists('DOTEmail')){
        class DOTEmail{
            /*
             * Constructor
	     * 
	     * @usage
	     *	    The constructor is called when a class instance is created.
	     * 
             * @params
	     *	    -
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    -
	     * 
	     * @functions
	     *	    -
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    -
	     * 
	     * @return_details
	     *	    -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            function __construct(){
            }

            /*
             * Send email.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    subject (string): email subject
             *	    message (string): email message
             *	    email_to (string): receiver email
             *	    email_from (string): sender email
             *	    email_reply (string): sender reply email
             *	    email_name (string): sender name
             *	    email_cc (string): cc emails
             *	    email_cc_name (string): cc names
             *	    email_bcc (string): bcc emails
             *	    email_bcc_name (string): bcc names
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    DOT_SMTP_HOST (string): SMTP host
	     *	    DOT_SMTP_PASSWORD (string): SMTP user password
	     *	    DOT_SMTP_PORT (integer): SMTP port
	     *	    DOT_SMTP_SECURITY (string): SMTP security type
	     *	    DOT_SMTP_USERNAME (string): SMTP user
	     * 
	     * @globals
	     *	    -
	     * 
	     * @functions
	     *	    this : mail() // Send an email via PHP mail function.
	     *	    this : smtp() // Send an email via SMTP using PHPMailer.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    A boolean value if the email has been sent or not.
	     * 
	     * @return_details
	     *	    -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            function send($subject = '',
			  $message = '',
		          $email_to = '',
			  $email_from = '',
			  $email_reply = '',
			  $email_name = '',
			  $email_cc = '',
			  $email_cc_name = '',
			  $email_bcc = '',
			  $email_bcc_name = ''){
		if ($subject == ''
			|| $message == ''
			|| $email_to == ''
			|| $email_from == ''){
		    return false;
		}
		
		/*
		 * If SMTP data is defined the email will be sent using it.
		 */
		if (defined('DOT_SMTP_HOST')
			&& defined('DOT_SMTP_USERNAME')
			&& defined('DOT_SMTP_PASSWORD')
			&& defined('DOT_SMTP_SECURITY')
			&& defined('DOT_SMTP_PORT')){
		    /*
		     * Send the email via SMTP.
		     */
		    return $this->smtp($subject,
				       $message,
				       $email_to,
				       $email_from,
				       $email_reply,
				       $email_name,
				       $email_cc,
				       $email_cc_name,
				       $email_bcc,
				       $email_bcc_name);
		}
		else{
		    /*
		     * Send the email via PHP mail function.
		     */
		    return $this->mail($subject,
				       $message,
				       $email_to,
				       $email_from,
				       $email_reply,
				       $email_name,
				       $email_cc,
				       $email_cc_name,
				       $email_bcc,
				       $email_bcc_name);
		}
	    }

            /*
             * Send email with PHP mail function.
	     * 
	     * @usage
	     *	    this : send()
	     * 
             * @params
             *	    subject (string): email subject
             *	    message (string): email message
             *	    email_to (string): receiver email
             *	    email_from (string): sender email
             *	    email_reply (string): sender reply email
             *	    email_name (string): sender name
             *	    email_cc (string): cc emails
             *	    email_cc_name (string): cc names
             *	    email_bcc (string): bcc emails
             *	    email_bcc_name (string): bcc names
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    -
	     * 
	     * @functions
	     *	    -
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    A boolean value if the email has been sent or not.
	     * 
	     * @return_details
	     *	    -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function mail($subject = '',
			  $message = '',
		          $email_to = '',
			  $email_from = '',
			  $email_reply = '',
			  $email_name = '',
			  $email_cc = '',
			  $email_cc_name = '',
			  $email_bcc = '',
			  $email_bcc_name = ''){
                $headers = array();
                $headers_cc = array();
                $headers_bcc = array();
		
                /*
                 * Add Cc addresses.
                 */
		if ($email_cc != ''){
		    $emails_cc = explode(',', $email_cc);
		    $emails_cc_name = explode(',', $email_cc_name);

		    for ($i=0; $i<count($emails_cc); $i++){
			array_push($headers_cc, $emails_cc_name[$i].(isset($emails_cc[$i]) ? ' <'.$emails_cc[$i].'>':''));
		    }
		}
                
                /*
                 * Add Bcc addresses.
                 */
		if ($email_bcc != ''){
		    $emails_bcc = explode(',', $email_bcc);
		    $emails_bcc_name = explode(',', $email_bcc_name);

		    for ($i=0; $i<count($emails_bcc); $i++){
			array_push($headers_bcc, $emails_bcc_name[$i].(isset($emails_bcc[$i]) ? ' <'.$emails_bcc[$i].'>':''));
		    }
		}
                
		/*
		 * Generate email header.
		 */
                array_push($headers, 'Content-type: text/html; charset=utf-8'."\r\n");
                array_push($headers, 'MIME-Version: 1.1'."\r\n");
                array_push($headers, 'From: '.($email_name == '' ? $email_from:$email_name).' <'.$email_from.'>'."\r\n");
                $email_reply != '' ? array_push($headers, 'Reply-To: '.($email_name == '' ? $email_reply:$email_name).' <'.$email_reply.'>'."\r\n"):'';
                count($headers_cc) > 0 ? array_push($headers, 'Cc: '.implode(',', $headers_cc)."\r\n"):'';
                count($headers_bcc) > 0 ? array_push($headers, 'Bcc: '.implode(',', $headers_bcc)):'';
        
                return mail($email_to, $subject, $message, implode('', $headers));
            } 
	    
            /*
             * Send email with PHPMailer SMTP.
	     * 
	     * @usage
	     *	    this : send()
	     * 
             * @params
             *	    subject (string): email subject
             *	    message (string): email message
             *	    email_to (string): receiver email
             *	    email_from (string): sender email
             *	    email_reply (string): sender reply email
             *	    email_name (string): sender name
             *	    email_cc (string): cc emails
             *	    email_cc_name (string): cc names
             *	    email_bcc (string): bcc emails
             *	    email_bcc_name (string): bcc names
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    DOT_SMTP_HOST (string): SMTP host
	     *	    DOT_SMTP_PASSWORD (string): SMTP user password
	     *	    DOT_SMTP_PORT (integer): SMTP port
	     *	    DOT_SMTP_SECURITY (string): SMTP security type
	     *	    DOT_SMTP_USERNAME (string): SMTP user
	     * 
	     * @globals
	     *	    -
	     * 
	     * @functions
	     *	    This function includes directly the PHPMailer API files [framework/libraries/phpmailer/class.phpmailer.php] & [framework/libraries/phpmailer/class.smtp.php].
	     *	    
	     *	    PHPMailer::addAddress(); // Add receiver email address.
	     *	    PHPMailer::addBCC(); // Add Bcc email addresses.
	     *	    PHPMailer::addCC(); // Add Cc email addresses.
	     *	    PHPMailer::addReplyTo(); // Add reply email address.
	     *	    PHPMailer::isHTML(); // Enable HTML in email.
	     *	    PHPMailer::isSMTP(); // Enable SMTP to send the email.
	     *	    PHPMailer::send(); // Send the email.
	     *	    PHPMailer::setFrom(); // Add sender email address.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    A boolean value if the email has been sent or not.
	     * 
	     * @return_details
	     *	    -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    function smtp($subject = '',
			  $message = '',
		          $email_to = '',
			  $email_from = '',
			  $email_reply = '',
			  $email_name = '',
			  $email_cc = '',
			  $email_cc_name = '',
			  $email_bcc = '',
			  $email_bcc_name = ''){
		include_once('framework/libraries/phpmailer/class.phpmailer.php');
		include_once('framework/libraries/phpmailer/class.smtp.php');

		$mail = new PHPMailer;
		
		// $mail->SMTPDebug = 3;

		/*
		 * Configure SMTP.
		 */    
		$mail->isSMTP();
		$mail->Host = DOT_SMTP_HOST;
		$mail->SMTPAuth = true;
		$mail->Username = DOT_SMTP_USERNAME;
		$mail->Password = DOT_SMTP_PASSWORD;
		$mail->SMTPSecure = DOT_SMTP_SECURITY;
		$mail->Port = DOT_SMTP_PORT;

		/*
		 * Email recipient.
		 */
		$mail->addAddress($email_to);
		
                /*
                 * Add Cc addresses.
                 */
		if ($email_cc != ''){
		    $emails_cc = explode(',', $email_cc);
		    $emails_cc_name = explode(',', $email_cc_name);

		    for ($i=0; $i<count($emails_cc); $i++){
			isset($emails_cc_name[$i]) ? $mail->addCC($emails_cc[$i], $emails_cc_name[$i]):$mail->addCC($emails_cc[$i]);
		    }
		}
                
                /*
                 * Add Bcc addresses.
                 */
		if ($email_bcc != ''){
		    $emails_bcc = explode(',', $email_bcc);
		    $emails_bcc_name = explode(',', $email_bcc_name);

		    for ($i=0; $i<count($emails_bcc); $i++){
			isset($emails_bcc_name[$i]) ? $mail->addBCC($emails_bcc[$i], $emails_bcc_name[$i]):$mail->addBCC($emails_bcc[$i]);
		    }
		}

		/*
		 * Set email sender.
		 */
		$email_name == '' ? $mail->setFrom($email_from):$mail->setFrom($email_from, $email_name);
		$email_reply != '' ? ($email_name == '' ? $mail->addReplyTo($email_reply):$mail->addReplyTo($email_reply, $email_name)):'';

		/*
		 * Set email content.
		 */
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $message;
		
		/*
		 * Send the email.
		 */
		if (!$mail->send()){
		    return false;
		} 
		else{
		    return true;
		}
	    }
        }
    }