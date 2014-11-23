<?php
/*
Plugin Name: Filtered Catalogue Plugin
Plugin URI: http://github.com/gmattgreenfield/catalogue
Description: A plugin to allow the creation of a sortable, filterable catalougue page, without the need or bloat of ecommerce.
Version: 0.0.1
Author: Matt Greenfield
Author URI: mattgreenfield.co.uk
License:
*/

//
// CREATE PAGE IN BACKEND SETTINGS PANEL
//

// This function create an options page on the wordpress side menu with the listed parameters.
function filtered_catalogue(){
	add_options_page (
		'filtered Catalogue Plugin',
		'filtered Catalogue Settings',
		'manage_options',
		'filtered_catalogue',
		'filtered_catalogue_options_page'
	);
}

// Run the above function on the admin_menu hook
add_action( 'admin_menu', 'filtered_catalogue');

// Populate the settings page
function filtered_catalogue_options_page () {
	// Check the user has permissions
	if( !current_user_can( 'manage_options')) {
		wp_die( 'you do not have sufficient permission to access this catalogue settings page');
	}
	// Output content
	echo 'Welcome to the catalogue plugin page. One day this will be full of settings! Not for now.';
}





// CREATE BACKEND CUSTOM POST TYPE AND TAXONOMIES


// Create Custom post type - Products
function my_custom_post_product() {
  $labels = array(
	'name'               => _x( 'Products', 'post type general name' ),
	'singular_name'      => _x( 'Product', 'post type singular name' ),
	'add_new'            => _x( 'Add New', 'book' ),
	'add_new_item'       => __( 'Add New Product' ),
	'edit_item'          => __( 'Edit Product' ),
	'new_item'           => __( 'New Product' ),
	'all_items'          => __( 'All Products' ),
	'view_item'          => __( 'View Product' ),
	'search_items'       => __( 'Search Products' ),
	'not_found'          => __( 'No products found' ),
	'not_found_in_trash' => __( 'No products found in the Trash' ),
	'parent_item_colon'  => '',
	'menu_name'          => 'Products'
  );
  $args = array(
	'labels'        => $labels,
	'description'   => 'Holds our products and product specific data',
	'public'        => true,
	'menu_position' => 5,
	'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	'has_archive'   => true,
  );
  register_post_type( 'product', $args );
}
add_action( 'init', 'my_custom_post_product' );



// Create custom categories for 'product' post type
// Creating both 'Product Catergories' and 'Product Brand' here
function my_taxonomies_product() {
  $categorylabels = array(
	'name'              => _x( 'Product Categories', 'taxonomy general name' ),
	'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
	'search_items'      => __( 'Search Product Categories' ),
	'all_items'         => __( 'All Product Categories' ),
	'parent_item'       => __( 'Parent Product Category' ),
	'parent_item_colon' => __( 'Parent Product Category:' ),
	'edit_item'         => __( 'Edit Product Category' ),
	'update_item'       => __( 'Update Product Category' ),
	'add_new_item'      => __( 'Add New Product Category' ),
	'new_item_name'     => __( 'New Product Category' ),
	'menu_name'         => __( 'Product Categories' ),
  );
  $categoryargs = array(
	'labels' => $categorylabels,
  );

  $brandlabels = array(
	'name'              => _x( 'Product Brand', 'taxonomy general name' ),
	'singular_name'     => _x( 'Product Brand', 'taxonomy singular name' ),
	'search_items'      => __( 'Search Product Brand' ),
	'all_items'         => __( 'All Product Brand' ),
	'parent_item'       => __( 'Parent Product Brand' ),
	'parent_item_colon' => __( 'Parent Product Brand:' ),
	'edit_item'         => __( 'Edit Product Brand' ),
	'update_item'       => __( 'Update Product Brand' ),
	'add_new_item'      => __( 'Add New Product Brand' ),
	'new_item_name'     => __( 'New Product Brand' ),
	'menu_name'         => __( 'Product Brand' ),
  );
  $brandargs = array(
	'labels' => $brandlabels,
  );

  register_taxonomy( 'product_brand', 'product', $brandargs );
  register_taxonomy( 'product_category', 'product', $categoryargs );
}
add_action( 'init', 'my_taxonomies_product', 0 );


// Create an additional box on the edit post page for the item price
// Visual appearance of the box
add_action( 'add_meta_boxes', 'product_price_box' );
function product_price_box() {
	add_meta_box(
		'product_price_box',
		__( 'Product Price', 'myplugin_textdomain' ),
		'product_price_box_content',
		'product',
		'side',
		'high'
	);
}
// The content of the box
function product_price_box_content( $post ) {
  // Add an nonce field so we can check for it later.
  wp_nonce_field( plugin_basename( __FILE__ ), 'product_price_box_content_nonce' );

  // Use get_post_meta() to retrieve an existing value
  $value = get_post_meta( $post->ID, 'product_price', true );

  echo '<label for="product_price"></label>';
  echo '<input type="text" id="product_price" name="product_price" placeholder="enter a price" value="' . esc_attr( $value ) . '" size="25"/>';
}

// What happens to the data input to the box
add_action( 'save_post', 'product_price_box_save' );
function product_price_box_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
  return;

  if ( !wp_verify_nonce( $_POST['product_price_box_content_nonce'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
	if ( !current_user_can( 'edit_page', $post_id ) )
	return;
  } else {
	if ( !current_user_can( 'edit_post', $post_id ) )
	return;
  }
  $product_price = $_POST['product_price'];
  update_post_meta( $post_id, 'product_price', $product_price );
}






// CREATE SHORTCODE TO OUTPUT HTML WITH [catalogue] TAG
// the output is stored in frontend/filtered_catalogue_markup.php

// The content to output when the code is used.
function outputhtml_function() {
	$return_string = include 'frontend/filtered_catalogue_markup.php';
	return $return_string;
}

// Register the output to a shortcode
function register_shortcodes(){
   add_shortcode('catalogue', 'outputhtml_function');
}

// Add the shortcodes to the add_action hook
add_action( 'init', 'register_shortcodes');






//
// LOAD CSS AND JS
//

// Attach the CSS and JS files to the page where the plugin is being used.
function filtered_catalogue_includes () {
	wp_enqueue_style( 'filtered_catalogue_frontend_css', plugins_url( '/filtered_product_catalogue/frontend/css/filtered_catalogue_styles.min.css' ));
	wp_enqueue_script( 'filtered_catalogue_frontend_list_js', plugins_url( '/filtered_product_catalogue/frontend/js/list.min.js' ), array(), '', true );
	wp_enqueue_script( 'filtered_catalogue_frontend_js', plugins_url( '/filtered_product_catalogue/frontend/js/filtered_catalogue_js.js' ), array('jquery'), '', true );

}
add_action('wp_enqueue_scripts','filtered_catalogue_includes');




/* Display single posts with the plugins custom html */

function change_post_type_template($single_template) {
	global $post;

	if ($post->post_type == 'product') {
		$single_template = plugin_dir_path( __FILE__ ) . 'frontend/filtered-catalogue-product-template.php';
	}

	return $single_template;
}

add_filter( 'single_template', 'change_post_type_template' );

 ?>
