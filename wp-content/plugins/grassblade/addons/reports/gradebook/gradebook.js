
GB_REPORTS_FUNCTIONS["gradebook"] = [];
GB_REPORTS_FUNCTIONS["gradebook"]["columns"] = function(columns, data, response, context) {
	//console.log(columns, data, context);
	columns  = 	[
					{ data: "sno", title: "S.No.", orderable:false, searchable: false },
					{ data: "name", title: "User" },
					{ data: "user_email", title: "Email", visible: false },
				];
	var i = columns.length;
	jQuery("#nss_report_contents :checkbox:checked").each(function(t) {
		columns[i++] = { data: jQuery(this).val(), title: jQuery(this).parent().text(), className: "content_"+jQuery(this).val()  };
	});
	return columns;
}


GB_REPORTS_FUNCTIONS["gradebook"]["createdCell"] = function(params, context) {
	var col = params.col;
	var content_id = params.updated_column_list[col].data;
	var global_avg = (typeof params.response == "object" && typeof params.response.global_avg == "object" && !isNaN(content_id) && typeof params.response.global_avg[content_id] == "number")? params.response.global_avg[content_id]:NaN;
	gb_reports_score_click(params.td, params.cellData, global_avg );
}
