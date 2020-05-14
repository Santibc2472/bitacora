
(function($){
  
  var abookingsystemdashboardAccount = {
    data: {
      days: 7,
      skip_days: 0,
      withdraws: "",
      invoices: [],
      no_invoices: 0,
      no_invoices_loaded: 0,
      page: 0,
      per_page: 10,
      search: "",    // search word
      current: {
        withdraw_id: 0,
        api_key: '',
        data: {}
      },
      currency: {
        code: 'USD',
        sign: '$'
      },
      money: 0,
      currencies: [],
      stats: [],
      user: [],
      deleted: {
        withdraw_id: 0,
        api_key: ''
      }
    },
    list: function(){
        
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                               absdashboardtext['wait']);
                                
            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['withdraws'],
                                        days: abookingsystemdashboardAccount.data.days,
                                        skip_days: abookingsystemdashboardAccount.data.skip_days,
                                        is_ajax_request: true,
                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                data = JSON.parse(data);
                
                abookingsystemdashboardAccount['data']['currencies'] = data['currencies'];
                abookingsystemdashboardAccount['data']['currency']['code'] = data['currency'];
                abookingsystemdashboardAccount['data']['currency']['sign'] = data['currencies'][data['currency']];
                abookingsystemdashboardAccount['data']['stats'] = data['stats'];
                abookingsystemdashboardAccount['data']['user'] = data['user'];
                abookingsystemdashboardAccount['data']['money'] = data['stats']['money_in'];
                abookingsystemdashboardAccount['data']['invoices'] = data['invoices'];
                abookingsystemdashboardAccount['data']['no_invoices'] = data['no_invoices'];
               
                abookingsystemdashboardAccount.search.group_withdraws(data['withdraws']);
            
                // View Account -> Search start
                abookingsystemdashboardAccount.search.start();
              
                // Stats
                abookingsystemdashboardAccount.withdraw.setup.view.header.start();
                abookingsystemdashboardAccount.withdraw.setup.view.content.start('statement');
              
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
            
            abookingsystemdashboardAccount['data']['current']['withdraw_id'] = $(this).parent().attr('data-withdraw-id'); 
            abookingsystemdashboardAccount['data']['current']['api_key'] = $(this).parent().attr('data-api-key'); 
          
            for(var key in abookingsystemdashboardAccount['data']['withdraws']) {
                
                if(abookingsystemdashboardAccount['data']['withdraws'][key]['wid'] === parseInt(abookingsystemdashboardAccount['data']['current']['withdraw_id'])
                  && abookingsystemdashboardAccount['data']['withdraws'][key]['api_key'] === abookingsystemdashboardAccount['data']['current']['api_key']) {
                    abookingsystemdashboardAccount['data']['current']['data'] = abookingsystemdashboardAccount['data']['withdraws'][key];
                }
            }
          
            $('#absd-withdraw-'+abookingsystemdashboardAccount['data']['current']['withdraw_id']).addClass('absd-opened');  
            
            abookingsystemdashboardAccount.withdraw.setup.start();     
        });
      
        $('.absd-payment-actions .absd-approve').unbind('click');
        $('.absd-payment-actions .absd-approve').bind('click', function(e){
            abookingsystemdashboardAccount['data']['current']['withdraw_id'] = $(this).parent().parent().parent().attr('data-withdraw-id'); 
            abookingsystemdashboardAccount['data']['current']['api_key'] = $(this).parent().parent().parent().attr('data-api-key'); 
     
            var approveWithdrawForm = {
                name: "approve_withdraw",
                fields: [
                  {
                    label: "",
                    name: "withdraw_id",
                    value: abookingsystemdashboardAccount['data']['current']['withdraw_id'],        // default value
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
                    input_class: "absd_withdraw_id",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  },
                  {
                    label: "",
                    name: "api_key",
                    value: abookingsystemdashboardAccount['data']['current']['api_key'],        // default value
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
                  },
                  {
                    label: "",
                    name: "type",
                    value: 'paid',        // default value
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
                    input_class: "",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  },
                  {
                    label: "",
                    name: "reason",
                    value: '',        // default value
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
                    input_class: "",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  },
                  {
                    label: absdashboardtext['statement_oder_id'],
                    name: "transaction_id",
                    value: '',        // default value
                    placeholder: "",  
                    required: "true",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "text",                            // text, textarea, select, radio, checkbox, password
                    options: {},     // select options
                    label_class: "",
                    input_class: "",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  }]

            };
            // Start Form
            abookingsystemdashboardInfo.start(absdashboardtext['approve_button'],
                             approveWithdrawForm,
                             absdashboardtext['yes'],
                             absdashboardtext['cancel'],
                             abookingsystemdashboardAccount.withdraw.approve);
        });
      
        $('.absd-payment-actions .absd-reject').unbind('click');
        $('.absd-payment-actions .absd-reject').bind('click', function(e){
            abookingsystemdashboardAccount['data']['current']['withdraw_id'] = $(this).parent().parent().parent().attr('data-withdraw-id'); 
            abookingsystemdashboardAccount['data']['current']['api_key'] = $(this).parent().parent().parent().attr('data-api-key'); 
     
            var rejectWithdrawForm = {
                name: "reject_withdraw",
                fields: [
                  {
                    label: "",
                    name: "withdraw_id",
                    value: abookingsystemdashboardAccount['data']['current']['withdraw_id'],        // default value
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
                    input_class: "absd_withdraw_id",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  },
                  {
                    label: "",
                    name: "api_key",
                    value: abookingsystemdashboardAccount['data']['current']['api_key'],        // default value
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
                  },
                  {
                    label: "",
                    name: "type",
                    value: 'rejected',        // default value
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
                    input_class: "",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  },
                  {
                    label: absdashboardtext['search_listing_reason'],
                    name: "reason",
                    value: '',        // default value
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
                  },
                  {
                    label: "",
                    name: "transaction_id",
                    value: '',        // default value
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
                    input_class: "",
                    hint: "",
                    label_position: "left"         // left, right, left_full, right_full
                  }]

            };
            // Start Form
            abookingsystemdashboardInfo.start(absdashboardtext['reject'],
                             rejectWithdrawForm,
                             absdashboardtext['yes'],
                             absdashboardtext['cancel'],
                             abookingsystemdashboardAccount.withdraw.reject);
        });
    },
    withdraw: {
      view: function(data){
          var status_class = 'withdraw-status-pending';
          
          if (data.status !== "unpaid") {
              status_class = 'withdraw-status-resolved';
          }
          
          var HTML = new Array();
          HTML.push('<div class="absd-element '+status_class+'" id="absd-withdraw-'+data['id']+'" data-withdraw-id="'+data['id']+'" data-api-key="'+data['api_key']+'">');
          HTML.push('   <h3>');
          HTML.push(    data['title']);
          HTML.push('   </h3>');
          
          if(abookingsystemdashboard['account_type'] === 'affiliate'
             || abookingsystemdashboard['account_type'] === 'network') {
              HTML.push('   <div class="absd-payment-actions-holder">');
              HTML.push('       <div class="absd-payment-actions">');
              HTML.push('           <span class="absd-approve"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['approve_button']+'</span></span>');
              HTML.push('           <span class="absd-reject"><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['reject_button']+'</span></span>');
              HTML.push('       </div>');
              HTML.push('   </div>');
          }
          
          HTML.push('</div>');
        
          HTML.push('</div>');
        
          return HTML.join('');
      },
      add: function(){
          // Add Withdraw
          var addWithdrawForm = {
              name: "create_withdraw",
              fields: [{
                  label: absdashboardtext['withdraw_name'],
                  name: "fullname",
                  value: '',  // default value
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
                },{
                  label: absdashboardtext['withdraw_company'],
                  name: "company",
                  value: '',  // default value
                  placeholder: "",  
                  required: "false",
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
                },{
                  label: absdashboardtext['withdraw_bank_name'],
                  name: "bank_name",
                  value: '',  // default value
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
                },{
                  label: absdashboardtext['withdraw_bank_iban'],
                  name: "bank_iban",
                  value: '',  // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  is_iban: "true",
                  type: "text",                            // text, textarea, select, radio, checkbox, password
                  options: {0: {"name": "", "value": ""}},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                },{
                  label: absdashboardtext['withdraw_bank_swift'],
                  name: "bank_swift",
                  value: '',  // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  is_swift: "true",
                  type: "text",                            // text, textarea, select, radio, checkbox, password
                  options: {0: {"name": "", "value": ""}},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                },{
                  label: absdashboardtext['withdraw_amount']+' ( '+abookingsystemdashboardAccount['data']['currency']['sign']+' )',
                  name: "amount",
                  value: abookingsystemdashboardAccount['data']['money'],  // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  lower_than: abookingsystemdashboardAccount['data']['money'],
                  higher_than: 50,
                  type: "text",                            // text, textarea, select, radio, checkbox, password
                  options: {0: {"name": "", "value": ""}},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                },{
                  label: '',
                  name: "currency",
                  value: abookingsystemdashboardAccount['data']['currency']['code'],  // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  type: "hidden",                            // text, textarea, select, radio, checkbox, password
                  options: {0: {"name": "", "value": ""}},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                },{
                  label: '',
                  name: "stripe_account_id",
                  value: 0,  // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  type: "hidden",                            // text, textarea, select, radio, checkbox, password
                  options: {0: {"name": "", "value": ""}},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                },{
                  label: '',
                  name: "type",
                  value: "bank",  // default value
                  placeholder: "",  
                  required: "true",
                  allowed_characters: "",
                  min_chars: 0,     // 0 - disabled
                  max_chars: 0,     // 0 - disabled
                  is_email: "false",
                  is_phone: "false",
                  type: "hidden",                            // text, textarea, select, radio, checkbox, password
                  options: {0: {"name": "", "value": ""}},     // select options
                  label_class: "",
                  input_class: "",
                  hint: "",
                  label_position: "left"         // left, right, left_full, right_full
                }]

          };

          if(parseFloat(abookingsystemdashboardAccount['data']['money']) > 50) {
              // Start Form
              abookingsystemdashboardInfo.start(absdashboardtext['new_withdraw'],
                           addWithdrawForm,
                           absdashboardtext['create_withdraw'],
                           absdashboardtext['cancel'],
                           abookingsystemdashboardAccount.withdraw.add_ok);
          } else {
             var warningMessage = new Array();

                      warningMessage.push(absdashboardtext['minimum_payout']);

                      abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                          warningMessage.join(''),
                                          10);
         }
      },
      add_ok: function(){
          var fields = abookingsystemdashboardForm.fields.get(),
              withdraws = [],
              stats = [];
        
          if(fields !== "error"){
              // Start Loader
              abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                 absdashboardtext['wait']);
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['add_withdraw'],
                                          is_ajax_request: true,
                                          fullname: fields['fullname'],
                                          company: fields['company'],
                                          bank_name: fields['bank_name'],
                                          bank_iban: fields['bank_iban'],
                                          bank_swift: fields['bank_swift'],
                                          amount: fields['amount'],
                                          currency: fields['currency'],
                                          stripe_account_id: fields['stripe_account_id'],
                                          type: fields['type'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                
                  data = JSON.parse(data);
                
                  if(data.status === "success"){
                      withdraws = data['data']['withdraws'];
                      stats = data['data']['stats'];
                      abookingsystemdashboardAccount['data']['stats'] = stats;
                      abookingsystemdashboardAccount['data']['money'] = stats['money_in'];
                      withdraws[0]['sign'] = abookingsystemdashboardAccount['data']['currency']['sign'];
                      abookingsystemdashboardAccount.search.add(withdraws[0]);
                      abookingsystemdashboardAccount.withdraw.setup.view.header.start();
                  } else if(data.status === 'error_amount') {
                      stats = data['data']['stats'];
                      abookingsystemdashboardAccount['data']['stats'] = stats;
                      abookingsystemdashboardAccount['data']['money'] = stats['money_in'];
                      abookingsystemdashboardAccount.withdraw.setup.view.header.start();
                    
                      var warningMessage = new Array();
                          warningMessage.push(absdashboardtext['minimum_payout']);
                    
                          abookingsystemdashboardWarning.start(absdashboardtext['warning'],
                                              warningMessage.join(''),
                                              10);
                  }

                  // Stop Loader
                  abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                     absdashboardtext['refresh'],
                                     true);

              });
          }
      },
      setup:{
        start: function(){
            $('#absd-withdraws-content').html('');
            abookingsystemdashboardAccount.withdraw.setup.view.start();
            abookingsystemdashboardAccount.withdraw.setup.events();
        },
        view: {
            start: function(){
                var HTML = new Array();
                abookingsystemdashboardAccount.withdraw.setup.view.header.start();
                abookingsystemdashboardAccount.withdraw.setup.view.content.start();
            },
            header: {
                start: function(){
                    var HTML = new Array(),
                        calendarRequests = abookingsystemdashboardAccount['data']['stats']['requests_frontend_calendar_load']+abookingsystemdashboardAccount['data']['stats']['requests_frontend_add_to_cart']+abookingsystemdashboardAccount['data']['stats']['requests_frontend_pay']+abookingsystemdashboardAccount['data']['stats']['requests_frontend_availability'],
                        dashboardRequests = abookingsystemdashboardAccount['data']['stats']['requests']-calendarRequests,
                        moneyIn = abookingsystemdashboardAccount['data']['stats']['money_in']+' '+abookingsystemdashboardAccount['data']['currency']['sign'],
                        moneyOut = abookingsystemdashboardAccount['data']['stats']['money_out']+' '+abookingsystemdashboardAccount['data']['currency']['sign'];
                    
                    if(abookingsystemdashboard['account_type'] === 'network') {
                        var moneyInArr = [],
                            moneyOutArr = [];
                        
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['money_in']+' $');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['eur_money_in']+' €');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['gbp_money_in']+' £');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['jpy_money_in']+' ¥');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['chf_money_in']+' CHF');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['aud_money_in']+' AUD');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['cad_money_in']+' CAD');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['rub_money_in']+' RUB');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['sek_money_in']+' SEK');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['pln_money_in']+' PLN');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['dkk_money_in']+' DKK');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['czk_money_in']+' CZK');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['nzd_money_in']+' NZD');
                        moneyInArr.push(abookingsystemdashboardAccount['data']['stats']['thb_money_in']+' THB');
                        
                        moneyIn = moneyInArr.join('&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;');
                        
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['money_out']+' $');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['eur_money_out']+' €');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['gbp_money_out']+' £');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['jpy_money_out']+' ¥');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['chf_money_out']+' CHF');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['aud_money_out']+' AUD');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['cad_money_out']+' CAD');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['rub_money_out']+' RUB');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['sek_money_out']+' SEK');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['pln_money_out']+' PLN');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['dkk_money_out']+' DKK');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['czk_money_out']+' CZK');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['nzd_money_out']+' NZD');
                        moneyOutArr.push(abookingsystemdashboardAccount['data']['stats']['thb_money_out']+' THB');
                        
                        moneyOut = moneyOutArr.join('&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;');
                        
                    } else {
                        var moneyPrefix = abookingsystemdashboardAccount['data']['currency']['code'] !== 'USD' ? abookingsystemdashboardAccount['data']['currency']['code'].toLowerCase()+'_':'';
                        moneyIn = abookingsystemdashboardAccount['data']['stats'][moneyPrefix+'money_in']+' '+abookingsystemdashboardAccount['data']['currency']['sign'];
                        moneyOut = abookingsystemdashboardAccount['data']['stats'][moneyPrefix+'money_out']+' '+abookingsystemdashboardAccount['data']['currency']['sign'];
                    }
                    
                    $('#absd-withdraws-content').html('');
                    HTML.push('<div class="absd-header">');
                    HTML.push(' <div class="absd-header-box">');
                    HTML.push('   <h3>'+absdashboardtext['money']+'</h3>');
                    HTML.push('   <p>'+absdashboardtext['money_earnings']+' : <span>'+moneyIn+'</span></p>');
                    HTML.push('   <p>'+absdashboardtext['money_paid']+' : <span>'+moneyOut+'</span></p>');
                    HTML.push(' </div>');
                    HTML.push(' <div class="absd-header-box">');
                    HTML.push('   <h3>'+absdashboardtext['my_account_reservations']+'</h3>');
                    HTML.push('   <p>'+absdashboardtext['my_account_reservations_upcoming']+' : <span>'+abookingsystemdashboardAccount['data']['stats']['upcoming_reservations']+'</span></p>');
                    HTML.push('   <p>'+absdashboardtext['my_account_reservations_past']+' : <span>'+abookingsystemdashboardAccount['data']['stats']['finished_reservations']+'</span></p>');
                    HTML.push(' </div>');
//                    HTML.push(' <div class="absd-header-box">');
//                    HTML.push('   <h3>'+absdashboardtext['my_account_requests']+'</h3>');
//                    HTML.push('   <p>'+absdashboardtext['my_account_requests_calendar']+' : <span>'+calendarRequests+'</span></p>');
//                    HTML.push('   <p>'+absdashboardtext['my_account_requests_dashboard']+' : <span>'+dashboardRequests+'</span></p>');
//                    HTML.push(' </div>');
                    HTML.push(' <div class="absd-header-box">');
                    HTML.push('   <h3>'+absdashboardtext['my_account_api_details']+'</h3>');
                    HTML.push('   <p>'+absdashboardtext['my_account_api_user_key']+' : <span>'+abookingsystemdashboardAccount['data']['user']['user_key']+'</span></p>');
//                    HTML.push('   <p>'+absdashboardtext['my_account_api_endpoint']+' : <span>'+abookingsystemdashboardAccount['data']['user']['endpoint']+'</span></p>');
                    HTML.push(' </div>');
                    HTML.push('</div>');  
                    
                    $('#absd-withdraws-content').append(HTML.join(''));
                }
            },
            content: {
                start: function(content_type){
                    var HTML = new Array(),
                        invoices = abookingsystemdashboardAccount['data']['invoices'],
                        type_text = '',
                        price = 0,
                        amount = 0,
                        amount_value = 0,
                        invoice_id = 0,
                        description = '';
                    
                    HTML.push('<div id="absd-withdraws-content-box" class="absd-content-settings">');
                    
                    if(content_type !== undefined
                       && content_type === 'statement') {
                        // --- Statement 
                        HTML.push('     <div class="absd-content-table">');
                        HTML.push('         <div class="absd-content-table-row absd-content-table-row-header">');
                        HTML.push('             <div class="absd-content-table-column">');
                        HTML.push('             '+absdashboardtext['statement_date']);
                        HTML.push('             </div>');  
                        HTML.push('             <div class="absd-content-table-column absd-content-table-column2">');
                        HTML.push('             '+absdashboardtext['statement_oder_id']);
                        HTML.push('             </div>');
                        HTML.push('             <div class="absd-content-table-column absd-content-table-column3">');
                        HTML.push('             '+absdashboardtext['statement_type']);
                        HTML.push('             </div>');
                        HTML.push('             <div class="absd-content-table-column absd-content-table-column4">');
                        HTML.push('             '+absdashboardtext['statement_detail']);
                        HTML.push('             </div>');
                        HTML.push('             <div class="absd-content-table-column absd-content-table-column5">');
                        HTML.push('             '+absdashboardtext['statement_price']);
                        HTML.push('             </div>');
                        HTML.push('             <div class="absd-content-table-column absd-content-table-column6">');
                        HTML.push('             '+absdashboardtext['statement_amount']);
                        HTML.push('             </div>');
                        HTML.push('         </div>');  

                        // Invoices
                        var invoices_html = abookingsystemdashboardAccount.invoices.generate(invoices);
                        
                        for(var key in invoices_html) {
                            HTML.push(invoices_html[key]);
                        }
                        
                        HTML.push(' </div>');  
                        
                        // More invoices button
                        if(abookingsystemdashboardAccount.data.no_invoices_loaded < abookingsystemdashboardAccount.data.no_invoices) {
                            HTML.push('     <div class="absd-button absd-more-button absd-more-invoices">'+absdashboardtext['more']+'</div>');
                        }
                    } else {
                        HTML.push(' <div class="absd-content-settings-box">');  
                        HTML.push(' </div>');  
                    }
                    HTML.push('</div>');  
                    
                    $('#absd-withdraws-content').append(HTML.join(''));
                    
                    // Invoices events
                    abookingsystemdashboardAccount.invoices.events();
                  
                    // Load withdraw
                    if(content_type === undefined) {
                        var tempContent = [],
                            pay_date_mod = abookingsystemdashboardAccount['data']['current']['data']['pay_date'].split('-');
                        
                        tempContent.push('<p><span>'+absdashboardtext['my_account_withdraw_pay_date']+' :'+'</span> '+pay_date_mod[2]+'.'+pay_date_mod[1]+'.'+pay_date_mod[0]+'</p>');
                        
                        if(abookingsystemdashboardAccount['data']['current']['data']['payout'].indexOf('@') !== -1 ) {
                            tempContent.push('<p><span>Paypal :'+'</span> '+abookingsystemdashboardAccount['data']['current']['data']['payout']+'</p>');
                        } else {
                            tempContent.push('<p><span>'+absdashboardtext['withdraw_bank_iban']+' :'+'</span> '+abookingsystemdashboardAccount['data']['current']['data']['payout']+'</p>');
                        }
                        
                        // Description : @@@@@
                        if(abookingsystemdashboardAccount['data']['current']['data']['owner_description'].indexOf('@@@@@') !== -1 ) {
                            var tempDesc = abookingsystemdashboardAccount['data']['current']['data']['owner_description'].split('@@@@@'), indexdesc = 0;
                            
                            tempContent.push('<p><span>'+absdashboardtext['description']+' :'+'</span>');
                            
                            for(var idesc in tempDesc) {
                                var invoice_data = idesc < 1 ? tempDesc[idesc].split(';;;;;')[0].split('##').join(','):tempDesc[idesc].split(';;;;;')[0].split('##').join(''),
                                    invoice_amount = tempDesc[idesc].split(';;;;;')[1].split('##').join(''),
                                    invoice_id = tempDesc[idesc].split(';;;;;')[2];
                                
                                tempContent.push('<span class="absd-content-table-column-row">');   
                                tempContent.push('  <i class="absd-content-table-column-column1">'+invoice_data+'</i>');
                                tempContent.push('  <i class="absd-content-table-column-column2">'+(indexdesc == 1 ? '-':'')+invoice_amount+' '+abookingsystemdashboardAccount['data']['currency']['sign']+'</i>');
                                tempContent.push('</span>');
                                indexdesc++;
                            }
                            
                            tempContent.push('</p>');
                        } else {
                            tempContent.push('<p><span>'+absdashboardtext['description']+' :'+'</span> '+abookingsystemdashboardAccount['data']['current']['data']['owner_description']+'</p>');
                        }
                        
                        
                        tempContent.push('<p><span>'+absdashboardtext['withdraw_amount']+' :'+'</span> '+abookingsystemdashboardAccount['data']['current']['data']['amount']+' '+abookingsystemdashboardAccount['data']['currency']['sign']+'</p>');
                        
                        
                        if(abookingsystemdashboardAccount['data']['current']['data']['reason'] !== '') {
                            tempContent.push('<p><span>'+absdashboardtext['search_listing_reason']+' :'+'</span> '+abookingsystemdashboardAccount['data']['current']['data']['reason']+'</p>');
                        }
                        
                        tempContent.push('<p><span>'+absdashboardtext['my_account_withdraw_status']+' :'+'</span> '+absdashboardtext['my_account_withdraw_status_'+abookingsystemdashboardAccount['data']['current']['data']['status']]+'</p>');

                        var accordionsData = [],
                            accordionData = {label: '<b>'+abookingsystemdashboardAccount['data']['current']['data']['title']+'</b> ',
                                             name: 'withdraw_'+abookingsystemdashboardAccount['data']['current']['data']['wid'],
                                             data_time: abookingsystemdashboardAccount['data']['current']['data']['created'],
                                             class: 'absd-opened',
                                             content: tempContent.join(''),
                                             api_key: abookingsystemdashboardAccount['data']['current']['data']['api_key']};

                        accordionsData.push(accordionData);

                        abookingsystemdashboardAccordion.start($('.absd-content-settings-box'), accordionsData);
                    }
                }
            }
        },
        events: function(){
            $('#withdraw-settings-menu .absd-link').unbind('click');
            $('#withdraw-settings-menu .absd-link').bind('click', function(){
                abookingsystemdashboardAccount['data']['subpage'] = $(this).attr('data-type');
                abookingsystemdashboardAccount.withdraw.setup.start();          
            });
        }
      },
      approve: function(){
          var fields = abookingsystemdashboardForm.fields.get();
        
          if(fields !== "error"){
              // Start Loader
              abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                 absdashboardtext['wait']);
              
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request_ext_network['change_withdraw'],
                                          is_ajax_request: true,
                                          id: fields['withdraw_id'],
                                          api_key: fields['api_key'],
                                          type: fields['type'],
                                          reason: fields['reason'],
                                          transaction_id: fields['transaction_id'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                  data = JSON.parse(data);
                
                  if(data.status === "success"){
                      // Stop Loader
                      abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                         absdashboardtext['save_success'],
                                         true);
                    
                      // Research
                      abookingsystemdashboardAccount.search.delete(fields['api_key']);
                      
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
      reject: function(){
          var fields = abookingsystemdashboardForm.fields.get();
        
          if(fields !== "error"){
              // Start Loader
              abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                 absdashboardtext['wait']);
              
              $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request_ext_network['change_withdraw'],
                                          is_ajax_request: true,
                                          id: fields['withdraw_id'],
                                          api_key: fields['api_key'],
                                          type: fields['type'],
                                          reason: fields['reason'],
                                          transaction_id: fields['transaction_id'],
                                          ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                  data = JSON.parse(data);
                
                  if(data.status === "success"){
                      // Stop Loader
                      abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                         absdashboardtext['save_success'],
                                         true);
                    
                      // Research
                      abookingsystemdashboardAccount.search.delete(fields['api_key']);
                      
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
      }
    },
    invoices: {
        generate: function(invoices){
            var HTML = new Array(),
                type_text = '',
                price = '',
                amount_value = '',
                amount = '',
                description = '';
            
            if(invoices.length > 0) {

                for(var ikey in invoices) {
                    
                    abookingsystemdashboardAccount.data.no_invoices_loaded++;

                    switch(invoices[ikey]['type']) {
                        case "stripe_fee":
                            type_text = absdashboardtext['statement_payment_fee'];
                            price = invoices[ikey]['currency_sign']+(invoices[ikey]['amount']/100);
                            amount_value = parseFloat(invoices[ikey]['amount'])/100+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'P-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ')+'<br><u>Reservation ID: '+invoices[ikey]['reservation_id']+'</u>';
                            break;
                        case "service_fee":
                            type_text = absdashboardtext['statement_service_fee'];
                            price = invoices[ikey]['currency_sign']+invoices[ikey]['amount'];
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'S-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ')+'<br><u>Reservation ID: '+invoices[ikey]['reservation_id']+'</u>';
                            break;
                        case "network_fee":
                            type_text = absdashboardtext['reservations_network_fee'];
                            price = invoices[ikey]['currency_sign']+invoices[ikey]['amount'];
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'N-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ')+'<br><u>Reservation ID: '+invoices[ikey]['reservation_id']+'</u>';
                            break;
                        case "reservation":
                            type_text = absdashboardtext['statement_booking'];
                            price = (invoices[ikey]['currency_sign'] === '$' ? invoices[ikey]['currency_sign']+invoices[ikey]['amount']:invoices[ikey]['amount']+' '+invoices[ikey]['currency_sign']);
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ')+'<br><u>Reservation ID: '+invoices[ikey]['reservation_id']+'</u>';
                            break;
                        case "refund":
                            type_text = absdashboardtext['statement_refund'];
                            price = invoices[ikey]['currency_sign']+invoices[ikey]['amount'];
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'REF-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ')+'<br><u>Reservation ID: '+invoices[ikey]['reservation_id']+'</u>';
                            break;
                        case "withdraw":
                            type_text = absdashboardtext['withdraw'];
                            price = invoices[ikey]['currency_sign']+invoices[ikey]['amount'];
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'W-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ');
                            break;
                        case "exchange":
                            type_text = absdashboardtext['statement_exchange'];
                            price = '<span class="absd-content-table-column-red">-'+invoices[ikey]['amount_from']+' '+invoices[ikey]['currency_from_sign']+'</span>';
                            price = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_from_sign'], invoices[ikey]['amount_from'], invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'E-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ');
                            break;
                        case "affiliate_guest_fee":
                            type_text = absdashboardtext['statement_guest_referral'];
                            price = invoices[ikey]['currency_sign']+invoices[ikey]['amount'];
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'AG-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ')+'<br><u>Reservation ID: '+invoices[ikey]['reservation_id']+'</u>';
                            break;
                        case "affiliate_host_fee":
                            type_text = absdashboardtext['statement_host_referral'];
                            price = invoices[ikey]['currency_sign']+invoices[ikey]['amount'];
                            amount_value = parseFloat(invoices[ikey]['amount'])+(parseFloat(invoices[ikey]['vat']));
                            amount = abookingsystemdashboardAccount.invoices.amount_display(invoices[ikey]['currency_sign'], amount_value, invoices[ikey]['user_id'], invoices[ikey]['to_user_id']);
                            invoice_id = 'AH-'+invoices[ikey]['invoice_id'];
                            description = invoices[ikey]['description'].split('##').join(', ')+'<br><u>Reservation ID: '+invoices[ikey]['reservation_id']+'</u>';
                            break;
                    }

                    if(parseFloat(invoices[ikey]['vat']) !== 0){
                       price += '<br><span class="absd-content-table-column-blue">+'+invoices[ikey]['currency_sign']+parseFloat(invoices[ikey]['vat'])+' '+absdashboardtext['vat_or_gst']+'</span>';
                    }

                    HTML.push('         <div class="absd-content-table-row absd-content-table-row-content">');
                    HTML.push('             <div class="absd-content-table-column">');
                    HTML.push('                 '+invoices[ikey]['created']);
                    HTML.push('             </div>');  
                    HTML.push('             <div class="absd-content-table-column absd-content-table-column2">');
                    
                    if(invoices[ikey]['type'] === 'stripe_fee') {
                        HTML.push('                 Paypal: '+invoices[ikey]['transaction_id']);
                    } else {
                        HTML.push('                 <a href="#" class="absd-download-invoice" data-invoice="'+invoices[ikey]['parent_invoice_id']+'" data-user="'+invoices[ikey]['user_id']+'" title="Download" style="background:url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIzMnB4IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48dGl0bGUvPjxkZXNjLz48ZGVmcy8+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSI+PGcgZmlsbD0iIzE1N0VGQiIgaWQ9Imljb24tOTctZm9sZGVyLWRvd25sb2FkIj48cGF0aCBkPSJNMTcsMTQgTDMwLDE0IEwzMCwyNC45OTkxMjgzIEMzMCwyNS41NTUzNjkxIDI5LjU1NTQzNDIsMjYgMjkuMDA3MDM0NiwyNiBMMy45OTI5NjU0NCwyNiBDMy40NDYxMDg2MiwyNiAzLDI1LjU1NTk1NDYgMywyNS4wMDgxOTY5IEwzLDE0IEwxNiwxNCBMMTYsMjMuMDQ5OTk5IEwxMi43NSwxOS43OTk5OTkgTDEyLDIwLjU0OTk5OSBMMTYuNSwyNS4wNDk5OTkgTDIxLDIwLjU0OTk5OSBMMjAuMjUsMTkuNzk5OTk5IEwxNywyMy4wNDk5OTkgTDE3LDE0IEwxNywxNCBaIE0zLDEzIEwzLDYuOTkxODAzMTEgQzMsNi40NTUzMDU1OCAzLjQ0NDAxNDgxLDYgMy45OTE3MzQ4Myw2IEwxNC40MDAwMjQ0LDYgTDE2LjM1OTk4NTQsMTAgTDI4Ljk5NzAxNzIsMTAgQzI5LjU0NjE3MjMsMTAgMzAsMTAuNDQ4MTA1NSAzMCwxMS4wMDA4NzE3IEwzMCwxMyBMMywxMyBMMywxMyBaIE0xNyw5IEwxNSw1IEw0LjAwMjc2MDEzLDUgQzIuODk2NjY2MjUsNSAyLDUuODg5NjczOTUgMiw2Ljk5MTE1NSBMMiwyNS4wMDg4NDUgQzIsMjYuMTA4NTI5NSAyLjg5OTcxMjY4LDI3IDMuOTkzMjg3NDQsMjcgTDI5LjAwNjcxMjYsMjcgQzMwLjEwNzU3NDgsMjcgMzEsMjYuMTA3Mzc3MiAzMSwyNS4wMDQ5MTA3IEwzMSwxMC45OTUwODkzIEMzMSw5Ljg5MzIzMTkgMzAuMTAyOTM5OSw5IDI4Ljk5NDE0MTMsOSBMMTcsOSBMMTcsOSBaIiBpZD0iZm9sZGVyLWRvd25sb2FkIi8+PC9nPjwvZz48L3N2Zz4=);width:30px;height:30px;float:left;background-size:cover;text-decoration:none;border:0px;"></a>');
                    }
                    
                    HTML.push('             </div>');
                    HTML.push('             <div class="absd-content-table-column absd-content-table-column3">');
                    HTML.push('                 '+type_text);
                    HTML.push('             </div>');
                    HTML.push('             <div class="absd-content-table-column absd-content-table-column4">');
                    HTML.push('                 '+description);
                    HTML.push('             </div>');
                    HTML.push('             <div class="absd-content-table-column absd-content-table-column5">');
                    HTML.push('                 '+price);
                    HTML.push('             </div>');
                    HTML.push('             <div class="absd-content-table-column absd-content-table-column6">');
                    HTML.push('                 '+amount);
                    HTML.push('             </div>');
                    HTML.push('         </div>'); 
                }
            } else {
                HTML.push('         <div class="absd-content-table-row absd-content-table-row-content">');
                HTML.push('             <div class="absd-content-table-column-full"></div>');
                HTML.push('         </div>'); 
            }
            
            return HTML;
        },
        amount_display: function(currency_sign, amount, from_uid, to_uid){
            var display_amount = amount+' '+currency_sign;
            
            if(window.abookingsystemdashboard["bookeu_user_id"] == from_uid) {
                display_amount = '<span class="absd-content-table-column-green">+'+(currency_sign === '$' ? currency_sign+amount:amount+' '+currency_sign)+'</span>';
            } else if(window.abookingsystemdashboard["bookeu_user_id"] == to_uid) {
                display_amount = '<span class="absd-content-table-column-red">-'+(currency_sign === '$' ? currency_sign+amount:amount+' '+currency_sign)+'</span>';
            }
            
            return display_amount;
        },
        more: function(){
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                               absdashboardtext['wait']);
            
            // Next 7 Days
            abookingsystemdashboardAccount.data.skip_days = abookingsystemdashboardAccount.data.skip_days+7;
            
            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['more_invoices'],
                                        days: abookingsystemdashboardAccount.data.days,
                                        skip_days: abookingsystemdashboardAccount.data.skip_days,
                                        is_ajax_request: true,
                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                data = JSON.parse(data);
                
                abookingsystemdashboardAccount['data']['invoices'] = data['invoices'];
                
                abookingsystemdashboardAccount.invoices.add(data['invoices']);
              
                // Stop Loader
                abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                   absdashboardtext['refresh'],
                                   true);
                
                if(abookingsystemdashboardAccount.data.no_invoices_loaded === abookingsystemdashboardAccount.data.no_invoices) {
                    $('.absd-more-invoices').remove();
                }
              
            });
        },
        download: function(invoice_id, user_id){
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                               absdashboardtext['wait']);
            
            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['download_invoice'],
                                        invoice_id: invoice_id,
                                        user_id: user_id,
                                        is_ajax_request: true,
                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                data = JSON.parse(data);
                
                if(data.status === 'success') {
                    abookingsystemdashboardAccount.invoices.download_file(data.data, invoice_id, user_id);   
                }  
              
                // Stop Loader
                abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                   absdashboardtext['refresh'],
                                   true);
              
            });
        },
        download_file: function(text_data, invoice_id, user_id){
            var link = document.createElement("a"),
                filename = absdashboardtext['statement_oder_id']+'_'+user_id+'_'+invoice_id+'.html';
            link.setAttribute("target","_blank");
            if(Blob !== undefined) {
                var blob = new Blob([text_data], {type: "text/html"});
                link.setAttribute("href", URL.createObjectURL(blob));
            } else {
                link.setAttribute("href","data:text/html," + encodeURIComponent(text_data));
            }
            link.setAttribute("download",filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        add: function(invoices){
            
            if(invoices.length > 0) {
                // Invoices
                var invoices_html = abookingsystemdashboardAccount.invoices.generate(invoices);
                
                $('.absd-content-table').append(invoices_html.join(''));
            }
        },
        events: function(){
            $('.absd-more-invoices').unbind('click');
            $('.absd-more-invoices').bind('click', function(){
                abookingsystemdashboardAccount.invoices.more();          
            });
            
            $('.absd-download-invoice').unbind('click');
            $('.absd-download-invoice').bind('click', function(){
                var invoice_id = $(this).attr('data-invoice'),
                    user_id = $(this).attr('data-user');
                    
                abookingsystemdashboardAccount.invoices.download(invoice_id, user_id);          
            });
            
            
        }
    },
    search: {
      start: function(){
          var withdraws = abookingsystemdashboardAccount['data']['withdraws'],
              searchWord = abookingsystemdashboardAccount['data']['search'],
              page = abookingsystemdashboardAccount['data']['page'],
              per_page = abookingsystemdashboardAccount['data']['per_page'],
              total_items = 0,
              count_items = 0,
              start_item = (page == 0)?page:page*per_page;
          
          $('.absd-withdraws-holder').html('');
          $('#absd-withdraws-content').html('');
        
          for(var i in withdraws){
              var HTML = new Array();
            
              // Search for word x if is not empty
              if(withdraws[i]['title'].toLowerCase().indexOf(searchWord.toLowerCase()) !== -1
                 || searchWord === ''){
                      
                  count_items++;
                  if (count_items <= start_item || total_items >= per_page) { continue; }
                  
                  HTML.push(abookingsystemdashboardAccount.withdraw.view(withdraws[i]));

                  $('.absd-withdraws-holder').append(HTML.join(''));
                  total_items++;
              }
          }
          abookingsystemdashboardAccount['data']['total_items'] = count_items;


          // Events
          abookingsystemdashboardAccount.events(withdraws);
          abookingsystemdashboardAccount.search.events(withdraws);
          abookingsystemdashboardAccount.search.pagination.start(withdraws);
          abookingsystemdashboardAccount.search.pagination.events(withdraws);
      },
      group_withdraws: function(data){
          var new_data = [];
          
          for(var i = 0; i < data.length; i++){
            
            if(data[i]['wid'] !== undefined) {
              data[i]['id'] = parseInt(data[i]['wid']);
              data[i]['wid'] = parseInt(data[i]['wid']);
            }

            data[i]['title'] = '#'+data[i]['wid']+' - '+data[i]['amount']+' '+data[i]['sign'];

            if(data[i]['user_id'] !== undefined) {
              data[i]['user_id'] = parseInt(data[i]['user_id']);
            } else if(data[i]['uid'] !== undefined) {
              data[i]['user_id'] = parseInt(data[i]['uid']);
            }
            
            if(!new_data.hasOwnProperty(data[i]['pay_date'])){
               new_data[data[i]['pay_date']] = [];
            }
              
            if(!new_data[data[i]['pay_date']].hasOwnProperty(data[i]['to_uid'])){
               new_data[data[i]['pay_date']][data[i]['to_uid']] = [];
            }
              
            if(!new_data[data[i]['pay_date']][data[i]['to_uid']].hasOwnProperty('data')){
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data'] = [];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['title'] = '#'+data[i]['wid']+'...';
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['amount'] = parseFloat(data[i]['amount']);
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['invoices'] = [];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['invoices'].push(data[i]);
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['id'] = data[i]['wid'];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['api_key'] = data[i]['api_key'];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['payout'] = data[i]['payout'];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['owner_description'] = '#'+data[i]['wid'];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['status'] = data[i]['status'];
            } else {
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['amount'] += parseFloat(data[i]['amount']);
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['invoices'].push(data[i]);
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['id'] += '-'+data[i]['wid'];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['api_key']+= '-'+data[i]['api_key'];
                new_data[data[i]['pay_date']][data[i]['to_uid']]['data']['owner_description'] += ', #'+data[i]['wid'];
            } 
          }

          // Save Account in data
          abookingsystemdashboardAccount['data']['withdraws'] = data;
          abookingsystemdashboardAccount['data']['withdraws_group'] = new_data;
      },
      events: function(){
          $('.absd-search input').unbind('keyup');
          $('.absd-search input').bind('keyup', function(){
              abookingsystemdashboardAccount['data']['search'] = $(this).val();  
              abookingsystemdashboardAccount['data']['page'] = 0;
              abookingsystemdashboardAccount.search.start();
              
            // Stats
            abookingsystemdashboardAccount.withdraw.setup.view.header.start();
            abookingsystemdashboardAccount.withdraw.setup.view.content.start('statement');
          });
        
          $('.absd-add-withdraw').unbind('click');
          $('.absd-add-withdraw').bind('click', function(){
              abookingsystemdashboardAccount.withdraw.add();
          }); 
      },
      delete: function(api_key){
          var withdraws = abookingsystemdashboardAccount['data']['withdraws'],
              newAccount = [];
        
          for(var i = 0; i <= withdraws.length-1; i++) {
              
              if(withdraws[i]['api_key'] !== api_key) {
                  newAccount.push(withdraws[i]);
              }
          }
        
          abookingsystemdashboardAccount['data']['withdraws'] = newAccount;
        
          abookingsystemdashboardAccount.search.start();
      },
      add: function(data){
        
          abookingsystemdashboardAccount['data']['withdraws'].unshift(data);
          abookingsystemdashboardAccount.search.group_withdraws(abookingsystemdashboardAccount['data']['withdraws']);
          abookingsystemdashboardAccount.search.start();
      },
      pagination: {
          start: function(){  
            var page = abookingsystemdashboardAccount['data']['page'],
              per_page = abookingsystemdashboardAccount['data']['per_page'],
              total_items = abookingsystemdashboardAccount['data']['total_items'],
              total_pages = Math.ceil(total_items/per_page),
              center_page = (page==0) ? 1 : ((page >= (total_pages-1)) ? page-1 : page),
              prev_page = (page==0)?page:page-1,
              next_page = (page >= total_pages-1)?page:page+1;
            
              $('.absd-pagination').html(abookingsystemdashboardAccount.search.pagination.view(prev_page, center_page, next_page, page, total_pages));
             
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
                abookingsystemdashboardAccount['data']['page'] = parseInt($(this).attr('data-page'));
                abookingsystemdashboardAccount.search.start();
              
                // Stats
                abookingsystemdashboardAccount.withdraw.setup.view.header.start();
                abookingsystemdashboardAccount.withdraw.setup.view.content.start('statement');
              }); 
          }
      }
    }
  };
  
  window.abookingsystemdashboardAccount = abookingsystemdashboardAccount;
  
})(jQuery);