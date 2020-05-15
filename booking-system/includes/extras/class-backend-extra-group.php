<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/extras/class-backend-extra-group.php
* File Version            : 1.0.5
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra group PHP class.
*/

    if (!class_exists('DOPBSPBackEndExtraGroup')){
        class DOPBSPBackEndExtraGroup extends DOPBSPBackEndExtraGroups{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add extra group.
             * 
             * @post extra_id (integer): extra ID
             * @post position (integer): group position
             * @post language (string): current group language
             * 
             * @return new group HTML
             */
            function add(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $extra_id = $DOT->post('extra_id', 'int');
                $position = $DOT->post('position', 'int');
                $language = $DOT->post('language');
                
                $wpdb->insert($DOPBSP->tables->extras_groups, array('extra_id' => $extra_id,
                                                                    'position' => $position,
                                                                    'translation' => $DOPBSP->classes->translation->encodeJSON('EXTRAS_EXTRA_ADD_GROUP_LABEL')));
                $id = $wpdb->insert_id;
                $group = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->extras_groups.' WHERE id=%d',
                                                       $id));
                
                $DOPBSP->views->backend_extra_group->template(array('group' =>$group,
                                                            'language' => $language));
                
                die();
            }
            
            /*
             * Edit extra group.
             * 
             * @post id (integer): extra group ID
             * @post field (string): extra group field
             * @post value (string): extra group value
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
                    
                    $group_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->extras_groups.' WHERE id=%d',
                                                                $id));
                    
                    $translation = json_decode($group_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $wpdb->update($DOPBSP->tables->extras_groups, array($field => $value), 
                                                              array('id' =>$id));
                
                die();
            }
            
            /*
             * Delete extra group.
             * 
             * @post id (integer): extra group ID
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                $wpdb->delete($DOPBSP->tables->extras_groups, array('id' => $id));
                $wpdb->delete($DOPBSP->tables->extras_groups_items, array('group_id' => $id));
                
                die();
            }
        }
    }