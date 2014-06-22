<ul>
	{foreach from=$EditaciaCien item=item}
	<li><a href="{EditaciaCien action="url_for" maction="detail" item_id=$item->getId() detailpage=$detailpage title=$item->title}">{$item->title}</a></li>
	{/foreach}
</ul>