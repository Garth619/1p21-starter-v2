<?php
/*
Bulk sidebar content template.

If the sidebar needs to be customized, copy this template and set a new template in your theme and paste and modify the code there
*/
//check for page's own custom sidebar first
if ( get_field('sm_custom_menu') ){ ?>

	<?php
		//get options settings
		$widget_class = get_field('sm_widget_class','option');
		$title_class = get_field('sm_title_class','option');
		$title_tag = (get_field('sm_title_tag','option')) ? get_field('sm_title_tag','option') : bulk_get_default('title_tag');
		$menu_depth = (get_field('sm_depth','option') ) ? get_field('sm_depth','option') : bulk_get_default('menu_depth');
		$default_title = ( get_field('sm_default_title','option') ) ?  get_field('sm_default_title','option') : bulk_get_default('default_title');
	?>

		<!-- custom sidebar -->
		<div class="widget acf-custom-menu <?=$widget_class; ?>">
			
			<<?=$title_tag; ?> class="widget-title <?=$title_class; ?>">
				
				<?php if(get_field('sm_custom_title')){
					the_field('sm_custom_title');
				}else{ //ACF doesnt somehow get the default set value for the acf value when the options page is not flushed like permalinks. output a basic ass bitch title
					echo $default_title;
				} ?>
			
			</<?=$title_tag; ?>>

			<?php
				wp_nav_menu(array(
					'menu' => get_field('sm_custom_menu'),
					'container' => 'ul',
					'depth' => $menu_depth
				));
			?>
		</div>
	<?php

//then check for blog and posts
}else if( is_home() || is_single() || (is_archive() && !is_post_type_archive()) ) { 

	if( is_active_sidebar( '_ilaw_sm_blog_sidebar' ) ){
		echo '<!-- blog sidebar -->';
		dynamic_sidebar( '_ilaw_sm_blog_sidebar' );
	}

//check for subdirectory or ancestral sidebars
}else  if( get_field('sm_sidebars','option') ){

	$available_sidebars = get_field('sm_sidebars','option');

	//to check if there was a sidebar for the page from an ancestor
	$no_sidebar_yet = true;

	foreach( $available_sidebars as $row ):

		$template_sidebar_id = _ilaw_sm_id_friendly_text($row['name']);

		if($row['pages']): 

			foreach($row['pages'] as $sub_row):
				the_row();

				if( $sub_row['page'] && _ilaw_sm_is_descendant_of($sub_row['page']) &&  $no_sidebar_yet ){

					echo '<!-- ancestor default: '.$template_sidebar_id.' -->';
					dynamic_sidebar( $template_sidebar_id );
					$no_sidebar_yet = false;

					break;
				}
			endforeach;

		endif;

	endforeach;
	

	
	// if it didnt get any ancestral sidebars just put the default boi
	if($no_sidebar_yet){

		if( is_active_sidebar( '_ilaw_sm_default_sidebar' ) ){
			echo '<!-- no ancestral default sidebar -->';
			dynamic_sidebar( '_ilaw_sm_default_sidebar' );
		}

	}

}else{
	
	if( is_active_sidebar( '_ilaw_sm_default_sidebar' ) ){
		echo '<!--  default sidebar -->';
		dynamic_sidebar( '_ilaw_sm_default_sidebar' );
	}
}
