<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/settings/views-backend-settings-calendar.php
* File Version            : 1.1.8
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar settings views class.
*/

    if (!class_exists('DOPBSPViewsBackEndSettingsCalendar')){
        class DOPBSPViewsBackEndSettingsCalendar extends DOPBSPViewsBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns calendar settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             * 
             * @return calendar settings HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($id,  
                                                                                'calendar');
                
                if ($id != 0){
                    $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                              $id));
?>
                <div class="dopbsp-inputs-wrapper">
                    <div class="dopbsp-input-wrapper">
                         <label for="DOPBSP-settings-name"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_NAME'); ?></label>
                         <input type="text" name="DOPBSP-settings-name" id="DOPBSP-settings-name" value="<?php echo $calendar->name; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndCalendar.edit(<?php echo $calendar->id; ?>, 'text', 'name', this.value);}" onpaste="DOPBSPBackEndCalendar.edit(<?php echo $calendar->id; ?>, 'text', 'name', this.value)" onblur="DOPBSPBackEndCalendar.edit(<?php echo $calendar->id; ?>, 'text', 'name', this.value, true)" />
                         <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_NAME_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                    <div class="dopbsp-input-wrapper dopbsp-last">
                         <label for="DOPBSP-settings-name"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_POST_ID'); ?></label>
                         <input type="text" name="DOPBSP-settings-post_id" id="DOPBSP-settings-post_id" value="<?php echo $calendar->post_id; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndCalendar.edit(<?php echo $calendar->id; ?>, 'text', 'post_id', this.value);}" onpaste="DOPBSPBackEndCalendar.edit(<?php echo $calendar->id; ?>, 'text', 'post_id', this.value)" onblur="DOPBSPBackEndCalendar.edit(<?php echo $calendar->id; ?>, 'text', 'post_id', this.value, true)" />
                         <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_POST_ID_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                </div>
<?php
                }
                
                $this->templateGeneral($id,
                                       $settings_calendar);
                $this->templateCurrency($id,
                                        $settings_calendar);
                $this->templateDays($id,
                                    $settings_calendar);
                $this->templateHours($id,
                                     $settings_calendar);
                $this->templateSidebar($id,
                                       $settings_calendar);
                $this->templateRules($id,
                                     $settings_calendar);
                $this->templateExtras($id,
                                      $settings_calendar);
//                $this->templateCart($id,
//                                    $settings_calendar);
                $this->templateDiscounts($id,
                                         $settings_calendar);
                $this->templateFees($id,
                                    $settings_calendar);
                $this->templateCoupons($id,
                                       $settings_calendar);
                $this->templateDeposit($id,
                                       $settings_calendar);
                $this->templateForms($id,
                                     $settings_calendar);
                $this->templateOrder($id,
                                     $settings_calendar);
                $this->templateSync($id,
                                     $settings_calendar);
                $this->templateGoogle($id,
                                     $settings_calendar);
                $this->templateAirbnb($id,
                                     $settings_calendar);
            }
            
            /*
             * Returns calendar general settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return general settings HTML
             */
            function templateGeneral($id,
                                     $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-general-settings')" id="DOPBSP-inputs-button-calendar-general-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-general-settings" class="dopbsp-inputs-wrapper">
<?php   
                /*
                 * Select date type.
                 */
                $this->displaySelectInput(array('id' => 'date_type',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE'),
                                                'value' => $settings_calendar->date_type,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE_HELP'),
                                                'options' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE_AMERICAN').';;'.$DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE_EUROPEAN'),
                                                'options_values' => '1;;2'));
                /*
                 * Select calendar template.
                 */
                $this->displaySelectInput(array('id' => 'template',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_TEMPLATE'),
                                                'value' => $settings_calendar->template,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_TEMPLATE_HELP'),
                                                'options' => $this->listTemplates('true'),
                                                'options_values' => $this->listTemplates()));
                /*
                 * Stop booking x minutes in advance.
                 */
                $this->displayTextInput(array('id' => 'booking_stop',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_BOOKING_STOP'),
                                              'value' => $settings_calendar->booking_stop,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_BOOKING_STOP_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'dopbsp-small'));
                /*
                 * Number of months displayed.
                 */
                $this->displayTextInput(array('id' => 'months_no',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_MONTHS_NO'),
                                              'value' => $settings_calendar->months_no,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_MONTHS_NO_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'dopbsp-small'));
                /*
                 * Enable server time.
                 */
                $this->displaySwitchInput(array('id' => 'server_time',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_SERVER_TIME'),
                                                'value' => $settings_calendar->server_time,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_SERVER_TIME_HELP')));
                /*
                 * Select timezone.
                 */
                $this->displaySelectInput(array('id' => 'timezone',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_TIMEZONE'),
                                                'value' => $settings_calendar->timezone,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_TIMEZONE_HELP'),
                                                'options' => ';;(GMT-12:00) International Date Line West;;(GMT-11:00) Midway Island;;(GMT-11:00) Samoa;;(GMT-10:00) Hawaii;;(GMT-09:00) Alaska;;(GMT-08:00) Pacific Time (US & Canada);;(GMT-08:00) Tijuana;;(GMT-07:00) Arizona;;(GMT-07:00) Mountain Time (US & Canada);;(GMT-07:00) Chihuahua;;(GMT-07:00) La Paz;;(GMT-07:00) Mazatlan;;(GMT-06:00) Central Time (US & Canada);;(GMT-06:00) Central America;;(GMT-06:00) Guadalajara;;(GMT-06:00) Mexico City;;(GMT-06:00) Monterrey;;(GMT-06:00) Saskatchewan;;(GMT-05:00) Eastern Time (US & Canada);;(GMT-05:00) Indiana (East);;(GMT-05:00) Bogota;;(GMT-05:00) Lima;;(GMT-05:00) Quito;;(GMT-04:00) Atlantic Time (Canada);;(GMT-04:00) Caracas;;(GMT-04:00) La Paz;;(GMT-04:00) Santiago;;(GMT-03:30) Newfoundland;;(GMT-03:00) Brasilia;;(GMT-03:00) Buenos Aires;;(GMT-03:00) Georgetown;;(GMT-03:00) Greenland;;(GMT-02:00) Mid-Atlantic;;(GMT-01:00) Azores;;(GMT-01:00) Cape Verde Is.;;(GMT) Casablanca;;(GMT) Dublin;;(GMT) Edinburgh;;(GMT) Lisbon;;(GMT) London;;(GMT) Monrovia;;(GMT+01:00) Amsterdam;;(GMT+01:00) Belgrade;;(GMT+01:00) Berlin;;(GMT+01:00) Bern;;(GMT+01:00) Bratislava;;(GMT+01:00) Brussels;;(GMT+01:00) Budapest;;(GMT+01:00) Copenhagen;;(GMT+01:00) Ljubljana;;(GMT+01:00) Madrid;;(GMT+01:00) Paris;;(GMT+01:00) Prague;;(GMT+01:00) Rome;;(GMT+01:00) Sarajevo;;(GMT+01:00) Skopje;;(GMT+01:00) Stockholm;;(GMT+01:00) Vienna;;(GMT+01:00) Warsaw;;(GMT+01:00) West Central Africa;;(GMT+01:00) Zagreb;;(GMT+02:00) Athens;;(GMT+02:00) Bucharest;;(GMT+02:00) Cairo;;(GMT+02:00) Harare;;(GMT+02:00) Helsinki;;(GMT+02:00) Istanbul;;(GMT+02:00) Jerusalem;;(GMT+02:00) Kyev;;(GMT+02:00) Minsk;;(GMT+02:00) Pretoria;;(GMT+02:00) Riga;;(GMT+02:00) Sofia;;(GMT+02:00) Tallinn;;(GMT+02:00) Vilnius;;(GMT+03:00) Baghdad;;(GMT+03:00) Kuwait;;(GMT+03:00) Moscow;;(GMT+03:00) Nairobi;;(GMT+03:00) Riyadh;;(GMT+03:00) St. Petersburg;;(GMT+03:00) Volgograd;;(GMT+03:30) Tehran;;(GMT+04:00) Abu Dhabi;;(GMT+04:00) Baku;;(GMT+04:00) Muscat;;(GMT+04:00) Tbilisi;;(GMT+04:00) Yerevan;;(GMT+04:30) Kabul;;(GMT+05:00) Ekaterinburg;;(GMT+05:00) Islamabad;;(GMT+05:00) Karachi;;(GMT+05:00) Tashkent;;(GMT+05:30) Chennai;;(GMT+05:30) Kolkata;;(GMT+05:30) Mumbai;;(GMT+05:30) New Delhi;;(GMT+05:45) Kathmandu;;(GMT+06:00) Almaty;;(GMT+06:00) Astana;;(GMT+06:00) Dhaka;;(GMT+06:00) Novosibirsk;;(GMT+06:00) Sri Jayawardenepura;;(GMT+06:30) Rangoon;;(GMT+07:00) Bangkok;;(GMT+07:00) Hanoi;;(GMT+07:00) Jakarta;;(GMT+07:00) Krasnoyarsk;;(GMT+08:00) Beijing;;(GMT+08:00) Chongqing;;(GMT+08:00) Hong Kong;;(GMT+08:00) Irkutsk;;(GMT+08:00) Kuala Lumpur;;(GMT+08:00) Perth;;(GMT+08:00) Singapore;;(GMT+08:00) Taipei;;(GMT+08:00) Ulaan Bataar;;(GMT+08:00) Urumqi;;(GMT+09:00) Osaka;;(GMT+09:00) Sapporo;;(GMT+09:00) Seoul;;(GMT+09:00) Tokyo;;(GMT+09:00) Yakutsk;;(GMT+09:30) Adelaide;;(GMT+09:30) Darwin;;(GMT+10:00) Brisbane;;(GMT+10:00) Canberra;;(GMT+10:00) Guam;;(GMT+10:00) Hobart;;(GMT+10:00) Melbourne;;(GMT+10:00) Port Moresby;;(GMT+10:00) Sydney;;(GMT+10:00) Vladivostok;;(GMT+11:00) Magadan;;(GMT+11:00) New Caledonia;;(GMT+11:00) Solomon Is.;;(GMT+12:00) Auckland;;(GMT+12:00) Fiji;;(GMT+12:00) Kamchatka;;(GMT+12:00) Marshall Is.;;(GMT+12:00) Wellington;;(GMT+13:00) Nuku\'alofa',
                                                'options_values' => ';;Pacific/Kwajalein;;Pacific/Midway;;Pacific/Apia;;Pacific/Honolulu;;America/Anchorage;;America/Los_Angeles;;America/Tijuana;;America/Phoenix;;America/Denver;;America/Chihuahua;;America/Chihuahua;;America/Mazatlan;;America/Chicago;;America/Managua;;America/Mexico_City;;America/Mexico_City;;America/Monterrey;;America/Regina;;America/New_York;;America/Indiana/Indianapolis;;America/Bogota;;America/Lima;;America/Bogota;;America/Halifax;;America/Caracas;;America/La_Paz;;America/Santiago;;America/St_Johns;;America/Sao_Paulo;;America/Argentina/Buenos_Aires;;America/Argentina/Buenos_Aires;;America/Godthab;;America/Noronha;;Atlantic/Azores;;Atlantic/Cape_Verde;;Africa/Casablanca;;Europe/London;;Europe/London;;Europe/Lisbon;;Europe/London;;Africa/Monrovia;;Europe/Amsterdam;;Europe/Belgrade;;Europe/Berlin;;Europe/Berlin;;Europe/Bratislava;;Europe/Brussels;;Europe/Budapest;;Europe/Copenhagen;;Europe/Ljubljana;;Europe/Madrid;;Europe/Paris;;Europe/Prague;;Europe/Rome;;Europe/Sarajevo;;Europe/Skopje;;Europe/Stockholm;;Europe/Vienna;;Europe/Warsaw;;Africa/Lagos;;Europe/Zagreb;;Europe/Athens;;Europe/Bucharest;;Africa/Cairo;;Africa/Harare;;Europe/Helsinki;;Europe/Istanbul;;Asia/Jerusalem;;Europe/Kiev;;Europe/Minsk;;Africa/Johannesburg;;Europe/Riga;;Europe/Sofia;;Europe/Tallinn;;Europe/Vilnius;;Asia/Baghdad;;Asia/Kuwait;;Europe/Moscow;;Africa/Nairobi;;Asia/Riyadh;;Europe/Moscow;;Europe/Volgograd;;Asia/Tehran;;Asia/Muscat;;Asia/Baku;;Asia/Muscat;;Asia/Tbilisi;;Asia/Yerevan;;Asia/Kabul;;Asia/Yekaterinburg;;Asia/Karachi;;Asia/Karachi;;Asia/Tashkent;;Asia/Kolkata;;Asia/Kolkata;;Asia/Kolkata;;Asia/Kolkata;;Asia/Kathmandu;;Asia/Almaty;;Asia/Dhaka;;Asia/Dhaka;;Asia/Novosibirsk;;Asia/Colombo;;Asia/Rangoon;;Asia/Bangkok;;Asia/Bangkok;;Asia/Jakarta;;Asia/Krasnoyarsk;;Asia/Hong_Kong;;Asia/Chongqing;;Asia/Hong_Kong;;Asia/Irkutsk;;Asia/Kuala_Lumpur;;Australia/Perth;;Asia/Singapore;;Asia/Taipei;;Asia/Irkutsk;;Asia/Urumqi;;Asia/Tokyo;;Asia/Tokyo;;Asia/Seoul;;Asia/Tokyo;;Asia/Yakutsk;;Australia/Adelaide;;Australia/Darwin;;Australia/Brisbane;;Australia/Sydney;;Pacific/Guam;;Australia/Hobart;;Australia/Melbourne;;Pacific/Port_Moresby;;Australia/Sydney;;Asia/Vladivostok;;Asia/Magadan;;Asia/Magadan;;Asia/Magadan;;Pacific/Auckland;;Pacific/Fiji;;Asia/Kamchatka;;Pacific/Fiji;;Pacific/Auckland;;Pacific/Tongatapu'));
                /*
                 * Hide Frontend price from calendar.
                 */
                $this->displaySwitchInput(array('id' => 'hide_price',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_HIDE_PRICE'),
                                                'value' => $settings_calendar->hide_price,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_HIDE_PRICE_HELP')));
                /*
                 * Hide No available from calendar.
                 */
                $this->displaySwitchInput(array('id' => 'hide_no_available',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_HIDE_NO_AVAILABLE'),
                                                'value' => $settings_calendar->hide_no_available,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_HIDE_NO_AVAILABLE_HELP')));
                /*
                 * Select minimum no available.
                 */
                $this->displaySelectInput(array('id' => 'minimum_no_available',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_MINIMUM_NO_AVAILABLE'),
                                                'value' => $settings_calendar->minimum_no_available,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_MINIMUM_NO_AVAILABLE_HELP'),
                                                'options' => '1;;2;;3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;16;;17;;18;;19;;20',
                                                'options_values' => '1;;2;;3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;16;;17;;18;;19;;20'));
                /*
                 * Enable view only.
                 */
                $this->displaySwitchInput(array('id' => 'view_only',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_VIEW_ONLY'),
                                                'value' => $settings_calendar->view_only,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_VIEW_ONLY_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php                
            }
            
            /*
             * Returns calendar currency settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return currency settings HTML
             */
            function templateCurrency($id,
                                      $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-currency-settings')" id="DOPBSP-inputs-button-calendar-currency-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-currency-settings" class="dopbsp-inputs-wrapper">
<?php
                /*
                 * Select currency.
                 */
                $this->displaySelectInput(array('id' => 'currency',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY'),
                                                'value' => $settings_calendar->currency,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_HELP'),
                                                'options' => $this->listCurrencies('labels'),
                                                'options_values' => $this->listCurrencies('ids')));
                /*
                 * Select currency position.
                 */
                $this->displaySelectInput(array('id' => 'currency_position',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION'),
                                                'value' => $settings_calendar->currency_position,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_HELP'),
                                                'options' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_BEFORE').';;'.$DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_BEFORE_WITH_SPACE').';;'.$DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_AFTER').';;'.$DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_AFTER_WITH_SPACE'),
                                                'options_values' => 'before;;before_with_space;;after;;after_with_space',
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php
            }
            
            /*
             * Returns calendar days settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return days settings HTML
             */
            function templateDays($id,
                                  $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DAYS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-days-settings')" id="DOPBSP-inputs-button-calendar-days-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-days-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Set available days.
                 */
                    $days_available = explode(',', $settings_calendar->days_available);
?>
                    <div class="dopbsp-input-wrapper">
                        <label class="dopbsp-for-checkboxes" for="DOPBSP-settings-days_available"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DAYS_AVAILABLE'); ?></label>
                        <div class="dopbsp-checkboxes-wrapper">
                            <input type="checkbox" name="DOPBSP-settings-days-available-0" id="DOPBSP-settings-days-available-0"<?php echo $days_available[0] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'checkbox', 'days_available')" />
                            <label class="dopbsp-for-checkbox" for="DOPBSP-settings-days-available-0"><?php echo $DOPBSP->text('DAY_SUNDAY'); ?></label>
                            <br class="dopbsp-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-1" id="DOPBSP-settings-days-available-1"<?php echo $days_available[1] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'checkbox', 'days_available')" />
                            <label class="dopbsp-for-checkbox" for="DOPBSP-settings-days-available-1"><?php echo $DOPBSP->text('DAY_MONDAY'); ?></label>
                            <br class="dopbsp-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-2" id="DOPBSP-settings-days-available-2"<?php echo $days_available[2] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'checkbox', 'days_available')" />
                            <label class="dopbsp-for-checkbox" for="DOPBSP-settings-day-available-2"><?php echo $DOPBSP->text('DAY_TUESDAY'); ?></label>
                            <br class="dopbsp-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-3" id="DOPBSP-settings-days-available-3"<?php echo $days_available[3] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'checkbox', 'days_available')" />
                            <label class="dopbsp-for-checkbox" for="DOPBSP-settings-days-available-3"><?php echo $DOPBSP->text('DAY_WEDNESDAY'); ?></label>
                            <br class="dopbsp-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-4" id="DOPBSP-settings-days-available-4"<?php echo $days_available[4] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'checkbox', 'days_available')"  />
                            <label class="dopbsp-for-checkbox" for="DOPBSP-settings-days-available-4"><?php echo $DOPBSP->text('DAY_THURSDAY'); ?></label>
                            <br class="dopbsp-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-5" id="DOPBSP-settings-days-available-5"<?php echo $days_available[5] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'checkbox', 'days_available')" />
                            <label class="dopbsp-for-checkbox" for="DOPBSP-settings-days-available-5"><?php echo $DOPBSP->text('DAY_FRIDAY'); ?></label>
                            <br class="dopbsp-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-6" id="DOPBSP-settings-days-available-6"<?php echo $days_available[6] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'checkbox', 'days_available')" />
                            <label class="dopbsp-for-checkbox" for="DOPBSP-settings-days-available-6"><?php echo $DOPBSP->text('DAY_SATURDAY'); ?></label>
                        </div>
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DAYS_AVAILABLE_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
<?php                        
                /*
                 * Select calendar first week day.
                 */
                $this->displaySelectInput(array('id' => 'days_first',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_FIRST'),
                                                'value' => $settings_calendar->days_first,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_FIRST_HELP'),
                                                'options' => $DOPBSP->text('DAY_MONDAY').';;'.$DOPBSP->text('DAY_TUESDAY').';;'.$DOPBSP->text('DAY_WEDNESDAY').';;'.$DOPBSP->text('DAY_THURSDAY').';;'.$DOPBSP->text('DAY_FRIDAY').';;'.$DOPBSP->text('DAY_SATURDAY').';;'.$DOPBSP->text('DAY_SUNDAY'),
                                                'options_values' => '1;;2;;3;;4;;5;;6;;7'));
                /*
                 * First day displayed.
                 */
                $this->displayTextInput(array('id' => 'days_first_displayed',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_FIRST_DISPLAYED'),
                                              'value' => $settings_calendar->days_first_displayed,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_FIRST_DISPLAYED_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'dopbsp-date'));
                /*
                 * Enable multiple days select.
                 */
                $this->displaySwitchInput(array('id' => 'days_multiple_select',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT'),
                                                'value' => $settings_calendar->days_multiple_select,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT_HELP')));
                /*
                 * Enable morning check out.
                 */
                $this->displaySwitchInput(array('id' => 'days_morning_check_out',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT'),
                                                'value' => $settings_calendar->days_morning_check_out,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT_HELP')));
                /*
                 * Enable details from hours.
                 */
                $this->displaySwitchInput(array('id' => 'days_details_from_hours',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS'),
                                                'value' => $settings_calendar->days_details_from_hours,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php
            }
            
            /*
             * Returns calendar hours settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return hours settings HTML
             */
            function templateHours($id,
                                   $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_HOURS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-hours-settings')" id="DOPBSP-inputs-button-calendar-hours-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-hours-settings" class="dopbsp-inputs-wrapper">
<?php
                /*
                 * Hours enabled.
                 */
                $this->displaySwitchInput(array('id' => 'hours_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ENABLED'),
                                                'value' => $settings_calendar->hours_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ENABLED_HELP')));
                /*
                 * Hours info enabled.
                 */
                $this->displaySwitchInput(array('id' => 'hours_info_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INFO_ENABLED'),
                                                'value' => $settings_calendar->hours_info_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INFO_ENABLED_HELP')));
                /*
                 * Hours definitions.
                 */
                $hours_html = array();
                $hours = json_decode($settings_calendar->hours_definitions);

                foreach ($hours as $hour){
                    array_push($hours_html, $hour->value);
                }
                
                $this->displayTextarea(array('id' => 'hours_definitions',
                                             'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_DEFINITIONS'),
                                             'value' => implode("\n", $hours_html),
                                             'settings_id' => $id,
                                             'settings_type' => 'calendar',
                                             'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_DEFINITIONS_HELP')));
                /*
                 * Enable multiple hours select.
                 */
                $this->displaySwitchInput(array('id' => 'hours_multiple_select',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT'),
                                                'value' => $settings_calendar->hours_multiple_select,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT_HELP')));
                /*
                 * Set hours AM/PM.
                 */
                $this->displaySwitchInput(array('id' => 'hours_ampm',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_AMPM'),
                                                'value' => $settings_calendar->hours_ampm,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_AMPM_HELP')));
                /*
                 * Enable to add last hour to total price.
                 */
                $this->displaySwitchInput(array('id' => 'hours_add_last_hour_to_total_price',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE'),
                                                'value' => $settings_calendar->hours_add_last_hour_to_total_price,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE_HELP')));
                /*
                 * Enable hours interval.
                 */
                $this->displaySwitchInput(array('id' => 'hours_interval_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED'),
                                                'value' => $settings_calendar->hours_interval_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED_HELP')));
                /*
                 * Enable Autobreak interval.
                 */
                $this->displaySwitchInput(array('id' => 'hours_interval_autobreak_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INTERVAL_AUTOBREAK_ENABLED'),
                                                'value' => $settings_calendar->hours_interval_autobreak_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INTERVAL_AUTOBREAK_ENABLED_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar sidebar settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return sidebar settings HTML
             */
            function templateSidebar($id,
                                     $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-sidebar-settings')" id="DOPBSP-inputs-button-calendar-sidebar-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-sidebar-settings" class="dopbsp-inputs-wrapper">
                    <div class="dopbsp-input-wrapper">
                        <label class="dopbsp-for-checkboxes"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_STYLE'); ?></label>
                        <ul id="DOPBSP-settings-sidebar-styles" class="dopbsp-sidebar-styles">
                            <li id="DOPBSP-settings-sidebar-style1"<?php echo $settings_calendar->sidebar_style == 1 ? ' class="dopbsp-selected"':''; ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 1)"></li>
                            <li id="DOPBSP-settings-sidebar-style2"<?php echo $settings_calendar->sidebar_style == 2 ? ' class="dopbsp-selected"':''; ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 2)"></li>
                            <li id="DOPBSP-settings-sidebar-style3"<?php echo $settings_calendar->sidebar_style == 3 ? ' class="dopbsp-selected"':''; ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 3)"></li>
                            <li id="DOPBSP-settings-sidebar-style4"<?php echo $settings_calendar->sidebar_style == 4 ? ' class="dopbsp-selected"':''; ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 4)"></li>
                            <li id="DOPBSP-settings-sidebar-style5"<?php echo $settings_calendar->sidebar_style == 5 ? ' class="dopbsp-selected"':''; ?> onclick="DOPBSPBackEndSettings.set('<?php echo $id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 5)"></li>
                        </ul>
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_STYLE_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
<?php    
                /*
                 * Enable number of items display.
                 */
                $this->displaySwitchInput(array('id' => 'sidebar_no_items_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED'),
                                                'value' => $settings_calendar->sidebar_no_items_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php                
            }
            
            /*
             * Returns calendar rules settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return rules settings HTML
             */
            function templateRules($id,
                                   $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_RULES_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-rules-settings')" id="DOPBSP-inputs-button-calendar-rules-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-rules-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Extra select.
                 */
                $this->displaySelectInput(array('id' => 'rule',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_RULES'),
                                                'value' => $settings_calendar->rule,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_RULES_HELP'),
                                                'options' => $this->listRules('labels'),
                                                'options_values' => $this->listRules('ids'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar extras settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return extras settings HTML
             */
            function templateExtras($id,
                                    $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_EXTRAS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-extras-settings')" id="DOPBSP-inputs-button-calendar-extras-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-extras-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Extra select.
                 */
                $this->displaySelectInput(array('id' => 'extra',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_EXTRAS'),
                                                'value' => $settings_calendar->extra,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_EXTRAS_HELP'),
                                                'options' => $this->listExtras('labels'),
                                                'options_values' => $this->listExtras('ids'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar cart settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return cart settings HTML
             */
            function templateCart($id,
                                  $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_CART_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-cart-settings')" id="DOPBSP-inputs-button-calendar-cart-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-cart-settings" class="dopbsp-inputs-wrapper">
<?php          
                /*
                 * Enable cart.
                 */
                $this->displaySwitchInput(array('id' => 'cart_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_CART_ENABLED'),
                                                'value' => $settings_calendar->cart_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_CART_ENABLED_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar discounts settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return discounts settings HTML
             */
            function templateDiscounts($id,
                                       $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DISCOUNTS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-discounts-settings')" id="DOPBSP-inputs-button-calendar-discounts-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-discounts-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Discount select.
                 */
                $this->displaySelectInput(array('id' => 'discount',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DISCOUNTS'),
                                                'value' => $settings_calendar->discount,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DISCOUNTS_HELP'),
                                                'options' => $this->listDiscounts('labels'),
                                                'options_values' => $this->listDiscounts('ids'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar fees settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return fees settings HTML
             */
            function templateFees($id,
                                  $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_FEES_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-fees-settings')" id="DOPBSP-inputs-button-calendar-fees-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-fees-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Fees multiple list.
                 */
                echo $this->multipleFees(array('label' => $DOPBSP->text('SETTINGS_CALENDAR_FEES'),
                                               'value' => $settings_calendar->fees,
                                               'settings_id' => $id,
                                               'settings_type' => 'calendar',
                                               'help' => $DOPBSP->text('SETTINGS_CALENDAR_FEES_HELP'),
                                               'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar coupons settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): settings data
             * 
             * @return coupons settings HTML
             */
            function templateCoupons($id,
                                     $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_COUPONS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-coupons-settings')" id="DOPBSP-inputs-button-calendar-coupons-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-coupons-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Copons multiple list.
                 */
                
                echo $this->multipleCoupons(array('label' => $DOPBSP->text('SETTINGS_CALENDAR_COUPONS'),
                                                   'value' => $settings_calendar->coupon,
                                                   'settings_id' => $id,
                                                   'settings_type' => 'calendar',
                                                   'help' => $DOPBSP->text('SETTINGS_CALENDAR_COUPONS_HELP'),
                                                   'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar deposit settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return deposit settings HTML
             */
            function templateDeposit($id,
                                     $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-deposit-settings')" id="DOPBSP-inputs-button-calendar-deposit-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-deposit-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Deposit
                 */
                $this->displayTextInput(array('id' => 'deposit',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT'),
                                              'value' => $settings_calendar->deposit,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_HELP')));
                /*
                 * Deposit type.
                 */
                $this->displaySelectInput(array('id' => 'deposit_type',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE'),
                                                'value' => $settings_calendar->deposit_type,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE_HELP'),
                                                'options' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE_FIXED').';;'.$DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE_PERCENT'),
                                                'options_values' => 'fixed;;percent'));
                /*
                 * Enable pay full amount option.
                 */
                $this->displaySwitchInput(array('id' => 'deposit_pay_full_amount',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_PAY_FULL_AMOUNT'),
                                                'value' => $settings_calendar->deposit_pay_full_amount,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_PAY_FULL_AMOUNT_HELP'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar form settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return form settings HTML
             */
            function templateForms($id,
                                   $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_FORMS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-forms-settings')" id="DOPBSP-inputs-button-calendar-forms-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-forms-settings" class="dopbsp-inputs-wrapper">
<?php           
                /*
                 * Form select.
                 */
                $this->displaySelectInput(array('id' => 'form',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_FORMS'),
                                                'value' => $settings_calendar->form,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_FORMS_HELP'),
                                                'options' => $this->listForms('labels'),
                                                'options_values' => $this->listForms('ids'),
                                                'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar order settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return order settings HTML
             */
            function templateOrder($id,
                                   $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-last dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_ORDER_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-order-settings')" id="DOPBSP-inputs-button-calendar-order-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-order-settings" class="dopbsp-inputs-wrapper dopbsp-last dopbsp-displayed">
<?php                
                /*
                 * Enable terms & conditions.
                 */
                $this->displaySwitchInput(array('id' => 'terms_and_conditions_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED'),
                                                'value' => $settings_calendar->terms_and_conditions_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED_HELP')));
                /*
                 * Terms & conditions link.
                 */
                $this->displayTextInput(array('id' => 'terms_and_conditions_link',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK'),
                                              'value' => $settings_calendar->terms_and_conditions_link,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK_HELP'),
                                              'container_class' => 'dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar sync url settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return sync settings HTML
             */
            function templateSync($id,
                                   $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_SYNC_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-sync-settings')" id="DOPBSP-inputs-button-calendar-sync-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-hours-settings" class="dopbsp-inputs-wrapper">
<?php
                /*
                 * iCAL URL
                 */
                $this->displayTextInput(array('id' => 'ical_url',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_ICAL_URL'),
                                              'value' => get_site_url().'?dopbsp_api=true&calendar_id='.$id.'&type=ics&key='.$DOPBSP->classes->backend_api_key->get(),
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_ICAL_URL_HELP'),
                                              'container_class' => 'dopbsp-disabled dopbsp-last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar google calendar sync settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return google calendar sync settings HTML
             */
            function templateGoogle($id,
                                   $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_SYNC_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-google-settings')" id="DOPBSP-inputs-button-calendar-google-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-hours-settings" class="dopbsp-inputs-wrapper dopbsp-last">
<?php
                /*
                 * Google enabled.
                 */
                $this->displaySwitchInput(array('id' => 'google_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_ENABLED'),
                                                'value' => $settings_calendar->google_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_ENABLED_HELP')));
                
                /*
                 * Google Client ID
                 */
                $this->displayTextInput(array('id' => 'google_client_id',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_CLIENT_ID'),
                                              'value' => $settings_calendar->google_client_id,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_CLIENT_ID_HELP'),
                                              'container_class' => 'dopbsp-hidden'));
                
                /*
                 * Google Client Secret
                 */
                $this->displayTextInput(array('id' => 'google_client_secret',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_CLIENT_SECRET'),
                                              'value' => $settings_calendar->google_client_secret,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_CLIENT_SECRET_HELP'),
                                              'container_class' => 'dopbsp-hidden'));
                
                /*
                 * Google Calendar ID
                 */
                $this->displayTextInput(array('id' => 'google_calendar_id',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_CALENDAR_ID'),
                                              'value' => $settings_calendar->google_calendar_id,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar', 
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_CALENDAR_ID_HELP'),
                                              'container_class' => 'dopbsp-hidden'));
                
                /*
                 * Google Feed URL
                 */
                $this->displayTextInput(array('id' => 'google_feed_url',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_FEED_URL'),
                                              'value' => $settings_calendar->google_feed_url,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_FEED_URL_HELP')));
                
                /*
                 * Google Sync Time
                 */
                $this->displayTextInput(array('id' => 'google_sync_time',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_SYNC_TIME'),
                                              'value' => $settings_calendar->google_sync_time,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_SYNC_TIME_HELP')));
?>
                    <a href="javascript:DOPGoogleCalendar.sync(3)" id="DOPBSP-google-calendar-sync" class="dopbsp-sync dopbsp-hidden dopbsp-last"><span class="dopbsp-info"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_GOOGLE_CALENDAR_SYNC_HELP'); ?></span></a>
                </div>
                <script type="text/javascript">
                    window.dopbspGoogleCalendar_CLIENT_ID = '<?php echo $settings_calendar->google_client_id; ?>';
                    window.dopbspGoogleCalendar_CLIENT_SECRET = '<?php echo $settings_calendar->google_client_secret; ?>';
                    window.dopbspGoogleCalendar_CALENDAR_ID = '<?php echo $settings_calendar->google_calendar_id; ?>';
                </script>
<?php       
            }
            
            /*
             * Returns calendar airbnb sync settings template.
             * 
             * @param id (integer): calendar ID
             * @param settings_calendar (object): calendar settings data
             * 
             * @return airbnb sync settings HTML
             */
            function templateAirbnb($id,
                                   $settings_calendar){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_AIRBNB_SYNC_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('calendar-airbnb-settings')" id="DOPBSP-inputs-button-calendar-airbnb-settings" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-hours-settings" class="dopbsp-inputs-wrapper dopbsp-last">
<?php
                /*
                 * Airbnb enabled.
                 */
                $this->displaySwitchInput(array('id' => 'airbnb_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_AIRBNB_ENABLED'),
                                                'value' => $settings_calendar->airbnb_enabled,
                                                'settings_id' => $id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_AIRBNB_ENABLED_HELP')));
                /*
                 * Airbnb Feed URL
                 */
                $this->displayTextInput(array('id' => 'airbnb_feed_url',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_AIRBNB_FEED_URL'),
                                              'value' => $settings_calendar->airbnb_feed_url,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_AIRBNB_FEED_URL_HELP')));
                /*
                 * Airbnb Sync time
                 */
                $this->displayTextInput(array('id' => 'airbnb_sync_time',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_AIRBNB_SYNC_TIME'),
                                              'value' => $settings_calendar->airbnb_sync_time,
                                              'settings_id' => $id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_AIRBNB_SYNC_TIME_HELP')));
?>
                </div>
<?php       
            }
        }
    }