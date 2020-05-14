
(function($){
  
  var abookingsystemdashboardTickets = {
    data: {
      tickets: "",
      page: 0,
      per_page: 10,
      no_replies: 0,
      no_replies_loaded: 0,
      skip_replies: 0,
      ticket_data: {},
      replies: [],
      search: "",    // search word
      current: {
        ticket_id: 0,
        api_key: ''
      },
      deleted: {
        ticket_id: 0,
        api_key: ''
      }
    },
    list: function(){
        
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                               absdashboardtext['wait']);
                                
            $.get(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['tickets'],
                                        is_ajax_request: true,
                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                data = JSON.parse(data);
              
                abookingsystemdashboardTickets.search.group_tickets(data);
            
                // View Tickets -> Search start
                abookingsystemdashboardTickets.search.start();
                
                abookingsystemdashboardTickets.ticket.setup.view.header.start();
              
                // Stop Loader
                abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                   absdashboardtext['refresh'],
                                   true);
              
            });
    },
    events: function() {
        $('.absd-element h3').unbind('click');
        $('.absd-element h3').bind('click', function(){
            
          
            $('.absd-group').removeClass('absd-opened');    
            $('.absd-element').removeClass('absd-opened');   
            
            abookingsystemdashboardTickets['data']['current']['ticket_id'] = $(this).parent().attr('data-ticket-id'); 
            abookingsystemdashboardTickets['data']['current']['api_key'] = $(this).parent().attr('data-api-key'); 
          
            $('#absd-ticket-'+abookingsystemdashboardTickets['data']['current']['ticket_id']).addClass('absd-opened');  
            
            abookingsystemdashboardTickets.ticket.setup.start();     
        });
      
        $('.absd-ticket-actions .absd-delete').unbind('click');
        $('.absd-ticket-actions .absd-delete').bind('click', function(e){
          
            
            abookingsystemdashboardTickets['data']['deleted']['ticket_id'] = $(this).parent().parent().parent().attr('data-ticket-id'); 
            abookingsystemdashboardTickets['data']['deleted']['api_key'] = $(this).parent().parent().parent().attr('data-api-key'); 
     
            var deleteTicketForm = {
                name: "delete_ticket",
                fields: [
                  {
                    label: "",
                    name: "ticket_id",
                    value: abookingsystemdashboardTickets['data']['deleted']['ticket_id'],        // default value
                    placeholder: "",  
                    required: "false",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "hidden",                            // text, textarea, select, radio, checkbox, password
                    options: {},     // select options
                    label_class: "",
                    input_class: "absd_ticket_id",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  },
                  {
                    label: "",
                    name: "api_key",
                    value: abookingsystemdashboardTickets['data']['deleted']['api_key'],        // default value
                    placeholder: "",  
                    required: "false",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "hidden",                            // text, textarea, select, radio, checkbox, password
                    options: {},     // select options
                    label_class: "",
                    input_class: "absd_api_key",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  }]

            };
            // Start Form
            abookingsystemdashboardInfo.start(absdashboardtext['delete'],
                         deleteTicketForm,
                         absdashboardtext['yes'],
                         absdashboardtext['cancel'],
                         abookingsystemdashboardTickets.ticket.delete_ok);
        });
    },
    ticket: {
      view: function(data){
          var status_class = 'support-status-unanswered';
          if (data.answered === "true") {
            status_class = 'support-status-answered';
          }
          if (data.closed === "true") {
            status_class = 'support-status-closed';
          }
          if (data.status !== "unsolved") {
            status_class = 'support-status-resolved';
          }
          var HTML = new Array();
          HTML.push('<div class="absd-element '+status_class+'" id="absd-ticket-'+data['id']+'" data-ticket-id="'+data['id']+'" data-api-key="'+data['api_key']+'">');
          HTML.push('   <h3>');
          HTML.push(    data['title']);
          HTML.push('   </h3>');
          HTML.push('   <div class="absd-ticket-actions-holder">');
          HTML.push('       <div class="absd-ticket-actions">');
          HTML.push('           <span class="absd-delete"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['delete_button']+'</span></span>');
          HTML.push('       </div>');
          HTML.push('   </div>');
          HTML.push('</div>');
        
          HTML.push('</div>');
        
          return HTML.join('');
      },
      add: function(){
          // Add Ticket
          var addTicketForm = {
              name: "create_ticket",
              fields: [{
                  label: absdashboardtext['ticket_subject'],
                  name: "title",
                  value: absdashboardtext['ticket_subject'],  // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  type: "text",                            // text, textarea, select, radio, checkbox, password
                  options: {0: {"name": "", "value": ""}},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                },
                {
                  label: absdashboardtext['ticket_problem'],
                  name: "content",
                  value: "",        // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  type: "textarea",                            // text, textarea, select, radio, checkbox, password
                  options: {},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                }]

          };

          // Start Form
          abookingsystemdashboardInfo.start(absdashboardtext['new_ticket'],
                       addTicketForm,
                       absdashboardtext['create_ticket'],
                       absdashboardtext['cancel'],
                       abookingsystemdashboardTickets.ticket.add_ok);
      },
      add_ok: function(){
          var fields = abookingsystemdashboardForm.fields.get();
        
          if(fields !== "error"){
              // Start Loader
              abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                 absdashboardtext['wait']);
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['add_ticket'],
                                          is_ajax_request: true,
                                          title: fields['title'],
                                          content: fields['content'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                  data = JSON.parse(data);
                
                  if(data.status === "success"){
                      abookingsystemdashboardTickets.search.add(data.data[0]);
                  }

                  // Stop Loader
                  abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                     absdashboardtext['refresh'],
                                     true);

              });
          }
      },
      delete_ok: function(){
          var fields = abookingsystemdashboardForm.fields.get();
        
          if(fields !== "error"){
              // Start Loader
              abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                 absdashboardtext['wait']);
              
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['delete_ticket'],
                                          is_ajax_request: true,
                                          id: fields['ticket_id'],
                                          api_key: fields['api_key'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                  data = JSON.parse(data);
                
                  if(data.status === "success"){
                      // Stop Loader
                      abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                         absdashboardtext['deleted'],
                                         true);
                    
                      // Research
                      abookingsystemdashboardTickets.search.delete(fields['api_key']);
                      
                  } else {
                      var warningMessage = new Array();
                    
                      warningMessage.push(absdashboardtext['warning_delete']);
                      warningMessage.push('<a href="'+abookingsystemdashboard['support_role']+'">'+absdashboardtext['warning_contact']+'</a>');

                      abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                          warningMessage.join(''),
                                          10);
                  }

              });
          }
      },
      setup:{
        start: function(){
            $('#absd-tickets-content').html('');
            abookingsystemdashboardTickets.ticket.setup.view.start();
            abookingsystemdashboardTickets.ticket.setup.events();
        },
        view: {
            start: function(){
                var HTML = new Array();
                abookingsystemdashboardTickets.ticket.setup.view.header.start();
                abookingsystemdashboardTickets.ticket.setup.view.content.start();
            },
            header: {
                start: function(){
                    var HTML = new Array();
                    
                    HTML.push('<div class="absd-header">');
                    HTML.push('<div class="absd-header-left">');
                    HTML.push('<div class="absd-header-status"><p><span class="status-unanswered"></span>'+absdashboardtext['status_unanswered']+'</p></div>');
                    HTML.push('<div class="absd-header-status"><p><span class="status-answered"></span>'+absdashboardtext['status_answered']+'</p></div>');
                    HTML.push('<div class="absd-header-status"><p><span class="status-resolved"></span>'+absdashboardtext['status_resolved']+'</p></div>');
                    HTML.push('</div>');
                    HTML.push('<div class="absd-header-right">');
                    HTML.push('<p>'+absdashboardtext['working_hours']+'</p>');
                    HTML.push('<p>'+absdashboardtext['monday_saturday']+'</p>');
                    HTML.push('<p>'+absdashboardtext['active_hours']+'</p>');
                    HTML.push('</div>');
                    HTML.push('</div>');  
                    
                    $('#absd-tickets-content').append(HTML.join(''));
                }
            },
            content: {
                start: function(){
                    var HTML = new Array();
                    
                    HTML.push('<div id="absd-tickets-content-box" class="absd-content-settings">');  
                    HTML.push('   <div class="absd-content-settings-box"></div>');  
                    HTML.push('</div>');  
                    
                    $('#absd-tickets-content').append(HTML.join(''));
                    
                   // Replies
                    abookingsystemdashboardTickets.ticket.setup.view.content.replies.start();
                },
                replies: {
                    data: {},
                    start: function(){
                      // Start Loader
                      abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                         absdashboardtext['wait']);
                        
                      // Reset Replies
                      abookingsystemdashboardTickets.data.replies = [];
                      abookingsystemdashboardTickets.data.no_replies = 0;
                      abookingsystemdashboardTickets.data.no_replies_loaded = 0;
                      abookingsystemdashboardTickets.data.skip_replies = 0;

                      $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['ticket'],
                                                  is_ajax_request: true,
                                                  ajax_ses: abookingsystemdashboard['ajax_ses'],
                                                  ticket_id: abookingsystemdashboardTickets['data']['current']['ticket_id'],
                                                  no_replies: abookingsystemdashboardTickets.data.per_page,
                                                  skip_replies: abookingsystemdashboardTickets.data.skip_replies,
                                                  api_key: abookingsystemdashboardTickets['data']['current']['api_key']}, function(data){
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.data = data;
                          data = JSON.parse(data);
                          
                          abookingsystemdashboardTickets.data.no_replies = data['no_replies'];
                          
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.load(data);
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.show();
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.events();
                        

                          // Stop Loader
                          abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                             absdashboardtext['refresh'],
                                             true);

                      });
                    },
                    more: function(){
                      var ticketData = JSON.parse(abookingsystemdashboardTickets.ticket.setup.view.content.replies.data),
                          repliesData = ticketData['replies'],
                          newTicketData = {answered: ticketData['answered'],
                                           api_key: ticketData['api_key'],
                                           closed: ticketData['closed'],
                                           content: ticketData['content'],
                                           created_time: ticketData['created_time'],
                                           id: ticketData['id'],
                                           last_reply_user: ticketData['last_reply_user'],
                                           last_update_time: ticketData['last_update_time'],
                                           no_replies: ticketData['no_replies'],
                                           replies: [],
                                           status: ticketData['status'],
                                           tid: ticketData['tid'],
                                           title: ticketData['title'],
                                           user_id: ticketData['user_id'],
                                           username: ticketData['username']};
                      // Start Loader
                      abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                         absdashboardtext['wait']);
            
                        // Next Replies
                        abookingsystemdashboardTickets.data.skip_replies = abookingsystemdashboardTickets.data.skip_replies+abookingsystemdashboardTickets.data.per_page;

                      $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['more_replies'],
                                                  is_ajax_request: true,
                                                  ajax_ses: abookingsystemdashboard['ajax_ses'],
                                                  ticket_id: abookingsystemdashboardTickets['data']['current']['ticket_id'],
                                                  no_replies: abookingsystemdashboardTickets.data.per_page,
                                                  skip_replies: abookingsystemdashboardTickets.data.skip_replies,
                                                  api_key: abookingsystemdashboardTickets['data']['current']['api_key']}, function(data){
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.data = data;
                          data = JSON.parse(data);
                          
                          // Save replies
                          for(var rkey in data['data']['replies']){
                            repliesData.push(data['data']['replies'][rkey]);
                            newTicketData['replies'].push(data['data']['replies'][rkey]);
                          }
                          
                          ticketData['replies'] = repliesData;
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.data = JSON.stringify(ticketData);
                          
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.load(newTicketData);
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.show();
                          abookingsystemdashboardTickets.ticket.setup.view.content.replies.events();
                        
                          // Stop Loader
                          abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                             absdashboardtext['refresh'],
                                             true);

                      });
                    },
                    show: function(){
                        var repliesData = abookingsystemdashboardTickets.data.replies,
                            data = abookingsystemdashboardTickets.data.ticket_data,
                            accordionsData = [],
                            accordionData = {},
                            ID = abookingsystemdashboardTickets['data']['current']['ticket_id'];
                      
                            $('.absd-content-settings-box').html('');
                            $('.absd-content-settings-box').append('<div class="ticket_close_container-'+ID+' absd-ticket-close" data-api-key="'+data['api_key']+'" data-ticket-close="'+data['closed']+'" data-ticket-id="'+ID+'"><span class="absd-close-ticket'+(data['closed'] === 'true' ? '':' absd-selected')+'">'+absdashboardtext['close_ticket']+'</span><span class="absd-open-ticket'+(data['closed'] === 'false' ? '':' absd-selected')+'">'+absdashboardtext['open_ticket']+'</span></div>');
                            $('.absd-content-settings-box').append('<div class="ticket_status_container-'+ID+' absd-ticket-status"></div>');
                            $('.absd-content-settings-box').append('<div class="ticket_main_container-'+ID+'"></div>');
                            $('.absd-content-settings-box').append('<div class="ticket_replies_container-'+ID+'"></div>');
                            $('.absd-content-settings-box').append('<div class="ticket_replies_more-'+ID+'"></div>');
                            $('.absd-content-settings-box').append('<div class="ticket_reply_message_container-'+ID+'"></div>');
                        
                        
                        
                            // More replies button
                            if(abookingsystemdashboardTickets.data.no_replies_loaded < abookingsystemdashboardTickets.data.no_replies) {
                                $('.ticket_replies_more-'+ID).html('<div class="absd-button absd-more-button absd-more-replies">'+absdashboardtext['more']+'</div>');
                            }
                            
                            accordionData = {label: '<b>'+data['username']+':</b> '+data['title'],
                                             name: 'ticket_'+ID,
                                             data_time: data['created_time'],
                                             class: 'absd-topic absd-opened',
                                             content: data['content'],
                                             delete: true,
                                             ticket_id: ID,
                                             reply_id: 0,
                                             api_key: data['api_key']};
                      
                            accordionsData.push(accordionData);
                      
                            abookingsystemdashboardAccordion.start($('.ticket_main_container-'+ID), accordionsData);
                            accordionsData = [];
                            // Add replies
                            for(var key in repliesData) {
                                accordionData = {label: (repliesData[key]['uid'] === abookingsystemdashboard['bookeu_user_id']) ? '<b>'+repliesData[key]['username']+'</b>':'<i style="color: #019900;">'+(abookingsystemdashboard["account_type"] === 'network' ? repliesData[key]['username']:'Support Team')+'</i>',
                                                 name: 'reply_'+repliesData[key]['id'],
                                                 data_time: repliesData[key]['created'],
                                                 class: 'absd-black absd-opened',
                                                 content: repliesData[key]['content'],
                                                 delete: repliesData[key]['uid'] === abookingsystemdashboard['bookeu_user_id'] ? true:false,
                                                 ticket_id: ID,
                                                 reply_id: repliesData[key]['id'],
                                                 api_key: data['api_key']};
                      
                                accordionsData.push(accordionData);
                            }
                        
                            $('.ticket_replies_container-'+ID).html('');
                      
                            abookingsystemdashboardAccordion.start($('.ticket_replies_container-'+ID), accordionsData);
                            
                            accordionsData = [];
                      
                            accordionData = {label: '<b>'+absdashboardtext['your_reply']+'</b>',
                                             class: 'absd-black absd-opened',
                                             name: 'reply_message'};
                      
                            accordionsData.push(accordionData);
                      
                            abookingsystemdashboardAccordion.start($('.ticket_reply_message_container-'+ID), accordionsData);
                            var statusData = [];
                      
                                statusData[0] = [];
                                statusData[0]['value'] = 'unsolved';
                                statusData[0]['name'] = absdashboardtext['status_unsolved'];
                                statusData[1] = [];
                                statusData[1]['value'] = 'solved';
                                statusData[1]['name'] = absdashboardtext['status_solved'];
                                statusData[2] = [];
                                statusData[2]['value'] = 'not_possible_yet';
                                statusData[2]['name'] = absdashboardtext['status_not_possible_yet'];
                                statusData[3] = [];
                                statusData[3]['value'] = 'not_answered';
                                statusData[3]['name'] = absdashboardtext['status_not_answered'];
                            
                            var defaultStatusForm = {
                                name: "ticket_change_status_"+ID,
                                fields: [{label: absdashboardtext['status'],
                                          name: "ticket_status"+ID,
                                          value: data['status'],        // default value
                                          modify: "abookingsystemdashboardTickets.ticket.setup.view.content.replies.modify('ticket_change_status', 'status', window.absdSelectedValue)",
                                          placeholder: "",  
                                          required: "false",
                                          allowed_characters: "",
                                          min_chars: 0,     // 0 - disabled
                                          max_chars: 0,     // 0 - disabled
                                          is_email: "false",
                                          is_phone: "false",
                                          type: "select",                            // text, textarea, select, radio, checkbox, password
                                          options: abookingsystemdashboardGeneral.select.optionsValues(statusData),     // select options : abookingsystemdashboardCalendars.data.categories
                                          label_class: "",
                                          input_class: "",
                                          hint: "",
                                          label_position: "left"         // left, right, left_full, right_full
                                          }]

                                };
                                
                        abookingsystemdashboardForm.start($('.ticket_status_container-'+ID), defaultStatusForm);
                        
                        if(data['closed'] === 'false') {
                            // Create Reply form
                            var defaultReplyForm = {
                                name: "replies_reply_"+ID,
                                fields: [{label: "",
                                          name: "ticket_id",
                                          value: ID,        // default value
                                          modify: "",
                                          placeholder: '',  
                                          required: "false",
                                          allowed_characters: "",
                                          min_chars: 0,     // 0 - disabled
                                          max_chars: 0,     // 0 - disabled
                                          is_email: "false",
                                          is_phone: "false",
                                          is_numeric: "false",
                                          type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                          options:  {0: {"name": "", "value": ""}},     // select options
                                          label_class: "",
                                          input_class: "",
                                          hint: "",
                                          label_position: "left"         // left, right, left_full, right_full
                                        },
                                        {
                                          label: absdashboardtext['reply_message'],
                                          name: "reply_message",
                                          value: '',        // default value
                                          placeholder: absdashboardtext['reply_message_hint'],  
                                          required: "true",
                                          allowed_characters: "",
                                          min_chars: 0,     // 0 - disabled
                                          max_chars: 0,     // 0 - disabled
                                          is_email: "false",
                                          is_phone: "false",
                                          is_numeric: "false",
                                          type: "textarea",                            // text, textarea, select, radio, checkbox, password
                                          options:  {0: {"name": "", "value": ""}},     // select options
                                          label_class: "",
                                          input_class: "",
                                          hint: "",
                                          label_position: "left"         // left, right, left_full, right_full
                                        },
                                        {
                                          label: absdashboardtext['send'],
                                          name: "reply_send",
                                          value: '',        // default value
                                          placeholder: "",  
                                          action: "abookingsystemdashboardTickets.ticket.setup.view.content.replies.save()",
                                          required: "false",
                                          allowed_characters: "",
                                          min_chars: 0,     // 0 - disabled
                                          max_chars: 0,     // 0 - disabled
                                          is_email: "false",
                                          is_phone: "false",
                                          is_numeric: "false",
                                          type: "button",                            // text, textarea, select, radio, checkbox, password
                                          options:  {0: {"name": "", "value": ""}},     // select options
                                          label_class: "",
                                          input_class: "",
                                          hint: "",
                                          label_position: "left"         // left, right, left_full, right_full
                                        }]

                            };

                            abookingsystemdashboardForm.start($('#absd-accordion-reply_message-content .absd-accordion-content-box'), defaultReplyForm);
                        }
                    },
                    load: function(data,
                                   first_load){
                        var repliesData = data['replies'],
                            accordionsData = [],
                            accordionData = {},
                            ID = abookingsystemdashboardTickets['data']['current']['ticket_id'];
                            
                            abookingsystemdashboardTickets.data.ticket_data = data;

                            // Add replies
                            for(var key in repliesData) {
                                
                                if(first_load === undefined) {
                                    abookingsystemdashboardTickets.data.replies.push(repliesData[key]);
                                } else if(first_load === 'add'){
                                    abookingsystemdashboardTickets.data.replies.unshift(repliesData[key]);
                                } else if(first_load === 'delete'){
                                    abookingsystemdashboardTickets.data.replies = data['replies'];
                                }
                                abookingsystemdashboardTickets.data.no_replies_loaded++;
                            }
                    },
                    modify: function(key,
                                     field,
                                     value){
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);
  
                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['change_ticket'],
                                                    is_ajax_request: true,
                                                    ticket_id: abookingsystemdashboardTickets['data']['current']['ticket_id'],
                                                    api_key: abookingsystemdashboardTickets['data']['current']['api_key'],
                                                    field: field,
                                                    data: value,
                                                    ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                          
                            data = JSON.parse(data);
                            
                            if(data['status'] === "success"){
                                
                                // Stop Loader
                                abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                                   absdashboardtext['save_success'],
                                                   true);
                            }

                        });
                    },
                    save: function(){
                        var ticketData = JSON.parse(abookingsystemdashboardTickets.ticket.setup.view.content.replies.data),
                            repliesData = ticketData['replies'],
                            newTicketData = {answered: ticketData['answered'],
                                             api_key: ticketData['api_key'],
                                             closed: ticketData['closed'],
                                             content: ticketData['content'],
                                             created_time: ticketData['created_time'],
                                             id: ticketData['id'],
                                             last_reply_user: ticketData['last_reply_user'],
                                             last_update_time: ticketData['last_update_time'],
                                             no_replies: ticketData['no_replies'],
                                             replies: [],
                                             status: ticketData['status'],
                                             tid: ticketData['tid'],
                                             title: ticketData['title'],
                                             user_id: ticketData['user_id'],
                                             username: ticketData['username']},
                            ID = abookingsystemdashboardTickets['data']['current']['ticket_id'];
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);
                        
                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['add_reply'],
                                                    is_ajax_request: true,
                                                    ticket_id: abookingsystemdashboardTickets['data']['current']['ticket_id'],
                                                    api_key: abookingsystemdashboardTickets['data']['current']['api_key'],
                                                    content: $('#absd-form-replies_reply_'+abookingsystemdashboardTickets['data']['current']['ticket_id']+'-reply_message').val(),
                                                    ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                          
                            
                            if(data !== "error"){
                                data = JSON.parse(data);

                                if(data['status'] === "success"){
                                    $('#absd-form-replies_reply_'+abookingsystemdashboardTickets['data']['current']['ticket_id']+'-reply_message').val('');
                                    
                                    abookingsystemdashboardTickets.data.skip_replies++;

                                    // Save reply
                                    repliesData.push(data['data'][0]);
                                    newTicketData['replies'].push(data['data'][0]);
                                    ticketData['replies'] = repliesData;
                                    abookingsystemdashboardTickets.ticket.setup.view.content.replies.data = JSON.stringify(ticketData);

                                    // Show replies
                                    abookingsystemdashboardTickets.ticket.setup.view.content.replies.load(newTicketData, 'add');
                                    abookingsystemdashboardTickets.ticket.setup.view.content.replies.show();
                                    abookingsystemdashboardTickets.ticket.setup.view.content.replies.events();
                                    
                                    // Scroll to top
                                    $('html, body').animate({
                                        scrollTop: $('.absd-content-settings-box').offset().top
                                    }, 1000);

                                    // Stop Loader
                                    abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                                       absdashboardtext['save_success'],
                                                       true);
                                } 
                            } else {
                                var warningMessage = new Array();

                                    warningMessage.push(absdashboardtext['reply_message_required']);

                                    abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                                        warningMessage.join(''),
                                                        10);
                            }

                        });
                    },
                    delete_ok: function(){
                        var fields = abookingsystemdashboardForm.fields.get();

                        if(fields !== "error"){
                            // Start Loader
                            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                               absdashboardtext['wait']);

                            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['delete_reply'],
                                                        is_ajax_request: true,
                                                        ticket_id: fields['ticket_id'],
                                                        id: fields['reply_id'],
                                                        api_key: fields['api_key'],
                                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                                data = JSON.parse(data);

                                if(data.status === "success"){
                                    // Stop Loader
                                    abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                                       absdashboardtext['deleted'],
                                                       true);
                                    
                                    // Delete & refresh replies
                                    abookingsystemdashboardTickets.ticket.setup.view.content.replies.delete(fields['reply_id']);

                                } else {
                                    var warningMessage = new Array();

                                    warningMessage.push(absdashboardtext['warning_delete']);
                                    warningMessage.push('<a href="'+abookingsystemdashboard['support_role']+'">'+absdashboardtext['warning_contact']+'</a>');

                                    abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                                        warningMessage.join(''),
                                                        10);
                                }

                            });
                        }
                    },
                    delete: function(id){
                        var ticketData = JSON.parse(abookingsystemdashboardTickets.ticket.setup.view.content.replies.data),
                            repliesData = ticketData['replies'],
                            newRepliesData = [],
                            newTicketData = {answered: ticketData['answered'],
                                             api_key: ticketData['api_key'],
                                             closed: ticketData['closed'],
                                             content: ticketData['content'],
                                             created_time: ticketData['created_time'],
                                             id: ticketData['id'],
                                             last_reply_user: ticketData['last_reply_user'],
                                             last_update_time: ticketData['last_update_time'],
                                             no_replies: ticketData['no_replies'],
                                             replies: [],
                                             status: ticketData['status'],
                                             tid: ticketData['tid'],
                                             title: ticketData['title'],
                                             user_id: ticketData['user_id'],
                                             username: ticketData['username']};
                      
                        for(var key in repliesData) {
                            
                            if(parseInt(repliesData[key]['id']) !== parseInt(id)) {
                                newTicketData['replies'].push(repliesData[key]);
                            }
                        }
                        
                        abookingsystemdashboardTickets.data.skip_replies--;
                        
                        abookingsystemdashboardTickets.ticket.setup.view.content.replies.data = JSON.stringify(newTicketData);
                              
                        // Show replies
                        abookingsystemdashboardTickets.ticket.setup.view.content.replies.load(newTicketData, 'delete');
                        abookingsystemdashboardTickets.ticket.setup.view.content.replies.show();
                        abookingsystemdashboardTickets.ticket.setup.view.content.replies.events();
                    },
                    events: function(){
                        
                        $('.absd-ticket-actions .absd-delete-ticket-reply').unbind('click');
                        $('.absd-ticket-actions .absd-delete-ticket-reply').bind('click', function(e){


                            abookingsystemdashboardTickets['data']['deleted']['ticket_id'] = parseInt($(this).attr('data-ticket-id')); 
                            abookingsystemdashboardTickets['data']['deleted']['reply_id'] = parseInt($(this).attr('data-reply-id')); 
                            abookingsystemdashboardTickets['data']['deleted']['api_key'] = $(this).attr('data-api-key'); 

                            if(abookingsystemdashboardTickets['data']['deleted']['reply_id'] === 0) {
                                var deleteTicketForm = {
                                    name: "delete_ticket",
                                    fields: [
                                      {
                                        label: "",
                                        name: "ticket_id",
                                        value: abookingsystemdashboardTickets['data']['deleted']['ticket_id'],        // default value
                                        placeholder: "",  
                                        required: "false",
                                        allowed_characters: "",
                                        min_chars: 0,     // 0 - disabled
                                        max_chars: 0,     // 0 - disabled
                                        is_email: "false",
                                        is_phone: "false",
                                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                        options: {},     // select options
                                        label_class: "",
                                        input_class: "absd_ticket_id",
                                        hint: "",
                                        label_position: "left"         // left, right, left_full, right_full
                                      },
                                      {
                                        label: "",
                                        name: "api_key",
                                        value: abookingsystemdashboardTickets['data']['deleted']['api_key'],        // default value
                                        placeholder: "",  
                                        required: "false",
                                        allowed_characters: "",
                                        min_chars: 0,     // 0 - disabled
                                        max_chars: 0,     // 0 - disabled
                                        is_email: "false",
                                        is_phone: "false",
                                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                        options: {},     // select options
                                        label_class: "",
                                        input_class: "absd_api_key",
                                        hint: "",
                                        label_position: "left"         // left, right, left_full, right_full
                                      }]

                                };
                                // Start Form
                                abookingsystemdashboardInfo.start(absdashboardtext['delete'],
                                             deleteTicketForm,
                                             absdashboardtext['yes'],
                                             absdashboardtext['cancel'],
                                             abookingsystemdashboardTickets.ticket.delete_ok);
                            } else {
                                var deleteReplyForm = {
                                    name: "delete_ticket",
                                    fields: [
                                      {
                                        label: "",
                                        name: "ticket_id",
                                        value: abookingsystemdashboardTickets['data']['deleted']['ticket_id'],        // default value
                                        placeholder: "",  
                                        required: "false",
                                        allowed_characters: "",
                                        min_chars: 0,     // 0 - disabled
                                        max_chars: 0,     // 0 - disabled
                                        is_email: "false",
                                        is_phone: "false",
                                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                        options: {},     // select options
                                        label_class: "",
                                        input_class: "absd_ticket_id",
                                        hint: "",
                                        label_position: "left"         // left, right, left_full, right_full
                                      },
                                      {
                                        label: "",
                                        name: "reply_id",
                                        value: abookingsystemdashboardTickets['data']['deleted']['reply_id'],        // default value
                                        placeholder: "",  
                                        required: "false",
                                        allowed_characters: "",
                                        min_chars: 0,     // 0 - disabled
                                        max_chars: 0,     // 0 - disabled
                                        is_email: "false",
                                        is_phone: "false",
                                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                        options: {},     // select options
                                        label_class: "",
                                        input_class: "absd_reply_id",
                                        hint: "",
                                        label_position: "left"         // left, right, left_full, right_full
                                      },
                                      {
                                        label: "",
                                        name: "api_key",
                                        value: abookingsystemdashboardTickets['data']['deleted']['api_key'],        // default value
                                        placeholder: "",  
                                        required: "false",
                                        allowed_characters: "",
                                        min_chars: 0,     // 0 - disabled
                                        max_chars: 0,     // 0 - disabled
                                        is_email: "false",
                                        is_phone: "false",
                                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                        options: {},     // select options
                                        label_class: "",
                                        input_class: "absd_api_key",
                                        hint: "",
                                        label_position: "left"         // left, right, left_full, right_full
                                      }]

                                };
                                // Start Form
                                abookingsystemdashboardInfo.start(absdashboardtext['delete'],
                                             deleteReplyForm,
                                             absdashboardtext['yes'],
                                             absdashboardtext['cancel'],
                                             abookingsystemdashboardTickets.ticket.setup.view.content.replies.delete_ok);
                            }
                        });
                        
                        $('.absd-ticket-close').unbind('click');
                        $('.absd-ticket-close').bind('click', function(e){
                            var ticketData = JSON.parse(abookingsystemdashboardTickets.ticket.setup.view.content.replies.data);
                            abookingsystemdashboardTickets['data']['current']['ticket_id'] = parseInt($(this).attr('data-ticket-id')); 
                            abookingsystemdashboardTickets['data']['current']['closed'] = $(this).attr('data-ticket-close'); 
                            abookingsystemdashboardTickets['data']['current']['api_key'] = $(this).attr('data-api-key'); 
                            
                            var tempClosed = abookingsystemdashboardTickets['data']['current']['closed'] === 'true' ? 'false':'true',
                                status_class = 'support-status-unanswered';
                              
                            if (ticketData.answered === "true") {
                              status_class = 'support-status-answered';
                            }

                            if (tempClosed === "true") {
                              status_class = 'support-status-closed';
                            }

                            if (ticketData.status !== "unsolved") {
                              status_class = 'support-status-resolved';
                            }
                          
                            $(this).attr('data-ticket-close', tempClosed);

                            if(tempClosed === 'true') {
                                $('.absd-close-ticket').removeClass('absd-selected');
                                $('.absd-open-ticket').addClass('absd-selected');
                                $('#absd-ticket-'+abookingsystemdashboardTickets['data']['current']['ticket_id']).removeClass('support-status-unanswered');
                                $('#absd-ticket-'+abookingsystemdashboardTickets['data']['current']['ticket_id']).removeClass('support-status-answered');
                                $('#absd-ticket-'+abookingsystemdashboardTickets['data']['current']['ticket_id']).removeClass('support-status-resolved');
                                $('#absd-ticket-'+abookingsystemdashboardTickets['data']['current']['ticket_id']).addClass('support-status-closed');
                            } else {
                                $('.absd-close-ticket').addClass('absd-selected');
                                $('.absd-open-ticket').removeClass('absd-selected');
                                $('#absd-ticket-'+abookingsystemdashboardTickets['data']['current']['ticket_id']).removeClass('support-status-closed');
                                $('#absd-ticket-'+abookingsystemdashboardTickets['data']['current']['ticket_id']).addClass(status_class);
                            }
                            
                            abookingsystemdashboardTickets.ticket.setup.view.content.replies.modify('ticket_close_open', 'closed', tempClosed);
                        });
                        
                        $('.absd-more-replies').unbind('click');
                        $('.absd-more-replies').bind('click', function(){
                            abookingsystemdashboardTickets.ticket.setup.view.content.replies.more();          
                        });
                    }
                }
            }
        },
        events: function(){
            $('#ticket-settings-menu .absd-link').unbind('click');
            $('#ticket-settings-menu .absd-link').bind('click', function(){
                abookingsystemdashboardTickets['data']['subpage'] = $(this).attr('data-type');
                abookingsystemdashboardTickets.ticket.setup.start();          
            });
        }
      }
    },
    search: {
      start: function(){
          var tickets = abookingsystemdashboardTickets['data']['tickets'],
              searchWord = abookingsystemdashboardTickets['data']['search'],
              page = abookingsystemdashboardTickets['data']['page'],
              per_page = abookingsystemdashboardTickets['data']['per_page'],
              total_items = 0,
              count_items = 0,
              start_item = (page == 0)?page:page*per_page;
          
          $('.absd-tickets-holder').html('');
          $('#absd-tickets-content').html('');
        
          for(var i in tickets){
              var HTML = new Array();
            
              // Search for word x if is not empty
              if(tickets[i]['title'].toLowerCase().indexOf(searchWord.toLowerCase()) !== -1
                 || searchWord === ''){
                      
                  count_items++;
                  if (count_items <= start_item || total_items >= per_page) { continue; }
                  
                  HTML.push(abookingsystemdashboardTickets.ticket.view(tickets[i]));

                  $('.absd-tickets-holder').append(HTML.join(''));
                  total_items++;
              }
          }
          abookingsystemdashboardTickets['data']['total_items'] = count_items;


          // Events
          abookingsystemdashboardTickets.events(tickets);
          abookingsystemdashboardTickets.search.events(tickets);
          abookingsystemdashboardTickets.search.pagination.start(tickets);
          abookingsystemdashboardTickets.search.pagination.events(tickets);
      },
      group_tickets: function(data){
          
          for(var i = 0; i < data.length; i++){
            
            if(data[i]['tid'] !== undefined) {
              data[i]['id'] = parseInt(data[i]['tid']);
              data[i]['tid'] = parseInt(data[i]['tid']);
            }
            
            if(data[i]['user_id'] !== undefined) {
              data[i]['user_id'] = parseInt(data[i]['user_id']);
            } else if(data[i]['uid'] !== undefined) {
              data[i]['user_id'] = parseInt(data[i]['uid']);
            }
          }

          // Save Tickets in data
          abookingsystemdashboardTickets['data']['tickets'] = data;
      },
      events: function(){
          $('.absd-search input').unbind('keyup');
          $('.absd-search input').bind('keyup', function(){
              abookingsystemdashboardTickets['data']['search'] = $(this).val();  
              abookingsystemdashboardTickets['data']['page'] = 0;
              abookingsystemdashboardTickets.search.start();
          });
        
          $('.absd-add-ticket').unbind('click');
          $('.absd-add-ticket').bind('click', function(){
              abookingsystemdashboardTickets.ticket.add();
          }); 
      },
      delete: function(api_key){
          var tickets = abookingsystemdashboardTickets['data']['tickets'],
              newTickets = [];
        
          for(var i = 0; i <= tickets.length-1; i++) {
              
              if(tickets[i]['api_key'] !== api_key) {
                  newTickets.push(tickets[i]);
              }
          }
        
          abookingsystemdashboardTickets['data']['tickets'] = newTickets;
        
          abookingsystemdashboardTickets.search.start();
      },
      add: function(data){
        
          abookingsystemdashboardTickets['data']['tickets'].unshift(data);
          abookingsystemdashboardTickets.search.group_tickets(abookingsystemdashboardTickets['data']['tickets']);
        
          abookingsystemdashboardTickets.search.start();
      },
      pagination: {
          start: function(){  
            var page = abookingsystemdashboardTickets['data']['page'],
              per_page = abookingsystemdashboardTickets['data']['per_page'],
              total_items = abookingsystemdashboardTickets['data']['total_items'],
              total_pages = Math.ceil(total_items/per_page),
              center_page = (page==0) ? 1 : ((page >= (total_pages-1)) ? page-1 : page),
              prev_page = (page==0)?page:page-1,
              next_page = (page >= total_pages-1)?page:page+1;
            
              $('.absd-pagination').html(abookingsystemdashboardTickets.search.pagination.view(prev_page, center_page, next_page, page, total_pages));
             
          },
          view: function(prev_page, center_page, next_page, page, total_pages){
              var HTML = new Array();
            
              HTML.push('<div class="absd-page" data-page='+prev_page+'>');
              HTML.push('<');
              HTML.push('</div>');
              
              last_page = (total_pages < 3)?total_pages-1:center_page+1;
              first_page = (total_pages < 3)?0:center_page-1;

              for(var i = first_page; i <= last_page; i++){
                var page_class = '';
                if(i == page){
                  page_class = ' absd-selected';
                }  
                HTML.push('<div class="absd-page'+page_class+'" data-page='+i+'>');
                HTML.push(i+1);
                HTML.push('</div>');
              }
              
              HTML.push('<div class="absd-page" data-page='+next_page+'>');
              HTML.push('>');
              HTML.push('</div>');
            
              return HTML.join('');
          },
          events: function(){
              $('.absd-page').unbind('click');
              $('.absd-page').bind('click', function(){
                abookingsystemdashboardTickets['data']['page'] = parseInt($(this).attr('data-page'));
                abookingsystemdashboardTickets.search.start();
              }); 
          }
      }
    }
  };
  
  window.abookingsystemdashboardTickets = abookingsystemdashboardTickets;
  
})(jQuery);