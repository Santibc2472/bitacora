
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/pro/backend-pro.js
* File Version            : 1.0.5
* Created / Last Modified : 20 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end pro JavaScript class.
*/

var DOPBSPBackEndPRO = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
        
    /*
     * Constructor
     */
    this.__construct = function(){
        $(document).ready(function(){
	    DOPBSPBackEndPRO.events();
	});
    };
    
    /*
     * Display PRO.
     */
    this.display = function(){
        $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
    };
    
    /*
     * PRO info events.
     */
    this.events = function(){
	$('#DOPBSP-pro-remove button').click(function(){
	    $.post(ajaxurl, {action: 'dopbsp_pro_remove'}, function(data){
                window.location.reload();
	    }).fail(function(data){
		DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
	    });
	});
    };
    
    return this.__construct();
};