
(function($){
  
  var abookingsystemdashboardConnection = {
    data: {
      country: 'US',
      currency: 'USD'
    },
    euroCountries: ['AT', 'BE', 'BG', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PO', 'PT', 'RO', 'SK', 'SI', 'SE', 'ES'],
    currencies: {"USD":"U.S. Dollar ( $ )", "EUR":"Euro ( &euro; )", "GBP":"Pound sterling ( &pound; )","JPY":"Japanese Yen ( &#165; )","CHF":"Swiss franc ( &#67;&#72;&#70; )","AUD":"Australian Dollar ( &#36; )","CAD":"Canadian Dollar ( &#36; )","RUB":"Russian Ruble ( ₽ )","SEK":"Swedish krona ( &#107;&#114; )","PLN":"Polish złoty ( &#122;&#322; )","DKK":"Danish krone ( &#107;&#114; )","CZK":"Czech koruna ( &#75;&#269; )","NZD":"New Zealand Dollar ( &#36; )","THB":"Thai baht ( &#3647; )"},
    connect: function(){ 
        var email = $('#absd-connection-email').val(),
            password = $('#absd-connection-password').val(),
            key = $('#absd-connection-key').val();
        
        if(email.length > 6
          && password.length > 4
          && key.length > 6) {
        
          
            if(!$('#absd-terms-and-conditions').is(":checked")) {
                alert(absdashboardtext['must_agree']);
                return false;
            }
          
            
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                absdashboardtext['wait']);
                                
            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['connect'],
                                        is_ajax_request: true,
                                        user_id: abookingsystemdashboard['user_id'],
                                        role: abookingsystemdashboard['role'],
                                        email: email,
                                        password: password,
                                        key: key}, function(data){
              
                if(data === 'success') {
                    // Stop Loader
                    abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                                       absdashboardtext['refresh'],
                                                       true);

                    window.location.href = window.location.href;
                } else {
                    var warningMessage = new Array();
                    
                    warningMessage.push(absdashboardtext['warning_error']);
                    warningMessage.push('<a href="'+abookingsystemdashboard['support_role']+'">'+absdashboardtext['warning_contact']+'</a>');
                  
                    abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                        warningMessage.join(''),
                                        10);
                }
            });
        }
    },
    disconnect: function(){
        
        // Start Loader
        abookingsystemdashboardInfo.start(absdashboardtext['disconnect'],
                         absdashboardtext['no_dashboard'],
                         absdashboardtext['button_yes'],
                         absdashboardtext['button_no'],
                         abookingsystemdashboardConnection.disconnect_ok);
    },
    disconnect_ok: function(){
        
        // Start Loader
        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                           absdashboardtext['wait']);

        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['disconnect'],
                                    is_ajax_request: true,
                                    user_id: abookingsystemdashboard['user_id'],
                                    role: abookingsystemdashboard['role']}, function(data){
            
            // Stop Loader
            abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                              absdashboardtext['refresh'],
                              true);

            window.location.href = window.location.href;
        });
    },
    detect_country: function(){
        $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['detect_country'],
                                                     detect_country: 'true',
                                                     is_ajax_request: true,
                                                     ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
            data = JSON.parse(data);

            if(data.status === 'success'
                 && data.data !== undefined
                 && data.data !== '') {
                abookingsystemdashboardConnection.data.country = data.data;
                abookingsystemdashboardConnection.data.currency = abookingsystemdashboardConnection.detect_currency(data.data);
            }
        });
    },
    detect_currency: function(country){
        var currency = 'USD';
        
        if(country === 'GB'
           || country === 'UK') {
            currency = 'GBP';
        }
        
        if(abookingsystemdashboardConnection.euroCountries.indexOf(country) !== -1) {
            currency = 'EUR';
        }
        
        return currency;
    },
    register_form: function(country,
                            fullname,
                            company,
                            email,
                            password,
                            re_password,
                            currency,
                            exist){
        delete window.abookingsystem_countries['IR'];
        var countries = abookingsystemdashboardConnection.dataMod(window.abookingsystem_countries);
                
        // Create Account
        var addAccountForm = {
            name: "register",
            fields: [{
                    label: absdashboardtext['fullname'],
                    name: "fullname",
                    value: fullname !== undefined ? fullname:window.abookingsystem_fullname,    // default value
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
                    label: absdashboardtext['company'],
                    name: "company",
                    value: company !== undefined ? company:"",    // default value
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
                },
                {
                label: absdashboardtext['email'],
                name: "email",
                value: email !== undefined ? email:window.abookingsystem_user_email,    // default value
                placeholder: "",  
                required: "true",
                allowed_characters: "",
                min_chars: 0,     // 0 - disabled
                max_chars: 0,     // 0 - disabled
                exist: exist !== undefined && exist === true ? "true":"false",
                exist_value: exist !== undefined ? email:"",
                is_email: "true",
                is_phone: "false",
                type: "text",                          // text, textarea, select, radio, checkbox, password
                options: {},     // select options
                label_class: "",
                input_class: "",
                hint: "",
                label_position: "left"              // left, right, left_full, right_full
              },{
                label: absdashboardtext['password'],
                name: "password",
                value: password !== undefined ? password:"",    // default value
                placeholder: "",  
                required: "true",
                allowed_characters: "",
                min_chars: 8,     // 0 - disabled
                max_chars: 0,     // 0 - disabled
                is_email: "false",
                is_phone: "false",
                type: "password",                          // text, textarea, select, radio, checkbox, password
                options: {},     // select options
                label_class: "",
                input_class: "",
                hint: "",
                label_position: "left"              // left, right, left_full, right_full
              },{
                label: absdashboardtext['re_password'],
                name: "re_password",
                value: re_password !== undefined ? re_password:"",    // default value
                placeholder: "",  
                required: "true",
                allowed_characters: "",
                min_chars: 8,     // 0 - disabled
                max_chars: 0,     // 0 - disabled
                is_email: "false",
                is_phone: "false",
                type: "password",                          // text, textarea, select, radio, checkbox, password
                options: {},     // select options
                label_class: "",
                input_class: "",
                hint: "",
                same_with: "password",
                same_with_label: absdashboardtext['password'],
                label_position: "left"              // left, right, left_full, right_full
              },{label: absdashboardtext['country'],
                name: "country",
                value: country !== undefined ? country:abookingsystemdashboardConnection.data.country,    // default value
                placeholder: "",  
                required: "true",
                allowed_characters: "",
                min_chars: 0,     // 0 - disabled
                max_chars: 0,     // 0 - disabled
                is_email: "false",
                is_phone: "false",
                type: "select",                          // text, textarea, select, radio, checkbox, password
                options: countries,     // select options
                label_class: "",
                input_class: "",
                hint: '',
                label_position: "left"              // left, right, left_full, right_full
              },{
                label: absdashboardtext['currency'],
                name: "currency",
                value: currency !== undefined ? currency:abookingsystemdashboardConnection.data.currency,    // default value
                placeholder: "",  
                required: "true",
                allowed_characters: "",
                min_chars: 0,     // 0 - disabled
                max_chars: 0,     // 0 - disabled
                is_email: "false",
                is_phone: "false",
                type: "select",                          // text, textarea, select, radio, checkbox, password
                options: abookingsystemdashboardConnection.dataMod(abookingsystemdashboardConnection.currencies),     // select options
                label_class: "",
                input_class: "",
                hint: "",
                label_position: "left"              // left, right, left_full, right_full
              },{
                label: absdashboardtext['i_m_agree'],
                name: "terms_and_condition",
                value: "false",    // default value
                placeholder: "",  
                required: "false",
                terms: "true",
                allowed_characters: "",
                min_chars: 0,     // 0 - disabled
                max_chars: 0,     // 0 - disabled
                is_email: "false",
                is_phone: "false",
                type: "terms",                          // text, textarea, select, radio, checkbox, password
                options: {},     // select options
                label_class: "absd-terms-label",
                input_class: "absd-terms",
                hint: '',
                label_position: "right"              // left, right, left_full, right_full
              }]
          };

          // Start Form
          window.abookingsystemdashboardInfo.start(absdashboardtext['account_main_settings'],
                                                   addAccountForm,
                                                   absdashboardtext['create_account'],
                                                   absdashboardtext['cancel'],
                                                   abookingsystemdashboardConnection.register_ok,
                                                   undefined,
                                                   'absd-selected');
        
          if(exist !== undefined 
             && exist === true) {
              wdhDelay(function(){
                $('#absd-form-register-email-errors').removeClass('absd-invisible');
                $('.absd-error-exist').removeClass('absd-invisible');
              }, 300);
          }

    },
    dataMod: function(data){
        var newData = [],
            dataBucket = {};
        
        for(var key in data) {
            dataBucket = {};
            dataBucket['name'] = data[key];
            dataBucket['value'] = key;
            newData.push(dataBucket);
        }
        
        return newData;
    },
    register_ok: function(){
        var fields = abookingsystemdashboardForm.fields.get();

        if(fields !== "error"
          || fields === undefined){
          // Start Loader
          abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                              absdashboardtext['wait']);

          $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['register'],
                                                       fullname: fields['fullname'],
                                                       company: fields['company'],
                                                       email: fields['email'],
                                                       password: fields['password'],
                                                       country: fields['country'],
                                                       currency: fields['currency'],
                                                       is_ajax_request: true,
                                                       ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
              data = JSON.parse(data);

              if(data.status === 'success') {
                  // Stop Loader
                  abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                                     absdashboardtext['refresh'],
                                                     true);
                  
                    var urlNow = new window.URL(window.location.href); 
                    urlNow.searchParams.set('page', 'abookingsystemdashboard-calendars');
                    window.location.href = urlNow.href;
                  
              } else if(data.status === 'error_email') {
                  abookingsystemdashboardConnection.register_form(fields['country'],
                                                                  fields['fullname'],
                                                                  fields['company'],
                                                                  fields['email'],
                                                                  fields['password'],
                                                                  fields['re_password'],
                                                                  fields['currency'],
                                                                  true);
              } else if(data.status === 'error_website') {
                    var warningMessage = new Array();

                    warningMessage.push(absdashboardtext['register_error_website']);

                    abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                                         warningMessage.join(''),
                                                         10);
                  
                  // Go to our website
                  wdhDelay(function(){
                      window.location.href = abookingsystemdashboard["create_account"];
                  }, 8000);
              } else if(data.status === 'error') {
                    var warningMessage = new Array();

                    warningMessage.push(data.data);

                    abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                                         warningMessage.join(''),
                                                         10);
              } else {
                    var warningMessage = new Array();

                    warningMessage.push(absdashboardtext['register_error']);

                    abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                                         warningMessage.join(''),
                                                         10);
              }

          });
        }
    }
  };
  
  window.abookingsystemdashboardConnection = abookingsystemdashboardConnection;
  
})(jQuery);