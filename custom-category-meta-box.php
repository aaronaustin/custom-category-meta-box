<?php
/*Plugin Name: Add Custom Category Meta Box to Posts
Description: This plugin adds a custom meta box in place of the standard category meta box for posts.
Version: 1.3.0
License: GPLv2
GitHub Plugin URI: https://github.com/aaronaustin/custom-category-meta-box
*/

//add custom category metabox
add_action( 'load-post.php' , 'custom_load_post' );
add_action( 'load-post-new.php' , 'custom_load_post' );
function custom_load_post() {
    remove_meta_box( 'categorydiv' , 'post' , 'side' );
	add_meta_box( 'custom_category_div' , __( 'Category' ) , 'custom_category_metabox' , 'post' , 'normal', 'high', array( 'taxonomy' => 'category' ) );
	
	remove_meta_box( 'slidediv' , 'post' , 'side' );
    add_meta_box( 'slide_category_div' , __( 'Slide Type' ) , 'slide_category_metabox' , 'post' , 'normal', 'high', array( 'taxonomy' => 'category' ) );
	
	remove_meta_box( 'mediadiv' , 'post' , 'side' );
    add_meta_box( 'media_category_div' , __( 'Media Type' ) , 'media_category_metabox' , 'post' , 'normal', 'high', array( 'taxonomy' => 'category' ) );
	
}
function custom_category_metabox( $post ) {
    ?>
        <div id="custom-category" class="custom-taxonomy categorydiv">
            <div id="custom-category-all">
                <input type="hidden" name="post_category[]" value="0" />
                <?php $args = array( 'type' => $post->post_type , 'hide_empty' => false , 'parent' => 0 ); ?>
                <?php $categories = get_categories( $args ); ?>
                <?php if( !empty( $categories ) ) : ?>
                    <ul id="custom-category-checklist" data-wp-lists="list:category" class="categorychecklist form-no-clear">
                        <?php $selected_cats = wp_get_post_categories( $post->ID , array( 'fields' => 'ids' ) ); ?>
                        <?php foreach( $categories as $category ) : ?>
                            <li id="category-<?php echo $category->term_id; ?>">
                                <label class="selectit">
                                    <input value="<?php echo $category->term_id; ?>" type="radio" name="post_category[]" data-catslug="<?php echo $category->slug; ?>" id="in-category-<?php echo $category->term_id; ?>" <?php checked( in_array( $category->term_id , $selected_cats ) , true ); ?> />
                                    <?php echo  esc_html( apply_filters( 'the_category' , $category->name ) ); ?>
                                </label>
                                <?php $child_args = array( 'type' => $post->post_type , 'hide_empty' => false , 'parent' => $category->term_id ); ?>
                                <?php $child_categories = get_categories( $child_args ); ?>
                                <?php if( !empty( $child_categories ) ) : ?>
                                    <ul class="children">
                                        <?php foreach( $child_categories as $child_category ) : ?>
                                            <li id="category-<?php echo $child_category->term_id; ?>">
                                                <label class="selectit">
                                                    <input value="<?php echo $child_category->term_id; ?>" type="radio" name="post_category[]" id="in-category-<?php echo $child_category->term_id; ?>" <?php checked( in_array( $child_category->term_id , $selected_cats ) , true ); ?> />
                                                    <?php echo  esc_html( apply_filters( 'the_category' , $child_category->name ) ); ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php   
}

function media_category_metabox( $post ) {
    ?>
        <div id="media-category" class="custom-taxonomy mediadiv">
            <div id="media-category-all">
                <input type="hidden" name="tax_input[media][]" value="0" />
                <?php $args = array('taxonomy' => 'media', 'type' => $post->post_type , 'hide_empty' => false , 'parent' => 0 ); ?>
                <?php $media_categories = get_terms( $args ); ?>
                <?php if( !empty( $media_categories ) ) : ?>
                    <ul id="mediachecklist" data-wp-lists="list:media" class="categorychecklist form-no-clear">
                        <?php $selected_cats = wp_get_post_terms( $post->ID , 'media', array( 'fields' => 'ids' ) ); ?>
                        <?php foreach( $media_categories as $category ) : ?>
                            <li id="media-<?php echo $category->term_id; ?>">
                                <label class="selectit">
                                    <input value="<?php echo $category->term_id; ?>" type="radio" name="tax_input[media][]" id="in-category-<?php echo $category->term_id; ?>" <?php checked( in_array( $category->term_id , $selected_cats ) , true ); ?> />
                                    <?php echo  esc_html( apply_filters( 'the_category' , $category->name ) ); ?>
                                </label>
                                <?php $child_args = array( 'type' => $post->post_type , 'hide_empty' => false , 'parent' => $category->term_id ); ?>
                                <?php $child_categories = get_categories( $child_args ); ?>
                                <?php if( !empty( $child_categories ) ) : ?>
                                    <ul class="children">
                                        <?php foreach( $child_categories as $child_category ) : ?>
                                            <li id="media-<?php echo $child_category->term_id; ?>">
                                                <label class="selectit">
                                                    <input value="<?php echo $child_category->term_id; ?>" type="radio" name="tax_input[media][]" id="in-category-<?php echo $child_category->term_id; ?>" <?php checked( in_array( $child_category->term_id , $selected_cats ) , true ); ?> />
                                                    <?php echo  esc_html( apply_filters( 'the_category' , $child_category->name ) ); ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php   
}


function slide_category_metabox( $post ) {
    ?>
        <div id="slide-category" class="custom-taxonomy slidediv">
            <div id="slide-category-all">
                <input type="hidden" name="tax_input[slide][]" value="0" />
                <?php $args = array('taxonomy' => 'slide', 'type' => $post->post_type , 'hide_empty' => false , 'parent' => 0 ); ?>
                <?php $slide_categories = get_terms( $args ); ?>
                <?php if( !empty( $slide_categories ) ) : ?>
                    <ul id="slidechecklist" data-wp-lists="list:slide" class="categorychecklist form-no-clear">
                        <?php $selected_cats = wp_get_post_terms( $post->ID , 'slide', array( 'fields' => 'ids' ) ); ?>
                        <?php foreach( $slide_categories as $category ) : ?>
                            <li id="slide-<?php echo $category->term_id; ?>">
                                <label class="selectit">
                                    <input value="<?php echo $category->term_id; ?>" type="radio" name="tax_input[slide][]" id="in-category-<?php echo $category->term_id; ?>" <?php checked( in_array( $category->term_id , $selected_cats ) , true ); ?> />
                                    <?php echo  esc_html( apply_filters( 'the_category' , $category->name ) ); ?>
                                </label>
                                <?php $child_args = array( 'type' => $post->post_type , 'hide_empty' => false , 'parent' => $category->term_id ); ?>
                                <?php $child_categories = get_categories( $child_args ); ?>
                                <?php if( !empty( $child_categories ) ) : ?>
                                    <ul class="children">
                                        <?php foreach( $child_categories as $child_category ) : ?>
                                            <li id="slide-<?php echo $child_category->term_id; ?>">
                                                <label class="selectit">
                                                    <input value="<?php echo $child_category->term_id; ?>" type="radio" name="tax_input[slide][]" id="in-category-<?php echo $child_category->term_id; ?>" <?php checked( in_array( $child_category->term_id , $selected_cats ) , true ); ?> />
                                                    <?php echo  esc_html( apply_filters( 'the_category' , $child_category->name ) ); ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php   
}


add_action( 'admin_init','custom_category_assets');
function custom_category_assets() {
    wp_register_script('custom_category_script', plugins_url('script.js',__FILE__ ));
    wp_enqueue_script('custom_category_script');
    wp_register_style('custom_category_style', plugins_url('style.css',__FILE__ ));
    wp_enqueue_style('custom_category_style');
}

// Register Custom Taxonomy
function media_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Media', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Media', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Media', 'text_domain' ),
		'all_items'                  => __( 'Media', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Media', 'text_domain' ),
		'add_new_item'               => __( 'Add Media', 'text_domain' ),
		'edit_item'                  => __( 'Edit Media', 'text_domain' ),
		'update_item'                => __( 'Update Media', 'text_domain' ),
		'view_item'                  => __( 'View Media', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                       => 'media',
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'query_var'                  => '',
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'media', array( 'post' ), $args );

}
add_action( 'init', 'media_taxonomy', 0 );

// Register Custom Taxonomy
function slide_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Slide', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Slide', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Slide', 'text_domain' ),
		'all_items'                  => __( 'Slide', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Slide', 'text_domain' ),
		'add_new_item'               => __( 'Add Slide', 'text_domain' ),
		'edit_item'                  => __( 'Edit Slide', 'text_domain' ),
		'update_item'                => __( 'Update Slide', 'text_domain' ),
		'view_item'                  => __( 'View Slide', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                       => 'slide',
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$capabilities = array(
		'assign_terms'				 => 'manage_options',
		'edit_terms'  				 => 'administrator',
		'manage_terms'				 => 'administrator',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'query_var'                  => '',
		'rewrite'                    => $rewrite,
		'capabilities'				 => $capabilities,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'slide', array( 'post' ), $args );

}
add_action( 'init', 'slide_taxonomy', 0 );

// Register Custom Taxonomy
function display_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Display', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Display', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Display', 'text_domain' ),
		'all_items'                  => __( 'Display', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Display', 'text_domain' ),
		'add_new_item'               => __( 'Add Display', 'text_domain' ),
		'edit_item'                  => __( 'Edit Display', 'text_domain' ),
		'update_item'                => __( 'Update Display', 'text_domain' ),
		'view_item'                  => __( 'View Display', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                       => 'display',
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$capabilities = array(
		'assign_terms'				 => 'manage_options',
		'edit_terms'  				 => 'administrator',
		'manage_terms'				 => 'administrator',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'query_var'                  => '',
		'rewrite'                    => $rewrite,
		'capabilities'				 => $capabilities,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'display', array( 'post' ), $args );

}
add_action( 'init', 'display_taxonomy', 0 );


//event dates
//Event meta box
function event_add_meta_box() {
//this will add the metabox for the event post type
$screens = array( 'post' );

foreach ( $screens as $screen ) {
    add_meta_box(
        'event_sectionid',
        __( 'Event Details', 'event_textdomain' ),
        'event_meta_box_callback',
        $screen
    );
 }
}
add_action( 'add_meta_boxes', 'event_add_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function event_meta_box_callback( $post ) {

// Add a nonce field so we can check for it later.
wp_nonce_field( 'event_save_meta_box_data', 'event_meta_box_nonce' );

/*
 * Use get_post_meta() to retrieve an existing value
 * from the database and use the value for the form.
 */
 // original for single retrieve.
 //https://developer.wordpress.org/reference/functions/get_post_meta/
// $value = get_post_meta( $post->ID, 'event_datetime', true );
$event_meta = get_post_meta( $post->ID, false );

echo '	<div class="input-group inline">
			<div class="input-wrapper">
				<label for="event_start_date">Start Date<span>*</span></label>
				<input type="date" class="event_start" id="event_start_date" name="event_start_date" value="' . esc_attr( substr($event_meta['event_start_datetime'][0],0,10) ) . '" size="25" />
			</div>
			<div class="input-wrapper">
				<label for="event_start_time">Start Time<span>*</span></label>
				<input type="time" class="event_start" id="event_start_time" name="event_start_time" value="' . esc_attr( substr($event_meta['event_start_datetime'][0],11,15) ) . '" size="25" />
			</div>
		</div>

		<div class="input-group inline">
			<div class="input-wrapper">
				<label for="event_end_date">End Date<span>*</span></label>
				<input type="date" class="event_end" id="event_end_date" name="event_end_date" value="' . esc_attr( substr($event_meta['event_end_datetime'][0],0,10) ) . '" size="25" />
			</div>
			<div class="input-wrapper">
				<label for="event_end_time">End Time<span>*</span></label>
				<input type="time" class="event_end" id="event_end_time" name="event_end_time" value="' . esc_attr( substr($event_meta['event_end_datetime'][0],11,15) ) . '" size="25" />
			</div>
		</div>
		<hr>
		<div class="input-group inline">
			<div class="input-wrapper">
				<label for="event_location">Event Location<span>*</span></label>
				<input type="text" id="event_location" name="event_location" value="' . esc_attr( $event_meta['event_location'][0] ) . '" size="25" />
			</div>
			<button id="setDefault" class="button">Default</button>
		</div>
	
		<div class="input-group inline">
			<div class="input-wrapper">
				<label for="event_address">Address<span>*</span></label>
				<input type="text" id="event_address" name="event_address" value="' . esc_attr( $event_meta['event_address'][0] ) . '" size="25" />
			</div>
			<div class="input-wrapper" style="width: 300px">
				<label for="event_city">City<span>*</span></label>
				<input type="text" id="event_city" name="event_city" value="' . esc_attr( $event_meta['event_city'][0] ) . '" size="25" />
			</div>
			<div class="input-wrapper" style="width: 100px">
				<label for="event_state">State<span>*</span></label>
				<input type="text" id="event_state" maxlength="2" pattern="[A-Z]{2}" name="event_state" value="' . esc_attr( $event_meta['event_state'][0] ) . '" size="5" />
			</div>
			<div class="input-wrapper" style="width: 100px">
				<label for="event_zip">Zip<span>*</span></label>
				<input type="text" maxlength="5" pattern="[0-9]{5}" id="event_zip" name="event_zip" value="' . esc_attr( $event_meta['event_zip'][0] ) . '" size="10" />
			</div>
		</div>



		<input type="hidden" id="event_start_datetime" name="event_start_datetime" value="' . esc_attr( $event_meta['event_start_datetime'][0] ) . '" size="25" />
		<input type="hidden" id="event_monthday" name="event_monthday" value="' . esc_attr( $event_meta['event_monthday'][0] ) . '" size="25" />
		<input type="hidden" id="event_end_datetime" name="event_end_datetime" value="' . esc_attr( $event_meta['event_end_datetime'][0] ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
 function event_save_meta_box_data( $post_id ) {

 if ( ! isset( $_POST['event_meta_box_nonce'] ) ) {
    return;
 }

 if ( ! wp_verify_nonce( $_POST['event_meta_box_nonce'], 'event_save_meta_box_data' ) ) {
    return;
 }

 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
 }

 // Check the user's permissions.
 if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

 } else {

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
 }

 if ( 
	! isset($_POST['event_start_datetime']) || 
	! isset( $_POST['event_end_datetime']) ||
	! isset( $_POST['event_location']) ||
	! isset( $_POST['event_address']) ||
	! isset( $_POST['event_city']) ||
	! isset( $_POST['event_state']) ||
	! isset( $_POST['event_zip'])
 ) 
 {
    return;
 }

 $event_start_datetime_data = sanitize_text_field( $_POST['event_start_datetime'] );
 $event_end_datetime_data = sanitize_text_field( $_POST['event_end_datetime'] );
 $event_monthday_data = sanitize_text_field( $_POST['event_monthday'] );
 $event_location_data = sanitize_text_field( $_POST['event_location'] );
 $event_address_data = sanitize_text_field( $_POST['event_address'] );
 $event_city_data = sanitize_text_field( $_POST['event_city'] );
 $event_state_data = sanitize_text_field( $_POST['event_state'] );
 $event_zip_data = sanitize_text_field( $_POST['event_zip'] );

 $event_data = array(
	 array(
		 'name' => 'event_start_datetime',
		 'value' => $event_start_datetime_data
	 ),
	 array(
		 'name' => 'event_end_datetime',
		 'value' => $event_end_datetime_data
	 ),
	 array(
		 'name' => 'event_monthday',
		 'value' => $event_monthday_data
	 ),
	 array(
		 'name' => 'event_location',
		 'value' => $event_location_data
	 ),
	 array(
		 'name' => 'event_address',
		 'value' => $event_address_data
	 ),
	 array(
		 'name' => 'event_city',
		 'value' => $event_city_data
	 ),
	 array(
		 'name' => 'event_state',
		 'value' => $event_state_data
	 ),
	 array(
		 'name' => 'event_zip',
		 'value' => $event_zip_data
	 ),

	 );
//  var_dump($event_start_datetime_data);
 update_event_meta( $post_id, $event_data );


}
function update_event_meta($post, $data_array) {
	foreach ($data_array as $field) {
		update_post_meta($post, $field['name'], $field['value']);
	}
}
add_action( 'save_post', 'event_save_meta_box_data' );


//add custom Meta to API endpoint
//https://developer.wordpress.org/reference/functions/register_rest_field/
add_action( 'rest_api_init', 'create_event_api_posts_meta_field' );

function create_event_api_posts_meta_field() {
    // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() );
    register_rest_field( 'post', 'event_details', array(
           'get_callback'    => 'get_event_post_meta_for_api',
           'schema'          => null,
        )
    );
}

function get_event_post_meta_for_api( $object ) {
    //get the id of the post object array
	$post_id = $object['id'];
	//return the post meta
	$event_start_datetime = get_post_meta( $post_id, 'event_start_datetime', true );
	$event_end_datetime = get_post_meta( $post_id, 'event_end_datetime', true );
	$event_monthday = get_post_meta( $post_id, 'event_monthday', true );
	$event_location = get_post_meta( $post_id, 'event_location', true );
	$event_address = get_post_meta( $post_id, 'event_address', true );
	$event_city = get_post_meta( $post_id, 'event_city', true );
	$event_state = get_post_meta( $post_id, 'event_state', true );
	$event_zip = get_post_meta( $post_id, 'event_zip', true );

	$event_post_meta = array(
		'event_start_datetime' => $event_start_datetime,
		'event_end_datetime' => $event_end_datetime,
		'event_monthday' => $event_monthday,
		'event_location' => $event_location,
		'event_address' => $event_address,
		'event_city' => $event_city,
		'event_state' => $event_state,
		'event_zip' => $event_zip,
	);
	// var_dump($event_post_meta);
    return $event_post_meta;
}



//path
//Path meta box
function path_add_meta_box() {
//this will add the metabox for the path post type
$screens = array( 'post');
foreach ( $screens as $screen ) {
    add_meta_box(
        'path_sectionid',
        __( 'Path Details', 'path_textdomain' ),
        'path_meta_box_callback',
		'post',
		'normal',
		'high'
    );
 }
}
add_action( 'add_meta_boxes', 'path_add_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function path_meta_box_callback( $post ) {

// Add a nonce field so we can check for it later.
wp_nonce_field( 'path_save_meta_box_data', 'path_meta_box_nonce' );

/*
 * Use get_post_meta() to retrieve an existing value
 * from the database and use the value for the form.
 */
 // original for single retrieve.
 //https://developer.wordpress.org/reference/functions/get_post_meta/
// $value = get_post_meta( $post->ID, 'path_custom', true );
$path_meta = get_post_meta( $post->ID, false );

echo '	<div class="input-group">
			<label for="path_custom">Path</label>
			<input type="text" disabled class="path_custom" id="path_custom" name="path_custom" value="' . $path_meta['path_custom'][0] . '" />
		</div>';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
 function path_save_meta_box_data( $post_id ) {

 if ( ! isset( $_POST['path_meta_box_nonce'] ) ) {
    return;
 }

 if ( ! wp_verify_nonce( $_POST['path_meta_box_nonce'], 'path_save_meta_box_data' ) ) {
    return;
 }

 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
 }

 // Check the user's permissions.
 if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

 } else {

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
 }

 if ( ! isset( $_POST['path_custom'] ) ) 
 {
    return;
 }

 $path_custom_data = sanitize_text_field( $_POST['path_custom'] );

 $path_data = array(
	 array(
		 'name' => 'path_custom',
		 'value' => $path_custom_data
	 )
	 );
//  var_dump($path_custom_data);
 update_path_meta( $post_id, $path_data );


}
function update_path_meta($post, $data_array) {
	foreach ($data_array as $field) {
		update_post_meta($post, $field['name'], $field['value']);
	}
}
add_action( 'save_post', 'path_save_meta_box_data' );


//add custom Meta to API endpoint
//https://developer.wordpress.org/reference/functions/register_rest_field/
add_action( 'rest_api_init', 'create_path_api_posts_meta_field' );

function create_path_api_posts_meta_field() {
    // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() );
    register_rest_field( 'post', 'path', array(
           'get_callback'    => 'get_path_post_meta_for_api',
           'schema'          => null,
        )
    );
}

function get_path_post_meta_for_api( $object ) {
    //get the id of the post object array
	$post_id = $object['id'];
	//return the post meta
	$path_custom = get_post_meta( $post_id, 'path_custom', true );
	$path_post_meta = array(
		'path_custom' => $path_custom,
	);
	// var_dump($path_post_meta);
    return $path_post_meta;
}

//save path depending on whether or not the post is in the event category
function my_update_value($post_id) {
  $category_array = array();
  $category_array = $_POST['post_category'];
  $event_category = get_category_by_slug('event');
  $worship_category = get_category_by_slug('worship');
  $start_date = get_post_meta( $post_id, 'event_start_datetime', true );
  $title = sanitize_title(get_the_title($post_id));

  $isEvent = in_array((string)$event_category->term_id, $category_array,  true) || in_array((string)$worship_category->term_id, $category_array,  true);

  //if in the event category - use the acf start_date field to set path.  Otherwise, grab date from the post date values.
  $date = $isEvent ? date('Y/m/d/', strtotime($start_date)) : $_POST['aa'] .'/'. $_POST['mm'] .'/'. $_POST['jj'] .'/';
  $value = $date . $title;

  update_post_meta($post_id, 'path_custom', $value);
    
}

add_filter('save_post', 'my_update_value', 20);

add_action( 'edit_form_after_title', 'add_content_before_editor' );

function add_content_before_editor($post) {
	$current_screen = get_current_screen();
	$front_base_url = get_field('front_URL', 'option');
	// var_dump($current_screen->post_type);
	if($current_screen->post_type === 'post') {
		$path_custom = get_post_meta( $post->ID, 'path_custom', true );
		$path_link = $front_base_url.'/'.$path_custom;
		echo '<strong>Path: </strong><a href="'.$path_link.'" target="_blank">'.$path_link.'</a>';
	}
	elseif($current_screen->post_type === 'page') {
		$path_custom = $post->post_name;
		$path_link = $front_base_url.'/'.$path_custom;
		echo '<strong>Path: </strong><a href="'.$path_link.'" target="_blank">'.$path_link.'</a>';
	}
	else {
		$path_link = get_permalink($post->ID);
		echo '<strong>Path: </strong><a href="'.$path_link.'" target="_blank">'.$path_link.'</a>';
	}
}


/**
 * vpm_default_hidden_meta_boxes
 */
function vpm_default_hidden_meta_boxes( $hidden, $screen ) {
	// Grab the current post type
	$post_type = $screen->post_type;
	// If we're on a 'post'...
	if ( $post_type == 'post' ) {
		// Define which meta boxes we wish to hide
		$hidden = array(
			'authordiv',
			'revisionsdiv',
			'postexcerpt',
			'commentsdiv',
			'trackbacksdiv',
			'commentstatusdiv',
			'path_sectionid',
			'slugdiv',
			'formatdiv',
			'edit-slug-box'

		);
		// Pass our new defaults onto WordPress
		return $hidden;
	}
	// If we are not on a 'post', pass the
	// original defaults, as defined by WordPress
	return $hidden;
		// remove_meta_box( 'revisionsdiv' , 'post' , 'normal' );      //removes comments

}
add_action( 'default_hidden_meta_boxes', 'vpm_default_hidden_meta_boxes', 10, 2 );

function remove_add_image_sizes() {
	foreach ( get_intermediate_image_sizes() as $size ) {
		if ( !in_array( $size, array( 'thumbnail' ) ) ) {
			remove_image_size( $size );
        }
    }
    add_image_size( 'large', 1920, 1080, true ); //force crop on photos.
}
add_action( 'after_setup_theme', 'remove_add_image_sizes' );

function remove_post_excerpt_checkbox() {
  ?>
    <style>
      .metabox-prefs label[for="media_category_div-hide"], 
	  .metabox-prefs label[for="slide_category_div-hide"], 
	  .metabox-prefs label[for="displaydiv-hide"], 
	  .metabox-prefs label[for="commentsdiv-hide"], 
	  .metabox-prefs label[for="slugdiv-hide"], 
	  .metabox-prefs label[for="formatdiv-hide"], 
	  .metabox-prefs label[for="postimagediv-hide"], 
	  .metabox-prefs label[for="commentstatusdiv-hide"], 
	  .metabox-prefs label[for="trackbacksdiv-hide"], 
	  .metabox-prefs label[for="event_sectionid-hide"], 
	  .metabox-prefs label[for="custom_category_div-hide"] 
	  { 
        display: none; 
      }
    </style>
  <?php
}
add_action( 'admin_head', 'remove_post_excerpt_checkbox' );


include 'upcoming-api-route.php';
?>
