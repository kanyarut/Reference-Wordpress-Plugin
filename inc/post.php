<?php $url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>
<div class="inside">
<h2>Related Entries: <button type="button" class="button-secondary" id="ref-add-related">Select Related Posts</button></h2>
<ul id="ref-selected-related" style="width:94%;padding-left:10px;">
	<?php 
	if(isset($options['related']) && is_array($options['related'])){
	foreach($options['related'] as $re){ 
		if(get_post_type($re) == 'post'){ ?>
	<li style="clear:both;border-bottom: 1px dotted #333;overflow:hidden"><?php echo get_the_title($re)?> <button type="button" class="button-secondary ref-remove-related" style="float:right;" >&times;</button>
		<input type="hidden" name="ref[related][]" value="<?php echo $re ?>" />
	</li>
	<?php }}}?>
</ul>

<h2>External References:</h2>

<div id="ref-external-container">
	<?php 
	if(isset($options['external']) && is_array($options['external'])){
		$i = 1;
		foreach($options['external'] as $ex){ ?>
		<p>
			<input type="text" name="ref[external][<?php echo $i ?>][title]" value="<?php echo $ex['title'] ?>" placeholder="Title" style="width:40%" />
			<input type="text" name="ref[external][<?php echo $i ?>][link]" value="<?php echo $ex['link'] ?>" placeholder="http://www.example.com" style="width:50%" />
			<button type="button" class="button-secondary ref-remove-external" >&times;</button>
		</p>	
	<?php $i++; } //end for external
	}else{ ?>
	<p>
		<input type="text" name="ref[external][1][title]" value="" placeholder="Title" style="width:40%" />
		<input type="text" name="ref[external][1][link]" value="" placeholder="http://www.example.com" style="width:50%" />
		<button type="button" class="button-secondary ref-remove-external" >&times;</button>
	</p>
	<?php } ?>
</div><!-- ref-external-container -->

<p>
	<button type="button" class="button-secondary ref-add-external">+ Add External Reference</button>
</p>

<h2>Book References:</h2>

<?php
$ref_options = get_option( 'ref_options' );
if(is_array($ref_options) && $ref_options['ref_gbook_api'] != '' ){ ?>
	<input type="hidden" id="ref_gbook_api_key" name="ref_gbook_api_key" value="<?php echo $ref_options['ref_gbook_api'] ?>" />
<?php }else{ ?>
	<p>Please set Google Book API key in <a href="/wp-admin/options-general.php?page=reference">plugin setting page</a> to use Google Book Preview and Amazon Affiliate Program.</p>
<?php } ?>

<div id="ref-book-container">
<?php 
if(isset($options['book']) && is_array($options['book'])){
	$i = 1;
	foreach($options['book'] as $bo){ ?>
	<div class="ref_a_book">
		<div class="ref_a_book_image">
			<img src="<?php echo ( isset($bo['thumbnail'])&& $bo['thumbnail']!='' )?$bo['thumbnail']:$url.'../img/custombookimage.gif'; ?>" class="ref-book-image" />
			<input type="hidden" name="ref[book][<?php echo $i ?>][thumbnail]" value="<?php echo (isset($bo['thumbnail']))?$bo['thumbnail']:''; ?>" class="ref-book-thumbnail" />
			<input type="hidden" name="ref[book][<?php echo $i ?>][thumbnailsm]" value="<?php echo (isset($bo['thumbnailsm']))?$bo['thumbnailsm']:''; ?>" class="ref-book-thumbnailsm" />
			<input type="hidden" name="ref[book][<?php echo $i ?>][haspreview]" value="<?php echo (isset($bo['haspreview']))?$bo['haspreview']:''; ?>" class="ref-book-haspreview" />
		</div>
		<button type="button" class="button-secondary ref-remove-book" >&times;</button>
		<a href="#" class="ref-gbook"><img src="<?php echo $url ?>../img/gbs_search.png" /></a>
		<div class="ref_a_book_detail">
			<p>
				<label>Title:</label>
				<input type="text" name="ref[book][<?php echo $i ?>][title]" value="<?php echo (isset($bo['title']))?$bo['title']:''; ?>" placeholder="Book Title" class="ref-book-title" />
			</p>
			<p>
				<label>Author:</label>
				<input type="text" name="ref[book][<?php echo $i ?>][author]" value="<?php echo (isset($bo['author']))?$bo['author']:''; ?>" placeholder="Author Name" class="ref-book-author" />
			</p>
			<p>
				<label>Published:</label>
				<input type="text" name="ref[book][<?php echo $i ?>][published]" value="<?php echo (isset($bo['published']))?$bo['published']:''; ?>" placeholder="Published Date" class="ref-book-published" />
			</p>
			<p>
				<label>ISBN:</label>
				<input type="text" name="ref[book][<?php echo $i ?>][isbn]" value="<?php echo (isset($bo['isbn']))?$bo['isbn']:''; ?>" placeholder="ISBN-10" class="ref-book-isbn" />
			</p>
			<p>
				<label>Publisher:</label>
				<input type="text" name="ref[book][<?php echo $i ?>][publisher]" value="<?php echo (isset($bo['publisher']))?$bo['publisher']:''; ?>" placeholder="Publisher Name" class="ref-book-publisher" />
			</p>
			<p>
				<label>Link to:</label> 
				<select name="ref[book][<?php echo $i ?>][linkto]"  class="ref-book-linkto">
					<option value="none" <?php echo (isset($bo['linkto']) && $bo['linkto']=='none')?'selected="selected"':''; ?>>No Link</option>
					<option value="Amazon" <?php echo (!isset($bo['linkto']) || (isset($bo['linkto']) && ($bo['linkto']=='Amazon' || $bo['linkto']=='')))?'selected="selected"':''; ?>>Amazon</option>
					<option value="Google" <?php echo (isset($bo['linkto']) && $bo['linkto']=='Google')?'selected="selected"':''; ?>>Google Books</option>
					<option value="External" <?php echo (isset($bo['linkto']) && $bo['linkto']=='External')?'selected="selected"':''; ?>>External Link</option>
				</select>
				<input type="text" name="ref[book][<?php echo $i ?>][external]" value="<?php echo (isset($bo['v']))?$bo['external']:''; ?>" placeholder="http://www.example.com/" class="ref-book-external"  style="<?php echo (isset($bo['linkto']) && $bo['linkto']=='External')?'':'display:none'; ?>" />
			</p>
		</div>
	</div>	
<?php $i++; } //end for external
}else{ ?>
<div class="ref_a_book">
	<div class="ref_a_book_image">
		<img src="<?php echo $url?>../img/custombookimage.gif" class="ref-book-image" />
		<input type="hidden" name="ref[book][1][thumbnail]" value="" class="ref-book-thumbnail" />
		<input type="hidden" name="ref[book][1][thumbnailsm]" value="" class="ref-book-thumbnailsm" />
		<input type="hidden" name="ref[book][1][haspreview]" value="" class="ref-book-haspreview" />
	</div>
	<button type="button" class="button-secondary ref-remove-book" >&times;</button>
	<a href="#" class="ref-gbook"><img src="<?php echo $url ?>../img/gbs_search.png" /></a>
	<div class="ref_a_book_detail">
		<p>
			<label>Title:</label>
			<input type="text" name="ref[book][1][title]" value="" placeholder="Book Title" class="ref-book-title" />
		</p>
		<p>
			<label>Author:</label>
			<input type="text" name="ref[book][1][author]" value="" placeholder="Author Name" class="ref-book-author" />
		</p>
		<p>
			<label>Published:</label>
			<input type="text" name="ref[book][1][published]" value="" placeholder="Published Date" class="ref-book-published" />
		</p>
		<p>
			<label>ISBN:</label>
			<input type="text" name="ref[book][1][isbn]" value="" placeholder="ISBN-10" class="ref-book-isbn" />
		</p>
		<p>
			<label>Publisher:</label>
			<input type="text" name="ref[book][1][publisher]" value="" placeholder="Publisher Name" class="ref-book-publisher" />
		</p>
		<p>
			<label>Link to:</label> 
			<select name="ref[book][1][linkto]"  class="ref-book-linkto">
				<option value="none">No Link</option>
				<option value="Amazon" selected="selected">Amazon</option>
				<option value="Google">Google Books</option>
				<option value="External">External Link</option>
			</select>
			<input type="text" name="ref[book][1][external]" value="" placeholder="http://www.example.com/" class="ref-book-external" style="display:none" />
		</p>
	</div>
</div>
<?php } ?>
</div><!-- ref-book-container -->
<p class="">
	<button type="button" class="button-secondary" id="ref-add-book">+ Add Another Book Reference</button>
</p>

</div><!-- inside -->

<div id="ref-book-dialog" style="display:none;">
	Book Title: <input type="text" name="ref_title" placeholder="Book Title"  id="ref_title" style="width:200px" />
	Author: <input type="text" name="ref_author" placeholder="Book Author"  id="ref_author" style="width:200px" />
	ISBN: <input type="text" name="ref_isbn" placeholder="ISBN-10"  id="ref_isbn" style="width:100px" />
	<input type="button" name="ref_search" value="Search Book" id="ref_book_search" class="button-secondary" />
	<img src="<?php echo $url ?>../img/poweredbygoogle.png" valign="middle" style="float:right" />
	<div id="ref-book-dialog-search"></div>
</div>

<div id="ref-list-dialog" style="display:none;">
	<ul id="ref-posts-list" style="height:350px;overflow-x:hidden;overflow-y:scroll;">
		<?php include($x.'list.php'); ?>
	</ul>
	<p style="padding-top: 8px;">
		<button type="button" class="button-primary" id="ref-select-list">Select</button> or <a href="#" id="ref-cancel-list">Cancel</a>
	</p>
</div><!-- ref-list-dialog -->

<script type="text/javascript">
var pluginurl = "<?php echo $url ?>";
</script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="<?php echo $url ?>../js/postedit.js"></script> 
<br/>