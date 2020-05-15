<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/extras/views-backend-extra-group.php
* File Version            : 1.0.7
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra group views class.
*/

    if (!class_exists('DOPBSPViewsBackEndExtraGroup')){
        class DOPBSPViewsBackEndExtraGroup extends DOPBSPViewsBackEndExtraGroups{
            /*
             * Constructor
             */
            function __construct(){
            }
          
            /*
             * Returns group template.
             * 
             * @param args (array): function arguments
             *                      * group (integer): group data
             *                      * language (string): group language
             * 
             * @return group HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $group = $args['group'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
                
                $items = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->extras_groups_items.' WHERE group_id=%d ORDER BY position ASC',
                                                           $group->id));  
?>
                <li id="DOPBSP-extra-group-<?php echo $group->id; ?>" class="dopbsp-group-wrapper">
<?php
                    /*
                     * Preview
                     */
                    $this->displayPreview(array('group' => $group,
                                                'language' => $language));
?>
                    <div class="dopbsp-settings-wrapper">
<?php
                    /*
                     * Label
                     */
                    $this->displayTextInput(array('id' => 'label',
                                                  'label' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_LABEL_LABEL'),
                                                  'value' => $DOPBSP->classes->translation->decodeJSON($group->translation, $language),
                                                  'extra_group_id' => $group->id,
                                                  'help' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_LABEL_HELP')));
                    
                    /*
                     * Multiple
                     */
                    $this->displaySwitchInput(array('id' => 'multiple_select',
                                                    'label' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_MULTIPLE_SELECT_LABEL'),
                                                    'value' => $group->multiple_select,
                                                    'extra_group_id' => $group->id,
                                                    'help' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_MULTIPLE_SELECT_HELP')));
                    
                    /*
                     * Required
                     */
                    $this->displaySwitchInput(array('id' => 'required',
                                                    'label' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_REQUIRED_LABEL'),
                                                    'value' => $group->required,
                                                    'extra_group_id' => $group->id,
                                                    'help' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_REQUIRED_HELP')));
                    
                    /*
                     * Multiply with No items
                     */
                    $this->displaySwitchInput(array('id' => 'no_items_multiply',
                                                    'label' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_NO_ITEMS_MULTIPLY_LABEL'),
                                                    'value' => $group->no_items_multiply,
                                                    'extra_group_id' => $group->id,
                                                    'help' => $DOPBSP->text('EXTRAS_EXTRA_GROUP_NO_ITEMS_MULTIPLY_HELP')));
?>
                        <div class="dopbsp-input-wrapper dopbsp-last">
                            <label><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_LABEL'); ?></label>
                            <div class="dopbsp-items-wrapper">
                                <div class="dopbsp-buttons">
                                    <a href="javascript:DOPBSPBackEndExtraGroupItem.add(<?php echo $group->id; ?>, '<?php echo $language; ?>')" class="dopbsp-button dopbsp-small dopbsp-add"><span class="dopbsp-info"><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ADD_ITEM_SUBMIT'); ?></span></a>
                                    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-small dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                </div>
                                <ul class="dopbsp-items-labels">
                                    <li><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_LABELS_LABEL'); ?></li>
                                    <li><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_LABELS_OPERATION'); ?></li>
                                    <li><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_LABELS_PRICE'); ?></li>
                                    <li><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_LABELS_PRICE_TYPE'); ?></li>
                                    <li><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_LABELS_PRICE_BY'); ?></li>
                                    <li><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_ITEMS_LABELS_DEFAULT'); ?></li>
                                </ul>    
                                <ul class="dopbsp-items" id="DOPBSP-extra-group-items-<?php echo $group->id; ?>">
<?php
                    foreach ($items as $item){
                        $DOPBSP->views->backend_extra_group_item->template(array('item' => $item, 
                                                                         'language' => $language));
                    }
?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
<?php           
            }
            
/*
 * Default templates.
 */            
            /*
             * Create a extra group preview.
             * 
             * @param args (array): function arguments
             *                      * group (integer): group data
             *                      * language (string): group language
             * 
             * @return extra group preview HTML
             */
            function displayPreview($args = array()){
                global $DOPBSP;
                
                $group = $args['group'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                    <div class="dopbsp-preview-wrapper">
                        <div class="dopbsp-preview dopbsp-input-wrapper">
                            <label id="DOPBSP-extra-group-label-preview-<?php echo $group->id; ?>" for="DOPBSP-extra-group-preview-<?php echo $group->id; ?>"><?php echo $DOPBSP->classes->translation->decodeJSON($group->translation, $language); ?> <span class="dopbsp-required"><?php echo $group->required == 'true' ? '*':''; ?></span></label>
                        </div>
                        <div class="dopbsp-buttons-wrapper">
                            <a href="javascript:DOPBSPBackEndExtraGroup.toggle(<?php echo $group->id; ?>)" class="dopbsp-button dopbsp-toggle"><span class="dopbsp-info"><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_SHOW_SETTINGS'); ?></span></a>
                            <a href="javascript:DOPBSPBackEnd.confirmation('EXTRAS_EXTRA_DELETE_GROUP_CONFIRMATION', 'DOPBSPBackEndExtraGroup.delete(<?php echo $group->id; ?>)')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info"><?php echo $DOPBSP->text('EXTRAS_EXTRA_DELETE_GROUP_SUBMIT'); ?></span></a>
                            <a href="javascript:void(0)" class="dopbsp-button dopbsp-handle"><span class="dopbsp-info"><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUP_SORT'); ?></span></a>
                        </div>
                        <br class="dopbsp-clear" />
                    </div>
<?php                
            }
            
/*
 * Inputs.
 */       
                     
            /*
             * Create a text input group for extra groups.
             * 
             * @param args (array): function arguments
             *                      * id (integer): group ID
             *                      * label (string): group label
             *                      * value (string): group current value
             *                      * extra_group_id (integer): extra group ID
             *                      * help (string): group help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $extra_group_id = $args['extra_group_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-extra-group-'.$id.'-'.$extra_group_id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-extra-group-'.$id.'-'.$extra_group_id.'" id="DOPBSP-extra-group-'.$id.'-'.$extra_group_id.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndExtraGroup.edit('.$extra_group_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndExtraGroup.edit('.$extra_group_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndExtraGroup.edit('.$extra_group_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            
            /*
             * Create a switch group for extra groups.
             * 
             * @param args (array): function arguments
             *                      * id (integer): group ID
             *                      * label (string): group label
             *                      * value (string): group current value
             *                      * extra_group_id (integer): extra group ID
             *                      * help (string): group help
             *                      * container_class (string): container class
             * 
             * @return switch HTML
             */
            function displaySwitchInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $extra_group_id = $args['extra_group_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label class="dopbsp-for-switch">'.$label.'</label>');
                array_push($html, '     <div class="dopbsp-switch">');
                array_push($html, '         <input type="checkbox" name="DOPBSP-extra-group-'.$id.'-'.$extra_group_id.'" id="DOPBSP-extra-group-'.$id.'-'.$extra_group_id.'" class="dopbsp-switch-checkbox" onchange="DOPBSPBackEndExtraGroup.edit('.$extra_group_id.', \'switch\', \''.$id.'\')"'.($value == 'true' ? ' checked="checked"':'').' />');
                array_push($html, '         <label class="dopbsp-switch-label" for="DOPBSP-extra-group-'.$id.'-'.$extra_group_id.'">');
                array_push($html, '             <div class="dopbsp-switch-inner"></div>');
                array_push($html, '             <div class="dopbsp-switch-switch"></div>');
                array_push($html, '         </label>');
                array_push($html, '     </div>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help dopbsp-switch-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                array_push($html, ' <style type="text/css">');
                array_push($html, '     .DOPBSP-admin .dopbsp-input-wrapper .dopbsp-switch .dopbsp-switch-inner:before{content: "'.$DOPBSP->text('SETTINGS_ENABLED').'";}');
                array_push($html, '     .DOPBSP-admin .dopbsp-input-wrapper .dopbsp-switch .dopbsp-switch-inner:after{content: "'.$DOPBSP->text('SETTINGS_DISABLED').'";}');
                array_push($html, ' </style>');
                
                echo implode('', $html);
            }
        }
    }