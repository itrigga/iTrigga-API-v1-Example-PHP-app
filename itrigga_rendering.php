<?php
	function render_item($item)
	{
		// aggregated/3rd-party articles have a clickthrough_url 
		if( $item->{'clickthrough_url'} )
		{
			echo '<h3><a href="' . $item->{"clickthrough_url"} . '" target="_blank">' . $item->{'name'} . '</a></h3>';
		}
		// editorial articles don't have a clickthrough_url, as their full content is available
		// so we can show the full content on this site
		//
		// NOTE: To keep it simple, this example code just links to item.php?id=(item id)
		// 		for best SEO impact, you should use the item permalink, e.g.
		//			<a href="articles/(item permalink)">(item name)</a>
		//		However, that would depend on web server config that is outside the scope of this example
		else {
			echo '<h3><a href="item.php?id=' . $item->{'id'} . '">' . $item->{'name'} . '</a></h3>';
		}

		echo '<span class="summary">' . $item->{"summary"} . '</span>';
		echo '<dl class="metadata">';
		if( $item->{'source'} ){
			echo '<dt>from</dt>';
			echo '<dd><a href="' . $item->{'source'}->{'site_url'} . '" target="_blank">' . $item->{'source'}->{'name'} . '</a></dd>';
		}
		echo '<dt>at</dt>';
		echo '<dd>' . date_format( date_create($item->{'updated_at'}), 'Y-m-d H:i:s' ) . '</dd>';
		echo '</dl>';
	}

	function render_pagination($this_page, $max_page)
	{
		echo '<div class="pagination"><span>page:</span>';

		if( $this_page > 4) {
			echo '<a href="channel.php?id=' . $_GET['id'] . '&page=1">' . 1 . '</a><span>...</span>';
		}
		for($p = max($this_page - 3, 1) ; $p <= min( $max_page, ($this_page + 3) ); $p++ ){
			if( $p == $this_page ){
				echo '<strong>' . $p . '</strong>';
			}
			else 
			{
				echo '<a href="channel.php?id=' . $_GET['id'] . '&page=' . $p .'">' . $p . '</a>';
			}
		}
		if($p < $max_page ){
			echo  '<span>...</span><a href="channel.php?id=' . $_GET['id'] . '&page=' . $max_page .'">' . $max_page . '</a>';
		}
		echo '</div>';
	}
	
	function render_tag_cloud($tags)
	{
		echo '<ul class="tags">';

		// work out max count so we can scale the cloud 
		$max_count = 0;
		foreach( $tags as $tag ){
			$count = intval( $tag->{"count"} );
			if( $count > $max_count ){
				$max_count = $count;
			}
		}
		
		// now actually render the cloud
		foreach( $tags as $tag ){
			$size = round( ($tag->{'count'} / $max_count) * 5);
			echo '<li><a href="tag.php?term=' . urlencode($tag->{'term'}) . '" class="tag-size-' . $size . '" title="' . $tag->{'count'} . '">' . $tag->{'term'} . '</a></li>';
		}
		echo '</ul>';
	}
?>