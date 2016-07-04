<?php
/*
Plugin Name: Ultimate Side Banners
Version: 0.0.2
Description: Ultimate Side Banners, helps simplify the process of adding side banners to your WordPress website. You don't have touch any piece of code. Note, the banners are placed at the extreme left and right side of the Webpage, so it fits with all kinds of websites which have some extra space of a minimum 120px wide.
Author: David Wampamba (Gagawala Graphics Limited)
Author URI: http://fictiontoactual.wordpress.com
Plugin URI: http://github/wampamba/ultimate-side-banners
Text Domain: usb-side-banners
*/
/** Step 2 (Add action hook to admin menu). */
add_action('admin_menu', 'usb_banner_menu');
/** Step 1. */
function usb_banner_menu() {
	add_menu_page( 'Ultimate Side Banners', 'Ultimate Side Banners', 'manage_options', 'ultimate-side-banners', 'usb_banner_options','',70 );
}
/** Step 3. */
function usb_banner_options() {
	if ( !current_user_can( 'manage_options' ) ){
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	// Save attachment ID
	if ( isset( $_POST['save_settings'] )):
	if(isset( $_POST['lon'])){
		$lon = sanitize_text_field($_POST['lon']); //Sanitize input and convert to interger
		$lon = absint( $lon); //Shouldn't be negative value otherwise convert it
		update_option( 'lon', $lon); //Send to value to database
		}
	if(isset( $_POST['lban_id'])){
		$lbanid = intval(sanitize_text_field($_POST['lban_id']));//Sanitize input and convert to interger
		$lbanid	=	absint( $lbanid); //Make sure value is not a negative otherwise convert it
		update_option( 'lban_attachment_id', $lbanid); //Send value to database
		}
	if(isset( $_POST['lurl'])){
		$lurl = sanitize_text_field($_POST['lurl']); //Sanitize input
		$lurl = esc_url_raw($lurl); //Prepare url for database storage
		update_option( 'lurl', $lurl);
		}
	if(isset( $_POST['ron'])){
		$ron = intval(sanitize_text_field($_POST['ron'])); //Sanitize input and convert to interger
		$ron = absint( $ron); //Shouldn't be negative value otherwise convert it
		update_option( 'ron',$ron);
		}
	if(isset( $_POST['rban_id'])){
		$rbanid = intval(sanitize_text_field($_POST['rban_id']));//Sanitize input and convert to interger
		$rbanid	= absint( $rbanid); //Make sure value is not a negative otherwise convert it	
		update_option( 'rban_attachment_id',$rbanid);
		}
	if(isset( $_POST['rurl'])){
		$rurl = sanitize_text_field($_POST['rurl']); //Sanitize input
		$rurl = esc_url_raw($rurl); //Prepare url for database storage
		update_option( 'rurl', $rurl);
		}
	if(isset( $_POST['topoffset'])){
		$topoffset = intval(sanitize_text_field($_POST['topoffset']));//Sanitize input and convert to interger
		$topoffset = absint( $topoffset); //Make sure value is not a negative otherwise convert it		
		update_option( 'topoffset', $topoffset);
		}
	if(isset( $_POST['bwidth'])){
		$bwidth = intval(sanitize_text_field($_POST['bwidth']));//Sanitize input and convert to interger
		$bwidth	= absint( $bwidth); //Make sure value is not a negative otherwise convert it
		update_option( 'bwidth', $bwidth);
		}
	if(isset( $_POST['tab'])){
		$tab = sanitize_text_field($_POST['tab']);//Sanitize input
		update_option( 'tab', $tab);
		}
	if(isset( $_POST['mode'])){
		$usb_mode = sanitize_text_field($_POST['mode']);//Sanitize input
		update_option( 'mode', $usb_mode);
		}
	if(isset( $_POST['hideon'])){
		if(is_array($_POST['hideon'])){
		foreach($_POST['hideon'] as $value){
			$value = sanitize_text_field($value); //Sanitize value
			$hideon .=$value.' ';
		}
		}else{
			$hideon = sanitize_text_field($_POST['hideon']); //Sanitize input
		}
		update_option( 'hideon', $hideon);
	}
		endif;
	wp_enqueue_media();
?>
<h2>Ultimate Side banners</h2>
<hr/>
<p>Do you have a WordPress website where you want to utilize the empty space on the sides? This plugin is for you. It allows to add two similar or different banners in formats of JPG|PNG|GIF to your website.</p>
<p>If you provide a URL (Link), the banners will redirect your website visitors to the targeted link once clicked. This can improve website monitization. Feel free to play around with the options under Additional settings section.Do you have questions and inquiries? <a href="https://fictiontoactual.wordpress.com/contact/" target="_blank">Contact me</a></p>
<form method="post">
<h3><?php _e( 'Left banner','side-banners'); ?></h3>
<hr/>
<p><label for="lon">Turn <input type="radio" name="lon" id="lon" value="1" <?php if(get_option("lon")==1){ ?> checked="checked" <?php }?>/> On
<input type="radio" name="lon" id="lon" value="0" <?php if(get_option("lon")==0){ ?> checked="checked" <?php }?>/> Off</p>
	<div class='image-preview-wrapper'>
		<img id='l_image-preview' src='<?php echo wp_get_attachment_url( get_option( 'lban_attachment_id' ) ); ?>' style="height:auto; width:120px" />
	</div>
	<p><label for="lurl"><?php _e( 'Link ','side-banners'); ?></label><input type="text" name="lurl" id="lurl" value="<?php echo !empty(get_option( 'lurl' ))? esc_url(get_option('lurl')):'#'; ?>" /> </p>
	<input id="lban_upload" name="lban_upload" type="button" class="button btn-upload" value="<?php _e( 'Add banner','side-banners'); ?>" />
	<input id="lban_remove" name="lban_remove" type="button" class="button btn-remove" value="<?php _e( 'Remove banner','side-banners'); ?>" />
	<input type='hidden' name='lban_id' id='lban_id' value='<?php echo get_option( 'lban_attachment_id' ); ?>' /> 
<h3><?php _e( 'Right banner','side-banners'); ?></h3>
<hr/>
<p><label for="ron">Turn <input type="radio" name="ron" id="ron" value="1" <?php if(get_option("ron")==1){ ?>checked="checked" <?php }?> /> On
<input type="radio" name="ron" id="ron" value="0" <?php if(get_option("ron")==0){ ?>checked="checked" <?php }?> /> Off</p>
<p><label for="rurl"><?php _e( 'Link ','side-banners'); ?></label><input type="text" name="rurl" id="rurl" value="<?php echo !empty(get_option( 'rurl' ))?esc_url(get_option('rurl')):'#'; ?>" /></p>
	<div class='image-preview-wrapper'>
		<img id='r_image-preview' src='<?php echo wp_get_attachment_url( get_option( 'rban_attachment_id' ) ); ?>' style="height:auto; width:120px">
	</div>
	<input id="rban_upload" name="rban_upload" type="button" class="button btn-upload" value="<?php _e( 'Add banner','side-banners'); ?>" />
	<input id="rban_remove" name="rban_remove" type="button" class="button btn-remove" value="<?php _e( 'Remove banner','side-banners'); ?>" />
	<input type='hidden' name='rban_id' id='rban_id' value='<?php echo absint(intval(get_option( 'rban_attachment_id' ))); ?>' />
<h3><?php _e( 'Additional settings','side-banners'); ?></h3>
<hr/>
<p><label for="topoffset"><?php _e( 'Distance from top: ','side-banners'); ?></label><input type="text" name="topoffset" id="topoffset" value="<?php if(empty(get_option( 'topoffset' ))){ echo "50";}else{ echo esc_html(get_option('topoffset')); }?>" /> px, <span class="description">Works only if scroll mode is set to static.</span></p>
<p><label for="bwidth"><?php _e( 'Banner width: ','side-banners'); ?></label><input type="text" name="bwidth" id="bwidth" value="<?php if(empty(get_option( 'bwidth' ))){ echo "120";}else{echo esc_html(get_option( 'bwidth' )); } ?>" /> px</p>
<p><?php _e( 'Scroll mode  ','side-banners'); ?><label for="scroll"><input type="radio" name="mode" id="scroll" value="scroll" <?php if(get_option('mode')=="scroll"){ ?>checked="checked"<?php }?> / ><?php _e( 'Scroll ','side-banners'); ?></label>
<label for="static"><input type="radio" name="mode" id="static" value="static" <?php if(get_option('mode')=="static"){ ?>checked="checked"<?php }?> /><?php _e( 'Static','side-banners'); ?></label></p>
<p><?php _e( 'Load in ','side-banners'); ?><label for="new_tab"><input type="radio" name="tab" id="new_tab" value="new_tab" <?php if(get_option('tab')=="new_tab"){ ?>checked="checked"<?php }?> / ><?php _e( 'New tab/Window ','side-banners'); ?></label> <label for="same"><input type="radio" name="tab" id="same" value="same" <?php if(get_option('tab')=="same"){ ?>checked="checked"<?php }?>  /><?php _e( 'Same ','side-banners'); ?></label></p>
<p><?php _e( 'Hide on ','side-banners'); ?><label for="xs"><input type="checkbox" name="hideon[]" id="xs" value="xs" <?php if(strpos(get_option('hideon'),"xs") !== false){ ?>checked="checked"<?php }?> /><?php _e( 'Extra small device ','side-banners'); ?></label>
<label for="sm"><input type="checkbox" name="hideon[]" id="sm" value="small" <?php if(strpos(get_option('hideon'),"small") !== false){ ?>checked="checked"<?php }?> /><?php _e( 'Small device ','side-banners'); ?></label>
<label for="med"><input type="checkbox" name="hideon[]" id="med" value="medium" <?php if(strpos(get_option('hideon'),"medium") !== false){ ?>checked="checked"<?php }?> /><?php _e( 'Medium device ','side-banners'); ?></label>
<label for="large"><input type="checkbox" name="hideon[]" id="large" value="large" <?php if(strpos(get_option('hideon'),"large") !== false){ ?>checked="checked"<?php }?> /><?php _e( 'Large device ','side-banners'); ?></label>
</p>
<p><input type="submit" name="save_settings" value="Save settings" /></p>
</form>
<?php
}
add_action( 'admin_footer', 'usb_banner_scripts' );
function usb_banner_scripts() {
	$lban_id = get_option( 'lban_attachment_id', 0 );
	$rban_id = get_option( 'rban_attachment_id', 0 );
	?><script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame,banner_id;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var l_banner_id = <?php echo $lban_id; ?>; // Set this
			var r_banner_id = <?php echo $rban_id; ?>; // Set this
			jQuery('.btn-upload').on('click', function( event){
				event.preventDefault();
				var btn_id  = $(this).attr('id'); //Get id of the click button
					if(btn_id == "lban_upload"){
					banner_id = l_banner_id;
					}else{
					banner_id = r_banner_id;	
					}
				// If the media frame already exists, reopen it.
				if (file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', banner_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = banner_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					if(banner_id == l_banner_id){
					$( '#l_image-preview' ).attr( 'src', attachment.url ).css( 'width', '120px' );
					$( '#lban_id' ).val( attachment.id );
					}else{
					$( '#r_image-preview' ).attr( 'src', attachment.url ).css( 'width', '120px' );
					$( '#rban_id' ).val( attachment.id );
					}
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script><?php

}
add_action("wp_footer","usb_show_banners"); //Show the banners to website visitors. Hook to the footer wp_footer action
function usb_show_banners(){
if(get_option("lon")==1):
?>
<div class="floatbanners left">
<a href="<?php echo esc_url(get_option('lurl')); ?>" <?php if(get_option("tab")=="new_tab"){ echo 'target="_blank"'; } ?>>
<img src="<?php echo wp_get_attachment_url( get_option( 'lban_attachment_id' ) ); ?>" style="width: <?php echo (!empty(get_option('bwidth'))) ? esc_html(get_option('bwidth')).'px':'120px'; ?>">
</a>
</div>
<?php endif; 
if(get_option("ron")==1):
?>
<div class="floatbanners right">
<a href="<?php echo esc_url(get_option('rurl')); ?>" <?php if(get_option("tab")=="new_tab"){ echo 'target="_blank"'; } ?>>
<img src="<?php echo wp_get_attachment_url( get_option( 'rban_attachment_id' ) ); ?>" style="width: <?php echo (!empty(get_option('bwidth')))?esc_html(get_option('bwidth')).'px':'120px'; ?>">
</a>
</div>
<?php endif;?>
<?php
}
add_action("wp_head","usb_style_banners"); //Hook a stylesheet for the banners to the wp_head action
function usb_style_banners(){
?>
<style type="text/css">
.floatbanners.left{
	z-index: 90009;
	left:1px;
	}
.floatbanners.right{
	z-index: 90010;
	right:1px;
	}
.floatbanners{
		position:<?php if(get_option('mode')=="static"){ echo "fixed;\n"; }else{ echo "relative;\n"; } ?>
		top:<?php if(!empty(get_option('topoffset')) && get_option('mode')=="static"){ echo esc_html(get_option('topoffset'))."px;\n";}else{ echo "50px;\n";}?>
		width:<?php if(!empty(get_option('bwidth'))){ echo esc_html(get_option('bwidth'))."px;\n";}else{ echo "120px;\n"; }?>
	}
<?php if(strpos(get_option('hideon'),"xs")){ //Check of hide on extra small devices is on?>
@media only screen and (max-width:768px){
	.floatbanners{
		display:none !important;
		}
	}
<?php } if(strpos(get_option('hideon'),"small")){ //Check of hide on Small devices is on ?>
@media only screen and (max-width:1280px){
	.floatbanners{
		display:none !important;
		}
	}
<?php } ?>
</style>
<?php
}
