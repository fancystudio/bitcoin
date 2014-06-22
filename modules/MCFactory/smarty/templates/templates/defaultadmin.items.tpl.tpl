{if isset($filters_form)}
    <div style="border: 1px solid #eee;">
	{$filters_form->getHeaders()}
	Filter by:
	{$filters_form->showWidgets('%LABEL% %INPUT% ')}
		{$filters_form->getButtons()}
	{$filters_form->getFooters()}
    </div>
{/if}
{$filters_buttons}
<div style="float:right;">{if $items_top != ''}<div style="margin-bottom: 15px;">{$items_top} </div>{/if} (<strong>{$total_items} item{if $total_items gt 1}s{/if}</strong>) </div>
<div style="clear: both;"></div>

{if $rows|@count}
	{if isset($add_item_icon)}
	<div class="pageoptions">
	                <p class="pageoptions">{$add_item_icon} {$add_item_link}</p>
	</div>
	{/if}
{/if}

    <table cellspacing="0" class="pagetable" id="treetable">
        <thead>
            <tr>
                <th>{{$title_label}}</th>
                {foreach from=$columns item=column key=name name=foo}
                    <th>{$name}</th>
                {/foreach}
                <th colspan="8" style="text-align: right;"></th>
            </tr>
        </thead>
        <tbody>
        {if $rows|@count > 0}
            {foreach from=$rows item=row}
            <tr class="{cycle values="row1,row2"}" onmouseover="this.className='{cycle values="row1,row2"}hover';" onmouseout="this.className='{cycle values="row1,row2"}';" data-tt-id="{$row.id}" data-tt-parent-id="{$row.parent_id}">
                <td>{if isset($row.level)}{$row.arrow}&nbsp;{section name=level start=1 loop=$row.level}-&nbsp;&nbsp;&nbsp;{/section}{/if}{$row.titlelink}</td>
                {foreach from=$columns item=column}<td>{foreach name=colloop from=$column[$row.id] item=value}{$value}{if !$smarty.foreach.colloop.last},{/if} {/foreach}</td>{/foreach}
                <td>{$row.publishlink}</td>
                <td>{$row.previewlink}</td>
                <td>{$row.cmon}</td>
                <td>{$row.twitter}</td>
                <td>{$row.editlink}</td>
                <td>{$row.deletelink}</td>
                <td>{if isset($row.moveuplink)}{$row.moveuplink}{/if}</td>
                <td>{if isset($row.movedownlink)}{$row.movedownlink}{/if}</td>
            </tr>
            {/foreach}
        {else}
            <tr><td>
                There are no results matching your criteria.
            </td></tr>
        {/if}
        </tbody>
    </table>
	{if isset($pages)}
    {if $pages|@count > 1}<p>Page: {foreach from=$pages item=link key=i}{if ($i + 1) == $currentPage}<strong>{$link}</strong>{else}{$link}{/if} {/foreach}</p>{/if}
	{/if}
{if isset($add_item_icon)}
<div class="pageoptions">
                <p class="pageoptions">{$add_item_icon} {$add_item_link}</p>
</div>
{/if}
<div style="float:right;">{$items_bottom}</div><div style="clear:both;"></div>