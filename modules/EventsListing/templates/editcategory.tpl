{$startform}
{$tabto}
{$category}
<div class="pageoverflow">
	<p class="pagetext">*{$prompt_short}:</p>
	<p class="pageinput">{$input_short}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_active}:</p>
    <p class="pageinput">{$input_active}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$prompt_long}:</p>
	<p class="pageinput">{$input_long}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$prompt_image}:</p>
	<p class="pagetext">{$input_image}{$input_image_ov}<br/>{$input_image_del}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{if isset($idfield)}{$idfield}{/if}{$submit}{$cancel}{$apply}</p>
</div>
{$endform}
