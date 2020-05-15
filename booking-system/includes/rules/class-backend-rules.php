<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.4
* File                    : includes/rules/class-backend-rules.php
* File Version            : 1.0.8
* Created / Last Modified : 04 May 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end rules PHP class. The file is different than PRO version.
*/

    if (!class_exists('DOPBSPBackEndRules')){
        class DOPBSPBackEndRules extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the rules page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_rules->template();
            }
                
            /*
             * Display rules list.
             * 
             * @return rules list HTML
             */      
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html = array();
                $user_roles = array_values(wp_get_current_user()->roles);
                
                if ($user_roles[0] == 'administrator'){
		    $rules = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->rules.' ORDER BY id DESC');
		}
		else{
		    $rules = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->rules.' WHERE user_id=%d OR user_id=0 ORDER BY id DESC',
							       wp_get_current_user()->ID));
		}
                
                /* 
                 * Create rules list HTML.
                 */
                array_push($html, '<ul>');
                
                if ($wpdb->num_rows != 0){
                    if ($rules){
                        foreach ($rules as $rule){
                            array_push($html, $this->listItem($rule));
                        }
                    }
                }
                else{
                    array_push($html, '<li class="dopbsp-no-data">'.$DOPBSP->text('RULES_NO_RULES').'</li>');
                }
                array_push($html, '</ul>');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns rules list item HTML.
             * 
             * @param rule (object): rule data
             * 
             * @return rule list item HTML
             */
            function listItem($rule){
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($rule->user_id); // Get data about the user who created the rules.
                
                array_push($html, '<li class="dopbsp-item" id="DOPBSP-rule-ID-'.$rule->id.'" onclick="DOPBSPBackEndRule.display('.$rule->id.')">');
                array_push($html, ' <div class="dopbsp-header">');
                
                /*
                 * Display rule ID.
                 */
                array_push($html, '     <span class="dopbsp-id">ID: '.$rule->id.'</span>');
                
                /*
                 * Display data about the user who created the rule.
                 */
                if ($rule->user_id > 0){
                    array_push($html, '     <span class="dopbsp-header-item dopbsp-avatar">'.get_avatar($rule->user_id, 17));
                    array_push($html, '         <span class="dopbsp-info">'.$DOPBSP->text('RULES_CREATED_BY').': '.$user->data->display_name.'</span>');
                    array_push($html, '         <br class="dopbsp-clear" />');
                    array_push($html, '     </span>');
                }
                array_push($html, '     <br class="dopbsp-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="dopbsp-name">'.($rule->name == '' ? '&nbsp;':$rule->name).'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
        }
    }