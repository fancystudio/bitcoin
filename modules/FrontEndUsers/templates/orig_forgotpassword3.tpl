<!-- forgot password verification template -->
{$startform}
{$title}
{if !empty($message)}
  {if !empty($error) }
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<p>{$prompt_username}&nbsp;{$input_username}</p>
<p>{$prompt_code}&nbsp;{$input_code}</p>
<p>{$prompt_password}&nbsp;{$input_password}</p>
<p>{$prompt_repeatpassword}&nbsp;{$input_repeatpassword}</p>
<p>{$hidden}{$submit}</p>
{$endform}
<!-- forgot password verification template -->
