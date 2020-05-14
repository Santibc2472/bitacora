<?php

/**
 * Register, display and save an option with radio buttons.
 *
 * This setting accepts the following arguments in its constructor function.
 *
 * $args = array(
 *		'id'			=> 'setting_id', 	// Unique id
 *		'title'			=> 'My Setting', 	// Title or label for the setting
 *		'description'	=> 'Description', 	// Help text description
 *		'options'		=> array(
 *							   'value' => 'Name'
 *						   ), 		// The radio buttons values and text
 *		);
 * );
 *
 * @since 2.0
 * @package Simple Admin Pages
 */

class sapAdminPageSettingRadio_2_2_0 extends sapAdminPageSetting_2_2_0 {

	public $sanitize_callback = 'sanitize_text_field';

	/**
	 * Display this setting
	 * @since 2.0
	 */
	public function display_setting() {
	
		$input_name = $this->get_input_name();

		?>
		<fieldset>
			<?php foreach ( $this->options as $id => $title  ) : ?>
				<label title="<?php echo $title; ?>" class="rtb-admin-input-container">
					<input type="radio" name="<?php echo $input_name; ?>" id="<?php echo $input_name . "-" . $id; ?>" value="<?php echo $id; ?>" <?php echo ( $id == $this->value ?  'checked="checked"' : '' ) ?> <?php echo ( $this->disabled ? 'disabled' : ''); ?> />
					<span class='rtb-admin-radio-button'></span> <span><?php echo $title; ?></span>
				</label>
				<br />
			<?php endforeach; ?>
			
			<?php $this->display_disabled(); ?>		
		</fieldset>
		<?php

		$this->display_description();

	}

}
