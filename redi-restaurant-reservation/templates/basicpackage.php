<div class="wrap">

    <h2><?php _e('ApiKey:'); ?></h2> <br/>
    <b><i><?php echo($this->ApiKey); ?></i></b></br>
    <br/>
    <input value="<?php _e('Change API key', 'redi-restaurant-reservation'); ?>" class="button-primary" id="key_edit" type="submit">
    <br/>
    <br/>
    <form method="post" id="form_key" style="display: none"><input type="hidden" name="page">
        <input id="new_key" type="text" name="new_key">
        <input value="<?php _e('Change', 'redi-restaurant-reservation'); ?>" class="button-primary" id="key_edit" type="submit">
    </form>
    <br/>
    <?php _e('This is your registration key. Please use it when you send request for support.', 'redi-restaurant-reservation'); ?>
    <br/><br/>
    <h2><?php _e('Texts and Translations', 'redi-restaurant-reservation'); ?></h2>
    <p class="description">
        ◾<?php _e('In order to change text or translation', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾<?php _e('Please install plugin <a href="plugin-install.php?tab=search&type=term&s=loco+translate" target="_blank">loco-translate</a>', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾<?php _e('After you install Loco Translate plugin click this link to navigate to page with translations <a href="admin.php?name=redi-restaurant-reservation%2Fredi-restaurant-reservation.php&type=plugin&poedit=plugins%2Fredi-restaurant-reservation%2Flang%2Fredi-restaurant-reservation-ru.po&page=loco-translate" target="blank">Redi translation</a>', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾<?php _e('Find text you want to change, change it and press save', 'redi-restaurant-reservation'); ?>
        <br/>
    </p>
    <br/><br/>
    <h2><?php _e('Basic package functionality (paid version)', 'redi-restaurant-reservation'); ?></h2>
    <br/>
    <p class="description">
        ◾ <?php _e('View your upcoming reservations from your Mobile/Tablet PC and never miss your customer. This page should be open on a Tablet PC and so hostess can see all upcoming reservations for today. Page refreshes every 15 min and shows reservations that in past for 3 hours as well as upcoming reservations for next 24 hours. By clicking on reservation you will see reservation details. Demo version can be accessed for 30 days using this link: ', 'redi-restaurant-reservation'); ?>
        <a href="http://upcoming.reservationdiary.eu/Entry/<?php _e($this->ApiKey) ?>"
           target="_blank"><?php _e('Open upcoming reservations', 'redi-restaurant-reservation'); ?></a><br/>
        ◾ <?php _e('Setup maximum available seats for online reservation by week day', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Open times. This option will enable you to choose between various working hours whichever is most convenient to you.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Support for multiple places. Number of places depends on number of subscriptions.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Blocked Time. Define time range when online reservation should not be accepted. Specify a reason why reservations are not accepted at this time to keep your clients happy.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Send client reservation confirmation emails from WordPress account.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Email template customization for all supported languages.', 'redi-restaurant-reservation'); ?><br/>
    </p>
    <?php _e('Basic package price is 5 EUR per month per place. To subscribe please use following PayPal link:') ?>
    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=R2KJQFCXB7EMN&item_name=ReDi Restaurant Reservation subscription fee, Api Key: <?php echo($this->ApiKey); ?>"
       target="_blank"><?php _e('Subscribe to basic package') ?></a><br/>
    <?php _e('Please allow 1 business day for us to confirm your payment and upgrade your account.', 'redi-restaurant-reservation'); ?>
    <br/>
    <br/>
    <h2>Additional services (by request)</h2>
    <p class="description">
        ◾ <?php _e('Use your Facebook account for your business. Make clients from your Facebook fans.', 'redi-restaurant-reservation'); ?>
        <a href="http://www.slideshare.net/sergeiprokopov/make-clients-from-your-facebook-fans"><?php _e('View presentation.', 'redi-restaurant-reservation'); ?></a><br/>
        ◾ <?php _e('We can offer you white labeled restaurant reservation application for Facebook Application, iPhone/iPad Application, Windows Phone Application or Android Application.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Enhance your business experience by using our Facebook integration service where we try to provide you with profile pictures of your customers if found. You can amaze your customer by knowing him by face when he visits you, especially at the time of first visit.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Do you want to know what your client thinks about his last visit? We will collect it for you.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Remind your customer about upcoming reservation via Email or by SMS', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Collect pre-payment for reservations.', 'redi-restaurant-reservation'); ?><br/>
        ◾ <?php _e('If you are building a catalogue of restaurants and looking for the perfect reservation plugin for it, we can provide it to you.', 'redi-restaurant-reservation'); ?>
        <br/>
        ◾ <?php _e('Do you want to write your own module? We have an API. Contact us to get more information.', 'redi-restaurant-reservation'); ?>
        <br/>
    </p>
    <?php _e('If you would like to add some new functionality or have any other queries, please contact us by email: ', 'redi-restaurant-reservation'); ?>
    <a href="mailto:info@reservationdiary.eu">info@reservationdiary.eu</a><br/>

    <h2>Other plugins</h2>
    <p class="description">
        ◾ <?php _e('Improve your restaurant’s turnaround time by allowing the clients to call a waiter using their smart phones. Create a mobile web page with our QR Code Waiter Calling System plugin.', 'redi-restaurant-reservation'); ?>
        <a href="http://wordpress.org/plugins/qr-code-waiter-calling-system/" target="_blank">Open QR Code Waiter
            Calling System plugin</a><br/>
    </p>
</div>