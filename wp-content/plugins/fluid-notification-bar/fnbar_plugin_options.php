<?php

/* --------------------------------------------------------------------------------------------------------------------*/
/*  Setting page for plugin */
class fn_notibar_options_class{
    public $fn_notification_text;
    public function __construct()
    {
        $this->fn_notification_text=get_option('fn_notibar_options');
        $this->register_settings_and_fields();
    }
    
    public function add_menu_page()
    {
        add_options_page('Fluid Notification Bar Options', 'Fluid Notification Bar Options', 'administrator', __FILE__, array('fn_notibar_options_class','display_options_page'));
    }
    
    public function display_options_page()
    {
        ?>
        <div class="wrap">
        <?php screen_icon();?>
        <h2>Fluid Notification Bar Options</h2>
        <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('fn_notibar_options'); //settings group name?> 
        <?php do_settings_sections(__FILE__); //file?> 
        
		<p>You can also add link along with your message, use &lt;a href=&quot;http://example.com&quot;&gt;example link&lt;/a&gt; HTML code to add link</p>
		
        <p class="submit">
        <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
        
        </p>
        
        </form>
        </div>
        
         <?php
    }
    
    public function register_settings_and_fields()
    {
        register_setting('fn_notibar_options', 'fn_notibar_options'); // group, name
        add_settings_section('fn_notibar_main_section', 'Main Settings', array($this,'fn_notibar_main_section_cb'), __FILE__);//$id, $title, $callback, $page
        add_settings_field('fn_notibar_text','Notification Bar Text : ', array($this, 'fn_notibar_text_settings'), __FILE__, 'fn_notibar_main_section' ); // $id, $title, $callback, $page, $section, $args 
    }
    
     //add_settings_section callback (optional)
    public function fn_notibar_main_section_cb()
    {
        //optional
    }
    
    
    
    /*
    *   INPUTS
    */
    
    //Notification Bar Text 
    public function fn_notibar_text_settings()
    {
        echo "<input name='fn_notibar_options[fn_notibar_text]' type='text' value='{$this->fn_notification_text['fn_notibar_text']}' size='80' />";
    }
    
   
}


add_action('admin_menu', 'addtomenupage');

function addtomenupage()
{
    fn_notibar_options_class::add_menu_page(); //we could have used clouser (anonymous function) but it wont run in older version (5.2) anonymous function needs php 5.3 on server
}

add_action('admin_init', 'myadmininit');

function myadmininit() //we could have used clouser (anonymous function) but it wont run in older version (5.2) anonymous function needs php 5.3 on server
{
    new fn_notibar_options_class();
}


?>