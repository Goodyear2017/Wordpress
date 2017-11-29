<?php
if ( ! defined( 'ABSPATH' ) ) exit;
	
	function wp_sms_subscribe_meta_box() {
		add_meta_box('subscribe-meta-box', __('Subscribe SMS', 'wp-sms'), 'wp_sms_subscribe_post', 'post', 'normal', 'high');
	}

	if(get_option('wp_subscribes_send'))
		add_action('add_meta_boxes', 'wp_sms_subscribe_meta_box');
	
	function wp_sms_subscribe_post($post) {
	
		$values = get_post_custom($post->ID);
		$selected = isset( $values['subscribe_post'] ) ? esc_attr( $values['subscribe_post'][0] ) : '';
		wp_nonce_field('subscribe_box_nonce', 'meta_box_nonce');
		
		include_once dirname( __FILE__ ) . "/includes/templates/wp-meta-box.php";
	}

	function wp_sms_subscribe_post_save($post_ID) {
	
		if(!current_user_can('edit_post')) return;

		if( isset( $_POST['subscribe_post'] ) )
			update_post_meta($post_ID, 'subscribe_post', esc_attr($_POST['subscribe_post']));
			
	}
	add_action('save_post', 'wp_sms_subscribe_post_save');

	function wp_sms_subscribe_send($wp_sms_new_status = NULL,
  $wp_sms_old_status = NULL,
  $post_ID = NULL) {
	
		if(isset( $_POST['subscribe_post'] ) && ($_POST['subscribe_post'] == 'yes') ){
			
			 
 	date_default_timezone_set('America/Los_Angeles');
	$hours=date('H');	 	 
 
if($hours >7 && $hours <19){
	

		if ( 'publish' == $wp_sms_new_status && 'publish' != $wp_sms_old_status ) {
			global $wpdb, $table_prefix, $sms;
			$cat_exc=array(271,279,277,41,1679,5204,9751,298);
			
			 
			if(!(in_category($cat_exc))){
			$sms->to = $wpdb->get_col("SELECT mobile FROM {$table_prefix}sms_subscribes WHERE status = '1'");
			
			$string = get_option('wp_sms_text_template');
			
			$str=get_the_title($post_ID);
			$chr_map = array(
   // Windows codepage 1252
   "\xC2\x82" => "'", // U+0082⇒U+201A single low-9 quotation mark
   "\xC2\x84" => '"', // U+0084⇒U+201E double low-9 quotation mark
   "\xC2\x8B" => "'", // U+008B⇒U+2039 single left-pointing angle quotation mark
   "\xC2\x91" => "'", // U+0091⇒U+2018 left single quotation mark
   "\xC2\x92" => "'", // U+0092⇒U+2019 right single quotation mark
   "\xC2\x93" => '"', // U+0093⇒U+201C left double quotation mark
   "\xC2\x94" => '"', // U+0094⇒U+201D right double quotation mark
   "\xC2\x9B" => "'", // U+009B⇒U+203A single right-pointing angle quotation mark
    "\xC2\x96" => "-", //high hyphen
	 "\xC2\x97" => "--",       // Double hyphen
	 "\xC2\x85" => "...",      // Tripple dot

   // Regular Unicode     // U+0022 quotation mark (")
                          // U+0027 apostrophe     (')
   "\xC2\xAB"     => '"', // U+00AB left-pointing double angle quotation mark
   "\xC2\xBB"     => '"', // U+00BB right-pointing double angle quotation mark
   "\xE2\x80\x98" => "'", // U+2018 left single quotation mark
   "\xE2\x80\x99" => "'", // U+2019 right single quotation mark
   "\xE2\x80\x9A" => "'", // U+201A single low-9 quotation mark
   "\xE2\x80\x9B" => "'", // U+201B single high-reversed-9 quotation mark
   "\xE2\x80\x9C" => '"', // U+201C left double quotation mark
   "\xE2\x80\x9D" => '"', // U+201D right double quotation mark
   "\xE2\x80\x9E" => '"', // U+201E double low-9 quotation mark
   "\xE2\x80\x9F" => '"', // U+201F double high-reversed-9 quotation mark
   "\xE2\x80\xB9" => "'", // U+2039 single left-pointing angle quotation mark
   "\xE2\x80\xBA" => "'", // U+203A single right-pointing angle quotation mark
);
$chr = array_keys  ($chr_map); // but: for efficiency you should
$rpl = array_values($chr_map); // pre-calculate these two arrays
$str = str_replace($chr, $rpl, html_entity_decode($str, ENT_QUOTES, "UTF-8"));

			
			$template_vars = array(
			'title_post'	=>$str,
			
				//'title_post'		=>preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8","HTML-ENTITIES"); }, get_the_title($post_ID)),
				'url_post'			=> wp_get_shortlink($post_ID),
				'date_post'			=> get_post_time(get_option('date_format'), true, $post_ID)
			);
			$final_message = preg_replace("/%(.*?)%/ime", "\$template_vars['$1']", $string);
			
//$final_message  = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8","HTML-ENTITIES"); }, $input); 
		
			if( get_option('wp_sms_text_template') ) {
				$sms->msg = $final_message;
			} else {
				$sms->msg = get_the_title($post_ID);
			}
			
			$sms->SendSMS();
		}
		}
		}
		}
			return $post_ID;
	}
	if(get_option('wp_subscribes_send'))
		add_action('transition_post_status', 'wp_sms_subscribe_send',10,3);
	
	function wp_sms_register_new_subscribe($name, $mobile) {
	
		global $sms;
		
		$string = get_option('wp_subscribes_text_send');
		
		$template_vars = array(
			'subscribe_name'	=> $name,
			'subscribe_mobile'	=> $mobile
		);
		

		$final_message = preg_replace("/%(.*?)%/ime", "\$template_vars['$1']", $string);
		
		$sms->to = array($mobile);
		$sms->msg = $final_message;
		
		$sms->SendSMS();
	}
	if(get_option('wp_subscribes_send_sms'))
		add_action('wp_sms_subscribe', 'wp_sms_register_new_subscribe', 10, 2);
?>
