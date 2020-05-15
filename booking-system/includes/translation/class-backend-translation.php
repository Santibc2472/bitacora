<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-backend-translation.php
* File Version            : 1.0.4
* Created / Last Modified : 03 September 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end translation PHP class.
*/

    if (!class_exists('DOPBSPBackEndTranslation')){
        class DOPBSPBackEndTranslation extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Display translation.
             * 
             * @post language (string): language (code) to be displayed
             * @post text_group (string): text group to be displayed
             * 
             * @return HTML translations list
             */
            function display(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $language = $DOT->post('language');
                $text_group = $DOT->post('text_group');
                
                $table = $DOPBSP->tables->translation.'_'.esc_sql($language);
                
                if ($text_group == 'all'){
                    $translation = $wpdb->get_results($wpdb->prepare('SELECT t1.* FROM '.$table.' t1 ORDER BY IF (t1.parent_key=%s, t1.translation, (SELECT t2.translation FROM '.$table.' t2 WHERE t1.parent_key=t2.key_data)), IF (t1.parent_key=%s, " ", t1.text_data)  ASC',
                                                                     '', ''));
                }
                else{
                    $translation = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$table.' WHERE parent_key=%s OR key_data=%s ORDER BY IF (parent_key="", " ", text_data) ASC',
                                                                     $text_group, $text_group));
                }
                
                $DOPBSP->views->backend_translation->text(array('language' => $language,
                                                                'translation' => $translation));
                
            	die();                
            }
            
            /*
             * Initialize/update translation database content.
             * 
             * @param lang_code (string): language code, default "all"
             * 
             * @return false if languages table does not exist
             */
            function database($lang_code = 'all'){
                global $wpdb;
                global $DOPBSP;
                
                $languages_codes = array();
                $query_values = array();
                $query_values_delete = array();
                $text = array();
                
                $languages = $DOPBSP->classes->languages->languages;
                
                /*
                 * Exit the function if languages table does not exist.
                 */
                $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->languages.'"');
                
                if ($wpdb->num_rows == 0
                   || !is_admin()){
                    return false;
                }
                
                /*
                 * Add languages to database.
                 */
                if ($lang_code == 'all'){
                    $control_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->languages);

                    if ($wpdb->num_rows == 0){
                        for ($i=0; $i<count($languages); $i++){
                            array_push($query_values, '(\''.$languages[$i]['name'].'\', \''.$languages[$i]['code'].'\', \''.(strpos(DOPBSP_CONFIG_TRANSLATION_LANGUAGES_TO_INSTALL, $languages[$i]['code']) !== false ? 'true':'false').'\')');
                        }

                        if (count($query_values) > 0){
                            $wpdb->query('INSERT INTO '.$DOPBSP->tables->languages.' (name, code, enabled) VALUES '.implode(', ', $query_values));
                        }
                    }

                    $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');

                    foreach ($languages as $language){
                        array_push($languages_codes, $language->code);
                    }
                }
                else{
                    array_push($languages_codes, $lang_code);
                }
                
                /*
                 * Check what text should be added or not to database.
                 */
                unset($query_values);
                $query_values = array();
                
                for ($i=0; $i<count($DOPBSP->classes->translation->text); $i++){
                    $text[$DOPBSP->classes->translation->text[$i]['key']] = $i;
                    $DOPBSP->classes->translation->text[$i]['add'] = true;
                    array_push($query_values, '\''.$DOPBSP->classes->translation->text[$i]['key'].'\'');
                }
                
                $current_translation = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.($lang_code == 'all' ? DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE:$lang_code).' WHERE key_data IN ('.implode(', ', $query_values).')');
                
                foreach ($current_translation as $translation_item){
                    if (array_key_exists($translation_item->key_data, $text)){
                        $DOPBSP->classes->translation->text[$text[$translation_item->key_data]]['add'] = false;
                    }
                }
                
                /*
                 *  Add/delete data to/from database.
                 */
                for ($l=0; $l<count($languages_codes); $l++){
                    unset($query_values);
                    unset($query_values_delete);
                    
                    $query_values = array();
                    $query_values_delete = array();
                            
                    for ($i=0; $i<count($DOPBSP->classes->translation->text); $i++){
                        /*
                         * Set add query values.
                         */
                        if ($DOPBSP->classes->translation->text[$i]['add']){
                            array_push($query_values, '(\''.$DOPBSP->classes->translation->text[$i]['key'].'\', \''.$DOPBSP->classes->translation->text[$i]['parent'].'\', \''.$DOPBSP->classes->translation->text[$i]['text'].'\', \''.(isset($DOPBSP->classes->translation->text[$i][$languages_codes[$l]]) ? $DOPBSP->classes->translation->text[$i][$languages_codes[$l]]:$DOPBSP->classes->translation->text[$i]['text']).'\', \''.(isset($DOPBSP->classes->translation->text[$i]['location']) ? $DOPBSP->classes->translation->text[$i]['location']:'backend').'\')');
                        }
                        
                        /*
                         * Set delete query values.
                         */
                        array_push($query_values_delete, '\''.$DOPBSP->classes->translation->text[$i]['key'].'\'');
                    }
                    
                    /*
                     * Add new translation.
                     */
                    if (count($query_values) > 0){
                        $wpdb->query('INSERT INTO '.$DOPBSP->tables->translation.'_'.$languages_codes[$l].' (key_data, parent_key, text_data, translation, location) VALUES '.implode(', ', $query_values));
                    }
                    
                    /*
                     * Delete duplicated keys.
                     */
                    $wpdb->query('DELETE t1 FROM '.$DOPBSP->tables->translation.'_'.$languages_codes[$l].' t1, '.$DOPBSP->tables->translation.'_'.$languages_codes[$l].' t2 WHERE t1.id > t2.id AND t1.key_data = t2.key_data');

                    /*
                     * Delete old translation.
                     */
                    $control_data = $wpdb->query('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$languages_codes[$l]);
                    
                    if ($wpdb->num_rows != count($query_values_delete)){
                        $wpdb->query('DELETE FROM '.$DOPBSP->tables->translation.'_'.$languages_codes[$l].' WHERE key_data NOT IN ('.implode(', ', $query_values_delete).')');
                    }
                }
            }
               
            /*
             * Edit translation.
             * 
             * @post id (integer): translation id to modified
             * @post language (string): language (code) to be modified
             * @post value (string): the value with which the translation will be modified
             */
            function edit(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $value = str_replace("'", '<<single-quote>>', $DOT->post('value', 'textarea'));
                $value = str_replace("\n", '<br />', $value);
                
                $wpdb->update($DOPBSP->tables->translation.'_'.$DOT->post('language'), array('translation' => $value), 
										       array('id' => $DOT->post('id', 'int')));
                
                die();
            }
            
            /*
             * Reset translation database.
             */
            function reset(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages);
                
                /*
                 * Delete or empty translation tables.
                 */
                foreach ($languages as $language){
                    if ($language->enabled == 'true'){
                        $wpdb->query('TRUNCATE TABLE '.$DOPBSP->tables->translation.'_'.$language->code);
                    }
                    else{
                        $wpdb->query('DROP TABLE IF EXISTS '.$DOPBSP->tables->translation.'_'.$language->code);
                    }
                }
                
                /*
                 * Reinitialize database content.
                 */
                $this->database();
                
                if ($DOT->post('ajax_request')){
                    die();
                }
            }
        }
    }