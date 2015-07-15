jQuery( document ).ready( function($) {

	console.log('hello from theme-footer.js');
	/* alert('hello from theme-footer.js'); */


	/* == Works Filter Name -- set text and class DS == */
	if($( ".works-filter" ).is( ":visible" )) {
		$(".works-filter-toggle").text("Close Filter");
		$(".works-filter-toggle").addClass("works-filter-open");
	}else {
		$(".works-filter-toggle").text("Open Filter");
		$(".works-filter-toggle").removeClass("works-filter-open")
	};
	
	/* == Works Filter toggle == */
	$( ".works-filter-toggle" ).click( function(e) {
		
		/* DS mods swizzle from above. */
		if($( ".works-filter" ).is( ":visible" )) {
			$(".works-filter-toggle").text("Open Filter");
			$(".works-filter-toggle").removeClass("works-filter-open");
		}else {
			$(".works-filter-toggle").text("Close Filter");
			$(".works-filter-toggle").addClass("works-filter-open");
		};

		e.preventDefault();
		$( ".works-filter" ).slideToggle();
	
	});

	/* === GRID and TILE View Masonry ===
		we receive col-masonry and in turn set col-masonry-active  */
	if ( $("body").hasClass( "col-masonry" ) ){

		/* add body class */
		$("body").addClass( "col-masonry-active" );

		/* masonry container */
		var masonry_container = $('.col-masonry-active .content-entry-wrap');

		/* trigger masonry on document ready 
		masonry_container.masonry(); */

		masonry_container.css({ opacity: 0 });

		masonry_container.imagesLoaded()
			.always( function( instance ) {
				//trigger masonry on document ready
				masonry_container.masonry();
				masonry_container.css({ opacity: 1 });
				//var temp = masonry_container.data('masonry');
				//alert( temp );
			    console.log('all images loaded');
			    //alert("all done img loading");
			})
			.done( function( instance ) {
			    console.log('all images successfully loaded');
			    //alert("all aok img load. no fails!");
			})
			.fail( function() {
			    console.log('all images loaded, at least one is broken');
			    alert("at least one img load fail!");
			})
			.progress( function( instance, image ) {
			    //var result = image.isLoaded ? 'loaded' : 'broken';
			    //console.log( 'image is ' + result + ' for ' + image.img.src );
		    	//alert( 'image is ' + result + ' for ' + image.img.src );
			});
		
	}; // end class check
	
	/* == Switch To List View == */
	$( ".works-list-toggle" ).click( function(e) {
		e.preventDefault();
		$( "body" ).removeClass("col-grid col-tile");
		$( "body" ).addClass("col-list");
		var masonry_container = $('.col-masonry-active .content-entry-wrap');
		masonry_container.masonry();
	});

	/* == Switch To Grid View == */
	$( ".works-grid-toggle" ).click( function(e) {
		e.preventDefault();
		$( "body" ).removeClass("col-list col-tile");
		$( "body" ).addClass("col-grid");
		//alert("col-grid");
		var masonry_container = $('.col-masonry-active .content-entry-wrap');
		masonry_container.masonry();
	});

	/* == Switch To Tile View == */
	$( ".works-tile-toggle" ).click( function(e) {
		e.preventDefault();
		$( "body" ).removeClass("col-list col-grid");
		$( "body" ).addClass("col-tile");
		var masonry_container = $('.col-masonry-active .content-entry-wrap');
		masonry_container.masonry();
	});

	/* Upcoming snowfall page. */
	$('a[rel="smoothscroll"]').click(function(){
		$('#scrollwindow').animate({ 
			scrollTop:  $( $.attr(this, 'href') ).offset().top - $('#one').offset().top
		}, 2000); 
		return false;
	});
	
	/* Responsive menus have toggles.
		HERE WE TRY TOGGLNG BOTH PRIMARY AND SECONDARY MENUS */
	$( '.menu-toggle button' ).click(
		function() {
			//$( this ).parents( '.menu' ).children( '.wrap' ).fadeToggle();
			//$( this ).toggleClass( 'active' );
			$( '.menu-toggle button' ).parents( '.menu' ).children( '.wrap' ).fadeToggle();
			$( '.menu-toggle button' ).toggleClass( 'active' );
		}
	);
	
	/* Banner loads as grayscale. Color as signal we have fully loaded. */
	$( window ).load( function() {
		//alert("hello from the fully loaded page and theme-footer.js"); 
		$('img.header-image').addClass( "colorup" );
	});

});

