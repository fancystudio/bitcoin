{if $rows|count > 0}
<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th></th>
      <th></th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$rows item=row}
    <tr class="{cycle values="row1,row2"}" onmouseover="this.className='{cycle values="row1,row2"}hover';" onmouseout="this.className='{cycle values="row1,row2"}';">
      <td>{$row.titlelink}</td>
      <td></td>
      <td>{$row.editlink}</td>
      <td>{$row.deletelink}</td>
    </tr>
{/foreach}
  </tbody>
</table>
{/if}

<div class="pageoptions">
	<p class="pageoptions">{$add_item_icon} {$add_item_link}</p>
</div>
