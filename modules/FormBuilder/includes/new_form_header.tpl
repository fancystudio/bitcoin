{$fb_form_header}
{if $fb_form_done == 1}
	{* This first section is for displaying submission errors *}
	{if $fb_submission_error}
		<div class="error_message">{$fb_submission_error}</div>
		{if $fb_show_submission_errors}
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
	{if $fb_form_has_validation_errors}
		<div class="error_message">
		<ul>
		{foreach from=$fb_form_validation_errors item=thisErr}
			<li>{$thisErr}</li>
		{/foreach}
		</ul>
		</div>
	{/if}
	{if $captcha_error}
		<div class="error_message">{$captcha_error}</div>
	{/if}

	{* and now the form itself *}
	{$fb_form_start}
	<div>{$fb_hidden}</div>
