
GB_REPORTS_FUNCTIONS["progress_snapshot"] = [];
GB_REPORTS_FUNCTIONS["progress_snapshot"]["columns"] = function(columns, data, response, context) {
	//console.log(columns, data, context);
	columns  = 	[
					{ data: "sno", title: "S.No.", orderable:false, searchable: false },
					{ data: "name", title: "User" },
					{ data: "user_email", title: "Email", visible: false },
				];

	if(typeof response.lessons == "object" && typeof response.lesson_order == "object") {
		var i = 3;
		jQuery.each(response.lesson_order, function(order, lesson_id) {
			var lesson_title = response.lessons[lesson_id];
			columns[i++] = { data: lesson_id, title: lesson_title };
		});
	}
	return columns;
}

GB_REPORTS_FUNCTIONS["progress_snapshot"]["createdCell"] = function(params, context) {
	var progress_html = gb_reports_data_to_progressbar(params.cellData);
	if(progress_html.length > 0)
	jQuery(params.td).html(progress_html);
}
