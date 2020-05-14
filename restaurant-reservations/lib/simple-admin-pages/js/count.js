jQuery(document).ready(function() {
	jQuery('.sap-count-count, .sap-count-unit').on('change', function() {
		var id = jQuery(this).data('id');

		var count = jQuery('#' + id + '_count').val();
		var unit = jQuery('#' + id + '_unit').val();
		
		jQuery('#' + id).val(count + '_' + unit);
	})
})