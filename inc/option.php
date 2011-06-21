<div class="wrap">
	<?php screen_icon(); ?><h1><?php echo "<h2>" . __( ' Reference Plugin Options' ) . "</h2>"; ?></h1>
	<?php $options = get_option( 'ref_options' );  ?>
	<form method="post" action="options.php"> 
	<?php settings_fields( 'ref_plugin_options' ); ?>
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle"><span>Options</span></h3>
			<div class="inside">
				<table class="form-table">
					<tr>
						<th valign="top">Google Book API Key</th>
						<td><input id="ref_gbook_api" type="text" class="regular-text" name="ref_options[ref_gbook_api]" value="<?php echo (isset($options['ref_gbook_api']))?$options['ref_gbook_api']:''; ?>" />
							<span class="description">(see <a href="https://code.google.com/apis/books/docs/v1/using.html#APIKey">Google Book API Documentation</a> for more information)</span>
						</td>
					</tr>
					<tr>
						<th valign="top">Amazon Affiliate Tracking ID</th>
						<td><input id="ref_amazon_tag" type="text" class="regular-text" name="ref_options[ref_amazon_tag]" value="<?php echo isset($options['ref_amazon_tag'])?$options['ref_amazon_tag']:''; ?>" />
							<span class="description">(see <a href="https://affiliate-program.amazon.com">Amazon Associates Program</a> for more information)</span>
						</td>
					</tr>
					<tr>
						<th valign="top">Book Display as</th>
						<td>
							<label><input type="radio" name="ref_options[ref_display]" value="list" <?php echo (isset($options['ref_display']) && $options['ref_display']=='list')?'checked="checked"':''; ?> /> List</label><br/>
							<label><input type="radio" name="ref_options[ref_display]" value="grid" <?php echo (isset($options['ref_display']) && $options['ref_display']=='grid')?'checked="checked"':''; ?> /> Grid</label>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<p><input type="submit" name="Submit" class="button-primary" value="Save Changes" /></p>
	</form>
</div>