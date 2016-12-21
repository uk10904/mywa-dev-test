


//after form submit callback
function frmThemeOverride_frmAfterSubmit(formReturned, pageOrder, errObj, object){
    
 $form = jQuery(object);
 // setFeedbackSubmitted(jQuery($form).find('[name="form_id"]').val());
 // enableFeedback();

 var feedbackUser = jQuery($form).find('[type="email"]').val();
 if(!Cookies.get('feedback_user') && feedbackUser) {
     Cookies.set('feedback_user', 'true', { expires: 1000 });
 }
}


jQuery(function($) {


    UIkit.domObserve('body', function(element) {
      // jQuery('.uk-fade-in').addClass('uk-show');
      

      
    });

jQuery('[data-uk-grid]').on('beforeupdate.uk.grid', function(e, children) {
        jQuery(this).css({'opacity' : '1'});
    });
 
 $spnav = UIkit.scrollspynav(".scrollnav", {smoothscroll:{offset:197}, closest:'li'}); 

jQuery(['data-uk-scrollspy-nav']).on('init.uk.scrollspy', function(){
  
});
jQuery('[data-uk-scrollspy-nav]').on('inview.uk.scrollspy', function(e){

});
 
jQuery(['data-uk-scrollspy']).on('init.uk.scrollspy', function(){

});


$('.section-info-title').toggle( function() {
    $('.section-intro .section-info.active').addClass('reveal'); 
    $('.tm-header').addClass('bg-color');},
    function() {
        $('.section-intro .section-info').removeClass('reveal');
        $('.tm-header').removeClass('bg-color');
});
jQuery('[data-uk-scrollspy]').on('inview.uk.scrollspy', function(e){
    $('.section-intro .section-info').removeClass('active').hide();
    var id = e.target.id;
    if(id.indexOf('out') !== -1) {
        $('.section-intro .section-info').removeClass('active').hide();
    }
    switch(id) {
        case 's0':
       
        break;
        case 's1':
        $('#s1-info').addClass('active').fadeIn();
        break;
        case 's2':
        $('#s2-info').addClass('active').fadeIn();
        break;
        case 's3':
        $('#s3-info').addClass('active').fadeIn();
        break;
        case 's4':
        $('#s4-info').addClass('active').fadeIn();
        break;
        case 's5':
        $('#s5-info').addClass('active').fadeIn();
        break;
    }
});





jQuery(window).scroll(function() {
  if (jQuery(document).scrollTop() > 50) {
    jQuery('.tm-header').addClass('shrink');
     jQuery('.userPhoto').fadeOut();
  } else {
    jQuery('.tm-header').removeClass('shrink');
     jQuery('.userPhoto').fadeIn();
  }
});


function showAboutModal() {
   var modal = UIkit.modal("#feedback-signup", {'center':true});
   UIkit.offcanvas.hide([force  = false]);
   modal.show();
}

/*add 'All Services' link to search result, remove flash of results when changing search bar to All of Government, keep search terms between search inputs*/
var aogSearch = false;

jQuery('body').on('click', 'a.search-aog', function() {
    aogSearch = true;
    if(!jQuery(this).parent().hasClass('uk-active')) {
    jQuery('input.gsc-input').val(jQuery('.orig').val()).focus();
    $('.gsc-search-button').click();
    }
});

jQuery('.uk-subnav-pill .search-services').on('click', function() {
    aogSearch = false;
    if(!jQuery(this).parent().hasClass('uk-active')) {
     jQuery('.orig').val(jQuery('input.gsc-input').val()).focus();
     $('.innericon').click();
    }
});

jQuery( document ).ajaxComplete(function( event, xhr, settings ) {
    jQuery('.all-services').show();
       jQuery('#ajaxsearchprores2_1').css({'margin-top' : '0'});
   if(aogSearch) {
       jQuery('#ajaxsearchprores2_1').css({'margin-top' : '-10000px'});
       jQuery('#ajaxsearchprores2_1').removeClass('asp_an_fadeInDrop').addClass('asp_an_fadeOutDrop');
   }
   if(jQuery.find('.all-services').length == 0) {
      jQuery('#ajaxsearchprores2_1').prepend('<div class="all-services"><a href="/all-services">myWA Alpha services list</a></div>');
     
   }
   if(jQuery.find('.asp_nores_header').length >= 1) {
       jQuery('.all-services').hide();
       jQuery('.asp_nores_header').html('We\'re still in development and don\'t have matching services listed yet. Please try searching <a class="no-res-search-aog">all of government</a> or <a href="/all-services">view the myWA Alpha services list</a>. <br />');
       jQuery('.no-res-search-aog').on('click',  function() {
    jQuery('a.search-aog').click();
});
   }
});

/* ///FORM FUNCTIONS/// */
$('#element-feedback-form').on('click','input[type="checkbox"]',function() {
      if(jQuery('div[id^="frm_checkbox_268"] input[type="checkbox"]:checked').length > limit) {
       this.checked = false;
   }
  else {
        $(this).closest('label').toggleClass('checked');
    }
});
$('#element-feedback-form').on('click','input[type="radio"]',function() {
    $(this).closest('.frm_opt_container').find('label').removeClass('checked');
    $(this).closest('label').addClass('checked');
});

jQuery('.proinput form').prepend('<span class="typed"></span>');
		var typed = jQuery(".typed").typed({
			strings: ["Find a health service", "Check driver licence details", "Pay for your car registration","Watch live coastal cameras", "Apply for a National Police Certificate"],
			typeSpeed: 60,
            loop: true
		});

jQuery('.orig, .typed, .proinput').click(function() {
  jQuery(".typed, .typed-cursor").hide();
  jQuery('.orig').focus();
});

var elemFeedbackModal = UIkit.modal('#element-feedback-form', {'center':true});

 $('body').on('click', '.feedback-modal', function() {
        var elemFeedbackModal = UIkit.modal('#element-feedback-form', {'center':true});
   $('#element-feedback-form .modal-inner').html('<div style="text-align:center; padding:50px 0 60px;"><i class="uk-icon-spinner uk-icon-spin" style="font-size:60px; color:#999;"></i></div>');
   elemFeedbackModal.show();
		var form_id = $(this).attr('data-formid');
		$.ajax({
			type:'POST',url:frm_js.ajax_url,dataType:'html',
			data:{action:'frm_entries_edit_entry_ajax', id:form_id, entry_id:0, nonce:frm_js.nonce},
			success:function(html){
				$('#element-feedback-form .modal-inner').html(html);
               // alert(jQuery(html).find('.browser').css({'display' : 'block' }));
                   //$('#element-feedback-form .modal-inner').find('.browser').val(browserName);
                   //alert($('#element-feedback-form .modal-inner').find('.browser').val());
                    jQuery('.browser').val(browserName);
                    jQuery('.browserFull').val(fullVersion);
                    jQuery('.browserMajor').val(majorVersion);
                    jQuery('.browserUserAgent').val(navigator.userAgent);
                    jQuery('.screenSize').val(window.screen.height + ' x ' + window.screen.width);
                    if(Cookies.get('feedback_uid')) {
                       // var uid = JSON.parse(Cookies.get('feedback_uid'));
                      //  jQuery('.userIP').val(uid.ip);
                      //  jQuery('.userID').val(uid.id);
                     
                    }
                    
				if (typeof __frmHideOrShowFields !== 'undefined') {
					frmFrontForm.hideOrShowFields( __frmHideOrShowFields, 'editInPlace' );
				}
				if (typeof __frmDepDynamicFields !== 'undefined') {
					frmFrontForm.checkDependentDynamicFields(__frmDepDynamicFields);
				}
			},
		});
		return false;
	});

/*  ////   */




/* GET USER BROWSER DETAILS */
var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix;

// In Opera, the true version is after "Opera" or after "Version"
if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In MSIE, the true version is after "MSIE" in userAgent
else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
 browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
// In Chrome, the true version is after "Chrome" 
else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Safari, the true version is after "Safari" or after "Version" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}
// In most other browsers, "name/version" is at the end of userAgent 
else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < (verOffset=nAgt.lastIndexOf('/')) ) 
{
 browserName = nAgt.substring(nameOffset,verOffset);
 fullVersion = nAgt.substring(verOffset+1);
 if (browserName.toLowerCase()==browserName.toUpperCase()) {
  browserName = navigator.appName;
 }
}
// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1)
   fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1)
   fullVersion=fullVersion.substring(0,ix);

majorVersion = parseInt(''+fullVersion,10);
if (isNaN(majorVersion)) {
 fullVersion  = ''+parseFloat(navigator.appVersion); 
 majorVersion = parseInt(navigator.appVersion,10);
}

});





