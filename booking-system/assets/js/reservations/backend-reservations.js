
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/reservations/backend-reservations.js
* File Version            : 1.0.6
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations JavaScript class.
*/

var DOPBSPBackEndReservations = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
        
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Display reservations.
     */
    this.display = function(){
        var calendarID = $('#DOPBSP-calendar-ID').val();
        
        $('.DOPBSP-admin .dopbsp-main').css('display', 'block');  
        
        if (calendarID.indexOf(',') !== -1){
            $('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-add-button').addClass('dopbsp-disabled');
            $('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-calendar-button').addClass('dopbsp-disabled');
            DOPBSPBackEndReservations.saveFilters({calendar: ''});
        }
        else{
            $('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-add-button').removeClass('dopbsp-disabled');
            $('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-calendar-button').removeClass('dopbsp-disabled');
            DOPBSPBackEndReservations.saveFilters({calendar: calendarID});
        }
        
        if (calendarID.indexOf(',') !== -1){
            DOPBSPBackEndReservationsList.display();
        }
        else if ($('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-add-button').hasClass('dopbsp-selected')){
            DOPBSPBackEndReservationsAdd.display();
        }
        else if ($('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-calendar-button').hasClass('dopbsp-selected')){
            DOPBSPBackEndReservationsCalendar.display();
        }
        else if ($('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-list-button').hasClass('dopbsp-selected')){
            DOPBSPBackEndReservationsList.display();
        }
        else{
            if (DOPPrototypes.getCookie('DOPBSP_reservations_view') === 'calendar'){
                DOPBSPBackEndReservationsCalendar.display();
            }
            else{
                DOPBSPBackEndReservationsList.display();
            }
        }
    };
    
    this.export = function(type){
        
        if(type === ''){
            return false;
        }
        var paymentMethods = new Array();
                
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        /*
         * Get payment methods.
         */
        $('#DOPBSP-inputs-reservations-filters-payment input[type=checkbox]').each(function(){
            if ($(this).is(':checked')){
                paymentMethods.push($(this).attr('id').split('DOPBSP-reservations-payment-')[1]);
            }
        });
        
        this.ajaxRequestInProgress !== undefined ? this.ajaxRequestInProgress.abort():'';
        
        DOPBSPBackEndReservations.saveFilters({status_pending: $('#DOPBSP-reservations-pending').is(':checked') ? true:false,
                                        status_approved: $('#DOPBSP-reservations-approved').is(':checked') ? true:false,
                                        status_rejected: $('#DOPBSP-reservations-rejected').is(':checked') ? true:false,
                                        status_canceled: $('#DOPBSP-reservations-canceled').is(':checked') ? true:false,
                                        status_expired: $('#DOPBSP-reservations-expired').is(':checked') ? true:false,
                                        payment_methods: paymentMethods.join(','),
                                        per_page: $('#DOPBSP-reservations-per-page').val(),
                                        order: $('#DOPBSP-reservations-order').val(),
                                        order_by: $('#DOPBSP-reservations-order-by').val()});
        
        this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_reservations_get',
                                                      type: type,
                                                      calendar_id: $('#DOPBSP-calendar-ID').val(),
                                                      start_date: $('#DOPBSP-reservations-start-date').val(),
                                                      end_date: $('#DOPBSP-reservations-end-date').val(),
                                                      start_hour: $('#DOPBSP-reservations-start-hour').val(),
                                                      end_hour: $('#DOPBSP-reservations-end-hour').val(),
                                                      status_pending: $('#DOPBSP-reservations-pending').is(':checked') ? true:false,
                                                      status_approved: $('#DOPBSP-reservations-approved').is(':checked') ? true:false,
                                                      status_rejected: $('#DOPBSP-reservations-rejected').is(':checked') ? true:false,
                                                      status_canceled: $('#DOPBSP-reservations-canceled').is(':checked') ? true:false,
                                                      status_expired: $('#DOPBSP-reservations-expired').is(':checked') ? true:false,
                                                      payment_methods: paymentMethods.join(','),
                                                      search: $('#DOPBSP-reservations-search').val(),
                                                      search_by: $('#DOPBSP-reservations-search-by').val(),
                                                      page: $('#DOPBSP-reservations-page').val(),
                                                      per_page: $('#DOPBSP-reservations-per-page').val(),
                                                      order: $('#DOPBSP-reservations-order').val(),
                                                      order_by: $('#DOPBSP-reservations-order-by').val()}, function(data){
            data = $.trim(data);
            
            DOPBSPBackEndReservations.download(type, data);
            DOPBSPBackEnd.toggleMessages('none', '');
        });
    };
    
    this.download = function(type, text) {
        var element = document.createElement('a'),
            dataSaveType = 'data:text/plain;charset=utf-8,';
        
        if(type === 'CSV') {
            dataSaveType = 'data:Application/octet-stream,';
        } else if(type === 'excel') {
            dataSaveType = 'data:application/vnd.ms-excel,';
        } else if(type === 'ics') {
            dataSaveType = "data:text/calendar;charset=utf8,";
        }
        
        element.setAttribute('href', dataSaveType + encodeURIComponent(text));
        element.setAttribute('download', 'reservations.'+type);

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
    };
    
    /*
     * Save reservations filters in cookies.
     * 
     * @param filters (Object): filters list to be saved
     *                          * status_pending (Boolean): pending status filter
     *                          * status_approved (Boolean): approved status filter
     *                          * status_rejected (Boolean): rejected status filter
     *                          * status_canceled (Boolean): canceled status filter
     *                          * status_expired (Boolean): expired status filter
     *                          * payment_methods (String): selected payment methods
     *                          * per_page (Number): number of results per page (list only)
     *                          * order (String): order direction filter (list only)
     *                          * order_by (String): order by field filter (list only)
     * 
     */
    this.saveFilters = function(filters){
        for (var key in filters){
            DOPPrototypes.setCookie('DOPBSP_reservations_'+key, filters[key], 60);
        }
    };
    
    return this.__construct();
};