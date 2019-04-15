<?php
/**
 * Template Name: Exhibitions
 *
 */

get_header(); ?>

<?php get_sidebar(); ?>
			
			<?php while ( have_posts() ) : the_post(); ?>


				<?php get_template_part( 'content-page', 'single' ); ?>

				<?php thinkup_input_nav( 'nav-below' ); ?>

				<?php edit_post_link( __( 'Edit', 'lan-thinkupthemes' ), '<span class="edit-link">', '</span>' ); ?>

				<?php thinkup_input_allowcomments(); ?>

			<?php endwhile; ?>

			<?php 
			// wp_list_pages();

			echo "~~~~~<br>";
			$args = array(
				'parent' => 0
			);
			var_dump(get_pages($args));
			$id = get_all_page_ids();
			echo get_permalink($id[0]);
			// echo get_page_link($id[0]);
			// echo get_site_url($id[0]);
			?>
<?php get_footer(); ?>