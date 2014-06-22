<ul>
	{foreach from=$Edit„CiaCien item=item}
	<li><a href="{Edit„CiaCien action="url_for" maction="detail" item_id=$item->getId() detailpage=$detailpage title=$item->title}">{$item->title}</a></li>
	{/foreach}
</ul>