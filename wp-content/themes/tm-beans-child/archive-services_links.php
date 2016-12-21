<?php 



beans_remove_markup( 'beans_post_title' );
beans_remove_markup( 'beans_post_header' );
beans_remove_markup( 'beans_post_body' );
beans_remove_markup( 'beans_post_content' );
		// Add grid.
		beans_wrap_inner_markup( 'beans_content', 'beans_child_posts_grid', 'div', array(
			'data-uk-grid' => '{gutter: 20}'
		) );
		beans_wrap_markup( 'beans_post', 'beans_child_post_grid_column', 'div', array(
			'class' => 'uk-width-large-1-3 uk-width-medium-1-2'
		) );



add_filter( 'the_content', 'beans_child_modify_post_content' );

function beans_child_modify_post_content( $content ) {



         return '<p>here</p><p>' . get_field( 'url' ) . '</p>';

   // return $content;

}


beans_modify_action_hook( 'beans_archive_title', 'beans_child_posts_grid_before_markup' );
		// Move the posts pagination after the new grid markup.
		beans_modify_action_hook( 'beans_posts_pagination', 'beans_child_posts_grid_before_markup' );




beans_remove_attribute( 'beans_post_title_link', 'href' );
beans_add_attribute( 'beans_post_title_link', 'href', get_field( 'url' ) );

add_action( 'beans_post_title_after_markup', 'example_additional_content' );






add_action( 'beans_loop_query_args', 'beans_child_services_query_args' );

function beans_child_services_query_args() {

    // Only apply to front page.
  

    return array(
        'post_type' => 'services_links',
        'posts_per_page' => 40
    );

}



add_action( 'beans_main_grid_before_markup', 'beans_child_featured_post_loop' );

function beans_child_featured_post_loop() {

    // Only apply to front page.
   

    beans_add_attribute( 'beans_post_title', 'class', 'uk-h4' );
    beans_remove_action( 'beans_post_meta' );
    beans_remove_action( 'beans_post_meta_categories' );
    beans_remove_action( 'beans_post_meta_tags' );
    beans_remove_action( 'beans_posts_pagination' );
    beans_wrap_markup( 'beans_post', 'beans_child_featured_post_grid_column', 'div' );

    ?><div class="uk-grid uk-grid-width-medium-1-3" data-uk-grid-margin><?php

       // beans_loop_template( 'featured' );

    ?></div><?php

    // Reset.
    remove_filter( 'the_content', 'beans_child_modify_post_content' );
    beans_reset_attributes( 'beans_post_title' );
    beans_reset_action( 'beans_post_meta' );
    beans_reset_action( 'beans_post_meta_categories' );
    beans_reset_action( 'beans_post_meta_tags' );
    beans_reset_action( 'beans_posts_pagination' );
    beans_remove_markup( 'beans_child_featured_post_grid_column' );

}






function example_additional_content() {



}


beans_load_document();