<?php
class fn_notibar_options {

    //Holds the values to be used in the fields callbacks
    private $options;

    public function __construct(){

        add_action("admin_menu", array($this,"add_plugin_menu_fnbar"));
        add_action("admin_init", array($this,"page_init_fnbar"));

        add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));
        //add_action('admin_enqueue_styles', array($this, 'register_admin_styles'));
    }

    public function add_plugin_menu_fnbar (){

        add_options_page( "Fluid Notification Bar", //page_title
                         "Fluid Notification Bar", //menu_title
                         "administrator", //capability
                         "fluid-notification-bar-settings", //menu_slug
                         array($this, "create_admin_page_fnbar")); //callback function

    }

    public function register_admin_scripts(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'Fnbar_admin', plugins_url('js/fnbar_admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
        wp_enqueue_style( 'custom-admin-style', plugins_url('css/admin-style.css', __FILE__));
    }

    public function create_admin_page_fnbar (){

        $this->options = get_option ( 'fluid_notification_bar_settings' );

        ?>
            <div class="wrap">

                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">


                        <div id="post-body-content">
                            <div class="meta-box-sortables ui-sortable">
                                <div class="postbox">
                                    <h3><span class="dashicons dashicons-admin-generic"></span>Fluid Notification Bar Settings</h3>
                                    <div class="inside">
                                        <form method="post" action="options.php">
                                            <?php
                                            // This prints out all hidden setting fields
                                            settings_fields( 'fluid_notification_bar_settings_group' ); //option group
                                            do_settings_sections( 'fluid-notification-bar-settings' ); //settings page slug
                                            submit_button(); ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!--post-body-content-->


                        <!-- sidebar -->
                        <div id="postbox-container-1" class="postbox-container">
                            <div class="meta-box-sortables">
                                <div class="postbox">
                                    <h3><span>About</span></h3>
                                    <div class="inside">
                                        Author: Shrinivas Naik <br>
                                        Plugin Homepage: <a href="http://www.techsini.com" target="_blank">Techsini.com</a> <br>
                                        Thank you for installing this plugin.
                                    </div> <!-- .inside -->
                                </div> <!-- .postbox -->

                                <div class="postbox">
                                    <h3><span>Losing your Adsense Revenue?</span></h3>
                                    <div class="inside" style="background-color:#ffffb9">
                                        <p>
                                            Are you losing your AdSense revenue with Ad-blocker browser plugin? Try our all new Simple Adblock Notice PRO wordpress plugin to tackle the Ad-blocker.
                                        </p>
                                        <a href="http://techsini.com/our-wordpress-plugins/simple-adblock-notice/" target="_blank"><button type="button" class="button button-primary">Get Simple Adblock Notice PRO Now</button></a><br>
                                    </div>
                                </div>

                                <div class="postbox">
                                    <h3><span>Rate This Plugin!</span></h3>
                                    <div class="inside">
                                      <p>Please <a href="https://wordpress.org/plugins/fluid-notification-bar/" target="_blank">rate this plugin</a> and share it to help the development.</p>

                                      <ul class="soc">
                                        <li><a class="soc-facebook" href="https://www.facebook.com/techsini" target="_blank"></a></li>
                                        <li><a class="soc-twitter" href="https://twitter.com/techsini" target="_blank"></a></li>
                                        <li><a class="soc-google soc-icon-last" href="https://plus.google.com/+Techsini" target="_blank"></a></li>
                                      </ul>

                                    </div> <!-- .inside -->
                                </div> <!-- .postbox -->

                                <div class="postbox">
                                    <h3><span>Our other WordPress Plugins</span></h3>
                                    <div class="inside">
                                      <ul>
                                      <li><a href="http://techsini.com/our-wordpress-plugins/simple-adblock-notice/">Simple Adblock Notice</a></li>
                                      <li><a href="http://techsini.com/our-wordpress-plugins/elegant-subscription-popup/">Elegant Subscription Popup</a></li>
                                      <li><a href="http://masterblogster.com/plugins/disable-right-click/">Disable Right Click</a></li>
                                      </ul>
                                    </div> <!-- .inside -->
                                </div> <!-- .postbox -->

                            </div> <!-- .meta-box-sortables -->
                        </div> <!-- #postbox-container-1 .postbox-container -->


                    </div>
                </div>
            </div>
        <?php

    }

    public function page_init_fnbar(){

        register_setting(
        'fluid_notification_bar_settings_group', // Option group
        'fluid_notification_bar_settings' // Option name
        );

        add_settings_section(
            'section1', // ID
            '', // Title
            array( $this, 'section_1_callback' ), // Callback
            'fluid-notification-bar-settings' // Page
        );

        add_settings_field(
            'general_settings', // ID
            '<span class="dashicons dashicons-welcome-write-blog"></span> General Settings', // Title
            array( $this, 'general_settings_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_enabled', // ID
            'Show Notification Bar', // Title
            array( $this, 'fnbar_enabled_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_text', // ID
            'Notification Bar Text', // Title
            array( $this, 'fnbar_text_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_link_text', // ID
            'Notification Bar Link Title (Button Caption)', // Title
            array( $this, 'fnbar_link_text_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_link', // ID
            'Notification Bar Link (Button URL)', // Title
            array( $this, 'fnbar_link_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'socialmedia_settings', // ID
            '<span class="dashicons dashicons-share"></span> <abbr title="Leave the links empty if you do not want to show the respective social media icons">Social Media Settings</abbr>', // Title
            array( $this, 'socialmedia_settings_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'googleplus_link', // ID
            'Google+ Link', // Title
            array( $this, 'googleplus_link_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'facebook_link', // ID
            'Facebook Link', // Title
            array( $this, 'facebook_link_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'twitter_link', // ID
            'Twitter Link', // Title
            array( $this, 'twitter_link_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'pinterest_link', // ID
            'Pinterest Link', // Title
            array( $this, 'pinterest_link_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'linkedin_link', // ID
            'Linkedin Link', // Title
            array( $this, 'linkedin_link_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'customization_settings', // ID
            '<span class="dashicons dashicons-admin-appearance"></span> Customization Settings', // Title
            array( $this, 'customization_settings_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_fontsize', // ID
            'Font Size', // Title
            array( $this, 'fnbar_fontsize_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_textcolor', // ID
            'Text Color', // Title
            array( $this, 'fnbar_textcolor_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_bgcolor', // ID
            'Background Color', // Title
            array( $this, 'fnbar_bgcolor_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_animation', // ID
            'Text Animation', // Title
            array( $this, 'fnbar_animation_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_delay', // ID
            'Notification Bar Delay', // Title
            array( $this, 'fnbar_delay_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

        add_settings_field(
            'fnbar_interval', // ID
            'Do not Disturb for (interval)', // Title
            array( $this, 'fnbar_interval_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section
        );

    }

    public function section_1_callback(){

    }

    public function general_settings_callback(){

    }

    public function fnbar_enabled_callback(){
        if(isset($this->options['fnbar_enabled'])){
            $fnbarenabled = $this->options['fnbar_enabled'];
        } else {
            $fnbarenabled = 0;
        }

        printf ('<label for="fnbar_enabled">
                <input type = "checkbox"
                    id = "fnbar_enabled"
                    name= "fluid_notification_bar_settings[fnbar_enabled]"
                    value = "1"' . checked(1, $fnbarenabled, false) . '/>'.
                ' Yes</label>');

    }

    public function fnbar_text_callback(){
        printf('<input type="text" class="large-text" id="fnbar_text" name="fluid_notification_bar_settings[fnbar_text]" value="%s" />',  isset( $this->options['fnbar_text'] ) ? esc_attr( $this->options['fnbar_text']) : '');
    }

    public function fnbar_link_text_callback(){
        printf('<input type="text" id="fnbar_link_text" name="fluid_notification_bar_settings[fnbar_link_text]" value="%s" />',  isset( $this->options['fnbar_link_text'] ) ? esc_attr( $this->options['fnbar_link_text']) : '');
    }

    public function fnbar_link_callback(){
        printf('<input type="text" id="fnbar_link" name="fluid_notification_bar_settings[fnbar_link]" value="%s" /> example:www.example.com',  isset( $this->options['fnbar_link'] ) ? esc_attr( $this->options['fnbar_link']) : '');
    }

    public function socialmedia_settings_callback(){

    }

    public function googleplus_link_callback(){
        printf('<input type="text" id="googleplus_link" name="fluid_notification_bar_settings[googleplus_link]" value="%s" />',  isset( $this->options['googleplus_link'] ) ? esc_attr( $this->options['googleplus_link']) : '');
    }

    public function facebook_link_callback(){
        printf('<input type="text" id="facebook_link" name="fluid_notification_bar_settings[facebook_link]" value="%s" />',  isset( $this->options['facebook_link'] ) ? esc_attr( $this->options['facebook_link']) : '');
    }

    public function twitter_link_callback(){
        printf('<input type="text" id="twitter_link" name="fluid_notification_bar_settings[twitter_link]" value="%s" />',  isset( $this->options['twitter_link'] ) ? esc_attr( $this->options['twitter_link']) : '');
    }

    public function pinterest_link_callback(){
        printf('<input type="text" id="pinterest_link" name="fluid_notification_bar_settings[pinterest_link]" value="%s" />',  isset( $this->options['pinterest_link'] ) ? esc_attr( $this->options['pinterest_link']) : '');
    }

    public function linkedin_link_callback(){
        printf('<input type="text" id="linkedin_link" name="fluid_notification_bar_settings[linkedin_link]" value="%s" />',  isset( $this->options['linkedin_link'] ) ? esc_attr( $this->options['linkedin_link']) : '');
    }

    public function customization_settings_callback(){

    }

    public function fnbar_fontsize_callback(){
        printf('<input type="text" class="small-text" id="fnbar_fontsize" name="fluid_notification_bar_settings[fnbar_fontsize]" value="%s" /> px',  isset( $this->options['fnbar_fontsize'] ) ? esc_attr( $this->options['fnbar_fontsize']) : '');
    }

    public function fnbar_textcolor_callback(){
        printf('<input id="fnbar_textcolor" name="fluid_notification_bar_settings[fnbar_textcolor]" type="text" value="%s" />',  isset( $this->options['fnbar_textcolor'] ) ? esc_attr( $this->options['fnbar_textcolor']) : '');
    }

    public function fnbar_bgcolor_callback(){
        printf('<input id="fnbar_bgcolor" name="fluid_notification_bar_settings[fnbar_bgcolor]" type="text" value="%s" />',  isset( $this->options['fnbar_bgcolor'] ) ? esc_attr( $this->options['fnbar_bgcolor']) : '');
    }

    public function fnbar_animation_callback(){

        if(isset($this->options['fnbar_animation'])){
            $textanimation = $this->options['fnbar_animation'];
        } else {
            $textanimation = "flash";
        }
        echo ('<select id="fnbar_animation" name="fluid_notification_bar_settings[fnbar_animation]">
                    <option value="flash" ' . selected($textanimation, "flash", false) .' >flash</option>
                    <option value="bounce" ' . selected($textanimation, "bounce", false) .'>bounce</option>
                    <option value="shake" ' . selected($textanimation, "shake", false) .'>shake</option>
                    <option value="tada" ' . selected($textanimation, "tada", false) .'>tada</option>
                    <option value="swing" ' . selected($textanimation, "swing", false) .'>swing</option>
                    <option value="wobble" ' . selected($textanimation, "wobble", false) .'>wobble</option>
                    <option value="pulse" ' . selected($textanimation, "pulse", false) .'>pulse</option>
                    <option value="flip" ' . selected($textanimation, "flip", false) .'>flip</option>
                    <option value="flipInX" ' . selected($textanimation, "flipInX", false) .'>flipInX</option>
                    <option value="flipInY" ' . selected($textanimation, "flipInY", false) .'>flipInY</option>
                    <option value="fadeIn" ' . selected($textanimation, "fadeIn", false) .'>fadeIn</option>
                    <option value="fadeInUp" ' . selected($textanimation, "fadeInUp", false) .'>fadeInUp</option>
                    <option value="fadeInDown" ' . selected($textanimation, "fadeInDown", false) .'>fadeInDown</option>
                    <option value="fadeInLeft" ' . selected($textanimation, "fadeInLeft", false) .'>fadeInLeft</option>
                    <option value="fadeInRight" ' . selected($textanimation, "fadeInRight", false) .'>fadeInRight</option>
                    <option value="fadeInUpBig" ' . selected($textanimation, "fadeInUpBig", false) .'>fadeInUpBig</option>
                    <option value="fadeInDownBig" ' . selected($textanimation, "fadeInDownBig", false) .'>fadeInDownBig</option>
                    <option value="fadeInLeftBig" ' . selected($textanimation, "fadeInLeftBig", false) .'>fadeInLeftBig</option>
                    <option value="fadeInRightBig" ' . selected($textanimation, "fadeInRightBig", false) .'>fadeInRightBig</option>
                    <option value="bounceIn" ' . selected($textanimation, "bounceIn", false) .'>bounceIn</option>
                    <option value="bounceInDown" ' . selected($textanimation, "bounceInDown", false) .'>bounceInDown</option>
                    <option value="bounceInUp" ' . selected($textanimation, "bounceInUp", false) .'>bounceInUp</option>
                    <option value="bounceInLeft" ' . selected($textanimation, "bounceInLeft", false) .'>bounceInLeft</option>
                    <option value="bounceInRight" ' . selected($textanimation, "bounceInRight", false) .'>bounceInRight</option>
                    <option value="rotateIn" ' . selected($textanimation, "rotateIn", false) .'>rotateIn</option>
                    <option value="rotateInDownLeft" ' . selected($textanimation, "rotateInDownLeft", false) .'>rotateInDownLeft</option>
                    <option value="rotateInDownRight" ' . selected($textanimation, "rotateInDownRight", false) .'>rotateInDownRight</option>
                    <option value="rotateInUpLeft" ' . selected($textanimation, "rotateInUpLeft", false) .'>rotateInUpLeft</option>
                    <option value="rotateInUpRight" ' . selected($textanimation, "rotateInUpRight", false) .'>rotateInUpRight</option>
                    <option value="rollIn" ' . selected($textanimation, "rollIn", false) .'>rollIn</option>
                </select>'
            );
    }

    public function fnbar_delay_callback(){

        $fnbardelay = isset( $this->options['fnbar_delay'] ) ? esc_attr( $this->options['fnbar_delay']) : '2';

        echo ('<select id="fnbar_delay" name="fluid_notification_bar_settings[fnbar_delay]">' .
                '<option value="2" ' . selected($fnbardelay, "2", false) . '>2</option>' .
                '<option value="5" ' . selected($fnbardelay, "5", false) . '>5</option>' .
                '<option value="10" ' . selected($fnbardelay, "10", false) . '>10</option>' .
                '<option value="20" ' . selected($fnbardelay, "20", false) . '>20</option>' .
                '<option value="30" ' . selected($fnbardelay, "30", false) . '>30</option>' .
                '<option value="40" ' . selected($fnbardelay, "40", false) . '>40</option>' .
                '<option value="50" ' . selected($fnbardelay, "50", false) . '>50</option>' .
                '<option value="60" ' . selected($fnbardelay, "60", false) . '>60</option>' .
                '</select> seconds'
            );
    }

    public function fnbar_interval_callback(){

        if(isset($this->options['fnbar_interval'])){
            $fnbarinterval = $this->options['fnbar_interval'];
        } else {
            $fnbarinterval = "5";
        }

        echo ('<select id="fnbar_interval" name="fluid_notification_bar_settings[fnbar_interval]">' .
                '<option value="5" ' . selected($fnbarinterval, "5", false) . '>5</option>' .
                '<option value="10" ' . selected($fnbarinterval, "10", false) . '>10</option>' .
                '<option value="20" ' . selected($fnbarinterval, "20", false) . '>20</option>' .
                '<option value="40" ' . selected($fnbarinterval, "40", false) . '>40</option>' .
                '<option value="60" ' . selected($fnbarinterval, "60", false) . '>60</option>' .
                '</select> Minutes'
            );
    }

}

?>
