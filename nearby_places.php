<?php
  $lat= $_GET['lat'];
  $long=$_GET['long'];
  $category=$_GET['category'];
  if($category=="false" || $category=="All places" || $category==""){
    $ch = curl_init("http://api.hoppr.com/offers/nearby.json?client=hoppr&latitude=".$lat."&longitude=".$long);
  }
  else{
    $ch = curl_init("http://api.hoppr.com/offers/nearby.json?client=hoppr&latitude=".$lat."&longitude=".$long."&category=".$category);
  }
	$a=curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec ($ch);
  	echo $data; 
?>
