<?php $per_page = 30;
if(isset($_GET['key']) && isset($_GET['q']) && $_GET['key']!='' && $_GET['q']!=''){
	require_once('gbook.class.php');
	
	$q = trim($_GET['q']);
	$k = $_GET['key'];
	
	if(!isset($_GET['page']) || $_GET['page']==1){
		$page = 1;
		$page_start = 1;
	}else{
		$page = $_GET['page'];
		$page_start = (($page*$per_page) - $per_page) +1;
	}
	
	$gb = new gBook($k);
	$params['q'] = $q;
	$params['maxResults'] = $per_page;
	$params['startIndex'] = ($page_start==1)?0:$page_start;
	$books = $gb->getList($params);
	
	$page_end = ($page * $per_page);
	$page_total = ceil($books['totalItems'] / $per_page);
	if($page_end>$books['totalItems'])$page_end = $books['totalItems'];
	
	//echo'<pre>';print_r($books);die();
	?>
	<div class="book_search_meta">
	Showing <?php echo $page_start ?> - <?php echo $page_end ?> of <?php echo $books['totalItems'] ?> book(s) found
	<ul class="book_pagination">
		<li>Pages: </li>
		<?php 
			for($i=1;$i<=$page_total;$i++){
				if(($i > $page + 5) && ($i < $page_total - 4) && $page_total > 10)
					continue;
				else if(($i > $page + 4) && ($i < $page_total - 4) && $page_total > 10)
					echo "<li>&hellip;</li>";
				else if($i == $page)
					echo "<li>$i</li>";
				else
					echo "<li><a href='$i'>$i</a></li>";
			}
		?>
	</ul>
	</div><!-- book_search_meta -->
	<?php 
	if(isset($books['items']) && count($books['items']) > 0){
	foreach($books['items'] as $b){  $book = $b['volumeInfo'] ?>
	<div class="ref_book_item">
		<?php if(isset($book['imageLinks']['thumbnail'])){ ?>
			<img src="<?php echo $book['imageLinks']['thumbnail']?>" class="ref_bookcover" />
		<?php }else{ ?>
			<div class="ref_bookcover_noimg"></div>
		<?php } ?>
		<input type="hidden" name="ref_book_thumbnail_select" class="ref_book_thumbnail_select" value="<?php echo $book['imageLinks']['thumbnail']?>" />
		<input type="hidden" name="ref_book_thumbnailsm_select" class="ref_book_thumbnailsm_select" value="<?php echo $book['imageLinks']['smallThumbnail']?>" />
		<strong class="ref_book_title_select"><?php echo $book['title'];?></strong> [<?php echo strtoupper($book['language']);?>]<br/>
		<em class="ref_book_author_select"><?php echo @implode(', ',$book['authors']);?></em><br/><br/>
		ISBN: <?php echo $book['industryIdentifiers'][0]['identifier'];?><br/>
		Published: <span class="ref_book_published_select"><?php echo $book['publishedDate'];?></span><br/>
		Publisher: <span class="ref_book_publisher_select"><?php echo $book['publisher'];?></span><br/><br/>
		<a href="<?php echo $book['industryIdentifiers'][0]['identifier'];?>" class="ref_select_book">Select this Book</a>
		<?php if($b['accessInfo']['viewability'] == 'PARTIAL' || $b['accessInfo']['viewability'] == 'ALL_PAGES'){ ?> | <a href="<?php echo $book['industryIdentifiers'][0]['identifier'];?>" class="ref_preview_book">Book Preview</a><input type="hidden" value="1" class="ref_book_haspreview" />
		<?php }else{ ?>
			<input type="hidden" value="0" class="ref_book_haspreview" />
		<?php } ?>
	</div>
	<?php }} ?>
	<div class="book_search_meta">
	Showing <?php echo $page_start ?> - <?php echo $page_end ?> of <?php echo $books['totalItems'] ?> book(s) found
	<ul class="book_pagination">
		<li>Pages: </li>
		<?php 
			for($i=1;$i<=$page_total;$i++){
				if(($i > $page + 5) && ($i < $page_total - 4) && $page_total > 10)
					continue;
				else if(($i > $page + 4) && ($i < $page_total - 4) && $page_total > 10)
					echo "<li>&hellip;</li>";
				else if($i == $page)
					echo "<li>$i</li>";
				else
					echo "<li><a href='$i'>$i</a></li>";
			}
		?>
	</ul>
	</div><!-- book_search_meta -->
<?php }else if($_GET['key']==''){ ?>
<p>Please set Google Book API key to use Google Book Preview.</p>
<?php } ?>