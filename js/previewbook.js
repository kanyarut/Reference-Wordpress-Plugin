jQuery(document).ready(function(){
	var $ref_book_review = jQuery('<div id="ref_book_review" style="display:none"></div>').appendTo(jQuery('body'));
	
	jQuery('.ref_preview_book').live('click',function(e){
		e.preventDefault();
		
		jQuery.colorbox({href: jQuery(this).attr('href'), iframe: true, width: '90%', height: '95%', title: jQuery(this).attr('title') })

		jQuery(window).resize(function(){
			jQuery.colorbox.resize({width: '90%', height: '95%'});
		});
		
		return false;
	});
});