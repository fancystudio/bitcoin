{* sortable list template *}

{*
 This template provides one example of using javascript in a CMS module template.  The javascript is left here as an example of how one can interact with smarty in javascript.  You may infact want to put most of these functions into a seperate .js file and include it somewhere in your head section.

 You are free to modify this javascript and this template.  However, the php driver scripts look for a field named in the smarty variable {$selectarea_prefix}, and expect that to be a comma seperated list of values.
 *}

{literal}
<script type='text/javascript'>
var allowduplicates = {/literal}{$allowduplicates};{literal}
var selectlist = {/literal}"{$selectarea_prefix}_selectlist";{literal}
var masterlist = {/literal}"{$selectarea_prefix}_masterlist";{literal}
var addbtn = {/literal}"{$selectarea_prefix}_add";{literal}
var rembtn = {/literal}"{$selectarea_prefix}_remove";{literal}
var upbtn = {/literal}"{$selectarea_prefix}_up";{literal}
var downbtn = {/literal}"{$selectarea_prefix}_down";{literal}
var valuefld = {/literal}"{$selectarea_prefix}";{literal}
var max_selected = {/literal}{$max_selected};{literal}

function selectarea_update_value()
{
  var sel_elem = document.getElementById(selectlist);
  var val_elem = document.getElementById(valuefld);
  var sel_idx = sel_elem.selectedIndex;
  var opts = sel_elem.getElementsByTagName('option');
  var tmp = new Array();
  for( i = 0; i < opts.length; i++ )
    {
      tmp[tmp.length] = opts[i].value;
    }
  var str = tmp.join(',');
  val_elem.value = str;  
}

function selectarea_handle_down()
{
  var sel_elem = document.getElementById(selectlist);
  var sel_idx = sel_elem.selectedIndex;
  var opts = sel_elem.getElementsByTagName('option');
  for( var i = opts.length - 2; i >= 0; i-- )
    {
      var opt = opts[i];
      if( opt.selected )
        {
           var nextopt = opts[i+1];
           opt = sel_elem.removeChild(opt);
           nextopt = sel_elem.replaceChild(opt,nextopt);
           sel_elem.insertBefore(nextopt,opt);
        }
    }
  selectarea_update_value();
}

function selectarea_handle_up()
{
  var sel_elem = document.getElementById(selectlist);
  var sel_idx = sel_elem.selectedIndex;
  var opts = sel_elem.getElementsByTagName('option');
  if( sel_idx > 0 )
    {
      for( var i = 1; i < opts.length; i++ )
        {
          var opt = opts[i];
          if( opt.selected )
            {
              sel_elem.removeChild(opt);
               sel_elem.insertBefore(opt, opts[i-1]);
            }
        }
    }
  selectarea_update_value();
}

function selectarea_handle_remove()
{
  var sel_elem = document.getElementById(selectlist);
  var sel_idx = sel_elem.selectedIndex;
  if( sel_idx >= 0 )
    {
      var val = sel_elem.options[sel_idx].value;
      sel_elem.remove(sel_idx);
    }
  selectarea_update_value();
}

function selectarea_handle_add()
{
  var mas_elem = document.getElementById(masterlist);
  var mas_idx = mas_elem.selectedIndex;
  var sel_elem = document.getElementById(selectlist);
  var opts = sel_elem.getElementsByTagName('option');
  if( opts.length >= max_selected && max_selected > 0) return;
  if( mas_idx >= 0 )
    {
      var newOpt = document.createElement('option');
      newOpt.text = mas_elem.options[mas_idx].text;
      newOpt.value = mas_elem.options[mas_idx].value;
      if( allowduplicates == 0 )
        {
          for( var i = 0; i < opts.length; i++ )
          {
            if( opts[i].value == newOpt.value ) return;
          }
        }
      sel_elem.add(newOpt,null);
    }
  selectarea_update_value();
}


function selectarea_handle_select()
{
  var sel_elem = document.getElementById(selectlist);
  var sel_idx = sel_elem.selectedIndex;
  var mas_elem = document.getElementById(masterlist);
  var mas_idx = mas_elem.selectedIndex;
  addbtn.disabled = (mas_idx >= 0);
  rembtn.disabled = (sel_idx >= 0);
  addbtn.disabled = (sel_idx >= 0);
  downbtn.disabled = (sel_idx >= 0);
}

</script>
{/literal}

 <table>
   <tr>
     <td>
      {* left column - for the selected items *}
      {$label_left}<br/>
      <select id="{$selectarea_prefix}_selectlist" size="10" onchange="selectarea_handle_select();">
        {html_options options=$selectarea_selected}
      </select><br/>
     </td>
     <td>
      {* center column - for the add/delete buttons *}
      <input type="submit" id="{$selectarea_prefix}_add" value="&lt;&lt;" onclick="selectarea_handle_add(); return false;"/><br/>
      <input type="submit" id="{$selectarea_prefix}_remove" value="&gt;&gt;" onclick="selectarea_handle_remove(); return false;"/><br/>
      <input type="submit" id="{$selectarea_prefix}_up" value="{$upstr}" onclick="selectarea_handle_up(); return false;"/><br/>
      <input type="submit" id="{$selectarea_prefix}_down" value="{$downstr}" onclick="selectarea_handle_down(); return false;"/><br/>
     </td>
     <td>
      {* right column - for the master list *}
      {$label_right}<br/>
      <select id="{$selectarea_prefix}_masterlist" size="10" onchange="selectarea_handle_select();">
        {html_options options=$selectarea_masterlist}
      </select>
     </td>
   </tr>
 </table>
 <div><input type="hidden" id="{$selectarea_prefix}" name="{$selectarea_prefix}" value="{$selectarea_selected_str}" /></div>
