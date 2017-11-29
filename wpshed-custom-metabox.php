<?php
/*
Plugin Name: EVN Custom Meta Boxes
Plugin URI: https://equalvoiceaction.com/
Description: Create Meta Boxes for EVN.
Version: 0.1
Author: Lili Xie
Author URI: https://equalvoiceaction.com/
License: GPL v2 or higher
License URI: License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


function wpshed_get_custom_field( $value ) {
	global $post;

    $custom_field = get_post_meta( $post->ID, $value, true );
    if ( !empty( $custom_field ) )
	    return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );

    return false;
}

// Register the Metabox
function wpshed_add_custom_meta_box() {
	add_meta_box( 'wpshed-meta-box', __( 'Organization', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'normal', 'high' );
	
}
add_action( 'add_meta_boxes', 'wpshed_add_custom_meta_box',2000 );

// Output the Metabox
function wpshed_meta_box_output( $post ) {
	// create a nonce field
	wp_nonce_field( 'my_wpshed_meta_box_nonce', 'wpshed_meta_box_nonce' ); ?>
	
	<p>
		<label for="grantee"><?php _e( 'Organization', 'textdomain' ); ?>:</label>
		<input type="text" name="grantee" id="grantee" value="<?php echo wpshed_get_custom_field( 'grantee' ); ?>" size="70" />
    </p>
    <p>
     <label>MCF Grantee</label>
        <select id="grantee_select"> 
        <option value="0">----------</option>
        <?php 
		global $wpdb;
		$results=$wpdb->get_results("SELECT * FROM wp_grantee ORDER BY grantee_id") or die(mysql_error());
foreach($results as $result){
	
	$grantee_name=$result->grantee_news;
	if($grantee_name==NULL){
	$grantee_name=$result->grantee_casey;
	
	}
	
	echo '<option value='.$grantee_name.'>'.$grantee_name.'</option>';
}
		?>
        </select>
        
  </p>
  
<script>
jQuery(function($) {
$('#grantee').css('background-color','yellow');
$('#grantee_select').change(function(){
var select_text= $(this).find(":selected").text();
$('#grantee').val(select_text);	

});
});  
</script>
    
	<?php
}
// Save the Metabox values
function wpshed_meta_box_save( $post_id ) {
	// Stop the script when doing autosave
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// Verify the nonce. If insn't there, stop the script
	if( !isset( $_POST['wpshed_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpshed_meta_box_nonce'], 'my_wpshed_meta_box_nonce' ) ) return;

	// Stop the script if the user does not have edit permissions
	if( !current_user_can( 'edit_post' ) ) return;

    // Save the textfield
	if( isset( $_POST['grantee'] ) )
		update_post_meta( $post_id, 'grantee', htmlspecialchars_decode( $_POST['grantee'] ) );
}
    // Save the textarea
	
add_action( 'save_post', 'wpshed_meta_box_save' );


// Place the metabox in the post edit page below the editor before other metaboxes (like the Excerpt)
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'normal', 'high' );
// Place the metabox in the post edit page below the editor at the end of other metaboxes
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'normal', '' );
// Place the metabox in the post edit page in the right column before other metaboxes (like the Publish)
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'side', 'high' );
// Place the metabox in the post edit page in the right column at the end of other metaboxes
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'side', '' );
?>