<ul>
	{foreach from=${{$module->getModuleName()}} item=item}
	<li><a href="{{literal}}{{{/literal}}{{$module->getModuleName()}} action="url_for" maction="detail" item_id=$item->getId() detailpage=$detailpage title=$item->title}">{$item->title}</a></li>
	{/foreach}
</ul>