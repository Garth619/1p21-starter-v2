<?php if(get_field('subfolder_sidebar') == 'Yes') :?>
		
			<?php wp_nav_menu( array('menu'=> 'PA Sidebar Menu','sub_menu' => true, 'direct_parent' => true, 'show_parent' => true));?>
		
		<?php else:?>
		
			<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'pa_menu' ) ); ?>
		
		<?php endif;?>
