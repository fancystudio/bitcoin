<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
  $('#feu_filterbox').click(function(){
    if( this.checked ) {
      $('#feu_filterform').show();
    }
    else {
      $('#feu_filterform').hide();
    }
  });
});
function select_all()
{
  cb = document.getElementsByName('{$feuactionid}selected[]');
  el = document.getElementById('selectall');
  st = el.checked;
  for( i = 0; i < cb.length; i++ ) {
    if( cb[i].type == "checkbox" )  cb[i].checked=st;
  }
}

function confirm_delete()
{
  var cb = document.getElementsByName('{$feuactionid}selected[]');
  var count = 0;
  for( i = 0; i < cb.length; i++ ) {
     if( cb[i].checked ) count++;
  }

  if( count > 250 ) {
     alert('{$mod->Lang('error_toomanyselected')}');
     return false;
  }
  return confirm('{$mod->Lang('confirm_delete_selected')}');
}
/*]]> */
</script>

{$startform}
<div id="feu_filterform" style="display: none;">
<table width="100%">
<tr><td width="50%" valign="top">
  <fieldset>
  <legend>{$mod->Lang('filter')}:</legend>
  {if isset($groups)}
  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('group')}:</p>
   <p class="pageinput">
     <select name="{$actionid}filter_group">
     {html_options options=$groups selected=$filter.group}
     </select>
   </p>
  </div>
  {/if}

  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('userfilter')}:</p>
   <p class="pageinput">
     <input type="text" name="{$actionid}filter_regex" value="{$filter.regex}"/>
   </p>
  </div>
  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('propertyfilter')}:</p>
   <p class="pageinput">
     <select name="{$actionid}filter_propertysel">{html_options options=$defnlist selected=$filter.propsel}</select>
   </p>
  </div>
  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('valueregex')}:</p>
   <p class="pageinput">
     <input type="text" name="{$actionid}filter_property" value="{$filter.propval}"/>
   </p>
  </div>

  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('prompt_loggedinonly')}:</p>
   <p class="pageinput">
     {cge_yesno_options prefix=$actionid name='filter_loggedinonly' selected=$filter.loggedinonly}
   </p>
  </div>
  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('userlimit')}:</p>
   <p class="pageinput">
     <select name="{$actionid}filter_limit">{html_options options=$limits selected=$filter.limit}</select>
   </p>
  </div>
  </fieldset>
</td><td valign="top">
  <fieldset>
  <legend>{$mod->Lang('view')}:</legend>
  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('prompt_viewprops')}:</p>
   <p class="pageinput">
     <select name="{$actionid}filter_viewprops[]" multiple="multiple" size="5">
       {html_options options=$alldefns selected=$viewprops}
     </select>
   </p>
  </div>
  <div class="pageoverflow">
   <p class="pagetext">{$mod->Lang('sortby')}:</p>
   <p class="pageinput">
     <select name="{$actionid}filter_sortby">{html_options options=$sortlist selected=$filter.sortby}</select>
     <br/>{$mod->Lang('info_filter_sortby')}
   </p>
  </div>
</fieldset>
</td></tr>
<tr>
  <td colspan="2" align="center">
    <input type="submit" name="{$actionid}filter" value="{$mod->Lang('applyfilter')}"/>
    <input type="submit" name="{$actionid}filter_reset" value="{$mod->Lang('reset')}"/>
  </td>
</tr>
</table>
<br/>
</div>{* #feu_filterform *}

<div class="pageoverflow">
 <div style="width: 75%; float: left;">
  <input id="feu_filterbox" type="checkbox" value="1"/><label for="feu_filterbox">{$mod->Lang('view_filter')} {if $filter_applied}({$mod->Lang('applied')}){/if}</label>&nbsp;
   <span title="{$mod->Lang('usersingroup')}">{cgimage image='users.gif' alt=""} = {$numusers}</span>&nbsp;
   {if isset($addlink)}{$addlink}{/if}
   {if isset($import_url)}<a href="{$import_url}" title="{$mod->Lang('title_import_users')}">{cgimage image='icons/system/import.gif'} {$mod->Lang('prompt_importusers')}</a>{/if}
   {if isset($export_url)}<a href="{$export_url}" title="{$mod->Lang('title_export_users')}">{cgimage image='icons/system/export.gif'} {$mod->Lang('prompt_exportusers')}</a>{/if}
 </div>
 <div style="width: 24%; float: right; text-align: right;">
 {if isset($navigation.firstpage_url)}
   <a href="{$navigation.firstpage_url}">{$mod->Lang('firstpage')}</a>&nbsp;
   <a href="{$navigation.prevpage_url}">{$mod->Lang('prevpage')}</a>&nbsp;
 {/if}
 {$mod->Lang('page')} {$navigation.curpage} {$mod->Lang('prompt_of')} {$navigation.npages}
 {if isset($navigation.lastpage_url)}
   &nbsp;<a href="{$navigation.nextpage_url}">{$mod->Lang('nextpage')}</a>
   &nbsp;<a href="{$navigation.lastpage_url}">{$mod->Lang('lastpage')}</a>
 {/if}
 </div>
</div>
{if !isset($groups)}
  <div class="red center">{$mod->Lang('nogroups')}</div>
{elseif $itemcount > 0}
<table class="pagetable cms_sortable tablesorter">
	<thead>
		<tr>
			<th>{$usernametext}</th>
			<th>{$createdtext}</th>
			<th>{$expirestext}</th>
                        {if isset($viewprops) && is_array($viewprops)}
                        {foreach from=$viewprops item='one'}
                        <th>{$alldefns.$one}</th>
                        {/foreach}
                        {/if}
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}"><input id="selectall" type="checkbox" name="junk" onclick="select_all();"/></th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
		<tr>
			<td>{$entry->username}</td>
			<td>{$entry->created}</td>
			<td>{$entry->expires}</td>
                        {if isset($viewprops) && isset($entry->extra)}
                        {foreach from=$viewprops item='one'}
                        <td>{if isset($entry->extra.$one) && $entry->extra.$one}{$entry->extra.$one}{/if}</td>
                        {/foreach}
                        {/if}
			<td>{if isset($entry->logoutlink)}{$entry->logoutlink}{/if}</td>
			<td>{$entry->historylink|default:''}</td>
			<td>{$entry->editlink|default:''}</td>
			<td>{if isset($entry->deletelink)}{$entry->deletelink}{/if}</td>
			<td><input type="checkbox" name="{$feuactionid}selected[]" value="{$entry->id}"/></td>
		</tr>
{/foreach}
	</tbody>
</table>
{/if}
<div class="pageoverflow">
 <div style="float: left;"></div>
 <div style="float: right;">
   {if isset($perm_removeusers) && $perm_removeusers == 1}<input type="submit" name="{$feuactionid}bulkdelete" value="{$mod->Lang('delete_selected')}" onclick="return confirm_delete();"/>{/if}
 </div>
</div>
{$endform}
