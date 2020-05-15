<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* File                    : includes/smses/class-backend-smses.php
* Author                  : PINPOINT.WORLD
* Copyright               : © 2018 PINPOINT.WORLD
* Website                 : http://www.pinpoint.world
* Description             : Back end smses PHP class.
*/

    if (!class_exists('DOPBSPBackEndSmses')){
        class DOPBSPBackEndSmses extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the SMSes page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_smses->template();
            }
                
            /*
             * Display SMSes list.
             * 
             * @return SMSes list HTML
             */      
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html = array();
                $user_roles = array_values(wp_get_current_user()->roles);
                
                if ($user_roles[0] == 'administrator'){
		    $smses = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->smses.' ORDER BY id DESC');
		}
		else{
		    $smses = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->smses.' WHERE user_id=%d OR user_id=0 ORDER BY id DESC',
								wp_get_current_user()->ID));
		}
                
                /* 
                 * Create SMSes list HTML.
                 */
                array_push($html, '<ul>');
                
                if ($wpdb->num_rows != 0){
                    if ($smses){
                        foreach ($smses as $sms){
                            array_push($html, $this->listItem($sms));
                        }
                    }
                }
                else{
                    array_push($html, '<li class="dopbsp-no-data">'.$DOPBSP->text('SMSES_NO_SMS').'</li>');
                }
                array_push($html, '</ul>');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns SMSes list item HTML.
             * 
             * @param SMS (object): SMS data
             * 
             * @return SMS list item HTML
             */
            function listItem($sms){
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($sms->user_id); // Get data about the user who created the SMSes.
                
                array_push($html, '<li class="dopbsp-item" id="DOPBSP-sms-ID-'.$sms->id.'" onclick="DOPBSPBackEndSms.display('.$sms->id.')">');
                array_push($html, ' <div class="dopbsp-header">');
                
                /*
                 * Display SMS ID.
                 */
                array_push($html, '     <span class="dopbsp-id">ID: '.$sms->id.'</span>');
                
                /*
                 * Display data about the user who created the SMS.
                 */
                if ($sms->user_id > 0){
                    array_push($html, '     <span class="dopbsp-header-item dopbsp-avatar">'.get_avatar($sms->user_id, 17));
                    array_push($html, '         <span class="dopbsp-info">'.$DOPBSP->text('SMSES_CREATED_BY').': '.$user->data->display_name.'</span>');
                    array_push($html, '         <br class="dopbsp-clear" />');
                    array_push($html, '     </span>');
                }
                array_push($html, '     <br class="dopbsp-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="dopbsp-name">'.($sms->name == '' ? '&nbsp;':$sms->name).'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
        }
    }