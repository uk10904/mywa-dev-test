<?php

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

/*
 * Remove this action and callback function if you do not whish to use LESS to style your site or overwrite UIkit variables.
 * If you are using LESS, make sure to enable development mode via the Admin->Appearance->Settings option. LESS will then be processed on the fly.
 */
 function is_localhost() {
    $whitelist = array( '127.0.0.1', '::1' );
    if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
        return true;
}
$devPrefix = is_localhost() ? '/mywa' : '';

add_action( 'beans_uikit_enqueue_scripts', 'beans_child_enqueue_uikit_assets' );

function beans_child_enqueue_uikit_assets() {

	beans_compiler_add_fragment( 'uikit', get_stylesheet_directory_uri() . '/style.less', 'less' );

}
add_filter( 'beans_footer_credit_right_text_output', 'edit_footer_credit_right_text' );

function edit_footer_credit_right_text() {

	return '';

}



function display_portals() {

    	global $post, $devPrefix;
$args = array( 'category' => 8, 'numberposts' => 4);
$stickyposts = get_posts( $args );


$return = '<h2 class="section-title">Other WA Gov Portals</h2><div class="uk-grid uk-grid-collapse other-portals" >';

$i=0;
//$colors = array('#8FBA3E','#00B1CF','#6D4987','#814833');

$colors = array('#eee','#eee','#eee','#eee');
foreach ($stickyposts as $post) : setup_postdata($post);
 
 
 $link = get_the_permalink();
 $title = get_the_title();
 $content = get_the_content();
 $url = get_the_post_thumbnail_url();
 $subtitle = get_field( "subtitle", $post->ID ) ? get_field( "subtitle", $post->ID ) : "EMPTY";
 $resized_src = beans_edit_image( $url, array(
	'resize' => array( 600, 400, array( 'center', 'top' ) )
) );
 $return .= '<div style="bottom:0; background:'.$colors[$i].'" class="uk-overlay uk-overlay-hover feedback-element uk-width-1-2 uk-width-small-1-2 uk-width-large-1-2 uk-grid-margin" data-element-name="'.$title.'">';

// $return .= '<img class="uk-overlay-scale" src="'.$resized_src.'" height="" alt="">';
$return .= '<img class="uk-overlay-scale" src="'.$devPrefix.'/wp-content/uploads/2016/11/3d-effect.png" height="" alt="">';

 // $return .= '<figcaption class="uk-overlay-panel uk-overlay-top uk-ignore">';
 $return .= '<figcaption class="uk-overlay-panel uk-flex uk-flex-center uk-flex-middle uk-text-center uk-ignore">';
 
 $return .= '<h3 style="margin:0;">'.$title.'</h3>';
 $return .= '<!--<div class="subtitle"><p></p></div>-->';
 $return .= '</figcaption>';
 $return .= '<a class="uk-position-cover" href="'.$link.'"></a>';
 $return .= '</div>';
 $i++;
endforeach;
$return .= '</div>';
wp_reset_postdata();

   return $return;
}
add_shortcode('display_portals', 'display_portals');

 
add_action('init', 'setup_functions');
function setup_functions() {

   if(!isset($_COOKIE['feedback_uid'])) {
    /*   $encodedIP = ip2long($_SERVER['REMOTE_ADDR']);
    $userIds = ['id' => uniqid(), 'ip' => ''.$encodedIP];
    $JSONUserIds = json_encode($userIds);
    setcookie('feedback_uid', $JSONUserIds, time() + (10 * 365 * 24 * 60 * 60), '/');*/
    setcookie('feedback_uid', uniqid(), time() + (10 * 365 * 24 * 60 * 60), '/');
   }

}

function theme_js() {
    wp_enqueue_script( 'typed', get_stylesheet_directory_uri() . '/js/typed.js', array( 'jquery' ), '1.0', true );
     wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array( 'typed' ), '1.0', true );
     wp_enqueue_script( 'cookie', get_stylesheet_directory_uri() . '/js/js.cookie.js', array( 'jquery' ), '1.0', true );
}

add_action('wp_enqueue_scripts', 'theme_js');


add_action('wp', 'page_setup');
function page_setup() {

    // $randNo = rand(0,4);
    // $imageIDs = array(88,86,85,84,49);
    // $imgMeta = get_post_meta($imageIDs[$randNo]);
    
    // beans_add_attribute( "beans_body", "style", "background-image:url(/mywa/wp-content/uploads/".$imgMeta['_wp_attached_file'][0].");" );
    //  beans_add_attribute( "beans_site", "data-uk-scollspy", "{cls:'in-view', target:'.uk-height-viewport'}" );
    beans_remove_action( 'beans_post_title' );

    beans_add_attribute( 'beans_main', 'id', 'tm-main' );

   
    if(is_front_page() || is_home()) {
    beans_remove_attribute( 'beans_fixed_wrap[_main]', 'class', 'uk-container' );
    beans_remove_markup( 'beans_post' );
    }

}






function show_news_posts() {
global $post;
$args = array( 'category' => array(7), 'posts_per_page'  => 4);
$newsposts = get_posts( $args );
//$return = '<h3>News for ';

//$return .= '<div class="uk-form-select" data-uk-form-select>';


//$return .= '<select><option value="1">Perth</option><option value="2">Wheatfields</option><option value="3">South West</option><option value="4">Broome</option></select></div>';
//$return .= '</h3>';
$return .= '<section id="section-4" style="position:relative;" class="news-wrapper feedback-element" data-element-name="Latest News">';
$return .= '<div id="s4" style="position:absolute; top:50%;" data-uk-scrollspy="{repeat: true}"></div>';
$return .= '<h2  class="section-title">myWA News</h2>';

$return .= '<div data-uk-grid="{gutter: 20}" style="margin-top:10vh;" class="uk-grid-width-small-1-2 uk-margin-left uk-margin-right uk-grid-width-medium-1-4 uk-grid-width-large-1-4" >';

foreach ($newsposts as $post) : setup_postdata($post);

$randNoHeart = rand(0,20);
$randNoViews = rand(20,100);
 
 $link = get_the_permalink();
 $title = get_the_title();
 $content = get_the_content();
 $url = get_the_post_thumbnail_url();
 //$date = get_the_date('jS l Y');
 $date = human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' ago';
 $subtitle = get_field( "subtitle", $post->ID ) ? get_field( "subtitle", $post->ID ) : "EMPTY";
 $resized_src = beans_edit_image( $url, array(
	'resize' => array( 600, 400, array( 'center', 'top' ) )
) );
 $return .= '<div class="news-item"><div class="uk-panel uk-panel-box">';
 $return .= '<div class="uk-panel-teaser">';
 $return .= '<img src="'.$resized_src.'" height="" alt="">';
 $return .= '</div>';
 
 $return .= '<div class="uk-panel-title">'.$title.'</div>';
 $return .= '<span class="date">'.$date.'</span>';
 $return .= '<p class="uk-hidden-small">'.$content.'</p>';
 $return .= '<div style="text-align:center; padding-bottom:10px;" class="uk-grid uk-grid-width-1-2"><div><i style="color:red" class="uk-icon-heart"></i> '.$randNoHeart.'</div><div><i class="uk-icon-eye"></i> '.$randNoViews.'</div></div>';



 $return .= '<a class="uk-position-cover" href="'.$link.'"></a>';

 $return .= '</div>';
 
 $return .= '</div>';
endforeach;

$return .= '</div>';
$return .= '<div style="text-align:center; margin-top:80px;"><a class="uk-button uk-button-primary uk-width-1-4" href="https://news.wa.gov.au">View all news</a></div>';
$return .= '</section> <!-- news-wrapper -->';
wp_reset_postdata();

   return $return;
   //return '';
}


add_shortcode('news_posts', 'show_news_posts');



function show_sticky_posts() {
global $post;
$args = array( 'category' => 8);
$stickyposts = get_posts( $args );

$return = '<div class="uk-grid uk-grid-small articles section-content feedback-element" data-element-name="General Info">';

$i=1;
foreach ($stickyposts as $post) : setup_postdata($post);
 
 $margin = $i > 1 ? 'uk-grid-margin' : '';
 $link = get_the_permalink();
 $title = get_the_title();
 $content = get_the_content();
 $url = get_the_post_thumbnail_url();
 $subtitle = get_field( "subtitle", $post->ID ) ? get_field( "subtitle", $post->ID ) : "EMPTY";
 $resized_src = beans_edit_image( $url, array(
	'resize' => array( 600, 400, array( 'center', 'top' ) )
) );
 $return .= '<div class="uk-width-small-1-2 article uk-width-large-1-3 uk-grid-margin">';

 $return .= '<img src="'.$resized_src.'" height="" alt="">';

 
 
 $return .= '<h3>'.$title.'</h3>';
 $return .= '<div class="subtitle"><p>'.$subtitle.'</p></div>';
 $return .= '<a class="uk-position-cover" href="'.$link.'"></a>';
 $return .= '</div>';
endforeach;
$return .= '</div>';
wp_reset_postdata();

   return $return;
   //return '';
}


add_shortcode('sticky_posts', 'show_sticky_posts');


add_action( 'widgets_init', 'custom_widgets_init' );

function custom_widgets_init() {

    beans_register_widget_area( array(
        'name' => 'Above Nav',
        'id' => 'abovenav',
        'description' => 'Widgets in this area will be shown in the hero section as a grid.',
        'beans_type' => 'grid'
    ) );

}

//add_action( 'beans_header_before_markup', 'abovenav_widget_area' );

function abovenav_widget_area() {
        echo '<div id="above-nav-wrap">';
        echo '<div class="uk-container uk-container-center">';
	echo beans_widget_area( 'abovenav' );
	echo '</div>';	
        echo '</div>';
}





function add_below_footer() {
global $devPrefix;

    if( wp_is_mobile()) {

$script = <<<EOT
<script>
jQuery(document).ready(function() {
jQuery('body').addClass('device');
    });
    </script>
EOT;
echo $script;
    }

$modalContent = get_post(525);
remove_filter( 'the_content', 'siteorigin_panels_filter_content' );
$content = apply_filters('the_content', $modalContent->post_content);

//$simpleFeedbackForm = do_shortcode('[contact-form-7 id="76" title="Simple Feedback Form"]');
//$elementFeedbackForm = do_shortcode('[contact-form-7 id="140" title="Element Feedback Form"]');

$elementFeedbackForm = do_shortcode('[formidable id=6]');

$simpleFeedbackForm = do_shortcode('[formidable id=15]');

$feedbackList = get_field('feedback_options');
$signUpModal = <<<HTML
<div class="uk-button-dropdown feedback-btn" data-uk-dropdown="{mode:'click', pos:'left-center'}" aria-haspopup="true" aria-expanded="false">
   <a class="" data-uk-modal="{center:true}"><img src="$devPrefix/wp-content/uploads/2016/11/feedback.png" /></a>
   <div class="uk-dropdown feedback-options" aria-hidden="true">
                                       
                                                     $feedbackList                          
                                        
                                    </div>
                                </div>

HTML;

$socialBGImageModal = <<<HTML
   <div id="bg-image-social" class="uk-modal">
     <div class="uk-modal-dialog uk-modal-dialog-large uk-padding-remove">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-modal-header">Your photographs showcased on myWA</div>
        <div class="uk-container modal-inner">
         <h3>Upload your best WA photos to Instagram or Pinterest</h3>
         <div class="social"><a target="_blank" href="http://instagram.com"><i class="uk-icon-instagram"></i></a> <a target="_blank" href="http://pinterest.com"><i class="uk-icon-pinterest"></i></a></div>
        </div>
    </div>
</div>
HTML;

$feedbackModal = <<<HTML
   <div id="feedback-form" class="uk-modal">
     <div class="uk-modal-dialog uk-modal-dialog-large uk-padding-remove">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-modal-header">Help Improve myWA</div>
        <div class="uk-container modal-inner">
           $simpleFeedbackForm
        </div>
    </div>
</div>
HTML;

 $elementFeedbackModal = <<<HTML
 <div id="element-feedback-form" class="uk-modal">
     <div class="uk-modal-dialog uk-modal-dialog-large uk-padding-remove">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-modal-header">Help Improve myWA</div>
        <div class="uk-container modal-inner">
         $elementFeedbackForm
        </div>
    </div>
</div>



HTML;

if ( is_home() || is_front_page() ) {
 $dotNav = <<<HTML

 <ul class="scrollnav uk-list uk-flex-column">
    <li data-uk-tooltip="{pos:'left', animation:true}"  title="myWA Search"><a href="#section-1"><i class="uk-icon-search"></i></a></li>
     <li data-uk-tooltip="{pos:'left', animation:true}"  title="myWA Services"><a href="#section-2"><i class="uk-icon-dashboard"></i></a></li>
     <!--<li data-uk-tooltip="{pos:'left', animation:true}" title="myWA Portals"><a href="#section-3"><i class="uk-icon-university"></i></a></li>
    <li data-uk-tooltip="{pos:'left', animation:true}" title="myWA News"><a href="#section-4"><i class="uk-icon-newspaper-o"></i></a></li>
    <li data-uk-tooltip="{pos:'left', animation:true}" title="myWA Links"><a href="#section-5"><i class="uk-icon-link"></i></a></li>-->
    

   

</ul>




HTML;
echo $dotNav;
}

echo $socialBGImageModal;
echo $elementFeedbackModal;
echo $feedbackModal;
echo $signUpModal;

}
add_action( 'wp_footer', 'add_below_footer', 100 );

// Remove this action and callback function if you are not adding CSS in the style.css file.
add_action( 'wp_enqueue_scripts', 'beans_child_enqueue_assets' );

function beans_child_enqueue_assets() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

}


add_action( 'beans_uikit_enqueue_scripts', 'load_uikit_extras' );

function load_uikit_extras() {

	beans_uikit_enqueue_components( array( 'toggle', 'switcher', 'animation','scrollspy','smooth-scroll', 'modal','overlay') );
	//beans_uikit_enqueue_components( array( 'tooltip', 'sticky', 'dotnav','dynamic-grid', 'lightbox','sortable','nestable','parallax-grid','accordion', 'parallax','slidenav','dynamic-pagination' ), 'add-ons' );

    //beans_uikit_enqueue_components( true );
	beans_uikit_enqueue_components( true, 'add-ons' );
	
}







add_action( 'wp_enqueue_scripts', 'print_uikit_components' );

function print_uikit_components() {

	global $_beans_uikit_enqueued_items;

	//print_r( $_beans_uikit_enqueued_items );

}


add_action( 'beans_header_after_markup', 'beans_child_home_add_title' );

function beans_child_home_add_title() {

    // Only apply to home page.
    if ( !is_home() ) {
	
		?>
		<div style="display:none;" class="uk-container uk-container-center">
			<h1>Added Title</h1>
		</div>
		<?php
	
	}

}



add_action( 'beans_content_prepend_markup', 'beans_child_home_add_description' );

function beans_child_home_add_description() {

    // Only apply to home page.
    if ( true ) { 
        

    
	}

}





add_action( 'beans_header_after_markup', 'beans_child_home_add_cover' );
function beans_child_home_add_cover() {
    global $devPrefix;

    global $post;
    $value = get_field( "above_main_content", $post->ID ) ? get_field( "above_main_content", $post->ID ) : "";
 ?>


 <?php if(is_home() || is_front_page()) : ?>

<section id="section-1" style="position:relative;" class="uk-container uk-container-center">


<div id="s1" style="position:absolute; top:50%;" data-uk-scrollspy="{repeat: true}"></div>
    <div class="alignMiddle section-1-inner">


        <div class="feedback-element search-bar" data-formid="6" data-element-name="Hompage Search Bar">
            <ul class="uk-subnav uk-subnav-pill uk-flex-center" data-uk-switcher="{connect:'#switch-search'}">
                <li><a href="" class="search-services"><i class="uk-icon-search"></i> myWA Alpha services</a></li>
                <li><a href="" class="search-aog"><i class="uk-icon-search"></i> All of Government</a></li>
            </ul>
            <ul id="switch-search" class="uk-switcher">
                <li><?php get_search_form(); ?></li>
                <li><gcse:search></gcse:search></li>
            </ul>
<script>
  (function() {
    var cx = '011211720768684915170:0jn_xi35s54';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>

        </div><!-- search-bar-->

         <div class="s1-feedback">
           <a data-formid="15" class="uk-button uk-button-primary uk-width-1-1 uk-width-small-5-10 uk-width-medium-1-3 uk-button-large feedback-modal"><i class="uk-icon-group"></i> | Tell us what you think</a>
           
        </div><!--s1-feedback-->
        
    </div><!--section-1-inner-->

        

<?php 
    $randNo = rand(0,4);
    $imageIDs = array(87,88,86,85,84,49);
    $imgMeta = get_post_meta($imageIDs[$randNo]);
    $caption = wp_get_attachment_caption($imageIDs[$randNo]);
?>
<style>
  body {background-image:url(<?php echo $devPrefix ?>/wp-content/uploads/<?php print $imgMeta['_wp_attached_file'][0]; ?>)}
</style>
    <!--<div class="userPhoto hide-600"><a data-uk-modal="{center:true}" href="#bg-image-social"><i class="uk-icon-camera"></i> <?php  print $caption; ?></a></div> -->
    <div class="userPhoto hide-600"><i class="uk-icon-camera"></i> <?php  print $caption; ?></div>

</section>
<?php endif; ?>
<?php if(is_home() || is_front_page()) : ?>
<section id="section-2" style="position:relative;">
<div id="s2" style="position:absolute; top:50%;" data-uk-scrollspy="{repeat: true}"></div>
    <div class="uk-container uk-container-center section-2-inner">
       <?php  if(is_front_page()) { echo $value; } ?>
   </div><!--section-2-inner-->

</section><!--section-2-->


<section id="section-3" style="position:relative; display:none;">
<div id="s3" style="position:absolute; top:50%;" data-uk-scrollspy="{repeat: true}"></div>
    <?php
    
      
 
      //  print display_portals();
   

    ?>
  
    
</section>

    <?php
    endif;
}



add_action( 'widgets_init', 'footer_widgets_init' );

function footer_widgets_init() {

    // Create 3 widget area.
    for( $i = 1; $i <= 3; $i++ ) {
        beans_register_widget_area( array(
            'name' => "Footer Widget Area {$i}",
            'id' => "footer_widget_area_{$i}",
        ) );
    }

}
add_action( 'beans_fixed_wrap[_header]_after_markup', 'gp_header' );

function gp_header() {
      ?>
<div class="section-intro uk-container uk-container-center">
      <div id="s1-info" class="section-info">
          <?php  the_field('section_1_description'); ?>
        
      </div>    
      <div id="s2-info" class="section-info">
          <?php  the_field('section_2_description'); ?>
      </div>  
      <div id="s3-info" class="section-info">
          <?php  the_field('section_3_description'); ?>
      </div>  
      <div id="s4-info" class="section-info">
          <?php the_field('section_4_description'); ?>
      </div>  
      <div id="s5-info" class="section-info">
          <?php the_field('section_5_description'); ?>
      </div>  
</div>
    <?php
}


add_action( 'beans_footer_before_markup', 'footer_footer_widget_area' );

function footer_footer_widget_area() {

    ?>


                               

    <div class="3-block-footer uk-block" style="background:#FAFAFA; display:none;" id="section-5" style="position:relative;">
    <div id="s5" style="position:absolute; top:50%;" data-uk-scrollspy="{repeat: true}"></div>
    <h2 style="text-align:center; background:#eee;margin:0;padding:10px 0;">myWA Links</h2>
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-width-medium-1-3" data-uk-grid-margin>
                <?php for( $i = 1; $i <= 3; $i++ ) : ?>
                    <div><?php echo beans_widget_area( "footer_widget_area_{$i}" ); ?></div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <?php
}


add_filter( 'frm_get_paged_fields', 'remove_my_breaks', 9, 2 );
function remove_my_breaks( $fields, $form_id ) {

  if ( $form_id == 6 ) { // change 12 to the ID of your form
    foreach( (array) $fields as $k => $f ) {
if ( $f->type == 'embed' ) {
unset( $fields[ $k ] );
}
      if ( $f->id == 999 ) {
        unset( $fields[ $k ] );
      }
    }
  }
  return $fields;
}

add_filter('frm_get_default_value', 'my_custom_default_value', 10, 2);
function my_custom_default_value($new_value, $field){
    $uidFieldKey = 'suid'.$field->form_id;
    if($field->field_key == $uidFieldKey){ //change 25 to the ID of the field
      if(isset($_COOKIE['feedback_user'])) {
        $new_value = $_COOKIE['feedback_user']; //$_SERVER["HTTP_REFERER"];
      }
    }
    //set user id fields
if($field->id == 116 || $field->id == 249 || $field->id == 251){
    if(isset($_COOKIE['feedback_uid'])) {
     $new_value = $_COOKIE['feedback_uid'];
  }
}

    return $new_value;
}