<div class="pageoverflow">
<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th width="75%">{$nameprompt}</th>
      <th>{$defaultprompt}</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
{foreach from=$items item=entry}
   {cycle values="row1,row2" assign='rowclass'}
   <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
     <td>{$entry->name}</td>
     <td>{$entry->default}</td>
     <td>{$entry->editlink}</td>
     <td>{$entry->deletelink}</td>
   </tr>
{/foreach}
</table>
</div>
<div class="pageoverflow">
  <p class="pageoptions">{$newtemplatelink}</p>
</div>
