{*<div>*}
    {*{if isset($module_design)}*}
        {*<a href="{$module_design}" class="btn">Design</a>*}
    {*{/if}*}
{*</div>*}

{$form_start}
{$input_module_id}
<p style="text-align: right;">
	{$publish_button}
	{$save_button}
	{$cancel_button}
</p>

{$tab_headers}

{$start_main_tab}
<div class="pageoverflow2">
  <p class="pagetext2">Module name:</p>
  <p class="pageinput2">{$input_module_friendlyname}</p>
</div>

<div class="pageoverflow2">
  <p class="pagetext2">Title label:</p>
  <p class="pageinput2">{$input_title_label}</p>
</div>

<div id="structure" style="margin-bottom: 7px;">

    <button id="create-tab">+ Add a new tab</button>

	<ul>
		{foreach from=$structure->getTabs() item=tab key=tab_key}
		<li{if $active_fields_tab eq $tab_key} class="ui-tabs-selected ui-state-active"{/if}><a href="#struc-{$tab_key}">{$tab.name}</a></li>
		{/foreach}
	</ul>
	
	{foreach from=$structure->getTabs() item=tab key=tab_key}
		<div id="struc-{$tab_key}">
			<p style="text-align: right;"><button id="remove-tab-{$tab_key}">Remove this tab</button></p>
			
			<table style="width: 100%;" class="pagetable">
			<thead>
				<th colspan="2"></th>
				<th>Label</th>
				<th>Name</th>
				<th>Type</th>
				<th>Options</th>
				<th>Column</th>
				<th>Filter</th>
				<th>Frontend</th>
				<th></th>
			</thead>
			<tbody>
			
			{foreach from=$tab.fieldsets item=fieldset key=fieldset_key}
			<tr style="background-color: #aaa;">
				<td colspan="9">
					<strong>{$fieldset.name}</strong>
					<input type="hidden" name="{$module_id}fields_ordered[{$tab_key}][{$fieldset_key}]" />
				</td>
				<td style="text-align: right;">
					<span class="remove-fieldset" name='{ldelim}"tab_key":"{$tab_key}", "remove_fieldset":"{$fieldset_key}"{rdelim}'>{$remove_icon}</span>
				</td>
			</tr>
			
			{* FIELDS *}
			
			{if isset($fieldset.fields)}
			<tbody id="sortable-{$tab_key}-{$fieldset_key}">
			{foreach from=$fieldset.fields item=field}			
			<tr name="{$field.name}" class="{cycle values="row1,row2"}" onmouseover="this.className='{cycle values="row1,row2"}hover';" onmouseout="this.className='{cycle values="row1,row2"}';">
				<td colspan="2"></td>
				<td>{$field.label}</td>
				<td>{$field.name}</td>
				<td>{$field.type}</td>
				<td>{$field.options}</td>
				<td>{$field.column}</td>
				<td>{$field.filter}</td>
				<td>{$field.frontend}</td>
				<td style="text-align: right;" width="100">					
					<span class="edit-field" name='{ldelim}"tab_key":"{$tab_key}", "fieldset_key":"{$fieldset_key}","label":"{$field.label}","name":"{$field.name}","type":"{$field.type}","options":"{$field.options}","column":"{$field.column}","filter":"{$field.filter}","frontend":"{$field.frontend}"{rdelim}'>{$edit_icon}</span>
					<span class="remove-field" name='{ldelim}"tab_key":"{$tab_key}", "fieldset_key":"{$fieldset_key}","field":"{$field.name}"{rdelim}'>{$remove_icon}</span>
				</td>
			</tr>			
			{/foreach}		
			</tbody>
			{/if}
			
			<tr style="background-color: #efefef;">
				<td colspan="9"></td>
				<td style="text-align: right;"><span class="add-field" name='{ldelim}"tab_key":"{$tab_key}", "fieldset_key":"{$fieldset_key}"{rdelim}'>Add field</span></td>
			</tr>
			{/foreach}
			</tbody>
		</table>
								
		<p style="text-align: right;"><button class="add-fieldset" name="{$tab_key}">Add a fieldset</button></p>			
		
		</div>
	{/foreach}
</div>



<p>{* SPACER *}</p>



<div class="pageoverflow2">
	<p class="pagetext2">Filters:</p>
	<div class="pageinput2">
		<div id="filters">
			{foreach from=$filters key=i item=filter}
			<p class="filters_item">
				<label for="{$module_id}filters_{$i}_name">Name:</label> <input type="text" id="{$module_id}filters_{$i}_name" name="{$module_id}filters[{$i}][name]" value="{$filter.name}" size="30" />
				<label for="{$module_id}filters_{$i}_field">Field:</label> <input type="text" id="{$module_id}filters_{$i}_field" name="{$module_id}filters[{$i}][field]" value="{$filter.field}" size="10" />
				<label for="{$module_id}filters_{$i}_type">Type:</label> <select id="{$module_id}filters_{$i}_type" name="{$module_id}filters[{$i}][type]">
					{foreach from=$filter_types item=filter_type}
					<option value="{$filter_type.type}" {if $filter.type == $filter_type.type}selected="selected"{/if}>{$filter_type.label}</option>
					{/foreach}
				</select>
				<a href="#" class="filter_remove">Remove filter</a>
			</p>
			{/foreach}
		</div>
		<p><button id="filter_add">Add filter</button></p>
	</div>
</div>


{$end_tab}

{$start_actions_tab}
<div class="pageoverflow2">
		<p class="pagetext2">Specific module actions</p>
		<div class="pageinput2">
				<table style="width: 100%;" class="pagetable">
					<thead>
						<th>Name</th>
						<th>Is a public action</th>
						<th></th>
					</thead>
					<tbody id="actions">
						{foreach from=$actions item=action}
						<tr>
							<td>{$action->name}</td>
							<td>{$action->is_public_icon}</td>
							<td>{$action->edit_url} {$action->delete_url}</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			<p><input type="button" id="action_add" value="Add action" onClick="return parent.location='{$add_action_url}'" /></p>
		</div>
</div>
{$end_tab}

{$start_extra_features_tab}
<h2>Extra features</h2>
	<p><input type="button" value="Add event" onClick="return parent.location='{$add_event}'" /></p>

{if $events|@count > 0}
<div class="pageoverflow2">
		<p class="pagetext2">Specific module events</p>
		<div class="pageinput2">
				<table style="width: 100%;" class="pagetable">
					<thead>
						<th>Module name</th>
						<th>Event name</th>
						<th></th>
					</thead>
					<tbody id="actions">
						{foreach from=$events item=event}
						<tr>
							<td>{$event.module_name}</td>
							<td>{$event.event_name}</td>
							<td>{$event.edit} {$event.delete}</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			<p><input type="button" id="action_add" value="Add action" onClick="return parent.location='{$add_action_url}'" /></p>
		</div>
</div>
{/if}
	<p><input type="button" value="Add event" onClick="return parent.location='{$add_event}'" /></p>
{$end_tab}

{$start_logic_tab}
<div class="pageoverflow2">
	<p class="pagetext2">Specific module object logic (extends the module item class):</p>
	<p class="pageinput2">{$module_logic}</p>
</div>
{$end_tab}

{$start_options_tab}

{if isset($form_module_options)}
    {if $form_module_options->hasErrors()}<div style="color: red;">{$form_module_options->showErrors()}</div>{/if}

    {$form_module_options->showWidgets()}

    {$form_module_options->renderFieldsets()}

    <hr />
{/if}

<div class="pageoverflow2">
		<p class="pagetext2">Restore module templates</p>
		<div class="pageinput2">
			<p><input type="button" id="templates_restore" value="Restore templates" onClick="return parent.location='{$templates_restore_url}'" /></p>
		</div>
</div>
<hr />
<div class="pageoverflow2">
	<p class="pagetext2">Created by:</p>
	<p class="pageinput2">{$created_by} on {$created_at}</p>
</div>

<div class="pageoverflow2">
	<p class="pagetext2">Last updated by:</p>
	<p class="pageinput2">{$updated_by} on {$updated_at}</p>
</div>
{$end_tab}

{$tab_footers}

<p style="text-align: right;">
	{$publish_button}
	{$save_button}
	{$cancel_button}
</p>

</form>

{* MODAL BOXES *}
<div id="tab-form" title="Create a new tab">
	{if isset($tab_form)}
		{$tab_form->render()}
	{/if}
</div>

<div id="add-fieldset-form" title="Create a new fieldset">
	{if isset($fieldset_form)}
		{$fieldset_form->render()}
	{/if}
</div>

<div id="remove-fieldset-form" title="Remove fieldset">
		<p>Are you sure you want to delete the fieldset? This will also remove all the fields of this fieldset.</p>
	{if isset($remove_fieldset_form)}
		{$remove_fieldset_form->render()}
	{/if}
</div>

<div id="add-field-form" title="Add field">
	{if isset($add_field_form)}
		{$add_field_form->render()}
	{/if}
</div>

<div id="remove-field-form" title="Remove field">
	<p>Are you sure you want to delete this field?</p>
	{if isset($remove_field_form)}
		{$remove_field_form->render()}
	{/if}
</div>


{foreach from=$structure->getTabs() item=tab key=tab_key}

<div id="remove-tab-message-{$tab_key}" title='Remove tab "{$tab.name}"'>
	<p>Are you sure you want to delete the tab "{$tab.name}"? This will also remove all the fieldsets and fields.</p>
	{if isset($tab_remove_form)}
		{if $tab_remove_form->hasErrors()}<div style="color: red;">{$tab_remove_form->showErrors()}</div>{/if}
		{$tab_remove_form->getHeaders()}
	
		{$tab_remove_form->showWidgets('<div class="pageoverflow">
			<div class="pagetext">%LABEL%:</div>
			<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
			<div class="pageinput" style="color: red;">%ERRORS%</div>
		</div>', 'true')}
		{$tab_remove_form->getFooters()}
	{/if}
</div>

{/foreach}


<script type="text/javascript">

  
	var options_default = new Object();
	{foreach from=$field_types item=field_type}options_default['{$field_type.type}'] = '{if isset($field_type.options_default)}{$field_type.options_default}{/if}';{/foreach}
  //console.log(options_default);
  {literal}
  (function($) {
		$( "#structure" ).tabs();
		$("#tab-form").dialog({
			autoOpen: false,
			height: 150,
			width: 350,
			modal: true,
			buttons: {
				"Create tab": function(){
					$("#tab-form > form").submit();
				},
				Cancel: function(){
					$(this).dialog("close");
				}
			}
		});
		
		$("#create-tab")
			.button()
			.click(function(){
				$("#tab-form").dialog("open");
				return false;
			});
		{/literal}
		{foreach from=$structure->getTabs() item=tab key=tab_key}
		
			$("#remove-tab-message-{$tab_key}").dialog(
				{literal}
				{
					autoOpen: false,
					modal: true,
					buttons: {
						"Remove": function(){
							$("#remove-tab-message-{/literal}{$tab_key}{literal} > form > input[name='{/literal}{$module_id}{literal}remove_tab']").val('{/literal}{$tab_key}{literal}');
							$("#remove-tab-message-{/literal}{$tab_key}{literal} > form").submit();
						},
						Cancel: function(){
							$(this).dialog("close");
						}
					}
				}
				{/literal}
			);
		
			$("#remove-tab-{$tab_key}")
				.button()
				.click(function(){ldelim}
					$("#remove-tab-message-{$tab_key}").dialog("open");
					return false;
				{rdelim});		
			
			{foreach from=$tab.fieldsets item=fieldset key=fieldset_key}
			
				$( "#sortable-{$tab_key}-{$fieldset_key}" ).sortable({ldelim}
				placeholder: "ui-state-highlight",
				update: function(event,ui){ldelim}
					var reordered_fields = []
					$(this).find('tr').each(function(){ldelim}
						reordered_fields.push($(this).attr('name'))
						//console.log();
					{rdelim});
					// console.log(reordered_fields);
					$("input[name='{$module_id}fields_ordered[{$tab_key}][{$fieldset_key}]']").val(reordered_fields);
					// {$module_id}fields_order[{$tab_key}][{$fieldset_key}]
					// console.log(reordered_fields);
					// console.log($(this).find('tr').attr('id'));
				{rdelim}
				{rdelim});
				$( "#sortable-{$tab_key}-{$fieldset_key}" ).disableSelection();
			
			{/foreach}

		{/foreach}
		{literal}
		
		$(".add-fieldset")
			.button()
			.click(function(){
					var tab_key = $(this).attr("name");
					$("#add-fieldset-form > form > input[name='{/literal}{$module_id}{literal}tab_key']")
								.val(tab_key);
					$("#add-fieldset-form").dialog("open");
					return false;
			});
			
		$("#add-fieldset-form").dialog(
				{
					autoOpen: false,
					modal: true,
					buttons: {
						"Create fieldset": function(){							
							$("#add-fieldset-form > form").submit();
						},
						Cancel: function(){
							$(this).dialog("close");
						}
					}
				}
			);	
			
		$(".remove-fieldset")
			.button()
			.click(function(){
				var options = $.parseJSON($(this).attr("name"));
				$("#remove-fieldset-form > form > input[name='{/literal}{$module_id}{literal}tab_key']")
					.val(options.tab_key);
				$("#remove-fieldset-form > form > input[name='{/literal}{$module_id}{literal}remove_fieldset']")
					.val(options.remove_fieldset);
				$("#remove-fieldset-form").dialog("open");
				return false;
			});
		
					
		$("#remove-fieldset-form").dialog(
				{
					autoOpen: false,
					modal: true,
					buttons: {
						"Delete fieldset": function(){							
							$("#remove-fieldset-form > form").submit();
						},
						Cancel: function(){
							$(this).dialog("close");
						}
					}
				}
			);	
			
		$(".edit-field")
			.button()
			.click(function(){
				var options = $.parseJSON($(this).attr("name"));
				$("#add-field-form > form input[name='{/literal}{$module_id}{literal}tab_key']")
					.val(options.tab_key);
				$("#add-field-form > form input[name='{/literal}{$module_id}{literal}fieldset_key']")
					.val(options.fieldset_key);
				$("#add-field-form > form input[name='{/literal}{$module_id}{literal}label']")
					.val(options.label);
				$("#add-field-form > form input[name='{/literal}{$module_id}{literal}name']")
					.val(options.name);
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}type']")
				 	.val(options.type); //.attr("disabled", "disabled");
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']")
				 	.val(options.type).attr("disabled", "disabled");
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}options']")
					.val(options.options);
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}place']")
				 	.val(options.tab_key+'---'+options.fieldset_key)
					.change(function(){
							 	var new_place = $(this).val().split('---');
								$("#add-field-form > form input[name='{/literal}{$module_id}{literal}tab_key']")
									.val(new_place[0]);
								$("#add-field-form > form input[name='{/literal}{$module_id}{literal}fieldset_key']")
									.val(new_place[1]);
										});				
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}place']").removeAttr('disabled');
				if(options.column == 1)
				{	
					$("#add-field-form > form [name='{/literal}{$module_id}{literal}column']")
					.attr('checked','checked');
				}
				else
				{
					$("#add-field-form > form [name='{/literal}{$module_id}{literal}column']")
					.removeAttr("checked");
				}
				if(options.filter == 1)
				{	
					$("#add-field-form > form [name='{/literal}{$module_id}{literal}filter']")
					.attr('checked','checked');
				}
				else
				{
					$("#add-field-form > form [name='{/literal}{$module_id}{literal}filter']")
					.removeAttr("checked");
				}
				if(options.frontend == 1)
				{	
					$("#add-field-form > form [name='{/literal}{$module_id}{literal}frontend']")
					.attr('checked','checked');
				}
				else
				{
					$("#add-field-form > form [name='{/literal}{$module_id}{literal}frontend']")
					.removeAttr("checked");
				}	
					
					$("#add-field-form").dialog({ title: 'Edit field ['+options.name+']', buttons: {
						"Edit": function(){
							$("#add-field-form > form").submit();
						},
						Cancel: function(){
							$(this).dialog("close");
						}
					}});	
				$("#add-field-form").dialog("open");
				return false;
			});
			
		$(".add-field")
			.button()
			.click(function(){
				var options = $.parseJSON($(this).attr("name"));
				// Cleaning form
				$("#add-field-form > form  input[name='{/literal}{$module_id}{literal}label']").val('');
				$("#add-field-form > form  input[name='{/literal}{$module_id}{literal}name']").val('');
				 // var select = $("#add-field-form > form  input[name='{/literal}{$module_id}{literal}type']");
				 // 				 				select.val($('options:first',select).val());
				
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']")
					.find('option:first').attr('selected', 'selected').parent('select');
			  $("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']").removeAttr('disabled');

				$("#add-field-form > form  [name='{/literal}{$module_id}{literal}type']")
				  .val($("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']").val());
				
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}options']")
					.val('');
				$("#add-field-form > form input[name='{/literal}{$module_id}{literal}column']")
					.removeAttr("checked");
				$("#add-field-form > form input[name='{/literal}{$module_id}{literal}filter']")
				.removeAttr("checked");
				$("#add-field-form > form input[name='{/literal}{$module_id}{literal}frontend']")
				.removeAttr("checked");
				
					
				$("#add-field-form > form > input[name='{/literal}{$module_id}{literal}tab_key']")
					.val(options.tab_key);
				$("#add-field-form > form > input[name='{/literal}{$module_id}{literal}fieldset_key']")
					.val(options.fieldset_key);
					
				$("#add-field-form > form [name='{/literal}{$module_id}{literal}place']")
				 	.val(options.tab_key+'---'+options.fieldset_key).attr("disabled", "disabled");

  				$("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']")
  					.find('option:first').attr('selected', 'selected').parent('select');
  			  $("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']").removeAttr('disabled');

  				$("#add-field-form > form  [name='{/literal}{$module_id}{literal}type']")
  				  .val($("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']").val());


				$("#add-field-form > form [name='{/literal}{$module_id}{literal}type_select']")
					.change(function(){
            // console.log($(this).val());
            // console.log(options_default[$(this).val()]);
						$("#add-field-form > form  [name='{/literal}{$module_id}{literal}options']")
						.val(options_default[$(this).val()]);
						$("#add-field-form > form  [name='{/literal}{$module_id}{literal}type']")
						.val($(this).val());
					});
						
				$("#add-field-form").dialog({ title: "Add field", buttons: {
						"Add": function(){
							//console.log($(this).children("form > input[name='{/literal}{$module_id}{literal}type']"));				
										
							$("#add-field-form > form").submit();
						},
						Cancel: function(){
							$(this).dialog("close");
						}
					}});			
				$("#add-field-form").dialog("open");
				return false;
			});
			
			$("#add-field-form").dialog(
				{
					autoOpen: false,
					modal: true,
					width: 350
				}
			);	
			
			$("#remove-field-form").dialog(
				{
					autoOpen: false,
					modal: true,
					buttons: {
						"Delete field": function(){							
							$("#remove-field-form > form").submit();
						},
						Cancel: function(){
							$(this).dialog("close");
						}
					}
				}
			);
			
			$(".remove-field")
			.button()
			.click(function(){
				var options = $.parseJSON($(this).attr("name"));
				$("#remove-field-form > form input[name='{/literal}{$module_id}{literal}tab_key']")
					.val(options.tab_key);
				$("#remove-field-form > form input[name='{/literal}{$module_id}{literal}fieldset_key']")
					.val(options.fieldset_key);
				$("#remove-field-form > form input[name='{/literal}{$module_id}{literal}field']")
					.val(options.field);
				$("#remove-field-form").dialog("open");
				return false;
			});		
  {/literal}

	var prefix = "{$module_id}";
	var options = '{foreach from=$field_types item=field_type}<option value="{$field_type.type}">{$field_type.label}</option>{/foreach}';
	var field_types_with_options = [{foreach name=types from=$field_types_with_options item=field_type}"{$field_type}"{if !$smarty.foreach.types.last}, {/if}{/foreach}];
	var options_default = [];
	{foreach from=$field_types item=field_type}
	options_default['{$field_type.type}'] = '{if isset($field_type.options_default)}{$field_type.options_default}{/if}';
	{/foreach}
	{literal}
	$('#fields a.field_remove').click(function() {
		$(this).parents('form').append('<input type="hidden" name="'+prefix+'delete_fields[]" value="' + $(this).parents("tr:first").find('.field_name').val() + '" />');
		$(this).parents("tr:first").remove();
		return false;
	});
	var i = $("#fields tr").length;
	$("#field_add").click(function() {
		$('<tr><td width="32" colspan="2"></td><td><!--<input type="text" id="'+prefix+'extra_fields['+i+'][label]" name="'+prefix+'extra_fields['+i+'][label]" size="30" />--></td><td width="300"><input type="hidden" name="'+prefix+'extra_fields['+i+'][new]" value="1" /><input type="text" id="'+prefix+'extra_fields['+i+'][name]" name="'+prefix+'extra_fields['+i+'][name]" size="30" /></td><td><select id="'+prefix+'extra_fields['+i+'][type]" name="'+prefix+'extra_fields['+i+'][type]" class="field_type">' + options + '</select></td><td><span class="field_options" style="display:none;"><input type="text" id="'+prefix+'extra_fields['+i+'][options]" name="'+prefix+'extra_fields['+i+'][options]" size="30" /></span></td><td></td><td></td><td></td><td><a href="#" class="field_remove">{/literal}{*Remove field*}{$remove_icon}{literal}</a></td></tr>')
			.find("select.field_type").change(function() {
				if ($.inArray($(this).val(), field_types_with_options) != -1) {
					$(this).parents("tr:first").find("span.field_options").find(":input").val(options_default[$(this).val()]).end().css("display", "inline");
				} else {
					$(this).parents("tr:first").find("span.field_options").css("display", "none");
				}
			})
			.end()
			.find("a.field_remove").click(function() {
				$(this).parents("tr:first").remove();
				return false;
			})
			.end()
			.appendTo("#fields");
		i++;
		return false;
	});
	{/literal}
{rdelim})(jQuery);
</script>

<script type="text/javascript">
  (function($) {ldelim}
	  var prefix = "{$module_id}";
	  var options = '{foreach from=$filter_types item=filter_type}<option value="{$filter_type.type}">{$filter_type.label}</option>{/foreach}';
	  {literal}
	  
	  $("a.filter_remove").click(function() {
		  $(this).parents("p.filters_item").remove();
		  return false;
	  });
	  
	  var i = $("#filters p.filters_item").length+1;
	  
	  $("#filter_add").button().click(function() {
		  $('<p class="filters_item"><label for="'+prefix+'filters_'+i+'_name">Name:</label> <input type="text" id="'+prefix+'filters_'+i+'_name" name="'+prefix+'filters['+i+'][name]" size="30" /> Field: <input type="text" id="'+prefix+'filters['+i+'][field]" name="'+prefix+'filters['+i+'][field]" size="10" /> <label for="'+prefix+'filters['+i+'][type]">Type:</label> <select id="'+prefix+'filters['+i+'][type]" name="'+prefix+'filters['+i+'][type]" class="filter_type">' + options + '</select> <a href="#" class="filter_remove">Remove filter</a></p>')
			.find("a.filter_remove").click(function() {
				$(this).parents("p.filters_item").remove();
				return false;
			})
			.end()
			.appendTo("#filters");
		  i++;
		  return false;
	  });
	  {/literal}
  {rdelim})(jQuery);
</script>