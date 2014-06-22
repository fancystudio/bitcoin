<h3>{$title}:</h3>
{if isset($username)}<h3>{$edittext}: {$username}</h3>{/if}
{if isset($message) }
  {if isset($error) }
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
{$startform}
{if $controlcount > 0}
{foreach from=$controls item=control}
  <div class="pageoverflow">
    <p class="pagetext">{$control->hidden}<font color="{$control->color}">{$control->prompt}{$control->marker}</font></p>
    <p class="pageinput">{$control->control}</p>
  </div>
  {if isset($control->image)}
    <div class="pageoverflow">
      <p class="pagetext">&nbsp;</p>
      <p class="pageinput">{$control->image}</p>
    </div>
  {/if}
  {if $control->required != true}
     {if isset($control->control2)}
       <div class="pageoverflow">
         <p class="pagetext">&nbsp;</p>
         <p class="pageinput">{$control->prompt2}&nbsp;{$control->control2}</p>
       </div>
     {/if}
  {/if}
{/foreach}
<br/>
{/if}
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$hidden|default:''}{$hidden2|default:''}{$back}{$submit}{$cancel}</p>
  </div>
{$endform}
