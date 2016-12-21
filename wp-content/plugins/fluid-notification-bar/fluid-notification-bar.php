<?php

/*
Plugin Name: Fluid Notification Bar
Plugin URI: http://techsini.com/our-wordpress-plugins/fluid-notification-bar/
Description: Wanna say something to your website visitor? This plugin adds the cool responsive notification bar on the top of your website homepage.
Author: Shrinivas Naik
Version: 3.2.3
Author URI: http://techsini.com
*/

/*
Copyright (C) 2016 Shrinivas Naik

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/.

*/

if(!class_exists('fluid_notification_bar') && !class_exists('Fn_notibar_options')){

    class fluid_notification_bar{

        private $options;

        public function __construct(){

            //Activate the plugin for first time
            register_activation_hook(__FILE__, array($this, "activate"));

            //Load scipts and styles
            add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
            add_action('wp_enqueue_scripts', array($this, 'register_styles'));

            //Initialize settings page
            require_once(plugin_dir_path(__FILE__) . "fnbar_options.php");
            $fn_notibar_options = new fn_notibar_options;

            //Run the plugin in footer
            add_action('wp_head', array($this, 'run_plugin'));

            //Store options in a variable
            $this->options = get_option( 'fluid_notification_bar_settings' );

            //Set cookie as required
            add_action( 'init', array($this,'set_fluid_notificationbar_cookie'));

            //plugin action links
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'my_plugin_action_links'));
        }

        public function activate(){

            //Set default options for the plugin
            $initial_settings = array(
                'fnbar_enabled'     => '1',
                'fnbar_bgcolor'     => '#5accf5',
                'googleplus_link'   => '',
                'facebook_link'     => '',
                'twitter_link'      => '',
                'pinterest_link'    => '',
                'linkedin_link'     => '',
                'fnbar_textcolor'   => '#fff',
                'fnbar_fontsize'    => '12',
                'fnbar_animation'   => 'fadeInLeft',
                'fnbar_interval'    => '5',
                'fnbar_delay'       => '2'

                );
            add_option("fluid_notification_bar_settings", $initial_settings);

            //Show activation notice
            add_action('admin_notices', array($this,'show_activation_message'));
        }

        public function deactivate(){

        }

        public function register_scripts(){

             wp_enqueue_script('jquery');
             wp_enqueue_script('fnbar_js', plugins_url( 'js/fnbar_js.js' , __FILE__ ),array( 'jquery' ));
             wp_enqueue_script('jquery_lettering', plugins_url( 'js/jquery.lettering.js' , __FILE__ ),array( 'jquery' ));
             wp_enqueue_script('jquery_textillate', plugins_url( 'js/jquery.textillate.js' , __FILE__ ),array( 'jquery' ));
        }

        public function register_styles(){

             wp_enqueue_style( 'Fluid_notification_bar_css', plugins_url('css/fnbar_css.css', __FILE__));
             wp_enqueue_style( 'animate_css', plugins_url('css/animate.css', __FILE__));
        }

        public function run_plugin(){

            //Get notification bar settings
            if(isset($this->options["fnbar_enabled"])){
                $fn_notibar_enabled = $this->options["fnbar_enabled"];
            } else {
                $fn_notibar_enabled = 0;
            }

            //General Settings
            $fn_notibar_text = $this->options["fnbar_text"];
            $fn_notibar_link_title = $this->options["fnbar_link_text"];
            $fn_notibar_link = $this->options["fnbar_link"];

            //Social Media Settings
            $googleplus_link = isset($this->options["googleplus_link"]) ? $this->options["googleplus_link"] : '';
            $facebook_link = isset($this->options["facebook_link"]) ? $this->options["facebook_link"] : '';
            $twitter_link = isset($this->options["twitter_link"]) ? $this->options["twitter_link"] : '';
            $pinterest_link = isset($this->options["pinterest_link"]) ? $this->options["pinterest_link"] : '';
            $linkedin_link = isset($this->options["linkedin_link"]) ? $this->options["linkedin_link"] : '';

            //Customization Settings
            $fn_notibar_font_size = $this->options["fnbar_fontsize"];
            $fn_notibar_text_color = $this->options["fnbar_textcolor"];
            $fn_notibar_bg_color = $this->options["fnbar_bgcolor"];
            $fn_notibar_animation = $this->options["fnbar_animation"];
            $fn_notibar_delay = $this->options['fnbar_delay'];

            if($fn_notibar_enabled == 1 && $this->can_show_notibar() == TRUE){

                if($fn_notibar_text == ""){

                    $fn_notibar_text = 'Welcome to Fluid Notification Bar.. Go to Settings -> Fluid Notification Bar to add your notification.';
                }
                ?>

                <style>
                    #hide_fluid_notification_bar {
                        background-image:url(<?php echo plugins_url('images/close.png', __FILE__ )?>);
                        background-repeat: no-repeat;
                        background-position: center;
                    }
                </style>

                <script type="text/javascript">
                jQuery(document).ready(function(){
                    //Show notification after 5 second

                    var notibar_delay = <?php echo $fn_notibar_delay * 1000 ?>;

                    function shownotibar() {

                        barshowingspeed = 700;

                        /*jQuery("#fluid_notification_bar_wrapper").show();*/
                        jQuery("#fluid_notification_bar_wrapper").css({"display":"block"});
                        jQuery("#fluid_notification_bar").css({"display":"block"});

                        //Support for Bootstrap's fixed navigation (navbar-fixed-top)
                        if(jQuery(".navbar-fixed-top").length)
                        {
                            var notibarheight = jQuery("#fluid_notification_bar_wrapper").height();
                            jQuery(".navbar-fixed-top").animate({"margin-top": notibarheight}, barshowingspeed);
                            jQuery("body").animate({"margin-top": notibarheight}, barshowingspeed);

                        }

                        jQuery("#fluid_notification_bar_wrapper").animate({"margin-top": "0px"}, barshowingspeed, function(){
                            jQuery("#fluid_notification_bar").css({"visibility":"visible"});
                            jQuery('.fnbar_notification').textillate({
                                in: {
                                    effect: '<?php echo $fn_notibar_animation ?>',
                                    delayScale: 1.5,
                                    delay: 20,
                                    callback: function () {
                                        setTimeout(function(){
                                        jQuery("#fluid_notification_bar .soc li").each(function(i){
                                          jQuery(this).delay(300 * i).animate({
                                            opacity: 1,
                                            marginTop: "0px"
                                          }, 400 , "linear");

                                        });
                                        },1000);

                                        jQuery('.fnbar_link').animate(
                                            {
                                                "opacity": 1
                                            },0, function(){
                                                jQuery(this).addClass("bounceIn");
                                            });
                                    }
                                }


                          });
                        });
                    }

                    // use setTimeout() to execute
                    setTimeout(shownotibar, notibar_delay)


                });
                </script>

                <style type="text/css">

                    #fluid_notification_bar_wrapper{
                        background: <?php echo $fn_notibar_bg_color ?>;
                    }

                    #fluid_notification_bar{
                        font-size: <?php echo $fn_notibar_font_size?>px;
                        color: <?php echo $fn_notibar_text_color ?>;
                    }

                </style>

                <div id="fluid_notification_bar_wrapper">

                    <div id="fluid_notification_bar"><span class="fnbar_notification"><?php echo $fn_notibar_text; ?></span>
                    <?php if(!empty($fn_notibar_link_title) && !empty($fn_notibar_link)) { ?>
                        <span class="fnbar_link animated"><a href="<?php echo $fn_notibar_link; ?>"><?php echo $fn_notibar_link_title; ?></a></span>
                    <?php } ?>
                    <ul class="soc">
                        <?php if(!empty($googleplus_link)) {?>
                        <li><a class="soc-google" href="<?php echo $googleplus_link ?>"></a></li>
                        <?php } ?>
                        <?php if(!empty($facebook_link)) {?>
                        <li><a class="soc-facebook" href="<?php echo $facebook_link ?>"></a></li>
                        <?php } ?>
                        <?php if(!empty($twitter_link)) {?>
                        <li><a class="soc-twitter" href="<?php echo $twitter_link ?>"></a></li>
                        <?php } ?>
                        <?php if(!empty($pinterest_link)) {?>
                        <li><a class="soc-pinterest" href="<?php echo $pinterest_link ?>"></a></li>
                        <?php } ?>
                        <?php if(!empty($linkedin_link)) {?>
                        <li><a class="soc-linkedin soc-icon-last" href="<?php echo $linkedin_link ?>"></a></li>
                        <?php } ?>
                    </ul>
                    </div>
                    <div id="hide_fluid_notification_bar"></div>

                </div>

            <?php

            } //if notification is enabled

        }


        public function can_show_notibar(){

            $fn_notibar_link = $this->options["fnbar_link"];
            $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            /*Do not show
            -> if cookie is set
            -> current URL is same as action button link
            */
            if(!isset($_COOKIE['fluid_notificationbar_cookie']) && $fn_notibar_link!=$url ){

                //show the popup
                return true;

            } else {
                //Do not show the popup
                return false;
            }
        }

        public function set_fluid_notificationbar_cookie(){

            if(!isset($_COOKIE['fluid_notificationbar_cookie']) && ! is_admin()){
                $fn_notibar_interval = $this->options["fnbar_interval"];
                setcookie("fluid_notificationbar_cookie", "shown", time()+ (60 * $fn_notibar_interval) , COOKIEPATH, COOKIE_DOMAIN, false);
            }
        }

        function show_activation_message(){
          echo '<div class="updated"><p><b>Fluid Notification Bar</b> has been activated successfully. Head over to plugin <a href="'. esc_url( get_admin_url(null, 'options-general.php?page=fluid-notification-bar-settings') ) .'">Settings</a></p></div>';
        }

        function my_plugin_action_links( $links ) {
           $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=fluid-notification-bar-settings') ) .'">Settings</a>';
           $links[] = '<br><b><a href="http://techsini.com" target="_blank">Check Out More plugins >></a></b>';
           return $links;
        }



    }

}

$fluid_notification_bar = new fluid_notification_bar;


?>
