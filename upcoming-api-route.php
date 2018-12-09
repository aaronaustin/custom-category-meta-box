<?php
    add_action( 'rest_api_init', 'my_register_route');
    
    
    function my_register_route() {
                
            register_rest_route( 'aad/v2', 'sunday', array(
                    'methods' => 'GET',
                    'callback' => 'this_sunday',
                )
            );
    }
    
    function this_sunday( $data ) {
                
        // default the author list to all
        // $post_author = 'all';
        
        // if ID is set
        // if( isset( $data[ 'id' ] ) ) {
        //     $post_author = $data[ 'id' ];
        // }
        $next_sunday_date = date('Y-m-d',strtotime('this sunday'));
            // var_dump($next_sunday_date);
        $sunday_args = array(
            'offset'           => 0,
            'meta_query' => array(
                'date_clause' => array(
                    array('key' => 'event_start_datetime',
                            'value' => $next_sunday_date,
                            'compare' => 'LIKE'
                    )
                )
            ),
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => false ,
            'orderby'   => 'meta_value',
            'order'            => 'ASC',
        );

        $sunday_posts = get_posts($sunday_args);

        // get the posts
        // $posts_list = get_posts( array( 'type' => 'post', 'category_slug' => 'worship' ) );
        $post_data = array();
                
        foreach( $sunday_posts as $posts) {
            $post_id = $posts->ID;
            $post_title = $posts->post_title;
            $event_start_datetime = get_post_meta($posts->ID, 'event_start_datetime'); 
            $path_custom = get_post_meta($posts->ID, 'path_custom'); 
            
            $post_data[ $post_id ][ 'wordpress_id' ] = $post_id;
            $post_data[ $post_id ][ 'title' ] = $post_title;
            $post_data[ $post_id ][ 'event_start_datetime' ] = $event_start_datetime;
            $post_data[ $post_id ][ 'path_custom' ] = $path_custom;

        }
        wp_reset_postdata();
                
        return rest_ensure_response( $post_data );
    }
        
?>