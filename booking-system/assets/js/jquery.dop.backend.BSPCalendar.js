
/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.2.0
* File                    : assets/js/jquery.dop.backend.BSPCalendar.js
* File Version            : 1.0.9
* Created / Last Modified : 30 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar jQuery plugin.
*/

(function($){
    $.fn.DOPBSPCalendar = function(options){
        /*
         * Private variables.
         */
        var Data = {'AddLastHourToTotalPrice': true,
                    'AddMonthViewText': 'Add month view',
                    'AvailableDays': [true, true, true, true, true, true, true],
                    'AvailableLabel': 'Number available',
                    'AvailableOneText': 'available',
                    'AvailableText': 'available',
                    'BookedText': 'booked',
                    'Currency': '$',
                    'CurrencyPosition': 'before',
                    'DateEndLabel': 'End date',
                    'DateStartLabel': 'Start date',
                    'DateType': 1,
                    'DayNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'DetailsFromHours': true,
                    'FirstDay': 1,
                    'HoursEnabled': false,
                    'GroupDaysLabel': 'Group days',
                    'GroupHoursLabel': 'Group hours',
                    'HourEndLabel': 'End hour',
                    'HourStartLabel': 'Start hour',
                    'HoursAMPM': false,
                    'HoursDefinitions': [{"value": "00:00"}],
                    'HoursDefinitionsChangeLabel': 'Change hours definitions (changing the definitions will overwrite any previous hours data)',
                    'HoursDefinitionsLabel': 'Hours definitions (hh:mm add one per line). Use only 24 hours format.',
                    'HoursSetDefaultDataLabel': 'Set default hours values for this day(s). This will overwrite any existing data.',
                    'HoursIntervalEnabled': false,
                    'HoursIntervalAutobreakEnabled': false,
                    'ID': 0,
                    'DefaultSchedule': {"available":0,"bind":0,"hours":{},"hours_definitions":[{"value":"00:00"}],"info":"","notes":"","price":0,"promo":0,"status":"none"},
                    'SavedDefaultSchedule': {"available":0,"bind":0,"hours":{},"hours_definitions":[{"value":"00:00"}],"info":"","notes":"","price":0,"promo":0,"status":"none"},
                    'InfoLabel': 'Information (users will see this message)',
                    'MaxYear': new Date().getFullYear(),
                    'MonthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    'NextMonthText': 'Next month',
                    'NotesLabel': 'Notes (only you will see this message)',
                    'PreviousMonthText': 'Previous Month',
                    'PriceLabel': 'Price',
                    'PromoLabel': 'Promo price',
                    'Reinitialize': false,
                    'RemoveMonthViewText': 'Remove month view',
                    'ResetConfirmation': 'Are you sure you want to reset data? If you reset days, hours data from those days will be reset to.',
                    'SetDaysAvailabilityLabel': 'Set days availability',
                    'SetHoursDefinitionsLabel': 'Set hours definitions',
                    'StatusAvailableText': 'Available',
                    'StatusBookedText': 'Booked',
                    'StatusLabel': 'Status',
                    'StatusSpecialText': 'Special',
                    'StatusUnavailableText': 'Unavailable',
                    'UnavailableText': 'unavailable'},
        Container = this,

        SavedDefaultSchedule = {},

        StartDate = new Date(),
        StartYear = StartDate.getFullYear(),
        StartMonth = StartDate.getMonth()+1,
        StartDay = StartDate.getDate(),
        CurrYear = StartYear,
        CurrMonth = StartMonth,

        AddLastHourToTotalPrice = true,
        AddMonthViewText = 'Add month view',
        AvailableDays = [true, true, true, true, true, true, true],
        AvailableLabel = 'Number available',
        AvailableOneText = 'available',
        AvailableText = 'available',
        BookedText = 'booked',
        Currency = '$',
        CurrencyPosition = 'before',
        DateEndLabel = 'End date',
        DateStartLabel = 'Start date',
        DateType = 1,
        DayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        DetailsFromHours = true,
        FirstDay = 1,
        HoursEnabled = true,
        GroupDaysLabel = 'Group days',
        GroupHoursLabel = 'Group hours',
        HourEndLabel = 'End hour',
        HourStartLabel = 'Start hour',
        HoursAMPM = false,
        HoursDefinitions = [{"value": "00:00"}],
        HoursDefinitionsChangeLabel = 'Change hours definitions (changing the definitions will overwrite any previous hours data)',
        HoursDefinitionsLabel = 'Hours definitions (hh:mm add one per line). Use only 24 hours format.',
        HoursSetDefaultDataLabel = 'Set default hours values for this day(s). This will overwrite any existing data.',
        HoursIntervalEnabled = false,
        HoursIntervalAutobreakEnabled = false,
        ID = 0,
        InfoLabel = 'nformation (users will see this message)',
        MaxYear = new Date().getFullYear(),
        MonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        NextMonthText = 'Next month',
        NotesLabel = 'Notes (only you will see this message)',
        PreviousMonthText = 'Previous month',
        PriceLabel = 'Price',
        PromoLabel = 'Promo',
        RemoveMonthViewText = 'Remove month view',
        ResetConfirmation =  'Are you sure you want to reset data? If you reset days, hours data from those days will be reset to.',
        SetDaysAvailabilityLabel = 'Set days availability',
        SetHoursDefinitionsLabel = 'Set hours definitions',
        StatusAvailableText = 'Available',
        StatusBookedText = 'Booked',
        StatusLabel = 'Status',
        StatusSpecialText = 'Special',
        StatusUnavailableText = 'Unavailable',
        UnavailableText = 'unavailable',
        
        showCalendar = true,
        firstYearLoaded = false,
        
        noMonths = 1,
        dayStartSelection,
        dayEndSelection,
        dayFirstSelected = false,
        dayTimeDisplay = false,
        dayStartSelectionCurrMonth,
        dayNo = 0,
        
        hourStartSelection,
        hourEndSelection,
        hourDaySelection,
        hourFirstSelected = false,
        
        yearStartSave,
        monthStartSave,
        yearEndSave,
        monthEndSave,

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
                            || Data['Reinitialize']){
                        $(Container).addClass('dopbsp-initialized');
                        methods.parse();
                    }
                });
            },
            parse:function(){
            /*
             * Parse jQuery plugin options.
             */    
                AddLastHourToTotalPrice = Data['AddLastHourToTotalPrice'] === 'true' ? true:false;
                AddMonthViewText = Data['AddMonthViewText'];
                AvailableDays[0] = Data['AvailableDays'][0] === "true" ? true:false;
                AvailableDays[1] = Data['AvailableDays'][1] === "true" ? true:false;
                AvailableDays[2] = Data['AvailableDays'][2] === "true" ? true:false;
                AvailableDays[3] = Data['AvailableDays'][3] === "true" ? true:false;
                AvailableDays[4] = Data['AvailableDays'][4] === "true" ? true:false;
                AvailableDays[5] = Data['AvailableDays'][5] === "true" ? true:false;
                AvailableDays[6] = Data['AvailableDays'][6] === "true" ? true:false;
                AvailableLabel = Data['AvailableLabel'];
                AvailableOneText = Data['AvailableOneText'];
                AvailableText = Data['AvailableText'];
                BookedText = Data['BookedText'];
                Currency = Data['Currency'];
                CurrencyPosition = Data['CurrencyPosition'];
                DateEndLabel = Data['DateEndLabel'];
                DateStartLabel = Data['DateStartLabel'];
                DateType = Data['DateType'];
                DayNames = Data['DayNames'];
                DetailsFromHours = Data['DetailsFromHours'] === 'true' ? true:false;
                FirstDay = Data['FirstDay'];
                HoursEnabled = Data['HoursEnabled'] === 'true' ? true:false;
                GroupDaysLabel = Data['GroupDaysLabel'];
                GroupHoursLabel = Data['GroupHoursLabel'];
                HourEndLabel = Data['HourEndLabel'];
                HourStartLabel = Data['HourStartLabel'];
                HoursAMPM = Data['HoursAMPM'] === 'true' ? true:false;
                HoursDefinitions = Data['HoursDefinitions'];
                HoursDefinitionsChangeLabel = Data['HoursDefinitionsChangeLabel'];
                HoursDefinitionsLabel = Data['HoursDefinitionsLabel'];
                HoursSetDefaultDataLabel = Data['HoursSetDefaultDataLabel'];
                HoursIntervalEnabled = Data['HoursIntervalEnabled'] === 'true' ? true:false;
                HoursIntervalAutobreakEnabled = Data['HoursIntervalAutobreakEnabled'] === 'true' ? true:false;
                ID = Data['ID'];
                SavedDefaultSchedule = Data['SavedDefaultSchedule'];
                InfoLabel = Data['InfoLabel'];
                MaxYear = Data['MaxYear'];
                MonthNames = Data['MonthNames'];
                NextMonthText = Data['NextMonthText'];
                NotesLabel = Data['NotesLabel'];
                PreviousMonthText = Data['PreviousMonthText'];
                PriceLabel = Data['PriceLabel'];
                PromoLabel = Data['PromoLabel'];
                RemoveMonthViewText = Data['RemoveMonthViewText'];
                ResetConfirmation = Data['ResetConfirmation'];
                SetDaysAvailabilityLabel = Data['SetDaysAvailabilityLabel'];
                SetHoursDefinitionsLabel = Data['SetHoursDefinitionsLabel'];
                StatusAvailableText = Data['StatusAvailableText'];
                StatusBookedText = Data['StatusBookedText'];
                StatusLabel = Data['StatusLabel'];
                StatusSpecialText = Data['StatusSpecialText'];
                StatusUnavailableText = Data['StatusUnavailableText'];
                UnavailableText = Data['UnavailableText'];
		
		
		DOT.methods.calendar_days.settings[ID] = {"available": AvailableDays,
							  "first": FirstDay,
							  "firstDisplayed": "",
							  "morningCheckOut": false,
							  "multipleSelect": true};
		DOT.methods.calendar_days.text[ID] = {"names": DayNames,
						      "shortNames": DayNames};
						  
                DOT.methods.calendar_schedule.default[ID] = JSON.parse(Data['DefaultSchedule']);
		DOT.methods.calendar_schedule.data[ID] = {};

                methods_schedule.parse(new Date().getFullYear());
            },
            doMetaboxHideBuster:function(){
            /*
             * If post meta box is closed, open it before resize.
             * 
             * @return true/false
             */
                if ($('#dopbsp-custom-post-meta').hasClass('closed')){
                    $('#dopbsp-custom-post-meta').removeClass('closed');
                    return true;
                }
                else{
                    return false;
                }
            },
            undoMetaboxHideBuster:function(wasHidden){
            /*
             * If post meta box is closed, close it after resize.
             * 
             * @param wasHidden (Boolean): true if meta box was closed
             */
                if (wasHidden){
                    $('#dopbsp-custom-post-meta').addClass('closed');
                }
            },
            externalCheck:function(){
                    /*
                     * Check for changes outside the calendar's jQuery plugin that might affect the calendar.
                     */    
                        if ($('#DOPBSP-calendar-jump-to-day').val() !== ''){
                            var date = $('#DOPBSP-calendar-jump-to-day').val(),
                            year = parseInt(date.split('-')[0], 10),
                            month = parseInt(date.split('-')[1], 10);

                            $('#DOPBSP-calendar-jump-to-day').val('');
                            methods_calendar.init(StartYear,
                                                  (year-StartYear)*12+month);

                            $('html').animate({scrollTop: 0}, 600, function(){
                                $('#'+ID+'_'+date).addClass('day-jump');

                                setTimeout(function(){
                                    $('#'+ID+'_'+date).removeClass('day-jump');
                                }, 1200);
                            });
                        }

                        if ($('#DOPBSP-calendar-jump-to-day').val() !== ''){
                            $('#DOPBSP-calendar-jump-to-day').val('');
                            showCalendar = true;
                            firstYearLoaded = false;
                            DOPBSPBackEnd.toggleMessages('active', 
                                                  DOPBSPBackEnd.text('MESSAGES_LOADING'));
                            methods_schedule.parse(new Date().getFullYear());
                        }

                        setTimeout(function(){
                            methods.externalCheck();
                        }, 500);
                    }
        },
                
// Calendar                
        methods_calendar = {
            display:function(){
            /*
             * Display calendar.
             */    
                var HTML = new Array(),
                no;

                HTML.push('<div class="DOPBSPCalendar-container">');                        
                HTML.push('    <div class="DOPBSPCalendar-navigation">');
                HTML.push('        <a href="javascript:void(0)" class="add-btn"><span class="info">'+AddMonthViewText+'</span></a>');                        
                HTML.push('        <a href="javascript:void(0)" class="remove-btn"><span class="info">'+RemoveMonthViewText+'</span></a>');
                HTML.push('        <a href="javascript:void(0)" class="next-btn"><span class="info">'+NextMonthText+'</span></a>');
                HTML.push('        <a href="javascript:void(0)" class="previous-btn"><span class="info">'+PreviousMonthText+'</span></a>');
                HTML.push('        <div class="month-year"></div>');
                HTML.push('        <div class="week">');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('        </div>');
                HTML.push('    </div>');
                HTML.push('    <div class="DOPBSPCalendar-calendar"></div>');
                HTML.push('</div>');
                
                Container.html(HTML.join(''));
                $('.DOPBSPCalendar-tooltip').remove();
                $('body').append('<div class="DOPBSPCalendar-tooltip" id="DOPBSPCalendar-tooltip'+ID+'"></div>');

                no = DOT.methods.calendar_days.settings[ID]['first']-1;

                $('.DOPBSPCalendar-navigation .week .day', Container).each(function(){
                    no++;

                    if (no === 7){
                        no = 0;
                    }
                    $(this).html(DayNames[no]);
                });

                methods_calendar.initSettings();
                
                // Default Availability
                methods_form.display('days', true);
            },
            initSettings:function(){
            /*
             * Initialize calendar settings.
             */    
                methods.externalCheck();
                methods_tooltip.init();
                methods_calendar.initContainer();
                methods_calendar.initNavigation();
                methods_calendar.init(StartYear,
                                      StartMonth);
            },
            initContainer:function(){
            /*
             * Initialize calendar container. 
             */
                var wasHidden = methods.doMetaboxHideBuster();

                $('.DOPBSPCalendar-container', Container).width(Container.width());
                methods.undoMetaboxHideBuster(wasHidden);
            },
            initNavigation:function(){
            /*
             * Initialize calendar navigation.
             */
                var wasHidden = methods.doMetaboxHideBuster();

                $('.DOPBSPCalendar-navigation .week .day', Container).width(parseInt(($('.DOPBSPCalendar-navigation .week', Container).width()-parseInt($('.DOPBSPCalendar-navigation .week', Container).css('padding-left'))+parseInt($('.DOPBSPCalendar-navigation .week', Container).css('padding-right')))/7));
                methods.undoMetaboxHideBuster(wasHidden);
                methods_calendar.events();
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
                
                CurrYear = new Date(year, month, 0).getFullYear();
                CurrMonth = parseInt(month, 10);    

                $('.DOPBSPCalendar-navigation .month-year', Container).html(MonthNames[(CurrMonth%12 !== 0 ? CurrMonth%12:12)-1]+' '+CurrYear);                        
                $('.DOPBSPCalendar-calendar', Container).html('');                        

                for (i=1; i<=noMonths; i++){
                    methods_month.display(CurrYear,
                                          month = month%12 !== 0 ? month%12:12,
                                          i);
                    month++;

                    if (month % 12 === 1){
                        CurrYear++;
                        month = 1;
                    }                            
                }
            },
            events:function(){
            /*
             * Initialize calendar events.
             */    
                /*
                 * Previous button event.
                 */
                $('.DOPBSPCalendar-navigation .previous-btn', Container).unbind('click');
                $('.DOPBSPCalendar-navigation .previous-btn', Container).bind('click', function(){
                    methods_calendar.init(StartYear,
                                          CurrMonth-1);

                    if (CurrMonth === StartMonth){
                        $('.DOPBSPCalendar-navigation .previous-btn', Container).css('display', 'none');
                    }
                });

                /*
                 * Next button event.
                 */
                $('.DOPBSPCalendar-navigation .next-btn', Container).unbind('click');
                $('.DOPBSPCalendar-navigation .next-btn', Container).bind('click', function(){
                    methods_calendar.init(StartYear,
                                          CurrMonth+1);
                    $('.DOPBSPCalendar-navigation .previous-btn', Container).css('display', 'block');
                });

                /*
                 * Add button event.
                 */
                $('.DOPBSPCalendar-navigation .add-btn', Container).unbind('click');
                $('.DOPBSPCalendar-navigation .add-btn', Container).bind('click', function(){
                    methods_form.clear();
                    noMonths++;
                    methods_calendar.init(StartYear,
                                          CurrMonth);
                    $('.DOPBSPCalendar-navigation .remove-btn', Container).css('display', 'block');
                    
                    // Default Availability
                    methods_form.display('days', true);
                });

                /*
                 * Remove button event.
                 */
                $('.DOPBSPCalendar-navigation .remove-btn', Container).unbind('click');
                $('.DOPBSPCalendar-navigation .remove-btn', Container).bind('click', function(){
                    methods_form.clear();
                    noMonths--;
                    methods_calendar.init(StartYear, 
                                          CurrMonth);
                    
                    // Default Availability
                    methods_form.display('days', true);

                    if(noMonths === 1){
                        $('.DOPBSPCalendar-navigation .remove-btn', Container).css('display', 'none');
                    }
                });
            }
        },
                
// Months
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
                var i,
                d, 
                cyear, 
                cmonth, 
                cday, 
                start, 
                totalDays = 0,
                noDays = new Date(year, month, 0).getDate(),
                noDaysPreviousMonth = new Date(year, month-1, 0).getDate(),
                firstDay = new Date(year, month-1, 2-DOT.methods.calendar_days.settings[ID]['first']).getDay(),
                lastDay = new Date(year, month-1, noDays-DOT.methods.calendar_days.settings[ID]['first']+1).getDay(),
                monthHTML = new Array(), 
                day = methods_day.default();

                dayNo = 0;

                if (position > 1){
                    monthHTML.push('<div class="DOPBSPCalendar-month-year">'+MonthNames[(month%12 !== 0 ? month%12:12)-1]+' '+year+'</div>');
                }
                monthHTML.push('<div class="DOPBSPCalendar-month">');

                /*
                 * Display previous month days.
                 */
                if (firstDay === 0){
                    start = 7;
                }
                else{
                    start = firstDay;
                }
                
                for (i=start-1; i>=1; i--){
                    totalDays++;

                    d = new Date(year, month-2, noDaysPreviousMonth-i+1);
                    cyear = d.getFullYear();
                    cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                    cday = DOPPrototypes.getLeadingZero(d.getDate());
                    day = DOT.methods.calendar_day.get(ID,
						       cyear+'-'+cmonth+'-'+cday);

                    if (StartYear === year 
                            && StartMonth === month){
                        monthHTML.push(methods_day.display('past-day', 
                                                           ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                           d.getDate(), 
                                                           '',
                                                           '',
                                                           '',
                                                           '', 
                                                           '', 
                                                           '', 
                                                           'none'));            
                    }
                    else{
                        monthHTML.push(methods_day.display('last-month'+(position>1 ?  ' mask':''), 
                                                           position>1 ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_last':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                           d.getDate(), 
                                                           day['available'], 
                                                           day['bind'], 
                                                           day['info'], 
                                                           day['notes'], 
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
					
                        
                        if (StartYear === year 
                                && StartMonth === month 
                                && StartDay > d.getDate()){
                            monthHTML.push(methods_day.display('past-day', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate(), 
                                                               '', 
                                                               '', 
                                                               '', 
                                                               '', 
                                                               '', 
                                                               '', 
                                                               'none'));    
                        }
                        else{
                            monthHTML.push(methods_day.display('curr-month', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate(), 
                                                               day['available'], 
                                                               day['bind'], 
                                                               day['info'], 
                                                               day['notes'], 
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


                        monthHTML.push(methods_day.display('next-month'+(position<noMonths ?  ' hide':''), 
                                                           position<noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                           d.getDate(), 
                                                           day['available'], 
                                                           day['bind'], 
                                                           day['info'], 
                                                           day['notes'], 
                                                           day['price'], 
                                                           day['promo'], 
                                                           day['status']));
                }
                monthHTML.push('</div>');
                monthHTML.push('<div class="DOPBSPCalendar-hours" id="'+ID+'_'+year+'-'+DOPPrototypes.getLeadingZero(month)+'_hours"></div>');

                $('.DOPBSPCalendar-calendar', Container).append(monthHTML.join(''));

                methods_day.customize();                        
                methods_day.events();
            }
        },             
                   
// Days                    
        methods_day = {
            display:function(type,
                             id,
                             day,
                             available,
                             bind,
                             info,
                             notes,
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
             * @param notes (String): day admin notes
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
                startTime = currDate.getTime();
                
                if(HoursEnabled) {
                    
                    // Count available
                    if (DOT.methods.calendar_schedule.data[ID][id.split('_')[1]] !== undefined){
                        var hours = DOT.methods.calendar_schedule.data[ID][id.split('_')[1]]['hours'];
                        available = 0;
                        var i = 0;

                        for(var key in hours){
                            
                            if (!HoursIntervalAutobreakEnabled) {
                                if ((hours[key]['status'] === 'available' || hours[key]['status'] === 'special') && (hours[key]['bind'] === 0 || hours[key]['bind'] === 1)) {
                                    available += hours[key]['available'];
                                }
                                if (id.split('_')[1] === today) {
                                    keyTime = new Date(currDate.getFullYear(), currDate.getMonth(), currDate.getDate(), parseInt(key.split(':')[0],10), parseInt(key.split(':')[1], 10));
                                    
                                    if (startTime > keyTime.getTime()) {
                                        available -= hours[key]['available'];
                                    }
                                }
                            }
                            
                            else if (HoursIntervalAutobreakEnabled && i%2 === 0) {

                                if (hours[key]['status'] === 'available' || hours[key]['status'] === 'special') {
                                    available += hours[key]['available'];
                                }
                                if (id.split('_')[1] === today) {
                                    keyTime = new Date(currDate.getFullYear(), currDate.getMonth(), currDate.getDate(), parseInt(key.split(':')[0],10), parseInt(key.split(':')[1], 10));
                                    
                                    if (startTime > keyTime.getTime()) {
                                        available -= hours[key]['available'];
                                    }
                                }
                            }
                            i++;
                        } 
                    } else {
                    
                        // Count available
                        if (DOT.methods.calendar_schedule.default[ID] !== undefined){
                            var hours = DOT.methods.calendar_schedule.default[ID]['hours'];
                            available = 0;
                            var i = 0;

                            for(var key in hours){
                                
                                if (!HoursIntervalAutobreakEnabled){
                                    if (hours[key]['status'] === 'available') {
                                        available += hours[key]['available'];
                                    }
                                    if (id.split('_')[1] === today) {
                                        keyTime = new Date(currDate.getFullYear(), currDate.getMonth(), currDate.getDate(), parseInt(key.split(':')[0],10), parseInt(key.split(':')[1], 10));
                                    
                                        if (startTime > keyTime.getTime()) {
                                            available -= hours[key]['available'];
                                        }
                                    }
                                }

                                else if (HoursIntervalAutobreakEnabled && i%2 === 0) {

                                    if (hours[key]['status'] === 'available') {
                                        available += hours[key]['available'];
                                    }
                                    if (id.split('_')[1] === today) {
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
                
                dayNo++;

                if (price > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = CurrencyPosition === 'before' ? Currency+DOPPrototypes.getWithDecimals(price, 2):DOPPrototypes.getWithDecimals(price, 2)+Currency;
                }

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    contentLine1 = CurrencyPosition === 'before' ? Currency+DOPPrototypes.getWithDecimals(promo, 2):DOPPrototypes.getWithDecimals(promo, 2)+Currency;
                }

                if (type !== 'past-day'){
                    switch (status){
                        case 'available':
                            type += ' available';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    contentLine2 = available+' '+AvailableText;
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+AvailableOneText;
                                }
                                else{
                                    contentLine2 = AvailableOneText;
                                }
                            }
                            break;
                        case 'booked':
                            type += ' booked';

                            if (bind === 0 
                                    || bind === 1){
                                contentLine2 = BookedText;
                            }
                            break;
                        case 'special':
                            type += ' special';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    contentLine2 = available+' '+AvailableText;
                                }
                                else if (available === 1){
                                    contentLine2 = available+' '+AvailableOneText;
                                }
                                else{
                                    contentLine2 = AvailableOneText;
                                }
                            }
                            break;
                        case 'unavailable':
                            type += ' unavailable';

                            if (bind === 0 
                                    || bind === 1){
                                contentLine2 = UnavailableText;  
                            }
                            break;
                    }
                }

                if (dayNo % 7 === 1){
                    type += ' first-column';
                }

                if (dayNo % 7 === 0){
                    type += ' last-column';
                }

                dayHTML.push('<div class="DOPBSPCalendar-day '+type+'" id="'+id+'">');
                dayHTML.push('  <div class="bind-left'+(bind === 2 || bind === 3 ? '  enabled':'')+'">');
                dayHTML.push('      <div class="header">&nbsp;</div>');
                dayHTML.push('      <div class="content">&nbsp;</div>');
                dayHTML.push('  </div>');                        
                dayHTML.push('  <div class="bind-content group'+bind+'">');
                dayHTML.push('      <div class="header">');
                dayHTML.push('          <div class="day">'+day+'</div>');

                if (HoursEnabled 
                        && type.indexOf('past-day') === -1 
                        && (bind === 0 
                                || bind === 3)){
                    dayHTML.push('          <div class="hours" id="'+id+'_hours"></div>');
                }

                if (notes !== '' 
                        && type.indexOf('past-day') === -1 
                        && (bind === 0 
                                || bind === 3)){
                    dayHTML.push('          <div class="notes" id="'+id+'_notes"></div>');
                }   

                if (info !== '' 
                        && type.indexOf('past-day') === -1 
                        && (bind === 0 
                                || bind === 3)){
                    dayHTML.push('          <div class="info" id="'+id+'_info"></div>');
                }
                dayHTML.push('      </div>');
                dayHTML.push('      <div class="content">');
                dayHTML.push('          <div class="price">'+contentLine1+'</div>');

                if (promo > 0 
                        && (bind === 0 
                                || bind === 1)){
                    dayHTML.push('          <div class="old-price">'+(CurrencyPosition === 'before' ? Currency+DOPPrototypes.getWithDecimals(price):DOPPrototypes.getWithDecimals(price)+Currency)+'</div>');
                }
                dayHTML.push('          <br class="DOPBSPCalendar-clear" />');
                dayHTML.push('          <div class="available">'+contentLine2+'</div>');
                dayHTML.push('      </div>');  
                dayHTML.push('  </div>');
                dayHTML.push('  <div class="bind-right'+(bind === 1 || bind === 2 ? '  enabled':'')+'">');
                dayHTML.push('      <div class="header">&nbsp;</div>');
                dayHTML.push('      <div class="content">&nbsp;</div>');
                dayHTML.push('  </div>');
                dayHTML.push('</div>');

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
                        "info": DOT.methods.calendar_schedule.default[ID]['info'],
                        "hours_definitions": DOT.methods.calendar_schedule.default[ID]['hours_definitions'],
                        "hours": DOT.methods.calendar_schedule.default[ID]['hours'],
                        "notes": DOT.methods.calendar_schedule.default[ID]['notes'],
                        "price": DOT.methods.calendar_schedule.default[ID]['price'], 
                        "promo": DOT.methods.calendar_schedule.default[ID]['promo'],
                        "status": DOT.methods.calendar_schedule.default[ID]['status']};
            },
            customize:function(){
            /*
             * Set days width and height.
             */
                var maxHeight = 0,
                wasHidden = methods.doMetaboxHideBuster();

                $('.DOPBSPCalendar-day', Container).width(parseInt(($('.DOPBSPCalendar-month', Container).width()-parseInt($('.DOPBSPCalendar-month', Container).css('padding-left')))/7));
                $('.DOPBSPCalendar-day .bind-content', Container).width($('.DOPBSPCalendar-day', Container).width()-2);

                $('.DOPBSPCalendar-day .bind-content .content', Container).each(function(){
                    if (maxHeight < $(this).height()){
                        maxHeight = $(this).height();
                    }
                });

                $('.DOPBSPCalendar-day .content', Container).height(maxHeight);
                methods.undoMetaboxHideBuster(wasHidden);
            },                    
            events:function(){
            /*
             * Initialize days events.
             */
                /*
                 * Hours icon event.
                 */
                $('.DOPBSPCalendar-day .hours', Container).unbind('click');
                $('.DOPBSPCalendar-day .hours', Container).bind('click', function(){
                    dayTimeDisplay = true;
                    methods_hours.display(ID+'_'+$(this).attr('id').split('_')[1]);
                });

                /*
                 * Days events.
                 */
                $('.DOPBSPCalendar-day', Container).unbind('click');
                $('.DOPBSPCalendar-day', Container).bind('click', function(){
                    var day = $(this);

                    setTimeout(function(){
                        if (!dayTimeDisplay){
                            if (!day.hasClass('mask')){
                                if (!day.hasClass('past-day')){
                                    if (!dayFirstSelected){
                                        dayFirstSelected = true;
                                        dayStartSelection = day.attr('id');
                                        dayStartSelectionCurrMonth = CurrMonth;
                                        methods_form.clear();

                                        if (HoursEnabled){
                                            methods_hours.clear();                                                    
                                        }
                                    }
                                    else{
                                        dayFirstSelected = false;
                                        dayEndSelection = day.attr('id');
                                        methods_form.display('days');
                                    }
                                    methods_day.displaySelection(day.attr('id'));
                                }
                            }
                        }
                        else{
                            dayTimeDisplay = false;
                        }
                    }, 10);
                });

                $('.DOPBSPCalendar-day', Container).hover(function(){
                    var day = $(this);

                    if (dayFirstSelected){
                        methods_day.displaySelection(day.attr('id'));
                    }

                    if (HoursEnabled 
                            && !day.hasClass('selected')){
                        methods_tooltip.display($(this).attr('id').split('_')[1], 
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
                $('.DOPBSPCalendar-day .info', Container).hover(function(){
                    methods_tooltip.display($(this).attr('id').split('_')[1], 
                                            '',
                                            'info');
                }, function(){
                    methods_tooltip.clear();
                });

                /*
                 * Notes icon events.
                 */
                $('.DOPBSPCalendar-day .notes', Container).hover(function(){
                    methods_tooltip.display($(this).attr('id').split('_')[1], 
                                            '', 
                                            'notes');
                }, function(){
                    methods_tooltip.clear();
                });
            },
            displaySelection:function(id){
            /*
             * Display selected days "selection".
             * 
             * @param id (String): current day ID (ID_YYYY-MM-DD) 
             */    
                var day, 
                maxHeight = 0;

                $('.DOPBSPCalendar-day', Container).removeClass('selected');
                methods_day.customize();

                if (id < dayStartSelection){
                    $('.DOPBSPCalendar-day', Container).each(function(){
                       day = $(this);

                       if (day.attr('id') >= id 
                               && day.attr('id') <= dayStartSelection 
                               && !day.hasClass('past-day') 
                               && !day.hasClass('hide') 
                               && !day.hasClass('mask')){
                           day.addClass('selected');
                       }
                    });
                }
                else{
                    $('.DOPBSPCalendar-day', Container).each(function(){
                       day = $(this);   

                       if (day.attr('id') >= dayStartSelection 
                               && day.attr('id') <= id 
                               && !day.hasClass('past-day') 
                               && !day.hasClass('hide') 
                               && !day.hasClass('mask')){
                           day.addClass('selected');
                       }
                    });
                }

                $('.DOPBSPCalendar-day.selected .header', Container).removeAttr('style');
                $('.DOPBSPCalendar-day.selected .content', Container).removeAttr('style');

                $('.DOPBSPCalendar-day .content', Container).each(function(){
                    if (maxHeight < $(this).height()){
                        maxHeight = $(this).height();
                    }
                });

                $('.DOPBSPCalendar-day .content', Container).height(maxHeight);
            }
        },
     
// Hours
        methods_hours = {
            display:function(id){
            /*
             * Display hours.
             * 
             * @param id (String): day ID (ID_YYYY-MM-DD)
             */    
                var HTML = new Array(), 
                i,
                hoursDef = HoursDefinitions,
                hoursContainer,
                date = id.split('_')[1],
                year = date.split('-')[0],
                month = date.split('-')[1],
                day = date.split('-')[2],
                hour,
                currTime = new Date(),
                currHour = currTime.getHours(),
                currMin = currTime.getMinutes();

                dayStartSelection = ID+'_'+date;
                dayEndSelection = ID+'_'+date;

                hourDaySelection = id;

                methods_form.clear();
                $('.DOPBSPCalendar-day', Container).removeClass('selected');
                methods_day.customize();
                $('#'+ID+'_'+date).addClass('selected');
                $('.DOPBSPCalendar-day.selected .header', Container).removeAttr('style');
                $('.DOPBSPCalendar-day.selected .content', Container).removeAttr('style');

                if (DOT.methods.calendar_schedule.data[ID][date] !== undefined){
                    hoursDef = DOT.methods.calendar_schedule.data[ID][date]['hours_definitions'];
                } else if(DOT.methods.calendar_schedule.default[ID] !== undefined){
                    hoursDef = DOT.methods.calendar_schedule.default[ID]['hours_definitions'];
                }

                for (i=0; i<hoursDef.length-(HoursIntervalEnabled || !AddLastHourToTotalPrice  ? 1:0); i++){
                    if (DOT.methods.calendar_schedule.data[ID][date] !== undefined 
                            && DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']] !== undefined){
                        hour = DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']];
                    }
                    else{
                        hour = methods_hour.default(hoursDef[i]['value']);
                    }

                    if (hoursDef[i]['value'] < DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin)
                            && StartYear+'-'+DOPPrototypes.getLeadingZero(StartMonth)+'-'+DOPPrototypes.getLeadingZero(StartDay) === year+'-'+month+'-'+day){             
                        
                        if(HoursIntervalAutobreakEnabled) {
                        
                            if(i%2 === 0) {
                                HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                               hoursDef[i]['value'],
                                                               hour['available'], 
                                                               hour['bind'], 
                                                               hour['info'], 
                                                               hour['notes'], 
                                                               hour['price'], 
                                                               hour['promo'], 
                                                               'past-hour', 
                                                               hoursDef));
                            }
                        } else {
                            HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                           hoursDef[i]['value'],
                                                           hour['available'], 
                                                           hour['bind'], 
                                                           hour['info'], 
                                                           hour['notes'], 
                                                           hour['price'], 
                                                           hour['promo'], 
                                                           'past-hour', 
                                                           hoursDef));
                        }
                    }
                    else{
                        if(HoursIntervalAutobreakEnabled) {
                        
                            if(i%2 === 0) {
                                HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                               hoursDef[i]['value'],
                                                               hour['available'], 
                                                               hour['bind'], 
                                                               hour['info'], 
                                                               hour['notes'], 
                                                               hour['price'], 
                                                               hour['promo'], 
                                                               hour['status'], 
                                                               hoursDef));
                            }
                        } else {
                            HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'],
                                                           hoursDef[i]['value'],
                                                           hour['available'], 
                                                           hour['bind'], 
                                                           hour['info'], 
                                                           hour['notes'], 
                                                           hour['price'], 
                                                           hour['promo'], 
                                                           hour['status'], 
                                                           hoursDef));
                        }
                    }
                }

                if ($('#'+id).hasClass('next-month')){
                    $('.DOPBSPCalendar-hours', Container).each(function(){
                        hoursContainer = $(this);
                    });
                    hoursContainer.css('display', 'block').html(HTML.join(''));
                }
                else if ($('#'+id).hasClass('last-month')){
                    $($('.DOPBSPCalendar-hours', Container).get().reverse()).each(function(){
                        hoursContainer = $(this);
                    });
                    hoursContainer.css('display', 'block').html(HTML.join(''));
                }
                else{
                    $('#'+ID+'_'+year+'-'+month+'_hours').css('display', 'block').html(HTML.join(''));
                }

                methods_hour.events();
            },
            displayInfo:function(id){
            /*
             * Display hours info.
             * 
             * @param id (String): day ID (ID_YYYY-MM-DD)
             */    
                var HTML = new Array(), 
                i,
                hoursDef = HoursDefinitions,
                date = id.split('_')[1],
                year = date.split('-')[0],
                month = date.split('-')[1],
                day = date.split('-')[2],
                hour,
                currTime = new Date(),
                currHour = currTime.getHours(),
                currMin = currTime.getMinutes();

                if (DOT.methods.calendar_schedule.data[ID][date] !== undefined){
                    hoursDef = DOT.methods.calendar_schedule.data[ID][date]['hours_definitions'];
                }   

                for (i=0; i<hoursDef.length-(HoursIntervalEnabled || !AddLastHourToTotalPrice  ? 1:0); i++){
                    if (DOT.methods.calendar_schedule.data[ID][date] !== undefined 
                            && DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']] !== undefined){
                        hour = DOT.methods.calendar_schedule.data[ID][date]['hours'][hoursDef[i]['value']];
                    }
                    else{
                        hour = methods_hour.default(hoursDef[i]['value']);
                    }

                    if (hoursDef[i]['value'] < DOPPrototypes.getLeadingZero(currHour)+':'+DOPPrototypes.getLeadingZero(currMin)
                            && StartYear+'-'+DOPPrototypes.getLeadingZero(StartMonth)+'-'+DOPPrototypes.getLeadingZero(StartDay) === year+'-'+month+'-'+day){           
                        
                        if(HoursIntervalAutobreakEnabled) {
                        
                            if(i%2 === 0) {
                                HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'].split(':')[0]+'-'+hoursDef[i]['value'].split(':')[1],
                                                               hoursDef[i]['value'],
                                                               hour['available'], 
                                                               hour['bind'], 
                                                               '', 
                                                               '', 
                                                               hour['price'], 
                                                               hour['promo'], 
                                                               'past-hour', 
                                                               hoursDef));
                            }
                        } else {
                            HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'].split(':')[0]+'-'+hoursDef[i]['value'].split(':')[1],
                                                           hoursDef[i]['value'],
                                                           hour['available'], 
                                                           hour['bind'], 
                                                           '', 
                                                           '', 
                                                           hour['price'], 
                                                           hour['promo'], 
                                                           'past-hour', 
                                                           hoursDef));
                        }
                    }
                    else{
                        if(HoursIntervalAutobreakEnabled) {
                        
                            if(i%2 === 0) {
                                HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'].split(':')[0]+'-'+hoursDef[i]['value'].split(':')[1],
                                                               hoursDef[i]['value'],
                                                               hour['available'], 
                                                               hour['bind'], 
                                                               '', 
                                                               '', 
                                                               hour['price'], 
                                                               hour['promo'], 
                                                               hour['status'], 
                                                               hoursDef));
                            }
                        } else {
                            HTML.push(methods_hour.display(ID+'_'+hoursDef[i]['value'].split(':')[0]+'-'+hoursDef[i]['value'].split(':')[1],
                                                           hoursDef[i]['value'],
                                                           hour['available'], 
                                                           hour['bind'], 
                                                           '', 
                                                           '', 
                                                           hour['price'], 
                                                           hour['promo'], 
                                                           hour['status'], 
                                                           hoursDef));
                        }
                    }
                }   

                return HTML.join('');
            },
            clear:function(){
            /*
             * Clear hours display.
             */
                $('.DOPBSPCalendar-hours', Container).css('display', 'none')
                                                     .html('');
            }
        },
        
        methods_hour = {
            display:function(id,
                             hour,
                             available,
                             bind,
                             info,
                             notes,
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
             * @param notes (String): hour admin notes
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
                        priceContent = CurrencyPosition === 'before' ? Currency+DOPPrototypes.getWithDecimals(price, 2):DOPPrototypes.getWithDecimals(price, 2)+Currency;
                    }

                    if (promo > 0 
                            && (bind === 0 
                                    || bind === 1)){
                        priceContent = CurrencyPosition === 'before' ? Currency+DOPPrototypes.getWithDecimals(promo, 2):DOPPrototypes.getWithDecimals(promo, 2)+Currency;
                    }

                    switch (status){
                        case 'available':
                            type += ' available';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    availableContent = available+' '+AvailableText;
                                }
                                else if (available === 1){
                                    availableContent = available+' '+AvailableOneText;
                                }
                                else{
                                    availableContent = AvailableOneText;
                                }
                            }
                            break;
                        case 'booked':
                            type += ' booked';

                            if (bind === 0 
                                    || bind === 1){
                                availableContent = BookedText;
                            }
                            break;
                        case 'special':
                            type += ' special';

                            if (bind === 0 
                                    || bind === 1){
                                if (available > 1){
                                    availableContent = available+' '+AvailableText;
                                }
                                else if (available === 1){
                                    availableContent = available+' '+AvailableOneText;
                                }
                                else{
                                    availableContent = AvailableOneText;
                                }
                            }
                            break;
                        case 'unavailable':
                            type += ' unavailable';

                            if (bind === 0 
                                    || bind === 1){
                                availableContent = UnavailableText;  
                            }
                            break;
                    }
                }
                else{
                    type = ' '+status;
                }

                hourHTML.push('<div class="DOPBSPCalendar-hour'+type+'" id="'+id+'">');
                hourHTML.push(' <div class="bind-top'+(bind === 2 || bind === 3 ? '  enabled':'')+'"><div class="hour">&nbsp;</div></div>');                        
                hourHTML.push(' <div class="bind-content group'+bind+'">');
                hourHTML.push('     <div class="hour">'+(HoursAMPM ? DOPPrototypes.getAMPM(hour):hour)+(HoursIntervalEnabled ? ' - '+(HoursAMPM ? DOPPrototypes.getAMPM(methods_hour.getNext(hour, hoursDef)):methods_hour.getNext(hour, hoursDef)):'')+'</div>');

                if (price > 0 
                        && type !== 'past-hour' 
                        && (bind === 0 
                                || bind === 1)){
                    hourHTML.push('     <div class="'+(promo > 0 ? 'price-promo':'price')+'">'+priceContent+'</div>');      
                }

                if (promo > 0 
                        && type !== 'past-hour' 
                        && (bind === 0 
                                || bind === 1)){                                      
                    hourHTML.push('     <div class="old-price">'+(CurrencyPosition === 'before' ? Currency+DOPPrototypes.getWithDecimals(price):DOPPrototypes.getWithDecimals(price)+Currency)+'</div>');
                }                        
                hourHTML.push('     <div class="available">'+availableContent+'</div>');

                if (notes !== '' 
                        && type !== 'past-hour' 
                        && (bind === 0 
                                || bind === 1)){
                    hourHTML.push('     <div class="notes" id="'+id+'_notes"></div>');
                }

                if (info !== '' 
                        && type !== 'past-hour' 
                        && (bind === 0 
                                || bind === 1)){
                    hourHTML.push('     <div class="info" id="'+id+'_info"></div>');
                }
                hourHTML.push(' </div>');
                hourHTML.push(' <div class="bind-bottom'+(bind === 1 || bind === 2 ? '  enabled':'')+'"><div class="hour">&nbsp;</div></div>');
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
                        "notes": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['notes']:"",
                        "price": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['price']:0, 
                        "promo": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['promo']:0,
                        "status": DOT.methods.calendar_schedule.default[ID]['hours'] !== undefined && DOT.methods.calendar_schedule.default[ID]['hours'][hour] !== undefined ? DOT.methods.calendar_schedule.default[ID]['hours'][hour]['status']:"none"};
            },
            events:function(){
            /*
             * Initialize hour events.
             */    
                /*
                 * Hours events.
                 */
                $('.DOPBSPCalendar-hour', Container).unbind('click');
                $('.DOPBSPCalendar-hour', Container).bind('click', function(){
                    var hour = $(this);

                    setTimeout(function(){
                        if (!hour.hasClass('past-hour')){
                            if (!hourFirstSelected){
                                hourFirstSelected = true;
                                hourStartSelection = hour.attr('id');
                                methods_form.clear();
                            }
                            else{
                                hourFirstSelected = false;
                                hourEndSelection = hour.attr('id');
                                methods_form.display('hours');
                            }
                            methods_hour.displaySelection(hour.attr('id'));
                        }
                    }, 10);
                });

                $('.DOPBSPCalendar-hour', Container).hover(function(){
                    var hour = $(this);

                    if (hourFirstSelected){
                        methods_hour.displaySelection(hour.attr('id'));
                    }
                });

                /*
                 * Info icon event.
                 */
                $('.DOPBSPCalendar-hour .info', Container).hover(function(){
                    methods_tooltip.display(hourDaySelection.split('_')[1], 
                                            $(this).attr('id').split('_')[1], 
                                            'info');
                }, function(){
                    methods_tooltip.clear();
                });

                /*
                 * Notes icon event.
                 */
                $('.DOPBSPCalendar-hour .notes', Container).hover(function(){
                    methods_tooltip.display(hourDaySelection.split('_')[1], 
                                            $(this).attr('id').split('_')[1], 
                                            'notes');
                }, function(){
                    methods_tooltip.clear();
                });
            },
            displaySelection:function(id){
            /*
             * Display selected hours "selection".
             * 
             * @param id (String): current hour ID (ID_HH:MM) 
             */    
                var hour;

                $('.DOPBSPCalendar-hour', Container).removeClass('selected');

                if (id < hourStartSelection){
                    $('.DOPBSPCalendar-hour', Container).each(function(){
                       hour = $(this);

                       if (hour.attr('id') >= id 
                               && hour.attr('id') <= hourStartSelection 
                               && !hour.hasClass('past-hour')){
                           hour.addClass('selected');
                       }
                    });
                }
                else{
                    $('.DOPBSPCalendar-hour', Container).each(function(){
                       hour = $(this);   

                       if (hour.attr('id') >= hourStartSelection 
                               && hour.attr('id') <= id 
                               && !hour.hasClass('past-hour')){
                           hour.addClass('selected');
                       }
                    });
                }       

                $('.DOPBSPCalendar-hour.selected .bind-content', Container).removeAttr('style');  
                $('.DOPBSPCalendar-hour.selected .bind-content .hour', Container).removeAttr('style');         
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
            }
        },
      
// Form
        methods_form = {
            display:function(type, defaultAvailability){
            /*
             * Display form.
             * 
             * @param type (String): type of form to be displayed
             *                       "days" display days form
             *                       "hours" display hours form
             * 
             * @param defaultAvailability (String): true for default availability
             *                          false for selected days
             * 
             * @retun form HTML
             */    
                var headerHTML = new Array(),
                HTML = new Array(),
                hours = '', 
                i,
                hoursDef = HoursDefinitions,
                startDate, 
                sYear, 
                sMonth, 
                sMonthText, 
                sDay,
                endDate, 
                eYear, 
                eMonth, 
                eMonthText, 
                eDay,
                startHour, 
                sHour, 
                sMinute,
                endHour, 
                eHour, 
                eMinute;

                if (type === 'days' 
                        && HoursEnabled){
                    for (i=0; i<HoursDefinitions.length; i++){
                        if (i === HoursDefinitions.length-1){
                            hours += HoursDefinitions[i]['value'];
                        }
                        else{
                            hours += HoursDefinitions[i]['value']+'\n';
                        }
                    }
                    hoursDef = HoursDefinitions;
                }

                /*
                 * Start form buttons.
                 */
                headerHTML.push('<div class="DOPBSPCalendar-form-buttons">');
                headerHTML.push('   <input type="button" name="DOPBSP-submit" id="DOPBSP-submit" class="submit-style" title="Submit" value="'+DOPBSPBackEnd.text('CALENDARS_CALENDAR_FORM_SUBMIT')+'" />');
                headerHTML.push('   <input type="hidden" name="DOPBSP-availability-type" id="DOPBSP-availability-type" value="'+((defaultAvailability === undefined || defaultAvailability === false) ? false:true)+'" />');
                headerHTML.push('   <input type="button" name="DOPBSP-reset" id="DOPBSP-reset" class="submit-style" title="Reset" value="'+DOPBSPBackEnd.text('CALENDARS_CALENDAR_FORM_RESET')+'" />');
                
                if((defaultAvailability === undefined || defaultAvailability === false)) {
                    headerHTML.push('   <input type="button" name="DOPBSP-close" id="DOPBSP-close" class="submit-style" title="Close" value="'+DOPBSPBackEnd.text('CALENDARS_CALENDAR_FORM_CANCEL')+'" />');
                }
                headerHTML.push('</div>');
                /*
                 * ***************************************************** End form buttons.
                 */

                HTML.push('<div class="DOPBSPCalendar-form">');

                /*
                 * Start dates/hours.
                 */
                HTML.push(' <div class="dopbsp-inputs-wrapper">');

                if (type === 'days'){
                    
                    if(defaultAvailability === undefined || 
                       defaultAvailability === false) {
                        if (dayStartSelection > dayEndSelection){
                            endDate = dayStartSelection.split('_')[1];
                            startDate = dayEndSelection.split('_')[1];
                        }
                        else{
                            startDate = dayStartSelection.split('_')[1];
                            endDate = dayEndSelection.split('_')[1];
                        }

                        sYear = startDate.split('-')[0];
                        sMonth = startDate.split('-')[1];
                        sMonthText = MonthNames[parseInt(sMonth, 10)-1];
                        sDay = startDate.split('-')[2];

                        eYear = endDate.split('-')[0];
                        eMonth = endDate.split('-')[1];
                        eMonthText = MonthNames[parseInt(eMonth, 10)-1];
                        eDay = endDate.split('-')[2];
                    }
                }
                else{    
                    
                    if(defaultAvailability === undefined || 
                       defaultAvailability === false) {        
                        startDate = hourDaySelection.split('_')[1];
                        sYear = startDate.split('-')[0];
                        sMonth = startDate.split('-')[1];
                        sMonthText = MonthNames[parseInt(sMonth, 10)-1];
                        sDay = startDate.split('-')[2];

                        if (hourStartSelection > hourEndSelection){
                            endHour = hourStartSelection.split('_')[1];
                            startHour = hourEndSelection.split('_')[1];
                        }
                        else{
                            startHour = hourStartSelection.split('_')[1];
                            endHour = hourEndSelection.split('_')[1];
                        }

                        hoursDef = DOT.methods.calendar_schedule.data[ID][startDate] !== undefined ? DOT.methods.calendar_schedule.data[ID][startDate]['hours_definitions']:HoursDefinitions;

                        sHour = startHour.split(':')[0];
                        sMinute = startHour.split(':')[1];

                        eHour = endHour.split(':')[0];
                        eMinute = endHour.split(':')[1];
                    }
                }

                if (type === 'days'){
                    
                    if(defaultAvailability === undefined || 
                       defaultAvailability === false) {
                        HTML.push('     <div class="dopbsp-input-wrapper">');
                        HTML.push('         <label for="DOPBSP-start-date-view">'+DateStartLabel+'</label>');
                        HTML.push('         <input type="text" name="DOPBSP-start-date-view" id="DOPBSP-start-date-view" value="'+(DateType === 1 ? sMonthText+' '+sDay+', '+sYear:sDay+' '+sMonthText+' '+sYear)+'" disabled="disabled" />');
                        HTML.push('     </div>');
                        HTML.push('     <div class="dopbsp-input-wrapper">');
                        HTML.push('         <label for="DOPBSP-end-date-view">'+DateEndLabel+'</label>');
                        HTML.push('         <input type="text" name="DOPBSP-end-date-view" id="DOPBSP-end-date-view" value="'+(DateType === 1 ? eMonthText+' '+eDay+', '+eYear:eDay+' '+eMonthText+' '+eYear)+'" disabled="disabled" />');
                        HTML.push('     </div>');
                    }
                }
                else{
                    
                    if(defaultAvailability === undefined || 
                       defaultAvailability === false) {
                        HTML.push('     <div class="dopbsp-input-wrapper">');
                        HTML.push('         <label for="DOPBSP-start-date-view">'+DateStartLabel+'</label>');
                        HTML.push('         <input type="text" name="DOPBSP-start-date-view" id="DOPBSP-start-date-view" value="'+(DateType === 1 ? sMonthText+' '+sDay+', '+sYear:sDay+' '+sMonthText+' '+sYear)+'" disabled="disabled" />');
                        HTML.push('     </div>');
                        HTML.push('     <div class="dopbsp-input-wrapper">');
                        HTML.push('         <label for="DOPBSP-start-hour">'+HourStartLabel+'</label>');
                        HTML.push('         <input type="text" name="DOPBSP-start-hour" id="DOPBSP-start-hour" value="'+(HoursAMPM ? DOPPrototypes.getAMPM(sHour+':'+sMinute):(sHour+':'+sMinute))+'" disabled="disabled" />');
                        HTML.push('     </div>');
                        HTML.push('     <div class="dopbsp-input-wrapper">');
                        HTML.push('         <label for="DOPBSP-end-hour">'+HourEndLabel+'</label>');
                        HTML.push('         <input type="text" name="DOPBSP-end-hour" id="DOPBSP-end-hour" value="'+(HoursAMPM ? DOPPrototypes.getAMPM(HoursIntervalEnabled ? methods_hour.getNext(eHour+':'+eMinute, hoursDef):eHour+':'+eMinute):(HoursIntervalEnabled ? methods_hour.getNext(eHour+':'+eMinute, hoursDef):eHour+':'+eMinute))+'" disabled="disabled" />');
                        HTML.push('     </div>');
                    }
                }
                HTML.push(' </div>');
                /*
                 * ***************************************************** End dates/hours.
                 */

                /*
                 * Start form fields.
                 */
                HTML.push(' <div class="dopbsp-inputs-header'+(type === "days" && HoursEnabled ? '':' dopbsp-last')+' dopbsp-hide">');
                HTML.push('     <h3>'+(type === "days" ? SetDaysAvailabilityLabel:SetHoursDefinitionsLabel)+'</h3>');
                HTML.push('     <a href="javascript:DOPBSPBackEnd.toggleInputs(\'calendar-set-days-availability\')" id="DOPBSP-inputs-button-calendar-set-days-availability" class="dopbsp-button"></a>');
                HTML.push(' </div>');
                HTML.push(' <div id="DOPBSP-inputs-calendar-set-days-availability" class="dopbsp-inputs-wrapper'+(type === "days" && HoursEnabled ? '':' dopbsp-last')+' displayed">');
                
                if ((type === 'days' && !HoursEnabled) 
                        || (type === 'days' 
                                && HoursEnabled 
                                && !DetailsFromHours) 
                        || type === 'hours'){
                    HTML.push('     <div class="dopbsp-input-wrapper">');  
                    HTML.push('         <label for="DOPBSP-status">'+StatusLabel+'</label>');
                    HTML.push('         <select name="DOPBSP-status" id="DOPBSP-status">');
                    HTML.push('             <option value="available" '+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':(DOT.methods.calendar_schedule.default[ID]['status'] === 'available' ? 'selected="selected"':'')):'')+'>'+StatusAvailableText+'</option>');
                    HTML.push('             <option value="booked" '+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':(DOT.methods.calendar_schedule.default[ID]['status'] === 'booked' ? 'selected="selected"':'')):'')+'>'+StatusBookedText+'</option>');
                    HTML.push('             <option value="special" '+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':(DOT.methods.calendar_schedule.default[ID]['status'] === 'special' ? 'selected="selected"':'')):'')+'>'+StatusSpecialText+'</option>');
                    HTML.push('             <option value="unavailable" '+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':(DOT.methods.calendar_schedule.default[ID]['status'] === 'unavailable' ? 'selected="selected"':'')):'')+'>'+StatusUnavailableText+'</option>');
                    HTML.push('         </select>');
                    HTML.push('     </div>');     
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <label for="DOPBSP-price">'+PriceLabel+' '+Currency+'</label>');
                    HTML.push('         <input type="text" name="DOPBSP-price" id="DOPBSP-price" value="'+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':DOT.methods.calendar_schedule.default[ID]['price']):'')+'" />');
                    HTML.push('     </div>');                        
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <label for="DOPBSP-promo">'+PromoLabel+' '+Currency+'</label>');
                    HTML.push('         <input type="text" name="DOPBSP-promo" id="DOPBSP-promo" value="'+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':DOT.methods.calendar_schedule.default[ID]['promo'] > 0 ? DOT.methods.calendar_schedule.default[ID]['promo']:''):'')+'" '+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':DOT.methods.calendar_schedule.default[ID]['promo'] > 0 ? '':'disabled="disabled"'):'disabled="disabled"')+' />');
                    HTML.push('     </div>');
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <label for="DOPBSP-available">'+AvailableLabel+'</label>');
                    HTML.push('         <input type="text" name="DOPBSP-available" id="DOPBSP-available" value="'+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? 1:DOT.methods.calendar_schedule.default[ID]['available']):1)+'" />');
                    HTML.push('     </div>');
                }
                HTML.push('     <div class="dopbsp-input-wrapper">');
                HTML.push('         <label class="dopbsp-for-textarea" for="DOPBSP-info">'+InfoLabel+'</label>');
                HTML.push('         <textarea name="DOPBSP-info" id="DOPBSP-info" rows="5" cols="">'+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':DOT.methods.calendar_schedule.default[ID]['info']):'')+'</textarea>');  
                HTML.push('     </div>');
                HTML.push('     <div class="dopbsp-input-wrapper">');
                HTML.push('         <label class="dopbsp-for-textarea" for="DOPBSP-notes">'+NotesLabel+'</label>');
                HTML.push('         <textarea name="DOPBSP-notes" id="DOPBSP-notes" rows="5" cols="">'+(defaultAvailability && DOT.methods.calendar_schedule.default[ID] !== undefined ? (HoursEnabled ? '':DOT.methods.calendar_schedule.default[ID]['notes']):'')+'</textarea>'); 
                HTML.push('     </div>');  

                if ((startDate !== endDate 
                                && type === 'days' 
                                && !HoursEnabled) 
                        || (startHour !== endHour 
                                && type === 'hours')){
                    HTML.push('     <div class="dopbsp-input-wrapper dopbsp-last">');
                    HTML.push('         <input type="checkbox" name="DOPBSP-group" id="DOPBSP-group" />');
                    HTML.push('         <label class="dopbsp-for-checkbox" for="DOPBSP-group">'+(type === 'days' ? GroupDaysLabel:GroupHoursLabel)+'</label>');
                    HTML.push('     </div>');   
                }                 
                HTML.push(' </div>');
                /*
                 * ***************************************************** End form fields.
                 */

                if (type === "days" 
                        && HoursEnabled){
                    /*
                     * Start hours definitions.
                     */
                    HTML.push(' <div class="dopbsp-inputs-header dopbsp-hide">');
                    HTML.push('     <h3>'+SetHoursDefinitionsLabel+'</h3>');
                    HTML.push('     <a href="javascript:DOPBSPBackEnd.toggleInputs(\'calendar-set-hours-definitions\')" id="DOPBSP-inputs-button-calendar-set-hours-definitions" class="dopbsp-button"></a>');
                    HTML.push(' </div>');
                    HTML.push(' <div id="DOPBSP-inputs-calendar-set-hours-definitions" class="dopbsp-inputs-wrapper">');
                    HTML.push('     <div class="dopbsp-input-wrapper '+((defaultAvailability === undefined || defaultAvailability === false) ? '':'dopbsp-hidden')+'">');
                    HTML.push('         <input type="checkbox" name="DOPBSP-change-hours-definitions" id="DOPBSP-change-hours-definitions" '+((defaultAvailability === undefined || defaultAvailability === false) ? '':'checked="checked"')+' />');
                    HTML.push('         <label class="dopbsp-for-checkbox" for="DOPBSP-change-hours-definitions">'+HoursDefinitionsChangeLabel+'</label>');
                    HTML.push('     </div>'); 
                    HTML.push('     <div class="dopbsp-input-wrapper dopbsp-last">');
                    HTML.push('         <label class="dopbsp-for-textarea" for="DOPBSP-hours-definitions">'+HoursDefinitionsLabel+'</label>');
                    HTML.push('         <textarea name="DOPBSP-hours-definitions" id="DOPBSP-hours-definitions" rows="5" cols="">'+hours+'</textarea>');
                    HTML.push('     </div>');
                    HTML.push(' </div>');
                    /*
                     * ************************************************* End hours definitions.
                     */

                    /*
                     * Star hours default values.
                     */
                    HTML.push(' <div class="dopbsp-inputs-header dopbsp-hide dopbsp-last">');
                    HTML.push('     <h3>'+SetDaysAvailabilityLabel+'</h3>');
                    HTML.push('     <a href="javascript:DOPBSPBackEnd.toggleInputs(\'calendar-set-hours-availability\')" id="DOPBSP-inputs-button-calendar-set-hours-availability" class="dopbsp-button"></a>');
                    HTML.push(' </div>');
                    HTML.push(' <div id="DOPBSP-inputs-calendar-set-hours-availability" class="dopbsp-inputs-wrapper dopbsp-last">');
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <input type="checkbox" name="DOPBSP-set-hours-default-data" id="DOPBSP-set-hours-default-data" />');
                    HTML.push('         <label class="dopbsp-for-checkbox" for="DOPBSP-set-hours-default-data">'+HoursSetDefaultDataLabel+'</label>');
                    HTML.push('     </div>'); 
                    HTML.push('     <div class="dopbsp-input-wrapper">');  
                    HTML.push('         <label for="DOPBSP-hours-status">'+StatusLabel+'</label>');
                    HTML.push('         <select name="DOPBSP-hours-status" id="DOPBSP-hours-status">');
                    HTML.push('             <option value="available">'+StatusAvailableText+'</option>');
                    HTML.push('             <option value="booked">'+StatusBookedText+'</option>');
                    HTML.push('             <option value="special">'+StatusSpecialText+'</option>');
                    HTML.push('             <option value="unavailable">'+StatusUnavailableText+'</option>');
                    HTML.push('         </select>');
                    HTML.push('     </div>');     
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <label for="DOPBSP-hours-price">'+PriceLabel+' '+Currency+'</label>');
                    HTML.push('         <input type="text" name="DOPBSP-hours-price" id="DOPBSP-hours-price" value="" />');
                    HTML.push('     </div>');                        
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <label for="DOPBSP-hours-promo">'+PromoLabel+' '+Currency+'</label>');
                    HTML.push('         <input type="text" name="DOPBSP-hours-promo" id="DOPBSP-hours-promo" value="" disabled="disabled" />');
                    HTML.push('     </div>');
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <label for="DOPBSP-hours-available">'+AvailableLabel+'</label>');
                    HTML.push('         <input type="text" name="DOPBSP-hours-available" id="DOPBSP-hours-available" value="1" />');
                    HTML.push('     </div>');
                    HTML.push('     <div class="dopbsp-input-wrapper">');
                    HTML.push('         <label class="dopbsp-for-textarea" for="DOPBSP-hours-info">'+InfoLabel+'</label>');
                    HTML.push('         <textarea name="DOPBSP-hours-info" id="DOPBSP-hours-info" rows="5" cols=""></textarea>');  
                    HTML.push('     </div>');
                    HTML.push('     <div class="dopbsp-input-wrapper dopbsp-last">');
                    HTML.push('         <label class="dopbsp-for-textarea" for="DOPBSP-hours-notes">'+NotesLabel+'</label>');
                    HTML.push('         <textarea name="DOPBSP-hours-notes" id="DOPBSP-hours-notes" rows="5" cols=""></textarea>'); 
                    HTML.push('     </div>');  
                    HTML.push(' </div>');
                    /*
                     * ************************************************* End hours default values.
                     */
                }

                HTML.push('</div>');

                $('#DOPBSP-column3 .dopbsp-column-header').html(headerHTML.join(''));
                $('#DOPBSP-column3 .dopbsp-column-content').html(HTML.join(''));

                methods_form.events(startDate, 
                                    endDate, 
                                    type);
                DOPPrototypes.scrollToY(0);
            },
            events:function(startDate,
                            endDate,
                            type){
            /*
             * Initialize form events.
             * 
             * @param startDate (String): selection start day (YYYY-MM-DD)
             * @param endDate (String): selection end day (YYYY-MM-DD)
             * @param type (String): type of form that was displayed
             *                       "days" display days form
             *                       "hours" display hours form
             */
                if ((type === 'days' 
                                && !HoursEnabled) 
                        || (type === 'days' 
                                && HoursEnabled 
                                && !DetailsFromHours) 
                        || type === 'hours'){
                    /*
                     * Status event.
                     */
                    $('#DOPBSP-status').DOPSelect();
                    $('#DOPBSP-status').unbind('change');
                    $('#DOPBSP-status').bind('change', function(){
                        switch ($(this).val()){
                            case 'available':
                                $('#DOPBSP-price').removeAttr('disabled');
                                $('#DOPBSP-promo').attr('disabled', 'disabled');
                                $('#DOPBSP-available').removeAttr('disabled');
                                $('#DOPBSP-available').val('1');

                                if (startDate !== endDate 
                                        && type !== 'days' 
                                        && !HoursEnabled){
                                    $('#DOPBSP-group').removeAttr('disabled');
                                }
                                break;
                            case 'booked':
                                $('#DOPBSP-price').attr('disabled', 'disabled');
                                $('#DOPBSP-promo').attr('disabled', 'disabled');
                                $('#DOPBSP-price').val('');
                                $('#DOPBSP-promo').val('');
                                $('#DOPBSP-available').attr('disabled', 'disabled');
                                $('#DOPBSP-available').val('');

                                if (startDate !== endDate 
                                        && type !== 'days' 
                                        && !HoursEnabled){
                                    $('#DOPBSP-group').removeAttr('disabled');
                                }
                                break;
                            case 'special':
                                $('#DOPBSP-price').removeAttr('disabled');
                                $('#DOPBSP-promo').attr('disabled', 'disabled');
                                $('#DOPBSP-available').removeAttr('disabled');
                                $('#DOPBSP-available').val('1');

                                if (startDate !== endDate 
                                        && type !== 'days' 
                                        && !HoursEnabled){
                                    $('#DOPBSP-group').removeAttr('disabled');
                                }
                                break;
                            case 'unavailable':
                                $('#DOPBSP-price').attr('disabled', 'disabled');
                                $('#DOPBSP-promo').attr('disabled', 'disabled');
                                $('#DOPBSP-price').val('');
                                $('#DOPBSP-promo').val('');
                                $('#DOPBSP-available').attr('disabled', 'disabled');
                                $('#DOPBSP-available').val('');

                                if (startDate !== endDate 
                                        && type !== 'days' 
                                        && !HoursEnabled){
                                    $('#DOPBSP-group').attr('disabled', 'disabled');
                                }
                                break;
                        }
                    });

                    /*
                     * Price event.
                     */
                    $('#DOPBSP-price').unbind('keyup');
                    $('#DOPBSP-price').bind('keyup', function(){
                        DOPPrototypes.cleanInput($(this), '0123456789.', '', '');

                        if ($(this).val() > '0'){
                            $('#DOPBSP-promo').removeAttr('disabled');
                        }
                        else{
                            $('#DOPBSP-promo').attr('disabled', 'disabled');
                            $('#DOPBSP-promo').val('');                                
                        }
                    });

                    /*
                     * Promo event.
                     */
                    $('#DOPBSP-promo').unbind('keyup');
                    $('#DOPBSP-promo').bind('keyup', function(){
                        DOPPrototypes.cleanInput($(this), '0123456789.', '', '');
                    });
                }

                if (type === 'days' 
                        && HoursEnabled){
                    /*
                     * Hours status event.
                     */
                    $('#DOPBSP-hours-status').DOPSelect();
                    $('#DOPBSP-hours-status').unbind('change');
                    $('#DOPBSP-hours-status').bind('change', function(){
                        switch ($(this).val()){
                            case 'available':
                                $('#DOPBSP-hours-price').removeAttr('disabled');
                                
                                if($('#DOPBSP-hours-price').val() === "") {
                                    $('#DOPBSP-hours-promo').attr('disabled', 'disabled');
                                }
                                $('#DOPBSP-hours-available').removeAttr('disabled');
                                $('#DOPBSP-hours-available').val('1');
                                break;
                            case 'booked':
                                $('#DOPBSP-hours-price').attr('disabled', 'disabled');
                                $('#DOPBSP-hours-promo').attr('disabled', 'disabled');
                                $('#DOPBSP-hours-price').val('');
                                $('#DOPBSP-hours-promo').val('');
                                $('#DOPBSP-hours-available').attr('disabled', 'disabled');
                                $('#DOPBSP-hours-available').val('');
                                break;
                            case 'special':
                                $('#DOPBSP-hours-price').removeAttr('disabled');
                                
                                if($('#DOPBSP-hours-price').val() === "") {
                                    $('#DOPBSP-hours-promo').attr('disabled', 'disabled');
                                }
                                $('#DOPBSP-hours-available').removeAttr('disabled');
                                $('#DOPBSP-hours-available').val('1');
                                break;
                            case 'unavailable':
                                $('#DOPBSP-hours-price').attr('disabled', 'disabled');
                                $('#DOPBSP-hours-promo').attr('disabled', 'disabled');
                                $('#DOPBSP-hours-price').val('');
                                $('#DOPBSP-hours-promo').val('');
                                $('#DOPBSP-hours-available').attr('disabled', 'disabled');
                                $('#DOPBSP-hours-available').val('');
                                break;
                        }
                    });

                    /*
                     * Hours price event.
                     */
                    $('#DOPBSP-hours-price').unbind('keyup');
                    $('#DOPBSP-hours-price').bind('keyup', function(){
                        DOPPrototypes.cleanInput($(this), '0123456789.', '', '');

                        if ($(this).val() > '0'){
                            $('#DOPBSP-hours-promo').removeAttr('disabled');
                        }
                        else{
                            $('#DOPBSP-hours-promo').attr('disabled', 'disabled');
                            $('#DOPBSP-hours-promo').val('');                                
                        }
                    });
                    
                    /*
                     * Hours promo event.
                     */
                    $('#DOPBSP-hours-promo').unbind('keyup');
                    $('#DOPBSP-hours-promo').bind('keyup', function(){
                        DOPPrototypes.cleanInput($(this), 
                                              '0123456789.', 
                                              '', 
                                              '');
                    });

                    /*
                     * Hours number of items available event.
                     */
                    $('#DOPBSP-hours-available').unbind('keyup');
                    $('#DOPBSP-hours-available').bind('keyup', function(){
                        DOPPrototypes.cleanInput($(this), 
                                              '0123456789', 
                                              '0', 
                                              '');
                    });
                }

                /*
                 * Number of items available event.
                 */
                $('#DOPBSP-available').unbind('keyup');
                $('#DOPBSP-available').bind('keyup', function(){
                    DOPPrototypes.cleanInput($(this), 
                                          '0123456789', 
                                          '0', 
                                          '');
                });

                /*
                 * Submit button event.
                 */
                $('#DOPBSP-submit').unbind('click');
                $('#DOPBSP-submit').bind('click', function(){
                    methods_schedule.set(type);
                });

                /*
                 * Reset button event.
                 */
                $('#DOPBSP-reset').unbind('click');
                $('#DOPBSP-reset').bind('click', function(){
                    methods_schedule.reset(type);
                });

                /*
                 * Close button event.
                 */
                $('#DOPBSP-close').unbind('click');
                $('#DOPBSP-close').bind('click', function(){
                    methods_form.clear(type);
                });
            },
            clear:function(type){
            /*
             * Clear form.
             * 
             * @param type (String): type of selection to be removed from calendar
             *                       "days" remove days selection
             *                       "hours" remove hours selection
             */    
                DOPBSPBackEnd.clearColumns(3);

                if (type === 'days'){
                    $('.DOPBSPCalendar-day', Container).removeClass('selected');   
                    methods_day.customize();
                }
                else{
                    $('.DOPBSPCalendar-hour', Container).removeClass('selected');
                }
            }
        },

// Schedule
        methods_schedule = {
            parse:function(year){
            /*
             * Parse schedule.
             * 
             * @param year (Number): the year for which the calendar should get the schedule
             */    
                var scheduleBuffer = {};
			
                $.post(ajaxurl, {action: 'dopbsp_calendar_schedule_get',
                                 id: ID,
                                 year: year,
                                 firstYear: '"'+firstYearLoaded+'"'}, function(data){
                    if ($.trim(data) !== ''){
                        scheduleBuffer = JSON.parse($.trim(data));

                        for (var day in scheduleBuffer){
                            scheduleBuffer[day] = JSON.parse(scheduleBuffer[day]);
                        }
			
                        $.extend(DOT.methods.calendar_schedule.data[ID], scheduleBuffer);
                    }

                    if (showCalendar 
                            && (StartMonth < 12-noMonths+1 
                                    || firstYearLoaded 
                                    || year >= MaxYear)){
                        showCalendar = false;
                        DOPBSPBackEnd.toggleMessages('success', 
                                              DOPBSPBackEnd.text('CALENDARS_CALENDAR_LOAD_SUCCESS'));
                        methods_calendar.display();
                    }

                    if (!firstYearLoaded){
                        firstYearLoaded = true;
                    }

                    /*
                     * Load schedule for other years. 
                     */
                    if (year < MaxYear){
                        methods_schedule.parse(year+1);
                    }
                });
            },
            set:function(type){
            /*
             * Set schedule to be sent to the database.
             * 
             * @param type (String): the type of the data being set
             *                       "days" set data for days
             *                       "hours" set data for hours
             */
                var hoursDefinitions = new Array(), 
                hours = new Array(),
                i, 
                y, 
                m, 
                d, 
                noDays, 
                key,
                startDate, 
                sYear, 
                sMonth, 
                sDay,
                endDate, 
                eYear, 
                eMonth, 
                eDay,
                startHour, 
                sHour, 
                sMinute,
                endHour, 
                eHour, 
                eMinute,
                prevHour,
                nextHour,
                fromMonth, 
                toMonth, 
                fromDay, 
                toDay,
                availableValue = $('#DOPBSP-available').val() !== undefined && $('#DOPBSP-available').val() !== '' ? parseInt($('#DOPBSP-available').val()):0,
                bindValue = 0,
                hoursValue = {},
                hoursDefinitionsValue,
                infoValue = $('#DOPBSP-info').val().replace(/\n/gi, '<br />'),
                notesValue = $('#DOPBSP-notes').val().replace(/\n/gi, '<br />'),
                priceValue = $('#DOPBSP-price').val() !== undefined && $('#DOPBSP-price').val() !== '' ? parseFloat($('#DOPBSP-price').val()):0,
                promoValue = $('#DOPBSP-promo').val() !== undefined && $('#DOPBSP-promo').val() !== '' ? parseFloat($('#DOPBSP-promo').val()):0,
                statusValue = $('#DOPBSP-status').val() !== undefined ? $('#DOPBSP-status').val():'',
                hoursAvailableValue = $('#DOPBSP-set-hours-default-data').is(':checked') && $('#DOPBSP-hours-available').val() !== undefined && $('#DOPBSP-hours-available').val() !== '' ? parseInt($('#DOPBSP-hours-available').val()):0,
                hoursInfoValue = $('#DOPBSP-set-hours-default-data').is(':checked') && $('#DOPBSP-hours-info').val() !== undefined ? $('#DOPBSP-hours-info').val().replace(/\n/gi, '<br />'):'',
                hoursNotesValue = $('#DOPBSP-set-hours-default-data').is(':checked') && $('#DOPBSP-hours-notes').val() !== undefined ? $('#DOPBSP-hours-notes').val().replace(/\n/gi, '<br />'):'',
                hoursPriceValue = $('#DOPBSP-set-hours-default-data').is(':checked') && $('#DOPBSP-hours-price').val() !== undefined && $('#DOPBSP-hours-price').val() !== '' ? parseFloat($('#DOPBSP-hours-price').val()):0,
                hoursPromoValue = $('#DOPBSP-set-hours-default-data').is(':checked') && $('#DOPBSP-hours-promo').val() !== undefined && $('#DOPBSP-hours-promo').val() !== '' ? parseFloat($('#DOPBSP-hours-promo').val()):0,
                hoursStatusValue = $('#DOPBSP-set-hours-default-data').is(':checked') && $('#DOPBSP-hours-status').val() !== undefined ? $('#DOPBSP-hours-status').val():'none',
                hourDefaultValue = {"available": hoursAvailableValue,
                                    "bind": 0,
                                    "info": hoursInfoValue,
                                    "notes": hoursNotesValue,
                                    "price": hoursPriceValue,
                                    "promo": hoursPromoValue,
                                    "status": hoursStatusValue},
                defaultAvailability = $('#DOPBSP-availability-type').val();
                
                if (HoursEnabled
			&& $('#DOPBSP-hours-available').val() !== undefined){
                    availableValue = $('#DOPBSP-hours-available').val() !== undefined && $('#DOPBSP-hours-available').val() !== '' ? parseInt($('#DOPBSP-hours-available').val()):0;
                    priceValue = hoursPriceValue;
                }

                if (type === 'days'){
                    
                    if(defaultAvailability !== 'true') {
                        startDate = dayStartSelection < dayEndSelection ? dayStartSelection.split('_')[1]:dayEndSelection.split('_')[1];
                        endDate = dayStartSelection < dayEndSelection ? dayEndSelection.split('_')[1]:dayStartSelection.split('_')[1];

                        sYear = parseInt(startDate.split('-')[0], 10);
                        sMonth = parseInt(startDate.split('-')[1], 10);
                        sDay = parseInt(startDate.split('-')[2], 10);

                        eYear = parseInt(endDate.split('-')[0], 10);
                        eMonth = parseInt(endDate.split('-')[1], 10);
                        eDay = parseInt(endDate.split('-')[2], 10);

                        if (DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getPrevDay(startDate)] !== undefined){
                            if (DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getPrevDay(startDate)]['bind'] === 1){
                                DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getPrevDay(startDate)]['bind'] = 0;                                                                
                            }
                            else if (DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getPrevDay(startDate)]['bind'] === 2){
                                DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getPrevDay(startDate)]['bind'] = 3;                                
                            }
                        }

                        if (DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getNextDay(endDate)] !== undefined){
                            if (DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getNextDay(endDate)]['bind'] === 2){
                                DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getNextDay(endDate)]['bind'] = 1;                                                                
                            }
                            else if (DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getNextDay(endDate)]['bind'] === 3){
                                DOT.methods.calendar_schedule.data[ID][DOPPrototypes.getNextDay(endDate)]['bind'] = 0;                                
                            }
                        }
                    }

                    if (HoursEnabled 
                            && $('#DOPBSP-change-hours-definitions').is(':checked') 
                            && $('#DOPBSP-hours-definitions').val() !== undefined 
                            && $('#DOPBSP-hours-definitions').val() !== ''){
                        hoursDefinitions = $('#DOPBSP-hours-definitions').val().split('\n');

                        for (i=0; i<hoursDefinitions.length; i++){
                            hoursDefinitions[i] = hoursDefinitions[i].replace(/\s/g, "");

                            if (hoursDefinitions[i] !== ''){
                                hours.push({'value': hoursDefinitions[i]});
                                hoursValue[hoursDefinitions[i]] = hourDefaultValue;

                                if ((HoursIntervalEnabled || !AddLastHourToTotalPrice) && i === hoursDefinitions.length-1){
                                     hoursValue[hoursDefinitions[i]] = methods_hour.default(hoursDefinitions[i]);
                                }
                            }
                        }
                    }
                    else{
                        key = sYear+'-'+DOPPrototypes.getLeadingZero(sMonth)+'-'+DOPPrototypes.getLeadingZero(sDay);

                        if (DOT.methods.calendar_schedule.data[ID][key] !== undefined){
                        
                            if(DOT.methods.calendar_schedule.data[ID][key]['hours_definitions'] === null) {
                                DOT.methods.calendar_schedule.data[ID][key]['hours_definitions']= [];
                            }
                            
                            for (i=0; i<DOT.methods.calendar_schedule.data[ID][key]['hours_definitions'].length; i++){
                                hoursValue[DOT.methods.calendar_schedule.data[ID][key]['hours_definitions'][i]['value']] = hourDefaultValue;

                                if ((HoursIntervalEnabled 
                                                || !AddLastHourToTotalPrice) 
                                        && i === DOT.methods.calendar_schedule.data[ID][key]['hours_definitions'].length-1){
                                    hoursValue[DOT.methods.calendar_schedule.data[ID][key]['hours_definitions'][i]['value']] = methods_hour.default(DOT.methods.calendar_schedule.data[ID][key]['hours_definitions'][i]['value']);
                                }
                            }
                        }
                        else{
                            for (i=0; i<HoursDefinitions.length; i++){
                                hoursValue[HoursDefinitions[i]['value']] = hourDefaultValue;

                                if ((HoursIntervalEnabled 
                                                || !AddLastHourToTotalPrice) 
                                        && i === HoursDefinitions.length-1){
                                    hoursValue[HoursDefinitions[i]['value']] = methods_hour.default(HoursDefinitions[i]['value']);
                                }
                            }
                        }
                    }

                    for (y=sYear; y<=eYear; y++){
                        fromMonth = 1;

                        if (y === sYear){
                            fromMonth = sMonth;
                        }

                        toMonth = 12;

                        if (y === eYear){
                            toMonth = eMonth;
                        }

                        for (m=fromMonth; m<=toMonth; m++){
                            noDays = new Date(y, m, 0).getDate();
                            fromDay = 1;

                            if (y === sYear 
                                    && m === sMonth){
                                fromDay = sDay;
                            }

                            toDay = noDays;

                            if (y === eYear 
                                    && m === eMonth){
                                toDay = eDay;
                            }

                            for (d=fromDay; d<=toDay; d++){
                                key = y+'-'+DOPPrototypes.getLeadingZero(m)+'-'+DOPPrototypes.getLeadingZero(d);

                                if (DOT.methods.calendar_days.settings[ID]['available'][DOT.methods.calendar_day.weekday(y+'-'+m+'-'+d)] 
                                        || startDate === endDate){
                                    if ($('#DOPBSP-group').is(':checked')){
                                        if (key === startDate){
                                            bindValue = 1;
                                        }                 
                                        else if (key === endDate){
                                            bindValue = 3;
                                        }   
                                        else{
                                            bindValue = 2;                                            
                                        }
                                    }

                                    if ($('#DOPBSP-change-hours-definitions').is(':checked') 
                                            && $('#DOPBSP-hours-definitions').val() !== undefined 
                                            && $('#DOPBSP-hours-definitions').val() !== ''){
                                        hoursDefinitionsValue = hours;
                                    }
                                    else{
                                        if (DOT.methods.calendar_schedule.data[ID][key] !== undefined){
                                            hoursValue = $('#DOPBSP-set-hours-default-data').is(':checked') ? hoursValue:DOT.methods.calendar_schedule.data[ID][key]['hours'];
                                            hoursDefinitionsValue = DOT.methods.calendar_schedule.data[ID][key]['hours_definitions'];
                                        }
                                        else{
                                            hoursDefinitionsValue = HoursDefinitions;
                                        }
                                    }

                                    DOT.methods.calendar_schedule.data[ID][key] = {"available": availableValue,
                                                     "bind": bindValue,
                                                     "hours": $.extend(true, {}, hoursValue),
                                                     "hours_definitions": hoursDefinitionsValue,
                                                     "info": infoValue,
                                                     "notes": notesValue,
                                                     "price": priceValue,
                                                     "promo": promoValue,
                                                     "status": statusValue};

                                    if (HoursEnabled 
                                            && DetailsFromHours){
                                        methods_schedule.setDayFromHours(key);
                                    }
                                    
                                    if(defaultAvailability === 'true') {
                                        DOT.methods.calendar_schedule.default[ID] = DOT.methods.calendar_schedule.data[ID][key];
                                    }
                                }
                            }
                        }
                    }
                    
                    if(defaultAvailability === 'true') {
                        var year = new Date().getFullYear(),
                            month = new Date().getMonth()+1,
                            day = new Date().getDate(),
                            startDate = year+'-'+month+'-'+day,
                            available = 0;

                        if (DOT.methods.calendar_schedule.default[ID] !== undefined){
                        
                            if(DOT.methods.calendar_schedule.default[ID]['hours_definitions'] === null) {
                                DOT.methods.calendar_schedule.default[ID]['hours_definitions']= [];
                            }
                            
                            for (i=0; i<hoursDefinitions.length; i++){
                                hoursValue[hoursDefinitions[i]['value']] = hourDefaultValue;
                                hoursValue[hoursDefinitions[i]['value']]['price'] = parseFloat($('#DOPBSP-hours-price').val() !== '' ? $('#DOPBSP-hours-price').val():0);
                                hoursValue[hoursDefinitions[i]['value']]['promo'] = parseFloat($('#DOPBSP-hours-promo').val() !== '' ? $('#DOPBSP-hours-promo').val():0);
                                hoursValue[hoursDefinitions[i]['value']]['status'] = $('#DOPBSP-hours-status').val();
                                hoursValue[hoursDefinitions[i]['value']]['available'] = availableValue;
                                
                                if ((HoursIntervalEnabled 
                                                || !AddLastHourToTotalPrice)){
                                    hoursValue[hoursDefinitions[i]['value']] = methods_hour.default(hoursDefinitions[i]['value']);
				    hoursValue[hoursDefinitions[i]['value']]['price'] = parseFloat($('#DOPBSP-hours-price').val() !== '' ? $('#DOPBSP-hours-price').val():0);
				    hoursValue[hoursDefinitions[i]['value']]['promo'] = parseFloat($('#DOPBSP-hours-promo').val() !== '' ? $('#DOPBSP-hours-promo').val():0);
                                    hoursValue[hoursDefinitions[i]['value']]['status'] = $('#DOPBSP-hours-status').val();
                                    hoursValue[hoursDefinitions[i]['value']]['available'] = availableValue;
                                }
                                
                                available = available+availableValue;
                                
                                if ((HoursIntervalEnabled 
                                                || !AddLastHourToTotalPrice) 
                                        && i === hoursDefinitions.length-1){
                                    available = available-availableValue;
                                }
                            }
                        }
                        else{
                            
                            for (i=0; i<HoursDefinitions.length; i++){
                                hoursValue[HoursDefinitions[i]['value']] = hourDefaultValue;
                                
                                if ((HoursIntervalEnabled 
                                                || !AddLastHourToTotalPrice) 
                                        && i === HoursDefinitions.length-1){
                                    hoursValue[HoursDefinitions[i]['value']] = methods_hour.default(HoursDefinitions[i]['value']);
                                    hoursValue[HoursDefinitions[i]['value']]['price'] = parseFloat($('#DOPBSP-hours-price').val());
                                    hoursValue[HoursDefinitions[i]['value']]['status'] = $('#DOPBSP-hours-status').val();
                                    hoursValue[HoursDefinitions[i]['value']]['available'] = availableValue;
                                
                                }
                                
                                available += hoursValue[HoursDefinitions[i]['value']]['available'];
                            }
                        }
                        
                        
                        if ($('#DOPBSP-change-hours-definitions').is(':checked') 
                                && $('#DOPBSP-hours-definitions').val() !== undefined 
                                && $('#DOPBSP-hours-definitions').val() !== ''){
                            hoursDefinitionsValue = hours;
                            statusValue = $('#DOPBSP-hours-status').val() !== undefined ? $('#DOPBSP-hours-status').val():$('#DOPBSP-status').val();
                        }
                        else{
                            if (DOT.methods.calendar_schedule.default[ID] !== undefined){
//                                hoursValue = $('#DOPBSP-set-hours-default-data').is(':checked') ? hoursValue:DOT.methods.calendar_schedule.default[ID]['hours'];
                                hoursDefinitionsValue = DOT.methods.calendar_schedule.default[ID]['hours_definitions'];
                                statusValue = $('#DOPBSP-hours-status').val() !== undefined ? $('#DOPBSP-hours-status').val():$('#DOPBSP-status').val();
                            }
                            else{
                                hoursDefinitionsValue = HoursDefinitions;
                                statusValue = $('#DOPBSP-hours-status').val() !== undefined ? $('#DOPBSP-hours-status').val():$('#DOPBSP-status').val();
                            }
                        }
                        
                        if (HoursEnabled && promoValue === 0 && hoursPromoValue !== 0){
                                priceValue = hoursPromoValue;
                        }
                        
                        if(!HoursEnabled) {
                            available = parseInt($('#DOPBSP-available').val());
                        }
                        
                        delete hoursValue[undefined];
                        
                        DOT.methods.calendar_schedule.default[ID] = {"available": available,
                                         "bind": 0,
                                         "hours": $.extend(true, {}, hoursValue),
                                         "hours_definitions": hoursDefinitionsValue,
                                         "info": infoValue,
                                         "notes": notesValue,
                                         "price": priceValue,
                                         "promo": promoValue,
                                         "status": statusValue};
                    }

                    methods_calendar.init(startDate.split('-')[0], 
                                          startDate.split('-')[1]); 
                }
                else{
                    
                    if(defaultAvailability !== 'true') {
                        startDate = hourDaySelection.split('_')[1];
                        sYear = startDate.split('-')[0];
                        sMonth = startDate.split('-')[1];
                        sDay = startDate.split('-')[2];

                        if (hourStartSelection > hourEndSelection){
                            endHour = hourStartSelection.split('_')[1];
                            startHour = hourEndSelection.split('_')[1];
                        }
                        else{
                            startHour = hourStartSelection.split('_')[1];
                            endHour = hourEndSelection.split('_')[1];
                        }

                        if (startHour !== endHour){
                            hoursDefinitionsValue = HoursDefinitions;
                        }
                        else{
                            if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay] !== undefined){
                                hoursDefinitionsValue = DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours_definitions'];
                            }
                            else{
                                hoursDefinitionsValue = HoursDefinitions;
                            }
                        }

                        sHour = startHour.split(':')[0];
                        sMinute = startHour.split(':')[1];

                        eHour = endHour.split(':')[0];
                        eMinute = endHour.split(':')[1];

                        prevHour = methods_hour.getPrev(startHour, hoursDefinitionsValue);
                        nextHour = methods_hour.getNext(endHour, hoursDefinitionsValue);

                        if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay] === undefined){
                            DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay] = methods_day.default(DOT.methods.calendar_day.weekday(sYear+'-'+sMonth+'-'+sDay));
                        }

                        if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour] !== undefined){
                            if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] === 1){
                                DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] = 0;                                                                
                            }
                            else if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] === 2){
                                DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] = 3;                                
                            }
                        }

                        if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour] !== undefined){
                            if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] === 2){
                                DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] = 1;                                                                
                            }
                            else if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] === 3){
                                DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] = 0;                                
                            }
                        }
                    }
                    
                    for (i=0; i<hoursDefinitionsValue.length; i++){
                        key = hoursDefinitionsValue[i]['value'];

                        if ($('#DOPBSP-group').is(':checked')){
                            if (key === startHour){
                                bindValue = 1;
                            }                 
                            else if (key === endHour){
                                bindValue = 3;
                            }   
                            else{
                                bindValue = 2;                                            
                            }
                        }

                        if (sHour+':'+sMinute <= key 
                                && key <= eHour+':'+eMinute){
//                            availableValue = parseInt($('#DOPBSP-available').val());
                            DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][key] = {"available": availableValue,
                                                                                 "bind": bindValue,
                                                                                 "info": infoValue,
                                                                                 "notes": notesValue,
                                                                                 "price": priceValue,
                                                                                 "promo": promoValue,
                                                                                 "status": statusValue};   
                            DOT.methods.calendar_schedule.default[ID]['hours'][key] = DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][key];
                        }
                        
                        if(defaultAvailability === 'true') {
                            DOT.methods.calendar_schedule.default[ID]['status'] = $('#DOPBSP-hours-status').val();
                            DOT.methods.calendar_schedule.default[ID]['hours'][key] = {"available": availableValue,
                                                             "bind": bindValue,
                                                             "info": infoValue,
                                                             "notes": notesValue,
                                                             "price": priceValue,
                                                             "promo": promoValue,
                                                             "status": statusValue};
                        }
                        
                    }
		    
                    if(defaultAvailability !== 'true') {
                        
                        if (HoursEnabled 
                                && DetailsFromHours){
                            methods_schedule.setDayFromHours(startDate);
                            methods_calendar.init(startDate.split('-')[0],
                                                  startDate.split('-')[1]); 
                        }

                        methods_hours.display(hourDaySelection);
                        window.location = '#'+ID+'_'+startHour;                            
                        DOPPrototypes.scrollToY($('body').scrollTop()-50);
                    }
                }

                methods_schedule.save(defaultAvailability);
            },
            save:function(defaultAvailability){
            /*
             * Save schedule.
             */
                if(defaultAvailability !== 'true') {
                    var startDate = dayStartSelection < dayEndSelection ? dayStartSelection.split('_')[1]:dayEndSelection.split('_')[1],
                        endDate = dayStartSelection < dayEndSelection ? dayEndSelection.split('_')[1]:dayStartSelection.split('_')[1];


                    yearStartSave = parseInt(startDate.split('-')[0], 10);
                    monthStartSave = parseInt(startDate.split('-')[1], 10);
                    yearEndSave = parseInt(endDate.split('-')[0], 10);
                    monthEndSave = parseInt(endDate.split('-')[1], 10);
                } 
                

                DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));
                methods_form.clear();

                if(defaultAvailability === 'true') {
                    methods_schedule.saveDefaultAvailability(DOT.methods.calendar_schedule.default[ID]);
                } else {
                    methods_schedule.saveMonth(yearStartSave, 
                                               monthStartSave);
                }
            },                    
            saveMonth:function(year,
                               month){
            /*
             * Save schedule in database by month.
             * 
             * @param year (Number): year of the month to be saved
             * @param month (Number): month to be saved
             * 
             * @return success message
             */
                var schedule = DOT.methods.calendar_schedule.data[ID].constructor(),
                nextYear = month === 12 ? year+1:year, 
                nextMonth = month === 12 ? 1:month+1,
                startDate = dayStartSelection < dayEndSelection ? dayStartSelection.split('_')[1]:dayEndSelection.split('_')[1],
                endDate = dayStartSelection < dayEndSelection ? dayEndSelection.split('_')[1]:dayStartSelection.split('_')[1];

                CurrMonth = (year-StartYear)*12+month;

                for (var day in DOT.methods.calendar_schedule.data[ID]){
                    if (day.indexOf(year+'-'+DOPPrototypes.getLeadingZero(month)) !== -1){
                        if (startDate <= day && day <= endDate){
                            schedule[day] = DOT.methods.calendar_schedule.data[ID][day];
                        }
                    }                            
                }         

                if (yearStartSave !== year 
                        || monthStartSave !== month){
                    methods_calendar.init(StartYear,
                                          CurrMonth);

                    if (StartMonth !== month){
                        $('.DOPBSPCalendar-navigation .previous-btn', Container).css('display', 'block');
                    }
                }
                
                $.post(ajaxurl, {action: 'dopbsp_calendar_schedule_set',
                                 id: ID,
                                 schedule: JSON.stringify(schedule),
                                 hours_enabled: HoursEnabled,
                                 default_availability: 'false'}, function(data){
				 console.log(data);
                    if (year === yearEndSave 
                            && month === monthEndSave){
                        DOPBSPBackEnd.toggleMessages('success',
                                              data);
                    }                            
                    else{
                        methods_schedule.saveMonth(nextYear,
                                                   nextMonth);                      
                    }  
                });
            },                            
            saveDefaultAvailability:function(schedule){
            /*
             * Save default schedule in database.
             * 
             * @param year (Number): year of the month to be saved
             * @param month (Number): month to be saved
             * 
             * @return success message
             */
                var year = new Date().getFullYear(),
                    month = new Date().getMonth()+1,
                    nextYear = month === 12 ? year+1:year, 
                    nextMonth = month === 12 ? 1:month+1;

                CurrMonth = (year-StartYear)*12+month;       

                if (yearStartSave !== year 
                        || monthStartSave !== month){
                    methods_calendar.init(StartYear,
                                          CurrMonth);

                    if (StartMonth !== month){
                        $('.DOPBSPCalendar-navigation .previous-btn', Container).css('display', 'block');
                    }
                }
                $.post(ajaxurl, {action: 'dopbsp_calendar_schedule_set',
                                 id: ID,
                                 schedule: JSON.stringify(DOT.methods.calendar_schedule.default[ID]),
                                 hours_enabled: HoursEnabled,
                                 default_availability: 'true'}, function(data){
                    console.log(data);
                    DOPBSPBackEnd.toggleMessages('success',
                                          data);
                    
                    var year = new Date().getFullYear(),
                        month = new Date().getMonth()+1,
                        day = new Date().getDate(),
                        startDate = year+'-'+month+'-'+day;
                    
                    methods_calendar.init(startDate.split('-')[0], 
                                          startDate.split('-')[1]); 
                    
                    // Default Availability
                    methods_form.display('days', true);
                });
            },               
            reset:function(type){
            /*
             * Reset schedule. 
             * 
             * @param type (String): the type of the data being removed
             *                       "days" remove data for days
             *                       "hours" remove data for hours
             */
                var i, 
                key,
                startDate, 
                sYear, 
                sMonth, 
                sDay,
                startHour, 
                sHour, 
                sMinute,
                endHour, 
                eHour, 
                eMinute,
                prevHour,
                nextHour;
                
                var defaultAvailability = $('#DOPBSP-availability-type').val();

                if (confirm(ResetConfirmation)){
                    if (type === 'days'){
                        
                        if(defaultAvailability !== 'true') {
                            methods_schedule.delete();
                        } else {
                            DOT.methods.calendar_schedule.default[ID] = SavedDefaultSchedule;
                        
                            methods_schedule.save(defaultAvailability);
                        }
                    }
                    else{
                        if(defaultAvailability !== 'true') {
                            startDate = hourDaySelection.split('_')[1];
                            sYear = startDate.split('-')[0];
                            sMonth = startDate.split('-')[1];
                            sDay = startDate.split('-')[2];

                            if (hourStartSelection > hourEndSelection){
                                endHour = hourStartSelection.split('_')[1];
                                startHour = hourEndSelection.split('_')[1];
                            }
                            else{
                                startHour = hourStartSelection.split('_')[1];
                                endHour = hourEndSelection.split('_')[1];
                            }

                            sHour = startHour.split(':')[0];
                            sMinute = startHour.split(':')[1];

                            eHour = endHour.split(':')[0];
                            eMinute = endHour.split(':')[1];

                            prevHour = methods_hour.getPrev(startHour, DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours_definitions']);
                            nextHour = methods_hour.getNext(endHour, DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours_definitions']);

                            if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay] === undefined){
                                DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay] = methods_day.default(DOT.methods.calendar_day.weekday(sYear+'-'+sMonth+'-'+sDay));
                            }

                            if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour] !== undefined){
                                if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] === 1){
                                    DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] = 0;                                                                
                                }
                                else if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] === 2){
                                    DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][prevHour]['bind'] = 3;                                
                                }
                            }

                            if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour] !== undefined){
                                if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] === 2){
                                    DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] = 1;                                                                
                                }
                                else if (DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] === 3){
                                    DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][nextHour]['bind'] = 0;                                
                                }
                            }

                            for (i=0; i<DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours_definitions'].length; i++){
                                key = DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours_definitions'][i]['value'];

                                if (sHour+':'+sMinute <= key 
                                        && key <= eHour+':'+eMinute){
                                    DOT.methods.calendar_schedule.data[ID][sYear+'-'+sMonth+'-'+sDay]['hours'][key] = methods_hour.default(key);
                                }
                            }

                            if (HoursEnabled 
                                    && DetailsFromHours){
                                methods_schedule.setDayFromHours(startDate);
                            }

                            methods_hours.display(hourDaySelection);
                            window.location = '#'+ID+'_'+startHour;                            
                            DOPPrototypes.scrollToY($('body').scrollTop()-50);       
                        } else {
                            DOT.methods.calendar_schedule.default[ID] = SavedDefaultSchedule;
                        }
                        
                        methods_schedule.save(defaultAvailability);
                    }
                }
            },                  
            delete:function(){
            /*
             * Delete schedule.
             */
                var startDate = dayStartSelection < dayEndSelection ? dayStartSelection.split('_')[1]:dayEndSelection.split('_')[1],
                endDate = dayStartSelection < dayEndSelection ? dayEndSelection.split('_')[1]:dayStartSelection.split('_')[1];

                yearStartSave = parseInt(startDate.split('-')[0], 10);
                monthStartSave = parseInt(startDate.split('-')[1], 10);
                yearEndSave = parseInt(endDate.split('-')[0], 10);
                monthEndSave = parseInt(endDate.split('-')[1], 10);

                DOPBSPBackEnd.toggleMessages('active', 
                                      DOPBSPBackEnd.text('MESSAGES_SAVING'));
                methods_form.clear();

                methods_schedule.deleteMonth(yearStartSave, 
                                             monthStartSave);
            },                    
            deleteMonth:function(year,
                                 month){
            /*
             * Delete schedule in database by month.
             * 
             * @param year (Number): year of the month to be deleted
             * @param month (Number): month to be deleted
             * 
             * @return success message
             */
                var schedule = DOT.methods.calendar_schedule.data[ID].constructor(),
                nextYear = month === 12 ? year+1:year, 
                nextMonth = month === 12 ? 1:month+1,
                startDate = dayStartSelection < dayEndSelection ? dayStartSelection.split('_')[1]:dayEndSelection.split('_')[1],
                endDate = dayStartSelection < dayEndSelection ? dayEndSelection.split('_')[1]:dayStartSelection.split('_')[1];

                for (var day in DOT.methods.calendar_schedule.data[ID]){
                    if (day.indexOf(year+'-'+DOPPrototypes.getLeadingZero(month)) !== -1){
                        if (startDate <= day 
                                && day <= endDate){
                            schedule[day] = DOT.methods.calendar_schedule.data[ID][day];                                        
                            delete DOT.methods.calendar_schedule.data[ID][day];
                        }
                    }                            
                }

                if (yearStartSave !== year 
                        || monthStartSave !== month){
                    methods_calendar.init(StartYear,
                                          CurrMonth+1);

                    if (StartMonth !== month){
                        $('.DOPBSPCalendar-navigation .previous-btn', Container).css('display', 'block');
                    }
                }
                else{
                    methods_calendar.init(StartYear, 
                                          dayStartSelectionCurrMonth); 
                }

                $.post(ajaxurl, {action: 'dopbsp_calendar_schedule_delete',
                                 id: ID,
                                 schedule: JSON.stringify(schedule)}, function(data){     console.log(data);                       
                    if (year === yearEndSave 
                            && month === monthEndSave){
                        DOPBSPBackEnd.toggleMessages('success', 
                                              data);
                    }                            
                    else{
                        methods_schedule.deleteMonth(nextYear, 
                                                     nextMonth);                     
                    }   
                });
            },
            setDayFromHours:function(day){
            /*
             * Set day availability from hours availability.
             * 
             * @param day (String): day to be changed (YYYY-MM-DD)
             */    
                if (DOT.methods.calendar_schedule.data[ID][day] !== undefined){
                    var available = 0,
                    price = 0,
                    status = 'none';
            
                    for (var hour in DOT.methods.calendar_schedule.data[ID][day]['hours']){
                        // No Available Check
                        if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['bind'] === 0 
                                || DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['bind'] === 1){
                            if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['available'] !== 0){
                                available += parseInt(DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['available']);
                            }

                            // Price Check
                            if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['price'] !== 0 
                                    && (price === 0 
                                            || parseFloat(DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['price']) < price)){
                                price = parseFloat(DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['price']);
                            }

                            if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['promo'] !== 0 
                                    && (price === 0 
                                            || parseFloat(DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['promo']) < price)){
                                price = parseFloat(DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['promo']);
                            }

                            // Status Check
                            if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['status'] === 'unavailable' 
                                    && status === 'none'){
                                status = 'unavailable';
                            }

                            if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['status'] === 'booked' 
                                    && (status === 'none' 
                                            || status === 'unavailable')){
                                status = 'booked';
                            }

                            if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['status'] === 'special' 
                                    && (status === 'none' 
                                            || status === 'unavailable' 
                                            || status === 'booked')){
                                status = 'special';
                            }

                            if (DOT.methods.calendar_schedule.data[ID][day]['hours'][hour]['status'] === 'available'){
                                status = 'available';
                            }
                        }
                    }

                    DOT.methods.calendar_schedule.data[ID][day]['available'] = available === 0 ? '':available;
                    DOT.methods.calendar_schedule.data[ID][day]['price'] = price;
                    DOT.methods.calendar_schedule.data[ID][day]['status'] = status;
                }
            }
        },
          
// Tooltip
        methods_tooltip = {
            init:function(){
            /*
             * Initialize information tooltip.
             */
                var xPos = 0, 
                yPos = 0;

                /*
                 * Position the tooltip depending on mouse position.
                 */
                $(document).mousemove(function(e){
                    xPos = e.pageX+15;
                    yPos = e.pageY-10;

                    if ($(document).scrollTop()+$(window).height() < yPos+$('#DOPBSPCalendar-tooltip'+ID).height()+parseInt($('#DOPBSPCalendar-tooltip'+ID).css('padding-top'))+parseInt($('#DOPBSPCalendar-tooltip'+ID).css('padding-bottom'))+10){
                       yPos = $(document).scrollTop()+$(window).height()-$('#DOPBSPCalendar-tooltip'+ID).height()-parseInt($('#DOPBSPCalendar-tooltip'+ID).css('padding-top'))-parseInt($('#DOPBSPCalendar-tooltip'+ID).css('padding-bottom'))-10;
                    }

                    $('#DOPBSPCalendar-tooltip'+ID).css({'left': xPos, 'top': yPos});
                }); 
            },
            display:function(day,
                             hour,
                             type,
                             infoData){
            /*
             * Display information tooltip.
             * 
             * @param day (String): the day for which the information will be displayed (YYYY-MM-DD)
             * @param hour (String): the hour for which the information will be displayed (HH:MM)
             * @param type (String): type of information to be displayed
             *                       "hours" display hours information
             *                       "info" display information
             *                       "notes" display notes
             * @param infoData (String): information to be displayed
             */                         
                var info = infoData !== undefined ? infoData:(hour === '' ? (DOT.methods.calendar_schedule.data[ID][day] !== undefined ? DOT.methods.calendar_schedule.data[ID][day][type]:DOT.methods.calendar_schedule.default[ID][type]):(DOT.methods.calendar_schedule.data[ID][day] !== undefined && DOT.methods.calendar_schedule.data[ID][day]['hours'][hour] ? DOT.methods.calendar_schedule.data[ID][day]['hours'][hour][type]:DOT.methods.calendar_schedule.default[ID]['hours'][hour][type]));

                /*
                 * Escape utf8 coding.
                 */
		try{
		    info = decodeURIComponent(escape(info));
		}
		catch(e){
		    info = decodeURIComponent(unescape(unescape(info)));
		}
               
                if (type === 'hours'){
                    $('#DOPBSPCalendar-tooltip'+ID).removeClass('text');
                }
                else{
                    $('#DOPBSPCalendar-tooltip'+ID).addClass('text');
                }
                $('#DOPBSPCalendar-tooltip'+ID).html(info).css('display', 'block');                         
            },
            clear:function(){
            /*
             * Clear information display.
             */
                $('#DOPBSPCalendar-tooltip'+ID).css('display', 'none');                        
            }
        };

        return methods.init.apply(this);
    };
})(jQuery);