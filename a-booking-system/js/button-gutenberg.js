window.aPlusBookingCalendarApiKey = '';

( function( wp ) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var __ = wp.i18n.__;
    var wpData = window.wp.data;
    var withSelect = wpData.withSelect;


    registerBlockType( 'bookeucom/bookeucom', {

        title: 'A+ Booking Calendar',

        description: __( 'Show availability calendar from A+ Booking System plugin.' ),

        icon:  {
                    background: 'rgb(129, 142, 160)',
                    foreground: '#fff',
                    src: 'calendar-alt'
                },
        category: 'common',					// common | formatting | layout | widgets | embed
        keywords: [ 'bookeucom' , 'booking', 'form' ],
        multiple: false,
        attributes: {
            bookeucom: {
                type: 'string',
                default: ''
            }
        },


        edit: withSelect( function( select ) {
            return {
                spaces: abookingsystemdashboard['main_calendars'] !== undefined ? JSON.parse(abookingsystemdashboard['main_calendars']):[],
            };
        } )( function( props ) {
            var shortcode = [];
            cid =  props.clientId;	
            var shortcodeAtts = props.attributes.bookeucom,
                value = shortcodeAtts,
                name = '';

            if ( ! props.spaces ) {
                return 'Loading...';
            }

            if ( props.spaces.length === 0 ) {
                return 'No spaces';
            }

            var className = props.className;
            var space = props.spaces[ props.spaces.length-1 ];

            if(value === undefined
                || value === ''){
                value = space['value'];
                props.setAttributes( { bookeucom: value } );
            }

            if(abookingsystemdashboard['apbs_api_key'] !== ''){
                value = abookingsystemdashboard['apbs_api_key'];
                props.setAttributes( { bookeucom: value } );
            }

            var found = false;
            for(var key in props.spaces) {
                if(props.spaces[key]['value'] === value){
                    found = true;
                    name = props.spaces[key]['name'];
                    if(name.length > 15) name = name.substring(0,15)+'...';
                }
            }

            if(!found){
                return 'This space no longer exists.';
            }

            if(document.querySelector('#absd-popup') !== null) {
                var changeNameContainer = [],
                    changeName = [];

                changeName.push(el(
                    'div',
                    {
                        className: 'aplusbooking_shortcode_change'
                    },
                    name
                ));

                changeNameContainer.push(el(
                    'div',
                    {
                        className: 'aplusbooking_shortcode_change_container'
                    },
                    changeName
                ));

                shortcode.push(changeNameContainer);
            }

            shortcode.push(el(
                'div',
                {
                    className: 'bookeucom'
                },
                __('[bookeucom key='+value+'-www'+' language=auto]')
            ));

            return el(
                'div',
                { className: 'bookeucom-container'},
                shortcode
            );
        }), // end edit
        save: function( props ) {
            
            if(abookingsystemdashboard['main_calendars'] !== undefined) {
                var spaces = abookingsystemdashboard['main_calendars'] !== undefined ? JSON.parse(abookingsystemdashboard['main_calendars']):[],
                    value = props.attributes.bookeucom,
                    found = false;

                for(var key in spaces) {
                    if(spaces[key]['value'] === value){
                        found = true;
                    }
                }

                if(!found){
                    return 'This space no longer exists.';
                }
            }
            
            // Save cors ( workflow, if is not saved. for current post id. )

            return el( 'div', {className: 'bookeucom'}, __('[bookeucom key='+props.attributes.bookeucom+'-www'+' language=auto]') );
        }
    } );
} )(
    window.wp
);

function aPlusBookingSystemShortcode(){
    var fields = abookingsystemdashboardForm.fields.get();

    if(fields !== "error"
      || fields === undefined){
        // Start Loader
        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                            absdashboardtext['wait']);

        var url = new window.URL(window.location.href); 
        url.searchParams.set('apbs_api_key', fields['calendar']);
        location.href=url.href;
    }
}

function aPlusBookingSystemShortcodeForm(){
    var main_calendars = abookingsystemdashboard['main_calendars'] !== undefined ? JSON.parse(abookingsystemdashboard['main_calendars']):[];
    // Add Calendar
    var addCalendarForm = {
        name: "get_shortcode",
        fields: [{
            label: absdashboardtext['space'],
            name: "calendar",
            value: main_calendars[0]['value'],    // default value
            placeholder: "",  
            required: "true",
            allowed_characters: "",
            min_chars: 0,     // 0 - disabled
            max_chars: 0,     // 0 - disabled
            is_email: "false",
            is_phone: "false",
            type: "select",                          // text, textarea, select, radio, checkbox, password
            options: main_calendars,     // select options
            label_class: "",
            input_class: "",
            hint: "",
            label_position: "left"              // left, right, left_full, right_full
          }]
      };

      // Start Form
      abookingsystemdashboardInfo.start(absdashboardtext['add_space_in_content'],
                                        addCalendarForm,
                                        absdashboardtext['add_space_add'],
                                        absdashboardtext['cancel'],
                                        aPlusBookingSystemShortcode);
}

jQuery(document).ready(function(){

    jQuery(document).bind('DOMSubtreeModified', function () {
        wdhDelay(function(){
            var existCalendar = document.querySelector(".bookeucom-container");
            if(existCalendar) {

                if(!jQuery(".bookeucom-container").hasClass('calendar-loaded')) {

                    jQuery('.aplusbooking_shortcode_change').unbind('click');
                    jQuery('.aplusbooking_shortcode_change').bind('click', function() {
                        aPlusBookingSystemShortcodeForm();
                    });

                    jQuery(".bookeucom-container").addClass('calendar-loaded');

                    (function(){
                        new Shortcode(document.querySelector('.bookeucom'), {
                          bookeucom: function() {
                            $GUP('.bookeucom').css('display', 'block');

                            if(this.options.key !== undefined) {
                              var tempApiKey = this.options.key.split('-'),
                                  selectedAPI = tempApiKey[0];
                            }

                            clearInterval(window.BECTryToLoad);

                            return '<div id="beccapp-'+selectedAPI+'" class="'+this.options.class+'"></div>';
                          }
                        },
                        function(options){
                          $GUP.calendarData = options;

                          setTimeout(function() {
                              var options = $GUP.calendarData,
                                  selectedCalendars = [],
                                  selectedLanguage = 'auto',
                                  selectedAPI = '',
                                  cssClass = '',
                                  on_facebook = 'false',
                                  estimated_price = 'false',
                                  estimated_price_to = '',
                                  useHours = 'false',
                                  selectedServer = 'www',
                                  referral_id = 0,
                                  fblink = '';

                              if(options.key !== undefined) {
                                var tempApiKey = options.key.split('-');
                                selectedAPI = tempApiKey[0];
                                selectedServer = tempApiKey[1];

                              }

                              if(options.class !== undefined) {
                                cssClass = options.class;
                              }

                              if(options.calendars !== undefined) {
                                selectedCalendars = options.calendars.split(',');
                              } else {
                                selectedCalendars = [];
                              }

                              if(options.language !== undefined) {
                                selectedLanguage = options.language;
                              }

                              if(options.hours !== undefined) {
                                useHours = options.hours;
                              }

                              var selectedCalendarsArr = [];
                              for( var i in selectedCalendars ) {

                                  if (selectedCalendars.hasOwnProperty(i)) {
                                      selectedCalendarsArr[i] = selectedCalendars[i];
                                  }
                              }

                              if(options.facebook !== undefined) {
                                on_facebook = options.facebook;
                              }

                              if(options.estimated_price !== undefined) {
                                estimated_price = options.estimated_price;
                              }

                              if(options.estimated_price_to !== undefined) {
                                estimated_price_to = options.estimated_price_to;
                              }

                              if(options.referral_id !== undefined) {
                                referral_id = parseInt(options.referral_id);
                              }

                              if(options.fblink !== undefined) {
                                fblink = options.fblink;
                              }

                              $GUP('#beccapp-'+selectedAPI).wdhBecBooking({'api_key': selectedAPI,
                                                                           'server': selectedServer,
                                                                           'language': selectedLanguage,
                                                                           'location_use': false,
                                                                           'category_use': false,
                                                                           'on_facebook': on_facebook,
                                                                           'estimated_price': estimated_price,
                                                                           'estimated_price_to': estimated_price_to,
                                                                           'referral_id': referral_id,
                                                                           'css_class': cssClass,
                                                                           'use_hours': useHours,
                                                                           'fblink': fblink,
                                                                           'selected': selectedCalendarsArr});
                          }, 1);
                        });
                    })();
                }
            }
        }, 300);
    });
});