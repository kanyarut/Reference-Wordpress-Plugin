<?
class Reference{
	function plugin_menu() {
		add_options_page( 'Reference Options', 'Reference Options', 'manage_options', 'reference', array($this,'plugin_options') );
	}
	
	function plugin_options() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		$x = WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		include($x.'option.php');
	}
	
	function register_settings(){
		register_setting( 'ref_plugin_options', 'ref_options' );
	}
	
	function create_custom_fields() {
		global $post;
		
		add_meta_box( 'ref-custom-field', 'References',  array($this,'display_custom_field') , 'post', 'normal', 'high' );
		
		$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		wp_enqueue_style('ref-style', $x.'../reference.css' );
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style('jqueryui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css' );
	} //createCustomFields 
	
	function display_custom_field(){ 
		global $post;
		$options = get_post_meta($post->ID, '_ref',true);
		$x = WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		include($x.'post.php');
	} //display_custom_field 
	
	function save_custom_fields( $post_id, $post ) {
		if ( $post->post_type != 'post' )
			return;
		
		if(isset($_POST['ref']))
			update_post_meta( $post_id, '_ref', $_POST['ref']);
	}
	
	function add_style(){
		if(is_single()){
			$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
			
			$ref = '';
			global $post;
			$options = get_post_meta($post->ID, '_ref',true);
			if(isset($options['book']) && is_array($options['book'])){
				wp_enqueue_script('jquery');
				wp_enqueue_script('colorbox', $x.'../js/colorbox/jquery.colorbox-min.js' );
				wp_enqueue_style('colorbox-css', $x.'../js/colorbox/colorbox.css' );
			}
			
			wp_enqueue_script('ref-previewbook', $x.'../js/previewbook.js' );
			wp_enqueue_style('ref-style', $x.'../reference.css' );
		}
	}
	
	function show($content){
		$ref = '';
		global $post;
		$ref_options = get_option( 'ref_options' );
		$options = get_post_meta($post->ID, '_ref',true);
		if(isset($options['related']) && is_array($options['related']) && $options['related'][1] != ""){
			$ref .= '<div class="ref-wrapper" id="ref-related"><h5 class="box primary">Related Entries</h5><ul>';
			foreach($options['related'] as $re){
				if(get_post_type($re) == 'post' && get_post_status($re) == 'publish'){
					$ref .= '<li class="boxlist"><a href="'.get_permalink($re).'" class="box accent" >'.get_the_title($re).'</a></li>';
				}
			}	
			$ref .= '</ul></div>';
		}
	 
		if(isset($options['external']) && is_array($options['external'])  && $options['external'][1]['title'] != ""){
			$ref .= '<div class="ref-wrapper" id="ref-external"><h5 class="box primary">External References</h5><ul>';
			foreach($options['external'] as $ex){
				if($ex['title']!=""){
					$ref .= '<li class="boxlist"><a href="'.$ex['link'].'" class="box accent">'.$ex['title'].'</a></li>';
				}
			}
			$ref .= '</ul></div>';
		}
		
		if(isset($options['book']) && is_array($options['book']) && $options['book'] > 0 && $options['book'][1]['title'] != ""){
			$ref .= '<div class="ref-wrapper" id="ref-book"><h5 class="box primary">Book References</h5>';
			if(is_array($ref_options) && isset($ref_options['ref_display']) && $ref_options['ref_display'] == 'list'){
				$ref .= $this->book_show_list($options);
			}else{
				$ref .= $this->book_show_grid($options);
			}
			$ref .= '</div>';
		}
		return $content.$ref;
	}
	
	function book_show_grid($options){
		$ref = '<ul class="ref_book_grid">';
		$ref_options = get_option( 'ref_options' );
		$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		foreach($options['book'] as $bo){
			$link = false;
			if(is_array($ref_options) && isset($ref_options['ref_amazon_tag']) && $ref_options['ref_amazon_tag'] != '' && $bo['isbn']!=''){
				$link = true;
			}
			if($bo['title']!=""){
				$ref .= '<li class="ref_book_grid">';
				
				if(isset($bo['haspreview']) && $bo['haspreview']=='1' && $bo['isbn']!=''){
					$ref .= ' <a href="'.$x.'../previewbook.php?isbn='.$bo['isbn'].'" class="ref_preview_book" title="'.$bo['title'].'"><img src="'.$x.'../img/gbs_preview.png" alt="Google Book Preview" /></a>';
				}
				
				$ref .= '<div class="book_ref">';
				
				if(isset($bo['thumbnailsm']) && $bo['thumbnailsm']!=''){
					if($link)$ref .= '<a href="http://www.amazon.com/dp/'.$bo['isbn'].'?tag='.$ref_options['ref_amazon_tag'].'" title="'.$bo['title'].'">';
					$ref .= '<img src="'.$bo['thumbnailsm'].'" class="ref_book_image" />';
					if($link)$ref .= '</a>';
				}
				
				$ref .= '<div class="ref_book_detail">';
				
				if($link)$ref .= '<a href="http://www.amazon.com/dp/'.$bo['isbn'].'?tag='.$ref_options['ref_amazon_tag'].'" title="'.$bo['title'].'">';
				$ref .= '<strong>'.$bo['title'].' </strong>';
				if($link)$ref .= '</a>';
				
				if(isset($bo['author']) && $bo['author']!= "" )$ref .= '<br/><em>'.$bo['author'].'</em>';
				$ref .= '<p>';
				if(isset($bo['publisher']) && $bo['publisher'] != "" )$ref .= '<small>'.$bo['publisher'].'</small> | ';
				if(isset($bo['published']) && $bo['published'] != "" )$ref .= '<small>Published: '.$bo['published'].'</small>';
				$ref .= '</p>';
				
				$ref .= '</div></div></li>';
			}
		}
		$ref .= "</ul>";
		return $ref;
	}
	
	function book_show_list($options){
		$ref = '<ul class="ref_book_list">';
		$ref_options = get_option( 'ref_options' );
		$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		foreach($options['book'] as $bo){
			$link = false;
			if(is_array($ref_options) && isset($ref_options['ref_amazon_tag']) && $ref_options['ref_amazon_tag'] != '' && $bo['isbn']!=''){
				$link = true;
			}
			if($bo['title']!=""){
				$ref .= '<li class="boxlist"><div class="box accent book_ref">';
				if($link)$ref .= '<a href="http://www.amazon.com/dp/'.$bo['isbn'].'?tag='.$ref_options['ref_amazon_tag'].'" title="'.$bo['title'].'">';
				$ref .= '<strong>'.$bo['title'].' </strong><small>by</small> <em>'.$bo['author'].'</em>';
				if($link)$ref .= '</a>';
				if(isset($bo['haspreview']) && $bo['haspreview']=='1' && $bo['isbn']!=''){
					$ref .= ' | <a href="'.$x.'../previewbook.php?isbn='.$bo['isbn'].'" class="ref_preview_book" title="'.$bo['title'].'">Book Preview</a>';
				}
				
				$ref .= '</div></li>';
			}
		}
		$ref .= "</ul>";
		return $ref;
	}
}