{if isset($form)}
{if $form->hasErrors()}<div style="color: red;">{$form->showErrors()}</div>{/if}
	{$form->getHeaders()}
	
	{$form->showWidgets('<div class="pageoverflow">
		<div class="pagetext">%LABEL%:</div>
		<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
		<div class="pageinput" style="color: red;">%ERRORS%</div>
	</div>')}

	<p>
		{$form->getButtons()}
	</p>
	{$form->getFooters()}
{/if}
{{*
{$form_start}
	{{foreach from=$filters item=filter}}
	<input type="text" name="{$id}{{$filter.name}}">
	{{/foreach}}
	<input type="submit" value="Search old" />
</form>
*}}