<?php
/**
 * Шаблон одной клиники
 */

get_header();
?>
<section id="in-vc-listing-clinic" class="content-area">
	<main id="in-vc-listing-main" class="site-main">
	<?php
	do_action('in_vc_listing_clinic_before_main');
	
	if ( have_posts() ) 
	{
		// Load posts loop.
		while ( have_posts() ) 
		{
			the_post();	?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<?php do_action('in_vc_listing_archive_before_entry', get_the_ID()); ?>
			<header class="entry-header">
				<h2><?php the_title() ?></h2>
			</header><!-- .entry-header -->
			
			<?php do_action('in_vc_listing_clinic_before_content', get_the_ID()); ?>
			<div class="entry-content">
				<?php if ( apply_filters('in_vc_listing_clinic_show_thumbnail', get_the_ID(), true ) ) 
					echo get_the_post_thumbnail( get_the_ID(), 
						apply_filters('in_vc_listing_clinic_thumbnail_size', get_the_ID(), 'large') ); ?>
				<?php the_content(); ?>
			</div><!-- .entry-content -->
			<?php do_action('in_vc_listing_clinic_after_content', get_the_ID());
			
			do_action('in_vc_listing_clinic_after_entry', get_the_ID());
		}
	} else {  ?>
	<div class="entry-content">
		<?php esc_html_e( 'Клиники не найдено', 'in-vc-listing' ) ?>
	</div><!-- .entry-content -->

<?php	}
	do_action('in_vc_listing_clinic_after_main');
	?>
			</article><!-- #post-<?php the_ID(); ?> -->
	</main><!-- .site-main -->
</section><!-- .content-area -->
<?php
get_footer();
