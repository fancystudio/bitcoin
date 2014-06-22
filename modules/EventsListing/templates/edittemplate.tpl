{$startform}
{$tabto}
{$template}
<div class="pageoverflow">
	<p class="pagetext">*{$prompt_title}:</p>
	<p class="pageinput">{$input_title}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">*{$prompt_content}:</p>
	<p class="pageinput">{$input_content}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{if isset($idfield)}{$idfield}{/if}{$submit}{$cancel}{$apply}</p>
</div>
{$endform}
