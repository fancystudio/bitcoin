<h3>{$title}</h3>
{if isset($message) }
  {if isset($error) }
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
{$startform}
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_username}:</p>
    <p class="pageinput">{$input_username}{if isset($username_readonly)}<br/>{$mod->Lang('msg_username_readonly')}{/if}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_password}:</p>
    <p class="pageinput">{$input_password}&nbsp;{$info_password|default:''}
    {if isset($username_readonly)}<br/>{$mod->Lang('msg_username_readonly')}{/if}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_repeatpassword}:</p>
    <p class="pageinput">{$input_repeatpassword}&nbsp;{$info_repeatpassword|default:''}
    {if isset($username_readonly)}<br/>{$mod->Lang('msg_username_readonly')}{/if}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_expires}:</p>
    <p class="pageinput">{html_select_date prefix=$expires_dateprefix time=$expiresdate start_year=2000 end_year=2040}</p>
  </div>
{if isset($itemcount) && $itemcount > 0}
<p class="pagetext">{$groupstitle}:</p>
<table cellspacing="0" class="pagetable cms_sortable tablesorter">
	<thead>
		<tr>
			<th width="5%">{$idtext}</th>
			<th>{$nametext}</th>
			<th>{$desctext}</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
		<tr class="{$entry->rowclass}">
			<td>{$entry->id}</td>
			<td>{$entry->name}</td>
			<td>{$entry->desc}</td>
			<td>{$entry->member}</td>
		</tr>
{/foreach}
	</tbody>
</table>
{/if}
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$hidden|default:''}{$submit}{$cancel}</p>
  </div>
{$endform}
