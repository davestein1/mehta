<!-- hello from taxonomy-content called by taxonomy.php-->
<article <?php hybrid_attr( 'post' ); ?>>
<?php /*. ( has_post_thumbnail() ? ', has-post-thumbnail' : '' ) ); */ ?>

	<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post. ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

			<div class="entry-byline">
				<span <?php hybrid_attr( 'entry-author' ); ?>><?php the_author_posts_link(); ?></span>
				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' ); ?>
				<?php if ( function_exists( 'ev_post_views' ) ) ev_post_views( array( 'text' => '%s' ) ); ?>
				<?php edit_post_link(); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<div class="entry-meta">
				    <?php edit_post_link(); ?>
			    <?php do_action('jh_entry_meta'); ?>
			</div>
		</footer><!-- .entry-footer -->

	<?php else : // If not viewing a single post. ?>

		<div <?php hybrid_attr( 'entry-wrap' ); ?>>

			<div <?php hybrid_attr( 'entry-media' ); ?>>
				<?php
				$image_class = 'theme-thumbnail';
				if ( has_post_thumbnail() ) {
					$post_thumbnail_id = get_post_thumbnail_id();
					$thumb_meta = wp_get_attachment_metadata($post_thumbnail_id);
					$thumb_file = $thumb_meta['file'];
					//echo $thumb_file;
					$find = '/icon-';
					$pos = strpos($thumb_file, $find);
					if ($pos !== false) $image_class = ' icon-thumbnail'; /* style icons */
				} ?>
				<?php get_the_image( array( 'attachment' => false, 'size' => 'thumbnail', 'image_class' => "$image_class" ) ); /* in library/extensions/get_the_image.php */?>
			</div>

			<div <?php hybrid_attr( 'entry-inner' ); ?>>
			
				<header <?php hybrid_attr( 'entry-header' ); ?>>
				  <?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
				</header><!-- entry-header -->

				<div <?php hybrid_attr( 'entry-summary' ); ?>>
					<div class="entry-summary-short">
						  	<?php $content = get_the_excerpt();
						 	$trimmed_content = wp_trim_words( $content, 20, '<a href="'. get_permalink() .'"> [More]</a>' );
						 	echo $trimmed_content; ?>
					</div>
					<div class="entry-summary-long">
							 	<?php the_excerpt(); ?>
					</div>

				</div><!-- .entry-summary -->

				<div class="entry-footer">
				  <div <?php hybrid_attr( 'entry-meta' ); ?>>
						<?php edit_post_link(); ?>
						<?php do_action('jh_entry_meta'); ?>
				  </div>
				</div><!-- .entry-footer -->
			</div><!-- .entry-inner -->
	   </div><!-- .entry-wrap -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->