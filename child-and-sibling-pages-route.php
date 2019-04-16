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
    
    $child_args = array(
        'post_parent' => $post_id,
        'post_type'   => 'page', 
        'numberposts' => -1,
        'post_status' => 'publish' 
    );
    $child_pages = get_children( $child_args );

    $child_page_data = array();
    $child_idx=0;
    foreach( $child_pages as $posts) {
        $post_id = $posts->ID;
        $post_title = $posts->post_title;
        $slug = $posts->post_name;

        $post_item = array(
            'ID' => $post_id,
            'title' => $post_title,
            'slug' => $slug
        );
        $child_page_data[$child_idx] = $post_item;

        $child_idx++;
    }

    $sibling_args = array(
        'post_parent' => $post_parent,
        'post_type'   => 'page', 
        'numberposts' => -1,
        'post_status' => 'publish' 
    );
    $sibling_pages = $post_parent != 0 ? get_children( $sibling_args ) : array();
    
    $sibling_page_data = array();
    $sibling_idx=0;
    foreach( $sibling_pages as $posts) {
        $post_id = $posts->ID;
        $post_title = $posts->post_title;
        $slug = $posts->post_name;

        $post_item = array(
            'ID' => $post_id,
            'title' => $post_title,
            'slug' => $slug
        );
        $sibling_page_data[$sibling_idx] = $post_item;

        $sibling_idx++;
    }

	$child_and_sibling_pages = array(
		'child_pages' => $child_page_data,
		'sibling_pages' => $sibling_page_data
    );
    
    return $child_and_sibling_pages;
}



?>