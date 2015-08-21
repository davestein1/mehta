jQuery( document ).ready( function($) {
	
	$("body").addClass( "js-active" );
	
	$('img.header-image').addClass( "grayit" ); /* gray header. Removed by theme~footer.js */
	
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
	
	/* Help the menu fit on one line on screens narrower than 615 pixels. 
		replace Contact/Publishing with Contact.  */
	var windowsize = window.innerWidth; 
	/* alert(windowsize); */
	if ( windowsize < 761 ) {
		//$("#menu-secondary #menu-item-26").find("a").text('Contact');
		$("#menu-item-26 > a").text('Contact');
	}
	
	console.log('hello from theme.js. Screen width is ' + windowsize + 'px.');
});
