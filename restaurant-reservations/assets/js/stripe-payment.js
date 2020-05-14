if ( rtb_stripe_payment.stripe_mode == 'test' ) { Stripe.setPublishableKey(rtb_stripe_payment.test_publishable_key); }
else { Stripe.setPublishableKey(rtb_stripe_payment.live_publishable_key);  }

function stripeResponseHandler(status, response) {
    if (response.error) {
		// show errors returned by Stripe
        jQuery(".payment-errors").html(response.error.message);
		// re-enable the submit button
		jQuery('#stripe-submit').attr("disabled", false);
    } else {
        var form$ = jQuery("#stripe-payment-form");
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        // and submit
        form$.get(0).submit();
    }
}
jQuery(document).ready(function($) {
	$("#stripe-payment-form").submit(function(event) {
		// disable the submit button to prevent repeated clicks
		$('#stripe-submit').attr("disabled", "disabled");
 
		// send the card details to Stripe
		Stripe.createToken({
			number: $('input[data-stripe="card_number"]').val(),
			cvc: $('input[data-stripe="card_cvc"]').val(),
			exp_month: $('input[data-stripe="exp_month"]').val(),
			exp_year: $('input[data-stripe="exp_year"]').val(),
			currency: $('input[data-stripe="currency"]').val()
		}, stripeResponseHandler);
 
		// prevent the form from submitting with the default action
		return false;
	});
});