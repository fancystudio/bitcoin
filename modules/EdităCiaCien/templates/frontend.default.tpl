<ul>
	{foreach from=$EdităCiaCien item=item}
	<li><a href="{EdităCiaCien action="url_for" maction="detail" item_id=$item->getId() detailpage=$detailpage title=$item->title}">{$item->title}</a></li>
	{/foreach}
</ul>