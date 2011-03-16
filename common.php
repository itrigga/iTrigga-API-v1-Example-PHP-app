<?php
// pagination parameters passed to each page
$this_page = $_GET['page'];
if( $this_page == null )
{
	$this_page = 1;
}
$per_page = $_GET['per_page'];
if( $per_page == null )
{
	$per_page = 10;
}

function number_of_pages($size){
	GLOBAL $per_page;
	return floor($size / $per_page);
}
function first_on_page($size){
	GLOBAL $this_page, $per_page;
	$first = (($this_page - 1) * $per_page) + 1;
	if($first > $size){
		$first = $size;
	}
	return $first;
}
function last_on_page($size){
	GLOBAL $this_page, $per_page;
	$last = $this_page * $per_page;
	if($last > $size){
		$last = $size;
	}
	return $last;
}


// iTrigga will provide the site_key and api_key to you
$site_key = "parishilton";
$api_key = "1vBbtLg7_-BM_FBYSEOP";
?>