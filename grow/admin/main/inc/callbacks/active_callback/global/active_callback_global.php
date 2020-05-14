<?php
/**
 * The active callbacks used for theme options.
 *
 * @package ThinkUpThemes
 */
 
function thinkup_customizer_callback_active_global( $control ) {

	$control_id = $control->id;

	// ==========================================================================================
	// 1. CALLBACK SECTION - GET DEPENDENT VALUES
	// ==========================================================================================

	// General Settings
	$thinkup_general_layout            = $control->manager->get_setting('thinkup_redux_variables[thinkup_general_layout]')->value();
	$thinkup_general_breadcrumbswitch  = $control->manager->get_setting('thinkup_redux_variables[thinkup_general_breadcrumbswitch]')->value();

	// Homepage
	$thinkup_homepage_layout           = $control->manager->get_setting('thinkup_redux_variables[thinkup_homepage_layout]')->value();
	$thinkup_homepage_sliderswitch     = $control->manager->get_setting('thinkup_redux_variables[thinkup_homepage_sliderswitch]')->value();
	$thinkup_homepage_introactionlink1 = $control->manager->get_setting('thinkup_redux_variables[thinkup_homepage_introactionlink1]')->value();

	// Social Media
	$thinkup_header_facebookswitch     = $control->manager->get_setting('thinkup_redux_variables[thinkup_header_facebookswitch]')->value();
	$thinkup_header_twitterswitch      = $control->manager->get_setting('thinkup_redux_variables[thinkup_header_twitterswitch]')->value();
	$thinkup_header_googleswitch       = $control->manager->get_setting('thinkup_redux_variables[thinkup_header_googleswitch]')->value();
	$thinkup_header_linkedinswitch     = $control->manager->get_setting('thinkup_redux_variables[thinkup_header_linkedinswitch]')->value();
	$thinkup_header_flickrswitch       = $control->manager->get_setting('thinkup_redux_variables[thinkup_header_flickrswitch]')->value();
	$thinkup_header_youtubeswitch      = $control->manager->get_setting('thinkup_redux_variables[thinkup_header_youtubeswitch]')->value();
	$thinkup_header_rssswitch          = $control->manager->get_setting('thinkup_redux_variables[thinkup_header_rssswitch]')->value();

	// Blog
	$thinkup_blog_layout               = $control->manager->get_setting('thinkup_redux_variables[thinkup_blog_layout]')->value();
	$thinkup_post_layout               = $control->manager->get_setting('thinkup_redux_variables[thinkup_post_layout]')->value();


	// ==========================================================================================
	// 2. CALLBACK CONTROLS - SHOW / HIDE CONTROLS
	// ==========================================================================================

	// General Settings - Page Layout
	if ( ( $thinkup_general_layout == 'option2' or $thinkup_general_layout == 'option3' ) and 
			$control_id == 'thinkup_general_sidebars' ) {
		return true;
	}

	// General Settings - Enable Breadcrumbs
	if ( $thinkup_general_breadcrumbswitch == '1' and
			$control_id == 'thinkup_general_breadcrumbdelimeter' ) {
		return true;
	}

	// Homepage - Homepage Layout
	if ( ( $thinkup_homepage_layout == 'option2' or $thinkup_homepage_layout == 'option3' ) and 
			$control_id == 'thinkup_homepage_sidebars' ) {
		return true;
	}

	// Homepage - Homepage Slider Shortcode
	if ( $thinkup_homepage_sliderswitch == 'option2' and
			  $control_id == 'thinkup_homepage_slidername' ) {
		return true;
	}

	// Homepage - Choose Homepage Slider
	if ( $thinkup_homepage_sliderswitch == 'option4' and
			( $control_id == 'thinkup_homepage_sliderimage1_info' or 
			  $control_id == 'thinkup_homepage_sliderimage1_image' or 
			  $control_id == 'thinkup_homepage_sliderimage1_title' or 
			  $control_id == 'thinkup_homepage_sliderimage1_desc' or 
			  $control_id == 'thinkup_homepage_sliderimage1_link' or 
			  $control_id == 'thinkup_homepage_sliderimage2_info' or 
			  $control_id == 'thinkup_homepage_sliderimage2_image' or 
			  $control_id == 'thinkup_homepage_sliderimage2_title' or 
			  $control_id == 'thinkup_homepage_sliderimage2_desc' or 
			  $control_id == 'thinkup_homepage_sliderimage2_link' or 
			  $control_id == 'thinkup_homepage_sliderimage3_info' or 
			  $control_id == 'thinkup_homepage_sliderimage3_image' or 
			  $control_id == 'thinkup_homepage_sliderimage3_title' or 
			  $control_id == 'thinkup_homepage_sliderimage3_desc' or 
			  $control_id == 'thinkup_homepage_sliderimage3_link' or 
			  $control_id == 'thinkup_homepage_sliderpageinfo' or 
			  $control_id == 'thinkup_homepage_sliderpresetheight' or
			  $control_id == 'thinkup_homepage_sliderpresetwidth' ) ) {
		return true;
	}

	// Homepage - Call To Action - Intro
	if ( $thinkup_homepage_introactionlink1 == 'option1' and
			$control_id == 'thinkup_homepage_introactionpage1' ) {
		return true;
	} else if ( $thinkup_homepage_introactionlink1 == 'option2' and
			$control_id == 'thinkup_homepage_introactioncustom1' ) {
		return true;
	}

	// Social Media - Facebook
	if ( $thinkup_header_facebookswitch == '1' and
			( $control_id == 'thinkup_header_facebooklink' or 
			  $control_id == 'thinkup_header_facebookiconswitch' or
			  $control_id == 'thinkup_header_facebookcustomicon' ) ) {
		return true;
	}

	// Social Media - Twitter
	if ( $thinkup_header_twitterswitch == '1' and
			( $control_id == 'thinkup_header_twitterlink' or 
			  $control_id == 'thinkup_header_twittericonswitch' or
			  $control_id == 'thinkup_header_twittercustomicon' ) ) {
		return true;
	}

	// Social Media - Google
	if ( $thinkup_header_googleswitch == '1' and
			( $control_id == 'thinkup_header_googlelink' or 
			  $control_id == 'thinkup_header_googleiconswitch' or
			  $control_id == 'thinkup_header_googlecustomicon' ) ) {
		return true;
	}

	// Social Media - LinkedIn
	if ( $thinkup_header_linkedinswitch == '1' and
			( $control_id == 'thinkup_header_linkedinlink' or 
			  $control_id == 'thinkup_header_linkediniconswitch' or
			  $control_id == 'thinkup_header_linkedincustomicon' ) ) {
		return true;
	}

	// Social Media - Flickr
	if ( $thinkup_header_flickrswitch == '1' and
			( $control_id == 'thinkup_header_flickrlink' or 
			  $control_id == 'thinkup_header_flickriconswitch' or
			  $control_id == 'thinkup_header_flickrcustomicon' ) ) {
		return true;
	}

	// Social Media - YouTube
	if ( $thinkup_header_youtubeswitch == '1' and
			( $control_id == 'thinkup_header_youtubelink' or 
			  $control_id == 'thinkup_header_youtubeiconswitch' or
			  $control_id == 'thinkup_header_youtubecustomicon' ) ) {
		return true;
	}

	// Social Media - RSS
	if ( $thinkup_header_rssswitch == '1' and
			( $control_id == 'thinkup_header_rsslink' or 
			  $control_id == 'thinkup_header_rssiconswitch' or
			  $control_id == 'thinkup_header_rsscustomicon' ) ) {
		return true;
	}

	// Blog - Blog Layout
	if ( ( $thinkup_blog_layout == 'option2' or $thinkup_blog_layout == 'option3' ) and 
			$control_id == 'thinkup_blog_sidebars' ) {
		return true;
	}

	// Blog - Post Layout
	if ( ( $thinkup_post_layout == 'option2' or $thinkup_post_layout == 'option3' ) and 
			$control_id == 'thinkup_post_sidebars' ) {
		return true;
	}

	return false;
}