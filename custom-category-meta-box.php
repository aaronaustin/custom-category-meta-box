<?php
/*Plugin Name: Add Custom Category Meta Box to Posts
Description: This plugin adds a custom meta box in place of the standard category meta box for posts.
Version: 1.0.5
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




?>
