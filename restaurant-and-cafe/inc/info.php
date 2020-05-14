<?php
/**
 * Restaurant and Cafe Theme Info
 *
 * @package Restaurant_and_Cafe
 */

function restaurant_and_cafe_customizer_theme_info( $wp_customize ) {
	
    $wp_customize->add_section( 'theme_info' , array(
		'title'       => __( 'Information Links' , 'restaurant-and-cafe' ),
		'priority'    => 6,
		));

	$wp_customize->add_setting('theme_info_theme',array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
		));
    
    $theme_info = '';
	$theme_info .= '<h3 class="sticky_title">' . __( 'Need help?', 'restaurant-and-cafe' ) . '</h3>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View demo', 'restaurant-and-cafe' ) . ': </label><a href="' . esc_url( 'https://demo.rarathemes.com/restaurant-and-cafe/' ) . '" target="_blank">' . __( 'here', 'restaurant-and-cafe' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View documentation', 'restaurant-and-cafe' ) . ': </label><a href="' . esc_url( 'https://docs.rarathemes.com/docs/restaurant-and-cafe/' ) . '" target="_blank">' . __( 'here', 'restaurant-and-cafe' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme info', 'restaurant-and-cafe' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/restaurant-and-cafe/' ) . '" target="_blnak">' . __( 'here', 'restaurant-and-cafe' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support ticket', 'restaurant-and-cafe' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/support-ticket/' ) . '" target="_blnak">' . __( 'here', 'restaurant-and-cafe' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Rate this theme', 'restaurant-and-cafe' ) . ': </label><a href="' . esc_url( 'https://wordpress.org/support/theme/restaurant-and-cafe/reviews/' ) . '" target="_blnak">' . __( 'here', 'restaurant-and-cafe' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="more-detail row-element">' . __( 'More WordPress Themes' ,'restaurant-and-cafe' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/' ) . '" target="_blank">' . __( 'here', 'restaurant-and-cafe' ) . '</a></span><br />';
	

	$wp_customize->add_control( new Restaurant_and_Cafe_Theme_Info( $wp_customize ,'theme_info_theme',array(
		'label' => __( 'About Restaurant And Cafe' , 'restaurant-and-cafe' ),
		'section' => 'theme_info',
		'description' => $theme_info
		)));

	$wp_customize->add_setting('theme_info_more_theme',array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
		));

}
add_action( 'customize_register', 'restaurant_and_cafe_customizer_theme_info' );


if( class_exists( 'WP_Customize_control' ) ){

	class Restaurant_and_Cafe_Theme_Info extends WP_Customize_Control
	{
    	/**
       	* Render the content on the theme customizer page
       	*/
       	public function render_content()
       	{
       		?>
       		<label>
       			<strong class="customize-text_editor"><?php echo esc_html( $this->label ); ?></strong>
       			<br />
       			<span class="customize-text_editor_desc">
       				<?php echo wp_kses_post( $this->description ); ?>
       			</span>
       		</label>
       		<?php
       	}
    }//editor close
    
}//class close

