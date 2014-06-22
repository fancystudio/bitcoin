{if $rows|@count}
<table cellspacing="0" class="pagetable">
    <thead>
        <tr>
            <th>Module name</th>
            <th>Smarty</th>
            <th class="pageicon" style="width:16px;">&nbsp;</th>
            <th class="pageicon" style="width:16px;">&nbsp;</th>
            <th class="pageicon" style="width:16px;">&nbsp;</th>
            <th class="pageicon" style="width:16px;">&nbsp;</th>
            <th class="pageicon" style="width:16px;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$rows item=row}
        <tr class="{cycle values="row1,row2"}" onmouseover="this.className='{cycle values="row1,row2"}hover';" onmouseout="this.className='{cycle values="row1,row2"}';">
            <td width="200px;">
                <a href="{$row.edit_link}">{$row.module_friendlyname}</a>
            </td>
            <td>{ldelim}{$row.module_name}{rdelim}</em></td>
            <td>{$row.publish}</td>
            <td>{$row.export}</td>
            <td>{$row.view}</td>
						<td>{$row.edit}</td>
            <td>{$row.delete}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
{/if}

<p>{$add_icon}  {$add}</p>

{if isset($form)}
	<div style="color: red;">{$form->showErrors()}</div>
	{$form->getHeaders()}
	{$form->showWidgets('<div class="pageoverflow">
		<div class="pagetext">%LABEL%:</div>
		<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
		<div class="pageinput" style="color: red;">%ERRORS%</div>
	</div>')}
	{$form->renderFieldsets('<div class="pageoverflow">
		<div class="pagetext">%LABEL%:</div>
		<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
		<div class="pageinput" style="color: red;">%ERRORS%</div>
	</div>')}
		{$form->getButtons()}
	{$form->getFooters()}
{/if}