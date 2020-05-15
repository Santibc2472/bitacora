
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : assets/js/backend.js
* File Version            : 1.1.5
* Created / Last Modified : 15 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end JavaScript class.
*/

var DOPBSPBackEnd = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables.
     */
    this.messagesTimeout = 0;

    /*
     * Constructor
     */
    this.__construct = function(){
        $(document).ready(function(){
            if (typeof DOPBSP_curr_page !== 'undefined'){
                switch (DOPBSP_curr_page){
                    case 'Addons':
                        DOPBSPBackEndAddons.display();
                        break;
                    case 'Amenities':
                        DOPBSPBackEndAmenities.display();
                        break;
                    case 'Calendars':
                        DOPBSPBackEndCalendars.display();
                        break;
                    case 'Coupons':
                        DOPBSPBackEndCoupons.display();
                        break;
                    case 'Dashboard':
                        DOPBSPBackEndDashboard.display();
                        break;
                    case 'Discounts':
                        DOPBSPBackEndDiscounts.display();
                        break;
                    case 'Emails':
                        DOPBSPBackEndEmails.display();
                        break;
                    case 'Extras':
                        DOPBSPBackEndExtras.display();
                        break;
                    case 'Fees':
                        DOPBSPBackEndFees.display();
                        break;
                    case 'Forms':
                        DOPBSPBackEndForms.display();
                        break;
                    case 'Locations':
                        DOPBSPBackEndLocations.init();
                        break;
                    case 'Models':
                        DOPBSPBackEndModels.display();
                        break;
                    case 'PRO':
                        DOPBSPBackEndPRO.display();
                        break;
                    case 'Reservations':
                        DOPBSPBackEndReservations.display();
                        break;
                    case 'Reviews':
                        DOPBSPBackEndReviews.display();
                        break;
                    case 'Rules':
                        DOPBSPBackEndRules.display();
                        break;
                    case 'Settings':
                        break;
                    case 'Smses':
                        DOPBSPBackEndSmses.display();
                        break;
                    case 'Templates':
                        DOPBSPBackEndTemplates.display();
                        break;
                    case 'Themes':
                        DOPBSPBackEndThemes.display();
                        break;
                    case 'Tools':
                        DOPBSPBackEndTools.display();
                        break;
                    case 'Translation':
                        if (DOPPrototypes.getCookie('DOPBSP-translation-redirect') === 'languages'){
                            DOPPrototypes.deleteCookie('DOPBSP-translation-redirect', '/');
                            DOPBSPBackEndLanguages.display();
                        }
                        else{
                            DOPBSPBackEndTranslation.display();
                        }
                        break;
                }
                
                DOPBSPBackEnd.rp();
            }
        });
        
        /*
         * Hide display "Go top" button.
         */
        $(document).scroll(function(){
            if ($(document).scrollTop() > 0){
                $('#DOPBSP-go-top').css('display', 'block');
            }
            else{
                $('#DOPBSP-go-top').css('display', 'none');
            }
        });
        
        /*
         * Resize events.
         */
        $(window).resize(function(){
            DOPBSPBackEnd.rp();
        });

        $('#collapse-menu').click(function(){
            DOPBSPBackEnd.rp();
        });
    };
    
    /*
     * Clear columns content.
     * 
     * @param no (Number): column number from which the clear will start
     */
    this.clearColumns = function(no){
        if (no <= 1){
            $('#DOPBSP-column1 .dopbsp-column-content').html('');
        }
        
        if (no <= 2){
            $('#DOPBSP-col-column2').removeClass('dopbsp-calendar');
            $('#DOPBSP-column2 .dopbsp-column-header').html('');
            $('#DOPBSP-column2 .dopbsp-column-content').html('');
        }
        
        if (no <= 3){
            $('#DOPBSP-column3 .dopbsp-column-header').html('');
            $('#DOPBSP-column3 .dopbsp-column-content').html('');       
        }
    };
    
    /*
     * Confirm an action.
     * 
     * @param message (String): confirmation message
     * @param yesAction (String): function to be executed if you click "Yes"
     * @param noAction (String): function to be executed if you click "No"
     */
    this.confirmation = function(message,
                                 yesAction,
                                 noAction,
                                 messageFallback){
        var text = DOPBSPBackEnd.text(message,
                               messageFallback);
        
        yesAction = yesAction === undefined ? '':yesAction;
        noAction = noAction === undefined ? '':noAction;
        
        $('#DOPBSP-messages-box').removeClass('dopbsp-active')
                                 .removeClass('dopbsp-active-info')
                                 .removeClass('dopbsp-error')
                                 .removeClass('dopbsp-success');
        $('#DOPBSP-messages-box .dopbsp-message').html('');
        
        $('#DOPBSP-messages-background').addClass('dopbsp-active');
        $('#DOPBSP-confirmation-box').addClass('dopbsp-active');
        $('#DOPBSP-confirmation-box .dopbsp-message').html(text);
        
        $('#DOPBSP-confirmation-box .dopbsp-button-yes').unbind('click');
        $('#DOPBSP-confirmation-box .dopbsp-button-yes').bind('click', function(){
            $('#DOPBSP-messages-background').removeClass('dopbsp-active');
            $('#DOPBSP-confirmation-box').removeClass('dopbsp-active');
            $('#DOPBSP-confirmation-box .dopbsp-message').html('');
            
            if (yesAction !== ''){
                eval(yesAction);
            }
        });
        
        $('#DOPBSP-confirmation-box .dopbsp-button-no').unbind('click');
        $('#DOPBSP-confirmation-box .dopbsp-button-no').bind('click', function(){
            $('#DOPBSP-messages-background').removeClass('dopbsp-active');
            $('#DOPBSP-confirmation-box').removeClass('dopbsp-active');
            $('#DOPBSP-confirmation-box .dopbsp-message').html('');
            
            if (noAction !== ''){
                eval(noAction);
            }
        });
    };
    
    /*
     * Set administration area styles depending on wrapper size.
     */
    this.rp = function(){
        var $admin = $('.DOPBSP-admin'),
        w =  $admin.width();
        
        $admin.removeClass('dopbsp-notebook')
              .removeClass('dopbsp-tablet')
              .removeClass('dopbsp-phone')
              .removeClass('dopbsp-responsive-hidden');
      
        if (w <= 740){
            $admin.addClass('dopbsp-phone');
        }
        else if (w <= 1024){
            $admin.addClass('dopbsp-tablet');
        }
        else if (w <= 1370){
            $admin.addClass('dopbsp-notebook');
        }
        
        if (w < 300){
            $admin.addClass('dopbsp-responsive-hidden');
        }
    };
    
    /*
     * Get translation textt.
     * 
     * @param key (String): translation key
     * 
     * @return translation text
     */
    this.text = function(key,
                         fallback){
        fallback = fallback === undefined ? '!':fallback;
        
        return DOPBSP_translation_text[key] === undefined ? fallback:DOPBSP_translation_text[key];
    };
    
    /*
     * Toggle boxes.
     * 
     * @param id (String): box ID
     */
    this.toggleBox = function(id){
        if ($('#DOPBSP-box-button-'+id).parent().hasClass('dopbsp-display')){
            $('#DOPBSP-box-button-'+id).parent()
                                       .removeClass('dopbsp-display')
                                       .addClass('dopbsp-hide');
            $('#DOPBSP-box-'+id).stop(true, false)
                                .fadeIn(300, function(){
            });
        }
        else{
            $('#DOPBSP-box-'+id).stop(true, false)
                                .fadeOut(300, function(){
                $('#DOPBSP-box-button-'+id).parent()
                                           .removeClass('dopbsp-hide')
                                           .addClass('dopbsp-display');
            });
        }
    };
    
    /*
     * Toggle inputs groups.
     * 
     * @param id (String): inputs groups ID
     */
    this.toggleInputs = function(id){
        if ($('#DOPBSP-inputs-button-'+id).parent().hasClass('dopbsp-display')){
            $('#DOPBSP-inputs-button-'+id).parent()
                                          .removeClass('dopbsp-display')
                                          .addClass('dopbsp-hide');
            $('#DOPBSP-inputs-'+id).stop(true, false)
                                   .fadeIn(300, function(){
            });
        }
        else{
            $('#DOPBSP-inputs-'+id).stop(true, false)
                                   .fadeOut(300, function(){
                $('#DOPBSP-inputs-button-'+id).parent()
                                              .removeClass('dopbsp-hide')
                                              .addClass('dopbsp-display');
            });
        }
    };
    
    /*
     * Toggle messages.
     * 
     * @param action (String): box action
     *                         "active" informs you that an action is taking place and blocks you from taking other actions
     *                         "active-info" informs you that an action is taking place, but doesn't block you from taking other actions
     *                         "error" error message
     *                         "success" success message
     * @param message (String): the message
     */
    this.toggleMessages = function(action, 
                                   message){
        action = action === undefined ? 'none':action;
        message = message === undefined ? '':message;
        
        clearTimeout(this.messagesTimeout);
        $('#DOPBSP-messages-background').removeClass('dopbsp-active');
        $('#DOPBSP-messages-box').removeClass('dopbsp-active')
                                 .removeClass('dopbsp-active-info')
                                 .removeClass('dopbsp-error')
                                 .removeClass('dopbsp-success')
                                 .addClass('dopbsp-'+action);
        $('#DOPBSP-messages-box .dopbsp-message').html(message);
            
        switch (action){
            case 'active':
                $('#DOPBSP-messages-background').addClass('dopbsp-active');
                break;
            case 'success':
                this.messagesTimeout = setTimeout(function(){
                     $('#DOPBSP-messages-box').removeClass('dopbsp-success');
                     $('#DOPBSP-messages-box .dopbsp-message').html('');
                }, 2000);
                break;
        }
    };
    
    return this.__construct();
};