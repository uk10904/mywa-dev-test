<?php 



beans_add_attribute( 'beans_post_content', 'style', 'padding:20px 0;' );

add_filter( 'the_content', 'beans_child_modify_post_content' );


function beans_child_modify_post_content( $content ) {
  // return '<h1>content</h1>';
}
add_action( 'beans_content_before_markup', 'display_service_filters' );
function display_service_filters() {
    $alpha = array();
    $guideUnique = array();
    $guideCompare;
    $guide;

$categories = get_categories( array ( 'taxonomy' => 'services_tax', 'orderby' => 'name', 'order' => 'asc', 'hide_empty' => false) );

//print_r($categories[0]);
foreach ($categories as $category){
   array_push($alpha, substr($category->name,0,1));
   $titleArray = explode(' ', $category->name);
   $titleArray = explode(',', $titleArray[0]);
   $guide = $titleArray[0];
   if($guide != $guideCompare) {
         $guideCompare = $guide;
         $guideUnique[substr($category->name,0,1)] .= $guide.', ';
   }
   
}
$ualpha = array_unique($alpha);
$html = '<div class="feedback-element"><ul id="dept-filter" class="uk-subnav uk-flex-center uk-subnav-pill">';
$html .= '<li class="uk-active" data-uk-filter><a href="#">All</a></li>';
foreach ($ualpha as $char) {
      $html .= <<<HTML
     <li data-uk-filter="filter-$char"><a data-uk-tooltip title="$guideUnique[$char]" href="#">$char</a></li>

HTML;
//print $html;
}
$html .= '</ul></div>';
print $html;
}


add_action( 'the_content', 'display_services' );

function display_services() {
$categories = get_categories( array ('taxonomy' => 'services_tax', 'orderby' => 'name', 'order' => 'asc', 'hide_empty' => false ) );
$content;

$html = '<div class="feedback-element"><div class="uk-grid-width-medium-1-2" data-uk-grid="{ controls:\'#dept-filter\'}">';
$oldChar = 'A';

$i=0;
foreach ($categories as $category){
$char = substr($category->name,0,1);
if($oldChar != $char) {
      $oldChar = substr($category->name,0,1);
      $endWrap = true;
      
}

if($i==0) {
 
 
  $html .= '<div class="char-wrap-'.strtolower($oldChar).'"  data-uk-filter="filter-'.$char.'">';
  $html .= '<span>'.$oldChar.'</span>';
  $i++;
}


if($endWrap) {
  
  $html .= '</div>';
  $html .= '<div class="char-wrap-'.strtolower($oldChar).'"  data-uk-filter="filter-'.$char.'">';
  $html .= '<span>'.$oldChar.'</span>';
  //$i=0;
   $endWrap = false;
  
}




$term = get_field('url', 'services_tax_'.$category->term_id);
$http = strpos($term, 'http') ? '' : 'http://';
  $html .= '<div style="padding:4px;font-weight:bold;"><a href="'.$http.$term.'">'. $category->name .'</a></div>';



 /*  $catPosts = new WP_Query( array ( 'post_type' => 'services_links', 
        'tax_query' => array(
            array( 'taxonomy' => 'services_tax',
            'field' => 'slug',
            'terms' => array( $category->slug ),
    ) ), 'orderby' => 'title' ) ); 
  print '<div  class="uk-accordion-content">';
   if ( $catPosts->have_posts() ){
       while ( $catPosts->have_posts() ){
           $catPosts->the_post();
         $url = get_field('url');
          $title = get_the_title();
        print '<a href="'.$url.'">'.$title.'</a><br />';
         
       }
   print '</div>';
  //     $content .=  '<p><a href="/category/'.$category->slug.'">More in this category</a></p>';

   } */



} //end foreach
$html .= '</div></div>';
wp_reset_query();

        // return '<p>here</p><p>test</p>';

    return $html;

}




beans_load_document();