<?php

/**
 * Add a setting to Simple Admin Pages to register and verify a
 * MailChimp API key
 *
 * This class is modelled on AdminPageSetting.class.php in the Simple
 * Admin Pages library. It should work just like an extended class, but
 * due to the way the library embeds the version into the class name,
 * that could cause problems if the library is updated in the parent
 * plugin.
 *
 * See: https://github.com/NateWr/simple-admin-pages
 *
 */

class mcfrtbAdminPageSettingMcApiKey_2_2_0 {

	/**
	 * Scripts and styles to load for this component
	 * (not used but required as part of the library)
	 */
	public $scripts = array();
	public $styles = array();

	/**
	 * Initialize the setting
	 */
	public function __construct( $args ) {

		// Parse the values passed
		$this->parse_args( $args );

		// Get any existing value
		$this->set_value();

		// Set an error if the object is missing necessary data
		if ( $this->missing_data() ) {
			$this->set_error();
		}
	}

	/**
	 * Parse the arguments passed in the construction and assign them to
	 * internal variables. This function will be overwritten for most subclasses
	 */
	private function parse_args( $args ) {
		foreach ( $args as $key => $val ) {
			switch ( $key ) {

				case 'id' :
					$this->{$key} = esc_attr( $val );

				case 'title' :
					$this->{$key} = esc_attr( $val );

				default :
					$this->{$key} = $val;

			}
		}
	}

	/**
	 * Check for missing data when setup.
	 */
	private function missing_data() {

		// Required fields
		if ( empty( $this->id ) ) {
			$this->set_error(
				array(
					'type'		=> 'missing_data',
					'data'		=> 'id'
				)
			);
		}
		if ( empty( $this->title ) ) {
			$this->set_error(
				array(
					'type'		=> 'missing_data',
					'data'		=> 'title'
				)
			);
		}
	}

	/**
	 * Set a value
	 */
	public function set_value( $val = null ) {

		if ( $val === null ) {
			$option_group_value = get_option( $this->page );
			$val = isset( $option_group_value[ $this->id ] ) ? $option_group_value[ $this->id ] : '';
		}

		$this->value = $this->esc_value( $val );
	}

	/**
	 * Escape the value to display it in text fields and other input fields
	 */
	public function esc_value( $val ) {

		$value = array(
			'api_key'	=> '',
			'status'	=> false,
		);

		if ( empty( $val ) || empty( $val['api_key'] ) ) {
			return $value;
		}

		$value['api_key'] = esc_attr( $val['api_key'] );
		$value['status'] = (bool) $val['status'];

		return $value;
	}

	/**
	 * Display this setting
	 */
	public function display_setting() {
		?>

			<input name="<?php echo $this->get_input_name(); ?>[api_key]" type="text" id="<?php echo $this->get_input_name(); ?>[api_key]" value="<?php echo $this->value['api_key']; ?>"<?php echo !empty( $this->placeholder ) ? ' placeholder="' . esc_attr( $this->placeholder ) . '"' : ''; ?> class="regular-text">

			<?php if ( !empty( $this->value['api_key'] ) && $this->value['status'] === true ) : ?>
			<span class="mcfrtb-status mcfrtb-status-connected"><?php echo $this->string_status_connected; ?></span>
			<?php elseif( !empty( $this->value['api_key'] ) ) : ?>
			<span class="mcfrtb-status mcfrtb-status-error"><?php echo $this->string_status_error; ?></span>
			<?php endif; ?>

			<input name="<?php echo $this->get_input_name(); ?>[status]" type="hidden" id="<?php echo $this->get_input_name(); ?>[status]" value="<?php echo $this->value['status']; ?>"<?php echo !empty( $this->placeholder ) ? ' placeholder="' . esc_attr( $this->placeholder ) . '"' : ''; ?>>

		<?php

		$this->display_description();
	}

	/**
	 * Display a description for this setting
	 */
	public function display_description() {

		if ( !empty( $this->description ) ) : ?>

			<p class="description"><?php echo $this->description; ?></p>

		<?php endif;
	}

	/**
	 * Generate an option input field name, using the grouped schema.
	 */
	public function get_input_name() {
		return esc_attr( $this->page ) . '[' . esc_attr( $this->id ) . ']';
	}


	/**
	 * Sanitize the array of text inputs for this setting
	 */
	public function sanitize_callback_wrapper( $values ) {
		global $rtb_controller;

		$output = array(
			'api_key'	=> '',
			'status'	=> false,
		);

		// Return an empty key and status if the values don't look right
		if ( !is_array( $values ) || empty( $values ) || empty( $values['api_key'] ) ) {
			return $output;
		}

		// Sanitize the API key
		$output['api_key'] = sanitize_text_field( $values['api_key'] );

		$rtb_controller->mailchimp->load_api( $output['api_key'] );

		// Check for a valid API key
		$output['status'] = $rtb_controller->mailchimp->is_valid_api_key();

		return $output;
	}

	/**
	 * Add and register this setting
	 *
	 * @since 1.0
	 */
	public function add_settings_field( $section_id ) {

		add_settings_field(
			$this->id,
			$this->title,
			array( $this, 'display_setting' ),
			$this->tab,
			$section_id
		);

	}

	/**
	 * Set an error
	 * @since 1.0
	 */
	public function set_error( $error ) {
		$this->errors[] = array_merge(
			$error,
			array(
				'class'		=> get_class( $this ),
				'id'		=> $this->id,
				'backtrace'	=> debug_backtrace()
			)
		);
	}

}
