<?php 



/* Enqueued Scripts
-------------------------------------------------------------- */



 
function load_my_styles_scripts() {
  
    
    wp_enqueue_style( 'styles', get_template_directory_uri() . '/style.css', '', 5, 'all' ); 
    

    // disables jquery then registers it again to go into footer
    
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    wp_enqueue_script( 'jquery' );

		// custom js to fall uner jquery in footer
		    
    wp_register_script( 'jquery-addon', get_template_directory_uri() . '/js/custom-min.js','', 1);

		
		// Localized PHP Data that needs to be passed onto my custom-min.js file, this grabs the live chat script acf and applies to my lazyload "getScript" function

			
		$livechat = get_field('live_chat_script','option');
		
		
		
			// Localize the script with new data array 
		
			$translation_array = array(
    		'live_chat' => $livechat
			);

			wp_localize_script( 'jquery-addon', 'my_data', $translation_array );
		
		
		
		// carry on to enqueue script like normal, but now it contains my needed js variable with php data tied to it from above
		

		// Enqueue Script
		    
    wp_enqueue_script( 'jquery-addon', get_template_directory_uri() . '/js/custom-min.js', 'jquery', '', true );
    
    // wp_enqueue_script( 'jquery-mygravity', get_template_directory_uri() . '/js/gravityforms-min.js', 'jquery', '', true );
    

 }
 
 add_action( 'wp_enqueue_scripts', 'load_my_styles_scripts', 20 );
 
 
 
 /* Defer JS for Lighthouse
-------------------------------------------------------------- */
 
 
/*
 function add_defer_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_defer = array('jquery', 'jquery-addon', 'jquery-mygravity');
   
   foreach($scripts_to_defer as $defer_script) {
      if ($defer_script === $handle) {
         return str_replace(' src', ' defer="defer" src', $tag);
      }
   }
   return $tag;
}


add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
*/



/* dequeue embed for lighthouse
-------------------------------------------------------------- */


/*
 function my_deregister_scripts(){
  
  wp_deregister_script( 'wp-embed' );

	}

	add_action( 'wp_footer', 'my_deregister_scripts' );
*/



/* dequeue gravity form files that effect critical chain page speed and defer them later in a combined file
-------------------------------------------------------------- */
	
	
/*
	function deregister_scripts(){
			
  wp_deregister_script("gform_placeholder");
  wp_deregister_script("gform_masked_input");
  wp_deregister_script("gform_json");
  wp_deregister_script("gform_gravityforms");
  
 }
	
	
add_action("gform_enqueue_scripts", "deregister_scripts");
*/



/* CSS in Header for Lighthouse
-------------------------------------------------------------- */
 
 
/*
function internal_css_print() {
   echo '<style>';
   
   include_once get_template_directory() . '/style.css';
  
   echo '</style>';
}


add_action( 'wp_head', 'internal_css_print' );
*/

 
 
/* Force Gravity Forms to init scripts in the footer and ensure that the DOM is loaded before scripts are executed
-------------------------------------------------------------- */


add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open', 1 );
function wrap_gform_cdata_open( $content = '' ) {
if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
return $content;
}
$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close', 99 );
function wrap_gform_cdata_close( $content = '' ) {
if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
return $content;
}
$content = ' }, false );';
return $content;
}



/* No Tab Conflicts Gravity Forms
 --------------------------------------------------------------------------------------- */

add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
function gform_tabindexer( $tab_index, $form = false ) {
  $starting_index = 1000; // if you need a higher tabindex, update this number
  if( $form )
    add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
  return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}





/* Remove Unnecessary Scripts
-------------------------------------------------------------- */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

/* Register Nav-Menus
-------------------------------------------------------------- */

register_nav_menus(array(
    'main_menu' => 'Main Menu',
    'pa_menu' => 'PA Sidebar Menu',
));

/* Widgets
-------------------------------------------------------------- */

if (function_exists('register_sidebars')) {


    register_sidebar(array(
        'name' => 'Recent Posts',
        'id' => 'recent_posts',
        'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));

    
    register_sidebar(array(
        'name' => 'Category',
        'id' => 'category_sidebar',
        'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'name' => 'Archive',
        'id' => 'archive_sidebar',
        'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'name' => 'Default Sidebar',
        'id' => 'default_sidebar',
        'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));

 }

/* Add Theme Support Page Thumbnails
-------------------------------------------------------------- */

add_theme_support('post-thumbnails');

/* Modify the_excerpt() " read more "
-------------------------------------------------------------- */

function new_excerpt_more($more)
{
    global $post;
    return '... <a href="' . get_permalink($post->ID) . '">' . 'read more' . '</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');

/* Add Page Slug to Body Class
-------------------------------------------------------------- */
function add_slug_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

add_filter('body_class', 'add_slug_body_class');



/* ACF: CREATE OPTIONS PAGE
-------------------------------------------------------------- */

if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title' 	=> 'Theme Options',
    'menu_title'	=> 'Theme Options',
    'menu_slug' 	=> 'theme-options',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));

}



/* ALLOW SVGs IN MEDIA UPLOAD
-------------------------------------------------------------- */
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');


/* ALLOW WEBPs IN MEDIA UPLOAD
-------------------------------------------------------------- */


function webp_upload_mimes( $existing_mimes ) {
	// add webp to the list of mime types
	$existing_mimes['webp'] = 'image/webp';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );


/* Blog Pagination
-------------------------------------------------------------- */

function wpbeginner_numeric_posts_nav() {
 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<div class="paged_wrapper"><div class="navigation"><ul>' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="myprev">%s</li>' . "\n", get_previous_posts_link('prev') );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="mynext">%s</li>' . "\n", get_next_posts_link('next') );
 
    echo '</ul></div></div>' . "\n";
 
}




// subfolder sidebar

// add hook
add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );
// filter_hook function to react on sub_menu flag
function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
  if ( isset( $args->sub_menu ) ) {
    $root_id = 0;
    
    // find the current menu item
    foreach ( $sorted_menu_items as $menu_item ) {
      if ( $menu_item->current ) {
        // set the root id based on whether the current menu item has a parent or not
        $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
        break;
      }
    }
    
    // find the top level parent
    if ( ! isset( $args->direct_parent ) ) {
      $prev_root_id = $root_id;
      while ( $prev_root_id != 0 ) {
        foreach ( $sorted_menu_items as $menu_item ) {
          if ( $menu_item->ID == $prev_root_id ) {
            $prev_root_id = $menu_item->menu_item_parent;
            // don't set the root_id to 0 if we've reached the top of the menu
            if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
            break;
          } 
        }
      }
    }
    $menu_item_parents = array();
    foreach ( $sorted_menu_items as $key => $item ) {
      // init menu_item_parents
      if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;
      if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
        // part of sub-tree: keep!
        $menu_item_parents[] = $item->ID;
      } else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
        // not part of sub-tree: away with it!
        unset( $sorted_menu_items[$key] );
      }
    }
    
    return $sorted_menu_items;
  } else {
    return $sorted_menu_items;
  }
}



// subfolder sidebars


if(!function_exists('is_descendant_of')){
  function is_descendant_of($an_ancestor = null,$an_id = null){

    if(!$an_ancestor){
     
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
  
    
    $ancestors_to_match = get_post_ancestors($the_id);
    
    if(count(array_intersect($ancestors_to_match, $ancestor)) > 0 || is_page($ancestor)){
      return true;
    }else{
      return false;
    }
  }
}


// register sidebars from theme options subdirectory setup
  //so u dont have to edit the functions anymore everytime a new unique sidebar area is set up :') 
  if (is_plugin_active('advanced-custom-fields-pro/acf.php')){ //Check to see if ACF is installed
    if (have_rows('sidebars','option')){
      while (have_rows('sidebars','option')){ //Loop through sidebar fields to generate custom sidebars
        the_row();
        $s_name = get_sub_field( 'sidebar_name', 'option' ); //validated to be unique by  validate_sidebar_name()
        $s_id = ilaw_id_friendly_text($s_name);

        register_sidebar( array(
          'name' => $s_name,
          'id' => $s_id,
          'description'   => 'Added through Theme Options > Sidebars',
          'before_widget' => '<div id="%1$s" class="widget %2$s">',
          'after_widget'  => '</div>',
          'before_title'  => '<h3 class="widget-title">',
          'after_title'   => '</h3>'
        ) );
      };
    };
  };





add_filter('acf/validate_value/key=field_5c36777f31fd1', 'ilaw_validate_sidebar_name', 20, 4); // this may be different each time after import check screen option key value
function ilaw_validate_sidebar_name( $valid, $value, $field, $input ) {
  // bail early if value is already invalid
  if( !$valid ) {
      
    return $valid;
    
  }

  //https://support.advancedcustomfields.com/forums/topic/avoid-duplicate-content-on-repeater-field/
  // get list of array indexes from $input
  // [ <= this fixes my IDE, it has problems with unmatched brackets
  preg_match_all('/\[([^\]]+)\]/', $input, $matches);
  if (!count($matches[1])) {
    // this should actually never happen
    return $valid;
  }
  $matches = $matches[1];
  
  // walk the acf input to find the repeater and current row      
  $array = $_POST['acf'];
  
  $repeater_key = false;
  $repeater_value = false;
  $row_key = false;
  $row_value = false;
  $field_key = false;
  $field_value = false;
  
  for ($i=0; $i<count($matches); $i++) {
    if (isset($array[$matches[$i]])) {
      $repeater_key = $row_key;
      $repeater_value = $row_value;
      $row_key = $field_key;
      $row_value = $field_value;
      $field_key = $matches[$i];
      $field_value = $array[$matches[$i]];
      if ($field_key == $field['key']) {
        break;
      }
      $array = $array[$matches[$i]];
    }
  }
  
  if (!$repeater_key) {
    // this should not happen, but better safe than sorry
    return $valid;
  }
  
  // look for duplicate values in the repeater
  foreach ($repeater_value as $index => $row) {
    if ($index != $row_key && $row[$field_key] == $value) {
      // this is a different row with the same value
      $valid = 'this value is not unique';
      break;
    }
  }
	
	// return
	return $valid;
}



function ilaw_id_friendly_text($string) {

  $new_id = preg_replace("/[^a-zA-Z_]/","",str_replace(array(' ',), '_', $string)); // Replaces spaces in Sidebar Name to dash
  $new_id = strtolower( $new_id ); // Transforms edited Sidebar Name to lowercase

  return $new_id;
}



