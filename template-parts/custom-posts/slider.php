<?php

function rt_slider_type() {
    register_post_type( 'rt_slider',
        array(
            'labels' => array(
                'name' => __( 'Slider' ),
                'singular_name' => __( 'Slide' )
            ),
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions' ),
            'public' => true,
            'has_archive' => true,
            'featured_image'=>true,
            'set_featured_image'=>true
        )
    );
}
add_action( 'init', 'rt_slider_type' );