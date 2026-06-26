<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

$empty_title = esc_html__('Your cart is currently empty.', 'autlines');

if (is_cart() != true) {
	$empty_title = esc_html__('Your wishlist is currently empty.', 'autlines');
}

?>

<div class="fl-wishlist-woo-empty-content text-center">
			<div class="title-content">
				<p class="cart-empty fl-text-title-style">
					<?php
					if (is_cart() == true) {
						do_action( 'woocommerce_cart_is_empty' );
					} else {
						echo esc_html($empty_title);
					}
					?>
				</p>
				<p class="subtitle">
					<?php esc_html_e('You may check out all the available products and buy some in the shop.', 'autlines'); ?>
				</p>
			</div>

		<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
			<p class="return-to-shop">
				<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
					<?php esc_html_e( 'Return To Shop', 'autlines' ) ?>
				</a>
			</p>
		<?php endif; ?>
</div>