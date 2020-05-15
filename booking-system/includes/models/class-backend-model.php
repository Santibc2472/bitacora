<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/models/class-backend-model.php
* File Version            : 1.0
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end model PHP class.
*/

    if (!class_exists('DOPBSPBackEndModel')){
        class DOPBSPBackEndModel extends DOPBSPBackEndModels{
            private $views;
            
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a model.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->insert($DOPBSP->tables->models, array('user_id' => wp_get_current_user()->ID,
                                                             'name' => $DOPBSP->text('MODELS_ADD_MODEL_NAME'),
                                                             'translation' => $DOPBSP->classes->translation->encodeJSON('MODELS_ADD_MODEL_LABEL'),
                                                             'translation_calendar' => $DOPBSP->classes->translation->encodeJSON('MODELS_ADD_MODEL_LABEL_CALENDAR'))); 
                
                echo $DOPBSP->classes->backend_models->display();

            	die();
            }
            
            /*
             * Prints out the model.
             * 
             * @post id (integer): model ID
             * @post language (string): model current editing language
             * 
             * @return model HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_model->template(array('id' => $id,
                                                              'language' => $language));
                
                die();
            }
            
            /*
             * Edit model fields.
             * 
             * @post id (integer): model ID
             * @post field (string): model field
             * @post value (string): model new value
             * @post language (string): model selected language
             */
            function edit(){
		global $DOT;
                global $wpdb;  
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $field = $DOT->post('field');
                $value = $DOT->post('value');
                $language = $DOT->post('language');
                
                if ($field == 'label'
			|| $field == 'label_calendar'){
                    $value = str_replace("\n", '<<new-line>>', $value);
                    $value = str_replace("\'", '<<single-quote>>', $value);
                    $value = utf8_encode($value);
                    
                    $model_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->models.' WHERE id=%d', 
                                                                $id));
                    
                    $translation = json_decode($field == 'label' ? $model_data->translation:$model_data->translation_calendar);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = $field == 'label' ? 'translation':'translation_calendar';
                }
                        
                $wpdb->update($DOPBSP->tables->models, array($field => $value), 
                                                       array('id' =>$id));
                
            	die();
            }
            
            /*
             * Delete model.
             * 
             * @post id (integer): model ID
             * 
             * @return number of models left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete model.
                 */
                $wpdb->delete($DOPBSP->tables->models, array('id' => $id));
                $models = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->models.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }