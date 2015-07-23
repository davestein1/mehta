jQuery( document ).ready( function($) {

	console.log('hello from theme.js');
	
	$("body").addClass( "js-active" );
	
	/* === GRID and TILE View Masonry ===
		Just turn it off until footer js turns it on. */
	if ( $("body").hasClass( "col-masonry" ) ) {
	
		/* add body class */
		$("body").addClass( "col-masonry-active" );

		/* masonry container */
		var masonry_container = $('.col-masonry-active .content-entry-wrap');
		
		/* Hide the Masonry area on the page until fully loaded. 
		  theme-footer.js uses imagesLoaded to wait. */
		masonry_container.css({ opacity: 0 });
	}
	
	/* Help the menu fit on one line on smaller screens. 
		replace Contact/Publishing with Contact.  */
	var windowsize = $(window).width(); 
	if (windowsize < 700) {
		$("#menu-secondary #menu-item-26").text('Contact');
	}

});
