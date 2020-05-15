<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/extras/class-backend-extra-group-item.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra group item PHP class.
*/

    if (!class_exists('DOPBSPBackEndExtraGroupItem')){
        class DOPBSPBackEndExtraGroupItem extends DOPBSPBackEndExtraGroupItems{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add extra group item.
             * 
             * @post group_id (integer): group ID
             * @post position (integer): group item position
             * @post language (string): current group item language
             * 
             * @return new group HTML
             */
            function add(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $group_id = $DOT->post('group_id', 'int');
                $position = $DOT->post('position', 'int');
                $language = $DOT->post('language');
                
                $wpdb->insert($DOPBSP->tables->extras_groups_items, array('group_id' => $group_id,
                                                                          'position' => $position,
                                                                          'translation' => $DOPBSP->classes->translation->encodeJSON('EXTRAS_EXTRA_GROUP_ADD_ITEM_LABEL')));
                $id = $wpdb->insert_id;
                $item = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->extras_groups_items.' WHERE id=%d',
                                                      $id));
                
                $DOPBSP->views->backend_extra_group_item->template(array('item' => $item,
                                                                 'language' =>$language));
                
                die();
            }
            
            /*
             * Edit extra group item.
             * 
             * @post id (integer): group item ID
             * @post field (string): group item field
             * @post value (string): group item value
             * @post language (string): extra selected language
             */
            function edit(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $field = $DOT->post('field');
                $value = $DOT->post('value');
                $language = $DOT->post('language');
                
                if ($field == 'label'){
                    $value = str_replace("\n", '<<new-line>>', $value);
                    $value = str_replace("\'", '<<single-quote>>', $value);
                    $value = utf8_encode($value);
                    
                    $group_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->extras_groups_items.' WHERE id=%d',
                                                                $id));
                    
                    $translation = json_decode($group_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $wpdb->update($DOPBSP->tables->extras_groups_items, array($field => $value), 
                                                                    array('id' => $id));
                
                die();
            }
            
            /*
             * Delete extra group item.
             * 
             * @post id (integer): group item ID
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                $wpdb->delete($DOPBSP->tables->extras_groups_items, array('id' => $id));
                
                die();
            }
        }
    }