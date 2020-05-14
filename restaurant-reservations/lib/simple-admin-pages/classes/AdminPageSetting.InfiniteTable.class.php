<?php

/**
 * Register, display and save an option with multiple checkboxes.
 *
 * This setting accepts the following arguments in its constructor function.
 *
 * $args = array(
 *		'id'			=> 'setting_id', 	// Unique id
 *		'title'			=> 'My Setting', 	// Title or label for the setting
 *		'add_label'		=> 'Add Row', 		// Text for the "Add Row" button
 *		'description'	=> 'Description', 	// Help text description
 *		'fields'		=> array(
 *		   'field' => array(
 * 				'type' => 'text' //text, select
 * 				'label' => 'Name'
 * 				'required' => false,
 *				'options' => array()
 * 			)
 *		) 		// The attributes and labels for the fields
 * );
 *
 * @since 2.0
 * @package Simple Admin Pages
 */

class sapAdminPageSettingInfiniteTable_2_2_0 extends sapAdminPageSetting_2_2_0 {

	public $sanitize_callback = 'sanitize_text_field';

	/**
	 * Add in the JS requried for rows to be added and the values to be stored
	 * @since 2.0
	 */
	public $scripts = array(
		'sap-infinite-table' => array(
			'path'			=> 'js/infinite_table.js',
			'dependencies'	=> array( 'jquery' ),
			'version'		=> '2.0.a.5',
			'footer'		=> true,
		),
	);

	/**
	 * Add in the CSS requried for rows to be displayed correctly
	 * @since 2.0
	 */
	public $styles = array(
		'sap-infinite-table' => array(
			'path'			=> 'css/infinite_table.css',
			'dependencies'	=> array( ),
			'version'		=> '2.0.a.5',
			'media'		=> 'all',
		),
	);

	/**
	 * Display this setting
	 * @since 2.0
	 */
	public function display_setting() {
	
		$row_count = 0;

		$input_name = $this->get_input_name();
		$values = json_decode( html_entity_decode( $this->value ) );

		if ( ! is_array( $values ) )
			$values = array();

		$fields = '';
		foreach ($this->fields as $field_id => $field) {
			$fields .= $field_id . ",";
		}
		$fields = trim($fields, ',');

		?>

		<fieldset>
			<div class='sap-infinite-table <?php echo ( $this->disabled ? 'disabled' : ''); ?>' data-fieldids='<?php echo $fields; ?>'>
				<input type='hidden' name='<?php echo $input_name; ?>' value='<?php echo $this->value; ?>' />
				<table>
					<thead>
						<tr>
							<?php foreach ($this->fields as $field) { ?>
								<th><?php echo  $field['label']; ?></th>
							<?php } ?>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($values as $row) { ?>
							<tr class='sap-inifinite-table-row' data-rowid='<?php echo $row_count; ?>'>
								<?php foreach ($this->fields as $field_id => $field) { ?>
									<td>
										<?php if ($field['type'] == 'text') : ?>
											<input type='text' name='<?php echo $field_id . "_" . $row_count; ?>' value='<?php echo $row->$field_id; ?>' />
										<?php endif; ?>
										<?php if ($field['type'] == 'select') : ?>
											<select name='<?php echo $field_id . "_" . $row_count; ?>'>
												<?php foreach ($field['options'] as $option_value => $option_name) { ?>
													<option value='<?php echo $option_value; ?>' <?php echo ($row->$field_id == $option_value ? 'selected="selected"' : ''); ?>><?php echo  $option_name; ?></option>
												<?php }?>
											</select>
										<?php endif; ?>
									</td>
								<?php } ?>
								<td class='sap-infinite-table-row-delete'><?php _e('Delete'); ?></td>
							</tr>
							<?php $row_count++; ?>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr class='sap-inifite-table-row-template sap-hidden'>
							<?php foreach ($this->fields as $field_id => $field) { ?>
								<td>
									<?php if ($field['type'] == 'text') : ?>
										<input type='text' name='<?php echo $field_id; ?>' value='' />
									<?php endif; ?>
									<?php if ($field['type'] == 'select') : ?>
										<select name='<?php echo $field_id; ?>'>
											<?php foreach ($field['options'] as $option_value => $option_name) { ?>
												<option value='<?php echo $option_value; ?>'><?php echo  $option_name; ?></option>
											<?php }?>
										</select>
									<?php endif; ?>
								</td>
							<?php } ?>
							<td class='sap-infinite-table-row-delete'><?php _e('Delete'); ?></td>
						</tr>
						<tr class='sap-infinite-table-add-row'>
							<td colspan="4">
								<a class="rtb-new-admin-add-button">&plus; <?php _e('ADD ROW'); ?></a>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>

			<?php $this->display_disabled(); ?>		
		</fieldset>

		<?php

		$this->display_description();

	}

}
