<?php

    //TODO:send API pages to endpoint
//add child pages to API endpoint
//https://developer.wordpress.org/reference/functions/register_rest_field/
add_action( 'rest_api_init', 'child_pages_api_posts_meta_field' );

function child_pages_api_posts_meta_field() {
    // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() );
    register_rest_field( 'page', 'related_pages', array(
           'get_callback'    => 'get_child_and_sibling_pages',
           'schema'          => null,
        )
    );
}

function get_child_and_sibling_pages( $object ) {
    //get the id of the post object array
    $post_id = $object['id'];
    $post_parent = wp_get_post_parent_id( $object['id'] );
	//return the post meta
    $path_custom = get_post_meta( $post_id, 'path_custom', true );
    
    $child_args = array(
        'post_parent' => $post_id,
        'post_type'   => 'page', 
        'numberposts' => -1,
        'post_status' => 'publish' 
    );
    $child_pages = get_children( $child_args );

    $sibling_args = array(
        'post_parent' => $post_parent,
        'post_type'   => 'page', 
        'numberposts' => -1,
        'post_status' => 'publish' 
    );
    $sibling_pages = get_children( $sibling_args );
	
	$child_and_sibling_pages = array(
		'child_pages' => $child_pages,
		'sibling_pages' => $sibling_pages
	);
	// var_dump($path_post_meta);
    return $child_and_sibling_pages;
}



?>