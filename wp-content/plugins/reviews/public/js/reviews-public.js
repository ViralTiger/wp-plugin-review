(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 function highlightStars(rating) {
		 for (var i = 1; i <= 5; i++) {
			 if (i <= +rating) {
				 $('[data-rating=' + i + ']').addClass('gold');
			 } else {
				 $('[data-rating=' + i + ']').removeClass('gold');
			 }
		 }
	 }

	 $(function() {
		 $('.review-star-symbol').click(function(){
  		 var rating = $(this).attr('data-rating');
			 $('[name="rating"]').val(rating);
			 highlightStars(rating);
  	 })
		 $('.review-star-symbol').mouseenter(function(){
			 highlightStars($(this).attr('data-rating'));
		 })
		 $('.review-star-symbol').mouseleave(function(){
			 highlightStars($('[name="rating"]').val());
		 })
	 });

})( jQuery );
