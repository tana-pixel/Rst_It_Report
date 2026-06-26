<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package autlines
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
if( !class_exists('Fl_Helping_Addons')){
    $comment_html_class = 'comment-without-back';
} else {
    $comment_html_class = '';
}


?>

<div class="comments-container <?php echo esc_attr($comment_html_class);?>" id="comments" data-coment-content="<?php esc_attr(bloginfo('title'));?>">
    <?php
    // You can start editing here -- including this comment!

    if (have_comments()) : ?>
        <h3 class="comment-title">
            <div class="comment-title-content text-center">

                <div class="font-text">
                    <?php

                    $num_comments = get_comments_number();
                    $text_comments = '';
                    if ( comments_open() ) {
                        if ( $num_comments == 1 ){
                            $text_comments = $num_comments.esc_html__(' Comment', 'autlines');
                        }elseif ( $num_comments >= 2 ) {
                            $text_comments = $num_comments.esc_html__(' Comments', 'autlines');
                        }
                    } else {
                        $text_comments =  esc_html__('Comments are off for this post.', 'autlines');
                    }
                    echo esc_html($text_comments);
                    ?>
                </div>
            </div>

        </h3>

        <div class="cf"></div>
        <div class="comments-list">
            <?php
            wp_list_comments(array(
                'walker' => new autlines_walker_comment(),
                'short_ping' => true,
                'avatar_size' => 100
            ));
            ?>
         </div>
        <!-- .comment-list -->

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>

            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="sr-only"><?php esc_html_e('Comment navigation', 'autlines'); ?></h2>
                <?php
                $page = get_query_var('cpage');
                ?>
                <?php if (isset($page)): ?>
                    <div class="fl-comment-pagination cf">
                        <?php previous_comments_link('<i class="fa fa-angle-left"></i>'.esc_html__('Older Comments', 'autlines'));?>
                        <?php next_comments_link(esc_html__('Newer Comments', 'autlines').'<i class="fa fa-angle-right"></i>');?>
                    </div><!-- .nav-links -->
                <?php endif; ?>
            </nav><!-- #comment-nav-below -->
            <?php
        endif; // Check for comment navigation.

    endif; // Check for have_comments().


    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>

        <p class="no-comments"><?php esc_html_e('Comments are closed', 'autlines'); ?></p>
        <?php
    endif;
    $commenter = wp_get_current_commenter();
    ?> <div class="fl-form-comment-reply">
        <?php
        comment_form(array(
            'title_reply' => '<div class="reply-title">
                                    <div class="comment-title-content text-center">
                                       
                                        <div class="font-text">' . esc_html__('Add Comment', 'autlines') . '</div>
                                    </div>
                              </div>',
            'comment_notes_before' => '',

            'fields' => array('<div class="comment-field-wrapper">',
                'author' => '<div class="author-name"> 
                                <label class="fl-font-style-bolt-two">' . esc_html__('Your Name *', 'autlines') . '</label>
                                <input type="text" class="required" name="author" value="' . esc_attr($commenter['comment_author']) .'">
				             </div>',
                'email' => '<div class="author-email">
                                 <label class="fl-font-style-bolt-two">' . esc_html__('Email Address *', 'autlines') . '</label>
                                <input type="email" class="required" name="email" value="' . esc_attr($commenter['comment_author_email']) .'">
                            </div>',
                'url'    => '<div class="author-website">
                                 <label class="fl-font-style-bolt-two">' . esc_html__('Website', 'autlines') . '</label>
                                <input type="text" name="url" value="' . esc_attr($commenter['comment_author_url']) .'">
                            </div>',
                '</div>'),
            'class_submit'  => 'hidden button',
            'class_form'    => 'fl-comment-form',
            'comment_field' => '<div class="author-comment"> 
                                    <label class="fl-font-style-bolt-two">' . esc_html__('Enter your comment *', 'autlines') . '</label>          
                                    <textarea class="form-control required " name="comment" rows="5" aria-required="true"></textarea>
                                </div>',
            'comment_notes_after' => '<div class="submit-btn-container">
                                        <div class="fl-secondary-bg">
                                            <button type="submit" class="fl-font-style-bolt-two default-btn submit-comment">' . esc_html__('Post Comment', 'autlines') . '</button>
                                        </div>
                                      </div>'
        ));

        ?>
    </div>
</div><!-- #comments -->

