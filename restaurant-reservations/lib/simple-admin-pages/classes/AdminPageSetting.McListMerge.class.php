<?php

/**
 * Add a setting to Simple Admin Pages to select a list and define
 * merge fields for that list.
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

class mcfrtbAdminPageSettingMcListMerge_2_2_0 {
	
	/**
	 * Scripts and styles to load for this component
	 * (not used but required as part of the library)
	 */
	public $scripts = array();
	public $styles = array();

	/**
	 * List of fields available for merging
	 */
	public $fields = array();

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

				case 'fields' :
					$this->{$key} = is_array( $val ) ? $val : array();

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
		if ( empty( $this->fields ) ) {
			$this->set_error(
				array(
					'type'		=> 'missing_data',
					'data'		=> 'fields'
				)
			);
		}
		if ( empty( $this->string_loading ) ) {
			$this->set_error(
				array(
					'type'		=> 'missing_data',
					'data'		=> 'string_loading'
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
			'list'		=> '',
			'fields'	=> array(),
		);

		if ( empty( $val ) || empty( $val['list'] ) ) {
			return $value;
		}

		$value['list'] = esc_attr( $val['list'] );

		// Escape the id/title of each merge field
		foreach( $val['fields'] as $id => $val ) {
			$value['fields'][$id] = esc_html( $val );
		}

		return $value;
	}

	/**
	 * Display this setting
	 */
	public function display_setting() {

		?>

			<span class="mcfrtb-list-select"></span>

			<span class="mcfrtb_loading">
				<span class="spinner"></span>
				<span><?php echo $this->string_loading; ?></span>
			</span>

			<?php $this->display_description(); ?>

			<div id="mcfrtb-merge-controls" data-input-name="<?php echo $this->get_input_name(); ?>"></div>

		<?php
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

		$output = array(
			'list'		=> '',
			'fields'	=> array(),
		);

		// Return an empty value if we're missing anything important
		if ( !is_array( $values ) || empty( $values ) || empty( $values['list'] ) ) {
			return $output;
		}

		// Sanitize the list
		$output['list'] = sanitize_text_field( $values['list'] );

		// Sanitize each merge field
		$val_log = array();
		foreach( $values['fields'] as $id => $val ) {

			// Make sure that a merge field isn't assigned to multiple data
			if ( !in_array( $val, $val_log ) ) {
				$output['fields'][$id] = sanitize_text_field( $val );
			}

			$val_log[] = $val;
		}

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
