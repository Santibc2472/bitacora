    function Booking_App_Calendar(weekName, dateFormat, positionOfWeek, startOfWeek, i18n, debug) {
    	
    	var object = this;
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._console.log = debug.getConsoleLog();
            
        }
        
        this._clock = 24;
    	this._i18n = null;
    	this._stopToCreateCalendar = false;
    	this._startOfWeek = parseInt(startOfWeek);
        if(typeof i18n == 'object'){
            
            this._i18n = i18n;
            
        }
    	
    	this._weekClassName = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
    	//this.setWeekNameList(weekName);
    	this._weekName = weekName;
    	if(dateFormat != null){
    	    
    	    this._dateFormat = dateFormat;
    	    
    	}else{
    	    
    	    this._dateFormat = 0;
    	    
    	}
    	
    	if(positionOfWeek == null){
    	    
    	    this._positionOfWeek = "before";
    	    
    	}else{
    	    
    	    this._positionOfWeek = positionOfWeek;
    	    
    	}
    	
    	this._shortWeekNameBool = false;
    	
    	
    }
    
    Booking_App_Calendar.prototype.setClock = function(clock) {
        
        this._clock = clock;
        
    }
    
    Booking_App_Calendar.prototype.setStopToCreateCalendar = function(bool){
        
        this._stopToCreateCalendar = bool;
        
    }
	
	Booking_App_Calendar.prototype.setShortWeekNameBool = function(bool){
	    
	    this._shortWeekNameBool = bool;
	    
	}
	
	Booking_App_Calendar.prototype.setWeekNameList = function(weekName){
	    
	    this._weekName = weekName;
	    
	}
	
	Booking_App_Calendar.prototype.getWeekNameList = function(startOfWeek){
	    
	    var object = this;
	    var weekClassName = []
	    var weekName = [];
	    for(var i = 0; i < this._weekName.length; i++){
	        
	        weekClassName[i] = this._weekClassName[i];
	        weekName[i] = this._weekName[i];
	        
	    }
	    //Object.assign(weekName, this._weekName);
	    for(var i = 0; i < startOfWeek; i++){
	        
	        weekClassName.push(weekClassName[i]);
	        weekName.push(weekName[i]);
	        
	    }
	    
	    for(var i = 0; i < startOfWeek; i++){
	        
	        weekClassName.shift();
	        weekName.shift();
	        
	    }
	    
	    object._console.log(weekName);
	    return {weekName: weekName, weekClassName: weekClassName};
	    
	}
	
	Booking_App_Calendar.prototype.create = function(calendarPanel, calendarData, month, day, year, permission, callback){
	    
	    var object = this;
	    var dayHeight = parseInt(calendarPanel.clientWidth / 7);
	    var nationalHoliday = {};
	    if (calendarData.nationalHoliday != null && calendarData.nationalHoliday.calendar) {
	        
	        nationalHoliday = calendarData.nationalHoliday.calendar;
	        
	    }
	    
	    
	    var weekNamePanel = document.createElement("div");
	    weekNamePanel.setAttribute("class", "calendar");
	    //var weekName = this.getWeekNameList(this._startOfWeek);
	    var getWeekNameList = this.getWeekNameList(this._startOfWeek);
	    var weekName = getWeekNameList.weekName;
	    var weekClassName = getWeekNameList.weekClassName;
	    for (var i = 0; i < 7; i++) {
	  	
            var dayPanel = document.createElement("div");
            dayPanel.setAttribute("class", "dayPanel " + weekClassName[i].toLowerCase());
            dayPanel.textContent = this._i18n.get(weekName[i]);
            weekNamePanel.insertAdjacentElement("beforeend", dayPanel);
            if (i == 6) {
                
                dayPanel.setAttribute("style", "border-width: 1px 1px 0px 1px;")
	            
            }
        }
        
	    calendarPanel.insertAdjacentElement("beforeend", weekNamePanel);
	    
	    if (calendarData['date']['lastDay'] == null || calendarData['date']['startWeek'] == null || calendarData['date']['lastWeek'] == null) {
	        
	        window.alert("There is not enough information to create a calendar.");
	        return null;
	        
	    }
        
        var lastDay = parseInt(calendarData['date']['lastDay']);
        var startWeek = parseInt(calendarData['date']['startWeek']);
        var lastWeek = parseInt(calendarData['date']['lastWeek']);
        
        var weekCount = 0;
        var calendar = calendarData.calendar;
        var scheduleList = calendarData.schedule;
        
        var weekLine = Object.keys(calendar).length / 7;
        object._console.log(calendarData);
        object._console.log(calendar);
        var index = 0;
        for (var key in calendar) {
            var className = 'dayPanel dayPanelHeight';
            var dataKey = parseInt(calendar[key].year + ("0" + calendar[key].month).slice(-2) + ("0" + calendar[key].day).slice(-2));
            var bool = 1;
            
            var textPanel = document.createElement("div");
            textPanel.setAttribute("class", "dayPostion");
            textPanel.textContent = calendar[key].day;
            
            var dayPanel = document.createElement("div");
            dayPanel.id = "booking-package-day-" + index;
            //dayPanel.classList.add(weekName[parseInt(calendar[key].week)]);
            dayPanel.setAttribute("data-select", 1);
            dayPanel.setAttribute("data-day", calendar[key].day);
            dayPanel.setAttribute("data-month", calendar[key].month);
            dayPanel.setAttribute("data-year", calendar[key].year);
            dayPanel.setAttribute("data-key", key);
            dayPanel.setAttribute("data-week", weekCount);
            if (calendar[key].week != null) {
                
                dayPanel.setAttribute("data-week", calendar[key].week);
                
            }
            
            dayPanel.setAttribute("class", className);
            dayPanel.classList.add(weekName[parseInt(calendar[key].week)]);
            dayPanel.insertAdjacentElement("beforeend", textPanel);
            weekNamePanel.insertAdjacentElement("beforeend", dayPanel);
            
            var data = {key: dataKey, week: parseInt(calendar[key].week), month: calendar[key].month, day: calendar[key].day, year: calendar[key].year, eventPanel: dayPanel, status: true, count: i, bool: bool, index: index};
            
            if (calendar[dataKey].status != null) {
                
                data.status = calendar[dataKey].status;
                
            }
            
            if (scheduleList != null) {
                
                (function(data, schedule){
                    
                    var capacity = 0;
                    var remainder = 0;
                    for (var key in schedule) {
                        
                        capacity += parseInt(schedule[key].capacity);
                        remainder += parseInt(schedule[key].remainder);
                        
                    }
                    
                    data.capacity = capacity;
                    data.remainder = remainder;
                    
                })(data, scheduleList[key]);
                
            }
            
            if (this._stopToCreateCalendar == true) {
                
                break;
                
            }
            
            if (calendarData.calendar[dataKey] != null || (calendarData.reservation != null && calendarData.reservation[dataKey])) {
                
                var weekClass = "";
                if (calendar[key].week != null) {
                    
                    weekClass = this._weekClassName[parseInt(calendar[key].week)].toLowerCase()
                    
                }
                
                if (nationalHoliday[key] != null && parseInt(nationalHoliday[key].status) == 1) {
                    
                    weekClass += " nationalHoliday";
                    
                }
                
                dayPanel.setAttribute("class", "dayPanel dayPanelHeight pointer " + weekClass);
                
                if (parseInt(weekLine) == 1) {
                    
                    dayPanel.setAttribute("class", "border_bottom_width dayPanel dayPanelHeight pointer " + weekClass);
                    
                }
                
                data.status = true;
                if (calendar[dataKey].status != null) {
                    
                    data.status = calendar[dataKey].status;
                    
                }
                callback(data);
                
            } else {
                
                dayPanel.setAttribute("class", "dayPanel dayPanelHeight closeDay");
                
                if (parseInt(weekLine) == 1) {
                    
                    dayPanel.setAttribute("class", "border_bottom_width dayPanel dayPanelHeight closeDay");
                    
                }
                
                data.status = false;
                if (calendar[dataKey].status != null) {
                    
                    data.status = calendar[dataKey].status;
                    
                }
                callback(data);
                
            }
            
            if (weekCount == 6) {
                
                //dayPanel.setAttribute("style", "border-width: 1px 1px 0px 1px; height: " + dayHeight + "px;");
                var style = dayPanel.getAttribute("style");
                if (style == null) {
                    
                    style = "";
                    
                }
                dayPanel.setAttribute("style", style + "border-width: 1px 1px 0px 1px;");
                
            }
            
            if (weekCount == 6) {
                	
                weekCount = 0;
                weekLine--;
                
            } else {
                
                weekCount++;
                
            }
            
            index++;
            
        }
        
        return true;
        
    }
    
    Booking_App_Calendar.prototype.getExpressionsCheck = function(expressionsCheck){
        
        /**
        var i18n = new I18n(this._i18n._locale);
        i18n.setDictionary(this._i18n._dictionary);
        **/
        var response = {
            arrival: this._i18n.get("Arrival (Check-in)"), 
            chooseArrival: this._i18n.get("Please choose %s", [this._i18n.get("Arrival (Check-in)")]),
            departure: this._i18n.get("Departure (Check-out)"),
            chooseDeparture: this._i18n.get("Please choose %s", [this._i18n.get("Departure (Check-out)")]),
        
        };
        
        if(expressionsCheck == 1){
            
            response.arrival = this._i18n.get("Arrival");
            response.departure = this._i18n.get("Departure");
            response.chooseArrival = this._i18n.get("Please choose %s", [response.arrival]);
            response.chooseDeparture = this._i18n.get("Please choose %s", [response.departure]);
            
        }else if(expressionsCheck == 2){
            
            response.arrival = this._i18n.get("Check-in");
            response.departure = this._i18n.get("Check-out");
            response.chooseArrival = this._i18n.get("Please choose %s", [response.arrival]);
            response.chooseDeparture = this._i18n.get("Please choose %s", [response.departure]);
            
        }
        
        return response;
        
    }
    
    Booking_App_Calendar.prototype.getDateKey = function(month, day, year){
        
        var key = year + ("0" + month).slice(-2) + ("0" + day).slice(-2);
        return key;
        
    }
    
	Booking_App_Calendar.prototype.formatBookingDate = function(month, day, year, hour, min, title, week){
        
        var object = this;
        var i18n = this._i18n;
        var dateFormat = this._dateFormat;
        var print_am_pm = "";
        if(typeof title == "string"){
            
            title = title.replace(/\\/g, "");
            
        }
        object._console.log("dateFormat = " + dateFormat + " month = " + month + " day = " + day + " year = " + year + " hour = " + hour + " min = " + min + " week = " + week);
        if(month != null){
            
            month = ("0" + month).slice(-2);
            
        }
        
        if(day != null){
            
            day = ("0" + day).slice(-2);
            
        }
        
        if(hour != null){
            
            if (object._clock == "12a.m.p.m") {
                
                print_am_pm = "a.m.";
                if (hour > 12) {
                    
                    print_am_pm = "p.m.";
                    hour -= 12;
                    
                } else if (hour == 12) {
                    
                    print_am_pm = "p.m.";
                    hour = 12;
                    
                } else if (hour == 0) {
                    
                    hour = 12;
                    
                }
                
            } else if (object._clock == "12ampm") {
                
                print_am_pm = "am";
                if (hour > 12) {
                    
                    print_am_pm = "pm";
                    hour -= 12;
                    
                } else if (hour == 12) {
                    
                    print_am_pm = "pm";
                    hour = 12;
                    
                } else if (hour == 0) {
                    
                    hour = 12;
                    
                }
                
            } else if (object._clock == "12AMPM") {
                
                print_am_pm = "AM";
                if (hour > 12) {
                    
                    print_am_pm = "PM";
                    hour -= 12;
                    
                } else if (hour == 12) {
                    
                    print_am_pm = "PM";
                    hour = 12;
                    
                } else if (hour == 0) {
                    
                    hour = 12;
                    
                }
                
            }
            
            hour = ("0" + hour).slice(-2);
            
        }
        
        if(min != null){
            
            min = ("0" + min).slice(-2);
            
        }
        
        if(week != null){
            
            week = parseInt(week);
            
        }
        
        if(month != null && day == null && year == null){
            
            date = month;
            if(dateFormat == 2 || dateFormat == 5){
                
                var monthShortName = ['', i18n.get('Jan'), i18n.get('Feb'), i18n.get('Mar'), i18n.get('Apr'), i18n.get('May'), i18n.get('Jun'), i18n.get('Jul'), i18n.get('Aug'), i18n.get('Sep'), i18n.get('Oct'), i18n.get('Nov'), i18n.get('Dec')];
                date = monthShortName[parseInt(month)];
                
            }
            return date;
            
        }
        
        //var weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var weekName = [i18n.get('Sunday'), i18n.get('Monday'), i18n.get('Tuesday'), i18n.get('Wednesday'), i18n.get('Thursday'), i18n.get('Friday'), i18n.get('Saturday')];
        //weekName = this._weekName;
        if(this._shortWeekNameBool == true){
            
            weekName = [i18n.get('Sun'), i18n.get('Mon'), i18n.get('Tue'), i18n.get('Wed'), i18n.get('Thu'), i18n.get('Fri'), i18n.get('Sat')];
            
        }
        var monthFullName = ['', i18n.get('January'), i18n.get('February'), i18n.get('March'), i18n.get('April'), i18n.get('May'), i18n.get('June'), i18n.get('July'), i18n.get('August'), i18n.get('September'), i18n.get('October'), i18n.get('November'), i18n.get('December')];
        var date = monthFullName[parseInt(month)] + " " + day + ", " + year + " ";
        
        if (dateFormat == 0) {
            
            date = month + "/" + day + "/" + year + " ";
            if (day == null) {
                
                date = month + "/" + year;
                
            }
            
        } else if (dateFormat == 1) {
            
            date = month + "-" + day + "-" + year + " ";
            if (day == null) {
                
                date = month + "-" + year;
                
            }
            
        } else if (dateFormat == 2) {
            
            date = monthFullName[parseInt(month)] + ", " + day + ", " + year + " ";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + ", " + year;
                
            }
            
        } else if (dateFormat == 3) {
            
            date = day + "/" + month + "/" + year + " ";
            if (day == null) {
                
                date = month + "/" + year;
                
            }
            
        } else if (dateFormat == 4) {
            
            date = day + "-" + month + "-" + year + " ";
            if (day == null) {
                
                date = month + "-" + year;
                
            }
            
        } else if (dateFormat == 5) {
            
            date = day + ", " + monthFullName[parseInt(month)] + ", " + year + " ";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + ", " + year;
                
            }
            
        } else if (dateFormat == 6) {
            
            date = year + "/" + month + "/" + day + " ";
            if (day == null) {
                
                date = year + "/" + month;
                
            }
            
        } else if (dateFormat == 7) {
            
            date = year + "-" + month + "-" + day + " ";
            if (day == null) {
                
                date = year + "-" + month;
                
            }
            
        } else if (dateFormat == 8) {
            
            date = day + "." + month + "." + year + " ";
            if (day == null) {
                
                date = month + "." + year;
                
            }
            
        } else if (dateFormat == 9) {
            
            date = day + "." + month + "." + year + " ";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + ", " + year;
                
            }
            
        } else {
            
        }
        
        if (month == null && day != null && year == null) {
            
            date = day;
            
        }
        
        if (this._positionOfWeek == 'before') {
            
            if (dateFormat != 2 && week != null) {
                
                date = this._i18n.get(weekName[week]) + " " + date;
                
            } else if (dateFormat == 2 && week != null) {
                
                date = this._i18n.get(weekName[week]) + ", " + date;
                
            }
            
        } else {
            
            if (dateFormat != 2 && week != null) {
                
                date = date + " " + this._i18n.get(weekName[week]) + " ";
                
            } else if (dateFormat == 2 && week != null) {
                
                date = date + ", " + this._i18n.get(weekName[week]) + " ";
                
            }
            
        }
        
        
        
        if (hour != null && min != null) {
            
            //date += hour + ":" + min + " ";
            date += i18n.get("%s:%s " + print_am_pm, [hour, min]);
        }
        
        if (title != null) {
            
            date += title;
            
        }
        
        return date;
        
    }
	
	Booking_App_Calendar.prototype.getPrintTime = function(hour, min) {
	    
	    var object = this;
	    var time = hour + ":" + min;
	    if (object._clock == '12a.m.p.m') {
            
            hour = parseInt(hour);
            var print_am_pm = "a.m.";
            if (hour > 12) {
                
                print_am_pm = "p.m.";
                hour -= 12;
                
            } else if (hour == 12) {
                
                print_am_pm = "p.m.";
                hour = 12;
                
            } else if (hour == 0) {
                
                hour = 12;
                
            }
            
            hour = ("0" + hour).slice(-2);
            time = object._i18n.get("%s:%s " + print_am_pm, [hour, min]);
            
        } else if (object._clock == '12ampm') {
            
            hour = parseInt(hour);
            var print_am_pm = "am";
            if (hour > 12) {
                
                print_am_pm = "pm";
                hour -= 12;
                
            } else if (hour == 12) {
                
                print_am_pm = "pm";
                hour = 12;
                
            } else if (hour == 0) {
                
                hour = 12;
                
            }
            
            hour = ("0" + hour).slice(-2);
            time = object._i18n.get("%s:%s " + print_am_pm, [hour, min]);
            
        } else if (object._clock == '12AMPM') {
            
            hour = parseInt(hour);
            var print_am_pm = "AM";
            if (hour > 12) {
                
                print_am_pm = "PM";
                hour -= 12;
                
            } else if (hour == 12) {
                
                print_am_pm = "PM";
                hour = 12;
                
            } else if (hour == 0) {
                
                hour = 12;
                
            }
            
            hour = ("0" + hour).slice(-2);
            time = object._i18n.get("%s:%s " + print_am_pm, [hour, min]);
            
        }
        
	    object._console.log(time);
	    return time;
	    
	    
	}
	
    Booking_App_Calendar.prototype.adjustmentSchedules = function(calendarData, calendarKey, i, courseTime, rejectionTime, preparationTime){
        
        var object = this;
        (function(schedule, key, courseTime, rejectionTime, preparationTime, callback){
            
            object._console.log(key);
            var stopUnixTime = parseInt(schedule[key].unixTime);
            if (schedule[key].stop == 'false') {
                
                stopUnixTime += preparationTime * 60;
                
            }
            object._console.log("stopUnixTime = " + stopUnixTime);
            
            for(var i = 0; i < schedule.length; i++){
                
                var time = parseInt(schedule[i]["hour"]) * 60 + parseInt(schedule[i]["min"]);
                if (time > rejectionTime && i < key) {
                    
                    object._console.log("i = " + i + " hour = " + schedule[i]["hour"] + " min = " + schedule[i]["min"]);
                    callback(i);
                    
                } else if (parseInt(schedule[i].unixTime) <= stopUnixTime && i > key) {
                    
                    object._console.log("i = " + i + " hour = " + schedule[i]["hour"] + " min = " + schedule[i]["min"]);
                    callback(i);
                    
                } else if (parseInt(schedule[i].unixTime) >= stopUnixTime) {
                    
                    break;
                    
                }
                
            }
            
        })(calendarData['schedule'][calendarKey], i, courseTime, rejectionTime, preparationTime, function(key){
            
            object._console.log("callback key = " + key);
            calendarData['schedule'][calendarKey][key]["select"] = false;
            
        });
        
    }
	
    function Booking_App_ObjectsControl(data, booking_package_dictionary) {
        
        this._data = data;
        this._debug = new Booking_Package_Console(data.debug);
        this._console = {};
        this._console.log = this._debug.getConsoleLog();
        this._console.error = this._debug.getConsoleError();
        this._i18n = new I18n(data.locale);
        this._i18n.setDictionary(booking_package_dictionary);
        this._services = data.courseList;
        this._nationalHoliday = {};
        this._weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        this._calendar = new Booking_App_Calendar(this._weekName, this._data.dateFormat, this._data.positionOfWeek, this._data.startOfWeek, this._i18n, this._debug);
        this._expirationDate = 0;
        this._expirationDateForService = 0;
        
    };
    
    Booking_App_ObjectsControl.prototype.setServices = function(services) {
        
        this._services = services;
        
    };
    
    Booking_App_ObjectsControl.prototype.setExpirationDate = function(expirationDate) {
        
        this._expirationDate = expirationDate;
        
    };
    
    Booking_App_ObjectsControl.prototype.getExpirationDate = function() {
        
        return this._expirationDate;
        
    };
    
    Booking_App_ObjectsControl.prototype.setNationalHoliday = function(nationalHoliday) {
        
        this._nationalHoliday = nationalHoliday;
        
    };
    
    Booking_App_ObjectsControl.prototype.validExpirationDate = function(expirationDate, expirationDateFrom, expirationDateTo, name) {
        
        var object = this;
        var isBooking = true;
        if (expirationDateFrom <= expirationDate) {
            
            object._console.error('1 expirationDateFrom = ' + expirationDateFrom + ' ' + name);
            
        }
        
        if (expirationDateTo <= expirationDate) {
            
            object._console.error('1 expirationDateTo = ' + expirationDateTo + ' ' + name);
            
        }
        
        if (expirationDateFrom >= expirationDate) {
            
            object._console.error('2 expirationDateFrom = ' + expirationDateFrom + ' ' + name);
            
        }
        
        if (expirationDateTo >= expirationDate) {
            
            object._console.error('2 expirationDateTo = ' + expirationDateTo + ' ' + name);
            
        }
        
        if (expirationDateFrom != 0 && expirationDateTo != 0 && ((expirationDateFrom <= expirationDate && expirationDateTo < expirationDate) || (expirationDateFrom > expirationDate && expirationDateTo >= expirationDate))) {
            
            isBooking = false;
            
        }
        
        return isBooking;
        
    };
    
    Booking_App_ObjectsControl.prototype.validateServices = function(month, day, year, week, changeSelected, expiration) {
        
        var object = this;
        var isBooking = {status: true, services: {}};
        object._console.log('validateServices');
        object._console.error('expiration = ' + expiration);
        object._console.log(object._services);
        object._console.log('month = ' + month + ' day = ' + day + ' year = ' + year);
        if (month != null && day != null && year != null && week != null) {
            
            var calendarKey = object._calendar.getDateKey(month, day, year);
            object._console.log(object._nationalHoliday[calendarKey]);
            var nationalHoliday = false;
            if (object._nationalHoliday[calendarKey] != null && parseInt(object._nationalHoliday[calendarKey].status) == 1) {
                
                nationalHoliday = true;
                week = 7;
                
            }
            object._console.log('week = ' + week);
            
        } else {
            
            week = null;
            
        }

        //var expirationDate = year + ("0" + month).slice(-2) + ("0" + day).slice(-2);
        var expirationDate = object._calendar.getDateKey(month, day, year);
        if (typeof expirationDate == 'string') {
            
            expirationDate = parseInt(expirationDate);
            
        }
        object._console.log('expirationDate = ' + expirationDate);
        object.setExpirationDate(expirationDate);
        
        for (var key in object._services) {
            
            object._console.log(object._services[key]);
            object._services[key].closed = 0;
            /**
            object._services[key].service = 1;
            object._services[key].selected = 0;
            object._services[key].selectedOptionsList = [];
            **/
            var timeToProvide = object._services[key].timeToProvide;
            if (week != null && timeToProvide != null && 0 < timeToProvide.length) {
                
                var times = timeToProvide[parseInt(week)];
                object._console.log(times);
                var closed = (function(times){
                    
                    var closed = 1;
                    for (var key in times) {
                        
                        var time = parseInt(times[key]);
                        if (time == 1) {
                            
                            closed = 0;
                            break;
                            
                        }
                        
                    }
                    
                    return closed;
                    
                })(times);
                object._services[key].closed = closed;
                object._console.log('closed = ' + closed);
                if (parseInt(object._services[key].selected) == 1 && closed == 1) {
                    
                    if (isBooking.status === true) {
                        
                        isBooking.status = false;
                        
                    }
                    isBooking.services[key] = object._services[key];
                    
                }
                
            }
            
            if (/**(expiration === true || parseInt(object._services[key].selected) == 1) && **/parseInt(object._services[key].expirationDateStatus) == 1) {
                
                var expirationDateFrom = parseInt(object._services[key].expirationDateFrom);
                var expirationDateTo = parseInt(object._services[key].expirationDateTo);
                var expirationDate = object.getExpirationDate();
                object._console.log(expirationDate);
                if (object._services[key].expirationDateTrigger != 'dateBooked') {
                    
                    
                    
                }
                
                if (object.validExpirationDate(expirationDate, expirationDateFrom, expirationDateTo, object._services[key].name) === false) {
                    
                    object._console.error(object._services[key]);
                    if (isBooking.status === true && (expiration === true || parseInt(object._services[key].selected) == 1)) {
                        
                        isBooking.status = false;
                        
                    }
                    object._services[key].closed = 1;
                    isBooking.services[key] = object._services[key];
                    
                }
                /**
                if (expirationDateFrom <= expirationDate) {
                    
                    object._console.error('1 expirationDateFrom = ' + expirationDateFrom + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateTo <= expirationDate) {
                    
                    object._console.error('1 expirationDateTo = ' + expirationDateTo + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateFrom >= expirationDate) {
                    
                    object._console.error('2 expirationDateFrom = ' + expirationDateFrom + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateTo >= expirationDate) {
                    
                    object._console.error('2 expirationDateTo = ' + expirationDateTo + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateFrom != 0 && expirationDateTo != 0 && ((expirationDateFrom <= expirationDate && expirationDateTo < expirationDate) || (expirationDateFrom > expirationDate && expirationDateTo >= expirationDate))) {
                    
                    object._console.error(object._services[key]);
                    if (isBooking.status === true && (expiration === true || parseInt(object._services[key].selected) == 1)) {
                        
                        isBooking.status = false;
                        
                    }
                    object._services[key].closed = 1;
                    isBooking.services[key] = object._services[key];
                    
                }
                **/
                
            }
            
        }
        
        if (isBooking.status === false && changeSelected === true) {
            
            for (var key in object._services) {
                
                object._services[key].selected = 0;
                var checkBox = document.getElementById('service_checkBox_' + key);
                if (checkBox != null) {
                    
                    checkBox.checked = false;
                    
                }
                
            }
            
        }
        
        return isBooking;
        
    };
    
    function FORMAT_COST(i18n, debug) {
    	
    	this._i18n = null;
        if(typeof i18n == 'object'){
            
            this._i18n = i18n;
            
        }
        
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._console.log = debug.getConsoleLog();
            
        }
        
    }
	
	FORMAT_COST.prototype.formatCost = function(cost, currency){
        
        var object = this;
        var format = function(cost){
            
            cost = String(cost).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
            return cost;
            
        }
        
        if (currency.toLocaleUpperCase() == 'USD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "US$" + cost;
            
        } else if (currency.toLocaleUpperCase() == "EUR") {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "€" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'JPY') {
            
            cost = format(cost);
            cost = "¥" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'HUF') {
            
            cost = format(cost);
            cost = "HUF " + cost;
            
        } else if (currency.toLocaleUpperCase() == 'DKK') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost) + "kr";
            
        } else if (currency.toLocaleUpperCase() == "CNY") {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "CN¥" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'TWD') {
            
            cost = Number(cost) / 100;
            cost = format(cost);
            cost = "NT$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'THB') {
            
            cost = format(cost);
            cost = "TH฿" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'COP') {
            
            cost = format(cost);
            cost = "COP" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'CAD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'AUD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'GBP') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "£" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'PHP') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "PHP " + cost;
            
        } else if (currency.toLocaleUpperCase() == 'CHF') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "CHF " + cost;
            
        } else if (currency.toLocaleUpperCase() == 'CZK') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "Kč" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'RUB') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = cost + "₽";
            
        } else if (currency.toLocaleUpperCase() == 'NZD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = "NZ$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'HRK') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = cost + " Kn";
            
        } else if (currency.toLocaleUpperCase() == 'UAH') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost);
            cost = cost + "грн.";
            
        }
        
        object._console.log("currency = " + currency + " cost = " + cost);
        return cost;
        
    }
    
    function TAXES(i18n, currency, debug) {
        
        this._i18n = null;
        this._applicantCount = 1;
        this._currency = currency;
        this._taxes = [];
        this._visitorsDetails = {};
        if(typeof i18n == 'object'){
            
            this._i18n = i18n;
            
        }
        
        this._debug = null;
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._debug = debug;
            this._console.log = debug.getConsoleLog();
            
        }
        
    }
    
    TAXES.prototype.setApplicantCount = function(applicantCount) {
        
        this._applicantCount = parseInt(applicantCount);
        this._console.log('_applicantCount = ' + this._applicantCount);
        
    }
    
    TAXES.prototype.setTaxes = function(taxes) {
        
        this._taxes = taxes;
        
    }
    
    TAXES.prototype.getTaxes = function() {
        
        return this._taxes;
        
    }
    
    TAXES.prototype.setVisitorsDetails = function(visitorsDetails) {
        
        this._visitorsDetails = visitorsDetails;
        
    }
    
    TAXES.prototype.getVisitorsDetails = function() {
        
        return this._visitorsDetails;
        
    }
    
    TAXES.prototype.getTaxValue = function(taxKey, type, visitorsDetails) {
        
        var object = this;
        object._console.log(visitorsDetails);
        var taxes = this._taxes;
        if (taxes[taxKey] == null) {
            
            return 0;
            
        } else {
            
            var tax = taxes[taxKey];
            var taxValue = 0;
            object._console.log(tax);
            var value = parseInt(tax.value);
            if (tax.method == 'multiplication') {
                
                value = parseFloat(tax.value);
                
            }
            
            object._console.log(value);
            
            if (type == 'day') {
                
                if (tax.method == 'multiplication') {
					
					taxValue =  (tax.value / 100) * visitorsDetails.amount;
					if (tax.tax == 'tax_inclusive') {
						
						taxValue = visitorsDetails.amount * (parseInt(tax.value) / (100 + parseInt(tax.value)));
						taxValue = Math.floor(taxValue);
						
					}
					tax.taxValue = taxValue;
					
				} else {
					
					tax.taxValue = parseInt(tax.value);
					taxValue = parseInt(tax.value);
					
				}
                
            } else if (type == 'hotel') {
                
                var applicantCount = object._applicantCount;
                var person = 0;
                var additionalFee = 0;
                var rooms = visitorsDetails.rooms;
                for (var roomKey in visitorsDetails.rooms) {
                    
                    var room = visitorsDetails.rooms[roomKey];
                    person += room.person;
                    additionalFee += room.additionalFee;
                    
                }
                
                if (tax.target == 'room') {
                    
                    if (tax.scope == 'day') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = (visitorsDetails.nights * applicantCount) * value;
                            
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * ((visitorsDetails.amount * applicantCount) + (additionalFee * visitorsDetails.nights));
                            if (tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                                
                                var amount = 0;
                                for (var i in visitorsDetails.list) {
                                    
                                    amount += parseInt(visitorsDetails.list[i].cost) * applicantCount;
                                    
                                }
                                /**
                                if (visitorsDetails.additionalFee > 0) {
                                    
                                    taxValue = (amount + (additionalFee * visitorsDetails.nights)) * (value / (100 + value));
                                    
                                }
                                **/
                                taxValue = (amount + (additionalFee * visitorsDetails.nights)) * (value / (100 + value));
                                taxValue = Math.floor(taxValue);
                                
                            }
                            
                        }
                        
                    } else if (tax.scope == 'booking') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = applicantCount * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * applicantCount;
                            
                        }
                        
                    } else if (tax.scope == 'bookingEachGuests') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = person * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * person;
                            
                        }
                        
                    }
                    
                    if (tax.method == 'addition' && tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                        
                        visitorsDetails.amount -= taxValue;
                        
                    }
                    
                } else if (tax.target == 'guest') {
                    
                    if (tax.scope == 'day') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = (visitorsDetails.nights * person) * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * additionalFee;
                            if (tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                                
                                taxValue = additionalFee * (value / (100 + value));
                                taxValue = Math.floor(taxValue);
                                
                            }
                            
                        }
                        
                    } else if (tax.scope == 'booking') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = 1 * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * 1;
                            
                        }
                        
                    } else if (tax.scope == 'bookingEachGuests') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = person * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * person;
                            
                        }
                        
                    }
                    
                }
                
            }
            
            return taxValue;
            
        }
        
    }
    
    TAXES.prototype.taxesDetails = function(amount, formPanel, surchargePanel, taxePanel) {
        
        var object = this;
        var currency = this._currency
        var taxes = this._taxes;
        var surchargeList = [];
        var taxList = [];
        var visitorsDetails = {amount: amount, additionalFee: 0, nights: 0, person: 0, list: []};
        for (var key in taxes) {
            
            var tax = taxes[key];
            if (tax.active != 'true') {
                
                continue;
                
            }
            
            var taxValue = this.getTaxValue(key, 'day', visitorsDetails);
            object._console.log("name = " + tax.name + " taxValue = " + taxValue);
            if (tax.type == 'surcharge') {
                
                surchargeList.push(tax);
                
            } else {
                
                taxList.push(tax);
                
            }
            
        }
        
        var format = new FORMAT_COST(this._i18n, this._debug);
        if(surchargeList.length > 0 || taxList.length > 0) {
            
            var namePanel = surchargePanel.getElementsByClassName("name")[0];
            if(surchargeList.length > 0 && taxList.length > 0) {
                
                namePanel.textContent = this._i18n.get("Surcharge and Tax");
                namePanel.classList.add("surcharge_and_tax");
                
            } else if(surchargeList.length > 0 && taxList.length == 0) {
                
                namePanel.textContent = this._i18n.get("Surcharge");
                namePanel.classList.add("surcharge");
                
            } else if(surchargeList.length == 0 && taxList.length > 0) {
                
                namePanel.textContent = this._i18n.get("Tax");
                namePanel.classList.add("tax");
                
            }
            
            var valuePanel = surchargePanel.getElementsByClassName("value")[0];
            valuePanel.textContent = null;
            for (var i = 0; i < surchargeList.length; i++) {
                
                var surcharge = surchargeList[i];
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("planName");
                nameSpan.textContent = surcharge.name;
                
                var costSpan = document.createElement("span");
                costSpan.classList.add("planPrice");
                if (parseInt(surcharge.taxValue) > 0) {
                    
                    costSpan.textContent = format.formatCost(surcharge.taxValue, currency);
                    
                }
                
                
                var addPanel = document.createElement("div");
                addPanel.classList.add("mainPlan");
                addPanel.appendChild(nameSpan);
                addPanel.appendChild(costSpan);
                valuePanel.appendChild(addPanel);
                formPanel.appendChild(surchargePanel);
                
            }
            
            for (var i = 0; i < taxList.length; i++) {
                
                var surcharge = taxList[i];
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("planName");
                nameSpan.textContent = surcharge.name;
                
                var costSpan = document.createElement("span");
                costSpan.classList.add("planPrice");
                if (parseInt(surcharge.taxValue) > 0) {
                    
                    costSpan.textContent = format.formatCost(surcharge.taxValue, currency);
                    
                }
                
                
                var addPanel = document.createElement("div");
                addPanel.classList.add("mainPlan");
                addPanel.appendChild(nameSpan);
                addPanel.appendChild(costSpan);
                valuePanel.appendChild(addPanel);
                formPanel.appendChild(surchargePanel);
                
            }
            
        }
        /**
        if(surchargeList.length > 0) {
            
            var valuePanel = surchargePanel.getElementsByClassName("value")[0];
            valuePanel.textContent = null;
            for (var i = 0; i < surchargeList.length; i++) {
                
                var surcharge = surchargeList[i];
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("planName");
                nameSpan.textContent = surcharge.name;
                
                var costSpan = document.createElement("span");
                costSpan.classList.add("planPrice");
                if (parseInt(surcharge.taxValue) > 0) {
                    
                    costSpan.textContent = format.formatCost(surcharge.taxValue, currency);
                    
                }
                
                
                var addPanel = document.createElement("div");
                addPanel.classList.add("mainPlan");
                addPanel.appendChild(nameSpan);
                addPanel.appendChild(costSpan);
                valuePanel.appendChild(addPanel);
                formPanel.appendChild(surchargePanel);
                
            }
            
        }
        
        if(taxList.length > 0) {
            
            var valuePanel = taxePanel.getElementsByClassName("value")[0];
            valuePanel.textContent = null;
            for (var i = 0; i < taxList.length; i++) {
                
                var surcharge = taxList[i];
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("planName");
                nameSpan.textContent = surcharge.name;
                
                var costSpan = document.createElement("span");
                costSpan.classList.add("planPrice");
                if (parseInt(surcharge.taxValue) > 0) {
                    
                    costSpan.textContent = format.formatCost(surcharge.taxValue, currency);
                    
                }
                
                
                var addPanel = document.createElement("div");
                addPanel.classList.add("mainPlan");
                addPanel.appendChild(nameSpan);
                addPanel.appendChild(costSpan);
                valuePanel.appendChild(addPanel);
                formPanel.appendChild(taxePanel);
                
            }
            
        }
        **/
        
    }
    
    function Booking_Package_Console(debug) {
        
        this._debug = parseInt(debug);
        this._consoleExt = {};
        this._consoleExt.originalConsoleLog = console.log;
        this._console = {};
        this._console.log = console.log;
        this._console.error = console.error;
        if (this._debug == 0) {
            
            //console.log = function(message){};
            
        }
        
    }
    
    Booking_Package_Console.prototype.getConsoleLog = function() {
        
        if (this._debug == 0) {
            
            this._console.log = function(message){};
            
        }
        
        return this._console.log;
        
    }
    
    Booking_Package_Console.prototype.getConsoleError = function() {
        
        if (this._debug == 0) {
            
            this._console.error = function(message){};
            
        }
        
        return this._console.error;
        
    }
	
	