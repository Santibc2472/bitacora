
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : assets/js/backend-shortcodes.php
* File Version            : 1.0.3
* Created / Last Modified : 25 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end shortcodes (TinyMCE editor plugin).
*/

(function(){
    var calendars = new Array(),
        calendarsData,
        i,
        title = 'Pinpoint Booking System',
        languages = new Array(),
        languagesData,
        windowHTML = new Array(),
        formHTML = new Array();
        
    if (typeof DOPBSP_tinyMCE_data === 'undefined'
            || typeof tinymce === 'undefined'){
        return false;
    }

    tinymce.create('tinymce.plugins.DOPBSP', {
        init:function(ed, url){
            var calendarsData = DOPBSP_tinyMCE_data.split(';;;;;')[1],
                calendars = calendarsData.split(';;;'),
                Calendar = DOPBSP_tinyMCE_data.split(';;;;;')[2],
                selectCalendar = DOPBSP_tinyMCE_data.split(';;;;;')[3],
                Language = DOPBSP_tinyMCE_data.split(';;;;;')[4],
                selectLanguage = DOPBSP_tinyMCE_data.split(';;;;;')[5],
                languagesData = DOPBSP_tinyMCE_data.split(';;;;;')[6],
                languages = languagesData.split(';;;'),
                selectedLanguage = DOPBSP_language;
            
            if (parseFloat(WP_version) > 3.8){ 
                var valueNew = '',
                valueALL = [];
                // GET Calendars
                for (i=0; i<calendars.length; i++){
                    if (calendars[i] !== ''){
                        valueALL.push('<option value="'+calendars[i].split(';;')[0]+'">ID: '+calendars[i].split(';;')[0]+": "+calendars[i].split(';;')[1]+'</option>');
                    }
                }
                // GET Languages
                var langValueNew = '',
                langValueALL = [];

                for (i=0; i<languages.length; i++){
                    if (languages[i] !== ''){
                        langValueALL.push('<option value="'+languages[i].split(';;')[0]+'">'+languages[i].split(';;')[1]+'</option>');
                    }
                }
                // ADD Button
                ed.addButton('DOPBSP', {
                    title: title,
                    image: DOPBSP_PATH+'assets/gui/images/icon-add.png',
                    onclick: function() {
                        
                        formHTML.push('   <div class="DOPBSP-window-title">'+title+'</div>');
                        formHTML.push('   <select id="DOPBSP-select-element" onchange="dopbspChangeElement(this);">');
                        formHTML.push('       <option value="none">Select element</option>');
                        formHTML.push('       <option value="calendar">Calendar</option>');
                        formHTML.push('       <option value="search" disabled="disabled">Search - Only in PRO</option>');
                        formHTML.push('   </select>');
                        formHTML.push('   <select id="DOPBSP-select-calendar" onchange="dopbspChangeElement(this);" class="dopbsp-hide">');
                        formHTML.push('       <option value="none">Select calendar</option>');
                        formHTML.push(        valueALL.join(''));
                        formHTML.push('   </select>');
                        formHTML.push('   <select id="DOPBSP-select-language" onchange="dopbspChangeElement(this);" class="dopbsp-hide">');
                        formHTML.push('       <option value="none">Select language</option>');
                        formHTML.push(        langValueALL.join(''));
                        formHTML.push('   </select>');
                        formHTML.push('   <div id="DOPBSP-buttons">');
                        formHTML.push('       <div id="DOPBSP-view-mode-container" class="dopbsp-hide">');
                        formHTML.push('         <input type="checkbox" id="DOPBSP-view-mode" value="true"> View only');
                        formHTML.push('       </div>');
                        formHTML.push('       <a href="#" id="DOPBSP-add" class="DOPBSP-button dopbsp-hide" onclick="dopbspInsertShortcode();"><span>Add</span></a>');
                        formHTML.push('       <a href="#" class="DOPBSP-button" onclick="dopbspCancelShortcode();"><span>Cancel</span></a>');
                        formHTML.push('   </div>');

                        windowHTML.push('<div class="DOPBSP-window-background"></div>');
                        windowHTML.push('<div class="DOPBSP-window">');
                        windowHTML.push('</div>');
                        
                        jQuery('body').append(windowHTML.join(''));
                        jQuery('.DOPBSP-window').html('');
                        jQuery('.DOPBSP-window').append(formHTML.join(''));
                        jQuery('.DOPBSP-window-background').fadeIn(300);
                        jQuery('.DOPBSP-window').animate({'top':'80px'},500);
                        formHTML = new Array();
                        windowHTML = new Array();
                        
                    }
                });
            }
    
        },

        createControl:function(n, cm){// Init Combo Box.
            
            if (parseFloat(WP_version) < 3.9) { 
                
                switch (n){
                    case 'DOPBSP':
                        if (calendarsData !== ''){
                            var mlb = cm.createListBox('DOPBSP', {
                                 title: title,
                                 onselect: function(value){
                                     tinyMCE.activeEditor.selection.setContent(value);
                                 }
                            });

                            for (i=0; i<calendars.length; i++){
                                if (calendars[i] !== ''){
                                    mlb.add('ID '+calendars[i].split(';;')[0]+': '+calendars[i].split(';;')[1], '[dopbsp id="'+calendars[i].split(';;')[0]+'"]');
                                }
                            }

                            return mlb;
                        }
                }
                
            }

            return null;
        },

        getInfo:function(){
            return {longname  : 'Pinpoint Booking System',
                    author    : 'Dot on Paper',
                    authorurl : 'http://www.dotonpaper.net',
                    infourl   : 'http://www.dotonpaper.net',
                    version   : '1.0'};
        }
    });

    tinymce.PluginManager.add('DOPBSP', tinymce.plugins.DOPBSP);
})();

function dopbspInsertShortcode(){
    var element = 'calendar',
        calendar = jQuery('#DOPBSP-select-calendar').val(),
        language = jQuery('#DOPBSP-select-language').val(),
        viewMode = jQuery('#DOPBSP-view-mode').is(':checked') ? true:false,
        shortcodeHML = '';

        if (element === 'calendar') {
            shortcodeHML = '[dopbsp id="'+calendar+'" '+(viewMode === true ? 'view="true"':'')+' lang="'+language+'"]';
        }
        
        if (shortcodeHML !== '') {
            window.tinyMCE.activeEditor.selection.setContent(shortcodeHML);
        }
        
        jQuery('.DOPBSP-window-background').fadeOut(300);
        jQuery('.DOPBSP-window').animate({'top':'-180px'},500, function(){
            jQuery('.DOPBSP-window').remove();
            jQuery('.DOPBSP-window-background').remove();
        });
}

function dopbspChangeElement(el){
    jQuery(el).val(el.value);
    var element = jQuery('#DOPBSP-select-element').val(),
        calendar = jQuery('#DOPBSP-select-calendar').val(),
        language = jQuery('#DOPBSP-select-language').val();
    
    if (element !== 'none') {

        if (element === 'calendar') {
            // SHOW ELEMENTS
            jQuery('#DOPBSP-select-calendar').removeClass('dopbsp-hide');
            jQuery('#DOPBSP-select-language').removeClass('dopbsp-hide');
            jQuery('#DOPBSP-view-mode-container').removeClass('dopbsp-hide');

            if (calendar !== 'none' && language !== 'none' ){
               jQuery('#DOPBSP-add').removeClass('dopbsp-hide');
            } else {
                // dopbsp-hide add
                jQuery('#DOPBSP-add').addClass('dopbsp-hide');
            }

        }
    } else {
        // dopbsp-hide ELEMENTS
        jQuery('#DOPBSP-select-calendar').addClass('dopbsp-hide');
        jQuery('#DOPBSP-select-language').addClass('dopbsp-hide');
        jQuery('#DOPBSP-view-mode-container').addClass('dopbsp-hide');
        jQuery('#DOPBSP-add').addClass('dopbsp-hide');
    }
}

function dopbspCancelShortcode(){
    jQuery('.DOPBSP-window-background').fadeOut(300);
    jQuery('.DOPBSP-window').animate({'top':'-180px'},500, function(){
        jQuery('.DOPBSP-window').remove();
        jQuery('.DOPBSP-window-background').remove();
    });
}