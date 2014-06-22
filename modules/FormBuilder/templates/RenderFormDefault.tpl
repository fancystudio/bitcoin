{* DEFAULT FORM LAYOUT / pure CSS *}
{literal}
<script type="text/javascript">
function fbht(htid)
	{
		var fbhtc=document.getElementById(htid);
		if (fbhtc)
			{
			if (fbhtc.style.display == 'none')
				{
				fbhtc.style.display = 'inline';
				}
			else
				{
				fbhtc.style.display = 'none';
				}
			}
}
</script>
{/literal}
{$fb_form_header}
{if $fb_form_done == 1}
	{* This first section is for displaying submission errors *}
	{if isset($fb_submission_error) && $fb_submission_error}
		<div class="error_message">{$fb_submission_error}</div>
		{if isset($fb_show_submission_errors) && $fb_show_submission_errors}
			<div class="error">
			<ul>
			{foreach from=$fb_submission_error_list item=thisErr}
				<li>{$thisErr}</li>
			{/foreach}
			</ul>
		</div>
		{/if}
	{/if}
{else}
	{* this section is for displaying the form *}
	{* we start with validation errors *}
	{if isset($fb_form_has_validation_errors) && $fb_form_has_validation_errors}
		<div class="error_message">
		<ul>
		{foreach from=$fb_form_validation_errors item=thisErr}
			<li>{$thisErr}</li>
		{/foreach}
		</ul>
		</div>
	{/if}
	{if isset($captcha_error) && $captcha_error}
		<div class="error_message">{$captcha_error}</div>
	{/if}

	{* and now the form itself *}
	{$fb_form_start}
	<div>{$fb_hidden}</div>
	<div{if $css_class != ''} class="{$css_class}"{/if}>
	{if $total_pages gt 1}<span>{$title_page_x_of_y}</span>{/if}
	{foreach from=$fields item=entry}
		{if $entry->display == 1}
			{strip}
			{if $entry->needs_div == 1}
				<div
				{if $entry->required == 1 || $entry->css_class != '' || $entry->valid == 0} class="
					{if $entry->required == 1}required{/if}
					{if $entry->css_class != ''} {$entry->css_class}{/if}
					{if $entry->valid == 0} fb_invalid{/if}
					"
				{/if}
				>
			{/if}
			{if $entry->hide_name == 0}
				<label{if $entry->multiple_parts != 1} for="{$entry->input_id}"{/if}>{$entry->name}
				{if $entry->required_symbol != ''}
					{$entry->required_symbol}
				{/if}
				</label>
			{/if}
			{if $entry->multiple_parts == 1}
				{section name=numloop loop=$entry->input}
					{if $entry->label_parts == 1}
						<div>{$entry->input[numloop]->input}&nbsp;{$entry->input[numloop]->name}</div>
					{else}
						{$entry->input[numloop]->input}
					{/if}
					{if isset($entry->input[numloop]->op) && $entry->input[numloop]->op}{$entry->input[numloop]->op}{/if}
				{/section}
			{else}
				{if $entry->smarty_eval == '1'}{eval var=$entry->input}{else}{$entry->input}{/if}
			{/if}
			{if $entry->helptext != ''}&nbsp;<a href="javascript:fbht('{$entry->field_helptext_id}')"><img src="modules/FormBuilder/images/info-small.gif" alt="Help" /></a>
					<span id="{$entry->field_helptext_id}" style="display:none" class="fbr_helptext">{$entry->helptext}</span>{/if}
			{if $entry->valid == 0} &lt;--- {$entry->error}{/if}
			{if $entry->needs_div == 1}
				</div>
			{/if}
			{/strip}
		{/if}
	{/foreach}
	{if $has_captcha == 1}
		<div class="captcha">{$graphic_captcha}{$title_captcha}<br />{$input_captcha}</div>
	{/if}
	<div class="submit">{$prev}{$submit}</div>
	</div>
	{$fb_form_end}
{/if}
{$fb_form_footer}