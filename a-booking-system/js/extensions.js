
(function($){
  
  var abookingsystemdashboardExtensions = {
    data: {
      extensions: "",
      page: 0,
      per_page: 10,
      search: "",    // search word
      current: {
        extension_id: 0,
        api_key: ''
      },
      deleted: {
        extension_id: 0,
        api_key: ''
      }
    },
    list: function(){
        
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                                absdashboardtext['wait']);
                                
            $.get(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request['extensions'],
                                                        is_ajax_request: true,
                                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){
                data = JSON.parse(data);
                abookingsystemdashboardExtensions.data.extensions = data.data;
              
            
                // View Extensions -> Search start
                abookingsystemdashboardExtensions.search.start();
//                
//                abookingsystemdashboardExtensions.extension.setup.view.header.start();
              
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
            
            abookingsystemdashboardExtensions['data']['current']['extension_id'] = $(this).parent().attr('data-extension-id'); 
          
            $('#absd-extension-'+abookingsystemdashboardExtensions['data']['current']['extension_id']).addClass('absd-opened');  
            
            abookingsystemdashboardExtensions.extension.setup.start();     
        });
        $('.aplusbooking-extension-action').unbind('click');
        $('.aplusbooking-extension-action').bind('click', function(){
            var element = this,
                extensionID = $(element).attr('data-extension-id'),
                extensionName = $(element).attr('data-extension-name'),
                extensionLink = $(element).attr('data-extension-link'),
                action = $(element).attr('data-action');
            abookingsystemdashboardExtensions.extension.action(extensionID, extensionName, extensionLink, action);
        });

        
    },
    extension: {
      view: function(data, installed, activated){
          var button = {
              label: absdashboardtext['extension_install'],
              action: 'install'
          };
          
          // Check if is installed
          if(installed.indexOf(data['name']) !== -1) {
              // Check if is activated
              if(activated.indexOf(data['name']) !== -1) {
                  button = {
                      label: absdashboardtext['extension_deactivate'],
                      action: 'deactivate'
                  };
              } else {
                  button = {
                      label: absdashboardtext['extension_activate'],
                      action: 'activate'
                  };
              }
          }
          var HTML = new Array();
          HTML.push('<div class="absd-ext-box extension-'+data['name']+'" id="absd-extension-'+data['id']+'" data-extension-id="'+data['id']+'">');
          HTML.push('   <div class="absd-row">');
          HTML.push('       <div class="absd-col1">');
          HTML.push('           <div class="absd-logo" style="background: url('+data['logo_link']+')"></div>');
          HTML.push('       </div>');
          HTML.push('       <div class="absd-col2">');
          HTML.push('           <h3>' + data['title'] + ' <u>'+data['version']+'.0</u><br><span>by</span> <a href="'+data['developer_link']+'"><i>'+data['developer']+'</i></a></h3>');
          HTML.push('           <p>' + data['short_description'] + '</p>');
          HTML.push('       </div>');
          HTML.push('   </div>');
          HTML.push('   <div class="absd-row">');
          HTML.push('       <div class="absd-col1">');
          HTML.push('           <div class="star-rating">'); 
          HTML.push('               <div class="star star-full" aria-hidden="true"></div>');
          HTML.push('               <div class="star star-full" aria-hidden="true"></div>');
          HTML.push('               <div class="star star-full" aria-hidden="true"></div>');
          HTML.push('               <div class="star star-full" aria-hidden="true"></div>');
          HTML.push('               <div class="star star-full" aria-hidden="true"></div>');
          HTML.push('           </div>');
          HTML.push('       </div>');
          HTML.push('       <div class="absd-col2 wp-core-ui">');
          HTML.push('           <div class="aplusbooking-extension-action '+button['action']+' button" data-action="'+button['action']+'" data-extension-link="'+data['download_link']+'" data-extension-name="'+data['name']+'" data-extension-id="'+data['id']+'">'+button['label']+'</div>');
          HTML.push('       </div>');
          HTML.push('   </div>');
          HTML.push('</div>');
        
          return HTML.join('');
      },
      action: function(id, name, download_link, action){
            // Start Loader
            abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                                                absdashboardtext['wait']);
                                
            $.post(abookingsystemdashboard_request_url, {action: abookingsystemdashboard_request[action+'_extension'],
                                                        is_ajax_request: true,
                                                        id: id,
                                                        name: name,
                                                        download_link: download_link,
                                                        ajax_ses: abookingsystemdashboard['ajax_ses']}, function(data){

                if(data === 'success'){
                    // Stop Loader
                    abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                                       absdashboardtext['refresh'],
                                                       true);
                    location.reload();
                    return false;
                }
              
            });
      }
    },
    search: {
      start: function(){
          var extensions = abookingsystemdashboardExtensions['data']['extensions'],
              searchWord = abookingsystemdashboardExtensions['data']['search'],
              page = abookingsystemdashboardExtensions['data']['page'],
              per_page = abookingsystemdashboardExtensions['data']['per_page'],
              total_items = 0,
              count_items = 0,
              start_item = (page == 0)?page:page*per_page,
              installedAndActive = JSON.parse(abookingsystemdashboard["extensions"]);
          
          $('.absd-extensions-holder').html('');
        
          for(var i in extensions){
              var HTML = new Array();
            
              // Search for word x if is not empty
              if(extensions[i]['title'].toLowerCase().indexOf(searchWord.toLowerCase()) !== -1
                 || searchWord === ''){
                      
                  count_items++;
                  if (count_items <= start_item || total_items >= per_page) { continue; }

                  if(installedAndActive['activated'].length === undefined){
                    installedAndActive['activated'] = Object.values(installedAndActive['activated']);
                  }

                  if(installedAndActive['installed'].length === undefined){
                    installedAndActive['installed'] = Object.values(installedAndActive['installed']);
                  }
                  
                  HTML.push(abookingsystemdashboardExtensions.extension.view(extensions[i], installedAndActive['installed'], installedAndActive['activated']));

                  $('.absd-extensions-holder').append(HTML.join(''));
                  total_items++;
              }
          }
          abookingsystemdashboardExtensions['data']['total_items'] = count_items;


          // Events
          abookingsystemdashboardExtensions.events(extensions);
//          abookingsystemdashboardExtensions.search.events(extensions);
//          abookingsystemdashboardExtensions.search.pagination.start(extensions);
//          abookingsystemdashboardExtensions.search.pagination.events(extensions);
      },
      events: function(){
          $('.absd-search input').unbind('keyup');
          $('.absd-search input').bind('keyup', function(){
              abookingsystemdashboardExtensions['data']['search'] = $(this).val();  
              abookingsystemdashboardExtensions['data']['page'] = 0;
              abookingsystemdashboardExtensions.search.start();
          });
      },
      pagination: {
          start: function(){  
            var page = abookingsystemdashboardExtensions['data']['page'],
              per_page = abookingsystemdashboardExtensions['data']['per_page'],
              total_items = abookingsystemdashboardExtensions['data']['total_items'],
              total_pages = Math.ceil(total_items/per_page),
              center_page = (page==0) ? 1 : ((page >= (total_pages-1)) ? page-1 : page),
              prev_page = (page==0)?page:page-1,
              next_page = (page >= total_pages-1)?page:page+1;
            
              $('.absd-pagination').html(abookingsystemdashboardExtensions.search.pagination.view(prev_page, center_page, next_page, page, total_pages));
             
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
                abookingsystemdashboardExtensions['data']['page'] = parseInt($(this).attr('data-page'));
                abookingsystemdashboardExtensions.search.start();
              }); 
          }
      }
    }
  };
  
  window.abookingsystemdashboardExtensions = abookingsystemdashboardExtensions;
  
})(jQuery);