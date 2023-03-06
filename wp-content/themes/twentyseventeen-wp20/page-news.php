<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<h1 class="entry-title screen-reader-text">
			<?php the_title(); ?>
		</h1>
		
		<?php
		$posts = get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );
		
		$posts_by_month = array();
		foreach ( $posts as $post ) {
			$month = date( 'F', strtotime( $post->post_date ) );
			$month = substr( $month, 0, 3 );
			$posts_by_month[ $month ][] = $post;
		}

		foreach ( $posts_by_month as $month => $posts ) {
			echo '<section class="wp20-news-section"><div class="wrap wrap-unconstrained"><h2>' . $month . '</h2><ul>';
			foreach ( $posts as $post ) {
				echo '<li>';
				get_template_part( 'template-parts/post/content-excerpt', get_post_format() );
				echo '</li>';
			}
			echo '</ul></div></section>';
		}
		?>

	</main>
</div>

<?php get_footer();
