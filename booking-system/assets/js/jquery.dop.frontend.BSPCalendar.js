
/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.2.0
* File                    : assets/js/jquery.dop.frontend.BSPCalendar.js
* File Version            : 1.4.0
* Created / Last Modified : 30 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end calendar jQuery plugin.
*/

(function($){
    'use strict';
  
    $.fn.DOPBSPCalendar = function(options){
        /*
         * Private variables.
         */
        var Data = {"calendar": {"data": {"bookingStop": 0,
                                          "bookingStartDate": "",
                                          "hidePrice": false,
                                          "hideNoAvailable": false,
                                          "minimumNoAvailable": 1,
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
                                         "type": "percent",
                                         "pay_full_amount": "true"},
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
                                       "interval_autobreak": false,
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
                                       "paymentFull": "Pay full amount",
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
                                        "title": "Search"}},           
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
                    "woocommerce": {"data": {"addToCart": false,
                                             "cartURL": "",
                                             "enabled": false,
                                             "productID": 0,
                                             "redirect": false},
                                    "text": {"addToCart": "Add to cart"}}},
        ajaxURL = '',
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
                        $(window).bind('resize.DOPBSPCalendar', methods.rp);                          
                    }
                });
            },
            parse:function(){
            /*
             * Parse calendar options.
             */    
                ajaxURL = DOPPrototypes.acaoBuster($('a', Container).attr('href'));
                DOT.ajax.url = ajaxURL;
                DOPBSPFrontEnd.calendar[Data['ID']] = Data;
                
                ID = Data['ID'];
		
                methods_calendar.data = Data['calendar']['data'];
                methods_calendar.text = Data['calendar']['text'];
                
                methods_cart.data = Data['cart']['data'];
                methods_cart.text = Data['cart']['text'];
                
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
                
                methods_woocommerce.data = Data['woocommerce']["data"];
                methods_woocommerce.text = Data['woocommerce']["text"];
		
                Container.html('<div class="dopbsp-loader"></div>');

                /*
                 * Verify if a payment has been made.
                 */
                methods_order.payment.verify();
                
                /*
                 * Init months data.
                 */
                methods_months.init();
		
//		DOT.methods.calendar.get(ID);
                methods_search.verify();
                
                /*
                 * Load schedule.
                 */
		DOT.methods.calendar_schedule.data[ID] = {};
                methods_schedule.get(ID);
            },
            rp:function(){
            /*
             * Initialize calendar resize & position. Used for responsive feature.
             */
                /*
                 * Resize & position the sidebar first.
                 */
                methods_sidebar.rp();
                methods_calendar.container.rp();
                methods_calendar.navigation.rp();
                methods_day.rp();
            }
        },           
        
// 2. Schedule

        methods_schedule = {
    
            get: function (id) {
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
                
                $.post(ajaxURL, {action: 'dopbsp_calendar_schedule_get',
                                 dopbsp_frontend_ajax_request: true,
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
                Container.html('<div class="dopbsp-loader"></div>');
                DOT.methods.calendar_schedule.data[ID] = {};
                methods_calendar.vars.display = true;
                methods_calendar.vars.firstYearLoaded = false;
                
                if(DOT.methods.calendar_days.settings[ID]['firstDisplayed'] !== '') {
                    methods_schedule.parse(new Date(DOT.methods.calendar_days.settings[ID]['firstDisplayed']).getFullYear());
                } else {
                    methods_schedule.parse(new Date().getFullYear());
                }
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
                methods_calendar.vars.startDate = new Date(new Date(methods_calendar.data['bookingStartDate'] !== '' ? methods_calendar.data['bookingStartDate'].replace(/-/g, "/"):new Date()).getTime()+methods_calendar.data['bookingStop']*60*1000);
                //new Date(new Date().getTime()+methods_calendar.data['bookingStop']*60*1000);
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
                 * Sidebar
                 */                      
                if (!methods_calendar.data['view']){
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
                     * Reservation
                     */
                    methods_reservation.display();
  
                    /*
                     * Check if WooCommerce is enabled.
                     */
                    if (!methods_woocommerce.data['enabled']){
                        /*
                         * Coupons
                         */
                        if (methods_coupons.data['id'] !== '0'
                           && methods_coupons.data['id'] !== ''){
                            methods_coupons.display();
                        }
                    
                        /*
                         * Cart 
                         */
                        methods_cart.display();

                        /*
                         * methods_form.data['form']
                         */
                        methods_form.display();

                        /*
                         * Order
                         */
                        methods_order.display();
                    }
                    else{
                        methods_woocommerce.init();
                    }
                    
                    /*
                     * Initialize sidebar.
                     */
                    methods_sidebar.init();
                    
                    if($('#DOPBSPCalendar-check-in'+ID).val() !== ''
                      || $('#DOPBSPCalendar-check-out'+ID).val() !== '') {
                        
                        if (methods_hours.data['enabled']
                                && methods_days.vars.selectionStart !== ''){
                            $('#DOPBSPCalendar-start-hour'+ID).val(DOPPrototypes.$_GET('start_hour') !== undefined ? DOPPrototypes.$_GET('start_hour'):'');
                            $('#DOPBSPCalendar-end-hour'+ID).val(DOPPrototypes.$_GET('end_hour') !== undefined ? DOPPrototypes.$_GET('end_hour'):'');
                            methods_hours.vars.selectionInit = false;
                            methods_hours.vars.selectionStart = DOPPrototypes.$_GET('start_hour') !== undefined ? ID+'_'+DOPPrototypes.$_GET('start_hour'):'';
                            if(methods_hours.data['multipleSelect']){
                                methods_hours.vars.selectionEnd = DOPPrototypes.$_GET('end_hour') !== undefined ? ID+'_'+DOPPrototypes.$_GET('end_hour'):'';
                            }
                            else{
                                methods_hours.vars.selectionEnd = methods_hours.vars.selectionStart;
                            }
                            methods_calendar.vars.startDate = new Date(new Date().getTime()+methods_calendar.data['bookingStop']*60*1000);
                            methods_calendar.vars.currMonth = methods_calendar.vars.startDate.getMonth()+1;
                            methods_calendar.vars.currYear = methods_calendar.vars.startDate.getFullYear();
                            methods_calendar.vars.startDay = methods_calendar.vars.startDate.getDate();
                            methods_calendar.vars.startMonth = methods_calendar.vars.startDate.getMonth()+1;
                            methods_calendar.vars.startYear = methods_calendar.vars.startDate.getFullYear(); 
                            methods_days.displaySelection(methods_days.vars.selectionStart);
                        } else {
                            methods_days.displaySelection(methods_days.vars.selectionEnd);
                        }
                        
                        methods_search.set();
                        
                        $('#DOPBSPCalendar-check-out-view'+ID).removeAttr('disabled');
                        
                        methods_reservation.set();
                    }

                    if(DOPPrototypes.$_GET('items') !== undefined) {
                        // Set No Items
                        methods_search.no_items.set(DOPPrototypes.$_GET('items'));
                        methods_reservation.set();
                    }
                }
                
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
                if ($('#DOPBSPCalendar-tooltip'+ID).length !== undefined){
                    $('#DOPBSPCalendar-tooltip'+ID).remove();
                }
                $('body').append('<div class="DOPBSPCalendar-tooltip" id="DOPBSPCalendar-tooltip'+ID+'"></div>');
                methods_tooltip.init();
            },
            init:function(){
            /*
             * Initialize information tooltip.
             */
                var $tooltip = $('#DOPBSPCalendar-tooltip'+ID),
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
             *                       "info-body" display information
             *                       "notes" display notes
             * @param infoData (String): information to be displayed
             */     
                var data = (hour === '' ? (DOT.methods.calendar_schedule.data[ID][day] !== undefined ? DOT.methods.calendar_schedule.data[ID][day]:DOT.methods.calendar_schedule.default[ID]):
                                          (DOT.methods.calendar_schedule.data[ID][day] !== undefined ? DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]:DOT.methods.calendar_schedule.default[ID]['hours'][hour])),
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
                    $('#DOPBSPCalendar-tooltip'+ID).removeClass('dopbsp-text');
                }
                else{
                    $('#DOPBSPCalendar-tooltip'+ID).addClass('dopbsp-text');
                }
                $('#DOPBSPCalendar-tooltip'+ID).html(info)
                                               .css('display', 'block');                         
            },
            clear:function(){
            /*
             * Clear information display.
             */
                $('#DOPBSPCalendar-tooltip'+ID).css('display', 'none');                        
            }
        },
                
// 7. Info
        
        methods_info = {
            vars: {time: 0},
            
            toggleMessages:function(message,
                                    type){
            /*
             * Toggle info messages.
             * 
             * @param message (String): the message to be displayed
             * @param type (String): message type
             *                       "dopbsp-error" error message
             *                       "dopbsp-success" success message
             */         
                type = type === undefined ? 'dopbsp-error':type;
                
                $('#DOPBSPCalendar-info-message'+ID+' .dopbsp-text').html(message);
                $('#DOPBSPCalendar-info-message'+ID).removeClass('dopbsp-success')
                                                    .removeClass('dopbsp-error')
                                                    .addClass(type)
                                                    .css('display', 'block');
                DOPPrototypes.scrollToY($('#DOPBSPCalendar-info-message'+ID).offset().top-100);
                
                if (methods_info.vars.time !== 0){
                    methods_info.vars.time = 15;
                    
                }
                else{
                    methods_info.vars.time = 15;
                    methods_info.timer();
                }
            },
            timer:function(){
            /*
             * Count the number of seconds before the info message is hidden.
             */    
                $('#DOPBSPCalendar-info-message'+ID+' .dopbsp-timer').html('['+DOPPrototypes.getLeadingZero(methods_info.vars.time)+']');
                
                if (methods_info.vars.time === 0){
                    $('#DOPBSPCalendar-info-message'+ID).stop(true, true).fadeOut(300);
                }
                else{
                    setTimeout(function(){
                        methods_info.vars.time--;
                        methods_info.timer();
                    }, 1000);
                }
            }
        },
                
// ***************************************************************************** Calendar

// 8. Calendar
        
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
                HTML.push('<div class="DOPBSPCalendar-container">');                        
                HTML.push('    <div class="DOPBSPCalendar-navigation">');
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
                HTML.push('    <div class="DOPBSPCalendar-calendar"></div>');
                HTML.push('</div>');

                /*
                 * Sidebar/form HTML.
                 */ 
                if (!methods_calendar.data['view']){
                    if ($('#DOPBSPCalendar-outer-sidebar'+ID).length === 0){
                        HTML.push('<div class="DOPBSPCalendar-sidebar dopbsp-style'+methods_sidebar.data['style']+'">'+methods_sidebar.display()+'</div>');
                    }
                    else{
                        HTML.push('<div class="DOPBSPCalendar-sidebar dopbsp-hidden"></div>');
                        $('#DOPBSPCalendar-outer-sidebar'+ID).html(methods_sidebar.display());
                    }
                }
                HTML.push('    <div class="DOPBSPCalendar-clear"></div>');
                
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
                    $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'block');
                } 
                else{
                    $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'none');
                }
                
                if (methods_months.vars.no === methods_months.vars.maxAllowed){
                    $('.DOPBSPCalendar-navigation .dopbsp-add-btn', Container).css('display', 'none');
                    $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).addClass('dopbsp-no-add');
                } 
                else{
                    $('.DOPBSPCalendar-navigation .dopbsp-add-btn', Container).css('display', 'block');
                    $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).removeClass('dopbsp-no-add');
                }

                /*
                 * Initialize previous button.
                 */
                if (year !== methods_calendar.vars.startYear 
                        || month !== methods_calendar.vars.startMonth){
                    $('.DOPBSPCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'block');
                }   

                if (year === methods_calendar.vars.startYear 
                        && month === methods_calendar.vars.startMonth){
                    $('.DOPBSPCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'none');
                }
                methods_day.vars.previousStatus = '';
                methods_day.vars.previousBind = 0;

                if (Container.width() <= 400){
                    $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
                }
                else{
                    $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
                }                        
                $('.DOPBSPCalendar-calendar', Container).html('');

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
                
                    if (Container.width() < 500
                            || (methods_sidebar.data['style'] === 1
                                    && Container.width() < 900)
                            || methods_sidebar.data['style'] === 2
                            || methods_sidebar.data['style'] === 3
                            || (methods_sidebar.data['style'] === 4
                                    && Container.width() < 660)
                            || (methods_sidebar.data['style'] === 5
                                    && Container.width() < 800)){
                        $('.DOPBSPCalendar-container', Container).width(Container.width());
                        
                        if (methods_sidebar.data['style'] === 5){                  
                            $('.DOPBSPCalendar-sidebar', Container).removeAttr('style');            
                        }
                    }
                    else{
                        if (methods_sidebar.data['style'] === 5){
                            $('.DOPBSPCalendar-container', Container).width((Container.width()-21)/2);                            
                            $('.DOPBSPCalendar-sidebar', Container).width((Container.width()-21)/2);                            
                        }
                        else{
                            $('.DOPBSPCalendar-container', Container).width(Container.width()-$('.DOPBSPCalendar-sidebar', Container).width()-parseFloat($('.DOPBSPCalendar-sidebar', Container).css('margin-left'))-1);
                        }
                    }

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

                    if ($('.DOPBSPCalendar-navigation', Container).width() <= 400){
                        $('.DOPBSPCalendar-navigation', Container).addClass('dopbsp-style-small');
                        $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear())); 
                    }
                    else{
                        $('.DOPBSPCalendar-navigation', Container).removeClass('dopbsp-style-small');
                        $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(DOPBSPFrontEnd.text(ID, 'months', 'names')[(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear()));
                    }

                    $('.DOPBSPCalendar-navigation .dopbsp-week .dopbsp-day', Container).width(parseInt(($('.DOPBSPCalendar-navigation .dopbsp-week', Container).width()-parseInt($('.DOPBSPCalendar-navigation .dopbsp-week', Container).css('padding-left'))+parseInt($('.DOPBSPCalendar-navigation .dopbsp-week', Container).css('padding-right')))/7));
                    no = DOT.methods.calendar_days.settings[ID]['first']-1;

                    $('.DOPBSPCalendar-navigation .dopbsp-week .dopbsp-day', Container).each(function(){
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
                    $('.DOPBSPCalendar-navigation .dopbsp-previous-btn', Container).unbind('click');
                    $('.DOPBSPCalendar-navigation .dopbsp-previous-btn', Container).bind('click', function(){
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth-1);

                        if (methods_calendar.vars.currMonth === methods_calendar.vars.startMonth){
                            $('.DOPBSPCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'none');
                        }
                    });

                    /*
                     * Next button event.
                     */
                    $('.DOPBSPCalendar-navigation .dopbsp-next-btn', Container).unbind('click');
                    $('.DOPBSPCalendar-navigation .dopbsp-next-btn', Container).bind('click', function(){
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth+1);
                        $('.DOPBSPCalendar-navigation .dopbsp-previous-btn', Container).css('display', 'block');
                    });

                    /*
                     * Add button event.
                     */
                    $('.DOPBSPCalendar-navigation .dopbsp-add-btn', Container).unbind('click');
                    $('.DOPBSPCalendar-navigation .dopbsp-add-btn', Container).bind('click', function(){
                        methods_months.vars.no++;
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth);
                         
                        if (methods_months.vars.no >= methods_months.vars.maxAllowed){
                            $('.DOPBSPCalendar-navigation .dopbsp-add-btn', Container).css('display', 'none');
                            $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).addClass('dopbsp-no-add');
                        }
                        $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'block');
                        
                        DOPPrototypes.scrollToY($('.DOPBSPCalendar-calendar', Container).offset().top+$('.DOPBSPCalendar-calendar', Container).height()-$(window).height()+10);
                    });

                    /*
                     * Remove button event.
                     */
                    $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).unbind('click');
                    $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).bind('click', function(){
                        methods_months.vars.no--;
                        methods_calendar.init(methods_calendar.vars.startYear, 
                                              methods_calendar.vars.currMonth);

                        if (methods_months.vars.no < methods_months.vars.maxAllowed){
                            $('.DOPBSPCalendar-navigation .dopbsp-add-btn', Container).css('display', 'block');
                            $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).removeClass('dopbsp-no-add');
                        }
                        
                        if(methods_months.vars.no === 1){
                            $('.DOPBSPCalendar-navigation .dopbsp-remove-btn', Container).css('display', 'none');
                        }
                        
                        DOPPrototypes.scrollToY($('.DOPBSPCalendar-calendar', Container).offset().top+$('.DOPBSPCalendar-calendar', Container).height()-$(window).height()+10);
                    });
                }
            }
        },
                  
// 9. Months
        
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
	
       
                if (position > 1){
                    HTML.push('<div class="DOPBSPCalendar-month-year">'+DOPBSPFrontEnd.text(ID, 'months', 'names')[(month%12 !== 0 ? month%12:12)-1]+' '+year+'</div>');
                }
                HTML.push('<div class="DOPBSPCalendar-month" id="DOPBSPCalendar-month-'+ID+'-'+position+'">');

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
                    methods_day.vars.previousStatus = methods_day.vars.previousStatus === '' ? (schedule[prevDay] !== undefined && schedule[prevDay] !== null ? schedule[prevDay]['status']:'none'):methods_day.vars.previousStatus;
                    methods_day.vars.previousBind = methods_day.vars.previousBind === 0 ? (schedule[prevDay] !== undefined && schedule[prevDay] !== null ? schedule[prevDay]['group']:0):methods_day.vars.previousBind;

                        
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
                    
                    methods_calendar.vars.startMonth = parseInt(methods_calendar.vars.startMonth);
                    
                        
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
                                                      day['info_body'],
                                                      day['info_info'], 
                                                      day['price'], 
                                                      day['promo'], 
                                                      day['status']));
                }
                HTML.push('</div>');
                HTML.push('<div class="DOPBSPCalendar-hours" id="'+ID+'_'+year+'-'+DOPPrototypes.getLeadingZero(month)+'_hours"></div>');

                $('.DOPBSPCalendar-calendar', Container).append(HTML.join(''));
            }
        },
 
// 10. Days
        
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
                        $($('.DOPBSPCalendar-day', Container).get().reverse()).each(function(){
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
                        $('.DOPBSPCalendar-day', Container).each(function(){
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
                $('.DOPBSPCalendar-day', Container).removeClass('dopbsp-selected')
                                                   .removeClass('dopbsp-first')
                                                   .removeClass('dopbsp-last'); 
                $('#DOPBSPCalendar-submit'+ID).css('display', 'none');
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
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'rules', 'minTimeLapseDaysWarning').replace(/%d/gi, minNoDays));
			
                        return false;
                    }
                    
                    if (maxNoDays !== 0
                            && noDays > maxNoDays){
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'rules', 'maxTimeLapseDaysWarning').replace(/%d/gi, maxNoDays));
			
                        return false;
                    }
                    
                    /*
                    * Check for availability with the checkin&checkout selected from the calendar
                    */
                    if (DOT.methods.calendar_days.settings[ID]['morningCheckOut'] === true){
                       if (!DOT.methods.calendar_availability.verify(ID, ciDay, coDay)){
                          methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
			
			             return false;
		                }
                    /*
                    * Change the checkout day for the availability interval saved in the database
                    */         
                    coDay= DOPPrototypes.getPrevDay(coDay);
                    }
                    
                    /*
                     * Check if first and last day are not in the middle of a group.
                     */    

		    if (schedule[ciDay] !== undefined
				    && (schedule[ciDay]['bind'] === 2
					    || schedule[ciDay]['bind'] === 3)
			    || schedule[coDay] !== undefined
				    && (schedule[coDay]['bind'] === 1
					    || schedule[coDay]['bind'] === 2)){
			methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'search', 'noServicesSplitGroup'));
			
			return false;
		    }
                    
                    /*
		     * Verify availability.
		     */
		    if (DOT.methods.calendar_availability.verify(ID, ciDay, coDay)){
			return true;
		    }
		    else{
			methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
			
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
                    ciDay = $('#DOPBSPCalendar-check-in'+ID).val();
                    coDay = $('#DOPBSPCalendar-check-out'+ID).val();
                }
                else{                            
                    ciDay = $('#DOPBSPCalendar-check-in'+ID).val();
                    coDay = $('#DOPBSPCalendar-check-in'+ID).val();
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

                    // noDays = DOPPrototypes.getNoDays(ciDay, coDay)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 1:0);
                    
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
                    } else if((DOT.methods.calendar_schedule.default[ID]['status'] === 'available' 
                                || DOT.methods.calendar_schedule.default[ID]['status'] === 'special')){
                        price = parseFloat(DOT.methods.calendar_schedule.default[ID]['price']);
                        promo = parseFloat(DOT.methods.calendar_schedule.default[ID]['promo']);

                        if (price !== 0){
                            totalPrice += promo === 0 || isNaN(promo) ? price:promo;
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
                    
                    if(schedule[currDay] === undefined) {
                        schedule[currDay] = DOT.methods.calendar_schedule.default[ID];
                    }
                    
                    history[currDay]['available'] = schedule[currDay]['available'];
                    history[currDay]['bind'] = schedule[currDay]['bind'];
                    history[currDay]['price'] = schedule[currDay]['price'];
                    history[currDay]['promo'] = schedule[currDay]['promo'];
                    history[currDay]['status'] = schedule[currDay]['status'];
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
                keyTime,
                contentLine1 = '&nbsp;', 
                contentLine2 = '&nbsp;',
                currDate = new Date,
                today = currDate.getFullYear()+'-'+DOPPrototypes.getLeadingZero(currDate.getMonth()+1)+'-'+DOPPrototypes.getLeadingZero(currDate.getDate()),       
                startTime = currDate.getTime() + methods_calendar.data['bookingStop']*60*1000;

                if(methods_hours.data['enabled']) {
                     // Count available
                    if (DOT.methods.calendar_schedule.data[ID][id.split('_')[1]] !== undefined){
                        var hours = DOT.methods.calendar_schedule.data[ID][id.split('_')[1]]['hours'];
                        available = 0;
                        var i = 0;

                        for(var key in hours){

                            if (!methods_hours.data['interval_autobreak']){

                                if((hours[key]['status'] === 'available' || hours[key]['status'] === 'special') && (hours[key]['bind'] === 0 || hours[key]['bind'] === 1)) {
                                    available += hours[key]['available'];
                                }
                                
                                if ((id.split('_')[1]) === today) {
                                    keyTime = new Date(currDate.getFullYear(), currDate.getMonth(), currDate.getDate(), parseInt(key.split(':')[0],10), parseInt(key.split(':')[1], 10));

                                    if (startTime > keyTime.getTime()){
                                        available -= hours[key]['available'];   
                                        }
                                    }
                                
                            }
                            
                            else if(methods_hours.data['interval_autobreak'] && i%2 === 0) {

                                if(hours[key]['status'] === 'available' || hours[key]['status'] === 'special') {
                                    available += hours[key]['available'];
                                }
                                if ((id.split('_')[1]) === today) {
                                    keyTime = new Date(currDate.getFullYear(), currDate.getMonth(), currDate.getDate(), parseInt(key.split(':')[0],10), parseInt(key.split(':')[1], 10));

                                    if (startTime > keyTime.getTime()){
                                        available -= hours[key]['available'];   
                                        }
                                    }
                            }
                            i++;
                        }
                    }  else {
                        // Count available for default availability
                        if (DOT.methods.calendar_schedule.default[ID] !== undefined){
                            var hours = DOT.methods.calendar_schedule.default[ID]['hours'];
                            available = 0;
                            var i = 0;
                            
                            for(var key in hours){

                                if (!methods_hours.data['interval_autobreak']){   
                                   
                                    if (hours[key]['status'] === 'available') {
                                        available += hours[key]['available'];
                                
                                    }
                                    if ((id.split('_')[1]) === today) {
                                        keyTime = new Date(currDate.getFullYear(), currDate.getMonth(), currDate.getDate(), parseInt(key.split(':')[0],10), parseInt(key.split(':')[1], 10));

                                        if (startTime > keyTime.getTime()){
                                            available -= hours[key]['available'];   
                                            }
                                    }
                                    
                                }
                                
                                else if(methods_hours.data['interval_autobreak'] && i%2 === 0) {
                                    
                                    if(hours[key]['status'] === 'available') {
                                        available += hours[key]['available'];
                                
                                    }
                                    if ((id.split('_')[1]) === today){
                                        keyTime = new Date(currDate.getFullYear(), currDate.getMonth(), currDate.getDate(), parseInt(key.split(':')[0],10), parseInt(key.split(':')[1], 10));

                                        if (startTime > keyTime.getTime()) {
                                            available -= hours[key]['available'];
                                        }
                                    }
                                }
                                i++;
                            }
                        } 
                    }
                    
                    if(available < 1
                      && status === 'available') {
                        status = 'booked';
                        price = 0;
                    }
                }
                
                price = parseFloat(price);
                promo = parseFloat(promo);
                methods_days.vars.no++;

                if (price > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = DOPBSPFrontEnd.setPrice(ID, price);
                }

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = DOPBSPFrontEnd.setPrice(ID, promo);;
                }

                if (type !== 'dopbsp-past-day'){
                    switch (status){
                        case 'available':
                            type += ' dopbsp-available';

                            if (bind === 0 
                                    || bind === 1 
                                    || methods_hours.data['enabled']){
                                
                                if(methods_calendar.data['hideNoAvailable']) {
                                    available = '';
                                }
                                
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'availableMultiple')+'</span>';
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
                                }
                                else if (methods_calendar.data['hideNoAvailable']){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
                                }
                                else{
                                    contentLine2 = '<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
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
                                
                                if (methods_calendar.data['hideNoAvailable']) {
                                    available = '';
                                }
                                
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'availableMultiple')+'</span>';
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
                                }
                                else{
                                    contentLine2 = '<span class="dopbsp-no-available-text">'+DOPBSPFrontEnd.text(ID, 'calendar', 'available')+'</span>';
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
                
                var date = id.split('_')[1],
                    year = date.split('-')[0],
                    month = date.split('-')[1],
                    day = date.split('-')[2],
                    season = 'winter';
                
                switch(month){
                    case "03": case "04": case "05":
                        season = 'spring';
                        break;
                    case "06": case "07": case "08":
                        season = 'summer';
                        break;
                    case "09": case "10": case "11":
                        season = 'autumn';
                        break;
                    default:
                        season = 'winter';
                        break;
                }

                dayHTML.push('<div class="DOPBSPCalendar-day dopbsp-season-'+season+' '+type+'" id="'+id+'">');
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
                
                if(!methods_calendar.data['hidePrice']) {
                    dayHTML.push('          <div class="dopbsp-price">'+contentLine1+'</div>');
                }

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    dayHTML.push('          <div class="dopbsp-old-price">'+DOPBSPFrontEnd.setPrice(ID, price)+'</div>');
                }
                dayHTML.push('          <br class="DOPBSPCalendar-clear" />');
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
                var $day = $('.DOPBSPCalendar-day', Container),
                $dayBody = $('.DOPBSPCalendar-day .dopbsp-body', Container),
                $month = $('#DOPBSPCalendar-month-'+ID+'-1'),        
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
                    $('.DOPBSPCalendar-day .dopbsp-bind-middle .dopbsp-body', Container).each(function(){
                        if (maxHeight < $(this).height()){
                            maxHeight = $(this).height();
                        }
                    });

                    $dayBody.height(maxHeight);
                }

                DOPPrototypes.undoHiddenBuster(hiddenBustedItems);
            },  
            
            getInfo:function(info){
                var info = new Array(),
                i;
                
                for (i=0; i<info.length; i++){
                    info.push(info[i]);
                }
                
                return info.join('<br />');
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
                        $('.DOPBSPCalendar-day .dopbsp-co', Container).css('cursor', 'default');
                        $('.DOPBSPCalendar-day .dopbsp-ci', Container).css('cursor', 'default');
                    }

                    if (!DOPPrototypes.isTouchDevice()){
                        /*
                         * Days hover events, not available for devices with touchscreen.
                         */
                        $('.DOPBSPCalendar-day', Container).hover(function(){
                            var day = $(this);

                            if (methods_days.vars.selectionInit){
                                methods_days.displaySelection(day.attr('id'));
                            }
                            
                            if (methods_hours.data['enabled'] 
                                    && methods_hours.data['info'] 
                                    && !day.hasClass('dopbsp-past-day')
                                    && !day.hasClass('dopbsp-selected')
                                    && !day.hasClass('dopbsp-unavailable')
                                    && !day.hasClass('dopbsp-mask')){
                                methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                    '', 
                                                    'hours', 
                                                    methods_hours.displayInfo(day.attr('id')));
                            }
                        }, function(){
                            methods_tooltip.clear();
                        });

                        /*
                         * Info icon events.
                         */
                        $('.DOPBSPCalendar-day .dopbsp-info', Container).hover(function(){
                            methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                '', 
                                                'info');
                        }, function(){
                            methods_tooltip.clear();
                        });
                        
                        /*
                         * Body info events.
                         */
                        $('.DOPBSPCalendar-day .dopbsp-info-body', Container).hover(function(){
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
                        $('.DOPBSPCalendar-day .dopbsp-info', Container).unbind('touchstart');
                        $('.DOPBSPCalendar-day .dopbsp-info', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPCalendar-tooltip'+ID).css({'left': xPos,
                                                                 'top': yPos});
                            methods_tooltip.set($(this).attr('id').split('_')[1], 
                                                '', 
                                                'info');
                        });

                        /*
                         * Body info events on devices with touchscreen.
                         */
                        $('.DOPBSPCalendar-day .dopbsp-info-body', Container).unbind('touchstart');
                        $('.DOPBSPCalendar-day .dopbsp-info-body', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPCalendar-tooltip'+ID).css({'left': xPos,
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
                    $('.DOPBSPCalendar-day', Container).unbind('click');
                    $('.DOPBSPCalendar-day', Container).bind('click', function(){
                        var day = $(this);
                        
                        if (!day.hasClass('dopbsp-mask') 
                                && !day.hasClass('dopbsp-past-day')
                                && !day.hasClass('dopbsp-unavailable')){
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
                    $('.DOPBSPCalendar-day', Container).unbind('click');
                    $('.DOPBSPCalendar-day', Container).bind('click', function(){
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

                                    $('#DOPBSPCalendar-check-in'+ID).val(sDate);
                                    $('#DOPBSPCalendar-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                              DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sDay+', '+sYear:
                                                                              sDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sYear);
                                    $('#DOPBSPCalendar-check-out'+ID).val('');
                                    $('#DOPBSPCalendar-check-out-view'+ID).val(DOPBSPFrontEnd.text(ID, 'search', 'checkOut'))
                                                                          .removeAttr('disabled');

                                    methods_search.days.initDatepicker('#DOPBSPCalendar-check-out-view'+ID,
                                                                       '#DOPBSPCalendar-check-out'+ID,
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
                                    $('#DOPBSPCalendar-check-out-view'+ID).removeAttr('disabled');

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

                                    $('#DOPBSPCalendar-check-in'+ID).val(sDate);
                                    $('#DOPBSPCalendar-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                              DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sDay+', '+sYear:
                                                                              sDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth]+' '+sYear);
                                    $('#DOPBSPCalendar-check-out'+ID).val(eDate);
                                    $('#DOPBSPCalendar-check-out-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                               DOPBSPFrontEnd.text(ID, 'months', 'names')[eMonth]+' '+eDay+', '+eYear:
                                                                               eDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[eMonth]+' '+eYear);
                                    methods_search.days.initDatepicker('#DOPBSPCalendar-check-out-view'+ID,
                                                                       '#DOPBSPCalendar-check-out'+ID,
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
                    $('.DOPBSPCalendar-day', Container).unbind('click');
                    $('.DOPBSPCalendar-day', Container).bind('click', function(){
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

                                $('#DOPBSPCalendar-check-in'+ID).val(sDate);
                                $('#DOPBSPCalendar-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
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

// 11. Hours
         
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
                day = date.split('-')[2],
                weekday = DOT.methods.calendar_day.get(ID,
                                                        year+'-'+month+'-'+day);

                methods_days.vars.selectionInit = false;
                methods_days.vars.selectionStart = id;
                methods_days.vars.selectionEnd = id;
                methods_day.vars.displayedHours = true;
                methods_hours.vars.selectionInit = false;
                methods_hours.vars.selectionStart = '';
                methods_hours.vars.selectionEnd = '';

                $('#DOPBSPCalendar-check-in'+ID).val(date);
                $('#DOPBSPCalendar-check-in-view'+ID).val(methods_calendar.data['dateType'] === 1 ? DOPBSPFrontEnd.text(ID, 'months', 'names')[parseInt(month, 10)-1]+' '+day+', '+year:
                                                                                                    day+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[parseInt(month, 10)-1]+' '+year);
                
                /*
                 * Select day even if status is not available or special.
                 */
                methods_days.displaySelection(methods_days.vars.selectionEnd);
                $('#'+methods_days.vars.selectionStart).addClass('dopbsp-selected');
                methods_search.set();
                
                /*
                 * Check if the weekday is unavailable (from the calendar settings)
                 */

                if (weekday['status'] === 'unavailable'){
                    methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
			
			             return false;
                }

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

                $('.DOPBSPCalendar-hours', Container).css('display', 'none')
                                                     .html('');

                /*
                 * Check for correct hours container when more months are displayed
                 */                                     
                if ($('#'+id).hasClass('dopbsp-next-month')){  
                    $('.DOPBSPCalendar-hours', Container).each(function(){
                        hoursContainer = $(this);
                    });
                    hoursContainer.css('display', 'block')
                                  .html(HTML.join(''));
                }
                else if ($('#'+id).hasClass('dopbsp-last-month')){
                    $($('.DOPBSPCalendar-hours', Container).get().reverse()).each(function(){
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
                
                DOPPrototypes.scrollToY($('#DOPBSPCalendar'+ID+' .DOPBSPCalendar-hours').offset().top-40);
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
                
                $('.DOPBSPCalendar-hour', Container).removeClass('dopbsp-selected');

                if (id < methods_hours.vars.selectionStart){
                    $($('.DOPBSPCalendar-hour', Container).get().reverse()).each(function(){
                        hour = $(this);

                        if (hour.attr('id') >= id 
                                && hour.attr('id') <= methods_hours.vars.selectionStart
                                && !hour.hasClass('dopbsp-past-hour')){
                            hour.addClass('dopbsp-selected');
                        }
                    });
                }
                else{
                    $('.DOPBSPCalendar-hour', Container).each(function(){
                        hour = $(this);   

                        if (hour.attr('id') >= methods_hours.vars.selectionStart 
                                && hour.attr('id') <= id
                                && !hour.hasClass('dopbsp-past-hour')){
                            hour.addClass('dopbsp-selected');
                        }
                    });
                }       

                $('.DOPBSPCalendar-hour.selected .dopbsp-bind-middle', Container).removeAttr('style');  
                $('.DOPBSPCalendar-hour.selected .dopbsp-bind-middle .dopbsp-hour', Container).removeAttr('style');         
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
                $('.DOPBSPCalendar-hours', Container).css('display', 'none')
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
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'rules', 'minTimeLapseHoursWarning').replace(/%d/gi, minNoMinutes/60));
                        return false;
                    }
                    
                    if (maxNoMinutes !== 0
                            && noMinutes > maxNoMinutes){
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'rules', 'maxTimeLapseHoursWarning').replace(/%d/gi, maxNoMinutes/60));
                        return false;
                    }
                                                            
                    /*
                     * Check if first and last hour are not in the middle of a group.
                     */ 
                    lastHour = schedule[day] === undefined ? endHour:methods_hour.getPrev(endHour, hours_definitions); // endHour has bind=0 when using hour intervals(it's the start of the next interval) so we verify the one before it
                    /*
                     * Multiple select is excluded because you cannot select with one click multiple intervals. You must have multiple select enabled.
                     */
                    if (schedule[day] !== undefined && methods_hours.data['multipleSelect'] && (schedule[day]['hours'][startHour]['bind'] === 2 
					|| schedule[day]['hours'][startHour]['bind'] === 3
				|| schedule[day]['hours'][methods_hours.data['interval'] === true ? lastHour:endHour]['bind'] === 1 
					|| schedule[day]['hours'][methods_hours.data['interval'] === true ? lastHour:endHour]['bind'] === 2)){
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'search', 'noServicesSplitGroup'));
                                  
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
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
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
                day = $('#DOPBSPCalendar-check-in'+ID).val();
                
                /*
                 * Verify hours.
                 */
                if (methods_hours.data['multipleSelect']){
                    startHour = $('#DOPBSPCalendar-start-hour'+ID).val();
                    endHour = $('#DOPBSPCalendar-end-hour'+ID).val();
                }
                else{                            
                    startHour = $('#DOPBSPCalendar-start-hour'+ID).val();
                    endHour = $('#DOPBSPCalendar-start-hour'+ID).val();
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
                                
                                if(methods_calendar.data['hideNoAvailable']) {
                                    available = '';
                                }
                                
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
                                
                                if(methods_calendar.data['hideNoAvailable']) {
                                    available = '';
                                }
                                
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

                hourHTML.push('<div class="DOPBSPCalendar-hour'+type+'" id="'+id+'">');
                hourHTML.push('    <div class="dopbsp-bind-top'+((bind === 2 || bind === 3) && (status === 'available' || status === 'special') ? ' dopbsp-enabled':'')+'"><div class="dopbsp-hour">&nbsp;</div></div>');                        
                hourHTML.push('    <div class="dopbsp-bind-middle dopbsp-group'+(status === 'available' || status === 'special' ? bind:'0')+'">');
                hourHTML.push('        <div class="dopbsp-hour">'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hour):hour)+(methods_hours.data['interval'] ? ' - '+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(methods_hour.getNext(hour, hoursDef)):methods_hour.getNext(hour, hoursDef)):'')+'</div>');

                if (price > 0 
                        && type !== ' dopbsp-past-hour' 
                        && (bind === 0 
                                || bind === 1)){
                    
                    if(!methods_calendar.data['hidePrice']) {
                        hourHTML.push('        <div class="'+(promo > 0 ? 'dopbsp-price-promo':'dopbsp-price')+'">'+priceContent+'</div>');
                    }
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
                        $('.DOPBSPCalendar-hour', Container).hover(function(){
                            var hour = $(this);

                            if (methods_hours.vars.selectionInit){
                                methods_hours.displaySelection(hour.attr('id'));
                            }
                        });

                        /*
                         * Info icon event.
                         */
                        $('.DOPBSPCalendar-hour .dopbsp-info', Container).hover(function(){
                            methods_tooltip.set(methods_days.vars.selectionStart.split('_')[1], 
                                                $(this).attr('id').split('_')[1],
                                                'info');
                        }, function(){
                            methods_tooltip.clear();
                        });

                        /*
                         * Body info event.
                         */
                        $('.DOPBSPCalendar-hour .dopbsp-info-body', Container).hover(function(){
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
                        $('.DOPBSPCalendar-hour .dopbsp-info', Container).unbind('touchstart');
                        $('.DOPBSPCalendar-hour .dopbsp-info', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPCalendar-tooltip'+ID).css({'left': xPos,
                                                                 'top': yPos});
                            methods_tooltip.set(methods_days.vars.selectionStart.split('_')[1], 
                                                $(this).attr('id').split('_')[1],
                                                'info');
                        });

                        /*
                         * Body info events on devices with touchscreen.
                         */
                        $('.DOPBSPCalendar-hour .dopbsp-info-body', Container).unbind('touchstart');
                        $('.DOPBSPCalendar-hour .dopbsp-info-body', Container).bind('touchstart', function(e){
                            e.preventDefault();
                            touch = e.originalEvent.touches[0];
                            xPos = touch.clientX+$(document).scrollLeft();
                            yPos = touch.clientY+$(document).scrollTop();
                            $('#DOPBSPCalendar-tooltip'+ID).css({'left': xPos,
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
                    $('.DOPBSPCalendar-hour', Container).unbind('click');
                    $('.DOPBSPCalendar-hour', Container).bind('click', function(){
                        
                        if(!$(this).hasClass('dopbsp-past-hour')) {
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
                        }
                    });
                },
                selectSingle:function(){
                /*
                 * Select single hours event.
                 */
                    /*
                     * Hours click event.
                     */                      
                    $('.DOPBSPCalendar-hour', Container).unbind('click');
                    $('.DOPBSPCalendar-hour', Container).bind('click', function(){
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

// 12. Sidebar

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
                
                HTML.push('<form name="DOPBSPCalendar-form'+ID+'" id="DOPBSPCalendar-form'+ID+'" action="" method="POST" onsubmit="return false;">');
                HTML.push(' <table class="dopbsp-sidebar-content">');
                HTML.push('     <colgroup>');
                HTML.push('         <col class="dopbsp-column1" />');
                HTML.push('         <col class="dopbsp-column-separator-style dopbsp-column2" />');
                HTML.push('         <col class="dopbsp-column3" />');
                HTML.push('     </colgroup>');
                HTML.push('     <tbody>');
                HTML.push('         <tr>');
                HTML.push('             <td class="dopbsp-column1">');
                
                HTML.push('                 <table class="dopbsp-sidebar-content">');
                HTML.push('                     <colgroup>');
                HTML.push('                         <col class="dopbsp-column4" />');
                HTML.push('                         <col class="dopbsp-column-separator-style dopbsp-column5" />');
                HTML.push('                         <col class="dopbsp-column6" />');
                HTML.push('                     </colgroup>');
                HTML.push('                     <tbody>');
                HTML.push('                         <tr>');
                HTML.push('                             <td id="DOPBSPCalendar-sidebar-column-wrapper-1-'+ID+'" class="dopbsp-column4">');
                HTML.push('                                 <div class="dopbsp-row1"></div>');
                HTML.push('                                 <div class="dopbsp-row2"></div>');
                HTML.push('                                 <div class="dopbsp-row3"></div>');
                HTML.push('                                 <div class="dopbsp-row4"></div>');
                HTML.push('                                 <div class="dopbsp-row5"></div>');
                HTML.push('                                 <div class="dopbsp-row6"></div>');
                HTML.push('                                 <div class="dopbsp-row7"></div>');
                HTML.push('                             </td>');
                HTML.push('                             <td class="dopbsp-column-separator dopbsp-column5"></td>');
                HTML.push('                             <td id="DOPBSPCalendar-sidebar-column-wrapper-2-'+ID+'" class="dopbsp-column6">');
                HTML.push('                                 <div class="dopbsp-row1"></div>');
                HTML.push('                                 <div class="dopbsp-row2"></div>');
                HTML.push('                                 <div class="dopbsp-row3"></div>');
                HTML.push('                                 <div class="dopbsp-row4"></div>');
                HTML.push('                                 <div class="dopbsp-row5"></div>');
                HTML.push('                                 <div class="dopbsp-row6"></div>');
                HTML.push('                                 <div class="dopbsp-row7"></div>');
                HTML.push('                             </td>');
                HTML.push('                         </tr>');
                HTML.push('                     </tbody>');
                HTML.push('                 </table>');
                
                HTML.push('             </td>');
                HTML.push('             <td class="dopbsp-column-separator dopbsp-column2"></td>');
                HTML.push('             <td class="dopbsp-column3">');
                
                HTML.push('                 <table class="dopbsp-sidebar-content level2">');
                HTML.push('                     <colgroup>');
                HTML.push('                         <col class="dopbsp-column7" />');
                HTML.push('                         <col class="dopbsp-column-separator-style dopbsp-column8" />');
                HTML.push('                         <col class="dopbsp-column9" />');
                HTML.push('                     </colgroup>');
                HTML.push('                     <tbody>');
                HTML.push('                         <tr>');
                HTML.push('                             <td id="DOPBSPCalendar-sidebar-column-wrapper-3-'+ID+'" class="dopbsp-column7">');
                HTML.push('                                 <div class="dopbsp-row1"></div>');
                HTML.push('                                 <div class="dopbsp-row2"></div>');
                HTML.push('                                 <div class="dopbsp-row3"></div>');
                HTML.push('                                 <div class="dopbsp-row4"></div>');
                HTML.push('                                 <div class="dopbsp-row5"></div>');
                HTML.push('                                 <div class="dopbsp-row6"></div>');
                HTML.push('                                 <div class="dopbsp-row7"></div>');
                HTML.push('                             </td>');
                HTML.push('                             <td class="dopbsp-column-separator dopbsp-column8"></td>');
                HTML.push('                             <td id="DOPBSPCalendar-sidebar-column-wrapper-4-'+ID+'" class="dopbsp-column9">');
                HTML.push('                                 <div class="dopbsp-row1"></div>');
                HTML.push('                                 <div class="dopbsp-row2"></div>');
                HTML.push('                                 <div class="dopbsp-row3"></div>');
                HTML.push('                                 <div class="dopbsp-row4"></div>');
                HTML.push('                                 <div class="dopbsp-row5"></div>');
                HTML.push('                                 <div class="dopbsp-row6"></div>');
                HTML.push('                                 <div class="dopbsp-row7"></div>');
                HTML.push('                             </td>');
                HTML.push('                         </tr>');
                HTML.push('                     </tbody>');
                HTML.push('                 </table>');
                
                HTML.push('             </td>');
                HTML.push('         </tr>');
                HTML.push('     <tbody>');
                HTML.push(' </table>');
                HTML.push('</form>');

                return HTML.join('');
            },
            init:function(){
            /*
             * Initialize sidebar.
             */    
                /*
                 * Hide WooCommerce "Add to cart" button.
                 */
                methods_search.init();
                methods_reservation.init();
                
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
            },
            
            rp:function(){
            /*
             *  Resize & position calendar sidebar. Used for responsive feature.
             */
                var hiddenBustedItems = DOPPrototypes.doHiddenBuster($(Container));

                $('.DOPBSPCalendar-sidebar', Container).removeClass('dopbsp-style1')
                                                       .removeClass('dopbsp-style2')
                                                       .removeClass('dopbsp-style3')
                                                       .removeClass('dopbsp-style4')
                                                       .removeClass('dopbsp-style5')
                                                       .removeClass('dopbsp-style1-medium')
                                                       .removeClass('dopbsp-style2-medium')
                                                       .removeClass('dopbsp-style3-medium')
                                                       .removeClass('dopbsp-style4-medium')
                                                       .removeClass('dopbsp-style5-medium')
                                                       .removeClass('dopbsp-style-small');
                
                if (Container.width() < 500){
                    $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style-small');
                }
                else{
                    switch (methods_sidebar.data['style']){
                        case 2:
                            if (Container.width() < 760){
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style2-medium');
                            }
                            else{
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style2');
                            }
                            break;
                        case 3:
                            if (Container.width() < 1020){
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style3-medium');
                            }
                            else{
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style3');
                            }
                            break;
                        case 4:
                            if (Container.width() < 660){
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style4-medium');
                            }
                            else{
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style4');
                            }
                            break;
                        case 5:
                            if (Container.width() < 800){
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style5-medium');
                            }
                            else{
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style5');
                            }
                            break;
                        default:                 
                            if (Container.width() < 900){
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style1-medium');
                            }
                            else{
                                $('.DOPBSPCalendar-sidebar', Container).addClass('dopbsp-style1');
                            }
                    }
                }

                DOPPrototypes.undoHiddenBuster(hiddenBustedItems);
            }
        },
                
// 13. Search
        
        methods_search = {
            data: {},
            text: {},
            
            display:function(){
            /*
             * Display sidebar search module.
             */    
                var HTML = new Array(),
                position = methods_sidebar.data['positions']['search'];
                
                HTML.push('     <div id="DOPBSPCalendar-search'+ID+'" class="dopbsp-module">');
                
                HTML.push(methods_search.days.display());

                if (methods_hours.data['enabled']){
                    HTML.push(methods_search.hours.display());
                }
                HTML.push(methods_search.no_items.display());
                
                HTML.push('     </div>');
                
                $('#DOPBSPCalendar-sidebar-column-wrapper-'+position['column']+'-'+ID+' .dopbsp-row'+position['row']).html(HTML.join(''));
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
            verify:function(){
              /*
                 * Set first month to be displayed when you get redirected from the search page.
                 * 
                 * @return the first day of the month to be displayed
                 */
                    var HTML = new Array(),
                        check_in = DOPPrototypes.$_GET('check_in') !== undefined ? DOPPrototypes.$_GET('check_in').split('-')[2]+'-'+DOPPrototypes.$_GET('check_in').split('-')[1]+'-'+DOPPrototypes.$_GET('check_in').split('-')[0]:'',
                        check_in_view = DOPBSPFrontEnd.text(ID, 'search', 'checkIn'),
                        check_out = DOPPrototypes.$_GET('check_out') !== undefined ? DOPPrototypes.$_GET('check_out').split('-')[2]+'-'+DOPPrototypes.$_GET('check_out').split('-')[1]+'-'+DOPPrototypes.$_GET('check_out').split('-')[0]:'',
                        check_out_view = DOPBSPFrontEnd.text(ID, 'search', 'checkOut');
                    
                    if(check_in !== '') {
                        var sDay = parseInt(check_in.split('-')[0]),
                            sMonth = parseInt(check_in.split('-')[1]),
                            sYear = parseInt(check_in.split('-')[2]),
                    
                        sMonth = sMonth < 10 ? '0'+sMonth:sMonth;
                        sDay = sDay < 10 ? '0'+sDay:sDay;
                        check_in = sYear+'-'+sMonth+'-'+sDay;
                        var firstday = sYear+'-'+sMonth+'-01';

                    DOT.methods.calendar_days.settings[ID]['firstDisplayed'] = firstday;
                    }  
            },
            days: {
                display:function(){
                /*
                 * Display sidebar search days.
                 * 
                 * @return days search HTML
                 */
                    var HTML = new Array(),
                        check_in = DOPPrototypes.$_GET('check_in') !== undefined ? DOPPrototypes.$_GET('check_in').split('-')[2]+'-'+DOPPrototypes.$_GET('check_in').split('-')[1]+'-'+DOPPrototypes.$_GET('check_in').split('-')[0]:'',
                        check_in_view = DOPBSPFrontEnd.text(ID, 'search', 'checkIn'),
                        check_out = DOPPrototypes.$_GET('check_out') !== undefined ? DOPPrototypes.$_GET('check_out').split('-')[2]+'-'+DOPPrototypes.$_GET('check_out').split('-')[1]+'-'+DOPPrototypes.$_GET('check_out').split('-')[0]:'',
                        check_out_view = DOPBSPFrontEnd.text(ID, 'search', 'checkOut');
                    
                    if(check_in !== '') {
                        var sDay = parseInt(check_in.split('-')[0]),
                            sMonth = parseInt(check_in.split('-')[1]),
                            sYear = parseInt(check_in.split('-')[2]),
                             check_in_view = methods_calendar.data['dateType'] === 1 ? 
                                             DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth-1]+' '+sDay+', '+sYear:
                                             sDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[sMonth-1]+' '+sYear;
                        
                        sMonth = sMonth < 10 ? '0'+sMonth:sMonth;
                        sDay = sDay < 10 ? '0'+sDay:sDay;
                        check_in = sYear+'-'+sMonth+'-'+sDay;
                        methods_days.vars.selectionStart = ID+'_'+check_in;
                    }
                    
                    if(check_out !== '') {
                        var eDay = parseInt(check_out.split('-')[0]),
                            eMonth = parseInt(check_out.split('-')[1]),
                            eYear = parseInt(check_out.split('-')[2]),
                            check_out_view = methods_calendar.data['dateType'] === 1 ? 
                                         DOPBSPFrontEnd.text(ID, 'months', 'names')[eMonth-1]+' '+eDay+', '+eYear:
                                         eDay+' '+DOPBSPFrontEnd.text(ID, 'months', 'names')[eMonth-1]+' '+eYear;
                        
                        eMonth = eMonth < 10 ? '0'+eMonth:eMonth;
                        eDay = eDay < 10 ? '0'+eDay:eDay;
                        check_out = eYear+'-'+eMonth+'-'+eDay;
                        
                        methods_calendar.vars.endYear = eYear;
                        methods_calendar.vars.endMonth = eMonth;
                        methods_calendar.vars.endDay = eDay;
                        if(DOT.methods.calendar_days.settings[ID]['multipleSelect']) {
                            methods_days.vars.selectionEnd = ID+'_'+check_out;
                        }
                        else {
                            methods_days.vars.selectionEnd = ID+'_'+check_in;
                        }
                        methods_days.vars.selectionInit = false;
                    }

                    /*
                     * Check in.
                     */
                    HTML.push('         <div class="dopbsp-input-wrapper DOPBSPCalendar-left">');
                    HTML.push('             <input type="text" name="DOPBSPCalendar-check-in-view'+ID+'" readonly="true" id="DOPBSPCalendar-check-in-view'+ID+'" class="DOPBSPCalendar-check-in-view" value="'+check_in_view+'" />');
                    HTML.push('             <input type="hidden" name="DOPBSPCalendar-check-in'+ID+'" readonly="true" id="DOPBSPCalendar-check-in'+ID+'" value="'+check_in+'" />');
                    HTML.push('         </div>');

                    /*
                     * Check out.
                     */
                    if (!methods_hours.data['enabled'] 
                            && DOT.methods.calendar_days.settings[ID]['multipleSelect']){
                        HTML.push('     <div class="dopbsp-input-wrapper DOPBSPCalendar-left">');
                        HTML.push('         <input type="text" name="DOPBSPCalendar-check-out-view'+ID+'" id="DOPBSPCalendar-check-out-view'+ID+'" class="DOPBSPCalendar-check-out-view" value="'+check_out_view+'" />');
                        HTML.push('         <input type="hidden" name="DOPBSPCalendar-check-out'+ID+'" id="DOPBSPCalendar-check-out'+ID+'" value="'+check_out+'" />');
                        HTML.push('     </div>');
                    }
                    HTML.push('         <br class="DOPBSPCalendar-clear" />');

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
                    
                    methods_calendar.vars.startMonth = parseInt(methods_calendar.vars.startMonth);
                    
                    if(minDate === undefined) {
                        var today = new Date(new Date(methods_calendar.data['bookingStartDate'] !== '' ? methods_calendar.data['bookingStartDate'].replace(/-/g, "/"):new Date()).getTime()+methods_calendar.data['bookingStop']*60*1000);
                        methods_calendar.vars.startDay = today.getDate();
                    }
                    
                    minDate = minDate === undefined ? DOPPrototypes.getNoDays(methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay),
                                                                           methods_calendar.vars.todayYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.todayMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.todayDay))-1:minDate;           
                                                                           
                    $(id).datepicker('destroy');
                    $(id).datepicker({altField: altId,
                                      altFormat: 'yy-mm-dd',
                                      beforeShow: function(input, inst){
                                        $('#ui-datepicker-div').removeClass('DOPBSPCalendar-datepicker')
                                                               .addClass('DOPBSPCalendar-datepicker');
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
                            methods_search.days.initDatepicker('#DOPBSPCalendar-check-in-view'+ID,
                                                               '#DOPBSPCalendar-check-in'+ID);

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
                                    methods_search.days.initDatepicker('#DOPBSPCalendar-check-out-view'+ID,
                                                                       '#DOPBSPCalendar-check-out'+ID);
                                    $('#DOPBSPCalendar-check-out-view'+ID).attr('disabled', 'disabled');
                                    
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
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('click', function(){
                            $(this).val('');
                            methods_hours.clear();
                            methods_search.set();
                        });
                        
                        /*
                         * Check in blur event.
                         */
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('blur');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('blur', function(){  
                            var $this = $(this);
                            
                            if ($this.val() === ''){
                                $this.val(DOPBSPFrontEnd.text(ID, 'search', 'checkIn'));
                            }
                        });
                            
                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPCalendar-check-in'+ID).val();
                            
                            if (methods_search.days.validate(ciDay)){
                                methods_calendar.init(parseInt(ciDay.split('-')[0], 10), 
                                                      parseInt(ciDay.split('-')[1], 10));                                
                                methods_hours.display(ID+'_'+ciDay);
                            }
                            else{
                                $('#DOPBSPCalendar-check-in-view'+ID).val(DOPBSPFrontEnd.text(ID, 'search', 'checkIn'));
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
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('click', function(){
                            $('#DOPBSPCalendar-check-out-view'+ID).val(DOPBSPFrontEnd.text(ID, 'search', 'checkOut'))
                                                                  .attr('disabled', 'disabled');
                            $('#DOPBSPCalendar-check-in'+ID).val('');
                            $('#DOPBSPCalendar-check-out'+ID).val('');

                            $(this).val('');
                            methods_days.vars.selectionInit = false;
                            methods_days.clearSelection();
                            methods_search.set();
                        });

                        /*
                         * Check in blur event.
                         */
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('blur');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('blur', function(){  
                            var $this = $(this);
                            
                            if ($this.val() === ''){
                                $this.val(DOPBSPFrontEnd.text(ID, 'search', 'checkIn'));
                            }
                            methods_search.set();
                        });
                        
                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPCalendar-check-in'+ID).val(),
                            minDateValue;
                            if (methods_search.days.validate(ciDay)){
                                minDateValue = DOPPrototypes.getNoDays(DOPPrototypes.getToday(), ciDay)-(DOT.methods.calendar_days.settings[ID]['morningCheckOut'] ? 0:1);
                                methods_days.vars.selectionInit = true;
                                methods_days.vars.selectionStart = ID+'_'+ciDay;
                                methods_days.vars.selectionEnd = ID+'_'+ciDay;
                                $('#DOPBSPCalendar-check-out-view'+ID).removeAttr('disabled')
                                                                      .val('');
                                $('#DOPBSPCalendar-check-out'+ID).val('');
                                methods_search.days.initDatepicker('#DOPBSPCalendar-check-out-view'+ID,
                                                                   '#DOPBSPCalendar-check-out'+ID,
                                                                   minDateValue);
                                                                   
                                methods_calendar.init(methods_calendar.vars.startYear, 
                                                      parseInt(methods_calendar.vars.startMonth)+DOPPrototypes.getNoMonths(methods_calendar.vars.startYear+'-'+methods_calendar.vars.startMonth+'-'+methods_calendar.vars.startDay, ciDay)-1);
                                methods_days.displaySelection(methods_days.vars.selectionEnd);

                                setTimeout(function(){
                                    $('#DOPBSPCalendar-check-out-view'+ID).val('')
                                                                          .select();  
                                    $('#DOPBSPCalendar-check-out'+ID).val('');
                                }, 100);
                            }
                            else{
                                $('#DOPBSPCalendar-check-in-view'+ID).val(DOPBSPFrontEnd.text(ID, 'search', 'checkIn'));
                            }
                        });
                        
                        /*
                         * Check out click event.
                         */
                        $('#DOPBSPCalendar-check-out-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-check-out-view'+ID).bind('click', function(){  
                            var ciDay = $('#DOPBSPCalendar-check-in'+ID).val();
                            
                            $('#DOPBSPCalendar-check-out-view'+ID).val('');  
                            $('#DOPBSPCalendar-check-out'+ID).val('');      
                            
                            methods_search.set();
      
                            if (ciDay !== ''){
                                methods_days.vars.selectionStart = ID+'_'+ciDay;    
                                methods_days.displaySelection(methods_days.vars.selectionStart);        
                            }
                        });
                        
                        /*
                         * Check out blur event.
                         */
                        $('#DOPBSPCalendar-check-out-view'+ID).unbind('blur');
                        $('#DOPBSPCalendar-check-out-view'+ID).bind('blur', function(){ 
                            var $this = $(this),
                            ciDay = $('#DOPBSPCalendar-check-in'+ID).val();

                            setTimeout(function(){
                                if ($this.val() === ''){
                                    $this.val(DOPBSPFrontEnd.text(ID, 'search', 'checkOut'));
                                }      
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
                        $('#DOPBSPCalendar-check-out-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-check-out-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPCalendar-check-in'+ID).val(),
                            coDay = $('#DOPBSPCalendar-check-out'+ID).val();
                            
                            setTimeout(function(){
                                if (methods_search.days.validate(coDay)){
                                    methods_days.vars.selectionInit = false;
                                    methods_days.vars.selectionStart = ID+'_'+ciDay;
                                    methods_days.vars.selectionEnd = ID+'_'+coDay;

                                    methods_calendar.init(methods_calendar.vars.startYear, 
                                                          parseInt(methods_calendar.vars.startMonth)+DOPPrototypes.getNoMonths(methods_calendar.vars.startYear+'-'+methods_calendar.vars.startMonth+'-'+methods_calendar.vars.startDay, ciDay)-1);
                                    methods_days.displaySelection(methods_days.vars.selectionEnd);
                                    methods_search.set();
                                }
                                else{
                                    $('#DOPBSPCalendar-check-out-view'+ID).val(DOPBSPFrontEnd.text(ID, 'search', 'checkOut'));
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
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('click', function(){
                            $(this).val('');
                            methods_days.vars.selectionInit = false;
                            methods_days.clearSelection();
                            methods_search.set();
                        });

                        /*
                         * Check in blur event.
                         */
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('blur');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('blur', function(){  
                            var $this = $(this);

                            if ($this.val() === ''){
                                $this.val(DOPBSPFrontEnd.text(ID, 'search', 'checkIn'));
                            }
                            methods_search.set();
                        });

                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPCalendar-check-in-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-check-in-view'+ID).bind('change', function(){ 
                            var ciDay = $('#DOPBSPCalendar-check-in'+ID).val();

                            if (methods_search.days.validate(ciDay)){
                                methods_days.vars.selectionStart = ID+'_'+ciDay;
                                methods_days.vars.selectionEnd = ID+'_'+ciDay;

                                methods_calendar.init(methods_calendar.vars.startYear, 
                                                      methods_calendar.vars.startMonth+DOPPrototypes.getNoMonths(methods_calendar.vars.startYear+'-'+methods_calendar.vars.startMonth+'-'+methods_calendar.vars.startDay, ciDay)-1);
                                methods_days.displaySelection(methods_days.vars.selectionEnd);
                                methods_search.set();
                            }
                            else{
                                $('#DOPBSPCalendar-check-in-view'+ID).val(DOPBSPFrontEnd.text(ID, 'search', 'checkIn'));
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
                    HTML.push('     <div id="DOPBSPCalendar-hours-select'+ID+'">');
                    HTML.push('         <div class="dopbsp-input-wrapper DOPBSPCalendar-left">');
                    HTML.push('             <label for="DOPBSPCalendar-start-hour'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'hourStart')+'</label>');
                    HTML.push('             <div id="DOPSelect-DOPBSPCalendar-start-hour'+ID+'" class="dopbsp-small"></div>');
                    HTML.push('         </div>');

                    /*
                     * End hour.
                     */
                    if (methods_hours.data['multipleSelect']){
                        HTML.push('         <div class="dopbsp-input-wrapper DOPBSPCalendar-left">');
                        HTML.push('             <label for="DOPBSPCalendar-end-hour'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'hourEnd')+'</label>');
                        HTML.push('             <div id="DOPSelect-DOPBSPCalendar-end-hour'+ID+'" class="dopbsp-small"></div>');
                        HTML.push('         </div>');
                    }
                    else{
                        HTML.push('         <input type="hidden" name="DOPBSPCalendar-end-hour'+ID+'" id="DOPBSPCalendar-end-hour'+ID+'" value="" />');
                    }
                    HTML.push('         <br class="DOPBSPCalendar-clear">');
                    HTML.push('     </div>');

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
                        startHTML.push('<select name="DOPBSPCalendar-start-hour'+ID+'" id="DOPBSPCalendar-start-hour'+ID+'" class="dopbsp-small">');
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

                        $('#DOPSelect-DOPBSPCalendar-start-hour'+ID).replaceWith(startHTML.join(''));
                        $('#DOPBSPCalendar-start-hour'+ID).DOPSelect();
                    }

                    /*
                     * Set end hour.
                     */
                    if (methods_hours.data['multipleSelect']){
                        endHTML.push('<select name="DOPBSPCalendar-end-hour'+ID+'" id="DOPBSPCalendar-end-hour'+ID+'" class="dopbsp-small">');
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

                        $('#DOPSelect-DOPBSPCalendar-end-hour'+ID).replaceWith(endHTML.join(''));
                        $('#DOPBSPCalendar-end-hour'+ID).DOPSelect();
                    }

                    methods_search.hours.events.init();
                },
                auto:function(toSet){
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
                        startHTML.push('<select name="DOPBSPCalendar-start-hour'+ID+'" id="DOPBSPCalendar-start-hour'+ID+'" class="dopbsp-small">');
                        startHTML.push('    <option value=""></option>');

                        for (i=0; i<hoursDef.length; i++){
                            /*
                             * Check if hour has passed then display.
                             */
                            if (hoursDef[i]['value'] >= DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                    || methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) !== selectedDay){
                                startHTML.push('    <option value="'+hoursDef[i]['value']+'"'+(selectedHourStart === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                            }
                        }
                        startHTML.push('</select>');

                        $('#DOPSelect-DOPBSPCalendar-start-hour'+ID).replaceWith(startHTML.join(''));
                        $('#DOPBSPCalendar-start-hour'+ID).DOPSelect();
                    }

                    /*
                     * Set end hour.
                     */
                    if (methods_hours.data['multipleSelect']){
                        endHTML.push('<select name="DOPBSPCalendar-end-hour'+ID+'" id="DOPBSPCalendar-end-hour'+ID+'" class="dopbsp-small">');
                        endHTML.push('  <option value=""></option>');
                        
                        for (i=0; i<hoursDef.length; i++){
                            if (hoursDef[i]['value'] >= DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin) 
                                    || methods_calendar.vars.startYear+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startMonth)+'-'+DOPPrototypes.getLeadingZero(methods_calendar.vars.startDay) !== selectedDay){
                                if (methods_hours.data['interval'] 
                                        || !methods_hours.data['addLastHourToTotalPrice']){
                                    if (selectedHourStart === undefined
                                            || hoursDef[i]['value'] > selectedHourStart){
                                        endHTML.push('  <option value="'+hoursDef[i]['value']+'"'+(selectedHourEnd === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                    }
                                }
                                else{
                                    if (selectedHourStart === undefined
                                            || hoursDef[i]['value'] >= selectedHourStart){
                                        endHTML.push('  <option value="'+hoursDef[i]['value']+'"'+(selectedHourEnd === hoursDef[i]['value'] ? ' selected="selected"':'')+'>'+(methods_hours.data['ampm'] ? DOPPrototypes.getAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+'</option>');
                                    }
                                }
                            }
                        }
                        endHTML.push('</select>');

                        $('#DOPSelect-DOPBSPCalendar-end-hour'+ID).replaceWith(endHTML.join(''));
                        $('#DOPBSPCalendar-end-hour'+ID).DOPSelect();
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
                        $('#DOPBSPCalendar-start-hour'+ID).unbind('change');
                        $('#DOPBSPCalendar-start-hour'+ID).bind('change', function(){
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
                        $('#DOPBSPCalendar-end-hour'+ID).unbind('change');
                        $('#DOPBSPCalendar-end-hour'+ID).bind('change', function(){
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
                        $('#DOPBSPCalendar-start-hour'+ID).unbind('change');
                        $('#DOPBSPCalendar-start-hour'+ID).bind('change', function(){
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
                        HTML.push('         <div id="DOPBSPCalendar-no-items-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                        HTML.push('             <label for="DOPBSPCalendar-no-items'+ID+'">'+DOPBSPFrontEnd.text(ID, 'search', 'noItems')+'</label>');
                        HTML.push('             <div id="DOPSelect-DOPBSPCalendar-no-items'+ID+'" class="dopbsp-small"></div>');
                        HTML.push('         </div>');
                    }
                    else{
                        HTML.push('         <input type="hidden" name="DOPBSPCalendar-no-items'+ID+'" id="DOPBSPCalendar-no-items'+ID+'" value="1" />');
                    }

                    return HTML.join('');
                },
                set:function(selected){
                /*
                 * Set sidebar search number of items.
                 */
                    var HTML = new Array(),
                    i,    
                    minSwap = methods_calendar.data['minimumNoAvailable'],   //temporary saving the minimumNoAvailable set in the calendar in case you change the day/hour selection
                    noAvailable = methods_hours.data['enabled'] ? methods_hours.getNoAvailable():methods_days.getNoAvailable();
                    selected = selected === undefined ? 1:parseInt(selected);
                    
                    HTML.push('<select name="DOPBSPCalendar-no-items'+ID+'" id="DOPBSPCalendar-no-items'+ID+'" class="dopbsp-small">');
                    
                    if(noAvailable < methods_calendar.data['minimumNoAvailable']
                      && ((!methods_hours.data['enabled'] && $('#DOPBSPCalendar-check-out'+ID).val() !== '')
                      || (methods_hours.data['enabled'] && $('#DOPBSPCalendar-end-hour'+ID).val() !== ''))) {
                        methods_calendar.data['minimumNoAvailable'] = noAvailable;
                    }
                    if(noAvailable < methods_calendar.data['minimumNoAvailable']
                      && (methods_hours.data['enabled'] && !methods_calendar.data['hours_multiple_select']) && $('#DOPBSPCalendar-start-hour'+ID).val() !== '') {
                        methods_calendar.data['minimumNoAvailable'] = noAvailable;
                    }
                    for (i=methods_calendar.data['minimumNoAvailable']; i<=noAvailable; i++){
                        HTML.push(' <option value="'+i+'" '+(selected === i ? 'selected="selected"':'')+'>'+i+'</option>');
                    }
                    HTML.push('</select>');

                    $('#DOPSelect-DOPBSPCalendar-no-items'+ID).replaceWith(HTML.join(''));
                    $('#DOPBSPCalendar-no-items'+ID).DOPSelect();
                    methods_search.no_items.events();
                    methods_calendar.data['minimumNoAvailable'] = minSwap;
                },
                events:function(){
                /*
                 * Initialize sidebar search number of items events.
                 */
                    /*
                     * Number of items change event.
                     */
                    $('#DOPBSPCalendar-no-items'+ID).unbind('change');
                    $('#DOPBSPCalendar-no-items'+ID).bind('change', function(){
                        methods_reservation.set();
                    });
                }
            }
        },
                
// 15. Extras
        
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
                
                HTML.push('<div id="DOPBSPCalendar-extras'+ID+'" class="dopbsp-module">');
                
                /*
                 * Title
                 */
                HTML.push(' <h4>'+DOPBSPFrontEnd.text(ID, 'extras', 'title')+'</h4>');

                /*
                 * List
                 */
                for (i=0; i<extra.length; i++){
                    HTML.push('<div class="dopbsp-input-wrapper">');
                    HTML.push(' <label for="DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']+'">'+extra[i]['translation']+(extra[i]['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                    HTML.push(' <select name="DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']+'" id="DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']+'"'+(extra[i]['multiple_select'] === 'true' ? ' value="[]" multiple class="dopbsp-big"':'')+'>');

                    if(extra[i]['multiple_select'] === 'false'){
                        HTML.push('<option value=""></option>');
                    }

                    for (j=0; j<extra[i]['group_items'].length; j++){
                        groupItem = extra[i]['group_items'][j];
                                
                        if (groupItem['translation'] !== ''){
                            
                            HTML.push('<option value="'+groupItem['id']+'" '+(groupItem['default_value'] === 'yes' ? 'selected="selected"':'')+'>');
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
                HTML.push(' <div class="dopbsp-message DOPBSPCalendar-hidden"></div>');
                HTML.push('</div>');
            
                $('#DOPBSPCalendar-sidebar-column-wrapper-'+methods_sidebar.data['positions']['extras']['column']+'-'+ID+' .dopbsp-row'+methods_sidebar.data['positions']['extras']['row']).html(HTML.join(''));
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
                    $('#DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']).DOPSelect();
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
                    $('#DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']).unbind('change');
                    $('#DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']).bind('change', function(){
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
                                        && $('#DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']).val() === groupItem['id']
                                        && extra[i]['verified'] === false)
                                || (extra[i]['multiple_select'] !== 'false'
                                        && $('#DOPSelect-DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']+'-'+groupItem['id']).is(':checked'))){
                            extra[i]['verified'] = true;
                            
                            extras.push({'group_id': extra[i]['id'],
                                         'group_translation': extra[i]['translation'],
                                         'id': groupItem['id'],
                                         'operation': groupItem['operation'],
                                         'price': parseFloat(groupItem['price']),
                                         'price_by': groupItem['price_by'],
                                         'price_type': groupItem['price_type'],
                                         'no_items_multiply': noItemsMultiply,
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
                validateGroup = true,
                messages = [];
                
                for (i=0; i<extra.length; i++){
                    
                    if (extra[i]['required'] === 'true'){
                        
                        if(extra[i]['multiple_select'] === 'true'){
                            validateGroup = false;
                            
                            for (j=0; j<extras.length; j++){
                                
                                if (extra[i]['id'] === extras[j]['group_id']){
                                    validateGroup = true;
                                }
                            }
                        } else {
                            
                            if($('#DOPBSPCalendar-extras-group'+ID+'-'+extra[i]['id']).val() !== '') {
                                validateExtras = true;
                                validateGroup = true;
                            } else {
                                validateExtras = false;
                            }
                        }
                        
                        if (!validateGroup
                            || !validateExtras){
                            validateExtras = false;
                            
                            messages.push(DOPBSPFrontEnd.text(ID, 'extras', 'invalid')+' '+extra[i]['translation']+'.');
                        }
                    }
                }
                
                if (messages.length > 0){
                    methods_extras.toggleMessages(messages.join('<br>'));
                    $('#DOPBSPCalendar-add-to-cart'+ID).css('display', 'none');
                    $('#DOPBSPCalendar-pay-full-amount-wrapper'+ID).addClass('DOPBSPCalendar-hidden');
                    $('.cart button[type=submit]').css('display', 'none');
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
                
                $('#DOPBSPCalendar-extras'+ID+' .dopbsp-message').html(message)
                                                                 .removeClass('dopbsp-success')
                                                                 .removeClass('dopbsp-error')
                                                                 .addClass(type)
                                                                 .css('display', display);
            }
        },
                
// 18. Coupons
        
        methods_coupons = {
            data: {},
            text: {},
            vars: {use: false},
            
            display:function(){
            /*
             * Display extras.
             */
                var HTML = new Array();
                
                HTML.push('<div id="DOPBSPCalendar-coupons'+ID+'" class="dopbsp-module">');
                
                /*
                 * Title
                 */
                HTML.push(' <h4>'+DOPBSPFrontEnd.text(ID, 'coupons', 'title')+'</h4>');
                
                /*
                 * Code
                 */     
                HTML.push(' <div class="dopbsp-input-wrapper">');
                HTML.push('     <label for="DOPBSPCalendar-coupons-code'+ID+'">'+DOPBSPFrontEnd.text(ID, 'coupons', 'code')+'</label>');
                HTML.push('     <input type="text" name="DOPBSPCalendar-coupons-code'+ID+'" id="DOPBSPCalendar-coupons-code'+ID+'" value="" />');
                HTML.push(' </div>');
                
                /*
                 * Buttons
                 */
                HTML.push(' <div class="dopbsp-input-wrapper">');
                HTML.push('     <input type="button" name="DOPBSPCalendar-coupons-verify'+ID+'" id="DOPBSPCalendar-coupons-verify'+ID+'" class="DOPBSPCalendar-hidden" value="'+DOPBSPFrontEnd.text(ID, 'coupons', 'verify')+'" />');
                HTML.push('     <input type="button" name="DOPBSPCalendar-coupons-use'+ID+'" id="DOPBSPCalendar-coupons-use'+ID+'" class="DOPBSPCalendar-hidden" value="'+DOPBSPFrontEnd.text(ID, 'coupons', 'use')+'" />');
                HTML.push('     <div id="DOPBSPCalendar-coupons-loader'+ID+'" class="dopbsp-submit-loader DOPBSPCalendar-hidden"></div>');
                HTML.push(' </div>');
                
                /*
                 * Message
                 */
                HTML.push(' <div class="dopbsp-message DOPBSPCalendar-hidden"></div>');
                HTML.push('</div>');
            
                $('#DOPBSPCalendar-sidebar-column-wrapper-'+methods_sidebar.data['positions']['coupons']['column']+'-'+ID+' .dopbsp-row'+methods_sidebar.data['positions']['coupons']['row']).html(HTML.join(''));
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
                $('#DOPBSPCalendar-coupons-code'+ID).unbind('input propertychange blur');
                $('#DOPBSPCalendar-coupons-code'+ID).bind('input propertychange blur', function(){
                    if ($(this).val() === ''){
                        $('#DOPBSPCalendar-coupons-verify'+ID).css('display', 'none');
                        $('#DOPBSPCalendar-coupons-verify'+ID).addClass('DOPBSPCalendar-hidden');
                    }
                    else{
                        $('#DOPBSPCalendar-coupons-verify'+ID).css('display', 'block');
                        $('#DOPBSPCalendar-coupons-verify'+ID).removeClass('DOPBSPCalendar-hidden');
                    }
                    $('#DOPBSPCalendar-coupons-use'+ID).css('display', 'none');
                    $('#DOPBSPCalendar-coupons-use'+ID).addClass('DOPBSPCalendar-hidden');
                    $('#DOPBSPCalendar-coupons-loader'+ID).css('display', 'none');
                    $('#DOPBSPCalendar-coupons-loader'+ID).addClass('DOPBSPCalendar-hidden');
                    methods_coupons.toggleMessages('', 'none');
                });
                
                /*
                 * Verify button.
                 */
                $('#DOPBSPCalendar-coupons-verify'+ID).unbind('click');
                $('#DOPBSPCalendar-coupons-verify'+ID).bind('click', function(){
                    methods_coupons.verify();
                });
                
                /*
                 * Use button.
                 */
                $('#DOPBSPCalendar-coupons-use'+ID).unbind('click');
                $('#DOPBSPCalendar-coupons-use'+ID).bind('click', function(){
                    methods_coupons.vars.use = true;
                    methods_reservation.set();
                    
                    $('#DOPBSPCalendar-coupons-code'+ID).val('');
                    $('#DOPBSPCalendar-coupons-use'+ID).css('display', 'none');
                    methods_coupons.toggleMessages('', 'none');
                });
            },
            verify:function(){
            /*
             * Verify coupon code.
             */  
                var currDate = new Date,
                today = currDate.getFullYear()+'-'+DOPPrototypes.getLeadingZero(currDate.getMonth()+1)+'-'+DOPPrototypes.getLeadingZero(currDate.getDate()),
                currTime = DOPPrototypes.getLeadingZero(currDate.getHours())+':'+DOPPrototypes.getLeadingZero(currDate.getMinutes());
                
                $('#DOPBSPCalendar-coupons-code'+ID).attr('disabled', 'disabled');
                $('#DOPBSPCalendar-coupons-verify'+ID).css('display', 'none');
                $('#DOPBSPCalendar-coupons-verify'+ID).addClass('DOPBSPCalendar-hidden');
                $('#DOPBSPCalendar-coupons-use'+ID).css('display', 'none');
                $('#DOPBSPCalendar-coupons-use'+ID).addClass('DOPBSPCalendar-hidden');
                methods_coupons.toggleMessages('', 'none');
                $('#DOPBSPCalendar-coupons-loader'+ID).css('display', 'block');
                $('#DOPBSPCalendar-coupons-loader'+ID).removeClass('DOPBSPCalendar-hidden');
               
                $.post(ajaxURL, {action: 'dopbsp_coupons_verify',
                                 dopbsp_frontend_ajax_request: true,
                                 code: $('#DOPBSPCalendar-coupons-code'+ID).val(),
                                 calendar_id: ID,
                                 today: today,
                                 check_in: methods_reservation.reservation['check_in'],
                                 check_out: methods_reservation.reservation['check_out'],
                                 start_hour: methods_reservation.reservation['start_hour'],
                                 end_hour: methods_reservation.reservation['end_hour'],
                                 language: methods_calendar.data['language'],
                                 curr_time: currTime}, function(data){  
                    data = $.trim(data);
                    
                    $('#DOPBSPCalendar-coupons-code'+ID).removeAttr('disabled');
                    $('#DOPBSPCalendar-coupons-loader'+ID).css('display', 'none');
                    $('#DOPBSPCalendar-coupons-loader'+ID).addClass('DOPBSPCalendar-hidden');
                    
                    if (data !== 'error'){
                        methods_coupons.data['coupon'] = JSON.parse(data);
                        methods_coupons.vars.use = false;
                        $('#DOPBSPCalendar-coupons-use'+ID).css('display', 'block');
                        $('#DOPBSPCalendar-coupons-use'+ID).removeClass('DOPBSPCalendar-hidden');
                        methods_coupons.toggleMessages(DOPBSPFrontEnd.text(ID, 'coupons', 'verifySuccess'),
                                                       'block',
                                                       'dopbsp-success');
                    }
                    else{
                        $('#DOPBSPCalendar-coupons-verify'+ID).css('display', 'block');
                        $('#DOPBSPCalendar-coupons-verify'+ID).removeClass('DOPBSPCalendar-hidden');
                        methods_coupons.vars.use = true;
                        methods_coupons.toggleMessages(DOPBSPFrontEnd.text(ID, 'coupons', 'verifyError'),
                                                       'block',
                                                       'dopbsp-error');
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
        
                /*
                 * Coupons are not used in WooCommerce.
                 */
                if (methods_woocommerce.data['enabled']){
                    return coupon;
                }
                
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
                 * Coupons are not used in WooCommerce.
                 */
                if (methods_woocommerce.data['enabled']){
                    return price;
                }
        
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
            },
            
            toggleMessages:function(message,
                                    display,
                                    type){
            /*
             * Toggle coupons messages.
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
                
                $('#DOPBSPCalendar-coupons'+ID+' .dopbsp-message').html(message)
                                                                  .removeClass('dopbsp-success')
                                                                  .removeClass('dopbsp-error')
                                                                  .addClass(type)
                                                                  .css('display', display);
                
                if(display === 'dopbsp-error') {
                    $('#DOPBSPCalendar-coupons'+ID+' .dopbsp-message').addClass('DOPBSPCalendar-hidden');
                } else {
                    $('#DOPBSPCalendar-coupons'+ID+' .dopbsp-message').removeClass('DOPBSPCalendar-hidden');
                }
            }
        },

// 20. Reservation
        
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
                
                HTML.push(' <div id="DOPBSPCalendar-reservation'+ID+'" class="dopbsp-module">');
                HTML.push('     <h4>'+DOPBSPFrontEnd.text(ID, 'reservation', 'title')+'</h4>');
                HTML.push('     <div id="DOPBSPCalendar-reservation-cart'+ID+'">');
                HTML.push('         <div class="dopbsp-message">'+(methods_hours.data['enabled'] ? DOPBSPFrontEnd.text(ID, 'reservation', 'selectHours'):DOPBSPFrontEnd.text(ID, 'reservation', 'selectDays'))+'</div>');
                HTML.push('     </div>');

                /*
                 * Add to cart button.
                 */
                if (methods_cart.data['enabled']
                        || (methods_woocommerce.data['enabled']
                                && methods_woocommerce.data['addToCart'])){

                    /*
                     * Pay full amount.
                     */
                    var dataDeposit = DOPBSPFrontEnd.calendar[ID]['deposit']['data'];

                    if (dataDeposit['deposit'] > 0
                       && dataDeposit['pay_full_amount'] === 'true'){
                        HTML.push(' <div class="dopbsp-input-wrapper DOPBSPCalendar-hidden dopbsp-add-to-cart-wrapper" id="DOPBSPCalendar-pay-full-amount-wrapper'+ID+'" style="margin-top: 20px;">');
                        HTML.push('     <input type="checkbox" name="DOPBSPCalendar-pay-full-amount'+ID+'" id="DOPBSPCalendar-pay-full-amount'+ID+'" />');
                        HTML.push('     <label class="dopbsp-for-checkbox" for="DOPBSPCalendar-pay-full-amount'+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', 'paymentFull')+'</label>');
                        HTML.push(' </div>');
                    }
                    
                    HTML.push('     <div class="dopbsp-input-wrapper dopbsp-add-to-cart-wrapper">');
                    HTML.push('         <input type="submit" name="DOPBSPCalendar-add-to-cart'+ID+'" id="DOPBSPCalendar-add-to-cart'+ID+'" value="'+DOPBSPFrontEnd.text(ID, 'woocommerce', 'addToCart')+'" />');
                    HTML.push('         <div id="DOPBSPCalendar-add-to-cart-loader'+ID+'" class="dopbsp-submit-loader DOPBSPCalendar-hidden"></div>');
                    HTML.push('     </div>');
                }
                HTML.push(' </div>');
                
                $('#DOPBSPCalendar-sidebar-column-wrapper-'+methods_sidebar.data['positions']['reservation']['column']+'-'+ID+' .dopbsp-row'+methods_sidebar.data['positions']['reservation']['row']).html(HTML.join(''));
            },
            init:function(){
            /*
             * Initialize reservation.
             */
                methods_reservation.events();
            },
            set:function(){
            /*
             * Set reservation details.
             */    
                var ciDay = $('#DOPBSPCalendar-check-in'+ID).val(),
                coDay = $('#DOPBSPCalendar-check-out'+ID).val() !== undefined ? $('#DOPBSPCalendar-check-out'+ID).val():'',
                endHour = $('#DOPBSPCalendar-end-hour'+ID).val() !== undefined ? $('#DOPBSPCalendar-end-hour'+ID).val():'',
                HTML = new Array(),
                noItems = parseInt($('#DOPBSPCalendar-no-items'+ID).val()),
                startHour = $('#DOPBSPCalendar-start-hour'+ID).val() !== undefined ? $('#DOPBSPCalendar-start-hour'+ID).val():'';
        
                if (!methods_hours.data['enabled']
                        && !methods_days.getAvailability(ciDay, coDay)){
                    methods_reservation.toggleMessages(DOPBSPFrontEnd.text(ID, 'reservation', 'selectDays'), '');
                    methods_reservation.clear();
                    methods_order.payment.set();

                    return false;
                }

                if (methods_hours.data['enabled']
                        && !methods_hours.getAvailability(ciDay, startHour, endHour)){
                    methods_reservation.toggleMessages(DOPBSPFrontEnd.text(ID, 'reservation', 'selectHours'), '');
                    endHour !== '' ? methods_reservation.clear():'';
                    methods_order.payment.set();

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
                    methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'search', 'noServices'));
                    
                    return false;
                }

                /*
                 * Set reservation data.
                 */
                methods_reservation.reservation['check_in'] = ciDay;
                methods_reservation.reservation['check_out'] = coDay;
                methods_reservation.reservation['start_hour'] = startHour;
                methods_reservation.reservation['end_hour'] = methods_hours.data['multipleSelect'] ? endHour:'';
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
                
                // Pay full deposit
                methods_reservation['pay_full'] = methods_reservation['pay_full'] === undefined ? false:$('input[name=DOPBSPCalendar-pay-full-amount'+ID+']').is(':checked');
                
                window.methods_reservation = methods_reservation;
                
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
                methods_reservation.reservation['price_total'] = parseFloat(methods_reservation.reservation['price_total'].toFixed(2));
                                                         
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
                
                if (methods_reservation.reservation['start_hour'] !== ''){
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
                if (methods_reservation.reservation['price'] !== 0
                    || methods_reservation.reservation['extras_price'] !== 0){
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
                if (methods_reservation.reservation['price_total'] >= 0 && methods_reservation.reservation['price']){
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
                
                $('#DOPBSPCalendar-reservation-cart'+ID).html(HTML.join(''));
                
                /*
                 * Scroll to reservation or to add to cart button for WooCommerce.
                 */
                if (methods_woocommerce.data['enabled']
                        && !methods_woocommerce.data['addToCart']){
                    if ($('.cart').offset().top+$('.cart').height() < $(document).scrollTop()){
                        DOPPrototypes.scrollToY($('.cart').offset().top+$('.cart').height()-200);
                    }
                }
                else{
                    if ($('#DOPBSPCalendar-reservation'+ID).offset().top+$('#DOPBSPCalendar-reservation'+ID).height() > $(document).scrollTop()+$(window).height()){
                        DOPPrototypes.scrollToY($('#DOPBSPCalendar-reservation'+ID).offset().top+$('#DOPBSPCalendar-reservation'+ID).height()-$(window).height()+50);
                    }
                }
                
                if (methods_extras.validate(methods_reservation.reservation['extras'])){
                    if (methods_woocommerce.data['enabled']){ 
                        methods_cart.cart[0] = methods_reservation.reservation;
                        methods_woocommerce.set();
                    }
                    else if (methods_cart.data['enabled']){ 
                        
                    }
                    else{
                        methods_cart.cart[0] = methods_reservation.reservation;
                        methods_order.payment.set();
                        $('#DOPBSPCalendar-submit'+ID).css('display', 'block');
                        $('#DOPBSPCalendar-submit'+ID).removeClass('DOPBSPCalendar-hidden');
                    }
                }
                else{
                    if (!methods_cart.data['enabled']){
                        $('#DOPBSPCalendar-submit'+ID).css('display', 'none');
                    }
                }
            },
            
            events:function(){
            /*
             * Initialize reservation events.
             */    
                /*
                 * "Add to cart" button.
                 */
                $('#DOPBSPCalendar-add-to-cart'+ID).unbind('click');
                $('#DOPBSPCalendar-add-to-cart'+ID).bind('click', function(){
                    if (methods_woocommerce.data['enabled']
                            && methods_woocommerce.data['addToCart']){
                        methods_woocommerce.add();
                    }
                });
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
                $('.DOPBSPCalendar-hour', Container).removeClass('dopbsp-selected');
                
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
                                               
                if (!methods_cart.data['enabled']){
                    methods_cart.cart = new Array();
                    $('#DOPBSPCalendar-submit'+ID).css('display', 'none');
                } 
            },
            clearUrl: function(){
                /*
                 * Clear anything left by the redirect from search.
                 */
                var url = window.location.href;
                var updatedUri = url.indexOf("?check_in") > 0 ? url.substring(0, url.indexOf("?check_in")) : url.substring(0, url.indexOf("&check_in"));   
                if (url.indexOf("?") > 0) {
                    window.history.replaceState({}, document.title, updatedUri);
                }
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
                
                $('#DOPBSPCalendar-reservation-cart'+ID).html('<div class="dopbsp-message '+type+'">'+message+'</div>');
            }
        },         
                
// 21. Cart

        methods_cart = {
            data: {},
            text: {},
            cart: new Array(),
              
            display:function(){
            /*
             * Display cart.
             */
                var HTML = new Array();
                
                /*
                 * Cart totals.
                 */
                HTML.push(' <div id="DOPBSPCalendar-cart'+ID+'" class="module'+(methods_cart.data['enabled'] ? '':' DOPBSPCalendar-hidden')+'">');
                HTML.push('     <h4>'+DOPBSPFrontEnd.text(ID, 'cart', 'title')+'</h4>');
                HTML.push('     <table id="DOPBSPCalendar-list-cart'+ID+'" class="cart">');
                HTML.push('         <tbody>');
                HTML.push('             <tr>');
                HTML.push('                 <td class="label">Price</td>');
                HTML.push('                 <td class="value"></td>');
                HTML.push('             </tr>');
                HTML.push('             <tr id="DOPBSPCalendar-cart-totals-discount'+ID+'">');
                HTML.push('                 <td class="label">Discount</td>');
                HTML.push('                 <td class="value"></td>');
                HTML.push('             </tr>');
                HTML.push('             <tr id="DOPBSPCalendar-cart-totals-deposit'+ID+'">');
                HTML.push('                 <td class="label">'+DOPBSPFrontEnd.text(ID, 'deposit', 'title')+'</td>');
                HTML.push('                 <td class="value"></td>');
                HTML.push('             </tr>');
                HTML.push('             <tr id="DOPBSPCalendar-cart-totals-total-price'+ID+'" class="total">');
                HTML.push('                 <td class="label">'+DOPBSPFrontEnd.text(ID, 'reservation', 'priceTotal')+'</td>');
                HTML.push('                 <td class="value"></td>');
                HTML.push('             </tr>');
                HTML.push('         </tbody>');
                HTML.push('     </table>');
                HTML.push(' </div>');
                
                $('#DOPBSPCalendar-sidebar-column-wrapper-'+methods_sidebar.data['positions']['cart']['column']+'-'+ID+' .row'+methods_sidebar.data['positions']['cart']['row']).html(HTML.join(''));
            },
            add:function(){
                methods_cart.cart.push(methods_reservation.reservation);
                methods_cart.set();
            },
            delete:function(i){
                methods_cart.cart.splice(i, 1);
                methods_cart.set();
            },
            set:function(){
                var HTML = new Array(),
                i;
                HTML.push('<tbody>');
                
                if (methods_cart.cart.length > 0){
                    for (i=0; i<methods_cart.cart.length; i++){

                    }
                    methods_order.set();
                }
                else{
                    HTML.push('  <tr>');
                    HTML.push('     <td>'+DOPBSPFrontEnd.text(ID, 'cart', 'isEmpty')+'</td>');
                    HTML.push('  </tr>');
                    methods_order.clear();
                }
                HTML.push('</tbody>');
            }
        },
                
// 22. Form
                
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
                countries = DOPPrototypes.getCountries(),
                i,
                j;
        
                HTML.push('<div id="DOPBSPCalendar-form'+ID+'" class="dopbsp-module">');

                if (!methods_woocommerce.data['enabled']){
                    /*
                     * Title
                     */
                    HTML.push(' <h4>'+DOPBSPFrontEnd.text(ID, 'form', 'title')+'</h4>');

                    /*
                     * Fields
                     */
                    for (i=0; i<form.length; i++){
                        formField = form[i];
                        
                        HTML.push(' <div class="dopbsp-input-wrapper">');

                        switch (formField['type']){
                            case 'checkbox':
                                /*
                                 * Checkbox field.
                                 */
                                HTML.push('     <div id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                HTML.push('         <div class="dopbsp-message">'+formField['translation']+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</div>');
                                HTML.push('     </div>');
                                HTML.push('     <input type="checkbox" name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" />');
                                HTML.push('     <label class="dopbsp-for-checkbox" for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                                break;
                            case 'select':
                                /*
                                 * Select field.
                                 */
                                HTML.push('     <div id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                HTML.push('         <div class="dopbsp-message">'+formField['translation']+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</div>');
                                HTML.push('     </div>');
                                HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                                HTML.push('     <select name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+(formField['multiple_select'] === 'true' ? '[]':'')+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" value=""'+(formField['multiple_select'] === 'true' ? ' multiple':'')+'>');

                                for (j=0; j<formField['options'].length; j++){
                                    formFieldOption = formField['options'][j];
                                    HTML.push('<option value="'+formFieldOption['id']+'">'+formFieldOption['translation']+'</option>');
                                }
                                HTML.push('     </select>');
                                break;
                            case 'text':
                                /*
                                 * Text field.
                                 */
                                HTML.push('     <div id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                HTML.push('         <div class="dopbsp-message">'+formField['translation']+' '+(formField['is_email'] === 'true' ? DOPBSPFrontEnd.text(ID, 'form', 'invalidEmail'):DOPBSPFrontEnd.text(ID, 'form', 'required'))+'</div>');
                                HTML.push('     </div>');
                                HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? ' <span class="dopbsp-required">*</span>':'')+'</label>');
                                
                                if(formField['is_phone'] === 'true') {
                                    HTML.push('     <select id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'-phone_code" class="dopbsp-phone-code">');
                                    for(var k = 0; k < countries.length; k++){
                                        if ( countries[k]['code2'] === formField['default_country']){
                                            HTML.push('         <option value="'+countries[k]['code']+'" selected>'+countries[k]['name']+'</option>');

                                        }
                                        else{
                                            HTML.push('         <option value="'+countries[k]['code']+'">'+countries[k]['name']+'</option>');
                                        }
                                    }
                                    HTML.push('     </select>');
                                }
                                HTML.push('     <input type="text" name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" class="'+(formField['is_phone'] === 'true' ? 'dopbsp-phone-input':'')+'" value="" />');
                                break;
                            case 'textarea':
                                /*
                                 * Textarea field.
                                 */
                                HTML.push('     <div id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                HTML.push('         <div class="dopbsp-message">'+formField['translation']+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</div>');
                                HTML.push('     </div>');
                                HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                                HTML.push('     <textarea name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" col="" rows="3"></textarea>');
                                break;
                        }
                        HTML.push(' </div>');
                    }
                }
                
                HTML.push('</div>');
                
                $('#DOPBSPCalendar-sidebar-column-wrapper-'+methods_sidebar.data['positions']['form']['column']+'-'+ID+' .dopbsp-row'+methods_sidebar.data['positions']['form']['row']).html(HTML.join(''));
                
                methods_form.init();
            },
            init:function(){
            /*
             * Initialize form.
             */    
                var form = methods_form.data['form'],
                formField,
                i,
                j,
                countries = DOPPrototypes.getCountries();

                for (i=0; i<form.length; i++){
                    formField = form[i];
                    
                    /*
                     * Initialize select fields.
                     */
                    if (formField['type'] === 'select'){
                        $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).DOPSelect();
                    }
                    
                    if (formField['is_phone'] === 'true'){
                        $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'-phone_code').DOPSelect();
                        for (j = 0; j<countries.length; j++){
                            if(countries[j]['name']=== $('#DOPSelect-DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'-phone_code .dopselect-select .dopselect-selection').text()){
                                $('#DOPSelect-DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'-phone_code .dopselect-select .dopselect-selection').text(function(){
                                    return countries[j]['code'];
                                });
                            }
                        }
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
                i,
                j,
                countries = DOPPrototypes.getCountries();

                for (i=0; i<form.length; i++){
                    formField = form[i];
                    formData[formField['id']] = formField;
                    formData[formField['id']]['size'] = parseInt(formData[formField['id']]['size'], 10);
                     
                    if (formField['is_phone'] === 'true'){
                        $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'-phone_code').bind('change', function(){
                            var cc = $(this).val(); //country code
                            for (j = 0; j<countries.length; j++){
                                if (countries[j]['code'] === cc){
                                    $(this).parent().find('.dopselect-selection').html(countries[j]['code']); 
                                }
                            }
                        });
                    }         
                   
                    switch (formField['type']){
                        case 'checkbox':
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).unbind('click');
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).bind('click', function(){
                                var id = $(this).attr('id').split('DOPBSPCalendar-form-field'+ID+'_')[1];
                                
                                /*
                                 * Verify if required.
                                 */
                                if (formData[id]['required'] === 'true' 
                                        && !$(this).is(':checked')){
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).removeClass('DOPBSPCalendar-hidden');
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).addClass('DOPBSPCalendar-hidden');
                                }
                            });
                            break;
                        case 'text':
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).unbind('input propertychange blur');
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).bind('input propertychange blur', function(){
                                var id = $(this).attr('id').split('DOPBSPCalendar-form-field'+ID+'_')[1],
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
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).removeClass('DOPBSPCalendar-hidden');
                                }
                                else if (formData[id]['required'] === 'true' 
                                            && value === ''){
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).removeClass('DOPBSPCalendar-hidden');
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).addClass('DOPBSPCalendar-hidden');
                                }
                            });
                            break;
                        case 'select':
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).unbind('change');
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).bind('change', function(){
                                var id = $(this).attr('id').split('DOPBSPCalendar-form-field'+ID+'_')[1];
                                
                                /*
                                 * Verify if required.
                                 */
                                if (formData[id]['required'] === 'true' 
                                        && ($(this).val() === '' 
                                            || $(this).val() === null)){
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).removeClass('DOPBSPCalendar-hidden');
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).addClass('DOPBSPCalendar-hidden');
                                }
                            });
                            break;
                        case 'textarea':
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).unbind('input propertychange blur');
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).bind('input propertychange blur', function(){
                                var id = $(this).attr('id').split('DOPBSPCalendar-form-field'+ID+'_')[1],
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
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).removeClass('DOPBSPCalendar-hidden');
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).addClass('DOPBSPCalendar-hidden');
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
                                   "is_phone": false,
                                   "add_to_day_hour_info": false,
                                   "add_to_day_hour_body": false,
                                   "translation": "",
                                   "value": ""};
                    formData[i]['id'] = formField['id'];
                    formData[i]['is_email'] = formField['is_email'] === 'true' ? true:false;
                    formData[i]['is_phone'] = formField['is_phone'] === 'true' ? true:false;
                    formData[i]['add_to_day_hour_info'] = formField['add_to_day_hour_info'] === 'true' ? true:false;
                    formData[i]['add_to_day_hour_body'] = formField['add_to_day_hour_body'] === 'true' ? true:false;
                    formData[i]['translation'] = formField['translation'];

                    switch (formField['type']){
                        case 'checkbox':
                            formData[i]['value'] = $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).is(':checked');
                            break;
                        case 'select':
                            option = $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val();
                            
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
                            if (formData[i]['is_phone']){
                                formData[i]['value'] = $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'-phone_code').val();
                            }
                            formData[i]['value'] = formData[i]['value'] +$('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val();
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
                                    && !$('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).is(':checked')){
                                isValid = false;
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).removeClass('DOPBSPCalendar-hidden');
                            }
                            else{
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).addClass('DOPBSPCalendar-hidden');
                            }
                            break;
                        case 'text':
                            if (formField['is_email'] === 'true' 
                                    && (formField['required'] === 'true' 
                                                    && !DOPPrototypes.validEmail($('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val())
                                            || formField['required'] === 'false' 
                                                    && !DOPPrototypes.validEmail($('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val())
                                                    && $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val() !== '')){
                                isValid = false;
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).removeClass('DOPBSPCalendar-hidden');
                            }
                            else if (formField['required'] === 'true' 
                                    && $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val() === ''){
                                isValid = false;
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).removeClass('DOPBSPCalendar-hidden');
                            }
                            else{
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).addClass('DOPBSPCalendar-hidden');
                            }
                            break;
                        case 'select':
                            if (formField['required'] === 'true' 
                                    && ($('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val() === '' 
                                    || $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val() === null)){
                                isValid = false;
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).removeClass('DOPBSPCalendar-hidden');
                            }
                            else{
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).addClass('DOPBSPCalendar-hidden');
                            }
                            break;
                        case 'textarea':
                            if (formField['required'] === 'true' 
                                    && $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).val() === ''){
                                isValid = false;
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'block');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).removeClass('DOPBSPCalendar-hidden');
                            }
                            else{
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).css('display', 'none');
                                $('#DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']).addClass('DOPBSPCalendar-hidden');
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
                    text.push(info[i]['data']);
                }
                
                return text.join('<br /><br />');
            }
        },
                
// 23. Order
 
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
                                    "text": "addressZipCode"}], 
                   tokenInit: false},
            
            display:function(){
            /*
             * Display order.
             * 
             * @return order HTML
             */
                var HTML = new Array (),
                key,
                paymentGateways = methods_order.data['paymentGateways'];
                
                HTML.push('<div id="DOPBSPCalendar-order'+ID+'" class="dopbsp-module">');

                /*
                 * Title
                 */
                HTML.push(' <h4>'+DOPBSPFrontEnd.text(ID, 'order', 'title')+'</h4>');

                /*
                 * Pay full amount.
                 */
                var dataDeposit = DOPBSPFrontEnd.calendar[ID]['deposit']['data'];
                
                if (dataDeposit['deposit'] > 0
                   && dataDeposit['pay_full_amount'] === 'true'){
                    HTML.push(' <div class="dopbsp-input-wrapper">');
                    HTML.push('     <input type="checkbox" name="DOPBSPCalendar-pay-full-amount'+ID+'" id="DOPBSPCalendar-pay-full-amount'+ID+'" />');
                    HTML.push('     <label class="dopbsp-for-checkbox" for="DOPBSPCalendar-pay-full-amount'+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', 'paymentFull')+'</label>');
                    HTML.push(' </div>');
                }

                /*
                 * Pay on arrival.
                 */
                if (methods_order.data['paymentArrival']){
                    HTML.push(' <div class="dopbsp-input-wrapper dopbsp-payment-first">');
                    HTML.push('     <input type="radio" name="DOPBSPCalendar-payment'+ID+'" value="default" />');
                    HTML.push('     <label class="dopbsp-for-radio">'+(methods_order.data['paymentArrivalWithApproval'] ? DOPBSPFrontEnd.text(ID, 'order', 'paymentArrivalWithApproval'):DOPBSPFrontEnd.text(ID, 'order', 'paymentArrival'))+'</label>');
                    HTML.push(' </div>');
                }

                /*
                 * Payment gateways.
                 */
                
                if (paymentGateways.length !== 0) {
                    
                    for (key in paymentGateways){
                        HTML.push(' <div class="dopbsp-input-wrapper">');
                        HTML.push('     <input type="radio" name="DOPBSPCalendar-payment'+ID+'" value="'+paymentGateways[key]['id']+'" />');
                        HTML.push('     <label class="dopbsp-for-radio">'+paymentGateways[key]['text']['label']+'</label>');
                        HTML.push(' </div>');
			
			if (key === 'stripe'){
			    HTML.push(DOT.layouts.addons_stripe.card(ID, paymentGateways[key]['data']['token']['function'], paymentGateways[key]['text']['card_title']));
			}
                    }
                }
                
                /*
                 * Token fields.
                 */
                HTML.push(' <input type="hidden" name="DOPBSPCalendar-payment-token'+ID+'" id="DOPBSPCalendar-payment-token'+ID+'" value="" />');
                HTML.push(' <input type="hidden" name="DOPBSPCalendar-payment-token-message'+ID+'" id="DOPBSPCalendar-payment-token-message'+ID+'" value="" />');
                
                HTML.push(' <div id="DOPBSPCalendar-payment-form-addon'+ID+'"></div>');
                /*
                 * Credit card.
                 */
                HTML.push(methods_order.payment.card.display());
                
                /*
                 * Billing address.
                 */
                HTML.push(methods_order.payment.address_billing.display());
                
                /*
                 * Shipping address.
                 */
                HTML.push(methods_order.payment.address_shipping.display());

                /*
                 * Terms & conditions.
                 */
                if (methods_order.data['termsAndConditions']){
                    HTML.push(' <div class="dopbsp-input-wrapper">');
                    HTML.push('     <input type="checkbox" name="DOPBSPCalendar-terms-and-conditions'+ID+'" id="DOPBSPCalendar-terms-and-conditions'+ID+'" />');
                    HTML.push('     <label class="dopbsp-for-checkbox" for="DOPBSPCalendar-terms-and-conditions'+ID+'"><a href="'+methods_order.data['termsAndConditionsLink']+'" target="_blank">'+DOPBSPFrontEnd.text(ID, 'order', 'termsAndConditions')+'</a></label>');
                    HTML.push(' </div>');
                }

                /*
                 * Submit button.
                 */
                HTML.push(' <div class="dopbsp-input-wrapper">');
                HTML.push('     <input type="submit" name="DOPBSPCalendar-submit'+ID+'" id="DOPBSPCalendar-submit'+ID+'" class="DOPBSPCalendar-hidden" value="'+DOPBSPFrontEnd.text(ID, 'order', 'book')+'" />');
                HTML.push('     <div id="DOPBSPCalendar-submit-loader'+ID+'" class="dopbsp-submit-loader DOPBSPCalendar-hidden"></div>');
                HTML.push(' </div>');
                
                /*
                 * Message
                 */
                HTML.push(' <div class="dopbsp-message DOPBSPCalendar-hidden"></div>');
                HTML.push('</div>');
                
                $('#DOPBSPCalendar-sidebar-column-wrapper-'+methods_sidebar.data['positions']['order']['column']+'-'+ID+' .dopbsp-row'+methods_sidebar.data['positions']['order']['row']).html(HTML.join(''));
                
                methods_order.init();
            },
            init:function(){
            /*
             * Initialize order.
             */  
                var key,
		paymentGateways = methods_order.data['paymentGateways'];
	
                $('#DOPBSPCalendar-payment-card-expiration-date-month'+ID).DOPSelect();
                $('#DOPBSPCalendar-payment-card-expiration-date-year'+ID).DOPSelect();
                
                methods_order.events();
                methods_order.payment.set();
                
                methods_order.payment.address_billing.init();
                methods_order.payment.address_shipping.init();
                methods_order.payment.card.init();
		
                if (paymentGateways.length !== 0){
                    for (key in paymentGateways){
			key === 'stripe' ? DOT.methods.addons_stripe.init(ID):'';
		    }
		}
            },
            events:function(){
            /*
             * Initialize order events.
             */    
                $('input[name=DOPBSPCalendar-pay-full-amount'+ID+']').unbind('click');
                $('input[name=DOPBSPCalendar-pay-full-amount'+ID+']').bind('click', function(){
                    methods_reservation.set();
                });    
                
                $('input[name=DOPBSPCalendar-payment'+ID+']').unbind('click');
                $('input[name=DOPBSPCalendar-payment'+ID+']').bind('click', function(){
                    methods_order.payment.form_addon.display();
                    methods_order.payment.card.set();
		    $(this).val() === 'stripe' ? $('#'+DOT.id+'-stripe-card-wrapper'+ID).removeClass('DOPBSPCalendar-hidden'):
						 $('#'+DOT.id+'-stripe-card-wrapper'+ID).addClass('DOPBSPCalendar-hidden');
                    methods_order.payment.address_billing.set();
                    methods_order.payment.address_shipping.set();
                });
            
                $('#DOPBSPCalendar-submit'+ID).unbind('click');
                $('#DOPBSPCalendar-submit'+ID).bind('click', function(){
                    methods_order.book();
                });
            },
            validate:function(){
            /*
             * Validate order.
             */    
                var isValid = true;
                
                if (methods_order.data['termsAndConditions'] 
                        && !$('#DOPBSPCalendar-terms-and-conditions'+ID).is(':checked')){
                    methods_order.toggleMessages(DOPBSPFrontEnd.text(ID, 'order', 'termsAndConditionsInvalid'),
                                                 'block');
                    isValid = false;
                }
                
                return isValid;
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
                        $('input[name=DOPBSPCalendar-payment'+ID+']').removeAttr('disabled')
                                                                     .removeAttr('checked');
                        $('input[name=DOPBSPCalendar-payment'+ID+']:first').attr('checked', 'checked');
                    }
                    else{
                        $('input[name=DOPBSPCalendar-payment'+ID+']').attr('disabled', 'disabled')
                                                                     .removeAttr('checked');
                    }
                    
                    methods_order.payment.form_addon.display();
                    methods_order.payment.card.set();
		    $('input[name=DOPBSPCalendar-payment'+ID+']').val() === 'stripe' ? $('#'+DOT.id+'-stripe-card-wrapper'+ID).removeClass('DOPBSPCalendar-hidden'):
										       $('#'+DOT.id+'-stripe-card-wrapper'+ID).addClass('DOPBSPCalendar-hidden');
                    methods_order.payment.address_billing.set();
                    methods_order.payment.address_shipping.set();
                },
                token:function(paymentMethod){
                /*
                 * Get payment token from a JavaScript function.
                 * 
                 * @param paymentMethod (String): selected payment method
                 */    
                    var paymentGateways = methods_order.data['paymentGateways'];

                    if (!methods_order.vars.tokenInit){
                        methods_order.vars.tokenInit = true;
                        eval(paymentGateways[paymentMethod]['data']['token']['function']);
                    }
                    
                    /*
                     * Book function is called to verify if the token is created. If not the book function will call this function again.
                     */
                    setTimeout(function(){
                        methods_order.book();
                    }, 100);
                },
                verify:function(){
                /*
                 * Verify if payment has been made.
                 */
                    var href = window.location.href,
                    key,
                    paymentGateways = methods_order.data['paymentGateways'],
                    paymentCancel = DOPPrototypes.$_GET('dopbsp_payment_cancel'),
                    paymentError = DOPPrototypes.$_GET('dopbsp_payment_error'),
                    paymentSuccess = DOPPrototypes.$_GET('dopbsp_payment_success'),
                    variables;
            
                    for (key in paymentGateways){
                        if (paymentCancel !== undefined
                                && key === paymentCancel){
                            methods_info.toggleMessages(paymentGateways[key]['text']['cancel'],
                                                        'dopbsp-error');
                            variables = (href.indexOf('?dopbsp_payment_cancel') !== -1 ? '?':'&')+'dopbsp_payment_cancel';
                        }
                        else if (paymentError !== undefined
                                && key === paymentError){
                            methods_info.toggleMessages(paymentGateways[key]['text']['error'],
                                                        'dopbsp-error');
                            variables = (href.indexOf('?dopbsp_payment_error') !== -1 ? '?':'&')+'dopbsp_payment_error';
                        }
                        else if (paymentSuccess !== undefined
                                && key === paymentSuccess){
                            methods_info.toggleMessages(paymentGateways[key]['text']['success'],
                                                        'dopbsp-success');
                            variables = (href.indexOf('?dopbsp_payment_success') !== -1 ? '?':'&')+'dopbsp_payment_success';
                        }   
                    }

                    if (paymentCancel !== undefined
                            || paymentError !== undefined
                            || paymentSuccess !== undefined){
                        try{
                            window.history.pushState({'html':'', 'pageTitle':document.title}, '', href.split(variables)[0]);
                            methods_reservation.clearUrl();
                        }
                        catch(e){
                            // console.log(e);
                        }
                    }
                },
            
                address_billing: {
                    display:function(){
                    /*
                     * Display billing address form.
                     * 
                     * @return billing address HTML
                     */
                        var countries = methods_order.data.countries,
                        fields = methods_order.vars.addressFields, 
                        HTML = new Array (),
                        i,
                        j;
                
                        HTML.push('<div id="DOPBSPCalendar-payment-address-billing'+ID+'" class="DOPBSPCalendar-hidden">');
                        HTML.push(' <h4 id="DOPBSPCalendar-payment-address-billing-title'+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', 'addressBilling')+'</h4>');

                        for (i=0; i<fields.length; i++){
                            switch (fields[i]['key']){
                                case 'country':
                                    HTML.push(' <div id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                                    HTML.push('     <div id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                    HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                    HTML.push('         <div class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</div>');
                                    HTML.push('     </div>');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <select name="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'" id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'">');

                                    for (j=0; j<countries.length; j++){
                                        HTML.push('     <option value="'+countries[j]['code3']+'">'+countries[j]['name']+'</option>');
                                    }
                                    HTML.push('     </select>');
                                    HTML.push(' </div>');           
                                    
                                    break;
                                case 'zip_code':
                                    HTML.push(' <div id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                                    HTML.push('     <div id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                    HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                    HTML.push('         <div class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</div>');
                                    HTML.push('     </div>');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'" id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'" class="dopbsp-small" value="" />');
                                    HTML.push(' </div>');
                                    
                                    break;
                                default:
                                    HTML.push(' <div id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                                    HTML.push('     <div id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                    HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                    HTML.push('         <div class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+(fields[i]['key'] === 'email' ? DOPBSPFrontEnd.text(ID, 'form', 'invalidEmail'):DOPBSPFrontEnd.text(ID, 'form', 'required'))+'</div>');
                                    HTML.push('     </div>');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'" id="DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID+'" value="" />');
                                    HTML.push(' </div>');
                            }
                        }
                        HTML.push('</div>');
                        
                        return HTML.join('');
                    },
                    init:function(){
                    /*
                     * Initialize billing address.
                     */    
                        $('#DOPBSPCalendar-payment-address-billing-country'+ID).DOPSelect();
                        methods_order.payment.address_billing.events();
                    },
                    
                    set:function(){
                    /*
                     * Set billing address form.
                     */
                        var fields = methods_order.vars.addressFields, 
                        i,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];

                        $('#DOPBSPCalendar-payment-address-billing'+ID).css('display', paymentMethod !== 'none' && data['enabled'] ? 'block':'none');
                        paymentMethod !== 'none' && data['enabled'] ? $('#DOPBSPCalendar-payment-address-billing'+ID).removeClass('DOPBSPCalendar-hidden'):$('#DOPBSPCalendar-payment-address-billing'+ID).addClass('DOPBSPCalendar-hidden');
                            
                        if (paymentMethod === 'none'
                                || !data['enabled']){
                            return false;
                        }
                        
                        for (i=0; i<fields.length; i++){
                            $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID).css('display', data[fields[i]['key']]['enabled'] ? 'block':'none');
                            $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-wrapper'+ID+' .dopbsp-required').css('display', data[fields[i]['key']]['required'] ? 'inline-block':'none');
                        }
                    },
                    get:function(){
                    /*
                     * Get billing address data.
                     */ 
                        var paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
 
                        if (!data['enabled']){
                            return '';
                        }
                        else{
                            return {"address_first": $('#DOPBSPCalendar-payment-address-billing-address-first'+ID).val(),
                                    "address_second": $('#DOPBSPCalendar-payment-address-billing-address-second'+ID).val(),
                                    "city": $('#DOPBSPCalendar-payment-address-billing-city'+ID).val(),
                                    "company": $('#DOPBSPCalendar-payment-address-billing-company'+ID).val(),
                                    "country": data['country']['enabled'] ? $('#DOPBSPCalendar-payment-address-billing-country'+ID).val():'',
                                    "email": $('#DOPBSPCalendar-payment-address-billing-email'+ID).val(),
                                    "first_name": $('#DOPBSPCalendar-payment-address-billing-first-name'+ID).val(),
                                    "last_name": $('#DOPBSPCalendar-payment-address-billing-last-name'+ID).val(),
                                    "phone": $('#DOPBSPCalendar-payment-address-billing-phone'+ID).val(),
                                    "state": $('#DOPBSPCalendar-payment-address-billing-state'+ID).val(),
                                    "zip_code": $('#DOPBSPCalendar-payment-address-billing-zip-code'+ID).val()};
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
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
                        
                        if (!data['enabled']){
                            return true;
                        }
                        
                        for (i=0; i<fields.length; i++){
                            if ($('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).val() === ''
                                    && data[fields[i]['key']]['enabled'] 
                                    && data[fields[i]['key']]['required']
                                    && (fields[i]['key'] === 'email'
                                                && !DOPPrototypes.validEmail($('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).val())
                                                || fields[i]['key'] !== 'email')){
                                $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-warning'+ID).css('display', 'block');
                                isValid = false;
                            }
                            else{
                                $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+'-warning'+ID).css('display', 'none');
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
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
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
                                        $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            var paymentGateways = methods_order.data['paymentGateways'],
                                            paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                                            data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_billing']:paymentGateways[paymentMethod]['data']['address_billing'];
                                            
                                            $(this).parent().find('.dopbsp-warning-info').css('display', !DOPPrototypes.validEmail($(this).val()) && $(this).val() !== '' || data['email']['required'] && $(this).val() === ''  ? 'block':'none');
                                        });
                                    }
                                    break;
                                case 'phone':
                                    if (data[fields[i]['key']]['enabled']){
                                        $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            DOPPrototypes.cleanInput($(this), '0123456789+-().');
                                        });
                                    }
                                    break;
                                default:
                                    if (data[fields[i]['key']]['enabled']
                                            && data[fields[i]['key']]['required']){
                                        $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPCalendar-payment-address-billing-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            $(this).parent().find('.dopbsp-warning-info').css('display', $(this).val() === '' ? 'block':'none');
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
                     * 
                     * @return shipping address HTML
                     */
                        var countries = methods_order.data.countries,
                        fields = methods_order.vars.addressFields, 
                        HTML = new Array (),
                        i,
                        j;
                
                        HTML.push('<div id="DOPBSPCalendar-payment-address-shipping'+ID+'" class="DOPBSPCalendar-hidden">');
                        HTML.push(' <h4 id="DOPBSPCalendar-payment-address-shipping-title'+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', 'addressShipping')+'</h4>');
                        
                        HTML.push(' <div class="dopbsp-input-wrapper">');
                        HTML.push('     <input type="checkbox" name="DOPBSPCalendar-payment-address-shipping-copy'+ID+'" id="DOPBSPCalendar-payment-address-shipping-copy'+ID+'" checked="checked">');
                        HTML.push('     <label class="dopbsp-for-checkbox" for="DOPBSPCalendar-payment-address-shipping-copy'+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', 'addressShippingCopy')+'</label>');
                        HTML.push(' </div>');           

                        for (i=0; i<fields.length; i++){
                            switch (fields[i]['key']){
                                case 'country':
                                    HTML.push(' <div id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                                    HTML.push('     <div id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                    HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                    HTML.push('         <div class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</div>');
                                    HTML.push('     </div>');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <select name="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'" id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'">');

                                    for (j=0; j<countries.length; j++){
                                        HTML.push('     <option value="'+countries[j]['code3']+'">'+countries[j]['name']+'</option>');
                                    }
                                    HTML.push('     </select>');
                                    HTML.push(' </div>');           
                                    
                                    break;
                                case 'zip_code':
                                    HTML.push(' <div id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                                    HTML.push('     <div id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                    HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                    HTML.push('         <div class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+DOPBSPFrontEnd.text(ID, 'form', 'required')+'</div>');
                                    HTML.push('     </div>');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'" id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'" class="dopbsp-small" value="" />');
                                    HTML.push(' </div>');
                                    
                                    break;
                                default:
                                    HTML.push(' <div id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                                    HTML.push('     <div id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-warning'+ID+'" class="dopbsp-warning-info DOPBSPCalendar-hidden">');
                                    HTML.push('         <a href="javascript:void(0)" class="dopbsp-icon"></a>');
                                    HTML.push('         <div class="dopbsp-message">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' '+(fields[i]['key'] === 'email' ? DOPBSPFrontEnd.text(ID, 'form', 'invalidEmail'):DOPBSPFrontEnd.text(ID, 'form', 'required'))+'</div>');
                                    HTML.push('     </div>');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'">'+DOPBSPFrontEnd.text(ID, 'order', fields[i]['text'])+' <span class="dopbsp-required">*</span></label>');
                                    HTML.push('     <input type="text" name="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'" id="DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID+'" value="" />');
                                    HTML.push(' </div>');
                            }
                        }
                        HTML.push('</div>');
                        
                        return HTML.join('');
                    },
                    init:function(){
                    /*
                     * Initialize shipping address.
                     */    
                        $('#DOPBSPCalendar-payment-address-shipping-country'+ID).DOPSelect();
                        methods_order.payment.address_shipping.events();
                    },
                    
                    set:function(){
                    /*
                     * Set shipping address form.
                     */
                        var fields = methods_order.vars.addressFields, 
                        i,
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'],
                        useBilling = $('#DOPBSPCalendar-payment-address-shipping-copy'+ID).is(':checked');

                        $('#DOPBSPCalendar-payment-address-shipping'+ID).css('display', paymentMethod !== 'none' && data['enabled'] ? 'block':'none');
                        paymentMethod !== 'none' && data['enabled'] ? $('#DOPBSPCalendar-payment-address-shipping'+ID).removeClass('DOPBSPCalendar-hidden'):$('#DOPBSPCalendar-payment-address-shipping'+ID).addClass('DOPBSPCalendar-hidden');
                          
                        if (paymentMethod === 'none'
                                || !data['enabled']){
                            return false;
                        }
                        
                        for (i=0; i<fields.length; i++){
                            $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID).css('display', data[fields[i]['key']]['enabled'] && !useBilling ? 'block':'none');
                            $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-wrapper'+ID+' .dopbsp-required').css('display', data[fields[i]['key']]['required'] ? 'inline-block':'none');
                        }
                    },
                    get:function(){
                    /*
                     * Get shipping address data.
                     * 
                     * @return shipping address data
                     */ 
                        var paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'],
                        useBilling = $('#DOPBSPCalendar-payment-address-shipping-copy'+ID).is(':checked');
 
                        if (!data['enabled']){
                            return '';
                        }
                        else if (useBilling){
                            return 'billing_address';
                        }
                        else{
                            return {"address_first": $('#DOPBSPCalendar-payment-address-shipping-address-first'+ID).val(),
                                    "address_second": $('#DOPBSPCalendar-payment-address-shipping-address-second'+ID).val(),
                                    "city": $('#DOPBSPCalendar-payment-address-shipping-city'+ID).val(),
                                    "company": $('#DOPBSPCalendar-payment-address-shipping-company'+ID).val(),
                                    "country": data['country']['enabled'] ? $('#DOPBSPCalendar-payment-address-shipping-country'+ID).val():'',
                                    "email": $('#DOPBSPCalendar-payment-address-shipping-email'+ID).val(),
                                    "first_name": $('#DOPBSPCalendar-payment-address-shipping-first-name'+ID).val(),
                                    "last_name": $('#DOPBSPCalendar-payment-address-shipping-last-name'+ID).val(),
                                    "phone": $('#DOPBSPCalendar-payment-address-shipping-phone'+ID).val(),
                                    "state": $('#DOPBSPCalendar-payment-address-shipping-state'+ID).val(),
                                    "zip_code": $('#DOPBSPCalendar-payment-address-shipping-zip-code'+ID).val()};
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
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'];
                        
                        if (!data['enabled']
                                || $('#DOPBSPCalendar-payment-address-shipping-copy'+ID).is(':checked')){
                            return true;
                        }
                        
                        for (i=0; i<fields.length; i++){
                            if ($('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).val() === ''
                                    && data[fields[i]['key']]['enabled'] 
                                    && data[fields[i]['key']]['required']
                                    && (fields[i]['key'] === 'email'
                                                && !DOPPrototypes.validEmail($('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).val())
                                                || fields[i]['key'] !== 'email')){
                                $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-warning'+ID).css('display', 'block');
                                isValid = false;
                            }
                            else{
                                $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+'-warning'+ID).css('display', 'none');
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
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'];
                
                        /*
                         * Use shipping address event.
                         */
                        $('#DOPBSPCalendar-payment-address-shipping-copy'+ID).unbind('click');
                        $('#DOPBSPCalendar-payment-address-shipping-copy'+ID).bind('click', function(){
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
                                        $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            var paymentGateways = methods_order.data['paymentGateways'],
                                            paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                                            data = paymentMethod === 'none' || paymentMethod === 'default' ? methods_order.data['address_shipping']:paymentGateways[paymentMethod]['data']['address_shipping'];
                                            
                                            $(this).parent().find('.dopbsp-warning-info').css('display', !DOPPrototypes.validEmail($(this).val()) && $(this).val() !== '' || data['email']['required'] && $(this).val() === ''  ? 'block':'none');
                                        });
                                    }
                                    break;
                                case 'phone':
                                    if (data[fields[i]['key']]['enabled']){
                                        $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            DOPPrototypes.cleanInput($(this), '0123456789+-().');
                                        });
                                    }
                                    break;
                                default:
                                    if (data[fields[i]['key']]['enabled']
                                            && data[fields[i]['key']]['required']){
                                        $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).unbind('input propertychange blur');
                                        $('#DOPBSPCalendar-payment-address-shipping-'+fields[i]['id']+ID).bind('input propertychange blur', function(){
                                            $(this).parent().find('.dopbsp-warning-info').css('display', $(this).val() === '' ? 'block':'none');
                                        });
                                    }
                            }
                        }
                    }
                },
                card: {
                    display:function(){
                    /*
                     * Display card form.
                     * 
                     * @return card HTML
                     */
                        var HTML = new Array (),
                        i;

                        HTML.push('<div id="DOPBSPCalendar-payment-card'+ID+'" class="DOPBSPCalendar-hidden">');
                        HTML.push(' <h4 id="DOPBSPCalendar-payment-card-title'+ID+'"></h4>');

                        /*
                         * Card number.
                         */
                        HTML.push(' <div id="DOPBSPCalendar-payment-card-number-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                        HTML.push('     <label id="DOPBSPCalendar-payment-card-number-label'+ID+'" for="DOPBSPCalendar-payment-card-number'+ID+'"></label>');
                        HTML.push('     <input type="text" name="DOPBSPCalendar-payment-card-number'+ID+'" id="DOPBSPCalendar-payment-card-number'+ID+'" value="" />');
                        HTML.push(' </div>');

                        /*
                         * Card security code.
                         */
                        HTML.push(' <div id="DOPBSPCalendar-payment-card-security-code-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                        HTML.push('     <label id="DOPBSPCalendar-payment-card-security-code-label'+ID+'" for="DOPBSPCalendar-payment-card-security-code'+ID+'"></label>');
                        HTML.push('     <input type="text" name="DOPBSPCalendar-payment-card-security-code'+ID+'" id="DOPBSPCalendar-payment-card-security-code'+ID+'" class="dopbsp-small" value="" />');
                        HTML.push(' </div>');

                        /*
                         * Card expiration date.
                         */
                        HTML.push(' <div id="DOPBSPCalendar-payment-card-expiration-date-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                        HTML.push('     <label id="DOPBSPCalendar-payment-card-expiration-date-label'+ID+'"></label>');
                        HTML.push('     <select name="DOPBSPCalendar-payment-card-expiration-date-month'+ID+'" id="DOPBSPCalendar-payment-card-expiration-date-month'+ID+'" class="dopbsp-small DOPBSPCalendar-left">');

                        for (i=1; i<=12; i++){
                            HTML.push('     <option value="'+DOPPrototypes.getLeadingZero(i)+'">'+DOPPrototypes.getLeadingZero(i)+' '+DOPBSPFrontEnd.text(ID, 'months', 'shortNames')[i-1]+'</option>');
                        }
                        HTML.push('     </select>');
                        HTML.push('     <select name="DOPBSPCalendar-payment-card-expiration-date-year'+ID+'" id="DOPBSPCalendar-payment-card-expiration-date-year'+ID+'" class="dopbsp-small DOPBSPCalendar-left">');

                        for (i=methods_calendar.vars.todayYear; i<=methods_calendar.vars.todayYear+10; i++){
                            HTML.push('     <option value="'+i+'">'+i+'</option>');
                        }
                        HTML.push('     </select>');
                        HTML.push('     <br class="DOPBSPCalendar-clear" />');
                        HTML.push(' </div>');

                        /*
                         * Card name.
                         */
                        HTML.push(' <div id="DOPBSPCalendar-payment-card-name-wrapper'+ID+'" class="dopbsp-input-wrapper">');
                        HTML.push('     <label id="DOPBSPCalendar-payment-card-name-label'+ID+'" for="DOPBSPCalendar-payment-card-name'+ID+'"></label>');
                        HTML.push('     <input type="text" name="DOPBSPCalendar-payment-card-name'+ID+'" id="DOPBSPCalendar-payment-card-name'+ID+'" value="" />');
                        HTML.push(' </div>');
                        HTML.push('</div>');

                        return HTML.join('');
                    },
                    init:function(){
                    /*
                     * Initialize card.
                     */     
                        methods_order.payment.card.events();
                    },

                    set:function(){
                    /*
                     * Set card data for the selected payment method.
                     */    
                        var paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val();

                        if (paymentMethod !== 'none'
                                && paymentMethod !== 'default'
                                && paymentGateways[paymentMethod]['data']['card']['enabled']){
                            $('#DOPBSPCalendar-payment-card'+ID).removeClass('DOPBSPCalendar-hidden');

                            /*
                             * Set card title.
                             */
                            $('#DOPBSPCalendar-payment-card-title'+ID).html(paymentGateways[paymentMethod]['text']['card_title']);

                            /*
                             * Set card number.
                             */
                            $('#DOPBSPCalendar-payment-card-number-label'+ID).html(paymentGateways[paymentMethod]['text']['card_number']);

                            paymentGateways[paymentMethod]['data']['card']['number']['attribute'] !== '' ? $('#DOPBSPCalendar-payment-card-number'+ID).attr(paymentGateways[paymentMethod]['data']['card']['number']['attribute'],
                                                                                                                                                            paymentGateways[paymentMethod]['data']['card']['number']['value']):'';

                            /*
                             * Set card security code.
                             */
                            $('#DOPBSPCalendar-payment-card-security-code-label'+ID).html(paymentGateways[paymentMethod]['text']['card_security_code']);
                            paymentGateways[paymentMethod]['data']['card']['security_code']['attribute'] !== '' ? $('#DOPBSPCalendar-payment-card-security-code'+ID).attr(paymentGateways[paymentMethod]['data']['card']['security_code']['attribute'],
                                                                                                                                                                          paymentGateways[paymentMethod]['data']['card']['security_code']['value']):'';

                            /*
                             * Set card expiration date.
                             */
                            $('#DOPBSPCalendar-payment-card-expiration-date-label'+ID).html(paymentGateways[paymentMethod]['text']['card_expiration_date']);
                            paymentGateways[paymentMethod]['data']['card']['expiration_date_month']['attribute'] !== '' ? $('#DOPBSPCalendar-payment-card-expiration-date-month'+ID).attr(paymentGateways[paymentMethod]['data']['card']['expiration_date_month']['attribute'],
                                                                                                                                                                                          paymentGateways[paymentMethod]['data']['card']['expiration_date_month']['value']):'';
                            paymentGateways[paymentMethod]['data']['card']['expiration_date_year']['attribute'] !== '' ? $('#DOPBSPCalendar-payment-card-expiration-date-year'+ID).attr(paymentGateways[paymentMethod]['data']['card']['expiration_date_year']['attribute'],
                                                                                                                                                                                        paymentGateways[paymentMethod]['data']['card']['expiration_date_year']['value']):'';

                            /*
                             * Set card name.
                             */
                            paymentGateways[paymentMethod]['data']['card']['name']['enabled'] ? $('#DOPBSPCalendar-payment-card-name-wrapper'+ID).removeClass('DOPBSPCalendar-hidden'):$('#DOPBSPCalendar-payment-card-name-wrapper'+ID).addClass('DOPBSPCalendar-hidden');
                            $('#DOPBSPCalendar-payment-card-name-label'+ID).html(paymentGateways[paymentMethod]['text']['card_name']);
                            paymentGateways[paymentMethod]['data']['card']['name']['attribute'] !== '' ? $('#DOPBSPCalendar-payment-card-name'+ID).attr(paymentGateways[paymentMethod]['data']['card']['name']['attribute'],
                                                                                                                                                        paymentGateways[paymentMethod]['data']['card']['name']['value']):'';
                        }
                        else{
                            $('#DOPBSPCalendar-payment-card'+ID).addClass('DOPBSPCalendar-hidden');

                            $('#DOPBSPCalendar-payment-card-title'+ID).html('');
                            $('#DOPBSPCalendar-payment-card-number-label'+ID).html('');
                            $('#DOPBSPCalendar-payment-card-security-code-label'+ID).html('');
                            $('#DOPBSPCalendar-payment-card-expiration-date-label'+ID).html('');
                            $('#DOPBSPCalendar-payment-card-name-label'+ID).html('');
                        }
                    },
                    get:function(){
                    /*
                     * Get card data.
                     */ 
                        return {"expiration_date_month": $('#DOPBSPCalendar-payment-card-expiration-date-month'+ID).val(),
                                "expiration_date_year": $('#DOPBSPCalendar-payment-card-expiration-date-year'+ID).val(),
                                "name": $('#DOPBSPCalendar-payment-card-name'+ID).val(),
                                "number": $('#DOPBSPCalendar-payment-card-number'+ID).val(),
                                "security_code": $('#DOPBSPCalendar-payment-card-security-code'+ID).val()};
                    },

                    events:function(){
                    /*
                     * Initialize card events.
                     */    
                        /*
                         * Allow only numbers for credit card number.
                         */
                        $('#DOPBSPCalendar-payment-card-number'+ID).unbind('input propertychange blur');
                        $('#DOPBSPCalendar-payment-card-number'+ID).bind('input propertychange blur', function(){
                            DOPPrototypes.cleanInput($(this), '0123456789');
                        });

                        /*
                         * Allow only numbers for credit card security code.
                         */
                        $('#DOPBSPCalendar-payment-card-security-code'+ID).unbind('input propertychange blur');
                        $('#DOPBSPCalendar-payment-card-security-code'+ID).bind('input propertychange blur', function(){
                            DOPPrototypes.cleanInput($(this), '0123456789');
                        });
                    }
                },
                form_addon: {
                    display:function(){
                    /*
                     * Display shipping address form.
                     */
                        var HTML = new Array(),
                        i,
                        options = new Array(),
                        paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? new Array():paymentGateways[paymentMethod]['data']['form_addon'];

                        $('#DOPBSPCalendar-payment-form-addon'+ID).html('');
                          
                        if (data.length === 0){
                            return false;
                        }
                        
                        for (var id in data){
                            switch (data[id]['type']){
                                case 'select':
                                    HTML.push(' <div id="DOPBSPCalendar-payment-form-addon-wrapper'+ID+'-'+id+'" class="dopbsp-input-wrapper '+data[id]['classes']+'">');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-form-addon'+ID+'-'+id+'">'+data[id]['label']+'</label>');
                                    HTML.push('     <select type="text" name="DOPBSPCalendar-payment-form-addon'+ID+'-'+id+'" id="DOPBSPCalendar-payment-form-addon'+ID+'-'+id+'" onchange="'+data[id]['function']+'">');
                                    
                                    options = data[id]['options'];
                                    
                                    for (i=0; i<options.length; i++){
                                        HTML.push('     <option value="'+options[i]['value']+'">'+options[i]['label']+'</label>');
                                    }
                                    HTML.push('     </select>');
                                    HTML.push(' </div>');
                                    break;
                                case 'text':
                                    HTML.push(' <div id="DOPBSPCalendar-payment-form-addon-wrapper'+ID+'-'+id+'" class="dopbsp-input-wrapper '+data[id]['classes']+'">');
                                    HTML.push('     <label for="DOPBSPCalendar-payment-form-addon'+ID+'-'+id+'">'+data[id]['label']+'</label>');
                                    HTML.push('     <input type="text" name="DOPBSPCalendar-payment-form-addon'+ID+'-'+id+'" id="DOPBSPCalendar-payment-form-addon'+ID+'-'+id+'" value="" />');
                                    HTML.push(' </div>');
                                    break;
                                case 'title':
                                    HTML.push(' <h4>'+data[id]['label']+'</h4>');
                                    break;
                                    
                            }
                        }
                        
                        $('#DOPBSPCalendar-payment-form-addon'+ID).html(HTML.join(''));
                        
                        methods_order.payment.form_addon.init();
                    },
                    init:function(){
                        var paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? new Array():paymentGateways[paymentMethod]['data']['form_addon'];
                          
                        if (data.length === 0){
                            return false;
                        }
                        
                        for (var id in data){
                            $('#DOPBSPCalendar-payment-form-addon'+ID+'-'+id).val();
                            switch (data[id]['type']){
                                case 'select':
                                    $('#DOPBSPCalendar-payment-form-addon'+ID+'-'+id).DOPSelect();
                                    break;
                            }
                        }
                    },
                    
                    get:function(){
                        var paymentGateways = methods_order.data['paymentGateways'],
                        paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val(),
                        data = paymentMethod === 'none' || paymentMethod === 'default' ? new Array():paymentGateways[paymentMethod]['data']['form_addon'],
                        returnData = {};
                          
                        if (data.length === 0){
                            return false;
                        }
                        
                        for (var id in data){
                            returnData[id] = $('#DOPBSPCalendar-payment-form-addon'+ID+'-'+id).val();
                        }
                        
                        return returnData;
                    }
                }
            },
            
            book:function(){
            /*
             * Book a reservation.
             */    
                var startDate,
                selection,
                y,
                m,
                d,
                h,
                min,
                isValid = true,
                paymentGateways = methods_order.data['paymentGateways'],
                paymentMethod = $('input[name=DOPBSPCalendar-payment'+ID+']:checked').val() === undefined ? 'none':$('input[name=DOPBSPCalendar-payment'+ID+']:checked').val();
                
                /*
                 * Stop if form, billing & shipping address or order are not valid.
                 */
                !methods_form.validate() ? (isValid = false):'';
                !methods_order.payment.address_billing.validate() ? (isValid = false):'';
                !methods_order.payment.address_shipping.validate() ? (isValid = false):'';
                !methods_order.validate() ? (isValid = false):'';
                
                if (!isValid){
                    return false;
                }
                
                methods_order.toggleMessages('', 'none');
                $('#DOPBSPCalendar-submit'+ID).css('display', 'none');
                $('#DOPBSPCalendar-submit-loader'+ID).css('display', 'block');
                $('#DOPBSPCalendar-submit-loader'+ID).removeClass('DOPBSPCalendar-hidden');
                
                /*
                 * Create payment token for different payment methods.
                 */
                if (paymentMethod !== 'none'
                        && paymentMethod !== 'default'
                        && paymentGateways[paymentMethod]['data']['token']['enabled']){
                    if ($('#DOPBSPCalendar-payment-token'+ID).val() === ''){
                        methods_order.payment.token(paymentMethod);
                        
                        return false;
                    }
                    else{
                        methods_order.vars.tokenInit = false;
                    }
                    
                    if ($('#DOPBSPCalendar-payment-token-message'+ID).val() !== ''){
                        methods_order.toggleMessages($('#DOPBSPCalendar-payment-token-message'+ID).val(),
                                                     'block');
                        $('#DOPBSPCalendar-payment-token'+ID).val('');
                        $('#DOPBSPCalendar-payment-token-message'+ID).val('');
                        
                        $('#DOPBSPCalendar-submit'+ID).css('display', 'block');
                        $('#DOPBSPCalendar-submit-loader'+ID).css('display', 'none');
                        $('#DOPBSPCalendar-submit-loader'+ID).addClass('DOPBSPCalendar-hidden');
                        
                        return false;
                    }
                }
                if (methods_calendar.data['bookingStop'] !== 0 && methods_hours.data['enabled']){
                    startDate = new Date().getTime()+methods_calendar.data['bookingStop']*60*1000;
                    y = parseInt(methods_days.vars.selectionStart.split('_')[1],10);
                    m = parseInt(methods_days.vars.selectionStart.split('-')[1],10);
                    d = parseInt(methods_days.vars.selectionStart.split('-')[2],10);
                    h = parseInt(methods_hours.vars.selectionStart.split('_')[1],10);
                    min = parseInt(methods_hours.vars.selectionStart.split(':')[1],10);
                    selection = new Date(y, m-1, d, h, min);

                    if (selection.getTime() < startDate ){
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'order', 'unavailable'),
                                                    'dopbsp-error');
                        methods_reservation.clear();
                        methods_schedule.reset();
                        
                        return false;
                    }
                }
                
                $.post(ajaxURL, {action: 'dopbsp_reservations_book',
                                 dopbsp_frontend_ajax_request: true,
                                 calendar_id: ID,
                                 language: methods_calendar.data['language'],
                                 currency: methods_currency.data['sign'],
                                 currency_code: methods_currency.data['code'],
                                 cart_data: methods_cart.cart,
                                 form: methods_form.get(),
                                 address_billing_data: methods_order.payment.address_billing.get(),
                                 address_shipping_data: methods_order.payment.address_shipping.get(),
                                 payment_method: paymentMethod,
                                 form_addon_data: methods_order.payment.form_addon.get(),
                                 card_data: methods_order.payment.card.get(),
                                 token: $('#DOPBSPCalendar-payment-token'+ID).val(),
                                 page_url: window.location.href}, function(data){  
                    data = $.trim(data);
		    
                    $('#DOPBSPCalendar-payment-token'+ID).val('');
                    $('#DOPBSPCalendar-payment-token-message'+ID).val('');
                    
                    /*
                     * If period is unavailable reload schedule.
                     */
                    if (data === 'unavailable'){
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'order', 'unavailable'),
                                                    'dopbsp-error');
                        methods_reservation.clear();
                        methods_schedule.reset();
                        
                        return false;
                    }
                    
                    /*
                     * If coupon is unavailable remove it from reservation.
                     */
                    if (data === 'unavailable-coupon'){
                        methods_info.toggleMessages(DOPBSPFrontEnd.text(ID, 'order', 'unavailableCoupon'),
                                                    'dopbsp-error');
                        methods_coupons.vars.use = false;
                        methods_reservation.set();
                        
                        return false;
                    }
                    
                    if (paymentMethod !== 'none'
                            && paymentMethod !== 'default'){
                        var response = data.split(';;;;;');

                        if (response[0] === 'success'){
                            $('#DOPBSPCalendar-submit'+ID).css('display', 'block');
                            $('#DOPBSPCalendar-submit-loader'+ID).css('display', 'none');
                            $('#DOPBSPCalendar-submit-loader'+ID).addClass('DOPBSPCalendar-hidden');

                            methods_info.toggleMessages(paymentGateways[paymentMethod]['text']['success'],
                                                        'dopbsp-success');
                            methods_reservation.clear();
                            methods_schedule.reset();
                        }
                        else if (response[0] === 'success_redirect'){
                            window.location.href = response[1];
                        } else if (response[0] === 'callback'){
                        
                            /*
                             * Outward Callback
                             */
                            
                            /*
                             * @param ID: calendar ID
                             * @param response[2]: reservation ID
                             * @param response[3]: amount
                             * @param response[4]: currency
                             * @param response[5]: extra_data JSON
                             */
                            eval(response[1]+"("+ID+","+ response[2]+",'"+ response[3]+"','"+ response[4]+"','"+response[5]+"');");
                        }
                        else{
                            $('#DOPBSPCalendar-submit'+ID).css('display', 'block');
                            $('#DOPBSPCalendar-submit-loader'+ID).css('display', 'none');
                            $('#DOPBSPCalendar-submit-loader'+ID).addClass('DOPBSPCalendar-hidden');
                            
                            methods_info.toggleMessages(data);
                            
                            return false;
                        }
                    }
                    else{
                        if (methods_order.data['redirect'] !== null
                                && methods_order.data['redirect'] !== ''){
                            window.location.href = methods_order.data['redirect'];
                        }
                        
                        $('#DOPBSPCalendar-submit'+ID).css('display', 'block');
                        $('#DOPBSPCalendar-submit-loader'+ID).css('display', 'none');
                        $('#DOPBSPCalendar-submit-loader'+ID).addClass('DOPBSPCalendar-hidden');
                        
                        methods_info.toggleMessages((methods_order.data['paymentArrivalWithApproval'] ? DOPBSPFrontEnd.text(ID, 'order', 'paymentArrivalWithApprovalSuccess'):DOPBSPFrontEnd.text(ID, 'order', 'paymentArrivalSuccess')),
                                                    'dopbsp-success');
                        methods_reservation.clear();
                        
                        /*
                         * Reload schedule if it has been changed after the reservation was made.
                         */
                        methods_reservation.clearUrl();
                        if (methods_order.data['paymentArrivalWithApproval']){
                            methods_schedule.reset();
                        }
                        else{
                            methods_calendar.display();
                            methods_components.init();
                        }
                    }
                });
            },
            
            toggleMessages:function(message,
                                    display,
                                    type){
            /*
             * Toggle order messages.
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
                
                $('#DOPBSPCalendar-order'+ID+' .dopbsp-message').html(message)
                                                                .removeClass('dopbsp-success')
                                                                .removeClass('dopbsp-error')
                                                                .addClass(type)
                                                                .css('display', display);
                
                if(display === 'block') {
                    $('#DOPBSPCalendar-order'+ID+' .dopbsp-message').removeClass('DOPBSPCalendar-hidden');
                } else {
                    $('#DOPBSPCalendar-order'+ID+' .dopbsp-message').addClass('DOPBSPCalendar-hidden');
                }
            }
        },  

// 24. WooCommerce
        
        methods_woocommerce = {
            data: {},
            text: {},
            
            init:function(){
            /*
             * Initialize WooCommerce.
             */    
                $('.cart button[type=submit]').css('display', 'none');
                    
                methods_woocommerce.events();
            },
            events:function(){
            /*
             * Initialize WooCommerce events.
             */    
                /*
                 * Woocommerce "Add to cart" button.
                 */
                if (!methods_woocommerce.data['addToCart']){
                    $('.cart').unbind('submit');
                    $('.cart').bind('submit', function(e){
                        e.preventDefault();
                        methods_woocommerce.add();
                    });
                }    
                
                /*
                 * Pay full amount
                 */
                $('input[name=DOPBSPCalendar-pay-full-amount'+ID+']').unbind('click');
                $('input[name=DOPBSPCalendar-pay-full-amount'+ID+']').bind('click', function(){
                    methods_reservation.set();
                });    
            },
            set:function(){
            /*
             * Set WooCommerce button for current reservation.
             */
                if (!methods_woocommerce.data['addToCart']){
                    $('.cart button[type=submit]').css('display', 'block');
                }
                else{
                    $('#DOPBSPCalendar-add-to-cart'+ID).css('display','block');
                    $('#DOPBSPCalendar-add-to-cart'+ID).removeClass('DOPBSPCalendar-hidden');
                    $('#DOPBSPCalendar-pay-full-amount-wrapper'+ID).removeClass('DOPBSPCalendar-hidden');
                }
            },
            
            add:function(){
            /*
             * Add product from cart using AJAX.
             */    
                $('#DOPBSPCalendar-add-to-cart'+ID).addClass('DOPBSPCalendar-hidden');
                $('#DOPBSPCalendar-pay-full-amount-wrapper'+ID).addClass('DOPBSPCalendar-hidden');
                $('#DOPBSPCalendar-add-to-cart-loader'+ID).removeClass('DOPBSPCalendar-hidden');
                
                $.post(ajaxURL, {action: 'dopbsp_woocommerce_add_to_cart',
                                 dopbsp_frontend_ajax_request: true,
                                 calendar_id: ID,
                                 language: methods_calendar.data['language'],
                                 currency: methods_currency.data['sign'],
                                 currency_code: methods_currency.data['code'],
                                 cart_data: methods_cart.cart,
                                 product_id: methods_woocommerce.data['productID']}, function(data){
                    data = $.trim(data);
                    
                    var result = data.split(';;;;;')[0],
                    message = data.split(';;;;;')[1];
                    
                    $('#DOPBSPCalendar-add-to-cart-loader'+ID).addClass('DOPBSPCalendar-hidden');
                    
                    if (result === 'success'){
                        if (methods_woocommerce.data['redirect']){
                            window.location.href = methods_woocommerce.data['cartURL'];
                        }
                        else{
                            methods_info.toggleMessages(message,
                                                        'dopbsp-success');
                        }
                    }
                    else if (result === 'unavailable'){
                        methods_info.toggleMessages(message,
                                                    'dopbsp-error');
                        methods_reservation.clear();
                        methods_schedule.reset();
                    }
                    else{
                        methods_info.toggleMessages(message,
                                                    'dopbsp-error');
                    }
                });
            }
        };
	
// 25. Public calls.

	this.methods_info_toggleMessages = function(message,
						    type){
	    methods_info.toggleMessages(message,
					type);
	};
	
	this.methods_reservation_clear = function(){
	    methods_reservation.clear();
	};
	
	this.methods_schedule_reset = function(){
	    methods_schedule.reset();
	};

        return methods.init.apply(this);
    };
})(jQuery);