<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<h2><?php the_title();?></h2>
	
	<?php $pfx_date = get_the_date(); echo $pfx_date ?>
			
	<?php echo get_the_category_list();?>
	
	<?php the_content();?>
	
	<?php edit_post_link( __( 'Edit'), '', '' ); ?>

<?php endwhile; // end of loop ?>

<?php endif; ?>