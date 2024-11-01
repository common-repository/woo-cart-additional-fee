<?php

// ---------------------------------------------------------
// Create Product Array List
// ---------------------------------------------------------

function wcfee_create_product_list_array(){

	$args = array( 'post_type' => 'product', 'posts_per_page' => -1 );

	$Products = array();

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();

        $Products[get_the_ID()] = get_the_title();

    endwhile;

    wp_reset_query();

	return $Products;
}

?>