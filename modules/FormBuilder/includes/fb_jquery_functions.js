jQuery.fn.fb_delete_field = function(message) {

    if (confirm(message)) {

		var url = jQuery(this).attr("href");
		var parent = jQuery(this).closest("tr");
		
		jQuery.ajax({
			type: "GET",
			url: url,
			error: function() {
				
				alert('Sorry. There was an error.');
			},			
			success: function() {
			
				parent.fadeOut("1000", function() {

					parent.remove();
				
					jQuery(".module_fb_table").find("tbody tr").removeClass();
					jQuery(".module_fb_table").find("tbody tr:nth-child(2n+1)").addClass("row1");
					jQuery(".module_fb_table").find("tbody tr:nth-child(2n)").addClass("row2");
				});			
			}	
		});
		
	}
	

};

jQuery.fn.fb_get_template = function(message, url) {

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
				
				jQuery("#fb_form_template").val(data);
			}
		});	
				
	
	}
	
};

jQuery.fn.fb_admin_update_field_required = function() {

	var url = jQuery(this).attr("href");
	var current = jQuery(this);
	
	jQuery.ajax({
		type: "POST",
		url: url,
		data: '&showtemplate=false',
		error: function() {
				
			alert('Sorry. There was an error.');
		},			
		success: function() {
			
			if(current.hasClass("true")) {
		
				var replaceurl = current.attr("href").replace('fbrp_active=off','fbrp_active=on');
				var replacepic = current.children().attr("src").replace('true', 'false');
				var replaceother = 'false';			
				current.removeClass("true").addClass("false");
			
			} else {
				
				var replaceurl = current.attr("href").replace('fbrp_active=on','fbrp_active=off');
				var replacepic = current.children().attr("src").replace('false', 'true');
				var replaceother = 'true';
				current.removeClass("false").addClass("true");
		
			}
		
			current.attr({ href : replaceurl });
			current.children().attr({ src : replacepic, title : replaceother, alt : replaceother });		
			
			
		}
	});		
};

jQuery.fn.fb_set_tab = function() {

	var active = jQuery('#page_tabs > .active');
	jQuery('.fbr_atab').val(active.attr('id'));
}