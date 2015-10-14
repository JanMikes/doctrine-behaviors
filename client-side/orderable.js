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
	$("table.orderable thead tr").prepend("<th></th>");
	$("table.orderable tbody tr").prepend("<td class='orderable-column'><i class='fa fa-arrows-v'></i></td>");

	$("table.orderable tbody").sortable({
		helper: fixHelperModified,
		placeholder: "ui-state-highlight",
		update: function( event, ui ) {
			var positions = $(this).sortable("toArray", {attribute: "data-orderable-id"});
			var reorderActionUrl = $(this).parent().data("orderable-handle");

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