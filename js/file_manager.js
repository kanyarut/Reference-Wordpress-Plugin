jQuery(document).ready(function(){
	if(window.send_to_editor){
		window.original_send_to_editor = window.send_to_editor;
	}
	
	var $filemanager_target = false;
	
	jQuery('.ref_a_book_image').live('click',function() {
		$filemanager_target = jQuery(this);
		tb_show('', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true');
		
		window.send_to_editor = function(html) {
			if ($filemanager_target != false) {
				imgurl = jQuery('img',html).attr('src');
				$filemanager_target.children('.ref-book-image').attr('src',imgurl);
				$filemanager_target.children('.ref-book-thumbnail').val(imgurl);
				$filemanager_target.children('.ref-book-thumbnailsm').val(imgurl);
				$filemanager_target.children('.ref-book-haspreview').val('1');
				filemanager_target = false;
				window.send_to_editor = window.original_send_to_editor;
				tb_remove();
			} else {
				window.original_send_to_editor(html);
			}
		}
		return false;
	});
});