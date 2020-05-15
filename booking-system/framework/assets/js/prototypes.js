/*
 * Title                   : DOT Framework
 * File                    : framework/assets/js/prototype.js
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : JavaScript prototype functions.
 */

var DOTPrototypes = new function(){
    'use strict';
    
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();

    /*
     * Constructor
     * 
     * @usage
     *	    The constructor is called when a class instance is created.
     * 
     * @params
     *	    -
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     * 
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    -
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.__construct = function(){
    };
    
/*
 * Actions
 */           
    
    /*
     * Open a link.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    url (String): link URL
     *	    target (String): link target (_blank, _parent, _self, _top)
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    The link is open in [target].
     * 
     * @return_details
     *	    The target values are same as HTML [_target] attribute values.
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.link = function(url,
			 target){
        target = target === undefined ? '_self':target;
	
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
     * Scroll vertically to position.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    position (Number): position to scroll to
     *	    speed (Number): scroll speed 
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    The website page is scrolled where you set the position.
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
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
 * Cookies
 */
    
    /*
     * Delete cookie.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    name (String): cookie name
     *	    path (String): cookie path
     *	    domain (String): cookie domain
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    -
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.cookieDelete = function(name,
                                 path,
                                 domain){
        if (this.getCookie(name)){
            document.cookie = name+'='+((path) ? ';path='+path:'')+((domain) ? ';domain='+domain:'')+';expires=Thu, 01-Jan-1970 00:00:01 GMT';
        }
    };
    
    /*
     * Get cookie.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    name (String): cookie name
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    Cookie value.
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.cookieGet = function(name){  
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
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    name (String): cookie name
     *	    value (String): cookie value
     *	    expire (String): the number of days after which the cookie will expire
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    -
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.cookieSet = function(name,
                              value,
                              expire){
        var expirationDate = new Date();

        expirationDate.setDate(expirationDate.getDate()+expire);
        document.cookie = name+'='+escape(value)+((expire === null) ? '': ';expires='+expirationDate.toUTCString())+';javahere=yes;path=/';
    };
    
/*
 * Domains & URLs.
 */
    
    /*
     * Parse a $_GET variable.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    name (String): variable name
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    Return the variable value or "false" if it does not exist.
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.$_GET = function(name){
        var url = window.location.href.split('?')[1], // Get $_GET variables.
        variables = url !== undefined ? url.split('&'):[], // Parse $_GET variables.
        i; 

        for (i=0; i<variables.length; i++){
            if (variables[i].indexOf(name) !== -1){
                return variables[i].split('=')[1];
                break;
            }
        }

        return false;
    };

/*
 * Strings & numbers.
 */
    
    /*
     * Email validation.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    email (String): email to be checked
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    If the email is valid "true" is returned, "false" if its not.
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.email = function(email){
        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

        if (filter.test(email)){
            return true;
        }
        return false;
    };
    
    /*
     * Create a permalink from a string.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    string (string): the string
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    The permalink slug.
     * 
     * @return_details
     *	    All non alphanumeric characters are deleted; spaces [ ] and underscore [_] characters are replaced with hyphens [-].
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.permalink = function(string){
	string = string.replace(/[~`!@#$%^&*()+={}\[\]|\\:;"'<,>.?\/€]/g, '');
	string = string.replace(/[ ]/g, '-');
	string = string.replace(/[_]/g, '-');
	string = string.toLowerCase();

	return string;
    };
    
    /*
     * Creates a string with random characters.
     * 
     * @usage
     *	    Reserved framework function that will be called by DOT application.
     * 
     * @params
     *	    length (Number): the length of the returned string
     *	    allowedCharacters (String): the string of allowed characters; by default only alphanumeric characters are allowed
     * 
     * @post
     *	    -
     * 
     * @get
     *	    -
     * 
     * @sessions
     *	    -
     * 
     * @cookies
     *	    -
     * 
     * @constants
     *	    -
     * 
     * @globals
     *	    -
     * 
     * @functions
     *	    -
     *	    
     * @hooks
     *	    -
     * 
     * @layouts
     *	    -
     * 
     * @return
     *	    random string
     * 
     * @return_details
     *	    -
     * 
     * @dv
     *	    -
     * 
     * @tests
     *	    -
     */
    this.random = function(length,
			   allowedCharacters){
        var randomString = '',
        characterPosition,
        i;

        allowedCharacters = allowedCharacters !== undefined ? allowedCharacters:'0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';

        for (i=0; i<length; i++){
            characterPosition = Math.floor(Math.random()*allowedCharacters.length);
            randomString += allowedCharacters.substring(characterPosition, characterPosition+1);
        }
	
        return randomString;
    };
    
    return this.__construct();
};