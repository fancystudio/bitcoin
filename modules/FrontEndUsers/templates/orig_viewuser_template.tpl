{* view user template *}
<p>{$feu->Lang('id')}:&nbsp;{$userinfo.id}</p>
<p>{$feu->Lang('username')}:&nbsp;{$userinfo.username}</p>
<p>{$feu->Lang('email')}:&nbsp;<a href="mailto:{$email_address}">{$email_address}</p>
<p>{$feu->Lang('expires')}:&nbsp;{$userinfo.expires}</p>
{foreach from=$user_properties item='entry'}
{if $entry.type != 0}
<p>{$entry.prompt}:&nbsp;{$entry.data}</p>
{/if}
{/foreach}
