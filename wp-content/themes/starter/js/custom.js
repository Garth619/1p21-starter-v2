// @codekit-prepend 'waypoints.js'
// @codekit-prepend 'slick.js'
// @codekit-prepend 'lity.js'
// @codekit-prepend 'modernizr-webp.js'

jQuery(document).ready(function($){
	
		

		
				
		
		
	
	 /* Modernizr - check if browser supports webp. 
     --------------------------------------------------------------------------------------- */
    
    // add data-webp and data-jpg to images in section one and you're gucci
    
     Modernizr.on('webp', function (result) {
	    
	    jQuery('#section_one img').each(function () {
	    
				if (result) {
    
					if (jQuery(this).attr('data-webp')) {
          
          	var img = jQuery(this).data('webp');
          
						jQuery(this).attr('src', img);
        	
        	}
      
   			}
  
	 			else {
		 			
		 			if (jQuery(this).attr('data-jpg')) {
          
          	var img = jQuery(this).data('jpg');
          
						jQuery(this).attr('src', img);
        	
        	}
    
    		
  	
  			}
  		
  		});
  		
  		console.log(result);
	
		});





    /* Waypoints
     --------------------------------------------------------------------------------------- */


    function createWaypoint(triggerElementId, animatedElement, className, offsetVal, functionName, reverse) {
      if(jQuery('#' + triggerElementId).length) {
        var waypoint = new Waypoint({
          element: document.getElementById(triggerElementId),
          handler: function (direction) {
            if (direction === 'down') {
              jQuery(animatedElement).addClass(className);

              if (typeof functionName === 'function') {
                functionName();
                this.destroy();
              }

            } else if (direction === 'up') {
              if (reverse) {
                jQuery(animatedElement).removeClass(className);
              }

            }
          },
          offset: offsetVal
          // Integer or percent
          // 500 means when element is 500px from the top of the page, the event triggers
          // 50% means when element is 50% from the top of the page, the event triggers
        });
      }
    }


    //createWaypoint('section_two', '#contact_trigger', 'visible', 500, null, true);
   
    
    
    
    
    



    /* Smooth Scroll down to section on click (<a href="#id_of_section_to_be_scrolled_to">)
      --------------------------------------------------------------------------------------- */

    jQuery(function() {
      jQuery('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          var target = jQuery(this.hash);
          target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
          if (target.length) {
            jQuery('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });

		
		
		 /* Wistia - Call function when script needs to be loaded either by hover or waypoints
     --------------------------------------------------------------------------------------- */

    function wistiaLoad() {
      jQuery.getScript('https://fast.wistia.com/assets/external/E-v1.js', function(data, textStatus, jqxhr) {
        console.log('wistia load:', textStatus); // Success
      });
    }

    // examples:

    // jQuery(".banner-box-1").one("mouseenter", function(e){
    //   wistiaLoad();
    // });

    // createWaypoint('section-1', null, null, '100%', wistiaLoad, false)







    /* Load Images - Call function when you reach the a section with images using waypoints
       BG image - <div data-src=""></div>   ,   Image - <img data-src="">
      --------------------------------------------------------------------------------------- */

    function loadImages() {
      
      // images
      
      jQuery('img').each(function () {
        
        if (jQuery(this).attr('data-src')) {
          
          var img = jQuery(this).data('src');
          
          jQuery(this).attr('src', img);
        
        }
      
      });

      // background images
      
      jQuery('div, section').each(function () {
       
        if (jQuery(this).attr('data-src')) {
          
          var backgroundImg = jQuery(this).data('src');
          
          jQuery(this).css('background-image', 'url(' + backgroundImg + ')');
        
        }
      
      });

      console.log('images loaded');
    }

    // createWaypoint('section_two', null, null, '100%', loadImages, false);
    
    



/* Slick Carousel ( http://kenwheeler.github.io/slick/ )
--------------------------------------------------------------------------------------- */


/*
$('.sec_three_slider').slick({
  infinite: true,
  slidesToShow: 6,
  slidesToScroll: 6,
	arrows:true,
	prevArrow:".arrow_left",
	nextArrow:".arrow_right",
	responsive: [
    {
      breakpoint: 1450,
      settings: {
      slidesToShow: 5,
      slidesToScroll: 5,
     }
   },
   {
      breakpoint: 1100,
      settings: {
      slidesToShow: 3,
      slidesToScroll: 3,
      dots:true,
     }
   },
   {
      breakpoint: 767,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      dots:true,
     }
   }
	]
 });
 
*/
 

	

/* Remove "#" from menu anchor items to avoid jump to the top of the page
--------------------------------------------------------------------------------------- */


$("ul > li.menu-item-has-children > a[href='#']").removeAttr("href");


  
}); // document ready