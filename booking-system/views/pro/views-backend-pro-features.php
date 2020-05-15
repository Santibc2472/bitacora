<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : views/pro/views-backend-pro-features.php
* File Version            : 1.0.8
* Created / Last Modified : 19 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end pro views class.
*/

    if (!class_exists('DOPBSPViewsBackEndPROFeatures')){
        class DOPBSPViewsBackEndPROFeatures extends DOPBSPViewsBackEndPRO{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns pro features template.
             * 
             * @param args (array): function arguments
             * 
             * @return pro features HTML template
             */
            function template($args = array()){
                global $DOPBSP;
?>            
            <section class="dopbsp-content-wrapper">
                <h3><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_TITLE');?></h3>
                <p><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_DESCRIPTION');?></p>
                
                <div id="DOPBSP-get-features-all" class="DOPBSP-pro-tips dopbsp-left">
                    
                    <table class="doptable features">
                        <colgroup>
                        <col>
                        <col>
                        <col>
                        </colgroup>
                        <thead>
                        <tr>
                        <th><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_TITLE');?></th>
                        <th><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_STANDARD');?></th>
                        <th>PRO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>
                        <h5 class="title"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_PRICING');?></h5>
                        </td>
                        <td>
                        <h6>FREE</h6>
                        <p>            <a href="https://wordpress.org/plugins/booking-system/" target="_blank" class="download"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_DOWNLOAD');?></a>
                                </p></td>
                        <td>
                        <h6><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_FROM');?> $70</h6>
                        <p>            <a href="https://pinpoint.world/shop/product/pinpoint-booking-system-wordpress-plugin-pro-version-1?utm_source=WordPress&utm_medium=Plugin%20FREE" target="_blank" class="buy"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_BUY');?></a>
                                </p></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CALENDARS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=17; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_LOCATIONS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=3; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_LOCATIONS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_DAYS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=9; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_DAYS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_HOURS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=8; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_HOURS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_WOO_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=4; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_WOO_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_LANGUAGES_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=6; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_LANGUAGES_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CURRENCIES_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=3; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CURRENCIES_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=6; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_SYNCHRONIZATION_TITLE');?></h5>
                        <ul class="doplist green">
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_SYNCHRONIZATION_TEXT1');?> </li>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_RULES_TITLE');?></h5>
                        <ul class="doplist green">
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_RULES_TEXT1');?> </li>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_EXTRAS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=5; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_EXTRAS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_DISCOUNTS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=4; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_DISCOUNTS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_FEES_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=5; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_FEES_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_COUPONS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=4; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_COUPONS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_EMAILS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=7; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_SMS_TITLE');?></h5>
                        <ul class="doplist green">
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_SMS_TEXT1');?> </li>
                        </ul>
                                </td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_FORMS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=3; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_FORMS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_PAYMENTS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=7; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CSS_TEMPLATES_TITLE');?></h5>
                        <ul class="doplist green">
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CSS_TEMPLATES_TEXT1');?> </li>
                        </ul>
                                </td>
                        <td><span class="icon-limited" title="Only one"></span></td>
                        <td><span class="icon-infinite" title="Unlimited"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_TOOLS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=4; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_TOOLS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_SEARCH_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=3; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_SEARCH_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-unavailable" title="Not Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_MULTI_SITES_USERS_TITLE');?></h5>
                        <ul class="doplist green">
                            <?php for($i = 1; $i<=4; $i++) { ?>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_MULTI_SITES_USERS_TEXT'.$i);?> </li>
                            <?php } ?>
                        </ul>
                                </td>
                        <td><span class="icon-unavailable" title="Not Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_WIDGETS_TITLE');?></h5>
                        <ul class="doplist green">
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_WIDGETS_TEXT1');?> </li>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_WIDGETS_TEXT2');?> </li>
                        </ul>
                                </td>
                        <td><span class="icon-available" title="Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        <tr>
                        <td>
                        <h5 class="green"><?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CUSTOM_POSTS_TITLE');?></h5>
                        <ul class="doplist green">
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CUSTOM_POSTS_TEXT1');?> </li>
                            <li> <?php echo $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_CUSTOM_POSTS_TEXT2');?> </li>

                        </ul>
                                </td>
                        <td><span class="icon-unavailable" title="Not Available"></span></td>
                        <td><span class="icon-available" title="Available"></span></td>
                        </tr>
                        </tbody>
                    </table>
                    
                </div>
            </section>
<?php
            }
        }
    }