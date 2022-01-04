// window.addEventListener("beforeunload", function (e) {
//   var confirmationMessage = 'Are you sure!. ';

//   (e || window.event).returnValue = confirmationMessage;
//   return confirmationMessage;
// });
jQuery(document).ready(function() {
	  jQuery("#select-all").click(function() {
		var select_class = document.getElementsByClassName('auto-checked');
		var select_length= select_class.length;
		for(var x=0; x<select_length; x++){
			select_class[x].checked =false;
    }
    jQuery(".auto-checked").toggleClass("unselect");  
	});
	jQuery("#select-all").click(function() {
	   var unselect_class = document.getElementsByClassName('unselect');
	   var unselect_length = unselect_class.length;
		for(var x=0; x<unselect_length; x++){
			unselect_class[x].checked =true;
    }
    
	});
});
jQuery(document).ready(function() {
	  jQuery("#select-all-one").click(function() {
		var select_class = document.getElementsByClassName('auto-checked');
		var select_length= select_class.length;
		for(var x=0; x<select_length; x++){
			select_class[x].checked =false;
		}
		jQuery(".auto-checked").toggleClass("unselect");
	});
	jQuery("#select-all-one").click(function() {
	   var unselect_class = document.getElementsByClassName('unselect');
	   var unselect_length = unselect_class.length;
		for(var x=0; x<unselect_length; x++){
			unselect_class[x].checked =true;
		}
	});
});

jQuery(document).ready(function () {
  // $(".external").click(function(event) {
  //   alert("You are leaving the site");
  // });
  jQuery(".header-right-search").click(function () {
    jQuery(".block-views-exposed-filter-blocksearch-content-page-1").toggle();
    jQuery("body").toggleClass("search-open");
    return false;
  });

  jQuery(".search-block-form .form-search").attr(
    "placeholder",
    "Enter your seach criteria"
  );

  jQuery("#block-language").click(function () {
    jQuery("#block-languageswitcher").toggle();
  });

  jQuery(".video-play-button-text .video-play-button").click(function () {
    // var click = $(this).data('clicked', true);
    // console.log(click,'outside');
    jQuery(".patients-comes-first-video").toggle();
    jQuery(".video-play-button-text span.video-play-button").toggleClass("play-bg");

    // if (click.length == 1) {
    //   console.log(click,'odd');
    //   click.length+=1;
    //   jQuery(".video-play-button-text span.video-play-button").css({'background':'url("/themes/custom/alnylam/images/buttons-circle-close.png")','background-size':'cover'});
    // }else{
    //   jQuery(".video-play-button-text span.video-play-button").css({'background':'url("/themes/custom/alnylam/images/play-button.png")','background-size':'cover'});
    // };
  });
});

jQuery(document).ready(function () {
  jQuery(".whole-title-image-link-area .title-image-link").click(function () {
    jQuery(".whole-title-image-link-area .title-image-link").removeClass(
      "active"
    );
    jQuery(this).addClass("active");
    //$(".bottom-content").togleClass('active');
  });
});

jQuery(document).ready(function () {
  jQuery("#accordion-column-feilds .inner-block-2 div.expand-accordion img").click(
    function () {
      jQuery(this).parents('.field--item').toggleClass("accordion-content-show");
    }
  );
});

jQuery(document).ready(function () {
  jQuery(".advocacy-img-grid-btn").click(
    function () {
      jQuery("#image-desc-fields desc").toggleClass("show-desc");
      // jQuery("img.advocacy-img-grid-btn").attr("src","/themes/custom/alnylam/images/advocacy-close.png");
    }
  );
  jQuery(".clp-header-right-top #language-switcher-icon").click(
    function () {
      jQuery(".clp-language-switcher-block-wrapper").toggle();
    });
  // jQuery(".region.region-clp-header-right-bottom").click(
  //   function(){
  //     jQuery(".region.region-clp-header-right-bottom .popup-content").toggle();
  //   }
  // )
  jQuery("#clp-whole-mobile-header .language-block").click(function(){
      jQuery("#clp-whole-mobile-header .language-block-switcher").toggle();
  });
  
});

jQuery(document).ready(function() {
  jQuery(".advocacy-open-btn").click(function () {
      jQuery(this).parents(".image-desc-fields").addClass("active");
    });
  jQuery(".advocacy-close-btn").click(function () {
    jQuery(this).parents(".image-desc-fields").removeClass("active");
  });
  jQuery("#edit-interested-international- .panel-body .control-label::before").click(function () {
    jQuery("#edit-interested-international- .panel-body .checkbox label").toggleClass("active-checkbox");
  });
});

jQuery(document).ready(function() {
jQuery('#edit-medical-professional-medical-professional').change(function() {

if(this.checked == true) {
      console.log(this.checked,"Medical Professional");
      jQuery("div#edit-medical-professional .form-type-radio:first-child label").css("background-color","#FF9900");
      jQuery("div#edit-medical-professional .form-type-radio:nth-child(2) label").css("background-color","#0099CC");
  }
});

jQuery('#edit-medical-professional-other').change(function() {
  if(this.checked == true) {
      console.log(this.checked,"Other");
     jQuery("div#edit-medical-professional .form-type-radio:nth-child(2) label").css("background-color","#FF9900");
     jQuery("div#edit-medical-professional .form-type-radio:first-child label").css("background-color","#0099CC");
  }
});

jQuery('#edit-patient-patient').change(function() {
  if(this.checked == true) {
      console.log(this.checked,"US patient change");
     jQuery("#edit-patient--wrapper #edit-patient .radio:first-child label").css("background-color","#FF9900");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(2) label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(3) label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(4) label").css("background-color","#0099CC");
  }
});

jQuery('#edit-patient-caregiver').change(function() {
  if(this.checked == true) {
      console.log(this.checked,"US caregiver");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(2) label").css("background-color","#FF9900");
     jQuery("#edit-patient--wrapper #edit-patient .radio:first-child label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(3) label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(4) label").css("background-color","#0099CC");
  }
});

jQuery('#edit-patient-medical-professional').change(function() {
  if(this.checked == true) {
      console.log(this.checked,"US medical Professional");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(3) label").css("background-color","#FF9900");
     jQuery("#edit-patient--wrapper #edit-patient .radio:first-child label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(2) label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(4) label").css("background-color","#0099CC");
  }
});
jQuery('#edit-patient-other').change(function() {
  if(this.checked == true) {
      console.log(this.checked,"US Other Patient");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(4) label").css("background-color","#FF9900");
     jQuery("#edit-patient--wrapper #edit-patient .radio:first-child label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(2) label").css("background-color","#0099CC");
     jQuery("#edit-patient--wrapper #edit-patient .radio:nth-child(3) label").css("background-color","#0099CC");
  }
});
});




$("#edit-sort-order--3").change(function() {
  this.form.submit();
});