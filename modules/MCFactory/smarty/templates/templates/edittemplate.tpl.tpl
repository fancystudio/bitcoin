{$form_start}

<div style="float: right; width: 200px;">
<p><strong>Available fields</strong></p>
<ul class="extra_fields" style="margin-left: 0; padding-left: 0;">
	{{foreach from=$extra_fields item=field}}
	<li><a href="#">$item->{{$field.name}}</a></li>
	{{/foreach}}
</ul>
<script type="text/javascript">
{literal}
(function($) {
	$.fn.insertAtCaret = function (myValue) {
	        return this.each(function(){
	                //IE support
	                if (document.selection) {
	                        this.focus();
	                        sel = document.selection.createRange();
	                        sel.text = myValue;
	                        this.focus();
	                }
	                //MOZILLA/NETSCAPE support
	                else if (this.selectionStart || this.selectionStart == '0') {
	                        var startPos = this.selectionStart;
	                        var endPos = this.selectionEnd;
	                        var scrollTop = this.scrollTop;
	                        this.value = this.value.substring(0, startPos)
	                                      + myValue
	                              + this.value.substring(endPos,
	this.value.length);
	                        this.focus();
	                        this.selectionStart = startPos + myValue.length;
	                        this.selectionEnd = startPos + myValue.length;
	                        this.scrollTop = scrollTop;
	                } else {
	                        this.value += myValue;
	                        this.focus();
	                }
	        });

	};
	$('.extra_fields a').click(function() {
		var field = '{'+$(this).text()+'}';
		$('[name={/literal}{$id}{literal}templatedetails]').insertAtCaret(field);
		return false;
	});
})(jQuery);
{/literal}
</script>
</div>

<div class="pageoverflow">
		<p class="pagetext">{$title_template}:</p>
		<p class="pageinput">{$input_template}</p>
</div>

<div class="pageoverflow">
		<p class="pagetext">{$code_template}:</p>
		<p class="pageinput">{$textarea_template}</p>
</div>


	{$form_details_submit}
	{$form_details_apply}
	{$form_details_restorelist}
	{$form_details_restoredetails}

</form>
