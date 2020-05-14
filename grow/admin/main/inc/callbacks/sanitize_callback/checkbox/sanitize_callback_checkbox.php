<?php
/**
 * Custom sanitisation callback - Checkbox.
 *
 * @package ThinkUpThemes
 */

function thinkup_customizer_callback_sanitize_checkbox( $value ) {

	return ( ( isset( $value ) && true == $value ) ? true : false );
}