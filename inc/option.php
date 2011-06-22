<div class="wrap">
	<?php screen_icon(); ?><h1><?php echo "<h2>" . __( ' Reference Plugin Options' ) . "</h2>"; ?></h1>
	<?php $options = get_option( 'ref_options' );  ?>
	<form method="post" action="options.php"> 
	<?php settings_fields( 'ref_plugin_options' ); ?>
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle"><span><?php _e('API Keys and Tags') ?></span></h3>
			<div class="inside">
				<table class="form-table">
					<tr>
						<th valign="top"><?php _e('Google Book API Key') ?></th>
						<td><input id="ref_gbook_api" type="text" class="regular-text" name="ref_options[ref_gbook_api]" value="<?php echo (isset($options['ref_gbook_api']))?$options['ref_gbook_api']:''; ?>" />
							<span class="description">(see <a href="https://code.google.com/apis/books/docs/v1/using.html#APIKey">Google Book API Documentation</a> for more information)</span>
						</td>
					</tr>
					<tr>
						<th valign="top"><?php _e('Amazon Affiliate Tracking ID') ?></th>
						<td><input id="ref_amazon_tag" type="text" class="regular-text" name="ref_options[ref_amazon_tag]" value="<?php echo isset($options['ref_amazon_tag'])?$options['ref_amazon_tag']:''; ?>" />
							<span class="description">(see <a href="https://affiliate-program.amazon.com">Amazon Associates Program</a> for more information)</span>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle"><span><?php _e('Display Options') ?></span></h3>
			<div class="inside">
				<table class="form-table">
					<tr>
						<th valign="top">Related entries title</th>
						<td><input id="ref_entries_title" type="text" class="regular-text" name="ref_options[ref_entries_title]" value="<?php echo isset($options['ref_entries_title'])?$options['ref_entries_title']:'Related Entries'; ?>" />
							<span class="description">(leave blank for no title)</span>
						</td>
					</tr>
					<tr>
						<th valign="top">External references title</th>
						<td><input id="ref_external_title" type="text" class="regular-text" name="ref_options[ref_external_title]" value="<?php echo isset($options['ref_external_title'])?$options['ref_external_title']:'External References'; ?>" />
							<span class="description">(leave blank for no title)</span>
						</td>
					</tr>
					<tr>
						<th valign="top">Book references title</th>
						<td><input id="ref_book_title" type="text" class="regular-text" name="ref_options[ref_book_title]" value="<?php echo isset($options['ref_book_title'])?$options['ref_book_title']:'Book References'; ?>" />
							<span class="description">(leave blank for no title)</span>
						</td>
					</tr>
					<tr>
						<th valign="top">Book Display</th>
						<td>
							<label><input type="radio" name="ref_options[ref_display]" value="list" <?php echo (isset($options['ref_display']) && $options['ref_display']=='list')?'checked="checked"':''; ?> /> List summary (title and author)</label><br/>
							<label><input type="radio" name="ref_options[ref_display]" value="grid" <?php echo (isset($options['ref_display']) && $options['ref_display']=='grid')?'checked="checked"':''; ?> /> Short book detail (small book thumbnail and details)</label><br/>
							<label><input type="radio" name="ref_options[ref_display]" value="full" <?php echo (isset($options['ref_display']) && $options['ref_display']=='full')?'checked="checked"':''; ?> /> Full book detail (big book thumbnail and details)</label>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<p><input type="submit" name="Submit" class="button-primary" value="Save Changes" /></p>
	</form>
</div>