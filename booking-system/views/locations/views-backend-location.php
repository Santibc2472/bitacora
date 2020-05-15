<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.2
* File                    : views/locations/views-backend-location.php
* File Version            : 1.0.5
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end location views class.
*/

    if (!class_exists('DOPBSPViewsBackEndLocation')){
        class DOPBSPViewsBackEndLocation extends DOPBSPViewsBackEndLocations{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns location.
             * 
             * @param args (array): function arguments
             *                      * id (integer): location ID
             *                      * language (string): location language
             * 
             * @return location HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                
                $location = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->locations.' WHERE id=%d',
                                                          $id));
?>
                <div class="dopbsp-inputs-wrapper">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('LOCATIONS_LOCATION_NAME'),
                                              'value' => $location->name,
                                              'location_id' => $location->id,
                                              'help' => $DOPBSP->text('LOCATIONS_LOCATION_NAME_HELP'),
                                              'container_class' => 'dopbsp-last'));
?>
                </div>
<?php           
                
                $this->templateMap($location);
                $this->templateCalendars($location);
                $this->templateShare($location);
            }
            
            /*
             * Returns location map template.
             * 
             * @param location (object): location data
             * 
             * @return map HTML
             */
            function templateMap($location){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('LOCATIONS_LOCATION_MAP'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('location-map')" id="DOPBSP-inputs-button-location-map" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-location-map" class="dopbsp-inputs-wrapper">
                    <!--
                        Location
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-location-address"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_ADDRESS'); ?></label>
                        <input type="text" name="DOPBSP-location-address" id="DOPBSP-location-address" value="<?php echo $location->address; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndLocation.edit('<?php echo $location->id; ?>', 'text', 'address', this.value); DOPBSPBackEndLocationMapHints.display();}" onpaste="DOPBSPBackEndLocation.edit('<?php echo $location->id; ?>', 'text', 'address', this.value); DOPBSPBackEndLocationMapHints.display();" onblur="DOPBSPBackEndLocation.edit('<?php echo $location->id; ?>', 'text', 'address', this.value, true); setTimeout(function(){DOPBSPBackEndLocationMapHints.clear();}, 300);" />
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_ADDRESS_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                    
                    <!--
                        Hints
                    -->
                    <ul id="DOPBSP-location-address-hints">
                        <li></li>
                    </ul>
                    
                    <!--
                        Coordinates
                    -->
                    <input type="hidden" name="DOPBSP-location-coordinates" id="DOPBSP-location-coordinates" value="<?php echo $location->coordinates; ?>" />

                    <!--
                        Map
                    -->
                    <div id="DOPBSP-location-address-map"></div>
<?php
                    
                    /*
                     * Address Alt
                     */ 
                    $this->displayTextInput(array('id' => 'address_alt',
                                                  'label' => $DOPBSP->text('LOCATIONS_LOCATION_ALT_ADDRESS'),
                                                  'value' => $location->address_alt,
                                                  'location_id' => $location->id,
                                                  'help' => $DOPBSP->text('LOCATIONS_LOCATION_ALT_ADDRESS_HELP'),
                                                  'container_class' => 'dopbsp-last'));   
                
?>
                </div>
<?php                
            }
            
            /*
             * Returns location calendars template.
             * 
             * @param location (object): location data
             * 
             * @return calendars HTML
             */
            function templateCalendars($location){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-last dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('LOCATIONS_LOCATION_CALENDARS'); ?></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('location-calendars')" id="DOPBSP-inputs-button-location-calendars" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-location-calendars" class="dopbsp-inputs-wrapper">
                    <div class="dopbsp-input-wrapper">
                        <ul id="DOPBSP-location-calendars" class="dopbsp-input-list">
<?php           
                /*
                 * Calendars list.
                 */
                echo $this->listCalendars($location);
?>
                        </ul>
                    </div>
                </div>
<?php       
            }
            
            /*
             * Returns location share template.
             * 
             * @param location (object): location data
             * 
             * @return calendars HTML
             */
            function templateShare($location){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-last dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('LOCATIONS_LOCATION_SHARE'); ?><a href="https://pinpoint,world/" target="_blank">PINPOINT.WORLD</a></h3>
                    <a href="javascript:DOPBSPBackEnd.toggleInputs('location-share')" id="DOPBSP-inputs-button-location-share" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-location-share" class="dopbsp-inputs-wrapper dopbsp-last">
                    <div class="dopbsp-input-wrapper dopbsp-last">
                        <ul id="DOPBSP-location-calendars" class="dopbsp-input-list">
<?php           
		/*
		 * Link
		 */ 
		$this->displayTextInput(array('id' => 'link',
					      'label' => $DOPBSP->text('LOCATIONS_LOCATION_LINK'),
					      'value' => $location->link,
					      'location_id' => $location->id,
					      'help' => $DOPBSP->text('LOCATIONS_LOCATION_LINK_HELP'))); 
		/*
		 * Image
		 */ 
		$this->displayTextInput(array('id' => 'image',
					      'label' => $DOPBSP->text('LOCATIONS_LOCATION_IMAGE'),
					      'value' => $location->image,
					      'location_id' => $location->id,
					      'help' => $DOPBSP->text('LOCATIONS_LOCATION_IMAGE_HELP')));
		/*
		 * Businesses
		 */ 
		$this->listBusinesses($location);
		/*
		 * Other businesses.
		 */ 
		$this->displayTextInput(array('id' => 'businesses_other',
					      'label' => $DOPBSP->text('LOCATIONS_LOCATION_BUSINESSES_OTHER'),
					      'value' => $location->businesses_other,
					      'location_id' => $location->id,
					      'help' => $DOPBSP->text('LOCATIONS_LOCATION_BUSINESSES_OTHER_HELP'))); 
		/*
		 * Businesses
		 */ 
		$this->listLanguages($location);  
		/*
		 * Email
		 */ 
		$this->displayTextInput(array('id' => 'email',
					      'label' => $DOPBSP->text('LOCATIONS_LOCATION_EMAIL'),
					      'value' => $location->email,
					      'location_id' => $location->id,
					      'help' => $DOPBSP->text('LOCATIONS_LOCATION_EMAIL_HELP')));   
?>
                        </ul>
                    </div>
		    
                    <!--
                        Share button.
                    -->
                    <div class="dopbsp-input-wrapper dopbsp-last">
                        <label>&nbsp;</label>
                        <input type="button" name="DOPBSP-settings-share-submit" id="DOPBSP-settings-share-submit" style="padding: 0;" value="<?php echo $DOPBSP->text('LOCATIONS_LOCATION_SHARE_SUBMIT'); ?>" onclick="DOPBSPBackEndLocation.share(<?php echo $location->id; ?>)" />
                    </div>
                </div>
<?php       
            }

/*
 * Inputs.
 */         
            /*
             * Create a text input for locations.
             * 
             * @param args (array): function arguments
             *                      * id (integer): location field ID
             *                      * label (string): location label
             *                      * value (string): location current value
             *                      * location_id (integer): location ID
             *                      * help (string): location help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $location_id = $args['location_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-location-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-location-'.$id.'" id="DOPBSP-location-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndLocation.edit('.$location_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndLocation.edit('.$location_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndLocation.edit('.$location_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');                        
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Get calendars list.
             * 
             * @param location (object): location data
             * 
             * @return HTML with the calendars
             */
            function listCalendars($location){
                global $wpdb;
                global $DOPBSP;
                 
                $calendars_data = ','.$location->calendars.',';
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $calendars = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE user_id=%d OR user_id=0 ORDER BY id ASC',
                                                                   wp_get_current_user()->ID));
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($calendars as $calendar){
?>                          
                            <li<?php echo strrpos($calendars_data, ','.$calendar->id.',') === false ? '':' class="dopbsp-selected"'; ?>>
                                <label for="DOPBSP-location-calendar<?php echo $calendar->id; ?>">
                                    <span class="dopbsp-id">ID: <?php echo $calendar->id; ?></span>
                                    <?php echo $calendar->name; ?>
                                </label>
                                <input type="checkbox" name="DOPBSP-location-calendar<?php echo $calendar->id; ?>" id="DOPBSP-location-calendar<?php echo $calendar->id; ?>"<?php echo strrpos($calendars_data, ','.$calendar->id.',') === false ? '':' checked="checked"'; ?> onclick="DOPBSPBackEndLocation.edit('<?php echo $location->id; ?>', 'checkbox', 'calendars')"  />
                            </li>
<?php
                    }
                }
                else{
?>
                            <li class="dopbsp-no-data">            
                                <?php printf($DOPBSP->text('LOCATIONS_LOCATION_NO_CALENDARS'), admin_url('admin.php?page=dopbsp-calendars')); ?>
                            </li>
<?php
                }
            }
	    
            /*
             * Get businesses list.
             * 
             * @param location (object): location data
             * 
             * @return HTML with the businesses
             */
            function listBusinesses($location){
		global $DOPBSP;
		
		$businesses = array('apartment',
				    'baby-sitter',
				    'bar',
				    'basketball-court',
				    'beauty-salon',
				    'bikes',
				    'boat',
				    'business',
				    'camping',
				    'camping-gear',
				    'cars',
				    'chef',
				    'cinema',
				    'clothes',
				    'costumes',
				    'club',
				    'dance-instructor',
				    'dentist',
				    'designer-handbags',
				    'doctor',
				    'esthetician',
				    'football-court',
				    'fishing',
				    'gadgets',
				    'games',
				    'golf',
				    'hairdresser',
				    'health-club',
				    'hospital',
				    'hotel',
				    'hunting',
				    'lawyer',
				    'library',
				    'massage',
				    'music-band',
				    'nails-salon',
				    'party-supplies',
				    'personal-trainer',
				    'pet-care',
				    'photo-equipment',
				    'photographer',
				    'pillates-instructor',
				    'plane-tickets',
				    'planes',
				    'restaurant',
				    'shoes',
				    'snow-equipment',
				    'spa',
				    'sports-coach',
				    'taxies',
				    'tenis-court',
				    'theatre',
				    'villa',
				    'weapons',
				    'working-tools');
		
		$businesses_data = ','.$location->businesses.',';
?>
			<div class="dopbsp-input-wrapper">
			    <label style="width: max-content;"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_BUSINESSES'); ?></label>
			    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_BUSINESSES_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
			</div>
                        <ul id="DOPBSP-location-businesses" class="dopbsp-input-list">
<?php
		foreach ($businesses as $business){
?>                          
                            <li<?php echo strrpos($businesses_data, ','.$business.',') === false ? '':' class="dopbsp-selected"'; ?>>
                                <label for="DOPBSP-location-business-<?php echo $business; ?>">
                                    <span class="dopbsp-id business-<?php echo $business; ?>"></span>
                                    <?php echo $DOPBSP->text('LOCATIONS_LOCATION_BUSINESS_'.strtoupper(str_replace('-', '_', $business))); ?>
                                </label>
                                <input type="checkbox" name="DOPBSP-location-business-<?php echo $business; ?>" id="DOPBSP-location-business-<?php echo $business; ?>"<?php echo strrpos($businesses_data, ','.$business.',') === false ? '':' checked="checked"'; ?> onclick="DOPBSPBackEndLocation.edit('<?php echo $location->id; ?>', 'checkbox', 'businesses')"  />
                            </li>
<?php
		}
?>
                        </ul>
<?php
            }
	    
            /*
             * Get languages list.
             * 
             * @param location (object): location data
             * 
             * @return HTML with the languages
             */
            function listLanguages($location){
		global $DOPBSP;
		
                $languages = $DOPBSP->classes->languages->languages;
		
		$languages_data = ','.$location->languages.',';
?>
			<div class="dopbsp-input-wrapper">
			    <label style="width: max-content;"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_LANGUAGES'); ?></label>
			    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_LANGUAGES_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
			</div>
                        <ul id="DOPBSP-location-languages" class="dopbsp-input-list">
<?php
		foreach ($languages as $language){
		    $code = $language['code'];
		    $name = $language['name'];
?>                          
                            <li<?php echo strrpos($languages_data, ','.$code.',') === false ? '':' class="dopbsp-selected"'; ?>>
                                <label for="DOPBSP-location-business-<?php echo $code; ?>">
                                    <span class="dopbsp-id"><?php echo $code; ?></span>
                                    <?php echo $name; ?>
                                </label>
                                <input type="checkbox" name="DOPBSP-location-language-<?php echo $code; ?>" id="DOPBSP-location-language-<?php echo $code; ?>"<?php echo strrpos($languages_data, ','.$code.',') === false ? '':' checked="checked"'; ?> onclick="DOPBSPBackEndLocation.edit('<?php echo $location->id; ?>', 'checkbox', 'languages')"  />
                            </li>
<?php
		}
?>
                        </ul>
<?php
            }
        }
    }