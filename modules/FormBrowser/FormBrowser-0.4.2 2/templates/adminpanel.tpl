<h3>{$title_section}</h3>
{$tab_headers}

{$start_administerformdata_tab}
{if isset($fbr_message)}<p>{$fbr_message}</p>{/if}

{if $browser_count > 0}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$title_browser_name}</th>
			<th>{$title_browser_alias}</th>
			<th>{$title_related_form}</th>
			<th>{$title_browser_administer}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$browsers item=entry}
		{cycle values='row1,row2' assign='rowclass'}
		<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
		<td>{$entry->name}</td>
		<td>{ldelim}FormBrowser browser='{$entry->usage}'{rdelim}</td>
		<td>{$entry->form_name}</td>
		<td>{$entry->adminlink}</td>
		<td>{$entry->exportlink}</td>
		<td>{$entry->editlink}</td>
		<td>{$entry->deletelink}</td>
		</tr>
	{/foreach}
	</tbody>
</table>
{/if}
<div class="pageoptions">
	<p class="pageoptions">{$addlink}{$addbrowser}</p>
</div>

{$end_tab}

{$start_configuration_tab}
{if $may_config == 1}
{$start_configform}
	<div class="pageoverflow">
		<p class="pagetext">{$title_date_format}</p>
		<p class="pageinput">{$input_date_format} {$title_date_format_help}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_suppress_email_on_edit}</p>
		<p class="pageinput">{$input_suppress_email_on_edit}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_strip_on_export}</p>
		<p class="pageinput">{$input_strip_on_export}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_export_file}</p>
		<p class="pageinput">{$input_export_file}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_export_file_encoding}</p>
		<p class="pageinput">{$input_export_file_encoding}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
	{$end_configform}
{else}
	<p>{$no_permission}</p>
{/if}
{$end_tab}

{$tab_footers}