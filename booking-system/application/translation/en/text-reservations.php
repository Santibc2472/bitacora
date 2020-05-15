<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/translation/en/text-reservations.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Reservations english text.
 */

    global $dot_text;

    $dot_text['RESERVATIONS_PARENT'] = 'Reservations';
    
    $dot_text['RESERVATIONS_TITLE'] = 'Reservations';

    $dot_text['RESERVATIONS_DISPLAY_NEW_RESERVATIONS'] = 'Display new reservations';    
    $dot_text['RESERVATIONS_NO_RESERVATIONS'] = 'There are no reservations.';

    /*
     * Reservations calendar filters.
     */
    $dot_text['RESERVATIONS_FILTERS_CALENDAR'] = 'Calendar';
    $dot_text['RESERVATIONS_FILTERS_CALENDAR_ALL'] = 'All';

    /*
     * Reservations view filters.
     */
    $dot_text['RESERVATIONS_FILTERS_VIEW_CALENDAR'] = 'View calendar';
    $dot_text['RESERVATIONS_FILTERS_VIEW_LIST'] = 'View list';

    /*
     * Reservations period filters.
     */
    $dot_text['RESERVATIONS_FILTERS_PERIOD'] = 'Period';
    $dot_text['RESERVATIONS_FILTERS_START_DAY'] = 'Start day';
    $dot_text['RESERVATIONS_FILTERS_END_DAY'] = 'End day';
    $dot_text['RESERVATIONS_FILTERS_START_HOUR'] = 'Start hour';
    $dot_text['RESERVATIONS_FILTERS_END_HOUR'] = 'End hour';

    /*
     * Reservations status filters.
     */
    $dot_text['RESERVATIONS_FILTERS_STATUS'] = 'Status';
    $dot_text['RESERVATIONS_FILTERS_STATUS_LABEL'] = 'Select statuses';
    $dot_text['RESERVATIONS_FILTERS_STATUS_PENDING'] = 'Pending';
    $dot_text['RESERVATIONS_FILTERS_STATUS_APPROVED'] = 'Approved';
    $dot_text['RESERVATIONS_FILTERS_STATUS_REJECTED'] = 'Rejected';
    $dot_text['RESERVATIONS_FILTERS_STATUS_CANCELED'] = 'Canceled';
    $dot_text['RESERVATIONS_FILTERS_STATUS_EXPIRED'] = 'Expired';

    /*
     * Reservations payment filters.
     */
    $dot_text['RESERVATIONS_FILTERS_PAYMENT_LABEL'] = 'Select payment methods';

    /*
     * Reservations search filters.
     */
    $dot_text['RESERVATIONS_FILTERS_SEARCH'] = 'Search';

    $dot_text['RESERVATIONS_FILTERS_PAGE'] = 'Page';
    $dot_text['RESERVATIONS_FILTERS_PER_PAGE'] = 'Reservations per page';

    $dot_text['RESERVATIONS_FILTERS_ORDER'] = 'Order';
    $dot_text['RESERVATIONS_FILTERS_ORDER_ASCENDING'] = 'Ascending';
    $dot_text['RESERVATIONS_FILTERS_ORDER_DESCENDING'] = 'Descending';
    $dot_text['RESERVATIONS_FILTERS_ORDER_BY'] = 'Order by';

    /*
     * Add
     */
    $dot_text['RESERVATIONS_RESERVATION_ADD'] = 'Add reservation';
    $dot_text['RESERVATIONS_RESERVATION_ADD_SUCCESS'] = 'Add reservation';

    /*
     * Details
     */
    $dot_text['RESERVATIONS_RESERVATION_DETAILS_TITLE'] = 'Details';

    $dot_text['RESERVATIONS_RESERVATION_ID'] = 'Reservation ID';
    $dot_text['RESERVATIONS_RESERVATION_DATE_CREATED'] = 'Date created';
    $dot_text['RESERVATIONS_RESERVATION_IP_ADDRESS'] = 'IP address';
    $dot_text['RESERVATIONS_RESERVATION_CALENDAR_ID'] = 'Calendar ID';
    $dot_text['RESERVATIONS_RESERVATION_CALENDAR_NAME'] = 'Calendar name';
    $dot_text['RESERVATIONS_RESERVATION_LANGUAGE'] = 'Selected language';

    /*
     * Status
     */
    $dot_text['RESERVATIONS_RESERVATION_STATUS'] = 'Status';
    $dot_text['RESERVATIONS_RESERVATION_STATUS_PENDING'] = 'Pending';
    $dot_text['RESERVATIONS_RESERVATION_STATUS_APPROVED'] = 'Approved';
    $dot_text['RESERVATIONS_RESERVATION_STATUS_REJECTED'] = 'Rejected';
    $dot_text['RESERVATIONS_RESERVATION_STATUS_CANCELED'] = 'Canceled';
    $dot_text['RESERVATIONS_RESERVATION_STATUS_EXPIRED'] = 'Expired';

    /*
     * Payment details.
     */
    $dot_text['RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'] = 'Price change';

    /*
     * Sync details.
     */
    $dot_text['RESERVATIONS_RESERVATION_SYNC'] = 'Synced from';

    /*
     * Sync details.
     */
    $dot_text['RESERVATIONS_APPROVE_UNAVAILABLE'] = 'Another approved reservation already exists for this period.';

    /*
     * No data.
     */
    $dot_text['RESERVATIONS_RESERVATION_NO_EXTRAS'] = 'No extras.';
    $dot_text['RESERVATIONS_RESERVATION_NO_DISCOUNT'] = 'No discount.';
    $dot_text['RESERVATIONS_RESERVATION_NO_COUPON'] = 'No coupon.';
    $dot_text['RESERVATIONS_RESERVATION_NO_FEES'] = 'No taxes or fees.';
    $dot_text['RESERVATIONS_RESERVATION_NO_ADDRESS_BILLING'] = 'No billing address.';
    $dot_text['RESERVATIONS_RESERVATION_NO_ADDRESS_SHIPPING'] = 'No shipping address.';
    $dot_text['RESERVATIONS_RESERVATION_NO_FORM'] = 'Form was not completed.';
    $dot_text['RESERVATIONS_RESERVATION_NO_FORM_FIELD'] = 'Form field was not completed.';

    $dot_text['RESERVATIONS_RESERVATION_ADDRESS_SHIPPING_COPY'] = 'Same as billing address.';

    $dot_text['RESERVATIONS_RESERVATION_INSTRUCTIONS'] = 'Click to edit the reservation.';

    /*
     * Approve reservation.
     */
    $dot_text['RESERVATIONS_RESERVATION_APPROVE'] = 'Approve';
    $dot_text['RESERVATIONS_RESERVATION_APPROVE_CONFIRMATION'] = 'Are you sure you want to approve this reservation?';
    $dot_text['RESERVATIONS_RESERVATION_APPROVE_SUCCESS'] = 'The reservation has been approved.';

    /*
     * Cancel reservation.
     */
    $dot_text['RESERVATIONS_RESERVATION_CANCEL'] = 'Cancel';
    $dot_text['RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION'] = 'Are you sure you want to cancel this reservation?';
    $dot_text['RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION_REFUND'] = 'Are you sure you want to cancel this reservation? A refund will be issued automatically.';
    $dot_text['RESERVATIONS_RESERVATION_CANCEL_SUCCESS'] = 'The reservation has been canceled.';
    $dot_text['RESERVATIONS_RESERVATION_CANCEL_SUCCESS_REFUND'] = 'A refund of %s has been made.';
    $dot_text['RESERVATIONS_RESERVATION_CANCEL_SUCCESS_REFUND_WARNING'] = 'A refund or a partial refund has already been made.';
    
    /*
     * Delete reservation.
     */
    $dot_text['RESERVATIONS_RESERVATION_DELETE'] = 'Delete';
    $dot_text['RESERVATIONS_RESERVATION_DELETE_CONFIRMATION'] = 'Are you sure you want to delete this reservation?';
    $dot_text['RESERVATIONS_RESERVATION_DELETE_SUCCESS'] = 'The reservation has been deleted.';

    /*
     * Reject reservation.
     */
    $dot_text['RESERVATIONS_RESERVATION_REJECT'] = 'Reject';
    $dot_text['RESERVATIONS_RESERVATION_REJECT_CONFIRMATION'] = 'Are you sure you want to reject this reservation?';
    $dot_text['RESERVATIONS_RESERVATION_REJECT_SUCCESS'] = 'The reservation has been rejected.';

    $dot_text['RESERVATIONS_RESERVATION_CLOSE'] = 'Close';

    /*
     * Reservations calendar filters.
     */
    $dot_text['RESERVATIONS_FILTERS_CALENDAR_HELP'] = 'Select the calendar for which you want to see reservations, or display all reservations.';

    /*
     * Reservations view filters.
     */
    $dot_text['RESERVATIONS_FILTERS_VIEW_CALENDAR_HELP'] = 'Selecting "Calendar view" will display the reservations in a calendar. Only possible when you select one calendar.';
    $dot_text['RESERVATIONS_FILTERS_VIEW_LIST_HELP'] = 'Selecting "List view" will display the reservations in a list.';

    /*
     * Reservations period filters.
     */
    $dot_text['RESERVATIONS_FILTERS_START_DAY_HELP'] = 'Select the day from where displayed reservations start.';
    $dot_text['RESERVATIONS_FILTERS_END_DAY_HELP'] = 'Select the day where displayed reservations end.';
    $dot_text['RESERVATIONS_FILTERS_START_HOUR_HELP'] = 'Select the hour from where displayed reservations start.';
    $dot_text['RESERVATIONS_FILTERS_END_HOUR_HELP'] = 'Select the hour where displayed reservations end.';

    /*
     * Reservations status filters.
     */
    $dot_text['RESERVATIONS_FILTERS_STATUS_HELP'] = 'Display reservations with selected status.';

    /*
     * Reservations payment filters.
     */
    $dot_text['RESERVATIONS_FILTERS_PAYMENT_HELP'] = 'Display reservations with selected payment methods.';

    /*
     * Reservations search filters.
     */
    $dot_text['RESERVATIONS_FILTERS_SEARCH_HELP'] = 'Enter the search value.';

    $dot_text['RESERVATIONS_FILTERS_PAGE_HELP'] = 'Select page.';
    $dot_text['RESERVATIONS_FILTERS_PER_PAGE_HELP'] = 'Select the number of reservations which will be displayed on page.';

    $dot_text['RESERVATIONS_FILTERS_ORDER_HELP'] = 'Order the reservations ascending or descending.';
    $dot_text['RESERVATIONS_FILTERS_ORDER_BY_HELP'] = 'Select the field after which the reservations will be sorted.';

    $dot_text['RESERVATIONS_RESERVATION_FRONT_END_TITLE'] = 'Reservation';
    $dot_text['RESERVATIONS_RESERVATION_FRONT_END_SELECT_DAYS'] = 'Please select the days from calendar.';
    $dot_text['RESERVATIONS_RESERVATION_FRONT_END_SELECT_HOURS'] = 'Please select the days and hours from calendar.';
    $dot_text['RESERVATIONS_RESERVATION_FRONT_END_PRICE'] = 'Price';
    $dot_text['RESERVATIONS_RESERVATION_FRONT_END_TOTAL_PRICE'] = 'Total';

    $dot_text['RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT'] = 'Deposit';
    $dot_text['RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT_LEFT'] = 'Left to pay';