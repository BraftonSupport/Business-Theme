<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Business_Theme
 * @since businesstheme 1.0
 */
$related_posts = get_field('related_posts', 'option');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php businesstheme_post_thumbnail('full'); ?>
	<?php if ( !is_singular( 'attachment' ) ) { ?><header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php } ?>

	<footer class="entry-footer">
		<?php businesstheme_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'businesstheme' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'businesstheme' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'businesstheme' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
		?>
	</div><!-- .entry-content -->

<?php if ( $related_posts ) :
	echo '<div class="latest">';
?>
	<h3>Related Posts</h3>
	<div class="post">

		<?php $categories = get_the_category();
		if ($categories) {
			$cat = $categories[0]->cat_ID;
			$args=array( 'cat' => $cat, 'post__not_in' => array($post->ID), 'posts_per_page'=>3 );
				$my_query = null;
				$my_query = new WP_Query($args);
				if( $my_query->have_posts() ) {
				while ($my_query->have_posts()) : $my_query->the_post();
				$url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
				echo '<a href="' . get_the_permalink() . '" title="'.get_the_title().'">';
					if ( get_post_thumbnail_id( get_the_ID() ) ) {
						echo '<div class="thumb"><img src="'.$url[0].'" alt="'.get_the_title().'"></div>';
					}
					echo '<h5>'.get_the_title().'<br/><span class="tiny">'.get_the_date('M j, Y').'</span></h5>';
				echo '</a>';
				endwhile;
			}
		} ?>
	</div>
</div>
<?php endif; ?>

</article><!-- #post-## -->