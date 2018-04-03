<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Business_Theme
 * @since Business Theme 1.0
 */
$options = get_option( 'businesstheme_options' );
$category_id = 'category_' . get_queried_object_id();
$bg = get_field( 'banner_image', $category_id );
$blog_page_id = get_option( "page_for_posts" );
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>

<?php
if ( $options['ga'] ) : ?>
	<!-- Google Analytics -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', '<?php echo $options['ga']; ?>', 'auto');
		  ga('send', 'pageview');
		</script>
	<!-- End Google Analytics -->
<?php endif;

$description = get_bloginfo( 'description', 'display' );
echo '<script type="application/ld+json">
	{
		"@context": "http://schema.org/",
		"@type": "Organization",
		"name": "'.get_bloginfo( "name" ).'",
		"legalName": "'.get_bloginfo( "name" ).'",
		"url": "'.network_site_url( '/' ).'",
		"email": "",
		"telephone": "",
		"description": "'.$description.'"
	}
</script>';
if(is_single()) {
	$content = wp_strip_all_tags(apply_filters('the_content', $post->post_content)); 
	$excerpt = wp_strip_all_tags(apply_filters('the_excerpt', $post->post_excerpt)); 
	$image_url = esc_url( get_theme_mod( 'businesstheme_logo' ) );
	$author = $post->post_author; 
	echo '<script type="application/ld+json">
		{ "@context": "http://schema.org",
		"@type": "BlogPosting",
		"headline": "'.esc_html( get_the_title() ).'",
		"image": "'.get_the_post_thumbnail_url().'",
		"wordcount": "'.str_word_count($content,0).'",
		"publisher": {
		"@type": "Organization",
		"name": "'.get_bloginfo( "name" ).'",
		"logo": "'.$image_url.'"
		},
		"url": "'.get_permalink().'",
		"datePublished": "'.get_the_date('Y-m-d').'",
		"description": "'.$excerpt.'",
		"author": {
		"@type": "Person",
		"name": "'.get_the_author_meta( "user_nicename" , $author ).'"
		}
		}
	</script>';
}
?>

</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'businesstheme' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<?php if ( is_active_sidebar( 'top' ) ) {
				echo '<div class="top"><div class="site-inner">';
				dynamic_sidebar( 'top' );
				echo '</div></div>';
			} ?>
			<div class="container site-inner site-header-main<?php if (!empty($options['nav'])) { echo ' '.$options['nav']; } ?>">
				<div class="site-branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php $logo1 = get_theme_mod( 'businesstheme_logo' );
						$logo2 = get_theme_mod( 'businesstheme_footerlogo' );

					if ( $logo1 && $logo2 ) {?>
						<img src='<?php echo $logo1; ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' class="site-title first">
						<img src='<?php echo $logo2; ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' class="site-title second">
					<?php }
					elseif ($logo1) { ?>
						<img src='<?php echo $logo1; ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' class="site-title">
					<?php }
					else { ?>
						<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<?php } ?>
				</a>
				</div><!-- .site-branding -->

				<div class="nextwidget">
					<?php if ( is_active_sidebar( 'header' ) ) {
						dynamic_sidebar( 'header' );
					} ?>
					<button id="menu-toggle" class="menu-toggle"><?php _e( '<i class="fa fa-bars"></i>', 'businesstheme' ); ?></button>	
				</div>

				<div id="site-header-menu" class="site-header-menu">
					<?php if ( has_nav_menu( 'primary' ) ) : ?>
						<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'businesstheme' ); ?>">
							<?php
								wp_nav_menu( array(
									'theme_location' => 'primary',
									'menu_class'     => 'primary-menu',
								 ) );
							?>
						</nav><!-- .main-navigation -->
					<?php endif; ?>
				</div><!-- .site-header-menu -->
			</div><!-- .site-header-main -->
		</header>

		<?php if ( $bg && is_archive() ) { ?>
			<header class="page-header visual"<?php echo ' style="background-image:url('.$bg.');"';?>>
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<p>', '</p>' );
				?>
			</header><!-- .page-header -->
		<?php } ?>
		<?php if (is_home() ) {
			$img = wp_get_attachment_image_src(get_post_thumbnail_id($blog_page_id),'full'); 
			$featured_image = $img[0]; ?>
			
			<header class="page-header<?php if ($featured_image) {echo ' visual" style="background-image:url('.$featured_image.');'; }?>">
				<div class="site-inner">
				<?php
					echo '<h1>'.get_the_title( $blog_page_id ).'</h1>';
					if ( has_excerpt($blog_page_id) ){
						echo '<p>'.get_the_excerpt( $blog_page_id ).'</p>';	
					}
				?>
				</div>
		</header><!-- .page-header -->
		<?php } ?>

		<div id="content" class="site-content<?php if ( !is_page_template( 'parent-page.php' ) || is_home() || is_archive() || is_single() ) {echo ' site-inner';} ?>">