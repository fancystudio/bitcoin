<ul>
	{foreach from=$Dynamickepolia item=item}
	<li><a href="{Dynamickepolia action="url_for" maction="detail" item_id=$item->getId() detailpage=$detailpage title=$item->title}">{$item->title}</a></li>
	{/foreach}
</ul>