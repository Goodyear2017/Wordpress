<?php


global $wpdb;
$grantees=array();
$results=$wpdb->get_results("SELECT * FROM wp_grantee ORDER BY grantee_id") or die(mysql_error());
foreach($results as $result){
	$grantee_name=$result->grantee_news;
	if($grantee_name==NULL){
	$grantee_name=$result->grantee_casey;
	
	}
	
	$grantees[] = array('id'=>$result->grantee_id,'grantee_name'=>$grantee_name);
}
 echo json_encode($grantees);
?>
  