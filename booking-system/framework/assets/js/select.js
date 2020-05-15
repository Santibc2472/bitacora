/*
 * Title                   : DOT Framework
 * File                    : framework/assets/js/select.js
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : DOT Select jQuery plugin.
 */

(function($){
    $.fn.DOTSelect = function(options){
	'use strict';
	
        /*
         * Private variables.
         */
        var Data = {}, // The data
        Container = this, // <select> HTML tag.
        
        ID = '', // Plugin ID.
        id = '', // <select> [id] attribute.
        name = '', // <select> [name] attribute.
        classes = '', // <select> [class] attribute.
        onChange = '', // <select> [onchange] attribute.
        isDisabled = false, // <select> [disabled] attribute.
        isMultiple = false, // <select> [multiple] attribute.
        thisItem = '', // Used to get [multiple] attribute.
        values = new Array(), // <select> <option> [value] attribute.
        labels = new Array(), // <select> <option> text.
        selectedOption = 0, // <select> selected option value.
        
        firstClick = false,
        wasChanged = false,

        methods = {            
                    init:function(){
                    /*
                     * Initialize jQuery plugin.
		     * 
		     * @usage
		     *	    This function is initialized when the plugin starts.
		     * 
		     * @params
		     *	    -
		     * 
		     * @post
		     *	    -
		     * 
		     * @get
		     *	    -
		     * 
		     * @sessions
		     *	    -
		     * 
		     * @cookies
		     *	    -
		     * 
		     * @constants
		     *	    -
		     * 
		     * @globals
		     *	    options (Object): // options sent to the plugin when you initialize it
		     * 
		     * @functions
		     *	    this : parse() // Parse <select> tag.
		     *	    
		     * @hooks
		     *	    -
		     * 
		     * @layouts
		     *	    -
		     * 
		     * @return
		     *	    -
		     * 
		     * @return_details
		     *	    -
		     * 
		     * @dv
		     *	    -
		     * 
		     * @tests
		     *	    -
		     */
                        return this.each(function(){
                            if (options){
                                $.extend(Data, options);
                            }
                            methods.parse();
                        });
                    },
                    parse:function(){
                    /*
                     * Parse <select> tag.
		     * 
		     * @usage
		     *	    this : parse()
		     * 
		     * @params
		     *	    -
		     * 
		     * @post
		     *	    -
		     * 
		     * @get
		     *	    -
		     * 
		     * @sessions
		     *	    -
		     * 
		     * @cookies
		     *	    -
		     * 
		     * @constants
		     *	    -
		     * 
		     * @globals
		     *	    -
		     * 
		     * @functions
		     *	    this : display() // Replace <select> with DOT Select plugin.
		     *	    this : events() // Initialize DOT Select events.
		     *	    
		     * @hooks
		     *	    -
		     * 
		     * @layouts
		     *	    -
		     * 
		     * @return
		     *	    Private variables are completed.
		     * 
		     * @return_details
		     *	    -
		     * 
		     * @dv
		     *	    -
		     * 
		     * @tests
		     *	    -
		     */
                        id = $(Container).attr('id') !== undefined ? $(Container).attr('id'):'';
                        name = $(Container).attr('name') !== undefined ? $(Container).attr('name'):'';
                        classes = $(Container).attr('class') !== undefined ? $(Container).attr('class'):'';
                        onChange = $(Container).attr('onchange') !== undefined ? $(Container).attr('onchange'):'';
                        isDisabled = $(Container).attr('disabled') !== undefined ? true:false;
                        thisItem = id !== '' ? '#'+id:'select[name*="'+name+'"]';
                        isMultiple = $(thisItem+'[multiple]').length ? true:false;
                        ID = id !== '' ? id:name;
                        
			/*
			 * Get the options' values and text.
			 */
                        $(thisItem+' option').each(function(){
                            values.push($(this).attr('value'));
                            labels.push($(this).html());
                            
                            if ($(this).is(':selected')){
                                selectedOption = values.length-1;
                            }
                        });
                        
			methods.display();
                        
                        if (!isDisabled){
                            methods.events();
                        }
                    },
                    display:function(){
                    /*
                     * Replace <select> with DOT Select plugin.
		     * 
		     * @usage
		     *	    this : init()
		     * 
		     * @params
		     *	    -
		     * 
		     * @post
		     *	    -
		     * 
		     * @get
		     *	    -
		     * 
		     * @sessions
		     *	    -
		     * 
		     * @cookies
		     *	    -
		     * 
		     * @constants
		     *	    -
		     * 
		     * @globals
		     *	    -
		     * 
		     * @functions
		     *	    -
		     *	    
		     * @hooks
		     *	    -
		     * 
		     * @layouts
		     *	    -
		     * 
		     * @return
		     *	    DOT Select HTML code is generated and <select> tag is replaced.
		     * 
		     * @return_details
		     *	    -
		     * 
		     * @dv
		     *	    -
		     * 
		     * @tests
		     *	    -
		     */
                        var HTML = new Array(), 
                        i;
                        
                        HTML.push('<div id="dot-select-'+ID+'" class="dot-select '+(isMultiple ? 'dot-select-multiple':'dot-select-single')+' '+(isDisabled ? 'dot-select-disabled':'')+' '+classes+'">');
                        HTML.push(' <input type="hidden" id="'+ID+'" name="'+name+'" value="'+(isMultiple ? '':values[selectedOption])+'">');
                        
                        /*
                         * Display "selected" component only on single select.
                         */
                        if (!isMultiple){
                            HTML.push(' <div class="dot-select-select">');
                            HTML.push('     <div class="dot-select-selection">'+(values.length !== 0 ? labels[selectedOption]:'')+'</div>');
                            HTML.push('     <div class="dot-select-icon">&#x25BE;</div>');
                            HTML.push(' </div>');
                        }
                        HTML.push(' <ul class="dot-select-list">');
                        
                        for (i=0; i<values.length; i++){
                            if (!isMultiple){
                            /*
                             * Single select options.
                             */
                                HTML.push('     <li class="dot-select-list-item'+(selectedOption === i ? ' dot-select-selected':'')+'" id="dot-select-'+ID+'-'+values[i]+'" title="'+labels[i]+'">'+labels[i]+'</li>');
                            }
                            else{
                            /*
                             * Multiple select options.
                             */
                                HTML.push('     <li class="dot-select-list-item" title="'+labels[i]+'">');
                                HTML.push('         <input type="checkbox" name="dot-select-'+ID+'-'+values[i]+'" id="dot-select-'+ID+'-'+values[i]+'" class="dot-select-checkbox"'+(isDisabled ? ' disabled="disabled"':'')+' />');
                                HTML.push('         <label for="dot-select-'+ID+'-'+values[i]+'" class="dot-select-label">'+labels[i]+'</label>');
                                HTML.push('     </li>');
                            }
                        }
                        HTML.push(' </ul>');
                        HTML.push('</div>');
                        
                        $(Container).replaceWith(HTML.join(''));
                    },
                    events:function(){
                    /*
                     * Initialize DOT Select events.
		     * 
		     * @usage
		     *	    this : init()
		     * 
		     * @params
		     *	    -
		     * 
		     * @post
		     *	    -
		     * 
		     * @get
		     *	    -
		     * 
		     * @sessions
		     *	    -
		     * 
		     * @cookies
		     *	    -
		     * 
		     * @constants
		     *	    -
		     * 
		     * @globals
		     *	    -
		     * 
		     * @functions
		     *	    -
		     *	    
		     * @hooks
		     *	    -
		     * 
		     * @layouts
		     *	    -
		     * 
		     * @return
		     *	    DOT Select events are initialized.
		     * 
		     * @return_details
		     *	    -
		     * 
		     * @dv
		     *	    -
		     * 
		     * @tests
		     *	    -
		     */
                        if (isMultiple){
                        /*
                         * Multiple select events.
                         */
                            $('#dot-select-'+ID+' .dot-select-list-item').unbind('click');
                            $('#dot-select-'+ID+' .dot-select-list-item').bind('click', function(){
                                var selected = new Array(),
                                id;
                                
                                $('#dot-select-'+ID+' .dot-select-checkbox').each(function(){
                                    if ($(this).is(':checked')){
                                        id = $(this).attr('id').split('dot-select-'+ID+'-')[1];
                                        selected.push(id);
                                    }
                                });
                                
                                $('#'+ID).val(selected)
                                         .trigger('change');

                                if (onChange !== ''){
                                    eval(onChange.replace(/this.value/g, selected));
                                }
                            });
                        }
                        else{
                        /*
                         * Single select events.
                         */ 
			    /*
			     * Hide options list when you click outside DOT Select.
			     */
                            $(document).mousedown(function(event){
                                if ($(event.target).parents('#dot-select-'+ID).length === 0){
                                    $('#dot-select-'+ID+' .dot-select-list').css('display', 'none')
									    .scrollTop(0);
                                }
                            });
                            
			    /*
			     * Display the options list.
			     */
                            $('#dot-select-'+ID+' .dot-select-select').unbind('click');
                            $('#dot-select-'+ID+' .dot-select-select').bind('click', function(){
                                if ($('#dot-select-'+ID+' .dot-select-list').css('display') === 'block'){
                                    $('#dot-select-'+ID+' .dot-select-list').css('display', 'none')
									    .scrollTop(0);
                                }
                                else{
                                    var scrollTo;
                                    
                                    $('.dot-select.dot-select-single .dot-select-list').css('display', 'none');
                                    $('#dot-select-'+ID+' .dot-select-list').css('display', 'block');
                                    
                                    /*
                                     * Duplicate scrollTo action for the right position.
                                     */
                                    scrollTo = $('#dot-select-'+ID+' .dot-select-list-item.dot-select-selected').position().top-$('#dot-select-'+ID+' .dot-select-list-item.dot-select-selected').height();
                                    $('#dot-select-'+ID+' .dot-select-list').scrollTop(scrollTo);
                                    
                                    if (wasChanged 
                                            || firstClick){
                                        scrollTo = $('#dot-select-'+ID+' .dot-select-list-item.dot-select-selected').position().top-$('#dot-select-'+ID+' .dot-select-list-item.dot-select-selected').height();
                                        $('#dot-select-'+ID+' .dot-select-list').scrollTop(scrollTo);
                                    }
                                    
                                    if (!firstClick){
                                        firstClick = true;
                                    }
                                }
                            });

			    /*
			     * Select an option.
			     */
                            $('#dot-select-'+ID+' .dot-select-list-item').unbind('click');
                            $('#dot-select-'+ID+' .dot-select-list-item').bind('click', function(){
                                if (!$(this).hasClass('dot-select-selected')){
                                    wasChanged = true; 
                                    
                                    $('#dot-select-'+ID+' .dot-select-list-item').removeClass('dot-select-selected');
                                    $(this).addClass('dot-select-selected');
                                    $('#dot-select-'+ID+' .dot-select-selection').html($(this).html());
                                    $('#'+ID).val($(this).attr('id').split('dot-select-'+ID+'-')[1])
                                             .trigger('change');

                                    if (onChange !== ''){
                                        eval(onChange.replace(/this.value/g, "'"+$(this).attr('id').split('dot-select-'+ID+'-')[1]+"'"));
                                    }
                                }
                                $('#dot-select-'+ID+' .dot-select-list').css('display', 'none')
								        .scrollTop(0);
                            });
                        }
                    }
                  };

        return methods.init.apply(this);
    };
})(jQuery);