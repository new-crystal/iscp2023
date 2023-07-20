/*
---------------------------------------
	: Custom - Table Datatable js :
---------------------------------------
*/
"use strict";
$(document).ready(function() {
	if ($("#datatable").length > 0) {
		var indexLastColumn = $("#datatable").find('tr')[0].cells.length-1;
		/* -- Table - Datatable -- */
		$('#datatable').DataTable({
			responsive: true,
			"order": [[ indexLastColumn, "desc" ]],
			lengthChange: false,
			displayLength: 20,
			responsive: true,
			info : false,
			filter: false
		});
	}
});