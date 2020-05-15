<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.4
* File                    : includes/discounts/class-backend-discounts.php
* File Version            : 1.0.9
* Created / Last Modified : 04 May 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discounts PHP class. The file is different than PRO version.
*/

    if (!class_exists('DOPBSPBackEndDiscounts')){
        class DOPBSPBackEndDiscounts extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the discounts page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_discounts->template();
            }
                
            /*
             * Display discounts list.
             * 
             * @return discounts list HTML
             */      
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html = array();
                $user_roles = array_values(wp_get_current_user()->roles);
                
                if ($user_roles[0] == 'administrator'){
		    $discounts = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts.' ORDER BY id DESC');
		}
		else{
		    $discounts = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts.' WHERE user_id=%d OR user_id=0 ORDER BY id DESC',
								   wp_get_current_user()->ID));
		}
                
                /* 
                 * Create discounts list HTML.
                 */
                array_push($html, '<ul>');
                
                if ($wpdb->num_rows != 0){
                    if ($discounts){
                        foreach ($discounts as $discount){
                            array_push($html, $this->listItem($discount));
                        }
                    }
                }
                else{
                    array_push($html, '<li class="dopbsp-no-data">'.$DOPBSP->text('DISCOUNTS_NO_DISCOUNTS').'</li>');
                }
                array_push($html, '</ul>');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns discounts list item HTML.
             * 
             * @param discount (object): discount data
             * 
             * @return discount list rule HTML
             */
            function listItem($discount){
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($discount->user_id); // Get data about the user who created the discounts.
                
                array_push($html, '<li class="dopbsp-item" id="DOPBSP-discount-ID-'.$discount->id.'" onclick="DOPBSPBackEndDiscount.display('.$discount->id.')">');
                array_push($html, ' <div class="dopbsp-header">');
                
                /*
                 * Display discount ID.
                 */
                array_push($html, '     <span class="dopbsp-id">ID: '.$discount->id.'</span>');
                
                /*
                 * Display data about the user who created the discount.
                 */
                if ($discount->user_id > 0){
                    array_push($html, '     <span class="dopbsp-header-item dopbsp-avatar">'.get_avatar($discount->user_id, 17));
                    array_push($html, '         <span class="dopbsp-info">'.$DOPBSP->text('DISCOUNTS_CREATED_BY').': '.$user->data->display_name.'</span>');
                    array_push($html, '         <br class="dopbsp-clear" />');
                    array_push($html, '     </span>');
                }
                array_push($html, '     <br class="dopbsp-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="dopbsp-name">'.($discount->name == '' ? '&nbsp;':$discount->name).'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
        }
    }