<h3>{$title}</h3>
{if isset($message) and $message != ''}
  {if isset($error) and $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}

{$startform}
{if $controlcount > 0}
{foreach from=$controls item=control}
<div class="pageoverflow">
  <p class="pagetext" style="color: {$control->color}">{$control->marker}{$control->prompt}:</p>
  <p class="pageinput">
    {$control->hidden|default:''}{$control->control}
    {if isset($control->extratext)}<br/>{$control->extratext}{/if}
  </p>
</div>
{/foreach}
{/if}
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
  {if isset($hidden)}{$hidden}{/if}
  {if isset($hidden2)}{$hidden2}{/if}
  {$submit}{$cancel}
  </p>
</div>
{$endform}