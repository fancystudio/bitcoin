{if isset($message)}
  {if isset($error)}
    <font color="red"><h4>{$message}</h4></font>
  {else}
    <h4>{$message}</h4>
  {/if}
{/if}

{if !isset($multiuser)}
<h4>{$title_userhistory}&nbsp;{$for}&nbsp;{$user_username}</h4>
{/if}
{$formstart}
<fieldset>
<legend>{$title_legend_filter}</legend>
  <div class="pageoverflow">
     <p class="pagetext">{$prompt_filter_eventtype}:</p>
     <p class="pageinput">{$input_filter_eventtype}</p>
  </div>
{if isset($multiuser)}
  <div class="pageoverflow">
     <p class="pagetext">{$prompt_username_regex}:</p>
     <p class="pageinput">{$input_username_regex}</p>
  </div>
{/if}
  <div class="pageoverflow">
     <p class="pagetext">{$prompt_filter_date}:</p>
     <p class="pageinput">{$input_filter_date}</p>
  </div>
  <div class="pageoverflow">
     <p class="pagetext">{$prompt_pagelimit}:</p>
     <p class="pageinput">{$input_pagelimit}</p>
  </div>
</fieldset>
<fieldset>
<legend>{$title_legend_groupsort}</legend>
  <div class="pageoverflow">
     <p class="pagetext">{$prompt_group_ip}:</p>
     <p class="pageinput">{$input_group_ip}</p>
  </div>
  <div class="pageoverflow">
     <p class="pagetext">{$prompt_sortorder}:</p>
     <p class="pageinput">{$input_sortorder}</p>
  </div>
</fieldset>
  <div class="pageoverflow">
     <p class="pagetext">&nbsp;</p>
     <p class="pageinput">{$submit}&nbsp;{$reset}</p>
  </div>
{$formend}

<p>{$recordcount}&nbsp;{$prompt_recordsfound}</p>
{if $itemcount > 0}
{if $pagecount > 1}
  <p>
{if $pagenumber > 1}
{$firstpage}&nbsp;{$prevpage}&nbsp;
{/if}
{$pagenumber}&nbsp;{$oftext}&nbsp;{$pagecount}
{if $pagenumber < $pagecount}
&nbsp;{$nextpage}&nbsp;{$lastpage}
{/if}
</p>
{/if}
<br/>
<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
{if isset($multiuser)}
	<th>{$prompt_username}</th>
{/if}
	<th>{$prompt_ipaddress}</th>
	<th>{$prompt_action}</th>
	<th>{$prompt_refdate}</th>
    </tr>
  </thead>
  <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
{if isset($multiuser)}
        <td>{$entry->username}</td>
{/if}
	<td>{$entry->ipaddress}</td>
	<td>{$entry->action}</td>
	<td>{$entry->refdate|date_format:"%b %e, %Y - %X"}</td>
  </tr>	 
{/foreach}
  </tbody>
</table>
{/if}
