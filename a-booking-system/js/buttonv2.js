(function($){ 
    
    var abmBtnShortcode = {
        start: function(){
            var element = $('.edit-post-header-toolbar'),
                html = [];
            
            if(element !== undefined
               && abookingsystemdashboard['main_calendars'] !== '[]'
               && abookingsystemdashboard['main_calendars'] !== undefined) {
                html.push('<div id="absd-bookeu-shortcodev2" class="absd-bookeu-shortcodev2"><button>'+absdashboardtext['space']+'</button></div>');
                
                abookingsystemdashboardDelay(function(){
                    $('.edit-post-header-toolbar').append(html.join(''));
                    abmBtnShortcode.events();
                }, 1000);
            }
        },
        shortcode: function(){
            var main_calendars = JSON.parse(abookingsystemdashboard['main_calendars']),
                languages = JSON.parse(abookingsystemdashboard['languages']);
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
                  },{
                    label: absdashboardtext['language'],
                    name: "language",
                    value: languages[0]['value'],    // default value
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

              // Start Form
              abookingsystemdashboardInfo.start(absdashboardtext['add_space_in_content'],
                               addCalendarForm,
                               'Copy '+absdashboardtext['share_wordpress'],
                               absdashboardtext['cancel'],
                               abmBtnShortcode.genShortcode);
        },
        genShortcode: function(){
            var fields = abookingsystemdashboardForm.fields.get(),
              HTML = '';

            if(fields !== "error"){
                HTML = '<div class="bookeucom">[bookeucom key='+fields['calendar']+'-'+abookingsystemdashboard['server']+' language='+fields['language']+']</div>';

                if (HTML !== '') {
                    abmBtnShortcode.copyToClipboard(HTML);

                    // Stop Loader
                    abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                     absdashboardtext['refresh'],
                                     true);
                }
            }
        },
        copyToClipboard: function(str) {
            var el = document.createElement('textarea'); 
            el.value = str;                                 
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';                 
            el.style.left = '-9999px';     
            document.body.appendChild(el);                 
            var selected =            
            document.getSelection().rangeCount > 0        
              ? document.getSelection().getRangeAt(0)     
              : false;                                    
            el.select();                                    
            document.execCommand('copy');                
            document.body.removeChild(el);                 
            if (selected) {                               
                document.getSelection().removeAllRanges();   
                document.getSelection().addRange(selected);  
            }
        },
        events: function(){
            $('#absd-bookeu-shortcodev2').unbind('click');
            $('#absd-bookeu-shortcodev2').bind('click', function(){
                
                if(abookingsystemdashboard['main_calendars'] !== '[]'
                   && abookingsystemdashboard['main_calendars'] !== undefined) {
                    abmBtnShortcode.shortcode();
                }
            });
        }
    };
    
    $(document).ready(function(){
        abmBtnShortcode.start();
    });
    
})(jQuery);