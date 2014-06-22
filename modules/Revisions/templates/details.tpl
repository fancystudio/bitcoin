<script type="text/javascript">
PAGEBACK_URL = '{$pageback_url}';
PAGEBACK_TEXT = '{$pageback_text}';
</script>
{*cms_jquery*}
<h3>{$content_name}</h3>

{if $itemcount > 0}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$mod->Lang('name')}</th>
			<th width="150">{$mod->Lang('revision')}</th>
			<th width="170">{$mod->Lang('create_date')}</th>
			<th width="170">{$mod->Lang('user')}</th>
			<th class="pageicon">{$mod->Lang('undo')}</th>
			<th class="pageicon">{$mod->Lang('preview')}</th>
			<th class="pageicon">{$mod->Lang('compare')}</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$items item=entry name="revisions"}
		<tr>
            <td>{$entry->name}</td>
            <td>{$entry->revision_nr}</td>
            <td>{$entry->create_time|date_format:"%d.%m.%Y %H:%M:%S"}</td>
            <td>{$entry->username}</td>
            <td>{$entry->restorelink}</td>
            <td>{$entry->previewlink}</td>
            <td>{$entry->comparelink}</td>
		</tr>
	{/foreach}
	</tbody>
</table>
{/if}