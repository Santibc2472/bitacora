
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/jquery.dop.backend.BSPCalendar.js
* File Version            : 1.0
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar jQuery plugin.
*/

(function($){
    'use strict';
  
    $.fn.DOPBSPCalendar = function(options){
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
                                "text": {}}},
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
                methods_calendar.data = Data['calendar']['data'];
                methods_calendar.text = Data['calendar']['text'];
                
                methods_currency.data = Data['currency']['data'];
                methods_currency.text = Data['currency']['text'];
                
                methods_days.data = Data['days']['data'];
                methods_days.text = Data['days']['text'];
                
                methods_form.data = Data['form']['data'];
                methods_form.text = Data['form']['text'];
                
                methods_hours.data = Data['hours']['data'];
                methods_hours.text = Data['hours']['text'];
                
                ID = Data['ID'];
                
                methods_months.data = Data['months']["data"];
                methods_months.text = Data['months']["text"];
                
                methods_search.data = Data['search']["data"];
                methods_search.text = Data['search']["text"];
                
                methods_sidebar.data = Data['sidebar']["data"];
                methods_sidebar.text = Data['sidebar']["text"];
                
                methods_months.init();
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
            vars: {schedule: {}},
            
            parse:function(year){
            /*
             * Parse calendar schedule.
             * 
             * @param year (Number): the year for which the calendar should get the schedule
             */
                var scheduleBuffer = {};
                
                $.post(ajaxurl, {action: 'dopbsp_calendar_schedule_get',
                                 id: ID,
                                 year:year}, function(data){
                    if ($.trim(data) !== ''){
                        scheduleBuffer = JSON.parse($.trim(data));

                        for (var day in scheduleBuffer){
                            scheduleBuffer[day] = JSON.parse(scheduleBuffer[day]);
                        }
                        $.extend(methods_schedule.vars.schedule, scheduleBuffer);
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
                methods_schedule.vars.schedule = {};
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
                methods_calendar.init(methods_calendar.vars.startYear, 
                                      methods_calendar.vars.startMonth);                     
                /*
                 * Search
                 */
                methods_search.display();
                
                /*
                 * Filters
                 */
                methods_filters.display();

                /*
                 * methods_form.data['form']
                 */
                methods_form.display();

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
         
// 5. Price         
                
        methods_price = {
            set:function(price){
            /*
             * Display price with currency in set format.
             * 
             * @param price (Number): price value
             * 
             * @return price with currency
             */ 
                var priceDisplayed = '';
                
                price = DOPPrototypes.getWithDecimals(Math.abs(price), 
                                                      2);
                                                   
                switch (methods_currency.data['position']){
                    case 'after':
                        priceDisplayed =  price+methods_currency.data['sign'];
                        break;
                    case 'after_with_space':
                        priceDisplayed =  price+' '+methods_currency.data['sign'];
                        break;
                    case 'before_with_space':
                        priceDisplayed =  methods_currency.data['sign']+' '+price;
                        break;
                    default:
                        priceDisplayed = methods_currency.data['sign']+price;
                }
                
                return priceDisplayed;
            }
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
             *                       "notes" display notes
             * @param infoData (String): information to be displayed
             */       
                var data = (hour === '' ? methods_schedule.vars.schedule[day]:
                                          methods_schedule.vars.schedule[day]['hours'][hour]),
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
                // info = decodeURIComponent(escape(info));
                info = decodeURIComponent(unescape(unescape(info)));
                
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
                HTML.push('<div class="DOPBSPCalendar-container">');                        
                HTML.push('    <div class="DOPBSPCalendar-navigation">');
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
                HTML.push('    <div class="DOPBSPCalendar-calendar"></div>');
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
                    $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
                }
                else{
                    $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+methods_calendar.vars.currYear); 
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

                    $('.DOPBSPCalendar-container', Container).width(Container.width());
                
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
                        $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear()))
                                                                                            .addClass('dopbsp-style-small'); 
                    }
                    else{
                        $('.DOPBSPCalendar-navigation .dopbsp-month-year', Container).html(methods_months.text['names'][(methods_calendar.vars.currMonth%12 !== 0 ? methods_calendar.vars.currMonth%12:12)-1]+' '+(new Date(methods_calendar.vars.startYear, methods_calendar.vars.currMonth, 0).getFullYear()))
                                                                                            .removeClass('dopbsp-style-small'); 
                    }

                    $('.DOPBSPCalendar-navigation .dopbsp-week .dopbsp-day', Container).width(parseInt(($('.DOPBSPCalendar-navigation .dopbsp-week', Container).width()-parseInt($('.DOPBSPCalendar-navigation .dopbsp-week', Container).css('padding-left'))+parseInt($('.DOPBSPCalendar-navigation .dopbsp-week', Container).css('padding-right')))/7));
                    no = methods_days.data['first']-1;

                    $('.DOPBSPCalendar-navigation .dopbsp-week .dopbsp-day', Container).each(function(){
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
                firstDay = new Date(year, month-1, 2-methods_days.data['first']).getDay(),
                lastDay = new Date(year, month-1, noDays-methods_days.data['first']+1).getDay(),
                schedule = methods_schedule.vars.schedule,
                totalDays = 0;

                methods_days.vars.no = 0;

                if (position > 1){
                    HTML.push('<div class="DOPBSPCalendar-month-year">'+methods_months.text['names'][(month%12 !== 0 ? month%12:12)-1]+' '+year+'</div>');
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
                    day = schedule[cyear+'-'+cmonth+'-'+cday] !== undefined ? schedule[cyear+'-'+cmonth+'-'+cday]:methods_day.default(DOPPrototypes.getWeekDay(cyear+'-'+cmonth+'-'+cday));

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
                    day = schedule[cyear+'-'+cmonth+'-'+cday] !== undefined ? schedule[cyear+'-'+cmonth+'-'+cday]:methods_day.default(DOPPrototypes.getWeekDay(cyear+'-'+cmonth+'-'+cday));

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
                    day = schedule[cyear+'-'+cmonth+'-'+cday] !== undefined ? schedule[cyear+'-'+cmonth+'-'+cday]:methods_day.default(DOPPrototypes.getWeekDay(cyear+'-'+cmonth+'-'+cday));

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
                HTML.push('<div class="DOPBSPCalendar-hours" id="'+ID+'_'+year+'-'+DOPPrototypes.getLeadingZero(month)+'_hours"></div>');

                $('.DOPBSPCalendar-calendar', Container).append(HTML.join(''));
            }
        },
 
// 9. Days
        
        methods_days = {
            data: {},
            text: {},
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
                                    if (methods_days.data['morningCheckOut']){
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
                                    if (methods_days.data['morningCheckOut']){
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

                if (price > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = methods_price.set(price);
                }

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = methods_price.set(promo);
                }

                if (type !== 'dopbsp-past-day'){
                    switch (status){
                        case 'available':
                            type += ' dopbsp-available';

                            if (bind === 0 
                                    || bind === 1 
                                    || methods_hours.data['enabled']){
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+methods_calendar.text['availableMultiple']+'</span>';
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+methods_calendar.text['available']+'</span>';
                                }
                                else{
                                    contentLine2 = '<span class="dopbsp-text">'+methods_calendar.text['available']+'</span>';
                                }
                            }
                            break;
                        case 'booked':
                            type += ' dopbsp-booked';
                            contentLine2 = '<span class="dopbsp-no-available-text">'+methods_calendar.text['booked']+'</span>';                                    
                            break;
                        case 'special':
                            type += ' dopbsp-special';

                            if (bind === 0 
                                    || bind === 1 
                                    || methods_hours.data['enabled']){
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+methods_calendar.text['availableMultiple']+'</span>';
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+'<span class="dopbsp-no-available-text">'+methods_calendar.text['available']+'</span>';
                                }
                                else{
                                    contentLine2 = '<span class="dopbsp-text">'+methods_calendar.text['available']+'</span>';
                                }
                            }
                            break;
                        case 'unavailable':
                            type += ' dopbsp-unavailable';
                            contentLine2 = '<span class="dopbsp-no-available-text">'+methods_calendar.text['unavailable']+'</span>';
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
                                || (!methods_days.data['morningCheckOut']
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

                dayHTML.push('<div class="DOPBSPCalendar-day '+type+'" id="'+id+'">');
                dayHTML.push('  <div class="dopbsp-bind-left'+((bind === 2 || bind === 3) && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-enabled':'')+(methods_day.vars.previousBind === 3 && methods_days.data['morningCheckOut'] && (methods_day.vars.previousStatus === 'available' || methods_day.vars.previousStatus === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended dopbsp-'+methods_day.vars.previousStatus:'')+'">');
                dayHTML.push('      <div class="dopbsp-head">&nbsp;</div>');
                dayHTML.push('      <div class="dopbsp-body">&nbsp;</div>');
                dayHTML.push('  </div>');                        
                dayHTML.push('  <div class="dopbsp-bind-middle dopbsp-group'+((status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? bind:'0')+(bind === 3 && methods_days.data['morningCheckOut'] && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended':'')+(methods_day.vars.previousBind === 3 && methods_days.data['morningCheckOut'] && (methods_day.vars.previousStatus === 'available' || methods_day.vars.previousStatus === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended':'')+'">');
                dayHTML.push('      <div class="dopbsp-head">');
                dayHTML.push('          <div class="dopbsp-co dopbsp-'+(methods_days.data['morningCheckOut'] ? methods_day.vars.previousStatus:status)+'"></div>');
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
                dayHTML.push('          <div class="dopbsp-co dopbsp-'+(methods_days.data['morningCheckOut'] ? methods_day.vars.previousStatus:status)+'"></div>');
                dayHTML.push('          <div class="dopbsp-ci dopbsp-'+status+'"></div>');
                dayHTML.push('          <div class="dopbsp-price">'+contentLine1+'</div>');

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    dayHTML.push('          <div class="dopbsp-old-price">'+methods_price.set(price)+'</div>');
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
                dayHTML.push('  <div class="dopbsp-bind-right'+((bind === 1 || bind === 2) && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-enabled':'')+(bind === 3 && methods_days.data['morningCheckOut'] && (status === 'available' || status === 'special') && !methods_hours.data['enabled'] ? ' dopbsp-extended':'')+'">');
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
                return {"available": "",
                        "bind": 0,
                        "hours_definitions": methods_hours.data['definitions'],
                        "hours": {},
                        "info": "",
                        "info_body": "",
                        "info_info": "",
                        "notes": "",
                        "price": 0, 
                        "promo": 0,
                        "status": methods_days.data['available'][day] ? "none":"unavailable"};
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
                            if (methods_days.data['multipleSelect']){
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
                        if (!methods_calendar.data['view']){
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
                                    minDateValue = DOPPrototypes.getNoDays(DOPPrototypes.getToday(), sDate)-(methods_days.data['morningCheckOut'] ? 0:1);

                                    $('#DOPBSPCalendar-start-date'+ID).val(sDate);
                                    $('#DOPBSPCalendar-start-date-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                        methods_months.text['names'][sMonth]+' '+sDay+', '+sYear:
                                                                                        sDay+' '+methods_months.text['names'][sMonth]+' '+sYear);
                                    $('#DOPBSPCalendar-end-date'+ID).val('');
                                    $('#DOPBSPCalendar-end-date-view'+ID).val(methods_search.text['checkOut'])
                                                                                 .removeAttr('disabled');;

                                    methods_search.days.initDatepicker('#DOPBSPCalendar-end-date-view'+ID,
                                                                       '#DOPBSPCalendar-end-date'+ID,
                                                                       minDateValue);

                                    methods_days.displaySelection(methods_days.vars.selectionStart);
                                }
                                else if (!methods_days.data['morningCheckOut'] 
                                            || (methods_days.data['morningCheckOut'] 
                                                        && methods_days.vars.selectionStart !== $day.attr('id'))){
                                /*
                                 * Select second day.
                                 */
                                    methods_days.vars.selectionInit = false;
                                    methods_days.vars.selectionEnd = $day.attr('id');
                                    $('#DOPBSPCalendar-end-date-view'+ID).removeAttr('disabled');

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
                                    minDateValue = DOPPrototypes.getNoDays(DOPPrototypes.getToday(), sDate)-(methods_days.data['morningCheckOut'] ? 0:1);

                                    $('#DOPBSPCalendar-start-date'+ID).val(sDate);
                                    $('#DOPBSPCalendar-start-date-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                        methods_months.text['names'][sMonth]+' '+sDay+', '+sYear:
                                                                                        sDay+' '+methods_months.text['names'][sMonth]+' '+sYear);
                                    $('#DOPBSPCalendar-end-date'+ID).val(eDate);
                                    $('#DOPBSPCalendar-end-date-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                        methods_months.text['names'][eMonth]+' '+eDay+', '+eYear:
                                                                                        eDay+' '+methods_months.text['names'][eMonth]+' '+eYear);
                                    methods_search.days.initDatepicker('#DOPBSPCalendar-end-date-view'+ID,
                                                                       '#DOPBSPCalendar-end-date'+ID,
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

                                $('#DOPBSPCalendar-start-date'+ID).val(sDate);
                                $('#DOPBSPCalendar-start-date-view'+ID).val(methods_calendar.data['dateType'] === 1 ? 
                                                                                    methods_months.text['names'][sMonth]+' '+sDay+', '+sYear:
                                                                                    sDay+' '+methods_months.text['names'][sMonth]+' '+sYear);

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

                $('#DOPBSPCalendar-start-date'+ID).val(date);
                $('#DOPBSPCalendar-start-date-view'+ID).val(methods_calendar.data['dateType'] === 1 ? methods_months.text['names'][parseInt(month, 10)-1]+' '+day+', '+year:
                                                                                                           day+' '+methods_months.text['names'][parseInt(month, 10)-1]+' '+year);
                
                /*
                 * Select day even if status is not available or special.
                 */
                methods_days.displaySelection(methods_days.vars.selectionEnd);
                $('#'+methods_days.vars.selectionStart).addClass('dopbsp-selected');
                methods_search.set();
                
                /*
                 * Generate hours list.
                 */
                if (methods_schedule.vars.schedule[date] !== undefined){
                    hoursDef = methods_schedule.vars.schedule[date]['hours_definitions'];
                }                        

                for (i=0; i<hoursDef.length-(methods_hours.data['interval'] ? 1:0); i++){
                    if (methods_schedule.vars.schedule[date] !== undefined 
                            && methods_schedule.vars.schedule[date]['hours'][hoursDef[i]['value']] !== undefined){
                        hour = methods_schedule.vars.schedule[date]['hours'][hoursDef[i]['value']];
                    }
                    else{
                        hour = methods_hour.default();
                    }
                    
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
                if (methods_schedule.vars.schedule[date] !== undefined){
                    hoursDef = methods_schedule.vars.schedule[date]['hours_definitions'];
                }   
                
                for (i=0; i<hoursDef.length-(methods_hours.data['interval'] ? 1:0); i++){
                    if (methods_schedule.vars.schedule[date] !== undefined 
                            && methods_schedule.vars.schedule[date]['hours'][hoursDef[i]['value']] !== undefined){
                        hour = methods_schedule.vars.schedule[date]['hours'][hoursDef[i]['value']];
                    }
                    else{
                        hour = methods_hour.default();
                    }

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
                var schedule = methods_schedule.vars.schedule,
                selectedHours = new Array();
        
                /*
                 * Verify hours.
                 */
                endHour = endHour === '' ? startHour:endHour;

                $.each(schedule[day]['hours_definitions'], function(index){
                    if (startHour <= schedule[day]['hours_definitions'][index]['value'] 
                            && schedule[day]['hours_definitions'][index]['value'] <= endHour){
                        selectedHours.push(schedule[day]['hours_definitions'][index]['value']);
                    }
                });
                
                return selectedHours;
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
                        priceContent = methods_price.set(price);
                    }

                    if (promo > 0 
                            && (bind === 0 
                                    || bind === 1)){
                        priceContent = methods_price.set(promo);
                    }

                    switch (status){
                        case 'available':
                            type += ' dopbsp-available';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    availableContent = available+' '+methods_calendar.text['availableMultiple'];
                                }
                                else if (available === 1){
                                    availableContent = available+' '+methods_calendar.text['available'];
                                }
                                else{
                                    availableContent = methods_calendar.text['available'];
                                }
                            }
                            break;
                        case 'booked':
                            type += ' dopbsp-booked';

                            if (bind === 0 
                                    || bind === 1){
                                availableContent = methods_calendar.text['booked'];
                            }
                            break;
                        case 'special':
                            type += ' dopbsp-special';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    availableContent = available+' '+methods_calendar.text['availableMultiple'];
                                }
                                else if (available === 1){
                                    availableContent = available+' '+methods_calendar.text['available'];
                                }
                                else{
                                    availableContent = methods_calendar.text['available'];
                                }
                            }
                            break;
                        case 'unavailable':
                            type += ' dopbsp-unavailable';

                            if (bind === 0 
                                    || bind === 1){
                                availableContent = methods_calendar.text['unavailable'];  
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
                    hourHTML.push('        <div class="'+(promo > 0 ? 'dopbsp-price-promo':'dopbsp-price')+'">'+priceContent+'</div>');      
                }

                if (promo > 0 
                        && type !== ' dopbsp-past-hour' 
                        && (bind === 0 
                                || bind === 1)){                                      
                    hourHTML.push('        <div class="dopbsp-old-price">'+methods_price.set(price)+'</div>');
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
            default:function(){
            /*
             * Default hour data.
             * 
             * @return JSON with default data
             */
                return {"available": "",
                        "bind": 0,
                        "info": "",
                        "info_body": "",
                        "info_info": "",
                        "notes": "",
                        "price": 0, 
                        "promo": 0,
                        "status": "none"};
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
                        var hour = $(this),
                        selectionAux,
                        selectionDay = methods_days.vars.selectionStart,
                        schedule = methods_schedule.vars.schedule,
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
                
                HTML.push('<form name="DOPBSPCalendar-form'+ID+'" id="DOPBSPCalendar-form'+ID+'" action="" method="POST" onsubmit="return false;">');
                HTML.push('</form>');

                return HTML.join('');
            },
            init:function(){
            /*
             * Initialize sidebar.
             */
                methods_search.init();
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
                HTML.push('</div>');
                
                $('#DOPBSPCalendar-form'+ID).append(HTML.join(''));
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
            },
            set:function(toSet){
            /*
             * Set sidebar search module.
             * 
             * @param toSet (String): what to set in search module
             *                        "hours" set hours & number of items
             *                        "noItems" number of items
             */    
//                toSet = toSet === undefined ? 'hours':toSet;
//                
//                if (toSet === 'hours' 
//                        && methods_hours.data['enabled']){ 
//                    methods_search.hours.set();
//                }

                methods_filters.set();
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
                    HTML.push('     <label for="DOPBSPCalendar-start-date-view'+ID+'">'+methods_search.text['checkIn']+'</label>');
                    HTML.push('     <input type="text" name="DOPBSPCalendar-start-date-view'+ID+'" id="DOPBSPCalendar-start-date-view'+ID+'" class="DOPBSPCalendar-start-date-view" value="" />');
                    HTML.push('     <input type="hidden" name="DOPBSPCalendar-start-date'+ID+'" id="DOPBSPCalendar-start-date'+ID+'" value="" />');
                    HTML.push(' </div>');

                    /*
                     * Check out.
                     */
                    HTML.push(' <div class="dopbsp-input-wrapper">');
                    HTML.push('     <label for="DOPBSPCalendar-end-date-view'+ID+'">'+methods_search.text['checkOut']+'</label>');
                    HTML.push('     <input type="text" name="DOPBSPCalendar-end-date-view'+ID+'" id="DOPBSPCalendar-end-date-view'+ID+'" class="DOPBSPCalendar-end-date-view" value="" />');
                    HTML.push('     <input type="hidden" name="DOPBSPCalendar-end-date'+ID+'" id="DOPBSPCalendar-end-date'+ID+'" value="" />');
                    HTML.push(' </div>');

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
                                      dayNames: methods_days.text['names'],
                                      dayNamesMin: methods_days.text['shortNames'],
                                      firstDay: methods_days.data['first'],
                                      minDate: minDate,
                                      monthNames: methods_months.text['names'],
                                      monthNamesMin: methods_months.text['shortNames'],
                                      nextText: methods_calendar.text['nextMonth'],
                                      prevText: methods_calendar.text['previousMonth']});
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
                            /*
                             * Initialize check in datepicker.
                             */
                            methods_search.days.initDatepicker('#DOPBSPCalendar-start-date-view'+ID,
                                                               '#DOPBSPCalendar-start-date'+ID);

                            if (methods_hours.data['enabled']){
                                /*
                                 * Initialize hours select events.
                                 */
                                methods_search.days.events.selectHours();
                            }
                            else{
                                    /*
                                     * Initialize check out datepicker.
                                     */
                                    methods_search.days.initDatepicker('#DOPBSPCalendar-end-date-view'+ID,
                                                                       '#DOPBSPCalendar-end-date'+ID);
                                    $('#DOPBSPCalendar-end-date-view'+ID).attr('disabled', 'disabled');
                                    
                                    /*
                                     * Initialize multiple days select events.
                                     */
                                    methods_search.days.events.selectMultiple();
                            }
                    },
                    selectHours:function(){
                    /*
                     * Initialize sidebar search days events when hours need to be selected.
                     */   
                        /*
                         * Check in click event.
                         */
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('click', function(){
                            $(this).val('');
                            methods_hours.clear();
                            methods_search.set();
                        });

                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPCalendar-start-date'+ID).val();

                            if (methods_search.days.validate(ciDay)){
                                methods_calendar.init(parseInt(ciDay.split('-')[0], 10), 
                                                      parseInt(ciDay.split('-')[1], 10));
                                methods_hours.display(ID+'_'+ciDay);
                            }
                            else{
                                $('#DOPBSPCalendar-start-date-view'+ID).val('');
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
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('click', function(){
                            $('#DOPBSPCalendar-end-date-view'+ID).val('')
                                                                 .attr('disabled', 'disabled');
                            $('#DOPBSPCalendar-start-date'+ID).val('');
                            $('#DOPBSPCalendar-end-date'+ID).val('');

                            $(this).val('');
                            methods_days.vars.selectionInit = false;
                            methods_days.clearSelection();
                            methods_search.set();
                        });

                        /*
                         * Check in blur event.
                         */
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('blur');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('blur', function(){  
                            methods_search.set();
                        });
                        
                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPCalendar-start-date'+ID).val(),
                            year = parseInt(ciDay.split('-')[0], 10),
                            month = parseInt(ciDay.split('-')[1], 10)-1,
                            minDateValue;
                            
                            if (methods_search.days.validate(ciDay)){
                                minDateValue = DOPPrototypes.getNoDays(DOPPrototypes.getToday(), ciDay)-(methods_days.data['morningCheckOut'] ? 0:1);
                                methods_days.vars.selectionInit = true;
                                methods_days.vars.selectionStart = ID+'_'+ciDay;
                                methods_days.vars.selectionEnd = ID+'_'+ciDay;

                                $('#DOPBSPCalendar-end-date-view'+ID).removeAttr('disabled')
                                                                     .val('');
                                $('#DOPBSPCalendar-end-date'+ID).val('');
                                methods_search.days.initDatepicker('#DOPBSPCalendar-end-date-view'+ID,
                                                                   '#DOPBSPCalendar-end-date'+ID,
                                                                   minDateValue);

                                methods_calendar.init(year, 
                                                      month+1);
                                methods_days.displaySelection(methods_days.vars.selectionEnd);

                                setTimeout(function(){
                                    $('#DOPBSPCalendar-end-date-view'+ID).val('')
                                                                         .select();  
                                    $('#DOPBSPCalendar-end-date'+ID).val('');
                                }, 100);
                            }
                            else{
                                $('#DOPBSPCalendar-start-date-view'+ID).val('');
                            }
                        });
                        
                        /*
                         * Check out click event.
                         */
                        $('#DOPBSPCalendar-end-date-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-end-date-view'+ID).bind('click', function(){  
                            $('#DOPBSPCalendar-end-date-view'+ID).val('');  
                            $('#DOPBSPCalendar-end-date'+ID).val('');      

                            methods_search.set();
                        });
                        
                        /*
                         * Check out blur event.
                         */
                        $('#DOPBSPCalendar-end-date-view'+ID).unbind('blur');
                        $('#DOPBSPCalendar-end-date-view'+ID).bind('blur', function(){ 
                            setTimeout(function(){         
                                methods_search.set();
                            }, 100);
                        });

                        /*
                         * Check out change event.
                         */
                        $('#DOPBSPCalendar-end-date-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-end-date-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPCalendar-start-date'+ID).val(),
                            coDay = $('#DOPBSPCalendar-end-date'+ID).val();
                            
                            setTimeout(function(){
                                if (methods_search.days.validate(coDay)){
                                    methods_days.vars.selectionInit = false;
                                    methods_days.vars.selectionEnd = ID+'_'+coDay;

                                    methods_calendar.init(parseInt(ciDay.split('-')[0], 10), 
                                                          parseInt(ciDay.split('-')[1], 10));
                                    methods_days.displaySelection(methods_days.vars.selectionEnd);
                                    methods_search.set();
                                }
                                else{
                                    $('#DOPBSPCalendar-end-date-view'+ID).val('');
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
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('click');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('click', function(){
                            $(this).val('');
                            methods_days.vars.selectionInit = false;
                            methods_days.clearSelection();
                            methods_search.set();
                        });

                        /*
                         * Check in blur event.
                         */
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('blur');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('blur', function(){
                            methods_search.set();
                        });

                        /*
                         * Check in change event.
                         */
                        $('#DOPBSPCalendar-start-date-view'+ID).unbind('change');
                        $('#DOPBSPCalendar-start-date-view'+ID).bind('change', function(){
                            var ciDay = $('#DOPBSPCalendar-start-date'+ID).val();

                            if (methods_search.days.validate(ciDay)){
                                methods_days.vars.selectionStart = ID+'_'+ciDay;
                                methods_days.vars.selectionEnd = ID+'_'+ciDay;

                                methods_calendar.init(parseInt(ciDay.split('-')[0], 10), 
                                                      parseInt(ciDay.split('-')[1], 10));
                                methods_days.displaySelection(methods_days.vars.selectionEnd);
                                methods_search.set();
                            }
                            else{
                                $('#DOPBSPCalendar-start-date-view'+ID).val('');
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
                    HTML.push('     <label for="DOPBSPCalendar-start-hour'+ID+'">'+methods_search.text['hourStart']+'</label>');
                    HTML.push('     <div id="DOPSelect-DOPBSPCalendar-start-hour'+ID+'"></div>');
                    HTML.push(' </div>');

                    /*
                     * End hour.
                     */
                    HTML.push(' <div class="dopbsp-input-wrapper">');
                    HTML.push('     <label for="DOPBSPCalendar-end-hour'+ID+'">'+methods_search.text['hourEnd']+'</label>');
                    HTML.push('     <div id="DOPSelect-DOPBSPCalendar-end-hour'+ID+'"></div>');
                    HTML.push(' </div>');

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
                    schedule = methods_schedule.vars.schedule,
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
                            schedule = methods_schedule.vars.schedule,
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
            }
        },
          
// 13. Filters
                
        methods_filters = {
            vars: {endDay: '',
                   endMonth: '',
                   endYear: '',
                   startDay: '',
                   startMonth: '',
                   startYear: ''},
            
            display:function(){
                var HTML = new Array();
                
                HTML.push(methods_filters.days.display());
                
                if (methods_hours.data['enabled']){
                    HTML.push(methods_filters.hours.display());
                }
                
                $('#DOPBSPCalendar-form'+ID).append(HTML.join(''));
            },
            init:function(){
//                methods_filters.set();
            },
            set:function(){
                methods_filters.days.set();
            },
            
            days: {
                display:function(){
                    var HTML = new Array();
                    
                    HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                    HTML.push(' <h3>Filter days</h3>');
                    HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPCalendar-filters-days'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPCalendar-filters-days'+ID+'" class="dopbsp-button"></a>');
                    HTML.push(' <a href="javascript:void(0)" id="DOPBSP-inputs-button-DOPBSPCalendar-filters-days-uncheck-all'+ID+'" class="dopbsp-button dopbsp-uncheck-all"></a>');
                    HTML.push(' <a href="javascript:void(0)" id="DOPBSP-inputs-button-DOPBSPCalendar-filters-days-check-all'+ID+'" class="dopbsp-button dopbsp-check-all"></a>');
                    HTML.push('</div>');
                    HTML.push('<div id="DOPBSP-inputs-DOPBSPCalendar-filters-days'+ID+'" class="dopbsp-inputs-wrapper">');
                    
                    HTML.push('</div>');

                    return HTML.join('');
                },
                
                set:function(){
                /*
                 * Set the days filters between 2 dates, included.
                 * 
                 * @return array with selected days
                 */
                    var HTML = new Array(),
                    i;
            
                    methods_filters.vars.startDay = methods_days.vars.selectionStart.split('_')[1];
                    methods_filters.vars.startYear = methods_filters.vars.startDay.split('-')[0];
                    methods_filters.vars.startMonth = methods_filters.vars.startDay.split('-')[1];
                    methods_filters.vars.endDay = methods_days.vars.selectionEnd.split('_')[1];
                    methods_filters.vars.endYear = methods_filters.vars.endDay.split('-')[0];
                    methods_filters.vars.endMonth = methods_filters.vars.endDay.split('-')[1];
                    
                    HTML.push(methods_filters.days.displayWeekdays());
                    HTML.push(methods_filters.days.displayMonth(parseInt(methods_filters.vars.startYear, 10),
                                                                parseInt(methods_filters.vars.startMonth, 10)));
                    
                    $('#DOPBSP-inputs-DOPBSPCalendar-filters-days'+ID).html(HTML.join(''));
                    
                    methods_filters.days.init();
                },
                displayMonth:function(year,
                                      month){
                /*
                 * Display month.
                 * 
                 * @param year (Number): the year that has the month to be initialized
                 * @param month (Number): month to be initialized
                 * 
                 * @return months HTML
                 */    
                    var cmonth, 
                    cday, 
                    cyear,
                    d, 
                    day,
                    HTML = new Array(), 
                    i, 
                    noDays = new Date(year, month, 0).getDate(),
                    firstDay = new Date(year, month-1, 2-methods_days.data['first']).getDay(),
                    lastDay = new Date(year, month-1, noDays-methods_days.data['first']+1).getDay(),
                    totalDays = 0;
            
                    HTML.push('<div class="dopbsp-inputs-header dopbsp-display'+(parseInt(methods_filters.vars.endYear, 10) === year && parseInt(methods_filters.vars.endMonth, 10) === month ? ' dopbsp-last':'')+'">');
                    HTML.push(' <h3>'+methods_months.text['names'][month-1]+' '+year+'</h3>');
                    HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPCalendar-filters-days'+ID+'-'+year+'-'+month+'\')" id="DOPBSP-inputs-button-DOPBSPCalendar-filters-days'+ID+'-'+year+'-'+month+'" class="dopbsp-button"></a>');
                    HTML.push(' <a href="javascript:void(0)" id="DOPBSP-inputs-button-DOPBSPCalendar-filters-days-uncheck-all'+ID+'-'+year+'-'+month+'" class="dopbsp-button dopbsp-uncheck-all"></a>');
                    HTML.push(' <a href="javascript:void(0)" id="DOPBSP-inputs-button-DOPBSPCalendar-filters-days-check-all'+ID+'-'+year+'-'+month+'" class="dopbsp-button dopbsp-check-all"></a>');
                    HTML.push('</div>');
                    HTML.push('<div id="DOPBSP-inputs-DOPBSPCalendar-filters-days'+ID+'-'+year+'-'+month+'" class="dopbsp-inputs-wrapper'+(parseInt(methods_filters.vars.endYear, 10) === year && parseInt(methods_filters.vars.endMonth, 10) === month ? ' dopbsp-last':'')+' DOPBSPCalendar-hidden">');
                    
                    HTML.push(methods_filters.days.displayWeekdays());  
                    
                    HTML.push(' <table class="dopbsp-days">');
                    HTML.push('     <tbody>');
                    HTML.push('         <tr>');

                    /*
                     * Display previous month days.
                     */
                    for (i=(firstDay === 0 ? 7:firstDay)-1; i>=1; i--){
                        totalDays++;

                        HTML.push('             <td>&nbsp;</td>');

                        if (totalDays%7 === 0){
                            HTML.push('             </tr><tr>');
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
                        day = cyear+'-'+cmonth+'-'+cday;

                        if (day >= methods_filters.vars.startDay
                                && day <= methods_filters.vars.endDay){
                            HTML.push('             <td>'); 
                            HTML.push('                 <div class="dopbsp-input-wrapper">');
                            HTML.push('                     <input type="checkbox" name="DOPBSPCalendar-days-filter-'+cyear+'-'+cmonth+'-'+cday+'" id="DOPBSPCalendar-days-filter-'+cyear+'-'+cmonth+'-'+cday+'" class="DOPBSPCalendar-days-filter" checked="checked" />'); 
                            HTML.push('                     <label for="DOPBSPCalendar-days-filter-'+cyear+'-'+cmonth+'-'+cday+'" class="dopbsp-for-checkbox">'+cday+'</label>'); 
                            HTML.push('                 </div>');
                            HTML.push('             </td>'); 
                        }
                        else{
                            HTML.push('             <td>&nbsp;</td>');
                        }

                        if (totalDays%7 === 0){
                            HTML.push('             </tr><tr>');
                        }
                    }

                    /*
                     * Display next month days.
                     */
                    for (i=1; i<=(totalDays+7 < 42 ? 14:7)-lastDay; i++){
                        totalDays++;

                        HTML.push('             <td>&nbsp;</td>');

                        if (totalDays%7 === 0){
                            HTML.push('             </tr>');
                            break
                        }
                    }
                    HTML.push('     </tbody>');
                    HTML.push(' </table>');
                    HTML.push('</div>');

                    if (methods_filters.vars.endYear+'-'+methods_filters.vars.endMonth > year+'-'+DOPPrototypes.getLeadingZero(month)){
                        HTML.push(methods_filters.days.displayMonth(month%12 === 0 ? year+1:year,
                                                                    month%12 === 0 ? 1:month+1));
                    }

                    return HTML.join('');
                },
                displayWeekdays:function(){
                    var HTML = new Array(),
                    i;
                    
                    HTML.push(' <table class="dopbsp-weekdays">');
                    HTML.push('     <tbody>');
                    HTML.push('         <tr>');
                    
                    for (i=1; i<=7; i++){
                        HTML.push('             <td>');
                        HTML.push('                 <div class="dopbsp-input-wrapper">');
                        HTML.push('                     <input type="checkbox" checked="checked" />');
                        HTML.push('                     <label class="dopbsp-for-checkbox">'+methods_days.text['shortNames'][i === 7 ? 0:i]+'</label>');
                        HTML.push('                 </div>');
                        HTML.push('             </td>');
                    }
                    HTML.push('         </tr>'); 
                    HTML.push('     </tbody>'); 
                    HTML.push(' </table>');
                    
                    return HTML.join('');
                },
                    
                init:function(){
                    methods_filters.days.events();
                },
                events:function(){
                    $('#DOPBSP-inputs-button-DOPBSPCalendar-filters-days-check-all'+ID).unbind('click');
                    $('#DOPBSP-inputs-button-DOPBSPCalendar-filters-days-check-all'+ID).bind('click', function(){
                        $('#DOPBSP-inputs-DOPBSPCalendar-filters-days'+ID+' input[type=checkbox]').attr('checked', 'checked');
                    });
                    
                    $('#DOPBSP-inputs-button-DOPBSPCalendar-filters-days-uncheck-all'+ID).unbind('click');
                    $('#DOPBSP-inputs-button-DOPBSPCalendar-filters-days-uncheck-all'+ID).bind('click', function(){
                        $('#DOPBSP-inputs-DOPBSPCalendar-filters-days'+ID+' input[type=checkbox]').removeAttr('checked');
                    });
                }
            },
            hours: {
                display:function(){
                    var HTML = new Array();

                    HTML.push('<div class="dopbsp-inputs-header dopbsp-hide">');
                    HTML.push(' <h3>Filter hours</h3>');
                    HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPCalendar-filters-hours'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPCalendar-filters-hours'+ID+'" class="dopbsp-button"></a>');
                    HTML.push('</div>');
                    HTML.push('<div id="DOPBSP-inputs-DOPBSPCalendar-filters-hours'+ID+'" class="dopbsp-inputs-wrapper">');



                    HTML.push('</div>');

                    return HTML.join('');
                },

                set:function(){
                    methods_filters.hours.init();
                },
                init:function(){
                    methods_filters.hours.events();
                },
                events:function(){

                }
            }
        },
                
// 14. Form
                
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
                HTML.push(' <h3>'+methods_form.text['title']+'</h3>');
                HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPCalendar-form'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPCalendar-form'+ID+'" class="dopbsp-button"></a>');
                HTML.push('</div>');
                HTML.push('<div id="DOPBSP-inputs-DOPBSPCalendar-form'+ID+'" class="dopbsp-inputs-wrapper">');

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
                            HTML.push('     <label class="dopbsp-for-checkbox-with-width" for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <input type="checkbox" name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" />');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info dopbsp-checkbox-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                            break;
                        case 'select':
                            /*
                             * Select field.
                             */
                            HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <select name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+(formField['multiple_select'] === 'true' ? '[]':'')+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" value=""'+(formField['multiple_select'] === 'true' ? ' multiple':'')+'>');

                            for (j=0; j<formField['options'].length; j++){
                                formFieldOption = formField['options'][j];
                                HTML.push('<option value="'+formFieldOption['id']+'">'+formFieldOption['translation']+'</option>');
                            }
                            HTML.push('     </select>');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                            break;
                        case 'text':
                            /*
                             * Text field.
                             */
                            HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? ' <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <input type="text" name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" value="" />');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                            break;
                        case 'textarea':
                            /*
                             * Textarea field.
                             */
                            HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                            HTML.push('     <textarea name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" col="" rows="3"></textarea>');
                            HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                            break;
                    }
                    HTML.push(' </div>');
                }
                
                HTML.push('</div>');
                
                $('#DOPBSPCalendar-form'+ID).append(HTML.join(''));
                
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
                        $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).DOPSelect();
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
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).unbind('click');
                            $('#DOPBSPCalendar-form-field'+ID+'_'+formField['id']).bind('click', function(){
                                var id = $(this).attr('id').split('DOPBSPCalendar-form-field'+ID+'_')[1];
                                
                                /*
                                 * Verify if required.
                                 */
                                if (formData[id]['required'] === 'true' 
                                        && !$(this).is(':checked')){
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
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
                                        && !DOPPrototypes.validEmail(value)){
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else if (formData[id]['required'] === 'true' 
                                            && value === ''){
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'block');
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
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
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
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
                                }
                                else{
                                    $('#DOPBSPCalendar-form-field-warning'+ID+'_'+id).css('display', 'none');
                                }
                            });
                            break;
                    }
                }
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
            },
            days: {
                display: function(){
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
                    HTML.push(' <h3>'+methods_form.text['title']+'</h3>');
                    HTML.push(' <a href="javascript:DOPBSPBackEnd.toggleInputs(\'DOPBSPCalendar-form'+ID+'\')" id="DOPBSP-inputs-button-DOPBSPCalendar-form'+ID+'" class="dopbsp-button"></a>');
                    HTML.push('</div>');
                    HTML.push('<div id="DOPBSP-inputs-DOPBSPCalendar-form'+ID+'" class="dopbsp-inputs-wrapper">');

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
                                HTML.push('     <label class="dopbsp-for-checkbox-with-width" for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                                HTML.push('     <input type="checkbox" name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" />');
                                HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info dopbsp-checkbox-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                                break;
                            case 'select':
                                /*
                                 * Select field.
                                 */
                                HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                                HTML.push('     <select name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+(formField['multiple_select'] === 'true' ? '[]':'')+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" value=""'+(formField['multiple_select'] === 'true' ? ' multiple':'')+'>');

                                for (j=0; j<formField['options'].length; j++){
                                    formFieldOption = formField['options'][j];
                                    HTML.push('<option value="'+formFieldOption['id']+'">'+formFieldOption['translation']+'</option>');
                                }
                                HTML.push('     </select>');
                                HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                                break;
                            case 'text':
                                /*
                                 * Text field.
                                 */
                                HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? ' <span class="dopbsp-required">*</span>':'')+'</label>');
                                HTML.push('     <input type="text" name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" value="" />');
                                HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                                break;
                            case 'textarea':
                                /*
                                 * Textarea field.
                                 */
                                HTML.push('     <label for="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'">'+formField['translation']+(formField['required'] === 'true' ? '  <span class="dopbsp-required">*</span>':'')+'</label>');
                                HTML.push('     <textarea name="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" id="DOPBSPCalendar-form-field'+ID+'_'+formField['id']+'" col="" rows="3"></textarea>');
                                HTML.push('     <a href="javascript:void(0)" id="DOPBSPCalendar-form-field-warning'+ID+'_'+formField['id']+'" class="dopbsp-button dopbsp-warning-info"><span class="dopbsp-info dopbsp-warning-info">'+formField['translation']+' '+methods_form.text['required']+'</span></a>');
                                break;
                        }
                        HTML.push(' </div>');
                    }

                    HTML.push('</div>');

                    $('#DOPBSPCalendar-form'+ID).append(HTML.join(''));

                    methods_form.init();

                }
            },
            hours: {
                
            }
        };

        return methods.init.apply(this);
    };
})(jQuery);