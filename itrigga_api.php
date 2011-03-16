<?php 
// base iTrigga API url
$base_url = 'http://api.itrigga.com/api/v1/';
$format = 'xml';

// hit the given url and get the content
function get_data($url)
{
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

// parse the given string in xml or json format, depending on the global $format variable
function parse($string)
{
	GLOBAL $format;
	
	switch( $format ){
		case "json":
			return json_decode($string);
			break;
		case "xml":
			return simplexml_load_string($string);
			break;
	}		
}

// converts a convenient relative URL (e.g. "items.xml") into a full absolute URL
function full_api_url($rel_path)
{
	GLOBAL $base_url, $format;
	
	// e.g. http://api.itrigga.com/api/v1/items/1234.xml
	return $base_url . $rel_path . "." . $format . "?";
}

// make the API call and return the parsed results
function api_call($url, $page=1, $per_page=100)
{
	GLOBAL $site_key, $api_key;
	
	$has_query_string = strpos($url, "?");
	if($has_query_string === false){
		$url = $url . "?";
	}
	// identification
	$url = $url . "&site_key=" . $site_key . "&api_key=" . $api_key;
	
	// pagination
	$url = $url . "&page=" . $page . "&per_page=" . $per_page;
	
	$data = get_data($url);
	
	return parse($data);
}
?>