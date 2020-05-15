
/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.2
* File                    : assets/js/locations/backend-locations.js
* File Version            : 1.0.4
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end locations JavaScript class.
*/

var DOPBSPBackEndLocations = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Initialize Google Maps before display.
     */
    this.init = function(){
        if (typeof google !== 'object' 
                || typeof google.maps !== 'object'){
            var script = document.createElement('script');

            script.type = 'text/JavaScript';
            script.src = 'https://maps.googleapis.com/maps/api/js?key='+dopbspGoogleAPIkey+'&v=3.exp&libraries=places&callback=DOPBSPBackEndLocations.display';

            $('body').append(script);
        }
        else{
            DOPBSPBackEndLocations.display();
        }
    }

    /*
     * Display locations list.
     */
    this.display = function(){
        DOPBSPBackEnd.clearColumns(1);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));

        $.post(ajaxurl, {action: 'dopbsp_locations_display'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('LOCATIONS_LOAD_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.__construct();
};