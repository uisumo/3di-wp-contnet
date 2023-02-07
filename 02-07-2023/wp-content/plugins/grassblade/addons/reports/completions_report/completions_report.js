
GB_REPORTS_FUNCTIONS["completions_report"] = [];
GB_REPORTS_FUNCTIONS["completions_report"]["columns"] = function(columns, data, response, context) {
	var group_avg_visibility = (typeof data.group_id == "number");
	columns = [
				{ data: "sno", title: "S.No.", orderable:false, searchable: false },
				{ data: "name", title: "User", visible: true },
				{ data: "user_email", title: "Email", visible: false },
				{ data: "content", title: "Content" },
				{ data: "date", title: "Date" },
				{ data: "score", title: "Student Score %" },
				{ data: "group_avg", title: "Group Avg", visible: group_avg_visibility },
				{ data: "global_avg", title: "Global Avg" },
				{ data: "time_spent_h", title: "Time Spent", orderData: [9] },
				{ data: "time_spent", visible: false  }
			];
	return columns;
}
GB_REPORTS_FUNCTIONS["completions_report"]["buttons"] = function(buttons, response, context) {
	buttons["excel"] = 1;
	buttons["print"] = 1;
	buttons["pdf"]	= 1;
	return buttons;
}

GB_REPORTS_FUNCTIONS["completions_report"]["createdCell"] = function(params, context) {
	if(typeof params.response.global_avg == "object" && params.updated_column_list[params.col].data == "score") {
		var global_avg = params.rowData.global_avg*1;
		gb_reports_score_click(params.td, params.cellData, global_avg);
	}
}
