<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to mixfolio_comment() which is
 * located in the functions.php file.
 *
 * @package Mixfolio
 * @since Mixfolio 1.1
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
				printf( _n( '&ldquo;%2$s&rdquo;', '%1$s&ldquo;%2$s&rdquo;', get_comments_number(), 'mixfolio' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'mixfolio' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Commentaires précédents', 'mixfolio' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Commentaires suivants &rarr;', 'mixfolio' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use mixfolio_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define mixfolio_comment() and that will be used instead.
				 * See mixfolio_comment() in functions.php for more.
				 */
				wp_list_comments( array( 'callback' => 'mixfolio_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Voir tout les commentaires', 'mixfolio' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Commentaires précédents', 'mixfolio' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Commentaires suivants &rarr;', 'mixfolio' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Les commentaires sont fermé', 'mixfolio' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments .comments-area -->