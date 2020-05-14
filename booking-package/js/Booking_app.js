/*globals scriptError */
/*globals I18n */
/*globals Booking_App_XMLHttp */
/*globals FORMAT_COST */
/*globals Booking_Package_Member */
/*globals booking_package_subscriptions */
/*globals Booking_App_Calendar */
/*globals Booking_Package_Hotel */
/*globals TAXES */
/*globals Booking_Package_Console */
/*globals Booking_Package_Input */
/*globals Booking_App_ObjectsControl */

var reservation_info = reservation_info;
var schedule_data = reservation_info;
var booking_package_dictionary = booking_package_dictionary;
var currency = reservation_info.currency;

var courseBool = reservation_info.courseBool;
var courseList = reservation_info.courseList;

var xmlHttp = null;

var monthFullName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var monthShortName = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];


var booking_App = null;

//window.onload = function(){
window.addEventListener('load', function(){
    
    var userAgent = window.navigator.userAgent.toLowerCase();
    var ie = 0;
    if (userAgent.indexOf('msie') != -1 || userAgent.indexOf('trident') != -1) {
        
        ie = 1;
        var version = window.navigator.appVersion.toLowerCase();
        
    }
    
    if (courseBool == 'true') {
        
        courseBool = true;
        
    } else {
        
        courseBool = false;
        
    }
    
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    if (typeof reservation_info.googleAnalytics == 'string') {
        
        gtag('js', new Date());
        gtag('config', reservation_info.googleAnalytics);
        
    }
    
    var stateObj = {page: "nextPage", month: reservation_info['month'], day: reservation_info['day'], year: reservation_info['year']};
    window.history.pushState(stateObj, null, null);
    booking_App = new Booking_App(reservation_info, booking_package_subscriptions, booking_package_dictionary);
    booking_App.setIE(ie);
    booking_App.setGtag(gtag);
    //booking_App.start();
    var judge = booking_App.getJudge();
    if (judge == true) {
        
        if (booking_App._myBookingDetailsBool == true) {
            
            booking_App.myBookingDetails();
            
        } else {
            
            booking_App.getReservationData(parseInt(reservation_info['month']), parseInt(reservation_info['day']), parseInt(reservation_info['year']), parseInt(reservation_info['accountKey']), false, true, null);
            
        }
        
    } else {
        
        
        
    }
    
});

var defaultOrientation;
window.addEventListener('load', function() {
    
    if('orientation' in window) {
        
        var o1 = (window.innerWidth < window.innerHeight);
        var o2 = (window.orientation % 180 == 0);
        defaultOrientation = (o1 && o2) || !(o1 || o2);
        checkOrientation();
        
    }
    
}, false);

window.addEventListener('error', function(event) {
    
    var script_error = new scriptError(reservation_info, booking_package_dictionary, event.message, event.filename, event.lineno, event.colno, event.error);
    if (booking_App.getFunction() != null) {
        
        script_error.setFunction(booking_App.getFunction());
        script_error.setResponseText(booking_App.getResponseText());
        script_error.send();
        
    }
    
}, false);

/**
window.onerror = function(msg, url, line, col, error){
    
    console.error(url);
    var script_error = new scriptError(reservation_info, booking_package_dictionary, msg, url, line, col, error);
    script_error.setFunction(booking_App.getFunction());
    script_error.setResponseText(booking_App.getResponseText());
    script_error.send();
    
}
**/
window.addEventListener('resize', checkOrientation, false);

function checkOrientation(response) {
    
    if('orientation' in window){
        var o = (window.orientation % 180 == 0);
        if((o && defaultOrientation) || !(o || defaultOrientation)) {
            
            var width = window.parent.screen.width;
            if(window.parent.screen.height < window.parent.screen.width){
                
                width = window.parent.screen.width;
                
            }
            console.log('portrait width = ' + width);
            
        }else{
            
            var width = window.parent.screen.width;
            if(window.parent.screen.height > window.parent.screen.width){
                
                width = window.parent.screen.height;
                
            }
            console.log('landscape width = ' + width);
            
        }
        
        if(booking_App != null){
            
            booking_App.resizeScreen(width);
            
        }
        
    }
    
}

    function Booking_App(reservation_info, booking_package_subscriptions, booking_package_dictionary) {
        
        var object = this;
        this._debug = new Booking_Package_Console(reservation_info.debug);
        this._console = {};
        this._console.log = this._debug.getConsoleLog();
        this._console.error = this._debug.getConsoleError();
        
        this._i18n = new I18n(reservation_info.locale);
        this._i18n.setDictionary(booking_package_dictionary);
        
        this._servicesControl = new Booking_App_ObjectsControl(reservation_info, booking_package_dictionary);
        
        this._dictionary = booking_package_dictionary;
        this._format = new FORMAT_COST(this._i18n, this._debug);
        this._subscriptions = booking_package_subscriptions;
        this._subscription = null;
        this._member = new Booking_Package_Member(reservation_info.prefix, reservation_info.calendarAccount, reservation_info.memberSetting, booking_package_subscriptions, reservation_info.url, reservation_info.nonce, reservation_info.action, reservation_info, booking_package_dictionary, this._debug);
        this._isExtensionsValid = parseInt(reservation_info.isExtensionsValid);
        this._reservation_info = reservation_info;
        this._memberSetting = reservation_info.memberSetting;
        this._prefix = reservation_info.prefix;
        this._locale = reservation_info.locale;
        this._url = reservation_info.url;
        this._action = reservation_info.action;
        this._nonce = reservation_info.nonce;
        this._dateFormat = reservation_info.dateFormat;
        this._positionOfWeek = reservation_info.positionOfWeek;
        this._country = reservation_info.country;
        this._currency = reservation_info.currency;
        this._formData = reservation_info.formData;
        this._courseName = reservation_info.courseName;
        this._courseList = reservation_info.courseList;
        this._enableFixCalendar = parseInt(reservation_info.calendarAccount.enableFixCalendar);
        this._topHeightList = [];
        this._top = 0;
        this._bottom = 0;
        this._topPanelHeight = 0;
        this._courseBool = true;
        this._dayPanelList = {};
        this._indexOfDayPanelList = [];
        this._calendarAccount = reservation_info.calendarAccount;
        this._guestsList = reservation_info.guestsList;
        this._lengthOfStayBool = true;
        this._step = "topPage";
        this._chagePanelList = {};
        this._screen_width_limit = 480;
        this._screen_width = parseInt(window.parent.screen.width);
        this._userInformation = {};
        this._headingPosition = reservation_info.headingPosition;
        this._startOfWeek = this._calendarAccount.startOfWeek;
        this._preparationTime = parseInt(this._calendarAccount.preparationTime);
        this._positionPreparationTime = this._calendarAccount.positionPreparationTime;
        this._nationalHoliday = {};
        this._function = {name: "root", post: {}};
        this._ie = 0;
        this._judge = true;
        this._responseText = null;
        this._taxes = reservation_info.taxes;
        this._gtag = null;
        this._redirectPage = null;
        this._userEmail = null;
        this._servicePanelList = [];
        this._currentCalendarDate = {};
        
        if (typeof reservation_info.redirectPage == 'string') {
            
            this._redirectPage = reservation_info.redirectPage;
            
        }
        
        if (this._isExtensionsValid != 1) {
            
            this._calendarAccount.hasMultipleServices = 0;
            this._calendarAccount.maximumNights = 0;
            this._calendarAccount.minimumNights = 0;
            
        }
        
        object._console.log(reservation_info);
        object._console.log("_preparationTime = " + this._preparationTime);
        object._console.log("_isExtensionsValid = " + this._isExtensionsValid);
        object._console.log(this);
        
        this._permalink = window.location.href ;
        this._cancellationOfBooking = 0;
        if (reservation_info.cancellationOfBooking != null) {
            
            this._cancellationOfBooking = parseInt(reservation_info.cancellationOfBooking);
            
        }
        this._myBookingDetailsBool = false;
        this._myBookingDetails = {};
        if (reservation_info.myBookingDetails != null) {
            
            this._myBookingDetailsBool = true;
            this._myBookingDetails = reservation_info.myBookingDetails;
            object._console.log(this._myBookingDetails);
            
        }
        this._permalink = null;
        if (reservation_info.permalink != null) {
            
            this._permalink = reservation_info.permalink;
            
        }
        
        if (typeof this._headingPosition == 'string' && isNaN(parseInt(this._headingPosition)) == false) {
            
            this._headingPosition = parseInt(this._headingPosition);
            
        } else {
            
            this._headingPosition = 0;
            
        }
        
        if (reservation_info.courseBool == 'false') {
            
            this._courseBool = false;
            
        }
        
        var judge = this.judgeSubscription();
        if (judge == false) {
            
            this._judge = judge;
            
        }
        
        this._paymentMethod = reservation_info.paymentMethod;
        object._console.log(this._paymentMethod);
        
        this._stripe_active = parseInt(reservation_info.stripe_active);
        this._stripe_public_key = null;
        if (reservation_info.stripe_public_key != null) {
            
            this._stripe_public_key = reservation_info.stripe_public_key;
            
        }
        
        this._paypal_active = parseInt(reservation_info.paypal_active);
        this._paypal_mode = parseInt(reservation_info.paypal_mode);
        this._paypal_client_id = null;
        if (reservation_info.paypal_client_id != null) {
            
            this._paypal_client_id = reservation_info.paypal_client_id;
            
        }
        
        this._loginform = null;
        if (document.getElementById('booking-package-loginform') != null) {
            
            this._loginform = document.getElementById('booking-package-loginform');
            this._loginform.classList.add("hidden_panel");
            this.memberOperation();
            
        }
        
        this._body = document.getElementsByTagName("body")[0];
        
        this.monthFullName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        this.monthShortName = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];;
        this.weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        this._calendar = new Booking_App_Calendar(this.weekName, this._dateFormat, this._positionOfWeek, this._startOfWeek, this._i18n, this._debug);
        this._calendar.setClock(reservation_info.clock);
        this._hotel = new Booking_Package_Hotel(this._currency, this.weekName, this._dateFormat, this._positionOfWeek, this._startOfWeek, booking_package_dictionary, this._debug);
        this._hotel.setTaxes(this._taxes);
        
        var MutationObserverBool = true;
        var userAgent = window.navigator.userAgent.toLowerCase();
        if (userAgent.indexOf('firefox') != -1) {
            
            MutationObserverBool = false;
            
        }
        object._console.log(userAgent);
        
        
        //if(this._headingPosition == 1){
            
            if (typeof MutationObserver == 'function' && MutationObserverBool == true) {
                
                var object = this;
                this._observer = new MutationObserver(function(mutations) {
                    
                    for (var key in mutations) {
                        
                        object.watchElement(mutations[key]);
                        
                    }
                    
                    
                });
                
                var config = {
                    attributes: true, 
                    childList: false, 
                    characterData: false, 
                    subtree: true, 
                    attributeFilter: ['class', 'style']
                };
                this._observer.observe(this._body, config);
                
                /**
                this._observer = new MutationObserver((mutations) => {
                    
                    mutations.forEach((mutation) => {
                        
                        this.watchElement(mutation);
                        
                    });
                    
                });
                
                var config = { attributes: true, childList: false, characterData: false, subtree: true, attributeFilter: ['class', 'style']};
                this._observer.observe(this._body, config);
                **/
                
            }
            
            var rect = {left: 0, right: 0, top: 0, bottom: 0, width: 0, height: 0, x: 0, y: 0};
            if(document.getElementById("booking-package_calendarPage") != null && document.getElementById("booking-package_calendarPage").getBoundingClientRect() != null){
                
                rect = document.getElementById("booking-package_calendarPage").getBoundingClientRect();
                
            }
            var left = rect.left;
            var right = rect.right;
            object._console.log(rect);
            
            var wpadminbarTop = 0;
            if (document.getElementById("wpadminbar") != null) {
                
                wpadminbarTop = document.getElementById("wpadminbar").clientHeight;
                
            }
            
            var list = this._body.getElementsByTagName("*");
            for (var i = 0; i < list.length; i++) {
                
                var style = window.getComputedStyle(list[i], null);
                if (style.getPropertyValue("position") == "fixed" && style.getPropertyValue("display") != "none" && style.getPropertyValue("visibility") != "hidden") {
                    
                    var top = parseInt(style.getPropertyValue("top"));
                    var bottom = parseInt(style.getPropertyValue("bottom"));
                    var z_index = 0;
                    if (style.getPropertyValue("z-index") != "auto") {
                        
                        z_index = parseInt(style.getPropertyValue("z-index"));
                        
                    }
                    var rect = list[i].getBoundingClientRect();
                    object._console.log(list[i]);
                    object._console.log(rect);
                    if (top >= 0 && top <= wpadminbarTop && rect.left < left && rect.right > right) {
                        
                        this._topHeightList.push(rect.height);
                        this._top += rect.height;
                        list[i].setAttribute("data-watchTopKey", (this._topHeightList.length - 1));
                        list[i].setAttribute("data-watchPosition", 1);
                        list[i].classList.add("booking-package-watchPosition");
                        if (z_index < 100) {
                            
                            list[i].classList.add("topPanelIndex");
                            
                        }
                        
                        object._console.log(rect);
                        object._console.log("z_index = " + z_index);
                        object._console.log(this._topHeightList);
                        object._console.log("top = " + top);
                        
                    }
                    
                    if (bottom == 0 && rect.left < left && rect.right > right) {
                        
                        this._bottom += rect.height;
                        if (z_index < 100) {
                            
                            list[i].classList.add("bottomPanelIndex");
                            
                        }
                        object._console.log(list[i]);
                        object._console.log(rect);
                        object._console.log("z_index = " + z_index);
                        object._console.log("bottom = " + bottom);
                        
                    }
                    
                }
                
            }
            
            for (var i = 0; i < list.length; i++) {
                
                var id = list[i].id;
                if (id == "booking-package_calendarPage") {
                    
                    break;
                    
                }
                
                /**
                var style = window.getComputedStyle(list[i], null);
                if(style.getPropertyValue("overflow") == "hidden"){
                    
                    list[i].setAttribute("style", "overflow: initial;");
                    
                }
                
                if(style.getPropertyValue("overflow-x") == "hidden"){
                    
                    list[i].setAttribute("style", "overflow-x: initial;");
                    
                }
                **/
                
            }
            
        //}
        /**else {
            
            //this.setIE(1);
            
            if(typeof MutationObserver == 'function' && MutationObserverBool == true){
                
                var object = this;
                this._observer = new MutationObserver(function(mutations){
                    
                    for(var key in mutations){
                        
                        object.watchElement(mutations[key]);
                        
                    }
                    
                    
                });
                
                var config = { attributes: true, childList: false, characterData: false, subtree: true, attributeFilter: ['class', 'style']};
                this._observer.observe(this._body, config);
                
            }
            
        }
        **/
        
    }
    
    Booking_App.prototype.setIE = function(ie){
        
        this._ie = parseInt(ie);
        if (parseInt(ie) == 1) {
            
            this._headingPosition = 0;
            this._ie = 0;
            
        }
        
    }
    
    Booking_App.prototype.getIE = function(){
        
        return this._ie;
        
    };
    
    Booking_App.prototype.getJudge = function(){
        
        return this._judge;
        
    };
    
    Booking_App.prototype.setCurrentCalendarDate = function(currentCalendarDate) {
        
        this._console.error(currentCalendarDate);
        this._currentCalendarDate = currentCalendarDate;
        
    };
    
    Booking_App.prototype.getCurrentCalendarDate = function() {
        
        return this._currentCalendarDate;
        
    };
    
    Booking_App.prototype.setUserInformation = function(userInformation){
        
        if(this._userInformation != null){
            
            this._userInformation = userInformation;
            
        }
        
    }
    
    Booking_App.prototype.setGtag = function(gtag){
        
        this._gtag = gtag;
        
    }
    
    Booking_App.prototype.setResponseText = function(responseText){
        
        this._responseText = responseText;
        
    }
    
    Booking_App.prototype.getResponseText = function(){
        
        return this._responseText;
        
    }
    
    Booking_App.prototype.setDayPanelList = function(dayPanelList){
        
        this._dayPanelList = dayPanelList;
        
    }
    
    Booking_App.prototype.getDayPanelList = function(){
        
        return this._dayPanelList;
        
    }
    
    Booking_App.prototype.serachDayPanelList = function(key){
        
        if(this._dayPanelList[key] != null){
            
            return this._dayPanelList[key];
            
        }
        
        return null;
        
    }
    
    Booking_App.prototype.resetIndexOfDayPanelList = function(){
        
        this._indexOfDayPanelList = [];
        
    }
    
    Booking_App.prototype.setIndexOfDayPanelList = function(value){
        
        this._indexOfDayPanelList.push(value);
        
    }
    
    Booking_App.prototype.getIndexOfDayPanelList = function(){
        
        return this._indexOfDayPanelList;
        
    }
    
    Booking_App.prototype.setSchedulesCallback = function(callback){
        
        this._callback = callback;
        
    }
    
    Booking_App.prototype.getSchedulesCallback = function(){
        
        return this._callback;
        
    }
    
    Booking_App.prototype.getGuestsList = function(){
        
        return this._guestsList;
        
    }
    
    Booking_App.prototype.initWeekDaysList = function(){
        
        this._weekDaysList = {};
        
    }
    
    Booking_App.prototype.addWeekDaysList = function(key, value){
        
        this._weekDaysList[key] = value;
        
    }
    
    Booking_App.prototype.getWeekDaysList = function(){
        
        return this._weekDaysList;
        
    }
    
    Booking_App.prototype.initInputData = function(){
        
        this._inputData = {};
        
    }
    
    Booking_App.prototype.setInputData = function(inputData){
        
        this._inputData = inputData;
        
    }
    
    Booking_App.prototype.addInputData = function(key, value){
        
        this._inputData[key] = value;
        
    }
    
    Booking_App.prototype.getInputData = function(){
        
        return this._inputData;
        
    }
    
    Booking_App.prototype.setFunction = function(name, post){
        
        this._function = {name: name, post: post};
        
    }
    
    Booking_App.prototype.getFunction = function(){
        
        return this._function;
        
    }
    
    Booking_App.prototype.setSubscription = function(subscription){
        
        this._subscription = subscription;
        
    }
    
    Booking_App.prototype.getSubscription = function(){
        
        return this._subscription;
        
    }
    
    Booking_App.prototype.setServicePanelList = function(servicePanelList) {
        
        this._servicePanelList = {};
        for (var key in servicePanelList) {
            
            var id = parseInt(servicePanelList[key].getAttribute('data-service'));
            this._servicePanelList[id] = servicePanelList[key];
            
        }
        
    }
    
    Booking_App.prototype.watchElement = function(mutation){
        
        var object = this;
        
        if (mutation.attributeName == "class" || mutation.attributeName == "style") {
            
            var targetElement = mutation.target;
            var body = document.getElementsByTagName("body")[0];
            var elementList = body.getElementsByClassName("booking-package-watchPosition");
            if (elementList.length > 0) {
                
                this._bottom = 0;
                for (var i = 0; i < elementList.length; i++) {
                    
                    var style = window.getComputedStyle(elementList[i], null);
                    var rect = elementList[i].getBoundingClientRect();
                    if (style.getPropertyValue("position") == "fixed" && style.getPropertyValue("display") != "none" && style.getPropertyValue("visibility") != "hidden") {
                        
                        if (parseInt(style.getPropertyValue("bottom")) == 0) {
                            
                            this._bottom += rect.height;
                            
                        }
                        
                    }
                    
                    
                }
                
            }
            
            
        }
        
        
        if(mutation.attributeName == "class"){
            
            var changeDataBool = true;
            var targetElement = mutation.target;
            var rect = targetElement.getBoundingClientRect();
            var style = window.getComputedStyle(targetElement, null);
            
            var wpadminbarTop = 0;
            if(document.getElementById("wpadminbar") != null){
                
                wpadminbarTop = document.getElementById("wpadminbar").clientHeight;
                
            }
            
            if(targetElement.id == "bookingBlockPanel"){
                
                return null;
                
            }
            
            
            if(style.getPropertyValue("display") == "none" && style.getPropertyValue("position") == "fixed" && (targetElement.getAttribute("data-watchPosition") == null || targetElement.getAttribute("data-watchPosition") == 0)){
                
                //if(rect.top <= wpadminbarTop){
                if(rect.top <= this._top){
                    
                    object._console.log(targetElement.getAttribute("data-watchPosition"));
                    if(targetElement.getAttribute("data-watchTopKey") == null){
                        
                        this._topHeightList.push((rect.height));
                        targetElement.setAttribute("data-watchTopKey", (this._topHeightList.length - 1));
                        
                    }
                    
                    this._top += (rect.height);
                    changeDataBool = false;
                    targetElement.setAttribute("data-watchPosition", 1);
                    object._console.log(rect);
                    object._console.error(rect);
                    object._console.log(mutation.target);
                    object._console.log(style.getPropertyValue("position"));
                    this.chageTop(this._top);
                    
                }
                
                object._console.log(this._top);
                
            }
            
            if(changeDataBool == true && style.getPropertyValue("position") != "fixed" && targetElement.getAttribute("data-watchPosition") == 1){
                
                this._top -= (rect.height);
                if(targetElement.style.height != null){
                    
                    targetElement.style.height = null;
                    
                }
                targetElement.setAttribute("data-watchPosition", 0);
                this.chageTop(this._top);
                object._console.log("return 0");
                
            }
            
            if(style.getPropertyValue("position") == "fixed" && targetElement.getAttribute("data-watchTopKey") != null){
                
                var key = targetElement.getAttribute("data-watchTopKey");
                this._topHeightList[key] = rect.height;
                if(style.getPropertyValue("position") == "fixed"){
                    
                    this._topHeightList[key] = rect.height;
                    
                }
                object._console.log(this._topHeightList);
                targetElement.style.height = rect.height + "px";
                this._top = 0;
                var heigthList = this._topHeightList;
                for(var i = 0; i < heigthList.length; i++){
                    
                    this._top += heigthList[i];
                    
                }
                
                object._console.log(this._top);
                this.chageTop(this._top);
                
            }
            
            this.chageTop(this._top);
            
        }
        
        if(mutation.attributeName == "style"){
            
            var targetElement = mutation.target;
            var style = window.getComputedStyle(targetElement, null);
            if(targetElement.getAttribute("data-watchTopKey") != null && style.getPropertyValue("display") == "none"){
                
                var key = targetElement.getAttribute("data-watchTopKey");
                var rect = targetElement.getBoundingClientRect();
                this._topHeightList[key] = 0;
                object._console.log(style.getPropertyValue("display"));
                object._console.log(targetElement);
                this._top = 0;
                var heigthList = this._topHeightList;
                for(var i = 0; i < heigthList.length; i++){
                    
                    this._top += heigthList[i];
                    
                }
                
                object._console.log(this._top);
                this.chageTop(this._top);
                
            }
            
            this.chageTop(this._top);
            this._member.setTop(this._top);
            
        }
        
    }
    
    Booking_App.prototype.createServiceGroupAndSortServices = function(services) {
        
        var object = this;
        var serviceGroup = [];
        var noServiceGroup = [];
        for (var key in services) {
            
            var service = services[key];
            object._console.log(service);
            if (service.group.length > 0) {
                
                object._console.log(serviceGroup.indexOf(service.group));
                if (serviceGroup.indexOf(service.group) < 0) {
                    
                    serviceGroup.push(service.group);
                    
                }
                
            } else {
                
                noServiceGroup.push(service);
                
            }
            
        }
        
        var newServices = [];
        if (serviceGroup != null && serviceGroup.length > 0) {
            
            for (var i = 0; i < serviceGroup.length; i++) {
                
                var service = serviceGroup[i];
                for (var key in services) {
                    
                    if (service == services[key].group) {
                        
                        newServices.push(services[key]);
                        
                    }
                    
                }
                
            }
            
            if (noServiceGroup.length > 0) {
                
                serviceGroup.push(object._i18n.get("Other"));
                for (var key in noServiceGroup) {
                    
                    newServices.push(noServiceGroup[key]);
                    
                }
                
            }
            
        }
        
        return {services: newServices, group: serviceGroup};
        
    };
    
    Booking_App.prototype.getReservationData = function(month, day, year, accountKey, update, request, calendarData){
        
        var object = this;
        month = parseInt(month);
        day = parseInt(day);
        year = parseInt(year);
        
        function prepareCalendarData(calendarData){
            
            var today = parseInt(calendarData.date.today);
            var timestamp = parseInt(calendarData.date.timestamp);
            var maxDeadlineDay = parseInt(calendarData.date.maxDeadlineDay);
            for (var key in calendarData.schedule) {
                
                if (parseInt(key) >= today) {
                    for(var i = 0; i < calendarData.schedule[key].length; i++){
                        
                        var schedule = calendarData.schedule[key][i];
                        if(parseInt(schedule.unixTimeDeadline) < timestamp){
                            
                            schedule.remainder = 0;
                            
                        }
                        
                    }
                    
                } else if (parseInt(key) > maxDeadlineDay) {
                    
                    break;
                    
                }
                
            }
            
            return calendarData;
            
        };
        
        if (request == true) {
            
            if(document.getElementById("bookingBlockPanel") != null){
                
                var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                bookingBlockPanel.classList.remove("hidden_panel");
                var post = {nonce: this._nonce, action: this._action, mode: object._prefix + 'getReservationData', year: year, month: month, day: 1, public: true, accountKey: accountKey};
                object.setFunction("getReservationData", post);
                new Booking_App_XMLHttp(this._url, post, false, function(calendarData){
                    
                    bookingBlockPanel.classList.add("hidden_panel");
                    object._console.log(calendarData);
                    object.resetIndexOfDayPanelList();
                    if(calendarData != null && typeof calendarData == 'object'){
                        
                        if(calendarData.date != null){
                            
                            calendarData = prepareCalendarData(calendarData);
                            
                            /**
                            var today = parseInt(calendarData.date.today);
                            var timestamp = parseInt(calendarData.date.timestamp);
                            var maxDeadlineDay = parseInt(calendarData.date.maxDeadlineDay);
                            for (var key in calendarData.schedule) {
                                
                                if (parseInt(key) >= today) {
                                    
                                    for(var i = 0; i < calendarData.schedule[key].length; i++){
                                        
                                        var schedule = calendarData.schedule[key][i];
                                        if(parseInt(schedule.unixTimeDeadline) < timestamp){
                                            
                                            schedule.remainder = 0;
                                            
                                        }
                                        
                                    }
                                    
                                } else if (parseInt(key) > maxDeadlineDay) {
                                    
                                    break;
                                    
                                }
                                
                            }
                            **/
                            
                            if (object._calendarAccount.flowOfBooking == 'services' && update === false) {
                                
                                object.createServicesPanel(calendarData, month, day, year, accountKey);
                                
                            } else {
                                
                                object.createCalendar(calendarData, month, day, year, accountKey, null);
                                
                            }
                            
                            
                            
                        }else{
                            
                            if(window.confirm(calendarData.message)){
                                
                                window.location.reload(true);
                                
                            }
                            
                        }
                        
                    }
                    
                }, function(responseText){
                    
                    object.setResponseText(responseText);
                    
                });
                
            }
            
        } else {
            
            calendarData = prepareCalendarData(calendarData);
            object._console.log(calendarData);
            return calendarData;
            
        }
        
    }
    
    Booking_App.prototype.i18n = function(str, args){
        
        var value = this._i18n.get(str, args);
        return value;
        
    }
    
    Booking_App.prototype.resizeScreen = function(width){
        
        var object = this;
        object._console.log("width = " + width);
        
    }
    
    Booking_App.prototype.setStep = function(event){
        
        var object = this;
        this._step = event;
        object._console.log("step = " + this._step);
    }
    
    Booking_App.prototype.memberOperation = function(){
        
        var object = this;
        var memberSetting = object._memberSetting;
        object._console.log(memberSetting);
        if (object._memberSetting.user_email != null) {
            
            object._userEmail = object._memberSetting.user_email;
            
        }
        object._console.log('_userEmail = ' + object._userEmail);
        if(memberSetting.value != null){
            
            object.setUserInformation(memberSetting.value);
            
            
        }
        
        object._member.memberOperation(object._top);
        
        
    }
    
    Booking_App.prototype.judgeSubscription = function(){
        
        var object = this;
        var judge = true;
        object._console.log(object._calendarAccount.enableSubscriptionForStripe);
        object._console.log(object._reservation_info.visitorSubscriptionForStripe);
        
        
        
        if(parseInt(object._reservation_info.visitorSubscriptionForStripe) == 1 && parseInt(object._calendarAccount.enableSubscriptionForStripe) == 1){
            
            if(parseInt(object._memberSetting.function_for_member) == 0){
                
                window.alert("Please enable \"Member\"");
                return false;
                
            }
            
            object._memberSetting.reject_non_membder = 1;
            if(object._memberSetting.login == 0){
                
                judge = false;
                
            }
            
        }
        
        object._console.log("judge = " + judge);
        return judge;
        
    }
    
    Booking_App.prototype.subscription_form = function(){
        
        var object = this;
        var calendarAccount = object._calendarAccount;
        var member = object._memberSetting;
        var subscription = object._subscriptions;
        var calendarPanel = document.getElementById("booking-package_calendarPage");
        var subscription_form = document.getElementById("booking-package-subscription_form");
        var subscription_amount = document.getElementById("booking-package-subscription_amount");
        var subscription_input_form = document.getElementById("booking-package-subscription_input_form");
        
        if(subscription_form == null){
            
            return null;
            
        }
        
        object._console.log(calendarAccount);
        object._console.log(member);
        object._console.log(member.subscription_list);
        object._console.log(subscription);
        if(member.subscription_list != null){
            
            var items = member.subscription_list;
            for(var key in items){
                
                var item = items[key];
                if(subscription.product == key){
                    
                    var plans = item.items;
                    for(var i = 0; i < plans.length; i++){
                        
                        var plan = plans[i];
                        if(subscription.planKeys.indexOf(plan.id) >= 0){
                            
                            object._console.log(plan);
                            subscription.subscribed = 1;
                            object._member.setSubscription(subscription);
                            //object.setSubscription(subscription);
                            return null;
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }
        
        
        var judge = true;
        if((subscription != null && parseInt(subscription.status) == 1) && parseInt(calendarAccount.enableSubscriptionForStripe) == 1 && member.login == 1){
            
            judge = false;
            calendarPanel.classList.add("hidden_panel");
            subscription_form.classList.remove("hidden_panel");
            var costFormat = new FORMAT_COST(object._i18n, object._debug);
            var costLine = subscription_amount.textContent;
            costLine = object._i18n.get(costLine, [costFormat.formatCost(subscription.amount, subscription.currency)]);
            object._console.log(costLine);
            subscription_amount.textContent = costLine;
            
            if(object._stripe_active == 1 && subscription.amount != 0){
                
                var cartPanel = document.createElement("div");
                cartPanel.id = "paymentPanel";
                cartPanel.classList.add("cartPanel");
                subscription_input_form.appendChild(cartPanel);
                
                object.paypalPanelcartInputForStripe(object._stripe_public_key, object._country, subscription.currency, cartPanel, subscription.plans, null, function(paymentResponse){
                    
                    object._console.log(paymentResponse);
                    var token = null;
                    if(paymentResponse.paymentName == 'stripe'){
                        
                        if(paymentResponse.complete != null && typeof paymentResponse.complete == 'function'){
                            
                            token = paymentResponse.token.id;
                            
                        }else{
                            
                            token = paymentResponse.token.id;
                            
                        }
                        
                    }else if(paymentResponse.paymentName == 'paypal'){
                        
                        token = paymentResponse.paymentID;
                        
                    }
                    
                    if(token != null){
                        
                        var post = {nonce: object._nonce, action: object._action, mode: "createCustomer", payType: paymentResponse.paymentName, payToken: token, calendarAccountKey: calendarAccount.key};
                        object._console.log(post);
                        var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                        bookingBlockPanel.classList.remove("hidden_panel");
                        new Booking_App_XMLHttp(object._url, post, false, function(response){
                            
                            object._console.log(response);
                            if(paymentResponse.paymentName == 'stripe'){
                                
                                if(parseInt(response.status) == 1){
                                    
                                    if(paymentResponse.complete != null && typeof paymentResponse.complete == 'function'){
                                        
                                        paymentResponse.complete('success');
                                        
                                    }
                                    window.location.reload(true);
                                    
                                }else{
                                    
                                    if(paymentResponse.complete != null && typeof paymentResponse.complete == 'function'){
                                        
                                        paymentResponse.complete('fail');
                                        bookingBlockPanel.classList.add("hidden_panel");
                                        
                                    }
                                    
                                }
                                
                            }
                            
                        }, function(responseText){
                            
                            object.setResponseText(responseText);
                            
                        });
                        
                    }
                    
                });
                
                var button = subscription_input_form.getElementsByClassName("paymentButton");
                if(typeof button == 'object' && button[0] != null){
                    
                    button[0].textContent = object._i18n.get("Submit Payment");
                    
                }
                
            }
            
        }else{
            
            if(member.login == 0){
                
                
                
            }
            
        }
        
        return judge;
        
    }
    
    Booking_App.prototype.myBookingDetails = function(){
        
        var object = this;
        var top = 0;
        var calendarAccount = object._calendarAccount;
        var myBookingDetails = object._myBookingDetails;
        var selectedOptions = JSON.parse(myBookingDetails.options);
        var course = null;
        var accommodationDetails = {};
        var schedule = {
            month: myBookingDetails.scheduleMonth,
            day: myBookingDetails.scheduleDay,
            year: myBookingDetails.scheduleYear,
            weekKey: myBookingDetails.scheduleWeek,
            hour: myBookingDetails.scheduleHour,
            min: myBookingDetails.scheduleMin,
            title: myBookingDetails.scheduleTitle,
            cost: myBookingDetails.scheduleCost
            
        };
        
        object._console.log(myBookingDetails);
        var courseList = JSON.parse(myBookingDetails.options);
        /**
        if (myBookingDetails.courseKey.length > 0) {
            
            course = {
                key: parseInt(myBookingDetails.courseKey),
                name: myBookingDetails.courseName,
                time: parseInt(myBookingDetails.courseTime),
                cost: parseInt(myBookingDetails.courseCost),
                
            }
            
        }
        **/
        
        if (myBookingDetails.accommodationDetails != 'null') {
            
            accommodationDetails = JSON.parse(myBookingDetails.accommodationDetails);
            
        }
        
        object._console.log(myBookingDetails);
        object._console.log(course);
        object._console.log(selectedOptions);
        object._console.log(accommodationDetails);
        
        var myBookingDetailsPanel = document.getElementById("booking-package_myBookingDetailsFroVisitor");
        myBookingDetailsPanel.classList.remove("hidden_panel");
        
        var topBarPanel = myBookingDetailsPanel.getElementsByClassName("selectedDate")[0];
        if (object._headingPosition == 1) {
            
            topBarPanel.style.top = object._top + "px";
            
        }
        
        var totalCost = 0;
        var goodsList = [];
        var rowPanel = object.createRowPanel(object._i18n.get("ID"), myBookingDetails.key, null, null, null);
        myBookingDetailsPanel.appendChild(rowPanel);
        
        var status = myBookingDetails.status;
        var statusPanel = object.createRowPanel(object._i18n.get("Status"), object._i18n.get(myBookingDetails.status.toLowerCase()), null, null, null);
        myBookingDetailsPanel.appendChild(statusPanel);
        
        if(calendarAccount.type == 'day'){
            
            myBookingDetailsPanel.classList.remove("hidden_panel");
            var date = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, schedule.hour, schedule.min, schedule.title, schedule.weekKey);
            var rowPanel = object.createRowPanel(object._i18n.get("Booking Date"), date, null, null, null);
            myBookingDetailsPanel.appendChild(rowPanel);
            top += parseInt(rowPanel.clientHeight);
            
            totalCost = parseInt(schedule.cost);
            
            if (courseList != null && courseList.length > 0) {
                
                var rowPanel = object.createRowPanel(myBookingDetails.courseTitle, "", null, null, null);
                myBookingDetailsPanel.appendChild(rowPanel);
                var valuePanel = rowPanel.getElementsByClassName("value")[0];
                valuePanel.textContent = null;
                
                var coursePanel = document.createElement("div");
                coursePanel.classList.add("mainPlan");
                valuePanel.appendChild(coursePanel);
                
                for (var key in courseList) {
                    
                    if (courseList[key].selected == 1) {
                        
                        course = true;
                        var courseCostPanel = null;
                        var goods = {label: courseList[key].name, amount: parseInt(courseList[key].cost)};
                        goodsList.push(goods);
                        totalCost += parseInt(courseList[key].cost);
                        
                        if (parseInt(courseList[key].cost) > 0) {
                            
                            courseCostPanel = document.createElement("span");
                            courseCostPanel.classList.add("planPrice");
                            courseCostPanel.textContent = object._format.formatCost(courseList[key].cost, object._currency);
                            
                        }
                        
                        var courseLinePanel = document.createElement("div");
                        courseLinePanel.classList.add("courseLinePanel");
                        coursePanel.appendChild(courseLinePanel);
                        
                        var courseNamePanel = document.createElement("span");
                        courseNamePanel.classList.add("planName");
                        courseNamePanel.textContent = courseList[key].name;
                        courseLinePanel.appendChild(courseNamePanel);
                        if (courseCostPanel != null) {
                            
                            courseLinePanel.appendChild(courseCostPanel);
                            
                        }
                        
                        var selectedOptions = courseList[key].selectedOptionsList;
                        if (selectedOptions != null && selectedOptions.length > 0) {
                            
                            var ul = document.createElement("ul");
                            coursePanel.appendChild(ul);
                            
                            for(var i = 0; i < selectedOptions.length; i++){
                                
                                var option = selectedOptions[i];
                                object._console.log(option);
                                if (parseInt(option.selected) == 1) {
                                    
                                    var goods = {label: option.name, amount: parseInt(option.cost)};
                                    goodsList.push(goods);
                                    totalCost += parseInt(option.cost);
                                    
                                    var optionNamePanel = document.createElement("span");
                                    optionNamePanel.classList.add("planName");
                                    optionNamePanel.textContent = option.name;
                                    
                                    var optionPricePanel = document.createElement("span");
                                    optionPricePanel.classList.add("planPrice");
                                    if (parseInt(option.cost) > 0) {
                                        
                                        optionPricePanel.textContent = object._format.formatCost(option.cost, object._currency);
                                        
                                    }
                                    
                                    var li = document.createElement("li");
                                    li.appendChild(optionNamePanel);
                                    li.appendChild(optionPricePanel);
                                    ul.appendChild(li);
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
            }
            
            object._console.log("totalCost = " + totalCost);
            if(totalCost != 0){
                
                var formatPrice = object._format.formatCost(totalCost, myBookingDetails.currency);
                var rowPanel = object.createRowPanel(this._i18n.get("Total amount"), formatPrice, null, null, null);
                rowPanel.classList.add("total_amount");
                myBookingDetailsPanel.appendChild(rowPanel);
                top += parseInt(rowPanel.clientHeight);
                
            }
            
        }else{
            
            object._hotel.setCheckIn(accommodationDetails.checkInSchedule);
            object._hotel.setCheckOut(accommodationDetails.checkOutSchedule);
            object._hotel.setCalendarAccount(object._calendarAccount);
            var detailes = myBookingDetails.accommodationDetailsList;
            var scheduleDetails = accommodationDetails.scheduleDetails;
            for (var key in scheduleDetails) {
                
                object._hotel.addSchedule(scheduleDetails[key]);
                
            }
            
            /** Rooms **/
            var guestsList = accommodationDetails.guestsList;
            object._console.log(accommodationDetails.guestsList);
            for (var roomKey in accommodationDetails.rooms) {
                
                var room = accommodationDetails.rooms[roomKey];
                for (var key in guestsList) {
                    
                    var list = guestsList[key].json;
                    object._console.log(typeof list);
                    if (typeof list == "string") {
                        
                        list = JSON.parse(list);
                        
                    } else {
                        
                        guestsList[key].json = JSON.stringify(list);
                        
                    }
                    
                    object._hotel.addGuests(key, guestsList[key], parseInt(roomKey));
                    for(var i = 0; i < list.length; i++){
                        
                        if(parseInt(list[i].selected) == 1){
                            
                            object._console.log(list[i].name);
                            guestsList[key].value = i;
                            guestsList[key].person = parseInt(list[i].number);
                            var response = object._hotel.setGuests(key, i, list[i].number, parseInt(roomKey));
                            
                        }
                        
                    }
                    
                }
                
            }
            /** Rooms **/
            
            object._console.log(detailes);
            
            var hotelDetails = object._hotel.verifySchedule(true);
            object._console.log(hotelDetails);
            totalCost = hotelDetails.amount + (hotelDetails.additionalFee * hotelDetails.nights);
            
            var amount = {label: this._i18n.get("Accommodation fees"), amount: parseInt(hotelDetails.amount * hotelDetails.applicantCount)};
            var additionalFee = {label: this._i18n.get("Additional fees"), amount: parseInt(hotelDetails.additionalFee * hotelDetails.nights * hotelDetails.applicantCount)};
            goodsList.push(amount);
            goodsList.push(additionalFee);
            object._console.log(goodsList);
            object._console.log("totalCost = " + totalCost)
            //callback({mode: "top", top: object._top});
            
            var expressionsCheck = object._calendar.getExpressionsCheck(parseInt(object._calendarAccount.expressionsCheck));
            object._console.log(expressionsCheck);
            
            var checkInDatePanel = document.createElement("div");
            var checkInDate = object._calendar.formatBookingDate(accommodationDetails.checkInSchedule.month, accommodationDetails.checkInSchedule.day, accommodationDetails.checkInSchedule.year, null, null, null, accommodationDetails.checkInSchedule.weekKey);
            checkInDatePanel.textContent = checkInDate;
            
            var checkOutDatePanel = document.createElement("div");
            var checkOutDate = object._calendar.formatBookingDate(accommodationDetails.checkOutSchedule.month, accommodationDetails.checkOutSchedule.day, accommodationDetails.checkOutSchedule.year, null, null, null, accommodationDetails.checkOutSchedule.weekKey);
            checkOutDatePanel.textContent = checkOutDate;
            
            var checkInPanel = object.createRowPanel(expressionsCheck.arrival, checkInDatePanel, null, null, null);
            var checkOutPanel = object.createRowPanel(expressionsCheck.departure, checkOutDatePanel, null, null, null);
            
            var totalLengthOfStay = object.createRowPanel(object._i18n.get("Total length of stay") + ": " + detailes.totalLengthOfStay.main.replace(/\\/g, ""), "", null, null, null);
            var valueOfStay = totalLengthOfStay.getElementsByClassName("value")[0];
            for(var i = 0; i < detailes.totalLengthOfStay.sub.length; i++) {
                
                var stayPanel = document.createElement("div");
                stayPanel.textContent = detailes.totalLengthOfStay.sub[i].replace(/\\/g, "");
                valueOfStay.appendChild(stayPanel);
                
            }
            
            var nameLabel = document.createElement("div");
            nameLabel.classList.add("name");
            //nameLabel.setAttribute("style", "margin-top: 0.5em");
            nameLabel.textContent = object._i18n.get("Total number of guests") + ": " + detailes.totalLengthOfGuests.main.replace(/\\/g, "");
            valueOfStay.appendChild(nameLabel);
            for(var i = 0; i < detailes.totalLengthOfGuests.sub.length; i++) {
                
                var guestsPanel = document.createElement("div");
                guestsPanel.textContent = detailes.totalLengthOfGuests.sub[i].replace(/\\/g, "");
                valueOfStay.appendChild(guestsPanel);
                
            }
            
            for(var i = 0; i < detailes.totalLengthOfTaxes.sub.length; i++) {
                
                var taxesPanel = document.createElement("div");
                taxesPanel.textContent = detailes.totalLengthOfTaxes.sub[i].replace(/\\/g, "");
                valueOfStay.appendChild(taxesPanel);
                
            }
            
            /**
            var totalLengthOfGuests = object.createRowPanel(object._i18n.get("Total number of guests") + ": " + detailes.totalLengthOfGuests.main, "", null, null, null);
            var valueOfGuests = totalLengthOfGuests.getElementsByClassName("value")[0];
            for(var i = 0; i < detailes.totalLengthOfGuests.sub.length; i++) {
                
                var guestsPanel = document.createElement("div");
                guestsPanel.textContent = detailes.totalLengthOfGuests.sub[i];
                valueOfGuests.appendChild(guestsPanel);
                
            }
            **/
            
            var totalCost = object._format.formatCost(accommodationDetails.totalCost, myBookingDetails.currency);
            var totalPricePanel = object.createRowPanel(object._i18n.get("Total amount"), totalCost, null, null, null);
            totalPricePanel.classList.add("total_amount");
            if (parseInt(accommodationDetails.totalCost) == 0) {
                
                totalPricePanel.classList.add("hidden_panel");
                
            }
            
            //durationStay.insertAdjacentElement("beforeend", bookingDetailsTitle);
            myBookingDetailsPanel.insertAdjacentElement("beforeend", checkInPanel);
            myBookingDetailsPanel.insertAdjacentElement("beforeend", checkOutPanel);
            myBookingDetailsPanel.insertAdjacentElement("beforeend", totalLengthOfStay);
            //myBookingDetailsPanel.insertAdjacentElement("beforeend", totalLengthOfGuests);
            myBookingDetailsPanel.insertAdjacentElement("beforeend", totalPricePanel);
            
            
        }
        
        var returnButton = document.createElement("button");
        returnButton.classList.add("returnButton");
        returnButton.textContent = object._i18n.get("Return to calendar");
        
        var cancelButton = document.createElement("button");
        cancelButton.classList.add("cancelButton");
        cancelButton.textContent = object._i18n.get("Cancel booking");
        if (status == 'canceled') {
            
            cancelButton.classList.add("hidden_panel");
            
        }
        
        var buttonPanel = myBookingDetailsPanel.getElementsByClassName("buttonPanel")[0];
        buttonPanel.appendChild(returnButton);
        buttonPanel.appendChild(cancelButton);
        myBookingDetailsPanel.appendChild(buttonPanel);
        
        returnButton.onclick = function() {
            
            window.location.href = object._permalink;
            
        }
        
        if (object._cancellationOfBooking == 1 && status != 'canceled') {
            
            cancelButton.onclick = function() {
                
                var post = {nonce: object._nonce, action: object._action, mode: 'cancelBookingData', key: myBookingDetails.key, token: myBookingDetails.cancellationToken, status: 'canceled', sendEmail: 1};
                object._console.log(post);
                if (window.confirm(object._i18n.get("Can we really cancel your booking?"))) {
                    
                    var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                    bookingBlockPanel.classList.remove("hidden_panel");
                    new Booking_App_XMLHttp(object._url, post, false, function(response){
                        
                        object._console.log(response);
                        bookingBlockPanel.classList.add("hidden_panel");
                        if (response.status == 'success') {
                            
                            window.location.href = object._permalink;
                            
                        }
                        
                    }, function(responseText){
                        
                        object.setResponseText(responseText);
                        
                    });
                    
                }
                
            }
            
        } else {
            
            cancelButton.classList.add("hidden_panel");
            cancelButton.disabled = true;
            
        }
        
    }
    
    Booking_App.prototype.createServicesPanel = function(calendarData, month, day, year, accountKey) {
        
        var object = this;
        var services = object._courseList;
        object._console.log(calendarData);
        object._console.log(services);
        var rootPanel = document.getElementById("booking-package_servicePage");
        if (rootPanel == null) {
            
            return null;
            
        }
        
        rootPanel.classList.remove("hidden_panel");
        
        var navigationPage = document.getElementById(object._prefix + "servicesPostPage");
        navigationPage.classList.remove("hidden_panel");
        
        object.setScrollY(rootPanel);
        var servicesPanel = rootPanel.getElementsByClassName("list")[0];
        servicesPanel.textContent = null;
        var titlePanel =  rootPanel.getElementsByClassName("title")[0];
        if (object._headingPosition == 1) {
            
            titlePanel.style.top = object._top + "px";
            
        } else {
            
            titlePanel.classList.add("noSticky");
            
        }
        
        var animationBool = true;
        var checkBoxList = {};
        var coursePanelList = [];
        object.setServicePanelList(coursePanelList);
        object.createServicesList(animationBool, checkBoxList, coursePanelList, servicesPanel, null, null, null, null, function(table_row) {
            
            var serviceKey = table_row.getAttribute("data-key");
            var service = services[parseInt(serviceKey)];
            var options = JSON.parse(service.options);
            service.selectedOptionsList = options;
            table_row.getElementsByTagName("input")[0].classList.add("hidden_panel");
            object._console.log(service);
            object._console.log(options);
            if (options.length > 0) {
                
                var optionsTitle = document.createElement("div");
                optionsTitle.classList.add("optionTitle");
                optionsTitle.textContent = object._i18n.get("Select option");
                
                var optionsPanel = document.createElement("div");
                optionsPanel.appendChild(optionsTitle);
                optionsPanel.classList.add("selectOptionList");
                table_row.appendChild(optionsPanel);
                for (var i = 0; i < options.length; i++) {
                    
                    var option = options[i];
                    option.selected = 0;
                    object._console.log(option);
                    
                    var titleLabel = document.createElement("span");
                    titleLabel.textContent = option.name;
                    
                    var optionPanel = document.createElement("div");
                    optionPanel.setAttribute("data-key", i);
                    optionPanel.setAttribute("data-serviceKey", serviceKey);
                    optionPanel.classList.add("optionPanel");
                    optionPanel.appendChild(titleLabel);
                    
                    if(option.cost != null && option.cost != 0){
                        
                        var cost = object._format.formatCost(option.cost, object._currency);
                        var optionCostPanel = document.createElement("span");
                        optionCostPanel.classList.add("courseCostPanel");
                        optionCostPanel.textContent = cost;
                        optionPanel.appendChild(optionCostPanel);
                        
                    }
                    
                    optionsPanel.appendChild(optionPanel);
                    optionPanel.onclick = function() {
                        
                        var serviceKey = parseInt(this.getAttribute("data-serviceKey"));
                        var key = parseInt(this.getAttribute("data-key"));
                        var service = services[serviceKey];
                        var option = service.selectedOptionsList[key];
                        if (object._calendarAccount.hasMultipleServices == 0) {
                            
                            (function(selectedService, selectedServiceKey){
                                
                                object._console.log(selectedService);
                                var optionsPanel = servicesPanel.getElementsByClassName("optionPanel");
                                for (var i = 0; i < optionsPanel.length; i++) {
                                    
                                    if (parseInt(optionsPanel[i].getAttribute("data-serviceKey")) != selectedServiceKey) {
                                        
                                        optionsPanel[i].classList.remove("selectedOptionPanel");
                                        
                                    }
                                    
                                }
                                
                                for (var key in services) {
                                    
                                    if (parseInt(services[key].key) != parseInt(selectedService.key)) {
                                        
                                        var options = services[key].selectedOptionsList;
                                        for (var optionKey in options) {
                                            
                                            options[optionKey].selected = 0;
                                            
                                        }
                                        
                                    }
                                    
                                }
                                
                            }(service, serviceKey));
                            
                        }
                        
                        if (parseInt(service.selectOptions) == 0) {
                            
                            var parent = this.parentNode;
                            var children = parent.getElementsByClassName("optionPanel");
                            for (var i = 0; i < children.length; i++) {
                                
                                if (parseInt(children[i].getAttribute("data-key")) != key) {
                                    
                                    children[i].classList.remove("selectedOptionPanel");
                                    
                                }
                                
                            }
                            
                            var options = service.selectedOptionsList;
                            for (var optionKey in options) {
                                
                                if(parseInt(optionKey) == key) {
                                    
                                    object._console.log(this.classList.contains("selectedOptionPanel"));
                                    if (this.classList.contains("selectedOptionPanel") === true) {
                                        
                                        this.classList.remove("selectedOptionPanel");
                                        options[optionKey].selected = 0;
                                        
                                    } else {
                                        
                                        this.classList.add("selectedOptionPanel");
                                        options[optionKey].selected = 1;
                                        
                                    }
                                    
                                } else {
                                    
                                    options[optionKey].selected = 0;
                                    
                                }
                                
                            }
                            
                        } else {
                            
                            if (option.selected == 0) {
                                
                                option.selected = 1;
                                this.classList.add("selectedOptionPanel");
                                
                            } else {
                                
                                option.selected = 0;
                                this.classList.remove("selectedOptionPanel");
                                
                            }
                            
                        }
                        
                    };
                    
                }
                
            }
            
            table_row.onclick = function() {
                
                var servicePanel = this;
                var key = this.getAttribute("data-key");
                var service = services[parseInt(key)];
                var options = service.selectedOptionsList;
                if (object._calendarAccount.hasMultipleServices == 0) {
                    
                    (function(selectedService, selectedServiceKey){
                        
                        object._console.log(selectedService);
                        var hasOptions = false;
                        if (selectedService.selectedOptionsList.length > 0) {
                            
                            hasOptions = true;
                            
                        }
                        var optionsPanel = servicesPanel.getElementsByClassName("selectPanel");
                        for (var i = 0; i < optionsPanel.length; i++) {
                            
                            if (parseInt(optionsPanel[i].getAttribute("data-key")) != selectedServiceKey) {
                                
                                optionsPanel[i].classList.remove("selectedPanel");
                                
                            }
                            
                        }
                        
                        for (var key in services) {
                            
                            if (parseInt(services[key].key) != parseInt(selectedService.key)) {
                                
                                services[key].selected = 0;
                                
                            }
                            
                            if (hasOptions === false) {
                                
                                var options = services[key].selectedOptionsList;
                                for (var optionKey in options) {
                                    
                                    options[optionKey].selected = 0;
                                    
                                }
                                
                            }
                            
                        }
                        
                        if (hasOptions === false) {
                            
                            optionsPanel = servicesPanel.getElementsByClassName("optionPanel");
                            for (var i = 0; i < optionsPanel.length; i++) {
                                
                                optionsPanel[i].classList.remove("selectedOptionPanel");
                                
                            }
                            
                        }
                        
                    }(service, key));
                    
                }
                
                if (options.length == 0) {
                    
                    if (service.selected == null || service.selected == 0) {
                        
                        service.selected = 1;
                        servicePanel.classList.add("selectedPanel");
                        
                    } else if (service.selected == 1) {
                        
                        service.selected = 0;
                        servicePanel.classList.remove("selectedPanel");
                        
                    }
                    
                } else {
                    
                    var selected = 0;
                    for (var key in options) {
                        
                        if (parseInt(options[key].selected) == 1) {
                            
                            selected = 1;
                            break;
                            
                        }
                        
                    }
                    
                    object._console.log("selected = " + selected);
                    if (selected == 1) {
                        
                        service.selected = 1;
                        servicePanel.classList.add("selectedPanel");
                        
                    } else {
                        
                        service.selected = 0;
                        servicePanel.classList.remove("selectedPanel");
                        
                    }
                    
                }
                
                object._console.log(service);
                object._console.log(services);
                object.servicesDetails(calendarData, month, day, year, accountKey);
                
            };
            
        });
        
        object.servicesDetails(calendarData, month, day, year, accountKey);
        
    };
    
    Booking_App.prototype.servicesDetails = function(calendarData, month, day, year, accountKey) {
        
        var object = this;
        var services = object._courseList;
        var serviceDetails = document.getElementById("booking-package_serviceDetails");
        serviceDetails.classList.remove("hidden_panel");
        if (object._headingPosition == 1) {
            
            serviceDetails.style.top = object._top + "px";
            
        } else {
            
            serviceDetails.classList.add("noSticky");
            
        }
        
        var navigationPage = document.getElementById(object._prefix + "servicesPostPage");
        //serviceDetails.textContent = "test";
        
        var myServiceDetails = serviceDetails.getElementsByClassName("list")[0];
        myServiceDetails.textContent = null;
        
        object._console.log(serviceDetails);
        object._console.log(services);
        object._console.log(object._top);
        
        var rowPanel = object.createRowPanel(object._courseName, "", null, null, null);
        myServiceDetails.appendChild(rowPanel);
        var valuePanel = rowPanel.getElementsByClassName("value")[0];
        valuePanel.textContent = null;
        
        var coursePanel = document.createElement("div");
        coursePanel.classList.add("mainPlan");
        valuePanel.appendChild(coursePanel);
        
        var next = false;
        var goodsList = [];
        var totalCost = 0;
        var response = object.selectedServicesPanel(next, services, goodsList, totalCost, coursePanel);
        next = response.course;
        totalCost = response.totalCost;
        
        object._console.log(next);
        if (next === true) {
            
            var surchargePanel = object.createRowPanel("Surcharge", "", null, null, null);
            surchargePanel.id = "surchargeTaxTitle";
            var taxePanel = object.createRowPanel("Surcharge and Tax", "", null, null, null);
            
            var taxes = new TAXES(object._i18n, object._currency, object._debug);
            taxes.setTaxes(object._taxes);
            taxes.taxesDetails(totalCost, myServiceDetails, surchargePanel, taxePanel);
            var responseTaxes = taxes.getTaxes();
            for (var key in responseTaxes) {
                
                var tax = responseTaxes[key];
                if (tax.active != 'true') {
                    
                    continue;
                    
                }
                
                if ((tax.type == 'tax' && tax.tax == 'tax_exclusive') || tax.type == 'surcharge') {
                    
                    totalCost += parseInt(tax.taxValue);
                    var goods = {label: tax.name, amount: parseInt(tax.taxValue)};
                    goodsList.push(goods);
                    
                }
                
            }
            
            object._console.log("totalCost = " + totalCost);
            if(totalCost != 0){
                
                var formatPrice = object._format.formatCost(totalCost, object._currency);
                var rowPanel = object.createRowPanel(object._i18n.get("Total amount"), formatPrice, null, null, null);
                rowPanel.classList.add("total_amount");
                myServiceDetails.appendChild(rowPanel);
                
            }
            
            var goToCalendarButton = document.createElement("button");
            goToCalendarButton.textContent = object._i18n.get("Choose a date");
            goToCalendarButton.classList.add("goToCalendarButton");
            myServiceDetails.appendChild(goToCalendarButton);
            goToCalendarButton.onclick = function() {
                
                navigationPage.classList.add("hidden_panel");
                document.getElementById("booking-package_servicePage").classList.add("hidden_panel");
                serviceDetails.classList.add("hidden_panel");
                object.createCalendar(calendarData, month, day, year, accountKey, function(response){
                    
                    if (response.mode == "return") {
                        
                        calendarData = response;
                        object._console.log(calendarData);
                        
                    }
                    
                });
                
            };
            
        } else {
            
            coursePanel.textContent = object._i18n.get("You have not selected anything");
            
        }
        
        
    };
    
    Booking_App.prototype.selectedServicesPanel = function(course, services, goodsList, totalCost, coursePanel) {
        
        var object = this;
        for (var key in services) {
            
            if (services[key].selected == 1) {
                
                course = true;
                var courseCostPanel = null;
                var goods = {label: services[key].name, amount: parseInt(services[key].cost)};
                goodsList.push(goods);
                totalCost += parseInt(services[key].cost);
                
                if (isNaN(parseInt(services[key].cost)) === false && parseInt(services[key].cost) != 0) {
                    
                    courseCostPanel = document.createElement("span");
                    courseCostPanel.classList.add("planPrice");
                    courseCostPanel.textContent = object._format.formatCost(services[key].cost, object._currency);
                    
                }
                
                var courseLinePanel = document.createElement("div");
                courseLinePanel.classList.add("courseLinePanel");
                coursePanel.appendChild(courseLinePanel);
                
                var courseNamePanel = document.createElement("span");
                courseNamePanel.classList.add("planName");
                courseNamePanel.textContent = services[key].name;
                courseLinePanel.appendChild(courseNamePanel);
                if (courseCostPanel != null) {
                    
                    courseLinePanel.appendChild(courseCostPanel);
                    
                }
                
                var selectedOptions = services[key].selectedOptionsList;
                if (selectedOptions != null && selectedOptions.length > 0) {
                    
                    var ul = document.createElement("ul");
                    coursePanel.appendChild(ul);
                    
                    for(var i = 0; i < selectedOptions.length; i++){
                        
                        var option = selectedOptions[i];
                        object._console.log(option);
                        if (parseInt(option.selected) == 1) {
                            
                            var goods = {label: option.name, amount: parseInt(option.cost)};
                            goodsList.push(goods);
                            totalCost += parseInt(option.cost);
                            
                            var optionNamePanel = document.createElement("span");
                            optionNamePanel.classList.add("planName");
                            optionNamePanel.textContent = option.name;
                            
                            var optionPricePanel = document.createElement("span");
                            optionPricePanel.classList.add("planPrice");
                            if (parseInt(option.cost) > 0) {
                                
                                optionPricePanel.textContent = object._format.formatCost(option.cost, object._currency);
                                
                            }
                            
                            var li = document.createElement("li");
                            li.appendChild(optionNamePanel);
                            li.appendChild(optionPricePanel);
                            ul.appendChild(li);
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }
        
        return {course: course, goodsList: goodsList, totalCost: totalCost};
        
    };
    
    Booking_App.prototype.getSelectedTotalTimeForServices = function(services) {
        
        var object = this;
        var totalTime = 0;
        for (var key in services) {
            
            if (services[key].selected == 1) {
                
                object._console.log(services[key]);
                totalTime += parseInt(services[key].time);
                var selectedOptions = services[key].selectedOptionsList;
                if (selectedOptions != null && selectedOptions.length > 0) {
                    
                    for(var i = 0; i < selectedOptions.length; i++){
                        
                        var option = selectedOptions[i];
                        if (parseInt(option.selected) == 1) {
                            
                            object._console.log(option);
                            totalTime += parseInt(option.time);
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }
        
        return totalTime;
        
    }
    
    Booking_App.prototype.createCalendar = function(calendarData, month, day, year, accountKey, callback) {
        
        month = parseInt(calendarData.date.month);
        day = parseInt(calendarData.date.day);
        year = parseInt(calendarData.date.year);
        
        var object = this;
        
        object._console.log(calendarData);
        object.setStep("topPage");
        
        var navigationPage = document.getElementById(object._prefix + "calendarPostPage");
        var calendarPanel = document.getElementById("booking-package_calendarPage");
        if (navigationPage == null && calendarPanel == null) {
            
            return null;
            
        }
        
        navigationPage.classList.remove("hidden_panel");
        
        var calendarAccount = this._calendarAccount;
        var calendarKey = object._calendar.getDateKey(month, day, year);
        object._nationalHoliday = calendarData.nationalHoliday.calendar;
        object._servicesControl.setNationalHoliday(calendarData.nationalHoliday.calendar);
        
        calendarPanel.classList.remove("hidden_panel");
        if (calendarPanel == null) {
            
            return null;
            
        }
        calendarPanel.textContent = null;
        object.setScrollY(calendarPanel);
        
        var judge = object.subscription_form();
        if (judge == false) {
            
            return null;
            
        }
        
        var checkInClearLabel = document.createElement("label");
        var checkOutClearLabel = document.createElement("label");
        if (document.getElementById("checkInClearLabel") != null) {
            
            checkInClearLabel = document.getElementById("checkInClearLabel");
            
        }
        if (document.getElementById("checkOutClearLabel") != null) {
            
            checkOutClearLabel = document.getElementById("checkOutClearLabel");
            
        }
        
        if (calendarAccount.type == "hotel" && object._lengthOfStayBool == true) {
            
            object.lengthOfStayForHotel(calendarPanel, month, day, year, checkInClearLabel, checkOutClearLabel, calendarData, accountKey);
            object._lengthOfStayBool = false;
            
        }
        
        var dayHeight = parseInt(calendarPanel.clientWidth / 7);
        var datePanel = document.createElement("div");
        datePanel.setAttribute("class", "calendarData");
        datePanel.textContent = object._calendar.formatBookingDate(month, null, year, null, null, null, null);
        object._console.log(year + "/" + month);
        
        var returnLabel = document.createElement("label");
        var nextLabel = document.createElement("label");
        var returnPanel = document.createElement("div");
        var nextPanel = document.createElement("div");
        var retrunMonth = document.createElement('span');
        var nextMonth = document.createElement('span');
        if (object._enableFixCalendar == 0) {
            
            returnLabel.setAttribute("class", "arrowLeft");
            if (month == 1) {
                
                //returnLabel.textContent = object._calendar.formatBookingDate(12, null, null, null, null, null, null);
                retrunMonth.textContent = object._calendar.formatBookingDate(12, null, null, null, null, null, null);
                
            } else {
                
                //returnLabel.textContent = object._calendar.formatBookingDate((parseInt(month) - 1), null, null, null, null, null, null);
                retrunMonth.textContent = object._calendar.formatBookingDate((parseInt(month) - 1), null, null, null, null, null, null);
                
            }
            
            var arrowRight = document.createElement("div");
            arrowRight.setAttribute("style", "font-family: 'Material Icons' !important");
            arrowRight.setAttribute("class", "material-icons arrowFont");
            arrowRight.textContent = "keyboard_arrow_left";
            //returnLabel.insertAdjacentElement("afterbegin", arrowRight);
            returnLabel.appendChild(arrowRight);
            returnLabel.appendChild(retrunMonth);
            
            returnPanel.setAttribute("class", "calendarChangeButton");
            returnPanel.insertAdjacentElement("beforeend", returnLabel);
            
            nextLabel.setAttribute("class", "arrowRight");
            if (month == 12) {
                
                //nextLabel.textContent = object._calendar.formatBookingDate(1, null, null, null, null, null, null)/** + "＞"**/;
                nextMonth.textContent = object._calendar.formatBookingDate(1, null, null, null, null, null, null);
                
            } else {
                
                //nextLabel.textContent = object._calendar.formatBookingDate((parseInt(month) + 1), null, null, null, null, null, null)/** + "＞"**/;
                nextMonth.textContent = object._calendar.formatBookingDate((parseInt(month) + 1), null, null, null, null, null, null);
                
            }
            
            var arrowLeft = document.createElement("div");
            arrowLeft.setAttribute("style", "font-family: 'Material Icons' !important");
            arrowLeft.setAttribute("class", "material-icons arrowFont");
            arrowLeft.textContent = "keyboard_arrow_right";
            //nextLabel.insertAdjacentElement("beforeend", arrowLeft);
            nextLabel.appendChild(nextMonth);
            nextLabel.appendChild(arrowLeft);
            
            nextPanel.setAttribute("style", "text-align: right;");
            nextPanel.setAttribute("class", "calendarChangeButton");
            nextPanel.insertAdjacentElement("beforeend", nextLabel);
            
        }
        
        var topPanel = document.createElement("div");
        topPanel.setAttribute("class", "calendarPanel");
        topPanel.insertAdjacentElement("beforeend", returnPanel);
        topPanel.insertAdjacentElement("beforeend", datePanel);
        topPanel.insertAdjacentElement("beforeend", nextPanel);
        calendarPanel.insertAdjacentElement("beforeend", topPanel);
        object._console.log(object._courseBool);
        var shortestTime = null;
        if (object._courseBool == true || object._calendarAccount.flowOfBooking == 'services') {
            
            var courseList = object._courseList;
            if (object._courseBool == true) {
                
                for (var i = 0; i < courseList.length; i++) {
                    
                    if (courseList[i].active == "true" && (parseInt(courseList[i].time) < shortestTime || shortestTime == null)) {
                        
                        object._console.log(courseList[i]);
                        shortestTime = parseInt(courseList[i].time);
                        
                    }
                    
                }
                
            } else {
                
                shortestTime = object.getSelectedTotalTimeForServices(courseList);
                
            }
            
        }
        
        if (object._preparationTime > 0) {
            
            if (shortestTime == null) {
                
                shortestTime = object._preparationTime;
                if (object._positionPreparationTime == 'before_after') {
                    
                    shortestTime += object._preparationTime;
                    
                }
                
            } else {
                
                shortestTime += object._preparationTime;
                if (object._positionPreparationTime == 'before_after') {
                    
                    shortestTime += object._preparationTime;
                    
                }
                
            }
            
        }
        
        object._console.log("shortestTime = " + shortestTime);
        
        var dayPanelList = {};
        var regularHoliday = calendarData.regularHoliday.calendar;
        var dayResponse = object._calendar.create(calendarPanel, calendarData, month, day, year, '', function(callback){
            
            object._console.log(callback);
            callback.select = 1;
            var dayPanel = callback.eventPanel;
            dayPanel.setAttribute('data-onclick', 1);
            dayPanel.classList.add("cell_" + callback.key);
            var rect = dayPanel.getBoundingClientRect();
            var height = parseInt(rect.width * 0.7);
            
            dayPanelList[callback.key] = callback;
            object.setDayPanelList(dayPanelList);
            object.setIndexOfDayPanelList(callback);
            
            var hotelDetails = object._hotel.getDetails();
            if (calendarAccount.type == "hotel") {
                
                dayPanel.style.height = null;
                
            }
            
            if (regularHoliday[callback.key] != null && parseInt(regularHoliday[callback.key].status) == 1) {
                
                dayPanel.classList.add("holidayPanel");
                
            }
            
            if(callback.day > 0){
                
                if (calendarData.schedule[callback.key] != null && calendarData.schedule[callback.key].length != 0) {
                    
                    if (object._calendarAccount.flowOfBooking == 'services') {
                        
                        if (callback.remainder > 0) {
                            
                            //var isBooking = object.checkTimeToProvide(parseInt(callback.month), parseInt(callback.day), parseInt(callback.year), parseInt(callback.week), false, true);
                            var isBooking = object._servicesControl.validateServices(parseInt(callback.month), parseInt(callback.day), parseInt(callback.year), parseInt(callback.week), false, false);
                            object._console.log(isBooking);
                            if (isBooking.status === false) {
                                
                                callback.status = false;
                                callback.remainder = 0;
                                dayPanel.setAttribute('data-onclick', 0);
                                dayPanel.classList.remove("nationalHoliday");
                                dayPanel.classList.remove("pointer");
                                dayPanel.classList.add("closeDay");
                                
                            }
                            
                        }
                        
                    }
                    
                    if (callback.remainder <= 0) {
                        
                        dayPanel.setAttribute('data-onclick', 0);
                        dayPanel.classList.remove("nationalHoliday");
                        dayPanel.classList.remove("pointer");
                        dayPanel.classList.add("closeDay");
                        if (calendarAccount.type == "hotel") {
                            
                            dayPanel.classList.add("pointer");
                            var indexOfDayPanel = object.getIndexOfDayPanelList();
                            var cancelIndex = parseInt(callback.index) - 1;
                            var cancelPanel = document.getElementById("booking-package-day-" + cancelIndex);
                            if (cancelPanel != null) {
                                
                                var cancelPanelData = indexOfDayPanel[cancelIndex];
                                //cancelPanel.setAttribute("data-select", 0);
                                
                                //cancelPanel.classList.remove("pointer");
                                //cancelPanel.classList.add("closeDay");
                                cancelPanel.removeEventListener("click", null, false);
                                calendarPanel.removeEventListener("click", cancelPanel, false);
                                
                            }
                            
                        }
                        /**
                        object.displayRemainingCapacityInCalendar(calendarData, callback, shortestTime, function(panel){
                            
                            
                        });
                        **/
                        //return null;
                        
                    }
                    
                    var nextAction = false;
                    for (var i = 0; i < calendarData.schedule[callback.key].length; i++) {
                        
                        nextAction = true;
                        break;
                        
                    }
                    
                    if (nextAction == false || calendarData.schedule[callback.key] == null || calendarData.schedule[callback.key][0] == null) {
                        
                        object._calendar.setStopToCreateCalendar(true);
                        window.alert(object._i18n.get("An unknown cause of error occurred"));
                        window.stop();
                        
                    }
                    
                    var stop = 0;
                    if (calendarAccount.type == "hotel" && calendarData.schedule[callback.key][0].stop == 'true') {
                        
                        dayPanel.setAttribute('data-onclick', 0);
                        dayPanel.classList.remove("nationalHoliday");
                        dayPanel.classList.remove("pointer");
                        dayPanel.classList.add("closeDay");
                        return null;
                        
                    }
                    
                    object.displayRemainingCapacityInCalendar(calendarData, callback, shortestTime, function(point){
                        
                        object._console.log('point = ' + point);
                        if (point <= 0) {
                            
                            dayPanel.setAttribute('data-onclick', 0);
                            
                        }
                        
                    });
                    
                    if (object._isExtensionsValid == 1 && calendarData.schedule[callback.key].length == 1) {
                        
                        var oneSchedule = calendarData.schedule[callback.key][0];
                        
                        var descriptionLabel = document.createElement("div");
                        descriptionLabel.setAttribute("title", oneSchedule.title);
                        descriptionLabel.classList.add("descriptionLabelForDay");
                        descriptionLabel.textContent = oneSchedule.title;
                        dayPanel.appendChild(descriptionLabel);
                        
                    }
                    
                    dayPanel.onclick = function() {
                        
                        object._console.log(this);
                        var monthKey = parseInt(this.getAttribute("data-month"));
                        var dayKey = parseInt(this.getAttribute("data-day"));
                        var yearKey = parseInt(this.getAttribute("data-year"));
                        
                        if (calendarAccount.type == "hotel") {
                            
                            var checkInPanel = document.getElementById("checkInPanel");
                            var checkOutPanel = document.getElementById("checkOutPanel");
                            
                            var checkInDatePanel = document.getElementById("checkInDate");
                            var checkOutDatePanel = document.getElementById("checkOutDate");
                            
                            var checkDate = object._hotel.getCheckDate();
                            var calendarKey = parseInt(this.getAttribute("data-key"));
                            var schedule = calendarData.schedule[calendarKey][0];
                            var date = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, null, null, null, schedule.weekKey);
                            
                            if (checkDate.checkIn == null) {
                                
                                if (schedule.remainder <= 0) {
                                    
                                    return null;
                                    
                                }
                                
                                var acceptBooking = parseInt(this.getAttribute("data-select"));
                                if (acceptBooking == 0) {
                                    
                                    return null;
                                    
                                }
                                
                                object._hotel.setCheckIn(schedule);
                                object._hotel.setCheckInKey(schedule.key);
                                var checkDate = object._hotel.getCheckDate();
                                this.classList.add("selectedDayPanel");
                                checkInClearLabel.classList.remove("hidden_panel");
                                checkInDatePanel.textContent = date;
                                checkInDatePanel.classList.remove("chooseDate");
                                
                                if (checkDate.checkOut == null) {
                                    
                                    checkOutPanel.classList.remove("hidden_panel");
                                    checkOutDatePanel.classList.add("chooseDate");
                                    
                                }
                                
                                for (var key in calendarData.schedule) {
                                    
                                    if (calendarData.schedule[key].length > 0 && checkDate.checkIn.unixTime <= calendarData.schedule[key][0].unixTime) {
                                        
                                        object._hotel.addSchedule(calendarData.schedule[key][0]);
                                        
                                    }
                                    
                                    if (key < calendarKey) {
                                        
                                        dayPanelList[key].select = 0;
                                        
                                    }
                                    
                                }
                                
                                if (checkDate.checkOut != null && parseInt(checkDate.checkOut.unixTime) > parseInt(schedule.unixTime)) {
                                    
                                    var verifySchedule = object._hotel.verifySchedule(true);
                                    if (verifySchedule.status == true) {
                                        
                                        object.validateRangeForHotel(calendarKey, dayPanelList, verifySchedule);
                                        
                                        
                                    }
                                    
                                }
                                
                                object._hotel.pushCallback();
                                
                            } else if (checkDate.checkIn != null) {
                                
                                if (parseInt(checkDate.checkIn.unixTime) < parseInt(schedule.unixTime)) {
                                    
                                    object._hotel.setCheckOut(schedule);
                                    object._hotel.setCheckOutKey(schedule.key);
                                    
                                    for (var key in calendarData.schedule) {
                                        
                                        if (calendarData.schedule[key].length > 0 && schedule.unixTime >= calendarData.schedule[key][0].unixTime) {
                                            
                                            object._hotel.addSchedule(calendarData.schedule[key][0]);
                                            
                                        }
                                        
                                    }
                                    
                                    var verifySchedule = object._hotel.verifySchedule(true);
                                    if (verifySchedule.status == true) {
                                        
                                        object.validateRangeForHotel(calendarKey, dayPanelList, verifySchedule);
                                        this.classList.add("selectedDayPanel");
                                        checkOutClearLabel.classList.remove("hidden_panel");
                                        checkOutDatePanel.textContent = date;
                                        checkOutDatePanel.classList.remove("chooseDate");
                                        object._hotel.pushCallback();
                                        
                                    } else {
                                        
                                        object.checkOutClearLabel();
                                        
                                    }
                                    
                                }
                                
                            }
                            
                            
                        } else {
                            
                            if (this.getAttribute('data-onclick') != null && parseInt(this.getAttribute('data-onclick')) == 0) {
                                
                                return null;
                                
                            }
                            
                            navigationPage.classList.add("hidden_panel");
                            if (object._courseBool == true && object._courseList.length == 0) {
                                
                                window.alert("There is no service available.");
                                return null;
                                
                            }
                            
                            object.selectCourseAndSchedulePanel(monthKey, dayKey, yearKey, calendarData, accountKey, function(response){
                                
                                object._console.log(response);
                                if (response.mode == 'return') {
                                    
                                    calendarData = response;
                                    
                                }
                                
                            });
                            
                        }
                        
                    }
                    
                    if (calendarAccount.type == 'hotel') {
                        
                        var checkDate = object._hotel.getCheckDate();
                        var checkInKey = null;
                        if (checkDate.checkIn != null) {
                            
                            checkInKey = object._calendar.getDateKey(checkDate.checkIn.month, checkDate.checkIn.day, checkDate.checkIn.year);
                            if (dayPanelList[checkInKey] != null) {
                                
                                dayPanelList[checkInKey].select = 1;
                                for (var key in dayPanelList) {
                                    
                                    if (calendarData.schedule[key].length > 0 && checkDate.checkIn.unixTime <= calendarData.schedule[key][0].unixTime) {
                                        
                                        object._hotel.addSchedule(calendarData.schedule[key][0]);
                                        
                                    }
                                    
                                }
                                
                            }
                            
                        }
                        
                        if (checkDate.checkIn != null && checkDate.checkOut != null) {
                            
                            var checkOutKey = object._calendar.getDateKey(checkDate.checkOut.month, checkDate.checkOut.day, checkDate.checkOut.year);
                            for (var key in dayPanelList) {
                                
                                if (key >= checkInKey && key <= checkOutKey) {
                                    
                                    dayPanelList[key].select = 1;
                                    dayPanelList[key].eventPanel.classList.add("selectedDayPanel");
                                    
                                } else {
                                    
                                    dayPanelList[key].select = 0;
                                    
                                }
                                
                                if (calendarData.schedule[key].length > 0 && checkDate.checkIn.unixTime <= calendarData.schedule[key][0].unixTime) {
                                    
                                    object._hotel.addSchedule(calendarData.schedule[key][0]);
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                } else {
                    
                    dayPanel.setAttribute('data-onclick', 0);
                    dayPanel.classList.remove("nationalHoliday");
                    dayPanel.classList.remove("pointer");
                    dayPanel.classList.add("closeDay");
                    
                }
                
            }
            
	    });
	    
	    if (object._calendarAccount.flowOfBooking == 'services') {
	        
	        var returnButton = document.createElement("button");
            returnButton.classList.add("returnButton");
            returnButton.classList.add("bookingButton");
            returnButton.textContent = object.i18n("Return");
            calendarPanel.appendChild(returnButton);
            object.setScrollY(calendarPanel);
            returnButton.onclick = function() {
                
                navigationPage.classList.add("hidden_panel");
                document.getElementById(object._prefix + "servicesPostPage").classList.remove("hidden_panel");
                document.getElementById("booking-package_servicePage").classList.remove("hidden_panel");
                document.getElementById("booking-package_serviceDetails").classList.remove("hidden_panel");
                object.setScrollY(document.getElementById("booking-package_servicePage"));
                //calendarPanel.classList.add("hidden_panel");
                calendarPanel.textContent = null;
                object._console.log(callback);
                if (callback != null) {
                    
                    callback(calendarData);
                    
                }
                
            };
	        
	    }
	    
        var rect = calendarPanel.getBoundingClientRect();
        
        returnLabel.onclick = function(){
            
            if (month == 1) {
                
                year--;
		        month = 12;
                
            } else {
                
                month--;
                
            }
            
            var stateObj = {page: "previousPage", month: month, day: 1, year: year, accountKey: accountKey};
            window.history.pushState(stateObj, null, "#previousPage");
            
            object.getReservationData(month, 1, year, accountKey, true, true, null);
        
        }
        
        nextLabel.onclick = function(){
            
            if (month == 12) {
                
                year++;
                month = 1;
                
            } else {
                
                month++;
		        
            }
            
            var stateObj = {page: "nextPage", month: month, day: 1, year: year, accountKey: accountKey};
            window.history.pushState(stateObj, null, "#nextPage");
            
            object.getReservationData(month, 1, year, accountKey, true, true, null);
            
        }
        
    }
    
    Booking_App.prototype.displayRemainingCapacityInCalendar = function(calendarData, element, shortestTime, callback){
        
        var object = this;
        object._console.log(element);
        object._console.log('shortestTime = ' + shortestTime);
        var calendarAccount = object._calendarAccount;
        var createSymbolPanel = function(calendarAccount, point, capacity, remainder) {
            
            object._console.log("point = " + point);
            var symbolPanel = document.createElement("div");
            
            if (parseInt(calendarAccount.displayRemainingCapacityInCalendarAsNumber) == 1) {
                
                symbolPanel.classList.add("numberInsteadOfSymbols");
                symbolPanel.textContent = remainder;
                return symbolPanel;
                
            }
            
            symbolPanel.classList.add("symbolPanel");
            symbolPanel.classList.add("material-icons");
            symbolPanel.setAttribute("style", "font-family :'Material Icons' !important;");
            var displayThresholdOfRemainingCapacity = parseInt(calendarAccount.displayThresholdOfRemainingCapacity);
            if (point >= displayThresholdOfRemainingCapacity && object.isJSON(calendarAccount.displayRemainingCapacityHasMoreThenThreshold) == true) {
                
                var remainingCapacity = JSON.parse(calendarAccount.displayRemainingCapacityHasMoreThenThreshold);
                symbolPanel.textContent = remainingCapacity.symbol;
                symbolPanel.style.color = remainingCapacity.color;
                
            } else if (point < displayThresholdOfRemainingCapacity && point > 0 && object.isJSON(calendarAccount.displayRemainingCapacityHasLessThenThreshold) == true) {
                
                var remainingCapacity = JSON.parse(calendarAccount.displayRemainingCapacityHasLessThenThreshold);
                symbolPanel.textContent = remainingCapacity.symbol;
                symbolPanel.style.color = remainingCapacity.color;
                
            } else if (point <= 0 && object.isJSON(calendarAccount.displayRemainingCapacityHas0) == true) {
                
                var remainingCapacity = JSON.parse(calendarAccount.displayRemainingCapacityHas0);
                symbolPanel.textContent = remainingCapacity.symbol;
                symbolPanel.style.color = remainingCapacity.color;
                
            }
            
            return symbolPanel;
            
        };
        
        //if (calendarAccount.displayRemainingCapacityInCalendar != null && parseInt(calendarAccount.displayRemainingCapacityInCalendar) == 1) {
            
        var calendarKey = parseInt(element.key);
        var panel = element.eventPanel;
        var regularHoliday = calendarData.regularHoliday.calendar;
        if (regularHoliday[calendarKey] != null && parseInt(regularHoliday[calendarKey].status) == 0) {
            
            var schedules = calendarData.schedule;
            var point = 0;
            var capacity = 0;
            var remainder = 0;
            if (parseInt(calendarAccount.courseBool) == 1) {
                
                object._console.log(schedules[calendarKey]);
                var remainderMap = {};
                for (var i = 0; i < calendarData['schedule'][calendarKey].length; i++) {
                    
                    if (element.status === false) {
                        
                        break;
                        
                    }
                    var schedule = calendarData['schedule'][calendarKey][i];
                    capacity += parseInt(schedule.capacity);
                    remainder += parseInt(schedule.remainder);
                    if (parseInt(schedule["remainder"]) == 0 || schedule["stop"] == 'true') {
                        
                        var rejectionTime = (parseInt(schedule["hour"]) * 60 + parseInt(schedule["min"])) - shortestTime;
                        object._console.log(schedule["hour"] + ' : ' + schedule["min"]);
                        (function(schedule, key, courseTime, rejectionTime, callback) {
                            
                            for (var i = 0; i < schedule.length; i++) {
                                
                                var time = parseInt(schedule[i]["hour"]) * 60 + parseInt(schedule[i]["min"]);
                                if (time > rejectionTime && i < key) {
                                    
                                    callback(parseInt(schedule[i].remainder), time);
                                    
                                }
                                
                                if (i == key) {
                                    
                                    if (schedule[i].stop == 'true') {
                                        
                                        callback(parseInt(schedule[i].remainder), time);
                                        
                                    }
                                    break;
                                    
                                }
                                
                            }
                            
                        })(calendarData['schedule'][calendarKey], i, shortestTime, rejectionTime, function(responseRemainder, time) {
                            
                            if (remainderMap[time] == null) {
                                
                                remainder -= responseRemainder;
                                remainderMap[time] = 1;
                                
                            }
                            
                        });
                        
                    }
                    
                }
                
                object._console.log("capacity = " + capacity + " remainder = " + remainder);
                if (capacity > 0) {
                    
                    point = remainder / capacity * 100;
                    
                } else {
                    
                    point = 0;
                    
                }
                
                if (calendarAccount.displayRemainingCapacityInCalendar != null && parseInt(calendarAccount.displayRemainingCapacityInCalendar) == 1) {
                    
                    var symbolPanel = createSymbolPanel(calendarAccount, point, capacity, remainder);
                    panel.appendChild(symbolPanel);
                    
                }
                
                if (point <= 0) {
                    
                    panel.classList.add("closeDay");
                    panel.classList.remove("pointer");
                    
                }
                
                callback(point);
                
            } else {
                
                capacity = parseInt(element.capacity);
                remainder = parseInt(element.remainder);
                point = remainder / capacity * 100;
                if (calendarAccount.displayRemainingCapacityInCalendar != null && parseInt(calendarAccount.displayRemainingCapacityInCalendar) == 1) {
                    
                    var symbolPanel = createSymbolPanel(calendarAccount, point, capacity, remainder);
                    panel.appendChild(symbolPanel);
                    
                }
                
                callback(point);
                
            }
            
        }
            
        //}
        
    }
    
    Booking_App.prototype.chageTop = function(elementTop){
        
        var object = this;
        if(document.getElementById("courseMainPanel") != null && document.getElementById("courseMainPanel").classList.contains("positionSticky") === true){
            
            document.getElementById("topPanel").style.top = elementTop + "px";
            document.getElementById("courseMainPanel").style.top = (elementTop + object._topPanelHeight) + "px";
            
        }
        
        if(document.getElementById("daysListPanel") != null && document.getElementById("daysListPanel").classList.contains("positionSticky") === true){
            
            document.getElementById("topPanel").style.top = elementTop + "px";
            document.getElementById("daysListPanel").style.top = (elementTop + object._topPanelHeight) + "px";
            
        }
        
    }
    
    Booking_App.prototype.changeHeight = function(rect){
        
        var object = this;
        object._console.log(rect);
        if(rect != null){
            
            var height = rect.height;
            var schedulePage = document.getElementById("booking-package_schedulePage");
            var topPanel = document.getElementById("topPanel");
            var daysListPanel = document.getElementById("daysListPanel").style.height = height + "px";
            var courseMainPanel = document.getElementById("courseMainPanel").style.height = height + "px";
            var optionsMainPanel = document.getElementById("optionsMainPanel");
            if(optionsMainPanel.classList.contains("hidden_panel") == false){
                
                optionsMainPanel = document.getElementById("optionsMainPanel").style.height = height + "px";
                
            }
            
            //optionsMainPanel = document.getElementById("optionsMainPanel").style.height = height + "px";
            var scheduleMainPanel = document.getElementById("scheduleMainPanel").style.height = height + "px";
            //var blockPanel = document.getElementById("blockPanel").style.height = (window.innerWidth - schedulePage.getBoundingClientRect().top - this._top) + "px";
            //var blockPanel = document.getElementById("blockPanel").style.height = height + "px";
            
        }else{
            
            var schedulePage = document.getElementById("booking-package_schedulePage").style.height = null;
            var topPanel = document.getElementById("topPanel");
            var daysListPanel = document.getElementById("daysListPanel").style.height = null;
            var courseMainPanel = document.getElementById("courseMainPanel").style.height = null;
            var optionsMainPanel = document.getElementById("optionsMainPanel").style.height = null;
            var scheduleMainPanel = document.getElementById("scheduleMainPanel").style.height = null;
            var blockPanel = document.getElementById("blockPanel").style.height = null;
            
        }
        
        
        
        
    }
    
    Booking_App.prototype.validateRangeForHotel = function(calendarKey, dayPanelList, verifySchedule){
        
        var object = this;
        object._console.log(verifySchedule);
        var rangeList = {};
        for(var key in verifySchedule.list){
            
            var schedule = verifySchedule.list[key];
            var rangeKey = object._calendar.getDateKey(schedule.month, schedule.day, schedule.year);
            rangeList[rangeKey] = schedule;
            
        }
        
        for(var key in dayPanelList){
            
            if(rangeList[key] != null || calendarKey == key){
                
                dayPanelList[key].eventPanel.classList.add("selectedDayPanel");
                dayPanelList[key].select = 1;
                
            }else{
                
                dayPanelList[key].eventPanel.classList.remove("selectedDayPanel");
                dayPanelList[key].select = 0;
                
            }
            
        }
        
    }
    
    Booking_App.prototype.addPanel = function(name, panel){
        
        this._chagePanelList[name] = panel;
        
    }
    
    Booking_App.prototype.lengthOfStayForHotel = function(calendarPanel, month, day, year, checkInClearLabel, checkOutClearLabel, calendarData, accountKey){
        
        
        var object = this;
        object._console.log("object._top = " + object._top);
        var totalNumberOfGuestsPanel = object.createRowPanel(object._i18n.get("Total number of guests"), String(0), "totalGuests", null, null);
        totalNumberOfGuestsPanel.id = "totalLengthOfGuestsPanel";
        var bookingNowButton = document.createElement("button");
        object._hotel.setCalendarAccount(object._calendarAccount);
        calendarPanel.classList.add("calendarWidthForHotel");
        
        var navigationPage = document.getElementById(object._prefix + "calendarPostPage");
        var durationStay = document.getElementById("booking-package_durationStay");
        durationStay.removeAttribute("class");
        durationStay.removeAttribute("style");
        durationStay.textContent = null;
        
        var hotelDetails = {};
        
        var bookingDetailsTitle = document.createElement("div");
        bookingDetailsTitle.classList.add("bookingDetailsTitle");
        bookingDetailsTitle.textContent = object._i18n.get("Your Booking Details");
        
        if (object._headingPosition == 1) {
            
            calendarPanel.setAttribute("style", "top: " + object._top + "px;");
            bookingDetailsTitle.setAttribute("style", "top: " + object._top + "px;");
            
        }
        
        //checkInClearLabel = document.createElement("label");
        checkInClearLabel.id = "checkInClearLabel";
        checkInClearLabel.textContent = object._i18n.get("Clear");
        checkInClearLabel.setAttribute("class", "clearLabel hidden_panel");
        
        //checkOutClearLabel = document.createElement("label");
        checkOutClearLabel.id = "checkOutClearLabel";
        checkOutClearLabel.textContent = object._i18n.get("Clear");
        checkOutClearLabel.setAttribute("class", "clearLabel hidden_panel");
        
        var expressionsCheck = object._calendar.getExpressionsCheck(parseInt(object._calendarAccount.expressionsCheck));
        
        var checkInDatePanel = document.createElement("div");
        checkInDatePanel.id = "checkInDate";
        checkInDatePanel.textContent = expressionsCheck.chooseArrival;
        
        var checkOutDatePanel = document.createElement("div");
        checkOutDatePanel.id = "checkOutDate";
        checkOutDatePanel.textContent = expressionsCheck.chooseDeparture;
        
        
        var checkInPanel = object.createRowPanel(expressionsCheck.arrival, checkInDatePanel, null, null, checkInClearLabel);
        checkInPanel.id = "checkInPanel";
        var checkOutPanel = object.createRowPanel(expressionsCheck.departure, checkOutDatePanel, null, null, checkOutClearLabel);
        checkOutPanel.id = "checkOutPanel";
        checkOutPanel.classList.add("hidden_panel");
        
        checkInDatePanel.classList.add("chooseDate");
        
        var guestsListPanel = document.createElement("div");
        guestsListPanel.id = 'guestsListPanel';
        guestsListPanel.classList.add("hidden_panel");
        
        /**
        durationStay.appendChild(bookingDetailsTitle);
        durationStay.appendChild(checkInPanel);
        durationStay.appendChild(checkOutPanel);
        durationStay.appendChild(guestsListPanel);
        **/
        
        durationStay.insertAdjacentElement("beforeend", bookingDetailsTitle);
        durationStay.insertAdjacentElement("beforeend", checkInPanel);
        durationStay.insertAdjacentElement("beforeend", checkOutPanel);
        durationStay.insertAdjacentElement("beforeend", guestsListPanel);
        
        var guestsList = object.getGuestsList();
        var totalLengthOfStayValue = document.createElement("div");
        totalLengthOfStayValue.id = "totalLengthOfStayValue";
        var totalLengthOfStay = object.createRowPanel(object._i18n.get("Total length of stay"), totalLengthOfStayValue, null, null, null);
        //guestsListPanel.appendChild(totalLengthOfStay);
        guestsListPanel.insertAdjacentElement("beforeend", totalLengthOfStay);
        
        var roomListPanel = document.createElement('div');
        roomListPanel.id = 'roomListPanel';
        guestsListPanel.insertAdjacentElement("beforeend", roomListPanel);
        
        var roomPanel = object.addGuestsForRoom(guestsList, bookingNowButton, totalNumberOfGuestsPanel, 0, parseInt(object._calendarAccount.multipleRooms), false);
        roomListPanel.insertAdjacentElement("beforeend", roomPanel);
        
        if (parseInt(object._calendarAccount.multipleRooms) == 1) {
            
            object._console.log('multipleRooms = ' + object._calendarAccount.multipleRooms);
            var addRoomButton = document.createElement('label');
            addRoomButton.id = 'addRoomButton';
            addRoomButton.classList.add('addRoomButton');
            addRoomButton.textContent = object._i18n.get('Add another room');
            addRoomButton.onclick = function(event) {
                
                bookingNowButton.disabled = true;
                bookingNowButton.classList.add("hidden_panel");
                var visitorDetails = object._hotel.getDetails();
                object._console.log(visitorDetails);
                if (visitorDetails.applicantCount < visitorDetails.vacancy) {
                    
                    var roomNumber = object._hotel.getNewRoomNumber();
                    object._console.log('roomNumber = ' + roomNumber);
                    var roomPanel = object.addGuestsForRoom(guestsList, bookingNowButton, totalNumberOfGuestsPanel, roomNumber, parseInt(object._calendarAccount.multipleRooms), true);
                    roomListPanel.insertAdjacentElement("beforeend", roomPanel);
                    object._hotel.addedRoom();
                    object.updateRoomNumber();
                    
                }
                
            };
            
            var addRoomPanel = document.createElement('div');
            addRoomPanel.classList.add('row');
            guestsListPanel.insertAdjacentElement("beforeend", addRoomPanel);
            addRoomPanel.appendChild(addRoomButton);
            
            
        }
        
        
        /**
        for (var key in guestsList) {
            
            var guests = guestsList[key];
            var list = guestsList[key].json;
            if(typeof guestsList[key].json == 'string'){
                
                list = JSON.parse(guestsList[key].json);
                
            }
            
            var values = [];
            for(var i = 0; i < list.length; i++){
                
                values.push(list[i].name);
                
            }
            
            guestsList[key].values = values;
            guestsList[key].type = "SELECT";
            guestsList[key].value = 0;
            guestsList[key].index = 0;
            guestsList[key].person = 0;
            object._hotel.addGuests(key, guestsList[key], 1);
            if(list[0] != null){
                
                guestsList[key].person = parseInt(list[0].number);
                var response = object._hotel.setGuests(key, 0, list[0].number, 1);
                
            }
            
            var input = new Booking_Package_Input(object._debug);
            input.setPrefix(object._prefix);
            var guestsSelectPanel = input.createInput(guestsList[key]['name'].replace(/\\/g, ""), guestsList[key], {}, function(event){
                
                var key = this.parentElement.getAttribute("data-guset");
                var index = parseInt(this.selectedIndex);
                var list = guestsList[key].json;
                if(typeof guestsList[key].json == 'string'){
                    
                    list = JSON.parse(guestsList[key].json);
                    
                }
                guestsList[key].index = index;
                var response = object._hotel.setGuests(key, index, list[index].number, 1);
                var feeList = object._hotel.getFeeList();
                
                var gutsetsValue = document.getElementById("guestsValue_" + key);
                if(0 < index){
                    
                    gutsetsValue.textContent = list[index].name;
                    
                }else{
                    
                    gutsetsValue.textContent = null;
                    
                }
               
                
                object._hotel.pushCallback();
                
                var taxAmount = 0;
                for(var key in response.taxes) {
                    
                    if ((response.taxes[key].type == 'tax' && response.taxes[key].tax == 'tax_exclusive') || response.taxes[key].type == 'surcharge') {
                        
                        taxAmount += response.taxes[key].taxValue;
                        
                    }
                    
                }
                
                object._console.log("taxAmount = " + taxAmount);
                object._console.log(feeList);
                //document.getElementById("bookingPrice").textContent = object._format.formatCost((feeList.additionalFee * response.nights) + response.amount + taxAmount, object._currency);
                document.getElementById("bookingPrice").textContent = object._format.formatCost((feeList.additionalFee * response.nights) + (response.amount * response.applicantCount) + taxAmount, object._currency);
                if(response.booking == false || response.nights == 0 || response.requiredGuests == false){
                    
                    bookingNowButton.disabled = true;
                    bookingNowButton.classList.add("hidden_panel");
                    
                }else{
                    
                    bookingNowButton.disabled = false;
                    bookingNowButton.classList.remove("hidden_panel");
                    
                }
                
                totalNumberOfGuestsPanel.classList.remove("errorPanel");
                if(response.booking == false){
                    
                    totalNumberOfGuestsPanel.classList.add("errorPanel");
                    
                }
                
            });
            
            var guestsLabel = document.createElement("div");
            guestsLabel.id = "guestsValue_" + key;
            guestsLabel.setAttribute("class", "value hidden_panel");
            
            guestsSelectPanel.setAttribute("data-guset", key);
            guestsSelectPanel.id = "guestsSelect_" + key;
            var required = parseInt(guestsList[key].required);
            var rowPanel = object.createRowPanel(guestsList[key]['name'].replace(/\\/g, ""), guestsSelectPanel, null, required, guestsLabel);
            //guestsListPanel.appendChild(rowPanel);
            roomListPanel.insertAdjacentElement("beforeend", rowPanel);
            
        }
        **/
        
        
        //guestsListPanel.appendChild(totalNumberOfGuestsPanel);
        guestsListPanel.insertAdjacentElement("beforeend", totalNumberOfGuestsPanel);
        
        /**
        var totalLengthOfStayValue = document.createElement("div");
        totalLengthOfStayValue.id = "totalLengthOfStayValue";
        
        var totalLengthOfStay = object.createRowPanel(object._i18n.get("Total length of stay"), totalLengthOfStayValue, null, null, null);
        guestsListPanel.appendChild(totalLengthOfStay);
        **/
        
        /**
        var additionalFeeForNightsPanel = document.createElement("div");
        additionalFeeForNightsPanel.classList.add("forNights");
        var additionalFeePanel = object.createRowPanel(object._i18n.get("Additional fees"), String(0), "additionalFee", null, additionalFeeForNightsPanel);
        additionalFeePanel.id = "additionalFeePanel";
        guestsListPanel.appendChild(additionalFeePanel);
        **/
        
        var accommodationFeePanelForNightsPanel = document.createElement("div");
        accommodationFeePanelForNightsPanel.classList.add("forNights");
        /**
        var accommodationFeePanel = object.createRowPanel(object._i18n.get("Accommodation fees"), String(0), "bookingFee", null, accommodationFeePanelForNightsPanel);
        guestsListPanel.appendChild(accommodationFeePanel);
        **/
        
        var summaryListPanel = document.createElement("div");
        summaryListPanel.id = "summaryListPanel";
        var summaryPanel = object.createRowPanel(object._i18n.get("Summary"), summaryListPanel, "summaryPanel", null, null);
        summaryPanel.classList.add("summary");
        //guestsListPanel.appendChild(summaryPanel);
        guestsListPanel.insertAdjacentElement("beforeend", summaryPanel);
        
        var totalFeePanel = object.createRowPanel(object._i18n.get("Total amount"), String(0), "bookingPrice", null, null);
        totalFeePanel.setAttribute("style", "border-width: 0;");
        totalFeePanel.classList.add("total_amount");
        //guestsListPanel.appendChild(totalFeePanel);
        guestsListPanel.insertAdjacentElement("beforeend", totalFeePanel);
        
        
        bookingNowButton.classList.add("goToBookingFormButton")
        bookingNowButton.textContent = object._i18n.get("Next");
        bookingNowButton.classList.add("hidden_panel");
        bookingNowButton.disabled = true;
        //guestsListPanel.appendChild(bookingNowButton);
        guestsListPanel.insertAdjacentElement("beforeend", bookingNowButton);
        
        object.addPanel("calendarPanel", calendarPanel);
        object.addPanel("durationStay", durationStay);
        object.addPanel("checkInDatePanel", checkInDatePanel);
        object.addPanel("checkOutDatePanel", checkOutDatePanel);
        
        if(object._screen_width <= object._screen_width_limit){
            
            //calendarPanel.classList.add("hidden_panel");
            
        }
            
        checkInDatePanel.onclick = function(){
            
            if(object._screen_width <= object._screen_width_limit){
                
                object.setStep("selectDayPage");
                calendarPanel.classList.remove("hidden_panel");
                durationStay.classList.add("hidden_panel");
            
            }
            
        }
        
        checkOutDatePanel.onclick = function(){
            
            if(object._screen_width <= object._screen_width_limit){
                
                object.setStep("selectDayPage");
                calendarPanel.classList.remove("hidden_panel");
                durationStay.classList.add("hidden_panel");
            
            }
            
        }
            
        
        
        object._hotel.setCallback(function(response){
            
            var checkDate = object._hotel.getCheckDate();
            object._console.log(response);
            var verifyGuests = object._hotel.verifyGuestsInRooms(response.rooms);
            if(response.status == true || response.guests == false){
                
                object._hotel.showSummary(summaryListPanel, expressionsCheck);
                if(response.booking == true && response.guests == false && object._step != 'inputPage'){    
                    
                    bookingNowButton.disabled = false;
                    bookingNowButton.classList.remove("hidden_panel");
                    document.getElementById("totalLengthOfGuestsPanel").classList.add("hidden_panel");
                    //document.getElementById("additionalFeePanel").classList.add("hidden_panel");
                
                }else if(verifyGuests.booking == true && response.guests == true){
                    /**
                    bookingNowButton.disabled = false;
                    bookingNowButton.classList.remove("hidden_panel");
                    document.getElementById("totalLengthOfGuestsPanel").classList.add("hidden_panel");
                    document.getElementById("additionalFeePanel").classList.add("hidden_panel");
                    **/
                }
                
                if(object._screen_width <= object._screen_width_limit){
                    
                    object.setStep("topPage");
                    //calendarPanel.classList.add("hidden_panel");
                    durationStay.classList.remove("hidden_panel");
                    
                }
                
                if(response.nights > 0 && checkDate.checkIn != null && checkDate.checkOut != null){
                    
                    guestsListPanel.classList.remove("hidden_panel");
                    
                }
                
                var nightsValue = response.nights + " " + object._i18n.get("nights");
                if (response.nights == 1) {
                    
                    nightsValue = response.nights + " " + object._i18n.get("night");;
                    
                }
                totalLengthOfStayValue.textContent = nightsValue;
                
                var totalNumberOfGuests = 0;
                var additionalFee = 0;
                for (var roomKey in response.rooms) {
                    
                    var room = response.rooms[roomKey];
                    totalNumberOfGuests += room.person;
                    additionalFee += room.additionalFee;
                    
                }
                
                //var totalNumberOfGuests = parseInt(response.adult) + parseInt(response.children);
                var totalNumberOfGuestsValue = 0;
                if (totalNumberOfGuests > 1) {
                    
                    totalNumberOfGuestsValue = totalNumberOfGuests + " " + object._i18n.get("people");
                    
                } else if (totalNumberOfGuests == 1) {
                    
                    totalNumberOfGuestsValue = totalNumberOfGuests + " " + object._i18n.get("person");
                    
                }
                document.getElementById("totalGuests").textContent = totalNumberOfGuestsValue;
                
                var taxAmount = 0;
                for (var key in response.taxes) {
                    
                    object._console.log(response.taxes[key]);
                    if ((response.taxes[key].type == 'tax' && response.taxes[key].tax == 'tax_exclusive') || response.taxes[key].type == 'surcharge') {
                        
                        taxAmount += response.taxes[key].taxValue;
                        
                    }
                    
                }
                
                object._console.log("taxAmount = " + taxAmount);
                
                var additionalFee = object._format.formatCost((response.amount * response.applicantCount) + taxAmount + (additionalFee * response.nights), object._currency);
                document.getElementById("bookingPrice").textContent = additionalFee;
                
                //var nightsText = "(for " + response.nights + " nights)";
                var nightsText = object._i18n.get("(for %s nights)", [response.nights]);
                if(response.nights == 1){
                    
                    //nightsText = "(for " + 1 + " night)";
                    nightsText = object._i18n.get("(for %s night)", [response.nights]);
                    
                }
                //additionalFeeForNightsPanel accommodationFeePanelForNightsPanel
                //additionalFeeForNightsPanel.textContent = nightsText;
                //accommodationFeePanelForNightsPanel.textContent = nightsText;
                
            }else{
                
                guestsListPanel.classList.add("hidden_panel");
                
            }
            
        });
        
        checkInClearLabel.onclick = function(){
            
            guestsListPanel.classList.add("hidden_panel");
            var dayPanelList = object.getDayPanelList();
            var checkDate = object._hotel.getCheckDate();
            var checkInDate = checkDate.checkIn;
            var checkOutDate = checkDate.checkOut;
            var checkInKey = null;
            var checkOutKey = null;
            
            if(checkInDate != null){
                
                checkInKey = object._calendar.getDateKey(checkInDate.month, checkInDate.day, checkInDate.year);
                
            }
            
            if(checkOutDate != null){
                
                checkOutKey = object._calendar.getDateKey(checkOutDate.month, checkOutDate.day, checkOutDate.year);
                
            }
            
            for(var key in dayPanelList){
                    
                dayPanelList[key].select = 0;
                dayPanelList[key].eventPanel.classList.remove("selectedDayPanel");
                    
            }
            
            //var expressionsCheck = object._calendar.getExpressionsCheck(parseInt(object._calendarAccount.expressionsCheck));
            
            checkInDatePanel.textContent = expressionsCheck.chooseArrival;
            checkInDatePanel.classList.add("chooseDate");
            checkInClearLabel.classList.add("hidden_panel");
            
            checkOutDatePanel.textContent = expressionsCheck.chooseDeparture;
            checkOutDatePanel.classList.add("chooseDate");
            checkOutPanel.classList.add("hidden_panel");
            checkOutClearLabel.classList.add("hidden_panel");
            
            object._hotel.setCheckIn(null);
            object._hotel.setCheckInKey(null)
            object._hotel.setCheckOut(null);
            object._hotel.setCheckOutKey(null);
            
        }
        
        checkOutClearLabel.onclick = function(){
            
            object.checkOutClearLabel();
            
            /**
            guestsListPanel.classList.add("hidden_panel");
            var dayPanelList = object.getDayPanelList();
            var checkDate = object._hotel.getCheckDate();
            var checkInDate = checkDate.checkIn;
            var checkOutDate = checkDate.checkOut;
            var checkInKey = null;
            var checkOutKey = null;
            
            if(checkInDate != null){
                
                checkInKey = object._calendar.getDateKey(checkInDate.month, checkInDate.day, checkInDate.year);
                
            }
            
            if(checkOutDate != null){
                
                checkOutKey = object._calendar.getDateKey(checkOutDate.month, checkOutDate.day, checkOutDate.year);
                
            }
            
            if(checkInKey != null){
                
                for(var key in dayPanelList){
                    
                    if(checkInKey != key){
                        
                        dayPanelList[key].select = 0;
                        dayPanelList[key].eventPanel.classList.remove("selectedDayPanel");
                        
                    }
                    
                }
                
            }
            
            checkOutDatePanel.textContent = expressionsCheck.chooseDeparture;
            checkOutDatePanel.classList.add("chooseDate");
            checkOutClearLabel.classList.add("hidden_panel");
            object._hotel.setCheckOut(null);
            object._hotel.setCheckOutKey(null);
            object._console.log(object._hotel.getCheckDate());
            **/
        }
        
        bookingNowButton.onclick = function(){
            
            var calendarPage = document.getElementById("booking-package_calendarPage");
            var durationStay = document.getElementById("booking-package_durationStay");
            var formPanel = document.getElementById("booking-package_inputFormPanel");
            var top = 0;
            var response = object._hotel.verifySchedule(true);
            var checkDate = object._hotel.getCheckDate();
            var month = parseInt(checkDate.checkIn.month);
            var day = parseInt(checkDate.checkIn.day);
            var year = parseInt(checkDate.checkIn.year);
            if (response.booking == true && response.status == true) {
                
                /** Rooms **/
                var guestsList = object.getGuestsList();
                for (var roomKey in response.rooms) {
                    
                    var room = response.rooms[roomKey];
                    for (var key in guestsList) {
                        
                        var gutsetsValue = document.getElementById("guestsValue_" + roomKey + '_' + key);
                        var gutsetsSelect = document.getElementById("guestsSelect_" + roomKey + '_' + key);
                        gutsetsValue.classList.remove("hidden_panel");
                        gutsetsSelect.classList.add("hidden_panel");
                        
                    }
                    
                }
                
                var deleteRoomButtons = roomListPanel.getElementsByClassName('deleteRoomButton');
                for (var i = 0; i < deleteRoomButtons.length; i++) {
                    
                    deleteRoomButtons[i].classList.add('hidden_panel');
                    
                }
                /** Rooms **/
                
                /**
                var guestsList = object.getGuestsList();
                for (var key in guestsList) {
                    
                    var gutsetsValue = document.getElementById("guestsValue_" + key);
                    var gutsetsSelect = document.getElementById("guestsSelect_" + key);
                    gutsetsValue.classList.remove("hidden_panel");
                    gutsetsSelect.classList.add("hidden_panel");
                    
                }
                **/
                if (addRoomButton != null) {
                    
                    addRoomButton.classList.add('hidden_panel');
                    
                }
                navigationPage.classList.add("hidden_panel");
                object.createForm(month, day, year, null, null, calendarData, null, checkDate.checkIn, null, accountKey, function(response){
                    
                    object._console.log(response);
                    if (response.status == 'success') {
                        
                        object._hotel.reset();
                        object._lengthOfStayBool = true;
                        document.getElementById("booking-package_calendarPage").classList.remove("hidden_panel");
                        object.createCalendar(response, month, day, year, accountKey, null);
                        delete(response.status);
                        
                    }
                    
                    if (response.mode == 'return') {
                        
                        /** Rooms **/
                        var visitorDetails = object._hotel.verifySchedule(true);
                        object._console.log(visitorDetails);
                        var guestsList = object.getGuestsList();
                        for (var roomKey in visitorDetails.rooms) {
                            
                            var room = visitorDetails.rooms[roomKey];
                            for (var key in guestsList) {
                                
                                var gutsetsValue = document.getElementById("guestsValue_" + roomKey + '_' + key);
                                var gutsetsSelect = document.getElementById("guestsSelect_" + roomKey + '_' + key);
                                gutsetsValue.classList.add("hidden_panel");
                                gutsetsSelect.classList.remove("hidden_panel");
                                
                            }
                            
                        }
                        
                        var deleteRoomButtons = roomListPanel.getElementsByClassName('deleteRoomButton');
                        for (var i = 0; i < deleteRoomButtons.length; i++) {
                            
                            deleteRoomButtons[i].classList.remove('hidden_panel');
                            
                        }
                        /** Rooms **/
                        
                        /**
                        var guestsList = object.getGuestsList();
                        for(var key in guestsList){
                            
                            var gutsetsValue = document.getElementById("guestsValue_" + key);
                            var gutsetsSelect = document.getElementById("guestsSelect_" + key);
                            gutsetsValue.classList.add("hidden_panel");
                            gutsetsSelect.classList.remove("hidden_panel");
                            
                        }
                        **/
                        
                        if (addRoomButton != null) {
                            
                            addRoomButton.classList.remove('hidden_panel');
                            
                        }
                        durationStay.setAttribute("style", "");
                        durationStay.classList.remove("hidden_panel");
                        durationStay.classList.remove("position_sticky");
                        durationStay.classList.remove("nextPageBookingDetails");
                        durationStay.classList.add("returnPageBookingDetails");
                        document.getElementById("booking-package_inputFormPanel").classList.add("hidden_panel");
                        checkInClearLabel.classList.remove("hidden_panel");
                        checkOutClearLabel.classList.remove("hidden_panel");
                        bookingNowButton.classList.remove("hidden_panel");
                        
                        var scrollPositionNew = window.pageYOffset + durationStay.getBoundingClientRect().top - object._top;
                        var scrollPosition = durationStay.getBoundingClientRect().top - object._top;
                        window.scrollTo(0, scrollPositionNew);
                        
                        if(object._screen_width > object._screen_width_limit){
                            
                            durationStay.addEventListener("animationend", (function(){
                                
                                var timer = setInterval(function(){
                                    
                                    calendarPage.classList.remove("hidden_panel");
                                    object._console.error("Time out");
                                    clearInterval(timer);
                                    
                                }, 810);
                                
                                return function returnPage(){
                                    
                                    durationStay.removeEventListener("animationend", returnPage, false);
                                    
                                }
                                
                            })(), false);
                            
                        }else{
                            
                            calendarPage.classList.remove("hidden_panel");
                            
                        }
                        
                        
                    }else if(response.mode == 'top'){
                        
                        top = response.top;
                        
                    }
                    
                });
                
                checkInClearLabel.classList.add("hidden_panel");
                checkOutClearLabel.classList.add("hidden_panel");
                bookingNowButton.classList.add("hidden_panel");
                
                durationStay.classList.remove("returnPageBookingDetails");
                formPanel.classList.remove("returnPageVisitorDetails");
                
                calendarPage.classList.add("hidden_panel");
                durationStay.classList.add("nextPageBookingDetails");
                
                var interval = 810;
                if (object._screen_width < object._screen_width_limit) {
                    
                    interval = 110;
                    
                }
                
                durationStay.addEventListener("animationend", (function(){
                    
                    var timer = setInterval(function() {
                        
                        //durationStay.setAttribute("style", "top: " + top + "px;");
                        durationStay.classList.add("position_sticky");
                        formPanel.classList.remove("hidden_panel");
                        formPanel.classList.add("nextPageVisitorDetails");
                        
                        if (object._screen_width < object._screen_width_limit) {
                            
                            object._console.log("object._top = " + object._top);
                            var durationStayRect = durationStay.getBoundingClientRect();
                            var scrollPositionNew = window.pageYOffset + (durationStayRect.top + durationStayRect.height) - (object._top * 2);
                            window.scrollTo({top: scrollPositionNew, behavior: "smooth"});
                            
                        }
                        object._console.error("Time out");
                        clearInterval(timer);
                        
                    }, interval);
                    
                    return function next(){
                        
                        durationStay.removeEventListener("animationend", next, false);
                        
                    }
                    
                })(), false);
                
                
            }
            
            
        }
        
    }
    
    Booking_App.prototype.checkOutClearLabel = function() {
        
        var object = this;
        var dayPanelList = object.getDayPanelList();
        var checkDate = object._hotel.getCheckDate();
        var checkInDate = checkDate.checkIn;
        var checkOutDate = checkDate.checkOut;
        var checkInKey = null;
        var checkOutKey = null;
        var expressionsCheck = object._calendar.getExpressionsCheck(parseInt(object._calendarAccount.expressionsCheck));
        
        if (checkInDate != null) {
            
            checkInKey = object._calendar.getDateKey(checkInDate.month, checkInDate.day, checkInDate.year);
            
        }
        
        if (checkOutDate != null) {
            
            checkOutKey = object._calendar.getDateKey(checkOutDate.month, checkOutDate.day, checkOutDate.year);
            
        }
        
        if (checkInKey != null) {
            
            for (var key in dayPanelList) {
                
                if (checkInKey != key) {
                    
                    dayPanelList[key].select = 0;
                    dayPanelList[key].eventPanel.classList.remove("selectedDayPanel");
                    
                }
                
            }
            
        }
        
        var guestsListPanel = document.getElementById('guestsListPanel');
        guestsListPanel.classList.add('hidden_panel');
        
        var checkOutDatePanel = document.getElementById('checkOutDate');
        checkOutDatePanel.textContent = expressionsCheck.chooseDeparture;
        checkOutDatePanel.classList.add("chooseDate");
        
        var checkOutClearLabel = document.getElementById('checkOutClearLabel');
        checkOutClearLabel.classList.add("hidden_panel");
        object._hotel.setCheckOut(null);
        object._hotel.setCheckOutKey(null);
        object._console.log(object._hotel.getCheckDate());
        
    }
    
    Booking_App.prototype.addGuestsForRoom = function(guestsList, bookingNowButton, totalNumberOfGuestsPanel, roomNo, multipleRooms, deleteRoom) {
        
        var object = this;
        object._console.log('addGuestsForRoom');
        var roomPanel = document.createElement('div');
        roomPanel.id = 'roomNo_' + roomNo;
        if (multipleRooms == 1) {
            
            var roomNoLabel = document.createElement('label');
            roomNoLabel.classList.add('roomNoLabel');
            roomNoLabel.textContent = object._i18n.get('Room') + ': ' + (roomNo + 1);
            roomPanel.appendChild(roomNoLabel);
            
        }
        
        if (deleteRoom === true) {
            
            var deleteRoomButton = document.createElement('label');
            deleteRoomButton.classList.add('material-icons');
            deleteRoomButton.classList.add('deleteRoomButton');
            deleteRoomButton.textContent = 'delete';
            deleteRoomButton.setAttribute('data-room', roomNo);
            roomPanel.appendChild(deleteRoomButton);
            deleteRoomButton.onclick = function(event) {
                
                var deleteRoomButton = this;
                var roomNo = parseInt(deleteRoomButton.getAttribute('data-room'));
                object._console.log('roomNo = ' + roomNo);
                var rooms = object._hotel.deleteRoom(roomNo);
                var roomPanel = deleteRoomButton.parentElement;
                document.getElementById('roomListPanel').removeChild(roomPanel);
                object.updateRoomNumber();
                var verifyGuests = object._hotel.verifyGuestsInRooms(response.rooms);
                if (verifyGuests.booking == false || response.nights == 0 || verifyGuests.requiredGuests == false) {
                    
                    bookingNowButton.disabled = true;
                    bookingNowButton.classList.add("hidden_panel");
                    
                } else {
                    
                    bookingNowButton.disabled = false;
                    bookingNowButton.classList.remove("hidden_panel");
                    
                }
                
            };
            
        }
        
        for (var key in guestsList) {
            
            var guests = guestsList[key];
            var list = guestsList[key].json;
            if (typeof guestsList[key].json == 'string') {
                
                list = JSON.parse(guestsList[key].json);
                
            }
            
            var values = [];
            for (var i = 0; i < list.length; i++) {
                
                values.push(list[i].name);
                
            }
            
            guestsList[key].values = values;
            guestsList[key].type = "SELECT";
            guestsList[key].value = 0;
            guestsList[key].index = 0;
            guestsList[key].person = 0;
            object._hotel.addGuests(key, guestsList[key], roomNo);
            object._console.log(list);
            if (list[0] != null) {
                
                guestsList[key].person = parseInt(list[0].number);
                var response = object._hotel.setGuests(key, 0, list[0].number, roomNo);
                
            }
            
            var input = new Booking_Package_Input(object._debug);
            input.setPrefix(object._prefix);
            var guestsSelectPanel = input.createInput(guestsList[key]['name'].replace(/\\/g, ""), guestsList[key], {}, function(event){
                
                var key = this.parentElement.getAttribute("data-guset");
                var roomNo = this.parentElement.getAttribute("data-room");
                var index = parseInt(this.selectedIndex);
                var list = guestsList[key].json;
                if (typeof guestsList[key].json == 'string') {
                    
                    list = JSON.parse(guestsList[key].json);
                    
                }
                /**
                guestsList[key].index = index;
                var response = object._hotel.setGuests(key, index, list[index].number, roomNo);
                **/
                var response = object._hotel.updateSelectedGuests(key, index, roomNo, true);
                var feeList = object._hotel.getFeeList();
                
                var gutsetsValue = document.getElementById("guestsValue_" + roomNo + '_' + key);
                if (0 < index) {
                    
                    gutsetsValue.textContent = list[index].name;
                    
                } else {
                    
                    gutsetsValue.textContent = null;
                    
                }
               
                
                object._hotel.pushCallback();
                
                var taxAmount = 0;
                for (var key in response.taxes) {
                    
                    if ((response.taxes[key].type == 'tax' && response.taxes[key].tax == 'tax_exclusive') || response.taxes[key].type == 'surcharge') {
                        
                        taxAmount += response.taxes[key].taxValue;
                        
                    }
                    
                }
                
                object._console.log("taxAmount = " + taxAmount);
                object._console.log(feeList);
                //document.getElementById("bookingPrice").textContent = object._format.formatCost((feeList.additionalFee * response.nights) + response.amount + taxAmount, object._currency);
                document.getElementById("bookingPrice").textContent = object._format.formatCost((feeList.additionalFee * response.nights) + (response.amount * response.applicantCount) + taxAmount, object._currency);
                var verifyGuests = object._hotel.verifyGuestsInRooms(response.rooms);
                if (verifyGuests.booking == false || response.nights == 0 || verifyGuests.requiredGuests == false) {
                    
                    bookingNowButton.disabled = true;
                    bookingNowButton.classList.add("hidden_panel");
                    
                } else {
                    
                    bookingNowButton.disabled = false;
                    bookingNowButton.classList.remove("hidden_panel");
                    
                }
                
                for (var roomKey in verifyGuests.rooms) {
                    
                    var roomStatus = verifyGuests.rooms[roomKey];
                    var roomPanel = document.getElementById('roomNo_' + roomKey);
                    object._console.log(roomStatus);
                    object._console.log(roomPanel);
                    if (roomStatus.booking === false || roomStatus.requiredGuests === false) {
                        
                        roomPanel.classList.add('errorPanel');
                        
                    } else {
                        
                        roomPanel.classList.remove('errorPanel');
                        
                    }
                    
                }
                
                totalNumberOfGuestsPanel.classList.remove("errorPanel");
                if (response.booking == false) {
                    
                    totalNumberOfGuestsPanel.classList.add("errorPanel");
                    
                }
                
            });
            
            var guestsLabel = document.createElement("div");
            guestsLabel.id = "guestsValue_" + roomNo + '_' + key;
            guestsLabel.setAttribute("class", "value hidden_panel");
            
            guestsSelectPanel.setAttribute("data-guset", key);
            guestsSelectPanel.setAttribute("data-room", roomNo);
            guestsSelectPanel.id = "guestsSelect_" + roomNo + '_' + key;
            var required = parseInt(guestsList[key].required);
            var rowPanel = object.createRowPanel(guestsList[key]['name'].replace(/\\/g, ""), guestsSelectPanel, null, required, guestsLabel);
            //guestsListPanel.appendChild(rowPanel);
            if (multipleRooms == 1) {
                
                rowPanel.setAttribute('class', 'rowRoom');
                
            }
            roomPanel.insertAdjacentElement("beforeend", rowPanel);
            
        }
        
        
        return roomPanel;
        
    };
    
    Booking_App.prototype.updateRoomNumber = function() {
        
        var object = this;
        var roomNumberLabels = document.getElementById('roomListPanel').getElementsByClassName('roomNoLabel');
        object._console.log(roomNumberLabels);
        for (var i = 0; i < roomNumberLabels.length; i++) {
            
            var roomNoLabel = roomNumberLabels[i];
            roomNoLabel.textContent = object._i18n.get('Room') + ': ' + (i + 1);
            
        }
        
    };
    
    
    
    Booking_App.prototype.selectCourseAndSchedulePanel = function(month, day, year, calendarData, accountKey, callback){
        
        month = parseInt(month);
        day = parseInt(day);
        year = parseInt(year);
        
        var object = this;
        var calendarKey = object._calendar.getDateKey(month, day, year);
        
        if (callback != null) {
            
            object.setSchedulesCallback(callback);
            
        } else {
            
            callback = object.getSchedulesCallback();
            
        }
        
        var navigationPage = document.getElementById(object._prefix + "servicesPostPage");
        object._console.log("day = " + day + " month = " + month + " year = " + year + " week = " + calendarData.calendar[calendarKey].week);
        object._console.log(calendarData);
        var calendarArray = Object.keys(calendarData.calendar);
        
        var startDayKey = calendarData.calendar[calendarKey].number - 3;
        var endDayKey = calendarData.calendar[calendarKey].number + 3;
        object._console.log(calendarArray[startDayKey]);
        object._console.log(calendarData.calendar[calendarArray[startDayKey]]);
        
        var startDay = calendarData.calendar[calendarKey].number - 3;
        var endDay = calendarData.calendar[calendarKey].number + 3;
        if (startDayKey <= 0) {
            
            startDay = 0;
            endDay = 6;
            
        } else {
            
            startDay = startDayKey;
            if (calendarArray[endDayKey] != null) {
                
                endDay = endDayKey;
                
            }
            
        }
        
        if (endDay > calendarArray.length) {
            
            startDay = calendarArray.length - 7;
            endDay = calendarArray.length - 1;
            
        }
        
        var calendarPage = document.getElementById("booking-package_calendarPage");
        calendarPage.setAttribute("class", "hidden_panel");
        
        var schedulePage = document.getElementById("booking-package_schedulePage");
        schedulePage.classList.remove("hidden_panel");
        object.setScrollY(schedulePage);
        var body = object._body;
        
        var selectedDate = document.createElement("div");
        selectedDate.id = "selectedDate";
        selectedDate.classList.add("selectedDate");
        selectedDate.textContent = object._calendar.formatBookingDate(month, day, year, null, null, null, calendarData.calendar[calendarKey].week);
        
        var leftButtonPanel = document.createElement("div");
        leftButtonPanel.id = "leftButtonPanel";
        leftButtonPanel.classList.add("leftButtonPanel");
        
        var rightButtonPanel = document.createElement("div");
        rightButtonPanel.id = "rightButtonPanel";
        rightButtonPanel.classList.add("rightButtonPanel");
        
        /**
        var topPanel = document.createElement("div");
        topPanel.id = "topPanel";
        **/
        var topPanel = document.getElementById("topPanel");
        topPanel.textContent = null;
        //topPanel.setAttribute("class", "topPanel");
        topPanel.appendChild(leftButtonPanel);
        topPanel.appendChild(selectedDate);
        topPanel.appendChild(rightButtonPanel);
        object._topPanelHeight = topPanel.clientHeight;
        if (object._headingPosition == 0) {
            
            //topPanel.classList.add("headingPosition");
            topPanel.classList.add("topPanelNoAnimation");
            
        } else {
            
            topPanel.classList.add("topPanel");
            
        }
        //schedulePage.appendChild(topPanel);
        
        
        /**
        var daysListPanel = document.createElement("div");
        daysListPanel.id = "daysListPanel";
        **/
        var daysListPanel = document.getElementById("daysListPanel");
        daysListPanel.textContent = null;
        daysListPanel.setAttribute("class", "daysListPanel");
        
        if (object._headingPosition == 0) {
            
            //daysListPanel.classList.add("headingPosition");
            daysListPanel.setAttribute("class", "daysListPanelNoAnimation");
            
        } else {
            
            daysListPanel.setAttribute("class", "daysListPanel");
            
        }
        
        //schedulePage.appendChild(daysListPanel);
        
        object.initWeekDaysList();
        var weekDaysPanelList = [];
        for (var i = startDay; i <= endDay; i++) {
            
            if (calendarArray[i] == null) {
                
                continue;
                
            }
            
            var calendar = calendarData.calendar[calendarArray[i]];
            var key = object._calendar.getDateKey(calendar.month, calendar.day, calendar.year);
            var weekNum = calendarData.calendar[key].week;
            var selecteWeekData = object.serachDayPanelList(key);
            
            var weekPanel = document.createElement("div");
            weekPanel.classList.add("weekPanel");
            weekPanel.classList.add(weekNum +"_OfWeek");
            weekPanel.textContent = this._i18n.get(this.weekName[weekNum]);
            
            var dayPanel = document.createElement("div");
            dayPanel.textContent = calendar.day;
            
            var weekDaysPanel = document.createElement("div");
            //weekDaysPanel.setAttribute("data-key", i);
            weekDaysPanel.setAttribute("data-key", calendar.number);
            weekDaysPanel.setAttribute("data-status", "1");
            weekDaysPanel.appendChild(weekPanel);
            weekDaysPanel.appendChild(dayPanel);
            weekDaysPanel.classList.add("selectPanel");
            
            if (calendar.day == day) {
                
                weekDaysPanel.classList.add("selectPanelActive");
                
            }
            
            if (calendarData.schedule[key].length == 0 || (selecteWeekData != null && parseInt(selecteWeekData.remainder) <= 0)) {
                
                weekDaysPanel.setAttribute("data-status", "0");
                weekDaysPanel.classList.remove("selectPanel");
                weekDaysPanel.classList.remove("selectPanelActive");
                weekDaysPanel.classList.add("selectPanelError");
                
            } else {
                
                //object.addWeekDaysList(String(i), this.weekName[weekNum] + " " + i);
                object.addWeekDaysList(String(calendar.number), this._i18n.get(this.weekName[weekNum]) + " " + calendar.day);
                weekDaysPanel.onclick = function(){
                    
                    this.setAttribute("class", "selectPanel selectPanelActive");
                    var key = parseInt(this.getAttribute("data-key"));
                    var calendar = calendarData.calendar[calendarArray[key]];
                    var calendarKey = object._calendar.getDateKey(calendar.month, calendar.day, calendar.year);
                    selectedDate.textContent = object._calendar.formatBookingDate(calendar.month, calendar.day, calendar.year, null, null, null, calendar.week);
                    object.unselectPanel(key, weekDaysPanelList, "selectPanel");
                    object.createCourseAndSchedules(calendar.month, calendar.day, calendar.year, daysListPanel, weekDaysPanelList, calendarData, rect, accountKey, function(response){
                        
                        if (response.mode == "completed") {
                            
                            if (object._calendarAccount.flowOfBooking == 'calendar') {
                                
                                object.createCalendar(response, calendar.month, calendar.day, calendar.year, accountKey, callback);
                                
                            } else {
                                
                                calendarPage.textContent = null;
                                object.createServicesPanel(response, calendar.month, calendar.day, calendar.year, accountKey);
                                
                            }
                            
                        } else if (response.mode == "return") {
                            
                            calendarData = response;
                            object._console.log(calendarData);
                            
                        }
                        
                    });
                    
                }
                
            }
            
            weekDaysPanelList.push(weekDaysPanel);
            daysListPanel.appendChild(weekDaysPanel);
            
        }
        /**
        var scheduleMainPanel = document.createElement("div");
        scheduleMainPanel.id = "scheduleMainPanel";
        **/
        var scheduleMainPanel = document.getElementById("scheduleMainPanel");
        scheduleMainPanel.textContent = null;
        scheduleMainPanel.setAttribute("style", "");
        //scheduleMainPanel.setAttribute("class", "courseListPanel box_shadow hidden_panel");
        if (object._headingPosition == 0) {
            
            //scheduleMainPanel.classList.add("headingPosition");
            scheduleMainPanel.setAttribute("class", "courseListPanelNoAnimation box_shadow hidden_panel");
            
        } else {
            
            scheduleMainPanel.setAttribute("class", "courseListPanel box_shadow hidden_panel");
            
        }
        //schedulePage.appendChild(scheduleMainPanel);
        
        var optionsMainPanel = document.getElementById("optionsMainPanel");
        optionsMainPanel.setAttribute("style", "");
        optionsMainPanel.classList.add("hidden_panel");
        if (object._headingPosition == 0) {
            
            optionsMainPanel.classList.add("headingPosition");
            
        }
        
        var courseMainPanel = document.getElementById("courseMainPanel");
        courseMainPanel.textContent = null;
        courseMainPanel.setAttribute("style", "");
        courseMainPanel.setAttribute("class", "courseListPanel box_shadow");
        if (object._headingPosition == 0) {
            
            //courseMainPanel.classList.add("headingPosition");
            courseMainPanel.setAttribute("class", "courseListPanelNoAnimation box_shadow");
            
        } else {
            
            courseMainPanel.setAttribute("class", "courseListPanel box_shadow");
            
        }
        
        var blockPanel = document.getElementById("blockPanel");
        blockPanel.style.height = (document.clientHeight - schedulePage.getBoundingClientRect().top) + "px";
        if (object._headingPosition == 0) {
            
            //blockPanel.classList.add("headingPosition");
            
        }
        
        var rect = daysListPanel.getBoundingClientRect();
        
        var bottomPanel = document.getElementById("bottomPanel");
        bottomPanel.classList.add("bottomPanel");
        
        if (object._calendarAccount.type == 'day' && object._calendarAccount.flowOfBooking == 'calendar') {
            
            bottomPanel.classList.remove("bottomPanel");
            bottomPanel.classList.add("bottomPanelForPositionInherit");
            
        }
        
        if (object._headingPosition == 0) {
            
            bottomPanel.classList.add("bottomPanelNoAnimation");
            
        }
        
        if (object._headingPosition == 1) {
            
            bottomPanel.style.bottom = object._bottom + "px";
            
        }
        
        var returnToCalendarButton = document.getElementById("returnToCalendarButton");
        returnToCalendarButton.classList.remove("hidden_panel");
        if (returnToCalendarButton.event != null) {
            
            returnToCalendarButton.removeEventListener("click", null);
            
        }
        
        bottomPanel.appendChild(returnToCalendarButton);
        returnToCalendarButton.onclick = function(){
            
            navigationPage.classList.add("hidden_panel");
            document.getElementById(object._prefix + "schedulesPostPage").classList.add("hidden_panel");
            document.getElementById(object._prefix + "calendarPostPage").classList.remove("hidden_panel");
            document.getElementById("optionsMainPanel").setAttribute("class", "hidden_panel");
            schedulePage.setAttribute("class", "hidden_panel");
            calendarPage.setAttribute("class", "");
            callback(calendarData);
            //object.createCalendar(calendarData, calendar.month, calendar.day, calendar.year, accountKey, callback);
            object.setScrollY(calendarPage);
            
        }
        
        
        if (calendarData.schedule[calendarKey].length != 0) {
            
            object.createCourseAndSchedules(month, day, year, daysListPanel, weekDaysPanelList, calendarData, rect, accountKey, function(response){
                
                if (response.mode == "completed") {
                    
                    response = object.getReservationData(month, day, year, accountKey, true, false, response);
                    if (object._calendarAccount.flowOfBooking == 'calendar') {
                        
                        calendarPage.classList.remove("hidden_panel");
                        object.createCalendar(response, month, day, year, accountKey, callback);
                        
                    } else {
                        
                        calendarPage.textContent = null;
                        object.createServicesPanel(response, month, day, year, accountKey);
                        
                    }
                    
                } else if (response.mode == "return") {
                    
                    calendarData = response;
                    object._console.log(calendarData);
                    
                }
                
            });
            
        }
        
    }
    
    Booking_App.prototype.createCourseAndSchedules = function(month, day, year, daysListPanel, weekDaysPanelList, calendarData, rect, accountKey, callback){
        
        var object = this;
        object._console.log('createCourseAndSchedules');
        var calendarKey = object._calendar.getDateKey(month, day, year);
        const week = calendarData.calendar[calendarKey].week;
        var schedulePage = document.getElementById("booking-package_schedulePage");
        var serviceAndSchedulePanel = document.getElementById("booking-package_schedulePage");
        var scheduleMainPanel = document.createElement("div");
        var navigationPage = document.getElementById(object._prefix + "servicesPostPage");
        if (document.getElementById("scheduleMainPanel")) {
            
            scheduleMainPanel = document.getElementById("scheduleMainPanel");
            
        } else {
            
            scheduleMainPanel.id = "scheduleMainPanel";
            scheduleMainPanel.setAttribute("class", "courseListPanel box_shadow hidden_panel");
            schedulePage.appendChild(scheduleMainPanel);
            if (object._headingPosition == 0) {
                
                //scheduleMainPanel.classList.add("headingPosition");
                scheduleMainPanel.setAttribute("class", "courseListPanelNoAnimation box_shadow hidden_panel");
                
            } else {
                
                scheduleMainPanel.setAttribute("class", "courseListPanel box_shadow hidden_panel");
                
            }
            
        }
        
        var formMainPanel = document.createElement("div");
        if (document.getElementById("formMainPanel")) {
            
            formMainPanel = document.getElementById("formMainPanel");
            
        } else {
            
            formMainPanel.id = "formMainPanel";
            formMainPanel.setAttribute("class", "courseListPanel box_shadow hidden_panel");
            schedulePage.appendChild(formMainPanel);
            
        }
        
        /**
        scheduleMainPanel.addEventListener("animationend", function(event){
            
            alert("animationend");
            
        });
        **/
        
        object._console.log(this._courseBool);
        object._console.log(object._courseList);
        
        if (this._courseBool == true && object._courseList.length != 0) {
            
            navigationPage.classList.remove("hidden_panel");
            /**
            for (var i in object._courseList) {
                
                object._courseList[i].service = 1;
                object._courseList[i].selected = 0;
                object._courseList[i].selectedOptionsList = [];
                
            }
            
            var courseList = object._courseList;
            **/
            
            object._console.log(rect.height);
            var courseMainPanel = document.createElement("div");
            if (document.getElementById("courseMainPanel")) {
                
                courseMainPanel = document.getElementById("courseMainPanel");
                courseMainPanel.textContent = null;
                
            } else {
                
                courseMainPanel.id = "courseMainPanel";
                courseMainPanel.setAttribute("class", "courseListPanel box_shadow");
                schedulePage.appendChild(courseMainPanel);
                if (object._headingPosition == 0) {
                    
                    courseMainPanel.setAttribute("class", "courseListPanelNoAnimation box_shadow");
                    
                } else {
                    
                    courseMainPanel.setAttribute("class", "courseListPanel box_shadow");
                    
                }
                
            }
            
            var animationBool = true;
            var checkBoxList = {};
            var coursePanelList = [];
            object.setServicePanelList(coursePanelList);
            object.createServicesList(animationBool, checkBoxList, coursePanelList, courseMainPanel, month, day, year, week, function(table_row) {
                
                table_row.onclick = function() {
                    
                    object._console.log(courseList);
                    object._console.log("animationBool = " + animationBool);
                    var serviceBottomPanel = document.getElementById('serviceBottomPanel');
                    if (typeof serviceBottomPanel == 'object') {
                        
                        serviceBottomPanel.classList.remove('hidden_panel');
                        
                    }
                    
                    //document.getElementById("optionsMainPanel").setAttribute("class", "hidden_panel");
                    var optionsMainPanel = document.getElementById("optionsMainPanel");
                    optionsMainPanel.classList.add("hidden_panel");
                    if (optionsMainPanel.classList.contains("postionDefaultForScheduleListPanel")) {
                        
                        animationBool = true;
                        
                    }
                    object._console.log("animationBool = " + animationBool);
                    
                    courseMainPanel.classList.remove("box_shadow");
                    
                    if (object._headingPosition == 0) {
                        
                        courseMainPanel.classList.remove("postionReturnForCourseListPanel");
                        courseMainPanel.classList.add("postionLeftForCourseListPanelNoAnimation");
                        
                    } else {
                        
                        courseMainPanel.classList.remove("postionReturnForCourseListPanel");
                        courseMainPanel.classList.add("postionLeftForCourseListPanel");
                        
                    }
                    
                    this.setAttribute("class", "selectPanel selectPanelActive");
                    var key = this.getAttribute("data-key");
                    object.unselectPanel(key, coursePanelList, "selectPanel");
                    object.updateServicePanelList();
                    object.changeHeight(null);
                    
                    if (parseInt(object._calendarAccount.hasMultipleServices) == 0) {
                        
                        for (var i in courseList) {
                            
                            courseList[i].selected = 0;
                            
                        }
                        
                        courseList[parseInt(key)].selected = 1;
                        
                    } else {
                        
                        var checkBox = checkBoxList[parseInt(key)];
                        if (checkBox.checked == true) {
                            
                            checkBox.checked = false;
                            this.setAttribute("class", "selectPanel");
                            courseList[parseInt(key)].selected = 0;
                            //delete(selectedOptions[key]);
                            
                        } else {
                            
                            checkBox.checked = true;
                            this.setAttribute("class", "selectPanel selectPanelActive");
                            courseList[parseInt(key)].selected = 1;
                            //selectedOptions[key] = option;
                            
                        }
                        
                        var returnPage = true;
                        for (var i in courseList) {
                            
                            if (courseList[i].selected == 1) {
                                
                                object._console.log(courseList[i]);
                                returnPage = false;
                                
                            }
                            
                        }
                        
                        object._console.log('returnPage = ' + returnPage);
                        if (returnPage == true) {
                            
                            object.returnToDayList(daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, true);
                            if (document.getElementById("returnToDayListButton") != null) {
                                
                                document.getElementById("returnToDayListButton").classList.add("hidden_panel");
                                
                            }
                            
                            if (document.getElementById("returnToCalendarButton") != null) {
                                
                                document.getElementById("returnToCalendarButton").classList.remove("hidden_panel");
                                
                            }
                            
                            return null;
                            
                        }
                        
                        
                    }
                    
                    
                    //courseList[parseInt(key)].selected = 1;
                    object._console.log(courseList);
                    object._console.log(courseList[parseInt(key)]);
                    var course = courseList[parseInt(key)];
                    var options = [];
                    if(course.options != null){
                        
                        options = JSON.parse(course.options);
                        object._console.log(options);
                        
                    }
                    
                    if(0 < options.length){
                        
                        if (checkBox == null || checkBox.checked == true) {
                            
                            animationBool = object.createOptions(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList[parseInt(key)], accountKey, function(response){
                                
                                object._console.log(response);
                                courseList[parseInt(key)].selectedOptionsList = response.selectedOptions;
                                if (response.next == 1) {
                                    
                                    navigationPage.classList.add("hidden_panel");
                                    object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, null, accountKey, function(response){
                                        
                                        if (response.mode == 'changeDay') {
                                            
                                            month = parseInt(response.month);
                                            day = parseInt(response.day);
                                            year = parseInt(response.year);
                                            
                                        } else if (response.mode == 'return') {
                                            
                                            calendarData = response;
                                            
                                        }
                                        callback(response);
                                        object._console.log(calendarData);
                            
                                    });
                                    
                                }
                                
                            });
                            
                        } else {
                            
                            object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, null, accountKey, function(response){
                                
                                if (response.mode == 'changeDay') {
                                    
                                    month = parseInt(response.month);
                                    day = parseInt(response.day);
                                    year = parseInt(response.year);
                                    
                                } else if (response.mode == 'return') {
                                    
                                    calendarData = response;
                                    object._console.log(calendarData);
                                    
                                }
                                callback(response);
                    
                            });
                            
                        }
                        
                    }else{
                        
                        var nextButton = document.getElementById("nextButton");
                        nextButton.removeEventListener("check", null);
                        nextButton.classList.add("hidden_panel");
                        navigationPage.classList.add("hidden_panel");
                        animationBool = true;
                        //object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList[parseInt(key)], null, accountKey, function(response){
                        object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, null, accountKey, function(response){
                            
                            if (response.mode == 'changeDay') {
                                
                                month = parseInt(response.month);
                                day = parseInt(response.day);
                                year = parseInt(response.year);
                                
                            } else if (response.mode == 'return') {
                                
                                calendarData = response;
                                object._console.log(calendarData);
                                
                            }
                            callback(response);
                
                        });
                        
                    }
                    
                };
                
            });
            
            
            /**
            var animationBool = true;
            var checkBoxList = [];
            var coursePanelList = [];
            for (var i in courseList) {
                
                var course = courseList[i];
                if (course.active != "true") {
                    
                    continue;
                    
                }
                
                course["status"] = true;
                
                var coursePanel = document.createElement("div");
                coursePanel.setAttribute("data-key", i);
                coursePanel.setAttribute("data-status", 1);
                
                var courseNamePanel = document.createElement("span");
                if(typeof course["name"] == "string"){
                    
                    course["name"] = course["name"].replace(/\\/g, "");
                    
                }
                courseNamePanel.textContent = course["name"];
                //coursePanel.appendChild(courseNamePanel);
                
                var checkBox = document.createElement("input");
                checkBox.setAttribute("data-key", i);
                checkBox.type = "checkbox";
                checkBox.value = "";
                //checkBox.disabled = true;
                
                checkBox.onclick = function() {
                    
                    if (this.checked == true) {
                        
                        this.checked = false;
                        
                    } else {
                        
                        this.checked = true;
                        
                    }
                    
                };
                
                checkBoxList.push(checkBox);
                
                var label = document.createElement("span");
                label.appendChild(checkBox);
                label.appendChild(courseNamePanel);
                if(parseInt(object._calendarAccount.hasMultipleServices) == 0){
                    
                    checkBox.classList.add("hidden_panel");
                    
                }
                coursePanel.appendChild(label);
                
                if(course.cost != null && course.cost != 0){
                    
                    var cost = object._format.formatCost(course.cost, object._currency);
                    var courseCostPanel = document.createElement("span");
                    courseCostPanel.classList.add("courseCostPanel");
                    courseCostPanel.textContent = cost;
                    coursePanel.appendChild(courseCostPanel);
                    
                }
                
                var table_row = document.createElement("div");
                table_row.setAttribute("data-key", i);
                table_row.setAttribute("data-status", 1);
                table_row.classList.add("selectPanel");
                table_row.appendChild(coursePanel);
                
                coursePanelList.push(table_row);
                courseMainPanel.appendChild(table_row);
                
                table_row.onclick = function(){
                    
                    object._console.log(courseList);
                    //document.getElementById("optionsMainPanel").setAttribute("class", "hidden_panel");
                    var optionsMainPanel = document.getElementById("optionsMainPanel");
                    optionsMainPanel.classList.add("hidden_panel");
                    if(optionsMainPanel.classList.contains("postionDefaultForScheduleListPanel")){
                        
                        animationBool = true;
                        
                    }
                    
                    courseMainPanel.classList.remove("box_shadow");
                    
                    if (object._headingPosition == 0) {
                        
                        courseMainPanel.classList.remove("postionReturnForCourseListPanel");
                        courseMainPanel.classList.add("postionLeftForCourseListPanelNoAnimation");
                        
                    } else {
                        
                        courseMainPanel.classList.remove("postionReturnForCourseListPanel");
                        courseMainPanel.classList.add("postionLeftForCourseListPanel");
                        
                    }
                    
                    this.setAttribute("class", "selectPanel selectPanelActive");
                    var key = this.getAttribute("data-key");
                    object.unselectPanel(key, coursePanelList, "selectPanel");
                    object.changeHeight(null);
                    
                    if(parseInt(object._calendarAccount.hasMultipleServices) == 0){
                        
                        for (var i in courseList) {
                            
                            courseList[i].selected = 0;
                            
                        }
                        
                        courseList[parseInt(key)].selected = 1;
                        
                    } else {
                        
                        var checkBox = checkBoxList[parseInt(key)];
                        if(checkBox.checked == true){
                            
                            checkBox.checked = false;
                            this.setAttribute("class", "selectPanel");
                            courseList[parseInt(key)].selected = 0;
                            //delete(selectedOptions[key]);
                            
                        }else{
                            
                            checkBox.checked = true;
                            this.setAttribute("class", "selectPanel selectPanelActive");
                            courseList[parseInt(key)].selected = 1;
                            //selectedOptions[key] = option;
                            
                        }
                        
                        var returnPage = true;
                        for (var i in courseList) {
                            
                            if (courseList[i].selected == 1) {
                                
                                returnPage = false;
                                
                            }
                            
                        }
                        
                        if (returnPage == true) {
                            
                            object.returnToDayList(daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, true);
                            if (document.getElementById("returnToDayListButton") != null) {
                                
                                document.getElementById("returnToDayListButton").classList.add("hidden_panel");
                                
                            }
                            
                            if (document.getElementById("returnToCalendarButton") != null) {
                                
                                document.getElementById("returnToCalendarButton").classList.remove("hidden_panel");
                                
                            }
                            
                            return null;
                            
                        }
                        
                        
                    }
                    
                    
                    //courseList[parseInt(key)].selected = 1;
                    object._console.log(courseList);
                    object._console.log(courseList[parseInt(key)]);
                    var course = courseList[parseInt(key)];
                    var options = [];
                    if(course.options != null){
                        
                        options = JSON.parse(course.options);
                        object._console.log(options);
                        
                    }
                    
                    if(0 < options.length){
                        
                        if (checkBox == null || checkBox.checked == true) {
                            
                            animationBool = object.createOptions(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList[parseInt(key)], accountKey, function(response){
                                
                                object._console.log(response);
                                courseList[parseInt(key)].selectedOptionsList = response.selectedOptions;
                                if (response.next == 1) {
                                    
                                    object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, null, accountKey, function(response){
                                        
                                        if(response.mode == 'changeDay'){
                                            
                                            day = parseInt(response.day);
                                            
                                        }
                                        callback(response);
                            
                                    });
                                    
                                }
                                
                            });
                            
                        } else {
                            
                            object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, null, accountKey, function(response){
                                
                                if(response.mode == 'changeDay'){
                                    
                                    day = parseInt(response.day);
                                    
                                }
                                callback(response);
                    
                            });
                            
                        }
                        
                    }else{
                        
                        var nextButton = document.getElementById("nextButton");
                        nextButton.removeEventListener("check", null);
                        nextButton.classList.add("hidden_panel");
                        animationBool = true;
                        //object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList[parseInt(key)], null, accountKey, function(response){
                        object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, null, accountKey, function(response){
                            
                            if(response.mode == 'changeDay'){
                                
                                day = parseInt(response.day);
                                
                            }
                            callback(response);
                
                        });
                        
                    }
                    
                }
                
            }
            **/
            
            courseMainPanel.style.height = null;
            daysListPanel.style.height = null;
            var blockPanel = document.getElementById("blockPanel");
            if(courseMainPanel.getBoundingClientRect().height < daysListPanel.getBoundingClientRect().height){
                
                blockPanel.style.height = 0 + "px";
                object.changeHeight(daysListPanel.getBoundingClientRect());
                
            }else{
                
                blockPanel.style.height = courseMainPanel.getBoundingClientRect().height - daysListPanel.getBoundingClientRect().height + "px";
                object.changeHeight(courseMainPanel.getBoundingClientRect());
                
            }
            
            var topPanel = document.getElementById("topPanel");
            daysListPanel.style.height = null;
            object._console.log("_headingPosition = " + object._headingPosition);
            if (object._headingPosition == 0) {
                
                
                
            } else {
                
                topPanel.style.top = object._top + "px";
                daysListPanel.style.top = (object._top + object._topPanelHeight) + "px";
                daysListPanel.classList.add("positionSticky");
                
            }
            
        }else{
            
            var services = null;
            if (object._calendarAccount.flowOfBooking == 'services') {
                
                services = object._courseList;
                for (var key in object._courseList) {
                    
                    
                    
                }
                
            }
            
            var topPanel = document.getElementById("topPanel");
            daysListPanel.style.height = null;
            object._console.log("_headingPosition = " + object._headingPosition);
            if (object._headingPosition == 0) {
                
                
                
            } else {
                
                topPanel.style.top = object._top + "px";
                daysListPanel.style.top = (object._top + object._topPanelHeight) + "px";
                daysListPanel.classList.add("positionSticky");
                
            }
            object._console.log(services);
            object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, services, null, accountKey, function(response){
                
                object._console.error(response);
                if (response.mode == 'changeDay') {
                    
                    day = parseInt(response.day);
                    
                } else if (response.mode == 'return') {
                    
                    calendarData = response;
                    object._console.log(calendarData);
                    
                }
                callback(response);
                
            });
            
        }
        
        
    }
    
    Booking_App.prototype.updateServicePanelList = function() {
        
        var object = this;
        object._console.log(object._courseList);
        object._console.log(object._servicePanelList);
        for (var key in object._courseList) {
            
            var serviceKey = parseInt(object._courseList[key].key);
            if (object._servicePanelList[serviceKey] == null || object._courseList[key].active == '') {
                
                continue;
                
            }
            
            if (object._courseList[key].closed == 1) {
                
                object._servicePanelList[serviceKey].classList.add('hidden_panel');
                
            } else {
                
                object._servicePanelList[serviceKey].classList.remove('hidden_panel');
                
            }
            
        }
        
    }
    
    /**
    Booking_App.prototype.checkTimeToProvide = function(month, day, year, week, changeSelected, expiration) {
        
        var object = this;
        var expirationDate = 0;
        var isBooking = {status: true, services: {}};
        object._console.log('checkTimeToProvide');
        object._console.error('expiration = ' + expiration);
        object._console.log(object._courseList);
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
        
        if (object._expirationDate == 1) {
            
            //expirationDate = year + ("0" + month).slice(-2) + ("0" + day).slice(-2);
            expirationDate = object._calendar.getDateKey(month, day, year);
            if (typeof expirationDate == 'string') {
                
                expirationDate = parseInt(expirationDate);
                
            }
            object._console.log('expirationDate = ' + expirationDate);
            
        }
        
        for (var key in object._courseList) {
            
            object._console.log(object._courseList[key]);
            object._courseList[key].closed = 0;
            var timeToProvide = object._courseList[key].timeToProvide;
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
                object._courseList[key].closed = closed;
                object._console.log('closed = ' + closed);
                if (parseInt(object._courseList[key].selected) == 1 && closed == 1) {
                    
                    if (isBooking.status === true) {
                        
                        isBooking.status = false;
                        
                    }
                    isBooking.services[key] = object._courseList[key];
                    
                }
                
            }
            
            if (parseInt(object._courseList[key].expirationDateStatus) == 1) {
                
                var expirationDateFrom = parseInt(object._courseList[key].expirationDateFrom);
                var expirationDateTo = parseInt(object._courseList[key].expirationDateTo);
                if (expirationDateFrom != 0 && expirationDateTo != 0 && expirationDateFrom <= expirationDate && expirationDateTo >= expirationDate) {
                    
                    object._console.error(object._courseList[key]);
                    if (isBooking.status === true && (expiration === true || parseInt(object._courseList[key].selected) == 1)) {
                        
                        isBooking.status = false;
                        
                    }
                    object._courseList[key].closed = 1;
                    isBooking.services[key] = object._courseList[key];
                    
                }
                
            }
            
        }
        
        if (isBooking.status === false && changeSelected === true) {
            
            for (var key in object._courseList) {
                
                object._courseList[key].selected = 0;
                var checkBox = document.getElementById('service_checkBox_' + key);
                if (checkBox != null) {
                    
                    checkBox.checked = false;
                    
                }
                
            }
            
        }
        
        return isBooking;
        
    }
    **/
    
    Booking_App.prototype.createServicesList = function(animationBool, checkBoxList, coursePanelList, courseMainPanel, month, day, year, week, callback) {
        
        var object = this;
        object._console.log('createServicesList');
        object._console.log(object._courseList);
        
        for (var i in object._courseList) {
            
            object._courseList[i].service = 1;
            object._courseList[i].selected = 0;
            object._courseList[i].selectedOptionsList = [];
            
        }
        
        //var isBooking = object.checkTimeToProvide(month, day, year, week, true, true);
        var isBooking = object._servicesControl.validateServices(month, day, year, week, true, true);
        object._console.log(isBooking);
        var courseList = object._courseList;
        for (var i in courseList) {
            
            var course = courseList[i];
            if (course.active != "true") {
                
                continue;
                
            }
            
            course["status"] = true;
            
            var coursePanel = document.createElement("div");
            coursePanel.setAttribute("data-key", i);
            coursePanel.setAttribute("data-status", 1);
            
            var courseNamePanel = document.createElement("span");
            if(typeof course["name"] == "string"){
                
                course["name"] = course["name"].replace(/\\/g, "");
                
            }
            courseNamePanel.textContent = course["name"];
            //coursePanel.appendChild(courseNamePanel);
            
            var checkBox = document.createElement("input");
            checkBox.id = 'service_checkBox_' + i;
            checkBox.setAttribute("data-key", i);
            checkBox.type = "checkbox";
            checkBox.value = "";
            //checkBox.disabled = true;
            
            checkBox.onclick = function() {
                
                if (this.checked == true) {
                    
                    this.checked = false;
                    
                } else {
                    
                    this.checked = true;
                    
                }
                
            };
            
            //checkBoxList.push(checkBox);
            checkBoxList[i] = checkBox;
            
            var label = document.createElement("span");
            label.appendChild(checkBox);
            label.appendChild(courseNamePanel);
            if(parseInt(object._calendarAccount.hasMultipleServices) == 0){
                
                checkBox.classList.add("hidden_panel");
                
            }
            coursePanel.appendChild(label);
            
            object._console.log(course);
            object._console.log(isNaN(parseInt(course.cost)));
            if(course.cost != null && isNaN(parseInt(course.cost)) === false && parseInt(course.cost) != 0){
                
                var cost = object._format.formatCost(course.cost, object._currency);
                var courseCostPanel = document.createElement("span");
                courseCostPanel.classList.add("courseCostPanel");
                courseCostPanel.textContent = cost;
                coursePanel.appendChild(courseCostPanel);
                
            }
            
            if (course.description != null && course.description.length > 0) {
                
                var description = document.createElement("div");
                description.classList.add("descriptionOfService");
                description.textContent = course.description.replace(/\\/g, "");
                coursePanel.appendChild(description);
                object._console.log(course.description);
                
            }
            
            var table_row = document.createElement("div");
            table_row.setAttribute("data-key", i);
            table_row.setAttribute("data-status", 1);
            table_row.setAttribute("data-service", course.key);
            table_row.classList.add("selectPanel");
            table_row.appendChild(coursePanel);
            if (course.closed != null && course.closed == 1) {
                
                table_row.classList.add("hidden_panel");
                
            }
            
            coursePanelList.push(table_row);
            courseMainPanel.appendChild(table_row);
            
            table_row.onclick = function(){
                
            }
            
            callback(table_row);
            
        }
        
        var serviceBottomPanel = document.createElement('div');
        serviceBottomPanel.id = 'serviceBottomPanel';
        serviceBottomPanel.classList.add('hidden_panel');
        courseMainPanel.appendChild(serviceBottomPanel);
        if (typeof document.getElementById('bottomPanel').getBoundingClientRect == 'function') {
            
            var topPanel = document.getElementById('bottomPanel').getBoundingClientRect();
            object._console.error(typeof document.getElementById('bottomPanel').getBoundingClientRect);
            object._console.error(topPanel);
            serviceBottomPanel.style.height = topPanel.height + 'px';
            
        }
        
        
        
        
        object.setServicePanelList(coursePanelList);
        return checkBoxList;
        
    };
    
    Booking_App.prototype.createOptions = function(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, course, accountKey, callback){
        
        var selectedOptions = [];
        var object = this;
        object._console.log(course);
        var calendarAccount = object._calendarAccount;
        var returnToCalendarButton = document.getElementById("returnToCalendarButton");
        var nextButton = document.getElementById("nextButton");
        var optionsMainPanel = document.getElementById("optionsMainPanel");
        var navigationPage = document.getElementById(object._prefix + "servicesPostPage");
        //optionsMainPanel.setAttribute("class", "courseListPanel box_shadow");
        optionsMainPanel.classList.remove("hidden_panel");
        //optionsMainPanel.classList.add("courseListPanel");
        optionsMainPanel.classList.add("box_shadow");
        optionsMainPanel.style.top = null;
        optionsMainPanel.style.height = null;
        optionsMainPanel.textContent = null;
        object._console.log("class = " + optionsMainPanel.getAttribute("class"));
        if (object._headingPosition == 0) {
            
            optionsMainPanel.classList.add("courseListPanelNoAnimation");
            
        } else {
            
            optionsMainPanel.classList.add("courseListPanel");
            
        }
        
        scheduleMainPanel.classList.add("hidden_panel");
        returnToCalendarButton.classList.add("hidden_panel");
        nextButton.classList.remove("hidden_panel");
        document.getElementById("returnDayButton").classList.add("hidden_panel");
        document.getElementById("nextDayButtton").classList.add("hidden_panel");
        
        var topPanel = document.getElementById("topPanel");
        object._topPanelHeight = topPanel.clientHeight;
        
        var blockPanel = document.getElementById("blockPanel");
        /**
        if(optionsMainPanel.getBoundingClientRect().height < courseMainPanel.getBoundingClientRect().height){
            
            object._console.error("no change");
            blockPanel.style.height = 0 + "px";
            object.changeHeight(courseMainPanel.getBoundingClientRect());
            
        }else{
            
            
            blockPanel.style.height = optionsMainPanel.getBoundingClientRect().height - courseMainPanel.getBoundingClientRect().height + "px";
            object._console.error(blockPanel.style.height);
            object.changeHeight(optionsMainPanel.getBoundingClientRect());
            
        }
        **/
        var optionPanelList = [];
        var checkBoxList = [];
        var options = JSON.parse(course.options);
        for(var i = 0; i < options.length; i++){
            
            var option = options[i];
            option.selected = 0;
            selectedOptions.push(option);
            object._console.log(option);
            
            var titleLabel = document.createElement("span");
            titleLabel.textContent = option.name;
            
            var checkBox = document.createElement("input");
            checkBox.setAttribute("data-key", i);
            checkBox.type = "checkbox";
            checkBox.value = "";
            //checkBox.disabled = true;
            
            checkBox.onclick = function() {
                
                if (this.checked == true) {
                    
                    this.checked = false;
                    
                } else {
                    
                    this.checked = true;
                    
                }
                
            };
            
            checkBoxList.push(checkBox);
            
            var label = document.createElement("span");
            label.appendChild(checkBox);
            label.appendChild(titleLabel);
            if(parseInt(course.selectOptions) == 0){
                
                checkBox.classList.add("hidden_panel");
                
            }
            
            var optionPanel = document.createElement("div");
            optionPanel.setAttribute("data-key", i);
            optionPanel.appendChild(label);
            
            if(option.cost != null && option.cost != 0){
                
                var cost = object._format.formatCost(option.cost, object._currency);
                var optionCostPanel = document.createElement("span");
                optionCostPanel.classList.add("courseCostPanel");
                optionCostPanel.textContent = cost;
                optionPanel.appendChild(optionCostPanel);
                
            }
            
            optionPanelList.push(optionPanel);
            
            var table_row = document.createElement("div");
            table_row.setAttribute("data-key", i);
            table_row.appendChild(optionPanel);
            
            table_row.setAttribute("data-status", 1);
            table_row.setAttribute("class", "selectPanel");
            table_row.onclick = function() {
                
                var key = parseInt(this.getAttribute("data-key"));
                var option = options[key];
                object._console.log(option);
                var checkBox = checkBoxList[key];
                if (checkBox.checked == true) {
                    
                    checkBox.checked = false;
                    this.setAttribute("class", "selectPanel");
                    selectedOptions[key].selected = 0;
                    //delete(selectedOptions[key]);
                    
                } else {
                    
                    checkBox.checked = true;
                    this.setAttribute("class", "selectPanel selectPanelActive");
                    selectedOptions[key].selected = 1;
                    //selectedOptions[key] = option;
                    
                }
                
                object._console.log(selectedOptions);
                nextButton.disabled = true;
                nextButton.classList.add("hidden_panel");
                for (var i = 0; i < selectedOptions.length; i++) {
                    
                    if (selectedOptions[i].selected == 1) {
                        
                        if (parseInt(course.selectOptions) == 0) {
                            
                            optionsMainPanel.classList.add("hidden_panel");
                            /**
                            object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, course, selectedOptions, accountKey, function(response){
                                
                                if(response.mode == 'changeDay'){
                                    
                                    day = parseInt(response.day);
                                    
                                }
                                callback(response);
                    
                            });
                            **/
                            callback({selectedOptions: selectedOptions, next: 1});
                            
                        } else {
                            
                            nextButton.disabled = false;
                            nextButton.classList.remove("hidden_panel");
                            callback({selectedOptions: selectedOptions, next: 0});
                            
                        }
                        
                        break;
                        
                    }
                    
                }
                
            };
            
            optionsMainPanel.appendChild(table_row);
            
        }
        
        if (optionsMainPanel.getBoundingClientRect().height < courseMainPanel.getBoundingClientRect().height) {
            
            blockPanel.style.height = 0 + "px";
            object.changeHeight(courseMainPanel.getBoundingClientRect());
            
        } else {
            
            blockPanel.style.height = optionsMainPanel.getBoundingClientRect().height - courseMainPanel.getBoundingClientRect().height + "px";
            object.changeHeight(optionsMainPanel.getBoundingClientRect());
            
        }
        
        if (object._headingPosition == 1) {
            
            topPanel.style.top = object._top + "px";
            
        }
        
        object._animationend = true;
        
        object._console.log("animationBool = " + animationBool);
        object._console.log("class = " + optionsMainPanel.getAttribute("class"));
        if(animationBool === true){
            
            if (object._headingPosition == 0) {
                
                daysListPanel.classList.add("hidden_panel");
                optionsMainPanel.classList.add("postionCenterForScheduleListPanelNoAnimation");
                
            } else {
                
                animationBool = false;
                optionsMainPanel.classList.add("postionCenterForScheduleListPanel");
                optionsMainPanel.addEventListener("animationend", function(event){
                    
                    var element = document.body;
                    object._console.log(element);
                    
                });
                courseMainPanel.addEventListener("animationend", (function(){
                    
                    var timer = setInterval(function(){
                        
                        courseMainPanel.style.height = null;
                        
                        daysListPanel.classList.add("hidden_panel");
                        courseMainPanel.style.top = (object._top + object._topPanelHeight) + "px";
                        courseMainPanel.classList.add("positionSticky");
                        object._console.error("Time out");
                        
                        clearInterval(timer);
                        
                    }, 1000);
                    
                    return function x(){
                        
                        courseMainPanel.removeEventListener("animationend", x, false);
                        
                    }
                    
                })(), false);
                
            }
            
            
            
        }else{
            
            daysListPanel.classList.add("hidden_panel");
            courseMainPanel.style.height = null;
            if (object._headingPosition == 1) {
                
                courseMainPanel.classList.add("positionSticky");
                //courseMainPanel.style.top = (object._top + object._topPanelHeight) + "px";
                
            }
            
        }
        
        nextButton.disabled = true;
        nextButton.classList.add("hidden_panel");
        for(var i = 0; i < selectedOptions.length; i++){
            
            if(selectedOptions[i].selected == 1){
                
                nextButton.disabled = false;
                nextButton.classList.remove("hidden_panel");
                break;
                
            }
            
        }
        
        nextButton.removeEventListener("check", null);
        nextButton.onclick = function(){
            
            navigationPage.classList.add("hidden_panel");
            nextButton.classList.add("hidden_panel");
            optionsMainPanel.classList.add("hidden_panel");
            /**
            object.createSchedule(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, course, selectedOptions, accountKey, function(response){
                
                if(response.mode == 'changeDay'){
                    
                    day = parseInt(response.day);
                    
                }
                callback(response);
    
            });
            **/
            callback({selectedOptions: selectedOptions, next: 1});
            
        }
        
        var returnToDayListButton = document.getElementById("returnToDayListButton");
        returnToDayListButton.classList.remove("hidden_panel");
        returnToDayListButton.removeEventListener("click", null);
        returnToDayListButton.onclick = function(){
            
            courseMainPanel.style.top = null;
            courseMainPanel.classList.remove("positionSticky");
            
            daysListPanel.style.top = null;
            daysListPanel.style.height = null;
            if (object._headingPosition == 1) {
                
                daysListPanel.classList.add("positionSticky");
                
            }
            
            daysListPanel.classList.remove("hidden_panel");
            if(typeof courseMainPanel == 'object'){
                
                nextButton.classList.add("hidden_panel");
                courseMainPanel.classList.remove("postionLeftForCourseListPanel");
                courseMainPanel.classList.remove("postionLeftForCourseListPanelNoAnimation");
                courseMainPanel.classList.remove("positionSticky");
                courseMainPanel.classList.remove("postionDefaultForCourseListPanel");
                courseMainPanel.classList.remove("postionDefaultForCourseListPanelNoAnimation");
                courseMainPanel.classList.add("box_shadow");
                //courseMainPanel.classList.add("postionReturnForCourseListPanel");
                //courseMainPanel.setAttribute("class", "courseListPanel box_shadow postionDefaultForCourseListPanel");
                if (object._headingPosition == 0) {
                    
                    courseMainPanel.classList.add("postionReturnForCourseListPanelNoAnimation");
                    optionsMainPanel.setAttribute("class", "courseListPanelNoAnimation postionDefaultForScheduleListPanelNoAnimation hidden_panel");
                    if(courseMainPanel.getBoundingClientRect().height < daysListPanel.getBoundingClientRect().height){
                        
                        object._console.log("daysListPanel");
                        object.changeHeight(daysListPanel.getBoundingClientRect());
                        
                    }else{
                        
                        object._console.log("courseMainPanel");
                        object.changeHeight(courseMainPanel.getBoundingClientRect());
                        
                    }
                    
                } else {
                    
                    courseMainPanel.classList.add("postionReturnForCourseListPanel");
                    optionsMainPanel.setAttribute("class", "courseListPanel postionDefaultForScheduleListPanel");
                    if(courseMainPanel.getBoundingClientRect().height < daysListPanel.getBoundingClientRect().height){
                        
                        object._console.log("daysListPanel");
                        object.changeHeight(daysListPanel.getBoundingClientRect());
                        
                    }else{
                        
                        object._console.log("courseMainPanel");
                        object.changeHeight(courseMainPanel.getBoundingClientRect());
                        
                    }
                    optionsMainPanel.addEventListener("animationend", (function(){
                        
                        var timer = setInterval(function(){
                            
                            optionsMainPanel.classList.add("hidden_panel");
                            object._console.error("Time out");
                            
                            clearInterval(timer);
                            
                        }, 801);
                        
                        return function x(){
                            
                            optionsMainPanel.removeEventListener("animationend", x, false);
                            
                        }
                        
                    })(), false);
                    
                }
                
                
            }
            
            returnToDayListButton.classList.add("hidden_panel");
            returnToCalendarButton.classList.remove("hidden_panel");
            //optionsMainPanel.setAttribute("class", "courseListPanel postionDefaultForScheduleListPanel");
            
        }
        
        return animationBool
        
    }
    
    Booking_App.prototype.getTotalTimeInOptions = function(options){
        
        var object = this;
        var totalTimeInOptions = 0;
        if (options != null) {
            
            for(var i = 0; i < options.length; i++) {
                
                var option = options[i];
                if (parseInt(option.selected) == 1) {
                    
                    totalTimeInOptions += parseInt(option.time);
                    
                }
                
            }
            
        }
        
        object._console.log("totalTimeInOptions = " + totalTimeInOptions);
        return totalTimeInOptions;
        
    }
    
    Booking_App.prototype.createSchedule = function(month, day, year, animationBool, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, selectedOptions, accountKey, callback){
        
        var object = this;
        object._console.log("day = " + day);
        object._console.log(calendarData);
        object._console.log(courseList);
        object._console.log(selectedOptions);
        object._console.log("animationBool = " + animationBool);
        var serviceAndSchedulePanel = document.getElementById("booking-package_schedulePage");
        var navigationPage = document.getElementById(object._prefix + "schedulesPostPage");
        object.setScrollY(serviceAndSchedulePanel);
        var calendarKey = this._calendar.getDateKey(month, day, year);
        var calendarArray = Object.keys(calendarData.calendar);
        object._console.log(calendarData.calendar[calendarKey]);
        //object.setCurrentCalendarDate(calendarData.calendar[calendarKey]);
        day = parseInt(day);
        var timeToProvide = [];
        var mode = null;
        if (calendarData.mode != null) {
            
            mode = calendarData.mode.toLowerCase();
            //delete calendarData.mode;
            
        }
        
        /**
        if (course != null && course.timeToProvide != null) {
            
            timeToProvide = course.timeToProvide;
            
        }
        **/
        
        object._console.log(object._courseBool);
        var course = null;
        var totalTimeInOptions = 0;
        if (object._courseBool == true || object._calendarAccount.flowOfBooking == 'services') {
            
            course = false;
            
            for (var key in courseList) {
                
                if (courseList[key].selected == 1 && courseList[key].timeToProvide != null) {
                    
                    course = true;
                    timeToProvide.push(courseList[key].timeToProvide);
                    
                }
                
                if (courseList[key].selected == 1 && courseList[key].selectedOptionsList.length > 0) {
                    
                    totalTimeInOptions += object.getTotalTimeInOptions(courseList[key].selectedOptionsList);
                    
                }
                
            }
            object._console.log(timeToProvide);
            if (course === true) {
                
                //var currentCalendarDate = object.getCurrentCalendarDate();
                //object._console.log(currentCalendarDate);
                //calendarKey = currentCalendarDate.key;
                object._console.log(calendarKey);
                object._console.log(calendarData.calendar[calendarKey]);
                //var isBooking = object.checkTimeToProvide(month, day, year, parseInt(calendarData.calendar[calendarKey].week), true, false);
                var isBooking = object._servicesControl.validateServices(month, day, year, parseInt(calendarData.calendar[calendarKey].week), true, false);
                object._console.log(isBooking);
                object.updateServicePanelList();
                if (isBooking.status === false) {
                    
                }
                
            }
            
        }
        
        object._console.log("totalTimeInOptions = " + totalTimeInOptions);
        object._console.log(calendarData.calendar[calendarKey]);
        var selectedDate = document.getElementById("selectedDate");
        selectedDate.textContent = object._calendar.formatBookingDate(month, day, year, null, null, null, calendarData.calendar[calendarKey].week);
        
        scheduleMainPanel.classList.remove("hidden_panel");
        scheduleMainPanel.classList.remove("postionDefaultForScheduleListPanel");
        scheduleMainPanel.classList.remove("postionDefaultForScheduleListPanelNoAnimation");
        scheduleMainPanel.style.top = null;
        scheduleMainPanel.style.height = null;
        scheduleMainPanel.textContent = null;
        
        var topPanel = document.getElementById("topPanel");
        object._topPanelHeight = topPanel.clientHeight;
        
        var blockPanel = document.getElementById("blockPanel");
        object._console.log(window.innerHeight);
        
        if(calendarData['schedule'][calendarKey].length == 0){
            
            var errorPanel = document.createElement("div");
            errorPanel.setAttribute("class", "noSchedule");
            errorPanel.textContent = object.i18n("No schedules");
            scheduleMainPanel.appendChild(errorPanel);
            
        }else if(calendarData['schedule'][calendarKey].length == 1){
            
            navigationPage.classList.add("hidden_panel");
            object.createForm(month, day, year, courseMainPanel, scheduleMainPanel, calendarData, courseList, calendarData['schedule'][calendarKey][0], selectedOptions, accountKey, function(response){
                
                object._console.log(response);
                if (response.mode == "return") {
                    /**
                    for(var i = 0; i < titleLabelList.length; i++){
                        
                        titleLabelList[i].classList.remove("hidden_panel");
                        
                    }
                    **/
                    object._console.log(course);
                    if (course == null || object._calendarAccount.flowOfBooking == 'services') {
                        
                        var schedulePage = document.getElementById("booking-package_schedulePage");
                        schedulePage.classList.add("hidden_panel");
                        
                        var calendarPage = document.getElementById("booking-package_calendarPage");
                        calendarPage.classList.remove("hidden_panel");
                        
                        if (document.getElementById("returnDayButton") != null && document.getElementById("nextDayButtton") != null) {
                        
                            document.getElementById("returnDayButton").classList.remove("hidden_panel");
                            document.getElementById("nextDayButtton").classList.remove("hidden_panel");
                            if (returnToDayListButton != null) {
                                
                                returnToDayListButton.classList.remove("hidden_panel");
                                
                            }
                            
                        } else {
                            
                            document.getElementById("returnToCalendarButton").classList.remove("hidden_panel");
                            
                        }
                        
                    } else {
                        
                        if (document.getElementById("returnDayButton") != null && document.getElementById("returnDayButton") != null && document.getElementById("returnToDayListButton") != null) {
                            
                            document.getElementById("returnToDayListButton").classList.add("hidden_panel");
                            document.getElementById("returnDayButton").classList.add("hidden_panel");
                            document.getElementById("nextDayButtton").classList.add("hidden_panel");
                            
                        }
                        
                        object.selectCourseAndSchedulePanel(month, day, year, calendarData, accountKey, callback);
                        object.setScrollY(serviceAndSchedulePanel);
                        
                    }
                    
                } else if (response.mode == "completed") {
                    
                    callback(response);
                    
                }
                
            });
            
            return null;
            
        }
        
        navigationPage.classList.remove("hidden_panel");
        var calendarKey = object._calendar.getDateKey(month, day, year);
        object._console.log(object._nationalHoliday[calendarKey]);
        var nationalHoliday = false;
        if (object._nationalHoliday[calendarKey] != null && parseInt(object._nationalHoliday[calendarKey].status) == 1) {
            
            nationalHoliday = true;
            
        }
        
        for(var i = 0; i < calendarData['schedule'][calendarKey].length; i++){
            
            var schedule = calendarData['schedule'][calendarKey][i];
            schedule["select"] = true;
            if(parseInt(schedule["remainder"]) == 0 || schedule["stop"] == 'true'){
                
                schedule["select"] = false;
                
            }
            
            var week = parseInt(schedule.weekKey);
            var minutes = parseInt(schedule.hour) * 60;
            if (nationalHoliday == true) {
                
                week = 7;
                
            }
            
            for (var key in timeToProvide) {
                
                if (timeToProvide[key][week] != null && parseInt(timeToProvide[key][week][minutes]) == 0) {
                    
                    schedule["select"] = false;
                    
                }
                
            }
            /**
            if (timeToProvide[week] != null && parseInt(timeToProvide[week][minutes]) == 0) {
                
                schedule["select"] = false;
                
            }
            **/
        }
        
        if (course != null || object._preparationTime > 0) {
            
            var courseTime = 0;
            if (object._positionPreparationTime == 'before_after' || object._positionPreparationTime == 'after') {
                    
                    courseTime = object._preparationTime;
                    
            }
            
            if (course != null) {
                
                //courseTime += parseInt(course["time"]) + totalTimeInOptions;
                for (var key in courseList) {
                    
                    if (courseList[key].selected == 1) {
                        
                        courseTime += parseInt(courseList[key].time);
                        
                    }
                    
                }
                
                courseTime += totalTimeInOptions;
                
            }
            
            var afterPreparationTime = 0;
            if (object._positionPreparationTime == 'before_after' || object._positionPreparationTime == 'before') {
                    
                    afterPreparationTime = object._preparationTime;
                    
            }
            //var courseTime = parseInt(course["time"]) + totalTimeInOptions;
            object._console.log("courseTime = " + courseTime);
            for(var i = 0; i < calendarData['schedule'][calendarKey].length; i++){
                
                var schedule = calendarData['schedule'][calendarKey][i];
                if (parseInt(schedule["remainder"]) == 0 || schedule["stop"] == 'true') {
                    
                    schedule["select"] = false;
                    var rejectionTime = (parseInt(schedule["hour"]) * 60 + parseInt(schedule["min"])) - courseTime;
                    object._console.log("rejectionTime = " + rejectionTime);
                    
                    (function(schedule, key, courseTime, rejectionTime, afterPreparationTime, callback){
                        
                        object._console.log(key);
                        var stopUnixTime = parseInt(schedule[key].unixTime);
                        stopUnixTime += afterPreparationTime * 60;
                        object._console.log("stopUnixTime = " + stopUnixTime);
                        for(var i = 0; i < schedule.length; i++){
                            
                            var time = parseInt(schedule[i]["hour"]) * 60 + parseInt(schedule[i]["min"]);
                            if (time > rejectionTime && i < key) {
                                
                                object._console.log("i = " + i + " hour = " + schedule[i]["hour"] + " min = " + schedule[i]["min"]);
                                callback(i);
                                
                            } else if (parseInt(schedule[i].unixTime) < stopUnixTime && i > key) {
                                
                                object._console.log("i = " + i + " hour = " + schedule[i]["hour"] + " min = " + schedule[i]["min"]);
                                callback(i);
                                
                            } else if (parseInt(schedule[i].unixTime) >= stopUnixTime) {
                                
                                break;
                                
                            }
                            /**
                            if(i == key){
                                
                                object._console.log("i = " + i + " hour = " + schedule[i]["hour"] + " min = " + schedule[i]["min"]);
                                break;
                                
                            }
                            **/
                        }
                        
                    })(calendarData['schedule'][calendarKey], i, courseTime, rejectionTime, afterPreparationTime, function(key){
                        
                        object._console.log("callback key = " + key);
                        calendarData['schedule'][calendarKey][key]["select"] = false;
                        
                    });
                    
                }
                
            }
            
        }
        
        var scheduleListPanel = [];
        var titleLabelList = []
        for(var i = 0; i < calendarData['schedule'][calendarKey].length; i++){
            
            var schedule = calendarData['schedule'][calendarKey][i];
            if(typeof schedule['title'] == "string"){
                
                schedule['title'] = schedule['title'].replace(/\\/g, "");
                
            }
            object._console.log(schedule);
            
            var timeLabel = document.createElement("span");
            timeLabel.textContent = object._calendar.getPrintTime(("0" + schedule["hour"]).slice(-2), ("0" + schedule["min"]).slice(-2)) + " ";
            //timeLabel.textContent = ("0" + schedule["hour"]).slice(-2) + ":" + ("0" + schedule["min"]).slice(-2) + " ";
            
            var titleLabel = document.createElement("span");
            titleLabel.textContent = schedule['title'];
            
            var schedulePanel = document.createElement("div");
            schedulePanel.setAttribute("data-key", i);
            schedulePanel.setAttribute("data-month", schedule.month);
            schedulePanel.setAttribute("data-day", schedule.day);
            schedulePanel.setAttribute("data-year", schedule.year);
            schedulePanel.appendChild(timeLabel);
            schedulePanel.appendChild(titleLabel);
            
            if(parseInt(object._calendarAccount.displayRemainingCapacity) == 1){
                
                var displayRemainingCapacityLabel = document.createElement("span");
                displayRemainingCapacityLabel.classList.add("displayRemainingCapacityLabel");
                displayRemainingCapacityLabel.textContent = object._i18n.get("%s remaining", [schedule.remainder]);
                schedulePanel.appendChild(displayRemainingCapacityLabel);
                
            }
            
            var table_row = document.createElement("div");
            table_row.setAttribute("data-key", i);
            table_row.appendChild(schedulePanel);
            scheduleListPanel.push(table_row);
            titleLabelList.push(titleLabel);
            
            if(schedule["select"] === true){
                
                table_row.setAttribute("data-status", 1);
                table_row.setAttribute("class", "selectPanel");
                table_row.onclick = function(){
                    
                    if(document.getElementById("returnDayButton") != null && document.getElementById("nextDayButtton") != null){
                        
                        document.getElementById("returnDayButton").classList.add("hidden_panel");
                        document.getElementById("nextDayButtton").classList.add("hidden_panel");
                        document.getElementById("returnToDayListButton").classList.add("hidden_panel");
                        
                    }else{
                        
                        document.getElementById("returnToCalendarButton").classList.add("hidden_panel");
                        
                    }
                    
                    for(var i = 0; i < titleLabelList.length; i++){
                        
                        titleLabelList[i].classList.add("hidden_panel");
                        
                    }
                    
                    this.setAttribute("class", "selectPanel selectPanelActive");
                    navigationPage.classList.add("hidden_panel");
                    var key = this.getAttribute("data-key");
                    var schedule = calendarData['schedule'][calendarKey][key];
                    object.unselectPanel(key, scheduleListPanel, "selectPanel");
                    object._console.log(courseList);
                    object.createForm(month, day, year, courseMainPanel, scheduleMainPanel, calendarData, courseList, schedule, selectedOptions, accountKey, function(response){
                        
                        if(response.mode == "return"){
                            
                            for(var i = 0; i < titleLabelList.length; i++){
                                
                                titleLabelList[i].classList.remove("hidden_panel");
                                
                            }
                            
                            if(document.getElementById("returnDayButton") != null && document.getElementById("nextDayButtton") != null){
                                
                                if(object._courseBool == true){
                                    
                                    document.getElementById("returnDayButton").classList.remove("hidden_panel");
                                    document.getElementById("nextDayButtton").classList.remove("hidden_panel");
                                    document.getElementById("returnToDayListButton").classList.remove("hidden_panel");
                                    
                                }
                                
                            }else{
                                
                                document.getElementById("returnToCalendarButton").classList.remove("hidden_panel");
                                
                            }
                            
                            object.setScrollY(serviceAndSchedulePanel);
                            calendarData = object.getReservationData(month, day, year, accountKey, false, false, response);
                            callback(calendarData);
                            object.createSchedule(month, day, year, false, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, selectedOptions, accountKey, callback);
                            
                        }else if(response.mode == "completed"){
                            
                            callback(object.getReservationData(month, day, year, accountKey, false, false, response));
                            
                        }
                        
                    });
                    
                }
                
            }else{
                
                table_row.setAttribute("data-status", 0);
                table_row.setAttribute("class", "selectPanelError");
                
            }
            
            scheduleMainPanel.appendChild(table_row);
            
        }
        object._console.log(course);
        if (course != null && object._calendarAccount.flowOfBooking == 'calendar') {
        //if (this._courseBool == true && object._courseList.length != 0 && object._calendarAccount.flowOfBooking == 'calendar') {
            
            if (scheduleMainPanel.getBoundingClientRect().height < courseMainPanel.getBoundingClientRect().height) {
                
                blockPanel.style.height = 0 + "px";
                object.changeHeight(courseMainPanel.getBoundingClientRect());
                
            } else {
                
                blockPanel.style.height = scheduleMainPanel.getBoundingClientRect().height - courseMainPanel.getBoundingClientRect().height + "px";
                object.changeHeight(scheduleMainPanel.getBoundingClientRect());
                
            }
            
            if (object._headingPosition == 0) {
                
                scheduleMainPanel.classList.add("postionCenterForScheduleListPanelNoAnimation");
                
            } else {
                
                scheduleMainPanel.classList.add("postionCenterForScheduleListPanel");
                scheduleMainPanel.addEventListener("animationend", function(event){
                    
                    var element = document.body;
                    object._console.log(element);
                    
                });
                
            }
            
            if (object._headingPosition == 1) {
                
                topPanel.style.top = object._top + "px";
                
            }
            
            object._animationend = true;
            if(animationBool === true){
                
                //daysListPanel.classList.add("hidden_panel");
                if (object._headingPosition == 0) {
                    
                    daysListPanel.classList.add("hidden_panel");
                    
                } else {
                    
                    courseMainPanel.addEventListener("animationend", (function(){
                        
                        var timer = setInterval(function(){
                            
                            courseMainPanel.style.height = null;
                            
                            daysListPanel.classList.add("hidden_panel");
                            courseMainPanel.classList.add("positionSticky");
                            object._console.error("Time out");
                            
                            clearInterval(timer);
                            
                        }, 1000);
                        
                        return function x(){
                            
                            courseMainPanel.removeEventListener("animationend", x, false);
                            
                        }
                        
                    })(), false);
                    
                }
                
            }else{
                
                courseMainPanel.style.height = null;
                if (object._headingPosition == 1) {
                    
                    courseMainPanel.style.top = (object._top + object._topPanelHeight) + "px";
                    
                }
                
            }
            
        } else {
            
            object._console.log(daysListPanel.getBoundingClientRect());
            object._console.log(scheduleMainPanel.getBoundingClientRect());
            if (scheduleMainPanel.getBoundingClientRect().height < daysListPanel.getBoundingClientRect().height) {
                
                
                blockPanel.style.height = 0 + "px";
                object.changeHeight(daysListPanel.getBoundingClientRect());
                object._console.log("zero = " + blockPanel.style.height);
                
            } else {
                
                
                blockPanel.style.height = scheduleMainPanel.getBoundingClientRect().height - daysListPanel.getBoundingClientRect().height + "px";
                object.changeHeight(scheduleMainPanel.getBoundingClientRect());
                object._console.log("up = " + blockPanel.style.height);
                
            }
            
            
            daysListPanel.style.height = null;
            if (object._headingPostition == 1) {
                
                topPanel.style.top = object._top + "px";
                daysListPanel.style.top = (object._top + object._topPanelHeight) + "px";
                daysListPanel.classList.add("positionSticky");
                
            } else {
                
                if(scheduleMainPanel.getBoundingClientRect().height < daysListPanel.getBoundingClientRect().height){
                    
                    blockPanel.style.height = 0 + "px";
                    
                } else {
                    
                    blockPanel.style.height = scheduleMainPanel.getBoundingClientRect().height - daysListPanel.getBoundingClientRect().height + "px";    
                
                }
                
            }
            
            
            if (document.getElementById("courseMainPanel") != null) {
                
                document.getElementById("courseMainPanel").classList.add("hidden_panel");
                
            }
            
            scheduleMainPanel.classList.add("positionOfPanelNotHavingCourseForScheduleListPanel");
            
        }
        
        var changeDay = function(key) {
            
            object._console.log(weekDaysPanelList);
            for (var i = 0; i < weekDaysPanelList.length; i++) {
                
                if (weekDaysPanelList[i].getAttribute("data-status") == 1) {
                    
                    if(weekDaysPanelList[i].getAttribute("data-key") == key){
                        
                        weekDaysPanelList[i].classList.add("selectPanelActive");
                        
                    } else {
                        
                        weekDaysPanelList[i].classList.remove("selectPanelActive");
                        
                    }
                    
                }
                
            }
            
            var calendar = calendarData.calendar[calendarArray[key]];
            object._console.log(calendar);
            object._console.log("day = " + key);
            callback({mode: "changeDay", month: calendar.month, day: calendar.day, year: calendar.year});
            //var isBooking = object.checkTimeToProvide(calendar.month, calendar.day, calendar.year, parseInt(calendar.week), true, false);
            var isBooking = object._servicesControl.validateServices(calendar.month, calendar.day, calendar.year, parseInt(calendar.week), true, false);
            //object.setCurrentCalendarDate(calendar);
            object._console.log(isBooking);
            object.updateServicePanelList();
            if (isBooking.status === false) {
                
                object._console.log(calendar);
                var selectedDate = document.getElementById('selectedDate');
                selectedDate.textContent = object._calendar.formatBookingDate(calendar.month, calendar.day, calendar.year, null, null, null, calendar.week);
                retrunServicesPanel();
                
            } else {
                
                object.createSchedule(calendar.month, calendar.day, calendar.year, false, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, selectedOptions, accountKey, callback);
                
            }
            //object.createSchedule(calendar.month, calendar.day, calendar.year, false, daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, calendarData, courseList, selectedOptions, accountKey, callback);
            
        }
        
        var retrunServicesPanel = function() {
            
            object._console.log("returnToDayListButton");
            var serviceBottomPanel = document.getElementById('serviceBottomPanel');
            if (typeof serviceBottomPanel == 'object') {
                
                serviceBottomPanel.classList.add('hidden_panel');
                
            }
            navigationPage.classList.add("hidden_panel");
            object.returnToDayList(daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, course);
            returnToDayListButton.classList.add("hidden_panel");
            returnToCalendarButton.classList.remove("hidden_panel");
            object.setScrollY(serviceAndSchedulePanel);
            
        };
        
        if(this._courseBool === true){
            
            var returnToCalendarButton = document.getElementById("returnToCalendarButton");
            returnToCalendarButton.classList.add("hidden_panel");
            
            var weekDaysList = object.getWeekDaysList();
            object._console.log(weekDaysList);
            var keys = Object.keys(weekDaysList);
            object._console.log(keys);
            var returnKey = null;
            var key = calendarData.calendar[calendarKey].number;
            object._console.log(key);
            object._console.log(calendarArray);
            if (weekDaysList[key - 1] == null) {
                
                returnKey = keys[keys.length - 1];
                for (var i = keys.length; i >= 0; i--) {
                    
                    if (key > keys[i]) {
                        
                        var calendar = calendarData.calendar[calendarArray[keys[i]]];
                        object._console.log(calendar);
                        returnKey = parseInt(calendar.number);
                        //returnKey = calendarArray[keys[i]];
                        break;
                        
                    }
                    
                }
                
            } else {
                
                returnKey = parseInt(key) - 1;
                
            }
            object._console.log("returnKey = " + returnKey);
            
            var nextKey = null;
            if (weekDaysList[key + 1] == null) {
                
                nextKey = keys[0];
                for (var i = 0; i < keys.length; i++) {
                    
                    if (key < keys[i]) {
                        
                        var calendar = calendarData.calendar[calendarArray[keys[i]]];
                        object._console.log(calendar);
                        nextKey = parseInt(calendar.number);
                        //nextKey = calendarArray[keys[i]];
                        break;
                        
                    }
                    
                }
                
            } else {
                
                nextKey = parseInt(key) + 1;
                
            }
            object._console.log("nextKey = " + nextKey);
            
            var leftButtonPanel = document.getElementById("leftButtonPanel");
            var bottomPanel = document.getElementById("bottomPanel");
            var rightButtonPanel = document.getElementById("rightButtonPanel");
            
            /**
            var returnToDayListButton = document.createElement("button");
            if(document.getElementById("returnToDayListButton") != null){
                
                returnToDayListButton = document.getElementById("returnToDayListButton");
                if(returnToDayListButton.event != null){
                    
                    returnToDayListButton.removeEventListener("click", null);
                    
                }
                
            }else{
                
                bottomPanel.appendChild(returnToDayListButton);
                
            }
            
            returnToDayListButton.id = "returnToDayListButton";
            **/
            var returnToDayListButton = document.getElementById("returnToDayListButton");
            returnToDayListButton.classList.remove("hidden_panel");
            if (returnToDayListButton.event != null) {
                
                returnToDayListButton.removeEventListener("click", null);
                
            }
            
            returnToDayListButton.onclick = function() {
                
                retrunServicesPanel();
                /**
                object._console.log("returnToDayListButton");
                navigationPage.classList.add("hidden_panel");
                object.returnToDayList(daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, course);
                returnToDayListButton.classList.add("hidden_panel");
                returnToCalendarButton.classList.remove("hidden_panel");
                object.setScrollY(serviceAndSchedulePanel);
                **/
                
            };
            
            /**
            var returnDayButton = document.createElement("button");
            if(document.getElementById("returnDayButton") != null){
                
                returnDayButton = document.getElementById("returnDayButton");
                if(returnDayButton.event != null){
                    
                    returnDayButton.removeEventListener("click", null);
                    
                }
                
            }else{
                
                bottomPanel.appendChild(returnDayButton);
                //leftButtonPanel.appendChild(returnDayButton);
                
            }
            
            object._console.log("returnDayButton = " + weekDaysList[returnKey]);
            object._console.log(returnKey);
            object._console.log(weekDaysList);
            
            returnDayButton.id = "returnDayButton";
            **/
            var returnDayButton = document.getElementById("returnDayButton");
            returnDayButton.classList.remove("hidden_panel");
            returnDayButton.setAttribute("date-key", returnKey);
            returnDayButton.textContent = weekDaysList[returnKey];
            returnDayButton.classList.add("returnDayButton");
            returnDayButton.onclick = function() {
                
                object.setScrollY(serviceAndSchedulePanel);
                var key = parseInt(this.getAttribute("date-key"));
                changeDay(key);
                
            };
            
            /**
            object._console.log(nextDayButtton);
            var nextDayButtton = document.createElement("button");
            if(document.getElementById("nextDayButtton") != null){
                
                nextDayButtton = document.getElementById("nextDayButtton");
                nextDayButtton.removeEventListener("click", null);
                
            }else{
                
                bottomPanel.appendChild(nextDayButtton);
                //rightButtonPanel.appendChild(nextDayButtton);
                
            }
            
            object._console.log("nextDayButtton = " + weekDaysList[nextKey]);
            object._console.log(nextKey);
            object._console.log(weekDaysList);
            
            nextDayButtton.id = "nextDayButtton";
            **/
            var nextDayButtton = document.getElementById("nextDayButtton");
            nextDayButtton.classList.remove("hidden_panel");
            nextDayButtton.setAttribute("date-key", nextKey);
            nextDayButtton.textContent = weekDaysList[nextKey];
            nextDayButtton.classList.add("nextDayButtton");
            nextDayButtton.onclick = function() {
                
                object.setScrollY(serviceAndSchedulePanel);
                var key = parseInt(this.getAttribute("date-key"));
                changeDay(key);
                
            };
            
        } else {
            
            document.getElementById("returnDayButton").classList.add("hidden_panel");
            document.getElementById("nextDayButtton").classList.add("hidden_panel");
            
        }
        
        return scheduleMainPanel;
    
    }
    
    Booking_App.prototype.returnToDayList = function(daysListPanel, courseMainPanel, scheduleMainPanel, weekDaysPanelList, course) {
        
        var object = this;
        object.changeHeight(null);
        
        if(course != null){
            
            document.getElementById(object._prefix + "servicesPostPage").classList.remove("hidden_panel");
            document.getElementById("returnDayButton").classList.add("hidden_panel");
            document.getElementById("nextDayButtton").classList.add("hidden_panel");
            //courseMainPanel.removeEventListener("animationend", event);
            courseMainPanel.style.top = null;
            courseMainPanel.classList.remove("positionSticky");
            
            daysListPanel.style.top = null;
            daysListPanel.style.height = null;
            if (object._headingPosition == 1) {
                
                daysListPanel.classList.add("positionSticky");
                
            }
            
        } else {
            
            
            
        }
        
        
        
        object._console.log(typeof courseMainPanel);
        if(typeof courseMainPanel == 'object'){
            
            courseMainPanel.classList.remove("postionLeftForCourseListPanel");
            courseMainPanel.classList.remove("postionLeftForCourseListPanelNoAnimation");
            courseMainPanel.classList.remove("positionSticky");
            courseMainPanel.classList.remove("postionDefaultForCourseListPanel");
            courseMainPanel.classList.remove("postionDefaultForCourseListPanelNoAnimation");
            courseMainPanel.classList.add("box_shadow");
            //courseMainPanel.classList.add("postionReturnForCourseListPanel");
            //courseMainPanel.setAttribute("class", "courseListPanel box_shadow postionDefaultForCourseListPanel");
            
            if (object._headingPosition == 0) {
                
                daysListPanel.classList.remove("hidden_panel");
                scheduleMainPanel.classList.add("hidden_panel");
                scheduleMainPanel.setAttribute("class", "courseListPanelNoAnimation postionDefaultForScheduleListPanelNoAnimation hidden_panel");
                if(courseMainPanel.getBoundingClientRect().height < daysListPanel.getBoundingClientRect().height){
                    
                    object._console.log("daysListPanel");
                    object.changeHeight(daysListPanel.getBoundingClientRect());
                    
                }else{
                    
                    object._console.log("courseMainPanel");
                    object.changeHeight(courseMainPanel.getBoundingClientRect());
                    
                }
                
            } else {
                
                courseMainPanel.classList.add("postionReturnForCourseListPanel");
                daysListPanel.classList.remove("hidden_panel");
                if(courseMainPanel.getBoundingClientRect().height < daysListPanel.getBoundingClientRect().height){
                    
                    object._console.log("daysListPanel");
                    object.changeHeight(daysListPanel.getBoundingClientRect());
                    
                }else{
                    
                    object._console.log("courseMainPanel");
                    object.changeHeight(courseMainPanel.getBoundingClientRect());
                    
                }
                
                courseMainPanel.addEventListener("animationend", (function(){
                    
                    var timer = setInterval(function(){
                        
                        scheduleMainPanel.classList.add("hidden_panel");
                        object._console.error("Time out");
                        
                        clearInterval(timer);
                        
                    }, 801);
                    
                    return function x(){
                        
                        courseMainPanel.removeEventListener("animationend", x, false);
                        
                    }
                    
                })(), false);
                
                scheduleMainPanel.setAttribute("class", "courseListPanel postionDefaultForScheduleListPanel");
                
            }
        
            
        }
        
        object.setScrollY(document.getElementById("booking-package_schedulePage"));
        //scheduleMainPanel.setAttribute("class", "courseListPanel postionDefaultForScheduleListPanel");
        if (object._headingPosition == 0) {
            
            scheduleMainPanel.classList.add("headingPosition");
            
        }
        
    }
    
    Booking_App.prototype.createForm = function(month, day, year, courseMainPanel, scheduleMainPanel, calendarData, courseList, schedule, selectedOptions, accountKey, callback){
        
        var object = this;
        object._console.log(schedule);
        object._console.log(courseList);
        object._console.log(calendarData);
        if(this.getInputData() == null){
            
            this.initInputData();
            
        }
        object._console.log(this.getInputData());
        object.setStep("inputPage");
        object._console.log(object._userInformation);
        var top = 0;
        var calendarKey = object._calendar.getDateKey(month, day, year);
        object._console.log(schedule);
        
        var navigationPage = document.getElementById(object._prefix + "visitorDetailsPostPage");
        navigationPage.classList.remove("hidden_panel");
        
        var calendarAccount = this._calendarAccount;
        object._console.log(calendarAccount);
        object._console.log(selectedOptions);
        
        var totalTimeInOptions = object.getTotalTimeInOptions(selectedOptions);
        
        /**
        var formMainPanel = document.getElementById("formMainPanel");
        formMainPanel.textContent = null;
        formMainPanel.setAttribute("class", "courseListPanel box_shadow positionCenterFormPanel");
        
        if(course != null){
            
            scheduleMainPanel.setAttribute("class", "courseListPanel postionLeftZeroForScheduleListPanel");
            
        }else{
            
            scheduleMainPanel.setAttribute("class", "courseListPanel positionOfNextPanelNotHavingCourseForScheduleListPanel");
            
        }
        
        var formPanel = document.createElement("div");
        formPanel.id = "inputFormPanel";
        formMainPanel.appendChild(formPanel);
        **/
        
        //document.scrollTop = object._top;
        
        var body = object._body;
        body.classList.remove("scrollBlock");
        
        var schedulePage = document.getElementById("booking-package_schedulePage");
        schedulePage.classList.add("hidden_panel");
        
        var formPanel = document.getElementById("booking-package_inputFormPanel");
        formPanel.classList.remove("booking_completed_panel");
        formPanel.textContent = null;
        
        
        var topBarPanel = document.createElement("div");
        topBarPanel.id = "reservationHeader";
        topBarPanel.classList.add("selectedDate");
        topBarPanel.textContent = object.i18n("Please fill in your details");
        formPanel.appendChild(topBarPanel);
        
        if (object._headingPosition == 1) {
            
            topBarPanel.style.top = object._top + "px";
            
        }
        
        var totalCost = 0;
        var goodsList = [];
        if(calendarAccount.type == 'day'){
            
            formPanel.classList.remove("hidden_panel");
            var date = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, schedule.hour, schedule.min, schedule.title, schedule.weekKey);
            var rowPanel = object.createRowPanel(object._i18n.get("Booking Date"), date, null, null, null);
            formPanel.appendChild(rowPanel);
            top += parseInt(rowPanel.clientHeight);
            
            
            totalCost = parseInt(schedule.cost);
            var course = null;
            /**
            for (var key in courseList) {
                
                if (courseList[key].selected == 1) {
                    
                    course = true;
                    var goods = {label: courseList[key].name, amount: parseInt(courseList[key].cost)};
                    goodsList.push(goods);
                    totalCost += parseInt(courseList[key].cost);
                    
                    if (parseInt(courseList[key].cost) > 0) {
                        
                        courseCostPanel = document.createElement("span");
                        courseCostPanel.classList.add("planPrice");
                        courseCostPanel.textContent = object._format.formatCost(courseList[key].cost, object._currency);
                        
                    }
                    
                }
                
            }
            **/
            //if(course != null){
            if (object._courseBool == true || object._calendarAccount.flowOfBooking == 'services') {
                
                /**
                var courseCostPanel = null;
                if(course.cost != null){
                    
                    var goods = {label: course.name, amount: parseInt(course.cost)};
                    goodsList.push(goods);
                    totalCost += parseInt(course.cost);
                    
                    if (parseInt(course.cost) > 0) {
                        
                        courseCostPanel = document.createElement("span");
                        courseCostPanel.classList.add("planPrice");
                        courseCostPanel.textContent = object._format.formatCost(course.cost, object._currency);
                        
                    }
                    
                    
                }
                **/
                
                //var rowPanel = object.createRowPanel(object._courseName, course.name, null, null, null);
                var rowPanel = object.createRowPanel(object._courseName, "", null, null, null);
                var valuePanel = rowPanel.getElementsByClassName("value")[0];
                valuePanel.textContent = null;
                
                var coursePanel = document.createElement("div");
                coursePanel.classList.add("mainPlan");
                valuePanel.appendChild(coursePanel);
                
                var response = object.selectedServicesPanel(course, courseList, goodsList, totalCost, coursePanel);
                course = response.course;
                goodsList = response.goodsList;
                totalCost = response.totalCost;
                /**
                for (var key in courseList) {
                    
                    if (courseList[key].selected == 1) {
                        
                        course = true;
                        var courseCostPanel = null;
                        var goods = {label: courseList[key].name, amount: parseInt(courseList[key].cost)};
                        goodsList.push(goods);
                        totalCost += parseInt(courseList[key].cost);
                        
                        if (parseInt(courseList[key].cost) > 0) {
                            
                            courseCostPanel = document.createElement("span");
                            courseCostPanel.classList.add("planPrice");
                            courseCostPanel.textContent = object._format.formatCost(courseList[key].cost, object._currency);
                            
                        }
                        
                        var courseLinePanel = document.createElement("div");
                        courseLinePanel.classList.add("courseLinePanel");
                        coursePanel.appendChild(courseLinePanel);
                        
                        var courseNamePanel = document.createElement("span");
                        courseNamePanel.classList.add("planName");
                        courseNamePanel.textContent = courseList[key].name;
                        courseLinePanel.appendChild(courseNamePanel);
                        if (courseCostPanel != null) {
                            
                            courseLinePanel.appendChild(courseCostPanel);
                            
                        }
                        
                        var selectedOptions = courseList[key].selectedOptionsList;
                        if (selectedOptions != null && selectedOptions.length > 0) {
                            
                            var ul = document.createElement("ul");
                            coursePanel.appendChild(ul);
                            
                            for(var i = 0; i < selectedOptions.length; i++){
                                
                                var option = selectedOptions[i];
                                object._console.log(option);
                                if (parseInt(option.selected) == 1) {
                                    
                                    var goods = {label: option.name, amount: parseInt(option.cost)};
                                    goodsList.push(goods);
                                    totalCost += parseInt(option.cost);
                                    
                                    var optionNamePanel = document.createElement("span");
                                    optionNamePanel.classList.add("planName");
                                    optionNamePanel.textContent = option.name;
                                    
                                    var optionPricePanel = document.createElement("span");
                                    optionPricePanel.classList.add("planPrice");
                                    if (parseInt(option.cost) > 0) {
                                        
                                        optionPricePanel.textContent = object._format.formatCost(option.cost, object._currency);
                                        
                                    }
                                    
                                    var li = document.createElement("li");
                                    li.appendChild(optionNamePanel);
                                    li.appendChild(optionPricePanel);
                                    ul.appendChild(li);
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                }
                **/
                object._console.log(goodsList);
                
                formPanel.appendChild(rowPanel);
                top += parseInt(rowPanel.clientHeight);
                
            }
            
            var surchargePanel = object.createRowPanel("Surcharge", "", null, null, null);
            surchargePanel.id = "surchargeTaxTitle";
            var taxePanel = object.createRowPanel("Tax", "", null, null, null);
            
            var taxes = new TAXES(object._i18n, object._currency, object._debug);
            taxes.setTaxes(object._taxes);
            taxes.taxesDetails(totalCost, formPanel, surchargePanel, taxePanel);
            var responseTaxes = taxes.getTaxes();
            for (var key in responseTaxes) {
                
                var tax = responseTaxes[key];
                if (tax.active != 'true') {
                    
                    continue;
                    
                }
                
                if ((tax.type == 'tax' && tax.tax == 'tax_exclusive') || tax.type == 'surcharge') {
                    
                    totalCost += parseInt(tax.taxValue);
                    var goods = {label: tax.name, amount: parseInt(tax.taxValue)};
                    goodsList.push(goods);
                    
                }
                
            }
            
            
            object._console.log("totalCost = " + totalCost);
            if(totalCost != 0){
                
                var formatPrice = object._format.formatCost(totalCost, object._currency);
                var rowPanel = object.createRowPanel(this._i18n.get("Total amount"), formatPrice, null, null, null);
                rowPanel.classList.add("total_amount");
                formPanel.appendChild(rowPanel);
                top += parseInt(rowPanel.clientHeight);
                
            }
            
        }else{
            
            topBarPanel.textContent = object.i18n("Please fill in your details");
            
            var hotelDetails = object._hotel.verifySchedule(true);
            object._console.log(hotelDetails);
            totalCost = hotelDetails.amount + (hotelDetails.additionalFee * hotelDetails.nights);
            
            var amount = {label: this._i18n.get("Accommodation fees"), amount: parseInt(hotelDetails.amount)};
            var additionalFee = {label: this._i18n.get("Additional fees"), amount: parseInt(hotelDetails.additionalFee * hotelDetails.nights)};
            goodsList.push(amount);
            goodsList.push(additionalFee);
            for (var key in hotelDetails.taxes) {
                
                var tax = hotelDetails.taxes[key];
                if ((tax.type == 'tax' && tax.tax == 'tax_exclusive') || tax.type == 'surcharge') {
                    
                    goodsList.push({label: tax.name, amount: parseInt(tax.taxValue)});
                    
                }
                
            }
            object._console.log("totalCost = " + totalCost);
            object.setScrollY(document.getElementById("booking-package_durationStay"));
            //callback({mode: "top", top: object._top});
            
        }
        
        
        
        var formPanelList = {};
        //var inputData = {};
        var inputData = object.getInputData();
        var input = new Booking_Package_Input(object._debug);
        input.setUserInformation(object._userInformation);
        input.setUserEmail(object._userEmail);
        input.setPrefix(object._prefix);
        var formData = object._formData;
        for(var i = 0; i < formData.length; i++){
            
            if(formData[i].active != 'true'){
                
                continue;
                
            }
            
            if(typeof formData[i]['name'] == "string"){
                
                formData[i]['name'] = formData[i]['name'].replace(/\\/g, "");
                
            }
            
            var name = formData[i].name;
            if (formData[i].uri != null && formData[i].uri.length > 0) {
                
                name = document.createElement("a");
                name.target = "_blank";
                name.href = formData[i].uri;
                name.textContent = formData[i].name;
                object._console.log(typeof name);
                
            }
            
            object._console.log(inputData);
            
            var value = input.createInput(i, formData[i], inputData, null);
            var rowPanel = object.createRowPanel(name, value, formData[i].id, formData[i].required, null);
            
            formPanelList[i] = rowPanel;
            formPanel.appendChild(rowPanel);
            
            /**
            rowPanel.classList.remove("row");
            var filedPanel = document.createElement("div");
            filedPanel.classList.add("row");
    		filedPanel.id = object._prefix + "group_" + formData[i].id;
    		filedPanel.appendChild(rowPanel);
            
            formPanelList[i] = filedPanel;
            formPanel.appendChild(filedPanel);
            **/
            
        }
        
        object._console.log(object._paymentMethod);
        var paymentMethod = object._paymentMethod;
        if (totalCost == 0 || object._isExtensionsValid != 1) {
            
            paymentMethod = ['locally'];
            
        }
        
        if (paymentMethod.length > 1) {
            
            var paymentEvent = function(payment) {
                
                var key = parseInt(payment.getAttribute("data-value"));
                object._console.log(paymentMethod[key]);
                var idList = ["booking-package_pay_locally", "booking-package_pay_with_paypal", "booking-package_pay_with_stripe"]
                for (var i = 0; i < idList.length; i++) {
                    
                    var id = idList[i];
                    if (document.getElementById(id) != null) {
                        
                        document.getElementById(id).classList.add("hidden_panel");
                        
                    }
                    
                }
                
                if (paymentMethod[key] == 'locally' && document.getElementById("booking-package_pay_locally") != null) {
                    
                    document.getElementById("booking-package_pay_locally").classList.remove("hidden_panel");
                    
                } else if (paymentMethod[key] == 'stripe' && document.getElementById("booking-package_pay_with_stripe") != null) {
                    
                    
                    document.getElementById("booking-package_pay_with_stripe").classList.remove("hidden_panel");
                    
                } else if (paymentMethod[key] == 'paypal' && document.getElementById("booking-package_pay_with_paypal") != null) {
                    
                    document.getElementById("booking-package_pay_with_paypal").classList.remove("hidden_panel");
                    
                }
                
            };
            
            var paymentData = {id: "paymentMethod", type: "RADIO", active: "true", name: object._i18n.get("Select payment method"), options: paymentMethod.join(","), value: ""};
            var value = input.createInput("paymentMethod", paymentData, [], paymentEvent);
            var paymentMethodPanel = object.createRowPanel(object._i18n.get("Select payment method"), value, "paymentMethod", "true", null);
            paymentMethodPanel.id = "booking-package_paymentMethod";
            formPanel.appendChild(paymentMethodPanel);
            
            var paymentMethodList = document.getElementById("booking_package_input_paymentMethod");
            var paymentRadios = paymentMethodList.getElementsByTagName("input");
            var paymentSpans = paymentMethodList.getElementsByClassName("radio_title");
            for (var i = 0; i < paymentRadios.length; i++) {
                
                if (paymentRadios[i].value == 'locally') {
                    
                    paymentSpans[i].classList.add("locally");
                    paymentSpans[i].textContent = object._i18n.get("I will pay locally");
                    
                } else if (paymentRadios[i].value == 'stripe') {
                    
                    paymentSpans[i].classList.add("stripe");
                    paymentSpans[i].textContent = object._i18n.get("Pay with Credit Card");
                    
                } else {
                    
                    paymentSpans[i].classList.add("paypal");
                    paymentSpans[i].textContent = object._i18n.get("Pay with PayPal");
                    
                }
                
            }
            
            
        }
        
        
        var cartPanel = document.createElement("div");
        cartPanel.id = "paymentPanel";
        cartPanel.classList.add("cartPanel");
        formPanel.appendChild(cartPanel);
        if((this._stripe_active == 1 || this._paypal_active == 1) && totalCost != 0){
            
            /** Stripe and PayPal **/
            
            object.paymentPanel(object._stripe_public_key, object._paypal_client_id, object._paypal_mode, object._country, object._currency, cartPanel, goodsList, calendarData, schedule, course, formData, formPanelList, inputData, selectedOptions, function(paymentResponse){
                
                object._console.log("paymentResponse.paymentName = " + paymentResponse.paymentName);
                object._console.log(paymentResponse);
                var token = null;
                
                if(paymentResponse.paymentName == 'stripe'){
                    
                    if(paymentResponse.complete != null && typeof paymentResponse.complete == 'function'){
                        
                        token = paymentResponse.token.id;
                        
                    }else{
                        
                        token = paymentResponse.token.id;
                        
                    }
                    
                }else if(paymentResponse.paymentName == 'paypal'){
                    
                    //token = paymentResponse.orderID;
                    token = paymentResponse.id;
                    
                }
                
                
                
                object.sendBooking(object._url, object._nonce, object._action, "sendBooking", true, paymentResponse.paymentName, token, calendarData, schedule, courseList, formData, formPanelList, inputData, selectedOptions, accountKey, function(response){
                    
                    object._console.log(response);
                    if (response === false || response.status == 'error') {
                        
                        if(paymentResponse.paymentName == 'stripe' && paymentResponse.complete != null && typeof paymentResponse.complete == 'function'){
                            
                            paymentResponse.complete('fail');
                            if (response !== false) {
                                
                                delete response.status;
                                delete response.message;
                                calendarData = response;
                                
                            }
                            
                        }
                        
                    } else {
                        
                        if(paymentResponse.paymentName == 'stripe' && paymentResponse.complete != null && typeof paymentResponse.complete == 'function'){
                            
                            paymentResponse.complete('success');
                            
                        }
                        
                        formPanel.removeChild(cartPanel);
                        reservationCompleted(response, accountKey);
                        
                    }
                    
                });
                
            });
            /** Stripe **/
            
        }
        
        //else{
            
            var bookingButton = document.createElement("button");
            bookingButton.classList.add("returnButton");
            bookingButton.classList.add("bookingButton");
            bookingButton.textContent = object.i18n("Book now");
            
            var bookingButtonPanel = document.createElement("div");
            bookingButtonPanel.id = "booking-package_pay_locally";
            bookingButtonPanel.classList.add("bottomBarPanel");
            bookingButtonPanel.classList.add("hidden_panel");
            bookingButtonPanel.appendChild(bookingButton);
            cartPanel.appendChild(bookingButtonPanel);
            
            bookingButton.onclick = function(){
                
                bookingButton.disabled = true;
                object.sendBooking(object._url, object._nonce, object._action, "sendBooking", true, null, null, calendarData, schedule, courseList, formData, formPanelList, inputData, selectedOptions, accountKey, function(response){
                    
                    object._console.log(typeof response);
                    
                    if (response === false) {
                        
                        bookingButton.disabled = false;
                        
                    } else {
                        
                        if (response.status == 'success') {
                            
                            cartPanel.removeChild(bookingButtonPanel);
                            reservationCompleted(response, accountKey);
                            
                        } else {
                            
                            delete response.status;
                            delete response.message;
                            calendarData = response;
                            object._console.log(response);
                            bookingButton.disabled = false;
                            
                        }
                        
                    }
                    
                    /**
                    if (response.status == 'success') {
                        
                        cartPanel.removeChild(bookingButtonPanel);
                        reservationCompleted(response, accountKey);
                        
                    } else {
                        
                        if (response !== false) {
                            
                            delete response.status;
                            delete response.message;
                            calendarData = response;
                            
                        }
                        
                        object._console.log(response);
                        bookingButton.disabled = false;
                        
                    }
                    **/
                });
                
            }
            
        //}
        
        object.setInputData(inputData);
        
        
        
        if (paymentMethod[0] == 'locally') {
            
            object._console.log(bookingButtonPanel);
            bookingButtonPanel.classList.remove("hidden_panel");
            
        } else if (paymentMethod[0] == 'stripe' && document.getElementById("booking-package_pay_with_stripe") != null) {
            
            document.getElementById("booking-package_pay_with_stripe").classList.remove("hidden_panel");
            
        } else if (paymentMethod[0] == 'paypal' && document.getElementById("booking-package_pay_with_paypal") != null) {
            
            document.getElementById("booking-package_pay_with_paypal").classList.remove("hidden_panel");
            
        }
        
        
        var bottomBarPanel = document.createElement("div");
        bottomBarPanel.classList.add("bottomBarPanel");
        formPanel.appendChild(bottomBarPanel);
        
        var returnButton = document.createElement("button");
        returnButton.id = "returnToSchedules";
        returnButton.classList.add("returnButton")
        returnButton.textContent = object.i18n("Return to schedules");
        if(calendarAccount.type == "hotel"){
            
            returnButton.textContent = object.i18n("Return to calendar");
            
        }
        bottomBarPanel.appendChild(returnButton);
        
        returnButton.onclick = function(){
            
            object.setScrollY(formPanel);
            object.setStep("topPage");
            navigationPage.classList.add("hidden_panel");
            if (calendarAccount.type == "day") {
                
                document.getElementById(object._prefix + "schedulesPostPage").classList.remove("hidden_panel");
                schedulePage.classList.remove("hidden_panel");
                schedulePage.scrollIntoView();
                formPanel.classList.add("hidden_panel");
                calendarData.mode = "return";
                callback(calendarData);
                
            } else {
                
                document.getElementById(object._prefix + "calendarPostPage").classList.remove("hidden_panel");
                calendarData.mode = "return";
                callback(calendarData);
                
            }
            
            
        };
        
        var reservationCompleted = function(response, accountKey){
            
            if (typeof object._gtag == 'function') {
                
                object._gtag('event', 'booking-package', {
                    'event_category': 'ID=' + object._calendarAccount.key, 
                    'event_label': 'completed',
                    'event_callback': function(){
                        object._console.log("Send gtag");
                    },
                });
                
            }
            
            if (typeof object._redirectPage == 'string') {
                
                var redirectForm = document.createElement('form');
                redirectForm.method = 'post';
                redirectForm.action = object._redirectPage;
                //formPanel.textContent = null;
                formPanel.appendChild(redirectForm);
                redirectForm.submit();
                return null;
                
            }
            
            object._console.log("accountKey = " + accountKey);
            navigationPage.classList.add("hidden_panel");
            var navigationPageForThanks = document.getElementById(object._prefix + "thanksPostPage");
            navigationPageForThanks.classList.remove("hidden_panel");
            object.setScrollY(navigationPageForThanks);
            
            returnButton.textContent = object.i18n("Return to calendar");
            returnButton.classList.add("returnButtonForBookingCmpleted");
            returnButton.removeEventListener("click", null);
            document.getElementById("daysListPanel").setAttribute("style", "");
            document.getElementById("scheduleMainPanel").setAttribute("style", "");
            document.getElementById("courseMainPanel").setAttribute("style", "");
            document.getElementById("blockPanel").setAttribute("style", "");
            returnButton.onclick = function(){
                
                navigationPageForThanks.classList.add("hidden_panel");
                object.setScrollY(formPanel);
                object._console.log("click");
                callback(response);
                document.getElementById("booking-package_calendarPage").classList.remove("hidden_panel");
                formPanel.classList.add("hidden_panel");
                
            }
            
            topBarPanel.textContent = object.i18n("Booking Completed");
            topBarPanel.classList.add("booking_completed");
            object.setScrollY(formPanel);
            
            formPanel.classList.add("booking_completed_panel");
            
            
            
        }
        
        if(document.getElementById("returnToSchedules") == null){
            
            var returnButton = document.createElement("button");
            returnButton.id = "returnToSchedules";
            returnButton.textContent = object.i18n("Return");
            
            var bookingButton = document.createElement("button");
            bookingButton.textContent = object.i18n("Book now");
            bookingButton.setAttribute("class", "bookingButton");
            
            var bottomPanel = document.getElementById("bottomPanel");
            bottomPanel.appendChild(returnButton);
            bottomPanel.appendChild(bookingButton);
            
            bookingButton.onclick = function(event){
                
                var valueList = {};
                var post = object.verifyForm("sendBooking", object._nonce, object._action, calendarData.date, schedule, courseList, formData, formPanelList, inputData, valueList);
                //post.sendEmail = Number(sendEmail);
                object._console.log(post);
                if(post !== false){
                    
                    post.sendEmail = 1;
                    xmlHttp = new Booking_App_XMLHttp(object._url, post, false, function(response){
                        
                        object._console.log(response);
                        if(response.status == "success"){
                            
                        }else{
                            
                            alert(response.message);
                            
                        }
                        //loadingPanel.setAttribute("class", "hidden_panel");
                        
                    }, function(responseText){
                        
                        object.setResponseText(responseText);
                        
                    });
                    
                    
                }else{
                    
                    var scrollTop = formMainPanel.scrollTop;
                    var formMainPanelTop = top;
                    for(var key in formPanelList){
                        
                        object._console.log(formPanelList[key]);
                        if(formPanelList[key].getAttribute("data-errorInput") == 1){
                            
                            object._console.log("error = " + key + " formMainPanelTop = " + formMainPanelTop);
                            var scrollPosition = formPanelList[key].getBoundingClientRect().top - object._top;
                            object._console.log("scrollPosition = " + scrollPosition);
                            window.scrollTo(0, scrollPosition);
                            formMainPanel.scrollTop = formMainPanelTop;
                            break;
                            
                        }
                        
                        formMainPanelTop += parseInt(formPanelList[key].clientHeight);
                        
                    }
                    
                }
                
            }
            
        }
        
        //formPanel.style.top = object._top + "px";
        var scrollPositionNew = window.pageYOffset + formPanel.getBoundingClientRect().top - object._top;
        //var scrollPositionNew = window.pageYOffset + formPanel.getBoundingClientRect().top;
        var scrollPosition = formPanel.getBoundingClientRect().top - object._top;
        if(calendarAccount.type == "hotel"){
            
            callback({mode: "top", top: object._top});
            scrollPositionNew = window.pageYOffset + document.getElementById("booking-package_durationStay").getBoundingClientRect().top - object._top;
            //scrollPositionNew = window.pageYOffset + document.getElementById("booking-package_durationStay").getBoundingClientRect().top;
            
        }
        
        object._console.log("scrollPosition = " + scrollPosition);
        //window.scrollTo(0, scrollPositionNew);
        object.setScrollY(formPanel);
        //formPanel.scrollIntoView();
        
    }
    
    Booking_App.prototype.sendBooking = function(url, nonce, action, mode, sendBool, payType, payToken, calendarData, schedule, courseList, formData, formPanelList, inputData, selectedOptions, accountKey, callback){
        
        var object = this;
        var calendarAccount = object._calendarAccount;
        var valueList = {};
        var post = object.verifyForm(mode, nonce, action, calendarData.date, schedule, courseList, formData, formPanelList, inputData, valueList);
        if(post !== false){
            
            if(sendBool === true){
                
                post.accountKey = accountKey;
                
                post.sendEmail = 1;
                if (payType != null && payToken != null) {
                    
                    post.payType = payType;
                    post.payToken = payToken;
                    
                }
                
                if (calendarAccount.type == "hotel") {
                    
                    post.json = JSON.stringify(object._hotel.verifySchedule(true));
                    
                }
                
                post.selectedOptions = JSON.stringify([]);
                if (selectedOptions != null) {
                    
                    post.selectedOptions = JSON.stringify(selectedOptions);
                    
                }
                
                post.public = 1;
                post.permalink = object._permalink;
                
                var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                bookingBlockPanel.classList.remove("hidden_panel");
                xmlHttp = new Booking_App_XMLHttp(url, post, false, function(response){
                    
                    object._console.log(response);
                    if (response.status == "success") {
                        
                        response.mode = "completed";
                        callback(response);
                        object.setUserInformation(response.userInformationValues);
                        
                        var buttonClassName = object._prefix + "user_information_button";
                        var userEditButtonList = document.getElementsByClassName(buttonClassName);
                        for (var i = 0; i < userEditButtonList.length; i++) {
                            
                            userEditButtonList[i].classList.add("hidden_panel");
                            
                        }
                        object._console.log(valueList);
                        for (var key in formPanelList) {
                            
                            var deletePanel = formPanelList[key].getElementsByClassName("value")[0];
                            formPanelList[key].removeChild(deletePanel);
                            var values = valueList[key];
                            if (typeof valueList[key] == 'string') {
                                
                                values = JSON.parse(valueList[key]);
                                
                            }
                            
                            for (var i = 0; i < values.length; i++) {
                                
                                var valuePanel = document.createElement("div");
                                valuePanel.classList.add("value");
                                valuePanel.textContent = values[i];
                                formPanelList[key].appendChild(valuePanel);
                                
                            }
                            
                        }
                        
                        if (document.getElementById("booking-package_paymentMethod")) {
                            
                            var paymentMethod = document.getElementById("booking-package_paymentMethod");
                            paymentMethod.parentNode.removeChild(paymentMethod);
                            
                        }
                        
                    } else {
                        
                        var message = "";
                        if (response.message != null) {
                            
                            message = response.message;
                            
                        }
                        
                        if (response.calendar != null && response.schedule != null) {
                            
                            callback(response);
                            
                        } else {
                            
                            callback(false);
                            
                        }
                        
                        var timer = setInterval(function(){
                            
                            clearInterval(timer);
                            alert(message);
                            
                        }, 500);
                        
                        if(response.reload != null && parseInt(response.reload) == 1){
                            
                            window.location.reload(true);
                            
                        }
                        
                    }
                    
                    bookingBlockPanel.classList.add("hidden_panel");
                    //loadingPanel.setAttribute("class", "hidden_panel");
                    
                }, function(responseText){
                    
                    object.setResponseText(responseText);
                    
                });
                
            }else{
                
                
                
            }
            
            
        }else{
            
            callback(false);
            for(var key in formPanelList){
                
                if(formPanelList[key].getAttribute("data-errorInput") == 1 && typeof window == 'object' && typeof window.scrollY == 'number'){
                    
                    object._console.log("error = " + key);
                    //formPanelList[key].scrollIntoView({behavior: "instant", block: "center"});
                    var scrollPosition = formPanelList[key].getBoundingClientRect().top - object._top - 50;
                    
                    object._console.log("scrollPosition = " + scrollPosition);
                    window.scrollTo(0, scrollPosition);
                    formPanelList[key].scrollIntoView(true);
                    object._console.log(formPanelList[key].getBoundingClientRect());
                    if (typeof window.scroll == 'function') {
                        
                        window.scroll(0, (window.scrollY - object._top - document.getElementById("reservationHeader").getBoundingClientRect().height));
                        
                    }
                    
                    break;
                    
                }
                
            }
            
        }
        
    }
    
    Booking_App.prototype.paymentPanel = function(stripe_public_key, paypal_client_id, paypal_mode, country, currency, cartPanel, goodsList, calendarData, schedule, courseList, formData, formPanelList, inputData, selectedOptions, callback){
        
        var object = this;
        if(object._stripe_active == 1){
            
            object.paypalPanelcartInputForStripe(stripe_public_key, country, currency, cartPanel, goodsList, selectedOptions, callback);
            
        }
        
        if(object._paypal_active == 1){
            
            object.paypalPanel(paypal_client_id, paypal_mode, country, currency, cartPanel, goodsList, calendarData, schedule, courseList, formData, formPanelList, inputData, selectedOptions, callback);
            
        }
        
    }
    
    Booking_App.prototype.paypalPanel = function(paypal_client_id, paypal_mode, country, currency, cartPanel, goodsList, calendarData, schedule, courseList, formData, formPanelList, inputData, selectedOptions, callback){
        
        var object = this;
        object._console.log("country = " + country + " currency = " + currency.toUpperCase());
        object._console.log("paypal_mode = " + paypal_mode);
        object._console.log("this._locale = " + this._locale);
        object._console.log(selectedOptions);
        
        var payPalPanel = document.createElement("div");
        payPalPanel.id = "booking-package_pay_with_paypal";
        payPalPanel.classList.add("hidden_panel");
        cartPanel.appendChild(payPalPanel);
        
        
        var locale = 'en_US';
        if(object._locale != null && object._locale != ''){
            
            if(object._locale.length == 2){
                
                if(object._locale == 'ja'){
                    
                    locale = 'ja_JP';
                    
                }
                
            }else{
                
                locale = object._locale;
                
            }
            
        }
        
        var total = 0;
        for(var i = 0; i < goodsList.length; i++){
            
            total += goodsList[i].amount;
            
        }
        /**
        if (selectedOptions != null) {
            
            for(var i = 0; i < selectedOptions.length; i++){
                
                var option = selectedOptions[i];
                if(parseInt(option.selected) == 1){
                    
                    goodsList.push({"label": option.name, "amount": parseInt(option.cost)});
                    total += parseInt(option.cost);
                    
                }
                
            }
            
        }
        **/
        if(currency.toLocaleUpperCase() != 'JPY'){
            
            total = Number(total) / 100;
            total = total.toFixed(2);
            
        }
        
        object._console.log("total = " + total);
        /**
        if (object._stripe_active == 1 && object._paypal_active == 1) {
            
            var orLabel = document.createElement("div");
            orLabel.setAttribute("class", "orLabel");
            orLabel.textContent = "OR";
            payPalPanel.appendChild(orLabel);
            
        }
        **/
        /**
        var payTypeLabel = document.createElement("div");
        payTypeLabel.textContent = "PayPal";
        payTypeLabel.setAttribute("class", "payTypeLabel");
        payPalPanel.appendChild(payTypeLabel);
        **/
        
        var submit_payment = document.createElement("div");
        submit_payment.id = "paypal-button";
        payPalPanel.appendChild(submit_payment);
        var mode = "sandbox";
        var client_data = {sandbox: paypal_client_id};
        if(paypal_mode == 1){
            
            mode = "production";
            client_data = {production: paypal_client_id};
            
        }
        
        paypal.Buttons({
            
            createOrder: function(data, actions) {
                
                var valueList = {};
                var post = object.verifyForm("paypal", object._nonce, object._action, calendarData.date, schedule, courseList, formData, formPanelList, inputData, valueList);
                object._console.log(post);
                if (post != false) {
                    
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: total,
                                /**currency_code: currency.toUpperCase(),**/
                            }
                        }]
                    });
                
                } else {
                    
                    for(var key in formPanelList){
                        
                        if(formPanelList[key].getAttribute("data-errorInput") == 1 && typeof window == 'object' && typeof window.scrollY == 'number'){
                            
                            var scrollPosition = formPanelList[key].getBoundingClientRect().top - object._top - 50;
                            window.scrollTo(0, scrollPosition);
                            formPanelList[key].scrollIntoView(true);
                            if (typeof window.scroll == 'function') {
                                
                                window.scroll(0, (window.scrollY - object._top - document.getElementById("reservationHeader").getBoundingClientRect().height));
                                
                            }
                            
                            break;
                            
                        }
                        
                    }
                    return {transactions: []};
                    
                }
                
            },
            onApprove: function(data, actions) {
                
                data.paymentName = "paypal";
                object._console.log(data);
                //callback(data);
                
                return actions.order.capture().then(function(details) {
                    
                    object._console.log(details);
                    details.paymentName = "paypal";
                    callback(details);
                    /**
                    return fetch('/paypal-transaction-complete', {
                        method: 'post',
                            headers: {
                                'content-type': 'application/json'
                            },
                        body: JSON.stringify({
                            orderID: data.orderID
                        })
                    });
                    **/
                    
                });
                
            }
            
            
        }).render('#paypal-button');
        
        /**
        paypal.Button.render({
            // Configure environment
            env: mode,
            client: {
                sandbox: paypal_client_id,
                production: paypal_client_id
            },
            // Customize button (optional)
            locale: locale,
            country: country,
            style: {
                size: 'responsive',
                color: 'blue',
                shape: 'rect',
            },
            // Set up a payment
            payment: function (data, actions) {
                
                object._console.log("Set up a payment");
                var valueList = {};
                var post = object.verifyForm("paypal", object._nonce, object._action, calendarData.date, schedule, courseList, formData, formPanelList, inputData, valueList);
                object._console.log(post);
                if(post != false){
                    
                    return actions.payment.create({
                        transactions: [{
                            amount: {
                                total: total,
                                currency: currency.toUpperCase()
                            },
                            custom: "",
                        }]
                    });
                    
                }else{
                    
                    for(var key in formPanelList){
                        
                        if(formPanelList[key].getAttribute("data-errorInput") == 1 && typeof window == 'object' && typeof window.scrollY == 'number'){
                            
                            var scrollPosition = formPanelList[key].getBoundingClientRect().top - object._top - 50;
                            window.scrollTo(0, scrollPosition);
                            formPanelList[key].scrollIntoView(true);
                            if (typeof window.scroll == 'function') {
                                
                                window.scroll(0, (window.scrollY - object._top - document.getElementById("reservationHeader").getBoundingClientRect().height));
                                
                            }
                            
                            break;
                            
                        }
                        
                    }
                    return {transactions: []};
                    
                }
                
            },
            // Execute the payment
            onAuthorize: function (data, actions) {
                
                object._console.log("Execute the payment");
                return actions.payment.execute().then(function () {
                    
                    data.paymentName = "paypal";
                    object._console.log(data);
                    callback(data);
                    // Show a confirmation message to the buyer
                    //window.alert('Thank you for your purchase!');
                    
                });
            },
            onCancel: function (data, actions) {
                
                object._console.log("onCancel");
                
            }
        }, '#paypal-button');
        **/
        
    }
    
    Booking_App.prototype.paypalPanelcartInputForStripe = function(stripe_public_key, country, currency, cartPanel, goodsList, selectedOptions, callback){
        
        var object = this;
        object._console.log("country = " + country + " currency = " + currency);
        object._console.log(goodsList);
        object._console.log(selectedOptions);
        
        var stripePanel = document.createElement("div");
        stripePanel.id = "booking-package_pay_with_stripe";
        stripePanel.classList.add("hidden_panel");
        cartPanel.appendChild(stripePanel);
        
        var total = 0;
        for(var i = 0; i < goodsList.length; i++){
            /**
            if (goodsList[i].tax == null) {
                
                total += goodsList[i].amount;
                
            } else if(goodsList[i].tax != null && goodsList[i].tax == 'tax_exclusive') {
                
                total += goodsList[i].amount;
                
            }
            **/
            total += goodsList[i].amount;
            
        }
        object._console.log('total = ' + total);
        /**
        if (selectedOptions != null) {
            
            for(var i = 0; i < selectedOptions.length; i++){
                
                var option = selectedOptions[i];
                if(parseInt(option.selected) == 1){
                    
                    goodsList.push({"label": option.name, "amount": parseInt(option.cost)});
                    total += parseInt(option.cost);
                    
                }
                
            }
            
        }
        **/
        var stripe = Stripe(stripe_public_key);
        var elements = stripe.elements();
        var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
        
        var titleLabel = document.createElement("label");
        titleLabel.setAttribute("for", "card-element");
        titleLabel.textContent = object.i18n("Credit card");
        
        var card_element = document.createElement("div");
        card_element.id = "card-element";
        
        var card_errors = document.createElement("div");
        card_errors.id = "card-errors";
        card_errors.setAttribute("role", "alert");
        
        var submit_payment = document.createElement("button");
        submit_payment.textContent = object.i18n("Payment & Booking");
        submit_payment.setAttribute("class", "paymentButton");
        
        var form_row = document.createElement("div");
        form_row.classList.add("form-row");
        form_row.appendChild(titleLabel);
        form_row.appendChild(card_element);
        form_row.appendChild(card_errors);
        form_row.appendChild(submit_payment);
        
        var payment_form = document.createElement("form");
        payment_form.id = "payment-form";
        //payment_form.action = "/charge";
        //payment_form.method = "post";
        payment_form.appendChild(form_row);
        
        stripePanel.appendChild(payment_form);
        
        var card = elements.create('card', {style: style, hidePostalCode: true});
        card.mount('#card-element');
        
        
        
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            
            event.preventDefault();
            var bookingBlockPanel = document.getElementById("bookingBlockPanel");
            bookingBlockPanel.classList.remove("hidden_panel");
            var post = {nonce: object._nonce, action: object._action, mode: 'intentForStripe', amount: total};
            new Booking_App_XMLHttp(object._url, post, false, function(response){
                
                object._console.log(response);
                var client_secret = response.client_secret;
                
                stripe.confirmCardPayment(client_secret, {
                    payment_method: {
                        card: card,
                    }
                }).then(function(result) {
                    
                    object._console.log(result);
                    bookingBlockPanel.classList.add('hidden_panel');
                    if (result.error) {
                        
                        window.alert(result.error.message);
                        
                    } else {
                        // The payment has been processed!
                        if (result.paymentIntent.status === 'succeeded') {
                            
                            result.token = {id: result.paymentIntent.id};
                            object._console.log(result);
                            object._console.log(result.paymentIntent.id);
                            result.paymentName = "stripe";
                            callback(result);
                            
                        }
                        
                    }
                    
                });
                
            });
            /**
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the customer that there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    //stripeTokenHandler(result.token);
                    object._console.log(result);
                    object._console.log(result.token);
                    result.paymentName = "stripe";
                    callback(result)
                    
                }
            
            });
            **/
        });
            
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        
        /** Apple pay AND Pay with Google **/
        
        var orLabel = document.createElement("div");
        orLabel.setAttribute("class", "orLabel hidden_panel");
        orLabel.textContent = "OR";
        stripePanel.appendChild(orLabel);
        
        var payTypeLabel = document.createElement("div");
        payTypeLabel.setAttribute("class", "payTypeLabel hidden_panel");
        stripePanel.appendChild(payTypeLabel);
        
        var payment_request_button = document.createElement("div");
        payment_request_button.id = "payment-request-button";
        stripePanel.appendChild(payment_request_button);
        
        var paymentRequest = stripe.paymentRequest({
            country: country,
            currency: currency,
            total: {
                label: 'Total amount',
                amount: total,
            },
            displayItems: goodsList
        });
        
        var prButton = elements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
            style: {
                paymentRequestButton: {
                    type: 'default', // default: 'default'
                    theme: 'light-outline', // default: 'dark'
                    height: '40px', // default: '40px', the width is always '100%'
                },
            }
        });
        
        // Check the availability of the Payment Request API first.
        paymentRequest.canMakePayment().then(function(result) {
            if(result){
                
                object._console.log(result.applePay);
                if(result.applePay === false){
                    
                    payTypeLabel.textContent = "Goolge pay";
                    
                }else{
                    
                    payTypeLabel.textContent = "Apple pay";
                    payTypeLabel.textContent = "";
                    
                }
                
                orLabel.classList.remove("hidden_panel");
                payTypeLabel.classList.remove("hidden_panel");
                prButton.mount('#payment-request-button');
                
            }else{
                
                document.getElementById('payment-request-button').style.display = 'none';
                
            }
            
        });
        
        paymentRequest.on('token', function(ev) {
            // Send the token to your server to charge it!
            
            object._console.log(ev);
            object._console.log(JSON.stringify({token: ev.token.id}));
            //ev.complete('success');
            ev.paymentName = "stripe";
            callback(ev);
            
        });
        
    }
    
    Booking_App.prototype.setScrollY = function(element){
        
        element = document.getElementById("booking-package");
        var object = this;
        var rect = element.getBoundingClientRect();
        object._console.log("this._top = " + this._top);
        object._console.log(rect);
        if (rect.y < this._top) {
            
            object._console.log("this._top = " + this._top);
            object._console.log("this._topPanelHeight = " + this._topPanelHeight);
            var scrollY = rect.y + window.pageYOffset - this._top;
            object._console.log("scrollY = " + scrollY);
            if (typeof window.scroll == 'function') {
                
                window.scroll(window.pageXOffset, scrollY);
                
            }
            
        }
        
    }
    
    Booking_App.prototype.verifyForm = function(mode, nonce, action, date, schedule, courseList, formData, formPanelList, inputData, valueList){
        
        var object = this;
        object._console.log(date);
        object._console.log(schedule);
        object._console.log(courseList);
        object._console.log(formData);
        var sendBool = true;
        var input = new Booking_Package_Input(object._debug);
        input.setPrefix(object._prefix);
        for(var key in formData){
            
            object._console.log(key);
            object._console.log(inputData[key]);
            object._console.log(formData[key]);
            
            if(formData[key].active != 'true'){
                
                continue;
                
            }
            
            if(formPanelList[key] == null){
                
                continue;
                
            }
            
            var bool = input.inputCheck(key, formData[key], inputData[key], valueList);
            object._console.log("bool = " + bool);
            if(bool === true){
                
                formPanelList[key].removeAttribute("data-errorInput");
                formPanelList[key].classList.remove("rowError");
                //formPanelList[key].setAttribute("class", "row");
                
            }else{
                
                sendBool = false;
                formPanelList[key].setAttribute("data-errorInput", 1);
                formPanelList[key].classList.add("rowError");
                //formPanelList[key].setAttribute("class", "row rowError");
                
            }
            
        }
        
        object._console.log(valueList);
        if(sendBool === true){
            
            var post = {nonce: nonce, action: action, mode: mode, month: date.month, day: 1, year: date.year, applicantCount: '1', permission: 'public', timeKey: schedule.key, unixTime: schedule.unixTime, receivedUri: object._permalink};
            if((object._courseBool == true && courseList != null) || object._calendarAccount.flowOfBooking == 'services'){
                
                var selectedCourseList = [];
                var selectedCourseKeyList = [];
                for (var i in courseList) {
                    
                    if (courseList[i].selected == 1) {
                        
                        object._console.log(courseList[i]);
                        object._console.log(typeof courseList[i].options);
                        var service = {};
                        for (var key in courseList[i]) {
                            
                            service[key] = courseList[i][key];
                            
                        }
                        
                        
                        if (typeof courseList[i].options == 'string') {
                            
                            var options = JSON.parse(courseList[i].options);
                            service.options = options;
                            
                        }
                        
                        selectedCourseList.push(service);
                        selectedCourseKeyList.push(service.key);
                        post.courseKey = courseList[i].key;
                        
                    }
                    
                }
                
                post.selectedCourseList = JSON.stringify(selectedCourseList);
                post.selectedCourseKeyList = JSON.stringify(selectedCourseKeyList);
                //post.courseKey = course.key;
                
            }
            
            for(var key in valueList){
                
                object._console.log(valueList[key]);
                //post['form' + key] = valueList[key].join(",");
                if (typeof valueList[key] == 'object') {
                    
                    post['form' + key] = valueList[key].join(",");
                    
                } else if (typeof valueList[key] == 'string') {
                    
                    post['form' + key] = valueList[key];
                    
                }
                
            }
            
            return post;
            
        }else{
            
            return false;
            
        }
        
    }
    
    Booking_App.prototype.createRowPanel = function(name, value, id, required, actionElement){
        
        var object = this;
        object._console.log(typeof value);
        object._console.log("id = " + id);
        var namePanel = document.createElement("div");
        namePanel.setAttribute("class", "name");
        if (typeof name == 'object') {
            
            namePanel.appendChild(name);
            
        } else {
            
            namePanel.textContent = name;
            
        }
        
        var edit = 0;
        if (typeof value == 'object' && value.getAttribute("data-edit") != null) {
            
            edit = parseInt(value.getAttribute("data-edit"));
            
        }
        
        object._console.log("edit = " + edit);
        
        if((typeof required == "string" && required == 'true') || (typeof required == "number" && required == 1)){
            
            namePanel.setAttribute("class", "name required");
            
        }
        
        var inputPanel = null;
        if(typeof value == 'string' || typeof value == 'number'){
            
            inputPanel = document.createElement("div");
            inputPanel.textContent = value;
            if(id != null){
                
                inputPanel.id = id;
                
            }
            
        }else{
            
            inputPanel = value;
            
        }
        inputPanel.setAttribute("class", "value");
        
        var rowPanel = document.createElement("div");
        rowPanel.setAttribute("class", "row");
        rowPanel.appendChild(namePanel);
        
        if(edit == 1){
            
            var editButton = document.createElement("div");
            editButton.setAttribute("data-id", id);
            editButton.classList.add("material-icons");
            editButton.classList.add("editButton");
            editButton.classList.add(object._prefix + "user_information_button");
            editButton.setAttribute("style", "font-family: 'Material Icons' !important;");
            editButton.textContent = "border_color";
            rowPanel.appendChild(editButton);
            
            var doneButton = document.createElement("div");
            doneButton.setAttribute("data-id", id);
            doneButton.classList.add("material-icons");
            doneButton.classList.add("editButton");
            doneButton.classList.add("hidden_panel");
            doneButton.classList.add(object._prefix + "user_information_button");
            doneButton.textContent = "done_outline";
            rowPanel.appendChild(doneButton);
            
            editButton.onclick = function(){
                
                var id = editButton.getAttribute("data-id");
                var valueId = object._prefix + "value_" + id;
                var inputId = object._prefix + "input_" + id;
                editButton.classList.add("hidden_panel");
                doneButton.classList.remove("hidden_panel");
                document.getElementById(valueId).classList.add("hidden_panel");
                document.getElementById(inputId).classList.remove("hidden_panel");
                
            }
            
            doneButton.onclick = function(){
                
                var id = doneButton.getAttribute("data-id");
                var valueId = object._prefix + "value_" + id;
                var inputId = object._prefix + "input_" + id;
                doneButton.classList.add("hidden_panel");
                editButton.classList.remove("hidden_panel");
                document.getElementById(valueId).classList.remove("hidden_panel");
                document.getElementById(inputId).classList.add("hidden_panel");
                
            }
            
        }
        
        if(actionElement != null){
            
            rowPanel.appendChild(actionElement);
            
        }
        rowPanel.appendChild(inputPanel);
        
        
        
        return rowPanel;
        
    }
    
    Booking_App.prototype.unselectPanel = function(selectedKey, panelList, styleName){
        
        var object = this;
        object._console.log('selectedKey = ' + selectedKey);
        object._console.log(object._courseList);
        object._console.log(object._booking);
        object._console.log(panelList);
        for (var i = 0; i < panelList.length; i++) {
            
            var key = panelList[i].getAttribute("data-key");
            object._console.log('key = ' + key);
            var status = parseInt(panelList[i].getAttribute("data-status"));
            var serviceKey = parseInt(panelList[i].getAttribute("data-service"));
            if (key != selectedKey && status === 1) {
                
                panelList[i].setAttribute("class", styleName);
                
            }
        
        }
    
    }
    
    Booking_App.prototype.isJSON = function(arg){
		
		arg = (typeof arg === "function") ? arg() : arg;
	    if(typeof arg  !== "string") {
	        return false;
	    }
	    
	    try{
	    	arg = (!JSON) ? eval("(" + arg + ")") : JSON.parse(arg);
			return true;
	    }catch(e){
			return false;
	    }
		
	}
    
    
    
