<?php
/**
 * The template for displaying the footer
 * @subpackage Royal Banquet Hall
 * @since 1.0
 * @version 0.1
 */

?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-overlay"></div>
		<div class="container">
			<div class="f_innbx">
			<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>
			</div>
		</div>
		<div class="copyright"> 
			<div class="container">
				<div class="col-md-12"><?php get_template_part( 'template-parts/footer/site', 'info' ); ?></div>
			</div>
		</div>
	</footer>
	<?php if (get_theme_mod('luzuk_royal_banquet_hall_show_back_totop',true) != ''){ ?>
		<button role="tab" class="back-to-top"><span class="back-to-top-text"><?php esc_html_e('Top', 'royal-banquet-hall'); ?></span></button>
	<?php }?>

<?php wp_footer(); ?>
</body>
</html>