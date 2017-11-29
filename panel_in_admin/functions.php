function left_panel( $atts, $content = null ) {
    return '<figure class="align-left">
<div class="special_box">
<div class="panel panel-default">
<div class="panel-body">'.$content.'</div>
</div>
</div>
</figure>';
}
function right_panel( $atts, $content = null ) {
    return '<figure class="align-right">
<div class="special_box">
<div class="panel panel-default">
<div class="panel-body">'.$content.'</div>
</div>
</div>
</figure>';
}

add_shortcode("left_panel", "left_panel");
add_shortcode("right_panel", "right_panel");
//add_shortcode("left_img", "left_img");
//add_shortcode("right_img", "right_img");
add_action('init', 'add_button');
function add_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
   
    add_filter('mce_external_plugins', 'add_plugin');
     add_filter('mce_buttons', 'register_button');
   }
}
function register_button($buttons) {
   array_push($buttons, "left_panel","right_panel");
   return $buttons;
}
function add_plugin($plugin_array) {
   $plugin_array['left_panel'] = get_stylesheet_directory_uri().'/inc/js/left_panel_button.js';
   $plugin_array['right_panel'] = get_stylesheet_directory_uri().'/inc/js/right_panel_button.js';
   
   return $plugin_array;
}
