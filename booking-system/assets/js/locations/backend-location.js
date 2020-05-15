
/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.8
* File                    : assets/js/locations/backend-location.js
* File Version            : 1.0.4
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end location JavaScript class.
*/

var DOPBSPBackEndLocation = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables
     */
    this.ajaxRequestInProgress;
    this.ajaxRequestTimeout;
    
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Display location.
     * 
     * @param id (Number): location ID
     * @param language (String): location current editing language
     * @param clearLocation (Boolean): clear location extra data diplay
     */
    this.display = function(id,
                            language,
                            clearLocation){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-location-language').val() === undefined ? '':$('#DOPBSP-location-language').val()):language;
        clearLocation = clearLocation === undefined ? true:false;
        language = clearLocation ? '':language;
        
        if (clearLocation){
            DOPBSPBackEnd.clearColumns(2);
        }
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .dopbsp-column-content li').removeClass('dopbsp-selected');
        $('#DOPBSP-location-ID-'+id).addClass('dopbsp-selected');
        $('#DOPBSP-location-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_location_display', 
                         id: id,
                         language: language}, function(data){
	    if (DOPBSP_view_pro){
		HTML.push('<a href="?page=dopbsp-pro" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info dopbsp-pro">'+DOPBSPBackEnd.text('LOCATIONS_DELETE_LOCATION_SUBMIT')+' - '+DOPBSPBackEnd.text('MESSAGES_PRO_TEXT')+'</span></a>');
	    }
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help">');
            HTML.push(' <span class="dopbsp-info dopbsp-help">');
            HTML.push(DOPBSPBackEnd.text('LOCATIONS_LOCATION_HELP')+'<br /><br />');
            HTML.push(DOPBSPBackEnd.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            DOPBSPBackEndLocation.init();
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize location.
     */
    this.init = function(){
        /*
         * Map Init
         */

        if (typeof google === 'object' 
                && typeof google.maps === 'object'){
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('LOCATIONS_LOCATION_LOADED'));
            google.maps.event.addDomListener(window, 'load', DOPBSPBackEndLocationMap.init());
        }
        else{
            DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('LOCATIONS_LOCATION_NO_GOOGLE_MAPS'));
        }
    };

    /*
     * Edit location.
     * 
     * @param id (Number): location ID
     * @param type (String): field type
     * @param field (String): field name
     * @param value (String): field value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         type, 
                         field,
                         value, 
                         onBlur){
        var calendars = new Array(),
	businesses = new Array(),
	languages = new Array();
        
        onBlur = onBlur === undefined ? false:true;
        
        this.ajaxRequestInProgress !== undefined && !onBlur ? this.ajaxRequestInProgress.abort():'';
        this.ajaxRequestTimeout !== undefined ? clearTimeout(this.ajaxRequestTimeout):'';
        
        switch (field){
            case 'name':
                $('#DOPBSP-location-ID-'+id+' .dopbsp-name').html(value === '' ? '&nbsp;':value);
                break;
            case 'businesses':
                $('#DOPBSP-location-businesses input[type=checkbox]').each(function(){
                    if ($(this).is(':checked')){
                        businesses.push($(this).attr('id').split('DOPBSP-location-business-')[1]);
                        $(this).parent().addClass('dopbsp-selected');
                    }
                    else{
                        $(this).parent().removeClass('dopbsp-selected');
                    }
                });
                value = businesses.join(',');
                break;
            case 'calendars':
                $('#DOPBSP-location-calendars input[type=checkbox]').each(function(){
                    if ($(this).is(':checked')){
                        calendars.push($(this).attr('id').split('DOPBSP-location-calendar')[1]);
                        $(this).parent().addClass('dopbsp-selected');
                    }
                    else{
                        $(this).parent().removeClass('dopbsp-selected');
                    }
                });
                value = calendars.join(',');
                break;
            case 'languages':
                $('#DOPBSP-location-languages input[type=checkbox]').each(function(){
                    if ($(this).is(':checked')){
                        languages.push($(this).attr('id').split('DOPBSP-location-language-')[1]);
                        $(this).parent().addClass('dopbsp-selected');
                    }
                    else{
                        $(this).parent().removeClass('dopbsp-selected');
                    }
                });
                value = languages.join(',');
                break;
        }
        
        if (onBlur  
                || type === 'checkbox'
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_location_edit',
                             id: id,
                             field: field,
                             value: value,
                             coordinates: $('#DOPBSP-location-coordinates').val()}, function(data){
                if (!onBlur){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }
            }).fail(function(data){
                DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
        else{
            DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));
            
            this.ajaxRequestTimeout = setTimeout(function(){
                clearTimeout(this.ajaxRequestTimeout);
                
                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_location_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              coordinates: $('#DOPBSP-location-coordinates').val()}, function(data){
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };

    /*
     * Share location.
     * 
     * @param id (Number): location ID
     */
    this.share = function(id){
	DOPBSPBackEnd.toggleMessages('active-info', DOPBSPBackEnd.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action: 'dopbsp_location_share', 
                         id: id}, function(data){
            data = $.trim(data);
                         
            if (data === 'success'){
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('LOCATIONS_LOCATION_SHARE_SUBMIT_SUCCESS'));
            }             
            else{
                DOPBSPBackEnd.toggleMessages('error', data);
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.__construct();
};