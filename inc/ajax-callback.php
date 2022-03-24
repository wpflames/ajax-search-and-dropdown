<?php

// Ajax Callback
 
add_action('wp_ajax_my_ajax_filter_search', 'my_ajax_filter_search_callback');
add_action('wp_ajax_nopriv_my_ajax_filter_search', 'my_ajax_filter_search_callback');
 
function my_ajax_filter_search_callback() {
 
    header("Content-Type: application/json"); 
 
    $meta_query = array('relation' => 'AND');
    
    if(isset($_GET['status'])) {
        $status = sanitize_text_field( $_GET['status'] );
        $meta_query[] = array(
            'key' => 'status',
            'value' => $status,
            'compare' => '='
        );
    }

    $tax_query = array();

    if(isset($_GET['year'])) {
        $year = sanitize_text_field( $_GET['year'] );
        $tax_query[] = array(
            'taxonomy' => 'ay',
            'field' => 'slug',
            'terms' => $year
        );
    }
 
    $args = array(
        'post_type' => 'grantee',
        'posts_per_page' => -1,
        'meta_query' => $meta_query,
        'tax_query' => $tax_query
    );
 
    // SEARCH BY NAME
    if(isset($_GET['search'])) {
        $search = sanitize_text_field( $_GET['search'] );
        $search_query = new WP_Query( array(
            'post_type' => 'grantee',
            'posts_per_page' => -1,
            'tax_query' => $tax_query,
            's' => $search,
        ) );
    }
    
    // SEARCH / META QUERY
    if(isset($_GET['search_2'])) {
        $search_2 = sanitize_text_field( $_GET['search_2'] );
        $search_query = new WP_Query( array(
            'post_type' => 'grantee',
            'posts_per_page' => -1,
            'meta_query'	=> array(
                'relation'		=> 'OR',
                array(
                    'key'		=> 'home_institution',
                    'value'		=> $search_2,
                    'compare'	=> 'LIKE'
                ),
                array(
                    'key'		=> 'host_institution',
                    'value'		=> $search_2,
                    'compare'	=> 'LIKE'
                ), 
                array(
                    'key'		=> 'field',
                    'value'		=> $search_2,
                    'compare'	=> 'LIKE'
                )
            ),
        ) );
    } 

    else {
        $search_query = new WP_Query( $args );
    }
 
    if ( $search_query->have_posts() ) {
 
        $result = array();
 
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
 
            $cats = strip_tags( get_the_category_list(", ") );
            $result[] = array(
                "id" => get_the_ID(),
                "title" => get_the_title(),
                "year" => get_field('ay'),
                "status" => get_field('status'),
                "home_institution" => get_field('home_institution'),
                "host_institution" => get_field('host_institution'),
                "field" => get_field('field'),
                "position" => get_field('position'),
                "media" => get_field('media')
            );
        }
        wp_reset_query();
 
        echo json_encode($result);
 
    } else {
        echo 'No posts found';
    }
    wp_die();
}