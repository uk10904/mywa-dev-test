<?php 


beans_add_attribute( 'beans_post_content', 'style', 'padding:20px 0;' );



add_action( 'the_content', 'display_services' );

function display_services() {
$categories = get_categories( array ('taxonomy' => 'services_tax', 'orderby' => 'name', 'order' => 'asc', 'hide_empty' => true ) );
$html;

$html .= <<<EOT
<h2>myWA Alpha Services List</h2>
<p>The following services are currently searchable from this site. Clicking on any link will take you to the relevant government website where that services is available.</p>

<p>Additional services will be identified, tested and added to myWA Alpha on an ongoing basis.</p>
<hr />
EOT;


foreach ($categories as $category){
  $html .= '<h3>'.$category->name.'</h3>';
  $html .= '<ul>';

  $args = array( 'posts_per_page' => -1, 'post_type' => 'services_links', 
  'tax_query' => array(
    array(
      'taxonomy' => 'services_tax',
      'field' => 'id',
      'terms' => $category->term_id, // Where term_id of Term 1 is "1".
      'include_children' => false
    )
  ) );

   $posts = get_posts($args);
   foreach ($posts as $post ) : setup_postdata( $post ); 
   $url = get_field('url', $post->ID);
   $http = strpos($url, 'http') === 0 ? '' : 'http://';
   $pos = strpos($url, 'http');

    $title = get_the_title($post->ID);
    $html .=  '<li><a target="_blank" href="'.$http.$url.'">'. $title .' <i class="uk-icon-external-link"></i></a></li>';



endforeach;

 $html .= '</ul>';


} //end foreach



        // return '<p>here</p><p>test</p>';
wp_reset_query();
    return $html;

}




beans_load_document();