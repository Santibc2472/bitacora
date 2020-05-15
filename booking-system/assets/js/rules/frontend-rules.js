
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.7
* File                    : assets/js/rules/frontend-rules.js
* File Version            : 1.0.1
* Created / Last Modified : 23 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end rules JavaScript class.
*/

var DOPBSPFrontEndRules = new function(){
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
     * Get the maximum stay of days/hours set in the rules.
     * 
     * @param ID (Number): calendar ID
     * 
     * @return maximum time lapse value
     */           
    this.getMaxTimeLapse = function(ID){
        var dataRules = DOPBSPFrontEnd.calendar[ID]['rules']['data'];
        
        if(dataRules['rule'] != null){   
            return dataRules['id'] !== '0' ? parseFloat(dataRules['rule']['time_lapse_max']):0;
        }
        else {
            return 0;
        }
    };
    
    /*
     * Get the minimum stay of days/hours set in the rules.
     * 
     * @param ID (Number): calendar ID
     * 
     * @return minimum time lapse value
     */ 
    this.getMinTimeLapse = function(ID){   
        var dataRules = DOPBSPFrontEnd.calendar[ID]['rules']['data'];
	
        if(dataRules['rule'] != null){   
            return dataRules['id'] !== '0' ? parseFloat(dataRules['rule']['time_lapse_min']):0;
        }
        else {
            return 0;
        }
    };
    
    return this.__construct();
};