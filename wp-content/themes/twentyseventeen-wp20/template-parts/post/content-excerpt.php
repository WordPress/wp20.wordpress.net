<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
			the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
		?>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php echo twentyseventeen_time_link(); ?>
			</div><!-- .entry-meta -->
		<?php elseif ( 'page' === get_post_type() && get_edit_post_link() ) : ?>
			<div class="entry-meta">
				<?php twentyseventeen_edit_link(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

	</header><!-- .entry-header -->

</article><!-- #post-<?php the_ID(); ?> -->
