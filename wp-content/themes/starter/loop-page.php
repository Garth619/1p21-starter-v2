<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php the_content();?>
	
	<?php edit_post_link( __( 'Edit'), '', '' ); ?>

<?php endwhile; // end of loop ?>

<?php endif; ?>