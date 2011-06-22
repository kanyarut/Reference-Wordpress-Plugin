jQuery(document).ready(function(){
	var num = jQuery('#ref-external-container p').length;
	var book = jQuery('#ref-book-container .ref_a_book').length;
	var $currentbook;
	jQuery('.ref-remove-external').live('click',function(){
		jQuery(this).parent('p').slideUp('fast',function(){ jQuery(this).remove() });
	});
	
	jQuery('.ref-add-external').click(function(){
		num++;
		var $tmp = '<p>'
			+'<input type="text" name="ref[external]['+num+'][title]" value="" placeholder="Title" style="width:40%" /> '
			+'<input type="text" name="ref[external]['+num+'][link]" value="" placeholder="http://www.example.com" style="width:50%" /> '
			+'<button type="button" class="button-secondary ref-remove-external" >&times;</button>'
			+'</p>'
		jQuery('#ref-external-container').append($tmp);
	});
	
	jQuery('#ref-select-list').click(function(){
		if(jQuery('#ref-posts-list input:checked').length > 0){
			var $tmp= '';
			jQuery('#ref-posts-list input:checked').each(function(){
				$tmp += '<li style="clear:both;border-bottom: 1px dotted #333;overflow:hidden">'+jQuery(this).attr('data-title')
					+'<button type="button" class="button-secondary ref-remove-related" style="float:right;" >&times;</button>'
					+'<input type="hidden" name="ref[related][]" value="'+jQuery(this).val()+'" />'
					+'</li>';
			});
			jQuery('#ref-selected-related').html($tmp);
		}
		jQuery('#ref-list-dialog').dialog('close');
	});
	
	jQuery('#ref-add-book').click(function(){
		book++;
		var $tmp;
		
		$tmp = '<div class="ref_a_book">'
				+'<div class="ref_a_book_image">'
				+'	<img src="'+pluginurl+'../img/custombookimage.gif" class="ref-book-image" />'
				+'	<input type="hidden" name="ref[book]['+book+'][thumbnail]" value="" class="ref-book-thumbnail" />'
				+'	<input type="hidden" name="ref[book]['+book+'][thumbnailsm]" value="" class="ref-book-thumbnailsm" />'
				+'	<input type="hidden" name="ref[book]['+book+'][haspreview]" value="" class="ref-book-haspreview" />'
				+'</div>'
				+'<button type="button" class="button-secondary ref-remove-book" >&times;</button>'
				+'<a href="#" class="ref-gbook"><img src="'+pluginurl+'../img/gbs_search.png" /></a>'
				+'<div class="ref_a_book_detail">'
				+'	<p>'
				+'		<label>Title:</label>'
				+'		<input type="text" name="ref[book]['+book+'][title]" value="" placeholder="Book Title" class="ref-book-title" />'
				+'	</p>'
				+'	<p>'
				+'		<label>Author:</label>'
				+'		<input type="text" name="ref[book]['+book+'][author]" value="" placeholder="Author Name" class="ref-book-author" />'
				+'	</p>'
				+'	<p>'
				+'		<label>Published:</label>'
				+'		<input type="text" name="ref[book]['+book+'][published]" value="" placeholder="Published Date" class="ref-book-published" />'
				+'	</p>'
				+'	<p>'
				+'		<label>ISBN:</label>'
				+'		<input type="text" name="ref[book]['+book+'][isbn]" value="" placeholder="ISBN-10" class="ref-book-isbn" />'
				+'	</p>'
				+'	<p>'
				+'		<label>Publisher:</label>'
				+'		<input type="text" name="ref[book]['+book+'][publisher]" value="" placeholder="Publisher Name" class="ref-book-publisher" />'
				+'	</p>'
				+'</div>'
			+'</div>';
				
		jQuery('#ref-book-container').append($tmp);
	});
	
	var $ref_book_review = jQuery('<div id="ref_book_review" style="display:none"></div>').appendTo(jQuery('body'));
	jQuery('.ref_preview_book').live('click',function(e){
		e.preventDefault();
		
		$bookiframe = jQuery("<iframe src='"+pluginurl+'../previewbook.php?isbn='+jQuery(this).attr('href')+"' ></iframe>");
		
		$bookiframe.width('700px');
		$bookiframe.height('590px');
		$bookiframe.css('overflow','hidden');
		
		
		$ref_book_review.html($bookiframe);
		
		$ref_book_review.dialog({width:730,height:650, title: jQuery(this).attr('title').substr(0,60) });
		
		return false;
	});
	
	
	jQuery('.ref-book-title, .ref-book-author, .ref-book-isbn').live('keypress',function(e) {
	    if(e.keyCode == 13) {
	    	e.preventDefault();
	        jQuery(this).parent().parent().parent().find('a.ref-gbook').trigger('click');
	        return false;
	    }
	});
	
	jQuery('#ref_title, #ref_author, #ref_isbn').keypress(function(e) {
	    if(e.keyCode == 13) {
	    	e.preventDefault();
	       	jQuery('#ref_book_search').trigger('click');
	        return false;
	    }
	});
	
	jQuery('.ref_select_book').live('click',function(e){
		e.preventDefault();
		
		var title = jQuery(this).parent().children('.ref_book_title_select').html();
		var author = jQuery(this).parent().children('.ref_book_author_select').html();
		var published = jQuery(this).parent().children('.ref_book_published_select').html();
		var publisher = jQuery(this).parent().children('.ref_book_publisher_select').html();
		var thumbnail = jQuery(this).parent().children('.ref_book_thumbnail_select').val();
		var thumbnailsm = jQuery(this).parent().children('.ref_book_thumbnailsm_select').val();
		var isbn = jQuery(this).attr('href');
		var haspreview = jQuery(this).parent().children('.ref_book_haspreview').val();
		
		$currentbook.find('.ref-book-title').val(title);
		$currentbook.find('.ref-book-author').val(author);
		$currentbook.find('.ref-book-isbn').val(isbn);
		$currentbook.find('.ref-book-published').val(published);
		$currentbook.find('.ref-book-publisher').val(publisher);
		$currentbook.find('.ref-book-haspreview').val(haspreview);
		$currentbook.find('.ref-book-thumbnail').val(thumbnail);
		$currentbook.find('.ref-book-thumbnailsm').val(thumbnailsm);
		
		if(thumbnail)
			$currentbook.find('.ref-book-image').attr('src', thumbnail );
		else
			$currentbook.find('.ref-book-image').attr('src', pluginurl+'../img/custombookimage.gif' );
		
		jQuery('#ref-book-dialog').dialog('close');
		return false;
	});
	
	jQuery('.ref-gbook').live('click',function(e){
		e.preventDefault();
		
		if(!jQuery('#ref_gbook_api_key').val()){
			alert('Please set Google Book API key to use Google Book Preview.');
			return false;
		}
		$currentbook = jQuery(this).parent('div');
		var title = $currentbook.find('.ref-book-title').val();
		var author = $currentbook.find('.ref-book-author').val();
		var isbn = $currentbook.find('.ref-book-isbn').val();
		var query = '';
		
		if(title){
			query += 'intitle:'+title;
			jQuery('#ref_title').val(title);
		}
		if(title && author){
			query += '+';
		}
		if(author){
			query += 'inauthor:'+author;
			jQuery('#ref_author').val(author);
		}
		if((title || author) && isbn){
			query += '+';
		}
		if(isbn){
			query += 'isbn:'+isbn;
			jQuery('#ref_isbn').val(isbn);
		}
        jQuery('#ref-book-dialog').dialog({ height: 500, width: '95%', title: 'Search a Book' });
        loadBook(jQuery('#ref_gbook_api_key').val(), query);
        return false;
	});
	
	jQuery('#ref_book_search').click(function(e){
		e.preventDefault();
		var title = jQuery('#ref_title').val();
		var author = jQuery('#ref_author').val();
		var isbn = jQuery('#ref_isbn').val();
		var query = '';
		
		if(title){
			query += 'intitle:'+title;
			jQuery('#ref_title').val(title);
		}
		if(title && author){
			query += '+';
		}
		if(author){
			query += 'inauthor:'+author;
			jQuery('#ref_author').val(author);
		}
		if((title || author) && isbn){
			query += '+';
		}
		if(isbn){
			query += 'isbn:'+isbn;
			jQuery('#ref_isbn').val(isbn);
		}
        loadBook(jQuery('#ref_gbook_api_key').val(), query);
        
		return false;
	});
	
	jQuery('.book_pagination a').live('click',function(e){
		e.preventDefault();
		
		var title = jQuery('#ref_title').val();
		var author = jQuery('#ref_author').val();
		var query = '';
		
		if(title){
			query += 'intitle:'+title;
			jQuery('#ref_title').val(title);
		}
		if(title && author){
			query += '+';
		}
		if(author){
			query += 'inauthor:'+author;
			jQuery('#ref_author').val(author);
		}
		query+= '&page='+jQuery(this).attr('href');
        loadBook(jQuery('#ref_gbook_api_key').val(), query);
		
		return false;
	});
	
	jQuery('.ref-remove-book').live('click',function(){
		jQuery(this).parent('div').slideUp('fast', function(){ jQuery(this).remove() });
	});
	
	jQuery('.ref-remove-related').live('click',function(){
		jQuery('#ref-post-checkbox-'+jQuery(this).siblings('input').val()).attr('checked','');
		jQuery(this).parent('li').slideUp('fast', function(){ jQuery(this).remove() });
	});
	
	jQuery('#ref-cancel-list').click(function(e){
		e.preventDefault();
		jQuery('#ref-list-dialog').dialog('close');
		return false;
	});
	
	jQuery('#ref-add-related').click(function(){
		jQuery('#ref-list-dialog').dialog({ height: 460, width: 600, title: 'Select Releted Posts' });
	});
});

function loadBook(api, query){
	if(api && query){
		jQuery('#ref-book-dialog-search').html('<div id="ref_book_loading"></div>');
		jQuery.ajax({
			url: pluginurl+'book.php?key='+encodeURI(api)+'&q='+encodeURI(query),
			success: function(msg){
				jQuery('#ref-book-dialog-search').html(msg);
			}
		});
	}else if(!api){
		alert('Please set Google Book API key to use Google Book Preview.');
	}
}