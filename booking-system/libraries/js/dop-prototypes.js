/*
* Title                   : DOP Prototypes (JavaScript class)
* Version                 : 1.0.3
* File                    : dop-prototypes.js
* File Version            : 1.0.3
* Created / Last Modified : 29 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2014 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : List of general functions that we use at Dot on Paper.
* Licence                 : MIT
*/

var DOPPrototypes = new function(){
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables
     */
        
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
// Actions           

    /*
     * Make all parents & current item visible.
     * 
     * @param item (element): item for which all parens are going to be made visible
     * 
     * @return list of parents
     */
    this.doHiddenBuster = function(item){
        var parent = item.parent(),
        items = new Array();

        if (item.prop('tagName') !== undefined 
                && item.prop('tagName').toLowerCase() !== 'body'){
            items = this.doHiddenBuster(parent);
        }

        if (item.css('display') === 'none'){
            item.css('display', 'block');
            items.push(item);
        }

        return items;
    };
    
    /*
     * Hide all items from list. The list is returned by function doHiddenBuster().
     * 
     * @param items (Array): list of items to be hidden
     */
    this.undoHiddenBuster = function(items){    
        var i;

        for (i=0; i<items.length; i++){
            items[i].css('display', 'none');
        }
    };
    
    /*
     * Open a link.
     * 
     * @param url (String): link URL
     * @param target (String): link target (_blank, _parent, _self, _top)
     */
    this.openLink = function(url,
                             target){
        switch (target.toLowerCase()){
            case '_blank':
                window.open(url);
                break;
            case '_parent':
                parent.location.href = url;
                break;
            case '_top':
                top.location.href = url;
                break;
            default:    
                window.location = url;
        }
    };
    
    /*
     * Randomize the items of an array.
     * 
     * @param theArray (Array): the array to be mixed
     * 
     * return array with mixed items
     */
    this.randomizeArray = function(theArray){
        theArray.sort(function(){
            return 0.5-Math.random();
        });
        return theArray;
    };

    /*
     * Scroll vertically to position.
     * 
     * @param position (Number): position to scroll to
     * @param speed (Number): scroll speed 
     */  
    this.scrollToY = function(position,
                              speed){
        speed = speed !== undefined ? speed: 300;
        
        $('html').stop(true, true)
                 .animate({'scrollTop': position}, 
                          speed);
        $('body').stop(true, true)
                 .animate({'scrollTop': position}, 
                          speed);
    };
    
    /*
     * One finger navigation for touchscreen devices.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     */
    this.touchNavigation = function(parent,
                                    child){
        var prevX, 
        prevY, 
        currX, 
        currY, 
        touch, 
        childX, 
        childY;

        parent.bind('touchstart', function(e){
            touch = e.originalEvent.touches[0];
            prevX = touch.clientX;
            prevY = touch.clientY;
        });

        parent.bind('touchmove', function(e){                                
            touch = e.originalEvent.touches[0];
            currX = touch.clientX;
            currY = touch.clientY;
            childX = currX>prevX ? parseInt(child.css('margin-left'))+(currX-prevX):parseInt(child.css('margin-left'))-(prevX-currX);
            childY = currY>prevY ? parseInt(child.css('margin-top'))+(currY-prevY):parseInt(child.css('margin-top'))-(prevY-currY);

            if (childX < (-1)*(child.width()-parent.width())){
                childX = (-1)*(child.width()-parent.width());
            }
            else if (childX > 0){
                childX = 0;
            }
            else{                                    
                e.preventDefault();
            }

            if (childY < (-1)*(child.height()-parent.height())){
                childY = (-1)*(child.height()-parent.height());
            }
            else if (childY > 0){
                childY = 0;
            }
            else{                                    
                e.preventDefault();
            }

            prevX = currX;
            prevY = currY;

            if (parent.width() < child.width()){
                child.css('margin-left', childX);
            }

            if (parent.height() < child.height()){
                child.css('margin-top', childY);
            }
        });

        parent.bind('touchstart', function(e){
            if (!this.isChromeMobileBrowser()){
                e.preventDefault();
            }
        });
    };

// Browsers & devices

    /*
     * Check if operating system is Android.
     * 
     * @return true/false
     */
    this.isAndroid = function(){
        var isAndroid = false,
        agent = navigator.userAgent.toLowerCase();

        if (agent.indexOf('android') !== -1){
            isAndroid = true;
        }
        return isAndroid;
    };
    
    /*
     * Check if browser is Chrome on mobile..
     * 
     * @return true/false
     */
    this.isChromeMobileBrowser = function(){
        var isChromeMobile = false,
        agent = navigator.userAgent.toLowerCase();

        if ((agent.indexOf('chrome') !== -1 
                        || agent.indexOf('crios') !== -1) 
                && this.isTouchDevice()){
            isChromeMobile = true;
        }
        return isChromeMobile;
    };
    
    /*
     * Check if browser is IE8.
     * 
     * @return true/false
     */
    this.isIE8Browser = function(){
        var isIE8 = false,
        agent = navigator.userAgent.toLowerCase();

        if (agent.indexOf('msie 8') !== -1){
            isIE8 = true;
        }
        return isIE8;
    };
    
    /*
     * Check if browser is IE..
     * 
     * @return true/false
     */
    this.isIEBrowser = function(){
        var isIE = false,
        agent = navigator.userAgent.toLowerCase();

        if (agent.indexOf('msie') !== -1){
            isIE = true;
        }
        return isIE;
    };
    
    /*
     * Detect touchscreen devices.
     * 
     * @return true/false
     */
    this.isTouchDevice = function(){
        var os = navigator.platform;

        if (os.toLowerCase().indexOf('win') !== -1){
            return window.navigator.msMaxTouchPoints;
        }
        else {
            return 'ontouchstart' in document;
        }
    },

// Cookies
    
    /*
     * Delete cookie.
     * 
     * @param name (String): cookie name
     * @param path (String): cookie path
     * @param domain (String): cookie domain
     */
    this.deleteCookie = function(name,
                                 path,
                                 domain){
        if (this.getCookie(name)){
            document.cookie = name+'='+((path) ? ';path='+path:'')+((domain) ? ';domain='+domain:'')+';expires=Thu, 01-Jan-1970 00:00:01 GMT';
        }
    };
    
    /*
     * Get cookie.
     * 
     * @param name (String): cookie name
     */  
    this.getCookie = function(name){  
        var namePiece = name+"=",
        cookie = document.cookie.split(";"),
        i;

        for (i=0; i<cookie.length; i++){
            var cookiePiece = cookie[i];

            while (cookiePiece.charAt(0) === ' '){
                cookiePiece = cookiePiece.substring(1,cookiePiece .length);            
            } 

            if (cookiePiece.indexOf(namePiece) === 0){
                return unescape(cookiePiece.substring(namePiece.length, cookiePiece.length));
            } 
        }
        return null;
    };
    
    /*
     * Set cookie.
     * 
     * @param name (String): cookie name
     * @param value (String): cookie value
     * @param expire (String): the number of days after which the cookie will expire
     */
    this.setCookie = function(name,
                              value,
                              expire){
        var expirationDate = new Date();

        expirationDate.setDate(expirationDate.getDate()+expire);
        document.cookie = name+'='+escape(value)+((expire === null) ? '': ';expires='+expirationDate.toUTCString())+';javahere=yes;path=/';
    };

// Date & time
    
    /*
     * Converts time to AM/PM format.
     *
     * @param time (String): the time that will be converted (HH:MM)
     *
     * @return time to AM/PM format
     */
    this.getAMPM = function(time){
        var hour = parseInt(time.split(':')[0], 10),
        minutes = time.split(':')[1],
        result = '';

        if (hour === 0){
            result = '12';
        }
        else if (hour > 12){
            result = this.getLeadingZero(hour-12);
        }
        else{
            result = this.getLeadingZero(hour);
        }

        result += ':'+minutes+' '+(hour < 12 ? 'AM':'PM');

        return result;
    };
    
    /*
     * Returns difference between 2 dates.
     * 
     * @param date1 (Date): first date (JavaScript date)
     * @param date2 (Date): second date (JavaScript date)
     * @param type (String): diference type
     *                       "seconds"
     *                       "minutes"
     *                       "hours"
     *                       "days"
     * @param valueType (String): type of number returned
     *                            "float"
     *                            "integer"
     * @param noDecimals (Number): number of decimals returned with the float value (-1 to display all decimals)
     * 
     * @return dates diference
     */
    this.getDatesDifference = function(date1,
                                       date2,
                                       type,
                                       valueType,
                                       noDecimals){
        var y1 = date1.split('-')[0],
        m1 = date1.split('-')[1],
        d1 = date1.split('-')[2],
        y2 = date2.split('-')[0],
        m2 = date2.split('-')[1],
        d2 = date2.split('-')[2],
        time1 = (new Date(y1, m1-1, d1)).getTime(),
        time2 = (new Date(y2, m2-1, d2)).getTime(),
        diff = Math.abs(time1-time2);

        if (type === undefined){
            type = 'seconds';
        }

        if (valueType === undefined){
            valueType = 'float';
        }

        if (noDecimals === undefined){
            noDecimals = -1;
        }

        switch (type){
            case 'days':
                diff = diff/(1000*60*60*24);
                break;
            case 'hours':
                diff = diff/(1000*60*60);
                break;
            case 'minutes':
                diff = diff/(1000*60);
                break;
            default:
                diff = diff/(1000);
        }

        if (valueType === 'float'){
            return noDecimals === -1 ? diff:DOPPrototypes.getWithDecimals(diff, noDecimals);
        }
        else{
            return Math.ceil(diff);
        }
    };
    
    /*
     * Returns difference between 2 hours.
     * 
     * @param hour1 (Date): first hour (HH:MM, HH:MM:SS)
     * @param hour2 (Date): second hour (HH:MM, HH:MM:SS)
     * @param type (String): diference type
     *                       "seconds"
     *                       "minutes"
     *                       "hours"
     * @param valueType (String): type of number returned
     *                            "float"
     *                            "integer"
     * @param noDecimals (Number): number of decimals returned with the float value (-1 to display all decimals)
     * 
     * @return hours difference
     */
    this.getHoursDifference = function(hour1,
                                       hour2,
                                       type,
                                       valueType,
                                       noDecimals){
        var hours1 = parseInt(hour1.split(':')[0], 10),
        minutes1 = parseInt(hour1.split(':')[1], 10),
        seconds1 = hour1.split(':')[2] !== undefined ? parseInt(hour1.split(':')[2], 10):0,
        hours2 = parseInt(hour2.split(':')[0], 10),
        minutes2 = parseInt(hour2.split(':')[1], 10),
        seconds2 = hour2.split(':')[2] !== undefined ? parseInt(hour2.split(':')[2], 10):0,
        time1,
        time2,
        diff;

        if (type === undefined){
            type = 'seconds';
        }

        if (valueType === undefined){
            valueType = 'float';
        }

        if (noDecimals === undefined){
            noDecimals = -1;
        }

        switch (type){
            case 'hours':
                time1 = hours1+minutes1/60+seconds1/60/60;
                time2 = hours2+minutes2/60+seconds2/60/60;
                break;
            case 'minutes':
                time1 = hours1*60+minutes1+seconds1/60;
                time2 = hours2*60+minutes2+seconds2/60;
                break;
            default:
                time1 = hours1*60*60+minutes1*60+seconds1;
                time2 = hours2*60*60+minutes2*60+seconds2;
        }

        diff = Math.abs(time1-time2);

        if (valueType === 'float'){
            return noDecimals === -1 ? diff:DOPPrototypes.getWithDecimals(diff, noDecimals);
        }
        else{
            return Math.ceil(diff);
        }
    };
    
    /*
     * Returns next day.
     * 
     * @param date (Date): current date (YYYY-MM-DD)
     * 
     * @return next day (YYYY-MM-DD)
     */
    this.getNextDay = function(date){
        var nextDay = new Date(),
        parts = date.split('-');

        nextDay.setFullYear(parts[0], parts[1], parts[2]);
        nextDay.setTime(nextDay.getTime()+86400000);

        return nextDay.getFullYear()+'-'+DOPPrototypes.getLeadingZero(nextDay.getMonth())+'-'+DOPPrototypes.getLeadingZero(nextDay.getDate());
    };
    
    /*
     * Returns number of days between 2 dates.
     * 
     * @param date1 (Date): first date (YYYY-MM-DD)
     * @param date2 (Date): second date (YYYY-MM-DD)
     * 
     * @return number of days
     */
    this.getNoDays = function(date1,
                              date2){
        var y1 = date1.split('-')[0],
        m1 = date1.split('-')[1],
        d1 = date1.split('-')[2],
        y2 = date2.split('-')[0],
        m2 = date2.split('-')[1],
        d2 = date2.split('-')[2],
        time1 = (new Date(y1, m1-1, d1)).getTime(),
        time2 = (new Date(y2, m2-1, d2)).getTime(),
        diff = Math.abs(time1-time2);

        return Math.round(diff/(1000*60*60*24))+1;
    };
    
            /*
             * Returns the number of months between 2 dates.
             * 
             * @param date1 (Date): first date (YYYY-MM-DD)
             * @param date2 (Date): second date (YYYY-MM-DD)
             * 
             * @return the number of months 
             */
     this.getNoMonths = function(date1,
                                 date2){
        var firstMonth,
        lastMonth,
        m,
        month1,
        month2,
        noMonths = 0,
        y,
        year1,
        year2;

        date1 = date1 <= date2 ? date1:date2;
        month1 = parseInt(date1.split('-')[1], 10);
        year1 = parseInt(date1.split('-')[0], 10);
        month2 = parseInt(date2.split('-')[1], 10);
        year2 = parseInt(date2.split('-')[0], 10);

        for (y=year1; y<=year2; y++){
            firstMonth = y === year1 ? month1:1;
            lastMonth = y === year2 ? month2:12;

            for (m=firstMonth; m<=lastMonth; m++){
                noMonths++;
            }
        }

        return noMonths;
    };
                    
    /*
     * Returns previous day.
     * 
     * @param date (Date): current date (YYYY-MM-DD)
     * 
     * @return previous day (YYYY-MM-DD)
     */
    this.getPrevDay = function(date){
        var previousDay = new Date(),
        parts = date.split('-');

        previousDay.setFullYear(parts[0], parseInt(parts[1])-1, parts[2]);
        previousDay.setTime(previousDay.getTime()-86400000);

        return previousDay.getFullYear()+'-'+DOPPrototypes.getLeadingZero(previousDay.getMonth()+1)+'-'+DOPPrototypes.getLeadingZero(previousDay.getDate());                        
    };
                        
    /*
     * Returns previous time by hours, minutes, seconds.
     * 
     * @param time (String): time (HH, HH:MM, HH:MM:SS)
     * @param diff (Number): diference for previous time
     * @param diffBy (Number): diference by 
     *                         "hours"
     *                         "minutes"
     *                         "seconds"
     * 
     * @return previus hour (HH, HH:MM, HH:MM:SS)
     */
    this.getPrevTime = function(time,
                                diff,
                                diffBy){
        var timePieces = time.split(':'),
        hours = parseInt(timePieces[0], 10),
        minutes = timePieces[1] === undefined ? 0:parseInt(timePieces[1], 10),
        seconds = timePieces[2] === undefined ? 0:parseInt(timePieces[2], 10);

        switch (diffBy){
            case 'seconds':
                seconds = seconds-diff;

                if (seconds < 0){
                    seconds = 60+seconds;
                    minutes = minutes-1;

                    if (minutes < 0){
                        minutes = 60+minutes;
                        hours = hours-1 < 0 ? 0:hours-1;
                    }
                }
                break;
            case 'minutes':
                    minutes = minutes-diff;

                    if (minutes < 0){
                        minutes = 60+minutes;
                        hours = hours-1 < 0 ? 0:hours-1;
                    }
                break;
            default:
                hours = hours-diff < 0 ? 0:hours-diff;
        }

        return this.getLeadingZero(hours)+(timePieces[1] === undefined ? '':':'+this.getLeadingZero(minutes)+(timePieces[2] === undefined ? '':':'+this.getLeadingZero(seconds)));
    };
    
    /*
     * Returns today date.
     * 
     * @return today (YYYY-MM-DD)
     */
    this.getToday = function(){    
        var today = new Date();

        return today.getFullYear()+'-'+DOPPrototypes.getLeadingZero(today.getMonth()+1)+'-'+DOPPrototypes.getLeadingZero(today.getDate());
    };

    /*
     * Returns week day.
     * 
     * @param date (String): date for which the function get day of the week (YYYY-MM-DD)
     * 
     * @return week day index (0 for Sunday)
     */
    this.getWeekDay = function(date){    
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        year = date.split('-')[0],
        month = date.split('-')[1],
        day = date.split('-')[2],
        newDate = new Date(eval('"'+day+' '+months[parseInt(month, 10)-1]+', '+year+'"'));

        return newDate.getDay();
    };
    
// Domains & URLs                        
    
    /*
     * Parse a $_GET variable.
     * 
     * @param name (String): variable name
     * 
     * @return variable vaue or "undefined" if it doesn't exist
     */
    this.$_GET = function(name){
        var url = window.location.href.split('?')[1],
        variables = url !== undefined ? url.split('&'):[],
        i; 

        for (i=0; i<variables.length; i++){
            if (variables[i].indexOf(name) !== -1){
                return variables[i].split('=')[1];
                break;
            }
        }

        return undefined;
    };
    
    /*
     * Access-Control-Allow-Origin buster. Modifies URL to be the same as browser URL.
     * 
     * @param url (String): URL
     * 
     * @return modified URL
     */
    this.acaoBuster = function(url){
        var browserURL = window.location.href,
        pathPiece1 = '', pathPiece2 = '';

        if (this.getDomain(browserURL) === this.getDomain(url)){
            if (url.indexOf('https') !== -1 
                    || url.indexOf('http') !== -1){
                if (browserURL.indexOf('http://www.') !== -1){
                    pathPiece1 = 'http://www.';
                }
                else if (browserURL.indexOf('http://') !== -1){
                    pathPiece1 = 'http://';
                }
                else if (browserURL.indexOf('https://www.') !== -1){
                    pathPiece1 = 'https://www.';
                }
                else if (browserURL.indexOf('https://') !== -1){
                    pathPiece1 = 'https://';
                }

                if (url.indexOf('http://www.') !== -1){
                    pathPiece2 = url.split('http://www.')[1];
                }
                else if (url.indexOf('http://') !== -1){
                    pathPiece2 = url.split('http://')[1];
                }
                else if (url.indexOf('https://www.') !== -1){
                    pathPiece2 = url.split('https://www.')[1];
                }
                else if (url.indexOf('https://') !== -1){
                    pathPiece2 = url.split('https://')[1];
                }

                return pathPiece1+pathPiece2;
            }
            else{
                return url;
            }
        }
        else{
            return url;
        }
    };
    
    /*
     * Get current domain.
     *
     * @param url (String): the URL from which the domain will be extracted
     *
     * @return current domain
     */ 
    this.getDomain = function(url){
        var domain = url;

        /*
         * Remove white spaces from the begining of the URL.
         */
        domain = domain.replace(new RegExp(/^\s+/),"");

        /*
         * Remove white spaces from the end of the URL.
         */
        domain = domain.replace(new RegExp(/\s+$/),"");

        /*
         * If found , convert back slashes to forward slashes.
         */
        domain = domain.replace(new RegExp(/\\/g),"/");

        /*
         * If there, removes "http://", "https://" or "ftp://" from the begining.
         */
        domain = domain.replace(new RegExp(/^http\:\/\/|^https\:\/\/|^ftp\:\/\//i),"");

        /*
         * If there, removes 'www.' from the begining.
         */
        domain = domain.replace(new RegExp(/^www\./i),"");

        /*
         * Remove complete string from first forward slash on.
         */
        domain = domain.replace(new RegExp(/\/(.*)/),"");

        return domain;
    };
    
    /*
     * Check if current URL has a subdomain.
     *
     * @param url (String): URL that will be checked
     *
     * @return true/false
     */ 
    this.hasSubdomain = function(url){
        var subdomain;

        /*
         * Remove white spaces from the begining of the URL.
         */
        url = url.replace(new RegExp(/^\s+/),"");

        /*
         * Remove white spaces from the end of the URL.
         */
        url = url.replace(new RegExp(/\s+$/),"");

        /*
         * If found , convert back slashes to forward slashes.
         */
        url = url.replace(new RegExp(/\\/g),"/");

        /*
         * If there, removes 'http://', 'https://' or 'ftp://' from the begining.
         */
        url = url.replace(new RegExp(/^http\:\/\/|^https\:\/\/|^ftp\:\/\//i),"");

        /*
         * If there, removes 'www.' from the begining.
         */
        url = url.replace(new RegExp(/^www\./i),"");

        /*
         * Remove complete string from first forward slaash on.
         */
        url = url.replace(new RegExp(/\/(.*)/),""); // 

        if (url.match(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i))){
            /*
             * Remove ".??.??" or ".???.??" from end - e.g. ".CO.UK", ".COM.AU"
             */
            url = url.replace(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i),"");
        }
        else if (url.match(new RegExp(/\.[a-z]{2,4}$/i))){
            /*
             * Removes ".??" or ".???" or ".????" from end - e.g. ".US", ".COM", ".INFO"
             */
            url = url.replace(new RegExp(/\.[a-z]{2,4}$/i),"");
        }

        /*
         * Check to see if there is a dot "." left in the string.
         */
        subdomain = (url.match(new RegExp(/\./g))) ? true : false;

        return(subdomain);
    };

// Resize & position                        
    
    /*
     * Resize & position an item inside a parent.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): parent width
     * @param ph (Number): parent height
     * @param cw (Number): child width
     * @param ch (Number): child height
     * @param pos (String): set child position in parent (bottom, bottom-center, bottom-left, bottom-right, center, left, horizontal-center, middle-left, middle-right, right, top, top-center, top-left, top-right, vertical-center)
     * @param type (String): resize type
     *                       "fill" fill parent (child will be cropped)
     *                       "fit" child resize to fit in parent
     */
    this.rp = function(parent,
                       child,
                       pw,
                       ph,
                       cw,
                       ch,
                       pos,
                       type){
        var newW = 0,
        newH = 0;

        /*
         * Resize child.
         */
        if (cw <= pw 
                && ch <= ph){
            newW = cw;
            newH = ch;
        }
        else{
            switch (type){
                case 'fill':
                    newH = ph;
                    newW = (cw*ph)/ch;

                    if (newW < pw){
                        newW = pw;
                        newH = (ch*pw)/cw;
                    }
                    break;
                default:
                    newH = ph;
                    newW = (cw*ph)/ch;

                    if (newW > pw){
                        newW = pw;
                        newH = (ch*pw)/cw;
                    }
                    break;
            }
        }

        child.width(newW);
        child.height(newH);

        /*
         * Position child.
         */
        switch(pos.toLowerCase()){
            case 'bottom':
                this.rpBottom(parent, 
                              child, 
                              ph);
                break;
            case 'bottom-center':
                this.rpBottomCenter(parent, 
                                    child, 
                                    pw, 
                                    ph);
                break;
            case 'bottom-left':
                this.rpBottomLeft(parent, 
                                  child, 
                                  pw, 
                                  ph);
                break;
            case 'bottom-right':
                this.rpBottomRight(parent, 
                                   child, 
                                   pw, 
                                   ph);
                break;
            case 'center':
                this.rpCenter(parent, 
                              child, 
                              pw, 
                              ph);
                break;
            case 'left':
                this.rpLeft(parent, 
                            child, 
                            pw);
                break;
            case 'horizontal-center':
                this.rpCenterHorizontally(parent, 
                                          child, 
                                          pw);
                break;
            case 'middle-left':
                this.rpMiddleLeft(parent, 
                                  child, 
                                  pw, 
                                  ph);
                break;
            case 'middle-right':
                this.rpMiddleRight(parent, 
                                   child, 
                                   pw, 
                                   ph);
                break;
            case 'right':
                this.rpRight(parent, 
                             child, 
                             pw);
                break;
            case 'top':
                this.rpTop(parent, 
                           child, 
                           ph);
                break;
            case 'top-center':
                this.rpTopCenter(parent, 
                                 child, 
                                 pw, 
                                 ph);
                break;
            case 'top-left':
                this.rpTopLeft(parent, 
                               child, 
                               pw, 
                               ph);
                break;
            case 'top-right':
                this.rpTopRight(parent, 
                                child, 
                                pw, 
                                ph);
                break;
            case 'vertical-center':
                this.rpCenterVertically(parent, 
                                        child, 
                                        ph);
                break;
        }
    };
    
    /*
     * Position item on bottom.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpBottom = function(parent,
                             child,
                             ph){
        if (ph !== undefined){
            parent.height(ph);
        }
        child.css('margin-top', parent.height()-child.height());
    };
    
    /*
     * Position item on bottom-left.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpBottomCenter = function(parent,
                                   child,
                                   pw,
                                   ph){
        this.rpBottom(parent, 
                      child, 
                      ph);
        this.rpCenterHorizontally(parent, 
                                  child, 
                                  pw);
    };
    
    /*
     * Position item on bottom-left.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpBottomLeft = function(parent,
                                 child,
                                 pw,
                                 ph){
        this.rpBottom(parent, 
                      child, 
                      ph);
        this.rpLeft(parent, 
                    child, 
                    pw);
    };
    
    /*
     * Position item on bottom-left.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpBottomRight = function(parent,
                                  child,
                                  pw,
                                  ph){
        this.rpBottom(parent, 
                      child, 
                      ph);
        this.rpRight(parent, 
                     child, 
                     pw);
    };
    
    /*
     * Position item on center.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpCenter = function(parent,
                             child,
                             pw,
                             ph){
        this.rpCenterHorizontally(parent,
                                  child,
                                  pw);
        this.rpCenterVertically(parent, 
                                child, 
                                ph);
    };
    
    /*
     * Center item horizontally.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     */
    this.rpCenterHorizontally = function(parent,
                                         child,
                                         pw){
        if (pw !== undefined){
            parent.width(pw);
        }
        child.css('margin-left', (parent.width()-child.width())/2);
    };
    
    /*
     * Center item vertically.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpCenterVertically = function(parent,
                                       child,
                                       ph){
        if (ph !== undefined){
            parent.height(ph);
        }
        child.css('margin-top', (parent.height()-child.height())/2);
    };
    
    /*
     * Position item on left.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     */
    this.rpLeft = function(parent,
                           child,
                           pw){
        if (pw !== undefined){
            parent.width(pw);
        }
        child.css('margin-left', 0);
    };
    
    /*
     * Position item on middle-left.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpMiddleLeft = function(parent,
                                 child,
                                 pw,
                                 ph){
        this.rpCenterVertically(parent, 
                                child, 
                                ph);
        this.rpLeft(parent, 
                    child, 
                    pw);
    };
    
    /*
     * Position item on middle-right.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpMiddleRight = function(parent,
                                  child,
                                  pw,
                                  ph){
        this.rpCenterVertically(parent, 
                                child, 
                                ph);
        this.rpRight(parent, 
                     child, 
                     pw);
    };
    
    /*
     * Position item on right.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     */
    this.rpRight = function(parent,
                            child,
                            pw){
        if (pw !== undefined){
            parent.width(pw);
        }
        child.css('margin-left', parent.width()-child.width());
    };
    
    /*
     * Position item on top.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpTop = function(parent,
                          child,
                          ph){
        if (ph !== undefined){
            parent.height(ph);
        }
        child.css('margin-top', 0);
    };
    
    /*
     * Position item on top-center.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpTopCenter = function(parent,
                                child,
                                pw,
                                ph){
        this.rpTop(parent, 
                   child, 
                   ph);
        this.rpCenterHorizontally(parent, 
                                  child, 
                                  pw);
    };
    
    /*
     * Position item on top-left.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */
    this.rpTopLeft = function(parent,
                              child,
                              pw,
                              ph){
        this.rpTop(parent, 
                   child, 
                   ph);
        this.rpLeft(parent, 
                    child, 
                    pw);
    };
          
    /*
     * Position item on top-right.
     * 
     * @param parent (element): parent item
     * @param child (element): child item
     * @param pw (Number): width to which the parent is going to be set
     * @param ph (Number): height to which the parent is going to be set
     */  
    this.rpTopRight = function(parent,
                               child,
                               pw,
                               ph){
        this.rpTop(parent, 
                   child, 
                   ph);
        this.rpRight(parent, 
                     child, 
                     pw);
    };

// Strings & numbers
    
    /*
     * Clean an input from unwanted characters.
     * 
     * @param input (element): the input to be checked
     * @param allowedCharacters (String): the string of allowed characters
     * @param firstNotAllowed (String): the character which can't be on the first position
     * @param min (Number/String): the minimum value that is allowed in the input
     * 
     * @return clean string
     */ 
    this.cleanInput = function(input,
                               allowedCharacters,
                               firstNotAllowed,
                               min){
        var characters = input.val().split(''),
        returnStr = '', 
        i, 
        startIndex = 0;

        /*
         * Check first character.
         */
        if (characters.length > 1 
                && characters[0] === firstNotAllowed){
            startIndex = 1;
        }

        /*
         * Check characters.
         */
        for (i=startIndex; i<characters.length; i++){
            if (allowedCharacters.indexOf(characters[i]) !== -1){
                returnStr += characters[i];
            }
        }

        /*
         * Check the minimum value.
         */
        if (min > returnStr){
            returnStr = min;
        }

        input.val(returnStr);
    };
    
    /*
     * Adds a leading 0 if number smaller than 10.
     * 
     * @param no (Number): the number
     * 
     * @return number with leading 0 if needed
     */
    this.getLeadingZero = function(no){
        if (no < 10){
            return '0'+no;
        }
        else{
            return no;
        }
    };
    
    /*
     * Creates a string with random characters.
     * 
     * @param stringLength (Number): the length of the returned string
     * @param allowedCharacters (String): the string of allowed characters
     * 
     * @return random string
     */
    this.getRandomString = function(stringLength,
                                    allowedCharacters){
        var randomString = '',
        charactersPosition,
        i;

        allowedCharacters = allowedCharacters !== undefined ? allowedCharacters:'0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';

        for (i=0; i<stringLength; i++){
            charactersPosition = Math.floor(Math.random()*allowedCharacters.length);
            randomString += allowedCharacters.substring(charactersPosition, charactersPosition+1);
        }
        return randomString;
    };
    
    /*
     * Returns a part of a string followed by 3 dots.
     * 
     * @param str (String): the string
     * @param size (Number): the number of characters that will be displayed minus 3 dots
     * 
     * @return short string ...
     */
    this.getShortString = function(str,
                                   size){
        var newStr = new Array(),
        pieces = str.split(''), 
        i;

        if (pieces.length <= size){
            newStr.push(str);
        }
        else{
            for (i=0; i<size-3; i++){
                newStr.push(pieces[i]);
            }
            newStr.push('...');
        }

        return newStr.join('');
    };
    
    /*
     * Returns a number with a predefined number of decimals.
     * 
     * @param number (Number): the number
     * @param no (Number): the number of decimals
     * 
     * @return string with number and decimals
     */
    this.getWithDecimals = function(number,
                                    no){
        no = no === undefined ? 2:no;
        return parseInt(number) === number ? String(number):parseFloat(number).toFixed(no);
    };
    
    /*
     * Verify if a string contains allowed characters.
     * 
     * @param str (String): string to be checked
     * @param allowedCharacters (String): the string of allowed characters
     * 
     * @return true/false
     */
    this.validateCharacters = function(str,
                                       allowedCharacters){
        var characters = str.split(''), 
        i;

        for (i=0; i<characters.length; i++){
            if (allowedCharacters.indexOf(characters[i]) === -1){
                return false;
            }
        }
        return true;
    };
    
    /*
     * Email validation.
     * 
     * @param email (String): email to be checked
     * 
     * @return true/false
     */
    this.validEmail = function(email){
        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

        if (filter.test(email)){
            return true;
        }
        return false;
    };
    
    /*
     * Remove slashes from string.
     * 
     * @param str (String): the string
     * 
     * @return string without slashes
     */
    this.stripSlashes = function(str){
        return (str + '').replace(/\\(.?)/g, function (s, n1){
            switch (n1){
                case '\\':
                    return '\\';
                case '0':
                    return '\u0000';
                case '':
                    return '';
                default:
                    return n1;
            }
        });
    };

// Styles
    
    /*
     * Convert RGB color to HEX.
     * 
     * @param rgb (String): RGB color
     * 
     * @return color HEX
     */
    this.getHEXfromRGB = function(rgb){
        var hexDigits = new Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

        return (isNaN(rgb[1]) ? '00':hexDigits[(rgb[1]-rgb[1]%16)/16]+hexDigits[rgb[1]%16])+
               (isNaN(rgb[2]) ? '00':hexDigits[(rgb[2]-rgb[2]%16)/16]+hexDigits[rgb[2]%16])+
               (isNaN(rgb[3]) ? '00':hexDigits[(rgb[3]-rgb[3]%16)/16]+hexDigits[rgb[3]%16]);
    };

    /*
     * Set text color depending on the background color.
     * 
     * @param bgColor(String): background color
     * 
     * return white/black
     */
    this.getIdealTextColor = function(bgColor){
        var rgb = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(bgColor);

        if (rgb !== null){
            return parseInt(rgb[1], 10)+parseInt(rgb[2], 10)+parseInt(rgb[3], 10) < 3*256/2 ? 'white' : 'black';
        }
        else{
            return parseInt(bgColor.substring(0, 2), 16)+parseInt(bgColor.substring(2, 4), 16)+parseInt(bgColor.substring(4, 6), 16) < 3*256/2 ? 'white' : 'black';
        }
    };
    
    this.getCountries = function(){
            return [{"code":"+93","code2":"AF","name":"Afghanistan"},{"code":"+355","code2":"AL","name":"Albania"},{"code":"+213","code2":"DZ","name":"Algeria"},{"code":"+1 684","code2":"AS","name":"American Samoa"},{"code":"+376","code2":"AD","name":"Andorra"},{"code":"+244","code2":"AO","name":"Angola"},{"code":"+1 264","code2":"AI","name":"Anguilla"},{"code":"+672","code2":"AQ","name":"Antarctica"},{"code":"+1 268","code2":"AG","name":"Antigua and Barbuda"},{"code":"+54","code2":"AR","name":"Argentina"},{"code":"+374","code2":"AM","name":"Armenia"},{"code":"+297","code2":"AW","name":"Aruba"},{"code":"+61","code2":"AU","name":"Australia"},{"code":"+43","code2":"AT","name":"Austria"},{"code":"+994","code2":"AZ","name":"Azerbaijan"},{"code":"+1 242","code2":"BS","name":"Bahamas"},{"code":"+973","code2":"BH","name":"Bahrain"},{"code":"+880","code2":"BD","name":"Bangladesh"},{"code":"+1 246","code2":"BB","name":"Barbados"},{"code":"+375","code2":"BY","name":"Belarus"},{"code":"+32","code2":"BE","name":"Belgium"},{"code":"+501","code2":"BZ","name":"Belize"},{"code":"+229","code2":"BJ","name":"Benin"},{"code":"+1 441","code2":"BM","name":"Bermuda"},{"code":"+975","code2":"BT","name":"Bhutan"},{"code":"+591","code2":"BO","name":"Bolivia"},{"code":"+387","code2":"BA","name":"Bosnia and Herzegovina"},{"code":"+267","code2":"BW","name":"Botswana"},{"code":"+55","code2":"BR","name":"Brazil"},{"code":"+246","code2":"IO","name":"British Indian Ocean Territory"},{"code":"+1 284","code2":"VG","name":"British Virgin Islands"},{"code":"+673","code2":"BN","name":"Brunei"},{"code":"+359","code2":"BG","name":"Bulgaria"},{"code":"+226","code2":"BF","name":"Burkina Faso"},{"code":"+257","code2":"BI","name":"Burundi"},{"code":"+855","code2":"KH","name":"Cambodia"},{"code":"+237","code2":"CM","name":"Cameroon"},{"code":"+1","code2":"CA","name":"Canada"},{"code":"+238","code2":"CV","name":"Cape Verde"},{"code":"+ 345","code2":"KY","name":"Cayman Islands"},{"code":"+236","code2":"CF","name":"Central African Republic"},{"code":"+235","code2":"TD","name":"Chad"},{"code":"+56","code2":"CL","name":"Chile"},{"code":"+86","code2":"CN","name":"China"},{"code":"+61","code2":"CX","name":"Christmas Island"},{"code":"+61","code2":"CC","name":"Cocos-Keeling Islands"},{"code":"+57","code2":"CO","name":"Colombia"},{"code":"+269","code2":"KM","name":"Comoros"},{"code":"+242","code2":"CG","name":"Congo"},{"code":"+243","code2":"CD","name":"Congo, Dem. Rep. of (Zaire)"},{"code":"+682","code2":"CK","name":"Cook Islands"},{"code":"+506","code2":"CR","name":"Costa Rica"},{"code":"+385","code2":"HR","name":"Croatia"},{"code":"+53","code2":"CU","name":"Cuba"},{"code":"+357","code2":"CY","name":"Cyprus"},{"code":"+420","code2":"CZ","name":"Czech Republic"},{"code":"+45","code2":"DK","name":"Denmark"},{"code":"+253","code2":"DJ","name":"Djibouti"},{"code":"+1 767","code2":"DM","name":"Dominica"},{"code":"+1 809","code2":"DO","name":"Dominican Republic"},{"code":"+670","code2":"TL","name":"East Timor"},{"code":"+593","code2":"EC","name":"Ecuador"},{"code":"+20","code2":"EG","name":"Egypt"},{"code":"+503","code2":"SV","name":"El Salvador"},{"code":"+240","code2":"GQ","name":"Equatorial Guinea"},{"code":"+291","code2":"ER","name":"Eritrea"},{"code":"+372","code2":"EE","name":"Estonia"},{"code":"+251","code2":"ET","name":"Ethiopia"},{"code":"+500","code2":"FK","name":"Falkland Islands"},{"code":"+298","code2":"FO","name":"Faroe Islands"},{"code":"+679","code2":"FJ","name":"Fiji"},{"code":"+358","code2":"FI","name":"Finland"},{"code":"+33","code2":"FR","name":"France"},{"code":"+594","code2":"GF","name":"French Guiana"},{"code":"+689","code2":"PF","name":"French Polynesia"},{"code":"+241","code2":"GA","name":"Gabon"},{"code":"+220","code2":"GM","name":"Gambia"},{"code":"+995","code2":"GE","name":"Georgia"},{"code":"+49","code2":"DE","name":"Germany"},{"code":"+233","code2":"GH","name":"Ghana"},{"code":"+350","code2":"GI","name":"Gibraltar"},{"code":"+30","code2":"GR","name":"Greece"},{"code":"+299","code2":"GL","name":"Greenland"},{"code":"+1 473","code2":"GD","name":"Grenada"},{"code":"+590","code2":"GP","name":"Guadeloupe"},{"code":"+1 671","code2":"GU","name":"Guam"},{"code":"+502","code2":"GT","name":"Guatemala"},{"code":"+224","code2":"GN","name":"Guinea"},{"code":"+245","code2":"GW","name":"Guinea-Bissau"},{"code":"+595","code2":"GY","name":"Guyana"},{"code":"+509","code2":"HT","name":"Haiti"},{"code":"+379","code2":"VA","name":"Holy See(Vatican)"},{"code":"+504","code2":"HN","name":"Honduras"},{"code":"+852","code2":"HK","name":"Hong Kong SAR China"},{"code":"+36","code2":"HU","name":"Hungary"},{"code":"+354","code2":"IS","name":"Iceland"},{"code":"+91","code2":"IN","name":"India"},{"code":"+62","code2":"ID","name":"Indonesia"},{"code":"+98","code2":"IR","name":"Iran"},{"code":"+964","code2":"IQ","name":"Iraq"},{"code":"+353","code2":"IE","name":"Ireland"},{"code":"+972","code2":"IR","name":"Israel"},{"code":"+39","code2":"IT","name":"Italy"},{"code":"+225","code2":"CI","name":"Ivory Coast"},{"code":"+1 876","code2":"JM","name":"Jamaica"},{"code":"+81","code2":"JP","name":"Japan"},{"code":"+962","code2":"JO","name":"Jordan"},{"code":"+7","code2":"KZ","name":"Kazakhstan"},{"code":"+254","code2":"KE","name":"Kenya"},{"code":"+686","code2":"KI","name":"Kiribati"},{"code":"+965","code2":"KW","name":"Kuwait"},{"code":"+996","code2":"KG","name":"Kyrgyzstan"},{"code":"+856","code2":"LA","name":"Laos"},{"code":"+371","code2":"LV","name":"Latvia"},{"code":"+961","code2":"LB","name":"Lebanon"},{"code":"+266","code2":"LS","name":"Lesotho"},{"code":"+231","code2":"LR","name":"Liberia"},{"code":"+218","code2":"LY","name":"Libya"},{"code":"+423","code2":"LI","name":"Liechtenstein"},{"code":"+370","code2":"LT","name":"Lithuania"},{"code":"+352","code2":"LU","name":"Luxembourg"},{"code":"+853","code2":"MO","name":"Macau SAR China"},{"code":"+389","code2":"MK","name":"Macedonia"},{"code":"+261","code2":"MG","name":"Madagascar"},{"code":"+265","code2":"MW","name":"Malawi"},{"code":"+60","code2":"MY","name":"Malaysia"},{"code":"+960","code2":"MV","name":"Maldives"},{"code":"+223","code2":"ML","name":"Mali"},{"code":"+356","code2":"MT","name":"Malta"},{"code":"+692","code2":"MH","name":"Marshall Islands"},{"code":"+596","code2":"MQ","name":"Martinique"},{"code":"+222","code2":"MR","name":"Mauritania"},{"code":"+230","code2":"MU","name":"Mauritius"},{"code":"+262","code2":"YT","name":"Mayotte"},{"code":"+52","code2":"MX","name":"Mexico"},{"code":"+691","code2":"FM","name":"Micronesia"},{"code":"+373","code2":"MD","name":"Moldova"},{"code":"+377","code2":"MC","name":"Monaco"},{"code":"+976","code2":"MN","name":"Mongolia"},{"code":"+382","code2":"ME","name":"Montenegro"},{"code":"+1664","code2":"MS","name":"Montserrat"},{"code":"+212","code2":"MA","name":"Morocco"},{"code":"+258","code2":"MZ","name":"Mozambique"},{"code":"+95","code2":"MM","name":"Myanmar"},{"code":"+264","code2":"NA","name":"Namibia"},{"code":"+674","code2":"NR","name":"Nauru"},{"code":"+977","code2":"NP","name":"Nepal"},{"code":"+31","code2":"NL","name":"Netherlands"},{"code":"+599","code2":"AN","name":"Netherlands Antilles"},{"code":"+1 869","code2":"KN","name":"Nevis"},{"code":"+687","code2":"NC","name":"New Caledonia"},{"code":"+64","code2":"NZ","name":"New Zealand"},{"code":"+505","code2":"NI","name":"Nicaragua"},{"code":"+227","code2":"NE","name":"Niger"},{"code":"+234","code2":"NG","name":"Nigeria"},{"code":"+683","code2":"NU","name":"Niue"},{"code":"+672","code2":"NF","name":"Norfolk Island"},{"code":"+850","code2":"KP","name":"North Korea"},{"code":"+1 670","code2":"MP","name":"Northern Mariana Islands"},{"code":"+47","code2":"NO","name":"Norway"},{"code":"+968","code2":"OM","name":"Oman"},{"code":"+92","code2":"PK","name":"Pakistan"},{"code":"+680","code2":"PW","name":"Palau"},{"code":"+970","code2":"PS","name":"Palestinian Territory"},{"code":"+507","code2":"PA","name":"Panama"},{"code":"+675","code2":"PG","name":"Papua New Guinea"},{"code":"+595","code2":"PY","name":"Paraguay"},{"code":"+51","code2":"PE","name":"Peru"},{"code":"+63","code2":"PH","name":"Philippines"},{"code":"+64","code2":"PN","name":"Pitcairn Islands"},{"code":"+48","code2":"PL","name":"Poland"},{"code":"+351","code2":"PT","name":"Portugal"},{"code":"+1 787","code2":"PR","name":"Puerto Rico"},{"code":"+974","code2":"QA","name":"Qatar"},{"code":"+262","code2":"RE","name":"Reunion"},{"code":"+40","code2":"RO","name":"Romania"},{"code":"+7","code2":"RU","name":"Russia"},{"code":"+250","code2":"RW","name":"Rwanda"},{"code":"+685","code2":"WS","name":"Samoa"},{"code":"+378","code2":"SM","name":"San Marino"},{"code":"+966","code2":"SA","name":"Saudi Arabia"},{"code":"+221","code2":"SN","name":"Senegal"},{"code":"+381","code2":"RS","name":"Serbia"},{"code":"+248","code2":"SC","name":"Seychelles"},{"code":"+232","code2":"SL","name":"Sierra Leone"},{"code":"+65","code2":"SG","name":"Singapore"},{"code":"+421","code2":"SK","name":"Slovakia"},{"code":"+386","code2":"SI","name":"Slovenia"},{"code":"+677","code2":"SB","name":"Solomon Islands"},{"code":"+27","code2":"ZA","name":"South Africa"},{"code":"+500","code2":"GS","name":"South Georgia and the South Sandwich Islands"},{"code":"+82","code2":"KR","name":"South Korea"},{"code":"+34","code2":"ES","name":"Spain"},{"code":"+94","code2":"LK","name":"Sri Lanka"},{"code":"+249","code2":"SD","name":"Sudan"},{"code":"+597","code2":"SR","name":"Suriname"},{"code":"+268","code2":"SZ","name":"Swaziland"},{"code":"+46","code2":"SE","name":"Sweden"},{"code":"+41","code2":"CH","name":"Switzerland"},{"code":"+963","code2":"SY","name":"Syria"},{"code":"+886","code2":"TW","name":"Taiwan"},{"code":"+992","code2":"TJ","name":"Tajikistan"},{"code":"+255","code2":"TZ","name":"Tanzania"},{"code":"+66","code2":"TH","name":"Thailand"},{"code":"+670","code2":"TL","name":"Timor Leste"},{"code":"+228","code2":"TG","name":"Togo"},{"code":"+690","code2":"TK","name":"Tokelau"},{"code":"+676","code2":"TO","name":"Tonga"},{"code":"+1 868","code2":"TT","name":"Trinidad and Tobago"},{"code":"+216","code2":"TN","name":"Tunisia"},{"code":"+90","code2":"TR","name":"Turkey"},{"code":"+993","code2":"TM","name":"Turkmenistan"},{"code":"+1 649","code2":"TC","name":"Turks and Caicos Islands"},{"code":"+688","code2":"TV","name":"Tuvalu"},{"code":"+1 340","code2":"VI","name":"U.S. Virgin Islands"},{"code":"+256","code2":"UG","name":"Uganda"},{"code":"+380","code2":"UA","name":"Ukraine"},{"code":"+971","code2":"AE","name":"United Arab Emirates"},{"code":"+44","code2":"GB","name":"United Kingdom"},{"code":"+1","code2":"US","name":"United States"},{"code":"+598","code2":"UY","name":"Uruguay"},{"code":"+998","code2":"UZ","name":"Uzbekistan"},{"code":"+678","code2":"VU","name":"Vanuatu"},{"code":"+58","code2":"VE","name":"Venezuela"},{"code":"+84","code2":"VN","name":"Vietnam"},{"code":"+681","code2":"WF","name":"Wallis and Futuna"},{"code":"+967","code2":"YE","name":"Yemen"},{"code":"+260","code2":"ZM","name":"Zambia"},{"code":"+263","code2":"ZW","name":"Zimbabwe"}];
    };
    
    return this.__construct();
};