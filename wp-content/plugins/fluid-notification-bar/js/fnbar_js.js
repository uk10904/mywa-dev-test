jQuery(document).ready(function(){
    //As our notification bar is responsive, it should be margined properly in any resolution

    var toolbarheight=jQuery("#fluid_notification_bar_wrapper").height();
	jQuery("#fluid_notification_bar").css({"display":"none"});
    jQuery("#fluid_notification_bar_wrapper").css({"margin-top":-toolbarheight});

    var barclosingspeed = 300;

    //close button
    jQuery("#hide_fluid_notification_bar").bind("click", function(){
        var mytoolbarheight=jQuery("#fluid_notification_bar_wrapper").height();
        jQuery("#fluid_notification_bar_wrapper").animate({"margin-top": -mytoolbarheight}, barclosingspeed);
        jQuery("#fluid_notification_bar_wrapper").hide(0);

        //Support for Bootstrap's fixed navigation (navbar-fixed-top)
        if(jQuery(".navbar-fixed-top").length)
        {
            jQuery(".navbar-fixed-top").animate({"margin-top": 0}, barclosingspeed);
            jQuery("body").animate({"margin-top": 0}, barclosingspeed);
        }

    });



});
