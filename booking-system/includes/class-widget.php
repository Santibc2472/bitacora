<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.3
* File                    : includes/class-widget.php
* File Version            : 1.0.7
* Created / Last Modified : 21 April 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Widget PHP class.
*/
  
    class DOPBSPWidget extends WP_Widget{
        /*
         * Constructor
         */
        function __construct(){
            global $wpdb;
            global $DOPBSP;
                
            if (is_admin()){
                $tables = $wpdb->get_results('SHOW TABLES');
                
                foreach ($tables as $table){
                    $object_name = 'Tables_in_'.DB_NAME;
                    $table_name = $table->$object_name;
                    
                    if (strrpos($table_name, 'dopbsp_translation') !== false){
                        
                        if(is_admin()) {
                            $DOPBSP->classes->translation->set();
                            break;
                        }
                    }
                }
            }
            
            $widget_ops = array('classname' => 'DOPBSPWidget', 
                                'description' => $DOPBSP->text('WIDGET_DESCRIPTION'));
            parent::__construct('DOPBSPWidget', 
                                $DOPBSP->text('WIDGET_TITLE'), 
                                $widget_ops);
        }
 
        function form($instance){
            global $wpdb;
            global $DOPBSP;
            
            $instance = wp_parse_args((array)$instance, array('title' => '',
                                                              'selection' => 'calendar',
                                                              'id' => '0',
                                                              'lang' => DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE));
            $title = $instance['title'];
            $selection = $instance['selection'];
            $id = $instance['id'];
            $lang = $instance['lang'];
?>
<!-- 
    Title field.
-->
            <p>
                <label for="<?php echo $this->get_field_id('title')?>"><?php echo $DOPBSP->text('WIDGET_TITLE_LABEL'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($title)?>" />
            </p>

<!--
    Action field.
-->
            <p>
                <label for="<?php echo $this->get_field_id('selection')?>"><?php echo $DOPBSP->text('WIDGET_SELECTION_LABEL'); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('selection')?>" name="<?php echo $this->get_field_name('selection')?>" onchange="DOPBSPBackEndWidgets.display('<?php echo $this->get_field_id('selection')?>', this.value)">
                    <option value="calendar"<?php echo (esc_attr($selection) == 'calendar' ? ' selected="selected"':'')?>><?php echo $DOPBSP->text('WIDGET_SELECTION_ADD_CALENDAR'); ?></option>
                    <option value="sidebar"<?php echo (esc_attr($selection) == 'sidebar' ? ' selected="selected"':'')?>><?php echo $DOPBSP->text('WIDGET_SELECTION_ADD_SIDEBAR'); ?></option>
                </select>
            </p>

<!-- 
    ID field.
-->
            <p id="DOPBSP-widget-id-<?php echo $this->get_field_id('selection')?>">
                <label for="<?php echo $this->get_field_id('id')?>"><?php echo $DOPBSP->text('WIDGET_ID_LABEL'); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('id')?>" name="<?php echo $this->get_field_name('id')?>">
<?php
	    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id DESC');

            if ($wpdb->num_rows != 0){
                foreach ($calendars as $calendar) {
                    if (esc_attr($id) == $calendar->id){
                        echo '<option value="'.$calendar->id.'" selected="selected">'.$calendar->id.' - '.$calendar->name.'</option>';
                        
                    }
                    else{
                        echo '<option value="'.$calendar->id.'">'.$calendar->id.' - '.$calendar->name.'</option>';
                    }
                }
            }
            else{
                echo '<option value="0">'.$DOPBSP->text('WIDGET_NO_CALENDARS').'</option>';
            }
?>            
            
                </select>
            </p>

<!-- Language Field -->
            <p id="DOPBSP-widget-lang-<?php echo $this->get_field_id('selection')?>">
                <label for="<?$this->get_field_id('lang')?>"><?php echo $DOPBSP->text('WIDGET_LANGUAGE_LABEL'); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('lang')?>" name="<?php echo $this->get_field_name('lang')?>">
                <?php echo $this->getLanguages(esc_attr($lang))?>
                </select>
            </p>

<!-- Form Configuration Script -->         
            <script type="text/JavaScript">
                jQuery(document).ready(function(){
                    dopbspConfigureWidgetForm('<?php echo $this->get_field_id('selection')?>', '<?php echo esc_attr($selection)?>');
                });
                
                function dopbspConfigureWidgetForm(id, selection){
                    jQuery('#DOPBSP-widget-id-'+id).css('display', 'none');
                    jQuery('#DOPBSP-widget-lang-'+id).css('display', 'none');

                    switch (selection){
                        case 'calendar':
                            jQuery('#DOPBSP-widget-id-'+id).css('display', 'block');
                            jQuery('#DOPBSP-widget-lang-'+id).css('display', 'block');
                            break;
                        case 'sidebar':
                            jQuery('#DOPBSP-widget-id-'+id).css('display', 'block');
                            break;
                    }
                }
            </script>
<?php       
        }
 
        function update($new_instance, 
                        $old_instance){
            $instance = $old_instance;
            
            $instance['title'] = $new_instance['title'];
            $instance['selection'] = $new_instance['selection'];
            $instance['id'] = $new_instance['id'];
            $instance['lang'] = $new_instance['lang'];
            
            return $instance;
        }

        function widget($args, 
                        $instance){
            extract($args, EXTR_SKIP);

            echo $before_widget;
            
            $title = empty($instance['title']) ? ' ':apply_filters('widget_title', $instance['title']);
            $selection = empty($instance['selection']) ? 'calendar':$instance['selection'];
            $id = empty($instance['id']) ? '0':$instance['id'];
            $lang = empty($instance['lang']) ? DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE:$instance['lang'];
 
            if (!empty($title)){
                echo $before_title.$title.$after_title;        
            }
            
            switch ($selection){
                case 'calendar':
                    echo do_shortcode('[dopbsp id="'.$id.'" lang="'.$lang.'"]');
                    break;
                case 'sidebar':
                    echo '<div class="DOPBSPCalendar-outer-sidebar" id="DOPBSPCalendar-outer-sidebar'.$id.'"></div>';
                    break;
            }

            echo $after_widget;
        }
        
        function getLanguages($current_language){ // List languages select.
	    global $wpdb;
	    global $DOPBSP;

	    $HTML = array();

	    $languages = $DOPBSP->classes->languages->languages;
	    $selected_language = $selected_language == '' ? $DOPBSP->classes->backend_language->get():$selected_language;

	    $enabled_languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');

	    foreach ($enabled_languages as $enabled_language){
		for ($i=0; $i<count($languages); $i++){
		    if ($enabled_language->code == $languages[$i]['code']){
			array_push($HTML, '<option value="'.$languages[$i]['code'].'"'.($current_language == $languages[$i]['code'] ? ' selected="selected"':'').'>'.$languages[$i]['name'].'</option>');
			break;
		    }
		}
	    }

	    return implode('', $HTML);
        }
    }