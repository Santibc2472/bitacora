<style type="text/css">
	.redi_required{
		color: #DD0000;
	}
	#selected_place_id{
		font-weight: bold;
	}

</style>
<script type="text/javascript">
    jQuery(function () {
        jQuery('#Place').change(function () {
            jQuery('#Place option:selected').each(function () {
                jQuery("#selected_place_id").html(this.value);
                var data = {
                    action: 'redi_restaurant-submit',
                    get: 'get_place',
                    placeID: this.value
                };

                jQuery('#ajaxload').show('slow');
                jQuery.post('admin-ajax.php', data, function (response) {
                    jQuery('#ajaxload').hide('slow');
                    jQuery('#ajaxed').html(response);
                });
            });
        });
    });
</script>
<div class="icon32" id="icon-options-general"><br></div>
	<div class="icon32" id="icon-users"><br></div>
	<h2><?php _e('Restaurant settings', 'redi-restaurant-reservation'); ?></h2>

	<table class="form-table">
        <tr style="vertical-align:top">
            <td style="width:20%; vertical-align: top;">
                <label for="Place"><?php _e('Place', 'redi-restaurant-reservation'); ?> </label>
            </td>
            <td style="vertical-align: top;">
                <select name="Place" id="Place">
                    <?php foreach((array)$places as $place_current):?>
                        <option value="<?php echo $place_current->ID ?>" <?php if($placeID == $place_current->ID): ?>selected="selected"<?php endif;?>>
                            <?php echo $place_current->Name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <img id="ajaxload" style="display: none;" src="<?php echo REDI_RESTAURANT_PLUGIN_URL ?>img/ajax-loader.gif" alt="loader icon"/>
            </td>
	        <td style="width:70%">
		        <p class="description">
                    <?php _e('This field lets you edit settings for multiple places. Multiple places are available for Basic package users only.', 'redi-restaurant-reservation') ?>
                </p>
            </td>
        </tr>
		<tr style="vertical-align:top">
			<td colspan="2" style="vertical-align: top;">
			    <label><?php _e('Current Place ID', 'redi-restaurant-reservation'); ?>: <span id="selected_place_id"><?php echo $placeID ?></span></label>
			</td>
			<td style="width:80%;">
				<p class="description">
					<?php echo sprintf(__('This <b>ID</b> associated with your place. The <b>ID</b> can be used as a short code for specifying the place of reservation in case of multiple restaurants. <br/>Example of shortcode:', 'redi-restaurant-reservation') . '<br/><code style="font-style: normal; padding:0">[redirestaurant apikeyid="1" apikey1="%s" placeid="%s"]<br/>[redirestaurant apikeyid="2" apikey2="%s" placeid="ID OF SECOND PLACE"]</code>', $apiKey, $placeID, $apiKey); ?>
				</p>
			</td>
        </tr>
	</table>	
				
	<!-- custom fields-->
	<div class="icon32" id="icon-edit-comments"><br></div>
	<h3><?php _e('Custom fields', 'redi-restaurant-reservation'); ?></h3>
	<p class="description">
		<?php _e('Custom fields are meant to allow users define additional fields for collecting more information from customers. You can choose the name of the field, type of field, the constraint whether it is a required field or not and the error message for the required field.', 'redi-restaurant-reservation') ?>
		<br/>
		<b style="color: red"><?php _e('NOTE: Name, Email, Phone and Comments are required fields of reservation form and do not need to be defined here as custom fields.', 'redi-restaurant-reservation') ?></b>
	</p>

	<table class="form-table" style="width: 90%; text-align: center;">
		<thead>
		<tr>
			<th>
				<label>
					<?php _e('Field name', 'redi-restaurant-reservation'); ?>
				</label>
			</th>
			<th>
				<label>
					<?php _e('Field type', 'redi-restaurant-reservation'); ?>
				</label>
			</th>
			<th>
				<label>
					<?php _e('Is required?', 'redi-restaurant-reservation'); ?>
				</label>
			</th>
			<th>
				<label>
					<?php _e('Is printed?', 'redi-restaurant-reservation'); ?>
				</label>
			</th>
			<th>
				<label>
					<?php _e('Required error message', 'redi-restaurant-reservation'); ?>
				</label>
			</th>
			<th>

			</th>
		</tr>
		</thead>

		<?php
		$RDRR = new ReDiRestaurantReservation();
		$custom_fields = $RDRR->redi->getCustomField(self::lang(), $placeID);
		for ($i = 0; $i != CUSTOM_FIELDS; $i++):
			if (!isset($custom_fields[$i])) {
				$custom_fields[$i] = (object)array(
					'Id' => 0,
					'Name' => '',
					'Type' => 'text',
					'Message' => '',
					'Required' => false,
					'Print' => false,
				);
			}
			$custom_field = $custom_fields[$i];
			?>
			<?php $field_id = ('field_' . $i . '_id'); ?>

			<tr>
				<td>
					<input type="hidden" id="<?php echo $field_id; ?>" name="<?php echo $field_id; ?>"
						   value="<?php echo $custom_field->Id ?>"/>
					<?php $field_name = ('field_' . $i . '_name'); ?>
					<input type="text" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>"
						   value="<?php echo $custom_field->Name; ?>"/>
				</td>
				<td style="vertical-align: top;">
					<?php $field_type = ('field_' . $i . '_type'); ?>
					<select onchange="set_name('<?php echo $field_name; ?>',this.options[this.selectedIndex].value);"
							class="field_type" name="<?php echo $field_type; ?>"
							id="<?php echo $field_type; ?>">
						<option value="text"
								<?php if ($custom_field->Type === 'text'): ?>selected="selected"<?php endif ?>><?php _e('Text field', 'redi-restaurant-reservation'); ?></option>
						<option value="checkbox"
								<?php if ($custom_field->Type === 'checkbox'): ?>selected="selected"<?php endif ?>><?php _e('Check box', 'redi-restaurant-reservation'); ?></option>
						<option value="reminder"
								<?php if ($custom_field->Type === 'reminder'): ?>selected="selected"<?php endif ?>><?php _e('Reminder', 'redi-restaurant-reservation'); ?></option>
						<option value="newsletter"
								<?php if ($custom_field->Type === 'newsletter'): ?>selected="selected"<?php endif ?>><?php _e('Newsletter', 'redi-restaurant-reservation'); ?></option>
						<option value="allowsms"
								<?php if ($custom_field->Type === 'allowsms'): ?>selected="selected"<?php endif ?>><?php _e('Allow SMS', 'redi-restaurant-reservation'); ?></option>
						<option value="gdpr"
								<?php if ($custom_field->Type === 'gdpr'): ?>selected="selected"<?php endif ?>><?php _e('GDPR', 'redi-restaurant-reservation'); ?></option>
					</select>
				</td>
				<td>
					<?php $field_required = ('field_' . $i . '_required'); ?>
					<input type="checkbox" id="<?php echo $field_required; ?>"
						   name="<?php echo $field_required; ?>"
						   <?php if ($custom_field->Required): ?>checked="checked"<?php endif ?>>
				</td>
				<td>
					<?php $field_print = ('field_' . $i . '_print'); ?>
					<input type="checkbox" id="<?php echo $field_print; ?>"
						   name="<?php echo $field_print; ?>"
						   <?php if ($custom_field->Print): ?>checked="checked"<?php endif ?>>
				</td>
				<td>
					<?php $field_message = ('field_' . $i . '_message'); ?>
					<input type="text" id="<?php echo $field_message; ?>"
						   name="<?php echo $field_message; ?>" value="<?php echo $custom_field->Message ?>"
						   style="width:250px;">
				</td>
				<td>
					<a onclick="jQuery('#<?php echo $field_name; ?>').val(''); jQuery('#<?php echo $field_message; ?>').val(''); jQuery('#<?php echo $field_type; ?>').val('text'); jQuery('#<?php echo $field_required; ?>').attr('checked', false);jQuery('#<?php echo $field_print; ?>').attr('checked', false);">clear</a>
				</td>
			</tr>

		<?php endfor; ?>
	</table>
	<!-- /custom fields-->
	<p class="description">
		<b style="color: red"><?php _e('Note: SMS messages and Reminders requires an extra addons to be purchased.', 'redi-restaurant-reservation'); ?></b>
	</p>
	<br/>
			
	<table class="form-table">
		<tr style="vertical-align:top">
			<td style="width:15%;vertical-align: top;">
				<label for="Name">
					<?php _e('Restaurant name', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="Name" type="text" value="<?php echo $place['Name'] ?>" name="Name"/>
			</td>
			<td style="width:80%;">
				<p class="description">
					<?php _e('The name of the restaurant is to be specified here.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<label for="Country">
					<?php _e('Country', 'redi-restaurant-reservation'); ?> <span class="redi_required">*</span>
				</label>
			</td>
			<td style="vertical-align: top;">
				<select id="Country" name="Country">
					<option value=""> -- <?php _e('Select Country', 'redi-restaurant-reservation')?> -- </option>
					<?php foreach($countries as $country):?>
					<option value="<?php echo $country ?>" <?php if($place['Country']==$country): ?>selected="selected"<?php endif ?>><?php echo $country ?></option>
					<?php endforeach ?>
				</select>
			</td>
			<td style="width:80%;">
				<p class="description">
					<?php _e('The country of restaurant can be mentioned here.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<label for="City">
					<?php _e('City', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="City" type="text" value="<?php echo $place['City'] ?>" name="City"/>
			</td>
			<td style="width:80%;">
				<p class="description">
					<?php _e('The restaurant city is to be specified in this field.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<label for="Address">
					<?php _e('Address', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="Address" type="text" value="<?php echo $place['Address'] ?>" name="Address"/>
			</td>
			<td style="width:80%;">
				<p class="description">
					<?php _e('Address of the restaurant is to be written here.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<label for="WebAddress">
					<?php _e('URL', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="WebAddress" type="text" value="<?php echo $place['WebAddress'] ?>" name="WebAddress"/>
			</td>
			<td style="width:80%;">
				<p class="description">
					<?php _e('The website address of the restaurant.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<label for="Email">
					<?php _e('Email', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="Email" type="email" value="<?php echo $place['Email'] ?>" name="Email"/>
			</td>
			<td style="width:80%;">
				<p class="description">
					<?php _e('Email address for contacting the restaurant.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<label for="EmailCC">
					<?php _e('Email CC', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="EmailCC" type="text" value="<?php echo $place['EmailCC'] ?>" name="EmailCC"/>
			</td>
			<td>
				<p class="description">
					<?php _e('The email addresses of recipients who should be sent the copies of reservation emails. You can separate multiple recipients using commas.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<label for="Phone">
					<?php _e('Phone', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="Phone" type="text" value="<?php echo $place['Phone'] ?>" name="Phone"/>
			</td>
			<td>
				<p class="description">
					<?php _e('The contact number of restaurant. It could have the format [area code] [phone number]', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>

		<tr>
			<td style="vertical-align: top;">
				<label for="MinTimeBeforeReservation">
					<?php _e('Late Bookings', 'redi-restaurant-reservation'); ?>
				</label>
			</td>
			<td style="vertical-align: top;">
				<input id="MinTimeBeforeReservation" type="text" value="<?php echo $place['MinTimeBeforeReservation'] ?>" name="MinTimeBeforeReservation"/>
			</td>
			<td style="width:80%">
				<p class="description">
					<?php _e('Specify how late customers can make their booking in hours. For example, the current time is 10:00 and this setting is set to 3 hours then the first time, when the reservation will be accepted is 13:00.', 'redi-restaurant-reservation'); ?>
					<br/>
					<?php _e('NOTE: If you define Open Time in basic package, then this setting will be ignored. Use open times settings to define Late Bookings.', 'redi-restaurant-reservation'); ?>
				</p>
			</td>
		</tr>
			
		<tr style="vertical-align:top">
			<td style="vertical-align: top;">
				<label for="services"><?php _e('Maximum number of guests', 'redi-restaurant-reservation'); ?> </label>
			</td>
			<td style="vertical-align: top;">
				<select name="services" id="services">
					<?php foreach(range(1, 500) as $current):?>
						<option value="<?php echo $current?>" <?php if($current == (int)count($getServices)): ?>selected="selected"<?php endif;?>>
							<?php echo $current ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
			<td style="width:80%">
				<p class="description">
					<?php _e('This is the number of maximum persons in restaurant at any time. System will check automatically availability of free seats and will not allow to go beyond this number.', 'redi-restaurant-reservation'); ?></br>
				</p>
			</td>
		</tr>
	</table>
    <br/>
	<h2><?php _e('Working time', 'redi-restaurant-reservation'); ?> </h2>
	<table class="form-table">
		<tr style="vertical-align:top">
			<th >

			</th>
			<td>
				<?php _e('Open', 'redi-restaurant-reservation'); ?>
			</td>
			<td>
				<?php _e('Close', 'redi-restaurant-reservation'); ?>
			</td>
		</tr>

		<?php foreach ($this->weekday as $serviceTimeName): ?>
			<?php $serviceTimeValue = isset($serviceTimes[$serviceTimeName]) ? $serviceTimes[$serviceTimeName] : ''; ?>

			<tr style="vertical-align:top">
				<td >
					<label for="OpenTime[<?php echo $serviceTimeName ?>]">
						<?php _e($serviceTimeName) ?>
					</label>
				</td>
				<td>
					<input id="OpenTime[<?php echo $serviceTimeName ?>]" type="text"
							value="<?php echo isset($serviceTimeValue['OpenTime'])?$serviceTimeValue['OpenTime']:'' ?>"
							name="OpenTime[<?php echo $serviceTimeName ?>]"/>
				</td>
				<td>
					<input type="text" value="<?php echo isset($serviceTimeValue['CloseTime'])?$serviceTimeValue['CloseTime']:'' ?>"
							name="CloseTime[<?php echo $serviceTimeName ?>]"/>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
	<br/>
	<br/>

	<p class="description">
		<?php _e('You can specify the working time of restaurant by setting the opening time and closing time for each day of the week.', 'redi-restaurant-reservation'); ?>
		<br/>
		<?php _e('Specify time in 24h format (00:00 - 23:59).', 'redi-restaurant-reservation'); ?>
		<br/>
		<?php _e('If you close next day at night then set closing time on a same day. For example 18:00 - 3:00', 'redi-restaurant-reservation'); ?>
		<br/>
		<?php _e('Set Open and Close fields to blank if restaurant is closed.', 'redi-restaurant-reservation'); ?>
		<br/>
		<?php _e('Multiple open and close times are available in Basic package. If times are configured in Basic package, then this table is ignored.', 'redi-restaurant-reservation'); ?>
	</p>
	<br/>
        <div class="icon32" id="icon-edit-comments"><br></div>
        <h2><?php _e('Email Configuration', 'redi-restaurant-reservation'); ?></h2>

        <table class="form-table">
            <tr>
                <td >
                    <label for="Lang">
                        <?php _e('Language', 'redi-restaurant-reservation'); ?>
                    </label>
                </td>
                <td>
					<select name="Lang" style="width:137px;">
                    <?php
						$place_lang = $place['Lang'];

						if ($place_lang != 'pt-BR' && $place_lang != 'pt-PT'){
							$place_lang = substr($place_lang, 0, 2);
						}
                    ?>

					<?php foreach ((array)$languages as $locale): ?>
                        <option <?php if ($place_lang == $locale['locale']): ?> selected="selected" <?php endif ?> value="<?php echo $locale['locale'] ?>">
                            <?php echo $locale['name']; ?>
                        </option>
                    <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <p class="description">
                        <?php _e('Language for internal emails communication. It is specially used for admin emails. ', 'redi-restaurant-reservation'); ?><br/>
						<?php _e('Language for emails of clients depend on the user interface language selected.', 'redi-restaurant-reservation'); ?>
                    </p>
                </td>
            </tr>
            <tr style="vertical-align:top">

                <td style="width:15%;">
                    <label for="DateFormat">
                        <?php _e('Date format', 'redi-restaurant-reservation'); ?>
                    </label>
                </td>
                <td>
                    <select id="DateFormat" name="DateFormat">
                        <optgroup label="<?php _e('Hyphen', 'redi-restaurant-reservation'); ?>">
                            <option <?php if ($place['DateFormat'] == 'yyyy-MM-dd'): ?> selected="selected" <?php endif ?> value="yyyy-MM-dd">yyyy-mm-dd</option>
                            <option <?php if ($place['DateFormat'] == 'MM-dd-yyyy'): ?> selected="selected" <?php endif ?> value="MM-dd-yyyy">mm-dd-yyyy</option>
                            <option <?php if ($place['DateFormat'] == 'dd-MM-yyyy'): ?> selected="selected" <?php endif ?> value="dd-MM-yyyy">dd-mm-yyyy</option>
                        </optgroup>
                        <optgroup label="<?php _e('Dot', 'redi-restaurant-reservation'); ?>">
                            <option <?php if ($place['DateFormat'] == 'yyyy.MM.dd'): ?> selected="selected" <?php endif ?> value="yyyy.MM.dd">yyyy.mm.dd</option>
                            <option <?php if ($place['DateFormat'] == 'MM.dd.yyyy'): ?> selected="selected" <?php endif ?> value="MM.dd.yyyy">mm.dd.yyyy</option>
                            <option <?php if ($place['DateFormat'] == 'dd.MM.yyyy'): ?> selected="selected" <?php endif ?> value="dd.MM.yyyy">dd.mm.yyyy</option>
                        </optgroup>
                        <optgroup label="<?php _e('Slash', 'redi-restaurant-reservation'); ?>">
                            <option <?php if ($place['DateFormat'] == 'yyyy/MM/dd'): ?> selected="selected" <?php endif ?> value="yyyy/MM/dd">yyyy/mm/dd</option>
                            <option <?php if ($place['DateFormat'] == 'MM/dd/yyyy'): ?> selected="selected" <?php endif ?> value="MM/dd/yyyy">mm/dd/yyyy</option>
                            <option <?php if ($place['DateFormat'] == 'dd/MM/yyyy'): ?> selected="selected" <?php endif ?> value="dd/MM/yyyy">dd/mm/yyyy</option>
                        </optgroup>
                    </select>
                </td>
	            <td>
		            <p class="description">
						<?php _e('The way date format is displayed on the date control. You can select from a drop down list of different date formats.', 'redi-restaurant-reservation'); ?>
		            </p>
	            </td>
            </tr>
        </table>