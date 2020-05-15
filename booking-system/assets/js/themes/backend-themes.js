
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/themes/backend-themes.js
* File Version            : 1.0.4
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end themes JavaScript class.
*/

var DOPBSPBackEndThemes = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
        
    /*
     * Constructor
     */
    this.__construct = function(){
    };
    
    /*
     * Display themes.
     */
    this.display = function(){
        DOPBSPBackEnd.clearColumns(1);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));

        $.post(ajaxurl, {action: 'dopbsp_themes_display'}, function(data){
            var content = '';
            
            data = $.trim(data);
            
            if (data === 'error'){
                DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('THEMES_LOAD_ERROR'));
            }
            else{
                content = data.split(';;;;;;;');

                $('#DOPBSP-column1 .dopbsp-column-content').html(content[0]);
                $('#DOPBSP-column2 .dopbsp-column-content').html(content[1]);
                $('.DOPBSP-admin .dopbsp-main').css('display', 'block');

                DOPBSPBackEndThemes.init();

                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('THEMES_LOAD_SUCCESS'));
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize themes.
     */
    this.init = function(){
        $('#DOPBSP-themes-list').isotope({layoutMode: 'fitRows',
                                          transitionDuration: 0});
        
        DOPBSPBackEndThemes.events();
    };
    
    /*
     * Initialize themes events.
     */
    this.events = function(){
        $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper').unbind('click');
        $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper').bind('click', function(){
            var filters = new Array();
            
            if ($(this).attr('data-filter') === '.dopbsp-all'){
                $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper').removeClass('dopbsp-selected');
                $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper input[type="checkbox"]').removeAttr('checked');
            }
            else{
                $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper:first-child').removeClass('dopbsp-selected');
                $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper:first-child input[type="checkbox"]').removeAttr('checked');
            }

            if ($(this).hasClass('dopbsp-selected')){
                $(this).removeClass('dopbsp-selected');
                $('input[type="checkbox"]', this).removeAttr('checked');
            }
            else{
                $(this).addClass('dopbsp-selected');
                $('input[type="checkbox"]', this).attr('checked', 'checked');
            }

            $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper').each(function(){
                if ($(this).hasClass('dopbsp-selected')){
                    filters.push($(this).attr('data-filter'));
                }
            });

            $('#DOPBSP-themes-list').isotope({filter: filters.join('')});
        });
        
    };
    
    /*
     * Search themes.
     */
    this.search = function(){
        var filters = new Array(),
        i = 0,
        searchRegex = new RegExp($('#DOPBSP-themes-search').val(), 'gi');

        $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper').removeClass('dopbsp-selected');
        $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper input[type="checkbox"]').removeAttr('checked');
        $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper:first-child').addClass('dopbsp-selected');
        $('#DOPBSP-inputs-themes-filters-tags .dopbsp-input-wrapper:first-child input[type="checkbox"]').attr('checked', 'checked');
                
        $('#DOPBSP-themes-list .dopbsp-theme').each(function(){
            i++;
            
            if ($(this).text().match(searchRegex) !== null){
                filters.push('.dopbsp-theme-'+i);
            }
        });
        
        $('#DOPBSP-themes-list').isotope({filter: (filters.length > 0 ? filters.join(','):true)});
    };
    
    return this.__construct();
};