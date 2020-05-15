<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : views/extras/views-backend-extra-groups.php
* File Version            : 1.0.7
* Created / Last Modified : 17 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra groups views class.
*/

    if (!class_exists('DOPBSPViewsBackEndExtraGroups')){
        class DOPBSPViewsBackEndExtraGroups extends DOPBSPViewsBackEndExtra{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns extra groups tempalte.
             * 
             * @param args (array): function arguments
             *                      * id (integer): extra ID
             *                      * language (string): extra language
             * 
             * @return extra groups HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                <div class="dopbsp-extra-groups-header">
                    <a href="javascript:DOPBSPBackEndExtraGroup.add(<?php echo $id; ?>, '<?php echo $language; ?>')" class="dopbsp-button dopbsp-add"><span class="dopbsp-info"><?php echo $DOPBSP->text('EXTRAS_EXTRA_ADD_GROUP_SUBMIT'); ?></span></a>
                    <h3><?php echo $DOPBSP->text('EXTRAS_EXTRA_GROUPS'); ?></h3>
                </div>
                <ul id="DOPBSP-extra-groups" class="dopbsp-extra-groups">
<?php
                $groups = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->extras_groups.' WHERE extra_id=%d ORDER BY position ASC',
                                                            $id));
                
                if ($wpdb->num_rows > 0){
                    foreach($groups as $group){
                        $DOPBSP->views->backend_extra_group->template(array('group' => $group,
                                                                    'language' => $language));
                    }
                }
?>    
                </ul>
<?php                    
            }
        }
    }