$(function () {

	var ctl = $("table.dataTable").attr("controller");

	function delRecord(id, act) {
		urlDele = rootUrl + "admin/" + ctl + "/" + act + "/" + id;
		$.ajax({
			url: urlDele,
			success: function (data) {
				if (data != 'error') {
					$('#row' + id).remove();
					toastr["success"]("DELETE", "Success!!");
				}
			},
			error: (result) => {
				toastr["error"]("DELETE", result);
			}

		})
	}

	$('tbody.records').on('click', 'td.btn-act button.del-record', function () {
		var isDel = confirm("Are you sure to delete this record?");
		if (isDel) {
			idAct = $(this).attr('alt');
			delRecord(idAct, 'del');
		}
	});
});