<div style="float:right;">{$export}{$options_top}</div>


{if isset($form)}
	<div style="color: red;">{$form->showErrors()}</div>
	{$form->getHeaders()}
	{$form->showWidgets('<div class="pageoverflow">
		<p class="pagetext">%LABEL%:</p>
		<p class="pageinput">%INPUT%</p>
	</div>')}
	<p style="text-align: right;">
		{$form->getButtons()}
	</p>
	{$form->getFooters()}
{/if}

<div style="float:right;">{$update_objects}{$options_bottom}</div><div style="clear:both;"></div>

