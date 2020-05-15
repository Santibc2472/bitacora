<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.1.1
* File                    : includes/locations/class-backend-location.php
* File Version            : 1.0.1
* Created / Last Modified : 25 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end location PHP class.
*/

    if (!class_exists('DOPBSPBackEndLocation')){
        class DOPBSPBackEndLocation extends DOPBSPBackEndLocations{
            private $views;
            
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Prints out the location.
             * 
             * @post id (integer): location ID
             * @post language (string): location current editing language
             * 
             * @return location HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_location->template(array('id' => $id,
                                                         'language' => $language));
                
                die();
            }
            
            /*
             * Edit location fields.
             * 
             * @post id (integer): location ID
             * @post field (string): location field
             * @post value (string): location new value
             * @post coordinates (string): location coordinates
             */
            function edit(){
		global $DOT;
                global $wpdb;  
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $field = $DOT->post('field');
                $value = $DOT->post('value');
                $coordinates = $DOT->post('coordinates');
                
                $wpdb->update($DOPBSP->tables->locations, array($field => $value), 
                                                          array('id' =>$id));
                
                if ($field == 'address'){
                    $wpdb->update($DOPBSP->tables->locations, array('address_en' => $DOPBSP->classes->prototypes->getEnglishCharacters($value)), 
                                                              array('id' =>$id));
                    $wpdb->update($DOPBSP->tables->locations, array('coordinates' => $coordinates), 
                                                              array('id' =>$id));
                } 
                else if ($field == 'address_alt'){
                    $wpdb->update($DOPBSP->tables->locations, array('address_alt_en' => $DOPBSP->classes->prototypes->getEnglishCharacters($value)), 
                                                              array('id' =>$id));
                }
                
                if ($field == 'address' 
                        || $field == 'calendars'){
                    $this->setCoordinates($id);
                }
                
            	die();
            }
            
            /*
             * Set coordinates from location in selected calendars.
             * 
             * @param id (integer): location ID
             * @param clean (boolean): set to "true" clean coordinates from calendars
             */
            function setCoordinates($id,
                                    $clean = false){
                global $wpdb;
                global $DOPBSP;
                
                $location = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->locations.' WHERE id=%d', 
                                                           $id));
                
                if (isset($location->calendars)
                        && $location->calendars != ''){
                    $calendars = explode(',', $location->calendars);

                    foreach($calendars as $calendar){
                        $wpdb->update($DOPBSP->tables->calendars, array('address' => $clean ? '':$location->address,
                                                                        'address_en' => $clean ? '':$location->address_en,
                                                                        'address_alt' => $clean ? '':$location->address_alt,
                                                                        'address_alt_en' => $clean ? '':$location->address_alt_en,
                                                                        'coordinates' => $clean ? '':$location->coordinates), 
                                                                  array('id' => $calendar));
                    }
                }
            }
            
            /*
             * Delete location.
             * 
             * @post id (integer): location ID
             * 
             * @return number of locations left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Clean coordinates from calendars.
                 */
                $this->setCoordinates($id, true);
                
                /*
                 * Delete location.
                 */
                $wpdb->delete($DOPBSP->tables->locations, array('id' => $id));
                $locations = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->locations.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
            
            /*
             * Share location.
             * 
             * @post id (integer): location ID
             * 
             * @return success or error message
             */
            function share(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                $location = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->locations.' WHERE id=%d',
                                                          $id));
		
		if ($location->name != ''
			&& $location->address != ''
			&& $location->coordinates != ''
			&& $location->link != ''
			&& $location->image != ''
			&& ($location->businesses != '' 
				|| $location->businesses_other != '' )
			&& $location->languages != ''
			&& $DOPBSP->classes->prototypes->validEmail($location->email)){
		    $coordinates = json_decode($location->coordinates);
		    
		    $post_variables = array('key' => $DOPBSP->classes->prototypes->getRandomString(16),
					    'name' => $location->name,
					    'address' => $location->address,
					    'address_en' => $location->address_en,
					    'address_alt' => $location->address_alt,
					    'address_alt_en' => $location->address_alt_en,
					    'latitude' => $coordinates[0],
					    'longitude' => $coordinates[1],
					    'link' => $location->link,
					    'image' => $location->image,
					    'businesses' => $location->businesses,
					    'businesses_other' => $location->businesses_other,
					    'languages' => $location->languages,
					    'email' => $location->email);
//
//		    $ch = curl_init();
//
//		    curl_setopt($ch, CURLOPT_URL, 'https://pinpoint.world/api/');
//		    curl_setopt($ch, CURLOPT_POST, 1);
//		    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_variables);
//		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//		    $server_output = curl_exec($ch);
//
//		    curl_close ($ch);
//		    
//		    echo $server_output == 'true' ? 'success':$DOPBSP->text('LOCATIONS_LOCATION_SHARE_SUBMIT_ERROR_DUPLICATE');
		    
		    $response = wp_remote_post('https://pinpoint.world/api/', array('method' => 'POST',
										    'timeout' => 45,
										    'redirection' => 5,
										    'httpversion' => '1.0',
										    'blocking' => true,
										    'headers' => array(),
										    'body' => $post_variables,
										    'cookies' => array()));

		    if (is_wp_error($response)){
			echo $DOPBSP->text('LOCATIONS_LOCATION_SHARE_SUBMIT_ERROR');
		    }
		    else{
		       echo $response['body'] == 'true' ? 'success':$DOPBSP->text('LOCATIONS_LOCATION_SHARE_SUBMIT_ERROR_DUPLICATE');
		    }
		}
		else{
		    echo $DOPBSP->text('LOCATIONS_LOCATION_SHARE_SUBMIT_ERROR');
		}

            	die();
            }
        }
    }