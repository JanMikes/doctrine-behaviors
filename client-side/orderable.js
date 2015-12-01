var selector = "table.orderable";

$(function(){
	$.nette.ext("orderableTable", {
		success: function(payload) {
			if (!payload.redirect) {
				orderableTable.init(selector);
			}
		}
	});

	orderableTable.init(selector);
});


var orderableTable = (function()
{
	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index)
		{
			$(this).width($originals.eq(index).width())
		});
		return $helper;
	};

	function init(selector) {
		$(selector).each(function(){
			if ($(this).find("tbody > tr").length > 1) {
				$("table.orderable thead tr").prepend("<th></th>");
				$("table.orderable tbody tr").prepend("<td class='orderable-column'><i class='fa fa-arrows-v'></i></td>");
			} else {
				$(this).removeClass("orderable");
			}
		});

		$(selector + " tbody").sortable({
			helper: fixHelperModified,
			placeholder: "ui-state-highlight",
			update: function( event, ui ) {
				var positions = $(this).sortable("toArray", {attribute: "data-orderable-id"});
				var reorderActionUrl = $(this).parent().data("orderable-handle");

				$.nette.ajax({
					url: reorderActionUrl,
					type: "POST",
					off: ["orderableTable"],
					data: {
						"positions": positions
					}
				});
			}
		}).disableSelection();	
	}

	return { init : init };
})();
