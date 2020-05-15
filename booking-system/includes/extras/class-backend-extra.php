<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/extras/class-backend-extra.php
* File Version            : 1.0.4
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra PHP class.
*/

    if (!class_exists('DOPBSPBackEndExtra')){
        class DOPBSPBackEndExtra extends DOPBSPBackEndExtras{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a extra.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                                
                $wpdb->insert($DOPBSP->tables->extras, array('user_id' => wp_get_current_user()->ID,
                                                             'name' => $DOPBSP->text('EXTRAS_ADD_EXTRA_NAME'))); 
                echo $DOPBSP->classes->backend_extras->display();

            	die();
            }
            
            /*
             * Prints out the extra.
             * 
             * @post id (integer): extra ID
             * @post language (string): extra current editing language
             * 
             * @return extra HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_extra->template(array('id' => $id,
                                                              'language' => $language));
                $DOPBSP->views->backend_extra_groups->template(array('id' => $id,
                                                                     'language' => $language));
                
                die();
            }
            
            /*
             * Edit extra fields.
             * 
             * @post id (integer): extra ID
             * @post field (string): extra field
             * @post value (string): group new value
             */
            function edit(){
		global $DOT;
                global $wpdb; 
                global $DOPBSP; 
                
                $wpdb->update($DOPBSP->tables->extras, array($DOT->post('field') => $DOT->post('value')), 
                                                       array('id' => $DOT->post('id', 'int')));
                
            	die();
            }
            
            /*
             * Delete extra.
             * 
             * @post id (integer): extra ID
             * 
             * @return number of extras left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete extra.
                 */
                $wpdb->delete($DOPBSP->tables->extras, array('id' => $id));
                
                /*
                 * Delete extra groups.
                 */
                $groups = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->extras_groups.' WHERE extra_id=%d', 
                                                            $id));
                $wpdb->delete($DOPBSP->tables->extras_groups, array('extra_id' => $id));
                
                /*
                 * Delete extra groups items.
                 */
                foreach($groups as $group){
                    $wpdb->delete($DOPBSP->tables->extras_groups_items, array('group_id' => $group->id));
                }
                
                $extras = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->extras.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }