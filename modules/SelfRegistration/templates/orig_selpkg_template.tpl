{* select subscription package *}
<div id="selfreg_selpkg">
{$formstart}{$hidden|default:''}

<table>
{foreach from=$pkgs item=pkg}
  <tr>
   <td align="left" width="5%">
     <input type="{$inputtype|default:'radio'}" name="{$actionid}sr_selpkg[]" value="{$pkg.id}"/>
   </td>
   <td align="left">{$pkg.prompt}</td>
   <td align="right" width="15%">{if $pkg.cost > 0.0}{$currency_symbol|default:''}{$pkg.cost|number_format:2}{$currency_code|default:''}{/if}</td>
  </tr>
  <tr>
   <td></td>
   <td colspan="3">{$pkg.description}</td>
  </tr>
{/foreach}
</table>

<div class="row">
  <p class="prompt"></p>
  <p class="input">
    <input type="submit" name="{$actionid}sr_submit" value="{$SelfRegistration->Lang('submit')}"/>
  </p>
</div>

{$formend}
</div>