$(".select-btn").attr("data-type", "check");
    $(".select-btn").click(function () {
        if ($(".select-btn").attr("data-type") === "check") {
            $(".form-item-transthyretin-mediated-amyloidosis-attr-amyloidosis- .form-checkbox, .form-item-porphyria .form-checkbox, .form-item-central-nervous-system-neurodegenerative-diseases-examples-alzhe .form-checkbox, .form-item-complement-mediated-diseases-examples-atypical-hemolytic-uremic- .form-checkbox, .form-item-primary-hyperoxaluria-type-1 .form-checkbox, .form-item-acute-hepatic-porphyria .form-checkbox, .form-item-hypertension .form-checkbox").prop("checked", true);
            $(".select-btn").attr("data-type", "uncheck");
        } else {
            $(".form-checkbox").prop("checked", false);
            $(".select-btn").attr("data-type", "check");
        }
    })

jQuery(document).ready(function(){
	function windowSize() {
		var width = jQuery(window).width();
		if( width <= 767 ){
			jQuery(".paragraph--type--add-block .mobile-newsroom").insertAfter("ul.newsList");
			var sociallinks = jQuery('.footer-bottom-right-area #block-followus ul.footer-social-link-section').html();
			var mobilesociallinkblock = '<div class="mobile-sociallinks-block">'+sociallinks+'</div>';
			jQuery('.mobile-sociallinks-block').remove();
			jQuery('.mobile-header-menu .block-superfish > ul.menu').append(mobilesociallinkblock);
			jQuery("#block-language-2").click(function () {
				jQuery("#block-languageswitcher-2").toggle();
				jQuery("#block-language-2").toggleClass("language-arrow");
      });
      jQuery("ul.clp-secondary-menu").click(function(){
        jQuery(".mobile-header-menu").toggleClass("menu-expand");
      });
			jQuery('#superfish-mobile-main-menu-toggle').click(function(){
        jQuery("body").toggleClass("search-language-block");
				if (jQuery( "body" ).hasClass('search-language-block')) {
					jQuery("a.logo.navbar-btn.pull-left img").attr("src","/themes/custom/alnylam/images/alnylam-corporate-logo-ko-hires.png");
				}
				else {
					jQuery("a.logo.navbar-btn.pull-left img").attr("src","/themes/custom/alnylam/logo.svg");
				}
			});

			var slider = jQuery('.view-patient-advocacy-and-engagement-team.view-display-id-block_2 .view-content');
			var slider1 = jQuery('#midcontent-area .paragraph--type--patient-advocacy-img-grid.paragraph-id--561 .field--name-field-image-description');
			slider.slick({
				infinite: true,
				arrows: false,
				dots: true,
				autoplay: true,
				speed: 800,
				fade: true,
				draggable: true,
				slidesToShow: 1,
				slidesToScroll: 1,
			});
			slider1.slick({
				infinite: true,
				arrows: false,
				dots: true,
				autoplay: true,
				speed: 800,
				fade: true,
				draggable: true,
				slidesToShow: 1,
				slidesToScroll: 1,
      });
      var slider2 = jQuery('#clp-banner-overlay .counter-box .row');
	    slider2.slick({
			infinite: true,
			arrows: false,
			dots: true,
			autoplay: true,
			speed: 800,
			fade: true,
			draggable: true,
			slidesToShow: 1,
			slidesToScroll: 1,
		 });
		}
		else{
			jQuery('.mobile-sociallinks-block').remove();
			jQuery("body").removeClass("search-language-block");
		}
	}
	windowSize();
	jQuery(window).resize(function() {
		windowSize();
	});
});
	
	
