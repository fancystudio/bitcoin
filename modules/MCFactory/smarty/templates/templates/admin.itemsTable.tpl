    <table cellspacing="0" class="pagetable">
        <thead>
            <tr>
                <th>{{$title_label}}</th>
                {foreach from=$columns item=column key=name name=foo}
                    <th>{$name}</th>
                {/foreach}
                <th colspan="5" style="text-align: right;"></th>
            </tr>
        </thead>
        <tbody>
        {if $rows|@count > 0}
            {foreach from=$rows item=row}
            <tr class="{cycle values="row1,row2"}" onmouseover="this.className='{cycle values="row1,row2"}hover';" onmouseout="this.className='{cycle values="row1,row2"}';">
                <td>{$row.titlelink}</td>
                {foreach from=$columns item=column}<td>{foreach name=colloop from=$column[$row.id] item=value}{$value->getTitle()}{if !$smarty.foreach.colloop.last},{/if} {/foreach}</td>{/foreach}
                <td>{$row.publishlink}</td>
                <td>{$row.editlink}</td>
                <td>{$row.deletelink}</td>
                <td>{$row.moveuplink}</td>
                <td>{$row.movedownlink}</td>
            </tr>
            {/foreach}
        {else}
            <tr><td>
                There are no results matching your criteria.
            </td></tr>
        {/if}
        </tbody>
    </table>
    {if $pages|@count > 1}<p>Page: {foreach from=$pages item=link key=i}{if ($i + 1) == $currentPage}<strong>{$link}</strong>{else}{$link}{/if} {/foreach}</p>{/if}

<div class="pageoptions">
                <p class="pageoptions">{$add_item_icon} {$add_item_link}</p>
</div>
