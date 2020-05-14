
(function($){
  
  Date.prototype.daysMoreLessR = 
     Date.prototype.daysMoreLessR ||
     function(days){
       days = days || 0;
       var ystrdy = new Date(this.setDate(this.getDate()+days));
       return ystrdy;
  };
  
  var abookingsystemdashboardReservations = {
    data: {
        space: '',
        room: '',
        selected_space: '',
        selected_room: '',
        calendars: [],
        category: 'all',
        country: 'US',
        countries: [],
        monthsText: [absdashboardtext['january'], absdashboardtext['february'], absdashboardtext['march'], absdashboardtext['april'], absdashboardtext['may'], absdashboardtext['june'], absdashboardtext['july'], absdashboardtext['august'], absdashboardtext['september'], absdashboardtext['october'], absdashboardtext['november'], absdashboardtext['december']],
        addDays: function(date, amount) {
          
            date = new Date(date.split('-')[2], (parseInt(date.split('-')[1])-1), date.split('-')[0]);
            date = date.daysMoreLessR(amount);

            return (date.getDate() < 10 ? '0'+(date.getDate()):(date.getDate()))+'-'+((date.getMonth()+1) < 10 ? '0'+(date.getMonth()+1):(date.getMonth()+1))+'-'+date.getFullYear();
        },
        show: function(data,
                       type){
            type = type === undefined ? 'eu':type;
            var tempData = data.split('-');
            
            if(type === 'eu') {
                data = parseInt(tempData[0])+' '+abookingsystemdashboardReservations.data.monthsText[(parseInt(tempData[1])-1)]+' '+tempData[2];
            } else {
                data = abookingsystemdashboardReservations.data.monthsText[(parseInt(tempData[1])-1)]+' '+parseInt(tempData[0])+', '+tempData[2];
            }

            return data;
        },
        convert: function(data){
            var newData = new Array(),
                colors = ['red', 'blue', 'green', 'yellow', 'pink', 'black'];
            j = 0;
            
            for (var i = 0; i < data.length; i++) {
                newData[i] = {};
                newData[i]['start'] 	= abookingsystemdashboardReservations.data.time(data[i]['start_date'], data[i]['start_time']);

                if(data[i]['end_date'] !== '') {
                    newData[i]['end'] 	 	= abookingsystemdashboardReservations.data.time(abookingsystemdashboardReservations.data.addDays(data[i]['end_date'], 1), data[i]['end_time']);
                }

                newData[i]['title'] = data[i]['selected_calendars'].join(',')+' '+(data[i]['space'] !== undefined ? '['+data[i]['space']+']':'');

                if(data[i]['entire'] !== undefined
                  && data[i]['entire'] === 'true'){
                  newData[i]['title'] = data[i]['space'] !== undefined ? data[i]['space']:data[i]['selected_calendars'][0];
                }
                newData[i]['id'] = i;

                switch(data[i]['reservation_from']) {
                   case 'booking_com': 
                    newData[i]['color'] = '#033c80';
                    break;
                   case 'airbnb_com': 
                    newData[i]['color'] = '#FF5A5F';
                    break;
                   case 'google_calendar': 
                    newData[i]['color'] = 'orange';
                    break;
                   case 'homeaway_com': 
                    newData[i]['color'] = '#0067db';
                    break;
                   case 'homestay_com': 
                    newData[i]['color'] = '#ca005d';
                    break;
                   case 'vrbo_com': 
                    newData[i]['color'] = '#34a171';
                    break;
                   case 'flipkey_com': 
                    newData[i]['color'] = '#e67618';
                    break;
                   case 'other_calendar': 
                    newData[i]['color'] = 'yellow';
                    break;
                   case 'admin': 
                    newData[i]['color'] = '#232831;';
                    break;
                   default: 
                    newData[i]['color'] = '#009900';
                    break;
                }
            }

			return newData;
        },
				time: function convert(date, time){
						var newData = '';
					
						newData = date.split('-')[2]+'-'+date.split('-')[1]+'-'+date.split('-')[0];
				
						// time
					
						return newData;
				},
				details: function(data){
						var html = new Array(),
								savedData = abookingsystemdashboardReservations.data.content,
                reservation_for = savedData[data['id']]['selected_calendars']+' '+(savedData[data['id']]['space'] !== undefined ? '['+savedData[data['id']]['space']+']':'');
          
            if(savedData[data['id']]['entire'] !== undefined
              && savedData[data['id']]['entire'] === 'true'){
              reservation_for = savedData[data['id']]['space'] !== undefined ? savedData[data['id']]['space']:savedData[data['id']]['selected_calendars'];
            }
            
						html.push('<h3>ID: '+savedData[data['id']]['id']+' - '+absdashboardtext['reservations_for']+' '+reservation_for+'</h3><br>');
            
            if(savedData[data['id']]['mode'] === 'nights') {
                html.push('<span><b>'+absdashboardtext['reservations_start_date']+'</b>: '+abookingsystemdashboardReservations.data.show(savedData[data['id']]['start_date'])+' - '+savedData[data['id']]['checkin_time']+'</span><br>');
                html.push('<span><b>'+absdashboardtext['reservations_end_date']+'</b>: '+abookingsystemdashboardReservations.data.show(abookingsystemdashboardReservations.data.addDays(savedData[data['id']]['end_date'], 1))+' -  '+savedData[data['id']]['checkout_time']+'</span><br>');
					  } else {
                html.push('<span><b>'+absdashboardtext['reservations_start_date']+'</b>: '+abookingsystemdashboardReservations.data.show(savedData[data['id']]['start_date'])+'</span><br>');
                html.push('<span><b>'+absdashboardtext['reservations_end_date']+'</b>: '+abookingsystemdashboardReservations.data.show(savedData[data['id']]['end_date'])+'</span><br>');
					  }
						if(savedData[data['id']]['items'] !== undefined
							&&  savedData[data['id']]['items'] > 1) {
								html.push('<span><b>'+absdashboardtext['reservations_no_items']+'</b>: '+savedData[data['id']]['items']+'</span><br>');
						}
					
						switch(abookingsystemdashboard['role']) {
								case "admin":
                
                  if(savedData[data['id']]['owner_price'] > 0) {
//                      html.push('<span><b>'+absdashboardtext['reservations_your_price']+'</b>: '+abookingsystemdashboardGeneral.currencies.sign(abookingsystemdashboardReservations.data['currency'])+' '+savedData[data['id']]['owner_price']+'</span><br>');
                  }
// 									html.push('<span><b>'+absdashboardtext['reservations_service_fee']+'</b> '+abookingsystemdashboardGeneral.currencies.sign(abookingsystemdashboardReservations.data['currency'])+' '+savedData[data['id']]['service_fee']+'</span><br>');
// 									html.push('<span><b>'+absdashboardtext['reservations_network_fee']+'</b> '+abookingsystemdashboardGeneral.currencies.sign(abookingsystemdashboardReservations.data['currency'])+' '+savedData[data['id']]['network_fee']+'</span><br>');
// 									html.push('<span><b>'+absdashboardtext['reservations_total_price']+'</b> '+abookingsystemdashboardGeneral.currencies.sign(abookingsystemdashboardReservations.data['currency'])+' '+savedData[data['id']]['price']+'</span><br><br>');
									break;
								case "owner":
									if(savedData[data['id']]['owner_price'] > 0) {
//                      html.push('<span><b>'+absdashboardtext['reservations_your_price']+'</b>: '+abookingsystemdashboardGeneral.currencies.sign(abookingsystemdashboardReservations.data['currency'])+' '+savedData[data['id']]['owner_price']+'</span><br>');
                  }
// 									html.push('<span><b>'+absdashboardtext['reservations_service_fee']+'</b> '+abookingsystemdashboardGeneral.currencies.sign(abookingsystemdashboardReservations.data['currency'])+' '+savedData[data['id']]['total_fee']+'</span><br>');
// 									html.push('<span><b>'+absdashboardtext['reservations_total_price']+'</b> '+abookingsystemdashboardGeneral.currencies.sign(abookingsystemdashboardReservations.data['currency'])+' '+savedData[data['id']]['price']+'</span><br><br>');
									break;
								default:
									html.push('<span><b>'+absdashboardtext['reservations_just_price']+'</b>: '+savedData[data['id']]['price']+'</span><br><br>');
									break;
								
						}
          
            if(savedData[data['id']]['reservation_from'] !== '') {
                html.push('<span><b>'+absdashboardtext['reservations_from']+'</b>: '+absdashboardtext['reservations_from_'+savedData[data['id']]['reservation_from']]+'</span><br>');
            }
						
            if(savedData[data['id']]['email'] !== ''
              || savedData[data['id']]['phone'].length > 4) {
                html.push('<h3>'+absdashboardtext['reservations_contact']+'</h3>');
              
                if(savedData[data['id']]['email'] !== '') {
                    html.push('<span><b>'+absdashboardtext['reservations_email']+'</b>: '+savedData[data['id']]['email']+'</span><br>');
                }
              
                if(savedData[data['id']]['phone'].length > 4) {
                    html.push('<span><b>'+absdashboardtext['reservations_phone']+'</b>: '+savedData[data['id']]['phone']+'</span><br>');
                }
            }
                  
            if(abookingsystemdashboard['role'] === 'owner'
               || abookingsystemdashboard['role'] === 'admin') {
                html.push('<div data-id="'+savedData[data['id']]['id']+'" data-api-key="'+savedData[data['id']]['api_key']+'" data-email="'+savedData[data['id']]['email']+'" class="absd-cancel-reservation absd-button">'+absdashboardtext['reservations_cancel_btn']+'</div>');
            }
            
            return html.join('');
        },
        save: function(data){
            abookingsystemdashboardReservations.data.content = data;
        }
    },
    calendar: {
        get: function(id){
            var tempCalendars = abookingsystemdashboardReservations.data.calendars,
                calendar = {};
          
            for(var key in tempCalendars) {
                
                if(parseInt(tempCalendars[key]['cid']) === parseInt(id)) {
                    calendar = tempCalendars[key];
                }
            }
          
            return calendar;
        }
    },
    spaces: {
        get: function(){
            var tempCalendars = abookingsystemdashboardReservations.data.calendars,
                newCalendars = [];
          
            for(var key in tempCalendars) {
                
                if(tempCalendars[key]['group_id'] === '0') {
                    newCalendars.push({"name": tempCalendars[key]['name'],"value": tempCalendars[key]['cid']});
                }
            }
          
            return newCalendars;
        }
    },
    rooms: {
        get: function(space){
            var tempCalendars = abookingsystemdashboardReservations.data.calendars,
                groupID = '0',
                newCalendars = [];
          
            for(var key in tempCalendars) {
                
                if(tempCalendars[key]['cid'] === space) {
                    groupID = tempCalendars[key]['cid'];
                }
            }
          
            if(groupID !== '0') {
              
                for(var key in tempCalendars) {
                    
                    if(tempCalendars[key]['group_id'] === groupID) {
                        newCalendars.push({"name": tempCalendars[key]['name'],"value": tempCalendars[key]['cid']});
                    }
                }
            }
          
            return newCalendars;
        },
        change: function(space){
            abookingsystemdashboardReservations.data.space = space;
            abookingsystemdashboardReservations.data.room = '';
          
            abookingsystemdashboardReservations.reservation.add();
        }
    },
    space_room: {
        select: function(){
            var tempSpaces = abookingsystemdashboardReservations.spaces.get();

            if(tempSpaces[0] !== undefined) {
                var tempSpace = abookingsystemdashboardReservations.data.space !== '' ? abookingsystemdashboardReservations.data.space:tempSpaces[0]['value'],
                    tempRooms = abookingsystemdashboardReservations.rooms.get(tempSpace),
                    tempRoom = abookingsystemdashboardReservations.data.room !== '' ? abookingsystemdashboardReservations.data.room:tempRooms[0]['value'];

                tempSpaces.unshift({"name": absdashboardtext['space_selected_all'],"value": ""});
                tempRooms.unshift({"name": absdashboardtext['space_selected_all_rooms'],"value": ""});
            
                var tempSpace = abookingsystemdashboardReservations.data.space !== '' ? abookingsystemdashboardReservations.data.space:tempSpaces[0]['value'],
                    tempRoom = abookingsystemdashboardReservations.data.room !== '' ? abookingsystemdashboardReservations.data.room:tempRooms[0]['value'];

                if(tempRooms.length > 0) {
                    // Add Reservation
                    var selectSpaceRoomForm = {
                        name: "select_space",
                        fields: [{
                                  label: absdashboardtext['space'],
                                  name: "space",
                                  value: tempSpace,    // default value
                                  modify: "abookingsystemdashboardReservations.space_room.space_change(window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                          // text, textarea, select, radio, checkbox, password
                                  options: tempSpaces,     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['space_rooms'],
                                  name: "rooms",
                                  value: tempRoom,    // default value
                                  modify: "abookingsystemdashboardReservations.space_room.room_change(window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                          // text, textarea, select, radio, checkbox, password
                                  options: tempRooms,     // select options
                                  label_class: "",
                                  input_class: "",
                                  checkboxes_class: "absd-checkbox-checkboxes",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                }]

                            };
                        } else {
                            // Add Reservation
                            var selectSpaceRoomForm = {
                                name: "select_space",
                                fields: [{
                                          label: absdashboardtext['space'],
                                          name: "space",
                                          value: tempSpace,    // default value
                                          modify: "abookingsystemdashboardReservations.space_room.space_change(window.absdSelectedValue)",
                                          placeholder: "",  
                                          required: "true",
                                          allowed_characters: "",
                                          min_chars: 0,     // 0 - disabled
                                          max_chars: 0,     // 0 - disabled
                                          is_email: "false",
                                          is_phone: "false",
                                          type: "select",                          // text, textarea, select, radio, checkbox, password
                                          options: tempSpaces,     // select options
                                          label_class: "",
                                          input_class: "",
                                          hint: "",
                                          label_position: "left"              // left, right, left_full, right_full
                                        }]

                            };
                }

                    // Start Form
                    abookingsystemdashboardInfo.start(absdashboardtext['reservations_add_details'],
                                     selectSpaceRoomForm,
                                     absdashboardtext['save'],
                                     absdashboardtext['cancel'],
                                     abookingsystemdashboardReservations.space_room.select_ok,
                                     undefined,
                                     'absd-selected');
            }
        },
        select_ok: function(){
            // Reload reservations
            abookingsystemdashboardReservations.list();
        },
        space_change: function(space){
            abookingsystemdashboardReservations.data.space = space;
            abookingsystemdashboardReservations.data.room  = '';
            abookingsystemdashboardReservations.data.selected_room = '';
            
            var tempCalendar = abookingsystemdashboardReservations.calendar.get(abookingsystemdashboardReservations.data.space);
            
            abookingsystemdashboardReservations.data.selected_space  = abookingsystemdashboardReservations.data.space !== '' ? tempCalendar['name']:'';
          
            abookingsystemdashboardReservations.space_room.select();  
        },
        room_change: function(room){
            abookingsystemdashboardReservations.data.room  = room;
            
            var tempCalendar = abookingsystemdashboardReservations.calendar.get(abookingsystemdashboardReservations.data.room);
            
            abookingsystemdashboardReservations.data.selected_room  = abookingsystemdashboardReservations.data.room !== '' ? tempCalendar['name']:'';
        }
    }, 
    list: function(){
        
					// Start Loader
					abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                       absdashboardtext['wait']);
            
          $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['reservations'],
                                      is_ajax_request: true,
                                      user_id: abookingsystemdashboard['user_id'],
                                      category: abookingsystemdashboardReservations['data']['category'],
                                      space: abookingsystemdashboardReservations.data.space,
                                      room: abookingsystemdashboardReservations.data.room,
                                      role: abookingsystemdashboard['role']}, function(data){
              data = JSON.parse(data);
              abookingsystemdashboardReservations.data.save(data['reservations']);
              abookingsystemdashboardReservations.data.calendars = data['calendars'];
              data['reservations'] = abookingsystemdashboardReservations.data.convert(data['reservations']);
						
              abookingsystemdashboardReservations.data.country = data['country'];
              abookingsystemdashboardReservations.data.countries = data['countries'];
						
              var today = new Date(),
                  HTML = new Array(),
                  selected_name = absdashboardtext['space_selected_all'];
						
                today = today.getFullYear()+'-'+((today.getMonth()+1) < 10 ? '0'+(today.getMonth()+1):(today.getMonth()+1))+'-'+(today.getDate() < 10 ? '0'+today.getDate():today.getDate());	
              
              if(abookingsystemdashboardReservations.data.selected_room !== '') {
                  selected_name = abookingsystemdashboardReservations.data.selected_room+'['+abookingsystemdashboardReservations.data.selected_space+']';
              } else if(abookingsystemdashboardReservations.data.selected_space !== ''){
                  selected_name = abookingsystemdashboardReservations.data.selected_space;
              }
              
              
              var tempSpaces = abookingsystemdashboardReservations.spaces.get();
              
              if(tempSpaces[0] !== undefined) {
                  HTML.push('<div id="absd-calendars-reservation" class="absd-full-box">');
                  HTML.push('   <div id="absd-calendars-reservation" class="absd-half-box">');
                  HTML.push('       <div class="absd-button absd-dropdown-button absd-switch-reservation-space">'+selected_name+'</div>');
                  HTML.push('   </div>');
                  HTML.push('   <div id="absd-add-reservation" class="absd-half-box">');
                  HTML.push('       <div class="absd-button absd-add-reservation">'+absdashboardtext['reservations_add']+'</div>');
                  HTML.push('   </div>');
                  HTML.push('</div>');
              }
            
              $("#absd-calendars-reservation").remove();
              $("#absd-add-reservation").remove();
              $('#bdm-reservations').before(HTML.join(''));
              
                $('#bdm-reservations').fullCalendar('destroy');
                $('#bdm-reservations').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: $(window).width() > 481 ? 'month,agendaWeek,agendaDay,listMonth':'agendaWeek' 
                        },
                        dayNames: [absdashboardtext['sunday'], absdashboardtext['monday'], absdashboardtext['tuesday'], absdashboardtext['wednesday'], absdashboardtext['thursday'], absdashboardtext['friday'], absdashboardtext['saturday']],
                        dayNamesShort: [absdashboardtext['sunday'].substr(0,2), absdashboardtext['monday'].substr(0,2), absdashboardtext['tuesday'].substr(0,2), absdashboardtext['wednesday'].substr(0,2), absdashboardtext['thursday'].substr(0,2), absdashboardtext['friday'].substr(0,2), absdashboardtext['saturday'].substr(0,2)],
                        monthNames: [absdashboardtext['january'], absdashboardtext['february'], absdashboardtext['march'], absdashboardtext['april'], absdashboardtext['may'], absdashboardtext['june'], absdashboardtext['july'], absdashboardtext['august'], absdashboardtext['september'], absdashboardtext['october'], absdashboardtext['november'], absdashboardtext['december']],
                        monthNamesShort: [absdashboardtext['january'].substr(0,2), absdashboardtext['february'].substr(0,2), absdashboardtext['march'].substr(0,2), absdashboardtext['april'].substr(0,2), absdashboardtext['may'].substr(0,2), absdashboardtext['june'].substr(0,2), absdashboardtext['july'].substr(0,2), absdashboardtext['august'].substr(0,2), absdashboardtext['september'].substr(0,2), absdashboardtext['october'].substr(0,2), absdashboardtext['november'].substr(0,2), absdashboardtext['december'].substr(0,2)],
                        buttonText: {
                          today:    absdashboardtext['today'],
                          month:    absdashboardtext['monthly_price'],
                          week:     absdashboardtext['weekly_price'],
                          day:      absdashboardtext['price'],
                          list:     absdashboardtext['list']
                        },
                        defaultView: $(window).width() > 481 ? 'month':'agendaWeek',
                        eventLimitText: absdashboardtext['more'],
                        defaultDate: today,
                        navLinks: true, // can click day/week names to navigate views
                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        events: data['reservations'],
                        eventClick: function(calEvent, jsEvent, view) {

                                $.magnificPopup.open({
                                    items: {
                                        src: '<div class="absd-white-popup">'+window.abookingsystemdashboardReservations.data.details(calEvent)+'</div>'
                                    },
                                    type: 'inline',
                                    callbacks: {
                                        open: function() {
                                            // Events
                                            abookingsystemdashboardReservations.reservation.events();
                                        }
                                    }
                                });

                        },
                    closeBtnInside: true
                });

                // Stop Loader
                abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                  absdashboardtext['refresh'],
                                  true);
              
              // Events
              abookingsystemdashboardReservations.events();
							
							
          });	
			},
    events: function(){
      
        $('.absd-add-reservation').unbind('click');
        $('.absd-add-reservation').bind('click', function(){
            abookingsystemdashboardReservations.reservation.add();
        }); 
      
        $('.absd-switch-reservation-space').unbind('click');
        $('.absd-switch-reservation-space').bind('click', function(){
            abookingsystemdashboardReservations.space_room.select();
        }); 
    },
    save_customer: function(customer_token, 
                            owner_id, 
                            user_id,
                            fnSuccessCallback){

        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['save_customer'],
                                    is_ajax_request: true,
                                    user_id: abookingsystemdashboard['user_id'],
                                    owner_id: owner_id,
                                    customer_token: customer_token,
                                    role: abookingsystemdashboard['role']}, function(data){
            // Success Action
            fnSuccessCallback();
        });	
    },
    reservation: {
        add: function(){
            var tempSpaces = abookingsystemdashboardReservations.spaces.get(),
                tempSpace = abookingsystemdashboardReservations.data.space !== '' ? abookingsystemdashboardReservations.data.space:tempSpaces[0]['value'],
                tempRooms = abookingsystemdashboardReservations.rooms.get(tempSpace);
                
            if(tempSpaces[0] !== undefined) {

                if(tempRooms.length > 0) {
                    // Add Reservation
                    var addReservationForm = {
                        name: "create_calendar",
                        fields: [{
                                  label: absdashboardtext['space'],
                                  name: "space",
                                  value: tempSpace,    // default value
                                  modify: "abookingsystemdashboardReservations.rooms.change(window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                          // text, textarea, select, radio, checkbox, password
                                  options: tempSpaces,     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['space_rooms'],
                                  name: "rooms",
                                  value: '[@'+tempRooms[0]['value']+'@]',    // default value
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "checkbox",                          // text, textarea, select, radio, checkbox, password
                                  options: tempRooms,     // select options
                                  label_class: "",
                                  input_class: "",
                                  checkboxes_class: "absd-checkbox-checkboxes",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_add_check_in'],
                                  name: "check_in",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "date",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_add_check_out'],
                                  name: "check_out",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "date",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['withdraw_name'],
                                  name: "fullname",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "text",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_email'],
                                  name: "email",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "text",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_phone'],
                                  name: "phone",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "phone",                          // text, textarea, select, radio, checkbox, password
                                  country: abookingsystemdashboardReservations.data.country,
                                  countries: abookingsystemdashboardReservations.data.countries,
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                }]

                    };
                } else {
                    // Add Reservation
                    var addReservationForm = {
                        name: "create_calendar",
                        fields: [{
                                  label: absdashboardtext['space'],
                                  name: "space",
                                  value: tempSpace,    // default value
                                  modify: "abookingsystemdashboardReservations.rooms.change(window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                          // text, textarea, select, radio, checkbox, password
                                  options: tempSpaces,     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_add_check_in'],
                                  name: "check_in",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "date",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_add_check_out'],
                                  name: "check_out",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "date",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['withdraw_name'],
                                  name: "fullname",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "text",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_email'],
                                  name: "email",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "text",                          // text, textarea, select, radio, checkbox, password
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                },{
                                  label: absdashboardtext['reservations_phone'],
                                  name: "phone",
                                  value: '',    // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "phone",                          // text, textarea, select, radio, checkbox, password
                                  country: abookingsystemdashboardReservations.data.country,
                                  countries: abookingsystemdashboardReservations.data.countries,
                                  options: {},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"              // left, right, left_full, right_full
                                }]

                    };
                }

                // Start Form
                abookingsystemdashboardInfo.start(absdashboardtext['reservations_add_details'],
                                 addReservationForm,
                                 absdashboardtext['add_space_add'],
                                 absdashboardtext['cancel'],
                                 abookingsystemdashboardReservations.reservation.save,
                                 undefined,
                                 'absd-selected');
            }
        },
        save: function(){
            var fields = abookingsystemdashboardForm.fields.get();
        
            if(fields !== "error"){
                
                // Start Loader
                abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                   absdashboardtext['wait']);

                $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['add_reservation'],
                                            is_ajax_request: true,
                                            check_in: fields['check_in'] <= fields['check_out'] ? fields['check_in']:fields['check_out'],
                                            check_out: fields['check_out'] >= fields['check_in'] ? fields['check_out']:fields['check_in'],
                                            space: fields['space'],
                                            rooms: fields['rooms'] !== undefined ? fields['rooms']:'',
                                            fullname: fields['fullname'],
                                            email: fields['email'],
                                            phone: fields['phone'],
                                            ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                    data = JSON.parse(data);

                    if(data['status'] === "success"){
                        // Stop Loader
                        abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                           absdashboardtext['save_success'],
                                           true);
                        
                        // Reload reservations
                        abookingsystemdashboardReservations.list();
                    } else if(data['status'] === 'error_availability'){
                        var warningMessage = new Array();

                        warningMessage.push(absdashboardtext['warning_overbooking'].split('%s').join(data['calendar']));

                        abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                            warningMessage.join(''),
                                            10);
                    }

                });
            }
        },
        cancel: function(id, 
                         api_key, 
                         email){
            // Add Reservation
            var cancelReservationForm = {
                name: "cancel_reservation",
                fields: [{
                          label: '',
                          name: "id",
                          value: id,    // default value
                          placeholder: "",  
                          required: "false",
                          allowed_characters: "",
                          min_chars: 0,     // 0 - disabled
                          max_chars: 0,     // 0 - disabled
                          is_email: "false",
                          is_phone: "false",
                          type: "hidden",                          // text, textarea, select, radio, checkbox, password
                          options: {},     // select options
                          label_class: "",
                          input_class: "",
                          hint: "",
                          label_position: "left"              // left, right, left_full, right_full
                        },
                        {
                          label: '',
                          name: "api_key",
                          value: api_key,    // default value
                          placeholder: "",  
                          required: "false",
                          allowed_characters: "",
                          min_chars: 0,     // 0 - disabled
                          max_chars: 0,     // 0 - disabled
                          is_email: "false",
                          is_phone: "false",
                          type: "hidden",                          // text, textarea, select, radio, checkbox, password
                          options: {},     // select options
                          label_class: "",
                          input_class: "",
                          hint: "",
                          label_position: "left"              // left, right, left_full, right_full
                        },
                        {
                          label: '',
                          name: "email",
                          value: email,    // default value
                          placeholder: "",  
                          required: "false",
                          allowed_characters: "",
                          min_chars: 0,     // 0 - disabled
                          max_chars: 0,     // 0 - disabled
                          is_email: "false",
                          is_phone: "false",
                          type: "hidden",                          // text, textarea, select, radio, checkbox, password
                          options: {},     // select options
                          label_class: "",
                          input_class: "",
                          hint: "",
                          label_position: "left"              // left, right, left_full, right_full
                        },
                        {
                          label: absdashboardtext['reservations_cancel_reason'],
                          name: "reason",
                          value: 'overbooking',    // default value
                          placeholder: "",  
                          required: "true",
                          allowed_characters: "",
                          min_chars: 0,     // 0 - disabled
                          max_chars: 0,     // 0 - disabled
                          is_email: "false",
                          is_phone: "false",
                          type: "select",                          // text, textarea, select, radio, checkbox, password
                          options: abookingsystemdashboardGeneral.select.optionsLower(['Overbooking', 'Other']),     // select options
                          label_class: "",
                          input_class: "",
                          hint: "",
                          label_position: "left"              // left, right, left_full, right_full
                        }]

            };
              
            // Start Form
            abookingsystemdashboardInfo.start(absdashboardtext['reservations_cancel_txt'],
                             cancelReservationForm,
                             absdashboardtext['yes'],
                             absdashboardtext['no'],
                             abookingsystemdashboardReservations.reservation.cancel_ok,
                             undefined,
                             'absd-selected');
        },
        cancel_ok: function(){
            var fields = abookingsystemdashboardForm.fields.get();
        
            if(fields !== "error"){
                
                // Start Loader
                abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                   absdashboardtext['wait']);

                $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['cancel_reservation_by_host'],
                                            is_ajax_request: true,
                                            id: fields['id'],
                                            api_key: fields['api_key'],
                                            email: fields['email'],
                                            reason: fields['reason'],
                                            ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                    data = JSON.parse(data);

                    if(data['status'] === "success"){
                        // Stop Loader
                        abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                          absdashboardtext['reservation_cancel_success'],
                                          true);
                        
                        // Reload reservations
                        abookingsystemdashboardReservations.list();
                        $.magnificPopup.close();
                    }

                });
            }
        },
        events: function(){
            $('.absd-cancel-reservation').unbind('click');
            $('.absd-cancel-reservation').bind('click', function(){
                abookingsystemdashboardReservations.reservation.cancel($(this).attr('data-id'), $(this).attr('data-api-key'), $(this).attr('data-email'));
            }); 
        }
    }
  };
  
  window.abookingsystemdashboardReservations = abookingsystemdashboardReservations;
  
})(jQuery); 