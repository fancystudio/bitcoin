{if isset($form)}
	<div style="color: red;">{$form->showErrors()}</div>
	{$form->getHeaders()}
	<p style="text-align: right;">
		{$form->getButtons()}
	</p>

		<div style="float: right;">
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
				$('[name={/literal}{$id}{literal}code]').insertAtCaret(field);
				return false;
			});
		})(jQuery);
		{/literal}
		</script>
		</div>

	{$form->showWidgets('<div class="pageoverflow">
		<div class="pagetext">%LABEL%:</div>
		<div class="pageinput">%INPUT% <em>%TIPS%</em></div>
		<div class="pageinput" style="color: red;">%ERRORS%</div>
	</div>')}

	<p style="text-align: right; margin-top: 15px;">
		{$form->getButtons()}
	</p>
	{$form->getFooters()}
{/if}