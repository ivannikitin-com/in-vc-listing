<?php
/**
 * Шаблон списка клиник
 */

get_header();
?>
<section id="in-vc-listing-archive" class="content-area">
	<main id="in-vc-listing-main" class="site-main">
	<?php
	do_action('in_vc_listing_archive_before_main');
	
	if ( have_posts() ) 
	{
		// Load posts loop.
		while ( have_posts() ) 
		{
			the_post();	
			do_action('in_vc_listing_archive_before_entry', get_the_ID()); ?>
			<header class="entry-header">
				<h2><?php the_title() ?></h2>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php if ( apply_filters('in_vc_listing_archive_show_thumbnail', get_the_ID(), true ) )
						echo get_the_post_thumbnail( get_the_ID(), 
							apply_filters('in_vc_listing_archive_thumbnail_size', get_the_ID(), 'thumbnail')); ?>
				<?php the_excerpt(); ?>
				<?php do_action('in_vc_listing_archive_after_content', get_the_ID()); ?>
			</div><!-- .entry-content -->
<?php		do_action('in_vc_listing_archive_after_entry', get_the_ID());
		}
	} else {  ?>
	<div class="entry-content">
		<?php esc_html_e( 'Клиник не найдено', 'in-vc-listing' ) ?>
	</div><!-- .entry-content -->

<?php	}
	do_action('in_vc_listing_archive_after_main');
	?>
	</main><!-- .site-main -->
</section><!-- .content-area -->
<?php
get_footer();
