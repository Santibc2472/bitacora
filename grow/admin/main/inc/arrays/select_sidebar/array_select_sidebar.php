<?php
/**
 * Array - Select Sidebar.
 *
 * @package ThinkUpThemes
 */

function thinkup_customizer_select_array_sidebar() {

	global $wp_registered_sidebars;
	$array_sidebars = array();
	foreach ( $wp_registered_sidebars as $sidebar ) {
		if ( strpos( $sidebar['name'], 'Footer' ) !== false ) {
		} else {
			$sidebar_name               = $sidebar['name'];
			$array_sidebars[$sidebar_name] = $sidebar_name;
		}
	}
	return $array_sidebars;
}
