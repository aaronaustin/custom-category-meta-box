<?php
/*Plugin Name: Add Custom Category Meta Box to Posts
Description: This plugin adds a custom meta box in place of the standard category meta box for posts.
Version: 1.0.4
License: GPLv2
GitHub Plugin URI: https://github.com/aaronaustin/custom-category-meta-box
*/

//add custom category metabox
add_action( 'load-post.php' , 'custom_load_post' );
add_action( 'load-post-new.php' , 'custom_load_post' );
function custom_load_post() {
    remove_meta_box( 'categorydiv' , 'post' , 'side' );
    add_meta_box( 'custom_category_div' , __( 'Category' ) , 'custom_category_metabox' , 'post' , 'normal', 'high', array( 'taxonomy' => 'category' ) );
}
function custom_category_metabox( $post ) {
    ?>
        



        <div id="custom-category" class="categorydiv">
            <div id="custom-category-all">
                <input type="hidden" name="post_category[]" value="0" />
                <?php $args = array( 'type' => $post->post_type , 'hide_empty' => false , 'parent' => 0 ); ?>
                <?php $categories = get_categories( $args ); ?>
                <?php if( !empty( $categories ) ) : ?>
                    <ul id="custom-category-checklist" data-wp-lists="list:category" class="categorychecklist form-no-clear">
                        <?php $selected_cats = wp_get_post_categories( $post->ID , array( 'fields' => 'ids' ) ); ?>
                        <?php foreach( $categories as $category ) : ?>
                            <?php $child_args = array( 'type' => $post->post_type , 'hide_empty' => false , 'parent' => $category->term_id ); ?>
                            <?php $child_categories = get_categories( $child_args ); ?>
                            <?php $child_cat_ids = join(',',get_term_children($category->term_id, 'category')); ?>
                            <li id="category-<?php echo $category->term_id; ?>" class="parent<?php echo in_array( $category->term_id , $selected_cats ) ? ' selected' : ''; ?>">
                                <label class="selectit">
                                    <input value="<?php echo $category->term_id; ?>" data-child="<?php echo $child_cat_ids;?>" type="checkbox" name="post_category[]" id="in-category-<?php echo $category->term_id; ?>" <?php checked( in_array( $category->term_id , $selected_cats ) , true ); ?> />
                                    <?php echo  esc_html( apply_filters( 'the_category' , $category->name ) ); ?>
                                </label>
                                
                                <?php if( !empty( $child_categories ) ) : ?>
                                    <!-- <ul class="children"> -->
                                        <?php foreach( $child_categories as $child_category ) : ?>
                                        <?php $parent_category = get_term($child_category->parent, 'category');?>
                                            <li class="child" id="category-<?php echo $child_category->term_id; ?>">
                                                <label class="selectit">
                                                    <input value="<?php echo $child_category->term_id; ?>" data-parent="<?php echo $parent_category->term_id;?>" type="checkbox" name="post_category[]" id="in-category-<?php echo $child_category->term_id; ?>" <?php checked( in_array( $child_category->term_id , $selected_cats ) , true ); ?> />
                                                    <?php echo  esc_html( apply_filters( 'the_category' , $child_category->name ) ); ?>
                                                </label>

                                                <?php $child_args = array( 'type' => $post->post_type , 'hide_empty' => false , 'parent' => $child_category->term_id ); ?>
                                                <?php $child_categories = get_categories( $child_args ); ?>
                                                <?php if( !empty( $child_categories ) ) : ?>
                                                    <ul class="children">
                                                        <?php foreach( $child_categories as $child_category ) : ?>
                                                            <li id="category-<?php echo $child_category->term_id; ?>">
                                                                <label class="selectit">
                                                                    <input value="<?php echo $child_category->term_id; ?>" type="checkbox" name="post_category[]" id="in-category-<?php echo $child_category->term_id; ?>" <?php checked( in_array( $child_category->term_id , $selected_cats ) , true ); ?> />
                                                                    <?php echo  esc_html( apply_filters( 'the_category' , $child_category->name ) ); ?>
                                                                </label>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>


                                            </li>
                                        <?php endforeach; ?>
                                    <!-- </ul> -->
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

?>
