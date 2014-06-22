<div class="pageoverflow">
	<table cellspacing="0" class="pagetable">
		<thead>
			<tr>
				<th class="pageicon">{$id}</th>
				<th class="pageicon">{$active}</th>
				<th>{$header_name}</th>
				<th class="pageicon">&nbsp;</th>
				<th class="pageicon">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$items item=entry}
            {cycle values="row1,row2" assign='rowclass'}
			<tr class="{$entry->rowclass}" onmouseover="this.className='{$entry->rowclass}hover';" onmouseout="this.className='{$entry->rowclass}';">
				<td>{$entry->id}</td>
				<td>{$entry->active}</td>
				<td>{$entry->title}</td>
                <td>{$entry->editlink}</td>
                <td>{$entry->deletelink}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</div>
<div class="pageoverflow">
    <p class="pageoptions">{$addlink}</p>
</div>