
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.4
* File                    : assets/js/reservations/backend-reservations-list.js
* File Version            : 1.1.2
* Created / Last Modified : 05 May 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations list JavaScript class.
*/

var DOPBSPBackEndReservationsList = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables
     */
    this.ajaxRequestInProgress;
        
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Display reservations.
     */
    this.display = function(){
        DOPBSPBackEndReservations.saveFilters({view: 'list'});
        
        /*
         * Clear previous content.
         */
        DOPBSPBackEnd.clearColumns(2);
        $('#DOPBSP-col-column-separator2').css('display', 'none');
        $('#DOPBSP-col-column3').css('display', 'none');
        $('#DOPBSP-column-separator2').css('display', 'none');
        $('#DOPBSP-column3').css('display', 'none');
        
        if ($('.DOPBSPReservationsCalendar-tooltip').length !== undefined){
            $('.DOPBSPReservationsCalendar-tooltip').remove();
        }
        
        /*
         * Set buttons.
         */
        $('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-list-button').addClass('dopbsp-selected');
        $('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-add-button').removeClass('dopbsp-selected');
        $('.DOPBSP-admin .dopbsp-main .dopbsp-button.dopbsp-reservations-calendar-button').removeClass('dopbsp-selected');
        
        /*
         * Set filters.
         */
        $('#DOPBSP-inputs-reservations-filters-calendars').removeClass('dopbsp-last');
        
        $('#DOPBSP-inputs-button-reservations-filters-period').parent().css('display', 'block');
        $('#DOPBSP-inputs-reservations-filters-period').css('display', $('#DOPBSP-inputs-button-reservations-filters-period').parent().hasClass('dopbsp-display') ? 'none':'block');
        $('#DOPBSP-reservations-start-date-wrapper').css('display', 'block');
        $('#DOPBSP-reservations-end-date-wrapper').css('display', 'block');
        
        $('#DOPBSP-inputs-button-reservations-filters-status').parent().css('display', 'block');
        $('#DOPBSP-inputs-reservations-filters-status').css('display', $('#DOPBSP-inputs-button-reservations-filters-status').parent().hasClass('dopbsp-display') ? 'none':'block');
        $('#DOPBSP-reservations-expired-wrapper').css('display', 'block');
        
        $('#DOPBSP-inputs-button-reservations-filters-payment').parent().css('display', 'block')
                                                                        .removeClass('dopbsp-last');
        $('#DOPBSP-inputs-reservations-filters-payment').css('display', $('#DOPBSP-inputs-button-reservations-filters-payment').parent().hasClass('dopbsp-display') ? 'none':'block')
                                                        .removeClass('dopbsp-last');
        
        $('#DOPBSP-inputs-button-reservations-filters-search').parent().css('display', 'block');
        $('#DOPBSP-inputs-reservations-filters-search').css('display', $('#DOPBSP-inputs-button-reservations-filters-search').parent().hasClass('dopbsp-display') ? 'none':'block');
        
        this.init();
        this.get();
    };
    
    /*
     * Initialize reservations list.
     */
    this.init = function(){
        var dayNames = [DOPBSPBackEnd.text('DAY_SUNDAY'),
                        DOPBSPBackEnd.text('DAY_MONDAY'),
                        DOPBSPBackEnd.text('DAY_TUESDAY'),
                        DOPBSPBackEnd.text('DAY_WEDNESDAY'),
                        DOPBSPBackEnd.text('DAY_THURSDAY'),
                        DOPBSPBackEnd.text('DAY_FRIDAY'),
                        DOPBSPBackEnd.text('DAY_SATURDAY')],
        dayShortNames = [DOPBSPBackEnd.text('SHORT_DAY_SUNDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_MONDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_TUESDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_WEDNESDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_THURSDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_FRIDAY'),
                         DOPBSPBackEnd.text('SHORT_DAY_SATURDAY')],
        monthNames = [DOPBSPBackEnd.text('MONTH_JANUARY'),
                      DOPBSPBackEnd.text('MONTH_FEBRUARY'),
                      DOPBSPBackEnd.text('MONTH_MARCH'),
                      DOPBSPBackEnd.text('MONTH_APRIL'),
                      DOPBSPBackEnd.text('MONTH_MAY'),
                      DOPBSPBackEnd.text('MONTH_JUNE'),
                      DOPBSPBackEnd.text('MONTH_JULY'),
                      DOPBSPBackEnd.text('MONTH_AUGUST'),
                      DOPBSPBackEnd.text('MONTH_SEPTEMBER'),
                      DOPBSPBackEnd.text('MONTH_OCTOBER'),
                      DOPBSPBackEnd.text('MONTH_NOVEMBER'),
                      DOPBSPBackEnd.text('MONTH_DECEMBER')],
        monthShortNames = [DOPBSPBackEnd.text('SHORT_MONTH_JANUARY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_FEBRUARY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_MARCH'),
                           DOPBSPBackEnd.text('SHORT_MONTH_APRIL'),
                           DOPBSPBackEnd.text('SHORT_MONTH_MAY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_JUNE'),
                           DOPBSPBackEnd.text('SHORT_MONTH_JULY'),
                           DOPBSPBackEnd.text('SHORT_MONTH_AUGUST'),
                           DOPBSPBackEnd.text('SHORT_MONTH_SEPTEMBER'),
                           DOPBSPBackEnd.text('SHORT_MONTH_OCTOBER'),
                           DOPBSPBackEnd.text('SHORT_MONTH_NOVEMBER'),
                           DOPBSPBackEnd.text('SHORT_MONTH_DECEMBER')],
        startDate,
        minDate;
        
        /*
         * Start date.
         */
        $('#DOPBSP-reservations-start-date').datepicker('destroy');                      
        $('#DOPBSP-reservations-start-date').datepicker({beforeShow: function(input, inst){
                                                            $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                                                   .addClass('DOPBSP-admin-datepicker');
                                                        },
                                                        dateFormat: 'yy-mm-dd',
                                                        dayNames: dayNames,
                                                        dayNamesMin: dayShortNames,
                                                        minDate: null,
                                                        monthNames: monthNames,
                                                        monthNamesMin: monthShortNames,
                                                        nextText: '',
                                                        prevText: ''});
                           
        $('#DOPBSP-reservations-start-date').unbind('change');
        $('#DOPBSP-reservations-start-date').bind('change', function(){
            $('#DOPBSP-reservations-end-date').val('');
            DOPBSPBackEndReservationsList.init();
        });
        
        /*
         * End date.
         */
        startDate = $('#DOPBSP-reservations-start-date'); 
	minDate = startDate.val() === '' ? 0:(DOPPrototypes.getToday() > startDate.val() ? -1:1)*DOPPrototypes.getDatesDifference(DOPPrototypes.getToday(), startDate.val(), 'days', 'integer');
            
        $('#DOPBSP-reservations-end-date').datepicker('destroy');                      
        $('#DOPBSP-reservations-end-date').datepicker({beforeShow: function(input, inst){
                                                            $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                                                   .addClass('DOPBSP-admin-datepicker');
                                                       },
                                                       dateFormat: 'yy-mm-dd',
                                                       dayNames: dayNames,
                                                       dayNamesMin: dayShortNames,
                                                       minDate: minDate,
                                                       monthNames: monthNames,
                                                       monthNamesMin: monthShortNames,
                                                       nextText: '',
                                                       prevText: ''});
        
        $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');
        
        /*
         * Period
         */
        $('#DOPBSP-reservations-start-hour').unbind('change');
        $('#DOPBSP-reservations-start-hour').bind('change', function(){
            DOPBSPBackEndReservationsList.get();
        });
        
        $('#DOPBSP-reservations-end-hour').unbind('change');
        $('#DOPBSP-reservations-end-hour').bind('change', function(){
            DOPBSPBackEndReservationsList.get();
        });
        
        /*
         * Status
         */
        $('#DOPBSP-inputs-reservations-filters-status input[type=checkbox]').unbind('click');
        $('#DOPBSP-inputs-reservations-filters-status input[type=checkbox]').bind('click', function(){
            DOPBSPBackEndReservationsList.get();
        });
        
        /*
         * Payment
         */
        $('#DOPBSP-inputs-reservations-filters-payment input[type=checkbox]').unbind('click');
        $('#DOPBSP-inputs-reservations-filters-payment input[type=checkbox]').bind('click', function(){
            DOPBSPBackEndReservationsList.get();
        });
    };

    /*
     * Get reservations list.
     * 
     * @param resetPages (Boolean): reset the number of pages
     */
    this.get = function(resetPages){
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

        resetPages = resetPages === undefined ? true:resetPages;
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
        
        this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_reservations_list_get',
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
            
            if (resetPages){
                $('#DOPBSP-reservations-total').val(data.split(';;;;;;;;;;;')[0]);
                DOPBSPBackEndReservationsList.set();
            }
            
            var HTML = new Array();
            
            HTML.push('<div id="DOPBSP-reservations-print">'+DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_PRINT')+'</div>');
            HTML.push('<select id="DOPBSP-reservations-export" class="dopbsp-left" onchange="DOPBSPBackEndReservations.export(this.value)">');
            HTML.push('     <option value="">'+DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_EXPORT')+'</option>');
            HTML.push('     <option value="ics">iCAL - ics</option>');
            HTML.push('     <option value="xls">Excel</option>');
            HTML.push('     <option value="csv">CSV</option>');
            HTML.push('     <option value="json">JSON</option>');
            HTML.push('</select>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-reservations-export').DOPSelect();
            
            $('#DOPBSP-column2 .dopbsp-column-content').html(data.split(';;;;;;;;;;;')[1]);
            
            $('#DOPBSP-reservations-print').unbind('click');
            $('#DOPBSP-reservations-print').bind('click', function(){
                DOPBSPBackEndReservationsList.print();
            });
            
            DOPBSPBackEndReservation.init();
            DOPBSPBackEnd.toggleMessages('none', '');
        });
    };

    /*
     * Set filters data.
     */
    this.set = function(){
        var i, 
        HTML = new Array(),
        noPages = Math.ceil(parseInt($('#DOPBSP-reservations-total').val())/parseInt($('#DOPBSP-reservations-per-page').val()));

        HTML.push('<select name="DOPBSP-reservations-page" id="DOPBSP-reservations-page" class="dopbsp-left dopbsp-small" onchange="DOPBSPBackEndReservationsList.get(false)">');
        HTML.push(' <option value="1">1</option>');
        
        for (i=2; i<=noPages; i++){
            HTML.push(' <option value="'+i+'">'+i+'</option>');
        }
        HTML.push('</select>');
        
        $('#DOPSelect-DOPBSP-reservations-page').replaceWith(HTML.join(''));
        $('#DOPBSP-reservations-page').DOPSelect();
    };
    

    /*
     * Print reservations data.
     */
    this.print = function(){
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
        
        var newWin = window.open('', '', 'width=800,height=500,top='+($(window).height()/2-325)+',left='+($(window).width()/2-400)+',scrollbars=0,menuBar=0');
        var allLinks = $('head').clone().find('script').remove().end().html();
        var keepColors = '<style>body {-webkit-print-color-adjust: exact !important; }</style>';
        var printContents = $('body').clone().find('script').remove().end().html();

        $.post(ajaxurl, {action: 'dopbsp_reservations_list_print',
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
            newWin.document.write(data);
            DOPBSPBackEnd.toggleMessages('none', '');
        });
    };
    
    return this.__construct();
};