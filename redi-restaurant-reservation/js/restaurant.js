function addSpace(n) {
    var rx = /(\d+)(\d{3})/;
    return String(n).replace(/^\d+/, function (w) {
        while (rx.test(w)) {
            w = w.replace(rx, '$1 $2');
        }
        return w;
    });
}

function toggleWaitList()
{
    var today = new Date();
    today.setHours(0);
    today.setMinutes(0);
    today.setSeconds(0);

    var startDate = jQuery('#redi-restaurant-startDate');

    if (Date.parse(today) == Date.parse(startDate.datepicker('getDate'))) 
    {
        jQuery('[name="message-waitlist-form"]').hide();
    } 
    else 
    {
        jQuery('[name="message-waitlist-form"]').show();
    }
}


jQuery(function () 
{
    jQuery('#step1button').show();

    jQuery('.disabled').on('click', function (e) {
        e.preventDefault();
    });

    jQuery('#notyou').on('click', function (event) {
        event.preventDefault();
        jQuery('#returned_user').hide();
        jQuery('#name_phone_email_form').show();
    });
        

    jQuery('.redi-restaurant-duration-button').on('click', function (e) {

        jQuery("#duration").val(this.value);

        jQuery('.redi-restaurant-duration-button').each(function () {
            jQuery(this).removeAttr('select');
        });

        jQuery(this).attr('select', 'select');

        jQuery('#step1button').attr('disabled', false);

        var day1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getDate();
        var month1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getMonth() + 1;
        var year1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getFullYear();
        var fullDate = year1 + '-' + zeroFill(month1) + '-' + zeroFill(day1)

        if (timeshiftmode === 'byshifts') {
            step1call(fullDate)
        } else {
            hideSteps();
        }

        return false;
    });

    updatePersons();

    function hideSteps() {
        jQuery('#step2').hide('slow'); // if user clicks again first button we hide the other steps
        jQuery('#step3').hide('slow');
        jQuery('#step2busy').hide('slow');
        
        if (hidesteps) {
            jQuery('#step1busy').hide();
        }
    }

    function updatePersons() {
        //maxPersonsOverride
        if (typeof maxPersonsOverride === 'function') {
            maxPersonsOverride();
        }
    }

    var updateTime = function () {
        if (timepicker == 'dropdown') {

            jQuery('#redi-restaurant-startTime-alt').val(jQuery('#redi-restaurant-startHour').val() + ':' + jQuery('#redi-restaurant-startMinute').val()); // update time in hidden field
            updatePersons();
        }
        hideSteps();
    };

    if (timepicker == 'dropdown') {
        jQuery('#redi-restaurant-startTime-alt').val(jQuery('#redi-restaurant-startHour').val() + ':' + jQuery('#redi-restaurant-startMinute').val()); // update time in hidden field
    }


    jQuery('#redi-restaurant-startHour').change(updateTime);
    jQuery('#redi-restaurant-startMinute').change(updateTime);
    jQuery('#persons, #children').change(function () {

        if (jQuery(this).val() === 'group') {
            jQuery('#step1button').attr('disabled', true);
            jQuery('#large_groups_message').show('slow');
            jQuery('#step1buttons').hide('slow');
            if (!hidesteps) {
                jQuery('#step2').hide();
            }
        } else {
            jQuery('#step1button').attr('disabled', false);
            jQuery('#large_groups_message').hide('slow');
            var day1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getDate();
            var month1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getMonth() + 1;
            var year1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getFullYear();
            var fullDate = year1 + '-' + zeroFill(month1) + '-' + zeroFill(day1)
            if (timeshiftmode === 'byshifts') {
                step1call(fullDate)
            } else {
                hideSteps();
                jQuery('#redi-restaurant-startDateISO').val(fullDate);
            }
        }

    });

    if (jQuery.timepicker.regional[datepicker_locale] !== undefined) {
        jQuery.timepicker.setDefaults(jQuery.timepicker.regional[datepicker_locale]);
    } else {
        jQuery.timepicker.setDefaults(jQuery.timepicker.regional['']);
    }

    if (jQuery.datepicker.regional[datepicker_locale] !== undefined) {
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional[datepicker_locale.substring(0, 2)]);
    } else {
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional['']);
    }

    jQuery('#redi-restaurant-startTime').timepicker({
        stepMinute: 15,
        timeFormat: timepicker_time_format,
        onClose: function () {
            hideSteps();
            updatePersons();
        },
        altField: '#redi-restaurant-startTime-alt',
        altFieldTimeOnly: false,
        altTimeFormat: 'HH:mm'
    });

    jQuery('#redi-restaurant-startDate').change(function () {
        var day1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getDate();
        var month1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getMonth() + 1;
        var year1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getFullYear();

        jQuery('#redi-restaurant-startDateISO').val(year1 + '-' + zeroFill(month1) + '-' + zeroFill(day1));
    });

    var startDateISO = new Date(jQuery('#redi-restaurant-startDateISO').val());

    jQuery('#redi-restaurant-startDate').datepicker({
        beforeShowDay: function (date) {
            let d = jQuery.datepicker.formatDate('yy-mm-dd', date);

            for (let i = 0; i < disabled_dates.length; i++)
            {
                if (disabled_dates[i].date == d || d < jQuery.datepicker.formatDate('yy-mm-dd', startDateISO))
                {   
                    if(jQuery.datepicker.formatDate('yy-mm-dd', startDateISO) == d){
                        startDateISO.setDate(startDateISO.getDate() + 1);
                    }
                    return [false, '', disabled_dates[i].reason];
                }
            }        

            return [true, '', ''];
        },
      
        dateFormat: date_format,
        minDate: new Date(),
        maxDate: maxDate,
        onSelect: function () {
            if (timeshiftmode === 'byshifts')
            {
                getTimeByDate();
            }
        }
    });
	
    startDateISO.setMinutes(startDateISO.getTimezoneOffset());

    var data = {
        action: 'redi_restaurant-submit',
        get: 'formatDate',
        startDate: Date.parse(startDateISO) / 1000,
        lang: locale,
        apikeyid: apikeyid
    };
    jQuery.post(redi_restaurant_reservation.ajaxurl, data, function(response) {
        jQuery('#redi-restaurant-startDate').datepicker("setDate", startDateISO);
        jQuery('#redi-restaurant-startDate').val(response);

        if (timeshiftmode === 'byshifts')
        {
            getTimeByDate();
        }

        getCustomFields();
        toggleWaitList();
    });

    jQuery(document).on('click', '.redi-restaurant-time-button', function () {
        jQuery('.redi-restaurant-time-button').each(function () {
            jQuery(this).removeAttr('select');
        });

        jQuery(this).attr('select', 'select');

        jQuery('#redi-restaurant-startTimeHidden').val(jQuery(this).val());

        if (hidesteps) {
            jQuery('#step2').hide();
            jQuery('#step3').show();
        } else {
            jQuery('#step3').show('slow');
        }
        jQuery('#UserName').focus();
        jQuery('#step3errors').hide();

        return false;
    });
    jQuery(document).on('click', '#redi-restaurant-step3', function () {
        var error = '';
        if (jQuery('#UserName').val() === '') {
            error += redi_restaurant_reservation.name_missing + '<br/>';
        }
        if (jQuery('#UserEmail').val() === '') {
            error += redi_restaurant_reservation.email_missing + '<br/>';
        }
        
        if (itiUserPhone.getNumber() === '') {
            error += redi_restaurant_reservation.phone_missing + '<br/>';
        }
        else if (!validatePhone(itiUserPhone.getNumber())) 
        {
            error += redi_restaurant_reservation.phone_not_valid + '<br/>';
        }

        if (jQuery('.g-recaptcha').length && !document.querySelector('.g-recaptcha-response').value)
        {
            error += redi_restaurant_reservation.captcha_not_valid + '<br/>';
        }

        jQuery('.field_required').each(function () 
        {
            if (jQuery(this).attr('type') === 'checkbox' && !jQuery(this).is(':checked') || jQuery(this).attr('type') === 'text' && jQuery(this).val() === '') {
                error += jQuery('#' + this.id + '_message').attr('value') + '<br/>';
            }
        });

        if (error) {
            jQuery('#step3errors').html(error).show('slow');
            return false;
        }
        var data = {
            action: 'redi_restaurant-submit',
            get: 'step3',
            startDate: jQuery('#redi-restaurant-startDate').val(),
            startTime: jQuery('#redi-restaurant-startTimeHidden').val(),
            persons: jQuery('#persons').val(),
            children: jQuery('#children').val(),
            UserName: jQuery('#UserName').val(),
            UserEmail: jQuery('#UserEmail').val(),
            UserComments: jQuery('#UserComments').val(),
            UserPhone: jQuery('#UserPhone').val(),
            placeID: jQuery('#placeID').val(),
            lang: locale,
            duration: jQuery('#duration').val(),
            apikeyid: apikeyid
        };

        var custom_fields = jQuery("[name^='field_']");

        for (var index = 0; index < custom_fields.length; ++index) {
            if (jQuery(custom_fields[index]).attr('type') === 'checkbox' && jQuery(custom_fields[index]).is(':checked'))
            {
                data[custom_fields[index].id] = 'on';
            } 
            else 
            {
                data[custom_fields[index].id] = jQuery(custom_fields[index]).val();
            }
        }

        jQuery('#step3load').show();
        jQuery('#step3errors').hide('slow');
        jQuery('#redi-restaurant-step3').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-step3').attr('disabled', false);
            jQuery('#step3load').hide();
            if (response['Error']) {
                jQuery('#step3errors').html(response['Error']).show('slow');
            } else {
                ga_event('Reservation confirmed', '');
                
                // redirect to new page is specified
                if (redirect_to_confirmation_page.length > 0)
                {
                    jQuery(location).attr('href', redirect_to_confirmation_page + "?reservation_id=" + addSpace(response['ID']));
                }
                else
                {
                    // show confirmation block
                    jQuery('#step1').hide('slow');
                    jQuery('#step2').hide('slow');
                    jQuery('#step3').hide('slow');
                    jQuery('#social').hide('slow');
                    jQuery('#step4').show('slow'); //success message
                    jQuery('#reservation-id').html(addSpace(response['ID']));
                    jQuery('html, body').animate({scrollTop: jQuery("#redi-reservation").offset().top}, 'slow');
                }
            }
        }, 'json');
        return false;
    });
    jQuery(document).on('click', '#step1button', function () {
        if (timeshiftmode === 'byshifts') {
            step1call();
        } else {
            jQuery('#step1button').attr('disabled', true);
            var start_date = jQuery('#redi-restaurant-startDate').datepicker('getDate');
            if (start_date !== null) {
                var day1 = start_date.getDate();
                var month1 = start_date.getMonth() + 1;
                var year1 = start_date.getFullYear();
                var fullDate = year1 + '-' + month1 + '-' + day1;
                step1call(fullDate);
            } else {
                jQuery('#redi-restaurant-startDate').addClass('redi-invalid');
            }
            jQuery('#step1button').attr('disabled', false);
        }
        return false;
    });

    jQuery('#placeID').change(function () {

        if (hidesteps){
            jQuery('#step1buttons').hide('slow');
        }

        jQuery('#step2').hide('slow'); // if user clicks again first button we hide the other steps
        jQuery('#step3').hide('slow');
        jQuery('#step1errors').hide('slow');

        var data = {
            action: 'redi_restaurant-submit',
            get: 'get_disabled_dates',
            placeID: jQuery('#placeID').val(),
            lang: locale,
            apikeyid: apikeyid
        };

        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            response = JSON.parse(response);
            disabled_dates = response.disabledDates;
            let startDate = new Date(response.startDate);
            
            startDate.setMinutes(startDate.getTimezoneOffset());
            jQuery('#redi-restaurant-startDate').datepicker("setDate", startDate);
            jQuery('#redi-restaurant-startDate').datepicker( "option", "minDate", startDate);  
            jQuery('#redi-restaurant-startDate').val(response.startDate);    
            getCustomFields();		
            getTimeByDate();
        });
    });

    function step1call(fullDate) {
        if (jQuery('#persons').val() === 'group') return;
        hideSteps();

        jQuery('#redi-restaurant-startDateISO').val(fullDate);
        jQuery('#step2').hide('slow'); // if user clicks again first button we hide the other steps
        jQuery('#step3').hide('slow');
        jQuery('#step1load').show();
        jQuery('#step1errors').hide('slow');
        jQuery('#step1times').hide();
        jQuery('#all_busy_error').hide();
        var data = {
            action: 'redi_restaurant-submit',
            get: 'step1',
            placeID: jQuery('#placeID').val(),
            startTime: jQuery('#redi-restaurant-startTime-alt').val(),
            startDateISO: jQuery('#redi-restaurant-startDateISO').val(),
            duration: jQuery("#duration").val(),
            persons: +jQuery('#persons').val() + (jQuery('#children').val() ? +jQuery('#children').val() : 0),
            lang: locale,
            timeshiftmode: timeshiftmode,
            apikeyid: apikeyid
        };

        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#step1load').hide();
            jQuery('#buttons').html('');

            if (response['Error'] !== undefined) {
                if (waitlist == 1) {
                    jQuery('#step2busy').show();
                }
                else{
                  jQuery('#step1errors').html(response['Error']).show('slow');  
                }
            } else if (response["all_booked_for_this_duration"]) {
                jQuery('#step1errors').html(redi_restaurant_reservation.error_fully_booked).show('slow');
            } else {
                if (hidesteps) {
                    jQuery('#step1times').show();
                }
                if (response['alternativeTime'] !== undefined) {
                    switch (response['alternativeTime']) {
                        case 1: //AlternativeTimeBlocks see class AlternativeTime::
                        //pass thought
                        case 2: //AlternativeTimeByShiftStartTime

                            var all_busy = true;
                            for (var res in response) {
                                if (response[res] !== undefined) {

                                    jQuery('#buttons').append(
                                        '<button ' + (response[res]['Available'] ? '' : 'title="' + redi_restaurant_reservation.tooltip +'"') + ' class="redi-restaurant-time-button button ' + (response[res]['Available'] ? '' : 'disabled') + '" value="' + response[res]['StartTimeISO'] + '" ' + //(response[res]['Available'] ? '' : 'disabled="disabled"') +
                                        ' ' + (response[res]['Select'] ? 'select="select"' : '') +
                                        '>' + response[res]['StartTime'] + '</button>'
                                    );
                                }
                                if (response[res]['Available']) all_busy = false;
                            }
                            display_all_busy(all_busy);
                            break;
                        case 3: //AlternativeTimeByDay
                            var all_busy = true;
                            var current = 0;
                            var step1buttons_html = '';
                            jQuery('#step1buttons_html').html(step1buttons_html).hide();
                            
                            for (var availability in response) 
                            {
                                                                
                                if (response[availability]['Name'] !== undefined) {
                                    var html = '';

                                    if (!hidesteps) {
                                        if (response[availability]['Name']) {
                                            html += response[availability]['Name'] + ':</br>';
                                        }
                                    }

                                    if (hidesteps) {
                                        if (response[availability]['Name'] === null) {
                                            response[availability]['Name'] = redi_restaurant_reservation.next;
                                        }
                                        step1buttons_html += '<input id="time_' + (current) + '" value="' + response[availability]['Name'] + '" class="redi-restaurant-button button ';
                                        html += '<span class="opentime" id="opentime_' + (current) + '" style="display: none">';
                                    }
                                    var current_button_busy = true;
                                    for (var current_button_index in response[availability]['Availability']) {

                                        var b = response[availability]['Availability'][current_button_index];

                                        html += '<button '
                                            + (b['Available'] ? '' : 'disabled="disabled"')
                                            + (b['Available'] ? '' : ' title="' + redi_restaurant_reservation.tooltip + '"') + ' class="redi-restaurant-time-button button ' + (b['Available'] ? '' : 'disabled') + '" value="' + b['StartTimeISO'] + '" ' +
                                            ' ' + (b['Select'] ? 'select="select"' : '') + '>'
                                            + b['StartTime'] + '</button>';
                                        if (b['Available']) {
                                            all_busy = false;
                                            current_button_busy = false;
                                        }
                                    }

                                    if(current_button_busy){
                                        let step2busyClone = jQuery('#step2busy').clone();
                                        if(!step2busyClone.hasClass('not-waitlist')){
                                            step2busyClone.removeAttr('id');
                                            step2busyClone.css("display", "block");
                                            html += step2busyClone.get(0).outerHTML;
                                        }
                                    }
                                    
                                    html += '<br clear="all">';
                                    if (hidesteps) {
                                        html += '</span>';
                                    }

                                    jQuery('#buttons').append(html);
                                    if (hidesteps) {
                                        if (current_button_busy) {
                                            step1buttons_html += 'disabled"'; //add class
                                            step1buttons_html += ' title="' + redi_restaurant_reservation.tooltip + '"';
                                        } else {
                                            step1buttons_html += 'available"'; //close class bracket
                                        }
                                        step1buttons_html += ' type="submit">';
                                    }
                                }
                                current++;
                            }
                            jQuery('#buttons').append('</br>');
                            if (jQuery('#persons').val() === 'group') {
                                jQuery('#step1button').attr('disabled', true);
                                jQuery('#large_groups_message').show('slow');
                                jQuery('#step1buttons').hide('slow');
                                if (!hidesteps) {
                                    jQuery('#step2').hide();
                                }
                            } else {
                                jQuery('#step1buttons').html(step1buttons_html).show();
                                display_all_busy(all_busy);
                            }
                            break;
                    }
                } else {
                    for (res in response) {
                        jQuery('#buttons').append(
                            '<button class="redi-restaurant-button redi-restaurant-time-button normal" value="' +
                            response[res]['StartTimeISO'] + '" ' +
                            (response[res]['Available'] ? '' : 'disabled="disabled"') +
                            ' ' + (response[res]['Select'] ? 'select="select"' : '') +
                            '>' + response[res]['StartTime'] + '</button>'
                        );
                    }
                }


                jQuery('#redi-restaurant-startTimeHidden').val(response['StartTimeISO']);
                if (!hidesteps) {
                    jQuery('#step2').show('slow');
                    // if selected time is available make it bold and show fields
                    jQuery('.redi-restaurant-time-button').each(function () {
                        if (jQuery(this).attr('select')) {
                            jQuery(this).click();
                        }
                    });
                }

                jQuery('#UserName').focus();
            }
            
            jQuery('.link-waitlist-form').off("click");
            jQuery('.link-waitlist-form').click(function() {
                clickWaitListForm();
            });        
        }, 'json');
    }

    function display_all_busy(hide) {
        jQuery('.redi-restaurant-button').tooltip();
        jQuery('.redi-restaurant-time-button').tooltip();
        if (hide) {
            jQuery('#step1times').hide();
            if (hidesteps) {
                jQuery('#step1busy').show();
            } else {
                jQuery('#buttons').hide();
                jQuery('#step2busy').show();
            }
        } else {
            jQuery('#step2busy').hide();
            jQuery('#step1times').show();
            if (hidesteps) {
                jQuery('#step1busy').hide();
            } else {
                jQuery('#buttons').show();
                jQuery('#step2busy').hide();
            }
        }


    }

    function ga_event(event, comment) {
        if (typeof _gaq !== 'undefined') {
            _gaq.push(['_trackEvent', 'ReDi Restaurant Reservation', event, comment]);
        }
    }
	
	function getTimeByDate(){
		var startDate = jQuery('#redi-restaurant-startDate');
            var day1 = startDate.datepicker('getDate').getDate();
            var month1 = startDate.datepicker('getDate').getMonth() + 1;
            var year1 = startDate.datepicker('getDate').getFullYear();
            var fullDate = year1 + '-' + zeroFill(month1) + '-' + zeroFill(day1);
            if (timeshiftmode === 'byshifts') {
                step1call(fullDate)
            } else {
                hideSteps();
                jQuery('#redi-restaurant-startDateISO').val(fullDate);
                step1call();
            }
            updatePersons();
            toggleWaitList();
    }
    
    function clickWaitListForm()
    {
        jQuery('#redi-reservation').toggle("slide");
        jQuery('#step2busy').hide();
        jQuery('#step1errors').hide();
        jQuery('.waitlist-form').toggle("slide");
        var valueDate = jQuery('#redi-restaurant-startDate').val();
        jQuery('#redi-waitlist-startDate').val(valueDate);
        jQuery('#waitlist-startDate-label').html(valueDate);
        var valuePersons = jQuery('#persons').val();
        jQuery('#waitlist-persons-label').html(valuePersons);
        jQuery('#waitlist-persons').val(valuePersons);
        var DateISO = jQuery('#redi-restaurant-startDateISO').val();
        jQuery('#redi-waitlist-startDateISO').val(DateISO);
    }
	
	function getCustomFields(){		
		var data = {
            action: 'redi_restaurant-submit',
            get: 'get_custom_fields',
            placeID: jQuery('#placeID').val(),
            lang: locale,
            apikeyid: apikeyid
        };
		
		jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
			jQuery('#custom_fields_container').html(JSON.parse(response))
        });
	}

    //Cancel reservation
    jQuery(document).on('click', '#cancel-reservation', function () {
        jQuery('#redi-reservation').slideUp();
        jQuery('#cancel-reservation-div').slideDown();
    });

    //Modify reservation
    jQuery(document).on('click', '#modify-reservation', function () {
        jQuery('#redi-reservation').slideUp();
        jQuery('#modify-reservation-div').slideDown();
    });

    jQuery(document).on('click', '.back-to-reservation', function () {
        jQuery('#redi-reservation').slideDown();
        jQuery('#cancel-reservation-div').slideUp();
        jQuery('#modify-reservation-div').slideUp();
        jQuery('#update-reservation-div').slideUp();
        jQuery('#cancel-reservation-form').slideDown();
        jQuery('#modify-reservation-form').slideDown();
        jQuery('#cancel-success').slideUp();
    });

    function getParameterByName(name) {
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.hash);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }

    jQuery(window).on("load", function () {

        if (Object.values(location.hash.split('?')).indexOf('#cancel') > -1) {
                jQuery('#cancel-reservation-div').slideDown();
                jQuery('#redi-reservation').slideUp();
                jQuery('#redi-restaurant-cancelID').val(getParameterByName("reservation"));
                jQuery('#redi-restaurant-cancelEmail').val(getParameterByName("personalInformation"));
        }

        if (Object.values(location.hash.split('?')).indexOf('#modify') > -1) {
            jQuery('#modify-reservation-div').slideDown();
            jQuery('#redi-reservation').slideUp();
            jQuery('#redi-restaurant-modifyID').val(getParameterByName("reservation"));
            jQuery('#redi-restaurant-modifyEmail').val(getParameterByName("personalInformation"));
        }

    });

    function validatePhone(phone) {
        var re = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g
        return re.test(phone);
    }

    function validateTime(time)
    {
        if (time === '') return true;

        var t = moment(time, ["HH", "hh", "hh A", "HH:mm", "hh:mm", "hh:mm A"]);

        return t.isValid();
    }

    // reservation cancel
    jQuery(document).on('click', '#redi-restaurant-cancel', function () {
        var error = '';

        if (jQuery('#redi-restaurant-cancelID').val() === '') {
            error += redi_restaurant_reservation.id_missing + '<br/>';
        }

        if (jQuery('#redi-restaurant-cancelEmail').val() === '') 
        {
            error += redi_restaurant_reservation.personalInf + '<br/>';
        } 

        if (jQuery('#redi-restaurant-cancelReason').val() === '') {
            error += redi_restaurant_reservation.reason_missing + '<br/>';
        }

        if (error) {
            jQuery('#cancel-errors').html(error).show('slow');
            return false;
        }
        //Ajax
        var data = {
            action: 'redi_restaurant-submit',
            get: 'cancel',
            ID: jQuery('#redi-restaurant-cancelID').val(),
            personalInformation: jQuery('#redi-restaurant-cancelEmail').val(),
            Reason: jQuery('#redi-restaurant-cancelReason').val(),
            lang: locale,
            apikeyid: apikeyid
        };
        jQuery('#cancel-errors').slideUp();
        jQuery('#cancel-success').slideUp();
        jQuery('#cancel-load').show();
        jQuery('#redi-restaurant-cancel').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-cancel').attr('disabled', false);
            jQuery('#cancel-load').hide();
            if (response['Error']) {
                jQuery('#cancel-errors').html(response['Error']).show('slow');
            } else {
                jQuery('#cancel-success').slideDown();
                jQuery('#cancel-errors').slideUp();
                jQuery('#cancel-reservation-form').slideUp();
                jQuery('html, body').animate({scrollTop: jQuery("#redi-reservation").offset().top}, 'slow');
                //clear form
                jQuery('#redi-restaurant-cancelID').val('');
                jQuery('#redi-restaurant-cancelEmail').val('');
                jQuery('#redi-restaurant-cancelReason').val('');
            }
        }, 'json');
        return false;
    });

    //reservation modify
    jQuery(document).on('click', '#redi-restaurant-modify', function () {
        var error = '';

        if (jQuery('#redi-restaurant-modifyID').val() === '') {
            error += redi_restaurant_reservation.id_missing + '<br/>';
        }

        if (jQuery('#redi-restaurant-modifyEmail').val() === '') 
        {
            error += redi_restaurant_reservation.personalInf + '<br/>';
        } 

        if (error) {
            jQuery('#modify-errors').html(error).show('slow');
            return false;
        }
        //Ajax
        var data = {
            action: 'redi_restaurant-submit',
            get: 'modify',
            ID: jQuery('#redi-restaurant-modifyID').val(),
            personalInformation: jQuery('#redi-restaurant-modifyEmail').val(),
            lang: locale,
            apikeyid: apikeyid
        };
        jQuery('#modify-errors').slideUp();
        jQuery('#modify-load').show();
        jQuery('#redi-restaurant-modify').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-modify').attr('disabled', false);
            jQuery('#modify-load').hide();

            let reservation = response.reservation;

            if (reservation['Error']) {
                jQuery('#modify-errors').html(reservation['Error']).show('slow');
            } else {
                jQuery('#update-success').slideUp();
                jQuery('#modify-reservation-div').slideUp();
                jQuery('#update-reservation-div').slideDown();
                jQuery('#update-reservation-form').slideDown();

                jQuery('#updatePersons').val(reservation['Persons']);
                jQuery('#updateUserName').val(reservation['Name']);
                jQuery('#updateUserEmail').val(reservation['Email']);
                jQuery('#updateUserComments').val(reservation['Comments']);   
                jQuery('#redi-restaurant-updateID').val(jQuery('#redi-restaurant-modifyID').val());
                jQuery('#updateTo').val(reservation['To']);
                jQuery('#updateFrom').val(reservation['From']);
                jQuery('#updateDateFrom').text(response.startDate);
                jQuery('#updateTimeFrom').text(response.startTime);
                jQuery('#updatePlaceReferenceId').val(reservation['PlaceReferenceId']);  
                jQuery('#updateUserPhone').val(reservation['Phone']);           
                itiUpdateUserPhone.setNumber(reservation['Phone']);

                //clear form
                jQuery('#redi-restaurant-modifyID').val('');
                jQuery('#redi-restaurant-modifyEmail').val('');
            }
        }, 'json');
        return false;
    });

    //reservation update
    jQuery(document).on('click', '#redi-restaurant-update', function () {
        var error = '';

        if (jQuery('#updateUserName').val() == '') {
            error += redi_restaurant_reservation.name_missing + '<br/>';
        }
        if (jQuery('#updateUserEmail').val() == '') {
            error += redi_restaurant_reservation.email_missing + '<br/>';
        }     
        if (itiUpdateUserPhone.getNumber() == '') {
            error += redi_restaurant_reservation.phone_missing + '<br/>';
        }
        else if (!validatePhone(itiUpdateUserPhone.getNumber())) 
        {
            error += redi_restaurant_reservation.phone_not_valid + '<br/>';
        }

        if (error) {
            jQuery('#update-errors').html(error).show('slow');
            return false;
        }
        //Ajax
        var data = {
            action: 'redi_restaurant-submit',
            get: 'update',
            ID: jQuery('#redi-restaurant-updateID').val(),
            PlaceReferenceId: jQuery('#updatePlaceReferenceId').val(),
            Quantity: jQuery('#updatePersons').val(),
            UserName: jQuery('#updateUserName').val(),
            UserPhone: jQuery('#updateUserPhone').val(),
            UserEmail: jQuery('#updateUserEmail').val(),
            UserComments: jQuery('#updateUserComments').val(),
            StartTime: jQuery('#updateFrom').val(),
            EndTime: jQuery('#updateTo').val(),
            lang: locale,
            apikeyid: apikeyid
        };

        jQuery('#update-errors').slideUp();
        jQuery('#update-success').slideUp();
        jQuery('#update-load').show();
        jQuery('#redi-restaurant-update').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-update').attr('disabled', false);
            jQuery('#update-load').hide();
 
            if (response['Error']) {
                jQuery('#update-errors').html(response['Error']).show('slow');
            } else {
                jQuery('#update-reservation-form').slideUp();
                jQuery('#update-success').slideDown();
                jQuery('html, body').animate({scrollTop: jQuery("#redi-reservation").offset().top}, 'slow');

                //clear form           
                jQuery('#updatePersons').val('');
                jQuery('#updateDateFrom').text('');
                jQuery('#updateTimeFrom').text('');
                jQuery('#updateUserName').val('');
                jQuery('#updateUserPhone').val('');
                jQuery('#updateUserEmail').val('');
                jQuery('#updateUserComments').val('');
            }
        }, 'json');
        return false;
    });

    jQuery(document).on('click', '.available', function (event) {
        event.preventDefault();
        jQuery('#step1').hide();
        jQuery('#step2').show();
        jQuery('#open' + this.id).show();
    });

    jQuery(document).on('click', '#step2prev', function (event) {
        event.preventDefault();
        jQuery('#step1').show();
        jQuery('#step2').hide();
        jQuery('.opentime').each(function () {
            jQuery(this).hide();
        });
    });

    jQuery(document).on('click', '#step3prev', function (event) {
        event.preventDefault();
        jQuery('#step3').hide();
        jQuery('#step2').show();
    });

    jQuery(document).on('click', '#redi-waitlist-submit', function () {
        
		var error = '';
        
        if (!validateTime(jQuery('#waitlist-Time').val())) {
            error += redi_restaurant_reservation.time_not_valid + '<br/>';
        }

        if (jQuery('#waitlist-UserName').val() === '') {
            error += redi_restaurant_reservation.name_missing + '<br/>';
        }
        
		if (jQuery('#waitlist-UserEmail').val() === '') {
            error += redi_restaurant_reservation.email_missing + '<br/>';
        }

		if (waitlist_itiUserPhone.getNumber() === '') {
            error += redi_restaurant_reservation.phone_missing + '<br/>';
        }
        else if (!validatePhone(waitlist_itiUserPhone.getNumber()))
        {
            error += redi_restaurant_reservation.phone_not_valid + '<br/>';
        }

        jQuery('.waitlist_field_required').each(function () {
            if (jQuery(this).attr('type') === 'checkbox' && !jQuery(this).is(':checked')) {
                error += jQuery('#' + this.id + '_message').attr('value') + '<br/>';
            }
        });

        if (error) {
            jQuery('#waitlistload').hide('slow');
            jQuery('#wait-list-error').html(error).show('slow');
            return false;
        }
                        
        jQuery('#waitlistload').show();
        jQuery('#wait-list-error').html(error).hide('slow');

        var data = {
            action: 'redi_waitlist-submit',
            get: 'waitlist',
            'Date': jQuery('#redi-waitlist-startDateISO').val(),
            'Guests': jQuery('#waitlist-persons').val(),
            'Name': jQuery('#waitlist-UserName').val(),
            'Email': jQuery('#waitlist-UserEmail').val(),
            'Phone': jQuery('#waitlist-UserPhone').val(),
            'placeID': jQuery('#waitlist-placeID').val(),
            'Time':jQuery('#waitlist-Time').val()
        };

        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response, success) {
            jQuery('#waitlistload').hide('slow');       
        }, 'json').done(function(data, statusText, xhr){
            var status = xhr.status;
            var head = xhr.responseJSON['Error'];
             if (status == 200) {
                if (data['Error']) {
                    jQuery('#wait-list-error').html(head).show('slow');
                }
                else{
                    jQuery('#wait-list-error').hide('slow');
                    jQuery('#redi-waitlist-form').hide('slow');
                    jQuery('#wait-list-success').show('slow');
                }
            }
            if (status == 500) {
                var Error = 'Wait List does not work at the moment, please try again later or contact restaurant directly.';
                jQuery('#wait-list-error').html(Error).show('slow');
            }
            if (status == 400) {
                jQuery('#wait-list-error').html(head).show('slow');
            }
        });

        return false;
    });

    // intl-tel-input
    var itiUserPhone = get_tel_input(document.querySelector("#intlTel"));
    var waitlist_itiUserPhone = get_tel_input(document.querySelector("#waitlist-intlTel"));
    var itiUpdateUserPhone = get_tel_input(document.querySelector("#updateUserPhone-intlTel"));

    function get_tel_input(val) {
        let itiPhone = window.intlTelInput(val, {
            // separateDialCode: true,
            placeholderNumberType: "off",
            preferredCountries: [],
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                jQuery.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
                });
            }
        });

        return itiPhone;
    }

    if (jQuery('#UserPhone').val()) {
        itiUserPhone.setNumber(jQuery('#UserPhone').val());
    }
    
    if (jQuery('#waitlist-UserPhone').val()) {
        waitlist_itiUserPhone.setNumber(jQuery('#waitlist-UserPhone').val());
    }
    
    jQuery('#intlTel').keyup(function(){
        if (itiUserPhone.getValidationError()) {
            jQuery('#UserPhone').val('');
        } else {
            jQuery('#UserPhone').val(itiUserPhone.getNumber());
        }
    });

    jQuery('#waitlist-intlTel').keyup(function(){
        if (waitlist_itiUserPhone.getValidationError()) {
            jQuery('#waitlist-UserPhone').val('');
        } else {
            jQuery('#waitlist-UserPhone').val(waitlist_itiUserPhone.getNumber());
        }
    });

    jQuery('#updateUserPhone-intlTel').keyup(function(){
        if (itiUpdateUserPhone.getValidationError()) {
            jQuery('#updateUserPhone').val('');
        } else {
            jQuery('#updateUserPhone').val(itiUpdateUserPhone.getNumber());
        }
    });
    
});



/********/

function zeroFill(i) {
    return (i < 10 ? '0' : '') + i
}

Date.createFromString = function (string) {
    'use strict';
    var pattern = /^(\d\d\d\d)-(\d\d)-(\d\d)[ T](\d\d):(\d\d)$/;
    var matches = pattern.exec(string);
    if (!matches) {
        throw new Error("Invalid string: " + string);
    }
    var year = matches[1];
    var month = matches[2] - 1;   // month counts from zero
    var day = matches[3];
    var hour = matches[4];
    var minute = matches[5];

    // Date.UTC() returns milliseconds since the unix epoch.
    var absoluteMs = Date.UTC(year, month, day, hour, minute, 0);

    return new Date(absoluteMs);
};

