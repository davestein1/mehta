			<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>

		</div><!-- #main -->

		<?php hybrid_get_sidebar( 'subsidiary' ); // Loads the sidebar/subsidiary.php template. ?>

		<?php hybrid_get_menu( 'subsidiary' ); // Loads the menu/subsidiary.php template. ?>

<footer <?php hybrid_attr( 'footer' ); ?>>

	<div class="wrap">

		<?php wp_nav_menu( 'footer' ); ?>
		
		<p class="credit">
			<?php do_action('jh_credit'); ?>
		</p><!-- .credit -->

	</div><!-- .wrap -->

</footer><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

</body>
</html>