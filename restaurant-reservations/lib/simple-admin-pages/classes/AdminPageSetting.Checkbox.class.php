<?php

/**
 * Register, display and save an option with multiple checkboxes.
 *
 * This setting accepts the following arguments in its constructor function.
 *
 * $args = array(
 *		'id'			=> 'setting_id', 	// Unique id
 *		'title'			=> 'My Setting', 	// Title or label for the setting
 *		'description'	=> 'Description', 	// Help text description
 *		'options'		=> array(
 *							   'value' => 'Name'
 *						   ), 		// The checkbox values and text
 *		);
 * );
 *
 * @since 2.0
 * @package Simple Admin Pages
 */

class sapAdminPageSettingCheckbox_2_2_0 extends sapAdminPageSetting_2_2_0 {

	//public $sanitize_callback = 'sanitize_text_field';

	/**
	 * Display this setting
	 * @since 2.0
	 */
	public function display_setting() {
	
		$input_name = $this->get_input_name();
		$values = (is_array($this->value) ? $this->value : array());

		?>
		<fieldset>
			<?php foreach ( $this->options as $id => $title  ) : ?>
				<label title="<?php echo $title; ?>" class="rtb-admin-input-container">
					<input type="checkbox" name="<?php echo $input_name; ?>[]" id="<?php echo $input_name . "-" . $id; ?>" value="<?php echo $id; ?>" <?php echo ( in_array($id, $values) ?  'checked="checked"' : '' ) ?> <?php echo ( $this->disabled ? 'disabled' : ''); ?> />
					<span class='rtb-admin-checkbox'></span> <span><?php echo $title; ?></span>
				</label>
				<br />
			<?php endforeach; ?>
			<?php $this->display_disabled(); ?>
		</fieldset>
		<?php

		$this->display_description();

	}

}
