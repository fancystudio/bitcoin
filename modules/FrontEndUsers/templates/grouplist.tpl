
{if $nprops == 0}
  <div class="red">{$mod->Lang('error_noproperties')}</div>
{elseif !isset($itemcount) || $itemcount == 0}
  <p>0&nbsp;{$groupsfound}</p>
{else}
  <p>{$itemcount}&nbsp;{$groupsfound}</p>
<table class="pagetable cms_sortable tablesorter">
	<thead>
		<tr>
			<th width="5%">{$idtext}</th>
			<th>{$nametext}</th>
			<th>{$desctext}</th>
			<th>{$mod->Lang('members')}</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
		<tr class="{$entry->rowclass}">
			<td>{$entry->id}</td>
			<td>{$entry->name}</td>
			<td>{$entry->desc}</td>
	                <td>{$entry->nusers|default:$mod->Lang('not_available')}</td>
			<td>{$entry->exportlink|default:''}</td>
			<td>{$entry->editlink|default:''}</td>
			<td>{$entry->deletelink|default:''}</td>
		</tr>
{/foreach}
	</tbody>
</table>
{/if}

<p class="pageoverflow">
{if $propcount > 0}{$addgrouplink|default:''}&nbsp;{/if}
{if isset($exportlink)}{$exportlink}&nbsp;{/if}
{$importlink|default:''}
</p>
