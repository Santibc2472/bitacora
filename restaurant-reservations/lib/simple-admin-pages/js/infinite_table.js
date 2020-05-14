jQuery(document).ready(function ($) {
	jQuery('.sap-infinite-table-add-row').on('click', function() {
		var max_row = findInfiniteTableMaxRow();

		jQuery('.sap-inifite-table-row-template').clone().appendTo('.sap-infinite-table tbody');

		jQuery('.sap-infinite-table tbody .sap-inifite-table-row-template').removeClass('sap-inifite-table-row-template').addClass('sap-inifinite-table-row').addClass('sap-new-infinite-row');
		jQuery('.sap-new-infinite-row').data('rowid', max_row + 1);
		jQuery('.sap-new-infinite-row input, .sap-new-infinite-row select').each(function() {
			jQuery(this).attr('name', jQuery(this).attr('name') + '_' + (max_row + 1));
		});
		jQuery('.sap-new-infinite-row').removeClass('sap-new-infinite-row').removeClass('sap-hidden');

		setInfiniteTableDeleteHandlers();
		setInfiniteTableUpdateHandlers();
	});

	setInfiniteTableDeleteHandlers();
	setInfiniteTableUpdateHandlers();

});

function findInfiniteTableMaxRow() {
	var max_row = 0;

	jQuery('.sap-inifinite-table-row').each(function() {
		max_row = Math.max(jQuery(this).data('rowid'), max_row);
	});

	return max_row;
}

function setInfiniteTableDeleteHandlers() {
	jQuery('.sap-infinite-table-row-delete').off('click');
	jQuery('.sap-infinite-table-row-delete').on('click', function() {
		jQuery(this).parent().remove();

		infiniteTableSaveData();
	});
}

function setInfiniteTableUpdateHandlers() {
	jQuery('.sap-inifinite-table-row input').off('keyup');
	jQuery('.sap-inifinite-table-row input').on('keyup', function() {
		infiniteTableSaveData();
	});

	jQuery('.sap-inifinite-table-row select').off('change');
	jQuery('.sap-inifinite-table-row select').on('change', function() {
		infiniteTableSaveData();
	});
}

function infiniteTableSaveData() {
	var fields = jQuery('.sap-infinite-table').data('fieldids').split(',');
	var data = [];

	jQuery('.sap-inifinite-table-row').each(function() {
		var row_id = jQuery(this).data('rowid');
		var row_data = {};

		jQuery(fields).each(function(index, field) {
			if ( jQuery('input[name="' + field + '_' + row_id + '"]').length ) { row_data[field] = jQuery('input[name="' + field + '_' + row_id + '"]').val(); }
			else { row_data[field] = jQuery('select[name="' + field + '_' + row_id + '"]').val(); }
		});
 
		data.push(row_data);
	});
	
	jQuery('.sap-infinite-table input[type="hidden"]').val(JSON.stringify(data));
}
