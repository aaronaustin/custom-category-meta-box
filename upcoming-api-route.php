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
        $today = current_time( 'mysql' );
        $this_sunday_date = date('Y-m-d',strtotime($today.'this sunday'));
        
        $sunday_args = array(
            'offset'           => 0,
            'meta_query' => array(
                'date_clause' => array(
                    array('key' => 'event_start_datetime',
                            'value' => $this_sunday_date,
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
        $post_data = array(
            array('date' => $this_sunday_date)
        );

        if(count($sunday_posts) == 0){
            
            $post_item = array(
                'ID' => 1,
                'title' => 'No scheduled events',
                'event_start_datetime' => $this_sunday_date,
                'path_custom' => ''
            );
            $post_data[1] = $post_item;
        }
        else {
            $idx=1;
            foreach( $sunday_posts as $posts) {
                $post_id = $posts->ID;
                $post_title = $posts->post_title;
                $event_start_datetime = get_post_meta($posts->ID, 'event_start_datetime', true); 
                $path_custom = get_post_meta($posts->ID, 'path_custom', true); 
                
                $post_item = array(
                    'ID' => $post_id,
                    'title' => $post_title,
                    'event_start_datetime' => $event_start_datetime,
                    'path_custom' => $path_custom
                );
                $post_data[$idx] = $post_item;

                $idx++;
            }
        }
        
        wp_reset_postdata();
                
        return rest_ensure_response( $post_data );
    }
        
?>