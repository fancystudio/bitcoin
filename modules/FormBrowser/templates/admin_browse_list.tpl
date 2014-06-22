{* default admin list template *}
{literal}
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$( ".statusObjednavky" ).each(function( index ) {
		var status = this;
		$.ajax({
			type: "POST",
			url: "../lib/admin/OrderStatusAjax.php",
			data: {
				"type" : "get",
				"idOrder" : $(status).attr("id"),
				"value" : null
			},
			beforeSend: function() 
			{
				//sem dat gifko
			},
			success: function(response)
			{
				if(response.status == 'success'){
					$(status).val(response.value);
				}else{
					alert("Chyba pri práci so statusom objednávky");
				}     
			},
			error: function(response)
			{
				alert("Chyba pri práci so statusom objednávky");
			}
		});  
	});
	$(".statusObjednavky").change(function(){
		//$(".changeStatus").html("");
		$.ajax({
			type: "POST",
			url: "../lib/admin/OrderStatusAjax.php",
			data: {
				"type" : "set",
				"idOrder" : $(this).attr("id"),
				"value" : $(this).val()
			},
			beforeSend: function() 
			{
				//sem dat gifko
			},
			success: function(response)
			{
				if(response.status == 'success'){
					//$(".changeStatus").html("Status bol zmenený").css("color","green");
				}else{
					//$(".changeStatus").html("Chyba pri práci so statusom objednávky").css("color","red");
					alert("Chyba pri práci so statusom objednávky");
				}     
			},
			error: function(response)
			{
				alert("Chyba pri práci so statusom objednávky");
				//$(".changeStatus").html("Chyba pri práci so statusom objednávky").css("color","red");
			}
		});
	});
});
function select_all()
{
	checkboxes = document.getElementsByTagName("input");
		elem = document.getElementById('selectall');
state = elem.checked;
	for (i=0; i<checkboxes.length ; i++)
	{
			if (checkboxes[i].type == "checkbox") 
	  {
		checkboxes[i].checked=state;
	  }
	}
}
//]]>
</script>
{/literal}
<!--<h2>{$browser_title}</h2>
{if isset($fbrp_message) && !empty($fbrp_message)}<h2>{$fbrp_message}</h2>{/if}
{if $inner_nav !=''}<div class="module_fbfr_innernav">{$inner_nav}</div>{/if} -->
{if $hasnav == 1}
<div class="module_bfr_browsenav">{$prev}&nbsp;({$pageof})&nbsp;{$pagelinks}&nbsp;{$next}</div>
{/if}
{$form_start}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
		<th>&nbsp;</th>
		{if $adminapproval}<th>{$title_approval_date}</th>{/if}
		<th>{$title_sort_submit_date}</th>
        {if $userapproval}<th>{$title_user_approved}</th>{/if}
		{* if using the Advanced Browser type, you will probably
		 *	want to replace the loop below with specific fields. It
		 *  would then look like:
		 * <th>{$sortingnames[1]}</th><th>{$sortingnames[3]}</th><th>{$sortingnames[12]}</th>
		 *
		 * to get those index numbers, temporarily put in a loop
		 * like this:
		 * 
		 * <pre> {section name=namelist start=0 loop=$fieldcount}
		 * Index: {$smarty.section.namelist.index} -> {$sortingnames[$smarty.section.namelist.index]}<br />
		 * {/section}
		 * </pre>
		 *}
		{section name=namelist start=0 loop=$fieldcount}
  				<th>{$sortingnames[$smarty.section.namelist.index]}</th>
  		{/section}
  		 <th>status objednavky</th>
		<!-- <th class="pageicon"></th> -->
		<th class="pageicon"></th> 
		<th class="checkbox" style="width: 61px;"><input id="selectall" type="checkbox" onclick="select_all();" /></th> 
		</tr>
	</thead>
	<tbody>
	{foreach from=$list item=entry}
		<tr>
			<td>{$entry->viewlink}</td>
			{if $adminapproval}<td>{$entry->admin_approval}</td>{/if}
			<td>{$entry->submitted}</td>
            {if $userapproval}<td>{$entry->user_approved}</td>{/if}
			{* if using an Advanced template, you will probably
			 *	want to replace the loop below with specific fields. It
			 *  would then look like:
			 * <td>{$entry->fields[1]|escape}</td><td>{$entry->fields[3]|escape}</td><td>{$entry->fields[12]|escape}</td>
			 *
			 * to get those index numbers, see the note above
			 *}
			{section name=fldlist start=0 loop=$fieldcount}
  				<td>{$entry->fields[$smarty.section.fldlist.index]|escape}</td>
  			{/section}
  			<td>
				<select id="{$entry->id}" class="statusObjednavky">
				  <option value="otvorena">Otvorená</option>
				  <option value="vybavujem">Vybavujem</option>
				  <option value="vybavena">Vybavená</option>
				</select>
			</td>
			<!-- <td>{$entry->editlink}</td> -->
			<td>{$entry->deletelink}</td>
			<td class="checkbox">{$entry->delbox}</td>
		</tr>
	{/foreach}
	</tbody>
</table>
<div class="pageoptions">
	<div style="margin-top: 0; float: right; text-align: right">
		{$delete}
	</div>
</div>
</form>
{if $hasnav == 1}
<div class="module_bfr_browsenav">{$prev}&nbsp;{$pagelinks}&nbsp;{$next}</div>
{/if}
<!-- {$addlink} {$addresp}-->
