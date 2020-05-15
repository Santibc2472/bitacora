
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.3.3
* File                    : assets/js/reservations/backend-reservation-form.js
* File Version            : 1.0
* Created / Last Modified : 12 October 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservation JavaScript class.
*/

var DOPBSPBackEndReservationForm = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict(),
        reservation_id = 0;
    
    /*
     * Constructor
     */ 
    this.__construct = function(){
    };
    
    /*
     * Initialize reservation form.
     */
    this.init = function(){
        $('.dopbsp-reservation-form span').unbind('click');
        $('.dopbsp-reservation-form span').bind('click', function(){
            if($(this).attr('id').indexOf('save') !== -1) {
                // Save
                reservation_id = $(this).attr('id').split('dopbsp-reservation-form-')[1].split('-save')[0];
                $('#dopbsp-reservation-form-'+reservation_id+'-save').addClass('dopbsp-hidden');
                $('#dopbsp-reservation-form-'+reservation_id).removeClass('dopbsp-hidden');
                $('.dopbsp-reservation-form-'+reservation_id).removeClass('dopbsp-hidden');
                $('.dopbsp-reservation-form-'+reservation_id+'-edit').addClass('dopbsp-hidden');
                DOPBSPBackEndReservationForm.save();
            } else {
                // Edit Reservation
                reservation_id = $(this).attr('id').split('dopbsp-reservation-form-')[1];
                $('#dopbsp-reservation-form-'+reservation_id+'-save').removeClass('dopbsp-hidden');
                $('#dopbsp-reservation-form-'+reservation_id).addClass('dopbsp-hidden');
                $('.dopbsp-reservation-form-'+reservation_id).addClass('dopbsp-hidden');
                $('.dopbsp-reservation-form-'+reservation_id+'-edit').removeClass('dopbsp-hidden');
            }
        });
        
        $('.dopbsp-reservation-form-edit').unbind('keyup paste keydown blur');
        $('.dopbsp-reservation-form-edit').bind('keyup paste keydown blur', function(){
            reservation_id = $(this).attr('data-reservation-id');
            var field_id = $(this).attr('id').split('dopbsp-reservation-form-field-edit-'+reservation_id+'-')[1];
            DOPBSPBackEndReservationForm.edit(field_id, $(this).val());
        });
    };

    /*
     * Edit reservation form.
     * 
     * @param id (Number): field ID
     * @param value (string): field value
     */
    this.edit = function(id, value){
        var reservation_json = JSON.parse($('#dopbsp-reservation-form-'+reservation_id+'-data').val());
            
            for(var i = 0; i<reservation_json.length; i++) {
                
                if (reservation_json[i]['id'] === id){
                    var value_json = value.replace(/'/g, "&#39;");
                        value_json = value_json.replace(/"/g, '&#39;');

                    reservation_json[i]['value'] = value_json;
                }
            }
        
            if(DOPPrototypes.validEmail(value)) {
               value = '<a href="mailto:'+value+'">'+value+'</a>'; 
            }
        
            $('#dopbsp-reservation-form-field-value-'+reservation_id+'-'+id).html(value);
            $('#dopbsp-reservation-form-'+reservation_id+'-data').val(JSON.stringify(reservation_json));  
    };

    /*
     * Save reservation.
     * 
     * @param id (Number): field ID
     * @param value (string): field value
     */
    this.save = function(){
        var reservation_json = $('#dopbsp-reservation-form-'+reservation_id+'-data').val();
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_form_edit',
                         id: reservation_id,
                         value: reservation_json}, function(data){
            data = $.trim(data);
                    
            if (data === 'success'){  
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('MESSAGES_SAVING_SUCCESS'));
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };
    
    return this.__construct();
};