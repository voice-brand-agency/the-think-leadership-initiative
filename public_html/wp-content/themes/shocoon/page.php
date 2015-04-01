<?php get_header(); ?>

<div class="met_content page_content">
	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'page' ); ?>


	<?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>
