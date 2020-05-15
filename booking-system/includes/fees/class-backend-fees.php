<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.4
* File                    : includes/fees/class-backend-fees.php
* File Version            : 1.0.9
* Created / Last Modified : 04 May 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end fees PHP class. The file is different than PRO version.
*/

    if (!class_exists('DOPBSPBackEndFees')){
        class DOPBSPBackEndFees extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the fees page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_fees->template();
            }
                
            /*
             * Display fees list.
             * 
             * @return fees list HTML
             */      
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html = array();
                $user_roles = array_values(wp_get_current_user()->roles);
                
                if ($user_roles[0] == 'administrator'){
		    $fees = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->fees.' ORDER BY id DESC');
		}
		else{
		    $fees = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->fees.' WHERE user_id=%d OR user_id=0 ORDER BY id DESC',
							      wp_get_current_user()->ID));
		}
                
                /* 
                 * Create fees list HTML.
                 */
                array_push($html, '<ul>');
                
                if ($wpdb->num_rows != 0){
                    if ($fees){
                        foreach ($fees as $fee){
                            array_push($html, $this->listItem($fee));
                        }
                    }
                }
                else{
                    array_push($html, '<li class="dopbsp-no-data">'.$DOPBSP->text('FEES_NO_FEES').'</li>');
                }
                array_push($html, '</ul>');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns fees list item HTML.
             * 
             * @param fee (object): fee data
             * 
             * @return fee list item HTML
             */
            function listItem($fee){
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($fee->user_id); // Get data about the user who created the fees.
                
                array_push($html, '<li class="dopbsp-item" id="DOPBSP-fee-ID-'.$fee->id.'" onclick="DOPBSPBackEndFee.display('.$fee->id.')">');
                array_push($html, ' <div class="dopbsp-header">');
                
                /*
                 * Display fee ID.
                 */
                array_push($html, '     <span class="dopbsp-id">ID: '.$fee->id.'</span>');
                
                /*
                 * Display data about the user who created the fee.
                 */
                if ($fee->user_id > 0){
                    array_push($html, '     <span class="dopbsp-header-item dopbsp-avatar">'.get_avatar($fee->user_id, 17));
                    array_push($html, '         <span class="dopbsp-info">'.$DOPBSP->text('FEES_CREATED_BY').': '.$user->data->display_name.'</span>');
                    array_push($html, '         <br class="dopbsp-clear" />');
                    array_push($html, '     </span>');
                }
                array_push($html, '     <br class="dopbsp-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="dopbsp-name">'.($fee->name == '' ? '&nbsp;':$fee->name).'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
        }
    }