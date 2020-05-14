<?php
/**
 * Map Section 
 * 
 * @package Restaurant_and_Cafe
 */            


    $iframe = get_theme_mod('restaurant_and_cafe_gmap');
        if($iframe){
            echo '<div class="map">';
            echo  restaurant_and_cafe_sanitize_iframe( $iframe );
            echo '</div>';
        }
              