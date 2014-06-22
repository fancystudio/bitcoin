{* default user full-record template *}

<h2>{$browser_title}</h2>
{if isset($fbrp_message) && !empty($fbrp_message)}<h2>{$fbrp_message}</h2>{/if}
{$inner_nav}
<table cellspacing="0" class="pagetable">
	<tbody>
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
		{section name=foo start=0 loop=$count}
		  <tr><td>{$resp->names[$smarty.section.foo.index]|escape}</td>
		<td>{$resp->values[$smarty.section.foo.index]|escape}</td>
		</tr>
		{/section}
	</tbody>
</table>