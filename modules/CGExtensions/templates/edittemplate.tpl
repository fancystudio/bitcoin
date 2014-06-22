<div class="pageoverflow">
<h3>{if isset($module_description)}{$module_description} - {/if}{$title}:</h3>
</div>
{$formstart}{$hidden}
{if isset($template_info)}
<div class="pageoverflow">
  {$template_info}
</div>
{/if}
<div class="pageoverflow">
  <p class="pagetext">{$prompt_templatename}:</p>
  <p class="pageinput">{$templatename}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$prompt_template}:</p>
  <p class="pageinput">{$template}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>
{$formend}
