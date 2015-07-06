<?php get_header(); // Loads the header.php template. ?>
<!--hello from taxonomy.php -->
	
	<?php if ( !is_front_page() && !is_singular() && !is_404() ) : // If viewing a multi-post page ?>

		<div <?php hybrid_attr( "works-filter-wrap" ); // DS Code here ?>>
		  <div <?php hybrid_attr( "works-filter" ); ?>>
	
			<?php if ( is_active_sidebar( 'filter_toggle_area' ) ) : ?>
				<?php dynamic_sidebar( 'filter_toggle_area' ); ?>
			<?php endif; ?>
		  </div><!-- .works-filter -->
	
		  <div class="filter-toggle-wrap">
			<a class="works-filter-toggle" href="#" rel="nofollow"><span>Open/Close Filter</span></a>
			<div class="filter-toggle-wrap-left">
				<a class="works-grid-toggle" href="#" rel="nofollow" title="Grid View"><span>Grid</span></a>
				<a class="works-tile-toggle" href="#" rel="nofollow" title="Tile View"><span>Tile</span></a>
				<a class="works-list-toggle" href="#" rel="nofollow" title="List View"><span>List</span></a>
	
			</div><!-- .filter-toggle-wrap-left -->
		  </div><!-- .filter-toggle-wrap -->
		</div><!-- .works-filter-wrap -->
	
		<br /><!-- main put here -->

		<?php hybrid_get_menu( 'breadcrumbs' ); // Loads menu/breadcrumbs.php template. ?>
		
		<main <?php hybrid_attr( 'content' ); ?>>
		
		<?php if ( is_active_sidebar( 'archive_top_content_area' ) ) : ?>
			<div <?php hybrid_attr( "archive-top-content-area" ); // DS Code ?>>
				<?php dynamic_sidebar( 'archive_top_content_area' ); ?>
			</div><!-- #archive-top-content-area -->
		<?php endif; ?>
		
		<?php locate_template( array( 'misc/loop-meta.php' ), true ); // Loads the misc/loop-meta.php template which displays entry title. ?>
	
	<?php else : // Not a multi-post page. ?>
		
		<?php hybrid_get_menu( 'breadcrumbs' ); // Loads menu/breadcrumbs.php template. ?>

		<main <?php hybrid_attr( 'content' ); ?>>
	
	<?php endif; // End check for multi-post page. ?>

	<?php if ( have_posts() ) : // Checks if any posts were found. ?>

		<div <?php hybrid_attr( "content-entry-wrap" ); //DS ?>>
		
			<?php while ( have_posts() ) : // Begins the loop through found posts. ?>
	
				<?php the_post(); // Loads the post data. ?>
	
				<?php get_template_part( 'content', 'taxonomy' ); // DS Loads content-taxonomy template. ?>
	
				<?php if ( is_singular() ) : // If viewing a single post/page/CPT. ?>
	
					<?php comments_template( '', true ); // Loads the comments.php template. ?>
	
				<?php endif; // End check for single post. ?>
	
			<?php endwhile; // End found posts loop. ?>
	
		</div><!-- .content-entry-wrap -->
	
		<?php locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>

	<?php else : // If no posts were found. ?>

		<?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>

	<?php endif; // End check for posts. ?>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>



