<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wedding Band 
 */
    $restaurant_and_cafe_enabled_sections       = restaurant_and_cafe_get_sections();
    $restaurant_and_cafe_ed_slider_section      = get_theme_mod( 'restaurant_and_cafe_ed_slider_section' );
    $restaurant_and_cafe_testimonial_section_bg = get_theme_mod( 'restaurant_and_cafe_testimonial_section_bg' );
    $restaurant_and_cafe_reservation_section_bg = get_theme_mod( 'restaurant_and_cafe_reservation_section_bg' );

get_header(); 
            
    if ( 'posts' == get_option( 'show_on_front' ) ) {

        include( get_home_template() );

    }elseif( $restaurant_and_cafe_enabled_sections ){ 

        foreach( $restaurant_and_cafe_enabled_sections as $restaurant_and_cafe_section ){ 
            
            if ( $restaurant_and_cafe_section['id'] == "about" ) { 

                 do_action('restaurant_and_cafe_about');

            }elseif ( $restaurant_and_cafe_section['id'] == "testimonial") { ?>

                <section class="<?php echo esc_attr( $restaurant_and_cafe_section['class'] ); ?>" id="<?php echo esc_attr( $restaurant_and_cafe_section['id'] ); ?>" <?php if( $restaurant_and_cafe_testimonial_section_bg ) echo 'style="background: url(' . esc_url( $restaurant_and_cafe_testimonial_section_bg ) . ')no-repeat; background-size: cover; background-position: center; "';?> >
                    <?php get_template_part( 'sections/section', esc_attr( $restaurant_and_cafe_section['id'] ) ); ?>
                </section>

            <?php }elseif ( $restaurant_and_cafe_section['id'] == "reservation") { ?>  

                <section class="<?php echo esc_attr( $restaurant_and_cafe_section['class'] ); ?>" id="<?php echo esc_attr( $restaurant_and_cafe_section['id'] ); ?>" <?php if( $restaurant_and_cafe_reservation_section_bg ) echo 'style="background: url(' . esc_url( $restaurant_and_cafe_reservation_section_bg ) . ')no-repeat; background-size: cover; background-position: center; "';?> >
                    <?php get_template_part( 'sections/section', esc_attr( $restaurant_and_cafe_section['id'] ) ); ?>
                </section>

            <?php 
            }else{ ?>
                <section class="<?php echo esc_attr( $restaurant_and_cafe_section['class'] ); ?>" id="<?php echo esc_attr( $restaurant_and_cafe_section['id'] ); ?>">
                    <?php get_template_part( 'sections/section', esc_attr( $restaurant_and_cafe_section['id'] ) ); ?>
                </section>
            <?php
            }
        }      
    }else {

        include( get_page_template() );

    }
                  
get_footer();