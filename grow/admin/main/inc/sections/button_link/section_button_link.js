( function( api ) {

	// Extends our custom "thinkup-button-link" section.
	api.sectionConstructor['thinkup-button-link'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
