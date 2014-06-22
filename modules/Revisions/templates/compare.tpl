<script type="text/javascript">
PAGEBACK_URL = '{$pageback_url}';
PAGEBACK_TEXT = '{$pageback_text}';
</script>
{*cms_jquery*}
<h3>{$content_name}</h3>
{if $diff == ''}
<p>{$mod->Lang('revisions_identical')}</p>
{else}
<p>{$restorelink}<br />&nbsp;</p>
{$diff}
<p>&nbsp;<br />{$restorelink}</p>
{/if}