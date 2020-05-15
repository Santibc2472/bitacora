/*
 * Title                   : Pinpoint Booking System
 * File                    : application/assets/js/dot.js
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : DOT JavaScript class.
 */

var DOT = new function(){
    this.ajax = {
	keys: new Array(),
	var: 'action',
	url: ''
    };
    this.calendars = new Array();
    this.id = 'pbs';
    this.layouts = {};
    this.methods = {};
};

DOT.ajax.keys['user_calendars_data'] = 'pbs_user_calendars_data';
DOT.ajax.keys['addons_stripe_error'] = 'pbs_addons_stripe_error';
DOT.ajax.keys['addons_stripe_success'] = 'pbs_addons_stripe_success';