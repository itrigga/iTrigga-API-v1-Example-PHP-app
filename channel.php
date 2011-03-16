<?php
include 'common.php';
include 'itrigga_api.php';
include 'itrigga_rendering.php';


$this_channel = null;

// get channels
$channels = api_call( full_api_url("channels") );
// find the current channel
// NOTE: current channel attributes coming in v1.1 API, so you'll be able to do this in one call
foreach( $channels->{'channel'} as $channel ){
	if( $channel->{'id'} == $_GET['id'] ){
		$this_channel = $channel;
	}
}

// get the items in this channel
$items = api_call( full_api_url("channels/" . $_GET['id']), $this_page, $per_page );

// top tags in this channel
$top_tags = api_call( full_api_url('item_tags') . "?channel_id=" . $_GET['id'] );
?>


<html lang="en">
	<head xmlns="http://www.w3.org/1999/xhtml">
		<title>iTrigga PHP API Demo - Channel - <?php echo $this_channel->{'name'} ?></title>
		<meta charset="utf-8"/> 
		<link rel="stylesheet" type="text/css" href="screen.css" />
	</head>
	<body>
		<h1><?php echo $this_channel->{'name'} ?></h1>
		
	<?php
		echo '<ul class="channels">';
		foreach( $channels->{'channel'} as $channel ){
			if( $channel->{'id'} == $_GET['id'] ){
				echo '<li>' . $channel->{'name'} . '</li>';
			} else {
				echo '<li><a href="channel.php?id=' . $channel->{'id'} . '">' . $channel->{'name'} . '</a></li>';
			}
		}
		echo '</ul>';
		// pagination example
		$number_of_items = $items->attributes()->{'size'};
		$pages = number_of_pages($number_of_items);
		echo 'Showing items ' . first_on_page($number_of_items) . ' to ' . last_on_page($number_of_items) . ' of ' . $number_of_items;
		if($pages > 1){
			render_pagination($this_page, $pages);
		}
		
		// output title, summary, source, published date/time for each item
		echo "<ul>";
		foreach( $items as $item ) {
			echo "<li>";
			render_item($item);
			echo "</li>";
		}
		echo "</ul>";
	
		// tag cloud
		$tags = $top_tags->{'item_tag'};
		if( $tags && sizeof( $tags ) > 0 ){
			echo '<h4>Top tags in &quot;' . $this_channel->{'name'} . '&quot;</h4>';
			render_tag_cloud($tags);
		}
	?>	
	</body>
</html>