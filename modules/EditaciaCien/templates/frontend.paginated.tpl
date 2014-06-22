<ul>
{foreach from=$items item=item}
	<li><a href="{$item->detail_link}">{$item->title}</a></li>
{/foreach}
</ul>

{if $pager.has_to_paginate}
<ul class="pager">
	{if $pager.previous_page}<li class="previous"><a href="{$pager.previous_page}">Previous page</a></li>{/if}
	{foreach from=$pager.pages item=page}
	<li>{$page}</li>
	{/foreach}
	{if $pager.next_page}<li class="next"><a href="{$pager.next_page}">Next page</a></li>{/if}
</ul>
{/if}
