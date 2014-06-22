<script type="text/javascript">
PAGEBACK_URL = '{$pageback_url}';
PAGEBACK_TEXT = '{$pageback_text}';
</script>
{*cms_jquery*}

<h3>{$content_name}</h3>
<p>{$restorelink}<br />&nbsp;</p>
<p><b>{$mod->Lang('revision')} {$revision_nr}</b><br />&nbsp;</p>

<pre id="previewcode">
<code>{$code}</code>
</pre>
<p>&nbsp;<br />{$restorelink}</p>