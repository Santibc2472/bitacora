(function($){
    var abookingsystemdashboardDefaultColors = {
        accordion_boxes: {
            background: {
                name: absdashboardtext['ext_calendar_designer_background_color'],
                data: '--bookeucom-box-background-color',
                color: '#fff'
            },
            border: {
                name: absdashboardtext['ext_calendar_designer_border_color'],
                data: '--bookeucom-box-border-color',
                color: '#dddfe1'
            }
        },
        accordion_calendar_header: {
            title: {
                name: absdashboardtext['ext_calendar_designer_title_color'],
                data: '--bookeucom-header-title-color',
                color: '#4d4d4d'
            },
            text: {
                name: absdashboardtext['ext_calendar_designer_text_color'],
                data: '--bookeucom-header-day-color',
                color: '#666666'
            },
            nextprev_background: {
                name: absdashboardtext['ext_calendar_designer_next_prev_background_color'],
                data: '--bookeucom-header-nav-next-prev-background-color',
                color: '#999'
            },
            nextprev_hover_background: {
                name: absdashboardtext['ext_calendar_designer_next_prev_hover_background_color'],
                data: '--bookeucom-header-nav-next-prev-hover-background-color',
                color: '#001000'
            }
        },
        accordion_calendar_day: {
            text: {
                name: absdashboardtext['ext_calendar_designer_text_color'],
                data: '--bookeucom-calendar-day-text-color',
                color: '#fff'
            },
            available: {
                name: absdashboardtext['ext_calendar_designer_available_day_color'],
                data: '--bookeucom-calendar-day-available-color',
                color: '#608f43'
            },
            selected_available: {
                name: absdashboardtext['ext_calendar_designer_selected_available_day_color'],
                data: '--bookeucom-calendar-day-selected-available-color',
                color: '#3e5d2c'
            },
            unavailable: {
                name: absdashboardtext['ext_calendar_designer_unavailable_day_color'],
                data: '--bookeucom-calendar-day-unavailable-color',
                color: '#cacaca'
            },
            booked: {
                name: absdashboardtext['ext_calendar_designer_booked_day_color'],
                data: '--bookeucom-calendar-day-booked-color',
                color: '#c15557'
            },
            incartfirst: {
                name: absdashboardtext['ext_calendar_designer_incartfirst_day_color'],
                data: '--bookeucom-calendar-day-incart-first-color',
                color: '#2f2f2f'
            },
            incartsecond: {
                name: absdashboardtext['ext_calendar_designer_incartsecond_day_color'],
                data: '--bookeucom-calendar-day-incart-second-color',
                color: '#1d1d1d'
            },
            availability_free: {
                name: absdashboardtext['ext_calendar_designer_availability_free_color'],
                data: '--bookeucom-calendar-day-availability-progressbar-available-color',
                color: '#fff'
            },
            availability_booked: {
                name: absdashboardtext['ext_calendar_designer_availability_booked_color'],
                data: '--bookeucom-calendar-day-availability-progressbar-booked-color',
                color: '#ffff00'
            },
            no_day_background: {
                name: absdashboardtext['ext_calendar_designer_calendar_day_no_background_color'],
                data: '--bookeucom-calendar-day-header-background-color',
                color: '#fff'
            },
            day_info_background: {
                name: absdashboardtext['ext_calendar_designer_calendar_day_info_background'],
                data: '--bookeucom-calendar-day-header-info-background-color',
                color: '#3e5d2c'
            },
            day_info_details_text: {
                name: absdashboardtext['ext_calendar_designer_calendar_day_info_box_text'],
                data: '--bookeucom-calendar-day-header-info-details-text-color',
                color: '#cccccc'
            },
            day_info_details_background: {
                name: absdashboardtext['ext_calendar_designer_calendar_day_info_box_background'],
                data: '--bookeucom-calendar-day-header-info-details-background-color',
                color: '#001000'
            }
        },
        accordion_calendar_message: {
            message_text_color: {
                name: absdashboardtext['ext_calendar_designer_text_color'],
                data: '--bookeucom-body-message-text-color',
                color: '#999999'
            },
            message_background_color: {
                name: absdashboardtext['ext_calendar_designer_background_color'],
                data: '--bookeucom-body-message-background-color',
                color: '#f2f2f2'
            },
            message_success_text_color: {
                name: absdashboardtext['ext_calendar_designer_calendar_message_success_text'],
                data: '--bookeucom-body-message-success-text-color',
                color: '#090'
            },
            message_error_text_color: {
                name: absdashboardtext['ext_calendar_designer_calendar_message_error_text'],
                data: '--bookeucom-body-message-error-text-color',
                color: '#c15557'
            },
            message_error_border_color: {
                name: absdashboardtext['ext_calendar_designer_calendar_message_error_border'],
                data: '--bookeucom-body-message-error-border-color',
                color: '#f9e1e2'
            }
        },
        accordion_sidebar_header: {
            sidebar_text_color: {
                name: absdashboardtext['ext_calendar_designer_text_color'],
                data: '--bookeucom-reservation-sidebar-header-text-color',
                color: '#fff'
            },
            sidebar_background_color: {
                name: absdashboardtext['ext_calendar_designer_background_color'],
                data: '--bookeucom-reservation-sidebar-header-background-color',
                color: '#2f2f2f'
            }
        },
        accordion_sidebar_rooms: {
            sidebar_rooms_checkbox_background: {
                name: absdashboardtext['ext_calendar_designer_calendar_checkbox_background'],
                data: '--bookeucom-reservation-rooms-checkbox-background-color',
                color: '#fff'
            },
            sidebar_rooms_checkbox_border: {
                name: absdashboardtext['ext_calendar_designer_calendar_checkbox_border'],
                data: '--bookeucom-reservation-rooms-checkbox-border-color',
                color: '#23282d'
            },
            sidebar_rooms_checkbox_checked_background: {
                name: absdashboardtext['ext_calendar_designer_calendar_checkbox_checked_background'],
                data: '--bookeucom-reservation-rooms-checkbox-checked-background-color',
                color: '#009900'
            },
            sidebar_rooms_checkbox_checked_border: {
                name: absdashboardtext['ext_calendar_designer_calendar_checkbox_checked_border'],
                data: '--bookeucom-reservation-rooms-checkbox-checked-border-color',
                color: '#009900'
            },
            sidebar_rooms_error_text: {
                name: absdashboardtext['ext_calendar_designer_calendar_checkbox_error_text'],
                data: '--bookeucom-reservation-rooms-error-text-color',
                color: '#c00'
            }
        },
        accordion_sidebar_reservations: {
            sidebar_reservations_close_text: {
                name: absdashboardtext['ext_calendar_designer_sidebar_reservations_close_text'],
                data: '--bookeucom-remove-reservation-button-icon-color',
                color: '#4b4f57'
            },
            sidebar_reservations_close_background: {
                name: absdashboardtext['ext_calendar_designer_sidebar_reservations_close_background'],
                data: '--bookeucom-remove-reservation-button-background-color',
                color: '#f6f7f8'
            },
            sidebar_reservations_close_hover_text: {
                name: absdashboardtext['ext_calendar_designer_sidebar_reservations_close_hover_text'],
                data: '--bookeucom-remove-reservation-button-hover-icon-color',
                color: '#fff'
            },
            sidebar_reservations_close_hover_background: {
                name: absdashboardtext['ext_calendar_designer_sidebar_reservations_close_hover_background'],
                data: '--bookeucom-remove-reservation-button-hover-background-color',
                color: '#990000'
            },
            sidebar_reservations_separator: {
                name: absdashboardtext['ext_calendar_designer_sidebar_reservations_separator'],
                data: '--bookeucom-reservation-details-box-border-bottom-color',
                color: '#eaeaea'
            }
        },
        accordion_sidebar_fields: {
            sidebar_fields_text_color: {
                name: absdashboardtext['ext_calendar_designer_text_color'],
                data: '--bookeucom-text-color',
                color: '#2f2f2f'
            },
            sidebar_fields_background_color: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_background'],
                data: '--bookeucom-form-fields-background-color',
                color: '#fff'
            },
            sidebar_fields_border_color: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_border'],
                data: '--bookeucom-form-fields-border-color',
                color: '#dddfe1'
            },
            sidebar_fields_select_icon_color: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_dropdown_icon'],
                data: '--bookeucom-select-dropdown-icon-color',
                color: '#bdc0c2'
            },
            sidebar_fields_select_text_color: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_dropdown_text'],
                data: '--bookeucom-select-options-text-color',
                color: '#adacac'
            },
            sidebar_fields_select_background_color: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_dropdown_background'],
                data: '--bookeucom-select-options-background-color',
                color: '#f5f5f5'
            },
            sidebar_fields_select_hover_background_color: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_dropdown_hover_background'],
                data: '--bookeucom-select-options-hover-background-color',
                color: '#fff'
            },
            sidebar_fields_select_border_color: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_dropdown_border'],
                data: '--bookeucom-select-options-border-color',
                color: '#e6e7e8'
            },
            sidebar_fields_terms_checkbox_border: {
                name: absdashboardtext['ext_calendar_designer_calendar_checkbox_border'],
                data: '--bookeucom-form-fields-checkbox-border-color',
                color: 'rgba(0,0,0,.075)'
            },
            sidebar_fields_terms_checkbox_checked_border: {
                name: absdashboardtext['ext_calendar_designer_calendar_checkbox_checked_border'],
                data: '--bookeucom-form-fields-checkbox-checked-border-color',
                color: '#484848'
            },
            sidebar_fields_terms_text: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_terms_text'],
                data: '--bookeucom-form-fields-terms-and-conditions-text-color',
                color: '#2f2f2f'
            },
            sidebar_fields_terms_link: {
                name: absdashboardtext['ext_calendar_designer_sidebar_fields_terms_link'],
                data: '--bookeucom-form-fields-terms-and-conditions-link-color',
                color: '#608f43'
            }
        },
        accordion_sidebar_buttons: {
            sidebar_buttons_text: {
                name: absdashboardtext['ext_calendar_designer_text_color'],
                data: '--bookeucom-button-text-color',
                color: '#fff'
            },
            sidebar_buttons_green: {
                name: absdashboardtext['ext_calendar_designer_sidebar_buttons_green_background'],
                data: '--bookeucom-green-button-background-color',
                color: '#608f43'
            },
            sidebar_buttons_hover_green: {
                name: absdashboardtext['ext_calendar_designer_sidebar_buttons_green_hover_background'],
                data: '--bookeucom-green-button-hover-background-color',
                color: '#3e5c2d'
            },
            sidebar_buttons_red: {
                name: absdashboardtext['ext_calendar_designer_sidebar_buttons_red_background'],
                data: '--bookeucom-red-button-background-color',
                color: '#c15557'
            },
            sidebar_buttons_hover_red: {
                name: absdashboardtext['ext_calendar_designer_sidebar_buttons_red_hover_background'],
                data: '--bookeucom-red-button-hover-background-color',
                color: '#9a2022'
            }
        },
        accordion_sidebar_loaders: {
            sidebar_loaders_background: {
                name: absdashboardtext['ext_calendar_designer_background_color'],
                data: '--bookeucom-steps-loader-background-color',
                color: '#fff'
            },
            sidebar_loaders_color: {
                name: absdashboardtext['ext_calendar_designer_color'],
                data: '--bookeucom-steps-loader-color',
                color: 'rgb(0, 153, 0)'
            }
        }
    };
  
    var abookingsystemdashboardCalendarDesigner = {
        loadedColors:{},
        savedColor: {},
        app: {
            container: '#bdm-calendar_designer',
            start: function(){
                this.preview.start(this.container);
                this.colors.start(this.container);
            },
            preview: {
                start: function(container){
                    $('#absd-wrapper').addClass('exist-demo-calendar');
                    $(container+' .preview').html(this.generate());
                    $('.aplusbookingcalendar-designer-h2').removeAttr('hidden');
                },
                generate: function(){
                    var HTML = new Array();
    
                    HTML.push('<div class="abookingsystem-demo-calendar">');
                    HTML.push(' <div class="bookeucom">[bookeucom key=d3fbc8053c8cd6eed13122c58de53fd0-www language=en]</div>');
                    HTML.push('</div>');
    
                    return HTML.join('');
                }
            },
            colors: {
                start: function(container){
                    this.generate($(container+' .settings'));
                },
                generate: function(container){
                    var defaultColors = abookingsystemdashboardDefaultColors;
                    var colors = window.aplusbookingsystemCalendarDesignColors;

                    // Create Advanced Accordions
                    var accordionData = [];

                    for(var key in defaultColors){
                        if(defaultColors.hasOwnProperty(key)) {
                            if(key === 'accordion_calendar_day') {
                                accordionData.push({label: absdashboardtext['ext_calendar_designer_'+key],
                                                    name: key,
                                                    class: "absd-opened"});
                            } else {
                                accordionData.push({label: absdashboardtext['ext_calendar_designer_'+key],
                                                    name: key});
                            }
                        }
                    }

                    abookingsystemdashboardAccordion.start(container, accordionData);

                    // Add colors in Accordions
                    for(var key in defaultColors){
                        if(defaultColors.hasOwnProperty(key)) {
                            var HTML = new Array();

                            $('#absd-accordion-'+key+'-content').html('');

                            for(var subkey in defaultColors[key]){
                                if(defaultColors[key].hasOwnProperty(subkey)) {
                                    HTML.push('<div class="row mt-2">');
                                    HTML.push(' <div class="ml-3 col-5">');
                                    HTML.push(      '<b>'+defaultColors[key][subkey]['name']+'</b>');
                                    HTML.push(' </div>');
                                    HTML.push(' <div class="col-3">');
                                    HTML.push(      '<div id="aplusbooking-color-'+defaultColors[key][subkey]['data']+'" data-color="'+defaultColors[key][subkey]['color']+'" data-save="'+defaultColors[key][subkey]['data']+'"></div>');
                                    HTML.push(' </div>');
                                    HTML.push('</div>');
                                }
                            }
                            HTML.push('<div class="row mt-2"></div>');

                            $('#absd-accordion-'+key+'-content').append(HTML.join(''));
                        }
                    }

                    this.events(colors);

                },
                events: function(colors){
                    var defaultColors = abookingsystemdashboardDefaultColors;

                    var me = this;
                    // Add colorpickers
                    for(var key in defaultColors){
                        if(defaultColors.hasOwnProperty(key)) {

                            for(var subkey in defaultColors[key]){
                                if(defaultColors[key].hasOwnProperty(subkey)) {
                                    me.colorpicker.add('#aplusbooking-color-'+defaultColors[key][subkey]['data'], me.color.get(defaultColors[key][subkey]['data'], defaultColors[key][subkey]['color'], colors));
                                }
                            }
                        }
                    }

                    $('.aplusbookingcalendar-designer-reset').unbind('click');
                    $('.aplusbookingcalendar-designer-reset').bind('click', function(){
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                                            absdashboardtext['wait']);

                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request_ext_calendar_designer['reset'],
                                                                     is_ajax_request: true,
                                                                     reset: 'true',
                                                                     ajax_ses: abookingsystemdashboard['ajax_ses']}, function(){
                            location.reload();
                        });
                    });
                },
                color:{
                    get: function(key, defaultColor, colors){
                        return colors !== undefined && colors[key] !== undefined ? colors[key]:defaultColor;
                    }
                },
                colorpicker:{
                    add: function(id, color){
                        var me = this;
                        var key = id.split('#aplusbooking-color-')[1];
                        abookingsystemdashboardCalendarDesigner.savedColor[key] = color;

                        var pickr = Pickr.create({
                            el: id,
                            theme: 'monolith', // or 'monolith', or 'nano'
                            default: color,

                            swatches: [
                                'rgba(244, 67, 54, 1)',
                                'rgba(233, 30, 99, 0.95)',
                                'rgba(156, 39, 176, 0.9)',
                                'rgba(103, 58, 183, 0.85)',
                                'rgba(63, 81, 181, 0.8)',
                                'rgba(33, 150, 243, 0.75)',
                                'rgba(3, 169, 244, 0.7)',
                                'rgba(0, 188, 212, 0.7)',
                                'rgba(0, 150, 136, 0.75)',
                                'rgba(76, 175, 80, 0.8)',
                                'rgba(139, 195, 74, 0.85)',
                                'rgba(205, 220, 57, 0.9)',
                                'rgba(255, 235, 59, 0.95)',
                                'rgba(255, 193, 7, 1)'
                            ],

                            components: {

                                // Main components
                                preview: true,
                                opacity: true,
                                hue: true,

                                // Input / output Options
                                interaction: {
                                    hex: true,
                                    rgba: true,
                                    hsla: false,
                                    hsva: false,
                                    cmyk: false,
                                    input: true,
                                    cancel: true,
                                    save: true
                                }
                            }
                        });

                        pickr.on('change', function(color){
                            me.change(key, color);
                        }).on('hide', function(){
                            me.cancel(key, me);
                        }).on('cancel', function(){
                            me.cancel(key, me);
                        }).on('save', function(color){
                            me.save(key, color, me);
                        });

                        abookingsystemdashboardCalendarDesigner.loadedColors[key] = color; 
                    },
                    change: function(key, color){
                        wdhDelay(function(){
                            abookingsystemdashboardCalendarDesigner.loadedColors[key] = color.toHEXA().toString(); 
                            abookingsystemdashboardCalendarDesigner.app.colors.vars.start();
                        }, 300);
                    },
                    cancel: function(key, me){
                        abookingsystemdashboardCalendarDesigner.loadedColors[key] = abookingsystemdashboardCalendarDesigner.savedColor[key]; 
                        abookingsystemdashboardCalendarDesigner.app.colors.vars.start();
                        me.close();
                    },
                    save: function(key, color, me){
                        abookingsystemdashboardCalendarDesigner.loadedColors[key] = color.toHEXA().toString(); 
                        abookingsystemdashboardCalendarDesigner.savedColor[key] = abookingsystemdashboardCalendarDesigner.loadedColors[key];
                        abookingsystemdashboardCalendarDesigner.app.colors.vars.start();
                        me.close();
                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request_ext_calendar_designer['save'],
                                                                     is_ajax_request: true,
                                                                     key: key,
                                                                     color: color.toHEXA().toString(),
                                                                     ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                        });
                    },
                    close: function(){
                        $('.pcr-app').removeClass('visible');
                    }
                },
                vars: {
                    start:function(){
                        var HTML = new Array();
                        var colors = abookingsystemdashboardCalendarDesigner.loadedColors;

                        $('#Booking-Everything-Unlimited-Calendar-New-Vars-css').remove();
                        HTML.push('<style id="Booking-Everything-Unlimited-Calendar-New-Vars-css">');

                        HTML.push(':root{');
                        for(var key in colors){
                            if(colors.hasOwnProperty(key)) {
                                HTML.push(key+':'+colors[key]+' !important;');
                            }
                        }
                        HTML.push('}');
                        HTML.push('</style>');

                        $('#Booking-Everything-Unlimited-Calendar-Vars-css').after(HTML.join(''));
                    }
                }
            }
        }
    };
  
    window.abookingsystemdashboardCalendarDesigner = abookingsystemdashboardCalendarDesigner;

    jQuery(document).ready(function(){
        window.abookingsystemdashboardCalendarDesigner.app.start();
    });
  
})(jQuery);