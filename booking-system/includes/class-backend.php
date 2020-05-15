<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/class-backend.php
* File Version            : 1.3.9
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end PHP class. The file is different than PRO version.
*/

    if (!class_exists('DOPBSPBackEnd')){
        class DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
                global $pagenow;
                
                /*
                 * Init back end.
                 */
                add_action('init', array(&$this, 'init'));
                
                /*
                 * Add styles needed outside plugin pages.
                 */
                add_action('admin_enqueue_scripts', array(&$this, 'addWPAdminStyles'));
                
                /*
                 * Add widgets scripts.
                 */
                if ($pagenow == 'widgets.php'){
                    add_action('admin_enqueue_scripts', array(&$this, 'addWidgetScripts'));
                }
                
                /*
                 * Add styles and scripts only on plugin pages.
                 */
                if ($this->validPage()){
                    add_action('admin_enqueue_scripts', array(&$this, 'addStyles'));
                    add_action('admin_enqueue_scripts', array(&$this, 'addScripts'));
                } 
                else{
                    add_action('admin_enqueue_scripts', array(&$this, 'addWPAdminScripts'));
                }
                
                /*
                 * Initialize rating request.
                 */
                add_action('admin_notices', array(&$this, 'rating'));
            }
            
            /*
             * Add plugin's CSS files outside plugin's pages.
             */
            function addWPAdminStyles(){
                global $DOPBSP;
                
                /*
                 * Register Styles.
                 */
                wp_register_style('DOPBSP-css-backend-wp-admin', $DOPBSP->paths->url.'assets/gui/css/backend-wp-admin.css');
                wp_register_style('DOPBSP-css-backend-shortcodes', $DOPBSP->paths->url.'assets/gui/css/backend-shortcodes.css');
                
                /*
                 * Enqueue Styles.
                 */
                wp_enqueue_style('DOPBSP-css-backend-wp-admin');
                wp_enqueue_style('DOPBSP-css-backend-shortcodes');
            }
            
            /*
             * Add plugin's CSS files.
             */
            function addStyles(){
                global $DOPBSP;
                
                /*
                 * Register styles.
                 */
                wp_register_style('DOPBSP-css-dopselect', $DOPBSP->paths->url.'libraries/css/jquery.dop.Select.css');
                wp_register_style('DOPBSP-css-businesses', $DOPBSP->paths->url.'libraries/css/pinpoint-businesses.css');
                wp_register_style('DOPBSP-css-backend', $DOPBSP->paths->url.'assets/gui/css/backend.css');
                
                wp_register_style('DOPBSP-css-backend-addons', $DOPBSP->paths->url.'assets/gui/css/backend-addons.css');
                wp_register_style('DOPBSP-css-backend-calendar', $DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPCalendar'.(DOPBSP_DEVELOPMENT_MODE ? '.alpha':'').'.css');
                wp_register_style('DOPBSP-css-backend-coupons', $DOPBSP->paths->url.'assets/gui/css/backend-coupons.css');
                wp_register_style('DOPBSP-css-backend-dashboard', $DOPBSP->paths->url.'assets/gui/css/backend-dashboard.css');
                wp_register_style('DOPBSP-css-backend-discounts', $DOPBSP->paths->url.'assets/gui/css/backend-discounts.css');
                wp_register_style('DOPBSP-css-backend-emails', $DOPBSP->paths->url.'assets/gui/css/backend-emails.css');
                wp_register_style('DOPBSP-css-backend-extras', $DOPBSP->paths->url.'assets/gui/css/backend-extras.css');
                wp_register_style('DOPBSP-css-backend-forms', $DOPBSP->paths->url.'assets/gui/css/backend-forms.css');
                wp_register_style('DOPBSP-css-backend-locations', $DOPBSP->paths->url.'assets/gui/css/backend-locations.css');
                wp_register_style('DOPBSP-css-backend-pro', $DOPBSP->paths->url.'assets/gui/css/backend-pro.css');
                wp_register_style('DOPBSP-css-backend-reservations', $DOPBSP->paths->url.'assets/gui/css/backend-reservations.css');
                wp_register_style('DOPBSP-css-backend-reservations-add', $DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPReservationsAdd.css');
                wp_register_style('DOPBSP-css-backend-reservations-calendar', $DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPReservationsCalendar.css');
                wp_register_style('DOPBSP-css-backend-settings', $DOPBSP->paths->url.'assets/gui/css/backend-settings.css');
                wp_register_style('DOPBSP-css-backend-smses', $DOPBSP->paths->url.'assets/gui/css/backend-smses.css');
                wp_register_style('DOPBSP-css-backend-themes', $DOPBSP->paths->url.'assets/gui/css/backend-themes.css');
                wp_register_style('DOPBSP-css-backend-tools', $DOPBSP->paths->url.'assets/gui/css/backend-tools.css');
                wp_register_style('DOPBSP-css-backend-translation', $DOPBSP->paths->url.'assets/gui/css/backend-translation.css');

                /*
                 * Enqueue styles.
                 */
                wp_enqueue_style('thickbox');
                wp_enqueue_style('DOPBSP-css-dopselect');
                wp_enqueue_style('DOPBSP-css-businesses');
                wp_enqueue_style('DOPBSP-css-backend');
                wp_enqueue_style('DOPBSP-css-backend-addons');
                wp_enqueue_style('DOPBSP-css-backend-calendar');
                wp_enqueue_style('DOPBSP-css-backend-coupons');
                wp_enqueue_style('DOPBSP-css-backend-dashboard');
                wp_enqueue_style('DOPBSP-css-backend-emails');
                wp_enqueue_style('DOPBSP-css-backend-discounts');
                wp_enqueue_style('DOPBSP-css-backend-extras');
                wp_enqueue_style('DOPBSP-css-backend-forms');
                wp_enqueue_style('DOPBSP-css-backend-locations');
                wp_enqueue_style('DOPBSP-css-backend-pro');
                wp_enqueue_style('DOPBSP-css-backend-reservations');
                wp_enqueue_style('DOPBSP-css-backend-reservations-add');
                wp_enqueue_style('DOPBSP-css-backend-reservations-calendar');
                wp_enqueue_style('DOPBSP-css-backend-settings');
                wp_enqueue_style('DOPBSP-css-backend-smses');
                wp_enqueue_style('DOPBSP-css-backend-themes');
                wp_enqueue_style('DOPBSP-css-backend-tools');
                wp_enqueue_style('DOPBSP-css-backend-translation');
            }
            
            /*
             * Get plugin's CSS files.
             */
            function getStyles(){
                global $DOPBSP;
                
                $HTML =  array();
                
                /*
                 * Register styles.
                 */
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'libraries/css/jquery.dop.Select.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'libraries/css/pinpoint-businesses.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend.css">');
                
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-addons.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-coupons.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-dashboard.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-discounts.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-emails.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-extras.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-forms.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-locations.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-pro.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-reservations.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPReservationsAdd.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPReservationsCalendar.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-settings.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-smses.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-themes.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-tools.css">');
                array_push($HTML, '<link rel="stylesheet" href="'.$DOPBSP->paths->url.'assets/gui/css/backend-translation.css">');
                
                return $HTML;
            } // to add
            
            /*
             * Add admin JavaScript files.
             */
            function addWPAdminScripts(){
                global $DOPBSP;
                
                /*
                 * Register JavaScript.
                 */
                wp_register_script('DOPBSP-js-backend-shortcodes', $DOPBSP->paths->url.'assets/js/shortcodes/backend-shortcodes.js', array('jquery'), false, true);
                
                /*
                 * Enqueue JavaScript.
                 */
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                /*
                 * Enqueue JavaScript.
                 */
                wp_enqueue_script('DOPBSP-js-backend-shortcodes');
            }
            
            /*
             * Add widget JavaScript files.
             */
            function addWidgetScripts(){
                global $DOPBSP;
                
                /*
                 * Register JavaScript.
                 */
                wp_register_script('DOPBSP-js-backend-widget', $DOPBSP->paths->url.'assets/js/widgets/backend-widgets.js', array('jquery'), false, true);
                
                /*
                 * Enqueue JavaScript.
                 */
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                wp_enqueue_script('DOPBSP-js-backend-widget');
            }
            
            /*
             * Add plugin's JavaScript files.
             */
            function addScripts(){
		global $DOT;
                global $DOPBSP;
                
                /*
                 * Register JavaScript.
                 */
                
                /*
                 * Libraries.
                 */
                wp_register_script('DOP-js-prototypes', $DOPBSP->paths->url.'libraries/js/dop-prototypes.js', array('jquery'));
                wp_register_script('DOP-Google-Calendar', $DOPBSP->paths->url.'libraries/js/dop-google-calendar.js', array('jquery'));
                wp_register_script('DOP-js-jquery-dopselect', $DOPBSP->paths->url.'libraries/js/jquery.dop.Select.js', array('jquery'));
                wp_register_script('DOPBSP-js-isotope', $DOPBSP->paths->url.'libraries/js/isotope.pkgd.min.js', array('jquery'), false, true);
                
                /*
                 * Back end.
                 */
                wp_register_script('DOPBSP-js-backend', $DOPBSP->paths->url.'assets/js/backend.js', array('jquery'), false, true);
                
                /*
                 * Front end.
                 */
                wp_register_script('DOPBSP-js-frontend', $DOPBSP->paths->url.'assets/js/frontend.js', array('jquery'), false, true);
                
                /*
                 * Addons
                 */
                wp_register_script('DOPBSP-js-backend-addons', $DOPBSP->paths->url.'assets/js/addons/backend-addons.js', array('jquery'), false, true);
                
                /*
                 * Amenities
                 */
                wp_register_script('DOPBSP-js-backend-amenities', $DOPBSP->paths->url.'assets/js/amenities/backend-amenities.js', array('jquery'), false, true);
                
                /*
                 * API
                 */
                wp_register_script('DOPBSP-js-backend-api', $DOPBSP->paths->url.'assets/js/api/backend-api.js', array('jquery'), false, true);
                
                /*
                 * Calendars
                 */
                wp_register_script('DOPBSP-js-jquery-backend-calendar', $DOPBSP->paths->url.'assets/js/jquery.dop.backend.BSPCalendar'.(DOPBSP_DEVELOPMENT_MODE ? '.alpha':'').'.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-calendars', $DOPBSP->paths->url.'assets/js/calendars/backend-calendars.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-calendar', $DOPBSP->paths->url.'assets/js/calendars/backend-calendar.js', array('jquery'), false, true);
                
                /*
                 * Coupons
                 */
                wp_register_script('DOPBSP-js-backend-coupons', $DOPBSP->paths->url.'assets/js/coupons/backend-coupons.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-coupon', $DOPBSP->paths->url.'assets/js/coupons/backend-coupon.js', array('jquery'), false, true);
                
                /*
                 * Dashboard
                 */
                wp_register_script('DOPBSP-js-backend-dashboard', $DOPBSP->paths->url.'assets/js/dashboard/backend-dashboard.js', array('jquery'), false, true);
                
                /*
                 * Deposit
                 */
                wp_register_script('DOPBSP-js-frontend-deposit', $DOPBSP->paths->url.'assets/js/deposit/frontend-deposit.js', array('jquery'), false, true);
                
                /*
                 * Discounts
                 */
                wp_register_script('DOPBSP-js-backend-discounts', $DOPBSP->paths->url.'assets/js/discounts/backend-discounts.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount', $DOPBSP->paths->url.'assets/js/discounts/backend-discount.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-items', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-items.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-item', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-item.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-item-rules', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-item-rules.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-item-rule', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-item-rule.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-frontend-discounts', $DOPBSP->paths->url.'assets/js/discounts/frontend-discounts.js', array('jquery'), false, true);
                
                /*
                 * Emails
                 */
                wp_register_script('DOPBSP-js-backend-emails', $DOPBSP->paths->url.'assets/js/emails/backend-emails.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-email', $DOPBSP->paths->url.'assets/js/emails/backend-email.js', array('jquery'), false, true);
                
                /*
                 * Extras
                 */
                wp_register_script('DOPBSP-js-backend-extras', $DOPBSP->paths->url.'assets/js/extras/backend-extras.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra', $DOPBSP->paths->url.'assets/js/extras/backend-extra.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-groups', $DOPBSP->paths->url.'assets/js/extras/backend-extra-groups.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-group', $DOPBSP->paths->url.'assets/js/extras/backend-extra-group.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-group-items', $DOPBSP->paths->url.'assets/js/extras/backend-extra-group-items.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-group-item', $DOPBSP->paths->url.'assets/js/extras/backend-extra-group-item.js', array('jquery'), false, true);
                
                /*
                 * Fees
                 */
                wp_register_script('DOPBSP-js-backend-fees', $DOPBSP->paths->url.'assets/js/fees/backend-fees.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-fee', $DOPBSP->paths->url.'assets/js/fees/backend-fee.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-frontend-fees', $DOPBSP->paths->url.'assets/js/fees/frontend-fees.js', array('jquery'), false, true);
                
                /*
                 * Forms
                 */
                wp_register_script('DOPBSP-js-backend-forms', $DOPBSP->paths->url.'assets/js/forms/backend-forms.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form', $DOPBSP->paths->url.'assets/js/forms/backend-form.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-fields', $DOPBSP->paths->url.'assets/js/forms/backend-form-fields.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-field', $DOPBSP->paths->url.'assets/js/forms/backend-form-field.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-field-select-options', $DOPBSP->paths->url.'assets/js/forms/backend-form-field-select-options.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-field-select-option', $DOPBSP->paths->url.'assets/js/forms/backend-form-field-select-option.js', array('jquery'), false, true);
                
                /*
                 * Languages
                 */
                wp_register_script('DOPBSP-js-backend-languages', $DOPBSP->paths->url.'assets/js/languages/backend-languages.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-language', $DOPBSP->paths->url.'assets/js/languages/backend-language.js', array('jquery'), false, true);
                
                /*
                 * Locations
                 */
                wp_register_script('DOPBSP-js-backend-locations', $DOPBSP->paths->url.'assets/js/locations/backend-locations.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-location', $DOPBSP->paths->url.'assets/js/locations/backend-location.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-location-map', $DOPBSP->paths->url.'assets/js/locations/backend-location-map.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-location-map-hints', $DOPBSP->paths->url.'assets/js/locations/backend-location-map-hints.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-location-map-marker', $DOPBSP->paths->url.'assets/js/locations/backend-location-map-marker.js', array('jquery'), false, true);
                
                /*
                 * Models.
                 */
                wp_register_script('DOPBSP-js-backend-models', $DOPBSP->paths->url.'assets/js/models/backend-models.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-model', $DOPBSP->paths->url.'assets/js/models/backend-model.js', array('jquery'), false, true);
                
                /*
                 * PRO
                 */
                wp_register_script('DOPBSP-js-backend-pro', $DOPBSP->paths->url.'assets/js/pro/backend-pro.js', array('jquery'), false, true);
                
                /*
                 * Reservations
                 */
                wp_register_script('DOPBSP-js-jquery-backend-reservations-add', $DOPBSP->paths->url.'assets/js/jquery.dop.backend.BSPReservationsAdd.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-jquery-backend-reservations-calendar', $DOPBSP->paths->url.'assets/js/jquery.dop.backend.BSPReservationsCalendar.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations-add', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations-add.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations-calendar', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations-calendar.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations-list', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations-list.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservation', $DOPBSP->paths->url.'assets/js/reservations/backend-reservation.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservation-form', $DOPBSP->paths->url.'assets/js/reservations/backend-reservation-form.js', array('jquery'), false, true);
                
                /*
                 * Reviews
                 */
                wp_register_script('DOPBSP-js-backend-reviews', $DOPBSP->paths->url.'assets/js/reviews/backend-reviews.js', array('jquery'), false, true);
                
                /*
                 * Rules
                 */
                wp_register_script('DOPBSP-js-backend-rules', $DOPBSP->paths->url.'assets/js/rules/backend-rules.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-rule', $DOPBSP->paths->url.'assets/js/rules/backend-rule.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-frontend-rules', $DOPBSP->paths->url.'assets/js/rules/frontend-rules.js', array('jquery'), false, true);
                
                /*
                 * Settings
                 */
                wp_register_script('DOPBSP-js-backend-settings', $DOPBSP->paths->url.'assets/js/settings/backend-settings.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-calendar', $DOPBSP->paths->url.'assets/js/settings/backend-settings-calendar.js', array('jquery'), false, true);
                wp_register_script('Google-Calendar', 'https://apis.google.com/js/client.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-notifications', $DOPBSP->paths->url.'assets/js/settings/backend-settings-notifications.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-payment-gateways', $DOPBSP->paths->url.'assets/js/settings/backend-settings-payment-gateways.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-licences', $DOPBSP->paths->url.'assets/js/settings/backend-settings-licences.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-users', $DOPBSP->paths->url.'assets/js/settings/backend-settings-users.js', array('jquery'), false, true);
                
                /*
                 * SMSes
                 */
                wp_register_script('DOPBSP-js-backend-smses', $DOPBSP->paths->url.'assets/js/smses/backend-smses.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-sms', $DOPBSP->paths->url.'assets/js/smses/backend-sms.js', array('jquery'), false, true);
                
                /*
                 * Templates
                 */
                wp_register_script('DOPBSP-js-backend-templates', $DOPBSP->paths->url.'assets/js/templates/backend-templates.js', array('jquery'), false, true);
                
                /*
                 * Themes
                 */
                wp_register_script('DOPBSP-js-backend-themes', $DOPBSP->paths->url.'assets/js/themes/backend-themes.js', array('jquery'), false, true);
                
                /*
                 * Tools
                 */
                wp_register_script('DOPBSP-js-backend-tools', $DOPBSP->paths->url.'assets/js/tools/backend-tools.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-tools-repair-calendars-settings', $DOPBSP->paths->url.'assets/js/tools/backend-tools-repair-calendars-settings.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-tools-repair-database-text', $DOPBSP->paths->url.'assets/js/tools/backend-tools-repair-database-text.js', array('jquery'), false, true);
                
                /*
                 * Translation
                 */
                wp_register_script('DOPBSP-js-backend-translation', $DOPBSP->paths->url.'assets/js/translation/backend-translation.js', array('jquery'), false, true);
		
		/*
		 * Framework
		 */
                wp_register_script('dot-js', $DOT->paths->url.'/application/assets/js/dot.js', array('jquery'), false, true);
                wp_register_script('dot-js-calendar', $DOT->paths->url.'/application/assets/js/calendars/calendar.js', array('jquery'), false, true);
                wp_register_script('dot-js-calendar-availability', $DOT->paths->url.'/application/assets/js/calendars/calendar-availability.js', array('jquery'), false, true);
                wp_register_script('dot-js-calendar-days', $DOT->paths->url.'/application/assets/js/calendars/calendar-days.js', array('jquery'), false, true);
                wp_register_script('dot-js-calendar-day', $DOT->paths->url.'/application/assets/js/calendars/calendar-day.js', array('jquery'), false, true);
                wp_register_script('dot-js-calendar-schedule', $DOT->paths->url.'/application/assets/js/calendars/calendar-schedule.js', array('jquery'), false, true);

                /*
                 * Enqueue JavaScript.
                 */
                
                /*
                 * Libraries.
                 */
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                if (!wp_script_is('jquery-effects-core', 'queue')){
                    wp_enqueue_script('jquery-effects-core');
                }
                
                if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                    wp_enqueue_script('jquery-ui-datepicker');
                }
                
                if (!wp_script_is('jquery-ui-sortable', 'queue')){
                    wp_enqueue_script('jquery-ui-sortable');
                }
                
                wp_enqueue_script('DOP-js-prototypes');
                wp_enqueue_script('DOP-Google-Calendar');
                wp_enqueue_script('DOP-js-jquery-dopselect');
                wp_enqueue_script('DOPBSP-js-isotope');
                
                /*
                 * Back end.
                 */
                wp_enqueue_script('DOPBSP-js-backend');
                
                /*
                 * Front end.
                 */
                wp_enqueue_script('DOPBSP-js-frontend');
                
                /*
                 * Addons
                 */
                wp_enqueue_script('DOPBSP-js-backend-addons');
                
                /*
                 * Amenities
                 */
                wp_enqueue_script('DOPBSP-js-backend-amenities');
                
                /*
                 * API
                 */
                wp_enqueue_script('DOPBSP-js-backend-api');
                
                /*
                 * Calendars
                 */
                wp_enqueue_script('DOPBSP-js-jquery-backend-calendar');
                wp_enqueue_script('DOPBSP-js-backend-calendars');
                wp_enqueue_script('DOPBSP-js-backend-calendar');
                
                /*
                 * Coupons
                 */
                wp_enqueue_script('DOPBSP-js-backend-coupons');
                wp_enqueue_script('DOPBSP-js-backend-coupon');
                
                /*
                 * Dashboard
                 */
                wp_enqueue_script('DOPBSP-js-backend-dashboard');
                
                /*
                 * Deposit
                 */
                wp_enqueue_script('DOPBSP-js-frontend-deposit');
                
                /*
                 * Discounts
                 */
                wp_enqueue_script('DOPBSP-js-backend-discounts');
                wp_enqueue_script('DOPBSP-js-backend-discount');
                wp_enqueue_script('DOPBSP-js-backend-discount-items');
                wp_enqueue_script('DOPBSP-js-backend-discount-item');
                wp_enqueue_script('DOPBSP-js-backend-discount-item-rules');
                wp_enqueue_script('DOPBSP-js-backend-discount-item-rule');
                wp_enqueue_script('DOPBSP-js-frontend-discounts');
                
                /*
                 * Emails
                 */
                wp_enqueue_script('DOPBSP-js-backend-emails');
                wp_enqueue_script('DOPBSP-js-backend-email');
                
                /*
                 * Extras
                 */
                wp_enqueue_script('DOPBSP-js-backend-extras');
                wp_enqueue_script('DOPBSP-js-backend-extra');
                wp_enqueue_script('DOPBSP-js-backend-extra-groups');
                wp_enqueue_script('DOPBSP-js-backend-extra-group');
                wp_enqueue_script('DOPBSP-js-backend-extra-group-items');
                wp_enqueue_script('DOPBSP-js-backend-extra-group-item');
                
                /*
                 * Fees
                 */
                wp_enqueue_script('DOPBSP-js-backend-fees');
                wp_enqueue_script('DOPBSP-js-backend-fee');
                wp_enqueue_script('DOPBSP-js-frontend-fees');
                
                /*
                 * Forms
                 */
                wp_enqueue_script('DOPBSP-js-backend-forms');
                wp_enqueue_script('DOPBSP-js-backend-form');
                wp_enqueue_script('DOPBSP-js-backend-form-fields');
                wp_enqueue_script('DOPBSP-js-backend-form-field');
                wp_enqueue_script('DOPBSP-js-backend-form-field-select-options');
                wp_enqueue_script('DOPBSP-js-backend-form-field-select-option');
                
                /*
                 * Languages
                 */
                wp_enqueue_script('DOPBSP-js-backend-languages');
                wp_enqueue_script('DOPBSP-js-backend-language');
                
                /*
                 * Locations
                 */
                wp_enqueue_script('DOPBSP-js-backend-locations');
                wp_enqueue_script('DOPBSP-js-backend-location');
                wp_enqueue_script('DOPBSP-js-backend-location-map');
                wp_enqueue_script('DOPBSP-js-backend-location-map-hints');
                wp_enqueue_script('DOPBSP-js-backend-location-map-marker');
                
                /*
                 * Models
                 */
                wp_enqueue_script('DOPBSP-js-backend-models');
                wp_enqueue_script('DOPBSP-js-backend-model');
                
                /*
                 * PRO
                 */
                wp_enqueue_script('DOPBSP-js-backend-pro');
                
                /*
                 * Reservations
                 */
                wp_enqueue_script('DOPBSP-js-jquery-backend-reservations-add');
                wp_enqueue_script('DOPBSP-js-jquery-backend-reservations-calendar');
                wp_enqueue_script('DOPBSP-js-backend-reservations');
                wp_enqueue_script('DOPBSP-js-backend-reservations-add');
                wp_enqueue_script('DOPBSP-js-backend-reservations-calendar');
                wp_enqueue_script('DOPBSP-js-backend-reservations-list');
                wp_enqueue_script('DOPBSP-js-backend-reservation');
                wp_enqueue_script('DOPBSP-js-backend-reservation-form');
                
                /*
                 * Reviews
                 */
                wp_enqueue_script('DOPBSP-js-backend-reviews');
                
                /*
                 * Rules
                 */
                wp_enqueue_script('DOPBSP-js-backend-rules');
                wp_enqueue_script('DOPBSP-js-backend-rule');
                wp_enqueue_script('DOPBSP-js-frontend-rules');
                
                /*
                 * Settings
                 */
                wp_enqueue_script('DOPBSP-js-backend-settings');
                wp_enqueue_script('DOPBSP-js-backend-settings-calendar');
                wp_enqueue_script('Google-Calendar');
                wp_enqueue_script('DOPBSP-js-backend-settings-licences');
                wp_enqueue_script('DOPBSP-js-backend-settings-notifications');
                wp_enqueue_script('DOPBSP-js-backend-settings-payment-gateways');
                wp_enqueue_script('DOPBSP-js-backend-settings-users');
                
                /*
                 * SMSes
                 */
                wp_enqueue_script('DOPBSP-js-backend-smses');
                wp_enqueue_script('DOPBSP-js-backend-sms');
                
                /*
                 * Templates
                 */
                wp_enqueue_script('DOPBSP-js-backend-templates');
                
                /*
                 * Themes
                 */
                wp_enqueue_script('DOPBSP-js-backend-themes');
                
                /*
                 * Tools
                 */
                wp_enqueue_script('DOPBSP-js-backend-tools');
                wp_enqueue_script('DOPBSP-js-backend-tools-repair-calendars-settings');
                wp_enqueue_script('DOPBSP-js-backend-tools-repair-database-text');
                
                /*
                 * Translation
                 */
                wp_enqueue_script('DOPBSP-js-backend-translation');
		
		/*
		 * Framework
		 */
                wp_enqueue_script('dot-js');
                wp_enqueue_script('dot-js-calendar');
                wp_enqueue_script('dot-js-calendar-availability');
                wp_enqueue_script('dot-js-calendar-days');
                wp_enqueue_script('dot-js-calendar-day');
                wp_enqueue_script('dot-js-calendar-schedule');
            }
            
            /*
             * Initialize plugin back end.
             */
            function init(){
                global $DOPBSP;
                
                $DOPBSP->classes->database->init();
                
                /*
                 * Reset database translation.
                 */
                if (DOPBSP_CONFIG_REPAIR_TRANSLATION_DATABASE){
                    $DOPBSP->classes->translation->reset();
                }
                
                if(is_admin()) {
                    $DOPBSP->classes->translation->set();
                }
            }
            
            /*
             * Check if current back end page is a plugin page.
             * 
             * @get action (string): wp post action
             * @get post_type (string): wp post type
             * @get page (string): wp page type
             * 
             * @return true/false
             */
            function validPage(){
		global $DOT;
		
                if ($DOT->get('page')){
		    $page = $DOT->get('page');
		    
                    /*
                     * Verify if current page is a plugin page.
                     */
                    if ($page == 'dopbsp'
                        || $page == 'dopbsp-addons'
                        || $page == 'dopbsp-amenities'
                        || $page == 'dopbsp-calendars'
                        || $page == 'dopbsp-coupons'
                        || $page == 'dopbsp-discounts'
                        || $page == 'dopbsp-emails'
                        || $page == 'dopbsp-extras'
                        || $page == 'dopbsp-fees'
                        || $page == 'dopbsp-forms'
                        || $page == 'dopbsp-locations'
                        || $page == 'dopbsp-models'
                        || $page == 'dopbsp-pro'
                        || $page == 'dopbsp-reservations'
                        || $page == 'dopbsp-reviews'
                        || $page == 'dopbsp-rules'
                        || $page == 'dopbsp-settings'
                        || $page == 'dopbsp-smses'
                        || $page == 'dopbsp-templates'
                        || $page == 'dopbsp-themes'
                        || $page == 'dopbsp-tools'
                        || $page == 'dopbsp-translation'){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else if ($DOT->get('post_type')){
                    /*
                     * Verify if current page is a custom post page.
                     */
                    return true;
                }
                else if ($DOT->get('action')){
                    /*
                     * Verify if current page is a custom post edit page.
                     */
                    if ($DOT->get('action') == 'edit') {
                        return true; 
                    } 
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
            
            function rating(){
                global $wpdb;
                global $DOPBSP;
                
                /*
                 * Verify page.
                 */
                if (!$this->validPage()){
                    return false;
                }
                
                /*
                 * Get option.
                 */
                $request_rating = get_option('DOPBSP_request_rating');
                $request_rating == '' ? add_option('DOPBSP_request_rating', 'true'):'';
                $request_rating == '' ? $request_rating = 'true':''; 
                
                /*
                 * Verify close.
                 */
                if (isset($_GET['dopbsp_request_rating_close'])){
                    update_option('DOPBSP_request_rating', 'false');
                    return false;
                }
                
                /*
                 * Display message.
                 */
                if ($request_rating === 'true'){
                    update_option('DOPBSP_request_rating', 'true');
		    
                    $install_date = $wpdb->get_var('SELECT create_time FROM INFORMATION_SCHEMA.TABLES
                                                    WHERE table_schema = "'.$wpdb->dbname.'"
                                                    AND table_name = "'.$DOPBSP->tables->calendars.'"');

                    if(time()-strtotime($install_date) > 5259486){
                        $error = array();

                        $url = (isset($_SERVER['HTTPS']) ? 'https://':'http://')
                                    .$_SERVER['HTTP_HOST']
                                    .$_SERVER['REQUEST_URI'];

                        array_push($error, '<div id="DOPBSP-rating-remove" class="updated notice dopbsp-notice">');
                        array_push($error, '  <p>');
                        array_push($error, '    Thank you for using Pinpoint Booking System. If you enjoy our plugin, please give us a 5 star rating');
                        array_push($error, '    <a href="https://wordpress.org/support/plugin/booking-system/reviews/?filter=5#new-post" target="_blank"> here</a>. ');
                        array_push($error, '  </p>');
                        array_push($error, '  <a href="'.$url.'&dopbsp_request_rating_close=true" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></a>');
                        array_push($error, '</div>');

                        echo implode('', $error);
                    }
                }   
            }
        }
    }