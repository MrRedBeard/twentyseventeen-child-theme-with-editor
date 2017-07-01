// One page nav code 
jQuery( document ).ready(function(){
  /* Add padding and id's to each front page section */
  jQuery( "h2.entry-title" ).each( function() {
    var panelId = jQuery( this ).html().toLowerCase().replace(/\s+/g, "-");
      jQuery( this ).wrapInner(function() {
        return "<span style='padding-top:96px;' id='" + panelId + "'></span>";
      })
  })
    
  /* Remove navigation link highlighting */
    jQuery('#top-menu li').removeClass('current-menu-item current_page_item ');
  
  /* Add highlighting on click */
    jQuery('#top-menu li a').on('click', function(event) {
    jQuery(this).parent().parent().find('li').removeClass('current-menu-item');
    jQuery(this).parent().addClass('current-menu-item');
  });
  
    /* Check current URL and highlight nav for current page */
  jQuery('#top-menu li a').each( function() {
      var pageUrl = jQuery( location ).attr( 'href' );
      var navUrl = jQuery( this ).attr( 'href' );
      if ( navUrl == pageUrl ) {
          jQuery( this ).parent().addClass('current-menu-item');
        } 
    })
})
/*************************************************************************/

// Sticky nav on pages and posts
var body = jQuery( 'body' );
var navigation = body.find( '.navigation-top' );
var customHeader = body.find( '.custom-header' );
var navigationOuterHeight = navigation.outerHeight();
if ( body.hasClass( 'has-header-image' ) ) {
  var headerOffset = customHeader.innerHeight() - navigationOuterHeight;
}
jQuery( window ).on( 'scroll', function() {
  if ( jQuery( window ).scrollTop() >= headerOffset ) {
    navigation.addClass( 'site-navigation-fixed' );
  } else {
    navigation.removeClass( 'site-navigation-fixed' );
  }
});
/*************************************************************************/

/* Color Picker Settings */
jQuery(document).ready(function($) 
{
	$(".colorPicker").spectrum({
		color: "",
		flat: false,
		showInput: true,
		className: "full-spectrum",
		showInitial: true,
		showPalette: false,
		showSelectionPalette: false,
		maxPaletteSize: 10,
		preferredFormat: "hex",
		localStorageKey: "spectrum.x2",
		move: function (color) {
			
		},
		show: function () {
		
		},
		beforeShow: function () {
		
		},
		hide: function () {
		
		},
		change: function() {
			
		},
		palette: [
			["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
			"rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
			["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
			"rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
			["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
			"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
			"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
			"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
			"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
			"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
			"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
			"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
			"rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
			"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
		]
	});
});
/*************************************************************************/

/* Borders Selector */
			function X2_BorderSelect(elem, optionName)
			{
				if(elem.getAttribute("status") == "off")
				{
					elem.style.backgroundColor = "#000";
					elem.style.color = "#fff";
					elem.setAttribute("status", "on");
				}
				else
				{
					elem.style.backgroundColor = "transparent";
					elem.style.color = "#000";
					elem.setAttribute("status", "off");
				}
				
				var doc = document.getElementById(optionName);
				var val = "";
				if(doc.getElementsByClassName("top")[0].getAttribute("status") == "on")
				{
					val += "T";
				}
				if(doc.getElementsByClassName("left")[0].getAttribute("status") == "on")
				{
					val += "L";
				}
				if(doc.getElementsByClassName("right")[0].getAttribute("status") == "on")
				{
					val += "R";
				}
				if(doc.getElementsByClassName("bottom")[0].getAttribute("status") == "on")
				{
					val += "B";
				}
				doc.getElementsByTagName("input")[0].value = val;
			}
			
			//Parse values from what's stored and style the selector
			function x2_ParseBrdrValue(obj)
			{
				if(obj.getElementsByTagName("input")[0].value.includes("T"))
				{
					obj.getElementsByClassName("top")[0].style.backgroundColor = "#000";
					obj.getElementsByClassName("top")[0].style.color = "#fff";
					obj.getElementsByClassName("top")[0].setAttribute("status", "on");
				}
				if(obj.getElementsByTagName("input")[0].value.includes("L"))
				{
					obj.getElementsByClassName("left")[0].style.backgroundColor = "#000";
					obj.getElementsByClassName("left")[0].style.color = "#fff";
					obj.getElementsByClassName("left")[0].setAttribute("status", "on");
				}
				if(obj.getElementsByTagName("input")[0].value.includes("R"))
				{
					obj.getElementsByClassName("right")[0].style.backgroundColor = "#000";
					obj.getElementsByClassName("right")[0].style.color = "#fff";
					obj.getElementsByClassName("right")[0].setAttribute("status", "on");
				}
				if(obj.getElementsByTagName("input")[0].value.includes("B"))
				{
					obj.getElementsByClassName("bottom")[0].style.backgroundColor = "#000";
					obj.getElementsByClassName("bottom")[0].style.color = "#fff";
					obj.getElementsByClassName("bottom")[0].setAttribute("status", "on");
				}
			}
/*************************************************************************/