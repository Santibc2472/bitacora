
/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.2.0
* File                    : assets/js/jquery.dop.backend.BSPReservationsAdd.js
* File Version            : 1.2.7
* Created / Last Modified : 30 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end add reservations jQuery plugin.
*/

(function($){
    'use strict';
  
    $.fn.DOPBSPReservationsAdd = function(options){
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
                    "cart": {"data": {"enabled": false},
                             "text": {"isEmpty": "Cart is empty.",
                                      "title": "Cart"}},
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
                                      "firstDisplayed": "",
                                      "morningCheckOut": false,
                                      "multipleSelect": true},
                             "text": {"names": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                                      "shortNames": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]}},
                    "deposit": {"data": {"deposit": 0,
                                         "type": "percent"},
                                "text": {"left": "Left to pay",
                                         "title": "Deposit"}}, 
                    "discounts": {"data": {"discount": [],
                                           "extras": false,
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
                                       "interval_autobreak": true,
                                       "multipleSelect": true},
                              "text": {}},
                    "ID": 0,
                    "default_schedule": {"available":1,"bind":0,"hours":{},"hours_definitions":[{"value":"00:00"}],"info":"","notes":"","price":0,"promo":0,"status":"none"},
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
                                        "title": "Seach"}},           
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
                                "text": {}}, 
                    "woocommerce": {"data": {"add_to_cart": false,
                                             "enabled": false,
                                             "product_id": 0},
                                    "text": {"none": "No reservation",
                                             "reservation": "Reservation",
                                             "addToCart": "Add to cart"}}},
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
                        $(window).bind('resize.DOPBSPReservationsAdd', methods.rp);                          
                    }
                });
            },
            parse:function(){
            /*
             * Parse calendar options.
             */    
                DOT.ajax.url = ajaxurl;
                
                DOPBSPFrontEnd.calendar[Data['ID']] = Data;
                
                ID = Data['ID'];
		
                methods_calendar.data = Data['calendar']['data'];
                methods_calendar.text = Data['calendar']['text'];
                
                methods_coupons.data = Data['coupons']['data'];
                methods_coupons.text = Data['coupons']['text'];
                
                methods_currency.data = Data['currency']['data'];
                methods_currency.text = Data['currency']['text'];
                
                DOT.methods.calendar_days.settings[ID] = Data['days']['data'];
                DOT.methods.calendar_days.text[ID] = Data['days']['text'];
                
                methods_extras.data = Data['extras']['data'];
                methods_extras.text = Data['extras']['text'];
                
                methods_form.data = Data['form']['data'];
                methods_form.text = Data['form']['text'];
                
                methods_hours.data = Data['hours']['data'];
                methods_hours.text = Data['hours']['text'];
                
                methods_months.data = Data['months']["data"];
                methods_months.text = Data['months']["text"];
                
                methods_order.data = Data['order']["data"];
                methods_order.text = Data['order']["text"];
                
                methods_reservation.data = Data['reservation']["data"];
                methods_reservation.text = Data['reservation']["text"];
                
                methods_search.data = Data['search']["data"];
                methods_search.text = Data['search']["text"];
		
                DOT.methods.calendar_schedule.default[ID] = JSON.parse(Data['default_schedule']);
                
                methods_sidebar.data = Data['sidebar']["data"];
                methods_sidebar.text = Data['sidebar']["text"];
                
                /*
                 * View info only option is disabled.
                 */
                Data['calendar']['data']['view'] = false;
                
                methods_months.init();
		
		methods_schedule.get(ID);
		DOT.methods.calendar_schedule.data[ID] = {};
                methods_schedule.parse(new Date().getFullYear());
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
                methods_day.rp();
            }
        },           
        
// 2. Schedule

        methods_schedule = {
            get:function(id) {
                
                var post = new Array();

                /*
                 * Set post variables.
                 */
                post.push(DOT.ajax.var + '=' + DOT.ajax.keys['user_calendars_data']);
                post.push('calendar_id=' + id);

                $.post(DOT.ajax.url, post.join('&'), function (data) {
                    data = JSON.parse($.trim(data));

                    DOT.methods.calendar_availability.data[id] = data['availability'];
                    methods_schedule.parse(new Date().getFullYear());
                }).fail(function (data) {
                    // console.log(data.status+': '+data.statusText);
                });
            },
            parse:function(year){
            /*
             * Parse calendar schedule.
             * 
             * @param year (Number): the year for which the calendar should get the schedule
             */
                var scheduleBuffer = {};
                
                $.post(ajaxurl, {action: 'dopbsp_calendar_schedule_get',
                                 id: ID,
                                 year:year,
                                 firstYear: '"'+methods_calendar.vars.firstYearLoaded+'"'}, function(data){
                    if ($.trim(data) !== ''){
                        scheduleBuffer = JSON.parse($.trim(data));

                        for (var day in scheduleBuffer){
                            scheduleBuffer[day] = JSON.parse(scheduleBuffer[day]);
                        }
			
                        $.extend(DOT.methods.calendar_schedule.data[ID], scheduleBuffer);
                    }
                    
                    if (methods_calendar.vars.display 
                            && (methods_calendar.vars.startMonth < 12-methods_months.vars.no+1 
                                    || methods_calendar.vars.firstYearLoaded 
                                    || year >= methods_calendar.data['maxYear'])){
                        methods_calendar.vars.display = false;
                        methods_calendar.display();
                        methods_components.init();
                        
                        DOPBSPBackEnd.toggleMessages('none', '');
                    }

                    if (!methods_calendar.vars.firstYearLoaded){
                        methods_calendar.vars.firstYearLoaded = true;
                    }

                    if (year < methods_calendar.data['maxYear']){
                        methods_schedule.parse(year+1);
                    }
                });
            },
            reset:function(){
            /*
             * Reset calendar schedule.
             */
                DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
                DOT.methods.calendar_schedule.data[ID] = {};
                methods_calendar.vars.display = true;
                methods_calendar.vars.firstYearLoaded = false;
                
                methods_schedule.parse(new Date().getFullYear());
            }
        },
                
// 3. Components

        methods_components = {
            init:function(){
            /*
             * Initialize calendar components.
             */ 
                var startDate;
        
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
                methods_calendar.vars.startDate = new Date(new Date().getTime()+methods_calendar.data['bookingStop']*60*1000);
                methods_calendar.vars.currMonth = methods_calendar.vars.startDate.getMonth()+1;
                methods_calendar.vars.currYear = methods_calendar.vars.startDate.getFullYear();
                methods_calendar.vars.startDay = methods_calendar.vars.startDate.getDate();
                methods_calendar.vars.startMonth = methods_calendar.vars.startDate.getMonth()+1;
                methods_calendar.vars.startYear = methods_calendar.vars.startDate.getFullYear(); 
                
                /*
                 * Tooltip
                 */
                methods_tooltip.display();
                
                startDate  = DOPPrototypes.getLeadingZero(methods_calendar.vars.startYear)
                             +'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)
                             +'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay);
                
                /*
                 * Calendar
                 */
                methods_calendar.container.init();
                methods_calendar.navigation.init();
                methods_calendar.init(methods_calendar.vars.startYear, 
                                      methods_calendar.vars.startMonth+(startDate < DOT.methods.calendar_days.settings[ID]['firstDisplayed'] ? DOPPrototypes.getNoMonths(startDate, DOT.methods.calendar_days.settings[ID]['firstDisplayed'])-1:0));
                                      
                /*
                 * Search
                 */
                methods_search.display();

                /*
                 * Extras
                 */
                if (methods_extras.data['id'] !== '0'){
                    methods_extras.display();
                }

                /*
                 * Coupons
                 */
                if (methods_coupons.data['id'] !== '0'){
                    methods_coupons.display();
                }

                /*
                 * Reservation
                 */
                methods_reservation.display();

                /*
                 * Form
                 */
                methods_form.display();
                
                /*
                 * Billing address.
                 */
                methods_order.payment.address_billing.display();
                
                /*
                 * Shipping address.
                 */
                methods_order.payment.address_shipping.display();

                /*
                 * Order
                 */
                methods_order.display();

                /*
                 * Initialize sidebar.
                 */
                methods_sidebar.init();
                
                methods.rp();
            }
        },  
                
// 4. Currency
        
        methods_currency = {
            data: {},
            text: {}
        },
         
// 6. Tooltip

        methods_tooltip = {
            display:function(){
            /*
             * Display information tooltip.
             */
                if ($('#DOPBSPReservationsAdd-tooltip'+ID).length !== undefined){
                    $('#DOPBSPReservationsAdd-tooltip'+ID).remove();
                }
                $('body').append('<div class="DOPBSPReservationsAdd-tooltip" id="DOPBSPReservationsAdd-tooltip'+ID+'"></div>');
                methods_tooltip.init();
            },
            init:function(){
            /*
             * Initialize information tooltip.
             */
                var $tooltip = $('#DOPBSPReservationsAdd-tooltip'+ID),
                h,
                xPos = 0, 
                yPos = 0;
                            
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

                        if ($(document).scrollTop()+$(window).height() < yPos+h+10){
                            yPos = $(document).scrollTop()+$(window).height()-h-10;
                        }

                        $tooltip.css({'left': xPos, 
                                      'top': yPos});
                    });
                }
                else{
                    /*
                     * Hide tooltip when you touch it.
                     */
                    $tooltip.unbind('touchstart');
                    $tooltip.bind('touchstart', function(e){
                        e.preventDefault();
                        methods_tooltip.clear();
                    });
                }
            },
            set:function(day,
                         hour,
                         type,
                         infoData){
            /*
             * Set tooltip.
             * 
             * @param day (String): the day for which the information will be displayed (YYYY-MM-DD)
             * @param hour (String): the hour for which the information will be displayed (HH:MM)
             * @param type (String): type of information to be displayed
             *                       "hours" display hours information
             *                       "info" display information
             *                       "notes" display notes
             * @param infoData (String): information to be displayed
             */       
                var data = (hour === '' ? DOT.methods.calendar_schedule.data[ID][day]:
                                          DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]),
                info = infoData !== undefined ? infoData:
                                                data[type]+(data['info_info'] !== undefined ? (data[type] !== '' && data['info_info'].length > 0 ? '<br /><br />':'')+methods_form.getInfo(data['info_info']):'');
                
                /*
                 * Display body info.
                 */
                if (type === 'info-body'){
                    info = methods_form.getInfo(data['info_body']);
                }

                /*
                 * Escape utf8 coding.
                 */
		try{
		    info = decodeURIComponent(escape(info));
		}
		catch(e){
		    info = decodeURIComponent(unescape(unescape(info)));
		}
                
                if (type === 'hours'
                        || type === 'info-body'){
                    $('#DOPBSPReservationsAdd-tooltip'+ID).removeClass('dopbsp-text');
                }
                else{
                    $('#DOPBSPReservationsAdd-tooltip'+ID).addClass('dopbsp-text');
                }
                $('#DOPBSPReservationsAdd-tooltip'+ID).html(info)
                                                      .css('display', 'block');                         
            },
            clear:function(){
            /*
             * Clear information display.
             */
                $('#DOPBSPReservationsAdd-tooltip'+ID).css('display', 'none');                        
            }
        },
                
// ***************************************************************************** Calendar

// 7. Calendar
        
        methods_calendar = {
            data: {},
            text: {},
            vars: {currMonth: new Date(),
                   currYear: new Date(),
                   display: true,
                   firstYearLoaded: false,
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
                HTML.push('<div class="DOPBSPReservationsAdd-container">');                        
                HTML.push('    <div class="DOPBSPReservationsAdd-navigation">');
                HTML.push('        <div class="dopbsp-month-year"></div>');
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-add-btn"><span class="dopbsp-info">'+DOPBSPFrontEnd.text(ID, 'calendar', 'addMonth')+'</span></a>');                        
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-remove-btn"><span class="dopbsp-info">'+DOPBSPFrontEnd.text(ID, 'calendar', 'removeMonth')+'</span></a>');
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-next-btn"><span class="dopbsp-info">'+DOPBSPFrontEnd.text(ID, 'calendar', 'nextMonth')+'</span></a>');
                HTML.push('        <a href="javascript:void(0)" class="dopbsp-previous-btn"><span class="dopbsp-info">'+DOPBSPFrontEnd.text(ID, 'calendar', 'previousMonth')+'</span></a>');
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
                HTML.push('    <div class="DOPBSPReservationsAdd-calendar"></div>');
                HTML.push('</div>');
                
                Container.html(HTML.join(''));
                $('#DOPBSP-column3 .dopbsp-column-content').html(methods_sidebar.display());
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
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).css('display', 'block');
                } 
                else{
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).css('display', 'none');
                }
                
                if (methods_months.vars.no === methods_months.vars.maxAllowed){
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-add-btn', Container).css('display', 'none');
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).addClass('dopbsp-no-add');
                } 
                else{
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-add-btn', Container).css('display', 'block');
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).removeClass('dopbsp-no-add');
                }

                /*
                 * Initialize previous button.
                 */
                if (year !== methods_calendar.vars.startYear 
                        || month !== methods_calendar.vars.startMonth){
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-previous-btn', Container).css('display', 'block');
                }   

                if (year === methods_calendar.vars.startYear 
                        && month === methods_calendar.vars.startMonth){
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-previous-btn', Container).css('display', 'none');
                }
                methods_day.vars.previousStatus = '';
                methods_day.vars.previousBind = 0;

                if (Container.width() <= 400){
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
                }
                else{
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
                }                        
                $('.DOPBSPReservationsAdd-calendar', Container).html('');

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
               
                methods_days.displaySelection();
                methods_day.events.init();
                
                if (methods_calendar.vars.firstYearLoaded){
                    methods_day.rp();                        
                }
                
                if (methods_hours.data['enabled']
                        && methods_days.vars.selectionStart !== ''){
                    methods_hours.display(methods_days.vars.selectionStart);
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

                    $('.DOPBSPReservationsAdd-container', Container).width(Container.width());
                
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

                    if ($('.DOPBSPReservationsAdd-navigation', Container).width() <= 400){
                        $('.DOPBSPReservationsAdd-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear()))
                                                                                            .addClass('dopbsp-style-small'); 
                    }
                    else{
                        $('.DOPBSPReservationsAdd-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear()))
                                                                                            .removeClass('dopbsp-style-small'); 
                    }

                    $('.DOPBSPReservationsAdd-navigation .dopbsp-week .dopbsp-day', Container).width(parseInt(($('.DOPBSPReservationsAdd-navigation .dopbsp-week', Container).width()-parseInt($('.DOPBSPReservationsAdd-navigation .dopbsp-week', Container).css('padding-left'))+parseInt($('.DOPBSPReservationsAdd-navigation .dopbsp-week', Container).css('padding-right')))/7));
                    no = DOT.methods.calendar_days.settings[ID]['first']-1;

                    $('.DOPBSPReservationsAdd-navigation .dopbsp-week .dopbsp-day', Container).each(function(){
                        no++;

                        if (no === 7){
                            no = 0;
                        }

                        if ($(this).width() <= 70){
                            $(this).html(DOPBSPFrontEnd.text(ID, 'days', 'shortNames')[no]);
                        }
                        else{
                            $(this).html(DOPBSPFrontEnd.text(ID, 'days', 'names')[no]);
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
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-previous-btn', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-previous-btn', Container).bind('click', function(){
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth-1);

                        if (methods_calendar.vars.currMonth === methods_calendar.vars.startMonth){
                            $('.DOPBSPReservationsAdd-navigation .dopbsp-previous-btn', Container).css('display', 'none');
                        }
                    });

                    /*
                     * Next button event.
                     */
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-next-btn', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-next-btn', Container).bind('click', function(){
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth+1);
                        $('.DOPBSPReservationsAdd-navigation .dopbsp-previous-btn', Container).css('display', 'block');
                    });

                    /*
                     * Add button event.
                     */
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-add-btn', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-add-btn', Container).bind('click', function(){
                        methods_months.vars.no++;
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth);
                                              
                        if (methods_months.vars.no >= methods_months.vars.maxAllowed){
                            $('.DOPBSPReservationsAdd-navigation .dopbsp-add-btn', Container).css('display', 'none');
                            $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).addClass('dopbsp-no-add');
                        }
                        $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).css('display', 'block');
                        
                        DOPPrototypes.scrollToY($('.DOPBSPReservationsAdd-calendar', Container).offset().top+$('.DOPBSPReservationsAdd-calendar', Container).height()-$(window).height()+10);
                    });

                    /*
                     * Remove button event.
                     */
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).bind('click', function(){
                        methods_months.vars.no--;
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth);

                        if (methods_months.vars.no < methods_months.vars.maxAllowed){
                            $('.DOPBSPReservationsAdd-navigation .dopbsp-add-btn', Container).css('display', 'block');
                            $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).removeClass('dopbsp-no-add');
                        }
                        
                        if(methods_months.vars.no === 1){
                            $('.DOPBSPReservationsAdd-navigation .dopbsp-remove-btn', Container).css('display', 'none');
                        }
                        
                        DOPPrototypes.scrollToY($('.DOPBSPReservationsAdd-calendar', Container).offset().top+$('.DOPBSPReservationsAdd-calendar', Container).height()-$(window).height()+10);
                    });
                }
            }
        },
                  
// 8. Months
        
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
                day = methods_day.default(),
                HTML = new Array(), 
                i, 
                prevDay,
                noDays = new Date(year, month, 0).getDate(),
                noDaysPrevMonth = new Date(year, month-1, 0).getDate(),
                firstDay = new Date(year, month-1, 2-DOT.methods.calendar_days.settings[ID]['first']).getDay(),
                lastDay = new Date(year, month-1, noDays-DOT.methods.calendar_days.settings[ID]['first']+1).getDay(),
                schedule = DOT.methods.calendar_schedule.data[ID],
                totalDays = 0;

                methods_days.vars.no = 0;

                if (position > 1){
                    HTML.push('<div class="DOPBSPReservationsAdd-month-year">'+DOPBSPFrontEnd.text(ID, 'months', 'names')[(month%12 !== 0 ? month%12:12)-1]+' '+year+'</div>');
                }
                HTML.push('<div class="DOPBSPReservationsAdd-month" id="DOPBSPReservationsAdd-month-'+ID+'-'+position+'">');

                /*
                 * Display previous month days.
                 */
                for (i=(firstDay === 0 ? 7:firstDay)-1; i>=1; i--){
                    totalDays++;

                    d = new Date(year, month-2, noDaysPrevMonth-i+1);
                    cyear = d.getFullYear();
                    cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                    cday = DOPPrototypes.getLeadingZero(d.getDate());
                    day = DOT.methods.calendar_day.get(ID,
						       cyear+'-'+cmonth+'-'+cday);

                    prevDay = DOPPrototypes.getPrevDay(cyear+'-'+cmonth+'-'+cday);
                    methods_day.vars.previousStatus = methods_day.vars.previousStatus === '' ? (schedule[prevDay] !== undefined ? schedule[prevDay]['status']:'none'):methods_day.vars.previousStatus;
                    methods_day.vars.previousBind = methods_day.vars.previousBind === 0 ? (schedule[prevDay] !== undefined ? schedule[prevDay]['group']:0):methods_day.vars.previousBind;

                    if (methods_calendar.vars.startMonth === month 
                            && methods_calendar.vars.startYear === year){
                        HTML.push(methods_day.display('dopbsp-past-day', 
                                                      ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate(), 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      'none'));            
                    }
                    else{
                        HTML.push(methods_day.display('dopbsp-last-month'+(position > 1 ?  ' dopbsp-mask':''), 
                                                      position > 1 ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_last':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate(), 
                                                      day['available'], 
                                                      day['bind'], 
                                                      day['info'], 
                                                      day['info_body'],
                                                      day['info_info'],
                                                      day['price'], 
                                                      day['promo'], 
                                                      day['status']));
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
                    day = DOT.methods.calendar_day.get(ID,
						       cyear+'-'+cmonth+'-'+cday);

                    if (methods_calendar.vars.startMonth === month 
                            && methods_calendar.vars.startYear === year
                            && methods_calendar.vars.startDay > d.getDate()){
                        HTML.push(methods_day.display('dopbsp-past-day', 
                                                      ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate(), 
                                                      '',
                                                      '', 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      '', 
                                                      'none'));    
                    }
                    else{
                        HTML.push(methods_day.display('dopbsp-curr-month', 
                                                      ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                      d.getDate(), 
                                                      day['available'], 
                                                      day['bind'], 
                                                      day['info'], 
                                                      day['info_body'],
                                                      day['info_info'],
                                                      day['price'], 
                                                      day['promo'], 
                                                      day['status']));
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
                    day = DOT.methods.calendar_day.get(ID,
						       cyear+'-'+cmonth+'-'+cday);

                    HTML.push(methods_day.display('dopbsp-next-month'+(position < methods_months.vars.no ?  ' dopbsp-hide':''), 
                                                  position < methods_months.vars.no ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                  d.getDate(), 
                                                  day['available'], 
                                                  day['bind'], 
                                                  day['info'], 
                                                  day['price'], 
                                                  day['promo'], 
                                                  day['status']));
                }
                HTML.push('</div>');
                HTML.push('<div class="DOPBSPReservationsAdd-hours" id="'+ID+'_'+year+'-'+DOPPrototypes.getLeadingZero(month)+'_hours"></div>');

                $('.DOPBSPReservationsAdd-calendar', Container).append(HTML.join(''));
            }
        },
 
// 9. Days
        
        methods_days = {
            vars: {selectionEnd: '',
                   selectionInit: false,
                   selectionStart: '',
                   no: 0},
            
            displaySelection:function(id){
            /*
             * Display selected days "selection".
             * 
             * @param id (String): current day ID (ID_YYYY-MM-DD) 
             */
                var $day,
                day,
                $nextDay = undefined, 
                $prevDay = undefined;
        
                id = id === undefined ? methods_days.vars.selectionEnd:id;

                methods_days.clearSelection();
                
                if (methods_days.vars.selectionStart !== ''){
                    if (id < methods_days.vars.selectionStart){
                        $($('.DOPBSPReservationsAdd-day', Container).get().reverse()).each(function(){
                            if ($(this).attr('id').split('_').length === 2){
                                $day = $(this);
                                day = this;

                                /*
                                 * Add selection if day is available.
                                 */
                                if ($day.attr('id') <= methods_days.vars.selectionStart
                                        && $day.attr('id') >= id
                                        && !$day.hasClass('dopbsp-mask') 
                                        && !$day.hasClass('dopbsp-past-day')){
                                    $day.addClass('dopbsp-selected');

                                    /*
                                     * Add selection if morning checkout option is enabled.
                                     */
                                    if (DOT.methods.calendar_days.settings[ID]['morningCheckOut']){
                                        if ($day.attr('id') === methods_days.vars.selectionStart){
                                            $day.addClass('dopbsp-last');
                                        }

                                        if ($day.attr('id') !== methods_days.vars.selectionStart){
                                            $day.addClass('dopbsp-first');

                                            if ($nextDay !== undefined){
                                                $nextDay.removeClass('dopbsp-first');
                                            }
                                            $nextDay = $day;
                                        }
                                    }
                                }
                            }
                        });
                    }
                    else{
                        $('.DOPBSPReservationsAdd-day', Container).each(function(){
                            if ($(this).attr('id').split('_').length === 2){
                                $day = $(this);  
                                day = this;

                                /*
                                 * Add selection if day is available.
                                 */
                                if ($day.attr('id') >= methods_days.vars.selectionStart
                                        && $day.attr('id') <= id
                                        && !$day.hasClass('dopbsp-mask') 
                                        && !$day.hasClass('dopbsp-past-day')){
                                    $day.addClass('dopbsp-selected');

                                    /*
                                     * Add selection if morning checkout option is enabled.
                                     */
                                    if (DOT.methods.calendar_days.settings[ID]['morningCheckOut']){
                                        if ($day.attr('id') === methods_days.vars.selectionStart){
                                            $day.addClass('dopbsp-first');
                                        }
                                                
                                        if ($day.attr('id') !== methods_days.vars.selectionStart){
                                            $day.addClass('dopbsp-last');
                                            
                                            if (methods_days.vars.selectionEnd !== ''
                                                    && $day.attr('id') < methods_days.vars.selectionEnd){
                                                $day.removeClass('dopbsp-last');
                                            }

                                            if ($prevDay !== undefined){
                                                $prevDay.removeClass('dopbsp-last');
                                            }
                                            $prevDay = $day;
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            },
            
            clearSelection:function(){
            /*
             * Clear days "selection".
             * 
             */    
                $('.DOPBSPReservationsAdd-day', Container).removeClass('dopbsp-selected')
                                                          .removeClass('dopbsp-first')
                                                          .removeClass('dopbsp-last'); 
            },
            
            getSelected:function(ciDay,
                                 coDay){
            /*
             * Get the list between 2 dates, included.
             * 
             * @param ciDay (String): check in day (YYYY-MM-DD)
             * @param coDay (String): check out day (YYYY-MM-DD)
             * 
             * @return array with selected days
             */
                var selectedDays = new Array(),
                y, 
                d, 
                m,
                ciy, 
                cim, 
                cid,
                coy, 
                com, 
                cod,
                firstMonth, 
                lastMonth, 
                firstDay, 
                lastDay,
                currYear, 
                currMonth, 
                currDay;

                /*
                 * Verify days.
                 */
                coDay = coDay === '' ? ciDay:coDay;

                ciy = parseInt(ciDay.split('-')[0], 10);
                cim = parseInt(ciDay.split('-')[1], 10);
                cid = parseInt(ciDay.split('-')[2], 10);
                coy = parseInt(coDay.split('-')[0], 10);
                com = parseInt(coDay.split('-')[1], 10);
                cod = parseInt(coDay.split('-')[2], 10);

                /*
                 * Generate all days between the dates.
                 */
                for (y=ciy; y<=coy; y++){
                    firstMonth = y === ciy ? cim:1;
                    lastMonth = y === coy ? com:12;

                    for (m=firstMonth; m<=lastMonth; m++){
                        firstDay = y === ciy && m === cim ? cid:1;
                        lastDay = y === coy && m === com ? cod:new Date(y,m,0).getDate();

                        for (d=firstDay; d<=lastDay; d++){
                            currYear = String(y);
                            currMonth = DOPPrototypes.getLeadingZero(m);
                            currDay = DOPPrototypes.getLeadingZero(d);

                            selectedDays.push(currYear+'-'+currMonth+'-'+currDay);
                        }
                    }
                }

                return selectedDays;
            },
            getAvailability:function(ciDay,
                                     coDay){
            /*
             * Get availability between 2 dates, included.
             * 
             * @param ciDay (String): check in day (YYYY-MM-DD)
             * @param coDay (String): check out day (YYYY-MM-DD)
             * 
             * @return true/false
             */
                var maxNoDays,
                minNoDays,
                noDays,
                schedule = DOT.methods.calendar_schedule.data[ID];

                /*
                 * Verify days.
                 */
                coDay = coDay === '' && !DOT.methods.calendar_days.settings[ID]['multipleSelect'] ? ciDay:coDay;
                
                if (methods_search.days.validate(ciDay) 
                        && methods_search.days.validate(coDay)){
                    /*
                     * Check if minimum/maximum number of days has been selected.
                     */
                    maxNoDays = DOPBSPFrontEndRules.getMaxTimeLapse(ID);
                    minNoDays = DOPBSPFrontEndRules.getMinTimeLapse(ID);
                    noDays = DOPPrototypes.getNoDays(ciDay, coDay)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 1:0);
                    
                    if (noDays < minNoDays){
                        DOPBSPBackEnd.toggleMessages('error',
                                                     DOPBSPFrontEnd.text(ID, 'rules', 'minTimeLapseDaysWarning').replace(/%d/gi, minNoDays));
			
                        return false;
                    }
                    
                    if (maxNoDays !== 0
                            && noDays > maxNoDays){
                        DOPBSPBackEnd.toggleMessages('error',
                                                     DOPBSPFrontEnd.text(ID, 'rules', 'maxTimeLapseDaysWarning').replace(/%d/gi, maxNoDays));
			
                        return false;
                    }
                    
                    /*
                     * Check if first and last day are not in the middle of a group.
                     */      
		    if(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] === true){
                        coDay= DOPPrototypes.getPrevDay(coDay);
                    }
		    
		    if (schedule[ciDay] !== undefined
				    && (schedule[ciDay]['bind'] === 2
					    || schedule[ciDay]['bind'] === 3)
			    || schedule[coDay] !== undefined
				    && (schedule[coDay]['bind'] === 1
					    || schedule[coDay]['bind'] === 2)){
			DOPBSPBackEnd.toggleMessages('error', 
						     DOPBSPFrontEnd.text(ID, 'search', 'noServicesSplitGroup'));
			
			return false;
		    }
		
		    /*
		     * Verify availability.
		     */
		    if (DOT.methods.calendar_availability.verify(ID, ciDay, coDay)){
			return true;
		    }
		    else{
			DOPBSPBackEnd.toggleMessages('error',
						     DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
			
			return false;
		    }
                }
                else{
		    return false;
                }
            },
            getNoAvailable:function(){
            /*
             * Get maximum number of available items for currently selected days.
             * 
             * @return number of available items
             */
                var ciDay,
                coDay,
                currDay,
                i,
                noAvailable = 1000000,
                schedule = DOT.methods.calendar_schedule.data[ID],
                selectedDays = new Array();

                /*
                 * Get days.
                 */
                if (DOT.methods.calendar_days.settings[ID]['multipleSelect']){
                    ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val();
                    coDay = $('#DOPBSPReservationsAdd-check-out'+ID).val();
                }
                else{                            
                    ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val();
                    coDay = $('#DOPBSPReservationsAdd-check-in'+ID).val();
                }

                if (methods_search.days.validate(ciDay) 
                        && methods_search.days.validate(coDay) 
                        && schedule !== {}){
                    /*
                     * Get selected days.
                     */
                    selectedDays = methods_days.getSelected(ciDay,
                                                            coDay);
                    
                    for (i=0; i<selectedDays.length-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 1:0); i++){
                        currDay = selectedDays[i];

                        if (schedule[currDay] === undefined || 
                                schedule[currDay]['available'] === ''){
                            
                            if(DOT.methods.calendar_schedule.default[ID] === undefined ||
                                DOT.methods.calendar_schedule.default[ID]['available'] === '') {
                                noAvailable = 1;
                            } 
                            else if (noAvailable > DOT.methods.calendar_schedule.default[ID]['available']){
                                noAvailable = DOT.methods.calendar_schedule.default[ID]['available'];
                            }
                        }
                        else if (noAvailable > schedule[currDay]['available']){
                            noAvailable = schedule[currDay]['available'];
                        }
                    }
                }
                
                return noAvailable === 0 || noAvailable === 1000000 ? 1:noAvailable;
            },
            getPrice:function(ciDay,
                              coDay){
            /*
             * Get the price between 2 dates, included.
             * 
             * @param ciDay (String): check in day (YYYY-MM-DD)
             * @param coDay (String): check out day (YYYY-MM-DD)
             * 
             * @return price value
             */
                var currDay,
                i,
                price,
                promo,
                schedule = DOT.methods.calendar_schedule.data[ID],
                selectedDays = new Array(),
                totalPrice = 0;
        
                /*
                 * Verify days.
                 */
                coDay = coDay === '' ? ciDay:coDay;

                /*
                 * Get selected days.
                 */
                selectedDays = methods_days.getSelected(ciDay,
                                                        coDay);

                for (i=0; i<selectedDays.length-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 1:0); i++){
                    currDay = selectedDays[i];

                    if (schedule[currDay] !== undefined 
                            && (schedule[currDay]['status'] === 'available' 
                                    || schedule[currDay]['status'] === 'special') 
                            && (schedule[currDay]['bind'] === 0
                                    || schedule[currDay]['bind'] === 1)){
                        price = parseFloat(schedule[currDay]['price']);
                        promo = parseFloat(schedule[currDay]['promo']);

                        if (price !== 0){
                            totalPrice += promo === 0 || isNaN(promo) ? price:promo;
                        }
                    } else {
                        
                        if((DOT.methods.calendar_schedule.default[ID]['status'] === 'available' 
                            || DOT.methods.calendar_schedule.default[ID]['status'] === 'special') 
                            && (DOT.methods.calendar_schedule.default[ID]['bind'] === 0
                            || DOT.methods.calendar_schedule.default[ID]['bind'] === 1)){
                            price = parseFloat(DOT.methods.calendar_schedule.default[ID]['price']);
                            promo = parseFloat(DOT.methods.calendar_schedule.default[ID]['promo']);

                            if (price !== 0){
                                totalPrice += promo === 0 || isNaN(promo) ? price:promo;
                            }
                        }
                    }
                }
                
                return totalPrice;
            },
            getHistory:function(ciDay,
                                coDay){
            /*
             * Get the history (current schedule) between 2 dates, included.
             * 
             * @param ciDay (String): check in day (YYYY-MM-DD)
             * @param coDay (String): check out day (YYYY-MM-DD)
             * 
             * @return curent schedule
             */
                var currDay,
                history = {},
                i, 
                selectedDays = new Array(),
                schedule = DOT.methods.calendar_schedule.data[ID];

                /*
                 * Verify days.
                 */
                coDay = coDay === '' ? ciDay:coDay;

                /*
                 * Get selected days.
                 */
                selectedDays = methods_days.getSelected(ciDay,
                                                        coDay);

                for (i=0; i<selectedDays.length-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 1:0); i++){
                    currDay = selectedDays[i];

                    history[currDay] = {"available": "",
                                        "bind": 0,
                                        "price": 0,
                                        "promo": 0,
                                        "status": ""};
                    history[currDay]['available'] = schedule[currDay] !== undefined ? schedule[currDay]['available']:DOT.methods.calendar_schedule.default[ID]['available'];
                    history[currDay]['bind'] = schedule[currDay] !== undefined ? schedule[currDay]['bind']:DOT.methods.calendar_schedule.default[ID]['bind'];
                    history[currDay]['price'] = schedule[currDay] !== undefined ? schedule[currDay]['price']:DOT.methods.calendar_schedule.default[ID]['price'];
                    history[currDay]['promo'] = schedule[currDay] !== undefined ? schedule[currDay]['promo']:DOT.methods.calendar_schedule.default[ID]['promo'];
                    history[currDay]['status'] = schedule[currDay] !== undefined ? schedule[currDay]['status']:DOT.methods.calendar_schedule.default[ID]['status'];
                }
                
                return history;
            }
        },
                
        methods_day = {
            vars: {displayedHours: false,
                   previousBind: 0,
                   previousStatus: ''},
    
            display:function(type,
                             id,
                             day,
                             available,
                             bind,
                             info,
                             infoBody, 
                             infoInfo, 
                             price,
                             promo,
                             status){
            /*
             * Display day.
             * 
             * @param type (String): day type (past-day, last-month, curr-month, next-month)
             * @param id (String): day ID (ID_YYYY-MM-DD)
             * @param day (String): current day
             * @param available (Number): number of available items for current day
             * @param bind (Number): day bind status
             *                       "0" none
             *                       "1" binded at the start of a group
             *                       "2" binded in a group group
             *                       "3" binded at the end of a group
             * @param info (String): day info
             * @param infoBody (String): day body info
             * @param infoInfo (String): day tooltip info
             * @param price (Number): day price
             * @param promo (Number): day promotional price
             * @param status (String): day status (available, booked, special, unavailable)
             * 
             * @retun day HTML
             */
                var dayHTML = Array(),
                contentLine1 = '&nbsp;', 
                contentLine2 = '&nbsp;';

                price = parseFloat(price);
                promo = parseFloat(promo);
                methods_days.vars.no++;
                
                if(methods_hours.data['interval_autobreak']) {
                    available = Math.floor(available/2);
                }

                if (price > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = DOPBSPFrontEnd.setPrice(ID, price);
                }

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = DOPBSPFrontEnd.setPrice(ID, promo);
                }

                if (type !== 'dopbsp-past-day'){
                    switch (status){
                        case 'available':
                            type += ' dopbsp-available';

                            if (bind === 0 
                                    || bind === 1 
                                    || methods_hours.data['enabled']){
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'availableMultiple')+'</span>';
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
                                }
                                else{
                                    contentLine2 = '<span class="dopbsp-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
                                }
                            }
                            break;
                        case 'booked':
                            type += ' dopbsp-booked';
                            contentLine2 = '<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'booked')+'</span>';                                    
                            break;
                        case 'special':
                            type += ' dopbsp-special';

                            if (bind === 0 
                                    || bind === 1 
                                    || methods_hours.data['enabled']){
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'availableMultiple')+'</span>';
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
                                }
                                else{
                                    contentLine2 = '<span class="dopbsp-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
                                }
                            }
                            break;
                        case 'unavailable':
                            type += ' dopbsp-unavailable';
                            contentLine2 = '<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'unavailable')+'</span>';
                            break;
                    }
                    
                    /*
                     * Add pointer cursor.
                     */
                    if (type.indexOf('mask') !== -1){
                    /*
                     * No pointer cursor.
                     */
                        type += ' dopbsp-no-cursor-pointer';
                    }
                    else{
                        if (methods_hours.data['enabled']
                                || (!DOT.methods.calendar_days.settings[ID]['morningCheckOut']
                                        && (status === 'available'
                                                || status === 'special'))){
                            type += ' dopbsp-cursor-pointer';
                        }
                    }
                }

                if (methods_days.vars.no % 7 === 1){
                    type += ' dopbsp-first-column';
                }

                if (methods_days.vars.no % 7 === 0){
                    type += ' dopbsp-last-column';
                }

                dayHTML.push('<div class="DOPBSPReservationsAdd-day '+type+'" id="'+id+'">');
                dayHTML.push('  <div class="dopbsp-bind-left'+((bind === 2 || bind === 3) && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-enabled':'')+(methods_day.vars.previousBind === 3 && DOT.methods.calendar_days.settings[ID]['morningCheckOut'] && (methods_day.vars.previousStatus === 'available' || methods_day.vars.previousStatus === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended dopbsp-'+methods_day.vars.previousStatus:'')+'">');
                dayHTML.push('      <div class="dopbsp-head">&nbsp;</div>');
                dayHTML.push('      <div class="dopbsp-body">&nbsp;</div>');
                dayHTML.push('  </div>');                        
                dayHTML.push('  <div class="dopbsp-bind-middle dopbsp-group'+((status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? bind:'0')+(bind === 3 && DOT.methods.calendar_days.settings[ID]['morningCheckOut'] && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended':'')+(methods_day.vars.previousBind === 3 && DOT.methods.calendar_days.settings[ID]['morningCheckOut'] && (methods_day.vars.previousStatus === 'available' || methods_day.vars.previousStatus === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended':'')+'">');
                dayHTML.push('      <div class="dopbsp-head">');
                dayHTML.push('          <div class="dopbsp-co dopbsp-'+(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? methods_day.vars.previousStatus:status)+'"></div>');
                dayHTML.push('          <div class="dopbsp-ci dopbsp-'+status+'"></div>');
                dayHTML.push('          <div class="dopbsp-day">'+day+'</div>');

                if ((info !== ''
                                || (infoInfo !== undefined
                                            && infoInfo.length > 0))
                        && type.indexOf('past-day') === -1){
                    switch (status){
                        case 'available':
                            if (bind === 0 
                                    || bind === 3 
                                    || methods_hours.data['enabled']){
                                dayHTML.push('          <div class="dopbsp-info" id="'+id+'_info"></div>');
                            }
                            break;
                        case 'booked':
                            dayHTML.push('          <div class="dopbsp-info" id="'+id+'_info"></div>');                                   
                            break;
                        case 'special':
                            if (bind === 0 
                                    || bind === 3 
                                    || methods_hours.data['enabled']){
                                dayHTML.push('          <div class="dopbsp-info" id="'+id+'_info"></div>');
                            }
                            break;
                        case 'unavailable':
                            dayHTML.push('          <div class="dopbsp-info" id="'+id+'_info"></div>');
                            break;
                        default:
                            dayHTML.push('          <div class="dopbsp-info" id="'+id+'_info"></div>');
                    }
                }
                dayHTML.push('      </div>');
                dayHTML.push('      <div class="dopbsp-body">');
                dayHTML.push('          <div class="dopbsp-co dopbsp-'+(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? methods_day.vars.previousStatus:status)+'"></div>');
                dayHTML.push('          <div class="dopbsp-ci dopbsp-'+status+'"></div>');
                dayHTML.push('          <div class="dopbsp-price">'+contentLine1+'</div>');

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    dayHTML.push('          <div class="dopbsp-old-price">'+DOPBSPFrontEnd.setPrice(ID, price)+'</div>');
                }
                dayHTML.push('          <br class="DOPBSPReservationsAdd-clear" />');
                dayHTML.push('          <div class="dopbsp-available">'+contentLine2+'</div>');
                
                if ((infoBody !== undefined
                                && infoBody.length > 0)
                        && type.indexOf('past-day') === -1){
                    dayHTML.push('          <div class="dopbsp-info-body" id="'+id+'_info-body">');
                    dayHTML.push('              <div class="dopbsp-info-body-mask">&#8594;</div>');
                    dayHTML.push(methods_form.getInfo(infoBody));
                    dayHTML.push('          </div>');
                }
                
                dayHTML.push('      </div>');  
                dayHTML.push('  </div>');
                dayHTML.push('  <div class="dopbsp-bind-right'+((bind === 1 || bind === 2) && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-enabled':'')+(bind === 3 && DOT.methods.calendar_days.settings[ID]['morningCheckOut'] && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended':'')+'">');
                dayHTML.push('      <div class="dopbsp-head">&nbsp;</div>');
                dayHTML.push('      <div class="dopbsp-body">&nbsp;</div>');
                dayHTML.push('  </div>');
                dayHTML.push('</div>');

                if (type !== 'dopbsp-past-day'){
                    methods_day.vars.previousStatus = status;
                    methods_day.vars.previousBind = bind;
                }
                else{
                    methods_day.vars.previousStatus = 'none';
                    methods_day.vars.previousBind = 0;
                }

                return dayHTML.join('');
            },                    
            default:function(day){
            /*
             * Day default data.
             * 
             * @param day (Date): this day
             * 
             * @return JSON with default data
             */    
                return {"available": DOT.methods.calendar_schedule.default[ID]['available'],
                        "bind": 0,
                        "hours_definitions":  DOT.methods.calendar_schedule.default[ID]['hours_definitions'],
                        "hours":  DOT.methods.calendar_schedule.default[ID]['hours'],
                        "info":  DOT.methods.calendar_schedule.default[ID]['info'],
                        "info_body": "",
                        "info_info": "",
                        "notes":  DOT.methods.calendar_schedule.default[ID]['notes'],
                        "price":  DOT.methods.calendar_schedule.default[ID]['price'], 
                        "promo":  DOT.methods.calendar_schedule.default[ID]['promo'],
                        "status":  DOT.methods.calendar_schedule.default[ID]['status']};
            },
            rp:function(){
            /*
             *  Resize & position calendar day. Used for responsive feature.
             */  
                var $day = $('.DOPBSPReservationsAdd-day', Container),
                $dayBody = $('.DOPBSPReservationsAdd-day .dopbsp-body', Container),
                $month = $('#DOPBSPReservationsAdd-month-'+ID+'-1'),        
                dayWidth = 0,
                maxHeight = 0,
                hiddenBustedItems = DOPPrototypes.doHiddenBuster($(Container));
        
                dayWidth = parseInt(($month.width()-parseInt($month.css('padding-left'))+parseInt($month.css('padding-right')))/7);
        
                $dayBody.removeAttr('style');
                $day.width(dayWidth);
                $day.find($('.dopbsp-bind-middle')).width(dayWidth-2);

                /*
                 * If day width smaller than 70px available, booked, unavailable text is hidden.
                 */
                if (dayWidth <= 70){
                    $day.find($('.dopbsp-no-available-text')).css('display', 'none');
                }
                else{
                    $day.find($('.dopbsp-no-available-text')).css('display', 'inline');
                }

                /*
                 * If day width smaller than 40px only day header with day number is visible.
                 */
                if (dayWidth <= 40){
                    $day.addClass('dopbsp-style-small');
                }
                else{
                    $day.removeClass('dopbsp-style-small');

                    /*
                     * Set days height to the biggest height found.
                     */
                    $('.DOPBSPReservationsAdd-day .dopbsp-bind-middle .dopbsp-body', Container).each(function(){
                        if (maxHeight < $(this).height()){
                            maxHeight = $(this).height();
                        }
                    });

                    $dayBody.height(maxHeight);
                }

                DOPPrototypes.undoHiddenBuster(hiddenBustedItems);
            },
            
            events: {
                init:function(){
                /*
                 * Initialize days events.
                 */
                    if (!methods_calendar.data['view']){
                        if (methods_hours.data['enabled']){
                            methods_day.events.selectHours();
                        }
                        else{
                            if (DOT.methods.calendar_days.settings[ID]['multipleSelect']){
                                methods_day.events.selectMultiple();
                            }
                            else{
                                methods_day.events.selectSingle();
                            }
                        }
                    }
                    else{
                        $('.DOPBSPReservationsAdd-day .dopbsp-co', Container).css('cursor', 'default');
                        $('.DOPBSPReservationsAdd-day .dopbsp-ci', Container).css('cursor', 'default');
                    }

                    if (!DOPPrototypes.isTouchDevice()){
                        if (!methods_calendar.data['view']){
                            /*
                             * Days hover events, not available for devices with touchscreen.
                             */
                            $('.DOPBSPReservationsAdd-day', Container).hover(function(){
                                var day = $(this);

                                if (methods_days.vars.selectionInit){
                                    methods_days.displaySelection(day.attr('id'));
                                }

                                if (methods_hours.data['enabled'] 
                                        && methods_hours.data['info'] 
                                        && !day.hasClass('dopbsp-past-day')
                                        && !day.hasClass('dopbsp-selected') 
                                        && !day.hasClass('dopbsp-mask')){
                                    methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                        '', 
                                                        'hours', 
                                                        methods_hours.displayInfo(day.attr('id')));
                                }
                            }, function(){
                                methods_tooltip.clear();
                            });
                        }

                        /*
                         * Info icon events.
                         */
                        $('.DOPBSPReservationsAdd-day .dopbsp-info', Container).hover(function(){
                            methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                '', 
                                                'info');
                        }, function(){
                            methods_tooltip.clear();
                        });

                        /*
                         * Body info events.
                         */
                        $('.DOPBSPReservationsAdd-day .dopbsp-info-body', Container).hover(function(){
                            methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                '', 
                                                'info-body');
                        }, function(){
                            methods_tooltip.clear();
                        });
                    }
                    else{
                        var xPos = 0, 
                        yPos = 0, 
                        touch;

                        /*
                         * Info icon events on devices with touchscreen.
                         */
                        $('.DOPBSPReservationsAdd-day .dopbsp-info', Container).unbind('touchstart');
                        $('.DOPBSPReservationsAdd-day .dopbsp-info', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPReservationsAdd-tooltip'+ID).css({'left': xPos,
                                                                        'top': yPos});
                            methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                '', 
                                                'info');
                        });

                        /*
                         * Body info events on devices with touchscreen.
                         */
                        $('.DOPBSPReservationsAdd-day .dopbsp-info-body', Container).unbind('touchstart');
                        $('.DOPBSPReservationsAdd-day .dopbsp-info-body', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPReservationsAdd-tooltip'+ID).css({'left': xPos,
                                                                        'top': yPos});
                            methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                '', 
                                                'info-body');
                        });
                    }
                },
                selectHours:function(){
                /*
                 * Select hours event.
                 */    
                    /*
                     * Days click event.
                     */
                    $('.DOPBSPReservationsAdd-day', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-day', Container).bind('click', function(){
                        var day = $(this);
                        
                        if (!day.hasClass('dopbsp-mask') 
                                && !day.hasClass('dopbsp-past-day')){
                            methods_hours.display(day.attr('id'));
                        }
                    });
                },
                selectMultiple:function(){
                /*
                 * Select multipe days events.
                 */    
                    /*
                     * Days click event.
                     */
                    $('.DOPBSPReservationsAdd-day', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-day', Container).bind('click', function(){
                        var auxDate,
                        $day = $(this),
                        eDate, 
                        eDay,
                        eMonth, 
                        eYear, 
                        minDateValue = 0,
                        sDate, 
                        sDay,
                        sMonth, 
                        sYear;

                        /*
                         * Add a small delay of 10 miliseconds for hover selection to display properly.
                         */
                        setTimeout(function(){
                            if (!$day.hasClass('dopbsp-mask') 
                                    && !$day.hasClass('dopbsp-past-day')){
                                if (!methods_days.vars.selectionInit){
                                /*
                                 * Select first day.
                                 */                                                       
                                    methods_days.vars.selectionInit = true;
                                    methods_days.vars.selectionStart = $day.attr('id');
                                    methods_days.vars.selectionEnd = '';

                                    /*
                                     * Reinitialize datepickers.
                                     */
                                    sDate = methods_days.vars.selectionStart.split('_')[1];
                                    sYear = sDate.split('-')[0];
                                    sMonth = parseInt(sDate.split('-')[1], 10)-1;
                                    sDay = sDate.split('-')[2];
                                    minDateValue = DOPPrototypes.getNoDays(DOPPrototypes.getToday(), sDate)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 0:1);

                                    $('#DOPBSPReservationsAdd-check-in'+ID).val(sDate);
                                    $('#DOPBSPReservationsAdd-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                        DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sDay+', '+sYear:
                                                                                        sDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sYear);
                                    $('#DOPBSPReservationsAdd-check-out'+ID).val('');
                                    $('#DOPBSPReservationsAdd-check-out-view'+ID).val(DOPBSPFrontEnd.text(ID, 'search', 'checkOut'))
                                                                                 .removeAttr('disabled');;

                                    methods_search.days.initDatepicker('#DOPBSPReservationsAdd-check-out-view'+ID,
                                                                       '#DOPBSPReservationsAdd-check-out'+ID,
                                                                       minDateValue);

                                    methods_days.displaySelection(methods_days.vars.selectionStart);
                                }
                                else if (!DOT.methods.calendar_days.settings[ID]['morningCheckOut'] 
                                            || (DOT.methods.calendar_days.settings[ID]['morningCheckOut'] 
                                                        && methods_days.vars.selectionStart !== $day.attr('id'))){
                                /*
                                 * Select second day.
                                 */
                                    methods_days.vars.selectionInit = false;
                                    methods_days.vars.selectionEnd = $day.attr('id');
                                    $('#DOPBSPReservationsAdd-check-out-view'+ID).removeAttr('disabled');

                                    if (methods_days.vars.selectionStart > methods_days.vars.selectionEnd){
                                        auxDate = methods_days.vars.selectionStart;
                                        methods_days.vars.selectionStart = methods_days.vars.selectionEnd;
                                        methods_days.vars.selectionEnd = auxDate;
                                    }

                                    /*
                                     * Reinitialize datepickers.
                                     */
                                    sDate = methods_days.vars.selectionStart.split('_')[1];
                                    sYear = sDate.split('-')[0];
                                    sMonth = parseInt(sDate.split('-')[1], 10)-1;
                                    sDay = sDate.split('-')[2];
                                    eDate = methods_days.vars.selectionEnd.split('_')[1];
                                    eYear = eDate.split('-')[0];
                                    eMonth = parseInt(eDate.split('-')[1], 10)-1;
                                    eDay = eDate.split('-')[2];
                                    minDateValue = DOPPrototypes.getNoDays(DOPPrototypes.getToday(), sDate)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 0:1);

                                    $('#DOPBSPReservationsAdd-check-in'+ID).val(sDate);
                                    $('#DOPBSPReservationsAdd-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                        DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sDay+', '+sYear:
                                                                                        sDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sYear);
                                    $('#DOPBSPReservationsAdd-check-out'+ID).val(eDate);
                                    $('#DOPBSPReservationsAdd-check-out-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                        DOPBSPFrontEnd.text(ID, 'months', 'names')[eMonth]+' '+eDay+', '+eYear:
                                                                                        eDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[eMonth]+' '+eYear);
                                    methods_search.days.initDatepicker('#DOPBSPReservationsAdd-check-out-view'+ID,
                                                                       '#DOPBSPReservationsAdd-check-out'+ID,
                                                                       minDateValue);
                                    methods_days.displaySelection(methods_days.vars.selectionEnd);
                                    methods_search.set();
                                }
                            }
                        }, 10);
                    });
                },
                selectSingle:function(){
                /*
                 * Select single day event.
                 */    
                    /*
                     * Days click event.
                     */
                    $('.DOPBSPReservationsAdd-day', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-day', Container).bind('click', function(){
                        var day = $(this),
                        dayThis = this,
                        sDate, 
                        sDay,
                        sMonth, 
                        sYear;

                        /*
                         * Add a small delay of 10 miliseconds for hover selection to display properly.
                         */
                        setTimeout(function(){
                            /*
                             * Check if the day has availability set.
                             */
                            if ((day.hasClass('dopbsp-available') 
                                        || day.hasClass('dopbsp-special')) 
                                    && $('.dopbsp-bind-middle', dayThis).hasClass('dopbsp-group0')){
                            /*
                             * Select one day.
                             */    
                                methods_days.vars.selectionInit = false;
                                methods_days.vars.selectionStart = day.attr('id');
                                methods_days.vars.selectionEnd = day.attr('id');

                                sDate = methods_days.vars.selectionStart.split('_')[1];
                                sYear = sDate.split('-')[0];
                                sMonth = parseInt(sDate.split('-')[1], 10)-1;
                                sDay = sDate.split('-')[2];

                                $('#DOPBSPReservationsAdd-check-in'+ID).val(sDate);
                                $('#DOPBSPReservationsAdd-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                    DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sDay+', '+sYear:
                                                                                    sDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sYear);

                                methods_days.displaySelection(methods_days.vars.selectionEnd);
                                methods_search.set();
                            }
                        }, 10);
                    });
                }
            }
        },

// 10. Hours
         
        methods_hours = {
            data: {},
            text: {},
            vars: {selectionEnd: '',
                   selectionInit: false,
                   selectionStart: ''},
            
            display:function(id){
            /*
             * Display hours.
             * 
             * @param id (String): day ID (ID_YYYY-MM-DD)
             */
                var currHour = methods_calendar.vars.startDate.getHours(),
                currMin = methods_calendar.vars.startDate.getMinutes(),
                hour,
                hoursContainer,
                hoursDef = methods_hours.data['definitions'], 
                HTML = new Array(), 
                i,
                date = id.split('_')[1],
                year = date.split('-')[0],
                month = date.split('-')[1],
                day = date.split('-')[2];

                methods_days.vars.selectionInit = false;
                methods_days.vars.selectionStart = id;
                methods_days.vars.selectionEnd = id;
                methods_day.vars.displayedHours = true;
                methods_hours.vars.selectionInit = false;
                methods_hours.vars.selectionStart = '';
                methods_hours.vars.selectionEnd = '';

                $('#DOPBSPReservationsAdd-check-in'+ID).val(date);
                $('#DOPBSPReservationsAdd-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? DOPBSPFrontEnd.text(ID, 'months', 'names')[parseInt(month, 10)-1]+' '+day+', '+year:
                                                                                                           day+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[parseInt(month, 10)-1]+' '+year);
                
                /*
                 * Select day even if status is not available or special.
                 */
                methods_days.displaySelection(methods_days.vars.selectionEnd);
                $('#'+methods_days.vars.selectionStart).addClass('dopbsp-selected');
                methods_search.set();
                
                /*
                 * Generate hours list.
                 */
                if (DOT.methods.calendar_schedule.data[ID][date] !== undefined){
                    hoursDef = DOT.methods.calendar_schedule.data[ID][date]['hours_definitions'];
                } else if(DOT.methods.calendar_schedule.default[ID] !== undefined){
                    hoursDef = DOT.methods.calendar_schedule.default[ID]['hours_definitions'];
                }                         

                for (i=0; i<hoursDef.length-(methods_hours.data['interval'] ? 1:0); i++){
                    if (DOT.methods.calendar_schedule.data[ID][date] !== undefined 
                            && DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']] !== undefined){
                        hour = DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']];
                    }
                    else{
                        hour = methods_hour.default(hoursDef[i]['value']);
                    }
                    
                    if(methods_hours.data['interval_autobreak']) {
                        
                        if(i%2 === 0) {
                            HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                           hoursDef[i]['value'],
                                                           hour['available'], 
                                                           hour['bind'], 
                                                           hour['info'], 
                                                           hour['info_body'],
                                                           hour['info_info'],
                                                           hour['price'], 
                                                           hour['promo'],
                                                           hoursDef[i]['value'] < DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                                                && methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) === year+'-'+month+'-'+day 
                                                                ? 'past-hour':hour['status'], 
                                                           hoursDef));
                        }
                    } else {
                        HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                       hoursDef[i]['value'],
                                                       hour['available'], 
                                                       hour['bind'], 
                                                       hour['info'], 
                                                       hour['info_body'],
                                                       hour['info_info'],
                                                       hour['price'], 
                                                       hour['promo'],
                                                       hoursDef[i]['value'] < DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                                            && methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) === year+'-'+month+'-'+day 
                                                            ? 'past-hour':hour['status'], 
                                                       hoursDef));
                    }
                }                   

                $('.DOPBSPReservationsAdd-hours', Container).css('display', 'none')
                                                            .html('');

                /*
                 * Check for correct hours container when more months are displayed
                 */                                     
                if ($('#'+id).hasClass('dopbsp-next-month')){  
                    $('.DOPBSPReservationsAdd-hours', Container).each(function(){
                        hoursContainer = $(this);
                    });
                    hoursContainer.css('display', 'block')
                                  .html(HTML.join(''));
                }
                else if ($('#'+id).hasClass('dopbsp-last-month')){
                    $($('.DOPBSPReservationsAdd-hours', Container).get().reverse()).each(function(){
                        hoursContainer = $(this);
                    });
                    hoursContainer.css('display', 'block')
                                  .html(HTML.join(''));
                }
                else{
                    $('#'+ID+'_'+year+'-'+month+'_hours').css('display', 'block')
                                                         .html(HTML.join(''));
                }
                
                /*
                 * Init hours events & sidebar.
                 */
                methods_hour.events.init();
                methods_search.hours.set();
            },
            displayInfo:function(id){
            /*
             * Display hours info.
             * 
             * @param id (String): day ID (ID_YYYY-MM-DD)
             */    
                var currHour = methods_calendar.vars.startDate.getHours(),
                currMin = methods_calendar.vars.startDate.getMinutes(),
                hour, 
                hoursDef = methods_hours.data['definitions'],
                HTML = new Array(),
                i,
                date = id.split('_')[1],
                year = date.split('-')[0],
                month = date.split('-')[1],
                day = date.split('-')[2];

                /*
                 * Generate hours list.
                 */
                if (DOT.methods.calendar_schedule.data[ID][date] !== undefined){
                    hoursDef = DOT.methods.calendar_schedule.data[ID][date]['hours_definitions'];
                }   
                
                for (i=0; i<hoursDef.length-(methods_hours.data['interval'] ? 1:0); i++){
                    if (DOT.methods.calendar_schedule.data[ID][date] !== undefined 
                            && DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']] !== undefined){
                        hour = DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']];
                    }
                    else{
                        hour = methods_hour.default(hoursDef[i]['value']);
                    }

                    if(methods_hours.data['interval_autobreak']) {
                        
                        if(i%2 === 0) {
                            HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                           hoursDef[i]['value'],
                                                           hour['available'],
                                                           hour['bind'], 
                                                           '',
                                                           hour['info_body'],
                                                           '',
                                                           hour['price'], 
                                                           hour['promo'], 
                                                           hoursDef[i]['value'] < DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                                                && methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) === year+'-'+month+'-'+day 
                                                                ? 'past-hour':hour['status'], 
                                                           hoursDef));
                        } 
                    } else {
                        HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                       hoursDef[i]['value'],
                                                       hour['available'],
                                                       hour['bind'], 
                                                       '',
                                                       hour['info_body'],
                                                       '',
                                                       hour['price'], 
                                                       hour['promo'], 
                                                       hoursDef[i]['value'] < DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                                            && methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) === year+'-'+month+'-'+day 
                                                            ? 'past-hour':hour['status'], 
                                                       hoursDef));
                    }
                }   

                return HTML.join('');
            },
            displaySelection:function(id){
            /*
             * Display selected hours "selection".
             * 
             * @param id (String): day ID (ID_YYYY-MM-DD)
             */    
                var hour;

                id = id === undefined ? methods_hours.vars.selectionEnd:id;
                
                $('.DOPBSPReservationsAdd-hour', Container).removeClass('dopbsp-selected');

                if (id < methods_hours.vars.selectionStart){
                    $($('.DOPBSPReservationsAdd-hour', Container).get().reverse()).each(function(){
                        hour = $(this);

                        if (hour.attr('id') >= id 
                                && hour.attr('id') <= methods_hours.vars.selectionStart
                                && !hour.hasClass('dopbsp-past-hour')){
                            hour.addClass('dopbsp-selected');
                        }
                    });
                }
                else{
                    $('.DOPBSPReservationsAdd-hour', Container).each(function(){
                        hour = $(this);   

                        if (hour.attr('id') >= methods_hours.vars.selectionStart 
                                && hour.attr('id') <= id
                                && !hour.hasClass('dopbsp-past-hour')){
                            hour.addClass('dopbsp-selected');
                        }
                    });
                }       

                $('.DOPBSPReservationsAdd-hour.selected .dopbsp-bind-middle', Container).removeAttr('style');  
                $('.DOPBSPReservationsAdd-hour.selected .dopbsp-bind-middle .dopbsp-hour', Container).removeAttr('style');         
            },
            
            clear:function(){
            /*
             * Clear selected hours, including selected day.
             */    
                methods_days.vars.selectionInit = false;
                methods_days.vars.selectionStart = '';
                methods_days.vars.selectionEnd = '';
                methods_day.vars.displayedHours = '';
                methods_hours.vars.selectionInit = false;
                methods_hours.vars.selectionStart = '';
                methods_hours.vars.selectionEnd = '';
                
                methods_days.clearSelection();
                $('.DOPBSPReservationsAdd-hours', Container).css('display', 'none')
                                                            .html('');
                methods_search.set();
            },
            
            getSelected:function(day,
                                 startHour,
                                 endHour){
            /*
             * Get the list between 2 hours, included.
             * 
             * @param day (String): check in day (YYYY-MM-DD)
             * @param startHour (String): start hour (HH-MM)
             * @param endHour (String): end hour (HH-MM)
             * 
             * @return array with selected hours
             */
                var schedule = DOT.methods.calendar_schedule.data[ID],
                selectedHours = new Array(),
                hours_definitions = schedule[day] !== undefined ? (schedule[day]['hours_definitions'] !== undefined ? schedule[day]['hours_definitions']:DOT.methods.calendar_schedule.default[ID]['hours_definitions']):DOT.methods.calendar_schedule.default[ID]['hours_definitions'];
        
                /*
                 * Verify hours.
                 */
                endHour = endHour === '' ? startHour:endHour;

                $.each(hours_definitions, function(index){
                    if (startHour <= hours_definitions[index]['value'] 
                            && hours_definitions[index]['value'] <= endHour){
                        selectedHours.push(hours_definitions[index]['value']);
                    }
                });
                
                return selectedHours;
            },
            getAvailability:function(day,
                                     startHour,
                                     endHour){
            /*
             * Get availability between 2 hours, included.
             * 
             * @param day (String): check in day (YYYY-MM-DD)
             * @param startHour (String): start hour (HH-MM)
             * @param endHour (String): end hour (HH-MM)
             * 
             * @return true/false
             */
                var maxNoMinutes,
                minNoMinutes,
                noMinutes,
                lastHour,
                hours_definitions,
                schedule = DOT.methods.calendar_schedule.data[ID];
        
                hours_definitions = schedule[day] !== undefined ? (schedule[day]['hours_definitions'] !== undefined ? schedule[day]['hours_definitions']:DOT.methods.calendar_schedule.default[ID]['hours_definitions']):DOT.methods.calendar_schedule.default[ID]['hours_definitions'];

                /*
                 * Verify hours.
                 */
                endHour = endHour === '' && !methods_hours.data['multipleSelect'] ? startHour:endHour;
                
                if (methods_search.days.validate(day) 
                        && startHour !== '' 
                        && endHour !== ''){
                    /*
                     * Check if minimum/maximum number of hours has been selected.
                     */
                    maxNoMinutes = DOPBSPFrontEndRules.getMaxTimeLapse(ID)*60;
                    minNoMinutes = DOPBSPFrontEndRules.getMinTimeLapse(ID)*60;
                    noMinutes = DOPPrototypes.getHoursDifference(startHour, endHour, 'minutes');
                    
                    if (noMinutes < minNoMinutes){
                        DOPBSPBackEnd.toggleMessages('error',
                                                     DOPBSPFrontEnd.text(ID, 'rules', 'minTimeLapseHoursWarning').replace(/%d/gi, minNoMinutes/60));
                        return false;
                    }
                    
                    if (maxNoMinutes !== 0
                            && noMinutes > maxNoMinutes){
                        DOPBSPBackEnd.toggleMessages('error',
                                                     DOPBSPFrontEnd.text(ID, 'rules', 'maxTimeLapseHoursWarning').replace(/%d/gi, maxNoMinutes/60));
                        return false;
                    }
                    
                    /*
                     * Check if first and last hour are not in the middle of a group.
                     */ 
                    lastHour = schedule[day] === undefined ? endHour:methods_hour.getPrev(endHour, hours_definitions); //// endHour has bind=0 when using hour intervals(it's the start of the next interval) so we verify the one before it

                    if (schedule[day] !== undefined && methods_hours.data['multipleSelect']
				&& ((schedule[day]['hours'][startHour]['bind'] === 2 
					|| schedule[day]['hours'][startHour]['bind'] === 3)
				|| (schedule[day]['hours'][methods_hours.data['interval'] === true ? lastHour:endHour]['bind'] === 1 
					|| schedule[day]['hours'][methods_hours.data['interval'] === true ? lastHour:endHour]['bind'] === 2))){
                        DOPBSPBackEnd.toggleMessages('error',
                                                     DOPBSPFrontEnd.text(ID, 'search', 'noServicesSplitGroup'));
			
                        return false;
                    }

                    /*
                     * Check if selected hours are available.
                     */	
                    endHour = methods_hours.data['interval'] ? endHour : methods_hour.getNext(endHour,hours_definitions);  //acts like an hour interval when intervals are not enabled for verification purposes

		    if (DOT.methods.calendar_availability.verify(ID, day, day, startHour, endHour)){
			return true;
		    }
		    else{
			DOPBSPBackEnd.toggleMessages('error', 
						     DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
			return false;
		    }
                }
                else{
		    return false;
                }
            },
            getNoAvailable:function(){
            /*
             * Get maximum number of available items for currently selected hours.
             * 
             * @return number of available items
             */
                var currHour,
                day,  
                endHour,
                i,
                noAvailable = 1000000,
                schedule = DOT.methods.calendar_schedule.data[ID],
                selectedHours = new Array(),
                startHour;
                
                /*
                 * Verify day.
                 */
                day = $('#DOPBSPReservationsAdd-check-in'+ID).val();
                
                /*
                 * Verify hours.
                 */
                if (methods_hours.data['multipleSelect']){
                    startHour = $('#DOPBSPReservationsAdd-start-hour'+ID).val();
                    endHour = $('#DOPBSPReservationsAdd-end-hour'+ID).val();
                }
                else{                            
                    startHour = $('#DOPBSPReservationsAdd-start-hour'+ID).val();
                    endHour = $('#DOPBSPReservationsAdd-start-hour'+ID).val();
                }

                if (methods_search.days.validate(day) 
                        && startHour !== '' 
                        && endHour !== '' 
                        && ((schedule !== {}
                             && schedule[day] !== undefined)
                           || (DOT.methods.calendar_schedule.default[ID] !== {}
                             && DOT.methods.calendar_schedule.default[ID] !== undefined))){
                    selectedHours = methods_hours.getSelected(day,
                                                              startHour,
                                                              endHour);
                    
                    for (i=0; i<selectedHours.length-((!methods_hours.data['addLastHourToTotalPrice'] || methods_hours.data['interval']) && methods_hours.data['multipleSelect'] ? 1:0); i++){
                        currHour = selectedHours[i];  
                                        
                        if (schedule[day] !== undefined
                            && schedule[day]['hours'][currHour] !== undefined 
                                && (schedule[day]['hours'][currHour]['status'] === 'available' 
                                        || schedule[day]['hours'][currHour]['status'] === 'special')
                           || (DOT.methods.calendar_schedule.default[ID]['hours'][currHour] !== undefined 
                                && (DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status'] === 'available' 
                                        || DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status'] === 'special'))){
                            
                            if (schedule[day] !== undefined
                                && schedule[day]['hours'][currHour]['available'] === ''){
                                
                                if(DOT.methods.calendar_schedule.default[ID] === undefined
                                  || DOT.methods.calendar_schedule.default[ID]['hours'][currHour] === undefined) {
                                    noAvailable = 1;
                                } else {
                                    noAvailable = DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['available'];
                                }
                            } 
                            else if (schedule[day] !== undefined 
                                     && parseInt(schedule[day]['hours'][currHour]['available'], 10) < noAvailable){
                                noAvailable = parseInt(schedule[day]['hours'][currHour]['available'], 10);
                            }
                            
                            if (schedule[day] === undefined){
                                
                                if(DOT.methods.calendar_schedule.default[ID]['hours'][currHour] !== undefined
                                    && DOT.methods.calendar_schedule.default[ID] !== undefined) {
                                    
                                    if(DOT.methods.calendar_schedule.default[ID]['hours'][currHour] !== undefined) {
                                        noAvailable = DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['available'];
                                    } else {
                                        noAvailable = 1;
                                    }
                                } else {
                                    noAvailable = 1;
                                }
                            } else {
                                
                                if(schedule[day]['hours'][currHour] !== undefined
                                    && schedule[day] !== undefined) {
                                    
                                    if(schedule[day]['hours'][currHour] !== undefined) {
                                        noAvailable = noAvailable < parseInt(schedule[day]['hours'][currHour]['available'], 10) ? noAvailable : parseInt(schedule[day]['hours'][currHour]['available'], 10);
                                    } else {
                                        noAvailable = 1;
                                    }
                                } else {
                                    noAvailable = 1;
                                }
                            }
                        }
                    }
                }
                
                return noAvailable === 0 || noAvailable === 1000000 ? 1:noAvailable;
            },
            getPrice:function(day,
                              startHour,
                              endHour){
            /*
             * Get the price between 2 hours, included.
             * 
             * @param day (String): check in day (YYYY-MM-DD)
             * @param startHour (String): start hour (HH-MM)
             * @param endHour (String): end hour (HH-MM)
             * 
             * @return price value
             */
                var currHour,
                i,
                price,
                promo,
                schedule = DOT.methods.calendar_schedule.data[ID],
                selectedHours = new Array(),
                totalPrice = 0;
        
                /*
                 * Verify hours.
                 */
                endHour = endHour === '' ? startHour:endHour;
                
                /*
                 * Get selected hours.
                 */
                selectedHours = methods_hours.getSelected(day,
                                                          startHour,
                                                          endHour);

                for (i=0; i<selectedHours.length-((!methods_hours.data['addLastHourToTotalPrice'] || methods_hours.data['interval']) && methods_hours.data['multipleSelect'] ? 1:0); i++){
                    currHour = selectedHours[i];  
                    
                    if(methods_hours.data['interval_autobreak']) {
                        
                        if((i+1)%2 !== 0) {
                            
                            if (schedule[day] !== undefined 
                                && schedule[day]['hours'][currHour] !== undefined 
                                    && (schedule[day]['hours'][currHour]['status'] === 'available' 
                                            || schedule[day]['hours'][currHour]['status'] === 'special')
                                    && (schedule[day]['hours'][currHour]['bind'] === 0 
                                            || schedule[day]['hours'][currHour]['bind'] === 1)){
                                price = parseFloat(schedule[day]['hours'][currHour]['price']);
                                promo = parseFloat(schedule[day]['hours'][currHour]['promo']);

                                if (price !== 0){
                                    totalPrice += promo === 0 ? price:promo;
                                }
                            } else if (DOT.methods.calendar_schedule.default[ID]['hours'][currHour] !== undefined 
                                    && (DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status'] === 'available' 
                                            || DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status'] === 'special')
                                    && (DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['bind'] === 0 
                                            || DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['bind'] === 1)){
                                price = parseFloat(DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['price']);
                                promo = parseFloat(DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['promo']);

                                if (price !== 0){
                                    totalPrice += promo === 0 ? price:promo;
                                }
                            }
                        }
                    } else {
                        if (schedule[day] !== undefined && (schedule[day]['hours'][currHour] !== undefined 
                                && (schedule[day]['hours'][currHour]['status'] === 'available' 
                                        || schedule[day]['hours'][currHour]['status'] === 'special')
                                && (schedule[day]['hours'][currHour]['bind'] === 0 
                                        || schedule[day]['hours'][currHour]['bind'] === 1))){
                            price = parseFloat(schedule[day]['hours'][currHour]['price']);
                            promo = parseFloat(schedule[day]['hours'][currHour]['promo']);

                            if (price !== 0){
                                totalPrice += promo === 0 ? price:promo;
                            }
                        } else if (DOT.methods.calendar_schedule.default[ID]['hours'][currHour] !== undefined 
                                && (DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status'] === 'available' 
                                        || DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status'] === 'special')
                                && (DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['bind'] === 0 
                                        || DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['bind'] === 1)){
                            price = parseFloat(DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['price']);
                            promo = parseFloat(DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['promo']);

                            if (price !== 0){
                                totalPrice += promo === 0 ? price:promo;
                            }
                        }
                    }
                }
                
                return totalPrice;
            },
            getHistory:function(day,
                                startHour,
                                endHour){
            /*
             * Get the history (current schedule) between 2 hours, included.
             * 
             * @param day (String): check in day (YYYY-MM-DD)
             * @param startHour (String): start hour (HH-MM)
             * @param endHour (String): end hour (HH-MM)
             * 
             * @return curent schedule
             */
                var currHour,
                history = {},
                i,
                schedule = DOT.methods.calendar_schedule.data[ID],
                selectedHours = new Array();
        
                /*
                 * Verify hours.
                 */
                endHour = endHour === '' ? startHour:endHour;

                /*
                 * Get selected hours.
                 */
                selectedHours = methods_hours.getSelected(day,
                                                          startHour,
                                                          endHour);

                for (i=0; i<selectedHours.length-((!methods_hours.data['addLastHourToTotalPrice'] || methods_hours.data['interval']) && methods_hours.data['multipleSelect'] ? 1:0); i++){
                    currHour = selectedHours[i];

                    history[currHour] = {"available": "",
                                         "bind": 0,
                                         "price": 0,
                                         "promo": 0,
                                         "status": ""};
                    history[currHour]['available'] = schedule[day] !== undefined ? (schedule[day]['hours'][currHour] !== undefined ? schedule[day]['hours'][currHour]['available']:DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['available']):DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['available'];
                    history[currHour]['bind'] = schedule[day] !== undefined ? (schedule[day]['hours'][currHour] !== undefined ? schedule[day]['hours'][currHour]['bind']:DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['bind']):DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['bind'];
                    history[currHour]['price'] = schedule[day] !== undefined ? (schedule[day]['hours'][currHour] !== undefined ? schedule[day]['hours'][currHour]['price']:DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['price']):DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['price'];
                    history[currHour]['promo'] = schedule[day] !== undefined ? (schedule[day]['hours'][currHour] !== undefined ? schedule[day]['hours'][currHour]['promo']:DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['promo']):DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['promo'];
                    history[currHour]['status'] = schedule[day] !== undefined ? (schedule[day]['hours'][currHour] !== undefined ? schedule[day]['hours'][currHour]['status']:DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status']):DOT.methods.calendar_schedule.default[ID]['hours'][currHour]['status'];
                }
                
                return history;
            }
        },
                
        methods_hour = {
            display:function(id, 
                             hour, 
                             available, 
                             bind, 
                             info, 
                             infoBody, 
                             infoInfo, 
                             price, 
                             promo, 
                             status, 
                             hoursDef){
            /*
             * Display hour.
             * 
             * @param id (String): hour ID (ID_HH:MM for list, ID_HH:MM for info)
             * @param hour (String): current hour (HH:MM)
             * @param available (Number): number of available items for current hour
             * @param bind (Number): day bind status
             *                       "0" none
             *                       "1" binded at the start of a group
             *                       "2" binded in a group group
             *                       "3" binded at the end of a group
             * @param info (String): hour info
             * @param infoBody (String): hour body info
             * @param infoInfo (String): hour tooltip info
             * @param price (Number): hour price
             * @param promo (Number): hour promotional price
             * @param status (String): hour status (available, booked, special, unavailable)
             * @param hoursDef (Array): hours definitions
             * 
             * @retun hour HTML
             */
                var hourHTML = new Array(),
                priceContent = '&nbsp;',
                availableContent = '&nbsp;',
                type = '';

                if (status !== 'past-hour'){
                    if (price > 0 
                            && (bind === 0 
                                    || bind === 1)){
                        priceContent = DOPBSPFrontEnd.setPrice(ID, price);
                    }

                    if (promo > 0 
                            && (bind === 0 
                                    || bind === 1)){
                        priceContent = DOPBSPFrontEnd.setPrice(ID, promo);
                    }

                    switch (status){
                        case 'available':
                            type += ' dopbsp-available';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    availableContent = available+' '+DOPBSPFrontEnd.text(ID, 'calendar', 'availableMultiple');
                                }
                                else if (available === 1){
                                    availableContent = available+' '+DOPBSPFrontEnd.text(ID, 'calendar', 'available');
                                }
                                else{
                                    availableContent = DOPBSPFrontEnd.text(ID, 'calendar', 'available');
                                }
                            }
                            break;
                        case 'booked':
                            type += ' dopbsp-booked';

                            if (bind === 0 
                                    || bind === 1){
                                availableContent = DOPBSPFrontEnd.text(ID, 'calendar', 'booked');
                            }
                            break;
                        case 'special':
                            type += ' dopbsp-special';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    availableContent = available+' '+DOPBSPFrontEnd.text(ID, 'calendar', 'availableMultiple');
                                }
                                else if (available === 1){
                                    availableContent = available+' '+DOPBSPFrontEnd.text(ID, 'calendar', 'available');
                                }
                                else{
                                    availableContent = DOPBSPFrontEnd.text(ID, 'calendar', 'available');
                                }
                            }
                            break;
                        case 'unavailable':
                            type += ' dopbsp-unavailable';

                            if (bind === 0 
                                    || bind === 1){
                                availableContent = DOPBSPFrontEnd.text(ID, 'calendar', 'unavailable');  
                            }
                            break;
                    }
                }
                else{
                    type = ' dopbsp-'+status;
                }

                hourHTML.push('<div class="DOPBSPReservationsAdd-hour'+type+'" id="'+id+'">');
                hourHTML.push('    <div class="dopbsp-bind-top'+((bind === 2 || bind === 3) && (status === 'available' || status === 'special') ? ' dopbsp-enabled':'')+'"><div class="dopbsp-hour">&nbsp;</div></div>');                        
                hourHTML.push('    <div class="dopbsp-bind-middle dopbsp-group'+(status === 'available' || status === 'special' ? bind:'0')+'">');
                hourHTML.push('        <div class="dopbsp-hour">'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hour):hour)+(methods_hours.data['interval'] ? ' - '+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(methods_hour.getNext(hour, hoursDef)):methods_hour.getNext(hour, hoursDef)):'')+'</div>');

                if (price > 0 
                        && type !== ' dopbsp-past-hour' 
                        && (bind === 0 
                                || bind === 1)){
                    hourHTML.push('        <div class="'+(promo > 0 ? 'dopbsp-price-promo':'dopbsp-price')+'">'+priceContent+'</div>');      
                }

                if (promo > 0 
                        && type !== ' dopbsp-past-hour' 
                        && (bind === 0 
                                || bind === 1)){                                      
                    hourHTML.push('        <div class="dopbsp-old-price">'+DOPBSPFrontEnd.setPrice(ID, price)+'</div>');
                }                        
                hourHTML.push('        <div class="dopbsp-available">'+availableContent+'</div>');
                
                if ((infoBody !== undefined
                                && infoBody.length > 0)
                        && type !== ' dopbsp-past-hour'){
                    hourHTML.push('          <div class="dopbsp-info-body" id="'+id+'_info-body">');
                    hourHTML.push('              <div class="dopbsp-info-body-mask">&#8594;</div>');
                    hourHTML.push(methods_form.getInfo(infoBody));
                    hourHTML.push('          </div>');
                }

                if ((info !== ''
                                || (infoInfo !== undefined
                                            && infoInfo.length > 0))
                        && type !== ' dopbsp-past-hour' 
                        && (bind === 0 
                                || bind === 1)){
                    hourHTML.push('        <div class="dopbsp-info" id="'+id+'_info"></div>');
                }
                hourHTML.push('    </div>');
                hourHTML.push('    <div class="dopbsp-bind-bottom'+((bind === 1 || bind === 2) && (status === 'available' || status === 'special') ? ' dopbsp-enabled':'')+'"><div class="dopbsp-hour">&nbsp;</div></div>');
                hourHTML.push('</div>');

                return hourHTML.join('');
            },
            default:function(hour){
            /*
             * Default hour data.
             * 
             * @return JSON with default data
             */
                return {"available": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['available']:0, 
                        "bind": 0,
                        "info": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['info']:"", 
                        "info_body": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['info_body']:"",
                        "info_info": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['info_info']:"",
                        "notes": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['notes']:"",
                        "price": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['price']:0, 
                        "promo": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['promo']:0,
                        "status": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['status']:"none"};
            },
            
            getNext:function(hour,
                             hours){
            /*
             * Returns next hour from a list of time hours definitions.
             * 
             * @param hour (String): current hour (HH:MM)
             * @param hours (Array): hours definitions
             * 
             * @return next hour
             */    
                var nextHour = '24:00', 
                i;

                for (i=hours.length-1; i>=0; i--){
                    if (hours[i]['value'] > hour){
                        nextHour = hours[i]['value'];
                    }
                }

                return nextHour;
            },
            getPrev:function(hour,
                             hours){
            /*
             * Returns previous hour from a list of time hours definitions.
             * 
             * @param hour (String): current hour (HH:MM)
             * @param hours (Array): hours definitions
             * 
             * @return previous hour
             */ 
                var previousHour = '00:00', 
                i;

                for (i=0; i<hours.length; i++){
                    if (hours[i]['value'] < hour){
                        previousHour = hours[i]['value'];
                    }
                }

                return previousHour;
            },
            
            events: {
                init:function(){
                /*
                 * Initialize hour events.
                 */    
                    /*
                     * Hours click events.
                     */                      
                    if (methods_hours.data['multipleSelect']){
                        methods_hour.events.selectMultiple();
                    }
                    else{
                        methods_hour.events.selectSingle();
                    }

                    if (!DOPPrototypes.isTouchDevice()){
                        /*
                         * Hour hover event. 
                         */
                        $('.DOPBSPReservationsAdd-hour', Container).hover(function(){
                            var hour = $(this);

                            if (methods_hours.vars.selectionInit){
                                methods_hours.displaySelection(hour.attr('id'));
                            }
                        });

                        /*
                         * Info icon event.
                         */
                        $('.DOPBSPReservationsAdd-hour .dopbsp-info', Container).hover(function(){
                            methods_tooltip.set(methods_days.vars.selectionStart.split('_')[1], 
                                                $(this).attr('id').split('_')[1],
                                                'info');
                        }, function(){
                            methods_tooltip.clear();
                        });

                        /*
                         * Body info event.
                         */
                        $('.DOPBSPReservationsAdd-hour .dopbsp-info-body', Container).hover(function(){
                            methods_tooltip.set(methods_days.vars.selectionStart.split('_')[1], 
                                                $(this).attr('id').split('_')[1],
                                                'info-body');
                        }, function(){
                            methods_tooltip.clear();
                        });
                    }
                    else{
                        var xPos = 0, 
                        yPos = 0, 
                        touch;

                        /*
                         * Info icon events on devices with touchscreen.
                         */
                        $('.DOPBSPReservationsAdd-hour .dopbsp-info', Container).unbind('touchstart');
                        $('.DOPBSPReservationsAdd-hour .dopbsp-info', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPReservationsAdd-tooltip'+ID).css({'left': xPos,
                                                                        'top': yPos});
                            methods_tooltip.set(methods_days.vars.selectionStart.split('_')[1], 
                                                $(this).attr('id').split('_')[1],
                                                'info');
                        });

                        /*
                         * Body info events on devices with touchscreen.
                         */
                        $('.DOPBSPReservationsAdd-hour .dopbsp-info-body', Container).unbind('touchstart');
                        $('.DOPBSPReservationsAdd-hour .dopbsp-info-body', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPReservationsAdd-tooltip'+ID).css({'left': xPos,
                                                                        'top': yPos});
                            methods_tooltip.set(methods_days.vars.selectionStart.split('_')[1], 
                                                $(this).attr('id').split('_')[1],
                                                'info-body');
                        });
                        
                    }
                },
                selectMultiple:function(){
                /*
                 * Select multiple hours events.
                 */
                    /*
                     * Hours click event.
                     */
                    $('.DOPBSPReservationsAdd-hour', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-hour', Container).bind('click', function(){
                        var hour = $(this),
                        selectionAux,
                        selectionDay = methods_days.vars.selectionStart,
                        schedule = DOT.methods.calendar_schedule.data[ID],
                        hoursDef = schedule[selectionDay.split('_')[1]] !== undefined ? schedule[selectionDay.split('_')[1]]['hours_definitions']:methods_hours.data['definitions'];

                        setTimeout(function(){
                            if (!methods_hours.vars.selectionInit){
                            /*
                             * Select start hour.
                             */    
                                methods_hours.vars.selectionInit = true;
                                methods_hours.vars.selectionStart = hour.attr('id');
                                methods_hours.vars.selectionEnd = '';

                                methods_search.set();
                                methods_hours.displaySelection(methods_hours.vars.selectionStart);
                            }
                            else if ((((!methods_hours.data['addLastHourToTotalPrice'] 
                                                && (methods_hours.vars.selectionStart !== hour.attr('id') 
                                                        || methods_hours.data['interval'])) 
                                                        || methods_hours.data['addLastHourToTotalPrice']))
                                        || (!methods_hours.data['interval'] 
                                                && !methods_hours.data['addLastHourToTotalPrice'] 
                                                && methods_hours.vars.selectionStart !== hour.attr('id'))){
                            /*
                             * Select end hour.
                             */    
                                methods_hours.vars.selectionInit = false;
                                methods_hours.vars.selectionEnd = hour.attr('id');

                                if (methods_hours.vars.selectionStart > methods_hours.vars.selectionEnd){
                                    selectionAux = methods_hours.vars.selectionStart;
                                    methods_hours.vars.selectionStart = methods_hours.vars.selectionEnd;
                                    methods_hours.vars.selectionEnd = selectionAux;
                                }
                                methods_hours.displaySelection(methods_hours.vars.selectionEnd);

                                if (methods_hours.data['interval']){
                                    methods_hours.vars.selectionEnd = ID+'_'+methods_hour.getNext(methods_hours.vars.selectionEnd.split('_')[1], hoursDef);
                                }

                                methods_search.set();
                            }
                        }, 10);
                    });
                },
                selectSingle:function(){
                /*
                 * Select single hours event.
                 */
                    /*
                     * Hours click event.
                     */                      
                    $('.DOPBSPReservationsAdd-hour', Container).unbind('click');
                    $('.DOPBSPReservationsAdd-hour', Container).bind('click', function(){
                        var $hour = $(this),
                        hour = this;
                        
                        setTimeout(function(){
                            if (($hour.hasClass('dopbsp-available') 
                                        || $hour.hasClass('dopbsp-special'))
                                    && $('.dopbsp-bind-middle', hour).hasClass('dopbsp-group0')){
                                methods_hours.vars.selectionInit = false;
                                methods_hours.vars.selectionStart = $hour.attr('id');
                                methods_hours.vars.selectionEnd = $hour.attr('id');

                                methods_hours.displaySelection(methods_hours.vars.selectionEnd);
                                methods_search.set();
                            }
                        }, 10);
                    });
                }
            }
        },
         
// ***************************************************************************** Sidebar       

// 11. Sidebar

        methods_sidebar = {
            data: {},
            text: {},
            
            display:function(){
            /*
             * Display sidebar.
             * 
             * @return sidebar HTML
             */    
                var HTML = new Array();
                
                HTML.push('<form name="DOPBSPReservationsAdd-form'+ID+'" id="DOPBSPReservationsAdd-form'+ID+'" action="" method="POST" onsubmit="return false;">');
                HTML.push('</form>');

                return HTML.join('');
            },
            init:function(){
            /*
             * Initialize sidebar.
             */
                methods_search.init();
                
                if (methods_extras.data['id'] !== '0'){
                    methods_extras.init();
                }

                if (methods_coupons.data['id'] !== '0'){
                    methods_coupons.init();
                }
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
                
                return methods_calendar.data['dateType'] === 1 ? DOPBSPFrontEnd.text(ID, 'months', 'names')[parseInt(month, 10)-1]+' '+day+', '+year:
                                                                 day+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[parseInt(month, 10)-1]+' '+year;
            }
        },
                
// 12. Search
        
        methods_search = {
            data: {},
            text: {},
            
            display:function(){
            /*
             * Display sidebar search module.
             */    
                var HTML = new Array();
                
                HTML.push('<div class="dopbsp-inputs-wrapper">');
                
                HTML.push(methods_search.days.display());

                if (methods_hours.data['enabled']){
                    HTML.push(methods_search.hours.display());
                }
                HTML.push(methods_search.no_items.display());
                
                HTML.push('</div>');
                
                $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
            },
            init:function(){
            /*
             * Initialize sidebar search module.
             */ 
                /*
                 * Initialize days.
                 */
                methods_search.days.init();
                
                /*
                 * Initialize hours.
                 */
                if (methods_hours.data['enabled']){
                    methods_search.hours.init();
                }
                
                /*
                 * Initialize number of booked items.
                 */
                if (methods_sidebar.data['noItems']){
                    methods_search.no_items.set();
                }
            },
            set:function(toSet){
            /*
             * Set sidebar search module.
             * 
             * @param toSet (String): what to set in search module
             *                        "hours" set hours & number of items
             *                        "noItems" number of items
             */    
                toSet = toSet === undefined ? 'hours':toSet;
                
                if (toSet === 'hours' 
                        && methods_hours.data['enabled']){ 
                    methods_search.hours.set();
                }
                
                if (methods_sidebar.data['noItems']){
                    methods_search.no_items.set();
                }
                methods_reservation.set();
            },
            
            days: {
                display:function(){
                /*
                 * Display sidebar search days.
                 * 
                 * @return days search HTML
                 */
                    var HTML = new Array();

                    /*
                     * Check in.
                     */
                    HTML.push(' <div class="dopbsp-input-wrapper">');
                    HTML.push('     <label for="DOPBSPReservationsAdd-check-in-view'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'checkIn')+'</label>');
                    HTML.push('     <input type="text" name="DOPBSPReservationsAdd-check-in-view'+ID+'" id="DOPBSPReservationsAdd-check-in-view'+ID+'" class="DOPBSPReservationsAdd-check-in-view" value="" />');
                    HTML.push('     <input type="hidden" name="DOPBSPReservationsAdd-check-in'+ID+'" id="DOPBSPReservationsAdd-check-in'+ID+'" value="" />');
                    HTML.push(' </div>');

                    /*
                     * Check out.
                     */
                    if (!methods_hours.data['enabled'] 
                            && DOT.methods.calendar_days.settings[ID]['multipleSelect']){
                        HTML.push(' <div class="dopbsp-input-wrapper">');
                        HTML.push('     <label for="DOPBSPReservationsAdd-check-out-view'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'checkOut')+'</label>');
                        HTML.push('     <input type="text" name="DOPBSPReservationsAdd-check-out-view'+ID+'" id="DOPBSPReservationsAdd-check-out-view'+ID+'" class="DOPBSPReservationsAdd-check-out-view" value="" />');
                        HTML.push('     <input type="hidden" name="DOPBSPReservationsAdd-check-out'+ID+'" id="DOPBSPReservationsAdd-check-out'+ID+'" value="" />');
                        HTML.push(' </div>');
                    }

                    return HTML.join('');
                },
                init:function(){
                /*
                 * Initialize sidebar search days.
                 */ 
                    methods_search.days.events.init();
                },
                initDatepicker:function(id,
                                        altId,    
                                        minDate){
                /*
                 * Initialize sidebar search datepicker.
                 * 
                 * @param id (String): input(text) field ID
                 * @param aldId (String): alternative input(hidden) field ID
                 * @param minDate (Number): start date from today
                 */                                   
                    minDate = minDate === undefined ? DOPPrototypes.getNoDays(methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay),
                                                                              methods_calendar.vars.todayYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.todayMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.todayDay))-1:minDate;

                    $(id).datepicker('destroy');
                    $(id).datepicker({altField: altId,
                                      altFormat: 'yy-mm-dd',
                                      beforeShow: function(input, inst){
                                        $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                               .addClass('DOPBSP-admin-datepicker');
                                      },
                                      dateFormat: methods_calendar.data['dateType'] === 1 ? 'MM dd, yy':'dd MM yy',
                                      dayNames: DOPBSPFrontEnd.text(ID, 'days', 'names'),
                                      dayNamesMin: DOPBSPFrontEnd.text(ID, 'days', 'shortNames'),
                                      firstDay: DOT.methods.calendar_days.settings[ID]['first'],
                                      minDate: minDate,
                                      monthNames: DOPBSPFrontEnd.text(ID, 'months', 'names'),
                                      monthNamesMin: DOPBSPFrontEnd.text(ID, 'months', 'shortNames'),
                                      nextText: DOPBSPFrontEnd.text(ID, 'calendar', 'nextMonth'),
                                      prevText: DOPBSPFrontEnd.text(ID, 'calendar', 'previousMonth')});
                    $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');
                },
                validate:function(day){
                /*
                 * Validate day format.
                 * 
                 * @param day (String): day format to be verified
                 * 
                 * @return true if format is "YYYY-MM-DD"
                 */     
                    if(day === undefined 
                      || day === '') {
                        return true;
                    }
                    
                    var dayPieces = day.split('-');
                    
                    if (day === ''
                            || dayPieces.length !== 3
                            || dayPieces[0].length !== 4
                            || dayPieces[1].length !== 2
                            || dayPieces[2].length !== 2){
                        return false;
                    }
                    else{
                        return true;
                    }
                },

                events: {
                    init:function(){
                    /*
                     * Initialize sidebar search days events.
                     */    
                        if (!methods_calendar.data['view']){
                            /*
                             * Initialize check in datepicker.
                             */
                            methods_search.days.initDatepicker('#DOPBSPReservationsAdd-check-in-view'+ID,
                                                               '#DOPBSPReservationsAdd-check-in'+ID);

                            if (methods_hours.data['enabled']){
                                /*
                                 * Initialize hours select events.
                                 */
                                methods_search.days.events.selectHours();
                            }
                            else{
                                if (DOT.methods.calendar_days.settings[ID]['multipleSelect']){
                                    /*
                                     * Initialize check out datepicker.
                                     */
                                    methods_search.days.initDatepicker('#DOPBSPReservationsAdd-check-out-view'+ID,
                                                                       '#DOPBSPReservationsAdd-check-out'+ID);
                                    $('#DOPBSPReservationsAdd-check-out-view'+ID).attr('disabled', 'disabled');
                                    
                                    /*
                                     * Initialize multiple days select events.
                                     */
                                    methods_search.days.events.selectMultiple();
                                }
                                else{
                                    /*
                                     * Initialize single day select events.
                                     */
                                    methods_search.days.events.selectSingle();
                                }
                            }
                        }
                    },
                    selectHours:function(){
                    /*
                     * Initialize sidebar search days events when hours need to be selected.
                     */   
                        /*
                         * Check in click event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('click');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('click', function(){
                            $(this).val('');
                            methods_hours.clear();
                            methods_search.set();
                        });

                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('change');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val();

                            if (methods_search.days.validate(ciDay)){
                                methods_calendar.init(parseInt(ciDay.split('-')[0], 10), 
                                                      parseInt(ciDay.split('-')[1], 10));
                                methods_hours.display(ID+'_'+ciDay);
                            }
                            else{
                                $('#DOPBSPReservationsAdd-check-in-view'+ID).val('');
                            }
                        });
                    },
                    selectMultiple:function(){
                    /*
                     * Initialize sidebar search days events when multiple days need to be selected.
                     */
                        /*
                         * Check in click event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('click');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('click', function(){
                            $('#DOPBSPReservationsAdd-check-out-view'+ID).val('')
                                                                         .attr('disabled', 'disabled');
                            $('#DOPBSPReservationsAdd-check-in'+ID).val('');
                            $('#DOPBSPReservationsAdd-check-out'+ID).val('');

                            $(this).val('');
                            methods_days.vars.selectionInit = false;
                            methods_days.clearSelection();
                            methods_search.set();
                        });

                        /*
                         * Check in blur event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('blur');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('blur', function(){  
                            methods_search.set();
                        });
                        
                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('change');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val(),
                            minDateValue;
                            
                            if (methods_search.days.validate(ciDay)){
                                minDateValue = DOPPrototypes.getNoDays(DOPPrototypes.getToday(), ciDay)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 0:1);
                                methods_days.vars.selectionInit = true;
                                methods_days.vars.selectionStart = ID+'_'+ciDay;
                                methods_days.vars.selectionEnd = ID+'_'+ciDay;

                                $('#DOPBSPReservationsAdd-check-out-view'+ID).removeAttr('disabled')
                                                                             .val('');
                                $('#DOPBSPReservationsAdd-check-out'+ID).val('');
                                methods_search.days.initDatepicker('#DOPBSPReservationsAdd-check-out-view'+ID,
                                                                   '#DOPBSPReservationsAdd-check-out'+ID,
                                                                   minDateValue);

                                methods_calendar.init(methods_calendar.vars.startYear, 
                                                      methods_calendar.vars.startMonth+DOPPrototypes.getNoMonths(methods_calendar.vars.startYear+'-'+methods_calendar.vars.startMonth+'-'+methods_calendar.vars.startDay, ciDay)-1);
                                methods_days.displaySelection(methods_days.vars.selectionEnd);

                                setTimeout(function(){
                                    $('#DOPBSPReservationsAdd-check-out-view'+ID).val('')
                                                                                 .select();  
                                    $('#DOPBSPReservationsAdd-check-out'+ID).val('');
                                }, 100);
                            }
                            else{
                                $('#DOPBSPReservationsAdd-check-in-view'+ID).val('');
                            }
                        });
                        
                        /*
                         * Check out click event.
                         */
                        $('#DOPBSPReservationsAdd-check-out-view'+ID).unbind('click');
                        $('#DOPBSPReservationsAdd-check-out-view'+ID).bind('click', function(){  
                            var ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val();
                            
                            $('#DOPBSPReservationsAdd-check-out-view'+ID).val('');  
                            $('#DOPBSPReservationsAdd-check-out'+ID).val('');      

                            methods_search.set();
      
                            if (ciDay !== ''){
                                methods_days.vars.selectionStart = ID+'_'+ciDay;    
                                methods_days.displaySelection(methods_days.vars.selectionStart);        
                            }
                        });
                        
                        /*
                         * Check out blur event.
                         */
                        $('#DOPBSPReservationsAdd-check-out-view'+ID).unbind('blur');
                        $('#DOPBSPReservationsAdd-check-out-view'+ID).bind('blur', function(){ 
                            setTimeout(function(){         
                                var ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val();
                                
                                methods_search.set();
                                
                                if (ciDay !== ''){
                                    methods_days.vars.selectionStart = ID+'_'+ciDay;  
                                    methods_days.displaySelection(methods_days.vars.selectionStart);                   
                                }
                            }, 100);
                        });

                        /*
                         * Check out change event.
                         */
                        $('#DOPBSPReservationsAdd-check-out-view'+ID).unbind('change');
                        $('#DOPBSPReservationsAdd-check-out-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val(),
                            coDay = $('#DOPBSPReservationsAdd-check-out'+ID).val();
                            
                            setTimeout(function(){
                                if (methods_search.days.validate(coDay)){
                                    methods_days.vars.selectionInit = false;
                                    methods_days.vars.selectionStart = ID+'_'+ciDay;
                                    methods_days.vars.selectionEnd = ID+'_'+coDay;

                                    methods_calendar.init(methods_calendar.vars.startYear, 
                                                          methods_calendar.vars.startMonth+DOPPrototypes.getNoMonths(methods_calendar.vars.startYear+'-'+methods_calendar.vars.startMonth+'-'+methods_calendar.vars.startDay, ciDay)-1);
                                    methods_days.displaySelection(methods_days.vars.selectionEnd);
                                    methods_search.set();
                                }
                                else{
                                    $('#DOPBSPReservationsAdd-check-out-view'+ID).val('');
                                }
                            }, 100);
                        });
                    },
                    selectSingle:function(){
                    /*
                     * Initialize sidebar search days events when single day need to be selected.
                     */
                        /*
                         * Check in click event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('click');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('click', function(){
                            $(this).val('');
                            methods_days.vars.selectionInit = false;
                            methods_days.clearSelection();
                            methods_search.set();
                        });

                        /*
                         * Check in blur event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('blur');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('blur', function(){
                            methods_search.set();
                        });

                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).unbind('change');
                        $('#DOPBSPReservationsAdd-check-in-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val();

                            if (methods_search.days.validate(ciDay)){
                                methods_days.vars.selectionStart = ID+'_'+ciDay;
                                methods_days.vars.selectionEnd = ID+'_'+ciDay;

                                methods_calendar.init(methods_calendar.vars.startYear, 
                                                      methods_calendar.vars.startMonth+DOPPrototypes.getNoMonths(methods_calendar.vars.startYear+'-'+methods_calendar.vars.startMonth+'-'+methods_calendar.vars.startDay, ciDay)-1);
                                methods_days.displaySelection(methods_days.vars.selectionEnd);
                                methods_search.set();
                            }
                            else{
                                $('#DOPBSPReservationsAdd-check-in-view'+ID).val('');
                            }
                        });
                    }
                }
            },
            hours: {
                display:function(){
                /*
                 * Display sidebar search hours.
                 * 
                 * @return hours search HTML
                 */
                    var HTML = new Array();

                    /*
                     * Start hour.
                     */
                    HTML.push(' <div class="dopbsp-input-wrapper">');
                    HTML.push('     <label for="DOPBSPReservationsAdd-start-hour'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'hourStart')+'</label>');
                    HTML.push('     <div id="DOPSelect-DOPBSPReservationsAdd-start-hour'+ID+'"></div>');
                    HTML.push(' </div>');

                    /*
                     * End hour.
                     */
                    if (methods_hours.data['multipleSelect']){
                        HTML.push(' <div class="dopbsp-input-wrapper">');
                        HTML.push('     <label for="DOPBSPReservationsAdd-end-hour'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'hourEnd')+'</label>');
                        HTML.push('     <div id="DOPSelect-DOPBSPReservationsAdd-end-hour'+ID+'"></div>');
                        HTML.push(' </div>');
                    }
                    else{
                        HTML.push(' <input type="hidden" name="DOPBSPReservationsAdd-end-hour'+ID+'" id="DOPBSPReservationsAdd-end-hour'+ID+'" value="" />');
                    }

                    return HTML.join('');
                },
                init:function(){
                /*
                 * Initialize sidebar search hours.
                 */ 
                    methods_search.hours.set();
                },
                set:function(toSet){
                /*
                 * Set sidebar search hours.
                 * 
                 * @param toSet (String): what to set in search hours
                 *                        "all" set all hours
                 *                        "endHour" set only end hour
                 */
                    var currHour = methods_calendar.vars.startDate.getHours(),
                    currMin = methods_calendar.vars.startDate.getMinutes(),
                    endHTML = new Array(),
                    i,
                    schedule = DOT.methods.calendar_schedule.data[ID],
                    selectedDay = methods_days.vars.selectionStart.split('_')[1],
                    hoursDef = schedule[selectedDay] !== undefined ? schedule[selectedDay]['hours_definitions']:methods_hours.data['definitions'],
                    selectedHourStart = methods_hours.vars.selectionStart.split('_')[1],
                    selectedHourEnd = methods_hours.vars.selectionEnd.split('_')[1],
                    startHTML = new Array();

                    toSet = toSet === undefined ? 'all':toSet;

                    /*
                     * Set start hour.
                     */
                    if (toSet === 'all'){
                        startHTML.push('<select name="DOPBSPReservationsAdd-start-hour'+ID+'" id="DOPBSPReservationsAdd-start-hour'+ID+'" class="dopbsp-small">');
                        startHTML.push('    <option value=""></option>');

                        for (i=0; i<hoursDef.length; i++){
                            /*
                             * Check if hour has passed then display.
                             */
                            if (hoursDef[i]['value'] >= DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                    || methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) !== selectedDay){
                                
                                if(methods_hours.data['interval_autobreak']) {
                        
                                    if(i%2 === 0
                                      && i !== hoursDef.length-1) {
                                        startHTML.push('    <option value="'+hoursDef[i]['value']+'"'+(selectedHourStart === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                    }
                                } else {
                                    startHTML.push('    <option value="'+hoursDef[i]['value']+'"'+(selectedHourStart === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                }
                            }
                        }
                        startHTML.push('</select>');

                        $('#DOPSelect-DOPBSPReservationsAdd-start-hour'+ID).replaceWith(startHTML.join(''));
                        $('#DOPBSPReservationsAdd-start-hour'+ID).DOPSelect();
                    }

                    /*
                     * Set end hour.
                     */
                    if (methods_hours.data['multipleSelect']){
                        endHTML.push('<select name="DOPBSPReservationsAdd-end-hour'+ID+'" id="DOPBSPReservationsAdd-end-hour'+ID+'" class="dopbsp-small">');
                        endHTML.push('  <option value=""></option>');
                        
                        for (i=0; i<hoursDef.length; i++){
                            if (hoursDef[i]['value'] >= DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                    || methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) !== selectedDay){
                                if (methods_hours.data['interval'] 
                                        || !methods_hours.data['addLastHourToTotalPrice']){
                                    if (selectedHourStart === undefined
                                            || hoursDef[i]['value'] > selectedHourStart){
                                        
                                        if(methods_hours.data['interval_autobreak']) {

                                            if(i%2 === 1) {
                                                endHTML.push('  <option value="'+hoursDef[i]['value']+'"'+(selectedHourEnd === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                            }
                                        } else {
                                            endHTML.push('  <option value="'+hoursDef[i]['value']+'"'+(selectedHourEnd === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                        }
                                    }
                                }
                                else{
                                    if (selectedHourStart === undefined
                                            || hoursDef[i]['value'] >= selectedHourStart){
                                        
                                        if(methods_hours.data['interval_autobreak']) {
                                            
                                            if(i%2 === 1) {
                                                endHTML.push('  <option value="'+hoursDef[i]['value']+'"'+(selectedHourEnd === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                            }
                                        } else {
                                            endHTML.push('  <option value="'+hoursDef[i]['value']+'"'+(selectedHourEnd === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                        }
                                    }
                                }
                            }
                        }
                        endHTML.push('</select>');

                        $('#DOPSelect-DOPBSPReservationsAdd-end-hour'+ID).replaceWith(endHTML.join(''));
                        $('#DOPBSPReservationsAdd-end-hour'+ID).DOPSelect();
                    }

                    methods_search.hours.events.init();
                },

                events: {
                    init:function(){
                    /*
                     * Initialize sidebar search hours events.
                     */
                        if (methods_hours.data['multipleSelect']){
                            /*
                             * Initialize multiple hours select events.
                             */
                            methods_search.hours.events.selectMultiple();
                        }
                        else{
                            /*
                             * Initialize single hour select event.
                             */
                            methods_search.hours.events.selectSingle();
                        }
                    },
                    selectMultiple:function(){
                    /*
                     * Initialize sidebar search hours events when multiple hours need to be selected.
                     */
                        /*
                         * Start hour change event.
                         */
                        $('#DOPBSPReservationsAdd-start-hour'+ID).unbind('change');
                        $('#DOPBSPReservationsAdd-start-hour'+ID).bind('change', function(){
                            var startHour = $(this).val();

                            methods_hours.vars.selectionInit = true;
                            methods_hours.vars.selectionStart = ID+'_'+startHour;
                            methods_hours.vars.selectionEnd = '';

                            methods_hours.displaySelection(methods_hours.vars.selectionStart);
                            methods_search.hours.set('endHour');
                            methods_search.set('noItems');
                        });

                        /*
                         * End hours change event.
                         */
                        $('#DOPBSPReservationsAdd-end-hour'+ID).unbind('change');
                        $('#DOPBSPReservationsAdd-end-hour'+ID).bind('change', function(){
                            var endHour = $(this).val(),
                            selectionDay = methods_days.vars.selectionStart,
                            schedule = DOT.methods.calendar_schedule.data[ID],
                            hoursDef = schedule[selectionDay.split('_')[1]] !== undefined ? schedule[selectionDay.split('_')[1]]['hours_definitions']:methods_hours.data['definitions'];

                            methods_hours.vars.selectionInit = false;
                            methods_hours.vars.selectionEnd = ID+'_'+endHour;

                            if (methods_hours.data['interval']){
                                methods_hours.vars.selectionEnd = ID+'_'+methods_hour.getPrev(methods_hours.vars.selectionEnd.split('_')[1], hoursDef);
                            }
                            methods_hours.displaySelection(methods_hours.vars.selectionEnd);
                            methods_search.set('noItems');
                        });
                    },
                    selectSingle:function(){
                    /*
                     * Initialize sidebar search hours events when single hour need to be selected.
                     */
                        /*
                         * Start hour change event.
                         */
                        $('#DOPBSPReservationsAdd-start-hour'+ID).unbind('change');
                        $('#DOPBSPReservationsAdd-start-hour'+ID).bind('change', function(){
                            var startHour = $(this).val();

                            methods_hours.vars.selectionStart = ID+'_'+startHour;
                            methods_hours.vars.selectionEnd = ID+'_'+startHour;

                            methods_hours.displaySelection(methods_hours.vars.selectionEnd);
                            methods_search.set('noItems');
                        });
                    }
                }
            },
            no_items: {
                display:function(){
                /*
                 * Display sidebar search number of items.
                 * 
                 * @return number of items search HTML
                 */
                    var HTML = new Array();

                     if (methods_sidebar.data['noItems']){
                        HTML.push(' <div id="DOPBSPReservationsAdd-no-items-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-last">');
                        HTML.push('     <label for="DOPBSPReservationsAdd-no-items'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'noItems')+'</label>');
                        HTML.push('     <div id="DOPSelect-DOPBSPReservationsAdd-no-items'+ID+'"></div>');
                        HTML.push(' </div>');
                     }
                     else{
                        HTML.push(' <input type="hidden" name="DOPBSPReservationsAdd-no-items'+ID+'" id="DOPBSPReservationsAdd-no-items'+ID+'" value="1" />');
                     }

                    return HTML.join('');
                },
                set:function(){
                /*
                 * Set sidebar search number of items.
                 */
                    var HTML = new Array(),
                    i,
                    noAvailable = methods_hours.data['enabled'] ? methods_hours.getNoAvailable():methods_days.getNoAvailable();

                    HTML.push('<select name="DOPBSPReservationsAdd-no-items'+ID+'" id="DOPBSPReservationsAdd-no-items'+ID+'" class="dopbsp-small">');

                    for (i=1; i<=noAvailable; i++){
                        HTML.push(' <option value="'+i+'">'+i+'</option>');
                    }
                    HTML.push('</select>');

                    $('#DOPSelect-DOPBSPReservationsAdd-no-items'+ID).replaceWith(HTML.join(''));
                    $('#DOPBSPReservationsAdd-no-items'+ID).DOPSelect();

                    methods_search.no_items.events();
                },
                events:function(){
                /*
                 * Initialize sidebar search number of items events.
                 */
                    /*
                     * Number of items change event.
                     */
                    $('#DOPBSPReservationsAdd-no-items'+ID).unbind('change');
                    $('#DOPBSPReservationsAdd-no-items'+ID).bind('change', function(){
                        methods_reservation.set();
                    });
                }
            }
        },
                
// 14. Extras
        
        methods_extras = {
            data: {},
            text: {},
            
            display:function(){
            /*
             * Display extras.
             */
                var extra = methods_extras.data['extra'],
                groupItem,
                HTML = new Array(),
                i,
                j;
                
                HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                HTML.push(' <h3>'+DOPBSPFrontEnd.text(ID, 'extras', 'title')+'</h3>');
                HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPReservationsAdd-extras'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPReservationsAdd-extras'+ID+'" class="dopbsp-button"></a>');
                HTML.push('</div>');
                HTML.push('<div id="DOPBSP-inputs-DOPBSPReservationsAdd-extras'+ID+'" class="dopbsp-inputs-wrapper">');

                /*
                 * List
                 */
                for (i=0; i<extra.length; i++){
                    HTML.push('<div class="dopbsp-input-wrapper'+(i === extra.length-1 ? ' dopbsp-last':'')+'">');
                    HTML.push(' <label for="DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']+'">'+extra[i]['translation']+(extra[i]['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                    HTML.push(' <select name="DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']+'" id="DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']+'"'+(extra[i]['multiple_select'] === 'true' ? ' value="[]" multiple class="dopbsp-big"':'')+'>');

                    if (extra[i]['required'] === 'false' 
                            && extra[i]['multiple_select'] === 'false'){
                        HTML.push('<option value=""></option>');
                    }

                    for (j=0; j<extra[i]['group_items'].length; j++){
                        groupItem = extra[i]['group_items'][j];
                                
                        if (groupItem['translation'] !== ''){
                            HTML.push('<option value="'+groupItem['id']+'">');
                            HTML.push(groupItem['translation']);
                            
                            if (parseFloat(groupItem['price']) !== 0){
                                HTML.push(' <span class="dopbsp-info">(');
                                    
                                if (groupItem['price_type'] === 'fixed'){
                                    HTML.push(groupItem['operation']+DOPBSPFrontEnd.setPrice(ID, groupItem['price']));
                                }
                                else{
                                    HTML.push(groupItem['operation']+groupItem['price']+'%');
                                }
                                
                                if (groupItem['price_by'] !== 'once'){
                                    HTML.push('/'+(methods_hours.data['enabled'] ? DOPBSPFrontEnd.text(ID, 'extras', 'byHour'):DOPBSPFrontEnd.text(ID, 'extras', 'byDay')));
                                }
                                HTML.push(')</span>');
                            }
                            HTML.push('</option>');
                        }
                    }
                    HTML.push(' </select>');
                    HTML.push('</div>');
                }
                
                /*
                 * Message
                 */
                HTML.push(' <div class="dopbsp-message DOPBSPReservationsAdd-hidden"></div>');
                HTML.push('</div>');
                            
                $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
            },
            init:function(){
            /*
             * Initialize extras lists (drop downs/selects).
             */    
                var extra = methods_extras.data['extra'],
                i;
                
                /*
                 * For each extras list initialize DOP Select jQuery plugin.
                 */
                for (i=0; i<extra.length; i++){
                    $('#DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']).DOPSelect();
                }
                methods_extras.events();
            },
            events:function(){
            /*
             * Initialize extras lists events.
             */
                var extra = methods_extras.data['extra'],
                i;
                
                /*
                 * For each extras list initialize change event.
                 */
                for (i=0; i<extra.length; i++){
                    $('#DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']).unbind('change');
                    $('#DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']).bind('change', function(){
                        methods_reservation.set();
                    });
                }
            },
            
            get:function(reservationPrice,
                         ciDay,
                         coDay,
                         startHour,
                         endHour,
                         noItems,
                         noItemsMultiply){
            /*
             * Get list of selected extras.
             * 
             * @param reservationPrice (Number): reservation price
             * @param ciDay (String): check in day
             * @param ciDay (String): check in day
             * @param startHour (String): start hour
             * @param endHour (String): start hour
             * @param noItems (Number): number of reserved items
             * 
             * @return array of extras
             */    
                var extra = methods_extras.data['extra'],
                extras = new Array(),
                groupItem,
                noItemsMultiply = 'false',
                i,
                j;
        
                /*
                 * All 3 "for" statements need to be separated.
                 */
                
                /*
                 * Set verified value to false.
                 */
                for (i=0; i<extra.length; i++){
                    extra[i]['verified'] = false;
                }
                
                /*
                 * Get selected extras list.
                 */
                for (i=0; i<extra.length; i++){
                    if (extra[i]['verified'] === undefined){
                        extra[i]['verified'] = false;
                    }
                    
                    noItemsMultiply = extra[i]['no_items_multiply'];
                    
                    for (j=0; j<extra[i]['group_items'].length; j++){
                        groupItem = extra[i]['group_items'][j];
                        
                        if ((extra[i]['multiple_select'] === 'false'
                                        && $('#DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']).val() === groupItem['id']
                                        && extra[i]['verified'] === false)
                                || (extra[i]['multiple_select'] !== 'false'
                                        && $('#DOPSelect-DOPBSPReservationsAdd-extras-group'+ID+'-'+extra[i]['id']+'-'+groupItem['id']).is(':checked'))){
                            extra[i]['verified'] = true;
                            
                            extras.push({'group_id': extra[i]['id'],
                                         'group_translation': extra[i]['translation'],
                                         'id': groupItem['id'],
                                         'operation': groupItem['operation'],
                                         'price': parseFloat(groupItem['price']),
                                         'price_by': groupItem['price_by'],
                                         'price_type': groupItem['price_type'],
                                         'translation': groupItem['translation']});
                        }
                    }
                }
        
                /*
                 * Calculate price for each selected extra.
                 */
                for (i=0; i<extras.length; i++){
                    delete extras[i]['verified'];
                    extras[i]['price_total'] = methods_extras.getPrice([extras[i]],
                                                                        reservationPrice,
                                                                        ciDay,
                                                                        coDay,
                                                                        startHour,
                                                                        endHour,
                                                                        noItems);
                }
                
                return extras;
            },
            getPrice:function(extras,
                              reservationPrice,
                              ciDay,
                              coDay,
                              startHour,
                              endHour,
                              noItems,
                              noItemsMultiply){
            /*
             * Get selected extras price. If you give an array with only one extra you get the price of that selected extra.
             * 
             * @param extras (Array): list of extras
             * @param reservationPrice (Number): reservation price
             * @param ciDay (String): check in day
             * @param ciDay (String): check in day
             * @param startHour (String): start hour
             * @param endHour (String): start hour
             * @param noItems (Number): number of reserved items
             * 
             * @retun extras total price value
             */
                var groupItem,
                i,
                price = 0,
                timeLapse;
        
                /*
                 * Verify days/hours.
                 */
                coDay = coDay === '' ? ciDay:coDay;
                endHour = endHour === '' ? startHour:endHour;
                
                /*
                 * Calculate price.
                 */
                timeLapse = methods_hours.data['enabled'] ? DOPPrototypes.getHoursDifference(startHour, endHour, 'hours')+(methods_hours.data['addLastHourToTotalPrice'] ? 1:0):
                                                            DOPPrototypes.getNoDays(ciDay, coDay)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 1:0);

                for (i=0; i<extras.length; i++){
                    groupItem = extras[i];
                    price += (groupItem['operation'] === '-' ? -1:1)
                             *(groupItem['price_by'] === 'once' ? 1:timeLapse)
                             *groupItem['price']
                             *(groupItem['price_type'] === 'fixed' ? (groupItem['no_items_multiply'] === 'true' ? noItems:1):reservationPrice)/
                             (groupItem['price_type'] === 'fixed' ? 1:100);
                }
                
                return price;
            },
            set:function(extras,
                         ciDay,
                         coDay,
                         startHour,
                         endHour){
            /*
             * Set selected extras details.
             * 
             * @param extras (Array): list of extras
             * @param ciDay (String): check in day
             * @param ciDay (String): check in day
             * @param startHour (String): start hour
             * @param endHour (String): start hour
             * 
             * @retun HTML
             */
                var extra,
                extraHTML = new Array(),
                extrasHTML = new Array(),
                HTML = new Array(),
                i,
                j;
        
                /*
                 * Verify days/hours.
                 */
                coDay = coDay === '' ? ciDay:coDay;
                endHour = endHour === '' ? startHour:endHour;
                
                /*
                 * If extras are selected display.
                 */
                if (extras.length > 0){
                    HTML.push('<tr class="dopbsp-separator">');
                    HTML.push(' <td class="dopbsp-label"><div class="dopbsp-line"></div></td>');
                    HTML.push(' <td class="dopbsp-value"><div class="dopbsp-line"></div></td>');
                    HTML.push('</tr>');
                }
                
                for (i=0; i<extras.length; i++){
                    extrasHTML.length = 0;
                    
                    if (extras[i]['displayed'] === undefined){
                        for (j=0; j<extras.length; j++){
                            extra = extras[j];
                            extraHTML.length = 0;
                                
                            if (extras[j]['displayed'] === undefined
                                    && extras[i]['group_id'] === extras[j]['group_id']){
                                extraHTML.push(extra['translation']);

                                if (parseFloat(extra['price']) !== 0){
                                    extraHTML.push(' <br />');
                                    
                                    if (extra['price_type'] !== 'fixed' 
                                            || extra['price_by'] !== 'once'){
                                        extraHTML.push(' <span class="dopbsp-info-rule">&#9632;&nbsp;');

                                        if (extra['price_type'] === 'fixed'){
                                            extraHTML.push(extra['operation']+DOPBSPFrontEnd.setPrice(ID, extra['price']));
                                        }
                                        else{
                                            extraHTML.push(extra['operation']+extra['price']+'%');
                                        }

                                        if (extra['price_by'] !== 'once'){
                                            extraHTML.push('/'+(methods_hours.data['enabled'] ? DOPBSPFrontEnd.text(ID, 'extras', 'byHour'):DOPBSPFrontEnd.text(ID, 'extras', 'byDay')));
                                        }
                                        extraHTML.push('</span><br />');
                                    }
                                    extraHTML.push('<span class="dopbsp-info-price">'+extra['operation']+'&nbsp;'+DOPBSPFrontEnd.setPrice(ID, extra['price_total'])+'</span>');
                                }
                            
                                if (extraHTML.length !== 0){
                                    extras[j]['displayed'] = true;
                                    extrasHTML.push(extraHTML.join(''));
                                }
                            }
                        }
                        
                        if (extrasHTML.length !== 0){
                            HTML.push('<tr>');
                            HTML.push(' <td class="dopbsp-label">'+extras[i]['group_translation']+'</td>');
                            HTML.push(' <td class="dopbsp-value dopbsp-info">'+extrasHTML.join('<br /><br />')+'</td>');
                            HTML.push('</tr>');
                        }
                    }
                }
                
                for (i=0; i<extras.length; i++){
                    delete extras[i]['displayed'];
                }
                
                return HTML.join('');
            },
            
            validate:function(extras){
            /*
             * Check if required extras are selected.
             * 
             * @param extras (Array): list of extras
             * 
             * @retun true/false
             */
                var extra = methods_extras.data['extra'],
                i,
                j,
                message = '',
                validateExtras = true,
                validateGroup;
                
                for (i=0; i<extra.length; i++){
                    if (extra[i]['required'] === 'true'
                            && extra[i]['multiple_select'] === 'true'){
                        validateGroup = false;
                        
                        for (j=0; j<extras.length; j++){
                            if (extra[i]['id'] === extras[j]['group_id']){
                                validateGroup = true;
                            }
                        }
                        
                        if (!validateGroup){
                            validateExtras = false;
                            
                            message += (message === '' ? '':'<br />')+DOPBSPFrontEnd.text(ID, 'extras', 'invalid')+' '+extra[i]['translation']+'.';
                        }
                    }
                }
                
                if (!validateExtras){
                    methods_extras.toggleMessages(message);
                    return false;
                }
                else{
                    methods_extras.toggleMessages('',
                                                  'dopbsp-success',
                                                  'none');
                    return true;
                }
            },
            toggleMessages:function(message,
                                    display,
                                    type){
            /*
             * Toggle extras messages.
             * 
             * @param message (String): the message to be displayed
             * @param display (String): CSS display value
             *                          "block" display message
             *                          "none" hide message
             * @param type (String): message type
             *                       "dopbsp-error" error message
             *                       "dopbsp-success" success message
             */         
                display = display === undefined ? 'block':display;
                type = type === undefined ? 'dopbsp-error':type;
                
                $('#DOPBSP-inputs-DOPBSPReservationsAdd-extras'+ID+' .dopbsp-message').html(message)
                                                                                      .removeClass('dopbsp-success')
                                                                                      .removeClass('dopbsp-error')
                                                                                      .addClass(type)
                                                                                      .css('display', display);
                if (display === 'block'){
                    $('#DOPBSP-inputs-DOPBSPReservationsAdd-extras'+ID+' .dopbsp-input-wrapper:nth-last-child(2)').removeClass('dopbsp-last');
                }
                else{
                    $('#DOPBSP-inputs-DOPBSPReservationsAdd-extras'+ID+' .dopbsp-input-wrapper:nth-last-child(2)').addClass('dopbsp-last');
                }
            }
        },
                
// 17. Coupons
        
        methods_coupons = {
            data: {},
            text: {},
            vars: {use: false},
            
            display:function(){
            /*
             * Display extras.
             */
                var HTML = new Array();
                
                HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                HTML.push(' <h3>'+DOPBSPFrontEnd.text(ID, 'coupons', 'title')+'</h3>');
                HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPReservationsAdd-coupons'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPReservationsAdd-coupons'+ID+'" class="dopbsp-button"></a>');
                HTML.push('</div>');
                HTML.push('<div id="DOPBSP-inputs-DOPBSPReservationsAdd-coupons'+ID+'" class="dopbsp-inputs-wrapper">');
                
                /*
                 * Code
                 */     
                HTML.push(' <div class="dopbsp-input-wrapper dopbsp-last">');
                HTML.push('     <label for="DOPBSPReservationsAdd-coupons-code'+ID+'">'+DOPBSPFrontEnd.text(ID, 'coupons', 'code')+'</label>');
                HTML.push('     <input type="text" name="DOPBSPReservationsAdd-coupons-code'+ID+'" id="DOPBSPReservationsAdd-coupons-code'+ID+'" value="" />');
                HTML.push(' </div>');
                
                /*
                 * Buttons
                 */
                HTML.push(' <div id="DOPBSPReservationsAdd-coupons-buttons'+ID+'" class="dopbsp-input-wrapper dopbsp-last DOPBSPReservationsAdd-hidden">');
                HTML.push('     <label>&nbsp;</label>');
                HTML.push('     <input type="button" name="DOPBSPReservationsAdd-coupons-verify'+ID+'" id="DOPBSPReservationsAdd-coupons-verify'+ID+'" class="DOPBSPReservationsAdd-hidden" value="'+DOPBSPFrontEnd.text(ID, 'coupons', 'verify')+'" />');
                HTML.push('     <input type="button" name="DOPBSPReservationsAdd-coupons-use'+ID+'" id="DOPBSPReservationsAdd-coupons-use'+ID+'" class="DOPBSPReservationsAdd-hidden" value="'+DOPBSPFrontEnd.text(ID, 'coupons', 'use')+'" />');
                HTML.push('     <div id="DOPBSPReservationsAdd-coupons-loader'+ID+'" class="dopbsp-submit-loader DOPBSPReservationsAdd-hidden"></div>');
                HTML.push(' </div>');
                
                /*
                 * Message
                 */
                HTML.push(' <div class="dopbsp-message DOPBSPReservationsAdd-hidden"></div>');
                HTML.push('</div>');
            
                $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
            },
            init:function(){
            /*
             * Initialize coupons.
             */
                methods_coupons.events();
            },
            events:function(){
            /*
             * Initialize coupons events.
             */
                /*
                 * Code input.
                 */
                $('#DOPBSPReservationsAdd-coupons-code'+ID).unbind('input propertychange blur');
                $('#DOPBSPReservationsAdd-coupons-code'+ID).bind('input propertychange blur', function(){
                    if ($(this).val() === ''){
                        $('#DOPBSP-inputs-DOPBSPReservationsAdd-coupons'+ID+' .dopbsp-input-wrapper:first-child').addClass('dopbsp-last');
                        $('#DOPBSPReservationsAdd-coupons-buttons'+ID).css('display', 'none');
                        $('#DOPBSPReservationsAdd-coupons-verify'+ID).css('display', 'none');
                    }
                    else{
                        $('#DOPBSP-inputs-DOPBSPReservationsAdd-coupons'+ID+' .dopbsp-input-wrapper:first-child').removeClass('dopbsp-last');
                        $('#DOPBSPReservationsAdd-coupons-buttons'+ID).css('display', 'block');
                        $('#DOPBSPReservationsAdd-coupons-verify'+ID).css('display', 'block');
                    }
                    $('#DOPBSPReservationsAdd-coupons-use'+ID).css('display', 'none');
                    $('#DOPBSPReservationsAdd-coupons-loader'+ID).css('display', 'none');
                    
                    DOPBSPBackEnd.toggleMessages('none', '');
                });
                
                /*
                 * Verify button.
                 */
                $('#DOPBSPReservationsAdd-coupons-verify'+ID).unbind('click');
                $('#DOPBSPReservationsAdd-coupons-verify'+ID).bind('click', function(){
                    methods_coupons.verify();
                });
                
                /*
                 * Use button.
                 */
                $('#DOPBSPReservationsAdd-coupons-use'+ID).unbind('click');
                $('#DOPBSPReservationsAdd-coupons-use'+ID).bind('click', function(){
                    methods_coupons.vars.use = true;
                    methods_reservation.set();
                    
                    $('#DOPBSPReservationsAdd-coupons-code'+ID).val('');
                    $('#DOPBSP-inputs-DOPBSPReservationsAdd-coupons'+ID+' .input-wrapper:first-child').addClass('last');
                    $('#DOPBSPReservationsAdd-coupons-buttons'+ID).css('display', 'none');
                    $('#DOPBSPReservationsAdd-coupons-use'+ID).css('display', 'none');
                    
                    DOPBSPBackEnd.toggleMessages('none', '');
                });
            },
            verify:function(){
            /*
             * Verify coupon code.
             */  
                var currDate = new Date(),
                today = currDate.getFullYear()+'-'+DOPPrototypes.getLeadingZero(currDate.getMonth()+1)+'-'+DOPPrototypes.getLeadingZero(currDate.getDate()),
                currTime = DOPPrototypes.getLeadingZero(currDate.getHours())+':'+DOPPrototypes.getLeadingZero(currDate.getMinutes());
                
                DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
               
                $.post(ajaxurl, {action: 'dopbsp_coupons_verify',
                                 dopbsp_frontend_ajax_request: true,
                                 calendar_id: ID,
                                 code: $('#DOPBSPReservationsAdd-coupons-code'+ID).val(),
                                 today: today,
                                 check_in: methods_reservation.reservation['check_in'],
                                 check_out: methods_reservation.reservation['check_out'],
                                 start_hour: methods_reservation.reservation['start_hour'],
                                 end_hour: methods_reservation.reservation['end_hour'],
                                 curr_time: currTime}, function(data){  
                    data = $.trim(data);
                    
                    if (data !== 'error'){
                        methods_coupons.data['coupon'] = JSON.parse(data);
                        methods_coupons.vars.use = false;
                        $('#DOPBSPReservationsAdd-coupons-verify'+ID).css('display', 'none');
                        $('#DOPBSPReservationsAdd-coupons-use'+ID).css('display', 'block');
                        DOPBSPBackEnd.toggleMessages('success', DOPBSPFrontEnd.text(ID, 'coupons', 'verifySuccess'));
                                                       
                    }
                    else{
                        methods_coupons.vars.use = true;
                        DOPBSPBackEnd.toggleMessages('error', DOPBSPFrontEnd.text(ID, 'coupons', 'verifyError'));
                        methods_coupons.data['coupon']['price'] = 0;
                    }
                });
            },
            
            get:function(){
            /*
             * Get coupon data.
             * 
             * @retun coupon data
             */
                var coupon = {'id': 0,
                              'code': '', 
                              'operation': '-',
                              'price': 0,
                              'price_type': 'percent',
                              'price_by': 'once',
                              'translation': ''},
                coupon_data = methods_coupons.data['coupon'];
                
                if (methods_coupons.vars.use === true){
                    coupon['id'] = coupon_data['id'];
                    coupon['code'] = coupon_data['code'];
                    coupon['operation'] = coupon_data['operation'];
                    coupon['price'] = coupon_data['price'];
                    coupon['price_type'] = coupon_data['price_type'];
                    coupon['price_by'] = coupon_data['price_by'];
                    coupon['translation'] = coupon_data['translation'];
                }
                
                return coupon;
            },
            getPrice:function(coupon,
                              reservationPrice,
                              discountPrice,
                              extrasPrice,
                              feesPrice,
                              ciDay,
                              coDay,
                              startHour,
                              endHour,
                              noItems){
            /*
             * Get coupon value.
             * 
             * @param coupon (Object): coupon data
             * @param reservationPrice (Number): reservation price
             * @param discountPrice (Number): discount price
             * @param extrasPrice (Number): extras price
             * @param feesPrice (Number): fees price
             * @param ciDay (String): check in day
             * @param ciDay (String): check in day
             * @param startHour (String): start hour
             * @param endHour (String): start hour
             * @param noItems (Number): number of reserved items
             * 
             * @retun coupon price value
             */
                var price = 0,
                timeLapse;
        
                /*
                 * Verify days/hours.
                 */
                coDay = coDay === '' ? ciDay:coDay;
                endHour = endHour === '' ? startHour:endHour;
                
                /*
                 * Calculate price.
                 */
                timeLapse = methods_hours.data['enabled'] ? DOPPrototypes.getHoursDifference(startHour, endHour, 'hours')+(methods_hours.data['addLastHourToTotalPrice'] ? 1:0):
                                                            DOPPrototypes.getNoDays(ciDay, coDay)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 1:0);
                                                    
                price += (coupon['operation'] === '-' ? -1:1)
                         *(coupon['price_by'] === 'once' ? 1:timeLapse)
                         *parseFloat(coupon['price'])
                         *(coupon['price_type'] === 'fixed' ? noItems:(reservationPrice+discountPrice+extrasPrice+feesPrice))/
                         (coupon['price_type'] === 'fixed' ? 1:100);
                
                return price;
            },
            set:function(coupon,
                         reservationPrice,
                         discountPrice,
                         extrasPrice,
                         feesPrice,
                         ciDay,
                         coDay,
                         startHour,
                         endHour,
                         noItems) {
            /*
             * Set coupon details.
             * 
             * @param coupon (Object): coupon data
             * @param reservationPrice (Number): reservation price
             * @param discountPrice (Number): discount price
             * @param extrasPrice (Number): extras price
             * @param feesPrice (Number): fees price
             * @param ciDay (String): check in day
             * @param ciDay (String): check in day
             * @param startHour (String): start hour
             * @param endHour (String): start hour
             * @param noItems (Number): number of reserved items
             * 
             * @retun HTML
             */
                var HTML = new Array(),
                i,
                price = 0;
        
                /*
                 * Verify days/hours.
                 */
                coDay = coDay === '' ? ciDay:coDay;
                endHour = endHour === '' ? startHour:endHour;
                
                if (coupon['price'] > 0){
                    price = methods_coupons.getPrice(coupon,
                                                     reservationPrice,
                                                     discountPrice,
                                                     extrasPrice,
                                                     feesPrice,
                                                     ciDay,
                                                     coDay,
                                                     startHour,
                                                     endHour,
                                                     noItems);
                                                       
                    HTML.push(' <tr class="dopbsp-separator">');
                    HTML.push('     <td class="dopbsp-label"><div class="dopbsp-line"></div></td>');
                    HTML.push('     <td class="dopbsp-value"><div class="dopbsp-line"></div></td>');
                    HTML.push(' </tr>');
                    HTML.push(' <tr>');
                    HTML.push('     <td class="dopbsp-label">'+coupon['translation']+'</td>');
                    HTML.push('     <td class="dopbsp-value dopbsp-info">');
                    HTML.push('         '+coupon['code']+'<br />');
                    
                    if (coupon['price_type'] !== 'fixed' 
                            || coupon['price_by'] !== 'once'){
                        HTML.push('         <span class="dopbsp-info-rule">&#9632;&nbsp;');

                        if (coupon['price_type'] === 'fixed'){
                            HTML.push(coupon['operation']+DOPBSPFrontEnd.setPrice(ID, coupon['price']));
                        }
                        else{
                            HTML.push(coupon['operation']+coupon['price']+'%');
                        }

                        if (coupon['price_by'] !== 'once'){
                            HTML.push('/'+(methods_hours.data['enabled'] ? DOPBSPFrontEnd.text(ID, 'coupons', 'byHour'):DOPBSPFrontEnd.text(ID, 'coupons', 'byDay')));
                        }
                        HTML.push('         </span><br />');
                    }
                    HTML.push('         <span class="dopbsp-info-price">'+coupon['operation']+'&nbsp;'+DOPBSPFrontEnd.setPrice(ID, price)+'</span>');
                    
                    HTML.push('     </td>');
                    HTML.push(' </tr>');
                }
                
                return HTML.join('');
            }
        },

// 19. Reservation
        
        methods_reservation = {
            data: {},
            text: {},
            reservation: {'check_in': '',
                          'check_out': '',
                          'start_hour': '',
                          'end_hour': '',
                          'no_items': 1,
                          'price': 0,
                          'price_total': 0,
                          'extras': new Array(),
                          'extras_price': 0,
                          'discount': {},
                          'discount_price': 0,
                          'coupon': {},
                          'coupon_price': 0,
                          'fees': new Array(),
                          'fees_price': 0,
                          'deposit': {},
                          'deposit_price': 0,
                          'days_hours_history': {}},
            
            display:function(){
            /*
             * Display reservation.
             */
                var HTML = new Array();
                
                HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                HTML.push(' <h3>'+DOPBSPFrontEnd.text(ID, 'reservation', 'title')+'</h3>');
                HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPReservationsAdd-reservation'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPReservationsAdd-reservation'+ID+'" class="dopbsp-button"></a>');
                HTML.push('</div>');
                HTML.push('<div id="DOPBSP-inputs-DOPBSPReservationsAdd-reservation'+ID+'" class="dopbsp-inputs-wrapper">');
                HTML.push(' <div id="DOPBSPReservationsAdd-reservation-cart'+ID+'">');
                HTML.push('     <div class="dopbsp-message">'+(methods_hours.data['enabled'] ? DOPBSPFrontEnd.text(ID, 'reservation', 'selectHours'):DOPBSPFrontEnd.text(ID, 'reservation', 'selectDays'))+'</div>');
                HTML.push(' </div>');
                HTML.push('</div>');
                
                $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
            },
            set:function(){
            /*
             * Set reservation details.
             */    
                var ciDay = $('#DOPBSPReservationsAdd-check-in'+ID).val(),
                coDay = $('#DOPBSPReservationsAdd-check-out'+ID).val() !== undefined ? $('#DOPBSPReservationsAdd-check-out'+ID).val():'',
                endHour = $('#DOPBSPReservationsAdd-end-hour'+ID).val() !== undefined ? $('#DOPBSPReservationsAdd-end-hour'+ID).val():'',
                HTML = new Array(),
                noItems = parseInt($('#DOPBSPReservationsAdd-no-items'+ID).val()),
                startHour = $('#DOPBSPReservationsAdd-start-hour'+ID).val() !== undefined ? $('#DOPBSPReservationsAdd-start-hour'+ID).val():'';
                
                if (!methods_hours.data['enabled']
                        && !methods_days.getAvailability(ciDay, coDay)){
                    methods_reservation.toggleMessages(DOPBSPFrontEnd.text(ID, 'reservation', 'selectDays'), '');
                    methods_reservation.clear();
                    methods_order.clear();
                    
                    return false;
                }
                
                if (methods_hours.data['enabled']
                        && !methods_hours.getAvailability(ciDay, startHour, endHour)){
                    methods_reservation.toggleMessages(DOPBSPFrontEnd.text(ID, 'reservation', 'selectHours'), '');
                    endHour !== '' ? methods_reservation.clear():'';
                    methods_order.clear();
                    
                    return false;
                }
                
                /*
                 * Prevent bookings after the last day available when default availability doesn't exists. 
                 */
                if (methods_hours.data['enabled']
                        && DOT.methods.calendar_schedule.default[ID]['available'] === 0
                        && DOT.methods.calendar_schedule.data[ID][ciDay] === undefined){
                    methods_reservation.toggleMessages(DOPBSPFrontEnd.text(ID, 'reservation', 'selectHours'), '');
                    methods_reservation.clear();
                    DOPBSPBackEnd.toggleMessages('error', 
                                                    DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
                    
                    return false;
                }  
                
                /*
                 * Set reservation data.
                 */
                methods_reservation.reservation['check_in'] = ciDay;
                methods_reservation.reservation['check_out'] = coDay;
                methods_reservation.reservation['start_hour'] = startHour;
                methods_reservation.reservation['end_hour'] = endHour;
                methods_reservation.reservation['no_items'] = noItems;
                methods_reservation.reservation['price'] = noItems*(methods_hours.data['enabled'] ? methods_hours.getPrice(methods_reservation.reservation['check_in'],
                                                                                                                           methods_reservation.reservation['start_hour'],
                                                                                                                           methods_reservation.reservation['end_hour']):
                                                                                                    methods_days.getPrice(methods_reservation.reservation['check_in'],
                                                                                                                          methods_reservation.reservation['check_out']));
                /*
                 * Set reservation extras data.
                 */
                methods_reservation.reservation['extras'] = methods_extras.get(methods_reservation.reservation['price'],
                                                                               methods_reservation.reservation['check_in'],
                                                                               methods_reservation.reservation['check_out'],
                                                                               methods_reservation.reservation['start_hour'],
                                                                               methods_reservation.reservation['end_hour'],
                                                                               methods_reservation.reservation['no_items']);
                methods_reservation.reservation['extras_price'] = methods_extras.getPrice(methods_reservation.reservation['extras'],
                                                                                          methods_reservation.reservation['price'],
                                                                                          methods_reservation.reservation['check_in'],
                                                                                          methods_reservation.reservation['check_out'],
                                                                                          methods_reservation.reservation['start_hour'],
                                                                                          methods_reservation.reservation['end_hour'],
                                                                                          methods_reservation.reservation['no_items']);
                
                /*
                 * Set reservation discount data.
                 */
                methods_reservation.reservation['discount'] = DOPBSPFrontEndDiscounts.get(ID,
                                                                                          methods_reservation.reservation['check_in'],
                                                                                          methods_reservation.reservation['check_out'],
                                                                                          methods_reservation.reservation['start_hour'],
                                                                                          methods_reservation.reservation['end_hour']);
                methods_reservation.reservation['discount_price'] = DOPBSPFrontEndDiscounts.getPrice(ID,
                                                                                                     methods_reservation.reservation['discount'],
                                                                                                     methods_reservation.reservation['price'],
                                                                                                     methods_reservation.reservation['extras_price'],
                                                                                                     methods_reservation.reservation['check_in'],
                                                                                                     methods_reservation.reservation['check_out'],
                                                                                                     methods_reservation.reservation['start_hour'],
                                                                                                     methods_reservation.reservation['end_hour'],
                                                                                                     methods_reservation.reservation['no_items']);
                
                /*
                 * Set reservation fees data.
                 */
                methods_reservation.reservation['fees'] = DOPBSPFrontEndFees.get(ID,
                                                                                 methods_reservation.reservation['price'],
                                                                                 methods_reservation.reservation['discount_price'],
                                                                                 methods_reservation.reservation['extras_price'],
                                                                                 methods_reservation.reservation['check_in'],
                                                                                 methods_reservation.reservation['check_out'],
                                                                                 methods_reservation.reservation['start_hour'],
                                                                                 methods_reservation.reservation['end_hour'],
                                                                                 methods_reservation.reservation['no_items']);
                methods_reservation.reservation['fees_price'] = DOPBSPFrontEndFees.getPrice(ID,
                                                                                            methods_reservation.reservation['fees'],
                                                                                            methods_reservation.reservation['price'],
                                                                                            methods_reservation.reservation['discount_price'],
                                                                                            methods_reservation.reservation['extras_price'],
                                                                                            methods_reservation.reservation['check_in'],
                                                                                            methods_reservation.reservation['check_out'],
                                                                                            methods_reservation.reservation['start_hour'],
                                                                                            methods_reservation.reservation['end_hour'],
                                                                                            methods_reservation.reservation['no_items']);
                
                /*
                 * Set reservation coupon data.
                 */
                methods_reservation.reservation['coupon'] = methods_coupons.get();
                methods_reservation.reservation['coupon_price'] = methods_coupons.getPrice(methods_reservation.reservation['coupon'],
                                                                                           methods_reservation.reservation['price'],
                                                                                           methods_reservation.reservation['discount_price'],
                                                                                           methods_reservation.reservation['extras_price'],
                                                                                           methods_reservation.reservation['fees_price'],
                                                                                           methods_reservation.reservation['check_in'],
                                                                                           methods_reservation.reservation['check_out'],
                                                                                           methods_reservation.reservation['start_hour'],
                                                                                           methods_reservation.reservation['end_hour'],
                                                                                           methods_reservation.reservation['no_items']);
                
                /*
                 * Total price.
                 */
                methods_reservation.reservation['price_total'] = methods_reservation.reservation['price']
                                                                 +methods_reservation.reservation['extras_price']
                                                                 +methods_reservation.reservation['discount_price']
                                                                 +methods_reservation.reservation['fees_price']
                                                                 +methods_reservation.reservation['coupon_price'];
                                                         
                /*
                 * Deposit
                 */
                methods_reservation.reservation['deposit'] = DOPBSPFrontEndDeposit.get(ID);
                methods_reservation.reservation['deposit_price'] = DOPBSPFrontEndDeposit.getPrice(ID,
                                                                                                  methods_reservation.reservation['deposit'],
                                                                                                  methods_reservation.reservation['price_total']);
                
                /*
                 * Set reservation history data.
                 */
                methods_reservation.reservation['days_hours_history'] = methods_hours.data['enabled'] ? methods_hours.getHistory(methods_reservation.reservation['check_in'],
                                                                                                                                 methods_reservation.reservation['start_hour'],
                                                                                                                                 methods_reservation.reservation['end_hour']):
                                                                                                        methods_days.getHistory(methods_reservation.reservation['check_in'],
                                                                                                                                methods_reservation.reservation['check_out']);
                
                /*
                 * Set reservation display.
                 */
                HTML.push('<div class="dopbsp-cart-wrapper">');
                HTML.push(' <table class="dopbsp-cart">');
                HTML.push('     <tbody>');
                HTML.push('         <tr>');
                HTML.push('             <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'search', 'checkIn')+'</td>');
                HTML.push('             <td class="dopbsp-value">'+methods_sidebar.getDateFormat(methods_reservation.reservation['check_in'])+'</td>');
                HTML.push('         </tr>');
                
                if (methods_reservation.reservation['check_out'] !== ''){
                    HTML.push(' <tr>');
                    HTML.push('     <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'search', 'checkOut')+'</td>');
                    HTML.push('     <td class="dopbsp-value">'+methods_sidebar.getDateFormat(methods_reservation.reservation['check_out'])+'</td>');
                    HTML.push(' </tr>');
                }
                
                if (methods_reservation.reservation['end_hour'] !== ''){
                    HTML.push(' <tr>');
                    HTML.push('     <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'search', 'hourStart')+'</td>');
                    HTML.push('     <td class="dopbsp-value">');
                    HTML.push(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(methods_reservation.reservation['start_hour']):
                                                           methods_reservation.reservation['start_hour']);
                    HTML.push('     </td>');
                    HTML.push(' </tr>');
                }
                
                if (methods_reservation.reservation['end_hour'] !== ''){
                    HTML.push(' <tr>');
                    HTML.push('     <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'search', 'hourEnd')+'</td>');
                    HTML.push('     <td class="dopbsp-value">');
                    HTML.push(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(methods_reservation.reservation['end_hour']):
                                                           methods_reservation.reservation['end_hour']);
                    HTML.push('     </td>');
                    HTML.push(' </tr>');
                }
                
                if (methods_sidebar.data['noItems']){
                    HTML.push(' <tr>');
                    HTML.push('     <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'search', 'noItems')+'</td>');
                    HTML.push('     <td class="dopbsp-value">'+methods_reservation.reservation['no_items']+'</td>');
                    HTML.push(' </tr>');
                }
                
                if (methods_reservation.reservation['price'] !== 0){
                    HTML.push(' <tr>');
                    HTML.push('     <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'reservation', 'price')+'</td>');
                    HTML.push('     <td class="dopbsp-value dopbsp-price">');
                    HTML.push(DOPBSPFrontEnd.setPrice(ID, methods_reservation.reservation['price']));
                    HTML.push('     </td>');
                    HTML.push(' </tr>');
                }
                
                /*
                 * Extras
                 */
                HTML.push(methods_extras.set(methods_reservation.reservation['extras'],
                                             methods_reservation.reservation['check_in'],
                                             methods_reservation.reservation['check_out'],
                                             methods_reservation.reservation['start_hour'],
                                             methods_reservation.reservation['end_hour']));
                
                /*
                 * Discounts
                 */
                if (methods_reservation.reservation['price'] !== 0){
                    HTML.push(DOPBSPFrontEndDiscounts.set(ID,
                                                          methods_reservation.reservation['discount'],
                                                          methods_reservation.reservation['price'],
                                                          methods_reservation.reservation['extras_price'],
                                                          methods_reservation.reservation['check_in'],
                                                          methods_reservation.reservation['check_out'],
                                                          methods_reservation.reservation['start_hour'],
                                                          methods_reservation.reservation['end_hour'],
                                                          methods_reservation.reservation['no_items']));
                }
                
                /*
                 * Fees
                 */
                HTML.push(DOPBSPFrontEndFees.set(ID,
                                                 'reservation',
                                                 methods_reservation.reservation['fees'],
                                                 methods_reservation.reservation['check_in'],
                                                 methods_reservation.reservation['check_out'],
                                                 methods_reservation.reservation['start_hour'],
                                                 methods_reservation.reservation['end_hour']));
                
                /*
                 * Coupons
                 */
                if (methods_reservation.reservation['price'] !== 0){
                    HTML.push(methods_coupons.set(methods_reservation.reservation['coupon'],
                                                  methods_reservation.reservation['price'],
                                                  methods_reservation.reservation['discount_price'],
                                                  methods_reservation.reservation['extras_price'],
                                                  methods_reservation.reservation['fees_price'],
                                                  methods_reservation.reservation['check_in'],
                                                  methods_reservation.reservation['check_out'],
                                                  methods_reservation.reservation['start_hour'],
                                                  methods_reservation.reservation['end_hour'],
                                                  methods_reservation.reservation['no_items']));
                }
                
                HTML.push('         <tr class="dopbsp-separator">');
                HTML.push('             <td class="dopbsp-label"></td>');
                HTML.push('             <td class="dopbsp-value"></td>');
                HTML.push('         </tr>');
                    
                /*
                 * Total price.
                 */
                if (methods_reservation.reservation['price_total'] >= 0 && methods_reservation.reservation['price'] !== 0){
                    /*
                     * Deposit
                     */
                    if (methods_reservation.reservation['deposit_price'] > 0){
                        HTML.push(DOPBSPFrontEndDeposit.set(ID,
                                                            methods_reservation.reservation['deposit'],
                                                            methods_reservation.reservation['price_total']));
                    }
                    HTML.push('         <tr class="dopbsp-total">');
                    HTML.push('             <td class="dopbsp-label">'+DOPBSPFrontEnd.text(ID, 'reservation', 'priceTotal')+'</td>');
                    HTML.push('             <td class="dopbsp-value">'+DOPBSPFrontEnd.setPrice(ID, methods_reservation.reservation['price_total'])+'</td>');
                    HTML.push('         </tr>');
                }
                HTML.push('     </tbody>');
                HTML.push(' </table>');
                HTML.push('</div>');
                
                $('#DOPBSPReservationsAdd-reservation-cart'+ID).html(HTML.join(''));
                
                if ($('#DOPBSP-inputs-DOPBSPReservationsAdd-reservation'+ID).offset().top+$('#DOPBSP-inputs-DOPBSPReservationsAdd-reservation'+ID).height() > $(document).scrollTop()+$(window).height()){
                    DOPPrototypes.scrollToY($('#DOPBSP-inputs-DOPBSPReservationsAdd-reservation'+ID).offset().top+$('#DOPBSP-inputs-DOPBSPReservationsAdd-reservation'+ID).height()-$(window).height()+50);
                }
                
                if (methods_extras.validate(methods_reservation.reservation['extras'])){
                    methods_cart.cart[0] = methods_reservation.reservation;
                    methods_order.payment.set();
                    $('#DOPBSPReservationsAdd-order-buttons'+ID).css('display', 'block');
                }
                else{
                    methods_order.clear();
                }
            },
            
            clear:function(){
            /*
             * Clear reservation data.
             */    
                methods_days.vars.selectionEnd = '';
                methods_days.vars.selectionInit = false;
                methods_days.vars.selectionStart = '';
                methods_days.clearSelection();
                
                methods_hours.vars.selectionEnd = '';
                methods_hours.vars.selectionInit = false;
                methods_hours.vars.selectionStart = '';
                $('.DOPBSPReservationsAdd-hour', Container).removeClass('dopbsp-selected');
                
                methods_coupons.vars.use = false;
        
                methods_reservation.reservation = {'check_in': '',
                                                   'check_out': '',
                                                   'start_hour': '',
                                                   'end_hour': '',
                                                   'no_items': 1,
                                                   'price': 0,
                                                   'price_total': 0,
                                                   'extras': new Array(),
                                                   'extras_price': 0,
                                                   'discount': {},
                                                   'discount_price': 0,
                                                   'coupon': {},
                                                   'coupon_price': 0,
                                                   'fees': new Array(),
                                                   'fees_price': 0,
                                                   'deposit': {},
                                                   'deposit_price': 0,
                                                   'days_hours_history': {}};
            },
            toggleMessages:function(message,
                                    type){
            /*
             * Toggle reservation messages.
             * 
             * @param message (String): the message to be displayed
             * @param type (String): message type
             *                       "none"
             *                       "dopbsp-error" error message
             *                       "dopbsp-success" success message
             */
                type = type === undefined ? 'dopbsp-error':type;
                
                $('#DOPBSPReservationsAdd-reservation-cart'+ID).html('<div class="dopbsp-message '+type+'">'+message+'</div>');
            }
        },         
                
// 20. Cart

        methods_cart = {
            cart: new Array()
        },
                
// 21. Form
                
        methods_form = {
            data: {},
            text: {},
            
            display:function(){
            /*
             * Display form.
             */
                var form = methods_form.data['form'],
                formField,
                formFieldOption,
                HTML = new Array (),
                i,
                j;
        
                HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                HTML.push(' <h3>'+DOPBSPFrontEnd.text(ID, 'form', 'title')+'</h3>');
                HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPReservationsAdd-form'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPReservationsAdd-form'+ID+'" class="dopbsp-button"></a>');
                HTML.push('</div>');
                HTML.push('<div id="DOPBSP-inputs-DOPBSPReservationsAdd-form'+ID+'" class="dopbsp-inputs-wrapper">');

                /*
                 * Fields
                 */
                for (i=0; i<form.length; i++){
                    formField = form[i];

                    HTML.push(' <div class="dopbsp-input-wrapper'+(i === form.length-1 ? ' dopbsp-last':'')+'">');

                    switch (formField['type']){
                        case 'checkbox':
                            /*
                             * Checkbox field.
                             */
                            HTML.push('     <label class="dopbsp-for-checkbox-with-width" for="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <input type="checkbox" name="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'" id="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'" />');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info dopbsp-checkbox-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</span></a>');
                            break;
                        case 'select':
                            /*
                             * Select field.
                             */
                            HTML.push('     <label for="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <select name="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+(formField['multiple_select'] === 'true' ? '[]':'')+'" id="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'" value=""'+(formField['multiple_select'] === 'true' ? ' multiple':'')+'>');

                            for (j=0; j<formField['options'].length; j++){
                                formFieldOption = formField['options'][j];
                                HTML.push('<option value="'+formFieldOption['id']+'">'+formFieldOption['translation']+'</option>');
                            }
                            HTML.push('     </select>');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</span></a>');
                            break;
                        case 'text':
                            /*
                             * Text field.
                             */
                            HTML.push('     <label for="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? ' <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <input type="text" name="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'" id="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'" value="" />');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+(formField['is_email'] === 'true' ? DOPBSPFrontEnd.text(ID, 'form', 'invalidEmail'):DOPBSPFrontEnd.text(ID, 'form', 'required'))+'</span></a>');
                            break;
                        case 'textarea':
                            /*
                             * Textarea field.
                             */
                            HTML.push('     <label for="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <textarea name="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'" id="DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']+'" col="" rows="3"></textarea>');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</span></a>');
                            break;
                    }
                    HTML.push(' </div>');
                }
                
                HTML.push('</div>');
                
                $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
                
                methods_form.init();
            },
            init:function(){
            /*
             * Initialize form.
             */    
                var form = methods_form.data['form'],
                formField,
                i;
        
                for (i=0; i<form.length; i++){
                    formField = form[i];
                    
                    /*
                     * Initialize select fields.
                     */
                    if (formField['type'] === 'select'){
                        $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).DOPSelect();
                    }
                }
                
                methods_form.events();
            },
            events:function(){
            /*
             * Initialize form events.
             */    
                var form = methods_form.data['form'],
                formData = {},
                formField,
                i;
        
                for (i=0; i<form.length; i++){
                    formField = form[i];
                    formData[formField['id']] = formField;
                    formData[formField['id']]['size'] = parseInt(formData[formField['id']]['size'], 10);
                        
                    switch (formField['type']){
                        case 'checkbox':
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).unbind('click');
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).bind('click', function(){
                                var id = $(this).attr('id').split('DOPBSPReservationsAdd-form-field'+ID+'_')[1];
                                
                                /*
                                 * Verify if required.
                                 */
                                if (formData[id]['required'] === 'true' 
                                        && !$(this).is(':checked')){
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else{
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'none');
                                }
                            });
                            break;
                        case 'text':
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).unbind('input propertychange blur');
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).bind('input propertychange blur', function(){
                                var id = $(this).attr('id').split('DOPBSPReservationsAdd-form-field'+ID+'_')[1],
                                value;
                                
                                /*
                                 * Verify characters.
                                 */
                                if (formData[id]['allowed_characters'] !== ''){
                                    DOPPrototypes.cleanInput($(this), formData[id]['allowed_characters']);
                                }
                                
                                value = $(this).val();
                                
                                /*
                                 * Verify size.
                                 */
                                if (formData[id]['size'] !== 0){
                                    $(this).val(value.substring(0, formData[id]['size']));
                                }
                                
                                /*
                                 * Verify if required/email.
                                 */
                                if (formData[id]['is_email'] === 'true' 
                                        && (formData[id]['required'] === 'true' 
                                                        && !DOPPrototypes.validEmail(value)
                                                || formData[id]['required'] === 'false' 
                                                        && !DOPPrototypes.validEmail(value)
                                                        && value !== '')){
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else if (formData[id]['required'] === 'true' 
                                            && value === ''){
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else{
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'none');
                                }
                            });
                            break;
                        case 'select':
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).unbind('change');
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).bind('change', function(){
                                var id = $(this).attr('id').split('DOPBSPReservationsAdd-form-field'+ID+'_')[1];
                                
                                /*
                                 * Verify if required.
                                 */
                                if (formData[id]['required'] === 'true' 
                                        && ($(this).val() === '' 
                                            || $(this).val() === null)){
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else{
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'none');
                                }
                            });
                            break;
                        case 'textarea':
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).unbind('input propertychange blur');
                            $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).bind('input propertychange blur', function(){
                                var id = $(this).attr('id').split('DOPBSPReservationsAdd-form-field'+ID+'_')[1],
                                value;
                                
                                /*
                                 * Verify characters.
                                 */
                                if (formData[id]['allowed_characters'] !== ''){
                                    DOPPrototypes.cleanInput($(this), formData[id]['allowed_characters']);
                                }
                                
                                value = $(this).val();
                                
                                /*
                                 * Verify size.
                                 */
                                if (formData[id]['size'] !== 0){
                                    $(this).val(value.substring(0, formData[id]['size']));
                                }
                                
                                /*
                                 * Verify if required.
                                 */
                                if (formData[id]['required'] === 'true' 
                                        && value === ''){
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else{
                                    $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+id).css('display', 'none');
                                }
                            });
                            break;
                    }
                }
            },
            
            get:function(){
            /*
             * Get form valid data.
             * 
             * @return JSON
             */    
                var form = methods_form.data['form'],
                formData = new Array(),
                formField,
                i,
                j,
                k,
                option,
                selectedOptions;
        
                for (i=0; i<form.length; i++){
                    formField = form[i];

                    formData[i] = {"id": "",
                                   "is_email": false,
                                   "add_to_day_hour_info": false,
                                   "add_to_day_hour_body": false,
                                   "translation": "",
                                   "value": ""};
                    formData[i]['id'] = formField['id'];
                    formData[i]['is_email'] = formField['is_email'] === 'true' ? true:false;
                    formData[i]['add_to_day_hour_info'] = formField['add_to_day_hour_info'] === 'true' ? true:false;
                    formData[i]['add_to_day_hour_body'] = formField['add_to_day_hour_body'] === 'true' ? true:false;
                    formData[i]['translation'] = formField['translation'];

                    switch (formField['type']){
                        case 'checkbox':
                            formData[i]['value'] = $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).is(':checked');
                            break;
                        case 'select':
                            option = $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val();
                            
                            if (formField['multiple_select'] === 'true'){
                                selectedOptions = option.split(',');
                                formData[i]['value'] = new Array();

                                for (j=0; j<selectedOptions.length; j++){
                                    for (k=0; k<formField['options'].length; k++){
                                        if (formField['options'][k]['id'] === selectedOptions[j]){
                                            formData[i]['value'][j] = formField['options'][k];
                                        }
                                    }
                                }
                                
                                if (formData[i]['value'].length === 0){
                                    formData[i]['value'] = '';
                                }
                            }
                            else{
                                formData[i]['value'] = '';
                                
                                for (k=0; k<formField['options'].length; k++){
                                    if (formField['options'][k]['id'] === option){
                                        formData[i]['value'] = formField['options'][k]['translation'];
                                        break;
                                    }
                                }
                            }
                            break;
                        default:
                            formData[i]['value'] = $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val();
                    }
                }
                
                return formData;
            },
            validate:function(){
            /*
             * Validate form data.
             * 
             * @return true/false
             */    
                var form = methods_form.data['form'],
                formField,        
                i,
                isValid = true;

                for (i=0; i<form.length; i++){
                    formField = form[i];
                        
                    switch (formField['type']){
                        case 'checkbox':
                            if (formField['required'] === 'true' 
                                    && !$('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).is(':checked')){
                                isValid = false;
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                            }
                            else{
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                            }
                            break;
                        case 'text':
                            if (formField['is_email'] === 'true' 
                                    && (formField['required'] === 'true' 
                                                    && !DOPPrototypes.validEmail($('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val())
                                            || formField['required'] === 'false' 
                                                    && !DOPPrototypes.validEmail($('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val())
                                                    && $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val() !== '')){
                                isValid = false;
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                            }
                            else if (formField['required'] === 'true' 
                                    && $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val() === ''){
                                isValid = false;
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                            }
                            else{
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                            }
                            break;
                        case 'select':
                            if (formField['required'] === 'true' 
                                    && ($('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val() === '' 
                                    || $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val() === null)){
                                isValid = false;
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                            }
                            else{
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                            }
                            break;
                        case 'textarea':
                            if (formField['required'] === 'true' 
                                    && $('#DOPBSPReservationsAdd-form-field'+ID+'_'+formField['id']).val() === ''){
                                isValid = false;
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                            }
                            else{
                                $('#DOPBSPReservationsAdd-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                            }
                            break;
                    }
                }

                return isValid;
            },
            
            getInfo:function(info){
            /*
             * Get form info in day/hour tooltip or body.
             * 
             * @param info (Array): info list
             * 
             * @return info text
             */    
                var i,
                text = new Array();
                
                for (i=0; i<info.length; i++){
                    text.push('ID '+info[i]['reservation_id']+': '+info[i]['data']);
                }
                
                return text.join('<br /><br />');
            }
        },
                
// 22. Order
 
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
            
            display:function(){
            /*
             * Display order.
             * 
             * @return order HTML
             */
                var HTML = new Array (),
                key,
                paymentGateways = methods_order.data['paymentGateways'];
                
                HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                HTML.push(' <h3>'+DOPBSPFrontEnd.text(ID, 'order', 'title')+'</h3>');
                HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPReservationsAdd-order'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPReservationsAdd-order'+ID+'" class="dopbsp-button"></a>');
                HTML.push('</div>');
                HTML.push('<div id="DOPBSP-inputs-DOPBSPReservationsAdd-order'+ID+'" class="dopbsp-inputs-wrapper dopbsp-last">');
                HTML.push(' <div class="dopbsp-input-wrapper">');
                HTML.push('     <label for="DOPBSPReservationsAdd-status'+ID+'">'+DOPBSPFrontEnd.text(ID, 'reservation', 'status')+'</label>');
                HTML.push('     <select name="DOPBSPReservationsAdd-status'+ID+'" id="DOPBSPReservationsAdd-status'+ID+'">');
                HTML.push('         <option value="approved">'+DOPBSPFrontEnd.text(ID, 'reservation', 'statusApproved')+'</option>');
                HTML.push('         <option value="pending">'+DOPBSPFrontEnd.text(ID, 'reservation', 'statusPending')+'</option>');
                HTML.push('     </select>');
                HTML.push(' </div>');

                /*
                 * Payment methods.
                 */
                HTML.push(' <div class="dopbsp-input-wrapper">');
                HTML.push('     <label class="dopbsp-for-radios">'+DOPBSPFrontEnd.text(ID, 'order', 'paymentMethod')+'</label>');
                HTML.push('     <div class="dopbsp-checkboxes-wrapper">');

                /*
                 * No payment.
                 */
                HTML.push('         <input type="radio" name="DOPBSPReservationsAdd-payment'+ID+'" value="none" disabled="disabled" />');
                HTML.push('         <label class="dopbsp-for-radio">'+DOPBSPFrontEnd.text(ID, 'order', 'paymentMethodNone')+'</label>');
                HTML.push('         <br class="DOPBSPReservationsAdd-clear" />');
                
                /*
                 * Pay on arrival.
                 */
                HTML.push('         <input type="radio" name="DOPBSPReservationsAdd-payment'+ID+'" value="default" disabled="disabled" />');
                HTML.push('         <label class="dopbsp-for-radio">'+DOPBSPFrontEnd.text(ID, 'order', 'paymentMethodArrival')+'</label>');
                HTML.push('         <br class="DOPBSPReservationsAdd-clear" />');
                
                /*
                 * Payment gateways.
                 */
                for (key in paymentGateways){
                    HTML.push('     <input type="radio" name="DOPBSPReservationsAdd-payment'+ID+'" value="'+paymentGateways[key]['id']+'" disabled="disabled" />');
                    HTML.push('     <label class="dopbsp-for-radio">'+paymentGateways[key]['text']['title']+'</label>');
                    HTML.push('     <br class="DOPBSPReservationsAdd-clear" />');
                }
                HTML.push('     </div>');
                HTML.push(' </div>');
                
                /*
                 * Transaction ID.
                 */
                HTML.push(' <div class="dopbsp-input-wrapper dopbsp-last">');
                HTML.push('     <label for="DOPBSPReservationsAdd-transaction-id'+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', 'paymentMethodTransactionID')+'</label>');
                HTML.push('     <input type="text" name="DOPBSPReservationsAdd-transaction-id'+ID+'" id="DOPBSPReservationsAdd-transaction-id'+ID+'" value="" />');
                HTML.push('     <br class="DOPBSPReservationsAdd-clear" />');
                HTML.push(' </div>');
                
                /*
                 * Submit button.
                 */
                HTML.push(' <div id="DOPBSPReservationsAdd-order-buttons'+ID+'" class="dopbsp-input-wrapper DOPBSPReservationsAdd-hidden last">');
                HTML.push('     <label>&nbsp;</label>');
                HTML.push('     <input type="submit" name="DOPBSPReservationsAdd-submit'+ID+'" id="DOPBSPReservationsAdd-submit'+ID+'" value="'+DOPBSPFrontEnd.text(ID, 'order', 'book')+'" />');
                HTML.push(' </div>');
                HTML.push('</div>');
                
                $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
                
                methods_order.init();
            },
            init:function(){
            /*
             * Initialize order.
             */    
                $('#DOPBSPReservationsAdd-status'+ID).DOPSelect();
                methods_order.events();
                
                methods_order.payment.address_billing.init();
                methods_order.payment.address_shipping.init();
            },
            events:function(){
            /*
             * Initialize order events.
             */    
                $('#DOPBSPReservationsAdd-submit'+ID).unbind('click');
                $('#DOPBSPReservationsAdd-submit'+ID).bind('click', function(){
                    methods_order.book();
                });
            },
            
            payment: {
                set:function(){
                /*
                 * Set payment methods to be used depending on cart price.
                 */
                    var cart= methods_cart.cart,
                    i,
                    price = 0;

                    for (i=0; i<cart.length; i++){
                        price += cart[i]['price_total'];
                    }

                    if (price > 0){
                        $('input[name=DOPBSPReservationsAdd-payment'+ID+']').removeAttr('disabled');
                        $('input[name=DOPBSPReservationsAdd-payment'+ID+'][value=none]').attr('disabled', 'disabled');
                        $('input[name=DOPBSPReservationsAdd-payment'+ID+'][value=default]').attr('checked', 'checked');
                    }
                    else{
                        $('input[name=DOPBSPReservationsAdd-payment'+ID+']').attr('disabled', 'disabled');
                        $('input[name=DOPBSPReservationsAdd-payment'+ID+'][value=none]').removeAttr('disabled');
                        $('input[name=DOPBSPReservationsAdd-payment'+ID+'][value=none]').attr('checked', 'checked');
                    }
                    $('#DOPBSPReservationsAdd-transaction-id'+ID).parent().removeClass('dopbsp-last');
                    
                    methods_order.payment.address_billing.set();
                    methods_order.payment.address_shipping.set();
                },
            
                address_billing: {
                    display:function(){
                    /*
                     * Display billing address form.
                     */
                        var countries = methods_order.data.countries,
                        fields = methods_order.vars.addressFields, 
                        HTML = new Array (),
                        i,
                        j;
                
                        HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                        HTML.push(' <h3>'+DOPBSPFrontEnd.text(ID, 'order', 'addressBilling')+'</h3>');
                        HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPReservationsAdd-payment-address-billing'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPReservationsAdd-payment-address-billing'+ID+'" class="dopbsp-button"></a>');
                        HTML.push('</div>');
                        HTML.push('<div id="DOPBSP-inputs-DOPBSPReservationsAdd-payment-address-billing'+ID+'" class="dopbsp-inputs-wrapper">');
                        
                        HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-billing-message'+ID+'" class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', 'addressSelectPaymentMethod')+'</div>');

                        for (i=0; i<fields.length; i++){
                            switch (fields[i]['key']){
                                case 'country':
                                    HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-hidden'+(i === fields.length-1 ? ' dopbsp-last':'')+'">');
                                    HTML.push('     <label for="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <select name="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'" id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'">');

                                    for (j=0; j<countries.length; j++){
                                        HTML.push('     <option value="'+countries[j]['code3']+'">'+countries[j]['name']+'</option>');
                                    }
                                    HTML.push('     </select>');
                                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</span></a>');
                                    HTML.push(' </div>');           
                                    
                                    break;
                                case 'zip_code':
                                    HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-hidden'+(i === fields.length-1 ? ' dopbsp-last':'')+'">');
                                    HTML.push('     <label for="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'" id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'" class="dopbsp-small" value="" />');
                                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</span></a>');
                                    HTML.push(' </div>');
                                    
                                    break;
                                default:
                                    HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-hidden'+(i === fields.length-1 ? ' dopbsp-last':'')+'">');
                                    HTML.push('     <label for="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'" id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID+'" value="" />');
                                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+(fields[i]['key'] === 'email' ? DOPBSPFrontEnd.text(ID, 'form', 'invalidEmail'):DOPBSPFrontEnd.text(ID, 'form', 'required'))+'</span></a>');
                                    HTML.push(' </div>');
                            }
                        }
                        HTML.push('</div>');
                        
                        $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
                    },
                    init:function(){
                    /*
                     * Initialize billing address.
                     */    
                        $('#DOPBSPReservationsAdd-payment-address-billing-country'+ID).DOPSelect();
                        methods_order.payment.address_billing.events();
                    },
                    
                    set:function(){
                    /*
                     * Set billing address form.
                     */
                        var fields = methods_order.vars.addressFields, 
                        i,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];

                        if (paymentMethod === 'none'
                                || !data['enabled']){
                            $('#DOPBSPReservationsAdd-payment-address-billing-message'+ID).css('display', 'block')
                                                                                          .html(data['enabled'] ? DOPBSPFrontEnd.text(ID, 'order', 'addressSelectPaymentMethod'):DOPBSPFrontEnd.text(ID, 'order', 'addressBillingDisabled'));
                            return false;
                        }
                        else{
                            $('#DOPBSPReservationsAdd-payment-address-billing-message'+ID).css('display', 'none');
                        }
                        
                        for (i=0; i<fields.length; i++){
                            $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID).css('display', data[fields[i]['key']]['enabled'] ? 'block':'none');
                            $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+' .dopbsp-required').css('display', data[fields[i]['key']]['required'] ? 'inline-block':'none');
                        }
                    },
                    get:function(){
                    /*
                     * Get billing address data.
                     */ 
                        var paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
 
                        if (!data['enabled']){
                            return '';
                        }
                        else{
                            return {"address_first": $('#DOPBSPReservationsAdd-payment-address-billing-address-first'+ID).val(),
                                    "address_second": $('#DOPBSPReservationsAdd-payment-address-billing-address-second'+ID).val(),
                                    "city": $('#DOPBSPReservationsAdd-payment-address-billing-city'+ID).val(),
                                    "company": $('#DOPBSPReservationsAdd-payment-address-billing-company'+ID).val(),
                                    "country": data['country']['enabled'] ? $('#DOPBSPReservationsAdd-payment-address-billing-country'+ID).val():'',
                                    "email": $('#DOPBSPReservationsAdd-payment-address-billing-email'+ID).val(),
                                    "first_name": $('#DOPBSPReservationsAdd-payment-address-billing-first-name'+ID).val(),
                                    "last_name": $('#DOPBSPReservationsAdd-payment-address-billing-last-name'+ID).val(),
                                    "phone": $('#DOPBSPReservationsAdd-payment-address-billing-phone'+ID).val(),
                                    "state": $('#DOPBSPReservationsAdd-payment-address-billing-state'+ID).val(),
                                    "zip_code": $('#DOPBSPReservationsAdd-payment-address-billing-zip-code'+ID).val()};
                        }
                    },
                    validate:function(){
                    /*
                     * Validate billing address data.
                     * 
                     * @return true/false
                     */    
                        var fields = methods_order.vars.addressFields, 
                        i,
                        isValid = true,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
                        
                        if (!data['enabled']){
                            return true;
                        }
                        
                        for (i=0; i<fields.length; i++){
                            if ($('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).val() === ''
                                    && data[fields[i]['key']]['enabled'] 
                                    && data[fields[i]['key']]['required']
                                    && (fields[i]['key'] === 'email'
                                                && !DOPPrototypes.validEmail($('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).val())
                                                || fields[i]['key'] !== 'email')){
                                $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-warning'+ID).css('display', 'block');
                                isValid = false;
                            }
                            else{
                                $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+'-warning'+ID).css('display', 'none');
                            }
                        }

                        return isValid;
                    },
                    
                    events:function(){
                    /*
                     * Initialize billing address events.
                     */   
                        var fields = methods_order.vars.addressFields, 
                        i,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
                        
                        /*
                         * Billing address form fields events.
                         */
                        for (i=0; i<fields.length; i++){
                            switch (fields[i]['key']){
                                case 'country':
                                    break;
                                case 'email':
                                    if (data[fields[i]['key']]['enabled']){
                                        $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            var paymentGateways = methods_order.data['paymentGateways'],
                                            paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                                            data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
                                            
                                            $(this).parent().find('.dopbsp-warning-info').css('display', !DOPPrototypes.validEmail($(this).val()) && $(this).val() !== '' || data['email']['required'] && $(this).val() === ''  ? 'block':'none');
                                        });
                                    }
                                    break;
                                case 'phone':
                                    if (data[fields[i]['key']]['enabled']){
                                        $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            DOPPrototypes.cleanInput($(this), '0123456789+-().');
                                        });
                                    }
                                    break;
                                default:
                                    if (data[fields[i]['key']]['enabled']
                                            && data[fields[i]['key']]['required']){
                                        $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPReservationsAdd-payment-address-billing-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            $(this).parent().find('.dopbsp-button.dopbsp-warning-info').css('display', $(this).val() === '' ? 'block':'none');
                                        });
                                    }
                            }
                        }
                    }
                },
                address_shipping: {
                    display:function(){
                    /*
                     * Display shipping address form.
                     */
                        var countries = methods_order.data.countries,
                        fields = methods_order.vars.addressFields, 
                        HTML = new Array (),
                        i,
                        j;
                
                        HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                        HTML.push(' <h3>'+DOPBSPFrontEnd.text(ID, 'order', 'addressShipping')+'</h3>');
                        HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPReservationsAdd-payment-address-shipping'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPReservationsAdd-payment-address-shipping'+ID+'" class="dopbsp-button"></a>');
                        HTML.push('</div>');
                        HTML.push('<div id="DOPBSP-inputs-DOPBSPReservationsAdd-payment-address-shipping'+ID+'" class="dopbsp-inputs-wrapper">');
                        
                        HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-shipping-message'+ID+'" class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', 'addressSelectPaymentMethod')+'</div>');
                        
                        HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-shipping-copy-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-hidden">');
                        HTML.push('     <input type="checkbox" name="DOPBSPReservationsAdd-payment-address-shipping-copy'+ID+'" id="DOPBSPReservationsAdd-payment-address-shipping-copy'+ID+'" checked="checked">');
                        HTML.push('     <label class="dopbsp-for-checkbox" for="DOPBSPReservationsAdd-payment-address-shipping-copy'+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', 'addressShippingCopy')+'</label>');
                        HTML.push(' </div>');     

                        for (i=0; i<fields.length; i++){
                            switch (fields[i]['key']){
                                case 'country':
                                    HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-hidden'+(i === fields.length-1 ? ' dopbsp-last':'')+'">');
                                    HTML.push('     <label for="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <select name="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'" id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'">');

                                    for (j=0; j<countries.length; j++){
                                        HTML.push('     <option value="'+countries[j]['code3']+'">'+countries[j]['name']+'</option>');
                                    }
                                    HTML.push('     </select>');
                                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</span></a>');
                                    HTML.push(' </div>');           
                                    
                                    break;
                                case 'zip_code':
                                    HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-hidden'+(i === fields.length-1 ? ' dopbsp-last':'')+'">');
                                    HTML.push('     <label for="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'" id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'" class="dopbsp-small" value="" />');
                                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</span></a>');
                                    HTML.push(' </div>');
                                    
                                    break;
                                default:
                                    HTML.push(' <div id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper dopbsp-hidden'+(i === fields.length-1 ? ' dopbsp-last':'')+'">');
                                    HTML.push('     <label for="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'" id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID+'" value="" />');
                                    HTML.push('     <a href="javascript:void(0)" id="DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+(fields[i]['key'] === 'email' ? DOPBSPFrontEnd.text(ID, 'form', 'invalidEmail'):DOPBSPFrontEnd.text(ID, 'form', 'required'))+'</span></a>');
                                    HTML.push(' </div>');
                            }
                        }
                        HTML.push('</div>');
                        
                        $('#DOPBSPReservationsAdd-form'+ID).append(HTML.join(''));
                    },
                    init:function(){
                    /*
                     * Initialize shipping address.
                     */    
                        $('#DOPBSPReservationsAdd-payment-address-shipping-country'+ID).DOPSelect();
                        methods_order.payment.address_shipping.events();
                    },
                    
                    set:function(){
                    /*
                     * Set shipping address form.
                     */
                        var fields = methods_order.vars.addressFields, 
                        i,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'],
                        useBilling = $('#DOPBSPReservationsAdd-payment-address-shipping-copy'+ID).is(':checked');
                          
                        if (paymentMethod === 'none'
                                || !data['enabled']){
                            $('#DOPBSPReservationsAdd-payment-address-shipping-message'+ID).css('display', 'block')
                                                                                           .html(data['enabled'] ? DOPBSPFrontEnd.text(ID, 'order', 'addressSelectPaymentMethod'):DOPBSPFrontEnd.text(ID, 'order', 'addressShippingDisabled'));
                            $('#DOPBSPReservationsAdd-payment-address-shipping-copy-wrapper'+ID).css('display', 'none');
                            
                            return false;
                        }
                        else{
                            $('#DOPBSPReservationsAdd-payment-address-shipping-message'+ID).css('display', 'none');
                            $('#DOPBSPReservationsAdd-payment-address-shipping-copy-wrapper'+ID).css('display', 'block');
                        }
                        
                        for (i=0; i<fields.length; i++){
                            $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID).css('display', data[fields[i]['key']]['enabled'] && !useBilling ? 'block':'none');
                            $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+' .dopbsp-required').css('display', data[fields[i]['key']]['required'] ? 'inline-block':'none');
                        }
                    },
                    get:function(){
                    /*
                     * Get shipping address data.
                     */ 
                        var paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'],
                        useBilling = $('#DOPBSPReservationsAdd-payment-address-shipping-copy'+ID).is(':checked');
 
                        if (!data['enabled']){
                            return '';
                        }
                        else if (useBilling){
                            return 'billing_address';
                        }
                        else{
                            return {"address_first": $('#DOPBSPReservationsAdd-payment-address-shipping-address-first'+ID).val(),
                                    "address_second": $('#DOPBSPReservationsAdd-payment-address-shipping-address-second'+ID).val(),
                                    "city": $('#DOPBSPReservationsAdd-payment-address-shipping-city'+ID).val(),
                                    "company": $('#DOPBSPReservationsAdd-payment-address-shipping-company'+ID).val(),
                                    "country": data['country']['enabled'] ? $('#DOPBSPReservationsAdd-payment-address-shipping-country'+ID).val():'',
                                    "email": $('#DOPBSPReservationsAdd-payment-address-shipping-email'+ID).val(),
                                    "first_name": $('#DOPBSPReservationsAdd-payment-address-shipping-first-name'+ID).val(),
                                    "last_name": $('#DOPBSPReservationsAdd-payment-address-shipping-last-name'+ID).val(),
                                    "phone": $('#DOPBSPReservationsAdd-payment-address-shipping-phone'+ID).val(),
                                    "state": $('#DOPBSPReservationsAdd-payment-address-shipping-state'+ID).val(),
                                    "zip_code": $('#DOPBSPReservationsAdd-payment-address-shipping-zip-code'+ID).val()};
                        }
                    },
                    validate:function(){
                    /*
                     * Validate shipping address data.
                     * 
                     * @return true/false
                     */    
                        var fields = methods_order.vars.addressFields, 
                        i,
                        isValid = true,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'];
                        
                        if (!data['enabled']
                                || $('#DOPBSPReservationsAdd-payment-address-shipping-copy'+ID).is(':checked')){
                            return true;
                        }
                        
                        for (i=0; i<fields.length; i++){
                            if ($('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).val() === ''
                                    && data[fields[i]['key']]['enabled'] 
                                    && data[fields[i]['key']]['required']
                                    && (fields[i]['key'] === 'email'
                                                && !DOPPrototypes.validEmail($('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).val())
                                                || fields[i]['key'] !== 'email')){
                                $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-warning'+ID).css('display', 'block');
                                isValid = false;
                            }
                            else{
                                $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+'-warning'+ID).css('display', 'none');
                            }
                        }

                        return isValid;
                    },
                    
                    events:function(){
                    /*
                     * Initialize shipping address events.
                     */    
                        var fields = methods_order.vars.addressFields, 
                        i,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'];
                
                        /*
                         * Use shipping address event.
                         */
                        $('#DOPBSPReservationsAdd-payment-address-shipping-copy'+ID).unbind('click');
                        $('#DOPBSPReservationsAdd-payment-address-shipping-copy'+ID).bind('click', function(){
                            methods_order.payment.address_shipping.set();
                        }); 
                        
                        /*
                         * Shipping address form fields events.
                         */
                        for (i=0; i<fields.length; i++){
                            switch (fields[i]['key']){
                                case 'country':
                                    break;
                                case 'email':
                                    if (data[fields[i]['key']]['enabled']){
                                        $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            var paymentGateways = methods_order.data['paymentGateways'],
                                            paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val(),
                                            data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'];
                                            
                                            $(this).parent().find('.dopbsp-warning-info').css('display', !DOPPrototypes.validEmail($(this).val()) && $(this).val() !== '' || data['email']['required'] && $(this).val() === ''  ? 'block':'none');
                                        });
                                    }
                                    break;
                                case 'phone':
                                    if (data[fields[i]['key']]['enabled']){
                                        $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            DOPPrototypes.cleanInput($(this), '0123456789+-().');
                                        });
                                    }
                                    break;
                                default:
                                    if (data[fields[i]['key']]['enabled']
                                            && data[fields[i]['key']]['required']){
                                        $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPReservationsAdd-payment-address-shipping-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            $(this).parent().find('.dopbsp-button.dopbsp-warning-info').css('display', $(this).val() === '' ? 'block':'none');
                                        });
                                    }
                            }
                        }
                    }
                }
            },
            clear:function(){
            /*
             * Clear order.
             */    
                $('input[name=DOPBSPReservationsAdd-payment'+ID+']').attr('disabled', 'disabled');
                $('input[name=DOPBSPReservationsAdd-payment'+ID+']').removeAttr('checked');
                $('#DOPBSPReservationsAdd-order-buttons'+ID).css('display', 'none');
                $('#DOPBSPReservationsAdd-transaction-id'+ID).parent().addClass('dopbsp-last');
            },
            
            book:function(){
            /*
             * Book a reservation.
             */    
                var isValid = true,
                paymentMethod = $('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPReservationsAdd-payment'+ID+']:checked').val();
                
                /*
                 * Stop if form, billing address or shipping address are not valid.
                 */
                !methods_form.validate() ? (isValid = false):'';
                !methods_order.payment.address_billing.validate() ? (isValid = false):'';
                !methods_order.payment.address_shipping.validate() ? (isValid = false):'';
                
                if (!isValid){
                    return false;
                }
                
                $('#DOPBSPReservationsAdd-submit'+ID).css('display', 'none');
                DOPBSPBackEnd.toggleMessages('active',
                                      DOPBSPBackEnd.text('MESSAGES_SAVING'));
               
                $.post(ajaxurl, {action: 'dopbsp_reservations_add_book',
                                 calendar_id: ID,
                                 language: methods_calendar.data['language'],
                                 currency: methods_currency.data['sign'],
                                 currency_code: methods_currency.data['code'],
                                 cart_data: methods_cart.cart,
                                 form: methods_form.get(),
                                 address_billing_data: methods_order.payment.address_billing.get(),
                                 address_shipping_data: methods_order.payment.address_shipping.get(),
                                 status: $('#DOPBSPReservationsAdd-status'+ID).val(),
                                 payment_method: paymentMethod,
                                 transaction_id: $('#DOPBSPReservationsAdd-transaction-id'+ID).val()}, function(data){  
                    data = $.trim(data);
                    
                    /*
                     * If period is unavailable reload schedule.
                     */
                    if (data === 'unavailable'){
                        DOPBSPBackEnd.toggleMessages('error',
                                                     DOPBSPFrontEnd.text(ID, 'order', 'unavailable'));
                        methods_reservation.clear();
                        methods_schedule.reset();
                        
                        return false;
                    }
                    
                    /*
                     * If coupon is unavailable remove it from reservation.
                     */
                    if (data === 'unavailable-coupon'){
                        DOPBSPBackEnd.toggleMessages('error',
                                                     DOPBSPFrontEnd.text(ID, 'order', 'unavailableCoupon'));
                        methods_coupons.vars.use = false;
                        methods_reservation.set();
                        
                        return false;
                    }
                    
                    $('#DOPBSPReservationsAdd-submit'+ID).css('display', 'block');

                    DOPBSPBackEnd.toggleMessages('success',
                                                 DOPBSPFrontEnd.text(ID, 'order', 'success'));
                    methods_reservation.clear();

                    /*
                     * Reload schedule if it has been changed after the reservation was made.
                     */
                    if ($('#DOPBSPReservationsAdd-status'+ID).val() === 'approved'){
                        methods_schedule.reset();
                    }
                    else{
                        methods_calendar.display();
                        methods_components.init();
                    }
                });
            }
        };

        return methods.init.apply(this);
    };
})(jQuery);