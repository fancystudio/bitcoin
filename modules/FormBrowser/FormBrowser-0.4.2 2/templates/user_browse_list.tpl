{* default user list template *}
<h2>{$browser_title}</h2>

{if isset($fbrp_message) && !empty($fbrp_message)}<h2>{$fbrp_message}</h2>{/if}

{if $fbrp_arr_searchfield != ""}
{$fbrp_startfbrsearchform}
{foreach from=$fbrp_arr_searchfield item=item}
<div style="float:left; width:61px;"><strong>{$item|upper}</strong>:</div>
<input name="{$item}" id="{$item}" value="" style="width:160px; margin-bottom:2px; border:#333 outset 1px;" /><br />
{/foreach}

{$submitbutton}
<input type="button" onclick="window.location.href='{$fbrp_searchcancel_url}'" value="{$fbrp_searchcancel}" />
{$fbrp_endfbrsearchform}
<p></p>
{/if}

{if $hasnav == 1}
<div class="module_bfr_browsenav">{$prev}&nbsp;({$pageof})&nbsp;{$pagelinks}&nbsp;{$next}</div>
{/if}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
		<th>&nbsp;</th>
		<th>{$title_sort_submit_date}</th>
        {if $userapproval}<th>{$title_user_approved}</th>{/if}
		{* if using the Advanced Browser type, you will probably
		 *	want to replace the loop below with specific fields. It
		 *  would then look like:
		 * <th>{$sortingnames[1]}</th><th>{$sortingnames[3]}</th><th>{$sortingnames[12]}</th>
		 *
		 * to get those index numbers, temporarily put in a loop
		 * like this:
		 * 
		 * <pre> {section name=namelist start=0 loop=$fieldcount}
		 * Index: {$smarty.section.namelist.index} -> {$sortingnames[$smarty.section.namelist.index]}<br />
		 * {/section}
		 * </pre>
		 *}

		{section name=namelist start=0 loop=$fieldcount}
			{if isset($sortingnames[$smarty.section.namelist.index])}
  				<th>{$sortingnames[$smarty.section.namelist.index]}</th>
			{else}
				<th>{$namelist[$smarty.section.namelist.index]}</th>
			{/if}
  		{/section}
		{if $allow_user_edit}<th></th>{/if}
		{if $allow_user_delete}<th></th>{/if} 
		</tr>
	</thead>
	<tbody>
	{foreach from=$list item=entry}
		<tr>
			<td>{$entry->viewlink}</td>
			<td>{$entry->submitted}</td>
			{* if using an Advanced template, you will probably
			 *	want to replace the loop below with specific fields. It
			 *  would then look like:
			 * <td>{$entry->fields[1]|escape}</td><td>{$entry->fields[3]|escape}</td><td>{$entry->fields[12]|escape}</td>
			 *
			 * to get those index numbers, see the note above
			 *}
			{section name=vals start=0 loop=$fieldcount}
				{if isset($entry->fields[$smarty.section.vals.index])}
  					<td>{$entry->fields[$smarty.section.vals.index]|escape}</td>
				{else}
					<td></td>
				{/if}
  			{/section}
			{if $allow_user_edit}<td>{$entry->editlink}</td>{/if}
			{if $allow_user_delete}<td>{$entry->deletelink}</td>{/if}
		</tr>
	{/foreach}
	</tbody>
</table>
{if $hasnav == 1}
<div class="module_bfr_browsenav">{$prev}&nbsp;{$pagelinks}&nbsp;{$next}</div>
{/if}
{if $allow_user_add}{$addlink}{$addresp}{/if}
