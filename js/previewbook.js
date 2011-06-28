jQuery(document).ready(function(){
	var $ref_book_review = jQuery('<div style="display:none"><div id="ref_book_review" style="width:100%;height:95%;"></div></div>').appendTo(jQuery('body'));
	
	jQuery('.ref_preview_book').live('click',function(e){
		e.preventDefault();
		jQuery.colorbox({inline:true, href:"#ref_book_review", width: '90%', height: '95%', title: jQuery(this).attr('title') })
		jQuery(window).resize(function(){
			jQuery.colorbox.resize({width: '90%', height: '95%'});
		});
		showBook(jQuery(this).attr('href'));
		
		return false;
	});
	
	function alertBookNotFound() {
		alert('Cannot load this book for preview');
		jQuery.colorbox.close(); 
	}
	
	function showBook(isbn) {
		var viewer = new google.books.DefaultViewer(document.getElementById('ref_book_review'));
		viewer.load('ISBN:'+isbn, alertBookNotFound);
	}
	
});
google.load("books", "0");