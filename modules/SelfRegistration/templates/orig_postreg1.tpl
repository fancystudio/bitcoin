{* post registration 1 template *}
{if isset($messasge) && $message != ''}
  {if isset($error) && $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<p>Thank you {$username} for registering with &quot;{sitename}&quot;.  An email has been sent to {$email} with instructions on how to continue the registration process</p>
<!-- Post Registration 1 template -->
