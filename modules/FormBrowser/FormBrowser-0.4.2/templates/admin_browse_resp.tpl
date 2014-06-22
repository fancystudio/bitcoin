{* default admin full-record template *}
<h2>{$browser_title}</h2>
{if isset($fbrp_message) && !empty($fbrp_message)}<h2>{$fbrp_message}</h2>{/if}
{if $inner_nav !=''}<div class="module_bfr_innernav">{$inner_nav}</div>{/if}
<table cellspacing="0" class="pagetable">
	<tbody>
		{if $adminapproval}<tr><td>{$title_approval_date}</td><td>{$resp->admin_approved}</td></tr>{/if}
		<tr><td>{$title_submit_date}</td><td>{$resp->submitted}</td></tr>
        {if $userapproval}<tr><td>{$title_user_approved}</td><td>{$resp->user_approved}</td></tr>{/if}
		{* if using the Advanced Browser type, you will probably
		 *	want to replace the loop below with specific fields. It
		 *  would then look like:
		 * <tr><td>{$resp->names[1]}</td><td>{$resp->values[1]}</td></tr>
		 *
		 * $resp->names[#] will give you the field name for that index number as setup in FormBuilder
		 * $resp->values[#] will give you the value for that index number within that specific record
		 *     		 
		 * to get those index numbers, temporarily put in a loop
	     * like this:
		 * 
		 * <pre> {section name=namelistindex start=0 loop=$count}
	     *  Index: {$smarty.section.namelistindex.index} -> {$resp->names[$smarty.section.namelistindex.index]}<br />
		 * {/section}</pre>
		 *}
		{section name=namelist start=0 loop=$count}
				{if isset($resp->names[$smarty.section.namelist.index])}
  				<tr><td>{$resp->names[$smarty.section.namelist.index]|escape}</td><td>{$resp->values[$smarty.section.namelist.index]|escape}</td></tr>
				{/if}
  		{/section}
		</tr>
	</tbody>
</table>
