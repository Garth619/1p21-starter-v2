<?php
				
				if ( get_field('sidebar_menu') ){ //use same classes as widgets ?>
    
   
        
        	<span class="sidebar_title">
            
            <?php if(get_field('sidebar_menu_title')){
                
                the_field('sidebar_menu_title');
            
            }
            
            else {
                
                echo 'Practice Areas';
            
            } ?>
	        
        	</span>

					<?php
            
            wp_nav_menu(array(
                'menu' => get_field('sidebar_menu'),
                'container' => 'ul',
                'depth' => 2
            ));
        	
        	?>
    	
    
			
			<?php
			
			}
			
			else {
			
			if(have_rows('sidebars','option')){
        
        $no_sidebar_yet = true;

        while(have_rows('sidebars','option')): the_row();
            
            if(is_descendant_of(get_sub_field('page')) &&  $no_sidebar_yet){
                
                echo '<!-- ancestor default -->';
                
                dynamic_sidebar( ilaw_id_friendly_text( get_sub_field( 'sidebar_name' ) ) );
                
                $no_sidebar_yet = false;
                
                break;
            }
        
        endwhile;

        if($no_sidebar_yet){
            
            echo '<!-- no ancestral sidebar -->';
            
            dynamic_sidebar( 'default_sidebar' );
            // break;
        }

    }
    	
    	else{
        
        echo '<!--  default -->';
        
        dynamic_sidebar( 'default_sidebar' );
    	
    	}
	
	};?>