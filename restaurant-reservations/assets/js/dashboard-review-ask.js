jQuery(document).ready(function($) {
	jQuery('.rtb-main-dashboard-review-ask').css('display', 'block');

	jQuery('.rtb-main-dashboard-review-ask').on('click', function(event) {
		if (jQuery(event.srcElement).hasClass('notice-dismiss')) {
			var data = 'ask_review_time=3&action=rtb_hide_review_ask';
        	jQuery.post(ajaxurl, data, function() {});
        }
	});

	jQuery('.rtb-review-ask-yes').on('click', function() {
		jQuery('.rtb-review-ask-feedback-text').removeClass('rtb-hidden');
		jQuery('.rtb-review-ask-starting-text').addClass('rtb-hidden');

		jQuery('.rtb-review-ask-no-thanks').removeClass('rtb-hidden');
		jQuery('.rtb-review-ask-review').removeClass('rtb-hidden');

		jQuery('.rtb-review-ask-not-really').addClass('rtb-hidden');
		jQuery('.rtb-review-ask-yes').addClass('rtb-hidden');

		var data = 'ask_review_time=7&action=rtb_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.rtb-review-ask-not-really').on('click', function() {
		jQuery('.rtb-review-ask-review-text').removeClass('rtb-hidden');
		jQuery('.rtb-review-ask-starting-text').addClass('rtb-hidden');

		jQuery('.rtb-review-ask-feedback-form').removeClass('rtb-hidden');
		jQuery('.rtb-review-ask-actions').addClass('rtb-hidden');

		var data = 'ask_review_time=1000&action=rtb_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.rtb-review-ask-no-thanks').on('click', function() {
		var data = 'ask_review_time=1000&action=rtb_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.rtb-main-dashboard-review-ask').css('display', 'none');
	});

	jQuery('.rtb-review-ask-review').on('click', function() {
		jQuery('.rtb-review-ask-feedback-text').addClass('rtb-hidden');
		jQuery('.rtb-review-ask-thank-you-text').removeClass('rtb-hidden');

		var data = 'ask_review_time=1000&action=rtb_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.rtb-review-ask-send-feedback').on('click', function() {
		var feedback = jQuery('.rtb-review-ask-feedback-explanation textarea').val();
		var email_address = jQuery('.rtb-review-ask-feedback-explanation input[name="feedback_email_address"]').val();
		var data = 'feedback=' + feedback + '&email_address=' + email_address + '&action=rtb_send_feedback';
        jQuery.post(ajaxurl, data, function() {});

        var data = 'ask_review_time=1000&action=rtb_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.rtb-review-ask-feedback-form').addClass('rtb-hidden');
        jQuery('.rtb-review-ask-review-text').addClass('rtb-hidden');
        jQuery('.rtb-review-ask-thank-you-text').removeClass('rtb-hidden');
	});
});