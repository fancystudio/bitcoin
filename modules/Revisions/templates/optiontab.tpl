{$startform}
<fieldset>
<legend>{$mod->Lang('general_options')}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('store_revisions_count')}:</p>
		<p class="pageinput">{$input_store_revisions_count}<br />{$mod->Lang('store_revisions_unlimited')}</p>
	</div>
	<div class="pageoverflow">
	<p class="pagetext">{$mod->Lang('delete_revisions_with_content')}:</p>
		<p class="pageinput">{$input_delete_revisions_with_content}</p>
	</div>
</fieldset>
<fieldset>
<legend>{$mod->Lang('delete_revisions')}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('delete_all_but')}:</p>
		<p class="pageinput">{$input_delete_all_but} {$submit_delete_all_but}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('delete_older_than')}:</p>
		<p class="pageinput datepicker">{$input_delete_older_than} {$submit_delete_older_than}</p>
	</div>
</fieldset>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$submit}</p>
</div>
{$endform}