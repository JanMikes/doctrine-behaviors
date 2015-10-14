var fixHelperModified = function(e, tr) {
	var $originals = tr.children();
	var $helper = tr.clone();
	$helper.children().each(function(index)
	{
		$(this).width($originals.eq(index).width())
	});
	return $helper;
};

$(function(){
	$("tbody.sortable-records").sortable({
		helper: fixHelperModified,
		placeholder: "ui-state-highlight",
		update: function( event, ui ) {
			var positions = $(this).sortable("toArray", {attribute: "data-reorder-id"});
			var reorderActionUrl = $(this).data("reorder-action");

			$.nette.ajax({
				url: reorderActionUrl,
				type: "POST",
				data: {
					"positions": positions
				}
			});
		}
	}).disableSelection();
});