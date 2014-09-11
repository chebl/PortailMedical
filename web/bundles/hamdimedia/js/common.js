if($.browser.mozilla||$.browser.opera ){document.removeEventListener("DOMContentLoaded",$.ready,false);document.addEventListener("DOMContentLoaded",function(){$.ready()},false)}
jQuery.event.remove( window, "load", jQuery.ready );
jQuery.event.add( window, "load", function(){ jQuery.ready(); } );
jQuery.extend({
	includeStates:{},
	include:function(url,callback,dependency){
		if ( typeof callback!='function'&&!dependency){
			dependency = callback;
			callback = null;
		}
		url = url.replace('\n', '');
		jQuery.includeStates[url] = false;
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.onload = function () {
			jQuery.includeStates[url] = true;
			if ( callback )
				callback.call(script);
		};
		script.onreadystatechange = function () {
			if ( this.readyState != "complete" && this.readyState != "loaded" ) return;
			jQuery.includeStates[url] = true;
			if ( callback )
				callback.call(script);
		};
		script.src = url;
		if ( dependency ) {
			if ( dependency.constructor != Array )
				dependency = [dependency];
			setTimeout(function(){
				var valid = true;
				$.each(dependency, function(k, v){
					if (! v() ) {
						valid = false;
						return false;
					}
				})
				if ( valid )
					document.getElementsByTagName('head')[0].appendChild(script);
				else
					setTimeout(arguments.callee, 10);
			}, 10);
		}
		else
			document.getElementsByTagName('head')[0].appendChild(script);
		return function(){
			return jQuery.includeStates[url];
		}
	},
	readyOld: jQuery.ready,
	ready: function () {
		if (jQuery.isReady) return;
		imReady = true;
		$.each(jQuery.includeStates, function(url, state) {
			if (! state)
				return imReady = false;
		});
		if (imReady) {
			jQuery.readyOld.apply(jQuery, arguments);
		} else {
			setTimeout(arguments.callee, 10);
		}
	}
});
///// include js files ////////////
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.easing.1.3.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/ddsmoothmenu.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/cufon/cufon-yui.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/cufon/FrancophilSans_500-FrancophilSans_700.font.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.flexibleColumns.min.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.cycle.all.min.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.prettyPhoto.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.tinycarousel.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.tipsy.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.watermarkinput.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.localscroll-min.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.scrollTo-min.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.jigowatt.js');
$.include('/ContactProject/web/bundles/hamdimedia/js/jquery.uniform.min.js');


jQuery(document).ready(function(){
	
	// DropDown Menu Plugin
	ddsmoothmenu.init({
		mainmenuid: "menu", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})
	
	// Cufon Font Load

	Cufon.replace('h1, h2, h3, h4', { fontFamily: 'FrancophilSans', hover: false, color: '-linear-gradient(#727171, #020202)' });	// Only for light theme color
	//Cufon.replace('h1, h2, h3, h4', { fontFamily: 'FrancophilSans', hover: false, color: '-linear-gradient(#ffffff, #bababa)' });	// Only for dark theme color
	Cufon.replace('.big_btn', { fontFamily: 'FrancophilSans', hover: true });
	Cufon.replace('#fsb h3', { fontFamily: 'FrancophilSans', hover: true, textShadow: '1px 1px rgba(0, 0, 0, 0.8)', color: '-linear-gradient(#FCFCFC, #B8B8B8)' });
	Cufon.replace('#fsb h4, .gallery h4, .partners h4, .header_full h2, .header_full h3, .overview h4', { fontFamily: 'FrancophilSans', hover: true, color: '-linear-gradient(#ffffff, #bababa)' });
	
	// Fluid Menu
	jQuery('.ddsmoothmenu li').click(function(){
		var url = jQuery(this).find('a').attr('href');
		document.location.href = url;
	});
	jQuery('.ddsmoothmenu li').hover(function(){
		jQuery(this).find('.menuslide').slideDown();
	},
	function(){
		jQuery(this).find('.menuslide').slideUp();
	});
	
	// *************************************** Images ******************************************************//
	//Horizontal Sliding
	jQuery('.gallery_item').hover(function(){
		jQuery(".cover", this).stop().animate({left:'214px'},{queue:false,duration:250});
	}, function() {
		jQuery(".cover", this).stop().animate({left:'0px'},{queue:false,duration:900});
	});

	// find the div.fade elements and hook the hover event
	jQuery('.portfolio_thumb a').hover(function() {
		// on hovering over find the element we want to fade *up*
		var fade = jQuery('> .hover_img, > .hover_vid', this);
		// if the element is currently being animated (to fadeOut)...
		if (fade.is(':animated')) {
			// ...stop the current animation, and fade it to 1 from current position
			fade.stop().fadeTo(300, 1);
		} else {
			fade.fadeIn(300);
		}
	}, function () {
		var fade = jQuery('> .hover_img, > .hover_vid', this);
		if (fade.is(':animated')) {
			fade.stop().fadeTo(300, 0);
		} else {
			fade.fadeOut(300);
		}
	});
 
	// get rid of the text
	jQuery('.portfolio_thumb a > .hover_img, .portfolio_thumb a > .hover_img').empty();

	// Partners Page

	//move the image in pixel
	var move = -15;
	//zoom percentage, 1.2 =120%
	var zoom = 1.2;
	//On mouse over those thumbnail
	jQuery('.partner_item').hover(function() {
		
		//Set the width and height according to the zoom percentage
		width = jQuery('.partner_item').width() * zoom;
		height = jQuery('.partner_item').height() * zoom;
		
		//Move and zoom the image
		jQuery(this).find('img').stop(false,true).animate({'width':width, 'height':height, 'top':move, 'left':move}, {duration:200});
		
		//Display the caption
		jQuery(this).find('div.caption').css({"visibility":"visible",opacity:0.8});
	},
	function() {
		//Reset the image
		jQuery(this).find('img').stop(false,true).animate({'width':jQuery('.partner_item').width(), 'height':jQuery('.partner_item').height(), 'top':'0', 'left':'0'}, {duration:100});	

		//Hide the caption
		jQuery(this).find('div.caption').css({"visibility":"hidden",opacity:0});
	});
	
		// *************************************** Shortcodes ******************************************************//
		
// jQuery Toggle

	jQuery(".toggle_container").hide(); //Hide (Collapse) the toggle containers on load

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	jQuery("b.trigger").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("slow");
		return false; //Prevent the browser jump to the link anchor
	});
    
// jQuery Accordion

	//Set default open/close settings
	jQuery('.acc_container').hide(); //Hide/close all containers
	jQuery('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container
	
	//On Click
	jQuery('.acc_trigger').click(function(){
		if( jQuery(this).next().is(':hidden') ) { //If immediate next container is closed...
			jQuery('.acc_trigger').removeClass('active').next().slideUp(); //Remove all "active" state and slide up the immediate next container
			jQuery(this).toggleClass('active').next().slideDown(); //Add "active" state to clicked trigger and slide down the immediate next container
		}
		return false; //Prevent the browser jump to the link anchor
	});

	// jQuery Tabs

	//When page loads...
	jQuery(".tab_content").hide(); //Hide all content
	jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
	jQuery(".tab_content:first").show(); //Show first tab content

	//On Click Event
	jQuery("ul.tabs li").click(function() {

		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(".tab_content").hide(); //Hide all tab content

		var activeTab = jQuery(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		jQuery(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
	
	// jQuery Watermark Plugin
	jQuery('input[name="s"]').each(function() {
		jQuery(this).Watermark("Enter keywords");
	});
	
	// jQuery autoAlign
	jQuery("#fsb").autoColumn(50, ".widget-container");
	jQuery("#fsb").autoHeight(".widget-container");
	
	jQuery(".columns").autoColumn(50, ".column");
	jQuery(".columns").autoHeight(".column");
	
	jQuery(".columns2").autoColumn(50, ".column");
	jQuery(".columns2").autoHeight(".column");
	
	jQuery(".columns3").autoColumn(33, ".column");
	jQuery(".columns3").autoHeight(".column");
	
	jQuery(".columns4").autoColumn(33, ".column");
	jQuery(".columns4").autoHeight(".column");
	
	jQuery(".columns5").autoColumn(33, ".column");
	jQuery(".columns5").autoHeight(".column");
	
	jQuery(".columns6").autoColumn(33, ".column");
	jQuery(".columns6").autoHeight(".column");
	
	jQuery(".columns7").autoColumn(33, ".column");
	jQuery(".columns7").autoHeight(".column");
	
	jQuery(".columns8").autoColumn(33, ".column");
	jQuery(".columns8").autoHeight(".column");
	
	jQuery(".columns9").autoColumn(33, ".column");
	jQuery(".columns9").autoHeight(".column");
	
	jQuery(".columns10").autoColumn(33, ".column");
	jQuery(".columns10").autoHeight(".column");
	
	jQuery(".columns11").autoColumn(33, ".column");
	jQuery(".columns11").autoHeight(".column");
	
	jQuery(".columns12").autoColumn(33, ".column");
	jQuery(".columns12").autoHeight(".column");
	
	jQuery(".columns13").autoColumn(33, ".column");
	jQuery(".columns13").autoHeight(".column");
	
	jQuery(".columns14").autoColumn(33, ".column");
	jQuery(".columns14").autoHeight(".column");
	
	jQuery(".columns15").autoColumn(33, ".column");
	jQuery(".columns15").autoHeight(".column");
	
	jQuery(".columns16").autoColumn(33, ".column");
	jQuery(".columns16").autoHeight(".column");
	
	// jQuery tipsy
	jQuery('.social a').tipsy(
	{
		gravity: 's', // nw | n | ne | w | e | sw | s | se
		fade: true
	}); 

	// Sliding menu items in sidebar
	if (jQuery("#sidebar").length) {
		slide("#sidebar .widget_categories", 10, 0, 150, .8);
		slide("#sidebar .widget_archive", 10, 0, 150, .8);
		slide("#sidebar .widget_nav_menu", 10, 0, 150, .8);
		slide("#sidebar .widget_links", 10, 0, 150, .8);
		slide("#sidebar .widget_recent_entries", 10, 0, 150, .8);
		slide("#sidebar .widget_recent_comments", 10, 0, 150, .8);
	}
	
	// go to top scroll effect
	if (jQuery(".gototop").length) {
		jQuery.localScroll();
	}
	
	// tabbed widget
	if (jQuery(".widget_tabbed").length) {
		jQuery(".widget_tabbed").tabs({ fx: { height: 'toggle', opacity: 'toggle' } });
	}
	
	// jQuery Cycle
	if (jQuery(".widget_recent_projects").length) {
		jQuery('.widget_recent_projects ul').cycle({
			fx: 'scrollLeft',
			timeout: 5000,
			delay: -1000
		});
	}
	
	// jQuery data-rel to rel
	if (jQuery("a[data-rel]").length) {
		jQuery('a[data-rel]').each(function() {jQuery(this).attr('rel', jQuery(this).data('rel'));});
	}
	
	// jQuery Uniform Plugin
	if (jQuery("select, input:checkbox, input:radio").length) {
		jQuery("select, input:checkbox, input:radio").uniform();
	}
	
	// PrettyPhoto
	
	function pp_lightbox() {
		
		jQuery("a[rel^='prettyPhoto']").prettyPhoto({
			animation_speed: 'normal', /* fast/slow/normal */
			opacity: 0.70, /* Value between 0 and 1 */
			show_title: true, /* true/false */
			allow_resize: true, /* true/false */
			counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
			theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			overlay_gallery: true, /* display or hide the thumbnails on a lightbox when it opened */
			deeplinking: false,
			social_tools: false /* html or false to disable */
		});
	
	}
	
	if(jQuery().prettyPhoto) {
		pp_lightbox(); 
	}
	
	// jQuery Roundabout Plugin
	if (jQuery(".portfolio_rotator").length) {
		jQuery('.portfolio_rotator ul').roundabout({
			bearing: 0.0,			// The starting direction in which the Roundabout should point.
			tilt: 0.0,				// The starting angle at which the Roundabout’s plane should be tipped.
			minZ: 10,				// The lowest z-index value that a moveable item can be assigned. (Will be the z-index of the item farthest from the focusBearing.)
			maxZ: 100,				// The greatest z-index value that a moveable item can be assigned. (Will be the z-index of the item in focus.)
			minOpacity: 0.3,		// The lowest opacity value that a moveable item can be assigned. (Will be the opacity of the item farthest from the focus bearing.)
			maxOpacity: 1.0,		// The greatest opacity value that a moveable item can be assigned. (Will be the opacity of the item in focus.)
			minScale: 0.6,			// The lowest percentage of font-size that a moveable item can be assigned. (Will be the scale of the item farthest from the focus bearing.)
			maxScale: 1.0,			// The greatest percentage of font-size that a moveable item can be assigned. (Will be the scale of the item in focus.)
			duration: 600,			// The length of time (in milliseconds) that all animations take to complete by default.
			btnNext: null,			// A jQuery selector of elements that will have a click event assigned to them. On click, the Roundabout will move to the next child (counterclockwise).
			btnPrev: null,			// A jQuery selector of elements that will have a click event assigned to them. On click, the Roundabout will move to the previous child (clockwise).
			easing: 'swing',		// The easing method to be used for animations by default. jQuery comes with “linear” and “swing,” although any of the jQuery Easing plugin’s values can be used if the easing plugin is included.
			clickToFocus: true,	// When an item is not in focus, should it be brought into focus via an animation? If true, will disable any click events on elements within the moving element that was clicked. Once the element is in focus, click events will no longer be blocked.
			focusBearing: 0.0,		// The bearing at which a moving item’s position must match on the Roundabout to be considered “in focus.”
			shape: 'waterWheel',	// For use with the Roundabout Shapes plugin. Sets the shape of the path over which moveable items will travel.
			debug: false,			// Changes the HTML within moving elements into a list of information about that element. Helpful for advanced configurations.
			childSelector: 'li',	// Changes the set of elements Roundabout will look for within the holding element for moving.
			startingChild: 0,		// Starts a given child at the focus of the Roundabout. This is a zero-based number positioned in order of appearance in the HTML file.
			reflect: false			// Setting to true causes the elements to be placed around the Roundabout in reverse order. Also flips the direction of “next” and ”previous” buttons. 
		});
	}
	
	// jQuery text slide up / slide down effect
		jQuery.fn.showFeatureText = function() {
		  return this.each(function(){    
			var box = jQuery(this);
			var text = jQuery('h4',this);    
		
			text.css({ position: 'absolute', bottom: '0px' }).hide();
		
			box.hover(function(){
			  text.slideDown("fast");
			},function(){
			  text.slideUp("fast");
			});
		
		  });
		}
	if (jQuery("#slider-code").length) {
		jQuery('#slider-code .overview li').showFeatureText();
	}
	
	// jQuery Tinycarousel
	if (jQuery("#slider-code").length) {
		jQuery('#slider-code').tinycarousel({
			start: 2, // where should the carousel start?
			display: 4, // how many blocks do you want to move at 1 time?
			axis: 'x', // vertical or horizontal scroller? ( x || y ).
			controls: true, // show left and right navigation buttons.
			pager: false, // is there a page number navigation present?
			interval: false, // move to another block on intervals.
			intervaltime: 3000, // interval time in milliseconds.
			rewind: false, // If interval is true and rewind is true it will play in reverse if the last slide is reached.
			animation: true, // false is instant, true is animate.
			duration: 1000, // how fast must the animation move in ms?
			callback: null // function that executes after every move
		});
	}
	
	// jQuery Accordion
	if (jQuery("#accordion").length) {
		jQuery('#accordion').eAccordion ({
			easing: 'swing',                // Anything other than "linear" or "swing" requires the easing plugin
			autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not
			startStopped: false,            // If autoPlay is on, this can force it to start stopped
			stopAtEnd: false,				// If autoplay is on, it will stop when it reaches the last slide
			delay: 3000,                    // How long between slide transitions in AutoPlay mode
			animationTime: 600,             // How long the slide transition takes
			hashTags: true,                 // Should links change the hashtag in the URL?
			pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
			width: null,					// Override the default CSS width
			height: null,					// Override the default CSS height
			expandedWidth: '422px'			// Width of the expanded slide
		});
	}
	
	// jQuery Nivo Slider
	if (jQuery("#nivo-slider").length) {
		jQuery('#nivo-slider').nivoSlider({
			effect:'random', //Specify sets like: 'fold,fade,sliceDown'
			slices:40,
			animSpeed:600,
			pauseTime:3000,
			directionNav:true, //Next and Prev
			directionNavHide:false,
			controlNav:true //1,2,3...
		});
	}
	
	// jQuery Coin Slider
	if (jQuery("#coin-slider").length) {
		jQuery('#coin-slider').coinslider({
			width: 952, // width of slider panel
			height: 392, // height of slider panel
			spw: 10, // squares per width
			sph: 5, // squares per height
			delay: 3000, // delay between images in ms
			sDelay: 30, // delay beetwen squares in ms
			opacity: 1, // opacity of title and navigation
			titleSpeed: 500, // speed of title appereance in ms
			effect: 'random', // random, swirl, rain, straight
			navigation: true, // prev next and buttons
			links : true, // show images as links 
			hoverPause: true // pause on hover
		});
	}
	
	// jQuery Anything Slider
	if (jQuery("#anything").length) {
		jQuery('#anything')
		  .anythingSlider({
		   width        : 952,
		   height       : 392,
		   startStopped : true
		  })
		  /* this code will make the caption appear when you hover over the panel
			remove the extra statements if you don't have captions in that location */
		  .find('.panel')
			.find('div[class*=caption]').css({ position: 'absolute' }).end()
			.hover(function(){ showCaptions( jQuery(this) ) }, function(){ hideCaptions( jQuery(this) ); });
		
		  showCaptions = function(el){
			var $this = el;
			if ($this.find('.caption-top').length) {
			  $this.find('.caption-top')
				.show()
				.animate({ top: 10, opacity: 0.8 }, 400);
			}
			if ($this.find('.caption-right').length) {
			  $this.find('.caption-right')
				.show()
				.animate({ right: 10, opacity: 0.8 }, 400);
			}
			if ($this.find('.caption-bottom').length) {
			  $this.find('.caption-bottom')
				.show()
				.animate({ bottom: 10, opacity: 0.8 }, 400);
			}
			if ($this.find('.caption-left').length) {
			  $this.find('.caption-left')
				.show()
				.animate({ left: 10, opacity: 0.8 }, 400);
			}
		  };
		  hideCaptions = function(el){
			var $this = el;
			if ($this.find('.caption-top').length) {
			  $this.find('.caption-top')
				.stop()
				.animate({ top: -50, opacity: 0 }, 350, function(){
				  $this.find('.caption-top').hide(); }); 
			}
			if ($this.find('.caption-right').length) {
			  $this.find('.caption-right')
				.stop()
				.animate({ right: -200, opacity: 0 }, 350, function(){
				  $this.find('.caption-right').hide(); });
			}
			if ($this.find('.caption-bottom').length) {
			  $this.find('.caption-bottom')
				.stop()
				.animate({ bottom: -50, opacity: 0 }, 350, function(){
				  $this.find('.caption-bottom').hide(); });
			}
			if ($this.find('.caption-left').length) {
			  $this.find('.caption-left')
				.stop()
				.animate({ left: -200, opacity: 0 }, 350, function(){
				  $this.find('.caption-left').hide(); });
			}
		  };
		
		  // hide all captions initially
		  hideCaptions( jQuery('#anything .panel') );
	}
	
	// 3D Piecemaker Slider
	if (jQuery("#piecemaker").length) {
      var flashvars = {};
      flashvars.cssSource = "piecemaker/piecemaker.css";
      flashvars.xmlSource = "piecemaker/piecemaker.xml";
		
      var params = {};
      params.play = "true";
      params.menu = "false";
      params.scale = "showall";
      params.wmode = "transparent";
      params.allowfullscreen = "true";
      params.allowscriptaccess = "always";
      params.allownetworking = "all";
	  
      swfobject.embedSWF('piecemaker/piecemaker.swf', 'piecemaker', '1000', '600', '10', null, flashvars,    
      params, null);
	}
	
	// Roundabout jQuery Plugin
	if (jQuery("#roundabout").length) {
		jQuery('#roundabout ul').roundabout({
			bearing: 0.0, // The starting direction in which the Roundabout should point.
			tilt: 0.0, // The starting angle at which the Roundabout’s plane should be tipped.
			minZ: 80, // The lowest z-index value that a moveable item can be assigned. (Will be the z-index of the item farthest from the focusBearing.)
			maxZ: 100, // The greatest z-index value that a moveable item can be assigned. (Will be the z-index of the item in focus.)
			minOpacity: 0.7, // The lowest opacity value that a moveable item can be assigned. (Will be the opacity of the item farthest from the focus bearing.)
			maxOpacity: 1.0, // The greatest opacity value that a moveable item can be assigned. (Will be the opacity of the item in focus.)
			minScale: 0.4, // The lowest percentage of font-size that a moveable item can be assigned. (Will be the scale of the item farthest from the focus bearing.)
			maxScale: 1.3, // The greatest percentage of font-size that a moveable item can be assigned. (Will be the scale of the item in focus.)
			duration: 800, // The length of time (in milliseconds) that all animations take to complete by default.
			easing: 'easeOutExpo', // The easing method to be used for animations by default. jQuery comes with “linear” and “swing,” although any of the jQuery Easing plugin’s values can be used if the easing plugin is included.
			clickToFocus: true, // When an item is not in focus, should it be brought into focus via an animation? If true, will disable any click events on elements within the moving element that was clicked. Once the element is in focus, click events will no longer be blocked.
			focusBearing: 0.0, // The bearing at which a moving item’s position must match on the Roundabout to be considered “in focus.”
			shape: 'square', // For use with the Roundabout Shapes plugin. Sets the shape of the path over which moveable items will travel.
			childSelector: 'li', // Changes the set of elements Roundabout will look for within the holding element for moving.
			startingChild: 6, // Starts a given child at the focus of the Roundabout. This is a zero-based number positioned in order of appearance in the HTML file.
			reflect: false // Setting to true causes the elements to be placed around the Roundabout in reverse order. Also flips the direction of “next” and ”previous” buttons. 
		});
	}
	
	// jQuery Orbit Slider
	if (jQuery("#orbit-slider").length) {
		jQuery('#orbit-slider').orbit({
			 animation: 'fade',                 // fade, horizontal-slide, vertical-slide, horizontal-push
			 animationSpeed: 800,               // how fast animtions are
			 timer: true, 			 			// true or false to have the timer
			 advanceSpeed: 4000, 				// if timer is enabled, time between transitions 
			 pauseOnHover: false, 				// if you hover pauses the slider
			 startClockOnMouseOut: false,		// if clock should start on MouseOut
			 startClockOnMouseOutAfter: 1000,	// how long after MouseOut should the timer start again
			 directionalNav: true,				// manual advancing directional navs
			 captions: true,					// do you want captions?
			 captionAnimation: 'fade',			// fade, slideOpen, none
			 captionAnimationSpeed: 800,		// if so how quickly should they animate in
			 bullets: true,						// true or false to activate the bullet navigation
			 bulletThumbs: true,				// thumbnails for the bullets
			 bulletThumbLocation: 'sliders/orbit-slider/orbit/',		// location from this file where thumbs will be
			 afterSlideChange: function(){}		// empty function 
		});
	}
	
	// jQuery Serie3 Slider
	if (jQuery("#s3slider").length) {
		jQuery('#s3slider').s3Slider({
			timeOut: 3000
		});
	}


	
});

		// *************************************** Functions ******************************************************//

function slide(navigation_id, pad_out, pad_in, time, multiplier)
{
	// creates the target paths
	var list_elements = navigation_id + " li";
	var link_elements = list_elements + " a";
	
	// initiates the timer used for the sliding animation
	var timer = 0;
	
	// creates the slide animation for all list elements 
	jQuery(list_elements).each(function(i)
	{
		// margin left = - ([width of element] + [total vertical padding of element])
		jQuery(this).css("margin-left","-15px");
		// updates timer
		timer = (timer*multiplier + time);
		jQuery(this).animate({ marginLeft: "0" }, timer);
		jQuery(this).animate({ marginLeft: "15px" }, timer);
		jQuery(this).animate({ marginLeft: "0" }, timer);
	});

	// creates the hover-slide effect for all link elements 		
	jQuery(link_elements).each(function(i)
	{
		jQuery(this).hover(
		function()
		{
			jQuery(this).animate({ paddingLeft: pad_out }, 150);
		},		
		function()
		{
			jQuery(this).animate({ paddingLeft: pad_in }, 150);
		});
	});
}