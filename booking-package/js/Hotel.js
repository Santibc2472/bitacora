    function Booking_Package_Hotel(currency, weekName, dateFormat, positionOfWeek, startOfWeek, booking_package_dictionary, debug) {
        
        this._debug = null;
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._debug = debug;
            this._console.log = debug.getConsoleLog();
            
        }
        
        this._dayPanelList = {};
        this._currency = currency;
        this._callback = null;
        this._calendarAccount = null;
        this._checkDate = {checkIn: null, checkOut: null};
        this._scheduleKeys = {checkInKey: null, checkOutKey: null};
        this._scheduleList = {};
        this._guestsList = {};
        this._rooms = {};
        this._roomNumber = [];
        this._person = 0;
        this._startOfWeek = startOfWeek;
        this._feeList = {bookingFee: 0, additionalFee: 0};
        this._taxes = [];
        this._i18n = new I18n(booking_package_dictionary);
        this._i18n.setDictionary(booking_package_dictionary);
        this._calendar = new Booking_App_Calendar(weekName, dateFormat, positionOfWeek, startOfWeek, this._i18n, this._debug);
        
        this._responseGuests = {status: false, person: 0, amount: 0, list: null};
        this._responseGuests = {status: false, booking: false, amount: 0, message: null, list: null, nights: 0, person: 0, additionalFee: 0, guests: false, requiredGuests: true, guestsList: null, adult: 0, children: 0, vacancy: 0, checkInKey: null, checkOutKey: null, taxes: {}, rooms: {}};
        
    }
    
    Booking_Package_Hotel.prototype.setCallback = function(callback){
        
        this._callback = callback;
        
    }
    
    Booking_Package_Hotel.prototype.reset = function(){
        
        this._dayPanelList = {};
        this._guestsList = {};
        this._rooms = {};
        this._roomNumber = [];
        this._scheduleList = {};
        this._checkDate = {checkIn: null, checkOut: null};
        this._scheduleKeys = {checkInKey: null, checkOutKey: null};
        this._feeList = {bookingFee: 0, additionalFee: 0};
        this._responseGuests = {status: false, booking: false, amount: 0, message: null, list: null, nights: 0, person: 0, additionalFee: 0, guests: false, requiredGuests: true, guestsList: null, adult: 0, children: 0, vacancy: 0, checkInKey: null, checkOutKey: null, taxes: {}, rooms: {}};
        
    }
    
    Booking_Package_Hotel.prototype.setCalendarAccount = function(calendarAccount){
        
        this._calendarAccount = calendarAccount;
        
    }
    
    Booking_Package_Hotel.prototype.resetCheckDate = function(){
        
        this._checkDate = {checkIn: null, checkOut: null};
        this._scheduleKeys = {checkInKey: null, checkOutKey: null};
        
    }
    
    Booking_Package_Hotel.prototype.setTaxes = function(taxes) {
        
        this._taxes = taxes;
        
    }
    
    Booking_Package_Hotel.prototype.getTaxes = function() {
        
        return this._taxes;
        
    }
    
    Booking_Package_Hotel.prototype.getCheckDate = function(){
        
        return this._checkDate;
        
    }
    
    Booking_Package_Hotel.prototype.setCheckIn = function(schedule){
        
        this._checkDate.checkIn = schedule;
        
    }
    
    Booking_Package_Hotel.prototype.setCheckOut = function(schedule){
        
        this._checkDate.checkOut = schedule;
        this._console.log(this._checkDate);
        
    }
    
    Booking_Package_Hotel.prototype.setCheckInKey = function(key){
        
        this._scheduleKeys.checkInKey = key;
        
    }
    
    Booking_Package_Hotel.prototype.setCheckOutKey = function(key){
        
        this._scheduleKeys.checkOutKey = key;
        
    }
    
    Booking_Package_Hotel.prototype.setNights = function(nights){
        
        this._responseGuests.nights = nights;
        
    }
    
    Booking_Package_Hotel.prototype.addSchedule = function(schedule){
        
        this._scheduleList[schedule.unixTime] = schedule;
        
    }
    
    Booking_Package_Hotel.prototype.setSchedule = function(scheduleList){
        
        for(var key in scheduleList){
            
            this._console.log(scheduleList[key]);
            
        }
        
    }
    
    Booking_Package_Hotel.prototype.getSchedule = function(){
        
        return this._scheduleList;
        
    }
    
    Booking_Package_Hotel.prototype.getDetails = function(){
        
        return this._responseGuests;
        
    };
    
    Booking_Package_Hotel.prototype.getNewRoomNumber = function(){
        
        var maxNumber = this._roomNumber.reduce(function (a, b) {
            return Math.max(a, b);
        });
        return maxNumber + 1;
        
    };
    
    Booking_Package_Hotel.prototype.addedRoom = function() {
        
        var object = this;
        object._callback(object._responseGuests);
        
    };
    
    Booking_Package_Hotel.prototype.getRoom = function(roomNo) {
        
        return this._rooms[roomNo];
        
    };
    
    Booking_Package_Hotel.prototype.deleteRoom = function(roomNo) {
        
        var object = this;
        delete(object._rooms[roomNo]);
        delete(object._responseGuests.rooms[roomNo]);
        var applicantCount = Object.keys(object._rooms).length;
        object._responseGuests.applicantCount = applicantCount;
        object._console.log(object._rooms);
        object._console.log(object._responseGuests);
        object._callback(object._responseGuests);
        return object._rooms;
        
    }
    
    Booking_Package_Hotel.prototype.pushCallback = function(){
        
        this._callback(this._responseGuests);
        
    }
    
    Booking_Package_Hotel.prototype.setDayPanelList = function(list){
        
        this._dayPanelList = list;
        
    }
    
    Booking_Package_Hotel.prototype.getDayPanelList = function(){
        
        return this._dayPanelList;
        
    }
    
    Booking_Package_Hotel.prototype.verifyGuestsInRooms = function() {
        
        var object = this;
        var rooms = object._responseGuests.rooms;
        object._console.log('verifyGuestsInRooms');
        var response = {booking: true, requiredGuests: true, rooms: {}};
        for (var roomKey in rooms) {
            
            var room = rooms[roomKey];
            var roomStatus = {requiredGuests: true, booking: true, adult: room.adult, children: room.children, person: room.person};
            if (room.requiredGuests === false) {
                
                roomStatus.requiredGuests = false;
                response.requiredGuests = false;
                
            }
            
            if (room.booking === false) {
                
                roomStatus.booking = false;
                response.booking = false;
                
            }
            response.rooms[parseInt(roomKey)] = roomStatus;
            
        }
        object._responseGuests.requiredGuests = response.requiredGuests;
        object._responseGuests.booking = response.booking;
        object._console.log(response);
        object._console.log(object._responseGuests);
        return response;
        
    };
    
    Booking_Package_Hotel.prototype.verifySchedule = function(verification){
        
        //var response = {status: false, amount: 0, message: null, list: null, nights: 0, person: 0, additionalFee: 0, guestsList: null, guests: false};
        var object = this;
        var checkIn = this._checkDate.checkIn;
        var checkOut = this._checkDate.checkOut;
        var scheduleList = this._scheduleList;
        object._console.log(object._calendarAccount);
        var maximumNights = parseInt(object._calendarAccount.maximumNights);
        var minimumNights = parseInt(object._calendarAccount.minimumNights);
        
        object._console.log(object._calendarAccount);
        object._console.log("verification = " + verification);
        object._console.log(Object.keys(this._guestsList).length);
        object._console.log(this._checkDate);
        object._console.log('maximumNights = ' + maximumNights);
        object._console.log('minimumNights = ' + minimumNights);
        if (Object.keys(this._guestsList).length > 0) {
            
            this._responseGuests.guests = true;
            
        } else {
            
            this._responseGuests.booking = true;
            
        }
        
        object._console.log(this._responseGuests);
        this._responseGuests.amount = 0;
        if (checkIn == null || checkOut == null) {
            
            this._responseGuests.status = false;
            this._responseGuests.list = null;
            this._responseGuests.nights = 0;
            this._responseGuests.checkInKey = null;
            this._responseGuests.checkOutKey = null;
            if (this._callback != null) {
                
                this._callback(this._responseGuests);
                
            }
            return this._responseGuests;
            
        }
        
        object._console.log(scheduleList);
        var vacancyList = [];
        var list = {};
        for (var key in scheduleList) {
            
            var schedule = scheduleList[key];
            if (parseInt(checkIn.unixTime) <= parseInt(schedule.unixTime) && parseInt(checkOut.unixTime) > parseInt(schedule.unixTime) && verification == true) {
                
                object._console.log(schedule);
                this._responseGuests.amount += parseInt(schedule.cost);
                list[key] = schedule;
                vacancyList.push(schedule.remainder);
                if ((schedule.stop == "true" || parseInt(schedule.remainder) <= 0) && verification == true) {
                    
                    this._checkDate.checkOut = null;
                    this._responseGuests.status = false;
                    this._responseGuests.amount = 0;
                    this._responseGuests.list = null;
                    this._responseGuests.nights = 0;
                    this._responseGuests.checkInKey = null;
                    this._responseGuests.checkOutKey = null;
                    this._responseGuests.taxes = {};
                    return this._responseGuests;
                    
                }
                
            } else if (verification == false) {
                
                object._console.log(schedule);
                this._responseGuests.amount += parseInt(schedule.cost);
                list[key] = schedule;
                vacancyList.push(schedule.remainder);
                
            }
            
        }
        
        object._console.log(list);
        object._console.log(vacancyList);
        var vacancy = vacancyList.reduce(function (a, b) {
            return Math.min(a, b);
        });
        object._console.log(vacancy);
        
        if (
            (minimumNights > 0 && minimumNights > Object.keys(list).length) ||
            (maximumNights > 0 && maximumNights < Object.keys(list).length)
        ) {
            
            object._console.log('nights = ' + Object.keys(list).length);
            this._responseGuests.status = false;
            this._responseGuests.list = null;
            this._responseGuests.nights = 0;
            this._responseGuests.checkOutKey = null;
            this._responseGuests.vacancy = parseInt(vacancy);
            if (this._callback != null) {
                
                this._callback(this._responseGuests);
                
            }
            return this._responseGuests;
            
        }
        
        var schedulekeys = this._scheduleKeys;
        this._responseGuests.list = list;
        this._responseGuests.nights = Object.keys(list).length;
        this._responseGuests.status = true;
        this._responseGuests.checkInKey = schedulekeys.checkInKey;
        this._responseGuests.checkOutKey = schedulekeys.checkOutKey;
        this._responseGuests.vacancy = parseInt(vacancy);
        if (this._responseGuests.applicantCount == null) {
            
            this._responseGuests.applicantCount = 1;
            
        }
        /**
        response.booking = this._responseGuests.booking;
        response.person = this._responseGuests.person;
        response.guestsList = this._responseGuests.guestsList;
        response.adult = this._responseGuests.adult;
        response.children = this._responseGuests.children;
        response.additionalFee = this._responseGuests.amount;
        this._responseGuests = response;
        **/
        //this._responseGuests = {status: false, person: 0, amount: 0, list: null};
        this._feeList.bookingFee = this._responseGuests.amount;
        if (this._callback != null) {
            
            this._callback(this._responseGuests);
            
        }
        
        return this._responseGuests;
        
    }
    
    Booking_Package_Hotel.prototype.getFeeList = function(){
        
        return this._feeList;
        
    }
    
    Booking_Package_Hotel.prototype.addGuests = function(key, guests, room){
        
        this._guestsList[key] = guests;
        /** Rooms **/
        if (this._rooms[room] == null) {
            
            this._rooms[room] = {};
            
        }
        this._roomNumber.push(room);
        this._rooms[room][key] = guests;
        this._console.log('room = ' + room);
        this._console.log(this._rooms);
        /** Rooms **/
        
    }
    
    Booking_Package_Hotel.prototype.getGuestsList = function(){
        
        return this._guestsList;
        
    }
    
    Booking_Package_Hotel.prototype.updateSelectedGuests = function(guestKey, index, room, setGuestsBool) {
        
        var object = this;
        object._console.log('updateSelectedGuests');
        object._console.log('guestKey = ' + guestKey + ' index = ' + index + ' room = ' + room);
        var guestsList = object.getRoom(room);
        var list = JSON.parse(guestsList[guestKey].json);
        if (typeof guestsList[guestKey].json == 'string') {
            
            list = JSON.parse(guestsList[guestKey].json);
            
        }
        /**
        for (var key in list) {
            
            if (typeof list[key].selected == 'string') {
                
                delete(list[key].selected);
                
            }
            
        }
        **/
        var selectedGuest = list[index];
        guestsList[guestKey].index = index;
        guestsList[guestKey].person = parseInt(selectedGuest.number);
        object._console.log(selectedGuest);
        object._console.log(guestsList[guestKey]);
        if (setGuestsBool === true) {
            
            var response = object.setGuests(guestKey, index, selectedGuest.number, room);
            return response;
            
        } else {
            
            return guestsList[guestKey];
            
        }
        
    }
    
    Booking_Package_Hotel.prototype.setGuests = function(key, index, person, room){
        
        var object = this;
        object._console.log("key " + key + " index = " + index + " person = " + person + " room = " + room);
        object._console.log(this._calendarAccount);
        object._console.log(this._guestsList);
        object._console.log(this._rooms);
        /**
        var response = {status: false, person: 0, amount: 0, list: null};
        this._responseGuests = response;
        **/
        if (this._guestsList[key] != null) {
            
            this._guestsList[key].index = parseInt(index);
            this._guestsList[key].person = parseInt(person);
            object._console.log(this._guestsList);
            //var guests = [];
            var requiredGuests = true;
            var applicantCount = 1;
            var guests = {};
            var adult = 0;
            var children = 0;
            var amount = 0;
            var person = 0;
            
            /** Rooms **/
            var details = {booking: false, requiredGuests: true, guests: {}, adult: 0, children: 0, amount: 0, additionalFee: 0, person: 0};
            applicantCount = Object.keys(object._rooms).length;
            object._console.log('applicantCount = ' + applicantCount);
            var guestsList = object._rooms[room];
            for (var key in guestsList) {
                
                object._console.log(guestsList[key]);
                //var list = JSON.parse(this._guestsList[key].json);
                var list = guestsList[key].json;
                if (typeof guestsList[key].json == 'string') {
                    
                    list = JSON.parse(guestsList[key].json);
                    
                }
                var index = parseInt(guestsList[key].index);
                details.guests[guestsList[key].key] = list[index];
                details.amount += parseInt(list[index].price);
                details.additionalFee += parseInt(list[index].price);
                details.person += parseInt(guestsList[key].person);
                
                if (parseInt(guestsList[key].required) == 1 && guestsList[key].index == 0) {
                    
                    details.requiredGuests = false;
                    
                }
                
                if (guestsList[key].target == 'adult') {
                    
                    details.adult += parseInt(guestsList[key].person);
                    
                } else {
                    
                    details.children += parseInt(guestsList[key].person);
                    
                }
                
                var totalPerson = details.adult;
                if (parseInt(this._calendarAccount.includeChildrenInRoom) == 1) {
                    
                    totalPerson += details.children;
                    
                }
                object._console.log("totalPerson = " + totalPerson);
                
                if (totalPerson > 0 && totalPerson <= parseInt(this._calendarAccount.numberOfPeopleInRoom)) {
                    
                    details.booking = true;
                    
                } else {
                    
                    details.booking = false;
                    
                }
                
            }
            /** Rooms **/
            
            
            
            
            for(var key in this._guestsList){
                
                object._console.log(this._guestsList[key]);
                //var list = JSON.parse(this._guestsList[key].json);
                var list = this._guestsList[key].json;
                if(typeof this._guestsList[key].json == 'string'){
                    
                    list = JSON.parse(this._guestsList[key].json);
                    
                }
                var index = parseInt(this._guestsList[key].index);
                //guests.push(list[index]);
                guests[this._guestsList[key].key] = list[index];
                amount += parseInt(list[index].price);
                person += parseInt(this._guestsList[key].person);
                
                if(parseInt(this._guestsList[key].required) == 1 && this._guestsList[key].index == 0){
                    
                    requiredGuests = false;
                    
                }
                
                if(this._guestsList[key].target == 'adult'){
                    
                    adult += parseInt(this._guestsList[key].person);
                    
                }else{
                    
                    children += parseInt(this._guestsList[key].person);
                    
                }
                
            }
            
            //var list = this._responseGuests.list;
            var totalPerson = adult;
            if (parseInt(this._calendarAccount.includeChildrenInRoom) == 1) {
                
                totalPerson += children;
                
            }
            object._console.log("totalPerson = " + totalPerson);
            
            if (totalPerson > 0 && totalPerson <= parseInt(this._calendarAccount.numberOfPeopleInRoom)) {
                
                this._responseGuests.booking = true;
                
            } else {
                
                this._responseGuests.booking = false;
                
            }
            
            this._responseGuests.status = true;
            this._responseGuests.applicantCount = applicantCount;
            this._responseGuests.requiredGuests = requiredGuests;
            this._responseGuests.additionalFee = amount;
            this._responseGuests.person = person;
            this._responseGuests.guestsList = guests;
            this._responseGuests.rooms[room] = details;
            this._responseGuests.adult = adult;
            this._responseGuests.children = children;
            this._feeList.additionalFee = 0;
            for (var roomKey in this._responseGuests.rooms) {
                
                var room = this._responseGuests.rooms[roomKey];
                this._feeList.additionalFee += room.additionalFee;
                
            }
            
            object._console.log(this._calendarAccount);
            object._console.log(this._responseGuests);
            object._console.log(this._feeList);
            object._console.log(this._responseGuests);
            
            return this._responseGuests;
            
        }else{
            
            this._responseGuests.status = false;
            return this._responseGuests;
            
        }
        
    }
    
    Booking_Package_Hotel.prototype.showSummary = function(summaryListPanel, expressionsCheck){
        
        var object = this;
        object._calendar.setShortWeekNameBool(true);
        
        var format = new FORMAT_COST(object._i18n, object._debug);
        
        var visitorsDetails = this._responseGuests;
        summaryListPanel.textContent = null;
        object._console.log(summaryListPanel);
        object._console.log(visitorsDetails);
        object._console.log(object._guestsList);
        
        if (expressionsCheck != null && typeof expressionsCheck == 'object') {
            
            object._console.log(expressionsCheck);
            var checkDate = object.getCheckDate();
            object._console.log(checkDate);
            
            var checkInTitlePanel = document.createElement("div");
            checkInTitlePanel.classList.add("summaryTitle");
            checkInTitlePanel.textContent = expressionsCheck.arrival + " :";
            summaryListPanel.insertAdjacentElement("beforeend", checkInTitlePanel);
            
            var checkInValuePanel = document.createElement("div");
            var checkInValue = object._i18n.get("None");
            if (checkDate.checkIn != null) {
                
                checkInValue = object._calendar.formatBookingDate(checkDate.checkIn.month, checkDate.checkIn.day, checkDate.checkIn.year, null, null, null, checkDate.checkIn.weekKey);
                
            }
            checkInValuePanel.textContent = checkInValue;
            checkInValuePanel.classList.add("summaryValue");
            summaryListPanel.insertAdjacentElement("beforeend", checkInValuePanel);
            
            var checkOutTitlePanel = document.createElement("div");
            checkOutTitlePanel.classList.add("summaryTitle");
            checkOutTitlePanel.textContent = expressionsCheck.departure + " :";
            summaryListPanel.insertAdjacentElement("beforeend", checkOutTitlePanel);
            
            var checkOutValuePanel = document.createElement("div");
            var checkOutValue = object._i18n.get("None");
            if (checkDate.checkOut != null) {
                
                checkOutValue = object._calendar.formatBookingDate(checkDate.checkOut.month, checkDate.checkOut.day, checkDate.checkOut.year, null, null, null, checkDate.checkOut.weekKey);
                
            }
            checkOutValuePanel.textContent = checkOutValue;
            checkOutValuePanel.classList.add("summaryValue");
            summaryListPanel.insertAdjacentElement("beforeend", checkOutValuePanel);
            
        }
        
        var amount = visitorsDetails.amount * visitorsDetails.applicantCount;
        
        var nightsValue = document.createElement("div");
        nightsValue.classList.add("summaryValue");
        nightsValue.classList.add("totalLengthOfStayLabel");
        nightsValue.textContent = visitorsDetails.nights + " " + object._i18n.get("nights") + " (" + format.formatCost(amount, object._currency) + ")";
        if (visitorsDetails.nights == 1) {
            
            nightsValue.textContent = visitorsDetails.nights + " " + object._i18n.get("night") + " (" + format.formatCost(amount, object._currency) + ")";
            if (amount == 0) {
                
                nightsValue.textContent = visitorsDetails.nights + " " + object._i18n.get("nights");
                
            }
            
            
        } else if (visitorsDetails.nights == 0) {
            
            nightsValue.classList.remove("totalLengthOfStayLabel");
            nightsValue.textContent = "No past schedule was found";
            
        }
        
        var totalLengthOfStay = document.createElement("div");
        totalLengthOfStay.classList.add("summaryTitle");
        totalLengthOfStay.textContent = object._i18n.get("Total length of stay") + " :";
        summaryListPanel.insertAdjacentElement("beforeend", totalLengthOfStay);
        summaryListPanel.insertAdjacentElement("beforeend", nightsValue);
        
        
        var scheduleListPanel = document.createElement("div");
        scheduleListPanel.classList.add("hidden_panel");
        scheduleListPanel.classList.add("list");
        summaryListPanel.appendChild(scheduleListPanel);
        for (var key in visitorsDetails.list) {
            
            var schedule = visitorsDetails.list[key];
            var date = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, null, null, null, schedule.weekKey);
            object._console.log(date);
            var schedulePanel = document.createElement("div");
            schedulePanel.classList.add("stayAndGuestsPanel");
            if (schedule.cost == 0) {
                
                schedulePanel.textContent = date;
                if (visitorsDetails.applicantCount > 1) {
                    
                    schedulePanel.textContent = date.trim() + ': ' + visitorsDetails.applicantCount + ' ' + object._i18n.get('Rooms');
                    
                }
                
            } else {
                
                schedulePanel.textContent = date.trim() + ": " + format.formatCost(schedule.cost, object._currency);
                if (visitorsDetails.applicantCount > 1) {
                    
                    schedulePanel.textContent = date.trim() + ": " + format.formatCost((schedule.cost * visitorsDetails.applicantCount), object._currency) + ' (' + format.formatCost(schedule.cost, object._currency) + ' * ' + visitorsDetails.applicantCount+ ' ' + object._i18n.get('Rooms') + ')';
                    
                }
                
            }
            scheduleListPanel.insertAdjacentElement("beforeend", schedulePanel);
            
        }
        
        var showTotalLengthOfStay = false;
        nightsValue.onclick = function(){
            
            if (showTotalLengthOfStay == false) {
                
                scheduleListPanel.classList.remove("hidden_panel");
                showTotalLengthOfStay = true;
                
            } else {
                
                scheduleListPanel.classList.add("hidden_panel");
                showTotalLengthOfStay = false;
            }
            
            
        }
        
        var amountPerson = 0;
        var additionalFee = 0;
        var rooms = visitorsDetails.rooms;
        for (var roomKey in rooms) {
            
            var room = rooms[roomKey];
            amountPerson += room.person;
            additionalFee += room.additionalFee;
            
        }
        
        if (amountPerson > 0) {
            
            var person = amountPerson + " " + object._i18n.get("person");
            if (amountPerson > 1) {
                
                person = amountPerson + " " + object._i18n.get("people");
                
            }
            
            if (additionalFee > 0) {
                
                person += " (" + format.formatCost((additionalFee * visitorsDetails.nights), object._currency) + ")";
                
            }
            
            var personPanel = document.createElement("label");
            personPanel.classList.add("summaryValue");
            personPanel.classList.add("totalLengthOfStayLabel");
            personPanel.textContent = person;
            
            var totalNumberOfGuestsPanel = document.createElement("div");
            totalNumberOfGuestsPanel.classList.add("summaryTitle");
            totalNumberOfGuestsPanel.textContent = object._i18n.get("Total number of guests") + " :";
            summaryListPanel.insertAdjacentElement("beforeend", totalNumberOfGuestsPanel);
            summaryListPanel.insertAdjacentElement("beforeend", personPanel);
            
            
            var totalGuests = [];
            var guestsListPanel = document.createElement("div");
            guestsListPanel.classList.add("hidden_panel");
            guestsListPanel.classList.add("list");
            summaryListPanel.appendChild(guestsListPanel);
            
            /** Rooms **/
            object._console.log(Object.keys(visitorsDetails.rooms).length);
            var multipleRooms = false;
            if (Object.keys(visitorsDetails.rooms).length > 1) {
                
                multipleRooms = true;
                
            }
            object._console.log('multipleRooms = ' + multipleRooms);
            var roomNumber = 0;
            for (var roomKey in visitorsDetails.rooms) {
                
                roomNumber++;
                if (multipleRooms === true) {
                    
                    var roomNumberPanel = document.createElement('div');
                    roomNumberPanel.classList.add("stayAndGuestsPanel");
                    roomNumberPanel.textContent = object._i18n.get('Room') + ': ' + roomNumber;
                    guestsListPanel.insertAdjacentElement("beforeend", roomNumberPanel);
                    
                }
                
                var room = visitorsDetails.rooms[roomKey];
                for (var key in object._guestsList) {
                    
                    var guests = object._guestsList[key];
                    object._console.log(guests);
                    var list = this._guestsList[key].json;
                    if (typeof guests.json == 'string') {
                        
                        list = JSON.parse(guests.json);
                        
                    }
                    
                    if (room.guests[guests.key] != null && parseInt(room.guests[guests.key].number) > 0) {
                        
                        var price = "";
                        var nightLabel = visitorsDetails.nights + " " + object._i18n.get("nights");
                        if (parseInt(room.guests[guests.key].price) > 0) {
                            
                            if (visitorsDetails.nights == 1) {
                                
                                nightLabel = visitorsDetails.nights + " " + object._i18n.get("night");
                                
                            }
                            
                            price = " (" + format.formatCost(parseInt(room.guests[guests.key].price), object._currency) + " * " + nightLabel + ")";
                            
                        }
                        
                        var guestsPanel = document.createElement("div");
                        guestsPanel.classList.add("stayAndGuestsPanel");
                        guestsPanel.textContent = guests.name + ": " + room.guests[guests.key].name + price;
                        guestsListPanel.insertAdjacentElement("beforeend", guestsPanel);
                        
                    }
                    
                }
                
                
            }
            /** Rooms **/
            
            /**
            for(var key in object._guestsList){
                
                var guests = object._guestsList[key];
                object._console.log(guests);
                var list = this._guestsList[key].json;
                if(typeof guests.json == 'string'){
                    
                    list = JSON.parse(guests.json);
                    
                }
                
                if(visitorsDetails.guestsList[guests.key] != null && parseInt(visitorsDetails.guestsList[guests.key].number) > 0){
                    
                    var price = "";
                    var nightLabel = visitorsDetails.nights + " " + object._i18n.get("nights");
                    if(parseInt(visitorsDetails.guestsList[guests.key].price) > 0){
                        
                        if(visitorsDetails.nights == 1){
                            
                            nightLabel = visitorsDetails.nights + " " + object._i18n.get("night");
                            
                        }
                        
                        price = " (" + format.formatCost(parseInt(visitorsDetails.guestsList[guests.key].price), object._currency) + " * " + nightLabel + ")";
                        
                    }
                    
                    var guestsPanel = document.createElement("div");
                    guestsPanel.classList.add("stayAndGuestsPanel");
                    guestsPanel.textContent = guests.name + ": " + visitorsDetails.guestsList[guests.key].name + price;
                    guestsListPanel.insertAdjacentElement("beforeend", guestsPanel);
                    
                }
                
            }
            **/
            
            var showGuestsListPanel = false;
            personPanel.onclick = function(){
                
                if (showGuestsListPanel == false) {
                    
                    guestsListPanel.classList.remove("hidden_panel");
                    showGuestsListPanel = true;
                    
                } else {
                    
                    guestsListPanel.classList.add("hidden_panel");
                    showGuestsListPanel = false;
                    
                }   
                
            }
            
        }
        
        object._console.log(visitorsDetails);
        object._console.log(object._taxes);
        var taxes = object._taxes;
        var taxesDetails = new TAXES(object._i18n, object._currency, object._debug);
        taxesDetails.setApplicantCount(visitorsDetails.applicantCount);
        taxesDetails.setTaxes(taxes);
        for (var key in taxes) {
            
            var taxValue = 0;
            var tax = taxes[key];
            object._console.log(tax);
            if (tax.active != 'true') {
                
                continue;
                
            }
            
            /**
            var value = parseInt(tax.value);
            if (tax.method == 'multiplication') {
                
                value = parseFloat(tax.value);
                
            }
            
            console.log(value);
            
            if (tax.target == 'room') {
                
                if (tax.scope == 'day') {
                    
                    if (tax.method == 'addition') {
                        
                        taxValue = visitorsDetails.nights * value;
                        
                        
                    } else if (tax.method == 'multiplication') {
                        
                        taxValue =  (value / 100) * (visitorsDetails.amount + (visitorsDetails.additionalFee * visitorsDetails.nights));
                        if (tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                            
                            var amount = 0;
                            for (var i in visitorsDetails.list) {
                                
                                amount += parseInt(visitorsDetails.list[i].cost);
                                
                            }
                            
                            taxValue = (amount + (visitorsDetails.additionalFee * visitorsDetails.nights)) * (value / (100 + value));
                            taxValue = Math.floor(taxValue);
                            
                        }
                        
                    }
                    
                } else if (tax.scope == 'booking') {
                    
                    if (tax.method == 'addition') {
                        
                        taxValue = 1 * value;
                        
                    } else if (tax.method == 'multiplication') {
                        
                        taxValue =  (value / 100) * 1;
                        
                    }
                    
                }
                
                if (tax.method == 'addition' && tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                    
                    visitorsDetails.amount -= taxValue;
                    
                }
                
            } else if (tax.target == 'guest') {
                
                if (tax.scope == 'day') {
                    
                    if (tax.method == 'addition') {
                        
                        taxValue = (visitorsDetails.nights * visitorsDetails.person) * value;
                        
                    } else if (tax.method == 'multiplication') {
                        
                        taxValue =  (value / 100) * visitorsDetails.additionalFee;
                        if (tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                            
                            taxValue = visitorsDetails.additionalFee * (value / (100 + value));
                            taxValue = Math.floor(taxValue);
                            
                        }
                        
                    }
                    
                } else if (tax.scope == 'booking') {
                    
                    if (tax.method == 'addition') {
                        
                        taxValue = 1 * value;
                        
                    } else if (tax.method == 'multiplication') {
                        
                        taxValue =  (value / 100) * 1;
                        
                    }
                    
                }
                
            }
            **/
            
            taxValue = taxesDetails.getTaxValue(key, 'hotel', visitorsDetails);
            tax.taxValue = taxValue;
            visitorsDetails.taxes[key] = tax;
            object._console.log("taxValue = " + tax.taxValue);
            
            var taxNamePanel = document.createElement("div");
            taxNamePanel.classList.add("summaryTitle");
            taxNamePanel.textContent = tax.name + " :";
            
            var taxValuePanel = document.createElement("div");
            taxValuePanel.classList.add("summaryValue");
            taxValuePanel.textContent = format.formatCost(parseInt(tax.taxValue), object._currency);
            
            summaryListPanel.insertAdjacentElement("beforeend", taxNamePanel);
            summaryListPanel.insertAdjacentElement("beforeend", taxValuePanel);
            
        }
        
        
        
        
    }
    
    
