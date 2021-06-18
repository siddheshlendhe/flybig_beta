( function( api ) {

	// Extends our custom "vw-travel" section.
	api.sectionConstructor['vw-travel'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );