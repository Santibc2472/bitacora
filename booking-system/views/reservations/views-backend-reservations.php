<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : views/reservations/views-backend-reservations.php
* File Version            : 1.1.9
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations views class.
*/

    if (!class_exists('DOPBSPViewsBackEndReservations')){
        class DOPBSPViewsBackEndReservations extends DOPBSPViewsBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns reservations template.
             * 
             * @param args (array): function arguments
             * 
             * @return reservations HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE'), $DOPBSP->text('RESERVATIONS_TITLE')); ?>
        <input type="hidden" name="DOPBSP-reservations-total" id="DOPBSP-reservations-total" value="" />
        
<!--
    Content
-->
        <div class="dopbsp-main dopbsp-hidden">
            <table class="dopbsp-content-wrapper">
                <colgroup>
                    <col id="DOPBSP-col-column1" class="dopbsp-column1 dopbsp-reservations" />
                    <col id="DOPBSP-col-column-separator1" class="dopbsp-separator" />
                    <col id="DOPBSP-col-column2" class="dopbsp-column2" />
                    <col id="DOPBSP-col-column-separator2" class="dopbsp-separator" />
                    <col id="DOPBSP-col-column3" class="dopbsp-column3" />
                </colgroup>
                <tbody>
                    <tr>
                        <td class="dopbsp-column" id="DOPBSP-column1">
                            <div class="dopbsp-column-header">
                                <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('RESERVATIONS_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>                           
                                <br class="dopbsp-clear" />
                            </div>
                            <div class="dopbsp-column-content">
<?php
                $this->filters();
?>                    
                            </div>
                        </td>
                        <td id="DOPBSP-column-separator1" class="dopbsp-separator"></td>
                        <td id="DOPBSP-column2" class="dopbsp-column">
                            <div class="dopbsp-column-header">&nbsp;</div>
                            <div class="dopbsp-column-content">&nbsp;</div>
                        </td>
                        <td id="DOPBSP-column-separator2" class="dopbsp-separator"></td>
                        <td id="DOPBSP-column3" class="dopbsp-column">
                            <div class="dopbsp-column-header">&nbsp;</div>
                            <div class="dopbsp-column-content">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>       
<?php
            }
            
            /*
             * Returns filters template.
             * 
             * @return filters HTML
             */
            function filters(){
                global $DOPBSP;
                
                $this->getTranslation();
                $hours = $DOPBSP->classes->prototypes->getHours('00:00',
                                                                '24:00',
                                                                60);
?>                        
                                <!--
                                    General filters.
                                -->
                                <div id="DOPBSP-inputs-reservations-filters-calendars" class="dopbsp-inputs-wrapper">
                                    <!--
                                        Calendars list.
                                    -->
                                    <div class="dopbsp-input-wrapper">
                                        <label for="DOPBSP-calendar-ID"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_CALENDAR'); ?></label>
                                        <select name="DOPBSP-calendar-ID" id="DOPBSP-calendar-ID" onchange="DOPBSPBackEndReservations.display()">
                                            <?php echo $this->listCalendars(); ?>
                                        </select>
                                        <script type="text/JavaScript">
                                            jQuery('#DOPBSP-calendar-ID').DOPSelect();
                                        </script>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_CALENDAR_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>

                                    <!--
                                        View
                                    -->
                                    <div class="dopbsp-input-wrapper dopbsp-last">
                                        <label>&nbsp;</label>
                                        <a href="javascript:DOPBSPBackEndReservationsList.display()" class="dopbsp-button dopbsp-reservations-list-button">
                                            <span class="dopbsp-info"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_LIST'); ?></span>
                                        </a>
                                        <a href="javascript:DOPBSPBackEndReservationsCalendar.display()" class="dopbsp-button dopbsp-reservations-calendar-button">
                                            <span class="dopbsp-info"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_CALENDAR'); ?></span>
                                        </a>
                                        <a href="javascript:DOPBSPBackEndReservationsAdd.display()" class="dopbsp-button dopbsp-reservations-add-button">
                                            <span class="dopbsp-info"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_ADD'); ?></span>
                                        </a>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help">
                                            <span class="dopbsp-info dopbsp-help">
                                                <?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_LIST_HELP'); ?>
                                                <br /><br />
                                                <?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_CALENDAR_HELP'); ?>
                                                <br /><br />
                                                <?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                
                                <!--
                                    Period
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide">
                                    <h3><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_PERIOD'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('reservations-filters-period')" id="DOPBSP-inputs-button-reservations-filters-period" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-period" class="dopbsp-inputs-wrapper">
                                
                                    <!--
                                        Start date.
                                    -->
                                    <div id="DOPBSP-reservations-start-date-wrapper" class="dopbsp-input-wrapper dopbsp-data">
                                        <label for="DOPBSP-reservations-start-date"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_START_DAY'); ?></label>
                                        <input type="text" name="DOPBSP-reservations-start-date" id="DOPBSP-reservations-start-date" class="dopbsp-left" value="" onchange="DOPBSPBackEndReservationsList.get()" />
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_START_DAY_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
                                
                                    <!--
                                        End date.
                                    -->
                                    <div id="DOPBSP-reservations-end-date-wrapper" class="dopbsp-input-wrapper dopbsp-data">
                                        <label for="DOPBSP-reservations-end-date"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_END_DAY'); ?></label>
                                        <input type="text" name="DOPBSP-reservations-end-date" id="DOPBSP-reservations-end-date" class="dopbsp-left" value="" onchange="DOPBSPBackEndReservationsList.get()" />
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_END_DAY_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
<?php
                /*
                 * Start hour.
                 */
                $this->displaySelectInput(array('id' => 'start-hour',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_START_HOUR'),
                                                'value' => '00:00',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_START_HOUR_HELP'),
                                                'options' => implode(';;', $hours),
                                                'options_values' => implode(';;', $hours),
                                                'container_class' => '',
                                                'input_class' => 'dopbsp-hour'));
                /*
                 * End hour.
                 */
                $this->displaySelectInput(array('id' => 'end-hour',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_END_HOUR'),
                                                'value' => '23:59',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_END_HOUR_HELP'),
                                                'options' => implode(';;', $hours),
                                                'options_values' => implode(';;', $hours),
                                                'container_class' => 'dopbsp-last',
                                                'input_class' => 'dopbsp-hour'));
?>                
                                </div>
                                
                                <!--
                                    Period
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide">
                                    <h3><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('reservations-filters-status')" id="DOPBSP-inputs-button-reservations-filters-status" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-status" class="dopbsp-inputs-wrapper">
                                    <div class="dopbsp-input-wrapper dopbsp-last">
                                        <label><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_LABEL'); ?></label>
                                        <div class="dopbsp-checkboxes-wrapper">
                                            <!--
                                                Pending
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-pending" id="DOPBSP-reservations-pending"<?php echo isset($_COOKIE['DOPBSP_reservations_status_pending']) && $_COOKIE['DOPBSP_reservations_status_pending'] == 'true' ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" id="DOPBSP-reservations-pending-label" for="DOPBSP-reservations-pending"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_PENDING'); ?></label>
                                            <br class="dopbsp-clear" />
                                            <!--
                                                Approved
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-approved" id="DOPBSP-reservations-approved"<?php echo isset($_COOKIE['DOPBSP_reservations_status_approved']) && $_COOKIE['DOPBSP_reservations_status_approved'] == 'true' ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" id="DOPBSP-reservations-approved-label" for="DOPBSP-reservations-approved"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_APPROVED'); ?></label>
                                            <br class="dopbsp-clear" />
                                            <!--
                                                Rejected
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-rejected" id="DOPBSP-reservations-rejected"<?php echo isset($_COOKIE['DOPBSP_reservations_status_rejected']) && $_COOKIE['DOPBSP_reservations_status_rejected'] == 'true' ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" id="DOPBSP-reservations-rejected-label" for="DOPBSP-reservations-rejected"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_REJECTED'); ?></label>
                                            <br class="dopbsp-clear" />
                                            <!--
                                                Canceled
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-canceled" id="DOPBSP-reservations-canceled"<?php echo isset($_COOKIE['DOPBSP_reservations_status_canceled']) && $_COOKIE['DOPBSP_reservations_status_canceled'] == 'true' ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" id="DOPBSP-reservations-canceled-label" for="DOPBSP-reservations-canceled"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_CANCELED'); ?></label>
                                            <br class="dopbsp-clear" />
                                            <!--
                                                Expired
                                            -->
                                            <div id="DOPBSP-reservations-expired-wrapper">
                                                <input type="checkbox" name="DOPBSP-reservations-expired" id="DOPBSP-reservations-expired"<?php echo isset($_COOKIE['DOPBSP_reservations_status_expired']) && $_COOKIE['DOPBSP_reservations_status_expired'] == 'true' ? ' checked="checked"':'';  ?> />
                                                <label class="dopbsp-for-checkbox" id="DOPBSP-reservations-expired-label" for="DOPBSP-reservations-expired"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_EXPIRED'); ?></label>
                                                <br class="dopbsp-clear" />
                                            </div>
                                        </div>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
                                </div>
                                
                                <!--
                                    Payment
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide">
                                    <h3><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('reservations-filters-payment')" id="DOPBSP-inputs-button-reservations-filters-payment" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-payment" class="dopbsp-inputs-wrapper">
                                    <div class="dopbsp-input-wrapper last">
                                        <label><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_PAYMENT_LABEL'); ?></label>
                                        <div class="dopbsp-checkboxes-wrapper">  
                                            <!--
                                                None
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-payment-none" id="DOPBSP-reservations-payment-none"<?php echo isset($_COOKIE['DOPBSP_reservations_payment_methods']) && strpos($_COOKIE['DOPBSP_reservations_payment_methods'], 'none') !== false ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" for="DOPBSP-reservations-payment-none"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'); ?></label>
                                            <br class="dopbsp-clear" />
                                            <!--
                                                Arrival
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-payment-default" id="DOPBSP-reservations-payment-default"<?php echo isset($_COOKIE['DOPBSP_reservations_payment_methods']) && strpos($_COOKIE['DOPBSP_reservations_payment_methods'], 'default') !== false ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" for="DOPBSP-reservations-payment-arrival"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_ARRIVAL'); ?></label>  
                                            <br class="dopbsp-clear" />
                                            <!--
                                                WooCommerce
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-payment-woocommerce" id="DOPBSP-reservations-payment-woocommerce"<?php echo isset($_COOKIE['DOPBSP_reservations_payment_methods']) && strpos($_COOKIE['DOPBSP_reservations_payment_methods'], 'woocommerce') !== false ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" for="DOPBSP-reservations-payment-woocomemrce"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE'); ?></label>
                                            <br class="dopbsp-clear" />
                                            <!--
                                                Payment gateways.
                                            -->
<?php
                $pg_list = $DOPBSP->classes->payment_gateways->get();
                
                for ($i=0; $i<count($pg_list); $i++){
                    $pg_id = $pg_list[$i];
                                        
?>
                                            <input type="checkbox" name="DOPBSP-reservations-payment-<?php echo $pg_id; ?>" id="DOPBSP-reservations-payment-<?php echo $pg_id; ?>"<?php echo isset($_COOKIE['DOPBSP_reservations_payment_methods']) && strpos($_COOKIE['DOPBSP_reservations_payment_methods'], $pg_id) !== false ? ' checked="checked"':'';  ?> />
                                            <label class="dopbsp-for-checkbox" for="DOPBSP-reservations-payment-<?php echo $pg_id; ?>"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_'.strtoupper($pg_id)); ?></label>
                                            <br class="dopbsp-clear" />
<?php                                            
                }
?>
                                        </div>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_PAYMENT_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
                                </div>
                                
                                <!--
                                    Search
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide dopbsp-last">
                                    <h3><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_SEARCH'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('reservations-filters-search')" id="DOPBSP-inputs-button-reservations-filters-search" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-search" class="dopbsp-inputs-wrapper dopbsp-last">
<?php
                /*
                 * Search
                 */
                $this->displayTextInput(array('id' => 'search',
                                              'label' => $DOPBSP->text('RESERVATIONS_FILTERS_SEARCH'),
                                              'help' => $DOPBSP->text('RESERVATIONS_FILTERS_SEARCH_HELP')));
                /*
                 * Page
                 */
                $this->displaySelectInput(array('id' => 'page',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_PAGE'),
                                                'value' => '',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_PAGE_HELP'),
                                                'options' => '1',
                                                'options_values' => '1',
                                                'container_class' => '',
                                                'dop_select' => false,
                                                'input_class' => 'dopbsp-small'));
                /*
                 * Per page.
                 */
                $this->displaySelectInput(array('id' => 'per-page',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_PER_PAGE'),
                                                'value' => isset($_COOKIE['DOPBSP_reservations_per_page']) && $_COOKIE['DOPBSP_reservations_per_page'] != '' ? $_COOKIE['DOPBSP_reservations_per_page']:'25',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_PER_PAGE_HELP'),
                                                'options' => '5;;10;;25;;50;;100',
                                                'options_values' => '5;;10;;25;;50;;100',
                                                'container_class' => '',
                                                'input_class' => 'dopbsp-small'));
                /*
                 * Order
                 */
                $this->displaySelectInput(array('id' => 'order',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER'),
                                                'value' => isset($_COOKIE['DOPBSP_reservations_order']) && $_COOKIE['DOPBSP_reservations_order'] != '' ? $_COOKIE['DOPBSP_reservations_order']:'ASC',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_HELP'),
                                                'options' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_ASCENDING').';;'.
                                                             $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_DESCENDING'),
                                                'options_values' => 'ASC;;DESC'));
                /*
                 * Order by.
                 */
                $this->displaySelectInput(array('id' => 'order-by',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_BY'),
                                                'value' => isset($_COOKIE['DOPBSP_reservations_order_by']) && $_COOKIE['DOPBSP_reservations_order_by'] != '' ? $_COOKIE['DOPBSP_reservations_order_by']:'check_in',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_BY_HELP'),
                                                'options' => $DOPBSP->text('SEARCH_FRONT_END_CHECK_IN').';;'.
                                                             $DOPBSP->text('SEARCH_FRONT_END_CHECK_OUT').';;'.
                                                             $DOPBSP->text('SEARCH_FRONT_END_START_HOUR').';;'.
                                                             $DOPBSP->text('SEARCH_FRONT_END_END_HOUR').';;'.
                                                             'ID;;'.
                                                             $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS').';;'.
                                                             $DOPBSP->text('RESERVATIONS_RESERVATION_DATE_CREATED'),
                                                'options_values' => 'check_in;;check_out;;start_hour;;end_hour;;id;;status;;date_created',
                                                'container_class' => 'dopbsp-last'));
?>      
                                </div>
<?php                
            }
            
            /*
             * Returns reservations list template.
             * 
             * @param reservations (array): reservations list
             * 
             * @return list HTML
             */
            function displayList($reservations){
                global $DOPBSP;
                
?>
                <ul class="dopbsp-reservations-list">
<?php
                /*
                 * Check if reservations exist.
                 */
                if (count($reservations) > 0){
                    foreach ($reservations as $reservation){
                        $DOPBSP->views->backend_reservation->template(array('reservation' => $reservation));
                    }
                }
                else{
?>                    
                    <li class="dopbsp-no-data"><?php echo $DOPBSP->text('RESERVATIONS_NO_RESERVATIONS'); ?></li>
<?php                    
                }
?>
                </ul>    
<?php
            }
            
/*
 * Inputs.
 */
            /*
             * Create a text input field for filters.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * settings_id (integer): settings ID
             *                      * help (string): field help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-reservations-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-reservations-'.$id.'" id="DOPBSP-reservations-'.$id.'" class="dopbsp-left '.$input_class.'" value="" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndReservationsList.get();}" onpaste="DOPBSPBackEndReservationsList.get()" onblur="DOPBSPBackEndReservationsList.get()" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Create a drop down field for filters.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field default value
             *                      * help (string): field help
             *                      * options (string): options labels
             *                      * options_values (string): options values
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return drop down HTML
             */
            function displaySelectInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $help = $args['help'];
                $options = $args['options'];
                $options_values = $args['options_values'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                
                $html = array();
                $options_data = explode(';;', $options);
                $options_values_data = explode(';;', $options_values);
                
                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-reservations-'.$id.'">'.$label.'</label>');
                array_push($html, '     <select name="DOPBSP-reservations-'.$id.'" id="DOPBSP-reservations-'.$id.'" class="dopbsp-left '.$input_class.'" '.($id !== 'start-hour' && $id !== 'end-hour' ? 'onchange="DOPBSPBackEndReservationsList.get('.($id == 'page' ? 'false':'').')"':'').'>');
                
                for ($i=0; $i<count($options_data); $i++){
                    if ($value != $options_values_data[$i]){
                        array_push($html, '     <option value="'.$options_values_data[$i].'">'.$options_data[$i].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$options_values_data[$i].'" selected="selected">'.$options_data[$i].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">jQuery(\'#DOPBSP-reservations-'.$id.'\').DOPSelect();</script>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                
                echo implode('', $html);
            }
            
            /*
             * List calendars in drop down.
             * 
             * @return calendars list
             */
            function listCalendars(){
                global $DOPBSP;
                                
                $calendars = $DOPBSP->classes->backend_calendars->get();
                $calendars_ids = array();
                $html = array();
                
                /* 
                 * Create calendars list HTML.
                 */
                if (count($calendars) > 0){
                    foreach ($calendars as $calendar){
                        array_push($calendars_ids, $calendar->id);
                        array_push($html, '<option value="'.$calendar->id.'" '.(isset($_COOKIE['DOPBSP_reservations_calendar']) && $_COOKIE['DOPBSP_reservations_calendar'] == $calendar->id ? 'selected="selected"':'').'>ID: '.$calendar->id.' - '.$calendar->name.'</option>');
                    }
                }
                
                return (count($calendars_ids) > 1 ? '<option value="'.implode(',', $calendars_ids).'">'.$DOPBSP->text('RESERVATIONS_FILTERS_CALENDAR_ALL').'</option>':'').
                       implode('', $html);
            }
        }
    }