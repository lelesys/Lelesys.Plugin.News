$(document).ready(function() {
	$("#rate-here").click(function() {
		$("#rate-recipe").css("display","block");
	});

	$('<span class="checkbox"></span>').insertBefore('.styled');

	$(".checkbox").click(function() {
		var check = $(this).next();
		if(check.is(':checked')){
			$(this).removeClass("checked");
			check.removeAttr("checked");
		} else {
			$(this).addClass("checked");
			check.attr('checked', 'true');
		}
	});

		$(".checkbox").click(function() {
			var check = $(this).next();
			if(check.is(':checked')){
				$(this).prevAll(".checkbox").addClass("checked");
				check.prevAll(':checkbox').attr('checked', 'true');
			} else {
				$(this).nextUntil("#points").removeClass("checked");
				check.nextUntil("#points").removeAttr("checked");
			}
		});

	function countChecked() {
		var n = $("input:checked").length;
		$("#points").val(n);
	}
	countChecked();
	$(".checkbox").click(countChecked);

});
