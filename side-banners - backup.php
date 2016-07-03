<?php
/*
Plugin Name: SideBanners
Version: 0.0.1
Description: Side banners is made to simplify the process of adding side banners to your WordPress website. You don't have touch any piece of code. Note, the banners are placed at the extreme left and right side of the Webpage, so it fits with all kinds of websites which have some extra space of a minimum 120px wide.
Author: David Wampamba (Gagawala Graphics Limited)
Author URI: http://fictiontoactual.wordpress.com
Plugin URI: gagawalagraphics.com/wp/plugins/side-banners.zip
Text Domain: side-banners
*/
/** Step 2 (from text above). */
add_action('admin_menu', 'banner_menu');
/** Step 1. */
function banner_menu() {
	add_menu_page( 'Side Banners', 'Side Banners', 'manage_options', 'left-right-banners', 'banner_options','',70 );
}
/** Step 3. */
function banner_options() {
	if ( !current_user_can( 'manage_options' ) ){
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	// Save attachment ID
	if ( isset( $_POST['save_settings'] )):
	if(isset( $_POST['lban_id'])){
		update_option( 'lban_attachment_id', absint( $_POST['lban_id']));
		}
	if(isset( $_POST['rban_id'])){
		update_option( 'rban_attachment_id', absint( $_POST['rban_id']));
		}
	endif;
	wp_enqueue_media();
?>
<form method="post">
<h3><?php _e( 'Left banner','side-banners'); ?></h3>
<hr/>
	<div class='image-preview-wrapper'>
		<img id='l_image-preview' src='<?php echo wp_get_attachment_url( get_option( 'lban_attachment_id' ) ); ?>' style="height:auto; width:120px" />
	</div>
	<p><label for="lurl"><?php _e( 'Link ','side-banners'); ?></label><input type="text" name="lurl" id="lurl" /> </p>
	<input id="lban_upload" name="lban_upload" type="button" class="button btn-upload" value="<?php _e( 'Add banner','side-banners'); ?>" />
	<input id="lban_remove" name="lban_remove" type="button" class="button btn-remove" value="<?php _e( 'Remove banner','side-banners'); ?>" />
	<input type='hidden' name='lban_id' id='lban_id' value='<?php echo get_option( 'lban_attachment_id' ); ?>' /> 
<h3><?php _e( 'Right banner','side-banners'); ?></h3>
<hr/>
<p><label for="rurl"><?php _e( 'Link ','side-banners'); ?></label><input type="text" name="rurl" id="rurl" /></p>
	<div class='image-preview-wrapper'>
		<img id='r_image-preview' src='<?php echo wp_get_attachment_url( get_option( 'rban_attachment_id' ) ); ?>' style="height:auto; width:120px">
	</div>
	<input id="rban_upload" name="rban_upload" type="button" class="button btn-upload" value="<?php _e( 'Add banner','side-banners'); ?>" />
	<input id="rban_remove" name="rban_remove" type="button" class="button btn-remove" value="<?php _e( 'Remove banner','side-banners'); ?>" />
	<input type='hidden' name='rban_id' id='rban_id' value='<?php echo get_option( 'rban_attachment_id' ); ?>' />
<h3><?php _e( 'Additional settings','side-banners'); ?></h3>
<hr/>
<p><label for="bwidth"><?php _e( 'Banner width: ','side-banners'); ?></label><input type="text" name="bwidth" id="bwidth" /> px</p>
<p><?php _e( 'Scroll mode  ','side-banners'); ?><label for="scroll"><input type="radio" name="mode" id="scroll" value="scroll"/ ><?php _e( 'Scroll ','side-banners'); ?></label>
<label for="static"><input type="radio" name="mode" id="static" value="static" selected /><?php _e( 'Static:  ','side-banners'); ?></label></p>
<p><?php _e( 'Load in ','side-banners'); ?><label for="new_tab"><input type="radio" name="tab" id="new_tab" value="new_tab"/ ><?php _e( 'New tab/Window ','side-banners'); ?></label> <label for="same"><input type="radio" name="tab" id="same" value="same" selected /><?php _e( 'Same ','side-banners'); ?></label></p>
<p><?php _e( 'Hide on ','side-banners'); ?><label for="xs"><input type="checkbox" name="hideon" id="xs" value="xs" /><?php _e( 'Extra small device ','side-banners'); ?></label>
<label for="sm"><input type="checkbox" name="hideon" id="sm" value="small" /><?php _e( 'Small device ','side-banners'); ?></label>
<label for="med"><input type="checkbox" name="hideon" id="med" value="medium "/><?php _e( 'Medium device ','side-banners'); ?></label>
<label for="large"><input type="checkbox" name="hideon" id="large" value="large" /><?php _e( 'Large device ','side-banners'); ?></label>
</p>
<p><input type="submit" name="save_settings" value="Save settings" /></p>
</form>
<?php
}
add_action( 'admin_footer', 'banner_scripts' );
function banner_scripts() {
	$lban_id = get_option( 'lban_attachment_id', 0 );
	$rban_id = get_option( 'rban_attachment_id', 0 );
	?><script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var l_file_frame,r_file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var l_banner_id = <?php echo $lban_id; ?>; // Set this
			var r_banner_id = <?php echo $rban_id; ?>; // Set this
			jQuery('.btn-upload').on('click', function( event){
				var btn_id  = $(this).attr('id'); //Get id of the click button
				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( l_file_frame ) {
					// Set the post ID to what we want
					l_file_frame.uploader.uploader.param( 'post_id', l_banner_id );
					// Open frame
					l_file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = l_banner_id;
				}

				// Create the media frame.
				l_file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				l_file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = l_file_frame.state().get('selection').first().toJSON();

					// Do something with attachment.id and/or attachment.url here
					$( '#l_image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#lban_id' ).val( attachment.id );

					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});

					// Finally, open the modal
					l_file_frame.open();
			});
			
			jQuery('#rban_upload').on('click', function( event ){

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( r_file_frame ) {
					// Set the post ID to what we want
					r_file_frame.uploader.uploader.param( 'post_id', r_banner_id );
					// Open frame
					r_file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = r_banner_id;
				}

				// Create the media frame.
				r_file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				r_file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = r_file_frame.state().get('selection').first().toJSON();

					// Do something with attachment.id and/or attachment.url here
					$( '#r_image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#rban_id' ).val( attachment.id );

					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});

					// Finally, open the modal
					r_file_frame.open();
			});

			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});

	</script><?php

}