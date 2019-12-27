<?php
/********************************************************************************************
* register sidebar
*********************************************************************************************/
function _ilaw_sm_register_sidebars(){
	if(function_exists('register_sidebars')){


		if(class_exists('ACF')){
			$_ilaw_sm_widget_class = get_field('sm_widget_class','option');
			$_ilaw_sm_title_class = get_field('sm_title_class','option');
			$_ilaw_sm_title_tag = (get_field('sm_title_tag','option')) ? get_field('sm_title_tag','option') : bulk_get_default('title_tag');

			register_sidebar(array(
				'name'          => 'Blog Sidebar (iLawyer Sidebar)',
				'id'            => '_ilaw_sm_blog_sidebar',
				'description'   => 'From the bulk edit bundle plugin',
				'before_widget' => '<div id="%1$s" class="widget %2$s '.$_ilaw_sm_widget_class.'">',
				'after_widget'  => '</div>',
				'before_title'  => '<'.$_ilaw_sm_title_tag.' class="widget-title '.$_ilaw_sm_title_class.'">',
				'after_title'   => '</'.$_ilaw_sm_title_tag.'>'
			));
		
			register_sidebar(array(
				'name'          => 'Default Sidebar (iLawyer Sidebar)',
				'id'            => '_ilaw_sm_default_sidebar',
				'description'   => 'From the bulk edit bundle plugin',
				'before_widget' => '<div id="%1$s" class="widget %2$s '.$_ilaw_sm_widget_class.'">',
				'after_widget'  => '</div>',
				'before_title'  => '<'.$_ilaw_sm_title_tag.' class="widget-title '.$_ilaw_sm_title_class.'">',
				'after_title'   => '</'.$_ilaw_sm_title_tag.'>'
			));

			$ilaw_set_sidebars = get_field('sm_sidebars','option');

			//so u dont have to edit the functions anymore everytime a new unique sidebar area is set up :') 
		
			if( $ilaw_set_sidebars ){

				//Loop through sidebar fields to generate custom sidebars
				foreach ( $ilaw_set_sidebars as $row ){ 
					the_row();
					$s_name = $row[ 'name' ]; //validated to be unique 
					$s_id = _ilaw_sm_slug_text($s_name);
					
					if($s_id !== '_ilaw_sm_default_sidebar' && $s_id !== '_ilaw_sm_blog_sidebar') {
						register_sidebar( array(
							'name' => $s_name. ' (iLawyer Sidebar)',
							'id' => $s_id,
							'description'   => 'Added through iLawyer Global > Subdirectory Sidebars',
							'before_widget' => '<div id="%1$s" class="widget %2$s '.$_ilaw_sm_widget_class.'">',
							'after_widget'  => '</div>',
							'before_title'  => '<'.$_ilaw_sm_title_tag.' class="widget-title '.$_ilaw_sm_title_class.'">',
							'after_title'   => '</'.$_ilaw_sm_title_tag.'>'
						));
					}else{
						echo 'sidebar '.$s_id.' already built in by iLawyer. please remove setup';
					}
				};
				
			};
		}
	}
}
add_action( 'widgets_init', '_ilaw_sm_register_sidebars' );

	

add_filter(
	'widget_nav_menu_args',
	function( $nav_menu_args, $nav_menu, $args, $instance ){

		
		$ilaw_valid_sidebar_ids = array();
		$ilaw_set_sidebars = get_field('sm_sidebars','option');
		$_ilaw_sm_menu_depth = (get_field('sm_depth','option') )? get_field('sm_depth','option') : bulk_get_default('menu_depth');

		if( $ilaw_set_sidebars ){

			foreach($ilaw_set_sidebars as $row){
				array_push(
					$ilaw_valid_sidebar_ids,
					_ilaw_sm_slug_text( $row['name'] )
				);
			}
		}
		
		if(
			in_array($args['id'],$ilaw_valid_sidebar_ids)
			|| $args['id'] == '_ilaw_sm_default_sidebar'
			|| $args['id'] == '_ilaw_sm_blog_sidebar'
		){
			$nav_menu_args['depth'] = $_ilaw_sm_menu_depth;
			$nav_menu_args['container'] = 'ul';
		}
		return $nav_menu_args;
	},
10,4);
