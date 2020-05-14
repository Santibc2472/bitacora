/*globals I18n */
/*globals Booking_App_Calendar */
/*globals Booking_App_XMLHttp */
/*globals Booking_manage */
    
    function Booking_Package_Member(prefix, calendarAccount, setting, subscription, url, nonce, action, reservation_info, booking_package_dictionary, debug) {
        
        var object = this;
        this._debug = debug;
        this._console = {};
        this._console.log = debug.getConsoleLog();
        
        this._i18n = new I18n(null);
        this._i18n.setDictionary(booking_package_dictionary);
        this._booking_package_dictionary = booking_package_dictionary;
        this._prefix = prefix;
        this._calendarAccount = calendarAccount;
        this._setting = setting;
        this._reservation_info = reservation_info;
        this._subscriptions = subscription;
        //this._subscriptions = null;
        this._url = url;
        this._nonce = nonce;
        this._action = action;
        this._function = {name: "root", post: {}};
        this._top = 0;
        this._calendarAccountList = {};
        object._console.log(setting);
        object._console.log(booking_package_dictionary);
        
        this._startOfWeek = this._calendarAccount.startOfWeek;
        this._dateFormat = reservation_info.dateFormat;
        this._positionOfWeek = reservation_info.positionOfWeek;
        
        this._weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        this._calendar = new Booking_App_Calendar(this._weekName, this._dateFormat, this._positionOfWeek, this._startOfWeek, this._i18n, this._debug);
        this._calendar.setClock(reservation_info.clock);
        //this._hotel = new Hotel(this._currency, this._weekName, this._dateFormat, this._positionOfWeek, this._startOfWeek, booking_package_dictionary, this._debug);
        this._booking_manage = new Booking_manage(reservation_info, booking_package_dictionary);
        
        for (var key in reservation_info.calendarAccountList) {
            
            var account = reservation_info.calendarAccountList[key];
            object._calendarAccountList[parseInt(account.key)] = account;
            
        }
        
    }
    
    Booking_Package_Member.prototype.setFunction = function(name, post){
        
        this._function = {name: name, post: post};
        
    }
    
    Booking_Package_Member.prototype.getFunction = function(){
        
        return this._function;
        
    }
    
    Booking_Package_Member.prototype.setTop = function(top) {
        
        this._top = top;
        
    }
    
    Booking_Package_Member.prototype.setSubscription = function(subscriptions){
        
        this._subscriptions = subscriptions;
        
    }
    
    Booking_Package_Member.prototype.memberOperation = function(top){
        
        var object = this;
        object._top = top;
        var calendarAccount = object._calendarAccount;
        var memberSetting = object._setting;
        var subscriptions = object._subscriptions;
        object._console.log(memberSetting);
        object._console.log(calendarAccount);
        object._console.log(subscriptions);
        object.hiddenLoginErrorMessage();
        
        if(parseInt(memberSetting.function_for_member) == 1){
            
            var user_status_field = document.getElementById("booking-package-user_status_field");
            user_status_field.textContent = null;
            user_status_field.classList.add("hidden_panel");
            
            var login = document.getElementById("booking-package-login");
            var logout = document.getElementById("booking-package-logout");
            var register = document.getElementById("booking-package-register");
            var edit = document.getElementById("booking-package-edit");
            var bookingHistory = document.getElementById("booking-package-bookedHistory");
            var delete_button = document.getElementById("booking-package-edit_user_delete_button");
            var subscribed = document.getElementById("booking-package-subscribed");
            
            var login_form = document.getElementById("booking-package-loginform");
            var user_form = document.getElementById("booking-package-user-form");
            var subscription_form = document.getElementById("booking-package-subscription_form");
            var subscribed_panel = document.getElementById("booking-package-subscribed_panel");
            var booking_calendar = document.getElementById("booking-package");
            var myBookingHistory = document.getElementById("booking-package_myBookingHistory");
            var myBookingDetails = document.getElementById("booking-package_myBookingDetails");
            
            var login_submit = login_form.getElementsByClassName("login-submit")[0];
            var login_input = login_submit.getElementsByTagName("input");
            var login_button = null;
            object._console.log(login_submit);
            for(var i = 0; i < login_input.length; i++){
                
                var input = login_input[i];
                if(input.type == "submit"){
                    
                    login_button = input;
                    input.value = object._i18n.get("Sign in");
                    object._console.log(input);
                    object._console.log(object._booking_package_dictionary);
                    break;
                    
                }
                
            }
            
            var pluginName = document.getElementById(this._prefix + "pluginName");
            if(pluginName == null){
                
                pluginName = document.createElement("input");
                pluginName.id = this._prefix + "pluginName";
                pluginName.type = "hidden";
                pluginName.name = "pluginName";
                pluginName.value = "booking-package";
                login_form.appendChild(pluginName);
                
            }
            
            if(parseInt(subscriptions.subscribed) == 1){
                
                subscription_form = null;
                //subscribed_panel = null;
                
            }
            
            if(subscriptions.status == 0){
                
                subscribed.classList.add("hidden_panel");
                subscribed = document.createElement("div");
                
            }
            
            var login_error_panel = document.createElement('p');
            login_error_panel.setAttribute('class', 'login_error hidden_panel');
            login_form.insertAdjacentElement('afterbegin', login_error_panel);
            
            var login_close_button = document.createElement('div');
            login_close_button.setAttribute('class', 'material-icons closeButton');
            login_close_button.textContent = 'close';
            login_form.insertAdjacentElement('afterbegin', login_close_button);
            
            login_form.onsubmit = function() {
                
                object._console.log(this);
                var user_login = document.getElementById('user_login').value;
                var user_password = document.getElementById('user_pass').value;
                var remember = 0;
                if (document.getElementById('rememberme').checked == 1) {
                    
                    remember = 1;
                    
                }
                
                
                if (user_login.length == 0 || user_password.length == 0) {
                    
                    return false;
                    
                }
                    
                var post = {mode: 'user_login_for_frontend', nonce: object._nonce, action: object._action, user_login: user_login, user_password: user_password, remember: remember};
                var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                bookingBlockPanel.classList.remove("hidden_panel");
                new Booking_App_XMLHttp(object._url, post, false, function(response) {
                    
                    if (response.status == 'success') {
                        
                        window.location.href = object._reservation_info.permalink;
                        
                    } else {
                        
                        login_error_panel.classList.remove('hidden_panel');
                        login_error_panel.textContent = null;
                        login_error_panel.insertAdjacentHTML('afterbegin', response.message);
                        var links = login_error_panel.getElementsByTagName('a');
                        if (links.length > 0) {
                            
                            for (var i = 0; i < links.length; i++) {
                                
                                var link = links[i];
                                object._console.log(link);
                                if (link.search.length == 0) {
                                    
                                    link.search += '?plugin=booking-package';
                                    
                                } else {
                                    
                                    link.search += '&plugin=booking-package';
                                    
                                }
                                
                                object._console.log(link.search);
                                
                            }
                            
                            
                        }
                        
                    }
                    
                    bookingBlockPanel.classList.add("hidden_panel");
                    
                });
                
                return false;
                
                
            };
            
            login_close_button.onclick = function() {
                
                login_form.classList.add('hidden_panel');
                login_form.classList.remove("loginform");
                login.classList.remove('hidden_panel');
                booking_calendar.classList.remove("hidden_panel");
                
            }
            
            var register_user_return_button = document.getElementById("booking-package-register_user_return_button");
            register_user_return_button.classList.remove("hidden_panel");
            register_user_return_button.onclick = function(){
                
                user_form.classList.add("hidden_panel");
                register.classList.remove("hidden_panel");
                if(parseInt(memberSetting.visitors_registration_for_member) == 1){
                    
                    login.classList.remove("hidden_panel");
                    login_form.classList.remove("loginform");
                    booking_calendar.classList.remove("hidden_panel");
                    if(parseInt(memberSetting.reject_non_membder) == 1){
                        
                        login.classList.add("hidden_panel");
                        login_form.classList.add("loginform");
                        
                    }
                    
                }else{
                    
                    login.classList.remove("hidden_panel");
                    booking_calendar.classList.remove("hidden_panel");
                    
                }
                
            };
            
            var edit_user_return_button = document.getElementById("booking-package-edit_user_return_button");
            edit_user_return_button.classList.remove("hidden_panel");
            edit_user_return_button.onclick = function(){
                
                if (subscription_form != null) {
                    
                    
                    if(parseInt(subscriptions.subscribed) == 1){
                        
                        subscription_form.classList.add("hidden_panel");
                        booking_calendar.classList.remove("hidden_panel");
                        
                    }else{
                        
                        
                        subscription_form.classList.remove("hidden_panel");
                        
                    }
                    
                }
                
                var edit_form = document.getElementById("booking-package-user-edit-form");
                booking_calendar.classList.remove("hidden_panel");
                bookingHistory.classList.remove("hidden_panel");
                edit.classList.remove("hidden_panel");
                subscribed.classList.remove("hidden_panel");
                edit_form.classList.add("hidden_panel");
                
            };
            
            var bookingHistory_close_button = document.getElementById("booking-package-bookingHistory_close_button")
            bookingHistory_close_button.classList.remove("hidden_panel");
            bookingHistory_close_button.onclick = function() {
                
                var myBookingHistory = document.getElementById("booking-package_myBookingHistory");
                myBookingHistory.classList.add("hidden_panel");
                bookingHistory.classList.remove("hidden_panel");
                booking_calendar.classList.remove("hidden_panel");
                
            };
            
            if(memberSetting.login == 1){
                
                login.classList.add("hidden_panel");
                logout.classList.remove("hidden_panel");
                register.classList.add("hidden_panel");
                edit.classList.remove("hidden_panel");
                subscribed.classList.remove("hidden_panel");
                bookingHistory.classList.remove("hidden_panel");
                
                var user_login = document.getElementById("booking-package-user_login");
                user_login.textContent = memberSetting.user_login;
                object._userInformation = memberSetting.value;
                
            }else{
                
                login.classList.remove("hidden_panel");
                logout.classList.add("hidden_panel");
                edit.classList.add("hidden_panel");
                subscribed.classList.add("hidden_panel");
                bookingHistory.classList.add("hidden_panel");
                
                if(parseInt(memberSetting.visitors_registration_for_member) == 1){
                    
                    register.classList.remove("hidden_panel");
                    
                }else{
                    
                    register.classList.add("hidden_panel");
                    
                }
                
                if(parseInt(memberSetting.reject_non_membder) == 1){
                    
                    user_form.classList.add("hidden_panel");
                    booking_calendar.classList.add("hidden_panel");
                    booking_calendar.textContent = null;
                    login_form.classList.add("loginform");
                    login.classList.add("hidden_panel");
                    
                }else{
                    
                    /**
                    var login_submit = login_form.getElementsByClassName("login-submit");
                    object._console.log(login_submit);
                    if(login_submit.length > 0){
                        
                        login_submit = login_submit[0];
                        var login_return_button = document.createElement("button");
                        login_return_button.textContent = object._i18n.get("Retrun");
                        login_return_button.setAttribute("class", "button button-primary");
                        login_submit.appendChild(login_return_button);
                        object._console.log(login_submit);
                        login_return_button.onclick = function(){
                            
                            login_form.classList.remove("loginform");
                            login.classList.remove("hidden_panel");
                            booking_calendar.classList.remove("hidden_panel");
                            
                        }
                        
                    }
                    **/
                    
                }
                
            }
            
            if(memberSetting.activation != null && memberSetting.activation.status == "success"){
                
                login_form.classList.remove("hidden_panel");
                login_form.classList.add("loginform");
                booking_calendar.classList.add("hidden_panel");
                register.classList.add("hidden_panel");
                login.classList.add("hidden_panel");
                document.getElementById("user_login").textContent = memberSetting.activation.user_login;
                
            }
            
            var memberActionPanel = document.getElementById("booking-package-memberActionPanel");
            memberActionPanel.classList.remove("hidden_panel");
            
            login.onclick = function(){
                
                object._console.log(this);
                user_form.classList.add("hidden_panel");
                booking_calendar.classList.add("hidden_panel");
                login_form.classList.add("loginform");
                login.classList.add("hidden_panel");
                
                if(parseInt(memberSetting.visitors_registration_for_member) == 1){
                    
                    register.classList.remove("hidden_panel");
                    
                }else{
                    
                    register.classList.add("hidden_panel");
                    
                }
                
            }
            
            register.onclick = function(){
                
                object._console.log(this);
                user_form.classList.remove("hidden_panel");
                booking_calendar.classList.add("hidden_panel");
                login_form.classList.remove("loginform");
                login.classList.remove("hidden_panel");
                register.classList.add("hidden_panel");
                
            }
            
            if(memberSetting.login == 1){
                
                logout.onclick = function(){
                    
                    object.logout(login, logout, register, function(response){
                        
                    });
                    
                }
                
                bookingHistory.onclick = function(){
                    
                    edit.classList.remove("hidden_panel");
                    var edit_form = document.getElementById("booking-package-user-edit-form");
                    edit_form.classList.add("hidden_panel");
                    object.bookingHistory_form(0, function(response) {
                        
                        
                        
                    });
                    
                };
                
                edit.onclick = function() {
                    
                    var edit_form = document.getElementById("booking-package-user-edit-form");
                    var edit_user_button = document.getElementById("booking-package-edit_user_button");
                    
                    if (subscription_form != null) {
                        
                        subscription_form.classList.add("hidden_panel");
                        
                    }
                    
                    object._console.log(subscribed_panel);
                    if (subscribed_panel != null) {
                        
                        subscribed_panel.classList.add("hidden_panel");
                        
                    }
                    
                    booking_calendar.classList.add("hidden_panel");
                    subscribed.classList.add("hidden_panel");
                    edit.classList.add("hidden_panel");
                    bookingHistory.classList.remove("hidden_panel");
                    myBookingHistory.classList.add("hidden_panel");
                    myBookingDetails.classList.add("hidden_panel");
                    
                    edit_form.classList.remove("hidden_panel");
                    
                    object.edit_form(memberActionPanel, edit_user_button, null, function(response) {
                            
                        object._console.log(response);
                            
                    });
                    
                };
                
                delete_button.onclick = function() {
                    
                    object.delete_member();
                    
                };
                
                subscribed.onclick = function() {
                    
                    
                    booking_calendar.classList.add("hidden_panel");
                    object.subscribed_form(booking_calendar, function(response) {
                        
                        
                        
                    });
                    
                };
                
            }
            
            var register_user_button = document.getElementById("booking-package-register_user_button");
            object.register_form(memberActionPanel, register_user_button, null, function(response){
                    
                object._console.log(response);
                
                    
            });
            
        }
        
    }
    
    Booking_Package_Member.prototype.bookingHistory_form = function(offset, callback){
        
        var object = this;
        var setting = object._setting;
        object._console.log(setting);
        object._console.log(object._top);
        var booking_calendar = document.getElementById("booking-package");
        var myBookingHistory = document.getElementById("booking-package_myBookingHistory");
        var table = document.getElementById("booking-package_myBookingHistoryTable");
        
        var beforButton = document.getElementById("booking-package-bookingHistory_returnButton");
        beforButton.removeEventListener("click", null);
        
        var nextButton = document.getElementById("booking-package-bookingHistory_nextButton");
        nextButton.removeEventListener("click", null);
        
        
        
        var post = {mode: 'getUsersBookedList', nonce: object._nonce, action: object._action, offset: offset, user_id: setting.current_member_id};
        var bookingBlockPanel = document.getElementById("bookingBlockPanel");
        bookingBlockPanel.classList.remove("hidden_panel");
        new Booking_App_XMLHttp(object._url, post, false, function(response) {
            
            object._console.log(response);
            var responseOffset = 0;
            var responseLimit = 0;
            var nextClick = 0;
            //table.textContent = null;
            var ths = table.getElementsByTagName("th");
            for (var i = 0; i < ths.length; i++) {
                
                ths[i].setAttribute("style", "top: " + object._top + "px;");
                
            }
            
            var trs = table.getElementsByTagName("tr");
            for (var i = trs.length; i > 0; i--) {
                
                if (i > 1) {
                    object._console.log(trs[i - 1]);
                    table.removeChild(trs[i - 1]);
                    
                }
                
            }
            
            
            document.getElementById("booking-package-bookedHistory").classList.add("hidden_panel");
            bookingBlockPanel.classList.add("hidden_panel");
            booking_calendar.classList.add("hidden_panel");
            myBookingHistory.classList.remove("hidden_panel");
            
            if (response.status == 'success') {
                
                var bookedList = response.bookedList;
                responseOffset = parseInt(response.offset);
                responseLimit = parseInt(response.limit);
                nextClick = parseInt(response.next);
                
                for(var i = 0; i < bookedList.length; i++) {
                
                    var userInfo = bookedList[i];
                    object._console.log(userInfo);
                    
                    var tr = document.createElement("tr");
                    tr.setAttribute("valign", "top");
                    tr.setAttribute("data-key", i);
                    table.appendChild(tr);
                    
                    var th = document.createElement("td");
                    th.setAttribute("scope", "row");
                    th.textContent = userInfo.key;
                    tr.appendChild(th);
                    
                    var dateTd = document.createElement("td");
                    dateTd.setAttribute("scope", "row");
                    dateTd.textContent = object._calendar.formatBookingDate(userInfo.date.month, userInfo.date.day, userInfo.date.year, userInfo.date.hour, userInfo.date.min, userInfo.scheduleTitle, userInfo.date.week);
                    tr.appendChild(dateTd);
                    
                    var accountTd = document.createElement("td");
                    accountTd.setAttribute("scope", "row");
                    accountTd.textContent = userInfo.accountKey;
                    tr.appendChild(accountTd);
                    
                    if (object._calendarAccountList[parseInt(userInfo.accountKey)] != null) {
                        
                        if (object._calendarAccountList[parseInt(userInfo.accountKey)].type == 'hotel') {
                            
                            dateTd.textContent = object._calendar.formatBookingDate(userInfo.date.month, userInfo.date.day, userInfo.date.year, null, null, null, userInfo.date.week);
                            
                        } else {
                            
                            dateTd.textContent = object._calendar.formatBookingDate(userInfo.date.month, userInfo.date.day, userInfo.date.year, userInfo.date.hour, userInfo.date.min, userInfo.scheduleTitle, userInfo.date.week);
                            
                        }
                        
                        accountTd.textContent = object._calendarAccountList[parseInt(userInfo.accountKey)].name;
                        
                    }
                    
                    var status = document.createElement("div");
                    status.id = "booking-status-" + i;
                    status.setAttribute("data-status", i);
                    status.textContent = object._i18n.get(userInfo.status.toLowerCase());
                    var statusClassName = "pendingLabel";
                    if (userInfo.status.toLowerCase() == "approved") {
                        
                        statusClassName = "approvedLabel";
                        
                    } else if (userInfo.status.toLowerCase() == "canceled") {
                        
                        statusClassName = "canceledLabel";
                        
                    }
                    status.classList.add(statusClassName);
                    
                    var td = document.createElement("td");
                    td.classList.add("statusTd");
                    td.setAttribute("scope", "row");
                    td.appendChild(status);
                    tr.appendChild(td);
                    
                    tr.onclick = function(){
                        
                        var tr = this;
                        var key = parseInt(this.getAttribute("data-key"));
                        var status = document.getElementById("booking-status-" + key);
                        object._console.log(key);
                        object._console.log(bookedList[key]);
                        object.bookingDetails(key, bookedList[key], function(response) {
                            
                            object._console.log(response);
                            object._console.log(object._top);
                            var rect = document.getElementById("booking-package-memberActionPanel").getBoundingClientRect();
                            object._console.log(rect);
                            document.getElementById("booking-package-memberActionPanel").scrollIntoView();
                            if (typeof window.scrollBy == 'function') {
                                
                                window.scrollBy(0, object._top);
                                
                            }
                            
                            bookedList[key].status = 'canceled';
                            status.textContent = object._i18n.get('canceled');
                            status.classList.add("canceledLabel");
                            
                            //table.removeChild(tr);
                            
                        });
                        /**
                        object.setSelectedKey(key);
                        object.showUserInfo(key, bookedList[key], true, bookedList[key].accountKey, function(response){
                            
                            object._console.log(response);
                            if(response.status == "returnButton"){
                                
                                object.reservation_users(reservation_usersPanel, response.month, response.day, response.year, calendarData, accountKey, callback);
                                
                            }
                            
                        });
                        **/
                        
                    };
                    
                }
                
            } else {
                
                window.location.reload(true);
                
            }
            
            
            
            beforButton.onclick = function() {
                
                offset = responseOffset - responseLimit;
                if (offset <= 0) {
                    
                    offset = 0;
                    
                }
                object._console.log("offset = " + offset);
                object.bookingHistory_form(offset, callback);
                
            };
            
            nextButton.onclick = function() {
                
                if (nextClick == 0) {
                    
                    return null;
                    
                }
                offset = responseOffset + responseLimit;
                object._console.log("offset = " + offset);
                object.bookingHistory_form(offset, callback);
                
            };
            
        });
        
    }
    
    Booking_Package_Member.prototype.bookingDetails = function(key, reservationData, callback) {
        
        var object = this;
        var setting = object._setting;
        object._console.log(reservationData);
        object._console.log(object._calendarAccountList);
        
        var myBookingHistory = document.getElementById("booking-package_myBookingHistory");
        var myBookingDetails = document.getElementById("booking-package_myBookingDetails");
        var infoPanel = document.getElementById("booking-package_myBookingDetails_panel");
        var closeButton = document.getElementById("booking-package-myBookingDetails_close_button");
        var cancelButton = document.getElementById("booking-package-cancelThisBooking");
        
        cancelButton.removeEventListener("click", null);
        var rect = myBookingHistory.getBoundingClientRect();
        object._console.log(rect);
        myBookingHistory.classList.add("hidden_panel");
        myBookingDetails.classList.remove("hidden_panel");
        infoPanel.textContent = null;
        
        var calendarAccount = object._calendarAccountList[parseInt(reservationData.accountKey)];
        object._console.log(calendarAccount);
        
        var bookingTimeChange = document.createElement("div");
        bookingTimeChange.setAttribute("data-status", "1");
        bookingTimeChange.setAttribute("class", "change hidden_panel");
        bookingTimeChange.textContent = object._i18n.get("Change");
        
        var courseChange = document.createElement("div");
        courseChange.setAttribute("data-status", "1");
        courseChange.setAttribute("class", "change hidden_panel");
        courseChange.textContent = object._i18n.get("Change");
        
        var response = object._booking_manage.showUserDetails(key, {account: calendarAccount, schedule: {}}, reservationData, calendarAccount.key, false, infoPanel, bookingTimeChange, courseChange, function(callback){
            
            object._console.log(callback);
            
        });
        
        if (parseInt(reservationData.cancel) == 1) {
            
            cancelButton.disabled = false;
            cancelButton.classList.remove("hidden_panel");
            
            cancelButton.onclick = function() {
                
                object._console.log(reservationData);
                var post = {nonce: object._nonce, action: object._action, mode: 'cancelUserBooking', key: reservationData.key, accountKey: reservationData.accountKey, token: reservationData.cancellationToken, status: 'canceled', user_id: setting.current_member_id, sendEmail: 1};
                object._console.log(post);
                if (window.confirm(object._i18n.get("Can we really cancel your booking?"))) {
                    
                    var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                    bookingBlockPanel.classList.remove("hidden_panel");
                    new Booking_App_XMLHttp(object._url, post, false, function(response){
                        
                        object._console.log(response);
                        if (response.status != "error") {
                            
                            myBookingHistory.classList.remove("hidden_panel");
                            myBookingDetails.classList.add("hidden_panel");
                            
                            callback(true);
                            
                        } else {
                            
                            if (response.reload != null && parseInt(response.reload) == 1) {
                                
                                window.location.reload(true);
                                
                            } else {
                                
                                
                                
                            }
                            
                        }
                        bookingBlockPanel.classList.add("hidden_panel");
                        
                    });
                    
                    
                }
                
            };
            
        } else {
            
            cancelButton.disabled = true;
            cancelButton.classList.add("hidden_panel");
            
        }
        
        closeButton.removeEventListener("click", null, false);
        closeButton.onclick = function() {
            
            myBookingHistory.classList.remove("hidden_panel");
            myBookingDetails.classList.add("hidden_panel");
            
        };
        
        var returnButton = document.getElementById("booking-package-myBookingDetails_returnButton");
        returnButton.classList.add("hidden_panel");
        returnButton.removeEventListener("click", null);
        returnButton.onclick = function() {
            
            myBookingHistory.classList.remove("hidden_panel");
            myBookingDetails.classList.add("hidden_panel");
            
        };
        
    }
    
    Booking_Package_Member.prototype.subscribed_form = function(booking_calendar, callback){
        
        var object = this;
        var memberSetting = object._setting;
        var subscriptions = object._subscriptions;
        object._console.log(memberSetting);
        object._console.log(subscriptions);
        var subscription_form = document.getElementById("booking-package-subscription_form");
        var subscribed_panel = document.getElementById("booking-package-subscribed_panel");
        var return_button = document.getElementById("booking-package-subscribed_return_button");
        var edit = document.getElementById("booking-package-edit");
        var subscribed = document.getElementById("booking-package-subscribed");
        edit.classList.add("hidden_panel");
        subscribed.classList.add("hidden_panel");
        subscribed_panel.classList.remove("hidden_panel");
        subscription_form.classList.add("hidden_panel");
        
        var cost = new FORMAT_COST(object._i18n, object._debug);
        var tbody = document.getElementById("booking-package-subscribed_items");
        tbody.textContent = null;
        var subscription_list = memberSetting.subscription_list;
        for(var key in subscription_list){
            
            var product = subscription_list[key];
            var items = product.items;
            var currency = null;
            var amount = 0;
            object._console.log(product);
            for(var i = 0; i < items.length; i++){
                
                var item = items[i];
                currency = item.currency;
                amount += parseInt(item.amount);
                object._console.log(item);
                
            }
            
            amount = cost.formatCost(amount, currency);
            
            var amountPanel = document.createElement("div");
            amountPanel.textContent = object._i18n.get("%s per month", [amount]);
            
            var expirationDate = document.createElement("div");
            expirationDate.textContent = object._i18n.get("Expiration date: %s", [product.period_end_date]);
            
            //You can reserve 5 more times by the expiration date.
            //You can make a reservation 5 times by the expiration date.
            
            var itemPanel = document.createElement("div");
            itemPanel.textContent = product.name;
            
            var itemTd = document.createElement("td");
            itemTd.appendChild(itemPanel);
            itemTd.appendChild(amountPanel);
            itemTd.appendChild(expirationDate);
            
            var deleteTd = document.createElement("td");
            deleteTd.setAttribute("data-key", key);
            deleteTd.setAttribute("style", "font-family: 'Material Icons' !important;");
            deleteTd.setAttribute("class", "material-icons delete_icon");
            deleteTd.textContent = "delete";
            
            var tr = document.createElement("tr");
            tr.id = object._prefix + key;
            tr.appendChild(itemTd);
            tr.appendChild(deleteTd);
            if(product.canceled != null && parseInt(product.canceled) == 1){
                
                tr.classList.add("canceled");
                deleteTd.setAttribute("style", "cursor: not-allowed; font-family: 'Material Icons' !important;");
                
            }
            
            
            tbody.appendChild(tr);
            
            deleteTd.onclick = function(){
                
                var deleteTd = this;
                var key = this.getAttribute("data-key");
                var product = subscription_list[key];
                object._console.log(product);
                if(product.canceled != null && parseInt(product.canceled) == 1){
                    
                    return null;
                    
                }
                
                if(window.confirm(object._i18n.get('If you cancel the "%s" subscription, you can not make a reservation after the deadline of %s. Do you really want to cancel the subscription?', [product.name, product.period_end_date]))){
                    
                    object.deleteSubscription(product, function(response){
                        
                        var tr = document.getElementById(object._prefix + key);
                        if(response.status == 1){
                            
                            subscription_list[key]['canceled'] = 1;
                            tr.classList.add("canceled");
                            deleteTd.setAttribute("style", "cursor: not-allowed; font-family: 'Material Icons' !important;");
                            
                        }else{
                            
                            tbody.removeChild(tr);
                            
                        }
                        
                    });
                    
                }
                
            }
            
        }
        
        
        return_button.onclick = function(){
            
            edit.classList.remove("hidden_panel");
            subscribed.classList.remove("hidden_panel");
            subscribed_panel.classList.add("hidden_panel");
            
            if(parseInt(subscriptions.subscribed) == 1){
                
                booking_calendar.classList.remove("hidden_panel");
                
            }else{
                
                subscription_form.classList.remove("hidden_panel");
                
                
            }
            
        }
        
    }
    
    Booking_Package_Member.prototype.deleteSubscription = function(product, callback){
        
        var object = this;
        var post = {mode: 'deleteSubscription', nonce: object._nonce, action: object._action, product: product.product};
        var bookingBlockPanel = document.getElementById("bookingBlockPanel");
        bookingBlockPanel.classList.remove("hidden_panel");
        new Booking_App_XMLHttp(object._url, post, false, function(response){
            
            object._console.log(response);
            if(parseInt(response.status) == 1){
                
                callback({stats: 1, error: null});
                
            }else{
                
                if(response.reload != null && parseInt(response.reload) == 1){
                    
                    window.location.reload();
                    
                }else{
                    
                    callback({stats: 0, error: response.error});
                    
                }
                
            }
            
            bookingBlockPanel.classList.add("hidden_panel");
            
        });
        
    }
    
    Booking_Package_Member.prototype.delete_member = function(){
        
        var object = this;
        object._console.log("delete_member");
        if(window.confirm(object._i18n.get("Do you really want to delete the license as a member?"))){
            
            var post = {mode: 'deleteUser', nonce: object._nonce, action: object._action};
            var bookingBlockPanel = document.getElementById("bookingBlockPanel");
            bookingBlockPanel.classList.remove("hidden_panel");
            new Booking_App_XMLHttp(object._url, post, false, function(response){
                
                object._console.log(response);
                if(response.status == "success"){
                    
                    window.location.reload();
                    
                }
                
                bookingBlockPanel.classList.add("hidden_panel");
                
            });
            
        }
        
    }
    
    Booking_Package_Member.prototype.edit_form = function(mainPanel, register_user_button, return_button, callback){
        
        var object = this;
        object._console.log(object._setting);
        var setting = object._setting;
        var edit_panel = document.getElementById("booking-package-user-edit-form");
        var user_login = document.getElementById("booking-package-user_edit_login");
        var user_email = document.getElementById("booking-package-user_edit_email");
        var user_pass = document.getElementById("booking-package-user_edit_pass");
        user_login.textContent = setting.user_login;
        
        var change_password_button = document.getElementById("booking-package-user_edit_change_password_button");
        change_password_button.onclick = function(){
            
            user_pass.classList.remove("hidden_panel");
            change_password_button.classList.add("hidden_panel");
            
        }
        
        register_user_button.onclick = function(){
            
            var updata = true;
            user_email.parentElement.classList.remove("errorPanel");
            user_pass.parentElement.classList.remove("errorPanel");
            if(!user_email.value.match(/.+@.+\..+/)){
                
                updata = false;
                user_email.parentElement.classList.add("errorPanel");
                
            }
            
            if(user_pass.value.length > 0 && user_pass.value.length < 8){
                
                updata = false;
                user_pass.parentElement.classList.add("errorPanel");
                
            }
            
            var post = {mode: 'updateUser', nonce: object._nonce, action: object._action, user_login: setting.user_login, accountKey: object._calendarAccount.key};
            if(document.getElementById("booking-package-permalink") != null){
                
                post.permalink = document.getElementById("booking-package-permalink").value;
                
            }
            
            object._console.log("updata = " + updata);
            if(updata == true){
                
                post.user_email = user_email.value;
                if(user_pass.value.length != 0){
                    
                    post.user_pass = user_pass.value;
                    
                }
                object._console.log(post);
                var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                bookingBlockPanel.classList.remove("hidden_panel");
                new Booking_App_XMLHttp(object._url, post, false, function(response){
                    
                    object._console.log(response);
                    if(response.status == 'success'){
                        
                        bookingBlockPanel.classList.add("hidden_panel");
                        window.location.reload();
                        
                    }
                    
                });
                
            }
            
        }
        
    }
    
    Booking_Package_Member.prototype.register_form = function(mainPanel, register_user_button, return_button, callback){
        
        var object = this;
        object._console.log("register_form");
        var user_regist_error_message = document.getElementById("booking-package-user_regist_error_message");
        user_regist_error_message.classList.add("hidden_panel");
        user_regist_error_message.textContent = null;
        
        register_user_button.onclick = function(){
            
            var user_data = {
                user_login: document.getElementById("booking-package-user_login"),
                user_email: document.getElementById("booking-package-user_email"),
                user_pass: document.getElementById("booking-package-user_pass"),
            };
            
            var registering = true;
            var post = {mode: 'createUser', nonce: object._nonce, action: object._action, accountKey: object._calendarAccount.key};
            for(var key in user_data){
                
                var panel = user_data[key].parentElement;
                panel.classList.remove("errorPanel");
                object._console.log(panel);
                
                var value = user_data[key].value;
                post[key] = value;
                object._console.log(key + " = " + value);
                
                if(key == 'user_login' && (value.length < 4 || !value.match(/^[A-Za-z0-9.-_]*$/))){
                    
                    registering = false;
                    panel.classList.add("errorPanel");
                    console.error("error key = " + key + " value = " + value);
                    
                }
                
                if(key == 'user_email' && !value.match(/.+@.+\..+/)){
                    
                    registering = false;
                    panel.classList.add("errorPanel");
                    console.error("error key = " + key + " value = " + value);
                    
                }
                
                if(key == 'user_pass' && value.length < 8){
                    
                    registering = false;
                    panel.classList.add("errorPanel");
                    console.error("error key = " + key + " value = " + value);
                    
                }
                
            }
            
            if (document.getElementById("booking-package-permalink") != null) {
                
                post.permalink = document.getElementById("booking-package-permalink").value;
                
            }
            
            if (registering == true) {
                
                object._console.log(post);
                user_regist_error_message.textContent.textContent = null;
                var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                bookingBlockPanel.classList.remove("hidden_panel");
                new Booking_App_XMLHttp(object._url, post, false, function(response){
                    
                    object._console.log(response);
                    bookingBlockPanel.classList.add("hidden_panel");
                    if (response.status == 'success') {
                        
                        window.location.reload();
                        
                    } else {
                        
                        user_regist_error_message.classList.remove("hidden_panel");
                        user_regist_error_message.textContent = response.error_messages;
                        //window.alert(response.error_messages);
                        
                    }
                    
                });
                
            }
            
        }
        
        if(return_button != null){
            
            return_button.onclick = function(){
                
                
                
            }
            
        }
        
        
    }
    
    Booking_Package_Member.prototype.logout = function(login, logout, register, callback){
        
        var object = this;
        var post = {mode: 'logout', nonce: object._nonce, action: object._action};
        object._console.log(post);
        var bookingBlockPanel = document.getElementById("bookingBlockPanel");
        bookingBlockPanel.classList.remove("hidden_panel");
        new Booking_App_XMLHttp(object._url, post, false, function(response){
            
            object._console.log(response);
            if(response.status == 'success'){
                
                window.location.reload();
                
            }
            
        });
        
    }
    
    Booking_Package_Member.prototype.hiddenLoginErrorMessage = function(){
        
        var object = this;
        var loginError = document.getElementById(object._prefix + "login_error");
        if (loginError != null) {
            
            var timer = setInterval(function(){
                
                loginError.classList.add("hiddenLoginErrorPanel");
                var timer1 = setInterval(function(){
                    
                    loginError.classList.add("hidden_panel");
                    clearInterval(timer1);
                    
                }, 1000);
                clearInterval(timer);
                
            }, 10000);
            
        }
        
    }
    
    Booking_Package_Member.prototype.isEmail = function(email){
        
        var mail_regex1 = new RegExp( '(?:[-!#-\'*+/-9=?A-Z^-~]+\.?(?:\.[-!#-\'*+/-9=?A-Z^-~]+)*|"(?:[!#-\[\]-~]|\\\\[\x09 -~])*")@[-!#-\'*+/-9=?A-Z^-~]+(?:\.[-!#-\'*+/-9=?A-Z^-~]+)*' );
        var mail_regex2 = new RegExp( '^[^\@]+\@[^\@]+$' );
        
        
    }
    
    Booking_Package_Member.prototype.setScrollY = function(element){
        
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