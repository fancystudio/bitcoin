{if $message != ''}<div class="pagemcontainer"><p class="pagemessage">{$message}</p></div>{/if}

{$tabheaders}
{$start_formtab}
<table cellspacing="0" class="pagetable" width="80%">
<thead><tr>
	<th>{$title_form_name}</th>
	<th>{$title_form_alias}</th>
	<th width="50">&nbsp;</th>
	<th width="33">&nbsp;</th>
	<th width="33">&nbsp;</th>
</tr>
</thead>

{foreach from=$forms item=entry}
	<tr class="{$entry->rowclass}" onmouseover="this.className='{$entry->rowclass}hover';" onmouseout="this.className='{$entry->rowclass}';">
		<td>{$entry->name}</td>
		<td>&#123;FormBuilder form='{$entry->usage}'&#125;</td>
		<td>{$entry->xml}</td>
		<td>{$entry->editlink}</td>
		<td>{$entry->deletelink}</td>
	</tr>
{/foreach}

<tr>
	<td colspan="5">
{if $addlink != ''}{$addlink}{$addform}{/if}
	</td>
</tr>
</table>

<fieldset>
<legend>{$legend_xml_import}</legend>
{$start_xmlform}
<div class="pageoverflow">
	<p class="pagetext">{$title_xml_to_upload}:</p>
	<p class="pageinput">{$input_xml_to_upload}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_xml_upload_formname}:</p>
	<p class="pageinput">{$input_xml_upload_formname}&nbsp;<em>{$info_leaveempty}</em></p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_xml_upload_formalias}:</p>
	<p class="pageinput">{$input_xml_upload_formalias}&nbsp;<em>{$info_leaveempty}</em></p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$submitxml}</p>
</div>
{$end_xmlform}
</fieldset>
{$end_tab}
{$start_configtab}

{if $may_config == 1}
{$start_configform}
<div class="pageoverflow">
	<p class="pagetext">{$title_enable_fastadd}:</p>
	<p class="pageinput">{$input_enable_fastadd}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_hide_errors}:</p>
	<p class="pageinput">{$input_hide_errors}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_require_fieldnames}:</p>
	<p class="pageinput">{$input_require_fieldnames}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_unique_fieldnames}:</p>
	<p class="pageinput">{$input_unique_fieldnames}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_blank_invalid}:</p>
	<p class="pageinput">{$input_blank_invalid}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_relaxed_email_regex}:</p>
	<p class="pageinput">{$input_relaxed_email_regex}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_show_version}:</p>
	<p class="pageinput">{$input_show_version}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_enable_antispam}:</p>
	<p class="pageinput">{$input_enable_antispam}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_show_fieldids}:</p>
	<p class="pageinput">{$input_show_fieldids}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_show_fieldaliases}:</p>
	<p class="pageinput">{$input_show_fieldaliases}</p>
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
{$end_tabs}