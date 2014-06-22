    <table cellspacing="0" class="pagetable" id="treetable">
        <thead>
            <tr>
                <th>Title</th>
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
<div style="float:right;">{$items_bottom}</div><div style="clear:both;"></div>