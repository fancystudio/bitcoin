jQuery.fn.fbr_get_template = function(message, url, target) {

	var value = jQuery(this).val();
		
	if (confirm(message)) {
			
		jQuery.ajax({
			type: "GET",
			url: url,			
			data: '&m1_fbrp_tid='+value,
			error: function() {
				
				alert('Sorry. There was an error.');
			},
			success: function(data) {
				jQuery(target).val(data);
			}
		});	
	}
};

function toggle_column(basename) {
	var isset = false;
	jQuery('select[name^='+basename+']').each(function(index,element) {

		if (element.selectedIndex != 0)
			{
			isset = true;
			}
		} 
	);
	if (isset)
		{
		jQuery('select[name^='+basename+']').each(function(index,element) {
			element.selectedIndex = 0;
			}); 
		}
	else
		{
		var count = 1;
		jQuery('select[name^='+basename+']').each(function(index,element) {
			element.selectedIndex = count++;
			}); 
		}
};

jQuery.fn.fbr_set_tab = function() {
	var active = jQuery('#page_tabs > .active');
	jQuery('#m1_active_tab').val(active.attr('id'));
}