/**
 * Adjusts multicheck layout for theme options page.
 * 
 * @since 1.0
 */

jQuery(document).ready(function() {

	// Removes vertical padding from multicheck table elements.
	jQuery('.multicheck').parent().parent().children().css({
		'padding-bottom': '0',
		'padding-top': '0',
	});
	
	// Adds vertical padding back onto the multicheck title element for proper alignment.
	jQuery.each( jQuery('.multicheck').parent().parent().children( 'th' ), function() {
      jQuery(this).css('padding-top', '2px');
   });

});
