{* registration 2 template *}
{$title}
{if isset($message) && $message != ''}
  {if isset($error) && $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
{$startform}
  <center>
  <table width="75%">
  <tr>
    <td>{$prompt_username}</font>
    </td>
    <td>{$input_username}</td>
  </tr>
  <tr>
    <td>{$prompt_password}</font>
    </td>
    <td>{$input_password}</td>
  </tr>
  <tr>
    <td>{$prompt_code}</font>
    </td>
    <td>{$input_code}</td>
  </tr>
  </table>
  </center>
<br/>
{if isset($hidden)}{$hidden}{/if}
{if isset($hidden2)}{$hidden2}{/if}
{$submit}
{$endform}

