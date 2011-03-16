<html lang="en">
	<head xmlns="http://www.w3.org/1999/xhtml">
		<title>iTrigga PHP API Demo - Channels</title>
		<meta charset="utf-8"/> 
		<link rel="stylesheet" type="text/css" href="screen.css" />
	</head>
	<body>
		<h1>iTrigga PHP API Demo - Channels</h1>
<?php

include 'common.php';
include 'itrigga_api.php';
include 'itrigga_rendering.php';

// MAIN PROCESS STARTS HERE

// get channels
$channels = api_call( full_api_url("channels") );
// get top tags across all channels
$top_tags = api_call( full_api_url('item_tags'), 1, 50 );

// loop round each channel and output a link to the channel page
echo '<ul>';
foreach( $channels->{'channel'} as $channel ){
	echo '<li><a href="channel.php?id=' . $channel->{'id'} . '">' . $channel->{"name"} . "</a></li>";
}
echo '</ul>';

// tag cloud
$tags = $top_tags->{'item_tag'};
if( $tags && sizeof( $tags ) > 0 ){
	echo '<h4>Top tags</h4>';
	render_tag_cloud($tags);
}
?>
</body>
</html>