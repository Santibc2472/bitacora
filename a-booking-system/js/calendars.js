(function($){
  
  var abookingsystemdashboardCalendars = {
    data: {
      countries: [],
      calendars: "",
      network: {
        use: 'false'
      },
      link: '',
      language: 'en',
      categories: "",
      currency_rate: 1,
      page: 0,
      per_page: 10,
      search: "",    // search word
      subpage: "availability",
      current: {
        calendar_id: 0,
        is_group: 'false',
        api_key: ''
      },
      deleted: {
        calendar_id: 0,
        is_group: 'false',
        api_key: ''
      }
    },
    hours: {
        get: function (){
            var data = new Array();
            
            for(var i = 0; i < 23; i++) {
                data.push({"name": (i < 10 ? '0'+i:i)+':'+'00', "value":(i < 10 ? '0'+i:i)+':'+'00'});
                data.push({"name": (i < 10 ? '0'+i:i)+':'+'30', "value":(i < 10 ? '0'+i:i)+':'+'30'});
            }
          
            return data;
        }
    },
    vat: {
      change: function(location){
          location['country'] = location['country'] === 'GB' ? 'UK':location['country'];
          var data = abookingsystemdashboard["vat_data"][location['country']],
              settings_data = abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data;

          if(typeof settings_data === 'string') {
              settings_data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data);
              
              if(settings_data['vat'] !== undefined) {
                  settings_data['vat'] = data['rate'];
                  abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data = JSON.stringify(settings_data);
              }
          }
          
          if(location['country'] === 'US') {
              data = abookingsystemdashboard["vat_data"][location['country']]['state'][location['state']];
          }
        
          if(data['rate'] > 0) {
              $("label[for*='absd-form-create_calendar-vat']").html(data['name']).removeClass('absd-invisible');
              $("#absd-form-create_calendar-vat").val(data['rate']).removeClass('absd-invisible');
              $('#absd-form-settings-vat').val(data['rate']);
          } else {
              $("label[for*='absd-form-create_calendar-vat']").html('').addClass('absd-invisible');
              $("#absd-form-create_calendar-vat").val(data['rate']).addClass('absd-invisible');
              $('#absd-form-settings-vat').val(data['rate']);
          }
      }
    },
    list: function(){
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                               absdashboardtext['wait']);
                                
            $.get(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendars'],
                                        is_ajax_request: true,
                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                data = JSON.parse(data);
              
                abookingsystemdashboardCalendars.data.network = data['network'];
                abookingsystemdashboardCalendars.data.countries = data['countries'];
                abookingsystemdashboardCalendars.data.categories = data['categories'];
                abookingsystemdashboardCalendars.data.link = data['link'];
                abookingsystemdashboardCalendars.data.language = data['language'];
                abookingsystemdashboardCalendars.data.currency_rate = data['currency_rate'];
                
                if(abookingsystemdashboardCalendars.data.network['add_calendar'] === 'false'){
                    $('.absd-add-calendar-btn').remove();
                }
              
                abookingsystemdashboardCalendars.search.group_calendars(data);
            
                // View Calendars -> Search start
                abookingsystemdashboardCalendars.search.start();
              
                // Stop Loader
                abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                   absdashboardtext['refresh'],
                                   true);
              
            });
    },
    events: function() {
        $('.absd-group-element h3, .absd-element h3').unbind('click');
        $('.absd-group-element h3, .absd-element h3').bind('click', function(){
          
            if(window.absdMorePrices !== undefined) {
                delete window.absdMorePrices;
            }
          
            $('.absd-group').removeClass('absd-opened');    
            $('.absd-element').removeClass('absd-opened');   
            
            abookingsystemdashboardCalendars['data']['current']['calendar_id'] = $(this).parent().attr('data-calendar-id'); 
            abookingsystemdashboardCalendars['data']['current']['is_group'] = $(this).parent().attr('data-is-group'); 
            abookingsystemdashboardCalendars['data']['current']['group_id'] = $(this).parent().attr('data-group-id'); 
            abookingsystemdashboardCalendars['data']['current']['api_key'] = $(this).parent().attr('data-api-key');
            abookingsystemdashboardCalendars['data']['current']['is_rejected'] = ($(this).parent().hasClass('absd-group-element-rejected') || $(this).parent().hasClass('absd-element-rejected')) ? true:false;
            abookingsystemdashboardCalendars['data']['current']['rejected_reason'] = $(this).parent().attr('data-rejected-reason');
          
            if(abookingsystemdashboardCalendars['data']['current']['is_group'] === 'true'){
//               $(this).parent().parent().addClass('absd-opened');   
            }   
//             $(this).parent().addClass('absd-opened');   
          
            if(abookingsystemdashboardCalendars['data']['current']['group_id'] !== '0'){
              $('#absd-group-'+abookingsystemdashboardCalendars['data']['current']['group_id']).addClass('absd-opened');  
            }
          
            if(abookingsystemdashboardCalendars['data']['current']['is_group'] === 'true'){
                $('#absd-group-'+abookingsystemdashboardCalendars['data']['current']['calendar_id']).addClass('absd-opened');  
            } else {
                $('#absd-calendar-'+abookingsystemdashboardCalendars['data']['current']['calendar_id']).addClass('absd-opened');  
            }
            
            abookingsystemdashboardCalendars.calendar.setup.start();     
        });
      
        $('.absd-calendar-actions .absd-delete').unbind('click');
        $('.absd-calendar-actions .absd-delete').bind('click', function(e){
          
            
            abookingsystemdashboardCalendars['data']['deleted']['calendar_id'] = $(this).parent().parent().parent().attr('data-calendar-id'); 
            abookingsystemdashboardCalendars['data']['deleted']['is_group'] = $(this).parent().parent().parent().attr('data-is-group'); 
            abookingsystemdashboardCalendars['data']['deleted']['api_key'] = $(this).parent().parent().parent().attr('data-api-key'); 
     
            var deleteCalendarForm = {
                name: "delete_calendar",
                fields: [
                  {
                    label: "",
                    name: "calendar_id",
                    value: abookingsystemdashboardCalendars['data']['deleted']['calendar_id'],        // default value
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
                    input_class: "absd_calendar_id",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  },
                  {
                    label: "",
                    name: "api_key",
                    value: abookingsystemdashboardCalendars['data']['deleted']['api_key'],        // default value
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
                         deleteCalendarForm,
                         absdashboardtext['yes'],
                         absdashboardtext['cancel'],
                         abookingsystemdashboardCalendars.calendar.delete_ok);
        });
      
        
      
        $('.absd-calendar-actions .absd-get-code').unbind('click');
        $('.absd-calendar-actions .absd-get-code').bind('click', function(e){
            abookingsystemdashboardCalendars['data']['current']['api_key'] = $(this).attr('data-api-key');
            abookingsystemdashboardCalendars.calendar.share.start();
        });
    },
    calendar: {
      view: function(data){
          var HTML = new Array();
          data['group_id'] = data['group_id'] === undefined ? 0:data['group_id'];
          
          HTML.push('<div class="absd-element'+(data['approved'] === 'rejected' && data['group_id'] === 0 ? ' absd-element-rejected':'')+'" '+(data['rejected_reason'] !== '' && data['group_id'] === 0 ? ' data-rejected-reason="'+data['rejected_reason']+'"':'data-rejected-reason=""')+' id="absd-calendar-'+data['id']+'" data-calendar-id="'+data['id']+'" data-api-key="'+data['api_key']+'" data-is-group="'+data['is_group']+'" data-group-id="'+(data['group_id'] !== undefined ? data['group_id']:0)+'">');
          HTML.push('   <h3 id="absd-calendar-'+data['id']+'-name">');
          HTML.push(    data['name']);
          HTML.push('   </h3>');
          HTML.push('   <div class="absd-calendar-actions-holder">');
          HTML.push('       <div class="absd-calendar-actions">');
            
          if(data['entire'] === "false") {
              HTML.push('           <span class="absd-get-code" data-api-key="'+data['api_key']+'"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['get_code'] +'</span></span>');
          }
          
//          if(abookingsystemdashboardCalendars['data']['network']['delete_calendar'] === 'true') {
              HTML.push('       <span class="absd-delete"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['delete_button']+'</span></span>');
//          }
          HTML.push('       </div>');
          HTML.push('   </div>');
          HTML.push('</div>');
        
          HTML.push('</div>');
        
          return HTML.join('');
      },
      group: function(data){
          var HTML = new Array();
          
          HTML.push('<div class="absd-group" id="absd-group-'+data['id']+'" data-calendar-id="'+data['id']+'" data-api-key="'+data['api_key']+'" data-is-group="'+data['is_group']+'" data-group-id="'+(data['group_id'] !== undefined ? data['group_id']:0)+'">');
          HTML.push('<div class="absd-group-arrow"></div>');
          HTML.push('<div class="absd-group-element'+(data['approved'] === 'rejected' ? ' absd-group-element-rejected':'')+'" '+(data['rejected_reason'] !== '' && data['group_id'] === 0 ? ' data-rejected-reason="'+data['rejected_reason']+'"':'data-rejected-reason=""')+' data-calendar-id="'+data['id']+'" data-api-key="'+data['api_key']+'" data-is-group="'+data['is_group']+'" data-group-id="'+(data['group_id'] !== undefined ? data['group_id']:0)+'">');
          HTML.push('<h3 id="absd-calendar-'+data['id']+'-name">');
          HTML.push(data['name']);
          HTML.push('</h3>');
//           HTML.push('<div class="absd-calendar-actions-holder"><div class="absd-calendar-actions"><span class="absd-get-code"><span class="absd-icon"></span><span class="absd-text">Get code</span></span><span class="absd-delete"><span class="absd-icon"></span><span class="absd-text">Delete</span></span></div></div>');
          
          HTML.push('   <div class="absd-calendar-actions-holder">');
          HTML.push('       <div class="absd-calendar-actions">');
        
//           if(abookingsystemdashboard["is_network"]) {
//               HTML.push('           <span class="absd-get-code" data-api-key="'+data['api_key']+'"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['get_code'] +'</span></span>');
//           }

          if(data['group_id'] === 0
            || data['group_id'] === undefined) {
              HTML.push('           <span class="absd-get-code" data-api-key="'+data['api_key']+'"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['get_code'] +'</span></span>');
          }
          
//          if(abookingsystemdashboardCalendars['data']['network']['delete_calendar'] === 'true') {
              HTML.push('       <span class="absd-delete"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['delete_button']+'</span></span>');
//          }
          HTML.push('       </div>');
          HTML.push('   </div>');
        
          HTML.push('</div>');
          HTML.push('<div class="absd-elements">');
          
          if(abookingsystemdashboardCalendars['data']['network']['add_calendar'] === 'true'){
              HTML.push('   <div class="absd-button absd-add-calendar-btn absd-add-calendar" data-group-id="'+(data['id'] !== undefined ? data['id']:0)+'">'+absdashboardtext[abookingsystemdashboard['used_for']+'_add_calendar']+'</div>');
          }
          HTML.push('</div>');
          HTML.push('</div>');
        
          return HTML.join(''); 
      },
      delete_ok: function(){
          var fields = abookingsystemdashboardForm.fields.get();
        
          if(fields !== "error"){
              // Start Loader
              abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                 absdashboardtext['wait']);
              
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['delete_calendar'],
                                          is_ajax_request: true,
                                          id: fields['calendar_id'],
                                          api_key: fields['api_key'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                  data = JSON.parse(data);
                
                  if(data.status === "success"){
                      // remove element
//                       $('#absd-calendar-'+abookingsystemdashboardCalendars['data']['deleted']['calendar_id']).remove();

                      // Stop Loader
                      abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                         absdashboardtext['deleted'],
                                         true);
                      abookingsystemdashboard["no_groups"] = data.no_groups;
                      abookingsystemdashboard["no_calendars"] = data.no_calendars;
                    
                      // Research
                      abookingsystemdashboardCalendars.search.delete(fields['api_key']);
                      
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
      share: {
          start: function (){
              // Show how to share calendar on facebook / your website ( wordpress website or other )
              var shareCalendarForm = {
                  name: "share_calendar",
                  fields: [
                    {
                      label: absdashboardtext['share_on'],
                      name: "share_on",
                      value: 'facebook',        // default value
                      modify: "abookingsystemdashboardCalendars.calendar.share.modify('share_on', window.absdSelectedValue);",
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      type: "select",                            // text, textarea, select, radio, checkbox, password
                      options: abookingsystemdashboardGeneral.select.optionsLower(['Facebook', 'Website']),     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_calendar_share_on",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: absdashboardtext['share_fb_link'],
                      name: "facebook_link",
                      value: abookingsystemdashboard["api_url"]+'facebook/?api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'-'+abookingsystemdashboard['server']+'&wdh_bec_rfid='+abookingsystemdashboard['referral_id']+'&fblink=',        // default value
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      is_read_only: "true",
                      html: "<br><div class='absd-info-share-text'>"+absdashboardtext['share_fb_text']+".</div>",
                      type: "textarea",                            // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_facebook_link",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: absdashboardtext['share_website'],
                      name: "share_website_type",
                      value: 'wordpress',        // default value
                      modify: "abookingsystemdashboardCalendars.calendar.share.modify('share_website_type', window.absdSelectedValue);",
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      type: "select",                            // text, textarea, select, radio, checkbox, password
                      options: abookingsystemdashboardGeneral.select.optionsLower(['Wordpress','Wix','Weebly','Other']),     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_calendar_share_website_type absd-invisible",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: absdashboardtext['share_wordpress'],
                      name: "wordpress_shortcode",
                      value: '<div class="bookeucom">[bookeucom key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'-'+abookingsystemdashboard['server']+' language=auto referral_id='+abookingsystemdashboard['referral_id']+']</div>',        // default value
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      is_read_only: "true",
                      html: "<br><div class='absd-info-share-text'>"+absdashboardtext['share_wordpress_text']+".</div>",
                      type: "textarea",                            // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_share_wordpress absd-invisible",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: absdashboardtext['share_wix'],
                      name: "wix_shortcode",
                      value: abookingsystemdashboard["api_url"]+'wix/?api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'-'+abookingsystemdashboard['server']+'&wdh_bec_rfid='+abookingsystemdashboard['referral_id'],        // default value
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      is_read_only: "true",
                      html: "<br><div class='absd-info-share-text'>"+absdashboardtext['share_wix_text']+".</div>",
                      type: "textarea",                            // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_share_wix absd-invisible",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: absdashboardtext['share_weebly'],
                      name: "weebly_shortcode",
                      value: '<iframe src="'+abookingsystemdashboard["api_url"]+'iframe/?api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'-'+abookingsystemdashboard['server']+'&wdh_bec_rfid='+abookingsystemdashboard['referral_id']+'" style="width:900px;height:700px;" frameborder="0" marginwidth="0" marginheight="0" scrolling="yes"></iframe>',        // default value
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      is_read_only: "true",
                      html: "<br><div class='absd-info-share-text'>"+absdashboardtext['share_weebly_text']+".</div>",
                      type: "textarea",                            // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_share_weebly absd-invisible",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: absdashboardtext['share_other_files'],
                      name: "share_other_files", 
                      value: '<link rel="stylesheet" type="text/css" href="'+abookingsystemdashboard['calendar_url']+'css/calendar.min.css"><script src="'+abookingsystemdashboard['calendar_url']+'js/calendar.min.js"></script>',        // default value
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      is_read_only: "true",
                      type: "textarea",                            // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_share_other absd-invisible",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: absdashboardtext['share_other_short'],
                      name: "share_other_short",
                      value: '<div class="bookeucom">[bookeucom key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'-'+abookingsystemdashboard['server']+' language=auto referral_id='+abookingsystemdashboard['referral_id']+']</div>',        // default value
                      placeholder: "",  
                      required: "false",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      is_read_only: "true",
                      html: "<br><div class='absd-info-share-text'>"+absdashboardtext['share_other_text']+".</div>",
                      type: "textarea",                            // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "",
                      field_class: "absd_share_other absd-invisible",
                      hint: "",
                      label_position: "left"         // left, right, left_full, right_full
                    },
                    {
                      label: "",
                      name: "api_key",
                      value: abookingsystemdashboardCalendars['data']['current']['api_key'],        // default value
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
              abookingsystemdashboardInfo.start(absdashboardtext['share'],
                               shareCalendarForm);

              $('#absd-info-buttons').addClass('absd-invisible');
          },
          modify: function(field, value){
              
              if(field === 'share_on') {
                
                  if(value === 'website') {
                      $('.absd_calendar_share_website_type').removeClass('absd-invisible');
                      $('.absd_facebook_link').addClass('absd-invisible');
            
                      if($('.absd_calendar_share_website_type input').val() === 'wordpress') {
                          $('.absd_share_wordpress').removeClass('absd-invisible');
                          $('.absd_share_wix').addClass('absd-invisible');
                          $('.absd_share_weebly').addClass('absd-invisible');
                          $('.absd_share_other').addClass('absd-invisible');
                      } else if($('.absd_calendar_share_website_type input').val() === 'wix') {
                          $('.absd_share_wordpress').addClass('absd-invisible');
                          $('.absd_share_wix').removeClass('absd-invisible');
                          $('.absd_share_weebly').addClass('absd-invisible');
                          $('.absd_share_other').addClass('absd-invisible');
                      } else if($('.absd_calendar_share_website_type input').val() === 'weebly') {
                          $('.absd_share_wordpress').addClass('absd-invisible');
                          $('.absd_share_wix').addClass('absd-invisible');
                          $('.absd_share_weebly').removeClass('absd-invisible');
                          $('.absd_share_other').addClass('absd-invisible');
                      } else {
                          $('.absd_share_wordpress').addClass('absd-invisible');
                          $('.absd_share_wix').addClass('absd-invisible');
                          $('.absd_share_weebly').addClass('absd-invisible');
                          $('.absd_share_other').removeClass('absd-invisible');
                      }
                  } else {
                      $('.absd_calendar_share_website_type').addClass('absd-invisible');
                      $('.absd_share_wordpress').addClass('absd-invisible');
                      $('.absd_share_wix').addClass('absd-invisible');
                      $('.absd_share_weebly').addClass('absd-invisible');
                      $('.absd_share_other').addClass('absd-invisible');
                      $('.absd_facebook_link').removeClass('absd-invisible');
                  }
              } else if(field === 'share_website_type') {
                
                  if(value === 'wordpress') {
                      $('.absd_share_wordpress').removeClass('absd-invisible');
                      $('.absd_share_wix').addClass('absd-invisible');
                      $('.absd_share_weebly').addClass('absd-invisible');
                      $('.absd_share_other').addClass('absd-invisible');
                  } else if(value === 'wix') {
                      $('.absd_share_wordpress').addClass('absd-invisible');
                      $('.absd_share_wix').removeClass('absd-invisible');
                      $('.absd_share_weebly').addClass('absd-invisible');
                      $('.absd_share_other').addClass('absd-invisible');
                  } else if(value === 'weebly') {
                      $('.absd_share_wordpress').addClass('absd-invisible');
                      $('.absd_share_wix').addClass('absd-invisible');
                      $('.absd_share_weebly').removeClass('absd-invisible');
                      $('.absd_share_other').addClass('absd-invisible');
                  } else {
                      $('.absd_share_wordpress').addClass('absd-invisible');
                      $('.absd_share_wix').addClass('absd-invisible');
                      $('.absd_share_weebly').addClass('absd-invisible');
                      $('.absd_share_other').removeClass('absd-invisible');
                  }
              }
          }
      },
      setup:{
        start: function(){
            $('#absd-calendars-content').html('');
            abookingsystemdashboardCalendars.calendar.setup.view.start();
            abookingsystemdashboardCalendars.calendar.setup.events();
        },
        view: {
            start: function(){
                var HTML = new Array();
                abookingsystemdashboardCalendars.calendar.setup.view.header.start();
                abookingsystemdashboardCalendars.calendar.setup.view.content.start();
            },
            header: {
                start: function(){
                    var HTML = new Array();
                    
                    HTML.push('<div class="absd-header">');
                    HTML.push(    abookingsystemdashboardCalendars.calendar.setup.view.header.menu());
                    HTML.push('</div>');  
                    
                    $('#absd-calendars-content').append(HTML.join(''));
                },
                menu: function(){
                    var HTML = new Array();
                  
                    HTML.push('<div id="calendar-settings-menu" class="absd-menu">');
                    HTML.push('   <div data-type="availability" class="absd-link'+(abookingsystemdashboardCalendars['data']['subpage'] === 'availability' ? ' absd-selected':'')+'">'+absdashboardtext['availability_price']+'</div>');
                    
                    // if(abookingsystemdashboardCalendars['data']['network']['use_settings'] === 'true') {
                        HTML.push('   <div data-type="settings" class="absd-link'+(abookingsystemdashboardCalendars['data']['subpage'] === 'settings' ? ' absd-selected':'')+'">'+absdashboardtext['settings']+'</div>');
                    // }
                    
//                     if(abookingsystemdashboardCalendars['data']['network']['use_form_settings'] === 'true') {
//                         HTML.push('   <div data-type="form" class="absd-link'+(abookingsystemdashboardCalendars['data']['subpage'] === 'form' ? ' absd-selected':'')+'">'+absdashboardtext['form']+'</div>');
//                     }
                    // abookingsystemdashboardCalendars['data']['network']['use_notifications'] === 'true'
                    // && 
                    if(abookingsystemdashboardCalendars['data']['current']['group_id'] === '0') {
                        HTML.push('   <div data-type="notifications" class="absd-link'+(abookingsystemdashboardCalendars['data']['subpage'] === 'notifications' ? ' absd-selected':'')+'">'+absdashboardtext['notifications']+'</div>');
                    }
                    // abookingsystemdashboardCalendars['data']['network']['use_sync'] === 'true'
                    //   && 
                    if(abookingsystemdashboardCalendars['data']['current']['is_group'] === 'false') {
                        HTML.push('   <div data-type="sync" class="absd-link'+(abookingsystemdashboardCalendars['data']['subpage'] === 'sync' ? ' absd-selected':'')+'">'+absdashboardtext['sync']+'</div>');
                    }
                  
                    HTML.push('</div>'); 
                    
                    return HTML.join('');
                }
            },
            content: {
                start: function(){
                    var HTML = new Array();
                    
                    HTML.push('<div id="absd-calendars-content-box" class="absd-content-settings">');  
                    HTML.push('   <div class="absd-content-settings-box"></div>');  
                    HTML.push('</div>');  
                    
                    $('#absd-calendars-content').append(HTML.join(''));
                  
                    switch(abookingsystemdashboardCalendars['data']['subpage']){
                        case "settings":
                          abookingsystemdashboardCalendars.calendar.setup.view.content.settings.start();
                          break;
                        case "form":
                          abookingsystemdashboardCalendars.calendar.setup.view.content.form.start();
                          break;
                        case "notifications":
                          abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.start();
                          break;
                        case "sync":
                          abookingsystemdashboardCalendars.calendar.setup.view.content.sync.start();
                          break;
                        default:
                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.start();
                          break;
                    }
                },
                availability: {
                    data: {},
                    start: function(){
                      // Start Loader
                      abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                         absdashboardtext['wait']);

                      $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings'],
                                                  is_ajax_request: true,
                                                  ajax_ses: abookingsystemdashboard['ajax_ses'],
                                                  type: 'availaibility',
                                                  calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                  api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                  is_group: abookingsystemdashboardCalendars['data']['current']['is_group']}, function(data){
                          
                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data = data;
                          data = JSON.parse(data);
                          
                          // Create Default & Advanced Tabs
                          var tabsData = [{label: absdashboardtext['default_settings'],
                                          name: "default_settings"},
                                         {label: absdashboardtext['advanced_settings'],
                                          name: "advanced_settings"}];
                        
                          abookingsystemdashboardTabs.start($('.absd-content-settings-box'), tabsData);
                        
                          // Create Advanced Accordions
                          var accordionData = [{label: absdashboardtext['yearly'],
                                                name: "advanced_year"},
                                               {label: absdashboardtext['weekaday'],
                                                name: "advanced_weekDay"},
                                               {label: absdashboardtext['monthly'],
                                                name: "advanced_months"},
                                               {label: absdashboardtext['weeks'],
                                                name: "advanced_weeks"}];
//                          ,{label: absdashboardtext['custom_date'],
//                            name: "advanced_custom_date"}
                          
                          abookingsystemdashboardAccordion.start($('#absd-tab-advanced_settings-content'), accordionData);
                            
                          // General
                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.show('general');
                          // Year
                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.show('year');
                          // WeekDay
                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.show('weekDay');
                          // Months
                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.show('months');
                          // Weeks
                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.show('weeks');
                          // Custom Date
//                          abookingsystemdashboardCalendars.calendar.setup.view.content.availability.show('custom_date');
                        

                          // Stop Loader
                          abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                             absdashboardtext['refresh'],
                                             true);
                        
                          if(abookingsystemdashboardCalendars['data']['current']['is_rejected']) {
                              var warningMessage = new Array();

                              warningMessage.push(absdashboardtext['space_rejected']);
                              warningMessage.push(' '+abookingsystemdashboardCalendars['data']['current']['rejected_reason']);

                              abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                                  warningMessage.join(''),
                                                  10);
                          }

                      });
                    },
                    show: function(key){
                        // Create Forms
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data);
                      
                        if(data[key] === undefined){
                            data[key] = data['general'];
                        }
                        
                        var defaultSettingsForm = {
                            name: "availability_"+key,
                            more_data_before: "general_monthly_price",
                            fields: [{
                                  label: "",
                                  name: key+"_period",
                                  data_key: key,
                                  value: '',        // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.change('"+key+"', window.absdSelectedValue)",
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
                                  label: "",
                                  name: key+"_type",
                                  data_key: key,
                                  value: key,        // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'type', this.value)",
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
                                label: absdashboardtext['price'],
                                data_key: key,
                                name: key+"_price",
                                value: data[key]['price'],  // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'price', this.value)",
                                fee: data['general']['fee'],
                                network_fee: data['general']['network_fee'],
                                network_fee_type: data['general']['network_fee_type'],
                                currency_sign: data['general']['currency']['sign'],
                                currency_position: data['general']['currency']['position'],
                                placeholder: "",  
                                required: "true",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                is_numeric: "true",
                                type: "price",                            // text, textarea, select, radio, checkbox, password
                                options: {0: {"name": "", "value": ""}},     // select options
                                label_class: "",
                                input_class: "",
                                hint: "",
                                higher_than: parseInt(10*abookingsystemdashboardCalendars.data.currency_rate),
                                label_position: "left"         // left, right, left_full, right_full
                              },
                                {
                                label: absdashboardtext['monthly_price'],
                                name: key+"_monthly_price",
                                data_key: key,
                                value: data[key]['monthly_price'] !== undefined ? data[key]['monthly_price']:0,  // default value
                                enabled: data[key]['monthly_price_enabled'],  // enabled price
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'monthly_price', this.value)",
                                enabling: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.enabling('"+key+"', 'monthly_price_enabled', this)",
                                fee: data['general']['fee'],
                                network_fee: data['general']['network_fee'],
                                network_fee_type: data['general']['network_fee_type'],
                                currency_sign: data['general']['currency']['sign'],
                                currency_position: data['general']['currency']['position'],
                                placeholder: "",  
                                required: "true",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                is_numeric: "true",
                                type: "price_added",                            // text, textarea, select, radio, checkbox, password
                                options: {0: {"name": "", "value": ""}},     // select options
                                label_class: "",
                                input_class: "",
                                hint: "",
                                example: "Ex 1-31 "+absdashboardtext['may'],
                                disabled: true,
                                higher_than: parseInt(10*abookingsystemdashboardCalendars.data.currency_rate),
                                label_position: "left"         // left, right, left_full, right_full
                              },
                                {
                                label: absdashboardtext['weekly_price'],
                                name: key+"_weekly_price",
                                data_key: key,
                                value: data[key]['weekly_price'] !== undefined ? data[key]['weekly_price']:0,  // default value
                                enabled: data[key]['weekly_price_enabled'],  // enabled price
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'weekly_price', this.value)",
                                enabling: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.enabling('"+key+"', 'weekly_price_enabled', this)",
                                fee: data['general']['fee'],
                                network_fee: data['general']['network_fee'],
                                network_fee_type: data['general']['network_fee_type'],
                                currency_sign: data['general']['currency']['sign'],
                                currency_position: data['general']['currency']['position'],
                                placeholder: "",  
                                required: "true",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                is_numeric: "true",
                                type: "price_added",                            // text, textarea, select, radio, checkbox, password
                                options: {0: {"name": "", "value": ""}},     // select options
                                label_class: "",
                                input_class: "",
                                hint: "",
                                example: absdashboardtext['monday']+"-"+absdashboardtext['sunday'],
                                disabled: true,
                                higher_than: parseInt(10*abookingsystemdashboardCalendars.data.currency_rate),
                                label_position: "left"         // left, right, left_full, right_full
                              },
                                {
                                label: absdashboardtext['weekend_price'],
                                name: key+"_weekend_price",
                                data_key: key,
                                value: data[key]['weekend_price'] !== undefined ? data[key]['weekend_price']:0,  // default value
                                enabled: data[key]['weekend_price_enabled'],  // enabled price
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'weekend_price', this.value)",
                                enabling: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.enabling('"+key+"', 'weekend_price_enabled', this)",
                                fee: data['general']['fee'],
                                network_fee: data['general']['network_fee'],
                                network_fee_type: data['general']['network_fee_type'],
                                currency_sign: data['general']['currency']['sign'],
                                currency_position: data['general']['currency']['position'],
                                placeholder: "",  
                                required: "true",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                is_numeric: "true",
                                type: "price_added",                            // text, textarea, select, radio, checkbox, password
                                options: {0: {"name": "", "value": ""}},     // select options
                                label_class: "",
                                input_class: "",
                                hint: "",
                                example: absdashboardtext['friday']+"-"+absdashboardtext['sunday'],
                                disabled: true,
                                higher_than: parseInt(10*abookingsystemdashboardCalendars.data.currency_rate),
                                label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                label: absdashboardtext['status'],
                                name: key+"_status",
                                data_key: key,
                                value: data[key]['status'],        // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'status', window.absdSelectedValue)",
                                placeholder: "",  
                                required: "false",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                type: "select",                            // text, textarea, select, radio, checkbox, password
                                options: abookingsystemdashboardGeneral.select.optionsLower([absdashboardtext['status_available'] ,absdashboardtext['status_unavailable']]),     // select options : abookingsystemdashboardCalendars.data.categories
                                label_class: "",
                                input_class: "",
                                hint: "",
                                label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                label: absdashboardtext['status_available'],
                                name: key+"_available",
                                data_key: key,
                                value: data[key]['available'],        // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'available', this.value)",
                                placeholder: "",  
                                required: "false",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                is_numeric: "true",
                                type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                options:  {0: {"name": "", "value": ""}},     // select options
                                label_class: "",
                                input_class: "",
                                hint: "", //absdashboardtext['day_hours_available'],
                                label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                label: absdashboardtext['status_booked'],
                                name: key+"_booked",
                                data_key: key,
                                value: data[key]['booked'],        // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'booked', this.value)",
                                placeholder: "",  
                                required: "false",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                is_numeric: "true",
                                type: "hidden",                            // text, textarea, select, radio, checkbox, password
                                options:  {0: {"name": "", "value": ""}},     // select options
                                label_class: "",
                                input_class: "",
                                hint: "", //absdashboardtext['day_hours_booked'],
                                label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                label: absdashboardtext['notes'],
                                name: key+"_notes",
                                data_key: key,
                                value: data[key]['notes'],        // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify('"+key+"', 'notes', this.value)",
                                placeholder: absdashboardtext['notes_write'],  
                                required: "false",
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
                                label: absdashboardtext['save'],
                                name: key+"_save",
                                value: data[key]['save'],        // default value
                                placeholder: "",  
                                action: "abookingsystemdashboardCalendars.calendar.setup.view.content.availability.save()",
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

                        },
                        accordionAvailabilityPrices = [{label: absdashboardtext['prices'],
                                                        name: "prices",
                                                        class: "absd-opened"},
                                                       {label: absdashboardtext['availability'],
                                                        name: "availability"}],
                        modDefaulSettingsForm = [],
                        modDefaulSettingsForm2 = [];

                        if(key === 'general') {
                            abookingsystemdashboardAccordion.start($('#absd-tab-default_settings-content'), accordionAvailabilityPrices, 'absd-black');
                          
                            // Prices settings
                            modDefaulSettingsForm = $.extend(true, {}, defaultSettingsForm);
                            delete modDefaulSettingsForm['fields'][6];
                            delete modDefaulSettingsForm['fields'][7];
                            delete modDefaulSettingsForm['fields'][8];
                            delete modDefaulSettingsForm['fields'][9];
                            modDefaulSettingsForm['fields'] = abookingsystemdashboardGeneral.reOrderArray(modDefaulSettingsForm['fields']);
                            abookingsystemdashboardForm.start($('#absd-accordion-prices-content .absd-accordion-content-box'), modDefaulSettingsForm);
                          
                            // Availability settings
                            modDefaulSettingsForm2 = $.extend(true, {}, defaultSettingsForm);
                            delete modDefaulSettingsForm2['fields'][2];
                            delete modDefaulSettingsForm2['fields'][3];
                            delete modDefaulSettingsForm2['fields'][4];
                            delete modDefaulSettingsForm2['fields'][5];
                            modDefaulSettingsForm2['fields'] = abookingsystemdashboardGeneral.reOrderArray(modDefaulSettingsForm2['fields']);
                            abookingsystemdashboardForm.start($('#absd-accordion-availability-content .absd-accordion-content-box'), modDefaulSettingsForm2);
                        } else {  
                            switch(key) {
                                case 'year':
                                    var yearsOptions = [],
                                        currentDate = new Date(),
                                        currentYear = currentDate.getFullYear();

                                    for(var i = currentYear; i<=(currentYear+50); i++){
                                        yearsOptions.push(i);
                                    }

                                    defaultSettingsForm['fields'][0]['label'] = absdashboardtext['year'];
                                    defaultSettingsForm['fields'][0]['value'] = currentYear;
                                    defaultSettingsForm['fields'][0]['type'] = 'select';
                                    defaultSettingsForm['fields'][0]['options'] = abookingsystemdashboardGeneral.select.options(yearsOptions);
                                
                                    var period =  currentYear;
                                
                                    if(period !== ''){

                                        if(data[key][period] === undefined){
                                            data[key][period] = data['general'];
                                        }
                                    }
                                    
                                    defaultSettingsForm['fields'][2]['value'] = data[key][period]['price'] !== undefined ? data[key][period]['price']:0;   
                                    defaultSettingsForm['fields'][3]['value'] = data[key][period]['monthly_price'] !== undefined ? data[key][period]['monthly_price']:0;   
                                    defaultSettingsForm['fields'][4]['value'] = data[key][period]['weekly_price'] !== undefined ? data[key][period]['weekly_price']:0;   
                                    defaultSettingsForm['fields'][5]['value'] = data[key][period]['weekend_price'] !== undefined ? data[key][period]['weekend_price']:0;   
                                    defaultSettingsForm['fields'][6]['value'] = data[key][period]['status']
                                    defaultSettingsForm['fields'][7]['value'] = data[key][period]['available'];
                                    defaultSettingsForm['fields'][8]['value'] = data[key][period]['booked'];
                                    defaultSettingsForm['fields'][9]['value'] = data[key][period]['notes'];
                                
                                break;
                                case 'weekDay':
                                    var weeakaDayOptions = [],
                                        currentDate = new Date(),
                                        currentWeekDay = currentDate.getDay();

                                    for(var i = 1; i<=7; i++){
                                        var currentData = [];
                                          
                                        switch(i) {
                                            case 1:
                                              currentData['name'] = absdashboardtext['monday'];
                                              break;
                                            case 2:
                                              currentData['name'] = absdashboardtext['tuesday'];
                                              break;
                                            case 3:
                                              currentData['name'] = absdashboardtext['wednesday'];
                                              break;
                                            case 4:
                                              currentData['name'] = absdashboardtext['thursday'];
                                              break;
                                            case 5:
                                              currentData['name'] = absdashboardtext['friday'];
                                              break;
                                            case 6:
                                              currentData['name'] = absdashboardtext['saturday'];
                                              break;
                                            case 7:
                                              currentData['name'] = absdashboardtext['sunday'];
                                              break;
                                        }
                                        currentData['value'] = i;
                                        weeakaDayOptions.push(currentData);
                                    }
                                    defaultSettingsForm['fields'][0]['label'] = absdashboardtext['weekday'];
                                    defaultSettingsForm['fields'][0]['value'] = currentWeekDay+1;
                                    defaultSettingsForm['fields'][0]['type'] = 'select';
                                    defaultSettingsForm['fields'][0]['options'] = weeakaDayOptions;
                                
                                    var period =  currentWeekDay+1;
                                
                                    if(period !== ''){

                                        if(data[key][period] === undefined){
                                            data[key][period] = data['general'];
                                        }
                                    }
                                    
                                    defaultSettingsForm['fields'][2]['value'] = data[key][period]['price'] !== undefined ? data[key][period]['price']:0;   
                                    delete defaultSettingsForm['fields'][3];
                                    delete defaultSettingsForm['fields'][4];
                                    delete defaultSettingsForm['fields'][5]; 
                                    defaultSettingsForm['fields'][6]['value'] = data[key][period]['status']
                                    defaultSettingsForm['fields'][7]['value'] = data[key][period]['available'];
                                    defaultSettingsForm['fields'][8]['value'] = data[key][period]['booked'];
                                    defaultSettingsForm['fields'][9]['value'] = data[key][period]['notes'];
                                    defaultSettingsForm['fields']             = abookingsystemdashboardGeneral.reOrderArray(defaultSettingsForm['fields']);
                                break;
                                case 'months':
                                    var monthsOptions = [],
                                        currentDate = new Date(),
                                        currentMonth = currentDate.getMonth();

                                    for(var i = 1; i<=11; i++){
                                        var currentData = [];

                                        switch(i) {
                                            case 0:
                                              currentData['name'] = absdashboardtext['january'];
                                              break;
                                            case 1:
                                              currentData['name'] = absdashboardtext['february'];
                                              break;
                                            case 2:
                                              currentData['name'] = absdashboardtext['march'];
                                              break;
                                            case 3:
                                              currentData['name'] = absdashboardtext['april'];
                                              break;
                                            case 4:
                                              currentData['name'] = absdashboardtext['may'];
                                              break;
                                            case 5:
                                              currentData['name'] = absdashboardtext['june'];
                                              break;
                                            case 6:
                                              currentData['name'] = absdashboardtext['july'];
                                              break;
                                            case 7:
                                              currentData['name'] = absdashboardtext['august'];
                                              break;
                                            case 8:
                                              currentData['name'] = absdashboardtext['september'];
                                              break;
                                            case 9:
                                              currentData['name'] = absdashboardtext['october'];
                                              break;
                                            case 10:
                                              currentData['name'] = absdashboardtext['november'];
                                              break;
                                            case 11:
                                              currentData['name'] = absdashboardtext['december'];
                                              break;
                                        }
                                        currentData['value'] = i;
                                        monthsOptions.push(currentData);
                                    }
                                    defaultSettingsForm['fields'][0]['label'] = absdashboardtext['month'];
                                    defaultSettingsForm['fields'][0]['value'] = currentMonth;
                                    defaultSettingsForm['fields'][0]['type'] = 'select';
                                    defaultSettingsForm['fields'][0]['options'] = monthsOptions;
                                
                                    var period =  currentMonth;
                                
                                    if(period !== ''){

                                        if(data[key][period] === undefined){
                                            data[key][period] = data['general'];
                                        }
                                    }
                                    
                                    defaultSettingsForm['fields'][2]['value'] = data[key][period]['price'] !== undefined ? data[key][period]['price']:0;   
                                    defaultSettingsForm['fields'][3]['value'] = data[key][period]['monthly_price'] !== undefined ? data[key][period]['monthly_price']:0;   
                                    defaultSettingsForm['fields'][4]['value'] = data[key][period]['weekly_price'] !== undefined ? data[key][period]['weekly_price']:0;   
                                    defaultSettingsForm['fields'][5]['value'] = data[key][period]['weekend_price'] !== undefined ? data[key][period]['weekend_price']:0;   
                                    defaultSettingsForm['fields'][6]['value'] = data[key][period]['status']
                                    defaultSettingsForm['fields'][7]['value'] = data[key][period]['available'];
                                    defaultSettingsForm['fields'][8]['value'] = data[key][period]['booked'];
                                    defaultSettingsForm['fields'][9]['value'] = data[key][period]['notes'];
                                break;
                                case 'weeks':
                                    var weeksOptions = [],
                                        currentDate = new Date(),
                                        currentWeek = currentDate.getWeek(),
                                        maxWeeks = currentDate.getWeeks();

                                    for(var i = 1; i<=maxWeeks; i++){
                                        weeksOptions.push(i);
                                    }

                                    defaultSettingsForm['fields'][0]['label'] = absdashboardtext['week'];
                                    defaultSettingsForm['fields'][0]['value'] = currentWeek;
                                    defaultSettingsForm['fields'][0]['type'] = 'select';
                                    defaultSettingsForm['fields'][0]['options'] = abookingsystemdashboardGeneral.select.options(weeksOptions);
                                
                                    var period =  currentWeek;
                                
                                    if(period !== ''){

                                        if(data[key][period] === undefined){
                                            data[key][period] = data['general'];
                                        }
                                    }
                                    
                                    defaultSettingsForm['fields'][2]['value'] = data[key][period]['price'] !== undefined ? data[key][period]['price']:0;   
                                    delete defaultSettingsForm['fields'][3];   
                                    defaultSettingsForm['fields'][4]['value'] = data[key][period]['weekly_price'] !== undefined ? data[key][period]['weekly_price']:0;   
                                    defaultSettingsForm['fields'][5]['value'] = data[key][period]['weekend_price'] ? data[key][period]['weekend_price']:0;   
                                    defaultSettingsForm['fields'][6]['value'] = data[key][period]['status']
                                    defaultSettingsForm['fields'][7]['value'] = data[key][period]['available'];
                                    defaultSettingsForm['fields'][8]['value'] = data[key][period]['booked'];
                                    defaultSettingsForm['fields'][9]['value'] = data[key][period]['notes'];
                                    defaultSettingsForm['fields']             = abookingsystemdashboardGeneral.reOrderArray(defaultSettingsForm['fields']);
                                break;
                                case 'custom_date':
                                    var customDateOptions = [],
                                        currentDate = new Date(),
                                        currentYear = currentDate.getFullYear();

                                    for(var i = currentYear; i<=(currentYear+50); i++){
                                        customDateOptions.push(i);
                                    }

                                    defaultSettingsForm['fields'][0]['label'] = absdashboardtext['year'];
                                    defaultSettingsForm['fields'][0]['value'] = currentYear;
                                    defaultSettingsForm['fields'][0]['type'] = 'select';
                                    defaultSettingsForm['fields'][0]['options'] = abookingsystemdashboardGeneral.select.options(customDateOptions);
                                
                                    var period =  currentYear;
                                
                                    if(period !== ''){

                                        if(data[key][period] === undefined){
                                            data[key][period] = data['general'];
                                        }
                                    }
                                    
                                    defaultSettingsForm['fields'][2]['value'] = data[key][period]['price'] ? data[key][period]['price']:0;   
                                    defaultSettingsForm['fields'][3]['value'] = data[key][period]['monthly_price'] ? data[key][period]['monthly_price']:0;   
                                    defaultSettingsForm['fields'][4]['value'] = data[key][period]['weekly_price'] ? data[key][period]['weekly_price']:0;   
                                    defaultSettingsForm['fields'][5]['value'] = data[key][period]['weekend_price'] ? data[key][period]['weekend_price']:0;   
                                    defaultSettingsForm['fields'][6]['value'] = data[key][period]['status']
                                    defaultSettingsForm['fields'][7]['value'] = data[key][period]['available'];
                                    defaultSettingsForm['fields'][8]['value'] = data[key][period]['booked'];
                                    defaultSettingsForm['fields'][9]['value'] = data[key][period]['notes'];
                                
                                break;
                            }
                            abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box('advanced_'+key), defaultSettingsForm);
                        }
                    },
                    modify: function(key,
                                     field,
                                     value){
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data),
                            period = $('#absd-form-availability_'+key+'-'+key+'_period').val(),
                            generalData = data['general'];
                        
                        if(period !== '') {
                          
                            if(data[key] === undefined
                              || data[key] === null) {
                                data[key] = {};
                            }
                          
                            if(data[key][period] === undefined
                              || data[key][period] === null) {
                                data[key][period] = {};
                                data[key][period]['available'] = generalData['available'];
                                data[key][period]['booked'] = generalData['booked'];
                                data[key][period]['currency'] = generalData['currency'];
                                data[key][period]['fee'] = generalData['fee'];
                                data[key][period]['network_fee'] = generalData['network_fee'],
                                data[key][period]['network_fee_type'] = generalData['network_fee_type'],
                                data[key][period]['group'] = generalData['group'];
                                data[key][period]['hours'] = {use: '',
                                                              select: '',
                                                              data: ''};
                                data[key][period]['notes'] = generalData['notes'];
                                data[key][period]['price'] = generalData['price'];
                                data[key][period]['promo'] = generalData['promo'];
                                data[key][period]['status'] = generalData['status'];
                            }
                          
                            data[key][period][field] = value;
                        } else {
                            data[key][field] = value;
                          
                            if(data['general']['hours'] !== undefined) {
                                data['general']['hours'] = {use: '',
                                                            select: '',
                                                            data: ''};
                            }
                        }
                        
                        abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data = JSON.stringify(data);
                    },
                    enabling: function(key,
                                       field,
                                       myElement){
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data),
                            period = $('#absd-form-availability_'+key+'-'+key+'_period').val(),
                            generalData = data['general'],
                            enabled = $(myElement).hasClass('absd-opened') ? 'true':'false';
                        
                        var tempPriceKey = field.split('_enabled')[0];
                      
                        if(enabled === 'true') {
                            $(myElement).removeClass('absd-opened');
                            enabled = 'false';
                            $('#absd-form-availability_general-general_'+tempPriceKey).val(0);
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-final').val(0);
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-fee').val(0);
                            $('#absd-form-availability_general-general_'+tempPriceKey).attr('disabled', 'disabled');
                            $('#absd-form-availability_general-general_'+tempPriceKey).css('opacity', '0.3');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-fee').css('opacity', '0.3');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-final').attr('disabled', 'disabled');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-final').css('opacity', '0.3');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-currency').css('opacity', '0.3');
                            data[key][tempPriceKey] = 0;
                        } else {
                            $(myElement).addClass('absd-opened');
                            $('#absd-form-availability_general-general_'+tempPriceKey).removeAttr('disabled');
                            $('#absd-form-availability_general-general_'+tempPriceKey).css('opacity', '1');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-fee').css('opacity', '1');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-final').removeAttr('disabled');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-final').css('opacity', '1');
                            $('#absd-form-availability_general-general_'+tempPriceKey+'-currency').css('opacity', '1');
                            enabled = 'true';
                        }
                        
                        data[key][field] = enabled;
                        
                        abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data = JSON.stringify(data);
                    },
                    change: function(key, period){
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data);
                      
                        if(data[key] === undefined) {
                            data[key] = {};
                        }
                      
                        if(data[key][period] === undefined) {
                            data[key][period] = data['general'];
                        }
                        
                        var feePrice = abookingsystemdashboardForm.fee.price(abookingsystemdashboard['account_type'], data[key][period]['price']),
                            finalPrice = data[key][period]['price']+feePrice,
                            weeklyFeePrice = abookingsystemdashboardForm.fee.price(abookingsystemdashboard['account_type'], data[key][period]['weekly_price']),
                            weeklyFinalPrice = data[key][period]['weekly_price']+weeklyFeePrice,
                            weekendFeePrice = abookingsystemdashboardForm.fee.price(abookingsystemdashboard['account_type'], data[key][period]['weekend_price']),
                            weekendFinalPrice = data[key][period]['weekend_price']+weekendFeePrice,
                            monthlyFeePrice = abookingsystemdashboardForm.fee.price(abookingsystemdashboard['account_type'], data[key][period]['monthly_price']),
                            monthlyFinalPrice = data[key][period]['monthly_price']+monthlyFeePrice;
                        
                        if(data[key][period]['network_fee'] !== undefined 
                            && data[key][period]['network_fee'] > 0) {

                            if(data[key][period]['network_fee_type'] === 'percent') {
                                feePrice            += data[key][period]['price']*data[key][period]['network_fee'];
                                finalPrice          += data[key][period]['price']*data[key][period]['network_fee'];
                                weeklyFeePrice      += data[key][period]['weekly_price']*data[key][period]['network_fee'];
                                weeklyFinalPrice    += data[key][period]['weekly_price']*data[key][period]['network_fee'];
                                weekendFeePrice     += data[key][period]['weekend_price']*data[key][period]['network_fee'];
                                weekendFinalPrice   += data[key][period]['weekend_price']*data[key][period]['network_fee'];
                                monthlyFeePrice     += data[key][period]['monthly_price']*data[key][period]['network_fee'];
                                monthlyFinalPrice   += data[key][period]['monthly_price']*data[key][period]['network_fee'];
                            } else {
                                feePrice            += data[key][period]['network_fee'];
                                finalPrice          += data[key][period]['network_fee'];
                                weeklyFeePrice      += data[key][period]['network_fee'];
                                weeklyFinalPrice    += data[key][period]['network_fee'];
                                weekendFeePrice     += data[key][period]['network_fee'];
                                weekendFinalPrice   += data[key][period]['network_fee'];
                                monthlyFeePrice     += data[key][period]['network_fee'];
                                monthlyFinalPrice   += data[key][period]['network_fee'];
                            }
                        }
                        
                        // Daily price
                        $('#absd-form-availability_'+key+'-'+key+'_price').val(data[key][period]['price']);
                        $('#absd-form-availability_'+key+'-'+key+'_price-fee').val(parseFloat(feePrice).toFixed(2));
                        $('#absd-form-availability_'+key+'-'+key+'_price-final').val(parseFloat(finalPrice).toFixed(2));
                        
                        // Weekly price
                        $('#absd-form-availability_'+key+'-'+key+'_weekly_price').val(data[key][period]['weekly_price']);
                        $('#absd-form-availability_'+key+'-'+key+'_weekly_price-fee').val(parseFloat(weeklyFeePrice).toFixed(2));
                        $('#absd-form-availability_'+key+'-'+key+'_weekly_price-final').val(parseFloat(weeklyFinalPrice).toFixed(2));
                        
                        // Weekend price
                        $('#absd-form-availability_'+key+'-'+key+'_weekend_price').val(data[key][period]['weekend_price']);
                        $('#absd-form-availability_'+key+'-'+key+'_weekend_price-fee').val(parseFloat(weekendFeePrice).toFixed(2));
                        $('#absd-form-availability_'+key+'-'+key+'_weekend_price-final').val(parseFloat(weekendFinalPrice).toFixed(2));
                        
                        // Monthly price
                        $('#absd-form-availability_'+key+'-'+key+'_monthly_price').val(data[key][period]['monthly_price']);
                        $('#absd-form-availability_'+key+'-'+key+'_monthly_price-fee').val(parseFloat(monthlyFeePrice).toFixed(2));
                        $('#absd-form-availability_'+key+'-'+key+'_monthly_price-final').val(parseFloat(monthlyFinalPrice).toFixed(2));
                        
                        $('#absd-form-availability_'+key+'-'+key+'_status').val(data[key][period]['status']);
                        $('#absd-form-availability_'+key+'-'+key+'_booked').val(data[key][period]['booked']);
                        $('#absd-form-availability_'+key+'-'+key+'_available').val(data[key][period]['available']);
                        $('#absd-form-availability_'+key+'-'+key+'_notes').val(data[key][period]['notes']);
                    },
                    save: function(){
                        
                        if((abookingsystemdashboardCalendars['data']['current']['group_id'] === 0
                            || abookingsystemdashboardCalendars['data']['current']['group_id'] === '0')
                            && abookingsystemdashboardCalendars['data']['current']['is_group'] === 'true') {
                            // Start Loader
                            abookingsystemdashboardInfo.start(absdashboardtext['availability_warning_head'],
                                             absdashboardtext['availability_warning'],
                                             absdashboardtext['button_yes'],
                                             absdashboardtext['button_no'],
                                             abookingsystemdashboardCalendars.calendar.setup.view.content.availability.save_ok);
                        } else {
                            abookingsystemdashboardCalendars.calendar.setup.view.content.availability.save_ok();
                        }
                    },
                    check: function(){
                        var availability_data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data),
                            min_price = parseInt(10*abookingsystemdashboardCalendars.data.currency_rate);
                        
                        // Hide errors
                        $('.absd-errors').addClass('absd-invisible');
                        $('div.absd-error').addClass('absd-invisible');
                        $('.absd-input').removeClass('absd-error');
                        $('.absd-textarea').removeClass('absd-error');
                        $('.absd-select').removeClass('absd-error');
                        
                        for(var key in availability_data){
                            
                            if(key === 'general') {
                                
                                if(availability_data[key]['monthly_price'] !== undefined
                                  && availability_data[key]['monthly_price'] !== 0) {

                                    if(availability_data[key]['monthly_price'] < min_price) {
                                        abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_monthly_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                        $('#absd-form-availability_'+key+'-'+key+'_monthly_price-errors').removeClass('absd-invisible');
                                        $('#absd-form-availability_'+key+'-'+key+'_monthly_price.absd-input').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_monthly_price.absd-textarea').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_monthly_price-select.absd-select').addClass('absd-error');
                                        return 'error';
                                    }
                                }

                                if(availability_data[key]['weekly_price'] !== undefined
                                  && availability_data[key]['weekly_price'] !== 0) {

                                    if(availability_data[key]['weekly_price'] < min_price) {
                                        abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_weekly_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                        $('#absd-form-availability_'+key+'-'+key+'_weekly_price-errors').removeClass('absd-invisible');
                                        $('#absd-form-availability_'+key+'-'+key+'_weekly_price.absd-input').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_weekly_price.absd-textarea').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_weekly_price-select.absd-select').addClass('absd-error');
                                        return 'error';
                                    }
                                }

                                if(availability_data[key]['weekend_price'] !== undefined
                                  && availability_data[key]['weekend_price'] !== 0) {

                                    if(availability_data[key]['weekend_price'] < min_price) {
                                        abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_weekend_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                        $('#absd-form-availability_'+key+'-'+key+'_weekend_price-errors').removeClass('absd-invisible');
                                        $('#absd-form-availability_'+key+'-'+key+'_weekend_price.absd-input').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_weekend_price.absd-textarea').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_weekend_price-select.absd-select').addClass('absd-error');
                                        return 'error';
                                    }
                                }

                                if(availability_data[key]['price'] !== undefined
                                  && availability_data[key]['price'] !== 0) {

                                    if(availability_data[key]['price'] < min_price) {
                                        abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                        $('#absd-form-availability_'+key+'-'+key+'_price-errors').removeClass('absd-invisible');
                                        $('#absd-form-availability_'+key+'-'+key+'_price.absd-input').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_price.absd-textarea').addClass('absd-error');
                                        $('#absd-form-availability_'+key+'-'+key+'_price-select.absd-select').addClass('absd-error');
                                        return 'error';
                                    }
                                }
                            } else {
                                
                                for(var skey in availability_data[key]){
                                    
                                    if(availability_data[key][skey]['monthly_price'] !== undefined
                                      && availability_data[key][skey]['monthly_price'] !== 0) {

                                        if(availability_data[key][skey]['monthly_price'] < min_price) {
                                            abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_monthly_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                            $('#absd-form-availability_'+key+'-'+key+'_monthly_price-errors').removeClass('absd-invisible');
                                            $('#absd-form-availability_'+key+'-'+key+'_monthly_price.absd-input').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_monthly_price.absd-textarea').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_monthly_price-select.absd-select').addClass('absd-error');
                                            return 'error';
                                        }
                                    }

                                    if(availability_data[key][skey]['weekly_price'] !== undefined
                                      && availability_data[key][skey]['weekly_price'] !== 0) {

                                        if(availability_data[key][skey]['weekly_price'] < min_price) {
                                            abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_weekly_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                            $('#absd-form-availability_'+key+'-'+key+'_weekly_price-errors').removeClass('absd-invisible');
                                            $('#absd-form-availability_'+key+'-'+key+'_weekly_price.absd-input').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_weekly_price.absd-textarea').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_weekly_price-select.absd-select').addClass('absd-error');
                                            return 'error';
                                        }
                                    }

                                    if(availability_data[key][skey]['weekend_price'] !== undefined
                                      && availability_data[key][skey]['weekend_price'] !== 0) {

                                        if(availability_data[key][skey]['weekend_price'] < min_price) {
                                            abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_weekend_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                            $('#absd-form-availability_'+key+'-'+key+'_weekend_price-errors').removeClass('absd-invisible');
                                            $('#absd-form-availability_'+key+'-'+key+'_weekend_price.absd-input').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_weekend_price.absd-textarea').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_weekend_price-select.absd-select').addClass('absd-error');
                                            return 'error';
                                        }
                                    }

                                    if(availability_data[key][skey]['price'] !== undefined
                                      && availability_data[key][skey]['price'] !== 0) {

                                        if(availability_data[key][skey]['price'] < min_price) {
                                            abookingsystemdashboardForm.fields.field.error($('#absd-form-availability_'+key+'-'+key+'_price-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], min_price);
                                            $('#absd-form-availability_'+key+'-'+key+'_price-errors').removeClass('absd-invisible');
                                            $('#absd-form-availability_'+key+'-'+key+'_price.absd-input').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_price.absd-textarea').addClass('absd-error');
                                            $('#absd-form-availability_'+key+'-'+key+'_price-select.absd-select').addClass('absd-error');
                                            return 'error';
                                        }
                                    }
                                }
                            }
                        }
                        
                        return 'ok';
                    },
                    save_ok: function(){
                        var check = abookingsystemdashboardCalendars.calendar.setup.view.content.availability.check();
                        
                        if(check !== "error"){
                            // Start Loader
                            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                               absdashboardtext['wait']);

                            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings_save'],
                                                        is_ajax_request: true,
                                                        type: 'availaibility',
                                                        calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                        is_group: abookingsystemdashboardCalendars['data']['current']['is_group'],
                                                        api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                        data: abookingsystemdashboardCalendars.calendar.setup.view.content.availability.data,
                                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){

                                data = JSON.parse(data);

                                if(data['status'] === "success"){
                                    // Stop Loader
                                    abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                                       absdashboardtext['save_success'],
                                                       true);
                                }

                            });
                        }
                    }
                },
                settings: {
                    data: {},
                    start: function(){
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);

                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings'],
                                                    is_ajax_request: true,
                                                    ajax_ses: abookingsystemdashboard['ajax_ses'],
                                                    type: 'settings',
                                                    calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                    api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                    is_group: abookingsystemdashboardCalendars['data']['current']['is_group']}, function(data){
                            abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data = data;
                          
                            // Create Default & Advanced Tabs
                            var tabsData = [{label: '',
                                            name: "default_settings"}];

                            abookingsystemdashboardTabs.start($('.absd-content-settings-box'), tabsData);
                          
                            abookingsystemdashboardCalendars.calendar.setup.view.content.settings.show();
                          
                            // Stop Loader
                            abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                               absdashboardtext['refresh'],
                                               true);

                        });
                    },
                    show: function(key){
                        // Create Forms
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data);
                        var settingsForm = {
                            name: "settings",
                            fields: [
                              {
                                  label: absdashboardtext['calendar_name'],
                                  name: "name",
                                  value: data['name'],  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('name', this.value); jQuery('#absd-calendar-"+abookingsystemdashboardCalendars['data']['current']['calendar_id']+"-name').html(this.value);",
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
                                label: absdashboardtext['space_cover'],
                                name: "space_cover",
                                value: data['cover'],    // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('cover', window.absdSelectedValue)",
                                placeholder: "",  
                                required: "false",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                type: "image",                          // text, textarea, select, radio, checkbox, password
                                options: {},     // select options
                                label_class: "",
                                input_class: "",
                                hint: "",
                                label_position: "left"              // left, right, left_full, right_full
                              },
                              {
                                  label: absdashboardtext['calendar_location'],
                                  name: "location",
                                  value: data['location'],  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('location', jQuery('#'+this.id.split('-map')[0]).val())",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "map",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                  label: absdashboardtext['calendar_address'],
                                  name: "address",
                                  value: data['address'],  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('address', this.value)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "textarea",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                  label: absdashboardtext[abookingsystemdashboard['used_for']+'_calendar_type'],
                                  name: "category",
                                  value: data['category'],        // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('category', window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                            // text, textarea, select, radio, checkbox, password
                                  options: abookingsystemdashboardGeneral.select.optionsLower(data['categories']),     // select options : abookingsystemdashboardCalendars.data.categories
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                  label: absdashboardtext['rent_type'],
                                  name: "mode",
                                  value: data['mode'],        // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('mode', window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                            // text, textarea, select, radio, checkbox, password
                                  options: [{"name": absdashboardtext['rent_type_nights'], "value": 'nights'},{"name": absdashboardtext['rent_type_days'], "value": 'days'}],     // select options : abookingsystemdashboardCalendars.data.categories
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                               {
                                label: absdashboardtext['space_check_in_time'],
                                name: "check_in",
                                value: data['check_in'],        // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('check_in', window.absdSelectedValue)",
                                placeholder: "",  
                                required: "true",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                type: "select",                            // text, textarea, select, radio, checkbox, password
                                options: abookingsystemdashboardCalendars.hours.get(),     // select options : abookingsystemdashboardCalendars.data.categories
                                label_class: "",
                                input_class: "",
                                hint: "",
                                label_position: "left"         // left, right, left_full, right_full
                               },
                               {
                                label: absdashboardtext['space_check_out_time'],
                                name: "check_out",
                                value: data['check_out'],        // default value
                                modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('check_out', window.absdSelectedValue)",
                                placeholder: "",  
                                required: "true",
                                allowed_characters: "",
                                min_chars: 0,     // 0 - disabled
                                max_chars: 0,     // 0 - disabled
                                is_email: "false",
                                is_phone: "false",
                                type: "select",                            // text, textarea, select, radio, checkbox, password
                                options: abookingsystemdashboardCalendars.hours.get(),     // select options : abookingsystemdashboardCalendars.data.categories
                                label_class: "",
                                input_class: "",
                                hint: "",
                                label_position: "left"         // left, right, left_full, right_full
                               },
                              {
                                  label: absdashboardtext['vat_or_gst_included'],
                                  name: "vat_included",
                                  value: data['vat_included'],  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('vat_included', window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                            // text, textarea, select, radio, checkbox, password
                                  options: [{"name": absdashboardtext['vat_or_gst_included_yes'], "value": "true"},{"name": absdashboardtext['vat_or_gst_included_no'], "value": "false"}],     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                  label: absdashboardtext['vat_or_gst'],
                                  name: "vat",
                                  value: data['vat'],  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('vat', this.value)",
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
                                  label: absdashboardtext['calendars_allowed'],
                                  name: "allowed_websites",
                                  value: data['allowed_websites'].split(',').join('\n'),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('allowed_websites', this.value)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "textarea",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                label: absdashboardtext['save'],
                                name: "save",
                                value: data['save'],        // default value
                                placeholder: "",  
                                action: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.check()",
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

                        },
                        rulesForm = {
                            name: "rules",
                            fields: [
                              {
                                  label: absdashboardtext[abookingsystemdashboard['used_for']+'_rules'],
                                  name: "rules",
                                  value: data['rules'],  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('rules', this.value)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "textarea",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                label: absdashboardtext['save'],
                                name: "save",
                                value: data['save'],        // default value
                                placeholder: "",  
                                action: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.save()",
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

                        },
                        cancellationForm = {
                            name: "cancellation",
                            fields: [
                              {
                                  label: absdashboardtext['cancellation_allowed'],
                                  name: "cancellation",
                                  value: parseInt(data['cancellation']),        // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('cancellation', window.absdSelectedValue)",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "select",                            // text, textarea, select, radio, checkbox, password
                                  options: abookingsystemdashboardGeneral.select.optionsTime(),     // select options : abookingsystemdashboardCalendars.data.categories
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                  label: absdashboardtext['cancellation_refund'],
                                  name: "refund",
                                  value: data['refund'],  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('refund', this.value)",
                                  placeholder: "",  
                                  required: "true",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  lower_than: 100,
                                  higher_than: 0,
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: absdashboardtext['cancellation_refund_info'],
                                  label_position: "left"         // left, right, left_full, right_full
                              },
                              {
                                label: absdashboardtext['save'],
                                name: "save",
                                value: data['save'],        // default value
                                placeholder: "",  
                                action: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.save()",
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
                      
                      if(abookingsystemdashboardCalendars['data']['current']['group_id'] !== '0') {
                          var syncForm = {
                              name: "sync",
                              fields: [
                                {
                                  label: absdashboardtext['sync_airbnb'],
                                  name: "airbnb_com",
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=airbnb_com&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_booking_com'],
                                  name: "booking_com",
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=booking_com&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_google_calendar'],
                                  name: "google_calendar",
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=google_calendar&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_homeaway_com'],
                                  name: "homeaway_com",
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=homeaway_com&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_homestay_com'],
                                  name: "homestay_com",
                                  value: data['homestay_com'],  // default value
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=homestay_com&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_vrbo_com'],
                                  name: "vrbo_com",
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=vrbo_com&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_flipkey_com'],
                                  name: "flipkey_com",
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=flipkey_com&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_other_calendar'],
                                  name: "other_calendar",
                                  value: abookingsystemdashboardCalendars.data.link+'ical?type=other_calendar&api_key='+abookingsystemdashboardCalendars['data']['current']['api_key']+'&lang='+abookingsystemdashboardCalendars.data.language,  // default value
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  is_read_only: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                }]

                          };
                          
                          settingsForm = {
                              name: "settings",
                              fields: [
                                {
                                    label: absdashboardtext['calendar_name'],
                                    name: "name",
                                    value: data['name'],  // default value
                                    modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('name', this.value); jQuery('#absd-calendar-"+abookingsystemdashboardCalendars['data']['current']['calendar_id']+"-name').html(this.value);",
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
                                  label: absdashboardtext['save'],
                                  name: "save",
                                  value: data['save'],        // default value
                                  placeholder: "",  
                                  action: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.save()",
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
                      }
                      
                      if(abookingsystemdashboardCalendars['data']['current']['group_id'] === '0') {
                        var settingsAccordion = [{label: absdashboardtext['main_settings'],
                                                  name: "main_settings",
                                                  class: "absd-opened"},
                                                 {label: absdashboardtext['rules_settings'],
                                                  name: "rules_settings"},
                                                 {label: absdashboardtext['cancellation_settings'],
                                                  name: "cancellation_settings"}];
                      } else {
                        var settingsAccordion = [{label: absdashboardtext['main_settings'],
                                                  name: "main_settings",
                                                  class: "absd-opened"},
                                                 {label: absdashboardtext['sync_my_settings'],
                                                  name: "sync_settings"}];
                      }
                      
                      
                        abookingsystemdashboardAccordion.start($('#absd-tab-default_settings-content'), settingsAccordion, 'absd-black');
                      
                        abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box('main_settings'), settingsForm);
                      
                        if(abookingsystemdashboardCalendars['data']['current']['group_id'] === '0') {
                            abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box('rules_settings'), rulesForm);
                            abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box('cancellation_settings'), cancellationForm);
                        } else {
                            abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box('sync_settings'), syncForm);
                        }
                        
//                               {
//                                   label: absdashboardtext['currency'],
//                                   name: "currency",
//                                   value: data['currency'],        // default value
//                                   modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.settings.modify('currency', window.absdSelectedValue)",
//                                   placeholder: "",  
//                                   required: "false",
//                                   allowed_characters: "",
//                                   min_chars: 0,     // 0 - disabled
//                                   max_chars: 0,     // 0 - disabled
//                                   is_email: "false",
//                                   is_phone: "false",
//                                   type: "select",                            // text, textarea, select, radio, checkbox, password
//                                   options: abookingsystemdashboardGeneral.currencies.get(),     // select options : abookingsystemdashboardCalendars.data.categories
//                                   label_class: "",
//                                   input_class: "",
//                                   hint: "",
//                                   label_position: "left"         // left, right, left_full, right_full
//                               },

//                         abookingsystemdashboardForm.start(abookingsystemdashboardTabs.box('default_settings'), settingsForm);
                     
                    },
                    modify: function(field, value){
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data);
                        
                        if(field === 'allowed_websites') {
                            value = value.replace(/\r?\n/g, ',');
                        }
                        
                        data[field] = value;
                      
                        abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data = JSON.stringify(data);
                    },
                    check: function(){
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data);
                        
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);
                        
                        if(window.wdhMapDataLocation !== undefined) {
                            data['location'] = window.wdhMapDataLocation;
                            window.wdhMapDataLocation['name'] = window.wdhMapDataLocation['address'];
                            abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data = JSON.stringify(data);
                          
                            
                            if(window.wdhMapDataLocation['timezone'] === undefined
                              || window.wdhMapDataLocation['timezone'] === 'no') {
                                $.ajax({
                                   url:"https://maps.googleapis.com/maps/api/timezone/json?key="+abookingsystemdashboard["google_map_api_key"]+window.wdhMapDataLocation['latitude']+","+window.wdhMapDataLocation['longitude']+"&timestamp="+(Math.round((new Date().getTime())/1000)).toString()+"&sensor=false",
                                }).done(function(response){

                                   if(response.timeZoneId != null){
                                      var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data);
                                          window.wdhMapDataLocation['timezone'] = response.timeZoneId;
                                          data['location'] = window.wdhMapDataLocation;
                                          abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data = JSON.stringify(data);
                                          abookingsystemdashboardCalendars.calendar.setup.view.content.settings.save(true);
                                   }
                                });
                            } else {
                                abookingsystemdashboardCalendars.calendar.setup.view.content.settings.save(true);
                            }
                        } else {
                            abookingsystemdashboardCalendars.calendar.setup.view.content.settings.save(true);
                        }
                    },
                    save: function(checked = false){
                        var data = abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data;
                        fields = abookingsystemdashboardForm.fields.get();
          
                        if(fields !== "error"){  
                        
                            if(!checked) {
                                // Start Loader
                                abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                                   absdashboardtext['wait']);
                            }

                            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings_save'],
                                                        is_ajax_request: true,
                                                        type: 'settings',
                                                        calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                        is_group: abookingsystemdashboardCalendars['data']['current']['is_group'],
                                                        api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                        data: abookingsystemdashboardCalendars.calendar.setup.view.content.settings.data.replace(/\r?\n/g, ','),
                                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                                data = JSON.parse(data);

                                if(data['status'] === "success"){
                                    // Stop Loader
                                    abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                                       absdashboardtext['save_success'],
                                                       true);
                                }

                            });
                        }
                    }
                },
                form: {
                    data: {},
                    start: function(){
                        // Start Loader
                      abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                         absdashboardtext['wait']);

                      $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings'],
                                                  is_ajax_request: true,
                                                  ajax_ses: abookingsystemdashboard['ajax_ses'],
                                                  type: 'form',
                                                  calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                  api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                  is_group: abookingsystemdashboardCalendars['data']['current']['is_group']}, function(data){
                          abookingsystemdashboardCalendars.calendar.setup.view.content.form.data = data;
                        
//                           defaultTab = ['email', 'phone', 'full_name', 'country', 'city', 'persons', 'password', 'zip_code', 'message'];
                          defaultTab = ['city', 'persons', 'password', 'zip_code', 'message'];
                          data = JSON.parse(data);
                        
                          // Create Default & Advanced Tabs
                          var tabsData = [{label: absdashboardtext['default_settings'],
                                          name: "default_settings"},
                                         {label: absdashboardtext['advanced_settings'],
                                          name: "advanced_settings"}];
                        
                          abookingsystemdashboardTabs.start($('.absd-content-settings-box'), tabsData);
                        
                          // Create Advanced Accordions
                          var accordionData = [];
                        
                          $.each(data, function( index, value ) {
                            
                              if (defaultTab.includes(index)) {
                                
                                  accordionData.push({label: value['name'], name: value['id']});
                              }
                          });
                          
                          abookingsystemdashboardAccordion.start($('#absd-tab-default_settings-content'), accordionData);
                            
                          for(var i = 0; i < accordionData.length; i++){
                              abookingsystemdashboardCalendars.calendar.setup.view.content.form.show(accordionData[i]['name']);    
                          }

                          // Stop Loader
                          abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                             absdashboardtext['refresh'],
                                             true);

                      });
                    },
                    show: function(key){
                        // Create Forms
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.form.data);
                        
                        if(data[key] !== undefined){
                            var isUsed = (data[key]['type'] === "no")?"false":"true";
                            var isRequired = (data[key]['type'] === "required")?"true":"false";
                        }
                        
                        var defaultSettingsForm = {
                            name: "form_"+key,
                            fields: [{
                                    label: absdashboardtext['form_use'],
                                    name: key+"_use",
                                    value: isUsed,        // default value
                                    modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.form.modify('"+key+"', this, 'use')",
                                    placeholder: '',  
                                    required: "false",
                                    allowed_characters: "",
                                    min_chars: 0,     // 0 - disabled
                                    max_chars: 0,     // 0 - disabled
                                    is_email: "false",
                                    is_phone: "false",
                                    is_numeric: "false",
                                    type: "switch",                            // text, textarea, select, radio, checkbox, password
                                    options:  "",     // select options
                                    label_class: "",
                                    input_class: "",
                                    hint: "",
                                    label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                    label: absdashboardtext['form_required'],
                                    name: key+"_required",
                                    value: isRequired,        // default value
                                    modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.form.modify('"+key+"', this, 'required')",
                                    placeholder: '',  
                                    required: "false",
                                    allowed_characters: "",
                                    min_chars: 0,     // 0 - disabled
                                    max_chars: 0,     // 0 - disabled
                                    is_email: "false",
                                    is_phone: "false",
                                    is_numeric: "false",
                                    type: "switch",                            // text, textarea, select, radio, checkbox, password
                                    options:  "",     // select options
                                    label_class: "",
                                    input_class: "is_required",
                                    hint: "",
                                    label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                    label: absdashboardtext['save'],
                                    name: key+"_save",
                                    value: data[key]['save'],        // default value
                                    placeholder: "",  
                                    action: "abookingsystemdashboardCalendars.calendar.setup.view.content.form.save()",
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
                      
                        abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box(key), defaultSettingsForm);
                        
                    },
                    modify: function(key, fieldObj, fieldName){
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.form.data);
                        
                        if(fieldName === "use"){
                            
                            if(fieldObj.checked) {
                                data[key]['type'] = 'optional';
                            } else {
                                data[key]['type'] = 'no';
                                $('#absd-form-form_'+key+'-'+key+'_required').removeAttr('checked');
                            }
                        }
                      
                        if(fieldName === "required" && data[key]['type'] !== "no"){
                            data[key]['type'] = (fieldObj.checked) ? "required":"optional";
                        }
                      
                        abookingsystemdashboardCalendars.calendar.setup.view.content.form.data = JSON.stringify(data);
                    },
                    save: function(){
                      
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);

                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings_save'],
                                                    is_ajax_request: true,
                                                    type: 'form',
                                                    calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                    is_group: abookingsystemdashboardCalendars['data']['current']['is_group'],
                                                    api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                    data: abookingsystemdashboardCalendars.calendar.setup.view.content.form.data,
                                                    ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                            data = JSON.parse(data);  
                          
                            if(data['status'] === "success"){
                                // Stop Loader
                                abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                                   absdashboardtext['save_success'],
                                                   true);
                            }

                        });
                    }
                },
                notifications: {
                    data: {},
                    start: function(){
                        // Start Loader
                      abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                         absdashboardtext['wait']);

                      $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings'],
                                                  is_ajax_request: true,
                                                  ajax_ses: abookingsystemdashboard['ajax_ses'],
                                                  type: 'notifications',
                                                  calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                  api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                  is_group: abookingsystemdashboardCalendars['data']['current']['is_group']}, function(data){
                          data = JSON.parse(data);
                          abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.data = data;
                        
                          // Create Default & Advanced Tabs
                          var tabsData = [{label: absdashboardtext['for_host'],
                                          name: "for_host"},
                                         {label: absdashboardtext['for_guest'],
                                          name: "for_guest"}];
                        
                          abookingsystemdashboardTabs.start($('.absd-content-settings-box'), tabsData);
                        
                          // Create Advanced Accordions
                          var accordionHostData = [{label: absdashboardtext['via_email_host'],
                                                name: "via_email_host"},
                                               {label: absdashboardtext['via_sms_host'],
                                                name: "via_sms_host"}];
                          var accordionGuestData = [{label: absdashboardtext['via_email_guest'],
                                                name: "via_email_guest"},
                                               {label: absdashboardtext['via_sms_guest'],
                                                name: "via_sms_guest"}];
                          
                          abookingsystemdashboardAccordion.start($('#absd-tab-for_host-content'), accordionHostData);
                          abookingsystemdashboardAccordion.start($('#absd-tab-for_guest-content'), accordionGuestData);
                            
                          // Show
                          abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.show('via_email_host');
                          abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.show('via_sms_host');
                          abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.show('via_email_guest');
                          abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.show('via_sms_guest');

                          // Stop Loader
                          abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                             absdashboardtext['refresh'],
                                             true);

                      });
                    },
                    show: function(key){
                        // Create Forms
                        var data = abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.data;
                      
                        var keyData = key.split('_'),
                            keyOne = keyData[2],
                            keySecond = keyData[1];

                        if(data[keyOne] !== undefined){
                            var messagesForLang = data[keyOne][keySecond]['message'];
                        }
                      
                        var defaultSettingsForm = {
                            name: "notifications_"+key,
                            fields: [{
                                    label: absdashboardtext['send'],
                                    name: key+"_send",
                                    value: data[keyOne][keySecond]['send'],        // default value
                                    modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.modify('"+key+"', this.checked, 'send')",
                                    placeholder: '',  
                                    required: "false",
                                    allowed_characters: "",
                                    min_chars: 0,     // 0 - disabled
                                    max_chars: 0,     // 0 - disabled
                                    is_email: "false",
                                    is_phone: "false",
                                    is_numeric: "false",
                                    type: "switch",                            // text, textarea, select, radio, checkbox, password
                                    options:  "",     // select options
                                    label_class: "",
                                    input_class: "",
                                    hint: "",
                                    label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                    label: absdashboardtext['sender'],
                                    name: key+"_sender",
                                    value: data[keyOne][keySecond]['sender'],        // default value
                                    modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.modify('"+key+"', this.value, 'sender')",
                                    placeholder: '',  
                                    required: "false",
                                    allowed_characters: "",
                                    min_chars: 0,     // 0 - disabled
                                    max_chars: 0,     // 0 - disabled
                                    is_email: "false",
                                    is_phone: "false",
                                    is_numeric: "false",
                                    type: "text",                            // text, textarea, select, radio, checkbox, password
                                    options:  "",     // select options
                                    label_class: "",
                                    input_class: "",
                                    hint: "",
                                    label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                    label: absdashboardtext['language'],
                                    name: key+"_language",
                                    value: abookingsystemdashboard['language'],        // default value
                                    modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.change('"+key+"', this)",
                                    placeholder: '',  
                                    required: "false",
                                    allowed_characters: "",
                                    min_chars: 0,     // 0 - disabled
                                    max_chars: 0,     // 0 - disabled
                                    is_email: "false",
                                    is_phone: "false",
                                    is_numeric: "false",
                                    type: "select",                            // text, textarea, select, radio, checkbox, password
                                    options:  abookingsystemdashboardGeneral.languages.get.all(),     // select options
                                    label_class: "",
                                    input_class: "",
                                    hint: "",
                                    label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                    label: absdashboardtext['message'],
                                    name: key+"_message",
                                    value: messagesForLang[abookingsystemdashboard['language']],        // default value
                                    modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.modify('"+key+"', this, 'message')",
                                    placeholder: '',  
                                    required: "false",
                                    allowed_characters: "",
                                    min_chars: 0,     // 0 - disabled
                                    max_chars: 0,     // 0 - disabled
                                    is_email: "false",
                                    is_phone: "false",
                                    is_numeric: "false",
                                    type: "textarea",                            // text, textarea, select, radio, checkbox, password
                                    options:  "",     // select options
                                    label_class: "",
                                    input_class: "",
                                    hint: "",
                                    label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                    label: absdashboardtext['save'],
                                    name: key+"_save",
                                    value: "save",        // default value
                                    placeholder: "",  
                                    action: "abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.save()",
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
                      
                        if(keyOne === 'host'){
                          
                            if(keySecond === 'email') {
                               var addedField = {
                                      label: absdashboardtext['email'],
                                      name: key+"_email",
                                      value: data[keyOne][keySecond]['email'],        // default value
                                      modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.modify('"+key+"', this.value, 'email')",
                                      placeholder: '',  
                                      required: "false",
                                      allowed_characters: "",
                                      min_chars: 0,     // 0 - disabled
                                      max_chars: 0,     // 0 - disabled
                                      is_email: "true",
                                      is_phone: "false",
                                      is_numeric: "false",
                                      type: "text",                            // text, textarea, select, radio, checkbox, password
                                      options:  "",     // select options
                                      label_class: "",
                                      input_class: "",
                                      hint: "",
                                      label_position: "left"         // left, right, left_full, right_full
                                  };
                            } else {
                               var addedField = {
                                      label: absdashboardtext['phone'],
                                      name: key+"_phone",
                                      value: data[keyOne][keySecond]['phone'].indexOf('@') !== -1 ? data[keyOne][keySecond]['phone'].split('@')[1]:data[keyOne][keySecond]['phone'],        // default value
                                      placeholder: '',  
                                      required: "false",
                                      allowed_characters: "",
                                      min_chars: 0,     // 0 - disabled
                                      max_chars: 0,     // 0 - disabled
                                      is_email: "false",
                                      is_phone: "true",
                                      is_numeric: "false",
                                      type: "phone",                          // text, textarea, select, radio, checkbox, password
                                      country: data[keyOne][keySecond]['phone'].indexOf('@') !== -1 ? data[keyOne][keySecond]['phone'].split('@')[0]:'US',
                                      countries: abookingsystemdashboardCalendars.data.countries,
                                      options:  "",     // select options
                                      label_class: "",
                                      input_class: "",
                                      hint: "",
                                      modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.modify('"+key+"', this.value, 'phone', this)",
                                      label_position: "left"         // left, right, left_full, right_full
                                  };
                            }
                          
                            defaultSettingsForm['fields'].splice(1, 0, addedField);
                          
                        }
                      
                        abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box(key), defaultSettingsForm);
                        
                    },
                    modify: function(key, fieldValue, type, element){
                        var data = abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.data;
                      
                        if(type == 'send') {
                            fieldValue = (fieldValue === true || fieldValue === 'true') ? 'true':'false';
                        }
                                    
                        if(type === 'phone') {
                            abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.phone(element);

                            var phone = $('#absd-form-notifications_via_sms_host-via_sms_host_phone-country-code').val();
                            fieldValue = fieldValue.indexOf('@') !== -1 ? fieldValue:phone+'@'+fieldValue;
                        }

                        if(type !== 'message'){
                          
                            switch(key) {
                                case 'via_email_host':
                                    data['host']['email'][type] = fieldValue;
                                break;
                                case 'via_sms_host':
                                    data['host']['sms'][type] = fieldValue;
                                break;
                                case 'via_email_guest':
                                    data['guest']['email'][type] = fieldValue;
                                break;
                                case 'via_sms_guest':
                                    data['guest']['sms'][type] = fieldValue;
                                break;
                            }  
                        } else{
                            var lang = $(fieldValue).parents('.absd-accordion-content-box').find('#absd-form-notifications_'+key+'-'+key+'_language').val();
                            var fieldValue = $(fieldValue).val();
                          
                            switch(key) {
                                case 'via_email_host':
                                    var messagesForLang = data['host']['email']['message'];
                                    messagesForLang[lang] = fieldValue;
                                    data['host']['email']['message'] = messagesForLang;
                                break;
                                case 'via_sms_host':
                                    var messagesForLang = data['host']['sms']['message'];
                                    messagesForLang[lang] = fieldValue;
                                    data['host']['sms']['message'] = messagesForLang;
                                break;
                                case 'via_email_guest':
                                    var messagesForLang = data['guest']['email']['message'];
                                    messagesForLang[lang] = fieldValue;
                                    data['guest']['email']['message'] = messagesForLang;
                                break;
                                case 'via_sms_guest':
                                    var messagesForLang = data['guest']['sms']['message'];
                                    messagesForLang[lang] = fieldValue;
                                    data['guest']['sms']['message'] = messagesForLang;
                                break;
                           }
                        }
                      
                        abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.data = data;
                    },
                    phone: function(element){
                        element.value = element.value !== '' ? (isNaN(parseInt(element.value)) ? '':parseInt(element.value)):element.value;
                    },
                    change: function(key, fieldObj){
                      var data = abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.data;
                      
                      switch(key) {
                            case 'via_email_host':
                                var messagesForLang = data['host']['email']['message'];
                            break;
                            case 'via_sms_host':
                                var messagesForLang = data['host']['sms']['message'];
                            break;
                            case 'via_email_guest':
                                var messagesForLang = data['guest']['email']['message'];
                            break;
                            case 'via_sms_guest':
                                var messagesForLang = data['guest']['sms']['message'];
                            break;
                        }
                        $(fieldObj).parents('.absd-accordion-content-box').find('textarea').val(messagesForLang[$(fieldObj).attr('data-value')]);   
                    },
                    save: function(){
                      
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);

                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings_save'],
                                                    is_ajax_request: true,
                                                    type: 'notifications',
                                                    calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                    is_group: abookingsystemdashboardCalendars['data']['current']['is_group'],
                                                    api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                    data: JSON.stringify(abookingsystemdashboardCalendars.calendar.setup.view.content.notifications.data),
                                                    ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                            data = JSON.parse(data);

                            if(data['status'] === "success"){
                                // Stop Loader
                                abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                                   absdashboardtext['save_success'],
                                                   true);
                            }

                        });
                    }
                },
                sync: {
                    data: {},
                    start: function(){
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);

                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings'],
                                                    is_ajax_request: true,
                                                    ajax_ses: abookingsystemdashboard['ajax_ses'],
                                                    type: 'sync',
                                                    calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                    api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                    is_group: abookingsystemdashboardCalendars['data']['current']['is_group']}, function(data){
                            abookingsystemdashboardCalendars.calendar.setup.view.content.sync.data = data;
                          
                            // Create Default & Advanced Tabs
                            var tabsData = [{label: '',
                                            name: "default_settings"}];

                            abookingsystemdashboardTabs.start($('.absd-content-settings-box'), tabsData);
                          
                            abookingsystemdashboardCalendars.calendar.setup.view.content.sync.show();
                          
                            // Stop Loader
                            abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                               absdashboardtext['refresh'],
                                               true);

                        });
                    },
                    show: function(key){
                      // Create Forms
                      var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.sync.data);
                      
                      if(abookingsystemdashboardCalendars['data']['current']['is_group'] === 'false') {
                          var settingsForm = {
                              name: "sync",
                              fields: [
                                {
                                  label: absdashboardtext['sync_airbnb'],
                                  name: "airbnb_com",
                                  value: decodeURIComponent(data['airbnb_com']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('airbnb_com', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_booking_com'],
                                  name: "booking_com",
                                  value: decodeURIComponent(data['booking_com']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('booking_com', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_google_calendar'],
                                  name: "google_calendar",
                                  value: decodeURIComponent(data['google_calendar']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('google_calendar', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_homeaway_com'],
                                  name: "homeaway_com",
                                  value: decodeURIComponent(data['homeaway_com']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('homeaway_com', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_homestay_com'],
                                  name: "homestay_com",
                                  value: decodeURIComponent(data['homestay_com']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('homestay_com', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_vrbo_com'],
                                  name: "vrbo_com",
                                  value: decodeURIComponent(data['vrbo_com']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('vrbo_com', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_flipkey_com'],
                                  name: "flipkey_com",
                                  value: decodeURIComponent(data['flipkey_com']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('flipkey_com', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['sync_other_calendar'],
                                  name: "other_calendar",
                                  value: decodeURIComponent(data['other_calendar']),  // default value
                                  modify: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.modify('other_calendar', this.value);",
                                  placeholder: "",  
                                  required: "false",
                                  allowed_characters: "",
                                  min_chars: 0,     // 0 - disabled
                                  max_chars: 0,     // 0 - disabled
                                  is_email: "false",
                                  is_phone: "false",
                                  is_url: "true",
                                  type: "text",                            // text, textarea, select, radio, checkbox, password
                                  options: {0: {"name": "", "value": ""}},     // select options
                                  label_class: "",
                                  input_class: "",
                                  hint: "",
                                  label_position: "left"         // left, right, left_full, right_full
                                },
                                {
                                  label: absdashboardtext['save'],
                                  name: "save",
                                  value: data['save'],        // default value
                                  placeholder: "",  
                                  action: "abookingsystemdashboardCalendars.calendar.setup.view.content.sync.save()",
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
                      
                          var settingsAccordion = [{label: absdashboardtext['sync_settings'],
                                                    name: "main_settings",
                                                    class: "absd-opened"}];

                          abookingsystemdashboardAccordion.start($('#absd-tab-default_settings-content'), settingsAccordion, 'absd-black');

                          abookingsystemdashboardForm.start(abookingsystemdashboardAccordion.box('main_settings'), settingsForm);
                      }
                     
                    },
                    modify: function(field, value){
                        var data = JSON.parse(abookingsystemdashboardCalendars.calendar.setup.view.content.sync.data);
                      
                        data[field] = decodeURIComponent(value);
                      
                        abookingsystemdashboardCalendars.calendar.setup.view.content.sync.data = JSON.stringify(data);
                    },
                    save: function(){
                        // Start Loader
                        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                           absdashboardtext['wait']);

                        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['calendar_settings_save'],
                                                    is_ajax_request: true,
                                                    type: 'sync',
                                                    calendar_id: abookingsystemdashboardCalendars['data']['current']['calendar_id'],
                                                    is_group: abookingsystemdashboardCalendars['data']['current']['is_group'],
                                                    api_key: abookingsystemdashboardCalendars['data']['current']['api_key'],
                                                    data: abookingsystemdashboardCalendars.calendar.setup.view.content.sync.data,
                                                    ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                            data = JSON.parse(data);

                            if(data['status'] === "success"){
                                // Stop Loader
                                abookingsystemdashboardLoader.stop(absdashboardtext['saved'],
                                                   absdashboardtext['save_success'],
                                                   true);
                            }

                        });
                    }
                }
            }
        },
        events: function(){
            $('#calendar-settings-menu .absd-link').unbind('click');
            $('#calendar-settings-menu .absd-link').bind('click', function(){
                abookingsystemdashboardCalendars['data']['subpage'] = $(this).attr('data-type');
                abookingsystemdashboardCalendars.calendar.setup.start();          
            });
        }
      }
    },
    space: {
      add: function(){
          var calendar_type_options = [],
                reservations_type_options = [];
      
            calendar_type_options[0] = [];
            calendar_type_options[0]['name'] = absdashboardtext['calendar_type_days'];
            calendar_type_options[0]['value'] = 'days';
            calendar_type_options[1] = [];
            calendar_type_options[1]['name'] = absdashboardtext['calendar_type_hours'];
            calendar_type_options[1]['value'] = 'hours';
      
            reservations_type_options[0] = [];
            reservations_type_options[0]['name'] = absdashboardtext['reservations_type_free'];
            reservations_type_options[0]['value'] = 'free';
            reservations_type_options[1] = [];
            reservations_type_options[1]['name'] = absdashboardtext['reservations_type_paid'];
            reservations_type_options[1]['value'] = 'paid';
            
            // Add Calendar
            var addCalendarForm = {
                name: "create_calendar",
                fields: [{
                    name: "rent_type",
                    value: "rooms",    // default value
                    placeholder: "",  
                    required: "true",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "checkbox",                          // text, textarea, select, radio, checkbox, password
                    options: {0: {"name": absdashboardtext['space_rent_rooms'], "value": "rooms"}, 1: {"name": absdashboardtext['space_rent_entire_space'], "value": "entire"}},     // select options
                    label_class: "absd-small-label",
                    input_class: "",
                    hint: "",
                    label_position: "left"              // left, right, left_full, right_full
                  },{
                    label: absdashboardtext['space_name'],
                    name: "space_name",
                    value: window.abookingsystem_website_title !== undefined ? window.abookingsystem_website_title:'',    // default value
                    placeholder: "",  
                    required: "true",
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
                  },
                  {
                    label: absdashboardtext['space_description'], 
                    name: "space_description",
                    value: window.abookingsystem_website_description !== undefined && window.abookingsystem_website_description !== '' ? window.abookingsystem_website_description:absdashboardtext['space_description_hint'],    // default value
                    placeholder: "",  
                    required: "true",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "textarea",                          // text, textarea, select, radio, checkbox, password
                    options: {},     // select options
                    label_class: "",
                    input_class: "",
                    hint: "",
                    label_position: "left"              // left, right, left_full, right_full
                  },
                   {
                    label: absdashboardtext['space_type'],
                    name: "space_type",
                    value: abookingsystemdashboardCalendars.data.categories[0],    // default value
                    placeholder: "",  
                    required: "true",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "select",                          // text, textarea, select, radio, checkbox, password
                    options: abookingsystemdashboardGeneral.select.options(abookingsystemdashboardCalendars.data.categories),     // select options
                    label_class: "",
                    input_class: "",
                    hint: "",
                    label_position: "left"              // left, right, left_full, right_full
                  },
                  {
                    label: absdashboardtext['rent_type'],
                    name: "mode",
                    value: 'nights',        // default value
                    modify: "abookingsystemdashboardCalendars.space.mode.modify(window.absdSelectedValue)",
                    placeholder: "",  
                    required: "true",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "select",                            // text, textarea, select, radio, checkbox, password
                    options: [{"name": absdashboardtext['rent_type_nights'], "value": 'nights'},{"name": absdashboardtext['rent_type_days'], "value": 'days'}],     // select options : abookingsystemdashboardCalendars.data.categories
                    label_class: "",
                    input_class: "",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                   },
                   {
                    name: "bullets",
                    value: '',        // default value
                    placeholder: "",  
                    required: "false",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "bullets",                            // text, textarea, select, radio, checkbox, password
                    bullets: 2,  
                    selected_bullet: 1,
                    options: {},     // select options : abookingsystemdashboardCalendars.data.categories
                    label_class: "",
                    input_class: "",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                   }]
              };
        
              //

              // Start Form
              abookingsystemdashboardInfo.start(absdashboardtext['space_what_you_rent'],
                           addCalendarForm,
                           absdashboardtext['space_next'],
                           absdashboardtext['cancel'],
                           abookingsystemdashboardCalendars.space.add_step2);
      },
      add_step2: function(){
          var calendar_type_options = [],
              reservations_type_options = [],
              fields = abookingsystemdashboardForm.fields.get();
          
          if(fields !== "error"){     
              
              // Add Calendar
                var addCalendarForm = {
                    name: "create_calendar",
                    fields: [{
                        name: "rent_type",
                        value: fields['rent_type'],    // default value
                        placeholder: "",  
                        required: "true",
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
                        label: absdashboardtext['rent_type'],
                        name: "mode",
                        value: fields['mode'],        // default value
                        placeholder: "",  
                        required: "true",
                        allowed_characters: "",
                        min_chars: 0,     // 0 - disabled
                        max_chars: 0,     // 0 - disabled
                        is_email: "false",
                        is_phone: "false",
                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                        options: {},     // select options : abookingsystemdashboardCalendars.data.categories
                        label_class: "",
                        input_class: "",
                        hint: "",
                        label_position: "left"         // left, right, left_full, right_full
                       },{
                        label: absdashboardtext['space_name'],
                        name: "space_name",
                        value: fields['space_name'],    // default value
                        placeholder: "",  
                        required: "true",
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
                        label: absdashboardtext['space_type'],
                        name: "space_type",
                        value: fields['space_type'],    // default value
                        placeholder: "",  
                        required: "true",
                        allowed_characters: "",
                        min_chars: 0,     // 0 - disabled
                        max_chars: 0,     // 0 - disabled
                        is_email: "false",
                        is_phone: "false",
                        type: "hidden",                          // text, textarea, select, radio, checkbox, password
                        options: abookingsystemdashboardGeneral.select.options(abookingsystemdashboardCalendars.data.categories),     // select options
                        label_class: "",
                        input_class: "",
                        hint: "",
                        label_position: "left"              // left, right, left_full, right_full
                      },{
                        label: absdashboardtext['space_description'], 
                        name: "space_description",
                        value: fields['space_description'],    // default value
                        placeholder: "",  
                        required: "true",
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
                        label: absdashboardtext['space_check_in_time'],
                        name: "check_in",
                        value: '14:00',        // default value
                        placeholder: "",  
                        required: "true",
                        allowed_characters: "",
                        min_chars: 0,     // 0 - disabled
                        max_chars: 0,     // 0 - disabled
                        is_email: "false",
                        is_phone: "false",
                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                        options: abookingsystemdashboardCalendars.hours.get(),     // select options : abookingsystemdashboardCalendars.data.categories
                        label_class: "",
                        input_class: "",
                        hint: "",
                        label_position: "left"         // left, right, left_full, right_full
                       },
                       {
                        label: absdashboardtext['space_check_out_time'],
                        name: "check_out",
                        value: '12:00',        // default value
                        placeholder: "",  
                        required: "true",
                        allowed_characters: "",
                        min_chars: 0,     // 0 - disabled
                        max_chars: 0,     // 0 - disabled
                        is_email: "false",
                        is_phone: "false",
                        type: "hidden",                            // text, textarea, select, radio, checkbox, password
                        options: abookingsystemdashboardCalendars.hours.get(),     // select options : abookingsystemdashboardCalendars.data.categories
                        label_class: "",
                        input_class: "",
                        hint: "",
                        label_position: "left"         // left, right, left_full, right_full
                       },{
                        label: absdashboardtext['space_location'],
                        name: "space_location",
                        value: '',    // default value
                        placeholder: "",  
                        required: "true",
                        allowed_characters: "",
                        min_chars: 0,     // 0 - disabled
                        max_chars: 0,     // 0 - disabled
                        is_email: "false",
                        is_phone: "false",
                        type: "map",                          // text, textarea, select, radio, checkbox, password
                        options: {},     // select options
                        label_class: "",
                        input_class: "",
                        hint: "",
                        label_position: "left"              // left, right, left_full, right_full
                      },{
                        label: absdashboardtext['space_cover'],
                        name: "space_cover",
                        value: '',    // default value
                        placeholder: "",  
                        required: "true",
                        allowed_characters: "",
                        min_chars: 0,     // 0 - disabled
                        max_chars: 0,     // 0 - disabled
                        is_email: "false",
                        is_phone: "false",
                        type: "image",                          // text, textarea, select, radio, checkbox, password
                        options: {},     // select options
                        label_class: "",
                        input_class: "",
                        hint: "",
                        label_position: "left"              // left, right, left_full, right_full
                      },{
                        label: absdashboardtext['calendar_address'],
                        name: "space_address",
                        value: '',    // default value
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
                      label: absdashboardtext['space_rooms'],
                      name: "space_rooms",
                      value: 1,    // default value
                      placeholder: "",  
                      required: "true",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      higher_than: 1,
                      lower_than: (abookingsystemdashboard["max_calendars"]-abookingsystemdashboard["no_calendars"]),
                      type: "text",                          // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "absd-wdh-small",
                      hint: "",
                      label_position: "left"              // left, right, left_full, right_full
                    },{
                      label: absdashboardtext['space_price']+' ('+abookingsystemdashboard['currency']+')',
                      name: "price",
                      value: parseInt(10*abookingsystemdashboardCalendars.data.currency_rate),    // default value
                      placeholder: "",  
                      required: "true",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      higher_than: parseInt(10*abookingsystemdashboardCalendars.data.currency_rate) < 10 ? 10:parseInt(10*abookingsystemdashboardCalendars.data.currency_rate),
                      type: "text",                          // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "",
                      input_class: "absd-wdh-small",
                      hint: "",
                      label_position: "left"              // left, right, left_full, right_full
                    },{
                      label: '',
                      name: "vat",
                      value: 0,    // default value
                      placeholder: "",  
                      required: "true",
                      allowed_characters: "",
                      min_chars: 0,     // 0 - disabled
                      max_chars: 0,     // 0 - disabled
                      is_email: "false",
                      is_phone: "false",
                      type: "hidden",                          // text, textarea, select, radio, checkbox, password
                      options: {},     // select options
                      label_class: "absd-invisible",
                      input_class: "absd-wdh-small absd-invisible",
                      hint: '',
                      label_position: "left"              // left, right, left_full, right_full
                    },
                       {
                        name: "bullets",
                        value: '',        // default value
                        placeholder: "",  
                        required: "false",
                        allowed_characters: "",
                        min_chars: 0,     // 0 - disabled
                        max_chars: 0,     // 0 - disabled
                        is_email: "false",
                        is_phone: "false",
                        type: "bullets",                            // text, textarea, select, radio, checkbox, password
                        bullets: 2,  
                        selected_bullet: 2,
                        options: {},     // select options : abookingsystemdashboardCalendars.data.categories
                        label_class: "",
                        input_class: "",
                        hint: "",
                        label_position: "left"         // left, right, left_full, right_full
                       }]

                };
              
                // Start Form
                abookingsystemdashboardInfo.start(absdashboardtext['space_details'],
                                 addCalendarForm,
                                 absdashboardtext['space_add'],
                                 absdashboardtext['cancel'],
                                 abookingsystemdashboardCalendars.space.add_ok,
                                 undefined,
                                 'absd-selected');
          }
      },
      add_ok: function(){
          var fields = abookingsystemdashboardForm.fields.get();
          
          if(fields !== "error"){
              // Start Loader
              abookingsystemdashboardCalendars.space.loader.start(fields['space_rooms']);
              
              var space_location = JSON.parse(fields['space_location']);
              
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['add_calendars'],
                                          is_ajax_request: true,
                                          type: 'space',
                                          rent_type: fields['rent_type'],
                                          name: fields['space_name'],
                                          cover: fields['space_cover'],
                                          description: fields['space_description'],
                                          location_address: space_location['address'] !== undefined ? space_location['address']:'',
                                          location_country: space_location['country'] !== undefined ? space_location['country']:'',
                                          location_country_long: space_location['country_long'] !== undefined ? space_location['country_long']:'',
                                          location_state: space_location['state'] !== undefined ? space_location['state']:'',
                                          location_state_long: space_location['state_long'] !== undefined ? space_location['state_long']:'',
                                          location_city: space_location['city'] !== undefined ? space_location['city']:'',
                                          location_city_long: space_location['city_long'] !== undefined ? space_location['city_long']:'',
                                          location_latitude: space_location['latitude'] !== undefined ? space_location['latitude']:'',
                                          location_longitude: space_location['longitude'] !== undefined ? space_location['longitude']:'',
                                          location_timezone: space_location['timezone'] !== undefined ? space_location['timezone']:'',
                                          address: fields['space_address'],
                                          category: fields['space_type'],
                                          no_rooms: fields['space_rooms'],
                                          mode: fields['mode'],
                                          check_in: fields['check_in'],
                                          check_out: fields['check_out'],
                                          price: fields['price'],
                                          vat: fields['vat'],
                                          language: abookingsystemdashboard['language'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                  data = JSON.parse(data);
                  
                  if(data.no_groups !== undefined) {
                    abookingsystemdashboard["no_groups"] = data.no_groups;
                  }
                  
                  if(data.no_calendars !== undefined) {
                    abookingsystemdashboard["no_calendars"] = data.no_calendars;
                  }
                
                  if(data.status === "success"){
                      abookingsystemdashboardCalendars.search.add(data.data);
                      
                      if(data.next_calendars > 0) {
                          var data_add_more = new Array();
                          data_add_more['no_rooms'] = data.next_calendars;
                          data_add_more['group_id'] = data.data[0].id;
                          
                          abookingsystemdashboardCalendars.space.rooms.add_more(data_add_more);
                      }
                  } else if(data.status === "error"
                           && data.no_groups !== undefined
                           && data.no_calendars !== undefined) {
                      data.next_calendars = 0;
                
                      if(abookingsystemdashboard["no_calendars"] === abookingsystemdashboard["max_calendars"]) {
                          var warningMessage = new Array();

                          warningMessage.push(absdashboardtext['space_rooms_limit_reached'].split('%s').join(abookingsystemdashboard["max_calendars"]));
                          warningMessage.push('<a href="'+abookingsystemdashboard['upgrade_account']+'">'+absdashboardtext['space_rooms_upgrade_account']+'</a>');

                          abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                              warningMessage.join(''),
                                              10);
                      } 
                      
                      if(abookingsystemdashboard["no_groups"] === abookingsystemdashboard["max_groups"]) {
                          var warningMessage = new Array();

                          warningMessage.push(absdashboardtext['space_limit_reached'].split('%s').join(abookingsystemdashboard["max_groups"]));
                          warningMessage.push('<a href="'+abookingsystemdashboard['upgrade_account']+'">'+absdashboardtext['space_upgrade_account']+'</a>');

                          abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                              warningMessage.join(''),
                                              10);
                      }
                  }

                  if(data.next_calendars === 0) {
                      // Stop Loader
                      abookingsystemdashboardCalendars.space.loader.stop();
                  }

              });
          }
      },
      mode: {
          modify: function(value){
            
              if(value === 'days') {
                  $('.absd-field').eq(2).addClass('absd-invisible');
                  $('.absd-field').eq(3).addClass('absd-invisible');
              } else {
                  $('.absd-field').eq(2).removeClass('absd-invisible');
                  $('.absd-field').eq(3).removeClass('absd-invisible');
              }
          }
      },
      rooms: {
          add: function(group_id){
              var calendar_type_options = [],
                    reservations_type_options = [];

                calendar_type_options[0] = [];
                calendar_type_options[0]['name'] = absdashboardtext['calendar_type_days'];
                calendar_type_options[0]['value'] = 'days';
                calendar_type_options[1] = [];
                calendar_type_options[1]['name'] = absdashboardtext['calendar_type_hours'];
                calendar_type_options[1]['value'] = 'hours';

                reservations_type_options[0] = [];
                reservations_type_options[0]['name'] = absdashboardtext['reservations_type_free'];
                reservations_type_options[0]['value'] = 'free';
                reservations_type_options[1] = [];
                reservations_type_options[1]['name'] = absdashboardtext['reservations_type_paid'];
                reservations_type_options[1]['value'] = 'paid';


                    // Add Calendar
                    var addCalendarForm = {
                        name: "create_calendar",
                        fields: [{
                            label: "",
                            name: "group_id",
                            value: group_id,        // default value
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
                            input_class: "bdm_group_id",
                            hint: "",
                            label_position: "left"         // left, right, left_full, right_full
                          },{
                            label: absdashboardtext['space_rooms'],
                            name: "space_rooms",
                            value: 1,    // default value
                            placeholder: "",  
                            required: "true",
                            allowed_characters: "",
                            min_chars: 0,     // 0 - disabled
                            max_chars: 0,     // 0 - disabled
                            is_email: "false",
                            is_phone: "false",
                            higher_than: 1,
                            lower_than: (abookingsystemdashboard["max_calendars"]-abookingsystemdashboard["no_calendars"]),
                            type: "text",                          // text, textarea, select, radio, checkbox, password
                            options: {},     // select options
                            label_class: "",
                            input_class: "absd-wdh-small",
                            hint: "",
                            label_position: "left"              // left, right, left_full, right_full
                          }]

                    };

                    // Start Form
                    abookingsystemdashboardInfo.start(absdashboardtext['space_rooms_adding'],
                                 addCalendarForm,
                                 absdashboardtext['space_rooms_add'],
                                 absdashboardtext['cancel'],
                                 abookingsystemdashboardCalendars.space.rooms.add_ok);
          },
          add_ok: function(){
              var fields = abookingsystemdashboardForm.fields.get();

              if(fields !== "error"){
                  // Start Loader
                  abookingsystemdashboardCalendars.space.loader.start(fields['space_rooms']);
                  
                  var data_add_more = new Array();
                      data_add_more['no_rooms'] = fields['space_rooms'];
                      data_add_more['group_id'] = fields['group_id'];

                  abookingsystemdashboardCalendars.space.rooms.add_more(data_add_more);
              }
          },
          add_more: function(fields){
              
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['add_calendars'],
                                          is_ajax_request: true,
                                          no_rooms: fields['no_rooms'],
                                          group_id: fields['group_id'],
                                          language: abookingsystemdashboard['language'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                  data = JSON.parse(data);
                  
                  if(data.no_groups !== undefined) {
                    abookingsystemdashboard["no_groups"] = data.no_groups;
                  }
                  
                  if(data.no_calendars !== undefined) {
                    abookingsystemdashboard["no_calendars"] = data.no_calendars;
                  }
                  
                  if(data.status === "success"){
                      abookingsystemdashboardCalendars.search.add(data.data);
                      
                      if(data.next_calendars > 0) {
                          var data_add_more = new Array();
                          data_add_more['no_rooms'] = data.next_calendars;
                          data_add_more['group_id'] = fields['group_id'];

                          abookingsystemdashboardCalendars.space.rooms.add_more(data_add_more);
                      } else {
                          // Stop Loader
                          abookingsystemdashboardCalendars.space.loader.stop();
                      }
                  }

              });
          }
      },
      loader: {
          data: {
              rooms_per_request: 30,        // 30 rooms
              time_per_request: 14000,      // 11 seconds
              no_requests: 1,               // no requests for saving all rooms
              time_per_percent: 700,        // time per load new percent
              total_time: 70000             // total per time for all requests
          },
          start: function(no_rooms){
              abookingsystemdashboardCalendars.space.loader.data.no_requests = Math.ceil(no_rooms/abookingsystemdashboardCalendars.space.loader.data.rooms_per_request);
              abookingsystemdashboardCalendars.space.loader.data.total_time = abookingsystemdashboardCalendars.space.loader.data.no_requests*abookingsystemdashboardCalendars.space.loader.data.time_per_request;
              abookingsystemdashboardCalendars.space.loader.data.total_time = abookingsystemdashboardCalendars.space.loader.data.total_time >= abookingsystemdashboardCalendars.space.loader.data.time_per_request ? abookingsystemdashboardCalendars.space.loader.data.total_time:abookingsystemdashboardCalendars.space.loader.data.time_per_request;
              abookingsystemdashboardCalendars.space.loader.data.time_per_percent = Math.ceil(abookingsystemdashboardCalendars.space.loader.data.total_time/100);
              window.abookingsystemdashboardLoaderLine.time_per_percent = abookingsystemdashboardCalendars.space.loader.data.time_per_percent;
              
              
              // Start Loader
              abookingsystemdashboardPercentageLoader.start(absdashboardtext['save'],
                                           absdashboardtext['loading']);
          },
          stop: function(){
                // Stop Loader
                abookingsystemdashboardPercentageLoader.stop(absdashboardtext['saved'],
                                            absdashboardtext['completed'],
                                            true);
          }
      }
    },
    search: {
      start: function(){
          var calendars = abookingsystemdashboardCalendars['data']['calendars'],
              searchWord = abookingsystemdashboardCalendars['data']['search'],
              page = abookingsystemdashboardCalendars['data']['page'],
              per_page = abookingsystemdashboardCalendars['data']['per_page'],
              total_items = 0,
              count_items = 0,
              start_item = (page == 0)?page:page*per_page;
          
          $('.absd-calendars-holder').html('');
          $('#absd-calendars-content').html('');
        
          for(var i in calendars){
              var HTML = new Array();
            
              // Search for word x if is not empty
              if(calendars[i]['name'].toLowerCase().indexOf(searchWord.toLowerCase()) !== -1
                 || searchWord === ''){
                      
                  count_items++;
                  if (count_items <= start_item || total_items >= per_page) { continue; }
                
                  if(calendars[i]['is_group'] === 'true'){
                      HTML.push(abookingsystemdashboardCalendars.calendar.group(calendars[i])); 
                  } else{
                      HTML.push(abookingsystemdashboardCalendars.calendar.view(calendars[i]));
                  }

                  $('.absd-calendars-holder').append(HTML.join(''));
                  total_items++;
                
                  if(calendars[i].childs.length > 0) {
                      for(var ii in calendars[i].childs){  
                          var HTML = new Array();
                          HTML.push(abookingsystemdashboardCalendars.calendar.view(calendars[i].childs[ii]));
                          if(calendars[i].childs[ii]['group_id']){
                              $('#absd-group-'+calendars[i].childs[ii]['group_id']).find('.absd-elements').append(HTML.join(''));
                          } 
                      }
                  }
              }
          }
          abookingsystemdashboardCalendars['data']['total_items'] = count_items;


          // Events
          abookingsystemdashboardCalendars.events(calendars);
          abookingsystemdashboardCalendars.search.events(calendars);
          abookingsystemdashboardCalendars.search.pagination.start(calendars);
          abookingsystemdashboardCalendars.search.pagination.events(calendars);
      },
      group_calendars: function(data){
          var groupedCalendars = [];
        
          for(var i = 0; i < data['calendars'].length; i++){
            data['calendars'][i]['group_id'] = data['calendars'][i]['group_id'] === undefined ? 0:data['calendars'][i]['group_id'];
            data['calendars'][i]['is_group'] = data['calendars'][i]['is_group'] === undefined ? 'false':data['calendars'][i]['is_group'];
            data['calendars'][i]['post_id'] = data['calendars'][i]['post_id'] === undefined ? 0:data['calendars'][i]['post_id'];
            
            if(data['calendars'][i]['cid'] !== undefined) {
              data['calendars'][i]['id'] = parseInt(data['calendars'][i]['cid']);
              data['calendars'][i]['cid'] = parseInt(data['calendars'][i]['cid']);
            } else if(data['calendars'][i]['id'] !== undefined) {
              data['calendars'][i]['cid'] = parseInt(data['calendars'][i]['id']);
            }
            data['calendars'][i]['post_id'] = parseInt(data['calendars'][i]['post_id']);
            
            if(data['calendars'][i]['user_id'] !== undefined) {
              data['calendars'][i]['user_id'] = parseInt(data['calendars'][i]['user_id']);
            } else if(data['calendars'][i]['uid'] !== undefined) {
              data['calendars'][i]['user_id'] = parseInt(data['calendars'][i]['uid']);
            }
            
            data['calendars'][i]['group_id'] = parseInt(data['calendars'][i]['group_id']);
            
            data['calendars'][i]['childs'] = [];
            
            if(data['calendars'][i]['group_id'] === 0) {
                groupedCalendars[data['calendars'][i]['id']] = data['calendars'][i];
            } else {
                groupedCalendars[data['calendars'][i]['group_id']]['childs'][data['calendars'][i]['id']] = data['calendars'][i];
            }
          }
          
          groupedCalendars = groupedCalendars.filter(function(){return true;});
          groupedCalendars.reverse();

          // Save Calendars in data
          abookingsystemdashboardCalendars['data']['calendars'] = groupedCalendars;
          //abookingsystemdashboardCalendars['data']['calendars'] = data['calendars'];
          abookingsystemdashboardCalendars['data']['categories'] = data['categories'];
      },
      events: function(){
          $('.absd-search input').unbind('keyup');
          $('.absd-search input').bind('keyup', function(){
              abookingsystemdashboardCalendars['data']['search'] = $(this).val();  
              abookingsystemdashboardCalendars['data']['page'] = 0;
              abookingsystemdashboardCalendars.search.start();
          });
        
          $('.absd-add-space').unbind('click');
          $('.absd-add-space').bind('click', function(){
              
              if(abookingsystemdashboard["no_groups"]+1 <= abookingsystemdashboard["max_groups"]) {
                
                  if(abookingsystemdashboard["no_calendars"]+1 <= abookingsystemdashboard["max_calendars"]) {
                      abookingsystemdashboardCalendars.space.add();
                  } else {
                      var warningMessage = new Array();

                      warningMessage.push(absdashboardtext['space_rooms_limit_reached'].split('%s').join(abookingsystemdashboard["max_calendars"]));
                      warningMessage.push('<a href="'+abookingsystemdashboard['upgrade_account']+'">'+absdashboardtext['space_rooms_upgrade_account']+'</a>');

                      abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                          warningMessage.join(''),
                                          10);
                  }
              } else {
                  var warningMessage = new Array();

                  warningMessage.push(absdashboardtext['space_limit_reached'].split('%s').join(abookingsystemdashboard["max_groups"]));
                  warningMessage.push('<a href="'+abookingsystemdashboard['upgrade_account']+'">'+absdashboardtext['space_upgrade_account']+'</a>');

                  abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                      warningMessage.join(''),
                                      10);
              }
          }); 
        
          $('.absd-add-calendar').unbind('click');
          $('.absd-add-calendar').bind('click', function(){
            
              switch(abookingsystemdashboard['used_for']) {
                case "spaces":
                  
                  if(abookingsystemdashboard["no_calendars"]+1 <= abookingsystemdashboard["max_calendars"]) {
                      abookingsystemdashboardCalendars.space.rooms.add($(this).attr('data-group-id'));
                  } else {
                      var warningMessage = new Array();

                      warningMessage.push(absdashboardtext['space_rooms_limit_reached'].split('%s').join(abookingsystemdashboard["max_calendars"]));
                      warningMessage.push('<a href="'+abookingsystemdashboard['upgrade_account']+'">'+absdashboardtext['space_rooms_upgrade_account']+'</a>');

                      abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                          warningMessage.join(''),
                                          10);
                  }
                  break;
                default: 
                  
                  if(abookingsystemdashboard["no_calendars"]+1 <= abookingsystemdashboard["max_calendars"]) {
                      abookingsystemdashboardCalendars.calendar.add($(this).attr('data-group-id'), false);
                  } else {
                      var warningMessage = new Array();

                      warningMessage.push(absdashboardtext['calendars_limit_reached'].split('%s').join(abookingsystemdashboard["max_calendars"]));
                      warningMessage.push('<a href="'+abookingsystemdashboard['upgrade_account']+'">'+absdashboardtext['calendars_upgrade_account']+'</a>');

                      abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                          warningMessage.join(''),
                                          10);
                  }
                  break;
              }
          }); 
        
          $('.absd-add-group').unbind('click');
          $('.absd-add-group').bind('click', function(){
            
              if(abookingsystemdashboard["no_groups"]+1 <= abookingsystemdashboard["max_groups"]) {
                  abookingsystemdashboardCalendars.calendar.add(0, true);
              } else {
                  var warningMessage = new Array();

                  warningMessage.push(absdashboardtext['groups_limit_reached'].split('%s').join(abookingsystemdashboard["max_groups"]));
                  warningMessage.push('<a href="'+abookingsystemdashboard['upgrade_account']+'">'+absdashboardtext['groups_upgrade_account']+'</a>');

                  abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                      warningMessage.join(''),
                                      10);
              }
          }); 
      },
      delete: function(api_key){
          var calendars = abookingsystemdashboardCalendars['data']['calendars'],
              newCalendars = [];
        
          for(var i = 0; i <= calendars.length-1; i++) {
              
              if(calendars[i]['api_key'] !== api_key) {
                  newCalendars.push(calendars[i]);
              }
            
              if(calendars[i]['childs'].length > 0) {
                  var newSubCalendars = [];
                  
                  for(var j in calendars[i]['childs']) {
              
                      if(calendars[i]['childs'][j]['api_key'] !== api_key) {
                          newSubCalendars.push(calendars[i]['childs'][j]);
                      }
                  }
                  calendars[i]['childs'] = newSubCalendars;
              }
          }
        
          abookingsystemdashboardCalendars['data']['calendars'] = newCalendars;
        
          abookingsystemdashboardCalendars.search.start();
      },
      add: function(data){
          var addded = [],
              calendars = [],
              no_calendars = 0,
              no_groups = 0;
        
          if(data[0]['is_group'] !== undefined
            && data[0]['is_group'] === 'true') {
              
              for(var key in data) {

                  if(data[key]['is_group'] !== undefined) {
                      addded[key] = data[key];
                      addded[key]['childs'] = [];
                      no_groups++;
                  } else if(data[key]['group_id'] !== undefined
                           && data[key]['group_id'] !== 0){
                      addded[0]['childs'].push(data[key]);
                      no_calendars++;
                  } else {
                      addded[key] = data[key];
                      no_calendars++;
                  }
              }
        
              for(var akey in addded) {
                  abookingsystemdashboardCalendars['data']['calendars'].unshift(addded[akey]);
              }
          } else if(data[0]['group_id'] !== undefined
                    && data[0]['group_id'] !== 0){
              addded = abookingsystemdashboardCalendars['data']['calendars'];
              
              for(var key in addded) {

                  for(var akey in data) {
                      if(addded[key]['id'] === data[akey]['group_id']) {
                         addded[key]['childs'].push(data[akey]);
                      }
                  }
              }
            
              abookingsystemdashboardCalendars['data']['calendars'] = addded;
          } else {
              addded = abookingsystemdashboardCalendars['data']['calendars'];

              for(var akey in data) {
                  data[akey]['childs'] = [];
                  addded.unshift(data[akey]);
              }

              abookingsystemdashboardCalendars['data']['calendars'] = addded;
          }
        
          abookingsystemdashboardCalendars.search.start();
      },
      pagination: {
          start: function(){  
            var page = abookingsystemdashboardCalendars['data']['page'],
              per_page = abookingsystemdashboardCalendars['data']['per_page'],
              total_items = abookingsystemdashboardCalendars['data']['total_items'],
              total_pages = Math.ceil(total_items/per_page),
              center_page = (page==0) ? 1 : ((page >= (total_pages-1)) ? page-1 : page),
              prev_page = (page==0)?page:page-1,
              next_page = (page >= total_pages-1)?page:page+1;
            
              $('.absd-pagination').html(abookingsystemdashboardCalendars.search.pagination.view(prev_page, center_page, next_page, page, total_pages));
             
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
                abookingsystemdashboardCalendars['data']['page'] = parseInt($(this).attr('data-page'));
                abookingsystemdashboardCalendars.search.start();
              }); 
          }
      }
    }
  };
  
  window.abookingsystemdashboardCalendars = abookingsystemdashboardCalendars;
  
})(jQuery);