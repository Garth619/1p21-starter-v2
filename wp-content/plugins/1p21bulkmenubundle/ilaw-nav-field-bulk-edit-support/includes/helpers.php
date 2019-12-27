<?php
/********************************************************************************************
* helpers and shit
*********************************************************************************************/

function _ilaw_sm_create_admin_error($message,$notice_type = 'error'){
		
	$class = 'notice notice-'.$notice_type;
	$parsed_message = __( $message );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), strip_tags( $parsed_message,"<br><pre><code><br/><strong><b><i><em><p><strong>" ) ); 
}

 
function _ilaw_sm_slug_text($string) {

	$new_id = preg_replace("/[^a-zA-Z_]/","",str_replace(array(' ',), '_', $string)); // Replaces spaces in Sidebar Name to dash
	$new_id = strtolower( $new_id ); // Transforms edited Sidebar Name to lowercase
  
	return $new_id;

}



function _ilaw_sm_is_descendant_of($an_ancestor = null,$an_id = null){

	if(!$an_ancestor){
		// no use checking kung wala namang iproprovide na ninuno
		return false;
	}else{
		$ancestor = $an_ancestor;
		if(!is_array($ancestor)) {
		$ancestor = array($ancestor);
		}
	}
	if(!$an_id){
		global $post;
		$the_id = $post->ID;
	}else{
		$the_id = $an_id;
	}
	
	//list all the current page's kwan... ancestor
	$ancestors_to_match = get_post_ancestors($the_id);
	
	if(count(array_intersect($ancestors_to_match, $ancestor)) > 0 || is_page($ancestor)){
		return true;
	}else{
		return false;
	}
}


function _ilaw_sm_id_friendly_text($string) {

	$new_id = preg_replace("/[^a-zA-Z_]/","",str_replace(array(' ',), '_', $string)); // Replaces spaces in Sidebar Name to dash
	$new_id = strtolower( $new_id ); // Transforms edited Sidebar Name to lowercase

	return $new_id;
}

/********************************************************************************************
* open for the pooblic
*********************************************************************************************/
//duh
if(!function_exists('bulk_sidebar')){
	function bulk_sidebar(){
		if(class_exists('ACF')){
			require_once _ILAW_SM_PLUGIN_PATH . 'template/sidebar.php';
		}
	}
}

//defaults arent really registered in the database unless you like... flush the pages were the field groups at. fuck you acf. imma still use u tho <3
if(!function_exists('get_bulk_default')){
	function bulk_get_default($slug = ''){
		
		$defaults = $GLOBALS['_ilaw']['defaults'];

	if(isset($defaults[$slug]))
		return $defaults[$slug];
	}
}
