<?php
/**
 * "Funny, 'cause I look around at this world you're so eager to be a part of and all I see is six billion 
 * lunatics looking for the fastest ride out. Who's not crazy? Look around, everyone's drinking, smoking, 
 * shooting up, shooting each other, or just plain screwing their brains out 'cause they don't want 'em anymore. 
 * I'm crazy? Honey, I'm the original one-eyed chicklet in the kingdom of the blind, 'cause at least I admit the 
 * world makes me nuts. Name one person who can take it here. That's all I'm asking. Name one." 
 * ~ Glorificus (Buffy the Vampire Slayer: Season 5 - Weight of the World)
 * 
 * Theme Authors: Make sure to add a favorite quote of yours above, maybe something that inspired you to 
 * create this theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    HybridBase
 * @subpackage Functions
 * @version    1.0.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/hybrid-base
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Get the template directory and make sure it has a trailing slash. */
$hybrid_base_dir = trailingslashit( get_template_directory() );

/* Load the Hybrid Core framework and theme files. */
require_once( $hybrid_base_dir . 'library/hybrid.php'        );
require_once( $hybrid_base_dir . 'inc/custom-background.php' );
require_once( $hybrid_base_dir . 'inc/custom-header.php'     );
require_once( $hybrid_base_dir . 'inc/theme.php'             );

/* Launch the Hybrid Core framework. */
new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'hybrid_base_theme_setup', 5 );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function hybrid_base_theme_setup() {

	/* Theme layouts. */
	add_theme_support( 
		'theme-layouts', 
		array(
			'1c'        => __( '1 Column',                     'hybrid-base' ),
			'2c-l'      => __( '2 Columns: Content / Sidebar', 'hybrid-base' ),
			'2c-r'      => __( '2 Columns: Sidebar / Content', 'hybrid-base' )
		),
		array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) 
	);

	/* Enable custom template hierarchy. */
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );

	/* Breadcrumbs. Yay! */
	add_theme_support( 'breadcrumb-trail' );

	/* Pagination. */
	add_theme_support( 'loop-pagination' );

	/* Nicer [gallery] shortcode implementation. */
	add_theme_support( 'cleaner-gallery' );

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Automatically add feed links to <head>. */
	add_theme_support( 'automatic-feed-links' );

	/* Post formats. */
	add_theme_support( 
		'post-formats', 
		array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
	);

	/* Handle content width for embeds and images. */
	hybrid_set_content_width( 1280 );
/*}. */

    /* Change default background color. */
    //add_theme_support( 'custom-background', array( 'default-color' => 'f7f7f7' ) );			
			
    /* Add a custom default color for the "primary" color option. */
    //add_filter( 'theme_mod_color_primary', 'my_color_primary' );
	
	/* Change default custom header */
	//add_theme_support( 'custom-header', array ( 'default-image' => '%2$s/images/headers/header.jpg'	) );
	add_theme_support( 'custom-header', 
	array ( 'default-image' => '', 'header-text' => true, 'height' => '150', 'width' => '980', 'flex-height' => false, 'flex-width' => false, 'default-text-color' => 'FAEBD7' ) ); // try our own values.  

	/* Filter custom header. Used with Custom Header Extended plugin. */ 
	add_filter( 'theme_mod_header_image', 'my_header_image', 99 ); 
	
	// header.php calls do action and we add header-image-text markup to the page. 
	add_action("jh_header_text", 'my_header_text');
	
	/* Filter Breadcrumb to make Home into our Menu items */
	add_filter("breadcrumb_trail", 'my_breadcrumb' );

	/* Get the theme prefix ("shell"). */
	//$prefix = hybrid_get_prefix();
	
	//Add tags to images
	add_action( 'init' , 'wptp_add_tags_to_attachments' );
	
	/* Register widget areas */
	add_action( 'widgets_init', 'widget_area_init' );
	
	// Manually add a new header widget area.  (Header only has logo, now. )
	add_action( "after_header", 'header_widget_area'); /* before secondary menu, please. */
	
	// Register additional URL params
	add_filter( 'query_vars', 'register_my_query_vars' );
	
	// Loop pagination fails with taxonomy queries. /page/x
	add_filter( 'loop_pagination_args', 'fix_loop_pagination' );
	
	// Set posts per page returned by query
	add_action( 'pre_get_posts', 'set_query_defaults' );
	
	// Add extras to composition archive 
	//add_action("the_content", 'add_page_extras');

	//Add Other descriptions and images into composition content. 
	add_filter( "the_content", 'add_other_to_entry_content', 10 );
	
	//Add Other descriptions into each composition in an archive
	add_action( "the_excerpt", 'add_other_to_entry_content', 10 );

 	// Replace entry meta info with our own version. 
 	// Requires do_action change in template(s) like content.php.
	//add_filter( "the_content", 'add_my_post_meta'); Old way was to add it onto content.
	add_action("jh_entry_meta", 'my_post_meta');

 	// Replace site credit in footer with our own version. 
 	//Requires do_action change in template footer.php.
	add_action("jh_credit", 'my_credit');

	// Make the archive titles smart.
	add_filter( "hybrid_loop_title", 'my_archive_title', 15);

	//Add a gallery to tag pages. 
	add_filter( "hybrid_loop_title", 'add_content_after_title', 16);

	//DS TEST for dynamic excerpt lengths with masonry/grids
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

	//Take the CPTs out of the URL stem. 
	add_filter( 'post_type_link', 'remove_cpt_from_url', 10, 2 );
	
	//Add classes to body class. 
	//Currently for Masonry and alos adding iPhone_OS 
	//to help with webkit issues. 
	add_filter('body_class','add_body_class');
	
	add_filter('excerpt_more', 'new_excerpt_more');

	/* === Scripts === */
	add_action( 'wp_enqueue_scripts', 'jh_enqueue_scripts' );
	
	add_filter('the_posts', 'conditionally_add_scripts'); // not before wp_head?
	
	//Add tags to gallery shortcode.
	//Belongs in plugin. 
	add_shortcode( 'gallery', 'file_gallery_shortcode' );
	
	// Control Relevanssi Search results. Sort and let recordings lead.
	add_filter('relevanssi_hits_filter', 'rlv_recordings_first');
	add_filter('relevanssi_modify_wp_query', 'rlv_asc_date');
	add_filter('relevanssi_content_to_index', 'rlv_add_other_content', 10, 2);
	add_filter('relevanssi_post_ok', 'rlv_private_cpt_post_ok', 11, 2);

	//add_filter('relevanssi_excerpt_content', 'rlv_add_other_content', 10, 2); //add to exceprt
	
	//Hide Related Videos for o-embedded Youtube videos. Add optional parameters. 
	add_filter("hyrv_extra_querystring_parameters", "my_hyrv_extra_querystring_parameters");
	
	//Cleaner Gallery Image filters for adding schema.org / microdata
	add_filter( 'wp_get_attachment_image_attributes','my_attachment_image_attributes', 6, 2 );
	//add_filter( 'wp_get_attachment_link', 'my_attachment_link', 10 );
	add_filter( 'cleaner_gallery_image', 'my_cg_attachment_link', 11, 4 );
	
	add_filter( 'wpseo_pre_analysis_post_content', 'yoast_content', 10, 1 );
	//add_filter( 'wpseo_opengraph_type', 'yoast_change_opengraph_type', 10, 1 );
	//add_action( 'wpseo_opengraph', 'yoast_change_opengraph', 10 );	
}

/**
 * Returns a default primary color if there is none set.  We use this instead of setting a default
 * so that child themes can overwrite the default early.
 *
 * @since  1.0.0
 * @param  string  $hex
 * @return string
 */
function my_color_primary( $hex ) {
	return $hex ? $hex : '1897a0';
}

/* Display different header images for each main menu item "categories".
   This needs to work with custom header extended plugin which allows pickng a 
   header on a per postpage basis. maybe set a blank default $url and test. dunno. */
function my_header_image( $url ) {

	if ( filter_var($url, FILTER_VALIDATE_URL) !== FALSE ) 
		return $url; // Let CHE plugin override post/page banners. 

	if ( is_front_page() )
		$url = '';
		
	elseif ( is_page('collaborators') || is_tag() ) 
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-collaborators.jpg';

	elseif ( is_search() )
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-recordings.jpg';

	elseif ( is_search() || is_category('recordings') || in_category('recordings') )
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-recordings.jpg';

	elseif ( is_category('works') || in_category('works') ) 
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-compositions.jpg';
		
	elseif ( is_page('calendar') || (  is_page() && strpos( get_permalink(), 'calendar-archive') !== FALSE ) ) 
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-calendar.jpg';
		
	elseif ( is_page('biography') ) 
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-biography.jpg';

	elseif ( is_page('contact') || ( is_singular() && is_attachment() ) ) 
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-contact.jpg';
		
	else 
		$url = get_stylesheet_directory_uri() . '/images/headers/banner-catchall.jpg';
	
	return $url;
}

/* Display different header images & text based on our own "categories". 
	called from do_action in header.php */
function my_header_text() {
	if ( is_front_page() )
		$header_text = '';
		
	elseif ( is_page('collaborators') || is_tag() ) 
		$header_text = "Collaborators";
		
	elseif ( is_search() )
		$header_text = "Search";

	elseif ( is_category('recordings') || in_category('recordings') )
		$header_text = "Recordings & Media";

	elseif ( is_category('works') || in_category('works') ) 
		$header_text = "Compositions";
		
	elseif ( is_page('calendar') || (  is_page() && strpos( get_permalink(), 'calendar-archive') !== FALSE ) ) 
		$header_text = "Calendar";
		
	elseif ( is_page('biography') ) 
		$header_text = "Biography";

	elseif ( is_page('contact') || ( is_singular() && is_attachment() ) ) 
		$header_text = "Contact/Publishing";
		
	else 
		$header_text = '';
	
	if ( !empty($header_text) ) {
		echo '<span ' . hybrid_get_attr('header-image-text') .  '>' . 
		$header_text . '</span>';
	}
}

/* Replace breadcrumb "Home" or remove breadcrumb based on page/post. */
function my_breadcrumb( $html_breadcrumb ) {

	$bread_start = '';

	if ( is_page('contact') ) 
		$html_breadcrumb = '';
	elseif ( is_page('biography') ) 
		$html_breadcrumb = '';
	elseif ( is_page('collaborators') ) 
		$html_breadcrumb = '';
	elseif ( is_page('calendar') || ( is_page() && strpos( get_permalink(), 'calendar-archive') !== FALSE ) )
		$bread_start = 'Calendar';
	elseif ( is_tag() ) 
		$bread_start = 'Collaborators';
	elseif ( is_search() ) 
		$bread_start = 'Search';
	elseif ( is_archive() && !is_paged() ) 
		$html_breadcrumb = '';
	elseif ( is_singular() && (is_category('works') || in_category('works')) ) 
		$bread_start = 'Compositions';
	elseif ( is_singular() && (is_category('recordings') || in_category('recordings')) ) 
		$bread_start = 'Recordings & Media';
	/*
	elseif ( is_category('the_recordings') ) 
		$html_breadcrumb = str_replace('Home', 'Recordings', $html_breadcrumb );
	<span class="sep">></span>
	*/
	/* Replace
	<span class="trail-begin"><a href="http://dev4.edakavin.com" title="Jake Heggie Composer &amp; Pianist" rel="home">Home</a></span> */
	if ( !empty($bread_start) ) {
		$pattern = '@<span class="trail-begin">.+</span>@';
		//$pattern = '@>Home<@';
		$replacement = $bread_start;
		$html_breadcrumb = preg_replace($pattern, $replacement, $html_breadcrumb);
	}

	return $html_breadcrumb;
}

// Here we tell WP any custom variables that can appear on the URL. 
function register_my_query_vars( $vars ) {
	$vars[] = "srchflg"; // Specialized search flag passed in submit. 
	$vars[] = "srchhist"; // Specialized search history passed in submit. 
	return $vars;
}

// Set posts per page displayed and default order. 
// Let recordings show in natural order. 
// Sort compositions and tax queries in order of descendinng date.
// called during pre_get_posts
// Now invites publicly queryable posts into the query. 
// the idea is that we can query for regular posts, and in the main query the CPTs are added in. Categories and tags are still able to filter posts. 
function set_query_defaults( $query ) {
	
	if ( is_admin() ) { $query->set( 'posts_per_page', '-1' ); return; }
	
	// 1. If only posts in main query we also include publicly queryable CPTs.
	// add CPTs for archives and queries without /cpt/ example.com/hello_world
	if ( $query->is_main_query() ) {
			
			//echo '<pre>';
			//var_dump($query);
			//echo '</pre>';
			
		if (	( is_tag() || is_tax() || is_category() ) ||
				(	count($query->query) == 2 && 
					isset($query->query['page']) && isset($query->query['name']) &&
					empty($query->query['page']) && !empty($query->query['name']) )
		   )
		{
			//See routine get_queryable_posts
			$post_types = get_queryable_posts();
			$query->set( 'post_type', $post_types );
		}
	}
	
	// 2. set order, posts per page
	if ( is_category('recordings') ) {
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'posts_per_page', '-1' );
	} 
	elseif ( is_tax('other') )  {
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'name' );
		$query->set( 'posts_per_page', '-1' );
	}
	elseif ( is_tax() || is_category('works') )  {
		$query->set( 'order', 'DESC' );
		$query->set( 'orderby', 'date' );
	}
	elseif ( is_tag() ) {
		$query->set( 'order', 'DESC' );
		$query->set( 'orderby', 'date' );
	}
	return; 
}

// Add tags to attachments. NEW!!!
function wptp_add_tags_to_attachments() {
	register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}

// Conditonally add body classes to the page for a variety of reasons. 
// We need a body class to flag if the client is on iOS 
// so we can deal with webkit issues. 
// set up masonry on archive oages. 
function add_body_class( $body_classes ) {
	if ( isset($_SERVER['HTTP_USER_AGENT']) && 
		  ( strstr($_SERVER['HTTP_USER_AGENT'], 'iPod') ||
			strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') ||
			strstr($_SERVER['HTTP_USER_AGENT'], 'iPad') ) 
		  ) {
		// add ios to body class so dropdowns can be handled differently. 
		$body_classes[] = 'iOS';
	}
	if ( is_archive() ) {
		//Set class for masonry on taxonomy archives. 
		//Theme.js will see col-masonry and set class col-masonry-active
		$body_classes[] = 'col-masonry'; // Set view
		$body_classes[] = 'col-auto'; // Set responsive no. of columns
	}	
	if ( is_archive() && is_category('recordings') ) {
		//Set a default view for the recordings archive. 
		$body_classes[] = 'col-tile'; // Set view
	}
	
	return $body_classes;
}

// ds header site title -- Force in bc the real site title has composer & pianist in it. 
function header_site_title() {
	$str = '<div id="site-title"><a href="' . get_bloginfo('url') . '" title="Jake Heggie" rel="home"><span>Jake Heggie</span></a></div>';
	echo $str;
}

// ds header site description -- Force in bc the real one says official  
function header_site_description() {
	$str = '<div id="site-description"><a href="' . get_bloginfo('url') . '">Composer &amp; Pianist</a></div>';
	echo $str;
}

/* Called from footer.php to print the site credit.
Translators: 1 is current year, 2 is site name/link, 3 is WordPress name/link, and 4 is theme name/link. */
function my_credit() {
	$loginout = '<span class="loginlink">' . wp_loginout( '', false ) . '</span>';
	
	printf( '<span class="credit">The Official Website of Jake Heggie.&nbsp;</span> %1$s<span class="copyright">Copyright &#169; %2$s %3$s</span>', 
		 $loginout ,
		 date_i18n( 'Y' ), 
		 '<a href="'. home_url('/contact') .'">Bent Pen Music, Inc.</a>'
	  );
	/* original here:	printf(	__( 'Copyright &#169; %1$s %2$s. Powered by %3$s and %4$s.', 'stargazer' ), 
	date_i18n( 'Y' ), hybrid_get_site_link(), hybrid_get_wp_link(), hybrid_get_theme_link() ); 
	*/
}

// Fix pagination URLs by removing /page/x and
// add page number query arg in its place. 
function fix_loop_pagination($args) {
	
	global $wp_rewrite;
	
	/* Get the pagination base. */
	$pagination_base = $wp_rewrite->pagination_base;
	
	$urlbase = get_pagenum_link();
	
	// Remove 'page/n' of in the link.  Probably not needed.
	$urlbase = preg_replace( 
		array( 
			"#(href=['\"].*?){$pagination_base}/[0-9]+(['\"])#",  // 'page/2'
			"#(href=['\"].*?){$pagination_base}/[0-9]+/(['\"])#", // 'page/2/'
			"#(href=['\"].*?)\?paged=[0-9]+(['\"])#",             // '?paged=2'
			"#(href=['\"].*?)&\#038;paged=[0-9]+(['\"])#"         // '&#038;paged=2'
		), 
		'$1$2', 
		$urlbase
	); 
	
	//$args['base'] = add_query_arg( 'paged', '%#%', $urlbase ); 
	//bug! add_q inserts &paged=%#% in middle of arguments
	//and bogus #038 inserted. Up and did it myself below.
	 $urlbase = str_replace('#038;', '', $urlbase);
	 
	if ( strpos($urlbase,'?') == false ) $addchr = '?';
	else $addchr = '&';
	//( strpos($urlbase,'?') == false ) ? $addchr = '?' : $addchr = '&';
	$args['base'] = $urlbase . $addchr . 'paged=%#%';
		
	//echo '<pre>' . $args['base'] . '</pre>'; // debug
	return $args;
}

/*
// Add rules to rewrite rules. Manual flush required.  
function fix_pagenum_rewrite($rules) {
	//echo '<pre>';
	//var_dump($rules);
	//echo '</pre>';
	$newrule = array();
	//$newrule['(works)/?$'] = 'index.php?category_name=$matches[1]';
	return $newrule + $rules;
}
//(recordings)/?$	index.php?category_name=$matches[1]	category
///page/([0-9]+)
*/

// Add the query's taxonomy onto category and taxonomy archive titles.
// Compositions becomes Compositions and Song and Mezzo-Soprano
// NOTE: Style file prepends Tagged or Searched before those archive titles. 
function my_archive_title($title) {
	
	if ( ( is_category() && is_tag() ) || is_tax() ) {

		// List all tax terms in archive title.
		$title = '';
		global $wp_query ;
		$tax_array = $wp_query->query ;
		//echo '<pre>';
		//var_dump($tax_array);
		//echo '</pre>';
		$first = true;
	
		foreach ($tax_array as $key => $value) {
		
			// get_term_by( slug, term value, taxonomy )
			// query returns 'category_name' and 'tag' for some reason.
			$taxval = $key;
			
			if ($taxval == "category_name") $taxval = 'category';
			if ($taxval == "tag") $taxval = 'post_tag';
			$tax = get_term_by( 'slug', $value, $taxval );
			if ($tax) {
				$tax_name = $tax->name;
				if ( !$first ) $title .= '<span style="font-size: 67%"> and</span>';
				$title .= ' ' . $tax_name;
				$first = false;
			}
		}
	}
	if (is_category('works')) {
		$title .= '<span style="font-size: 67%"> (by date)</span>';
	}
	if (is_tag() ) {
		$title .= ' Tag Page';
	}
	if ( true ) {
		global $wp_query;
		$last_page = $wp_query->max_num_pages; // 1 if not paged.
		if ( $last_page == 1 || !is_paged() ) {} // Page 1
		else {
				$title .= '<span style="font-size: 67%">, cont.</span>';
			}
	}
	return $title;
}

// Replaces the excerpt ellipsis with a [more] link
function new_excerpt_more($more) {
	global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '"> [more]</a>';
}

/* routines to help integrate Custom Post Types */
//Remove CPTs from URL. 
//THIS WILL BREAK THE SITE BECAUSE THESE URLS WONT WORK UNLESS THE QUERY ADDS THEM IN AUTOMATICALLY. 
//THUS is the merge-into-query method: auto-add before, auto-filter after.  
function remove_cpt_from_url( $url, $post ) {

	//get non built-in queryable posts. 
	//Note we could call the get_queryable_posts routine below and then remove 'post' from it. 
	$args = array(
		'public' => true,
		'publicly_queryable' => true,
		'_builtin' => false
	);
	$output = 'names';
	$operator = 'and';

	$post_types = get_post_types( $args, $output, $operator );
	
	if ($post_types) {
		// Add 'link' and/or 'page' to array() if you want these included.
		// array( 'post', 'link', 'page' ), etc.
		//$post_types = array_merge( $post_types, array( 'post' ) );
		
		$this_post_type = get_post_type( $post );
		
		if ( in_array($this_post_type, $post_types) ) {
			$url = str_replace('/' . $this_post_type . '/', '/', $url);
		}
	}
    return $url;
}

if ( !function_exists('get_queryable_posts') ) {
// Helper routine to get all queryable posts
// Used in set_query_defaults (pre_get_posts)
// Also in ds_plugin-functions
  function get_queryable_posts() {
	$args = array(
		'public' => true,
		'publicly_queryable' => true,
		'_builtin' => false
	);
	$output = 'names';
	$operator = 'and';

	$post_types = get_post_types( $args, $output, $operator );

	return array_values( array_merge( $post_types, array( 'post' ) ) );

  }
}

//Set the long excerpt length, and grid/column code uses wp_trim_words to shorten it to 20.
function custom_excerpt_length( $length ) {
	return 55;
}

function jh_enqueue_scripts(){

	if( true == true ){
		/* wp_enqueue_script('theme'); */
		//wp_enqueue_script( 'imagesloaded', get_stylesheet_directory_uri() . '/js/imagesloaded.min.js', array(), false, false );
		wp_enqueue_script( 'theme', get_stylesheet_directory_uri() . '/js/theme.min.js', array(), false, false );
		//wp_dequeue_script('masonry');
		wp_enqueue_script('masonry');
		wp_enqueue_script( 'theme-footer', get_stylesheet_directory_uri() . '/js/theme-footer.min.js', array('jquery', 'masonry'), false, true );
		wp_dequeue_script('gigpress-js');
		wp_enqueue_script('gigpress-js', plugins_url('gigpress/scripts/gigpress.js', 'gigpress'), array('jquery'), false, true);
		wp_enqueue_style('dashicons');
		//wp_enqueue_script('theme-footer', get_stylesheet_directory_uri() . '/js/theme-footer.min.js', array('jquery'), false, true );
		/*wp_enqueue_style( 'themename-style', get_stylesheet_uri(), array( 'dashicons' ), '1.0' ); /* This loads child style.css twice!*/
		wp_enqueue_style( 'mfp-styles', get_stylesheet_directory_uri() . '/css/magnific-popup.css' );
	}
}

function widget_area_init() {

	register_sidebar( array(
		'name' => 'Filter Toggle Area',
		'id' => 'filter_toggle_area',
		'description' => '',
		'class' => '',
		'before_widget' => '<div id="filter-item-%1$s"  class="filter-item">',
		'after_widget' => '</div><!-- filter-item -->',
		'before_title' => '<label>',
		'after_title' => '</label>'
	) );

	register_sidebar( array(
		'name' => 'Header Widget Area',
		'id' => 'header_widget_area',
		'description' => 'Header Widget Area',
		'class' => '',
		'before_widget' => '<div id="header-widget-%1$s" class="header-item">',
		'after_widget' => '</div><!-- header-item -->',
		'before_title' => '<label>',
		'after_title' => '</label>'
	) );

	register_sidebar( array(
		'name' => 'Works Genre Area',
		'id' => 'works_genre_area',
		'description' => 'Works Genre Area',
		'class' => '',
		'before_widget' => '<div id="works-genre-%1$s" class="works-genre-item">',
		'after_widget' => '</div><!-- works-genre-item -->',
		'before_title' => '<label>',
		'after_title' => '</label>'
	) );
	
	register_sidebar( array(
		'name' => 'Archive Top Content Area',
		'id' => 'archive_top_content_area',
		'description' => 'Archive Top of Content Area',
		'class' => '',
		'before_widget' => '<div id="archive-top-%1$s" class="archive-top-item">',
		'after_widget' => '</div><!-- #archive-top-item -->',
		'before_title' => '<label>',
		'after_title' => '</label>'
	) );
}


function header_widget_area() {

	if ( is_active_sidebar( 'header_widget_area' ) ) {
		echo('<div id="header_widget_area" class="header_widget_area" >');
		dynamic_sidebar( 'header_widget_area' );
		echo('</div><!-- #header_widget_area -->');
	}
}

function conditionally_add_scripts($posts) { // triggers before wp_head

	if (empty($posts)) return $posts;
 
	//Enqueue Royal Slider and Magnific Popup Lightbox JS if their shortcodes present. 
	$gallery_shortcode_found = false; // Should read this from get_gallery_shortcode 
	//$royal_slider_shortcode_found = false; // enqueue if found.
	
	foreach ($posts as $post) {
		if ( has_shortcode( $post->post_content, 'gallery') ) {
			$gallery_shortcode_found = true; // bingo!
			break;
		}
		/*if ( has_shortcode( $post->post_content, 'new_royalslider') ) {
			$royal_slider_shortcode_found = true; // bingo!
		}
		if ( $gallery_shortcode_found && $royal_slider_shortcode_found ) break;
		*/
	}
	if( $gallery_shortcode_found || is_tag() ) {
		// Load JS in footer
		wp_enqueue_script( 'mfp-scripts', get_stylesheet_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'mfp-custom', get_stylesheet_directory_uri() . '/js/magnific-custom.min.js', array( 'jquery', 'mfp-scripts' ), '1.0', true );
	}
	/*if( $royal_slider_shortcode_found ) {
		// Load JS in footer
	}
	*/
	return $posts;
}

//Add gallery to tag page content. 
function add_content_after_title( $title ) {

	if ( is_tag() ) {
		global $wp_query;
		$gallery = '';
		$last_page = $wp_query->max_num_pages; // 1 if not paged. 
		//echo '<pre>pages max '. $wp_query->max_num_pages . '</pre>';
		if ( $last_page == 1 || !is_paged() ) {
			$tagged_photos = true;
			if ( $tagged_photos ) {
				$gallery = do_shortcode('[ds_gallery size=large tax_located_in=query tax_in_query=tag]'); //ids="2126,2127"
			}
		}
		if ( $gallery )  $title .= $gallery;
	}
	return $title;
}

//Add links to top of composition archive.
//Depricated 
function add_page_extras( $content) {
/*
		ob_start();
		dynamic_sidebar( 'works_genre_area' );
		$sidebar = ob_get_contents();
		ob_end_clean();
		if ( $sidebar ) $content = $sidebar . $content;
*/
	return $content;
}

//Add search of pages for this tag to end of (last page) of tag pages. 
function add_tag_page_extras( $content ) {
	if ( is_tag() ) {
		global $wp_query;
		$last_page = $wp_query->max_num_pages; // 1 if not paged. 
		if ( $last_page == 1 || is_paged($last_page) ) {
			$search = '';
			if ( shortcode_exists('ds_search') ) $search = do_shortcode('[ds_search tax_located_in=query tax_in_query=tag post_type=page ]'); //search only pages
			if ( $search ) $content .= $search;
		}
	}
	return $content;
}

// If this is a singular composition post, or a search archive excerpt, 
// we auto insert text and images from Other taxonomy into entry content.
// Are we called twice? (the_excerpt and the_content)
function add_other_to_entry_content($content) {

	if ( !( is_category('works') || in_category('works') ) ) return $content;

	ob_start();
	if ( is_singular() ) {
		display_other_text(); // recorded, rental, etc.
		display_other_images(); // schirmer, holab
	} 
	else {
		display_other_text(); // recorded, rental, etc.
		$search = get_query_var( 's' );
		if ( $search ) display_other_images(); //display images on searches. 
	}
	$output = ob_get_contents();
	ob_end_clean();
	if ($output) $content .= $output;
	
	return $content . '[add_other]';
}

function display_other_images() {
	$output = get_other_images();
	if( $output ) echo $output;
}

function display_other_text() {
	global $post;
	$output = get_other_text($post);
	if( $output ) echo $output;
}

// Service Routine. Return descriptions from this Composition post's Other tax terms. Sorts by slug. 
// Called with post in case we arent working on the current query. 
// dont know if is_singular will trigger when search calls, but not worried. 
function get_other_text($post) {

	if ( !has_category('works', $post) ) return false;

	$before = '<div class="autoinsert"><p class="autoinserttext">';
	$after = '</p></div>';
	$inbtw = '&nbsp;&nbsp;';

	$terms = get_the_terms( $post->ID, 'other' );
	if ( !$terms ) return false;
	
	$tmp = array();
	$output = '';
	
	foreach ($terms as $term) {
		$addthis = '';
		// one tricky add search link here so the recording can be easily searched. 
		if (is_singular() && $term->slug == 'recorded') {
			// repeated in display_other_image :(
			$title_array = explode('-', $post->post_name);
			$keywords = implode('+', $title_array);
			$bhm_keywords = preg_replace('#\+\d\d\d\d#', '', $keywords); // eat +1999 etc.
			$search_keywords = preg_replace('#\+#', ' ', $bhm_keywords); // make + into sp for site search	
			$search_url = get_search_link();
			$addthis = '(Here is a <a rel="nofollow" href="' . $search_url . $search_keywords . '">Search</a> for them.) ';
		}
		$tmp[$term->slug] = $term->description . $addthis;
	}
	ksort($tmp);
	$first = true;
	foreach ($tmp as $key => $value) {
		if (!$first) $output .= $inbtw;
		$output .= $value;
		$first = false;
	}
	return $before . $output . $after;
}


// Service Routine. Return descriptions from this Composition post's Other tax terms. Sorts by slug. 
// A very specialized routine. 
function get_other_images() {

	if ( !( is_category('works') || in_category('works') ) ) return false;

	global $post;
	$before = '<div class="autoinsert"><p class="autoinsertimage">';
	$after = '</p></div>';
	$inbtw = '&nbsp;&nbsp;';

	$terms = get_the_terms( $post->ID, 'other' );
	if ( !$terms ) return false;
	
	// specialized image links require preparation
	//$redir_base = 'http://jakeheggie.com/t.php?link=';
	$schirmer_url = 'http://halleonard.com/search_items.jsp?keywords=Heggie&catcode=0&type=product';
	$title_array = explode('-', $post->post_name);
	$keywords = implode('+', $title_array);
	$bhm_keywords = preg_replace('#\+\d\d\d\d#', '', $keywords); // eat +1999 etc.
	$search_keywords = preg_replace('#\+#', ' ', $bhm_keywords); // make + into sp for search
	$bhm_base = 'http://www.billholabmusic.com/store/index.php?main_page=advanced_search_result&search_in_description=1&categories_id=108&keyword=';
	$bhm_rental_base = 'http://www.billholabmusic.com/rent-music/?Composer=14&Title=';
	$class = 'imginsert';
	$url = '';
	
	$tmp = array();
	$output = '';
	
	foreach ($terms as $term) {
		$tmp[$term->slug] = $term->description;
	}
	ksort($tmp);
	foreach ($tmp as $key => $value) {
		$img = false;
		if ( $key == 'score_purch') {

			$image_id = '1426';
			$url = $bhm_base . $bhm_keywords;
			//$url = $redir_base . rawurlencode($url);
			$img = get_an_image($image_id, $url, $class);

		} elseif ($key == 'score_rent') {

			$image_id = '1427';
			$url = $bhm_rental_base . $bhm_keywords;
			//$url = $redir_base . rawurlencode($url);
			$img = get_an_image($image_id, $url, $class);

		} elseif ($key == 'score_schirmer') {

			$image_id = '2016'; /* used to be '1393'; */ // media image ID
			$url = $schirmer_url;
			//$url = $redir_base . rawurlencode($url);
			$img = get_an_image($image_id, $url, $class);
		}
		if( $img ) $output .= $img;
	}
	return $before . $output . $after;
}

// Code much easier to read if we break out the image creation. 
function get_an_image( $id, $url, $class) {
	$output = '<span class="'. $class . '"><a href="' . $url . '" target=_blank >';
	$output .= wp_get_attachment_image( $id, 'full' );
	$output .= '</a></span>';
	return $output;
}

//Package wrapper form gallery shortcode. 
//Accepts tag as a parameter and exoands it into ids. 
//Really belongs in plugin. 
function file_gallery_shortcode( $atts ) {

	if ( isset($atts['tag']) ) {

		// Create the query array
		$qargs = array(
			'post_type' => 'attachment',
			'posts_per_page' => 10,
			'post_status' => 'any', //NEEDED FOR ATTACHMENT QUERIES!
			'tag' => $atts['tag']
			);
		$the_query = new WP_Query( $qargs );

		if ( $the_query->have_posts() ) {

			$atts['ids'] = '';
			$first = true;
			
			while ( $the_query->have_posts() ) {

				$the_query->the_post();
				$atts['ids'] .= ($first ? '' : ',') . $the_query->post->ID;
				$first = false;
			}
		}
		else return; //No posts means no images to show. 
	}
	return gallery_shortcode( $atts );
}

function my_post_meta() {
	$all_tax_meta = get_post_tax_meta();
	if( $all_tax_meta ) echo $all_tax_meta;
}

// Generate Post's complete Taxonomy meta
// Returns string of shortcodes "[ ] [ ]" or false if error. 
function get_post_tax_meta() {

	global $post ;
	// get post type by post
	$post_type = $post->post_type;

	// get post type taxonomies
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );
	
	if (!$taxonomies) return false;
	$all_tax_meta = '| '; // Build |result|
	$arrow = "&#x21a0;";
	
	foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

		// get the terms related to post
		$terms = get_the_terms( $post->ID, $taxonomy_slug );
		if ( !empty( $terms ) ) {
			$label = $taxonomy->label;
			$the_meta = hybrid_get_post_terms( array( 'taxonomy' => $taxonomy_slug,
			 'text' => __(  $label . $arrow . '%s | ', 'mehta' ), 
			 'sep' => ' ' ) );
			//template-post.php holds this routine.  
			//field items_wrap is <span %s>%s</span>
			//$shortcode = '[entry-terms taxonomy="' .
			//$taxonomy_slug . '" before="' . $label . $arrow . '" after="&nbsp;|"] ';
			//$shortcode =  '[entry-terms taxonomy="genre"]';
			$all_tax_meta .= $the_meta; 
		}
	}
	$all_tax_meta .= '<br /><br />'; // end of post spacing. 
	$atomic_meta = '<div ' . hybrid_get_attr('entry-meta') . '>' . $all_tax_meta . '</div>';
	return $atomic_meta;
}

// Relevanssi Search results sorted here. 
// Test for srchflg in query vars (URL) and apply filter(s) accordingly. 
// Put results that are recordings at the top of the list, followed by compositions, followed by everything else. 
function rlv_recordings_first($hits) {
	
	// DS tries to implement search category filter when url param srchflg is present.
	// Eventually we can test for srchfog value and do different operations.
	// Filter only for Recordings and Compositions => categories 7 and 9.  
	$srchflg = get_query_var( 'srchflg' );
	if ( !empty($srchflg) ) {
		foreach ( $hits[0] as $key => $hit ) {
			$categories = get_the_category($hit->ID);
			if ( $categories ) {			
				foreach ( $categories as $cat ) {
					if ($cat->cat_ID != 7 && $cat->cat_ID != 9) {
						unset($hits[0][$key]);
					}
				}
			} else { unset($hits[0][$key]); } // Pages have no categories. Kill. 
		}
	}

	$recordings = array();
	$compositions = array();
	$everything_else = array();
	foreach ($hits[0] as $hit) {
		$is_recording = false;
		$is_composition = false;
		foreach (get_the_category($hit->ID) as $cat) {
			if ($cat->cat_ID == 7) {
				$is_recording = true;
				break;
			} 
			if ($cat->cat_ID == 9) {
				$is_composition = true;
				break;
			}
		}
		if ($is_recording) array_push($recordings, $hit);
		else if ($is_composition) array_push($compositions, $hit);
		else array_push($everything_else, $hit);
	}
 
	$hits[0] = array_merge($recordings, $compositions, $everything_else);
	return $hits;
}
	
// Relevanssi Search order for Relevanssi
function rlv_asc_date($query) {
    $query->set('orderby', 'post_date');
    $query->set('order', 'DESC');
    return $query;
}

// Relevanssi Search -= Add Other content to post so it is included in search.
function rlv_add_other_content($content, $post) {
	$output = get_other_text($post);
    if( $output ) $content .= $output;
    return $content;
}

// Allow editors to search private CPTs
function rlv_private_cpt_post_ok($post_ok, $doc) {
	$status = relevanssi_get_post_status($doc);
 
	if ('private' == $status) {
		//$type = relevanssi_get_post_type($doc);
		//if ($type == 'the_recordings') $type = "post";
		$cap = 'edit_private_posts';
		if (current_user_can($cap)) {
			$post_ok = true;
		}
	}
 
	return $post_ok;
}

/* OpenGraph Meta Data - Expand shortcodes to add images reported into the meta data*/
function yoast_content( $content) {
	return do_shortcode($content);
}

/* OpenGraph Meta Data - If needed, change the reported post/page type */
/* function yoast_change_opengraph_type( $type ) {

	if ( is_page( 'X' ) )
    return 'video';
} */

/* OpenGraph Meta Data - If needed, add to the Yoast meta data.  */
/* function yoast_change_opengraph() {

	// Insert into WP SEO's Open Graph meta data.
	echo '<!--' . 'hello' . '-->';
	
    return ;
} */

//YOUTUBE Embedded Parameters Filter 
//Requres plugin Hide Related Videos
//add_filter("hyrv_extra_querystring_parameters", "my_hyrv_extra_querystring_parameters");
//If you want to pass in some other parameters to the youtube embedded url, we can do so 
//IMPORTANT 1: Just make sure you end with an ampersand.
//IMPORTANT 2: Inactivate/Reactivate after changing here so that the cache is cleared.
//str$ should arrive 'wmode=transparent' and rel=0 gets appended by the plugin after this.
function my_hyrv_extra_querystring_parameters($str) {
	//return "wmode=transparent&amp;MY_VAR_NAME=MY_VALUE&amp;";
	//return ""; //Remove the wmode=transparent:
	//return $str . "autoplay=1&wmode=opaque&showinfo=0&modestbranding=0&";
	return $str . "showinfo=0&";
}
function my_cg_attachment_link( $image, $id, $attr, $instance ) {

	//return $image . "<!-- hello filter -->";
	return preg_replace( '/(<a.*?)>/i', '$1 itemprop="contentURL">', $image );
}

function my_attachment_image_attributes( $attr, $attachment ) {

	/* if ( true === $this->has_caption )
		$attr['aria-describedby'] = esc_attr( "figcaption-{$this->args['id']}-{$attachment->ID}" );
	*/
	//$attr['itemprop'] = 'thumbnail';
	$attr['itemprop'] = 'image thumbnail';


	return $attr;
}
	
/**/
