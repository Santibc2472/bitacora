
(function($){ 
    if (typeof tinymce === 'undefined'
       || tinymce === undefined
       || tinymce === null){
        return false;
    }
  
    if(typeof abookingsystemdashboard['main_calendars'] !== 'undefined') {
        var main_calendars = JSON.parse(abookingsystemdashboard['main_calendars']);

        if (main_calendars[0] === undefined) {
            return false;
        }
    } else {
        return false;
    }

    tinymce.create('tinymce.plugins.BOOKEUCOM', {
        init:function(ed, url){
            
            // ADD Button
            ed.addButton('BOOKEUCOM', {
                text: absdashboardtext['space'],
                title: absdashboardtext['add_space'],
                classes: 'absd-bookeu-shortcode',
                onclick: function() {
                    var main_calendars = JSON.parse(abookingsystemdashboard['main_calendars']),
                        languages = JSON.parse(abookingsystemdashboard['languages']);
                    // Add Calendar
                    var addCalendarForm = {
                        name: "add_calendar",
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
                                       absdashboardtext['add_space_add'],
                                       absdashboardtext['cancel'],
                                       addShortcode);

                }
            });
    
        },

        getInfo:function(){
            return {longname  : absdashboardtext['title'],
                    author    : absdashboardtext['title'],
                    authorurl : 'https://www.book.eu.com',
                    infourl   : 'https://www.book.eu.com',
                    version   : '1.0'};
        }
    });

    tinymce.PluginManager.add('BOOKEUCOM', tinymce.plugins.BOOKEUCOM);
})(jQuery);

function addShortcode(){
      var fields = abookingsystemdashboardForm.fields.get(),
          HTML = '';

      if(fields !== "error"){
            HTML = '<div class="bookeucom">[bookeucom key='+fields['calendar']+'-'+abookingsystemdashboard['server']+' language='+fields['language']+']</div>';

            if (HTML !== '') {
                window.tinyMCE.activeEditor.selection.setContent(HTML);

                // Stop Loader
                abookingsystemdashboardLoader.stop(absdashboardtext['completed'],
                                                   absdashboardtext['refresh'],
                                                   true);
            }
      }
}