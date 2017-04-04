<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pusher
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card">
		<div class="card-image">
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			} else { ?>
			<img src="<?php bloginfo( 'template_directory' ); ?>/img/default.png" alt="<?php the_title(); ?>" />
			<?php } ?>
			<span class="card-title">
				<header class="entry-header">
				<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
				</header>
				<?php if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						<?php pusher_posted_on(); ?>
					</div>
				<?php endif; ?>
			</span>
		</div>
		<div class="card-content">
		<div class="entry-content">
		<?php
		if ( is_single() ) {
			the_excerpt( sprintf( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'immaterial'), the_title( 'span class="screen-reader-text">"', '"</span>', false ) ) );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php pusher_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'pusher' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pusher' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php pusher_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
