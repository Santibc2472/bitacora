<?php
/**
 * Help Panel.
 *
 * @package Restaurant_And_Cafe
 */
?>
<!-- Help file panel -->
<div id="help-panel" class="panel-left">

    <div class="panel-aside">
        <h4><?php esc_html_e( 'View Our Documentation Link', 'restaurant-and-cafe' ); ?></h4>
        <p><?php esc_html_e( 'Are you new to the WordPress world? Our step by step easy documentation guide will help you create an attractive and engaging website without any prior coding knowledge or experience.', 'restaurant-and-cafe' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://docs.rarathemes.com/docs/restaurant-and-cafe/' ); ?>" title="<?php esc_attr_e( 'Visit the Documentation', 'restaurant-and-cafe' ); ?>" target="_blank">
            <?php esc_html_e( 'View Documentation', 'restaurant-and-cafe' ); ?>
        </a>
    </div><!-- .panel-aside -->
    
    <div class="panel-aside">
        <h4><?php esc_html_e( 'Support Ticket', 'restaurant-and-cafe' ); ?></h4>
        <p><?php printf( __( 'It\'s always better to visit our %1$sDocumentation Guide%2$s before you send us a support query.', 'restaurant-and-cafe' ), '<a href="'. esc_url( 'https://docs.rarathemes.com/docs/restaurant-and-cafe/' ) .'" target="_blank">', '</a>' ); ?></p>
        <p><?php printf( __( 'If the Documentation Guide didn\'t help you, contact us via our %1$sSupport Ticket%2$s. We reply to all the support queries within one business day, except on the weekends.', 'restaurant-and-cafe' ), '<a href="'. esc_url( 'https://rarathemes.com/support-ticket/' ) .'" target="_blank">', '</a>' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://rarathemes.com/support-ticket/' ); ?>" title="<?php esc_attr_e( 'Visit the Support', 'restaurant-and-cafe' ); ?>" target="_blank">
            <?php esc_html_e( 'Contact Support', 'restaurant-and-cafe' ); ?>
        </a>
    </div><!-- .panel-aside -->

    <div class="panel-aside">
        <h4><?php esc_html_e( 'View Our Restaurant And Cafe Demo', 'restaurant-and-cafe' ); ?></h4>
        <p><?php esc_html_e( 'Visit the demo to get more idea about our theme design and its features.', 'restaurant-and-cafe' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://demo.rarathemes.com/restaurant-and-cafe/' ); ?>" title="<?php esc_attr_e( 'Visit the Demo', 'restaurant-and-cafe' ); ?>" target="_blank">
            <?php esc_html_e( 'View Demo', 'restaurant-and-cafe' ); ?>
        </a>
    </div><!-- .panel-aside -->
</div>