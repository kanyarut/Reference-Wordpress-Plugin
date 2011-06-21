<?php $allposts = get_posts('numberposts=-1');
foreach($allposts as $p){ 
	if($p->ID == $post-> ID) continue; ?>
	<li><label><input type="checkbox" id="ref-post-checkbox-<?php echo $p->ID ?>" value="<?php echo $p->ID ?>" 
	<?php if(isset($options['related']) && in_array($p->ID,$options['related']))echo 'checked="checked"'; ?>
	data-title="<?php echo get_the_title($p->ID); ?>" /> <?php echo get_the_title($p->ID); ?></label></li>
<?php } ?>