<?php get_header(); ?>


		
		<h1><?php
					printf( __( '%s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1>
		
		
				
		<?php get_template_part( 'loop', 'index' );?>
				
		

<?php get_footer(); ?>




				
				
			
		
