<style type="text/css">
    .tab_wrap {
        background-color: #FFFFFF;
        border: 1px solid #CCCCCC;
        padding: 10px;
        min-width: 763px;
    }

    .redi_required {
        color: #DD0000;
    }

    .redi-admin-left {
        margin-right: 300px;
        float: left;
    }

    .redi-admin-right {
        position: absolute;
        right: 0;
        width: 290px;
    }

    .postbox h3 {
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 8px 12px;
    }

    .nav-tab-basic {
        background-color: #78DD88;
    }

    .nav-tab-basic:hover {
        background-color: #7FFF8E;
    }
</style>
<script type="text/javascript">
    // Include the UserVoice JavaScript SDK (only needed once on a page)
    UserVoice = window.UserVoice || [];
    (function () {
        var uv = document.createElement('script');
        uv.type = 'text/javascript';
        uv.async = true;
        uv.src = '//widget.uservoice.com/gDfKlRGSIwZxjtqDE5rg.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(uv, s)
    })();
    UserVoice.push(['set', {locale: '<?php echo get_locale()?>'}]);
    UserVoice.push(['identify', {
        email: '<?php echo get_option('admin_email');?>',
        name: '<?php echo get_option('blogname');?>',
        type: 'ReDi Restaurant Reservation',
    }]);
    UserVoice.push(['addTrigger', {mode: 'smartvote', trigger_position: 'bottom-right'}]);
    var remainder_name_text = '<?php _e('Send me reservation reminder', 'redi-restaurant-reservation') ?>';
    var newsletter_name_text = '<?php _e('Send me newsletter and promotions', 'redi-restaurant-reservation') ?>';
    var sms_confirmation_name_text = '<?php _e('Allow to receive SMS', 'redi-restaurant-reservation') ?>';
    var gdpr_name_text = '<?php _e('I agree to the privacy policy', 'redi-restaurant-reservation') ?>';

    function set_name(field, type) {
        var name_field = jQuery('#' + field);
        if (name_field.val() == '') {
            switch (type) {
                case 'reminder':
                    name_field.val(remainder_name_text);
                    break;
                case'newsletter':
                    name_field.val(newsletter_name_text);
                    break;
                case 'allowsms':
                    name_field.val(sms_confirmation_name_text);
                    break;
                case 'gdpr':
                    name_field.val(gdpr_name_text);
                    break;
            }
        }
    }

    jQuery(document).on('click', '#key_edit', function () {
        if (jQuery("#form_key").is(":visible")) {
            jQuery("#form_key").hide();
        } else {
            jQuery("#form_key").show();
        }

    })
</script>
<?php $admin_slug = 'redi-restaurant-reservation-settings' ?>
<div class="wrap">
    <a class="nav-tab <?php if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?> nav-tab-active<?php endif; ?>"
       href="admin.php?page=<?php echo $admin_slug ?>&amp;sm=free"><?php _e('Free package settings', 'redi-restaurant-reservation') ?></a>
    <a class="nav-tab nav-tab-basic <?php if ((isset($_GET['sm']) && $_GET['sm'] == 'basic')): ?> nav-tab-active<?php endif; ?>"
       href="admin.php?page=<?php echo $admin_slug ?>&amp;sm=basic"><?php _e('Basic package settings', 'redi-restaurant-reservation') ?></a>
    <a class="nav-tab <?php if ((isset($_GET['sm']) && $_GET['sm'] == 'cancel')): ?> nav-tab-active<?php endif; ?>"
       href="admin.php?page=<?php echo $admin_slug ?>&amp;sm=cancel"><?php _e('Cancel reservation', 'redi-restaurant-reservation') ?></a>
    <?php if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?>
        <div class="redi-admin-right">

            <div class="postbox">
                <h3><?php _e('Plugin Info', 'redi-restaurant-reservation') ?></h3>
                <div class="inside">
                    <p><?php _e('Name', 'redi-restaurant-reservation') ?>: Redi Restaurant Reservation</p>
                    <p><?php _e('Version', 'redi-restaurant-reservation') ?>: <?php echo $this->version ?></p>
                    <p><?php _e('News', 'redi-restaurant-reservation') ?>: <a target="_blank"
                                                                              href="https://www.facebook.com/ReDiReservation">News</a>
                    </p>
                    <p><?php _e('User guideline', 'redi-restaurant-reservation') ?>: <a target="_blank" <a
                                href="http://plugin.reservationdiary.eu/wp-content/uploads/2017/04/ReDi-Restaurant-Reservation-Plugin-Userguide.pdf">Download PDF</a>
                    </p>
                    <p><?php _e('Support', 'redi-restaurant-reservation') ?>: <a target="_blank"
                                                                                 href="https://reservationdiary-wp-plugin.uservoice.com/clients/widgets/classic_widget?referrer=wordpress-redirestaurant-reservation-apikey-<?php echo $this->ApiKey; ?>#contact_us">Create a
                            support ticket</a>
                    <p><?php _e('Email', 'redi-restaurant-reservation') ?>: <a target="_blank"
                                                                               href="mailto:info@reservationdiary.eu">info@reservationdiary.eu</a>
                    </p>
                    <p><?php _e('Skype', 'redi-restaurant-reservation') ?>: thecatkin </p>
                    <p><?php _e('Phone', 'redi-restaurant-reservation') ?>: +372 51 65 285 (10AM - 10PM UTC) </p>
                    <p><?php _e('WhatsApp', 'redi-restaurant-reservation') ?>: +372 51 65 285 (10AM - 10PM UTC) </p>
                    <p><?php _e('Authors', 'redi-restaurant-reservation') ?>: <a
                                href="https://profiles.wordpress.org/thecatkin/" target="_blank">Catkin</a> & <a
                                href="https://profiles.wordpress.org/robbyroboter/" target="_blank">Robby Roboter</a>
                    </p>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="tab_wrap <?php if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?>redi-admin-left<?php endif ?>">

        <?php if (isset($settings_saved) && $settings_saved): ?>
            <div class="updated" id="message">
                <p>
                    <?php _e('Your settings have been saved!', 'redi-restaurant-reservation') ?>
                </p>
            </div>
        <?php endif ?>
        <?php if (isset($cancel_success)): ?>
            <div class="updated">
                <p>
                    <?php echo $cancel_success; ?>
                </p>
            </div>
        <?php endif; ?>
        <?php if (isset($errors)): ?>
            <?php foreach ((array)$errors as $error): ?>
                <div class="error">
                    <p>
                        <?php echo $error; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
        <?php if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?>

            <div class="icon32" id="icon-admin"><br></div>
            <h2><?php _e('Common settings', 'redi-restaurant-reservation'); ?></h2>
            <form name="redi-restaurant" method="post">
                <table class="form-table">
                    <tr style="vertical-align:top">
                        <th scope="row" style="width:25%;">
                            <label for="MinPersons"><?php _e('Min persons per reservation', 'redi-restaurant-reservation'); ?> </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="MinPersons" id="MinPersons">
                                <?php foreach (range(1, 10) as $current): ?>
                                    <option value="<?php echo $current ?>"
                                            <?php if ($current == $minPersons): ?>selected="selected"<?php endif; ?>>
                                        <?php echo $current ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Minimum number of persons allowed for each reservation. Drop down list of persons starts from this number.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="vertical-align:top">
                        <th scope="row" style="width:15%;">
                            <label for="MaxPersons"><?php _e('Max persons per reservation', 'redi-restaurant-reservation'); ?> </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="MaxPersons" id="MaxPersons">
                                <?php foreach (range(1, 500) as $current): ?>
                                    <option value="<?php echo $current ?>"
                                            <?php if ($current == $maxPersons): ?>selected="selected"<?php endif; ?>>
                                        <?php echo $current ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Maximum number of persons allowed for each reservation. Drop down list of persons ends with this number.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width:25%;">
                            <label for="ChildrenSelection"><?php _e('Сhildren selection', 'redi-restaurant-reservation'); ?> </label>
                        </th>
                        <td>
                            <input type="checkbox" name="ChildrenSelection" id="ChildrenSelection"
                                   value="1" <?php if (isset($childrenSelection) && $childrenSelection) echo 'checked="checked"' ?>>	
                        </td>
                        <td>
                            <p class="description">
                                <?php _e('Enable/Disable children dropdown', 'redi-restaurant-reservation');?>
                            </p>
                        </td>
						
                    </tr>					
					<tr>
						<th></th>
						<td>
							<input id="ChildrenDescription" type="text" value="<?php echo $childrenDescription ?>" name="ChildrenDescription"/>
						</td>
						<td>
                            <p class="description">
                                <?php _e('Description for children dropdown', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
					</tr>
                    <tr>
                        <th scope="row">
                            <label for="ReservationTime">
                                <?php _e('Reservation time', 'redi-restaurant-reservation'); ?>&nbsp;<span
                                        class="redi_required">*</span>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <input id="ReservationTime" type="text" value="<?php echo $reservationTime ?>"
                                   name="ReservationTime"/>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Duration of reservation in minutes. This is the time allocated for each reservation.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="ManualReservation">
                                <?php _e('Manual reservation', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="ManualReservation" id="ManualReservation"
                                   value="1" <?php if (isset($manualReservation) && $manualReservation) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('If checkbox is checked then reservations will not be automatically confirmed. You will receive email with reservation request and each reservation needs to be confirmed or rejected manually.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
					<tr>
                        <th scope="row">
                            <label for="EnableCancelForm">
                                <?php _e('Enable cancel form', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="EnableCancelForm" id="EnableCancelForm"
                                   value="1" <?php if (isset($EnableCancelForm) && $EnableCancelForm) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable or Disable reservation cancel form.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="EnableModifyReservations">
                                <?php _e('Enable modify reservations', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="EnableModifyReservations" id="EnableModifyReservations"
                                   value="1" <?php if (isset($EnableModifyReservations) && $EnableModifyReservations) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable or Disable modify reservation.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
					<tr>
                        <th scope="row">
                            <label for="EnableSocialLogin">
                                <?php _e('Enable social network login', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="EnableSocialLogin" id="EnableSocialLogin"
                                   value="1" <?php if (isset($EnableSocialLogin) && $EnableSocialLogin) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable or Disable social network account login. When enabled clients can login with any social network accounts like Facebook and then reservation form will be pre-filled with personal information. You need to install and setup plugin with name \'Super Socializer\' from WordPress directory.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="AlternativeTimeStep">
                                <?php _e('Alternative time step', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="AlternativeTimeStep">
                                <option value="15"
                                        <?php if ($alternativeTimeStep == 15): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 15); ?></option>
                                <option value="30"
                                        <?php if ($alternativeTimeStep == 30): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 30); ?></option>
                                <option value="60"
                                        <?php if ($alternativeTimeStep == 60): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 60); ?></option>
                                <option value="90"
                                        <?php if ($alternativeTimeStep == 90): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 90); ?></option>
                                <option value="120"
                                        <?php if ($alternativeTimeStep == 120): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 120); ?></option>
								<option value="180"
                                        <?php if ($alternativeTimeStep == 180): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 180); ?></option>		
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Displays the available time with time step to the clients. For instance, if one selects 15 min time step, then alternative time will be 10:00, 10:15, 10:30, etc.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="EmailFrom">
                                <?php _e('Send confirmation email to client', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="EmailFrom">
                                <option value="ReDi"
                                        <?php if ($emailFrom == EmailFrom::ReDi): ?>selected="selected" <?php endif; ?>><?php _e('From ReservationDiary.eu', 'redi-restaurant-reservation'); ?></option>
                                <option value="WordPress"
                                        <?php if ($emailFrom == EmailFrom::WordPress): ?>selected="selected" <?php endif; ?>><?php _e('From WordPress email account', 'redi-restaurant-reservation'); ?></option>
                                <option value="Disabled"
                                        <?php if ($emailFrom == EmailFrom::Disabled): ?>selected="selected" <?php endif; ?>><?php _e('Disable confirmation email', 'redi-restaurant-reservation'); ?></option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('The way you want confirmation email to be delivered to the client. It can be "From WordPress email account", "From reservationdiary.eu" or "Disable confirmation email".', 'redi-restaurant-reservation') ?>
                                <br/>
                                <b><?php _e('From WordPress email account', 'redi-restaurant-reservation') ?></b>
                                - <?php _e('The confirmation email will be sent out from your email set in WordPress.', 'redi-restaurant-reservation') ?>
                                <br/>
                                <b><?php _e('From ReservationDiary.eu', 'redi-restaurant-reservation') ?></b>
                                - <?php _e('The confirmation email will be sent out from info@reservationdiary.eu. When the client replies to confirmation email, you will receive it.', 'redi-restaurant-reservation') ?>
                                <br/>
                                <b><?php _e('Disable confirmation email', 'redi-restaurant-reservation') ?></b>
                                - <?php _e('With this option, confirmation email is not sent to the client.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                        <label for="ConfirmationPage">
                                <?php _e('Confirmation page', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;"><?php 
                        $dropdown_args = array(
                            'show_option_none' => 'Please select a page',
                            'name' => 'ConfirmationPage',
                            'selected' => $confirmationPage
                        );
                        wp_dropdown_pages($dropdown_args); ?></td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('If you want to customize confirmation page or have a separated page for marketing purposes, then select custom reservation confirmation page. If not specified, then built in confirmation page will be used.', 'redi-restaurant-reservation') ?>
                                <?php _e('In order to display reservation id on that page, install plugin GET Params and add following short code: [display-get-param name="reservation_id"]', 'redi-restaurant-reservation') ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="MaxTime">
                                <?php _e('Early Bookings', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="MaxTime">
                                <?php foreach (range(1, 12) as $current): ?>
                                    <option value="<?php echo $current ?>"
                                            <?php if ($current == $maxTime): ?>selected="selected"<?php endif; ?>>
                                        <?php echo $current ?> <?php echo _n('Month', 'Months', $current, 'redi-restaurant-reservation') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Maximum time before the reservation can be accepted. It can be anything from 1 month to 1 year.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <br/>
                <div class="icon32" id="icon-admin"><br></div>
                <h2><?php _e('Frontend settings', 'redi-restaurant-reservation'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row" style="width:25%;">
                            <label for="LargeGroupsMessage">
                                <?php _e('Message for large groups', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <textarea maxlength="250" name="LargeGroupsMessage" id="LargeGroupsMessage" rows="5"
                                      cols="40"><?php echo $largeGroupsMessage ?></textarea>
                        </td>
                        <td style="width:75%; vertical-align: top;">
                            <p class="description">
                                <?php _e('If this field is filled, the drop down menu of persons would show "Large Groups" and upon selection, the specified message would appear.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="width: 250px">
                        <th scope="row">
                            <label for="TimeShiftMode">
                                <?php _e('TimeShift Mode', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="TimeShiftMode">
                                <option value="normal"
                                        <?php if ($timeshiftmode === 'normal'): ?>selected="selected"<?php endif; ?>>
                                    normal
                                </option>
                                <option value="byshifts"
                                        <?php if ($timeshiftmode === 'byshifts'): ?>selected="selected"<?php endif; ?>>
                                    byshifts
                                </option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Mode how available working hours presented to user so that they can choose time slots most convenient to them.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('Normal', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('In this mode, the user selects the desired time and the system verifies its availability to present five different alternative times to the customer.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('By shifts', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('In this mode, the system automatically displays all the available times for the date selected without any manual time input.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('Hide steps', 'redi-restaurant-reservation'); ?></b>
                                - <?php _e('This option is meant only for the by shifts mode. It is meant for hiding the previous steps. The system would display all the available times for the specified date but upon selecting the available time, the previous steps are hidden and the next step is presented. It is a good mode for widgets specially.', 'redi-restaurant-reservation'); ?>
                                <br/>

                            </p>
                        </td>
                    </tr>
                    <tr style="width: 250px">
                        <th scope="row">
                            <label for="Hidesteps">
                                <?php _e('Hide steps', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="Hidesteps">
                                <option value="true"
                                        <?php if ($hidesteps === 'true'): ?>selected="selected"<?php endif; ?>>true
                                </option>
                                <option value="false"
                                        <?php if ($hidesteps === 'false'): ?>selected="selected"<?php endif; ?>>false
                                </option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Hide previous steps (only for timeshiftmode byshifts)', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="width: 250px">
                        <th scope="row">
                            <label for="Calendar">
                                <?php _e('Calendar type', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="Calendar">
                                <option value="show"
                                        <?php if ($calendar === 'show'): ?>selected="selected"<?php endif; ?>>Always
                                    show
                                </option>
                                <option value="hide"
                                        <?php if ($calendar === 'hide'): ?>selected="selected"<?php endif; ?>>Shown on
                                    click
                                </option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('This field lets you select the style in which the calendar control is displayed. It can be either "Show on click" or "Always show”.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('Shown on click', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('Selecting this option, the calendar is set to popup when the user clicks the calendar control.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('Always show', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('This option sets the calendar control to display all the time.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="TimePicker">
                                <?php _e('TimePicker type', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="TimePicker">
                                <option value="plugin"
                                        <?php if ($timepicker === 'plugin'): ?>selected="selected" <?php endif; ?>>
                                    jQuery plugin
                                </option>
                                <option value="dropdown"
                                        <?php if ($timepicker === 'dropdown'): ?>selected="selected" <?php endif; ?>>
                                    dropdown
                                </option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('This field lets you select the way time picker is displayed. You can choose from "jQuery plugin" and "HTML dropdown".', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('jQuery plugin', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('Time picker type if selected to be jQuery plugin, it is set to pop up with the hour and time.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('HTML dropdown', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('With this option selected, the Time Picker is shown to be simple dropdown for selecting the hour and time.', 'redi-restaurant-reservation'); ?>

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="FullyBookedMessage">
                                <?php _e('Override fully booked message text', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
							<textarea maxlength="250" name="FullyBookedMessage" id="FullyBookedMessage" rows="5"
                                      cols="40"><?php echo $fullyBookedMessage ?></textarea>	
                        </td>
                        <td style="width:75%; vertical-align: top;">
                            <p class="description">
                                <?php _e('Text that will be displayed when there are no available time for selected day/time.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
					<tr>
                        <th scope="row">
                            <label for="Captcha">
                                <?php _e('Captcha', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="Captcha" id="Captcha"
                                   value="1" <?php if (isset($captcha) && $captcha) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable/Disable captcha on reservation form.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
					<tr>
						<th scope="row">
                        <label for="CaptchaKey">
                                <?php _e('Captcha key', 'redi-restaurant-reservation'); ?>
                            </label>

                        </th>
						<td>
							<input id="CaptchaKey" type="text" value="<?php echo $captchaKey ?>" name="CaptchaKey"/>
						</td>
						<td>
                            <p class="description">
                                <?php _e('Obtain your captcha key from Google.', 'redi-restaurant-reservation'); ?> <a target='_blank' href='https://www.google.com/recaptcha/intro/v3.html'><?php _e('Visit Google site', 'redi-restaurant-reservation'); ?></a>
                            </p>
                        </td>
					</tr>
                    <tr>
                        <th scope="row">
                            <label for="WaitList">
                                <?php _e('Wait List', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="WaitList" id="WaitList"
                                   value="1" <?php if (isset($waitlist) && $waitlist) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('When this option is enabled, guest will have an opportunity to fill out Wait List form in case it\'s fully booked. Then if someone cancels reservation, this guest can be contacted and offered a reservation.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="Thanks">
                                <?php _e('Support us', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="Thanks" id="Thanks"
                                   value="1" <?php if (isset($thanks) && $thanks) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('If checkbox is checked, a logo of <b>"Powered by ReDi"</b> is displayed. Thank you for supporting us.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <div id="ajaxed">
                    <?php self::ajaxed_admin_page($placeID, $categoryID, $settings_saved); ?>
                </div>


                <input class="button-primary" id="submit" type="submit"
                       value="<?php _e('Save Changes', 'redi-restaurant-reservation') ?>" name="submit">
            </form>
        <?php elseif ((isset($_GET['sm']) && $_GET['sm'] == 'basic')): ?>
            <iframe src="//wp.reservationdiary.eu/<?php echo str_replace('_', '-', get_locale()) ?>/<?php echo $this->ApiKey; ?>/Home"
                    width="100%;" style="min-height: 1700px;"></iframe>
        <?php elseif ((isset($_GET['sm']) && $_GET['sm'] == 'cancel')): ?>
            <div id="icon-admin" class="icon32">
                <br>
            </div>
            <h2><?php _e('Cancel reservation', 'redi-restaurant-reservation'); ?></h2>
            <form id="redi-reservation-cancel" name="redi-reservation-cancel" method="post">
                <input type="hidden" name="action" value="cancel"/>
                <br/>
                <label for="redi-restaurant-cancel-id"><?php _e('Reservation number', 'redi-restaurant-reservation') ?>:<span
                            class="redi_required">*</span></label><br/>
                <input type="text" value="" name="id" id="redi-restaurant-cancel-id"/>
                <br/>
                <label for="redi-restaurant-cancel-reason"><?php _e('Reason', 'redi-restaurant-reservation') ?>:</label><br/>
                <textarea maxlength="250" name="reason" id="redi-restaurant-cancel-reason" rows="5"
                          cols="60"></textarea>
                <br/>
                <br/>
                <input class="button-secondary" type="submit" name="cancelReservation"
                       value="<?php _e('Cancel reservation', 'redi-restaurant-reservation') ?>">
            </form>
        <?php endif ?>
    </div>
</div>

<br/>
<br/>
<br/>