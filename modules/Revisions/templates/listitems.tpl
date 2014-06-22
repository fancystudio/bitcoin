{if isset($title)}<h3>{$title}</h3>{/if}
{if $itemcount > 0}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th width="35">&nbsp;</th>
			<th>{$mod->Lang('name')}</th>
			<th>{$mod->Lang('revisions')}</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$items item=entry}
		<tr>
			<td>{$entry->hierarchy}</td>
            <td>{repeat string="-&nbsp;&nbsp;&nbsp;" times=$entry->depth}{$entry->namelink}</td>
            <td>{$entry->revisions}</td>
            <td>{$entry->detaillink}</td>
		</tr>
	{/foreach}
	</tbody>
</table>
{else}
<p>{$mod->Lang('norevisions')}</p>
{/if}