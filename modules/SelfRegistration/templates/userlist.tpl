<script type="text/javascript">
$(document).ready(function(){
  $('#seluser_all').click(function(){
    var v = $(this).attr('checked');
    if( v == 'checked' ) {
      $('.seluser').attr('checked','checked');
    }
    else {
      $('.seluser').removeAttr('checked');
    }
  });
  $('.seluser').click(function(){
    $('#seluser_all').removeAttr('checked');
  });
});
</script>

{if isset($message) && $message != ''}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{else}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
{$startform}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th width="5%">{$useridtext}</th>
			<th>{$usernametext}</th>
			<th>{$grpnametext}</th>
			<th>{$createdtext}</th>
			{if !isset($username_is_email)}<th>{$emailtext}</th>{/if}
			<th class="pageicon"></th>
			<th class="pageicon"></th>
			<th class="pageicon"></th>
			<th class="pageicon"><input type="checkbox" id="seluser_all" value="1"/></th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
		<tr class="{$entry->rowclass}">
			<td>{$entry->userid}</td>
			<td><a href="{$entry->edit_url}">{$entry->username}</a></td>
			<td>{if isset($entry->grpname)}{$entry->grpname|summarize:30}{/if}</td>
			<td>{$entry->created|cms_date_format}</td>
			{if !isset($username_is_email)}<td>{$entry->email}</td>{/if}
			<td>{$entry->pushlink}</td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
			<td><input type="checkbox" class="seluser" name="{$actionid}markdelete_{$entry->userid}" value="{$entry->userid}"/></td>
		</tr>
	 
{/foreach}
</tbody>
</table>
<div class="pageoverflow" style="text-align: right;">
{$submit}
</div>

{/if}
{$endform}
{/if}
