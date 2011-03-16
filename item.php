
<?php

include 'common.php';
include 'itrigga_api.php';
include 'itrigga_rendering.php';

// get the item details
$item = api_call(full_api_url("items/" . $_GET['id']) );

?>


<html lang="en">
	<head xmlns="http://www.w3.org/1999/xhtml">
		<title>iTrigga PHP API Demo - Item - <?php echo $item->{'name'} ?></title>
		<meta charset="utf-8"/> 
		<link rel="stylesheet" type="text/css" href="screen.css" />
	</head>
	<body>
		<h1><?php echo $item->{'name'} ?></h1>
<?php 
		echo '<dl class="metadata">';
		
		// The source may sometimes not be available for a particular item
		// If it is available, we link out to it
		if( $item->{'source'} ){
			echo '<dt>from</dt>';
			echo '<dd><a href="' . $item->{'source'}->{'site_url'} . '" target="_blank">' . $item->{'source'}->{'name'} . '</a></dd>';
		}
		
		// Editorial articles and some third-party articles have the authors cited
		if( $item->{'detail'}->{'authors'} ){
			echo '<dt>by</dt><dd>' . $item->{'detail'}->{'authors'} . '</dd>';
		}
		
		// Articles may be in one or more channels
		if( $item->{'channels'} && sizeof( $item->{'channels'} ) > 0 ){
			echo '<dt>in</dt>';
			echo '<dd><ul class="channels">';
			foreach( $item->{'channels'}->{'channel'} as $channel ){
				echo '<li><a href="channel.php?id=' . $channel->{'id'} . '">' . $channel->{'name'} . '</a>';
			}
			echo '</ul></dd>';
		}
		
		echo '<dt>at</dt>';
		echo '<dd>' . date_format( date_create($item->{'updated_at'}), 'Y-m-d H:i:s' ) . '</dd>';
		echo '</dl>';
		
		// the item content itself
		echo '<div class="content">' . $item->{"content"} . '</div>';
		
		// most items (not all) have tags
		$tags = $item->{'item_tags'}->{'item_tag'};
		// if this one does, lets render a tag cloud
		if( $tags && sizeof( $tags ) > 0 ){
			echo '<h4>Top tags on &quot;' . $item->{"name"} . '&quot;</h4>';
			render_tag_cloud($tags);
		}
		

?>		
	
	</body>
</html>