			<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>

		</div><!-- #main -->

		<?php hybrid_get_sidebar( 'subsidiary' ); // Loads the sidebar/subsidiary.php template. ?>

		<?php hybrid_get_menu( 'subsidiary' ); // Loads the menu/subsidiary.php template. ?>

<footer <?php hybrid_attr( 'footer' ); ?>>

	<div class="footer_wrap">

		<?php wp_nav_menu(
			array(
				'menu'            => 'footer',
				'container'       => 'nav',
				'menu_id'         => 'menu-footer-items',
				'menu_class'      => 'menu-items',
				'fallback_cb'     => '',
				'items_wrap'      => '<div class="wrap"><ul id="%s" class="%s">%s</ul></div>'
			)
		); ?>
		
		<p class="credit">
			<?php do_action('jh_credit'); ?>
		</p><!-- .credit -->

	</div><!-- .footer_wrap -->

</footer><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

</body>
</html>