jQuery(document).ready(function() {
	jQuery('.rtb-welcome-screen-box h2').on('click', function() {
		var section = jQuery(this).parent().data('screen');
		rtb_toggle_section(section);
	});

	jQuery('.rtb-welcome-screen-next-button').on('click', function() {
		var section = jQuery(this).data('nextaction');
		rtb_toggle_section(section);
	});

	jQuery('.rtb-welcome-screen-previous-button').on('click', function() {
		var section = jQuery(this).data('previousaction');
		rtb_toggle_section(section);
	});

	jQuery('.rtb-welcome-screen-add-reservations-page-button').on('click', function() {
		var reservations_page_title = jQuery('.rtb-welcome-screen-add-reservations-page-name input').val();

		var data = 'reservations_page_title=' + reservations_page_title + '&action=rtb_welcome_add_menu_page';
		jQuery.post(ajaxurl, data, function(response) {});

		var section = jQuery(this).data('nextaction');
		rtb_toggle_section(section);
	});

	jQuery('.rtb-welcome-screen-save-schedule-open-button').on('click', function() {

		var schedule_open = [];
 
 		jQuery('.sap-scheduler-rule').each(function() {
			var weekdays ={};

			jQuery(this).find('.sap-scheduler-weekdays input[type="checkbox"]').each(function() { 
				if ( jQuery(this).is(':checked') ) { weekdays[jQuery(this).data('day')] = "1" ; }
			}); 

			var start = jQuery(this).find('.sap-scheduler-time-input .start input').first().val();
			var end = jQuery(this).find('.sap-scheduler-time-input .end input').first().val();

			schedule_open.push({'weekdays': weekdays, 'time': {'start': start, 'end': end }});
		}); 

		var data = 'schedule_open=' + JSON.stringify(schedule_open) + '&action=rtb_welcome_set_schedule';
		jQuery.post(ajaxurl, data, function(response) {});
	});

	jQuery('.rtb-welcome-screen-save-options-button').on('click', function() {
		var party_size_min = jQuery('select[name="min-party-size"]').val();
		var party_size = jQuery('select[name="party-size"]').val();
		var early_bookings = jQuery('select[name="early-bookings"]').val();
		var late_bookings = jQuery('select[name="late-bookings"]').val();
		var time_interval = jQuery('select[name="time-interval"]').val();

		var data = 'party_size_min=' + party_size_min + '&party_size=' + party_size + '&early_bookings=' + early_bookings + '&late_bookings=' + late_bookings + '&time_interval=' + time_interval + '&action=rtb_welcome_set_options';
		jQuery.post(ajaxurl, data, function(response) {});
	});
});

function rtb_toggle_section(page) {
	jQuery('.rtb-welcome-screen-box').removeClass('rtb-welcome-screen-open');
	jQuery('.rtb-welcome-screen-' + page).addClass('rtb-welcome-screen-open');
}