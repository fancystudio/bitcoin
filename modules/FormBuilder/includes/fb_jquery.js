jQuery(function($){

	//run sortable function
	$(".module_fb_table tbody").sortable({
		helper: function(event, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		},
        update: function(event, ui) {
		
			$(this).find("tr").removeClass();
			$(this).find("tr:odd").addClass("row2");
			$(this).find("tr:even").addClass("row1");
			
			var rows = $(this).find("tr").toArray();
			var sortstr = rows[0].id;
			for (var i=1; i<rows.length; i++) {
				sortstr += ","+rows[i].id;
			}
			
			$('.fbrp_sort').val(sortstr);
        }
	});	
	
    $(".updown").hide();
});