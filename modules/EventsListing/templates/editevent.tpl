{$startform}
{$tabto}
{$event}
<div class="pageoverflow">
    <p class="pagetext">{$prompt_active}:</p>
    <p class="pageinput">{$input_active}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">*{$prompt_short}:</p>
	<p class="pageinput">{$input_short}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$prompt_category}:</p>
	<p class="pageinput"><input type="hidden" name="{$formid}category" value="1" />{foreach from=$cats key='catkey' item='catvalue'}
		{capture assign='checked'}{/capture}
		{foreach from=$cats_selected item='scat'}{if $catvalue==$scat}{capture assign='checked'} checked="checked"{/capture}{/if}{/foreach}
		<input type="checkbox" name="{$formid}cats[]" value="{$catvalue}"{$checked} /> {$catkey}<br />
	{/foreach}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">*{$prompt_start_date}:</p>
	<p class="pageinput">
		Date:
		{html_select_date
			prefix=$prefix_startdate
			time=$start_date
			start_year="-5"
			end_year="+10"}
		Time:
		{html_select_time
			display_seconds=false
			minute_interval=15
			prefix=$prefix_startdate
			time=$start_date}
	</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">*{$prompt_end_date}:</p>
	<p class="pageinput">
		Date:
		{html_select_date
			prefix=$prefix_enddate
			time=$end_date
			start_year="-5"
			end_year="+10"}
		Time:
		{html_select_time
			display_seconds=false
			minute_interval=15
			prefix=$prefix_enddate
			time=$end_date}
	</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">*{$prompt_long}:</p>
	<p class="pageinput">{$input_long}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$prompt_image}:</p>
	<p class="pagetext">{$input_image}{$input_image_ov}<br/>{$input_image_del}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$prompt_link}:</p>
	<p class="pageinput">{$input_link}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{if isset($idfield)}{$idfield}{/if}{$submit}{$cancel}{$apply}</p>
</div>
{$endform}
