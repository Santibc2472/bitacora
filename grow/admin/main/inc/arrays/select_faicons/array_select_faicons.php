<?php
/**
 * Array - Icons.
 *
 * @package ThinkUpThemes
 */

function thinkup_customizer_select_array_faicons() {

	require_once( trailingslashit( get_template_directory() ) . 'admin/main/inc/arrays/select_faicons/fa-icons.php' );

	$input_icons = thinkup_customizer_control_get_font_icons();

	$array_icons = array();
	foreach( $input_icons as $icon ) {
		$icon               = esc_attr( $icon );
		$array_icons[$icon] = $icon;
	}
	return $array_icons;
}
