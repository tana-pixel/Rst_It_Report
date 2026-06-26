<?php




// Woo Comments Form filter
add_filter( 'woocommerce_product_review_comment_form_args', 'autlines_filter_function_comments_form' );
function autlines_filter_function_comments_form( $comment_form ){
    // filter...
    $commenter = wp_get_current_commenter();

    $comment_form = array(
        /* translators: %s is product title */
        'title_reply'         => have_comments() ? esc_html__( 'Add New Review:', 'autlines' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'autlines' ), get_the_title() ),
        /* translators: %s is product title */
        'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'autlines' ),
        'title_reply_before'  => '<h4 id="reply-title" class="comment-reply-title">',
        'title_reply_after'   => '</h4>',

        'fields'              => array(
            'author' => '<div class="input-fields-wrapper"><div class="author-name comment-form-author">
                            <label>' . esc_attr__( 'Name *', 'autlines' ) . '</label>
                            <input id="author" name="author" type="text"  value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></div>',
            'email'  => '<div class="author-email comment-form-email">
                                <label>' . esc_attr__( 'Email *', 'autlines' ) . '</label>
                                <input id="email" name="email"  type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></div></div>',
        ),
        'label_submit'        => esc_html__( 'Submit', 'autlines' ),
        'logged_in_as'        => '',
        'comment_field'       => '',
        'class_submit'        => 'hidden button',
        'comment_notes_after' => '<div class="submit-btn-container">
                                            <button type="submit" class="fl-submit-comment default-btn fl-font-style-bolt-two fl-secondary-bg">' . esc_attr__('Submit', 'autlines') . '</button>
                                  </div>',
    );

    $account_page_url = wc_get_page_permalink( 'myaccount' );
    if ( $account_page_url ) {
        /* translators: %s opening and closing link tags respectively */
        $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'autlines' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
    }

    if ( wc_review_ratings_enabled() ) {
        $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'autlines' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_attr__( 'Rate&hellip;', 'autlines' ) . '</option>
						<option value="5">' . esc_attr__( 'Perfect', 'autlines' ) . '</option>
						<option value="4">' . esc_attr__( 'Good', 'autlines' ) . '</option>
						<option value="3">' . esc_attr__( 'Average', 'autlines' ) . '</option>
						<option value="2">' . esc_attr__( 'Not that bad', 'autlines' ) . '</option>
						<option value="1">' . esc_attr__( 'Very poor', 'autlines' ) . '</option>
					</select></div>';
    }

    $comment_form['comment_field'] .= '<div class="author-comment comment-form-comment">
                        <label>' . esc_attr__( 'Your review *', 'autlines' ) . '</label>
                        <textarea id="comment"  name="comment" cols="45" rows="8" required></textarea>
                        </div>';

    return $comment_form;
}




// Remove RElated Product In Single Page Shop
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);


if(!class_exists('Fl_Helping_Addons')){
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
}
