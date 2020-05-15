
/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : assets/js/addons/backend-addons.js
* File Version            : 1.0.3
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end addons JavaScript class.
*/

var DOPBSPBackEndAddons = new function(){
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
     * Display addons.
     */
    this.display = function(){
        DOPBSPBackEnd.clearColumns(1);
        DOPBSPBackEnd.toggleMessages('active', DOPBSPBackEnd.text('MESSAGES_LOADING'));

        $.post(ajaxurl, {action: 'dopbsp_addons_display'}, function(data){
            var content = '';
            
            data = $.trim(data);
            
            if (data === 'error'){
                DOPBSPBackEnd.toggleMessages('error', DOPBSPBackEnd.text('ADDONS_LOAD_ERROR'));
            }
            else{
                content = data.split(';;;;;;;');

                $('#DOPBSP-column1 .dopbsp-column-content').html(content[0]);
                $('#DOPBSP-column2 .dopbsp-column-content').html(content[1]);
                $('.DOPBSP-admin .dopbsp-main').css('display', 'block');
                DOPBSPBackEnd.toggleMessages('success', DOPBSPBackEnd.text('ADDONS_LOAD_SUCCESS'));
            }
        }).fail(function(data){
            DOPBSPBackEnd.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Set addons category.
     */
    this.category = function(key){
        $('#DOPBSP-addons-search').val('');
        $('#DOPBSP-column2 .dopbsp-column-content .dopbsp-addon').css('display', 'block');
        
        if ($('#DOPBSP-inputs-button-addons-category-'+key).parent().hasClass('dopbsp-hide')){
            $('#DOPBSP-addons-category-'+key).removeAttr('checked');
        }
        else{
            $('#DOPBSP-addons-category-'+key).attr('checked', 'checked');
        }
        DOPBSPBackEnd.toggleInputs('addons-category-'+key);
    };
    
    /*
     * Search addons.
     */
    this.search = function(){
        var searchRegex = new RegExp($('#DOPBSP-addons-search').val(), 'gi');
                
        $('#DOPBSP-column2 .dopbsp-column-content .dopbsp-addon').each(function(){
            $(this).css('display', $(this).text().match(searchRegex) !== null ? 'block':'none');
        });
        
        $('#DOPBSP-column2 .dopbsp-addons-list').each(function(){
            var key = $(this).parent().attr('id').split('DOPBSP-inputs-addons-category-')[1],
            noAddons = 0,
            $parent = $('#DOPBSP-inputs-button-addons-category-'+key).parent();
            
            $('li', this).each(function(){
                $(this).css('display') === 'block' ? noAddons++:'';
            });
            
            if (noAddons === 0){
                if ($parent.hasClass('dopbsp-hide')){
                    $parent.removeClass('dopbsp-hide')
                           .addClass('dopbsp-display');
                    $('#DOPBSP-addons-category-'+key).removeAttr('checked');
                    $('#DOPBSP-inputs-addons-category-'+key).css('display', 'none');
               }
            }
            else{
                if ($parent.hasClass('dopbsp-display')){
                    $parent.removeClass('dopbsp-display')
                           .addClass('dopbsp-hide');
                    $('#DOPBSP-addons-category-'+key).attr('checked', 'checked');
                    $('#DOPBSP-inputs-addons-category-'+key).css('display', 'block');
               }
            }
        });
    };
    
    return this.__construct();
};