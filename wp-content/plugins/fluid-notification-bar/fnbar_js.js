jQuery(document).ready(function(){
    <!--As our notification bar is responsive, it should be margined properly in any resolution-->
    
    $toolbarheight=jQuery("#toolbar_holder").height();
    jQuery("#toolbar_holder").css({"margin-top":-$toolbarheight-10});
    jQuery("#hidetoolbar").css({"visibility":"hidden"});
    
    <!--Show notification after 5 second-->
    jQuery("#toolbar_holder").delay(5000).show(0);
	jQuery("#toolbar_holder").css({"display":"block"});
    jQuery("#hidetoolbar").css({"visibility":"visible"});
    jQuery("#toolbar_holder").animate({"margin-top": "0px"},1000);
    
    
    <!--close button-->
    jQuery("#hidetoolbar").bind("click", function(){
    $mytoolbarheight=jQuery("#toolbar_holder").height();
    jQuery("#toolbar_holder").animate({"margin-top": -$mytoolbarheight-10},1000);
    jQuery("#toolbar_holder").hide(0);
    });
});