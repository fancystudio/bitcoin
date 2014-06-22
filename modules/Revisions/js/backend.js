jQuery(function($){
	// POPUP LINKS
	$('a.popup').click(function(e){
		window.open($(this).attr('href'), $(this).attr('title'),'width=800, height=600,scrollbars=yes');
		e.preventDefault();
		return false;
	});
	// DATEPICKER FIELDS
	$('.datepicker input').datepicker({
		dateFormat: 'yy-mm-dd'
	})
	// PAGEBACK LINK
	if(typeof PAGEBACK_URL != 'undefined')
	{
		$('a.pageback').attr('href', PAGEBACK_URL).text(PAGEBACK_TEXT)
	}
});