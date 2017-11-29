(function($) {
 "use strict";
	$(window).load(function(){
	$('.floating_box').delay(10000).show(0);
	$('#box_move').click(function(){
		$(this).parent().hide();
	});
$('#top_nav').click(function(){
	
	$('#top_menu').show();
	$('#menu_text').html('X');
	$('#menu_text').css('cursor','pointer');
});

$("#menu_text").click(function(){
	$('#top_menu').hide();
	$('#menu_text').html('Menu');
});

$('#embed_code').hide();
$('#embed_code').hide();
$('.allow').click(function(){
$('#embed_code').toggle();
});

});

})(jQuery); 