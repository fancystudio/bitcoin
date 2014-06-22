{if isset($message)}{$message}{/if}

{$formstart}
{$formid}{$fb_hidden}
{$tab_start}

{$maintab_start}
<fieldset class="module_fb_fieldset"><legend>{$title_form_main}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_name}:</p>
		<p class="pageinput">{$input_form_name}</p>
	</div>
{if $adding == 0}
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_status}:</p>
		<p class="pageinput">{if $hasdisposition == 1}{$text_ready}{else}{$link_notready}{/if}</p>
	</div>
{/if}
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_alias}:</p>
		<p class="pageinput">{$input_form_alias}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_css_class}:</p>
		<p class="pageinput">{$input_form_css_class}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_inline_form}:</p>
		<p class="pageinput">{$input_inline_form}</p>
	</div>
</fieldset>
{if $adding==0}
<fieldset><legend>{$title_form_fields}</legend>
	{if $fastadd==1}
		<div class="pageoverflow">
			<p class="pagetext">{$title_fastadd}</p>
			<div class="pageinput">
				{$input_fastadd}
			</div>
		</div>
	{/if}
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_fields}</p>
		<div class="pageinput">
			<table class="module_fb_table pagetable" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						{if isset($title_field_id)}<th width="20">{$title_field_id}</th>{/if}
						<th width="20%">{$title_field_name}</th>
						{if isset($title_field_alias)}<th width="10%">{$title_field_alias}</th>{/if}
						<th width="20%">{$title_field_type}</th>
						{*<th width="20">{$title_field_required_abbrev}</th>*}
						<th>{$title_information}</th>
						<th width="20" class="updown">&nbsp;</th>
						<th width="20" class="updown">&nbsp;</th>
						<th class="pageicon">&nbsp;</th>
						<th class="pageicon">&nbsp;</th>
						<th class="pageicon">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				{foreach from=$fields item=entry}
					<tr id="fbrp_{$entry->id}" class="{$entry->rowclass}">
						{if isset($title_field_id)}
							<td>{$entry->id}</td>
						{/if}
						<td>{$entry->name}</td>
						{if isset($title_field_alias)}
							<td>{$entry->alias}</td>
						{/if}
						<td>{$entry->type}</td>
						<td>{$entry->field_status}</td>						
						<td class="updown">{$entry->up}</td>
						<td class="updown">{$entry->down}</td>				
						<td>{$entry->disposition}</td>					
						<td>{$entry->editlink}</td>
						<td>{$entry->deletelink}</td>
					</tr>
				{/foreach}
				</tbody>
            </table>
			{*<div class="reordermessage pagemcontainer" style="display:none"><p class="pagemessage">{$title_must_save_order}</p></div>*}	
			<br />
			{$add_field_link}
        </div>
     </div>
</fieldset>
{/if}
{$tab_end}{$submittab_start}
	<fieldset>
	<div class="pageoverflow">
		<p class="pageinput">{$title_submit_help}</p>
	</div>
	</fieldset>
<fieldset class="module_fb_fieldset"><legend>{$title_submit_actions}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_validate_udt}:</p>
		<p class="pageinput">{$input_form_validate_udt}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_submit_action}:</p>
		<p class="pageinput">{$input_submit_action}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_redirect_page}:</p>
		<p class="pageinput">{$input_redirect_page}</p>
	</div>
</fieldset>
<fieldset class="module_fb_fieldset"><legend>{$title_submit_labels}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$title_submit_button_safety}:</p>
		<p class="pageinput">{$input_submit_button_safety}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_submit_javascript}:</p>
		<p class="pageinput">{$input_submit_javascript}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_submit_button}:</p>
		<p class="pageinput">{$input_form_submit_button}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_next_button}:</p>
		<p class="pageinput">{$input_form_next_button}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_prev_button}:</p>
		<p class="pageinput">{$input_form_prev_button}</p>
	</div>
</fieldset>
{$tab_end}{$symboltab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_required_symbol}:</p>
		<p class="pageinput">{$input_form_required_symbol}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_unspecified}:</p>
		<p class="pageinput">{$input_form_unspecified}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_list_delimiter}:</p>
		<p class="pageinput">{$input_list_delimiter}</p>
	</div>
{$tab_end}{$udttab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_predisplay_udt}:</p>
		<p class="pageinput">{$input_form_predisplay_udt}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_predisplay_each_udt}:</p>
		<p class="pageinput">{$input_form_predisplay_each_udt}</p>
	</div>
{$tab_end}{$captchatab_start}
{if $captcha_installed}
	<div class="pageoverflow">
		<p class="pagetext">{$title_use_captcha}:</p>
		<p class="pageinput">{$input_use_captcha}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_title_user_captcha}:</p>
		<p class="pageinput">{$input_title_user_captcha}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_user_captcha_error}:</p>
		<p class="pageinput">{$input_title_user_captcha_error}</p>
	</div>
{else}
	<div class="pageoverflow">
		<p class="pageinput">{$title_install_captcha}</p>
	</div>
{/if}
{$tab_end}
{$templatetab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_load_template}:</p>
		<p class="pageinput">{$input_load_template}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_template}:</p>
		<p class="pageinput">{$input_form_template}</p>
	</div>
	<div class="pageoverflow">
		<div class="pageinput">{$help_template_variables}</div>
	</div>
{$tab_end}
{$submittemplatetab_start}
	<fieldset>
	<div class="pageoverflow">
		<div class="pageinput">{$title_submit_response_help}</div>
	</div>
	</fieldset>
	<div class="pageoverflow">
		<p class="pagetext">{$title_submit_response}:</p>
		<p class="pageinput">{$input_submit_response}</p>
		<div class="pageinput">{$help_submit_response}</div>
	</div>
{$tab_end}
{$tabs_end}
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$save_button}{$submit_button}{$cancel_button}</p>
	</div>
{$form_end}