{if isset($form)}
	<div style="color: red;">{$form->showErrors()}</div>
	{$form->getHeaders()}
	<p style="text-align: right;">
		{$form->getButtons()}
	</p>
	
<script type="text/javascript">
{literal}
  jQuery(function($) {
		$( "#structure" ).tabs();			
    });  
{/literal}
</script>

	
	<div id="structure" style="margin-bottom: 7px;">
	<ul>
		{{foreach from=$structure->getTabs() item=tab key=tab_key}}
		<li{{if isset($active_fields_tab)}}{{if $active_fields_tab eq $tab_key}} class="ui-tabs-selected ui-state-active"{{/if}}{{/if}}><a href="#struc-{{$tab_key}}">{{$tab.name}}</a></li>
		{{/foreach}}
		{foreach from=$submodules item=module}
		<li{if $tab == $module.gname} class="ui-tabs-selected ui-state-active"{/if}><a href="#struc-{$module.gname}">{$module.name}</a></li>
		{/foreach}
		{if $xtended_form != ''}
		<li{if $tab == 'related'} class="ui-tabs-selected ui-state-active"{/if}><a href="#struc-related">Related items</a></li>
    {/if}
    <li><a href="#module---options">Options</a></li>
	</ul>
	{{foreach from=$structure->getTabs() item=tab key=tab_key}}
		<div id="struc-{{$tab_key}}">
		{{foreach from=$tab.fieldsets item=fieldset key=fieldset_key}}
			{$form->renderFieldset('{{$tab_key}}---{{$fieldset_key}}','<div class="formfield">
					<div class="pagetext">%LABEL%:</div>
					<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
					<div class="pageinput" style="color: red;">%ERRORS%</div>
			</div>')}
		{{/foreach}}
		</div>
	{{/foreach}}	
	{foreach from=$submodules item=module}
	  <div id="struc-{$module.gname}">
    			{$module.template}
    			<p>{if $module.add_item_link}{$module.add_item_icon} {$module.add_item_link}{else}<em>First click on "Save &amp; continue editing" to be able to add {$module.name} items.</em>{/if}</p>
	  </div>
	{/foreach}
	{if $xtended_form != ''}
	<div id="struc-related">
	  {$xtended_form}
	</div>
	{/if}	
	<div id="module---options">
	  {$form->renderFieldset('module---options','<div class="formfield">
				<div class="pagetext">%LABEL%:</div>
				<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
				<div class="pageinput" style="color: red;">%ERRORS%</div>
		</div>')}
	</div>
	</div>
	
	{$form->renderFieldsets('<div class="formfield">
		<div class="pagetext">%LABEL%:</div>
		<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
		<div class="pageinput" style="color: red;">%ERRORS%</div>
	</div>')}

	{$form->showWidgets('<div class="formfield">
		<div class="pagetext">%LABEL%:</div>	
		<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
		<div class="pageinput" style="color: red;">%ERRORS%</div>
	</div>')}

	<p style="text-align: right; margin-top: 15px;">
		{$form->getButtons()}
	</p>
	{$form->getFooters()}
{/if}