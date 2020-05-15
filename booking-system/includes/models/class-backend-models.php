<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/models/class-backend-models.php
* File Version            : 1.0
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end models PHP class.
*/

    if (!class_exists('DOPBSPBackEndModels')){
        class DOPBSPBackEndModels extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the models page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
		
                $DOPBSP->views->backend_models->template();
            }
                
            /*
             * Display models list.
             * 
             * @return models list HTML
             */      
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html = array();
                
                $models = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->models.' ORDER BY id DESC');
                
                /* 
                 * Create models list HTML.
                 */
                array_push($html, '<ul>');
                
                if ($wpdb->num_rows != 0){
                    if ($models){
                        foreach ($models as $model){
                            array_push($html, $this->listItem($model));
                        }
                    }
                }
                else{
                    array_push($html, '<li class="dopbsp-no-data">'.$DOPBSP->text('MODELS_NO_MODELS').'</li>');
                }
                array_push($html, '</ul>');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns model list item HTML.
             * 
             * @param model (object): model data
             * 
             * @return model list item HTML
             */
            function listItem($model){
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($model->user_id); // Get data about the user who created the model.
                
                array_push($html, '<li class="dopbsp-item" id="DOPBSP-model-ID-'.$model->id.'" onclick="DOPBSPBackEndModel.display('.$model->id.')">');
                array_push($html, ' <div class="dopbsp-header">');
                
                /*
                 * Display model ID.
                 */
                array_push($html, '     <span class="dopbsp-id">ID: '.$model->id.'</span>');
                
                /*
                 * Display data about the user who created the model.
                 */
                if ($model->user_id > 0){
                    array_push($html, '     <span class="dopbsp-header-item dopbsp-avatar">'.get_avatar($model->user_id, 17));
                    array_push($html, '         <span class="dopbsp-info">'.$DOPBSP->text('MODELS_CREATED_BY').': '.$user->data->display_name.'</span>');
                    array_push($html, '         <br class="dopbsp-clear" />');
                    array_push($html, '     </span>');
                }
                array_push($html, '     <br class="dopbsp-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="dopbsp-name">'.($model->name == '' ? '&nbsp;':$model->name).'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
        }
    }