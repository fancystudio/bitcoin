/* <![CDATA[ */
(function ($) {
$.fn.hasB = function() {
		var hasB = $(this).parent().find("b").find(".priority:first").size();		
		return hasB;
	}
	
	$.fn.autodepth = function() {
		$(this).parentsUntil("tbody").parent().find("tr").next().first().addClass("h");
		var pg = $(this).parentsUntil("tr").parent().find("td.pg:first").html();
		var a = Array.map(pg, function(x) { return String.charCodeAt(x) });
		var depth = $.grep( a, function(n,i){ return n == 187;});
		
		switch(depth.length) {
			case 0:				
			  var autodepth = ($(this).parentsUntil("tr").parent().hasClass("h")) ? 100 : 80;
			  break;
			case 1:
			  var autodepth = 40;
			  break;
			default:
			  var autodepth = 20;
		}
		return autodepth;
	}
})(jQuery);

$(document).ready(function(){
	var spinner = "<img src=\"'.$root_url.'/modules/SEOTools2/img/ajax-loader.gif\" alt=\"Ajax loading...\" width=\"16\" height=\"16\" class=\"spinner\" />";
	
	$(".seo2ajax a").click(function(e){
		e.preventDefault();
		var img = $(this).find("img");
		var imgsrc = img.attr("src");
		var imgsrc = (imgsrc.indexOf("true") !== -1) ? imgsrc.replace("true","false") : imgsrc.replace("false","true");
		$(img).attr("src",imgsrc);		
		var x = $(this).attr("href");
		$(this).append(spinner);
		$.get(x, function(data){
			$(".spinner:first").detach();
		});
	});
	$(".updown").click(function(e){
		e.preventDefault();
		$(this).append(spinner);
		var priority = ($(this).hasB() > 0) ? $(this).parent().find("b").find(".priority:first") : $(this).parent().find(".priority:first");		
		var amt = ($(this).hasClass("up")) ? 10 : -10;
		var newval = Number(priority.text())+amt;
		var x = $(this).attr("href");
		$.get(x, function(data){
			$(priority).text(newval);
			$(".spinner:first").detach();
		});
	});
	
	
	$(".reset100 a").click(function(e){
		e.preventDefault();
		var td = $(this).parentsUntil("td").parent();
		$(td).append(spinner);
		var b = $(this).parent();
		
		var defaultPriority = "(auto) <span class=\"priority\">" + $(this).autodepth() + "</span>% ";		
		var x = $(this).attr("href");
		$.get(x, function(data){		
			$(td).append(defaultPriority);	
			$(b).remove();
			$(".spinner:first").detach();
		});
		
	});
});
/* ]]> */
