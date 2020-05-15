
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : assets/js/reservations/backend-reservations.js
* File Version            : 1.0.9
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservation JavaScript class.
*/

var DOPBSPBackEndReservation = new function(){
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
     * Initialize reservation.
     */
    this.init = function(){
        $('.DOPBSP-admin .dopbsp-main table.dopbsp-content-wrapper .dopbsp-reservations-list li .dopbsp-reservation-body').isotope({itemSelector: '.dopbsp-data-module'});
        DOPBSPBackEndReservationForm.init();
    };

    /*
     * Approve reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.approve = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_approve',
                         reservation_id: id}, function(data){
            data = $.trim(data);
                    
            if (data === 'unavailable'){  
                DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('RESERVATIONS_APPROVE_UNAVAILABLE'));
            }
            else if (data === 'unavailable-coupon'){  
                DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('RESERVATIONS_APPROVE_UNAVAILABLE_COUPON'));
            }
            else{
                DOPBSPBackEndReservation.update(id,
                                         'approve');
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_APPROVE_SUCCESS'));
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };

    /*
     * Cancel reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.cancel = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_cancel',
                         reservation_id: id}, function(data){
            data = $.trim(data);
            
            var response = data.split(';;;;;');
            
            DOPBSPBackEndReservation.update(id,
                                     'cancel');
                                     
            if (response[0] === 'error'){
                DOPBSPBackEnd.toggleMessages('error', response[1]);
            }                    
            else if (response[0] === 'error_with_message'){
                DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS')+'<br /><br />'+response[1]);
            }
            else if (response[0] === 'success_with_message'){
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS')+'<br /><br />'+response[1]);
            }
            else{
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS'));
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };

    /*
     * Delete reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.delete = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_delete',
                         reservation_id: id}, function(data){
            DOPBSPBackEndReservation.update(id,
                                     'delete');
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };

    /*
     * Reject reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.reject = function(id){
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_reject',
                         reservation_id: id}, function(data){
            DOPBSPBackEndReservation.update(id,
                                     'reject');
            DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_REJECT_SUCCESS'));
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };
    
    /*
     * Update reservation display when status changes.
     * 
     * @param id (Number): reservation ID
     * @param action (String): action to be taken on reservation
     */
    this.update = function(id,
                           action){
        $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-icon').removeClass('dopbsp-approved')
                                                                            .removeClass('dopbsp-canceled')
                                                                            .removeClass('dopbsp-expired')
                                                                            .removeClass('dopbsp-pending')
                                                                            .removeClass('dopbsp-rejected');
        $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-status-info').removeClass('dopbsp-approved')
                                                                                   .removeClass('dopbsp-canceled')
                                                                                   .removeClass('dopbsp-expired')
                                                                                   .removeClass('dopbsp-pending')
                                                                                   .removeClass('dopbsp-rejected');
                
        switch (action){
            case 'approve':
                $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-icon').addClass('dopbsp-approved');
                $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-status-info').addClass('dopbsp-approved')
                                                                                           .html(DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_STATUS_APPROVED'));
                break;
            case 'cancel':
                $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-icon').addClass('dopbsp-canceled');
                $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-status-info').addClass('dopbsp-canceled')
                                                                                           .html(DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_STATUS_CANCELED'));
                break;
            case 'delete':
                $('#DOPBSP-reservation'+id).fadeOut(300, function(){
                    $(this).remove();
                    DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_DELETE_SUCCESS'));
                });
                break;
            case 'reject':
                $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-icon').addClass('dopbsp-rejected');
                $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-status-info').addClass('dopbsp-rejected')
                                                                                           .html(DOPBSPBackEnd.text('RESERVATIONS_RESERVATION_STATUS_REJECTED'));
                break;
        }
                
        /*
         * Display appropriate buttons.
         */
        $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-button-approve').css('display', action === 'cancel' || action === 'reject' ? 'block':'none');
        $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-button-cancel').css('display', action === 'approve' ? 'block':'none');
        $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-button-delete').css('display', action === 'cancel' || action === 'reject' ? 'block':'none');
        $('#DOPBSP-reservation'+id+' .dopbsp-reservation-head .dopbsp-button-reject').css('display', 'none');
    };
    
    return this.__construct();
};