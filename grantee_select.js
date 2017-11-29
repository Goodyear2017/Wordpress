jQuery(function($) {
	$('#grantee').css('background-color','yellow');
   
	
$.getJSON("http://localhost/equalvoicenews/wp-content/plugins/grantee_customfield/grantee_jason.php", function(data){
	 var html = '<option value="0">-------Select a grantee--------</option>';
   
	
    var len = data.length;
    for (var i = 0; i< len; i++) {
        html += '<option value="'+ data[i].id + '">' + data[i].grantee_name + '</option>';
    }
	
     $('#grantee_select').append(html);
	
});

$('#grantee_select').change(function(){
var select_text= $(this).find(":selected").text();
$('#grantee').val(select_text);	

});
});  