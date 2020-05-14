(function($){
  
var placeSearch, 
    autocomplete,
    abookingsystemMediaLibrary;
  
  /* 
   * Forms
   */
  var abookingsystemdashboardForm = {
      data: {},
      errors: 0,
      wpMediaLibraryUploadInit: function(){
        if(window.wp.media !== undefined) {
            abookingsystemMediaLibrary = window.wp.media({

                // Accepts [ 'select', 'post', 'image', 'audio', 'video' ]
                // Determines what kind of library should be rendered.
                frame: 'select',

                // Modal title.
                title: "Select Image",

                // Enable/disable multiple select
                multiple: false,

                // Library wordpress query arguments.
                library: {
                    order: 'DESC',

                    // [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
                    orderby: 'date',

                    // mime type. e.g. 'image', 'image/jpeg'
                    type: 'image',

                    // Searches the attachment title.
                    search: null,

                    // Includes media only uploaded to the specified post (ID)
                    uploadedTo: null // wp.media.view.settings.post.id (for current post ID)
                },

                button: {
//                    text: absdashboardtext['save']
                }

            });
        }
      },
      start: function(box, data){
          abookingsystemdashboardForm.wpMediaLibraryUploadInit();
          abookingsystemdashboardForm['data'] = data;
          box.html(abookingsystemdashboardForm.generate(data));
          abookingsystemdashboardForm.events();
      },
      generate: function(data){
          return abookingsystemdashboardForm.fields.generate(data);
      },
      events: function(){
          abookingsystemdashboardForm.fields.events();
      },
      clearError: function(element){
          var id = $(element).attr('id');
          $(element).removeClass('absd-error');
          $('#'+id+'-errors').addClass('absd-invisible');
      },
      fields: {
          get: function(){
              var myFields = abookingsystemdashboardForm['data']['fields'];
                  fieldsData = [];
              abookingsystemdashboardForm['erros'] = 0;
              $('.absd-errors').addClass('absd-invisible');
              $('div.absd-error').addClass('absd-invisible');
              $('.absd-input').removeClass('absd-error');
              $('.absd-textarea').removeClass('absd-error');
              $('.absd-select').removeClass('absd-error');
              
              for(var i = 0; i < myFields.length; i++) {
                  fieldsData[myFields[i]['name']] = abookingsystemdashboardForm.fields.field.get(abookingsystemdashboardForm['data']['name'], myFields[i]);
                  
                  if(fieldsData[myFields[i]['name']] === -999999999999999) {
                      return 'error';  
                  }
              }
              
              return fieldsData;
          },
          generate: function(data){
              var HTML = new Array();
              
              for(var i = 0; i < data['fields'].length; i++) {
                  HTML.push(abookingsystemdashboardForm.fields.field.generate(data['name'], data['fields'][i]));
              }
              
              return HTML.join('');
          },
          events: function(){
              abookingsystemdashboardForm.fields.field.events();
          },
          field: {
              generate: function(formName, data){
                  var HTML = new Array();
                  // absd-invisible
                  
                  if(data['type'] !== 'hidden') {
                      if(data['type'] === 'price_added'
                        && data['name'] === 'general_monthly_price') {
                          HTML.push('<div class="absd-more-price">'+absdashboardtext['more_prices']+'...</div>');
                      }
                      HTML.push('<div class="absd-field'+(data['type'] === 'price_added' && formName === 'availability_general' ? ' absd-price-box-add-content absd-invisible':'')+(data['field_class'] !== undefined ? ' '+data['field_class']:'')+'">');
                  }
                  
                  if(data['label_position'] === 'left') {
                    
                    // Label
                    if(data['type'] !== 'hidden'
                      && data['type'] !== 'button'
                      && data['type'] !== 'bullets'
                      && data['type'] !== 'image'){
                      
                      if(data['type'] === 'price' && formName === 'availability_general'
                        || data['type'] === 'price_added' && formName === 'availability_general'){
                          HTML.push('     <div class="absd-price-box-add">');
                        
                          if(data['type'] === 'price_added'){
                              HTML.push('     <div class="absd-price-box-add-plus '+(parseFloat(data['value']) > 0 ? ' absd-opened':'')+'" onclick="'+(data['enabling'] !== undefined ? data['enabling']:'javascript:void(0);')+'"><span class="absd-added">+</span><span class="absd-remove">-</span></div>');
                          }
                          HTML.push('     </div>');
                      }
                      
                      if(data['label'] !== undefined) {
                          HTML.push('   <label for="absd-form-'+formName+'-'+data['name']+'" class="absd-label '+(data['type'] === 'price' ? 'absd-price-label':'')+' '+(data['type'] === 'price_added' ? 'absd-price-label':'')+' '+data['label_class']+'">'+data['label']+' '+(data['required'] === 'true' ? (data['example'] === undefined ? '<span>*</span>':'<i>'+data['example']+'</i>'):'')+'</label>');
                      }
                    } else if(data['type'] === 'image'){
                          HTML.push('   <label for="absd-form-'+formName+'-'+data['name']+'" class="absd-label '+(data['type'] === 'price' ? 'absd-price-label':'')+' '+(data['type'] === 'price_added' ? 'absd-price-label':'')+' '+data['label_class']+'"></label>');
                    }
                    
                    switch(data['type']) {
                        case "phone":
                          HTML.push(' <div class="wdh-box-full">');
                          HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-select" class="absd-noselect-text wdh-box-1-3 absd-select"><span class="wdh-absd-flag wdh-absd-flag-'+data['country'].toLowerCase()+'"></span>');
                          HTML.push('     <div class="absd-select-icon"><span></span></div>');
                          HTML.push('     <ul id="absd-form-'+formName+'-'+data['name']+'-select-options" class="absd-select-options absd-phone">');
                          
                          for(var key in data['countries']) {
                              HTML.push('   <li data-value="'+key+'" class="'+(key === data['country'] ? 'absd-selected':'')+'"><span class="wdh-absd-flag wdh-absd-flag-'+key.toLowerCase()+'"></span> '+data['countries'][key]+'</li>');
                          }
                          HTML.push('     </ul>');
                          HTML.push('   </div>');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'-country-code" type="hidden" class="absd-input '+data['input_class']+'" '+(data['modify'] !== undefined ? 'data-change="'+data['modify']+'"':'')+' value="'+data['country']+'" />');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' type="text" class="absd-input wdh-box-2-3 '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          HTML.push(' </div>');
                          break;
                        case "country_state":
                          HTML.push(' <div class="wdh-box-full">');
                          HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-select" class="absd-noselect-text wdh-country wdh-box-1-3 absd-select"><span class="wdh-absd-flag wdh-absd-flag-'+data['country'].toLowerCase()+'"></span><span class="wdh-country-full">'+data['countries'][data['country']]+'</span>');
                          HTML.push('     <div class="absd-select-icon"><span></span></div>');
                          HTML.push('     <ul id="absd-form-'+formName+'-'+data['name']+'-select-options" class="absd-select-options absd-country">');
                          
                          for(var key in data['countries']) {
                              HTML.push('   <li data-value="'+key+'" class="'+(key === data['country'] ? 'absd-selected':'')+'"><span class="wdh-absd-flag wdh-absd-flag-'+key.toLowerCase()+'"></span> '+data['countries'][key]+'</li>');
                          }
                          HTML.push('     </ul>');
                          HTML.push('   </div>');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'-country-code" type="hidden" class="absd-input '+data['input_class']+'" '+(data['modify'] !== undefined ? 'data-change="'+data['modify']+'"':'')+' value="'+data['country']+'" />');
                          HTML.push(' </div>');
                          HTML.push(' <div class="wdh-state-full-box absd-invisible">');
                              HTML.push(' <label for="absd-form-'+formName+'-'+data['name']+'-state-code-select" class="absd-label '+data['label_class']+'">'+absdashboardtext['state']+'<span>*</span></label>');
                              HTML.push(' <div class="wdh-box-full">');
                              HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-state-code-select" class="absd-noselect-text wdh-state absd-select"><span class="absd-state-show">'+abookingsystemdashboardForm.fields.field.option.name(data['states'][0]['value'],data['states'])+'</span>');
                              HTML.push('     <div class="absd-select-icon"><span></span></div>');
                              HTML.push('     <ul id="absd-form-'+formName+'-'+data['name']+'-state-code-select-options" class="absd-select-options absd-state">');

                              for(var key in data['states']) {
                                  HTML.push('   <li data-value="'+data['states'][key]['value']+'" class="'+(data['states'][key]['value'] === data['state'] ? 'absd-selected':'')+'">'+data['states'][key]['name']+'</li>');
                              }
                              HTML.push('     </ul>');
                              HTML.push('   </div>');
                              HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'-state-code" type="hidden" class="absd-input '+data['input_class']+'" '+(data['modify'] !== undefined ? 'data-change="'+data['modify']+'"':'')+' value="'+data['state']+'" />');
                              HTML.push(' </div>');
                          HTML.push(' </div>');
                          HTML.push(' <div class="wdh-vat-full-box absd-invisible">');
                          HTML.push('   <div class="wdh-vat-full-box-left">'+absdashboardtext['pro_account']+'<br><span class="absd-vat-name"></span> (<span class="absd-vat-location"></span> - <span class="absd-vat-rate"></span>%)</div>');
                          HTML.push('   <div class="wdh-vat-full-box-right">'+abookingsystemdashboardRegister.data.account.pro.currency_symbol+abookingsystemdashboardRegister.data.account.pro.price+'<br><span class="absd-vat-amount"></div>');
                          HTML.push('   <div class="wdh-box-full-all">');
                          HTML.push('     <div class="wdh-vat-full-box-left-second">'+absdashboardtext['pro_account_total']+'</div>');
                          HTML.push('     <div class="wdh-vat-full-box-right-second"><span class="absd-vat-total"></div>');
                          HTML.push('   </div>');
                          HTML.push(' </div>');
                          break;
                        case "select":
                          HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-select" class="absd-noselect-text absd-select"><span>'+abookingsystemdashboardForm.fields.field.option.name(data['value'],data['options'])+'</span>');
                          HTML.push('     <div class="absd-select-icon"><span></span></div>');
                          HTML.push('     <ul id="absd-form-'+formName+'-'+data['name']+'-select-options" class="absd-select-options">');
                          
                          for(var key in data['options']) {
                              HTML.push('   <li data-value="'+data['options'][key]['value']+'" class="'+(data['options'][key]['value'] === data['value'] ? 'absd-selected':'')+'">'+data['options'][key]['name']+'</li>');
                          }
                          HTML.push('     </ul>');
                          HTML.push('   </div>');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-input '+data['input_class']+'"" '+(data['modify'] !== undefined ? 'data-change="'+data['modify']+'"':'')+' value="'+data['value']+'" />');
                          break;
                        case "checkbox":
                          HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-checkbox" class="absd-checkboxes '+((data['checkboxes_class'] !== undefined) ? data['checkboxes_class']:'')+'">');
                          for(var key in data['options']) {
                            HTML.push('     <div id="absd-form-'+formName+'-'+data['name']+'-checkbox-'+data['options'][key]['value']+'" class="absd-checkbox-multiple'+(data['value'].indexOf('@'+data['options'][key]['value']+'@') !== -1 ? ' absd-checked':(data['value'] !== undefined && data['value'] !== '' && data['value'] === data['options'][key]['value'] ? ' absd-checked':''))+'" data-value="'+data['options'][key]['value']+'"></div>');
                            HTML.push('     <label id="absd-form-'+formName+'-'+data['name']+'-checkbox-'+data['options'][key]['value']+'-label" for="absd-form-'+formName+'-'+data['name']+'-checkbox-'+data['options'][key]['value']+'-checkbox" class="absd-checkbox-label absd-checkbox-multiple-label '+((data['label_class'] !== undefined) ? data['label_class']:'')+'">'+data['options'][key]['name']+'</label>');
                          }
                          HTML.push('     <input id="absd-form-'+formName+'-'+data['name']+'-checkbox-value" type="hidden" class="absd-input '+data['input_class']+'" value="'+data['value']+'" />');
                          HTML.push('   </div>');
                          break;
                        case "terms":
                            HTML.push('     <div id="absd-form-'+formName+'-'+data['name']+'-checkbox" class="absd-checkbox '+data['input_class']+(data['value'] === "true" ? ' absd-checked':'')+'"></div>');
                            HTML.push('     <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-input" value="'+data['value']+'" />');
                          break;
                        case "textarea":
                          HTML.push('   <textarea id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['is_read_only'] !== undefined && data['is_read_only'] === 'true' ? 'readonly':'')+' class="absd-textarea '+data['input_class']+'">'+data['value']+'</textarea>');
                          
                          if(data['html'] !== undefined) {
                              HTML.push('   '+data['html']);
                          }
                          
                          break;
                        case "hidden":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' value="'+data['value']+'" />');
                          break;
                        case "image":
                          HTML.push('   <div id="absd-image-upload">'+data['label']+'</div>');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-image-upload-data" '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' />');
                          HTML.push('   <div class="wdh-box-full-full absd-image-upload-preview-box">');
                          HTML.push('     <label class="absd-label"></label>');
                          HTML.push('     <img '+(data['value'] !== undefined && data['value'] !== '' ? 'src="'+data['value']+'"':'')+' class="absd-image-upload-preview">');
                          HTML.push('   </div>');
                          break;
                        case "button":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" class="absd-button" type="button" value="'+data['label']+'" onclick="javascript:'+data['action']+'" />');
                          break;
                        case "map":
                        
                          if(data['value'] !== undefined
                            && data['value'] !== '') {
                              data['value']['latitude'] = data['value']['lat'];
                              data['value']['longitude'] = data['value']['lng'];
                              data['value']['address'] = data['value']['name'];
                              var tempLocation = JSON.stringify(data['value']),
                                  tempLocationName = data['value']['name'];

                              window.wdhMapDataLocation = data['value'];
                          }
                          
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'-map" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' type="text" class="absd-input absd-map '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+(tempLocationName !== undefined ? tempLocationName:'')+'" />');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" value="'+(tempLocation !== undefined ? tempLocation:'')+'" />');
                          break;
                        case "price":
                          var feePrice = abookingsystemdashboardForm.fee.price(abookingsystemdashboard['account_type'], data['value']), //data['value']*data['fee'],
                              finalPrice = data['value']+feePrice;
                          
                          if(data['network_fee'] !== undefined 
                              && data['network_fee'] > 0) {
                            
                              if(data['network_fee_type'] === 'percent') {
                                  feePrice += data['value']*data['network_fee'];
                                  finalPrice += data['value']*data['network_fee'];
                              } else {
                                  feePrice += data['network_fee'];
                                  finalPrice += data['network_fee'];
                              }
                          }
                          
                          HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-price" class="absd-price-box">');
                          HTML.push('     <div class="absd-price-box-info">');
                          HTML.push('       <label for="absd-form-'+formName+'-'+data['name']+'" class="absd-price-box-info-your">'+absdashboardtext['your_price']+'</label>');
                          HTML.push('       <label for="absd-form-'+formName+'-'+data['name']+'-fee" class="absd-price-box-info-fee">'+absdashboardtext['service_fee']+'<span>i<i>'+absdashboardtext['service_fee_info']+'</i></span></label>');
                          HTML.push('       <label for="absd-form-'+formName+'-'+data['name']+'-final" class="absd-price-box-info-final">'+absdashboardtext['estimated_price']+'<span>i<i>'+absdashboardtext['estimated_price_info']+'</i></span></label>');
                          HTML.push('     </div>');
                          HTML.push('     <div id="absd-form-'+formName+'-'+data['name']+'-price" class="absd-price-box-content">');
                          HTML.push('       <input id="absd-form-'+formName+'-'+data['name']+'" data-id="absd-form-'+formName+'-'+data['name']+'" data-key="'+data['name']+'" data-type="'+data['data_key']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' type="text" class="absd-input absd-price '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          HTML.push('       <span>+</span>');
                          HTML.push('       <input id="absd-form-'+formName+'-'+data['name']+'-fee" disabled="disabled" data-id="absd-form-'+formName+'-'+data['name']+'" data-key="'+data['name']+'" data-type="'+data['data_key']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' readonly="true" type="text" class="absd-input absd-price absd-price-fee '+data['input_class']+'" data-fee="'+data['fee']+'" data-network-fee="'+data['network_fee']+'" data-network-fee-type="'+data['network_fee_type']+'" placeholder="'+data['placeholder']+'" value="'+parseFloat(feePrice).toFixed(2)+'" />');
                          HTML.push('       <span>=</span>');
                          
                          
                          if(data['currency_position'] === 'before'
                             || data['currency_position'] === 'before_space') {
                              HTML.push('       <div class="absd-left">'+data['currency_sign']+'</div>');
                          }
                        
                          HTML.push('       <input id="absd-form-'+formName+'-'+data['name']+'-final" data-id="absd-form-'+formName+'-'+data['name']+'" data-key="'+data['name']+'" data-type="'+data['data_key']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' type="text" class="absd-input absd-final-price '+(data['currency_position'] === 'before' || data['currency_position'] === 'before_space' ? 'absd-no-left':'')+' '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+parseFloat(finalPrice).toFixed(2)+'" />');
                          
                          if(data['currency_position'] === 'after'
                             || data['currency_position'] === 'after_space') {
                              HTML.push('       <div>'+data['currency_sign']+'</div>');
                          }
                        
                        
                          HTML.push('     </div>');
                          HTML.push('   </div>');
                          break;
                        case "price_added":
                          var feePrice = abookingsystemdashboardForm.fee.price(abookingsystemdashboard['account_type'], data['value']), //data['value']*data['fee'],
                              finalPrice = data['value']+feePrice;
                          
                          if(data['network_fee'] !== undefined 
                              && data['network_fee'] > 0) {
                            
                              if(data['network_fee_type'] === 'percent') {
                                  feePrice += data['value']*data['network_fee'];
                                  finalPrice += data['value']*data['network_fee'];
                              } else {
                                  feePrice += data['network_fee'];
                                  finalPrice += data['network_fee'];
                              }
                          }
                          
                          HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-price" class="absd-price-box">');
                          HTML.push('     <div class="absd-price-box-info">');
                          HTML.push('       <label for="absd-form-'+formName+'-'+data['name']+'" class="absd-price-box-info-your">'+absdashboardtext['your_price']+'</label>');
                          HTML.push('       <label for="absd-form-'+formName+'-'+data['name']+'-fee" class="absd-price-box-info-fee">'+absdashboardtext['service_fee']+'<span>i<i>'+absdashboardtext['service_fee_info']+'</i></span></label>');
                          HTML.push('       <label for="absd-form-'+formName+'-'+data['name']+'-final" class="absd-price-box-info-final">'+absdashboardtext['estimated_price']+'<span>i<i>'+absdashboardtext['estimated_price_info']+'</i></span></label>');
                          HTML.push('     </div>');
                          HTML.push('     <div id="absd-form-'+formName+'-'+data['name']+'-price" class="absd-price-box-content">');
                          HTML.push('       <input id="absd-form-'+formName+'-'+data['name']+'" data-id="absd-form-'+formName+'-'+data['name']+'" data-key="'+data['name']+'" data-type="'+data['data_key']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' type="text" class="absd-input absd-price '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" '+(parseFloat(data['value']) === 0 && data['disabled'] !== undefined && formName === 'availability_general' ? 'disabled="disabled" style="opacity:0.3;"':'')+' />');
                          HTML.push('       <span>+</span>');
                          HTML.push('       <input id="absd-form-'+formName+'-'+data['name']+'-fee" disabled="disabled" data-id="absd-form-'+formName+'-'+data['name']+'" data-key="'+data['name']+'" data-type="'+data['data_key']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' readonly="true" type="text" class="absd-input absd-price absd-price-fee '+data['input_class']+'" data-fee="'+data['fee']+'" data-network-fee="'+data['network_fee']+'" data-network-fee-type="'+data['network_fee_type']+'" placeholder="'+data['placeholder']+'" value="'+parseFloat(feePrice).toFixed(2)+'" '+(parseFloat(data['value']) === 0 && data['disabled'] !== undefined && formName === 'availability_general' ? 'disabled="disabled" style="opacity:0.3;"':'')+' />');
                          HTML.push('       <span>=</span>');
                          
                          
                          if(data['currency_position'] === 'before'
                             || data['currency_position'] === 'before_space') {
                              HTML.push('       <div id="absd-form-'+formName+'-'+data['name']+'-currency" class="absd-left" '+(parseFloat(data['value']) === 0 && data['disabled'] !== undefined && formName === 'availability_general' ? 'style="opacity:0.3;"':'')+'>'+data['currency_sign']+'</div>');
                          }
                        
                          HTML.push('       <input id="absd-form-'+formName+'-'+data['name']+'-final" data-id="absd-form-'+formName+'-'+data['name']+'" data-key="'+data['name']+'" data-type="'+data['data_key']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' type="text" class="absd-input absd-final-price '+(data['currency_position'] === 'before' || data['currency_position'] === 'before_space' ? 'absd-no-left':'')+' '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+parseFloat(finalPrice).toFixed(2)+'" '+(parseFloat(data['value']) === 0 && data['disabled'] !== undefined && formName === 'availability_general' ? 'disabled="disabled" style="opacity:0.3;"':'')+' />');
                          
                          if(data['currency_position'] === 'after'
                             || data['currency_position'] === 'after_space') {
                              HTML.push('       <div id="absd-form-'+formName+'-'+data['name']+'-currency" '+(parseFloat(data['value']) === 0 && data['disabled'] !== undefined && formName === 'availability_general' ? 'style="opacity:0.3;"':'')+'>'+data['currency_sign']+'</div>');
                          }
                        
                        
                          HTML.push('     </div>');
                          HTML.push('   </div>');
                          break;
                        case "switch":
                          HTML.push('   <label id="absd-form-'+formName+'-'+data['name']+'-switch" class="absd-switch">');
                          HTML.push('     <input id="absd-form-'+formName+'-'+data['name']+'" type="checkbox" class="absd-checkbox '+data['input_class']+'"" '+(data['modify'] !== undefined ? 'onclick="'+data['modify']+'"':'')+' '+(data['value'] === 'true' ? 'checked="checked"':'')+' />');
                          HTML.push('     <div class="absd-slider absd-round"></div>');
                          HTML.push('   </label>');
                          break;
                        case "password":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' type="password" class="absd-input '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          break;
                        case "date":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'-date" type="text" class="absd-input absd-date '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-input '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          break;
                        case "bullets":
                          HTML.push('   <div class="absd-bullets">');
                            
                          for(var bulletKey = 1; bulletKey <= data['bullets']; bulletKey++) {
                            HTML.push('   <div class="absd-bullet '+(data['selected_bullet'] === bulletKey ? 'absd-selected_bullet':'')+'"></div>');
                          }
                          HTML.push('   </div>');
                          break;
                        default:
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' '+(data['is_read_only'] !== undefined && data['is_read_only'] === 'true' ? 'readonly':'')+' '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'onkeyup="abookingsystemdashboardForm.clearError(this);"')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'onblur="abookingsystemdashboardForm.clearError(this);"')+' type="text" class="absd-input '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          break;
                    }
                    
                    // Info
                    if(data['hint'] !== undefined
                       && data['hint'] !== '') {
                        HTML.push('   <div class="absd-info '+(data['type'] === 'switch' ? 'absd-margin-left-10':'')+'">');
                        HTML.push('       ?');
                        HTML.push('       <div class="absd-info-box"><span class="absd-info-title">'+absdashboardtext['hint']+'</span><span class="absd-info-content">'+data['hint']+'</span></div>');
                        HTML.push('   </div>');
                    }
                    
                  } else {
                    
                    switch(data['type']) {
                        case "select":
                          HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-select" class="absd-noselect-text absd-select"><span>'+abookingsystemdashboardForm.fields.field.option.name(data['value'],data['options'])+'</span>');
                          HTML.push('     <div class="absd-select-icon"><span></span></div>');
                          HTML.push('     <ul id="absd-form-'+formName+'-'+data['name']+'-select-options" class="absd-select-options">');
                          
                          for(var key in data['options']) {
                              HTML.push('   <li data-value="'+data['options'][key]['value']+'" class="'+(data['options'][key]['value'] === data['value'] ? 'absd-selected':'')+'">'+data['options'][key]['name']+'</li>');
                          }
                          HTML.push('     </ul>');
                          HTML.push('   </div>');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-input '+data['input_class']+'"" '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' value="'+data['value']+'" />');
                          break;
                        case "checkbox":
                          HTML.push('   <div class="absd-checkboxes '+((data['checkboxes_class'] !== undefined) ? data['checkboxes_class']:'')+'">');
                        
                          for(var key in data['options']) {
                            HTML.push('     <div id="absd-form-'+formName+'-'+data['name']+'-checkbox-'+data['options'][key]['name']+'-checkbox" class="absd-checkbox'+(data['value'].indexOf('@'+data['options'][key]['value']+'@') !== -1 ? ' absd-checked':'')+'"></div>');
                            HTML.push('     <input id="absd-form-'+formName+'-'+data['name']+'-checkbox-'+data['options'][key]['name']+'" type="hidden" class="absd-input '+data['input_class']+'" value="'+data['value']+'" />');
                          }
                          HTML.push('     <input id="absd-form-'+formName+'-'+data['name']+'-checkbox-value" type="hidden" class="absd-input '+data['input_class']+'" value="'+data['value']+'" />');
                          HTML.push('   </div>');
                          break;
                        case "terms":
                            HTML.push('     <div id="absd-form-'+formName+'-'+data['name']+'-checkbox" class="absd-checkbox '+data['input_class']+(data['value']=== "true" ? ' absd-checked':'')+'"></div>');
                            HTML.push('     <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-input" value="'+data['value']+'" />');
                          break;
                        case "textarea":
                          HTML.push('   <textarea id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['is_read_only'] !== undefined && data['is_read_only'] === 'true' ? 'readonly':'')+' class="absd-textarea '+data['input_class']+'">'+data['value']+'</textarea>');
                          
                          if(data['html'] !== undefined) {
                              HTML.push('   '+data['html']);
                          }
                          
                          break;
                        case "hidden":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' value="'+data['value']+'" />');
                          break;
                        case "button":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" class="absd-button" type="button" value="'+data['label']+'" onclick="javascript:'+data['action']+'" />');
                          break;
                        case "map":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' type="text" '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' class="absd-input absd-map '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          break;
                        case "image":
                          HTML.push('   <input id="absd-image-upload" type="file" style="width: 60%;overflow: hidden;" />');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-image-upload-data" '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' />');
                          HTML.push('   <div class="wdh-box-full-full absd-image-upload-preview-box">');
                          HTML.push('     <img style="max-height:80px;" '+(data['value'] !== undefined && data['value'] !== '' ? 'src="'+data['value']+'"':'')+' class="absd-image-upload-preview">');
                          HTML.push('   </div>');
                          break;
                        case "switch":
                          HTML.push('   <label id="absd-form-'+formName+'-'+data['name']+'-switch" class="absd-switch">');
                          HTML.push('     <input id="absd-form-'+formName+'-'+data['name']+'" type="checkbox" class="absd-checkbox '+data['input_class']+'"" '+(data['modify'] !== undefined ? 'onclick="'+data['modify']+'"':'')+' '+(data['value'] === 'true' ? 'checked="checked"':'')+' />');
                          HTML.push('     <div class="absd-slider absd-round"></div>');
                          HTML.push('   </label>');
                          break;
                        case "pasword":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' type="password" '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'')+' class="absd-input '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          break;
                        case "date":
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'-date" type="text" class="absd-input absd-date '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" type="hidden" class="absd-input '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          break;
                        case "bullets":
                          HTML.push('   <div class="absd-bullets">');
                            
                          for(var bulletKey = 1; bulletKey <= data['bullets']; bulletKey++) {
                            HTML.push('   <div class="absd-bullet '+(bulletKey <= data['selected_bullet'] ? 'absd-selected_bullet':'')+'"></div>');
                          }
                          HTML.push('   </div>');
                          break;
                        default:
                          HTML.push('   <input id="absd-form-'+formName+'-'+data['name']+'" '+(data['max_chars'] > 0 ? ' maxlength="'+data['max_chars']+'"':'')+' '+(data['is_read_only'] !== undefined && data['is_read_only'] === 'true' ? 'readonly':'')+' '+(data['modify'] !== undefined ? 'onchange="'+data['modify']+'"':'')+' '+(data['modify'] !== undefined ? 'onkeyup="'+data['modify']+'"':'onkeyup="abookingsystemdashboardForm.clearError(this);"')+' '+(data['modify'] !== undefined ? 'onblur="'+data['modify']+'"':'onblur="abookingsystemdashboardForm.clearError(this);"')+' type="text" class="absd-input '+data['input_class']+'" placeholder="'+data['placeholder']+'" value="'+data['value']+'" />');
                          break;
                    }
                    
                    // Info
                    if(data['hint'] !== undefined
                       && data['hint'] !== '') {
                        HTML.push('   <div class="absd-info '+(data['type'] === 'switch' ? 'absd-margin-left-10':'')+'">');
                        HTML.push('       ?');
                        HTML.push('       <div class="absd-info-box"><span class="absd-info-title">'+absdashboardtext['hint']+'</span><span class="absd-info-content">'+data['hint']+'</span></div>');
                        HTML.push('   </div>');
                    }
                    
                    // Label
                    if(data['type'] !== 'hidden'){
                        HTML.push('   <label for="absd-form-'+formName+'-'+data['name']+'" class="absd-label '+data['label_class']+'">'+data['label']+' '+(data['required'] === 'true' ? '<span>*</span>':'')+'</label>');
                    }
                  }
                
                  HTML.push('   <div id="absd-form-'+formName+'-'+data['name']+'-errors" class="absd-errors absd-invisible">');
                  HTML.push('     <div class="absd-error absd-error-required absd-invisible">'+absdashboardtext['error_is_required']+'</div>');
                  HTML.push('     <div class="absd-error absd-error-email absd-invisible">'+absdashboardtext['error_is_email']+'</div>');
                  HTML.push('     <div class="absd-error absd-error-phone absd-invisible">'+absdashboardtext['error_is_phone']+'</div>');
                  HTML.push('     <div class="absd-error absd-error-iban absd-invisible">'+absdashboardtext['error_is_iban']+'</div>');
                  HTML.push('     <div class="absd-error absd-error-swift absd-invisible">'+absdashboardtext['error_is_swift']+'</div>');
                  
                  if(data['lower_than'] !== undefined) {
                      HTML.push('     <div class="absd-error absd-error-lower absd-invisible">'+absdashboardtext['error_is_lower_than']+'</div>');
                  }
                
                  if(data['higher_than'] !== undefined) {
                      HTML.push('     <div class="absd-error absd-error-higher absd-invisible">'+absdashboardtext['error_is_higher_than']+'</div>');
                  }
                
                  if(data['same_with'] !== undefined) {
                      HTML.push('     <div class="absd-error absd-error-same-with absd-invisible">'+absdashboardtext['the_fields']+' <b>'+data['label']+'</b> '+absdashboardtext['and']+' <b>'+data['same_with_label']+'</<b> '+absdashboardtext['must_be_identique']+'</div>');
                  }
                
                  if(data['exist'] !== undefined) {
                      HTML.push('     <div class="absd-error absd-error-exist absd-invisible">'+absdashboardtext['the_field']+' <b>'+data['label']+'</b> '+absdashboardtext['already_exist']+'</div>');
                  }
                
                  if(data['is_url'] !== undefined) {
                      HTML.push('     <div class="absd-error absd-error-url absd-invisible">'+absdashboardtext['error_invalid_url']+'</div>');
                  }
                
                  if(data['terms'] !== undefined) {
                      HTML.push('     <div class="absd-error absd-error-terms absd-invisible">'+absdashboardtext['must_agree']+'</div>');
                  }
                
                  HTML.push('     <div class="absd-error absd-error-min-chars absd-invisible">'+absdashboardtext['error_min_chars']+'</div>');
                  HTML.push('     <div class="absd-error absd-error-allowed-chars absd-invisible">'+absdashboardtext['error_allowed_characters']+'</div>');
                  HTML.push('   </div>');
                
                  if(data['type'] !== 'hidden') {
                      HTML.push('</div>');
                  }
                
                  return HTML.join('');
              },
              map: function(){
                  var mapinputID = $('.absd-map').attr('id');
                  
                  if(mapinputID !== undefined) {
                      autocomplete = new google.maps.places.Autocomplete(document.getElementById(mapinputID), {
                          types: []
                      });
//                           types: ['(cities)']
                    

                      google.maps.event.addListener(autocomplete, 'place_changed', function () {
                          var place = autocomplete.getPlace();
                          
                          if(place !== undefined) {
                              var address = place.formatted_address,
                                  latitude = place.geometry.location.lat(),
                                  longitude = place.geometry.location.lng(),
                                  tempData = {},
                                  mapinputSaveDataID = mapinputID.split('-map')[0];
                            
                              // Get Country & State
                              for(var key in place.address_components){
                                  
                                  if($.inArray('country', place.address_components[key]['types']) > -1){
                                      tempData['country'] = place.address_components[key]['short_name'];
                                      tempData['country_long'] = place.address_components[key]['long_name'];
                                  }
                                  
                                  if($.inArray('administrative_area_level_1', place.address_components[key]['types']) > -1){
                                      tempData['state'] = place.address_components[key]['short_name'];
                                      tempData['state_long'] = place.address_components[key]['long_name'];
                                  }
                                  
                                  if($.inArray('administrative_area_level_2', place.address_components[key]['types']) > -1){
                                      tempData['city'] = place.address_components[key]['short_name'];
                                      tempData['city_long'] = place.address_components[key]['short_name'];
                                  }
                                  
                                  if($.inArray('route', place.address_components[key]['types']) > -1){
                                      tempData['street'] = place.address_components[key]['short_name'];
                                  }
                                  
                                  if($.inArray('street_number', place.address_components[key]['types']) > -1){
                                      tempData['street_no'] = place.address_components[key]['long_name'];
                                  }
                                  
                                  if($.inArray('postal_code', place.address_components[key]['types']) > -1){
                                      tempData['postal_code'] = place.address_components[key]['long_name'];
                                  }
                              }
                            
                              tempData['address'] = address;
                              tempData['latitude'] = latitude;
                              tempData['longitude'] = longitude;
                            
                              abookingsystemdashboardCalendars.vat.change(tempData);
                            
                              window.wdhMapDataLocation = tempData;
                            
                              tempData = JSON.stringify(tempData);
                            
                              $.ajax({
                                 url:"https://maps.googleapis.com/maps/api/timezone/json?key="+abookingsystemdashboard["google_map_api_key"]+"&location="+latitude+","+longitude+"&timestamp="+(Math.round((new Date().getTime())/1000)).toString()+"&sensor=false",
                              }).done(function(response){
                                  
                                 if(response.timeZoneId != null){
                                    //do something
                                    var hour=(response.rawOffset)/60;
                                    window.wdhMapDataLocation['timezone'] = response.timeZoneId;
                            
                                    $('#'+mapinputSaveDataID).val(JSON.stringify(window.wdhMapDataLocation));
                                 }
                              });
                            
                              $('#'+mapinputSaveDataID).val(JSON.stringify(window.wdhMapDataLocation));
                          }
                      });
                  }
              },
              getBase64Image: function(url, callback) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function() {
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        callback(reader.result);
                    }
                    reader.readAsDataURL(xhr.response);
                };
                xhr.open('GET', url);
                xhr.responseType = 'blob';
                xhr.send();
              },
              image: function(data) {
                var size = data.filesizeInBytes/1024;
                  
                if(size > 1000){ // 1 MB
                    data.url = data.sizes !== undefined && data.sizes.large !== undefined ? data.sizes.large.url:data.url;
                    data.width = data.width !== undefined && data.sizes.large !== undefined ? data.sizes.large.width:data.width;
                    data.height = data.height !== undefined && data.sizes.large !== undefined ? data.sizes.large.height:data.height;
                }
                  
                var tempImage = data.url;

                if(size <= 1000) { // Maximum 1 MB

                    if ( (/\.(png|jpeg|jpg)$/i).test(data.url) ) {

                            if(data.width >= 1024 &&
                               data.height >= 685){
                                abookingsystemdashboardForm.fields.field.getBase64Image(data.url, function(tempData64){
                                    $('.absd-image-upload-preview').attr('src', tempImage);
                                    $('.absd-image-upload-preview-box').removeClass('absd-invisible');
                                    $('.absd-image-upload-data').val(tempData64);
                                    window.absdSelectedValue = tempData64; 
                                });
                            } else {
                               alert(absdashboardtext['error_cover_size']);
                               abookingsystemMediaLibrary.open();
                            }
                    } else {
                        alert(absdashboardtext['error_cover_extensions']);
                        abookingsystemMediaLibrary.open();
                    }
                } else {
                    alert(absdashboardtext['error_cover_file_size']);
                    abookingsystemMediaLibrary.open();
                }
              },
              option:{
                 name: function(value, options){
                   
                   for(var i = 0; i < options.length; i++){
                     
                      if(options[i] !== undefined) {
                          
                          if(options[i]['value'] === value) {
                              return options[i]['name'];
                          }

                          if(value === '') {
                              value = options[i]['name'];
                          }
                      }
                   }
                   
                   return value;
                     
                 }
              },
              events: function(){
                  
                  $('.absd-checkbox-multiple').unbind('click');
                  $('.absd-checkbox-multiple').bind('click', function(){
                    var tempCheckbox = $(this).attr('id'),
                        tempCheckboxValuesID = $(this).attr('id').split('-checkbox')[0],
                        tempCheckboxValues = $('#'+tempCheckboxValuesID+'-checkbox-value').val();
                    
                      if(tempCheckboxValues === '') {
                          tempCheckboxValues = [];
                      } else {
                          
                          if(tempCheckboxValues.indexOf('@') !== -1) {
                              tempCheckboxValues = tempCheckboxValues.split('@').join('"');
                              tempCheckboxValues = JSON.parse(tempCheckboxValues);
                          } else {
                            var tempValue = tempCheckboxValues;
                            tempCheckboxValues = [];
                            tempCheckboxValues.push(tempValue);
                          }
                      }
                      
                      if($(this).hasClass('absd-checked')){
                          $(this).removeClass('absd-checked');
                          var newTempCheckboxValues = [];
                          
                          for(var key in tempCheckboxValues) {
                              
                              if($('#'+tempCheckbox).attr('data-value') !== tempCheckboxValues[key]) {
                                  newTempCheckboxValues.push(tempCheckboxValues[key]);
                              }
                          }
                          var checked = JSON.stringify(newTempCheckboxValues);
                              checked = checked.split('"').join('@');
                          $('#'+tempCheckboxValuesID+'-checkbox-value').val(checked);
                      } else {
                          $(this).addClass('absd-checked');
                          
                          if(tempCheckboxValues.indexOf($('#'+tempCheckbox).attr('data-value')) === -1) {
                              tempCheckboxValues.push($('#'+tempCheckbox).attr('data-value'));
                              var checked = JSON.stringify(tempCheckboxValues);
                                  checked = checked.split('"').join('@');
                              $('#'+tempCheckboxValuesID+'-checkbox-value').val(checked);
                          }
                      }
                  });
                  
                  $('.absd-checkbox-multiple-label').unbind('click');
                  $('.absd-checkbox-multiple-label').bind('click', function(){
                      var tempCheckbox = $(this).attr('id').split('-label')[0],
                          tempCheckboxValuesID = $(this).attr('id').split('-checkbox')[0],
                          tempCheckboxValues = $('#'+tempCheckboxValuesID+'-checkbox-value').val();
                    
                      if(tempCheckboxValues === '') {
                          tempCheckboxValues = [];
                      } else {
                          
                          if(tempCheckboxValues.indexOf('@') !== -1) {
                              tempCheckboxValues = tempCheckboxValues.split('@').join('"');
                              tempCheckboxValues = JSON.parse(tempCheckboxValues);
                          } else {
                            var tempValue = tempCheckboxValues;
                            tempCheckboxValues = [];
                            tempCheckboxValues.push(tempValue);
                          }
                      }
                      
                      if($('#'+tempCheckbox).hasClass('absd-checked')){
                          $('#'+tempCheckbox).removeClass('absd-checked');
                          var newTempCheckboxValues = [];
                          
                          for(var key in tempCheckboxValues) {
                              
                              if($('#'+tempCheckbox).attr('data-value') !== tempCheckboxValues[key]) {
                                  newTempCheckboxValues.push(tempCheckboxValues[key]);
                              }
                          }
                          var checked = JSON.stringify(newTempCheckboxValues);
                              checked = checked.split('"').join('@');
                          $('#'+tempCheckboxValuesID+'-checkbox-value').val(checked);
                      } else {
                          $('#'+tempCheckbox).addClass('absd-checked');
                          
                          if(tempCheckboxValues.indexOf($('#'+tempCheckbox).attr('data-value')) === -1) {
                              tempCheckboxValues.push($('#'+tempCheckbox).attr('data-value'));
                              var checked = JSON.stringify(tempCheckboxValues);
                                  checked = checked.split('"').join('@');
                              $('#'+tempCheckboxValuesID+'-checkbox-value').val(checked);
                          }
                      }
                  });
                  
                  $('.absd-select').unbind('click');
                  $('.absd-select').bind('click', function(){
                      
                      if($(this).hasClass('absd-opened')){
                          $(this).removeClass('absd-opened');
                      } else {
                          $(this).addClass('absd-opened');
                      }
                  });
                
                  // More prices
                  $('.absd-more-price').unbind('click');
                  $('.absd-more-price').bind('click', function(){
                      $(this).remove();
                      $('.absd-price-box-add-content').removeClass('absd-invisible');
                  });
                  
                  // Checkbox
                  $('.absd-checkbox').unbind('click');
                  $('.absd-checkbox').bind('click', function(){
                      var fieldCheckboxID = $(this).attr('id'),
                          fieldID = fieldCheckboxID.split('-checkbox')[0];
                      
                      if($('#'+fieldCheckboxID).hasClass('absd-checked')) {
                          $('#'+fieldCheckboxID).removeClass('absd-checked');
                          $('#'+fieldID).val('false');
                      } else {
                          $('#'+fieldCheckboxID).addClass('absd-checked');
                          $('#'+fieldID).val('true');
                      }
                  });
                
                  // Select
                  $('.absd-select-options li').unbind('click');
                  $('.absd-select-options li').bind('click', function(){
                      var formID = $(this).parent().attr('id'),
                          idsData = formID.split('absd-form-')[1],
                          formName = idsData.split('-select-options')[0].split('-')[0],
                          fieldID = idsData.split('-select-options')[0].split('-')[1];
                    
                      $('.absd-select-options li').removeClass('absd-selected');
                      $('#absd-form-'+formName+'-'+fieldID+'-select span').eq(0).html($(this).html());
                      $('#absd-form-'+formName+'-'+fieldID).val($(this).attr('data-value'));
                    
                      var dataChange = $('#absd-form-'+formName+'-'+fieldID).attr('data-change');
                      window.absdSelectedValue = $(this).attr('data-value'); 
                      eval(dataChange);
                    
                      $(this).addClass('absd-selected');
                  });
                
                  // Select Phone country
                  $('.absd-select-options.absd-phone li').unbind('click');
                  $('.absd-select-options.absd-phone li').bind('click', function(){
                      var formID = $(this).parent().attr('id'),
                          idsData = formID.split('absd-form-')[1],
                          formName = idsData.split('-select-options')[0].split('-')[0],
                          fieldID = idsData.split('-select-options')[0].split('-')[1],
                          tempValue = $(this).attr('data-value'),
                          countries = window.abookingsystemdashboardRegister !== undefined ? window.abookingsystemdashboardRegister['data']['countries']:(window.abookingsystemdashboardCalendars !== undefined ? window.abookingsystemdashboardCalendars['data']['countries']:[]);

                      $('.absd-select-options.absd-phone li').removeClass('absd-selected');

                      for(var ckey in countries) { 
                          $('#absd-form-'+formName+'-'+fieldID+'-select span').eq(0).removeClass('wdh-absd-flag-'+ckey.toLowerCase());
                      }

                      $('#absd-form-'+formName+'-'+fieldID+'-select span').eq(0).addClass('wdh-absd-flag-'+tempValue.toLowerCase());
                      $('#absd-form-'+formName+'-'+fieldID+'-country-code').val(tempValue);

                      $('#absd-form-'+formName+'-'+fieldID).addClass('absd-selected');
                  });
                
                  // Select Phone country
                  $('.absd-select-options.absd-country li').unbind('click');
                  $('.absd-select-options.absd-country li').bind('click', function(){
                      var formID = $(this).parent().attr('id'),
                          idsData = formID.split('absd-form-')[1],
                          formName = idsData.split('-select-options')[0].split('-')[0],
                          fieldID = idsData.split('-select-options')[0].split('-')[1],
                          tempValue = $(this).attr('data-value'),
                          countries = window.abookingsystemdashboardRegister !== undefined ? window.abookingsystemdashboardRegister['data']['countries']:(window.abookingsystemdashboardCalendars !== undefined ? window.abookingsystemdashboardCalendars['data']['countries']:[]);

                      $('.absd-select-options.absd-country li').removeClass('absd-selected');

                      for(var ckey in countries) { 
                          $('#absd-form-'+formName+'-'+fieldID+'-select span').eq(0).removeClass('wdh-absd-flag-'+ckey.toLowerCase());
                      }
                      // wdh-country-full, wdh-absd-flag
                      $('#absd-form-'+formName+'-'+fieldID+'-select span.wdh-absd-flag').eq(0).addClass('wdh-absd-flag-'+tempValue.toLowerCase());
                      $('#absd-form-'+formName+'-'+fieldID+'-select span.wdh-country-full').eq(0).html(countries[tempValue]);
                      $('#absd-form-'+formName+'-'+fieldID+'-country-code').val(tempValue);
                    
                      if(tempValue === 'US'){
                          $('.wdh-state-full-box').removeClass('absd-invisible');
                      } else {
                          $('.wdh-state-full-box').addClass('absd-invisible');
                      }

                      $('#absd-form-'+formName+'-'+fieldID).addClass('absd-selected');
                    
                      var dataChange = $('#absd-form-'+formName+'-'+fieldID+'-country-code').attr('data-change');
                      window.absdSelectedValue = $(this).attr('data-value'); 
                      window.absdSelectedValueType = 'country'; 
                      eval(dataChange);
                  });
                
                  // Select
                  $('.absd-select-options.absd-state li').unbind('click');
                  $('.absd-select-options.absd-state li').bind('click', function(){
                      var formID = $(this).parent().attr('id'),
                          idsData = formID.split('absd-form-')[1],
                          formName = idsData.split('-select-options')[0].split('-')[0],
                          fieldID = idsData.split('-select-options')[0].split('-')[1];
                    
                      $('.absd-select-options.absd-state li').removeClass('absd-selected');
                      $('#absd-form-'+formName+'-'+fieldID+'-state-code-select span.absd-state-show').html($(this).html());
                      $('#absd-form-'+formName+'-'+fieldID+'-state-code').val($(this).attr('data-value'));
                    
                      var dataChange = $('#absd-form-'+formName+'-'+fieldID+'-state-code').attr('data-change');
                      window.absdSelectedValue = $(this).attr('data-value'); 
                      window.absdSelectedValueType = 'state'; 
                      eval(dataChange);
                    
                      $(this).addClass('absd-selected');
                  });
                
                  // Price
                  $('.absd-price').unbind('keyup');
                  $('.absd-price').bind('keyup', function(){ 
                      var price = parseFloat($(this).val());
                      
                      if(price >= 10) {
                          var feePercent = parseFloat($('#'+$(this).attr('data-id')+'-fee').attr('data-fee')),
                              networkFee  = parseFloat($('#'+$(this).attr('data-id')+'-fee').attr('data-network-fee')),
                              networkFeeType  = $('#'+$(this).attr('data-id')+'-fee').attr('data-network-fee-type'),
                              priceKey  = $(this).attr('data-type'),
                              priceType  = $(this).attr('data-key').split(priceKey+'_')[1],
                              fee = 0,
                              total = 0;

                          fee = abookingsystemdashboardForm.fee.price(abookingsystemdashboard['account_type'], price); //feePercent*price;

                          if(networkFee !== undefined 
                              && networkFee > 0) {

                              if(networkFeeType === 'percent') {
                                  fee += networkFee*price;
                              } else {
                                  fee += networkFee;
                              }
                          }

                          total = price+fee;
                          $('#'+$(this).attr('data-id')+'-fee').val(parseFloat(fee).toFixed(2));
                          $('#'+$(this).attr('data-id')+'-final').val(parseFloat(total).toFixed(2));

                          if($(this).attr('data-key') !== undefined) {
                              abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify(priceKey, priceType, price);
                          }
                      }
                      
                  });
                
                  // Final Price
                  $('.absd-final-price').unbind('keyup');
                  $('.absd-final-price').bind('keyup', function(){ 
                      var total = parseFloat($(this).val());
                      
                      if((abookingsystemdashboard['account_type'] === 'free'
                          && total >= 11)
                        || (abookingsystemdashboard['account_type'] === 'pro'
                            && total >= 10.5)) {
                          var feePercent = abookingsystemdashboardForm.fee.percent(abookingsystemdashboard['account_type'], total)/100, //parseFloat($('#'+$(this).attr('data-id')+'-fee').attr('data-fee')),
                              networkFee  = parseFloat($('#'+$(this).attr('data-id')+'-fee').attr('data-network-fee')),
                              networkFeeType  = $('#'+$(this).attr('data-id')+'-fee').attr('data-network-fee-type'),
                              networkFeePrice = 0,
                              priceKey  = $(this).attr('data-type'),
                              priceType  = $(this).attr('data-key').split(priceKey+'_')[1],
                              fee = 0,
                              price = 0;

                          if(networkFee !== undefined 
                              && (networkFee > 0
                                  || feePercent > 0)) {

                              if(networkFeeType === 'percent') {
                                  price = total/(1+feePercent+networkFee);
                                  fee = total-price;
                              } else {
                                  price = (total-networkFee)/(1+feePercent);
                                  fee = total-price;
                              }
                          }

                          $('#'+$(this).attr('data-id')+'-fee').val(parseFloat(fee).toFixed(2));
                          $('#'+$(this).attr('data-id')).val(parseFloat(price).toFixed(2));

                          if($(this).attr('data-key') !== undefined) {
                              abookingsystemdashboardCalendars.calendar.setup.view.content.availability.modify(priceKey, priceType, parseFloat(price).toFixed(2));
                          }
                      }
                      
                  });
                  
                  // Map
                  abookingsystemdashboardForm.fields.field.map();
                  
                  // Image
//                  $('#absd-image-upload-data').on("change", abookingsystemdashboardForm.fields.field.imageChanged);
                  
                  $('#absd-image-upload').unbind('click');
                  $('#absd-image-upload').bind('click', function(e){
                      e.preventDefault();
                      abookingsystemMediaLibrary.open();
                  });
                  
                  if(abookingsystemMediaLibrary !== undefined) {
                      abookingsystemMediaLibrary.on('select', function() {

                        // write your handling code here.
                        var selectedImages = abookingsystemMediaLibrary.state().get( 'selection' );

                            selectedImages.each(function(attachment) {
                                abookingsystemdashboardForm.fields.field.image(attachment.attributes);
                            });

                        // Probably send the image IDs to the backend using ajax?
                      });

                      abookingsystemMediaLibrary.on('open', function() {
                            // Used for defining the image selections in the media library.
                            var selectedImages = abookingsystemMediaLibrary.state().get( 'selection' );
                      });
                  }
                
                  // Datepicker
                  if($('input').hasClass('absd-date')) {
                      $('.absd-date').datepicker({
                        format: 'yy-mm-dd',
                        minDate: 0,
                        monthNames: [absdashboardtext['january'],absdashboardtext['february'],absdashboardtext['march'],absdashboardtext['april'],absdashboardtext['may'],absdashboardtext['june'],absdashboardtext['july'],absdashboardtext['august'],absdashboardtext['september'],absdashboardtext['october'],absdashboardtext['november'],absdashboardtext['december']],
                        monthNamesShort: [absdashboardtext['january'].slice(0,3),absdashboardtext['february'].slice(0,3),absdashboardtext['march'].slice(0,3),absdashboardtext['april'].slice(0,3),absdashboardtext['may'].slice(0,3),absdashboardtext['june'].slice(0,3),absdashboardtext['july'].slice(0,3),absdashboardtext['august'].slice(0,3),absdashboardtext['september'].slice(0,3),absdashboardtext['october'].slice(0,3),absdashboardtext['november'].slice(0,3),absdashboardtext['december'].slice(0,3)]
                      });

                      $('.absd-date').each(function() {
                          var altField = '#'+$(this).attr('id').split('-date')[0],
                              type = $(this).attr('id').indexOf('check_in') !== -1 ? 'check_in':'check_out';

                          $(this).datepicker('option', 'altField', altField);
                          $(this).datepicker('option', 'altFormat', 'yy-mm-dd');
                      });
                  }
              },
              get: function(formName, data){
                  var value = -999999999999999;
                
                  if(data['type'] === 'checkbox') {
                
                      value = $('#absd-form-'+formName+'-'+data['name']+'-checkbox-value').val();
                      value = value.indexOf('[') !== -1 ? value.split('[').join(''):value;
                      value = value.indexOf(']') !== -1 ? value.split(']').join(''):value;
                      
                      if(!abookingsystemdashboardForm.fields.field.validation(value, formName, data)) {
                          value = -999999999999999;
                      } else {
                          value = '['+value+']';
                      }
                  } else if(data['type'] === 'phone') {
                      
                      if(abookingsystemdashboardForm.fields.field.validation($('#absd-form-'+formName+'-'+data['name']).val(), formName, data)) {
                          value = $('#absd-form-'+formName+'-'+data['name']+'-country-code').val()+'@'+$('#absd-form-'+formName+'-'+data['name']).val();
                      }
                  } else if(data['type'] === 'country_state') {
                      
                      if(abookingsystemdashboardForm.fields.field.validation($('#absd-form-'+formName+'-'+data['name']+'-country-code').val(), formName, data)) {
                          value = $('#absd-form-'+formName+'-'+data['name']+'-country-code').val()+'@'+$('#absd-form-'+formName+'-'+data['name']+'-state-code').val();
                      }
                  } else {
                     
                      if(abookingsystemdashboardForm.fields.field.validation($('#absd-form-'+formName+'-'+data['name']).val(), formName, data)) {
                          value = $('#absd-form-'+formName+'-'+data['name']).val();
                      }
                  }
                
                  return value;
              }, 
              validation: function(value, formName, data){
                  var valid = true;
                  
                  // Required
                  if(data['required'] === 'true'
                    && value.length < 1) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-required'), absdashboardtext['error_is_required']);
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Email
                  if(data['is_email'] === 'true'
                    && !abookingsystemdashboardForm.fields.field.check.is_email(value)
                    && valid) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-email'), absdashboardtext['error_is_email']);
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Phone
                  if(data['is_phone'] === 'true'
                    && !abookingsystemdashboardForm.fields.field.check.is_phone(value)
                    && valid) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-phone'), absdashboardtext['error_is_phone']);
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Iban
                  if(data['is_iban'] === 'true'
                    && !abookingsystemdashboardForm.fields.field.check.is_iban(value)) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-iban'), absdashboardtext['error_is_iban']);
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Swift
                  if(data['is_swift'] === 'true'
                    && !abookingsystemdashboardForm.fields.field.check.is_swift(value)) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-swift'), absdashboardtext['error_is_swift']);
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Lower Than
                  if(data['lower_than'] !== undefined
                    && !abookingsystemdashboardForm.fields.field.check.is_lower(value, data['lower_than'])) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-lower'), absdashboardtext['error_is_lower_than'], (data['lower_than'] !== undefined ? data['lower_than']:''));
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Higher Than
                  if(data['higher_than'] !== undefined
                    && !abookingsystemdashboardForm.fields.field.check.is_higher(value, data['higher_than'])) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-higher'), absdashboardtext['error_is_higher_than'], (data['higher_than'] !== undefined ? data['higher_than']:''));
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Same with
                  if(data['same_with'] !== undefined
                    && value !== $('#absd-form-'+formName+'-'+data['same_with']).val()){
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-same-with'));
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                  
                  // Exist
                  if(data['exist'] !== undefined
                    && data['exist'] === 'true'
                    && value === data['exist_value']){
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-exist'));
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Is URL
                  if(data['is_url'] !== undefined
                     && data['is_url'] === 'true'
                     && value !== ''
                     && !abookingsystemdashboardForm.fields.field.check.is_url(value)) {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-url'));
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Terms
                  if(data['terms'] !== undefined
                     && data['terms'] === 'true'
                     && value !== ''
                     && value === 'false') {
                      abookingsystemdashboardForm.fields.field.error($('#absd-form-'+formName+'-'+data['name']+'-errors .absd-error-terms'));
                      $('#absd-form-'+formName+'-'+data['name']+'-errors').removeClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').addClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').addClass('absd-error');
                      abookingsystemdashboardForm['erros']++;
                      valid = false;
                  }
                
                  // Remove error if is ok
                  if(valid) {
//                       $('#absd-form-'+formName+'-'+data['name']+'-errors').addClass('absd-invisible');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-input').removeClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'.absd-textarea').removeClass('absd-error');
                      $('#absd-form-'+formName+'-'+data['name']+'-select.absd-select').removeClass('absd-error');
                  }
                
                  return valid;
              },
              check: {
                  is_email: function(email){ 
                      var re = /\S+@\S+\.\S+/;
                      return re.test(email);
                  },
                  is_phone: function(phone){
                      var reg = /^([+|\d])+([\s|\d])+([\d])$/;
                      return reg.test(phone);
                  },
                  /*
                   * Returns 1 if the IBAN is valid 
                   * Returns FALSE if the IBAN's length is not as should be (for CY the IBAN Should be 28 chars long starting with CY )
                   * Returns any other number (checksum) when the IBAN is invalid (check digits do not match)
                   */
                  is_iban: function(input) {
                      var CODE_LENGTHS = {
                          AD: 24, AE: 23, AT: 20, AZ: 28, BA: 20, BE: 16, BG: 22, BH: 22, BR: 29,
                          CH: 21, CR: 21, CY: 28, CZ: 24, DE: 22, DK: 18, DO: 28, EE: 20, ES: 24,
                          FI: 18, FO: 18, FR: 27, GB: 22, GI: 23, GL: 18, GR: 27, GT: 28, HR: 21,
                          HU: 28, IE: 22, IL: 23, IS: 26, IT: 27, JO: 30, KW: 30, KZ: 20, LB: 28,
                          LI: 21, LT: 20, LU: 20, LV: 21, MC: 27, MD: 24, ME: 22, MK: 19, MR: 27,
                          MT: 31, MU: 30, NL: 18, NO: 15, PK: 24, PL: 28, PS: 29, PT: 25, QA: 29,
                          RO: 24, RS: 22, SA: 24, SE: 24, SI: 19, SK: 24, SM: 27, TN: 24, TR: 26
                      };
                      var iban = String(input).toUpperCase().replace(/[^A-Z0-9]/g, ''), // keep only alphanumeric characters
                              code = iban.match(/^([A-Z]{2})(\d{2})([A-Z\d]+)$/), // match and capture (1) the country code, (2) the check digits, and (3) the rest
                              digits;
                      // check syntax and length
                      if (!code || iban.length !== CODE_LENGTHS[code[1]]) {
                          return false;
                      }
                      // rearrange country code and check digits, and convert chars to ints
                      digits = (code[3] + code[1] + code[2]).replace(/[A-Z]/g, function (letter) {
                          return letter.charCodeAt(0) - 55;
                      });
                      // final check
                      return abookingsystemdashboardForm.fields.field.check.mod97(digits);
                  },
                  mod97: function (string) {
                      var checksum = string.slice(0, 2), fragment;
                      for (var offset = 2; offset < string.length; offset += 7) {
                          fragment = String(checksum) + string.substring(offset, offset + 7);
                          checksum = parseInt(fragment, 10) % 97;
                      }
                      return checksum;
                  },
                  is_swift: function(value) {
                      return /^([A-Z]{6}[A-Z2-9][A-NP-Z1-2])(X{3}|[A-WY-Z0-9][A-Z0-9]{2})?$/.test(value.toUpperCase());
                  },
                  is_lower: function(value, thanValue) {
                      return value <= thanValue ? true:false;
                  },
                  is_higher: function(value, thanValue) {
                      return value >= thanValue ? true:false;
                  },
                  is_url: function(str) {
                      var pattern = new RegExp('((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ // domain name
                      '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                      '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                      '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                      '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
                      return pattern.test(str);
                  }
              },
              error: function(box, text, data){
                  
                  if(data !== undefined) {
                      text = text.split('%s').join(data);
                  }
                  
                  box.html(text).removeClass('absd-invisible');
              }
          }
      },
      fee: {
          comissions: function(type){
              var commisions_data = [];

                switch(type) {
                  case "pro":
                      commisions_data = [{"price_min": 10,
                                          "price_max": 25.99,
                                          "percent_fee": 5},
                                         {"price_min": 26,
                                          "price_max": 50.99,
                                          "percent_fee": 4.7},
                                         {"price_min": 51,
                                          "price_max": 100.99,
                                          "percent_fee": 4.4},
                                         {"price_min": 101,
                                          "price_max": 200.99,
                                          "percent_fee": 4.1},
                                         {"price_min": 201,
                                          "price_max": 400.99,
                                          "percent_fee": 3.8},
                                         {"price_min": 401,
                                          "price_max": 800.99,
                                          "percent_fee": 3.5},
                                         {"price_min": 801,
                                          "price_max": 1600.99,
                                          "percent_fee": 3.2},
                                         {"price_min": 1601,
                                          "price_max": 3200.99,
                                          "percent_fee": 2.9},
                                         {"price_min": 3201,
                                          "price_max": 6400.99,
                                          "percent_fee": 2.6},
                                         {"price_min": 6401,
                                          "percent_fee": 2.5}];
                      break;
                  case "free":
                      commisions_data = [{"price_min": 10,
                                          "price_max": 25.99,
                                          "percent_fee": 10},
                                         {"price_min": 26,
                                          "price_max": 50.99,
                                          "percent_fee": 9.5},
                                         {"price_min": 51,
                                          "price_max": 100.99,
                                          "percent_fee": 9},
                                         {"price_min": 101,
                                          "price_max": 200.99,
                                          "percent_fee": 8.5},
                                         {"price_min": 201,
                                          "price_max": 400.99,
                                          "percent_fee": 8},
                                         {"price_min": 401,
                                          "price_max": 800.99,
                                          "percent_fee": 7.5},
                                         {"price_min": 801,
                                          "price_max": 1600.99,
                                          "percent_fee": 7},
                                         {"price_min": 1601,
                                          "price_max": 3200.99,
                                          "percent_fee": 6.5},
                                         {"price_min": 3201,
                                          "price_max": 6400.99,
                                          "percent_fee": 6},
                                         {"price_min": 6401,
                                          "percent_fee": 5.5}];
                      break;
                  default:
                      commisions_data = [{"price_min": 10,
                                          "price_max": 25.99,
                                          "percent_fee": 10},
                                         {"price_min": 26,
                                          "price_max": 50.99,
                                          "percent_fee": 9.5},
                                         {"price_min": 51,
                                          "price_max": 100.99,
                                          "percent_fee": 9},
                                         {"price_min": 101,
                                          "price_max": 200.99,
                                          "percent_fee": 8.5},
                                         {"price_min": 201,
                                          "price_max": 400.99,
                                          "percent_fee": 8},
                                         {"price_min": 401,
                                          "price_max": 800.99,
                                          "percent_fee": 7.5},
                                         {"price_min": 801,
                                          "price_max": 1600.99,
                                          "percent_fee": 7},
                                         {"price_min": 1601,
                                          "price_max": 3200.99,
                                          "percent_fee": 6.5},
                                         {"price_min": 3201,
                                          "price_max": 6400.99,
                                          "percent_fee": 6},
                                         {"price_min": 6401,
                                          "percent_fee": 5.5}];
                      break;
                }
              return commisions_data;
          },
          price: function (type, price){
                var commisions_data = abookingsystemdashboardForm.fee.comissions(type),
                    price_compare = price/abookingsystemdashboardCalendars.data.currency_rate;
              
                if(price_compare >= commisions_data[0]['price_min']
                   && price_compare <= commisions_data[0]['price_max']) {
                    return commisions_data[0]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[1]['price_min']
                   && price_compare <= commisions_data[1]['price_max']) {
                    return commisions_data[1]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[2]['price_min']
                   && price_compare <= commisions_data[2]['price_max']) {
                    return commisions_data[2]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[3]['price_min']
                   && price_compare <= commisions_data[3]['price_max']) {
                    return commisions_data[3]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[4]['price_min']
                   && price_compare <= commisions_data[4]['price_max']) {
                    return commisions_data[4]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[5]['price_min']
                   && price_compare <= commisions_data[5]['price_max']) {
                    return commisions_data[5]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[6]['price_min']
                   && price_compare <= commisions_data[6]['price_max']) {
                    return commisions_data[6]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[7]['price_min']
                   && price_compare <= commisions_data[7]['price_max']) {
                    return commisions_data[7]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[8]['price_min']
                   && price_compare <= commisions_data[8]['price_max']) {
                    return commisions_data[8]['percent_fee']/100*price;
                }

                if(price_compare >= commisions_data[0]['price_min']) {
                    return commisions_data[9]['percent_fee']/100*price;
                }
              
                return commisions_data[0]['percent_fee']/100*price;
          },
          percent: function (type, total){
                var commisions_data = abookingsystemdashboardForm.fee.comissions(type),
                    found = false,
                    percent = 10,
                    fee = 0,
                    pp_price = 0,
                    pp_price_compare = 0;

                pp_price = (total*100)/(100+commisions_data[9]['percent_fee']);
                pp_price_compare = total/abookingsystemdashboardCalendars.data.currency_rate;
              
                if(pp_price_compare >= commisions_data[9]['price_min']
                   && !found) {
                    found = true;
                    return commisions_data[9]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[8]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[8]['price_min']
                   && pp_price_compare <= commisions_data[8]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[8]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[7]['percent_fee']);
              
                if(pp_price >= commisions_data[7]['price_min']
                   && pp_price <= commisions_data[7]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[7]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[6]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[6]['price_min']
                   && pp_price_compare <= commisions_data[6]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[6]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[5]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[5]['price_min']
                   && pp_price_compare <= commisions_data[5]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[5]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[4]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[4]['price_min']
                   && pp_price_compare <= commisions_data[4]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[4]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[3]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[3]['price_min']
                   && pp_price_compare <= commisions_data[3]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[3]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[2]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[2]['price_min']
                   && pp_price_compare <= commisions_data[2]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[2]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[1]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[1]['price_min']
                   && pp_price_compare <= commisions_data[1]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[1]['percent_fee'];
                }

                pp_price = (total*100)/(100+commisions_data[0]['percent_fee']);
              
                if(pp_price_compare >= commisions_data[0]['price_min']
                   && pp_price_compare <= commisions_data[0]['price_max']
                   && !found) {
                    found = true;
                    return commisions_data[0]['percent_fee'];
                }
          }
      },
      language: {
          show: function(){
            var languages = abookingsystemdashboard['languages'] !== undefined ? JSON.parse(abookingsystemdashboard['languages']):[];
              
            if(languages.length > 1){
                delete languages[0];
            }
            // change Language
            var changeLanguageForm = {
                name: "change_language",
                fields: [{
                    label: absdashboardtext['language'],
                    name: "language",
                    value: abookingsystemdashboard['language'] !== undefined ? abookingsystemdashboard['language']:languages[0] !== undefined ? languages[0]['value']:'en',    // default value
                    placeholder: "",  
                    required: "true",
                    allowed_characters: "",
                    min_chars: 0,     // 0 - disabled
                    max_chars: 0,     // 0 - disabled
                    is_email: "false",
                    is_phone: "false",
                    type: "select",                          // text, textarea, select, radio, checkbox, password
                    options: languages,     // select options
                    label_class: "",
                    input_class: "",
                    hint: "",
                    label_position: "left"              // left, right, left_full, right_full
                  }]
              };

              $('#absd-popup').css('display', 'block');
              // Start Form
              abookingsystemdashboardInfo.start(absdashboardtext['my_account'],
                               changeLanguageForm,
                               absdashboardtext['save'],
                               absdashboardtext['cancel'],
                               abookingsystemdashboardForm.language.change,
                               abookingsystemdashboardForm.language.close,
                               'absd-selected');
          },
          change: function(){
              
            var fields = abookingsystemdashboardForm.fields.get();
        
            if(fields !== "error"){
                
                // Start Loader
                abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                   absdashboardtext['wait']);
                
                var url = new URL(window.location.href);
                url.searchParams.set('lang', fields['language']);
                window.location.href = url;
            }
          },
          close: function(){
              $('#absd-popup').css('display', 'none');
               abookingsystemdashboardInfo.stop();
          }
      }
  };
  
  window.abookingsystemdashboardForm = abookingsystemdashboardForm;
  
})(jQuery);