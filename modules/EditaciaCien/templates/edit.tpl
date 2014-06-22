
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
				<li><a href="#struc-default">Main</a></li>
				{foreach from=$submodules item=module}
		<li{if $tab == $module.gname} class="ui-tabs-selected ui-state-active"{/if}><a href="#struc-{$module.gname}">{$module.name}</a></li>
		{/foreach}
		{if $xtended_form != ''}
		<li{if $tab == 'related'} class="ui-tabs-selected ui-state-active"{/if}><a href="#struc-related">Related items</a></li>
    {/if}

	</ul>
			<div id="struc-default">
					{$form->renderFieldset('default---default','<div class="formfield">
					<div class="pagetext">%LABEL%:</div>
					<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
					<div class="pageinput" style="color: red;">%ERRORS%</div>
			</div>')}
				</div>
		
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
	<div id="module---options" style="display:none">
	  {$form->renderFieldset('module---options','')}
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