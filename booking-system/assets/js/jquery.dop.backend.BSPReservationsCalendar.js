
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/jquery.dop.backend.BSPReservationsCalendar.js
* File Version            : 1.0.9
* Created / Last Modified : 19 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations calendar jQuery plugin.
*/

(function($){
    'use strict';
  
    $.fn.DOPBSPReservationsCalendar = function(options){
        /*
         * Private variables.
         */
        var Data = {"calendar": {"data": {"bookingStop": 0,
                                          "dateType": 1,
                                          "language": "en",
                                          "languages": [],
                                          "pluginURL": "",
                                          "maxYear": new Date().getFullYear(),
                                          "reinitialize": false,
                                          "view": false},
                                 "text": {"addMonth": "Add month view",
                                          "available": "available",
                                          "availableMultiple": "available",
                                          "booked": "booked",
                                          "nextMonth": "Next month",
                                          "previousMonth": "Previous month",
                                          "removeMonth": "Remove month view",
                                          "unavailable": "unavailable"}}, 
                    "coupons": {"data": {"coupon": {},
                                         "id": 0},
                                "text": {"byDay": "day",
                                         "byHour": "hour",
                                         "code": "Enter code",
                                         "title": "Coupon",
                                         "use": "Use coupon",
                                         "verify": "Verify code",
                                         "verifyError": "The coupon code is invalid. Please enter another one.",
                                         "verifySuccess": "The coupon code is valid."}}, 
                    "currency": {"data": {"code": "USD",
                                          "position": "before",
                                          "sign": "$"},
                                 "text": {}}, 
                    "days": {"data": {"available": [true, true, true, true, true, true, true],
                                      "first": 1,
                                      "morningCheckOut": false,
                                      "multipleSelect": true},
                             "text": {"names": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                                      "shortNames": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]}},
                    "deposit": {"data": {"deposit": 0,
                                         "type": "percent"},
                                "text": {"left": "Left to pay",
                                         "title": "Deposit"}}, 
                    "discounts": {"data": {"discount": [],
                                           "id": 0},
                                  "text": {"byDay": "day",
                                           "byHour": "hour",
                                           "title": "Discount"}},
                    "extras": {"data": {"extra": [],
                                        "id": 0},
                               "text": {"byDay": "day",
                                        "byHour": "hour",
                                        "invalid": "Select an option from",
                                        "title": "Extras"}},
                    "fees": {"data": {"fees": []},
                             "text": {"byDay": "day",
                                      "byHour": "hour",
                                      "included": "Included in price",
                                      "title": "Taxes & fees"}},
                    "form": {"data": {"form": [],
                                      "id": 0},
                             "text": {"checked": "Checked",
                                      "invalidEmail": "is invalid. Please enter a valid email.",
                                      "required": "is required.",
                                      "title": "Contact information",
                                      "unchecked": "Unchecked"}},
                    "hours": {"data": {"addLastHourToTotalPrice": true,
                                       "ampm": false,
                                       "definitions": [{"value": "00:00"}],
                                       "enabled": false,
                                       "info": true,
                                       "interval": true,
                                       "multipleSelect": true},
                              "text": {}},
                    "ID": 0,
                    "months": {"data": {"no": 1},
                               "text": {"names": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                                        "shortNames": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]}},
                    "order": {"data": {"address_billing": {"address_first": {"enabled": true,
                                                                             "required": true},
                                                           "address_second": {"enabled": true,
                                                                              "required": false},
                                                           "city": {"enabled": true,
                                                                    "required": true},
                                                           "company": {"enabled": true,
                                                                       "required": false},
                                                           "country": {"enabled": true,
                                                                       "required": true},
                                                           "email": {"enabled": true,
                                                                     "required": true},
                                                           "enabled": false,
                                                           "first_name": {"enabled": true,
                                                                          "required": true},
                                                           "last_name": {"enabled": true,
                                                                         "required": true},
                                                           "phone": {"enabled": true,
                                                                     "required": true},
                                                           "state": {"enabled": true,
                                                                     "required": true},
                                                           "zip_code": {"enabled": true,
                                                                        "required": true}},
                                       "address_shipping": {"address_first": {"enabled": true,
                                                                              "required": true},
                                                            "address_second": {"enabled": true,
                                                                               "required": false},
                                                            "city": {"enabled": true,
                                                                     "required": true},
                                                            "company": {"enabled": true,
                                                                        "required": false},
                                                            "country": {"enabled": true,
                                                                        "required": true},
                                                            "email": {"enabled": true,
                                                                     "required": true},
                                                            "enabled": false,
                                                            "first_name": {"enabled": true,
                                                                           "required": true},
                                                            "last_name": {"enabled": true,
                                                                          "required": true},
                                                            "phone": {"enabled": true,
                                                                      "required": true},
                                                            "state": {"enabled": true,
                                                                      "required": true},
                                                            "zip_code": {"enabled": true,
                                                                         "required": true}},
                                       "countries": [],
                                       "paymentArrival": true,
                                       "paymentArrivalWithApproval": false,
                                       "paymentGateways": [],
                                       "redirect": "",
                                       "terms": false,
                                       "termsLink": ""},
                              "text": {"addressAddressFirst": "Address line 1",
                                       "addressAddressSecond": "Address line 2",
                                       "addressBilling": "Billing address",
                                       "addressBillingDisabled": "Billing address is not enabled.",
                                       "addressCity": "City",
                                       "addressCompany": "Company",
                                       "addressCountry": "Country",
                                       "addressEmail": "Email",
                                       "addressFirstName": "First name",
                                       "addressLastName": "Last name",
                                       "addressPhone": "Phone number",
                                       "addressSelectPaymentMethod": "Select payment method.",
                                       "addressShipping": "Shipping address",
                                       "addressShippingDisabled": "Shipping address is not enabled.",
                                       "addressShippingCopy": "Use billing address",
                                       "addressState": "State/Province",
                                       "addressZipCode": "Zip code",
                                       "book": "Book now",
                                       "paymentArrival": "Pay on arrival (instant booking)",
                                       "paymentArrivalWithApproval": "Pay on arrival (need to be approved)",
                                       "paymentArrivalSuccess": "Your request has been successfully received. We are waiting you!",
                                       "paymentArrivalWithApprovalSuccess": "Your request has been successfully sent. Please wait for approval.",
                                       "paymentMethod": "Payment method",
                                       "paymentMethodNone": "None",
                                       "paymentMethodArrival": "On arrival",
                                       "paymentMethodTransactionID": "Transaction ID",
                                       "paymentMethodWooCommerce": "WooCommerce",
                                       "paymentMethodWooCommerceOrderID": "Order ID",
                                       "success": "Reservation has been added!",
                                       "terms": "I accept to agree to the Terms & Conditions.",
                                       "termsInvalid": "You must agree with our Terms & Conditions to continue.",
                                       "title": "Order",
                                       "unavailable": "The period you selected is not available anymore. The calendar will refresh to update the schedule.",
                                       "unavailableCoupon": "The coupon you entered is not available anymore."}},
                    "reservation": {"data": {},
                                    "text": {"addressShippingCopy": "Same as billing address.",
                                             "buttonApprove": "Approve",
                                             "buttonCancel": "Cancel",
                                             "buttonClose": "Close",
                                             "buttonDelete": "Delete",
                                             "buttonReject": "Reject",
                                             "dateCreated": "Date created",
                                             "id": "ID",
                                             "instructions": "Click to edit the reservation.",
                                             "language": "Selected language",
                                             "noAddressBilling": "No billing address.",
                                             "noAddressShipping": "No shipping address.",
                                             "noExtras": "No extras.",
                                             "noDiscount": "No discount.",
                                             "noCoupon": "No coupon.",
                                             "noFees": "No taxes or fees.",
                                             "noForm": "Form was not completed.",
                                             "noFormField": "Form field was not completed.",
                                             "price": "Price",
                                             "priceChange": "Price change",
                                             "priceTotal": "Total",
                                             "selectDays": "Please select the days from calendar.",
                                             "selectHours": "Please select the days and hours from calendar.",
                                             "title": "Reservation",
                                             "titleDetails": "Details"}},
                    "rules": {"data": {"rule": {},
                                       "id": 0},
                              "text": {"maxTimeLapseDaysWarning": "You can book only a maximum number of %d days.",
                                       "maxTimeLapseHoursWarning": "You can book only a maximum number of %d hours.",
                                       "minTimeLapseDaysWarning": "You need to book a minimum number of %d days.",
                                       "minTimeLapseHoursWarning": "You need to book a minimum number of %d hours."}},
                    "search": {"data": {},
                               "text": {"checkIn": "Check in",
                                        "checkOut": "Check out",
                                        "hourEnd": "Finish at",
                                        "hourStart": "Start at",
                                        "noItems": "No. book items",
                                        "noServices": "There are no services available for the period you selected.",
                                        "noServicesSplitGroup": "You cannot add divided groups to a reservation.",
                                        "title": "Seach"},           
                    "sidebar": {"data": {"noItems": true,
                                         "positions": {"search": {"column": 1,
                                                                  "row": 1},
                                                       "extras": {"column": 1,
                                                                  "row": 2},   
                                                       "coupons": {"column": 1,
                                                                  "row": 3},       
                                                       "reservation": {"column": 1,
                                                                       "row": 4},
                                                       "cart": {"column": 1,
                                                                "row": 5},
                                                       "form": {"column": 1,
                                                                "row": 6},
                                                       "order": {"column": 1,
                                                                 "row": 7}},
                                         "style": 5},
                                "text": {}}}},
        Container = this,
        ID = 0,

// ***************************************************************************** Main methods.

// 1. Main methods.
        
        methods = {
            init:function(){
            /*
             * Initialize jQuery plugin.
             */
                return this.each(function(){
                    if (options){
                        $.extend(Data, options);
                    }
                    
                    if (!$(Container).hasClass('dopbsp-initialized')
                            || Data['calendar']['data']['reinitialize']){
                        $(Container).addClass('dopbsp-initialized');
                        methods.parse();
                        $(window).bind('resize.DOPBSPReservationsCalendar', methods.rp);
                    }
                });
            },
            parse:function(){
            /*
             * Parse calendar options.
             */    
                methods_calendar.data = Data['calendar']['data'];
                methods_calendar.text = Data['calendar']['text'];
                
                methods_coupons.data = Data['coupons']['data'];
                methods_coupons.text = Data['coupons']['text'];
                
                methods_currency.data = Data['currency']['data'];
                methods_currency.text = Data['currency']['text'];
                
                methods_days.data = Data['days']['data'];
                methods_days.text = Data['days']['text'];
                
                methods_deposit.data = Data['deposit']['data'];
                methods_deposit.text = Data['deposit']['text'];
                
                methods_discounts.data = Data['discounts']['data'];
                methods_discounts.text = Data['discounts']['text'];
                
                methods_extras.data = Data['extras']['data'];
                methods_extras.text = Data['extras']['text'];
                
                methods_fees.data = Data['fees']['data'];
                methods_fees.text = Data['fees']['text'];
                
                methods_form.data = Data['form']['data'];
                methods_form.text = Data['form']['text'];
                
                methods_hours.data = Data['hours']['data'];
                methods_hours.text = Data['hours']['text'];
                
                ID = Data['ID'];
                
                methods_months.data = Data['months']["data"];
                methods_months.text = Data['months']["text"];
                
                methods_order.data = Data['order']["data"];
                methods_order.text = Data['order']["text"];
                
                methods_reservation.data = Data['reservation']["data"];
                methods_reservation.text = Data['reservation']["text"];
                
                methods_rules.data = Data['rules']["data"];
                methods_rules.text = Data['rules']["text"];
                
                methods_search.data = Data['search']["data"];
                methods_search.text = Data['search']["text"];
                
                methods_sidebar.data = Data['sidebar']["data"];
                methods_sidebar.text = Data['sidebar']["text"];
                
                methods_months.init();
                methods_reservations.parse();
            },
            rp:function(){
            /*
             * Initialize calendar resize & position. Used for responsive feature.
             */
                /*
                 * Resize & position the sidebar first.
                 */
                methods_calendar.container.rp();
                methods_calendar.navigation.rp();
            }
        },              
                
// 2. Components

        methods_components = {
            init:function(){
            /*
             * Initialize calendar components.
             */ 
                /*
                 * Initialize today date.
                 */
                methods_calendar.vars.todayDate = new Date();
                methods_calendar.vars.todayDay = methods_calendar.vars.todayDate.getDate();
                methods_calendar.vars.todayMonth = methods_calendar.vars.todayDate.getMonth()+1;
                methods_calendar.vars.todayYear = methods_calendar.vars.todayDate.getFullYear(); 
                
                /*
                 * Initialize start date.
                 */
                methods_calendar.vars.startDate = methods_calendar.vars.todayDate;
                methods_calendar.vars.currMonth = methods_calendar.vars.todayMonth;
                methods_calendar.vars.currYear = methods_calendar.vars.todayYear;
                methods_calendar.vars.startDay = methods_calendar.vars.todayDay;
                methods_calendar.vars.startMonth = methods_calendar.vars.todayMonth;
                methods_calendar.vars.startYear = methods_calendar.vars.todayYear; 
                
                /*
                 * Tooltip
                 */
                methods_tooltip.display();
                
                /*
                 * Calendar
                 */
                methods_calendar.container.init();
                methods_calendar.navigation.init();
                
                /*
                 * Filters
                 */
                methods_filters.init();
                
                methods.rp();
            }
        },  
                
// 3. Currency
        
        methods_currency = {
            data: {},
            text: {}
        },
         
// 4. Price         
                
        methods_price = {
            set:function(price,
                         currency){
            /*
             * Display price with currency in set format.
             * 
             * @param price (Number): price value
             * @param currency (String): currency sign
             * 
             * @return price with currency
             */ 
                var priceDisplayed = '';
                
                price = DOPPrototypes.getWithDecimals(Math.abs(price), 
                                                      2);
                                                   
                switch (methods_currency.data['position']){
                    case 'after':
                        priceDisplayed =  price+currency;
                        break;
                    case 'after_with_space':
                        priceDisplayed =  price+' '+currency;
                        break;
                    case 'before_with_space':
                        priceDisplayed =  currency+' '+price;
                        break;
                    default:
                        priceDisplayed = currency+price;
                }
                
                return priceDisplayed;
            }
        }, 

// 5. Tooltip

        methods_tooltip = {
            display:function(){
            /*
             * Display information tooltip.
             */
                if ($('#DOPBSPReservationsCalendar-tooltip'+ID).length !== undefined){
                    $('#DOPBSPReservationsCalendar-tooltip'+ID).remove();
                }
                $('body').append('<div class="DOPBSPReservationsCalendar-tooltip" id="DOPBSPReservationsCalendar-tooltip'+ID+'"></div>');
                methods_tooltip.init();
            },
            init:function(){
            /*
             * Initialize information tooltip.
             */
                var $tooltip = $('#DOPBSPReservationsCalendar-tooltip'+ID),
                h,
                xPos = 0, 
                yPos = 0,
                w;
                            
                if (!DOPPrototypes.isTouchDevice()){
                    /*
                     * Position the tooltip depending on mouse position.
                     */
                    $(document).mousemove(function(e){
                        xPos = e.pageX+15;
                        yPos = e.pageY-10;

                        /*
                         * Tooltip height.
                         */
                        h = $tooltip.height()
                            +parseFloat($tooltip.css('padding-top'))
                            +parseFloat($tooltip.css('padding-bottom'))
                            +parseFloat($tooltip.css('border-top-width'))
                            +parseFloat($tooltip.css('border-bottom-width'));
                        w = $tooltip.width()
                            +parseFloat($tooltip.css('padding-right'))
                            +parseFloat($tooltip.css('padding-left'))
                            +parseFloat($tooltip.css('border-right-width'))
                            +parseFloat($tooltip.css('border-left-width'));

                        if ($(document).scrollLeft()+$(window).width() < xPos+w+10){
                            xPos = e.pageX-w-15;
                        }
                        
                        if ($(document).scrollTop()+$(window).height() < yPos+h+10){
                            yPos = $(document).scrollTop()+$(window).height()-h-10;
                        }

                        if (!$tooltip.hasClass('dopbsp-selected')){
                            $tooltip.css({'left': xPos, 
                                          'top': yPos});
                        }
                    });
                }
            },
            set:function(data){
            /*
             * Set tooltip.
             * 
             * @param data (String): data to be displayed
             */  
                $('#DOPBSPReservationsCalendar-tooltip'+ID).html(data)
                                                           .css('display', 'block');                         
            },
            clear:function(){
            /*
             * Clear information display.
             */
                if (!$('#DOPBSPReservationsCalendar-tooltip'+ID).hasClass('dopbsp-selected')){
                    $('#DOPBSPReservationsCalendar-tooltip'+ID).css('display', 'none');
                }   
            }
        },
                
// ***************************************************************************** Calendar

// 6. Calendar
        
        methods_calendar = {
            data: {},
            text: {},
            vars: {currMonth: new Date(),
                   currYear: new Date(),
                   startDate: new Date(),
                   startDay: new Date(),
                   startMonth: new Date(),
                   startYear: new Date(),
                   todayDate: new Date(),
                   todayDay: new Date(),
                   todayMonth: new Date(),
                   todayYear: new Date()},
            
            display:function(){
            /*
             * Display calendar.
             */
                var HTML = new Array();

                /*
                 *  Calendar HTML.
                 */
                HTML.push('<div class="DOPBSPReservationsCalendar-container">');                        
                HTML.push('    <div class="DOPBSPReservationsCalendar-navigation">');
                HTML.push('        <div class="dopbsp-month-year"></div>');
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-add-btn"><span class="dopbsp-info">'+methods_calendar.text['addMonth']+'</span></a>');                        
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-remove-btn"><span class="dopbsp-info">'+methods_calendar.text['removeMonth']+'</span></a>');
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-next-btn"><span class="dopbsp-info">'+methods_calendar.text['nextMonth']+'</span></a>');
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-previous-btn"><span class="dopbsp-info">'+methods_calendar.text['previousMonth']+'</span></a>');
                HTML.push('        <div class="dopbsp-week">');
                HTML.push('            <div class="dopbsp-day"></div>');
                HTML.push('            <div class="dopbsp-day"></div>');
                HTML.push('            <div class="dopbsp-day"></div>');
                HTML.push('            <div class="dopbsp-day"></div>');
                HTML.push('            <div class="dopbsp-day"></div>');
                HTML.push('            <div class="dopbsp-day"></div>');
                HTML.push('            <div class="dopbsp-day"></div>');
                HTML.push('        </div>');
                HTML.push('    </div>');
                HTML.push('    <div class="DOPBSPReservationsCalendar-calendar"></div>');
                HTML.push('</div>');
                
                Container.html(HTML.join(''));
            },
            init:function(year,
                          month){
            /*
             * Initialize calendar.
             * 
             * @param year (Number): year to be displayed
             * @param month (Number): month to be displayed
             */
                var i;

                methods_calendar.vars.currYear = new Date(year, month, 0).getFullYear();
                methods_calendar.vars.currMonth = month;     

                /*
                 * Initialize add/remove buttons.
                 */
                if (methods_months.vars.no > 1){
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'block');
                } 
                else{
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'none');
                }
                
                if (methods_months.vars.no === methods_months.vars.maxAllowed){
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-add-btn', Container).css('display', 'none');
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).addClass('dopbsp-no-add');
                } 
                else{
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-add-btn', Container).css('display', 'block');
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).removeClass('dopbsp-no-add');
                }

                /*
                 * Initialize previous button.
                 */
                if (year !== methods_calendar.vars.startYear 
                        || month !== methods_calendar.vars.startMonth){
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'block');
                }   

                if (year === methods_calendar.vars.startYear 
                        && month === methods_calendar.vars.startMonth){
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'none');
                }

                if (Container.width() <= 400){
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
                }
                else{
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
                }                        
                $('.DOPBSPReservationsCalendar-calendar', Container).html('');

                for (i=1; i<=methods_months.vars.no; i++){
                    methods_month.display(methods_calendar.vars.currYear, 
                                          month = month%12 !== 0 ? month%12:12, 
                                          i);
                    month++;

                    if (month % 12 === 1){
                        methods_calendar.vars.currYear++;
                        month = 1;
                    }                            
                }
            },
            
            container: {
                init:function(){
                /*
                 * Initialize calendar container. 
                 */
                    methods_calendar.container.rp();
                },
                rp:function(){
                /*
                 *  Resize & position calendar container. Used for responsive feature.
                 */  
                    var hiddenBustedItems = DOPPrototypes.doHiddenBuster($(Container));

                    $('.DOPBSPReservationsCalendar-container', Container).width(Container.width());
                    DOPPrototypes.undoHiddenBuster(hiddenBustedItems);
                }
            },
            navigation: {
                init:function(){
                /*
                 * Initialize calendar navigation.
                 */
                    methods_calendar.navigation.events();
                    methods_calendar.navigation.rp();
                },
                rp:function(){
                /*
                 *  Resize & position calendar navigation. Used for responsive feature.
                 */  
                    var no = 0,
                    hiddenBustedItems = DOPPrototypes.doHiddenBuster($(Container));

                    if ($('.DOPBSPReservationsCalendar-navigation', Container).width() <= 400){
                        $('.DOPBSPReservationsCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear()))
                                                                                                 .addClass('dopbsp-style-small'); 
                    }
                    else{
                        $('.DOPBSPReservationsCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear()))
                                                                                                 .removeClass('dopbsp-style-small'); 
                    }

                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-week .dopbsp-day', Container).width(parseInt(($('.DOPBSPReservationsCalendar-navigation .dopbsp-week', Container).width()-parseInt($('.DOPBSPReservationsCalendar-navigation .dopbsp-week', Container).css('padding-left'))+parseInt($('.DOPBSPReservationsCalendar-navigation .dopbsp-week', Container).css('padding-right')))/7));
                    no = methods_days.data['first']-1;

                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-week .dopbsp-day', Container).each(function(){
                        no++;

                        if (no === 7){
                            no = 0;
                        }

                        if ($(this).width() <= 70){
                            $(this).html(methods_days.text['shortNames'][no]);
                        }
                        else{
                            $(this).html(methods_days.text['names'][no]);
                        }
                    });

                    DOPPrototypes.undoHiddenBuster(hiddenBustedItems);
                },
                events:function(){
                /*
                 * Initialize calendar navigation events.
                 */
                    /*
                     * Previous button event.
                     */
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-previous-btn', Container).unbind('click');
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-previous-btn', Container).bind('click', function(){
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth-1);

                        if (methods_calendar.vars.currMonth === methods_calendar.vars.startMonth){
                            $('.DOPBSPReservationsCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'none');
                        }
                    });

                    /*
                     * Next button event.
                     */
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-next-btn', Container).unbind('click');
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-next-btn', Container).bind('click', function(){
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth+1);
                        $('.DOPBSPReservationsCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'block');
                    });

                    /*
                     * Add button event.
                     */
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-add-btn', Container).unbind('click');
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-add-btn', Container).bind('click', function(){
                        methods_months.vars.no++;
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth);
                                              
                        if (methods_months.vars.no >= methods_months.vars.maxAllowed){
                            $('.DOPBSPReservationsCalendar-navigation .dopbsp-add-btn', Container).css('display', 'none');
                            $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).addClass('dopbsp-no-add');
                        }
                        $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'block');
                        
                        DOPPrototypes.scrollToY($('.DOPBSPReservationsCalendar-calendar', Container).offset().top+$('.DOPBSPReservationsCalendar-calendar', Container).height()-$(window).height()-300);
                    });

                    /*
                     * Remove button event.
                     */
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).unbind('click');
                    $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).bind('click', function(){
                        methods_months.vars.no--;
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth);

                        if (methods_months.vars.no < methods_months.vars.maxAllowed){
                            $('.DOPBSPReservationsCalendar-navigation .dopbsp-add-btn', Container).css('display', 'block');
                            $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).removeClass('dopbsp-no-add');
                        }
                        
                        if(methods_months.vars.no === 1){
                            $('.DOPBSPReservationsCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'none');
                        }
                        
                        DOPPrototypes.scrollToY($('.DOPBSPReservationsCalendar-calendar', Container).offset().top+$('.DOPBSPReservationsCalendar-calendar', Container).height()-$(window).height()-300);
                    });
                }
            }
        },
                  
// 7. Months
        
        methods_months = {
            data: {},
            text: {},
            vars: {maxAllowed: 6,
                   no: 1},
            
            init:function(){
            /*
             * Initialize months data.
             */
                methods_months.vars.no = methods_months.data['no'];
            }
        },
                
        methods_month = {
            display:function(year,
                             month,
                             position){
            /*
             * Display month.
             * 
             * @param year (Number): the year that has the month to be initialized
             * @param month (Number): month to be initialized
             * @param position (Number): month's position in display order
             * 
             * @return months HTML
             */ 
                var cmonth, 
                cday, 
                cyear,
                d, 
                HTML = new Array(), 
                i, 
                prevDay,
                noDays = new Date(year, month, 0).getDate(),
                noDaysPrevMonth = new Date(year, month-1, 0).getDate(),
                firstDay = new Date(year, month-1, 2-methods_days.data['first']).getDay(),
                lastDay = new Date(year, month-1, noDays-methods_days.data['first']+1).getDay(),
                totalDays = 0;

                methods_days.vars.no = 0;
                
                if (position > 1){
                    HTML.push('<div class="DOPBSPReservationsCalendar-month-year">'+methods_months.text['names'][(month%12 !== 0 ? month%12:12)-1]+' '+year+'</div>');
                }
                HTML.push('<table class="DOPBSPReservationsCalendar-month" id="DOPBSPReservationsCalendar-month-'+ID+'-'+position+'">');
                HTML.push('    <tbody>');

                /*
                 * Display previous month days.
                 */
                for (i=(firstDay === 0 ? 7:firstDay)-1; i>=1; i--){
                    totalDays++;

                    d = new Date(year, month-2, noDaysPrevMonth-i+1);
                    cyear = d.getFullYear();
                    cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                    cday = DOPPrototypes.getLeadingZero(d.getDate());
                    prevDay = DOPPrototypes.getPrevDay(cyear+'-'+cmonth+'-'+cday);

                    if (methods_calendar.vars.startMonth === month 
                            && methods_calendar.vars.startYear === year){
                        HTML.push(methods_day.display('dopbsp-past-day', 
                                                      ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate()));            
                    }
                    else{
                        HTML.push(methods_day.display('dopbsp-last-month'+(position > 1 ?  ' dopbsp-mask':''), 
                                                      position > 1 ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_last':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate()));
                    }
                }

                /*
                 * Display current month days.
                 */
                for (i=1; i<=noDays; i++){
                    totalDays++;

                    d = new Date(year, month-1, i);
                    cyear = d.getFullYear();
                    cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                    cday = DOPPrototypes.getLeadingZero(d.getDate());

                    if (methods_calendar.vars.startMonth === month 
                            && methods_calendar.vars.startYear === year
                            && methods_calendar.vars.startDay > d.getDate()){
                        HTML.push(methods_day.display('dopbsp-past-day', 
                                                      ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate()));    
                    }
                    else{
                        HTML.push(methods_day.display('dopbsp-curr-month', 
                                                      ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate()));
                    }
                }

                /*
                 * Display next month days.
                 */
                for (i=1; i<=(totalDays+7 < 42 ? 14:7)-lastDay; i++){
                    d = new Date(year, month, i);
                    cyear = d.getFullYear();
                    cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                    cday = DOPPrototypes.getLeadingZero(d.getDate());

                    HTML.push(methods_day.display('dopbsp-next-month'+(position < methods_months.vars.no ?  ' dopbsp-hide':''), 
                                                  position < methods_months.vars.no ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                  d.getDate()));
                }
                HTML.push('    </tbody>');
                HTML.push('</table>');
                        
                $('.DOPBSPReservationsCalendar-calendar', Container).append(HTML.join(''));
                
                methods_reservations.events();
            }
        },
 
// 8. Days
        
        methods_days = {
            data: {},
            text: {},
            vars: {no: 0}
        },
                
        methods_day = {
            display:function(type,
                             id,
                             day){
            /*
             * Display day.
             * 
             * @param type (String): day type (past-day, last-month, curr-month, next-month)
             * @param id (String): day ID (ID_YYYY-MM-DD)
             * @param day (String): current day
             * 
             * @retun day HTML
             */
                var blocks = new Array(),
                blocksHTML = new Array(),
                date = id.split('_')[1],
                dayHTML = Array(),
                i, 
                j, 
                k, 
                levels = new Array(),
                info = new Array(),
                reservations = methods_reservations.vars.reservations,
                value = '';

                methods_days.vars.no++;

                for (i=0; i<(reservations.length > 5 ? reservations.length:5); i++){
                    levels[i] = false;
                    
                    blocksHTML = new Array();        
                    blocksHTML.push('<div class="dopbsp-block">');
                    blocksHTML.push('   <div class="dopbsp-bind-left"></div>');
                    blocksHTML.push('   <div class="dopbsp-bind-content"></div>');
                    blocksHTML.push('   <div class="dopbsp-bind-right"></div>');
                    blocksHTML.push('</div>');
                    
                    blocks[i] = blocksHTML.join('');
                }

                if (methods_days.vars.no % 7 === 1){
                    dayHTML.push('<tr>');
                }                       
                dayHTML.push('<td class="DOPBSPReservationsCalendar-day '+type+'" id="DOPBSPReservationsCalendar-reservations'+id+'">');
                dayHTML.push('  <div class="dopbsp-head">'+day+'</div>');
                dayHTML.push('  <div class="dopbsp-body">');

                for (i=0; i<reservations.length; i++){
                    info = new Array();
                    
                    info.push(reservations[i]['start_hour'] === '' ? '':(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(reservations[i]['start_hour']):reservations[i]['start_hour']));
                    info.push(reservations[i]['end_hour'] === '' ? '':'-'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(reservations[i]['end_hour']):reservations[i]['end_hour']));

                    for (k=0; k<reservations[i]['form'].length; k++){
                        value = reservations[i]['form'][k]['value'];
                        
                        info.push((info.length > 0 ? ' ':'')+(value === 'false' ? '':
                                                                                  (value === 'true' ? value = reservations[i]['form'][k]['translation']:
                                                                                                      value)));
                    }

                    if ((reservations[i]['check_in'] <= date 
                                    && date <= reservations[i]['check_out']) 
                            || (reservations[i]['check_in'] === date 
                                    && reservations[i]['check_out'] === '')){
                        if (reservations[i]['level'] === 0){
                            for (j=0; j<reservations.length; j++){
                                if (!levels[j]){
                                    levels[j] = true;
                                    reservations[i]['level'] = j;
                                    
                                    blocksHTML = new Array();        
                                    blocksHTML.push('<div class="dopbsp-block dopbsp-reservation" id="DOPBSPReservationsCalendar-reservation'+reservations[i]['id']+'-'+id+'-'+i+'">');
                                    blocksHTML.push('   <div class="dopbsp-bind-left '+(reservations[i]['check_in'] < date ? 'dopbsp-reservation'+reservations[i]['id']+' dopbsp-'+reservations[i]['status']:'')+'"></div>');
                                    blocksHTML.push('   <div class="dopbsp-bind-content dopbsp-reservation'+reservations[i]['id']+' dopbsp-'+reservations[i]['status']+'">'+(reservations[i]['check_in'] === date ? info.join(''):'')+'</div>');
                                    blocksHTML.push('   <div class="dopbsp-bind-right '+(date < reservations[i]['check_out'] ? 'dopbsp-reservation'+reservations[i]['id']+' dopbsp-'+reservations[i]['status']:'')+'"></div>');
                                    blocksHTML.push('</div>');

                                    blocks[j] = blocksHTML.join('');
                                    break;
                                }
                            }
                        }
                        else{
                            levels[reservations[i]['level']] = true;
                                    
                            blocksHTML = new Array();      
                            blocksHTML.push('<div class="dopbsp-block dopbsp-reservation" id="DOPBSPReservationsCalendar-reservation'+reservations[i]['id']+'-'+id+'-'+i+'">');
                            blocksHTML.push('   <div class="dopbsp-bind-left '+(reservations[i]['check_in'] < date ? 'dopbsp-reservation'+reservations[i]['id']+' dopbsp-'+reservations[i]['status']:'')+'"></div>');
                            blocksHTML.push('   <div class="dopbsp-bind-content dopbsp-reservation'+reservations[i]['id']+' dopbsp-'+reservations[i]['status']+'">'+(reservations[i]['check_in'] === date ? info.join(''):'')+'</div>');
                            blocksHTML.push('   <div class="dopbsp-bind-right '+(date < reservations[i]['check_out'] ? 'dopbsp-reservation'+reservations[i]['id']+' dopbsp-'+reservations[i]['status']:'')+'"></div>');
                            blocksHTML.push('</div>');
                            
                            blocks[reservations[i]['level']] = blocksHTML.join('');
                        }
                    }
                }

                for (i=blocks.length; i>=5; i--){
                    if (!levels[i]){
                        blocks.splice(i, 1);
                    }
                    else{
                        break;
                    }
                }

                dayHTML.push(blocks.join(''));
                dayHTML.push('  </div>');
                dayHTML.push('</td>');

                if (methods_days.vars.no % 7 === 0){
                    dayHTML.push('</tr>');
                }

                return dayHTML.join('');
            }
        },

// 9. Hours
         
        methods_hours = {
            data: {},
            text: {}
        },
         
// ***************************************************************************** Reservations       
        
// 10. Reservations

        methods_reservations = {
            vars: {reservations: new Array(),
                   reservationsData: new Array()},
            
            parse:function(){
            /*
             * Parse reservations.
             */
                $.post(ajaxurl, {action: 'dopbsp_reservations_calendar_get',
                                 calendar_id: ID}, function(data){
                    if ($.trim(data) !== ''){
                        methods_reservations.vars.reservationsData = JSON.parse($.trim(data));
                    }
                    
                    methods_calendar.display();
                    methods_components.init();
                    methods_reservations.init();
                    methods_reservations.display();

                    DOPBSPBackEnd.toggleMessages('none', '');
                });
            },
            
            init:function(){
            /*
             * Initialize reservations.
             */
                var i;
                
                for (i=0; i<methods_reservations.vars.reservationsData.length; i++){
                    methods_reservations.vars.reservationsData[i]['address_billing'] = methods_reservations.vars.reservationsData[i]['address_billing'] === '' ? '':JSON.parse(methods_reservations.vars.reservationsData[i]['address_billing']);
                    methods_reservations.vars.reservationsData[i]['address_shipping'] = methods_reservations.vars.reservationsData[i]['address_shipping'] === '' || methods_reservations.vars.reservationsData[i]['address_shipping'] === 'billing_address' ? methods_reservations.vars.reservationsData[i]['address_shipping']:JSON.parse(methods_reservations.vars.reservationsData[i]['address_shipping']);
                    methods_reservations.vars.reservationsData[i]['coupon'] = methods_reservations.vars.reservationsData[i]['coupon'] === '' ? '':JSON.parse(methods_reservations.vars.reservationsData[i]['coupon']);
                    methods_reservations.vars.reservationsData[i]['deposit'] = methods_reservations.vars.reservationsData[i]['deposit'] === '' ? '':JSON.parse(methods_reservations.vars.reservationsData[i]['deposit']);
                    methods_reservations.vars.reservationsData[i]['discount'] = methods_reservations.vars.reservationsData[i]['discount'] === '' ? '':JSON.parse(methods_reservations.vars.reservationsData[i]['discount']);
                    methods_reservations.vars.reservationsData[i]['extras'] = methods_reservations.vars.reservationsData[i]['extras'] === '' ? '':JSON.parse(methods_reservations.vars.reservationsData[i]['extras']);
                    methods_reservations.vars.reservationsData[i]['fees'] = methods_reservations.vars.reservationsData[i]['fees'] === '' ? '':JSON.parse(methods_reservations.vars.reservationsData[i]['fees']);
                    methods_reservations.vars.reservationsData[i]['form'] = methods_reservations.vars.reservationsData[i]['form'] === '' ? '':JSON.parse(methods_reservations.vars.reservationsData[i]['form']);
                }
            },
            display:function(){
            /*
             * Display reservations depending on the selected filters.
             */    
                var i, 
                select = false,
                displayStartHour = $('#DOPBSP-reservations-start-hour').val(),
                displayEndHour = $('#DOPBSP-reservations-end-hour').val(),
                displayPending = $('#DOPBSP-reservations-pending').is(':checked') ? true:false,
                displayApproved = $('#DOPBSP-reservations-approved').is(':checked') ? true:false,
                displayRejected = $('#DOPBSP-reservations-rejected').is(':checked') ? true:false,
                displayCanceled = $('#DOPBSP-reservations-canceled').is(':checked') ? true:false,
                displayPayment = new Array(),
                reservations = new Array(),
                reservationsData = methods_reservations.vars.reservationsData;
        
                /*
                 * Save status filters.
                 */
                DOPBSPBackEndReservations.saveFilters({status_pending: displayPending,
                                                status_approved: displayApproved,
                                                status_rejected: displayRejected,
                                                status_canceled: displayCanceled});

                /*
                 * Check selected status to be displayed.
                 */
                if (!displayPending 
                        && !displayApproved 
                        && !displayRejected 
                        && !displayCanceled){
                    displayPending = true;
                    displayApproved = true;
                    displayRejected = true;
                    displayCanceled = true;
                }

                /*
                 * Check selected payment systems to be displayed.
                 */
                $('#DOPBSP-inputs-reservations-filters-payment input[type=checkbox]').each(function(){
                    if ($(this).is(':checked')){
                        displayPayment.push($(this).attr('id').split('DOPBSP-reservations-payment-')[1]);
                    }
                });
                
                /*
                 * Save payments filters.
                 */
                DOPBSPBackEndReservations.saveFilters({payment_methods: displayPayment.join(',')});

                for (i=0; i<reservationsData.length; i++){
                    select = true;
                    
                    /*
                     * Verify hours.
                     */
                    if (methods_hours.data['enabled']
                            && (reservationsData[i]['end_hour'] < displayStartHour 
                                            && reservationsData[i]['end_hour'] !== ''
                                    || displayEndHour < reservationsData[i]['start_hour']
                                            && reservationsData[i]['start_hour'] !== '')){
                        select = false;
                    }

                    /*
                     * Verify status.
                     */
                    switch (reservationsData[i]['status']){
                        case 'pending':
                            if (!displayPending){
                                select = false;
                            }
                            break;
                        case 'approved':
                            if (!displayApproved){
                                select = false;
                            }
                            break;
                        case 'rejected':
                            if (!displayRejected){
                                select = false;
                            }
                            break;
                        case 'canceled':
                            if (!displayCanceled){
                                select = false;
                            }
                            break;
                    }
                    
                    /*
                     * Verify payment.
                     */
                    if (displayPayment.length > 0){
                        if ($.inArray(reservationsData[i]['payment_method'], displayPayment) === -1){
                            select = false;
                        }
                    }

                    if (select){
                        reservations.push(reservationsData[i]);
                    }
                }

                for (i=0; i<reservations.length; i++){
                    reservations[i]['level'] = 0;
                }

                methods_reservations.vars.reservations = reservations;

                methods_calendar.init(methods_calendar.vars.startYear, 
                                      methods_calendar.vars.startMonth);
            },
            
            events:function(){
            /*
             * Set reservations events.
             */
                if (!DOPPrototypes.isTouchDevice()){
                    $('.dopbsp-reservation', Container).hover(function(){
                        var pieces = $(this).attr('id').split('DOPBSPReservationsCalendar-reservation'),
                        id  = pieces[1].split('-')[0];

                        if (!$('#DOPBSPReservationsCalendar-tooltip'+ID).hasClass('dopbsp-selected')){
                            methods_reservation.set(id);
                        }
                    },
                    function(){
                        methods_tooltip.clear();
                    });

                    $('.dopbsp-reservation', Container).unbind('click');
                    $('.dopbsp-reservation', Container).bind('click', function(){
                        $('#DOPBSPReservationsCalendar-tooltip'+ID).addClass('dopbsp-selected');
                    });
                }
                else{
                    var $tooltip,
                    h,
                    id,
                    pieces,
                    xPos = 0, 
                    yPos = 0, 
                    touch,
                    w;
            
                    /*
                     * Info icon events on devices with touchscreen.
                     */
                    $('.dopbsp-reservation', Container).unbind('touchstart');
                    $('.dopbsp-reservation', Container).bind('touchstart', function(e){
                        $tooltip = $('#DOPBSPReservationsCalendar-tooltip'+ID);
                        
                        pieces = $(this).attr('id').split('DOPBSPReservationsCalendar-reservation');
                        id  = pieces[1].split('-')[0];
                        
                        e.preventDefault();
                        touch = e.originalEvent.touches[0];
                        xPos = touch.clientX+$(document).scrollLeft();
                        yPos = touch.clientY+$(document).scrollTop();
                        
                        methods_reservation.set(id);
                        
                        /*
                         * Tooltip height/width.
                         */
                        h = $tooltip.height()
                            +parseFloat($tooltip.css('padding-top'))
                            +parseFloat($tooltip.css('padding-bottom'))
                            +parseFloat($tooltip.css('border-top-width'))
                            +parseFloat($tooltip.css('border-bottom-width'));
                        w = $tooltip.width()
                            +parseFloat($tooltip.css('padding-right'))
                            +parseFloat($tooltip.css('padding-left'))
                            +parseFloat($tooltip.css('border-right-width'))
                            +parseFloat($tooltip.css('border-left-width'));

                        /*
                         * Position tooltip on devices with touchscreen.
                         */
                        if ($(document).scrollLeft()+$(window).width() < xPos+w+10){
                            xPos = xPos-w-15;
                        }
                        
                        if ($(document).scrollTop()+$(window).height() < yPos+h+10){
                            yPos = $(document).scrollTop()+$(window).height()-h-10;
                        }
                        
                        
                        $tooltip.css({'left': xPos,
                                      'top': yPos});
                        $tooltip.addClass('dopbsp-selected');
                    });
                }
            }
        },
        
        methods_reservation = {
            data: {},
            text: {},
            
            display:function(column1,
                             column2,
                             column3,
                             buttons){
            /*
             * Display reservation in tooltip.
             * 
             * @param column1 (Array): column 1 HTML
             * @param column2 (Array): column 2 HTML
             * @param column3 (Array): column 3 HTML
             * @param buttons (Array): buttons HTML
             */
            
                var HTML = new Array();
                
                column1 = column1 === undefined ? new Array():column1;
                column2 = column2 === undefined ? new Array():column2;
                column3 = column3 === undefined ? new Array():column3;
                buttons = buttons === undefined ? new Array():buttons;
                
                HTML.push('<table class="dopbsp-data-module-wrapper">');
                HTML.push('<tbody>');
                HTML.push('     <tr>');
                HTML.push('         <td>');
                HTML.push('             <div id="DOPBSPReservationsCalendar-data-module-column1">');
                HTML.push(column1.join(''));
                HTML.push('             </div>');
                HTML.push('         </td>');
                HTML.push('         <td>');
                HTML.push('             <div id="DOPBSPReservationsCalendar-data-module-column2">');
                HTML.push(column2.join(''));
                HTML.push('             </div>');
                HTML.push('         </td>');
                HTML.push('         <td>');
                HTML.push('             <div id="DOPBSPReservationsCalendar-data-module-column3">');
                HTML.push(column3.join(''));
                HTML.push('             </div>');
                HTML.push('         </td>');
                HTML.push('     </tr>');
                HTML.push('</tbody>');
                HTML.push('</table>');
                
                HTML.push(buttons.join(''));
                
                methods_tooltip.set(HTML.join(''));
            },
            displayColumn:function(){
            /*
             * Select the column where the reservation info will be displayed.
             * 
             * @return selected column
             */
                var column = 1,
                column1h = $('#DOPBSPReservationsCalendar-data-module-column1').height(),
                column2h = $('#DOPBSPReservationsCalendar-data-module-column2').height(),
                column3h = $('#DOPBSPReservationsCalendar-data-module-column3').height();
                
                if (column1h === undefined){
                    return 1;
                }
                
                if (column3h <= column1h
                        && column3h <= column2h){
                    column = 3;
                }
                
                if (column2h <= column1h
                        && column2h <= column3h){
                    column = 2;
                }
                
                if (column1h <= column2h
                        && column1h <= column2h){
                    column = 1;
                }
                    
                return column;
            },
            displayData:function(label,
                                 value,
                                 dataClass){
            /*
             * Display reservation data field.
             * 
             * @param label (String): field label
             * @param value (String): field value
             * @param dataClass (String): field class
             * 
             * @return data field HTML
             */
                var HTML = new Array();
                
                label = label === undefined ? '':label;
                value = value === undefined ? '':value;
                dataClass = dataClass === undefined ? '':dataClass;
                
                HTML.push('<div class="dopbsp-data-field '+dataClass+'">');
                HTML.push('     <label>'+label+'</label>');
                HTML.push('     <div class="dopbsp-data-value">'+value+'</div>');
                HTML.push('</div>');
                
                return HTML.join('');
            },
            
            get:function(id){
            /*
             * Get reservation data.
             * 
             * @param id (Number): reservation ID
             * 
             * @return reservation data
             */
                var i,
                reservations = methods_reservations.vars.reservations,
                reservation = '';

                for (i=0; i<reservations.length; i++){
                    if (reservations[i]['id'] === id){
                        reservation = reservations[i];
                        break;
                    }
                }
                
                return reservation;
            },
            set:function(id){
            /*
             * Set reservation details.
             * 
             * @param id (Number): reservation ID
             */    
                var displayApproveButton = false,
                displayRejectButton = false,
                displayCancelButton = false,
                displayDeleteButton = false,
                HTMLColumn1 = new Array(),
                HTMLColumn2 = new Array(),
                HTMLColumn3 = new Array(),
                HTML = new Array(),
                i,
                reservation = methods_reservation.get(id),
                statusLabel = '';
        
                methods_reservation.display();
        
                /*
                 * Set status label and buttons which will initially be displayed.
                 */
                switch (reservation['status']){
                    case 'pending':
                        statusLabel = methods_reservation.text['statusPending'];
                        displayApproveButton = true;
                        displayRejectButton = true;
                        break;
                    case 'approved':
                        statusLabel = methods_reservation.text['statusApproved'];
                        displayCancelButton = true;
                        break;
                    case 'rejected':
                        statusLabel = methods_reservation.text['statusRejected'];
                        displayApproveButton = true;
                        displayDeleteButton = true;
                        break;
                    case 'canceled':
                        statusLabel = methods_reservation.text['statusCanceled'];
                        displayApproveButton = true;
                        displayDeleteButton = true;
                        break;
                    default:
                        statusLabel = methods_reservation.text['statusExpired'];
                        displayDeleteButton = true;
                }
                
                for (i=1; i<=8; i++){
                    HTML = new Array();
                    
                    switch (i){
                        case 1:
                            /*
                             * Set details/order data.
                             */
                            HTML.push(methods_order.set(reservation,
                                                        statusLabel));
                            break;
                        case 2:
                            /*
                             * Set form data.
                             */
                            HTML.push(methods_form.set(reservation['form']));
                            break;
                        case 3:
                            /*
                             * Set extras data.
                             */
                            HTML.push(methods_extras.set(reservation['extras'],
                                                         parseFloat(reservation['extras_price']),
                                                         reservation['currency']));
                            break;
                        case 4:
                            /*
                             * Set discount data.
                             */
                            HTML.push(methods_discounts.set(reservation['discount'],
                                                            parseFloat(reservation['discount_price']),
                                                            reservation['currency']));
                            break;
                        case 5:
                            /*
                             * Set taxes & fees data.
                             */
                            HTML.push(methods_fees.set(reservation['fees'],
                                                       parseFloat(reservation['fees_price']),
                                                       reservation['currency']));
                            break;
                        case 6:
                            /*
                             * Set coupons data.
                             */
                            HTML.push(methods_coupons.set(reservation['coupon'],
                                                          parseFloat(reservation['coupon_price']),
                                                          reservation['currency']));
                            break;
                        case 7:
                            /*
                             * Set billing address data.
                             */
                            HTML.push(methods_order.setAddress(reservation['address_billing'],
                                                               reservation['payment_method'],
                                                               'billing'));
                            break;
                        case 8:
                            /*
                             * Set shipping address data.
                             */
                            HTML.push(methods_order.setAddress(reservation['address_shipping'],
                                                               reservation['payment_method'],
                                                               'shipping'));
                            break;
                    }
                    
                    /*
                     * Add data to the right column.
                     */
                    switch (methods_reservation.displayColumn()){
                        case 2:
                            HTMLColumn2.push(HTML);
                            break;
                        case 3:
                            HTMLColumn3.push(HTML);
                            break;
                        default:
                            HTMLColumn1.push(HTML);
                    }
                    
                    methods_reservation.display(HTMLColumn1,
                                                HTMLColumn2,
                                                HTMLColumn3);
                }
                
                /*
                 * Set buttons.
                 */
                HTML = new Array();
                
                if (reservation['check_in'] >= methods_calendar.vars.todayYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.todayMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.todayDay)){
                    HTML.push('<div class="dopbsp-instructions">'+methods_reservation.text['instructions']+'</div>');
                    HTML.push('<div class="dopbsp-buttons-wrapper">');
                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsCalendar-reservation-close'+reservation['id']+'" class="dopbsp-button-close">'+methods_reservation.text['buttonClose']+'</a>');
                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsCalendar-reservation-delete'+reservation['id']+'" class="dopbsp-button-delete" style="display: '+(displayDeleteButton ? 'block':'none')+'">'+methods_reservation.text['buttonDelete']+'</a>');
                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsCalendar-reservation-cancel'+reservation['id']+'" class="dopbsp-button-cancel" style="display: '+(displayCancelButton ? 'block':'none')+'">'+methods_reservation.text['buttonCancel']+'</a>');
                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsCalendar-reservation-reject'+reservation['id']+'" class="dopbsp-button-reject" style="display: '+(displayRejectButton ? 'block':'none')+'">'+methods_reservation.text['buttonReject']+'</a>');
                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsCalendar-reservation-approve'+reservation['id']+'" class="dopbsp-button-approve" style="display: '+(displayApproveButton ? 'block':'none')+'">'+methods_reservation.text['buttonApprove']+'</a>');
                    HTML.push('</div>');
                }
                else{
                    HTML.push('<div class="dopbsp-buttons-wrapper">');
                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsCalendar-reservation-close'+reservation['id']+'" class="dopbsp-button-close">'+methods_reservation.text['buttonClose']+'</a>');
                    HTML.push('</div>');
                }   
                methods_reservation.display(HTMLColumn1,
                                            HTMLColumn2,
                                            HTMLColumn3,
                                            HTML);
                
                methods_reservation.events.init();
            },
            update:function(id,
                            action){
            /*
             * Update reservation display when status changes.
             * 
             * @param id (Number): reservation ID
             * @param action (String): action to be taken on reservation
             */
                var i,
                reservationIndex, 
                reservationsData = methods_reservations.vars.reservationsData;
        
                /*
                 * Set appropriate status.
                 */
                $('.dopbsp-reservation'+id, Container).removeClass('dopbsp-approved')
                                                      .removeClass('dopbsp-canceled')
                                                      .removeClass('dopbsp-pending')
                                                      .removeClass('dopbsp-rejected');
                                              
                $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-status').removeClass('dopbsp-approved')
                                                                             .removeClass('dopbsp-canceled')
                                                                             .removeClass('dopbsp-pending')
                                                                             .removeClass('dopbsp-rejected');
                                                                     
                /*
                 * Get reservation index.
                 */
                for (i=0; i<reservationsData.length; i++){
                    if (reservationsData[i]['id'] === id){
                        reservationIndex = i;
                        break;
                    }
                }
                
                switch (action){
                    case 'approve':
                        methods_reservations.vars.reservationsData[reservationIndex]['status'] = 'approved';
                        $('.dopbsp-reservation'+id, Container).addClass('dopbsp-approved');
                        $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-status').addClass('dopbsp-approved');
                        $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-status .dopbsp-data-value').html(methods_reservation.text['statusApproved']);
                        break;
                    case 'cancel':
                        methods_reservations.vars.reservationsData[reservationIndex]['status'] = 'canceled';
                        $('.dopbsp-reservation'+id, Container).addClass('dopbsp-canceled');
                        $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-status').addClass('dopbsp-canceled');
                        $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-status .dopbsp-data-value').html(methods_reservation.text['statusCanceled']);
                        break;
                    case 'delete':
                        methods_reservations.vars.reservationsData.splice(reservationIndex, 1);
                        $('#DOPBSPReservationsCalendar-tooltip'+ID).removeClass('dopbsp-selected');
                        methods_tooltip.clear();
                        methods_reservations.display();
                        break;
                    case 'reject':
                        methods_reservations.vars.reservationsData[reservationIndex]['status'] = 'rejected';
                        $('.dopbsp-reservation'+id, Container).addClass('dopbsp-rejected');
                        $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-status').addClass('dopbsp-rejected');
                        $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-status .dopbsp-data-value').html(methods_reservation.text['statusRejected']);
                        break;
                }
                
                /*
                 * Display appropriate buttons.
                 */
                $('#DOPBSPReservationsCalendar-reservation-approve'+id).css('display', action === 'cancel' || action === 'reject' ? 'block':'none');
                $('#DOPBSPReservationsCalendar-reservation-cancel'+id).css('display', action === 'approve' ? 'block':'none');
                $('#DOPBSPReservationsCalendar-reservation-delete'+id).css('display', action === 'cancel' || action === 'reject' ? 'block':'none');
                $('#DOPBSPReservationsCalendar-reservation-reject'+id).css('display', 'none');
            },
            
            events: {
                init:function(){
                /*
                 * Initialize reservation buttons events.
                 */    
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-approve').unbind('click');
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-approve').bind('click', function(){
                        methods_reservation.events.confirmation('RESERVATIONS_RESERVATION_APPROVE_CONFIRMATION',
                                                                $(this).attr('id').split('DOPBSPReservationsCalendar-reservation-approve')[1],
                                                                'approve');
                    });
                    
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-cancel').unbind('click');
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-cancel').bind('click', function(){
                        var i,
                        id = $(this).attr('id').split('DOPBSPReservationsCalendar-reservation-cancel')[1],
                        paymentGateways = methods_order.data.paymentGateways,
                        refund = false,
                        reservations = methods_reservations.vars.reservations;
                        
                        for (i=0; i<reservations.length; i++){
                            if (reservations[i]['id'] === id){
                                refund = paymentGateways[reservations[i]['payment_method']] !== undefined ? paymentGateways[reservations[i]['payment_method']].data['refund']:false;
                                break;
                            }
                        }
                        
                        methods_reservation.events.confirmation(refund ? 'RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION_REFUND':'RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION',
                                                                id,
                                                                'cancel');
                    });
                    
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-delete').unbind('click');
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-delete').bind('click', function(){
                        methods_reservation.events.confirmation('RESERVATIONS_RESERVATION_DELETE_CONFIRMATION',
                                                                $(this).attr('id').split('DOPBSPReservationsCalendar-reservation-delete')[1],
                                                                'delete');
                    });
                    
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-reject').unbind('click');
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-reject').bind('click', function(){
                        methods_reservation.events.confirmation('RESERVATIONS_RESERVATION_REJECT_CONFIRMATION',
                                                                $(this).attr('id').split('DOPBSPReservationsCalendar-reservation-reject')[1],
                                                                'reject');
                    });

                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-close').unbind('click');
                    $('#DOPBSPReservationsCalendar-tooltip'+ID+' .dopbsp-button-close').bind('click', function(){
                        $('#DOPBSPReservationsCalendar-tooltip'+ID).removeClass('dopbsp-selected');
                        methods_tooltip.clear();
                    });
                },
                confirmation:function(message,
                                      id,
                                      action){
                /*
                 * Confirm an action.
                 * 
                 * @param message (String): confirmation message
                 * @param id (Number): reservation ID
                 * @param action (String): action to be taken
                 */
                   var text = DOPBSPBackEnd.text(message);

                   $('#DOPBSP-messages-box').removeClass('dopbsp-active')
                                            .removeClass('dopbsp-active-info')
                                            .removeClass('dopbsp-error')
                                            .removeClass('dopbsp-success');
                   $('#DOPBSP-messages-box .dopbsp-message').html('');

                   $('#DOPBSP-messages-background').addClass('dopbsp-active');
                   $('#DOPBSP-confirmation-box').addClass('dopbsp-active');
                   $('#DOPBSP-confirmation-box .dopbsp-message').html(text);
                   
                   $('#DOPBSP-confirmation-box .dopbsp-button-yes').unbind('click');
                   $('#DOPBSP-confirmation-box .dopbsp-button-yes').bind('click', function(){
                       $('#DOPBSP-messages-background').removeClass('dopbsp-active');
                       $('#DOPBSP-confirmation-box').removeClass('dopbsp-active');
                       $('#DOPBSP-confirmation-box .dopbsp-message').html('');
                       
                       switch (action){
                           case 'approve':
                               methods_reservation.events.approve(id);
                               break;
                           case 'cancel':
                               methods_reservation.events.cancel(id);
                               break;
                           case 'delete':
                               methods_reservation.events.delete(id);
                               break;
                           case 'reject':
                               methods_reservation.events.reject(id);
                               break;
                       }       
                   });

                   $('#DOPBSP-confirmation-box .dopbsp-button-no').unbind('click');
                   $('#DOPBSP-confirmation-box .dopbsp-button-no').bind('click', function(){
                       $('#DOPBSP-messages-background').removeClass('dopbsp-active');
                       $('#DOPBSP-confirmation-box').removeClass('dopbsp-active');
                       $('#DOPBSP-confirmation-box .dopbsp-message').html('');
                   });
                },
                
                approve:function(id){
                /*
                 * Approve reservation.
                 * 
                 * @param id (Number): reservation ID
                 */    
                    DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

                    $.post(ajaxurl, {action:'dopbsp_reservation_approve',
                                     reservation_id: id}, function(data){
                        data = $.trim(data);

                        if (data === 'unavailable'){  
                            DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('RESERVATIONS_APPROVE_UNAVAILABLE'));
                        }
                        else if (data === 'unavailable-coupon'){  
                            DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('RESERVATIONS_APPROVE_UNAVAILABLE_COUPON'));
                        }
                        else{
                            methods_reservation.update(id,
                                                       'approve');
                            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_APPROVE_SUCCESS'));
                        }
                    }).fail(function(data){
                        DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                    });   
                    
                },
                cancel:function(id){
                /*
                 * Cancel reservation.
                 * 
                 * @param id (Number): reservation ID
                 */
                    DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

                    $.post(ajaxurl, {action: 'dopbsp_reservation_cancel',
                                     reservation_id: id}, function(data){                     
                        data = $.trim(data);

                        var response = data.split(';;;;;');
            
                        methods_reservation.update(id,
                                                   'cancel');
                                     
                        if (response[0] === 'error'){
                            DOPBSPBackEnd.toggleMessages('error', response[1]);
                        }                    
                        else if (response[0] === 'error_with_message'){
                            DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS')+'<br /><br />'+response[1]);
                        }
                        else if (response[0] === 'success_with_message'){
                            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS')+'<br /><br />'+response[1]);
                        }
                        else{
                            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS'));
                        }
                    }).fail(function(data){
                        DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                    });
                },
                delete:function(id){
                /*
                 * Delete reservation.
                 * 
                 * @param id (Number): reservation ID
                 */
                    DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

                    $.post(ajaxurl, {action:'dopbsp_reservation_delete',
                                     reservation_id: id}, function(data){
                            methods_reservation.update(id,
                                                       'delete');
                            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_DELETE_SUCCESS'));
                    }).fail(function(data){
                        DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                    });    
                    
                },
                reject:function(id){
                /*
                 * Reject reservation.
                 * 
                 * @param id (Number): reservation ID
                 */
                    DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

                    $.post(ajaxurl, {action:'dopbsp_reservation_reject',
                                     reservation_id: id}, function(data){
                        methods_reservation.update(id,
                                                   'reject');
                        DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_REJECT_SUCCESS'));
                    }).fail(function(data){
                        DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                    });
                }
            }
        },

// 11. Filters                
                
        methods_filters = {
            init:function(){
            /*
             * Initialize filters.
             */
                methods_filters.events();
            },
            events:function(){
            /*
             * Initialize filters events.
             */
                /*
                 * Period
                 */
                $('#DOPBSP-reservations-start-hour').unbind('change');
                $('#DOPBSP-reservations-start-hour').bind('change', function(){
                    methods_reservations.display();
                });

                $('#DOPBSP-reservations-end-hour').unbind('change');
                $('#DOPBSP-reservations-end-hour').bind('change', function(){
                    methods_reservations.display();
                });

                /*
                 * Status
                 */
                $('#DOPBSP-inputs-reservations-filters-status input[type=checkbox]').unbind('click');
                $('#DOPBSP-inputs-reservations-filters-status input[type=checkbox]').bind('click', function(){
                    methods_reservations.display();
                });

                /*
                 * Payment
                 */
                $('#DOPBSP-inputs-reservations-filters-payment input[type=checkbox]').unbind('click');
                $('#DOPBSP-inputs-reservations-filters-payment input[type=checkbox]').bind('click', function(){
                    methods_reservations.display();
                });
            }
        },

// 12. Sidebar

        methods_sidebar = {
            data: {},
            text: {}
        },
                
// 13. Search
        
        methods_search = {
            data: {},
            text: {}
        },

// 14. Rules        
                
        methods_rules = {
            data: {},
            text: {}
        },
                
// 15. Extras
        
        methods_extras = {
            data: {},
            text: {},
            
            set:function(extras,
                         price,
                         currency){
            /*
             * Set extras data.
             * 
             * @param extras (Array): reservation extras
             * @param price (Number): extras price
             * @param currency (String): reservation currency sign
             * 
             * @return extras data HTML
             */                 
                var extra,
                HTML = new Array(),
                i,
                j,
                value = new Array(),
                values = new Array();
                
                HTML.push('<div class="dopbsp-data-module dopbsp-last">');
                HTML.push('     <div class="dopbsp-data-head">');
                HTML.push('         <h3>'+methods_extras.text['title']+'</h3>');
                HTML.push('     </div>');
                HTML.push('     <div class="dopbsp-data-body">');
                
                if (extras !== ''){
                    for (i=0; i<extras.length; i++){
                        extras[i]['displayed'] = false;
                    }

                    for (i=0; i<extras.length; i++){
                        values = new Array();

                        if (extras[i]['displayed'] === false){
                            for (j=0; j<extras.length; j++){
                                value = new Array();
                                extra = extras[j];

                                if (extras[i]['group_id'] === extra['group_id']){
                                    value.push(extra['translation']);

                                    if (extra['price'] !== 0){
                                        value.push('<br />');

                                        if (extra['price_type'] !== 'fixed' 
                                                || extra['price_by'] !== 'once'){ 
                                            value.push('<span class="dopbsp-info-rule">&#9632;&nbsp;');

                                            if (extra['price_type'] === 'fixed'){
                                                value.push(extra['operation']+'&nbsp;'+methods_price.set(extra['price'], currency));
                                            }
                                            else{
                                                value.push(extra['operation']+'&nbsp;'+extra['price']+'%');
                                            }

                                            if (extra['price_by'] !== 'once'){
                                                value.push('/'+(methods_hours.data['enabled'] ? methods_extras.text['byHour']:methods_extras.text['byDay']));
                                            }
                                            value.push('</span><br />');
                                        }
                                        value.push('<span class="dopbsp-info-price">'+extra['operation']+'&nbsp;');
                                        value.push(methods_price.set(extra['price_total'], currency));
                                        value.push('</span>');
                                    }

                                    if (value.length !== 0){
                                        extras[j]['displayed'] = true;
                                        values.push(value.join(''));
                                    }
                                }
                            }  

                            HTML.push(methods_reservation.displayData(extras[i]['group_translation'],
                                                                      values.join('<br /><br />')));  
                        }
                    }

                    if (price !== 0){
                        HTML.push('<br />');
                        HTML.push(methods_reservation.displayData(methods_reservation.text['priceChange'],
                                                                  (price > 0 ? '+':'-')+
                                                                        '&nbsp;'+
                                                                        methods_price.set(price, currency),
                                                                   'dopbsp-price'));
                    }
                }
                else{
                    HTML.push('<em>'+methods_reservation.text['noExtras']+'</em>');
                }
                HTML.push('     </div>');
                HTML.push('</div>');

                return HTML.join('');
            }
        },

// 16. Discounts
        
        methods_discounts = {
            data: {},
            text: {},
            
            set:function(discount,
                         price, 
                         currency){
            /*
             * Set discount data.
             * 
             * @param discount (Object): reservation discount
             * @param price (Number): discount price
             * @param currency (String): reservation currency sign
             * 
             * @return discount data HTML
             */
                var HTML = new Array(),
                value = new Array();
                
                HTML.push('<div class="dopbsp-data-module">');
                HTML.push('     <div class="dopbsp-data-head">');
                HTML.push('         <h3>'+methods_discounts.text['title']+'</h3>');
                HTML.push('     </div>');
                HTML.push('     <div class="dopbsp-data-body">');
                
                if (discount['id'] !== '0'){
                    value = new Array();

                    value.push('<span class="dopbsp-info-rule">&#9632;&nbsp;');

                    if (discount['price_type'] === 'fixed'){
                        value.push(discount['operation']+'&nbsp;'+methods_price.set(discount['price'], currency));
                    }
                    else{
                        value.push(discount['operation']+'&nbsp;'+discount['price']+'%');
                    }

                    if (discount['price_by'] !== 'once'){
                        value.push('/'+(methods_hours.data['enabled'] ? methods_discounts.text['byHour']:methods_discounts.text['byDay']));
                    }
                    value.push('</span>');

                    HTML.push(methods_reservation.displayData(discount['translation'],
                                                              value.join('')));

                    if (price !== 0){
                        HTML.push('<br />');
                        HTML.push(methods_reservation.displayData(methods_reservation.text['priceChange'],
                                                                  (price > 0 ? '+':'-')+
                                                                        '&nbsp;'+
                                                                        methods_price.set(price, currency),
                                                                   'dopbsp-price'));
                    }
                }
                else{
                    HTML.push('<em>'+methods_reservation.text['noDiscount']+'</em>');
                }
                HTML.push('     </div>');
                HTML.push('</div>');

                return HTML.join('');
            }
        },

// 17. Fees
        
        methods_fees = {
            data: {},
            text: {},
            
            set:function(fees,
                         price, 
                         currency){
            /*
             * Set fees data.
             * 
             * @param fees (Array): reservation fees
             * @param price (Number): fees price
             * @param currency (String): reservation currency sign
             * 
             * @return fees data HTML
             */
                var fee,
                HTML = new Array(),
                i,
                value = new Array();
                
                HTML.push('<div class="dopbsp-data-module">');
                HTML.push('     <div class="dopbsp-data-head">');
                HTML.push('         <h3>'+methods_fees.text['title']+'</h3>');
                HTML.push('     </div>');
                HTML.push('     <div class="dopbsp-data-body">');
                
                if (fees !== ''){
                    for (i=0; i<fees.length; i++){
                        value = new Array();
                        fee = fees[i];

                        if (fee['price_type'] !== 'fixed' 
                                || fee['price_by'] !== 'once'){ 
                            value.push('<span class="dopbsp-info-rule">&#9632;&nbsp;');

                            if (fee['price_type'] === 'fixed'){
                                value.push(fee['operation']+'&nbsp;'+methods_price.set(fee['price'], currency));
                            }
                            else{
                                value.push(fee['operation']+'&nbsp;'+fee['price']+'%');
                            }

                            if (fee['price_by'] !== 'once'){
                                value.push('/'+(methods_hours.data['enabled'] ? methods_fees.text['byHour']:methods_fees.text['byDay']));
                            }
                            value.push('<br /></span>');
                        }
                        
                        if (fee['included'] === 'true'){
                            value.push('<span class="dopbsp-info-price">'+methods_fees.text['included']+'</span>');
                        }
                        else{
                            value.push('<span class="dopbsp-info-price">'+fee['operation']+'&nbsp;');
                            value.push(methods_price.set(fee['price_total'], currency));
                            value.push('</span>');
                        }

                        HTML.push(methods_reservation.displayData(fee['translation'],
                                                                  value.join('')));
                    }
                    
                    if (price !== 0){
                        HTML.push('<br />');
                        HTML.push(methods_reservation.displayData(methods_reservation.text['priceChange'],
                                                                  (price > 0 ? '+':'-')+
                                                                        '&nbsp;'+
                                                                        methods_price.set(price, currency),
                                                                   'dopbsp-price'));
                    }
                }
                else{
                    HTML.push('<em>'+methods_reservation.text['noFees']+'</em>');
                }
                HTML.push('     </div>');
                HTML.push('</div>');

                return HTML.join('');
            }
        },
                
// 18. Coupons
        
        methods_coupons = {
            data: {},
            text: {},
            
            set:function(coupon,
                         price, 
                         currency){
            /*
             * Set coupon data.
             * 
             * @param coupon (Object): reservation coupon
             * @param price (Number): coupon price
             * @param currency (String): reservation currency sign
             * 
             * @return coupon data HTML
             */
                var HTML = new Array(),
                value = new Array();
                
                HTML.push('<div class="dopbsp-data-module dopbsp-last">');
                HTML.push('     <div class="dopbsp-data-head">');
                HTML.push('         <h3>'+methods_coupons.text['title']+'</h3>');
                HTML.push('     </div>');
                HTML.push('     <div class="dopbsp-data-body">');
                
                if (coupon['id'] !== '0'){
                    value = new Array();

                    value.push(coupon['code']);

                    if (coupon['price_type'] !== 'fixed' 
                            || coupon['price_by'] !== 'once'){ 
                        value.push('<br /><span class="dopbsp-info-rule">&#9632;&nbsp;');

                        if (coupon['price_type'] === 'fixed'){
                            value.push(coupon['operation']+'&nbsp;'+methods_price.set(coupon['price'], currency));
                        }
                        else{
                            value.push(coupon['operation']+'&nbsp;'+coupon['price']+'%');
                        }

                        if (coupon['price_by'] !== 'once'){
                            value.push('/'+(methods_hours.data['enabled'] ? methods_coupons.text['byHour']:methods_coupons.text['byDay']));
                        }
                        value.push('</span>');
                    }

                    HTML.push(methods_reservation.displayData(coupon['translation'],
                                                              value.join('')));

                    if (price !== 0){
                        HTML.push('<br />');
                        HTML.push(methods_reservation.displayData(methods_reservation.text['priceChange'],
                                                                  (price > 0 ? '+':'-')+
                                                                        '&nbsp;'+
                                                                        methods_price.set(price, currency),
                                                                   'dopbsp-price'));
                    }
                }
                else{
                    HTML.push('<em>'+methods_reservation.text['noCoupon']+'</em>');
                }
                HTML.push('     </div>');
                HTML.push('</div>');

                return HTML.join('');
            }
        },

// 19. Deposit
        
        methods_deposit = {
            data: {},
            text: {},
            
            set:function(price,
                         reservationPrice,
                         currency){
            /*
             * Set deposit data.
             * 
             * @param price (Object): deposit price
             * @param reservationPrice (Number): reservation price
             * @param currency (String): reservation currency sign
             * 
             * @return deposit data HTML
             */
                var HTML = new Array();
               
                if (parseFloat(price) > 0){
                    HTML.push(methods_reservation.displayData(methods_deposit.text['title'],
                                                              methods_price.set(parseFloat(price), currency),
                                                              'price'));
                    HTML.push(methods_reservation.displayData(methods_deposit.text['left'],
                                                              methods_price.set(parseFloat(reservationPrice)-parseFloat(price), currency),
                                                              'price'));
                }
            
                return HTML.join('');
            }
        },       
                
// 20. Form
                
        methods_form = {
            data: {},
            text: {},
            
            set:function(form){
            /*
             * Set form data.
             * 
             * @param form (Object): reservation form
             * 
             * @return form data HTML
             */
                var field,
                HTML = new Array(),
                i,
                j,
                value = '',
                values = new Array();
        
                HTML.push('<div class="dopbsp-data-module">');
                HTML.push('     <div class="dopbsp-data-head">');
                HTML.push('         <h3>'+methods_form.text['title']+'</h3>');
                HTML.push('     </div>');
                HTML.push('     <div class="dopbsp-data-body">');
                
                if (form !== ''){
                    for (i=0; i<form.length; i++){
                        field = form[i];
                            
                        if (field['value'] instanceof Array){
                            values = new Array();

                            for (j=0; j<field['value'].length; j++){
                               values.push(field['value'][j]['translation']);
                            }
                            HTML.push(methods_reservation.displayData(field['translation'],
                                                                      values.join('<br />')));
                        }
                        else{
                            if (field['value'] === 'true'){
                                value = methods_form.text['checked'];
                            }
                            else if (field['value'] === 'false'){
                                value = methods_form.text['unchecked'];
                            }
                            else{
                                value = field['is_email'] !== undefined && field['is_email'] === 'true' ? '<a href="mailto:'+field['value']+'">'+field['value']+'</a>':
                                                                                                          field['value'];
                            }
                            HTML.push(methods_reservation.displayData(field['translation'],
                                                                      value !== '' ? value:methods_reservation.text['noFormField'],
                                                                      value !== '' ? '':'dopbsp-no-data'));
                        }
                    }
                }
                else{
                    HTML.push('<em>'+methods_reservation.text['noForm']+'</em>');
                }
                HTML.push('     </div>');
                HTML.push('</div>');

                return HTML.join('');
            }
        },
                
// 21. Order
 
        methods_order = {
            data: {},
            text: {},
            vars: {addressFields: [{"id": "first-name",
                                    "key": "first_name",
                                    "text": "addressFirstName"},
                                   {"id": "last-name",
                                    "key": "last_name",
                                    "text": "addressLastName"},
                                   {"id": "company",
                                    "key": "company",
                                    "text": "addressCompany"},
                                   {"id": "email",
                                    "key": "email",
                                    "text": "addressEmail"},
                                   {"id": "phone",
                                    "key": "phone",
                                    "text": "addressPhone"},
                                   {"id": "country",
                                    "key": "country",
                                    "text": "addressCountry"},
                                   {"id": "address-first",
                                    "key": "address_first",
                                    "text": "addressAddressFirst"},
                                   {"id": "address-second",
                                    "key": "address_second",
                                    "text": "addressAddressSecond"},
                                   {"id": "city",
                                    "key": "city",
                                    "text": "addressCity"},
                                   {"id": "state",
                                    "key": "state",
                                    "text": "addressState"},
                                   {"id": "zip-code",
                                    "key": "zip_code",
                                    "text": "addressZipCode"}]},
            
            set:function(reservation,
                         status){
            /*
             * Set reservation details data.
             * 
             * @param reservation (Object): reservation data
             * @param status (String): reservation status
             * 
             * @return reservation details data HTML
             */
                var HTML = new Array(),
                paymentGateways = methods_order.data['paymentGateways'];
                
                HTML.push('<div class="dopbsp-data-module">');
                HTML.push('     <div class="dopbsp-data-head">');
                HTML.push('         <h3>'+methods_reservation.text['titleDetails']+'</h3>');
                HTML.push('     </div>');
                HTML.push('     <div class="dopbsp-data-body">');
                
                /*
                 * ID
                 */
                HTML.push(methods_reservation.displayData(methods_reservation.text['id'],
                                                          reservation['id']));
                                                          
                /*
                 * Status
                 */
                HTML.push(methods_reservation.displayData(methods_reservation.text['status'],
                                                          status,
                                                          'dopbsp-status dopbsp-'+reservation['status']));
                                                          
                /*
                 * Date created.
                 */
                HTML.push(methods_reservation.displayData(methods_reservation.text['dateCreated'],
                                                          methods_order.getDateFormat(reservation['date_created'].split(' ')[0])));
                
                /*
                 * Selected language.
                 */
                HTML.push(methods_reservation.displayData(methods_reservation.text['language'],
                                                          methods_order.getLanguage(reservation['language'])));
                HTML.push('         <br />');
                
                /*
                 * Check in data.
                 */
                HTML.push(methods_reservation.displayData(methods_search.text['checkIn'],
                                                          methods_order.getDateFormat(reservation['check_in'])));
                /*
                 * Check out data.
                 */
                if (reservation['check_out'] !== ''){
                    HTML.push(methods_reservation.displayData(methods_search.text['checkOut'],
                                                              methods_order.getDateFormat(reservation['check_out'])));
                }

                /*
                 * Start hour data.
                 */
                if (reservation['start_hour'] !== ''){
                    HTML.push(methods_reservation.displayData(methods_search.text['hourStart'],
                                                              (methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(reservation['start_hour']):reservation['start_hour'])));
                }

                /*
                 * End hour data.
                 */
                if (reservation['end_hour'] !== ''){
                    HTML.push(methods_reservation.displayData(methods_search.text['hourEnd'],
                                                              (methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(reservation['end_hour']):reservation['end_hour'])));
                }

                /*
                 * No items data.
                 */
                if (methods_sidebar.data['noItems']){
                    HTML.push(methods_reservation.displayData(methods_search.text['noItems'],
                                                              reservation['no_items']));
                }

                /*
                 * Reservation price.
                 */
                if (parseFloat(reservation['price']) > 0){
                    HTML.push(methods_reservation.displayData(methods_reservation.text['price'],
                                                              methods_price.set(reservation['price'],
                                                                                reservation['currency']),
                                                              'dopbsp-price'));
                }
                HTML.push('         <br />');
                
                /*
                 * Payment method.
                 */
                switch (reservation['payment_method']){
                    case 'none':
                        HTML.push(methods_reservation.displayData(methods_order.text['paymentMethod'],
                                                                  methods_order.text['paymentMethodNone']));
                        break;
                    case 'default':
                        HTML.push(methods_reservation.displayData(methods_order.text['paymentMethod'],
                                                                  methods_order.text['paymentMethodArrival']));
                        break;
                    case 'woocommerce':
                        HTML.push(methods_reservation.displayData(methods_order.text['paymentMethod'],
                                                                  methods_order.text['paymentMethodWooCommerce']));
                        
                        /*
                         * Order ID
                         */
                        HTML.push(methods_reservation.displayData(methods_order.text['paymentMethodWooCommerceOrderID'],
                                                                  reservation['transaction_id']));
                        break;
                    default:
                        HTML.push(methods_reservation.displayData(methods_order.text['paymentMethod'],
                                                                  paymentGateways[reservation['payment_method']]['text']['title']));
                        
                        /*
                         * Transaction ID
                         */
                        HTML.push(methods_reservation.displayData(methods_order.text['paymentMethodTransactionID'],
                                                                  reservation['transaction_id']));
                }

                /*
                 * Reservation total price.
                 */
                if (parseFloat(reservation['price_total']) > 0){
                    HTML.push(methods_reservation.displayData(methods_reservation.text['priceTotal'],
                                                              methods_price.set(reservation['price_total'],
                                                                                reservation['currency']),
                                                              'dopbsp-price'));
                }
                
                /*
                 * Deposit.
                 */
                HTML.push(methods_deposit.set(reservation['deposit_price'],
                                              reservation['price_total'],
                                              reservation['currency']));
                
                HTML.push('     </div>');
                HTML.push('</div>');

                return HTML.join('');
            },
            setAddress:function(address,
                                paymentMethod,
                                type){
            /*
             * Set form data.
             * 
             * @param address (Object): reservation billing/shipping address
             * @param paymentMethod (String): reservation payment method
             * @param type (String): address type
             * 
             * @return form data HTML
             */
                var fields = methods_order.vars.addressFields, 
                HTML = new Array(),
                i,
                paymentGateways = methods_order.data['paymentGateways'],
                data = paymentMethod === 'none' || paymentMethod === 'default' || paymentMethod === 'woocommerce' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
                
                if (address !== ''){
                    type = type === undefined ? 'billing':type;
                            
                    HTML.push('<div class="dopbsp-data-module">');
                    HTML.push('     <div class="dopbsp-data-head">');
                    HTML.push('         <h3>'+(type === 'billing' ? methods_order.text['addressBilling']:methods_order.text['addressShipping'])+'</h3>');
                    HTML.push('     </div>');
                    HTML.push('     <div class="dopbsp-data-body">');
                    
                    if (type === 'shipping'
                            && address === 'billing_address'){
                        HTML.push('<em>'+methods_reservation.text['addressShippingCopy']+'</em>');
                    }
                    else if (address !== ''){
                        for (i=0; i<fields.length; i++){
                            if (data[fields[i]['key']]['enabled']){
                                HTML.push(methods_reservation.displayData(methods_order.text[fields[i]['text']],
                                                                          address[fields[i]['key']] !== '' ? (fields[i]['key'] === 'email' ? '<a href="mailto:'+address[fields[i]['key']]+'">'+address[fields[i]['key']]+'</a>':
                                                                                                                                             address[fields[i]['key']]):
                                                                                                             methods_reservation.text['noFormField'],
                                                                          address[fields[i]['key']] !== '' ? '':'dopbsp-no-data'));
                            }
                            
                        }
                    }
                    else{
                        HTML.push('<em>'+(type === 'billing' ? methods_order.text['noAddressBilling']:methods_order.text['noAddressShipping'])+'</em>');
                    }
                    HTML.push('     </div>');
                    HTML.push('</div>');
                }

                return HTML.join('');
            },
            
            getDateFormat:function(date){
            /*
             * Convert a date to calendar format.
             * 
             * @param date (String): date to be converted "YYYY-MM-DD"
             * 
             * @return date in set format
             */    
                var year = date.split('-')[0],
                month = date.split('-')[1],
                day = date.split('-')[2];
                
                return methods_calendar.data['dateType'] === 1 ? methods_months.text['names'][parseInt(month, 10)-1]+' '+day+', '+year:
                                                                 day+' '+methods_months.text['names'][parseInt(month, 10)-1]+' '+year;
            },
            getLanguage:function(code){
            /*
             * Get language name.
             * 
             * @param code (String): language code
             * 
             * @return language name
             */    
                var i,
                languages = methods_calendar.data['languages'],
                name = 'English';
        
                for (i=0; i<languages.length; i++){
                    if (languages[i]['code'] === code){
                        name = languages[i]['name'];
                        break;
                    }
                }
                
                return name;
            }
        };

        return methods.init.apply(this);
    };
})(jQuery);