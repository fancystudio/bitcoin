{* logout form template *}
{if isset($alt_logoutform)}{$alt_logoutform}{/if}
{if isset($message)}<div class="message">{$message}</div>{/if}
<p>{$prompt_loggedin}&nbsp;{$username}</p> 
<p><a href="{$url_changesettings}" title="{$FrontEndUsers->Lang('info_changesettings')}">{$FrontEndUsers->Lang('prompt_changesettings')}</p>
{if isset($url_logout)}
<p><a href="{$url_logout}" title="{$FrontEndUsers->Lang('info_logout')}">{$FrontEndUsers->Lang('logout')}</a></p>
{/if}
