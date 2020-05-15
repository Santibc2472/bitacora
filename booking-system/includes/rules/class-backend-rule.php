<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/rules/class-backend-rule.php
* File Version            : 1.0.4
* Created / Last Modified : 19 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end rule PHP class.
*/

    if (!class_exists('DOPBSPBackEndRule')){
        class DOPBSPBackEndRule extends DOPBSPBackEndRules{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a rule.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->insert($DOPBSP->tables->rules, array('user_id' => wp_get_current_user()->ID,
                                                            'name' => $DOPBSP->text('RULES_ADD_RULE_NAME'))); 
                
                echo $DOPBSP->classes->backend_rules->display();

            	die();
            }
            
            /*
             * Prints out the rule.
             * 
             * @post id (integer): rule ID
             * @post language (string): rule current editing language
             * 
             * @return rule HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_rule->template(array('id' => $id,
							     'language' => $language));
                
                die();
            }
            
            /*
             * Edit rule fields.
             * 
             * @post id (integer): rule ID
             * @post field (string): rule field
             * @post value (string): rule new value
             * @post language (string): rule selected language
             */
            function edit(){
		global $DOT;
                global $wpdb; 
                global $DOPBSP; 
                
                $id = $DOT->post('id', 'int');
                $field = $DOT->post('field');
                $value = $DOT->post('value');
//                $language = $DOT->post('language');
                        
                $wpdb->update($DOPBSP->tables->rules, array($field => $value), 
                                                      array('id' =>$id));
                
            	die();
            }
            
            /*
             * Delete rule.
             * 
             * @post id (integer): rule ID
             * 
             * @return number of rules left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete rule.
                 */
                $wpdb->delete($DOPBSP->tables->rules, array('id' => $id));
                $rules = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->rules.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }