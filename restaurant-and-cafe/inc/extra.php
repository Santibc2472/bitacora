<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Restaurant_and_Cafe
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function restaurant_and_cafe_body_classes( $classes ) {
  $restaurant_and_cafe_ed_slider = get_theme_mod( 'restaurant_and_cafe_ed_slider' ); 

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

  // Adds a class of custom-background-image to sites with a custom background image.
  if ( get_background_image() ) {
    $classes[] = 'custom-background-image';
  }
    
  // Adds a class of custom-background-color to sites with a custom background color.
  if ( get_background_color() != 'ffffff' ) {
    $classes[] = 'custom-background-color';
  }

  if( !( is_active_sidebar( 'right-sidebar' ) ) || is_page_template( 'template-home.php' ) ) {
    $classes[] = 'full-width'; 

  }elseif( is_page() ){

    $restaurant_and_cafe_post_class = restaurant_and_cafe_sidebar_layout();      
    if( $restaurant_and_cafe_post_class == 'no-sidebar' )
      $classes[] = 'full-width';

  }else{
    $classes[] = '';
  }

	return $classes;
}
add_filter( 'body_class', 'restaurant_and_cafe_body_classes' );

/**
 * Custom Bread Crumb
 *
 * @link http://www.qualitytuts.com/wordpress-custom-breadcrumbs-without-plugin/
 */
 
function restaurant_and_cafe_breadcrumbs_cb() {
 
  if( get_theme_mod( 'restaurant_and_cafe_ed_breadcrumb' ) && ! is_404() ){ 
        
    global $post;
    
    $post_page   = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front  = get_option( 'show_on_front' ); //What to show on the front page
    $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter   = get_theme_mod( 'restaurant_and_cafe_breadcrumb_separator', __( '>', 'restaurant-and-cafe' ) ); // delimiter between crumbs
    $home        = get_theme_mod( 'restaurant_and_cafe_breadcrumb_home_text', __( 'Home', 'restaurant-and-cafe' ) ); // text for the 'Home' link
    $showCurrent = get_theme_mod( 'restaurant_and_cafe_ed_current', '1' ); // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before      = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb        
 
    $depth = 1;
    echo '<div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url() ) . '"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
    
    if( is_home() ){
        $depth = 2;
        echo $before . '<a itemprop="item" href="'. esc_url( get_the_permalink() ) .'"><span itemprop="name">' . esc_html( single_post_title( '', false ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
            
    }elseif( is_category() ){
        $depth = 2;
        $thisCat = get_category( get_query_var( 'cat' ), false );

        if( $show_front === 'page' && $post_page ){ //If static blog post page is set
            $p = get_post( $post_page );
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $post_page ) ) . '"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
            $depth ++;  
        }

        if ( $thisCat->parent != 0 ) {
            $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
            $parent_categories = explode( ',', $parent_categories );

            foreach ( $parent_categories as $parent_term ) {
                $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                if( is_object( $parent_obj ) ){
                    $term_url    = get_term_link( $parent_obj->term_id );
                    $term_name   = $parent_obj->name;
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
                    $depth ++;
                }
            }
        }
        echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $thisCat->term_id) ) . '"><span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
    
    }elseif(restaurant_and_cafe_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){ //For Woocommerce archive page
        
        $depth = 2;
        $current_term = $GLOBALS['wp_query']->get_queried_object();
        if( is_product_category() ){
            $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor ) {
                $ancestor = get_term( $ancestor, 'product_cat' );    
                if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
                    $depth ++;
                }
            }
        }           
        echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $current_term->term_id ) ) . '"><span itemprop="name">' . esc_html( $current_term->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        
    } elseif(restaurant_and_cafe_woocommerce_activated() && is_shop() ){ //Shop Archive page
        $depth = 2;
        if ( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ) {
            return;
        }
        $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
        $shop_url = wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );

        if ( ! $_name ) {
            $product_post_type = get_post_type_object( 'product' );
            $_name = $product_post_type->labels->singular_name;
        }
        echo $before . '<a itemprop="item" href="' . esc_url( $shop_url ) . '"><span itemprop="name">' . esc_html( $_name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        
    }elseif( is_tag() ){
        $queried_object = get_queried_object();
        $depth = 2;

        echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( single_tag_title( '', false ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
 
    }elseif( is_author() ){
        $depth = 2;
        global $author;

        $userdata = get_userdata( $author );
        echo $before . '<a itemprop="item" href="' . esc_url( get_author_posts_url( $author ) ) . '"><span itemprop="name">' . esc_html( $userdata->display_name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
 
    }elseif( is_search() ){
        $depth = 2;
        $request_uri = $_SERVER['REQUEST_URI'];
        echo $before .'<a itemprop="item" href="'. esc_url( $request_uri ) .'"><span itemprop="name">'. esc_html__( 'Search Results for "', 'restaurant-and-cafe' ) . esc_html( get_search_query() ) . esc_html__( '"', 'restaurant-and-cafe' ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
    
    }elseif( is_day() ){
        $depth = 2;
        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
        $depth ++;
        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ), get_the_time( __( 'm', 'restaurant-and-cafe' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'restaurant-and-cafe' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
        $depth ++;
        echo $before .'<a itemprop="item" href="' . esc_url( get_day_link( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ), get_the_time( __( 'm', 'restaurant-and-cafe' ) ), get_the_time( __( 'd', 'restaurant-and-cafe' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'd', 'restaurant-and-cafe' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
    
    }elseif( is_month() ){
        $depth = 2;
        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
        $depth++;
        echo $before .'<a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ), get_the_time( __( 'm', 'restaurant-and-cafe' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'F', 'restaurant-and-cafe' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
    
    }elseif( is_year() ){
        $depth = 2;
        echo $before .'<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'restaurant-and-cafe' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;

    }elseif( is_single() && !is_attachment() ){
        $depth = 2;
        if( restaurant_and_cafe_woocommerce_activated() && 'product' === get_post_type() ){ //For Woocommerce single product
            /** NEED TO CHECK THIS PORTION WHILE INTEGRATION WITH WOOCOMMERCE */
            if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, 'product_cat' );    
                    if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
                        $depth++;
                    }
                }
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $main_term ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $main_term->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
            }
            
            echo $before .'<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
            
        }elseif ( get_post_type() != 'post' ){
            $post_type = get_post_type_object( get_post_type() );
            
            if( $post_type->has_archive == true ){// For CPT Archive Link
               
               // Add support for a non-standard label of 'archive_title' (special use case).
               $label = !empty( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $post_type->labels->name;
               printf( '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a><meta itemprop="position" content="%3$s" />', esc_url( get_post_type_archive_link( get_post_type() ) ), $label, $depth );
               echo '<meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
               $depth ++;

            }
            echo $before .'<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
            
        }else{ //For Post
            $cat_object       = get_the_category();
            $potential_parent = 0;
            $depth            = 2;
            
            if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                $p = get_post( $post_page );
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';  
                $depth++;
            }
            
            if( is_array( $cat_object ) ){ //Getting category hierarchy if any
    
                //Now try to find the deepest term of those that we know of
                $use_term = key( $cat_object );
                foreach( $cat_object as $key => $object )
                {
                    //Can't use the next($cat_object) trick since order is unknown
                    if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                        $use_term = $key;
                        $potential_parent = $object->term_id;
                    }
                }
                
                $cat = $cat_object[$use_term];
          
                $cats = get_category_parents( $cat, false, ',' );
                $cats = explode( ',', $cats );

                foreach ( $cats as $cat ) {
                    $cat_obj = get_term_by( 'name', $cat, 'category' );
                    if( is_object( $cat_obj ) ){
                        $term_url    = get_term_link( $cat_obj->term_id );
                        $term_name   = $cat_obj->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . esc_html( $delimiter ) . '</span></span>';
                        $depth ++;
                    }
                }
            }

            echo $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
            
        }
    
    }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){
        $depth = 2;
        $post_type = get_post_type_object(get_post_type());
        if( get_query_var('paged') ){
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />';
            echo ' <span class="separator">' . esc_html( $delimiter ) . '</span></span> ' . $before . sprintf( __('Page %s', 'restaurant-and-cafe'), get_query_var('paged') ) . $after;
        }elseif( is_archive() ){
            echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( post_type_archive_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }else{
            echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }

    }elseif( is_attachment() ){
        $depth = 2;
        $parent = get_post( $post->post_parent );
        $cat = get_the_category( $parent->ID ); 
        if( $cat ){
            $cat = $cat[0];
            echo get_category_parents( $cat, TRUE, ' <span class="separator">' . esc_html( $delimiter ) . '</span> ');
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $parent ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $parent->post_title ) . '<span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . ' <span class="separator">' . esc_html( $delimiter ) . '</span></span>';
        }
        echo  $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
    
    }elseif( is_page() && !$post->post_parent ){
        $depth = 2;
        echo $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;

    }elseif( is_page() && $post->post_parent ){
        $depth = 2;
        $parent_id  = $post->post_parent;
        $breadcrumbs = array();
        
        while( $parent_id ){
            $page = get_post( $parent_id );
            $breadcrumbs[] = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $page->ID ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $page->ID ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /></span>';
            $parent_id  = $page->post_parent;
            $depth++;
        }
        $breadcrumbs = array_reverse( $breadcrumbs );
        for ( $i = 0; $i < count( $breadcrumbs) ; $i++ ){
            echo $breadcrumbs[$i];
            if ( $i != count( $breadcrumbs ) - 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
        }
        echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' . $before .'<a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" /></span>'. $after;
    
    }elseif( is_404() ){
        echo $before . esc_html__( '404 Error - Page Not Found', 'restaurant-and-cafe' ) . $after;
    }
    
    if( get_query_var('paged') ) echo __( ' (Page', 'restaurant-and-cafe' ) . ' ' . get_query_var('paged') . __( ')', 'restaurant-and-cafe' );
 
    echo '</div>';
    }
} 
add_action( 'restaurant_and_cafe_breadcrumbs', 'restaurant_and_cafe_breadcrumbs_cb' );

/**
 * Callback function for Comment List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
 
 function restaurant_and_cafe_comment($comment, $args, $depth) {
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
	<?php endif; ?>
	
    <footer class="comment-meta">
    
        <div class="comment-author vcard">
    	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    	<?php printf( __( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b>', 'restaurant-and-cafe' ), get_comment_author_link() ); ?>
    	</div>
    	<?php if ( $comment->comment_approved == '0' ) : ?>
    		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'restaurant-and-cafe' ); ?></em>
    		<br />
    	<?php endif; ?>
    
    	<div class="comment-metadata commentmetadata">
            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_date(); ?>"><?php echo get_comment_date(); ?></time></a><?php edit_comment_link( __( '(Edit)', 'restaurant-and-cafe' ), '  ', '' ); ?>
    	</div>
    </footer>
    
    <div class="comment-content"><?php comment_text(); ?></div>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/** Function to get Sections */
function restaurant_and_cafe_get_sections(){

$restaurant_and_cafe_sections = array( 

    'banner-section' => array(
        'class' => 'banner',
        'id'    => 'slider'

    ),

    'featured-section' => array(
        'class' => 'section-1',
        'id'    => 'featured'    
    ),
    
    'about-section' => array(
        'class' => 'section-2',
        'id'    => 'about'    
    ),

    'services-section' => array(
        'class' => 'section-3',
        'id'    => 'service'    
    ),
    
    'testimonial-section' => array(
        'class' => 'section-4',
        'id'    => 'testimonial'    
    ),

    'tabmenu-section' => array(
        'class' => 'section-5',
        'id'    => 'tabmenu'    
    ),
    
    'reservation-section' => array(
        'class' => 'section-6',
        'id'    => 'reservation'    
    ),

    'blog-section' => array(
        'class' => 'blog-section',
        'id'    => 'blog'
    ),

    'map-section' => array(
        'class'  => 'map',
        'id'     => 'home_map'
    )
      
);


$restaurant_and_cafe_enabled_section = array();
foreach ( $restaurant_and_cafe_sections as $restaurant_and_cafe_section ) {
    
    if ( esc_attr( get_theme_mod( 'restaurant_and_cafe_ed_' . $restaurant_and_cafe_section['id'] . '_section' ) ) == 1 ){
        $restaurant_and_cafe_enabled_section[] = array(
            'id' => $restaurant_and_cafe_section['id'],
            'class' => $restaurant_and_cafe_section['class']
        );
    }
}
return $restaurant_and_cafe_enabled_section;
}


/** CallBack function for Banner */
function restaurant_and_cafe_banner_cb(){
$restaurant_and_cafe_ed_slider_section = get_theme_mod( 'restaurant_and_cafe_ed_slider_section' );
$restaurant_and_cafe_banner_post       = get_theme_mod( 'restaurant_and_cafe_banner_post' );
$restaurant_and_cafe_banner_read_more  = get_theme_mod( 'restaurant_and_cafe_banner_read_more',  __( 'Get Started', 'restaurant-and-cafe' ) );
?>
    <?php 
        if( $restaurant_and_cafe_ed_slider_section ){
            
            $banner_qry = new WP_Query( array( 'p' => $restaurant_and_cafe_banner_post ) );
            
            if( $banner_qry->have_posts() ){
                while( $banner_qry->have_posts() ){
                    $banner_qry->the_post();
                    $categories_list = get_the_category_list( esc_html__( ', ', 'restaurant-and-cafe' ) );
                    if( has_post_thumbnail() ){
                        the_post_thumbnail( 'restaurant-and-cafe-banner', array( 'itemprop' => 'image' ) );
                    ?>
                    <div class="banner-text">
                    <div class="container">
                    <div class="text">
                      <strong class="title"><?php the_title(); ?></strong>
                      <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?> " class="btn-green"><?php echo esc_html( $restaurant_and_cafe_banner_read_more ); ?></a>
                    </div>
                    </div>
                    </div>
                  <div class="btn-scroll-down"><button><?php esc_html_e('scroll Down','restaurant-and-cafe'); ?></button></div><div id="next_section"></div>
                    <?php
                    }
                }
                wp_reset_postdata();
            }
            
        }
    ?>
<?php
}

add_action( 'restaurant_and_cafe_banner', 'restaurant_and_cafe_banner_cb' );

function restaurant_and_cafe_author_info_box_cb( ) {
    if( get_the_author_meta( 'description' ) ){
        global $post;
    ?>
    <section class="author">
        <div class="img-holder"><?php echo get_avatar( get_the_author_meta( 'ID' ), 126 ); ?></div>
            <div class="text-holder">
                <strong class="name"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></strong>
                <?php echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ); ?>
            </div>
    </section>
    <?php  
    }  
}
add_action( 'restaurant_and_cafe_author_info_box', 'restaurant_and_cafe_author_info_box_cb' );

/** Callback Function for about Block */
function restaurant_and_cafe_about_cb(){

$restaurant_and_cafe_about_section_bg = get_theme_mod('restaurant_and_cafe_about_section_bg');
$restaurant_and_cafe_about_section_page = get_theme_mod( 'restaurant_and_cafe_about_section_page' );
    

    ?>
    <section class="section-2" id="<?php echo esc_html( 'about' ); ?>" <?php if( $restaurant_and_cafe_about_section_bg ) echo 'style="background: url(' . esc_url( $restaurant_and_cafe_about_section_bg ) . '); background-size: cover; background-repeat: no-repeat; background-position: center;"';?> >
<?php
 if($restaurant_and_cafe_about_section_page){

  $about_qry = new WP_Query( array( 
                    'post_type'             => 'page',
                    'post__in'              => array( $restaurant_and_cafe_about_section_page ),
                    'post_status'           => 'publish',
                    'posts_per_page'        => -1,
                    'ignore_sticky_posts'   => true ) );

 ?>

  <div class="container">
    <div class="holder">
    <?php
      if( $about_qry->have_posts() ){                
                    while( $about_qry->have_posts() ){
                        $about_qry->the_post(); ?>
            <div class="row">
               <div class="col">
                <div class="images">                    
                <?php 
                    if( has_post_thumbnail() ){
                        the_post_thumbnail( 'restaurant-and-cafe-about-section', array( 'itemprop' => 'image' ) ); 
                    }else{
                        restaurant_and_cafe_get_fallback_svg( 'restaurant-and-cafe-about-section' );
                    }
                ?>
                </div>
                 </div>
              <div class="col">
                <div class="text-holder">
                <?php
                   the_title( '<h2 class="main-title">', '</h2>' );  
                       the_excerpt();
                    ?>
                </div>
              </div>
            </div>
            <?php } 

            wp_reset_postdata();

          } ?>
    </div>
  </div>
<?php } ?>
</section>
<?php
 } 
 add_action( 'restaurant_and_cafe_about', 'restaurant_and_cafe_about_cb' ); 

/**
 * Return sidebar layouts for pages
*/
function restaurant_and_cafe_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'restaurant_and_cafe_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'restaurant_and_cafe_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
    
}

if ( ! function_exists( 'restaurant_and_cafe_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function restaurant_and_cafe_excerpt_more( $more ) {
  return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'restaurant_and_cafe_excerpt_more' );


if ( ! function_exists( 'restaurant_and_cafe_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function restaurant_and_cafe_excerpt_length( $length ) {
  if( is_front_page() || is_page_template('template-home.php') ){
    return is_admin() ? $length : 30;
  }else{   return is_admin() ? $length : 45;}
}
endif;
add_filter( 'excerpt_length', 'restaurant_and_cafe_excerpt_length', 999 );


/**
 * Footer Credits 
*/
function restaurant_and_cafe_footer_credit(){
    $copyright_text = get_theme_mod( 'restaurant_and_cafe_footer_copyright_text' );
?>
    <div class="site-info">
        <?php 
        if( $copyright_text ){
            echo wp_kses_post( $copyright_text );
        }else{
            echo esc_html__( 'Copyright &copy; ', 'restaurant-and-cafe' ) . date_i18n('Y'); ?> 
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>.  
        <?php } ?>
        <span class="by">
        <?php echo esc_html__( 'Restaurant And Cafe | Developed By', 'restaurant-and-cafe' ); ?>
        <a href="<?php echo esc_url( 'https://rarathemes.com/' ); ?>" rel="nofollow" target="_blank"><?php echo esc_html__( 'Rara Theme', 'restaurant-and-cafe' ); ?></a>.
        <?php printf( esc_html__( 'Powered by %s', 'restaurant-and-cafe' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'restaurant-and-cafe' ) ) .'" target="_blank">WordPress.</a>' ); ?>
        </span>
        <?php  
            if ( function_exists( 'the_privacy_policy_link' ) ) {
                the_privacy_policy_link( '<span class="policy_link">', '</span>');
            }
         ?>
    </div>

<?php
}
add_action( 'restaurant_and_cafe_footer', 'restaurant_and_cafe_footer_credit' );

/**
 * Escape iframe
*/
function restaurant_and_cafe_sanitize_iframe( $iframe ){
        $allow_tag = array(
            'iframe'=>array(
                'src'             => array()
            ) );
    return wp_kses( $iframe, $allow_tag );
    }

/**
 * Custom CSS
*/
function restaurant_and_cafe_custom_css(){
    $custom_css = get_theme_mod( 'restaurant_and_cafe_custom_css' );
    if( $custom_css ){
        echo '<style type="text/css" media="all">';
        echo wp_strip_all_tags( $custom_css );
        echo '</style>';
    }
}
add_action( 'wp_head', 'restaurant_and_cafe_custom_css', 101 );

if( ! function_exists( 'restaurant_and_cafe_single_post_schema' ) ) :
/**
 * Single Post Schema
 *
 * @return string
 */
function restaurant_and_cafe_single_post_schema() {
    if ( is_singular( 'post' ) ) {
        global $post;
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        $site_logo   = wp_get_attachment_image_src( $custom_logo_id , 'restaurant-and-cafe-schema' );
        $images      = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $excerpt     = restaurant_and_cafe_escape_text_tags( $post->post_excerpt );
        $content     = $excerpt === "" ? mb_substr( restaurant_and_cafe_escape_text_tags( $post->post_content ), 0, 110 ) : $excerpt;
        $schema_type = ! empty( $custom_logo_id ) && has_post_thumbnail( $post->ID ) ? "BlogPosting" : "Blog";

        $args = array(
            "@context"  => "http://schema.org",
            "@type"     => $schema_type,
            "mainEntityOfPage" => array(
                "@type" => "WebPage",
                "@id"   => get_permalink( $post->ID )
            ),
            "headline"  => get_the_title( $post->ID ),
            "image"     => array(
                "@type"  => "ImageObject",
                "url"    => $images[0],
                "width"  => $images[1],
                "height" => $images[2]
            ),
            "datePublished" => get_the_time( DATE_ISO8601, $post->ID ),
            "dateModified"  => get_post_modified_time(  DATE_ISO8601, __return_false(), $post->ID ),
            "author"        => array(
                "@type"     => "Person",
                "name"      => restaurant_and_cafe_escape_text_tags( get_the_author_meta( 'display_name', $post->post_author ) )
            ),
            "publisher" => array(
                "@type"       => "Organization",
                "name"        => get_bloginfo( 'name' ),
                "description" => get_bloginfo( 'description' ),
                "logo"        => array(
                    "@type"   => "ImageObject",
                    "url"     => $site_logo[0],
                    "width"   => $site_logo[1],
                    "height"  => $site_logo[2]
                )
            ),
            "description" => ( class_exists('WPSEO_Meta') ? WPSEO_Meta::get_value( 'metadesc' ) : $content )
        );

        if ( has_post_thumbnail( $post->ID ) ) :
            $args['image'] = array(
                "@type"  => "ImageObject",
                "url"    => $images[0],
                "width"  => $images[1],
                "height" => $images[2]
            );
        endif;

        if ( ! empty( $custom_logo_id ) ) :
            $args['publisher'] = array(
                "@type"       => "Organization",
                "name"        => get_bloginfo( 'name' ),
                "description" => get_bloginfo( 'description' ),
                "logo"        => array(
                    "@type"   => "ImageObject",
                    "url"     => $site_logo[0],
                    "width"   => $site_logo[1],
                    "height"  => $site_logo[2]
                )
            );
        endif;

        echo '<script type="application/ld+json">' , PHP_EOL;
        if ( version_compare( PHP_VERSION, '5.4.0' , '>=' ) ) {
            echo wp_json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
        } else {
            echo wp_json_encode( $args ) , PHP_EOL;
        }
        echo '</script>' , PHP_EOL;
    }
}
endif;
add_action( 'wp_head', 'restaurant_and_cafe_single_post_schema' );

if( ! function_exists( 'restaurant_and_cafe_escape_text_tags' ) ) :
/**
 * Remove new line tags from string
 *
 * @param $text
 * @return string
 */
function restaurant_and_cafe_escape_text_tags( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

if( ! function_exists( 'restaurant_and_cafe_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function restaurant_and_cafe_admin_notice(){
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'restaurant_and_cafe_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();
    
    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'restaurant-and-cafe' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'restaurant-and-cafe' ), $name ) ; ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=restaurant-and-cafe-getting-started' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the getting started.', 'restaurant-and-cafe' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?restaurant_and_cafe_admin_notice=1"><?php esc_html_e( 'Dismiss', 'restaurant-and-cafe' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'restaurant_and_cafe_admin_notice' );

if( ! function_exists( 'restaurant_and_cafe_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function restaurant_and_cafe_update_admin_notice(){
    if ( isset( $_GET['restaurant_and_cafe_admin_notice'] ) && $_GET['restaurant_and_cafe_admin_notice'] = '1' ) {
        update_option( 'restaurant_and_cafe_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'restaurant_and_cafe_update_admin_notice' );

if( ! function_exists( 'restaurant_and_cafe_restore_admin_notice' ) ) :
/**
 * Restoring admin notice on theme switch
 */
function restaurant_and_cafe_restore_admin_notice(){
    update_option( 'restaurant_and_cafe_admin_notice', false );
}
endif;
add_action( 'after_switch_theme', 'restaurant_and_cafe_restore_admin_notice' );

if( ! function_exists( 'restaurant_and_cafe_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function restaurant_and_cafe_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'restaurant_and_cafe_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function restaurant_and_cafe_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = restaurant_and_cafe_get_image_sizes( $post_thumbnail );
     
    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#dedbdb;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;
