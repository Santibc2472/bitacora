<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/reservations/class-backend-reservations-list.php
* File Version            : 1.0.8
* Created / Last Modified : 07 September 2015
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations list PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservationsList')){
        class DOPBSPBackEndReservationsList extends DOPBSPBackEndReservations{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Search & display reservations list.
             * 
             * 
             * @post key (string): API key
             * @post calendar_id (string/integer): list of calendars or calendar
             * @post start_date (string): reservations start date
             * @post end_date (string): reservations end date
             * @post start_hour (string): reservations start hour
             * @post end_hour (string): reservations end hour
             * @post status_pending (boolean): display reservations with status pending
             * @post status_approved (boolean): display reservations with status approved
             * @post status_rejected (boolean): display reservations with status rejected
             * @post status_canceled (boolean): display reservations with status canceled
             * @post status_expired (boolean): display reservations with status expired
             * @post payment_methods (string): list of payment methods
             * @post search (string): search text
             * @post page (integer): page number to be displayed
             * @post per_page (integer): number of reservation displayed per page
             * @post order (string): order direction "ASC", "DESC"
             * @post order_by (string): order by "check_in", "check_out", "start_hour", "end_hour", "id", "status", "date_created"
             * 
             * @get dopbsp_api (boolean): will initilize API calls if it is enabled
             * @get calendar_id (string/integer): list of calendars or calendar
             * @get start_date (string): reservations start date
             * @get end_date (string): reservations end date
             * @get start_hour (string): reservations start hour
             * @get end_hour (string): reservations end hour
             * @get status (boolean): display reservations with selected status
             * @get payment_methods (string): list of payment methods
             * @get search (string): search text
             * @get page (integer): page number to be displayed
             * @get per_page (integer): number of reservation displayed per page
             * @get order (string): order direction "ASC", "DESC"
             * @get order_by (string): order by "check_in", "check_out", "start_hour", "end_hour", "id", "status", "date_created"
             * 
             * @return reservations list
             */
            function get(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $calendars_ids = array();
                $query = array();
                $values = array();
                $api = $DOT->get('dopbsp_api') == 'true' ? true:false;
                
                if (!$api){
                    $calendar_id = $DOT->post('calendar_id');
                    $start_date = $DOT->post('start_date');
                    $end_date = $DOT->post('end_date');
                    $start_hour = $DOT->post('start_hour');
                    $end_hour = $DOT->post('end_hour');
                    $status_pending = $DOT->post('status_pending') == 'true' ? true:false;
                    $status_approved = $DOT->post('status_approved') == 'true' ? true:false;
                    $status_rejected = $DOT->post('status_rejected') == 'true' ? true:false;
                    $status_canceled = $DOT->post('status_canceled') == 'true' ? true:false;
                    $status_expired = $DOT->post('status_expired') == 'true' ? true:false;
                    $payment_methods = $DOT->post('payment_methods') == '' ? array():explode(',', $DOT->post('payment_methods'));
                    $search = $DOT->post('search');
                    $page = $DOT->post('page', 'int');
                    $per_page = $DOT->post('per_page', 'int');
                    $order = $DOT->post('order');
                    $order_by = $DOT->post('order_by');
                }
                else{
                    if ($DOT->get('calendar_id') !== false
			    || $DOT->get('calendar_id') != ''){
                        $calendars_requested = ','.$DOT->get('calendar_id').',';
                    }
                    else{
                        $calendars_requested = '';
                    }
                    
                    $calendars_id = array();
                    $key_pieces = explode('-', $DOT->post('key'));
                    $calendars = $DOPBSP->classes->backend_calendars->get(array('user_id' => (int)$key_pieces[1]));
                    
                    foreach ($calendars as $calendar){
                        if ($calendars_requested != ''){
                            if (strpos($calendars_requested, ','.(string)$calendar->id.',') !== false){
                                array_push($calendars_id, $calendar->id);
                            }
                        }
                        else{
                            array_push($calendars_id, $calendar->id);
                        }
                    }
                    
                    $calendar_id = implode(',', $calendars_id);
                    $start_date = $DOT->get('start_date') ? $DOT->get('start_date'):'';
                    $end_date = $DOT->get('end_date') ? $DOT->get('end_date'):'';
                    $start_hour = $DOT->get('start_hour') ? $DOT->get('start_hour'):'00:00';
                    $end_hour = $DOT->get('end_hour') ? $DOT->get('end_hour'):'24:00';
                    $status = $DOT->get('status') ? $DOT->get('status'):'';
                    $status_pending = strpos($status, 'pending') !== false ? true:false;
                    $status_approved = strpos($status, 'approved') !== false ? true:false;
                    $status_rejected = strpos($status, 'rejected') !== false ? true:false;
                    $status_canceled = strpos($status, 'canceled') !== false ? true:false;
                    $status_expired = strpos($status, 'expired') !== false ? true:false;
                    $payment_methods = $DOT->get('payment_methods') != '' ? explode(',', $DOT->get('payment_methods')):array();
                    $search = $DOT->get('search') ? $DOT->get('search'):'';
                    $page = $DOT->get('page') ? $DOT->get('page'):'1';
                    $per_page = $DOT->get('per_page') ? $DOT->get('per_page'):'10';
                    $order = $DOT->get('order') ? $DOT->get('order'):'ASC';
                    $order_by = $DOT->get('order_by') ? $DOT->get('order_by'):'check_in';
                }
                
                /*
                 * Calendars query.
                 */
                if (strpos($calendar_id, ',') !== false){
                    $calendars_ids = explode(',', $calendar_id);
                    array_push($query, 'SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE (calendar_id=%d');
                    array_push($values, $calendars_ids[0]);
                    
                    for ($i=1; $i<count($calendars_ids); $i++){
                        array_push($query, ' OR calendar_id=%d');
                        array_push($values, $calendars_ids[$i]);
                    }
                    array_push($query, ')');
                }
                else{
                    array_push($query, 'SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id=%d');
                    array_push($values, $calendar_id);
                }

                /*
                 * Days query.
                 */
                if ($start_date != ''){
                    if ($end_date != ''){
                        array_push($query, ' AND (check_in >= %s AND check_in <= %s');
                        array_push($values, $start_date);
                        array_push($values, $end_date);
                    
                        array_push($query, ' OR check_out >= %s AND check_out <= %s AND check_out <> "")');
                        array_push($values, $start_date);
                        array_push($values, $end_date);
                    }
                    else{
                        array_push($query, ' AND (check_in >= %s)');
                        array_push($values, $start_date);
                    }
                }
                elseif ($end_date != ''){
                    array_push($query, ' AND check_in <= %s');
                    array_push($values, $end_date);
                }
               
               
                /*
                 * Hours query.
                 */
                array_push($query, ' AND (start_hour >= %s AND end_hour <= %s OR start_hour = "")');
                array_push($values, $start_hour);
                array_push($values, $end_hour);

                /*
                 * Status query.
                 */
                if ($status_pending 
                        || $status_approved 
                        || $status_rejected 
                        || $status_canceled 
                        || $status_expired){
                    $status_init = false;

                    if ($status_pending){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'pending');
                        $status_init = true;
                    }

                    if ($status_approved){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'approved');
                        $status_init = true;
                    }

                    if ($status_rejected){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'rejected');
                        $status_init = true;
                    }

                    if ($status_canceled){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'canceled');
                        $status_init = true;
                    }

                    if ($status_expired){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'expired');
                        $status_init = true;
                    }
                    array_push($query, ')');                    
                }
                else{
                    array_push($query, ' AND status <> %s');
                    array_push($values, 'expired');
                }

                /*
                 * Payment query.       
                 */
                if (count($payment_methods) > 0){
                    $payment_init = false;

                    for ($i=0; $i < count($payment_methods); $i++){
                        array_push($query, $payment_init ? ' OR payment_method=%s':' AND (payment_method=%s');
                        array_push($values, $payment_methods[$i]);
                        $payment_init = true;
                    }    
                    array_push($query, ')');                    
                }

                /*
                 * Search query.
                 */
                if ($search != ''){
                    array_push($query, ' AND (id=%s OR transaction_id=%s OR form LIKE %s)');
                    array_push($values, $search);
                    array_push($values, $search);
                    array_push($values, '%'.$search.'%');
                }
                
                /*
                 * Exclude reservations with incomplete payment.
                 */
                array_push($query, ' AND (token="" OR (token<>"" AND (payment_method="none" OR payment_method="default")))');
               
                /*
                 * Order query.
                 */
                $order_value = $order == 'DESC' ? 'DESC':'ASC';
                        
                switch ($order_by){
                    case 'check_out':
                        $order_by_value = 'check_out';
                        break;
                    case 'start_hour':
                        $order_by_value = 'start_hour';
                        break;
                    case 'end_hour':
                        $order_by_value = 'end_hour';
                        break;
                    case 'id':
                        $order_by_value = 'id';
                        break;
                    case 'status':
                        $order_by_value = 'status';
                        break;
                    case 'date_created':
                        $order_by_value = 'date_created';
                        break;
                    default:
                        $order_by_value = 'check_in';
                }
                
                array_push($query, ' ORDER BY '.$order_by_value.' '.($order_value));

                /*
                 * ************************************************************* Get number of reservations.
                 */
                if (!$api){
                    $reservations_total = $wpdb->get_var($wpdb->prepare(str_replace('*', 'COUNT(*)', implode('', $query)), $values));
                }
                else{
                    $reservations_total = 0;
                }

                /*
                 * Pagination query.
                 */
                array_push($query, ' LIMIT %d, %d');
                array_push($values, (($page-1)*$per_page));
                array_push($values, $per_page);
                
                /*
                 * ************************************************************* Get reservations.
                 */
                $reservations = $wpdb->get_results($wpdb->prepare(implode('', $query), $values));
                     
                if (!$api){
                    $DOPBSP->views->backend_reservations_list->template(array('reservations' => $reservations,
                                                                              'reservations_total' => $reservations_total));
                    die();
                }
                else{
                    return $reservations;
                }
            }
            
            /*
             * Search & display reservations list.
             * 
             * 
             * @post key (string): API key
             * @post calendar_id (string/integer): list of calendars or calendar
             * @post start_date (string): reservations start date
             * @post end_date (string): reservations end date
             * @post start_hour (string): reservations start hour
             * @post end_hour (string): reservations end hour
             * @post status_pending (boolean): display reservations with status pending
             * @post status_approved (boolean): display reservations with status approved
             * @post status_rejected (boolean): display reservations with status rejected
             * @post status_canceled (boolean): display reservations with status canceled
             * @post status_expired (boolean): display reservations with status expired
             * @post payment_methods (string): list of payment methods
             * @post search (string): search text
             * @post page (integer): page number to be displayed
             * @post per_page (integer): number of reservation displayed per page
             * @post order (string): order direction "ASC", "DESC"
             * @post order_by (string): order by "check_in", "check_out", "start_hour", "end_hour", "id", "status", "date_created"
             * 
             * @get dopbsp_api (boolean): will initilize API calls if it is enabled
             * @get calendar_id (string/integer): list of calendars or calendar
             * @get start_date (string): reservations start date
             * @get end_date (string): reservations end date
             * @get start_hour (string): reservations start hour
             * @get end_hour (string): reservations end hour
             * @get status (boolean): display reservations with selected status
             * @get payment_methods (string): list of payment methods
             * @get search (string): search text
             * @get page (integer): page number to be displayed
             * @get per_page (integer): number of reservation displayed per page
             * @get order (string): order direction "ASC", "DESC"
             * @get order_by (string): order by "check_in", "check_out", "start_hour", "end_hour", "id", "status", "date_created"
             * 
             * @return reservations list
             */
            function printReservations(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $calendars_ids = array();
                $query = array();
                $values = array();
                $api = $DOT->get('dopbsp_api') == 'true' ? true:false;
                
                if (!$api){
                    $calendar_id = $DOT->post('calendar_id');
                    $start_date = $DOT->post('start_date');
                    $end_date = $DOT->post('end_date');
                    $start_hour = $DOT->post('start_hour');
                    $end_hour = $DOT->post('end_hour');
                    $status_pending = $DOT->post('status_pending') == 'true' ? true:false;
                    $status_approved = $DOT->post('status_approved') == 'true' ? true:false;
                    $status_rejected = $DOT->post('status_rejected') == 'true' ? true:false;
                    $status_canceled = $DOT->post('status_canceled') == 'true' ? true:false;
                    $status_expired = $DOT->post('status_expired') == 'true' ? true:false;
                    $payment_methods = $DOT->post('payment_methods') == '' ? array():explode(',', $DOT->post('payment_methods'));
                    $search = $DOT->post('search');
                    $page = $DOT->post('page', 'int');
                    $per_page = $DOT->post('per_page', 'int');
                    $order = $DOT->post('order');
                    $order_by = $DOT->post('order_by');
                }
                else{
                    if ($DOT->get('calendar_id') !== false
			    || $DOT->get('calendar_id') != ''){
                        $calendars_requested = ','.$DOT->get('calendar_id').',';
                    }
                    else{
                        $calendars_requested = '';
                    }
                    
                    $calendars_id = array();
                    $key_pieces = explode('-', $DOT->post('key'));
                    $calendars = $DOPBSP->classes->backend_calendars->get(array('user_id' => (int)$key_pieces[1]));
                    
                    foreach ($calendars as $calendar){
                        if ($calendars_requested != ''){
                            if (strpos($calendars_requested, ','.(string)$calendar->id.',') !== false){
                                array_push($calendars_id, $calendar->id);
                            }
                        }
                        else{
                            array_push($calendars_id, $calendar->id);
                        }
                    }
                    
                    $calendar_id = implode(',', $calendars_id);
                    $start_date = $DOT->get('start_date') ? $DOT->get('start_date'):'';
                    $end_date = $DOT->get('end_date') ? $DOT->get('end_date'):'';
                    $start_hour = $DOT->get('start_hour') ? $DOT->get('start_hour'):'00:00';
                    $end_hour = $DOT->get('end_hour') ? $DOT->get('end_hour'):'24:00';
                    $status = $DOT->get('status') ? $DOT->get('status'):'';
                    $status_pending = strpos($status, 'pending') !== false ? true:false;
                    $status_approved = strpos($status, 'approved') !== false ? true:false;
                    $status_rejected = strpos($status, 'rejected') !== false ? true:false;
                    $status_canceled = strpos($status, 'canceled') !== false ? true:false;
                    $status_expired = strpos($status, 'expired') !== false ? true:false;
                    $payment_methods = $DOT->get('payment_methods') != '' ? explode(',', $DOT->get('payment_methods')):array();
                    $search = $DOT->get('search') ? $DOT->get('search'):'';
                    $page = $DOT->get('page') ? $DOT->get('page'):'1';
                    $per_page = $DOT->get('per_page') ? $DOT->get('per_page'):'10';
                    $order = $DOT->get('order') ? $DOT->get('order'):'ASC';
                    $order_by = $DOT->get('order_by') ? $DOT->get('order_by'):'check_in';
                }
                
                /*
                 * Calendars query.
                 */
                if (strpos($calendar_id, ',') !== false){
                    $calendars_ids = explode(',', $calendar_id);
                    array_push($query, 'SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE (calendar_id=%d');
                    array_push($values, $calendars_ids[0]);
                    
                    for ($i=1; $i<count($calendars_ids); $i++){
                        array_push($query, ' OR calendar_id=%d');
                        array_push($values, $calendars_ids[$i]);
                    }
                    array_push($query, ')');
                }
                else{
                    array_push($query, 'SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id=%d');
                    array_push($values, $calendar_id);
                }

                /*
                 * Days query.
                 */
                if ($start_date != ''){
                    if ($end_date != ''){
                        array_push($query, ' AND (check_in >= %s AND check_in <= %s');
                        array_push($values, $start_date);
                        array_push($values, $end_date);
                    
                        array_push($query, ' OR check_out >= %s AND check_out <= %s AND check_out <> "")');
                        array_push($values, $start_date);
                        array_push($values, $end_date);
                    }
                    else{
                        array_push($query, ' AND (check_in >= %s)');
                        array_push($values, $start_date);
                    }
                }
                elseif ($end_date != ''){
                    array_push($query, ' AND check_in <= %s');
                    array_push($values, $end_date);
                }
               
               
                /*
                 * Hours query.
                 */
                array_push($query, ' AND (start_hour >= %s AND end_hour <= %s OR start_hour = "")');
                array_push($values, $start_hour);
                array_push($values, $end_hour);

                /*
                 * Status query.
                 */
                if ($status_pending 
                        || $status_approved 
                        || $status_rejected 
                        || $status_canceled 
                        || $status_expired){
                    $status_init = false;

                    if ($status_pending){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'pending');
                        $status_init = true;
                    }

                    if ($status_approved){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'approved');
                        $status_init = true;
                    }

                    if ($status_rejected){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'rejected');
                        $status_init = true;
                    }

                    if ($status_canceled){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'canceled');
                        $status_init = true;
                    }

                    if ($status_expired){
                        array_push($query, $status_init ? ' OR status = %s':' AND (status = %s');
                        array_push($values, 'expired');
                        $status_init = true;
                    }
                    array_push($query, ')');                    
                }
                else{
                    array_push($query, ' AND status <> %s');
                    array_push($values, 'expired');
                }

                /*
                 * Payment query.       
                 */
                if (count($payment_methods) > 0){
                    $payment_init = false;

                    for ($i=0; $i < count($payment_methods); $i++){
                        array_push($query, $payment_init ? ' OR payment_method=%s':' AND (payment_method=%s');
                        array_push($values, $payment_methods[$i]);
                        $payment_init = true;
                    }    
                    array_push($query, ')');                    
                }

                /*
                 * Search query.
                 */
                if ($search != ''){
                    array_push($query, ' AND (id=%s OR transaction_id=%s OR form LIKE %s)');
                    array_push($values, $search);
                    array_push($values, $search);
                    array_push($values, '%'.$search.'%');
                }
                
                /*
                 * Exclude reservations with incomplete payment.
                 */
                array_push($query, ' AND (token="" OR (token<>"" AND (payment_method="none" OR payment_method="default")))');
               
                /*
                 * Order query.
                 */
                $order_value = $order == 'DESC' ? 'DESC':'ASC';
                        
                switch ($order_by){
                    case 'check_out':
                        $order_by_value = 'check_out';
                        break;
                    case 'start_hour':
                        $order_by_value = 'start_hour';
                        break;
                    case 'end_hour':
                        $order_by_value = 'end_hour';
                        break;
                    case 'id':
                        $order_by_value = 'id';
                        break;
                    case 'status':
                        $order_by_value = 'status';
                        break;
                    case 'date_created':
                        $order_by_value = 'date_created';
                        break;
                    default:
                        $order_by_value = 'check_in';
                }
                
                array_push($query, ' ORDER BY '.$order_by_value.' '.($order_value));

                /*
                 * ************************************************************* Get number of reservations.
                 */
                if (!$api){
                    $reservations_total = $wpdb->get_var($wpdb->prepare(str_replace('*', 'COUNT(*)', implode('', $query)), $values));
                }
                else{
                    $reservations_total = 0;
                }

                /*
                 * Pagination query.
                 */
                array_push($query, ' LIMIT %d, %d');
                array_push($values, (($page-1)*$per_page));
                array_push($values, $per_page);
                
                /*
                 * ************************************************************* Get reservations.
                 */
                $reservations = $wpdb->get_results($wpdb->prepare(implode('', $query), $values));
                     
                $DOPBSP->views->backend_reservations_list->templatePrint(array('reservations' => $reservations,
                                                                               'reservations_total' => $reservations_total));
                die();
            } // to add
        }
    }