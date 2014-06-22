{if isset($fbrp_message) && !empty($fbrp_message)}<p class="pagemessage">{$fbrp_message}</p>{/if}
{if $inner_nav !=''}<div class="module_bfr_innernav">{$inner_nav}</div>{/if}
{$formstart}{$browser_id}{$hidden}{$tab_start}{$maintab_start}

	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_name}:</p>
		<p class="pageinput">{$input_browser_name}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_alias}:</p>
		<p class="pageinput">{$input_browser_alias}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_css_class}:</p>
		<p class="pageinput">{$input_browser_css_class}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_form_id}:</p>
		<p class="pageinput">{$input_form_id}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_type}:</p>
		<p class="pageinput">{$input_browser_type}</p>
	</div>
	{if $field_count != 0}
	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_search_field}</p>
		<p class="pageinput">{$input_browser_search_field}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_udt_name}:</p>
		<p class="pageinput">{$input_udt_name}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext"></p>
		<p class="pageinput">{$title_field_count}<br />{$savemsg}</p>
	</div>
   {if $mode_simple == '1'}
	<div class="pageoverflow">
	
		<div class="pageinput">
			<table class="module_fbr_table pagetable" cellspacing=0 cellpadding=0 style="width: 800px; margin: 0">
			<tr><th>{$title_field_name}</th><th>{$title_list_order}</th><th>{$title_full_order}</th><th>{$title_admin_list_order}</td><th>{$title_admin_full_order}</th></tr>
			{foreach from=$fields item=entry}
				<tr><td width="300">{$entry->name}</td>
					<td>{$entry->list_order}</td>
					<td>{$entry->full_order}</td>
					<td>{$entry->admin_list_order}</td>
					<td>{$entry->admin_full_order}</td>
				</tr>
			{/foreach}
			<tr>
				<td></td>
				<td><a href="javascript:toggle_column('{$actionid}{$toggle_user_list}')">{$toggle_column}</a></td>
				<td><a href="javascript:toggle_column('{$actionid}{$toggle_user_full}')">{$toggle_column}</a></td>
				<td><a href="javascript:toggle_column('{$actionid}{$toggle_admin_list}')">{$toggle_column}</a></td>
				<td><a href="javascript:toggle_column('{$actionid}{$toggle_admin_full}')">{$toggle_column}</a></td>		
			</tr>
			</table>
		</div>
	</div>
	{else}
	  {foreach from=$fields item=entry}
	  	{$entry->list_order}{$entry->full_order}{$entry->admin_list_order}{$entry->admin_full_order}
	  {/foreach}
	{/if}
	{/if}

{$tab_end}
{$useroptiontab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_rows_per_page}:</p>
		<p class="pageinput">{$input_rows_per_page}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_require_admin_approval}:</p>
		<p class="pageinput">{$input_require_admin_approval}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_require_user_approval}:</p>
		<p class="pageinput">{$input_require_user_approval}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_allow_user_add}:</p>
		<p class="pageinput">{$input_allow_user_add}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_allow_user_edit}:</p>
		<p class="pageinput">{$input_allow_user_edit}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_allow_user_delete}:</p>
		<p class="pageinput">{$input_allow_user_delete}</p>
	</div>
{$tab_end}
{$adminoptiontab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_admin_rows_per_page}:</p>
		<p class="pageinput">{$input_admin_rows_per_page}</p>
	</div>
{$tab_end}
{$ulisttab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_load_template}:</p>
		<p class="pageinput">{$input_load_ul_template}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_user_list_template}:</p>
		<p class="pageinput">{$input_browser_user_list_template}</p>
	</div>
{$tab_end}
{$ufulltab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_load_template}:</p>
		<p class="pageinput">{$input_load_uf_template}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_user_full_template}:</p>
		<p class="pageinput">{$input_browser_user_full_template}</p>
	</div>
{$tab_end}
{$alisttab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_load_template}:</p>
		<p class="pageinput">{$input_load_al_template}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_admin_list_template}:</p>
		<p class="pageinput">{$input_browser_admin_list_template}</p>
	</div>
{$tab_end}
{$afulltab_start}
	<div class="pageoverflow">
		<p class="pagetext">{$title_load_template}:</p>
		<p class="pageinput">{$input_load_af_template}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_browser_admin_full_template}:</p>
		<p class="pageinput">{$input_browser_admin_full_template}</p>
	</div>
{$tab_end}
{$tabs_end}
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$save_button}{$submit_button}{$cancel}</p>
	</div>
{$form_end}
