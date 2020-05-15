<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.3
* File                    : includes/calendars/class-backend-calendar.php
* File Version            : 1.1.1
* Created / Last Modified : 14 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar PHP class.
*/

    if (!class_exists('DOPBSPBackEndCalendar')){
        class DOPBSPBackEndCalendar extends DOPBSPBackEndCalendars{
            /*
             * Constructor
             */
            function __construct(){
            }

            /* 
             * Returns a JSON with calendar's data & options.
             * 
             * @post id (integer): calendar ID
             * 
             * @return options JSON
             */
            function getOptions(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                // Sync iCal
                $DOPBSP->classes->backend_calendar_schedule->sync($id);
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($id,  
                                                                                'calendar');
                
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                               $id));

                $data = array('AddLastHourToTotalPrice' => $settings_calendar->hours_add_last_hour_to_total_price,
                              'AddtMonthViewText' => $DOPBSP->text('CALENDARS_CALENDAR_ADD_MONTH_VIEW'),
                              'AvailableDays' => explode(',', $settings_calendar->days_available),
                              'AvailableLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_AVAILABLE_LABEL'),
                              'AvailableOneText' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_ONE_TEXT'),
                              'AvailableText' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_TEXT'),
                              'BookedText' => $DOPBSP->text('CALENDARS_CALENDAR_BOOKED_TEXT'),
                              'Currency' => $DOPBSP->classes->currencies->get($settings_calendar->currency),
                              'DateEndLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_DATE_END_LABEL'),
                              'DateStartLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_DATE_START_LABEL'),
                              'DateType' => 1,
                              'DayNames' => array($DOPBSP->text('DAY_SUNDAY'), 
                                                  $DOPBSP->text('DAY_MONDAY'), 
                                                  $DOPBSP->text('DAY_TUESDAY'), 
                                                  $DOPBSP->text('DAY_WEDNESDAY'), 
                                                  $DOPBSP->text('DAY_THURSDAY'), 
                                                  $DOPBSP->text('DAY_FRIDAY'), 
                                                  $DOPBSP->text('DAY_SATURDAY')),
                              'DetailsFromHours' => $settings_calendar->days_details_from_hours,
                              'FirstDay' => $settings_calendar->days_first,
                              'HoursEnabled' => $settings_calendar->hours_enabled,
                              'GroupDaysLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_GROUP_DAYS_LABEL'),
                              'GroupHoursLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_GROUP_HOURS_LABEL'),
                              'HourEndLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_END_LABEL'),
                              'HourStartLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_START_LABEL'),
                              'HoursAMPM' => $settings_calendar->hours_ampm,
                              'HoursDefinitions' => json_decode($settings_calendar->hours_definitions),
                              'HoursDefinitionsChangeLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_DEFINITIONS_CHANGE_LABEL'),
                              'HoursDefinitionsLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_DEFINITIONS_LABEL'),
                              'HoursSetDefaultDataLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_SET_DEFAULT_DATA_LABEL'),
                              'HoursIntervalEnabled' => $settings_calendar->hours_interval_enabled,
                              'HoursIntervalAutobreakEnabled' => $settings_calendar->hours_interval_autobreak_enabled,
                              'ID' => $id,
                              'DefaultSchedule' => $calendar->default_availability != '' ? $calendar->default_availability:'{"available":1,"bind":0,"hours":{},"hours_definitions":[{"value":"00:00"}],"info":"","notes":"","price":0,"promo":0,"status":"none"}',
                              'InfoLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_INFO_LABEL'),
                              'MaxYear' => $DOPBSP->classes->backend_calendar->getMaxYear($id),
                              'MonthNames' => array($DOPBSP->text('MONTH_JANUARY'), 
                                                    $DOPBSP->text('MONTH_FEBRUARY'), 
                                                    $DOPBSP->text('MONTH_MARCH'),
                                                    $DOPBSP->text('MONTH_APRIL'), 
                                                    $DOPBSP->text('MONTH_MAY'), 
                                                    $DOPBSP->text('MONTH_JUNE'), 
                                                    $DOPBSP->text('MONTH_JULY'), 
                                                    $DOPBSP->text('MONTH_AUGUST'), 
                                                    $DOPBSP->text('MONTH_SEPTEMBER'), 
                                                    $DOPBSP->text('MONTH_OCTOBER'), 
                                                    $DOPBSP->text('MONTH_NOVEMBER'), 
                                                    $DOPBSP->text('MONTH_DECEMBER')),
                              'NextMonthText' => $DOPBSP->text('CALENDARS_CALENDAR_NEXT_MONTH'),
                              'NotesLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_NOTES_LABEL'),
                              'PreviousMonthText' => $DOPBSP->text('CALENDARS_CALENDAR_PREVIOUS_MONTH'),
                              'PriceLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_PRICE_LABEL'),
                              'PromoLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_PROMO_LABEL'),
                              'RemoveMonthViewText' => $DOPBSP->text('CALENDARS_CALENDAR_REMOVE_MONTH_VIEW'),
                              'AddMonthViewText' => $DOPBSP->text('CALENDARS_CALENDAR_ADD_MONTH_VIEW'),
                              'ResetConfirmation' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_RESET_CONFIRMATION'),
                              'SetDaysAvailabilityLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_SET_DAYS_AVAILABILITY_LABEL'),
                              'SetHoursAvailabilityLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_SET_HOURS_AVAILABILITY_LABEL'),
                              'SetHoursDefinitionsLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_SET_HOURS_DEFINITIONS_LABEL'),
                              'StatusAvailableText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_AVAILABLE_TEXT'),
                              'StatusBookedText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_BOOKED_TEXT'),
                              'StatusLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_LABEL'),
                              'StatusSpecialText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_SPECIAL_TEXT'),
                              'StatusUnavailableText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_UNAVAILABLE_TEXT'),
                              'UnavailableText' => $DOPBSP->text('CALENDARS_CALENDAR_UNAVAILABLE_TEXT'));

                echo json_encode($data);

                die();
            }
            
            /*
             * Edit calendar.
             * 
             * @post field (string): calendars table field
             * @post id (integer): calendar ID
             * @post value (string): the value with which the field will be updated
             */
            function edit(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $field = $DOT->post('field');
                $id = $DOT->post('id', 'int');
                $value = $DOT->post('value');
                
                /*
                 * Update calendar field.
                 */
                $wpdb->update($DOPBSP->tables->calendars, array($field => $value), 
                                                          array('id' => $id));
                
                die();
            }

            /*
             * Delete calendar.
             * 
             * @post id (integer): calendar ID
             * 
             * @return number of calendars left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;

                $id = $DOT->post('id', 'int');
                
                /*
                 * Delete calendar.
                 */
                $wpdb->delete($DOPBSP->tables->calendars, array('id' => $id));
                
                /*
                 * Delete calendar schedule.
                 */
                $wpdb->delete($DOPBSP->tables->days, array('calendar_id' => $id));
                
                /*
                 * Delete calendar reservations.
                 */
                $wpdb->delete($DOPBSP->tables->reservations, array('calendar_id' => $id));
                
                /*
                 * Delete calendar settings.
                 */
                $wpdb->delete($DOPBSP->tables->settings_calendar, array('calendar_id' => $id));
                $wpdb->delete($DOPBSP->tables->settings_notifications, array('calendar_id' => $id));
                $wpdb->delete($DOPBSP->tables->settings_payment, array('calendar_id' => $id));
                
                /*
                 * Delete users permissions.
                 */
                $users = get_users();
                
                foreach ($users as $user){
                    if ($DOPBSP->classes->backend_settings_users->permission($user->ID, 'use-calendar', $id)){
                        $DOPBSP->classes->backend_settings_users->set(array('calendar_id' => $id,
                                                                            'id' => $user->ID,
                                                                            'slug' => '',
                                                                            'value' => 0));
                    }
                }
                
                /*
                 * Count the number of remaining calendars.
                 */
                $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
            
            /*
             * Get calendar maximum available year.
             * 
             * @post id (integer): calendar ID
             * 
             * @return maximum available year
             */
            function getMaxYear($id){
                global $wpdb;
                global $DOPBSP;
                
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT max_year FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                          $id));
                
                return (int)($calendar->max_year == 0 ? $DOPBSP->classes->backend_settings->value($id, 'calendar', 'max_year'):$calendar->max_year);
            }
        }
    }