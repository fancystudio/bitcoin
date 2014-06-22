{* registration 1 template *}
{$title}
{if isset($message) && $message != ''}
  {if isset($error) && $error != ''}
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
    <td>{if isset($control->hidden)}{$control->hidden}{/if}
    {if $control->color != ''}
      <font color="{$control->color}">{$control->prompt}{$control->marker}</font>
    {else}
      {$control->prompt}{$control->marker}
    {/if}
    </td>
    <td>{$control->control}</td>
  </tr>
{/foreach}
  </table>
  </center>
<br/>
{/if}
{if isset($captcha)}
{$captcha_title}: {$input_captcha}<br />
  {$captcha}<br />
{/if}
 {$hidden|default:''}{$hidden2|default:''}{$submit}<br/>
{$msg_sendanotheremail}&nbsp;{$link_sendanotheremail}
{$endform}

