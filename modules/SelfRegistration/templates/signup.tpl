{$title}
{if $message != ''}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
{$startform}
{if $controlcount > 0}
  <center>
  <table width="75%">
{foreach from=$controls item=control}
  <tr>
    <td>{$control->hidden}
    <font color="{$control->color}">{$control->prompt}{$control->marker}</font>
    </td>
    <td>{$control->control}</td>
  </tr>
{/foreach}
  </table>
  </center>
<br/>
{/if}
{if isset($hidden)}{$hidden}{/if}
{if isset($hidden2)}{$hidden2}{/if}
{$back}{$submit}{$cancel}
{$endform}
