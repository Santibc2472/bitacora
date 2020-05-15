<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.8
* File                    : views/settings/views-backend-settings-users.php
* File Version            : 1.0
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end users settings views class. The file is different than PRO version.
*/

    if (!class_exists('DOPBSPViewsBackEndSettingsUsers')){
        class DOPBSPViewsBackEndSettingsUsers extends DOPBSPViewsBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns users settings template.
             * 
             * @param args (array): function arguments
             * 
             * @return users settings HTML
             */
            function template($args = array()){
                /*
                 * Users roles for booking system permissions.
                 */
                $this->templateDefault();
                
                /*
                 * Users
                 */
                $this->templateUsers();
            }
            
            /*
             * Display users roles for booking system permissions.
             * 
             * @return user roles HTML
             */
            function templateDefault(){
                global $wp_roles;
                global $DOPBSP;
                
                $roles = $wp_roles->get_names();
?>
                <div class="dopbsp-inputs-header dopbsp-display">
                    <h3><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('users-permissions')" id="DOPBSP-inputs-button-users-permissions" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-users-permissions" class="dopbsp-inputs-wrapper dopbsp-hidden">
<?php
                while ($data = current($roles)){
		    if (key($roles) != 'administrator'){
?>                      
                    <div class="dopbsp-input-wrapper">
                        <input type="checkbox" name="DOPBSP-settings-users-permissions-<?php echo key($roles); ?>" id="DOPBSP-settings-users-permissions-<?php echo key($roles); ?>" onclick="DOPBSPBackEndSettingsUsers.set(0, '<?php echo key($roles); ?>')" <?php echo get_option('DOPBSP_users_permissions_'.key($roles)) > 0 ? ' checked=checked':''; ?> />
                        <label class="dopbsp-for-checkbox" for="DOPBSP-settings-users-permissions-<?php echo key($roles); ?>"><?php printf(key($roles) == 'administrator' ? $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_ADMINISTRATORS_LABEL'):$DOPBSP->text('SETTINGS_USERS_PERMISSIONS_LABEL'), '<strong>'.__(strtolower($data)).'</strong>'); ?></label>
                    </div>
<?php                        
		    }
                    next($roles);                        
                }
?>
                </div>
<?php           
            }
            
            /*
             * Display users template.
             * 
             * @param calendar_id (integer): calendar ID
             * 
             * @param user area HTML
             */
            function templateUsers($calendar_id = 0){
                global $wp_roles;
                global $DOPBSP;
                
                $roles = $wp_roles->get_names();
                
                if ($calendar_id == 0){
?>
                <div class="dopbsp-inputs-header dopbsp-last dopbsp-display">
                    <h3><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_INDIVIDUAL'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('users')" id="DOPBSP-inputs-button-users" class="dopbsp-button"></a>
                </div>

                <div id="DOPBSP-inputs-users" class="dopbsp-inputs-wrapper dopbsp-last dopbsp-hidden">
<?php
                }
                else{
?>

                <div class="dopbsp-inputs-wrapper dopbsp-last">
<?php
                }
?>
                    
                    <!-- 
                        Search by role.
                    -->
                    <div class="dopbsp-input-wrapper dopbsp-left">
                        <label for="DOPBSP-settings-users-permissions-filters-role"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE'); ?></label>
                        <select name="DOPBSP-settings-users-permissions-filters-role" id="DOPBSP-settings-users-permissions-filters-role" onchange="DOPBSPBackEndSettingsUsers.get(<?php echo $calendar_id; ?>)">
                            <option value=""><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE_ALL'); ?></option>
<?php           
                while ($data = current($roles)){
                    if ($calendar_id === 0){
                        echo '<option value="'.key($roles).'">'.$data.'</option>';
                    }
                    else{
                        if (key($roles) !== 'administrator'){
                            echo '<option value="'.key($roles).'">'.$data.'</option>';
                        }
                    }
                    next($roles);                        
                }
?>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-settings-users-permissions-filters-role').DOPSelect();</script>
                    </div>
                    
                    <!--
                        Order by.
                    -->
                    <div class="dopbsp-input-wrapper dopbsp-left">
                        <label for="DOPBSP-settings-users-permissions-filters-order-by"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY'); ?></label>
                        <select name="DOPBSP-settings-users-permissions-filters-order-by" id="DOPBSP-settings-users-permissions-filters-order-by" onchange="DOPBSPBackEndSettingsUsers.get(<?php echo $calendar_id; ?>)">
                            <option value="email"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_EMAIL'); ?></option>
                            <option value="ID"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_ID'); ?></option>
                            <option value="login" selected="selected"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_USERNAME'); ?></option>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-settings-users-permissions-filters-order-by').DOPSelect();</script>
                    </div>
                    
                    <!--
                        Order
                    -->
                    <div class="dopbsp-input-wrapper dopbsp-left">
                        <label for="DOPBSP-settings-users-permissions-filters-order"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER'); ?></label>
                        <select name="DOPBSP-settings-users-permissions-filters-order" id="DOPBSP-settings-users-permissions-filters-order" onchange="DOPBSPBackEndSettingsUsers.get(<?php echo $calendar_id; ?>)">
                            <option value="ASC"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_ASCENDING'); ?></option>
                            <option value="DESC"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_DESCENDING'); ?></option>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-settings-users-permissions-filters-order').DOPSelect();</script>
                    </div>
                    
                    <!-- 
                        Search by text.
                    -->
                    <div class="dopbsp-input-wrapper dopbsp-left">
                        <label for="DOPBSP-settings-users-permissions-filters-search"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_SEARCH'); ?></label>
                        <input type="text" name="DOPBSP-settings-users-permissions-filters-search" id="DOPBSP-settings-users-permissions-filters-search" value="" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndSettingsUsers.get(<?php echo $calendar_id; ?>);}" onpaste="if ((event.keyCode||event.which) != 9){DOPBSPBackEndSettings.getUsers(<?php echo $calendar_id; ?>);}" />
                    </div>
                    
                    <!--
                        Users list.
                    -->
                    <table class="dopbsp-users-table">
                        <colgroup>
                            <!--<col class="column1" />-->
                            <col class="dopbsp-column2" />
                            <col class="dopbsp-column3" />
                            <col class="dopbsp-column4" />
                            <col class="dopbsp-column5" />
                            <col class="dopbsp-column6" />
                        </colgroup>
                        <thead>
                            <tr>
                                <!--<th></th>-->
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_LIST_ID'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_USERNAME'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_EMAIL'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_ROLE'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_USE'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="DOPBSP-users-list"></tbody>
                    </table>
                </div>
<?php                
            }
        }
    }