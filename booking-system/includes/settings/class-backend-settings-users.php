<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/settings/class-backend-settings-users.php
* File Version            : 1.0.7
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end settings PHP class. The file is different than PRO version.
*/

    if (!class_exists('DOPBSPBackEndSettingsUsers')){
        class DOPBSPBackEndSettingsUsers extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Display users settings.
             * 
             * @post calendar_id (integer): calendar ID
             * 
             * @return users settings HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $calendar_id = $DOT->post('calendar_id', 'int');
                
                if ($calendar_id == 0){
                    $DOPBSP->views->backend_settings_users->template();
                }
                else{
                    $DOPBSP->views->backend_settings_users->templateUsers($calendar_id);
                }
                
                die();
            }
            
            /*
             * Initialize users permissions.
             */
            function init(){
                global $wp_roles;
                
                $roles = $wp_roles->get_names();
                
                while ($data = current($roles)){
                    switch (key($roles)){
                        case 'administrator':
                            get_option('DOPBSP_users_permissions_administrator') == '' ? add_option('DOPBSP_users_permissions_administrator', DOPBSP_CONFIG_USERS_PERMISSIONS_ADMINISTRATORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_administrator') == '' ? add_option('DOPBSP_users_permissions_custom_posts_administrator', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_ADMINISTRATORS):'';
                            break;
                        case 'author':
                            get_option('DOPBSP_users_permissions_author') == '' ? add_option('DOPBSP_users_permissions_author', DOPBSP_CONFIG_USERS_PERMISSIONS_AUTHORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_author') == '' ? add_option('DOPBSP_users_permissions_custom_posts_author', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_AUTHORS):'';
                            break;
                        case 'contributor':
                            get_option('DOPBSP_users_permissions_contributor') == '' ? add_option('DOPBSP_users_permissions_contributor', DOPBSP_CONFIG_USERS_PERMISSIONS_CONTRIBUTORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_contributor') == '' ? add_option('DOPBSP_users_permissions_custom_posts_contributor', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_CONTRIBUTORS):'';
                            break;
                        case 'editor':
                            get_option('DOPBSP_users_permissions_editor') == '' ? add_option('DOPBSP_users_permissions_editor', DOPBSP_CONFIG_USERS_PERMISSIONS_EDITORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_editor') == '' ? add_option('DOPBSP_users_permissions_custom_posts_editor', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_EDITORS):'';
                            break;
                        case 'subscriber':
                            get_option('DOPBSP_users_permissions_subscriber') == '' ? add_option('DOPBSP_users_permissions_subscriber', DOPBSP_CONFIG_USERS_PERMISSIONS_SUBSCRIBERS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_subscriber') == '' ? add_option('DOPBSP_users_permissions_custom_posts_subscriber', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_SUBSCRIBERS):'';
                            break;
                        default:
                            get_option('DOPBSP_users_permissions_'.key($roles)) == '' ? add_option('DOPBSP_users_permissions_'.key($roles), DOPBSP_CONFIG_USERS_PERMISSIONS_OTHERS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_'.key($roles)) == '' ? add_option('DOPBSP_users_permissions_custom_posts_'.key($roles), DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_OTHERS):'';
                    }
                    next($roles);                        
                }
            }
            
            /*
             * Get users list.
             * 
             * @post calendar_id (integer): calendar ID
             * @post number (integer): users number
             * @post offset (integer): users offset
             * @post order (string): users order "ASC"/"DESC"
             * @post orderby (string): users order by field "email"/"ID"/"login"
             * @post role (string): users role
             * @post search (string): users search string
             * 
             * @return HTML users list
             */
            function get(){
		global $DOT;
                global $wp_roles;
		
                $HTML = array();
                
                $calendar_id = $DOT->post('calendar_id', 'int');
                
                $users = get_users(array('number' => '',
                                         'offset' => '',
                                         'order' => $DOT->post('order'),
                                         'orderby' => $DOT->post('orderby'),
                                         'role' => $DOT->post('role'),
                                         'search' => $DOT->post('search')));
                
                foreach ($users as $user){
                    $roles = array();
                    
                    foreach ($user->roles as $role){
                        array_push($roles, $wp_roles->roles[$role]['name']);
                    }
                    
                    if ($calendar_id == 0){
			/*
			 * Use booking system setting.
			 */
                        array_push($HTML, '<tr>');
                        array_push($HTML, ' <td>'.$user->ID.'</td>');
                        array_push($HTML, ' <td>'.get_avatar($user->ID, 18, '', $user->first_name.' '.$user->last_name).$user->user_login.'<br />'.$user->first_name.' '.$user->last_name.'</td>');
                        array_push($HTML, ' <td>'.$user->user_email.'</td>');
                        array_push($HTML, ' <td>'.implode('<br />', $roles).'</td>');
                        array_push($HTML, ' <td>');
			array_push($HTML, '	<div class="dopbsp-input-wrapper">');
			array_push($HTML, '	    <input type="checkbox" name="DOPBSP-settings-users-permissions-use-'.$user->ID.'" id="DOPBSP-settings-users-permissions-use-'.$user->ID.'" onclick="DOPBSPBackEndSettingsUsers.set('.$user->ID.', \'use\')" '.($this->permission($user->ID, 'use-booking-system', 0) ? 'checked="checked"':'').($user->roles[0] == 'administrator' ? ' disabled="disabled"':'').' />');
			array_push($HTML, '	</div>');
                        array_push($HTML, ' </td>');
                        array_push($HTML, '</tr>');
                    }
                }
                
                echo implode('', $HTML);
                
                die();
            }
            
            /*
             * Set user permissions.
             * 
             * @param id (integer): user ID; 0 for general settings
             * @param slug (string): option/meta slug
             * @param value (integer): permissions value "0" and/or "1"
             * @param calendar_id (integer): calendar ID
             * 
             * @param args (array): function arguments
             *                          "calendar_id" (integer): calendar ID
             *                          "id" (integer): user ID; 0 for general settings
             *                          "slug" (string): option/meta slug
             *                          "value" (integer): permissions value "0" and/or "1"
             */
            function set($args = array('calendar_id' => 0,
                                       'id' => 0,
                                       'slug' => '',
                                       'value' => 0)){
		global $DOT;
		
                $id = $DOT->post('id', 'int') != 0 ? $DOT->post('id', 'int'):$args['id'];
                $slug = $DOT->post('slug') ? $DOT->post('slug'):$args['slug'];
                $value = $DOT->post('value', 'int') != 0 ? $DOT->post('value', 'int'):(int)$args['value'];
                $calendar_id = $DOT->post('calendar_id', 'int') != 0 ? $DOT->post('calendar_id', 'int'):(int)$args['calendar_id'];
                
                if ($id == 0){
                    update_option('DOPBSP_users_permissions_'.$slug, $value);
                }
                else{
                    if ($calendar_id == 0){
                        if (get_user_meta($id, 'DOPBSP_permissions_'.$slug, true) == ''){
                            add_user_meta($id, 'DOPBSP_permissions_'.$slug, $value, true);
                        }
                        else{
                            update_user_meta($id, 'DOPBSP_permissions_'.$slug, $value);
                        }
                    }
                    else{
                        if (get_user_meta($id, 'DOPBSP_permissions_calendars', true) == ''){
                            if ($value == 1){
                                add_user_meta($id, 'DOPBSP_permissions_calendars', ','.$calendar_id.',', true);
                            }
                        }
                        else{
                            $calendars = get_user_meta($id, 'DOPBSP_permissions_calendars', true);
                            
                            if ($value == 1){
                                update_user_meta($id, 'DOPBSP_permissions_calendars', $calendars.$calendar_id.',');
                            }
                            else{
                                $calendars_list = explode(',', $calendars);
                                $calendars_new = array();
                                
                                for ($i=1; $i<count($calendars_list)-1; $i++){
                                    if ((int)$calendars_list[$i] != $calendar_id){
                                        array_push($calendars_new, $calendars_list[$i]);
                                    }
                                }
                                update_user_meta($id, 'DOPBSP_permissions_calendars', count($calendars_new) == 0 ? ',':','.implode(',', $calendars_new).',');
                            }
                        }
                    }
                }
                
                die();
            }
            
            /*
             * Check if user has permission.
             * 
             * @param id (integer): user ID
             * @param do (string): user permission
             *                     "use-booking-system": user can use the plugin
             *                     "use-custom-posts": user can use custom posts
             *                     "use-calendars": user can use calendars set by an administrtor
             *                     "view-all-calendars": administrator can view all calendars
             * @param calendar_id (integer): calendar ID
             * 
             * @return: true/false
             */
            function permission($id, 
                                $do,
                                $calendar_id = 0){
                if ($id == 0){
                    return false;
                }
                
                $user = get_userdata($id);
                $user_roles = array_values($user->roles);
                
                switch ($do){
                    case 'view-all-calendars':
                        if ($user_roles[0] == 'administrator'){
                            if (get_user_meta($id, 'DOPBSP_permissions_view', true) != ''){
                                if (get_user_meta($id, 'DOPBSP_permissions_view', true) == 1){
                                    return true;
                                }
                                else{
                                    return false;
                                }
                            }
                            else{
                                if (get_option('DOPBSP_users_permissions_administrator') == 1){
                                    return true;
                                }
                                else{
                                    return false;
                                }
                            }
                        }
                        else{
                            return false;
                        }
                        break;
                    case 'use-booking-system':
                        if ($user_roles[0] == 'administrator'){
                            return true;
                        }
                        else{
                            if (get_user_meta($id, 'DOPBSP_permissions_use', true) != ''){
                                if (get_user_meta($id, 'DOPBSP_permissions_use', true) == 1){
                                    return true;
                                }
                                else{
                                    return false;
                                }
                            }
                            else{
                                foreach ($user->roles as $role){
                                    if (get_option('DOPBSP_users_permissions_'.$role) == 1){
                                        return true;
                                    }
                                }
                                return false;
                            }
                        }
                        break;
                    case 'use-custom-posts':
                        if (get_user_meta($id, 'DOPBSP_permissions_custom_posts', true) != ''){
                            if (get_user_meta($id, 'DOPBSP_permissions_custom_posts', true) == 1){
                                return true;
                            }
                            else{
                                return false;
                            }
                        }
                        else{
                            foreach ($user->roles as $role){
                                if (get_option('DOPBSP_users_permissions_custom_posts_'.$role) == 1){
                                    return true;
                                }
                            }
                            return false;
                        }
                        break;
                    case 'use-calendars':
                        if (get_user_meta($id, 'DOPBSP_permissions_calendars', true) != ''
                                && get_user_meta($id, 'DOPBSP_permissions_calendars', true) != ','){
                            return true;
                        }
                        else{
                            return false;
                        }
                        break;
                    case 'use-calendar':
                        if (get_user_meta($id, 'DOPBSP_permissions_calendars', true) != ''){
                            $calendars = get_user_meta($id, 'DOPBSP_permissions_calendars', true);
                            
                            if (strpos($calendars, ','.$calendar_id.',') === false){
                                return false;
                            }
                            else{
                                return true;
                            }
                        }
                        else{
                            return false;
                        }
                        break;
                }
                
                return false;
            }
        }
    }