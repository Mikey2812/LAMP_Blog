$(function () {
	var numAllBtn = 0;
	var numBtnActive;
	var listChecked = [];
	var strFil = "";
	var ctl = $("table.dataTable").attr("controller");

	function delRecord(id, act) {
		urlDele = rootUrl + "admin/" + ctl + "/" + act + "/" + id;
		$.ajax({
			url: urlDele,
			success: function (data) {
				if (data != 'error') {
					$('#row' + id).remove();
				}
			}
		})
	}

	function trashRecord(id, act, status = null) {
		urlDele = rootUrl + "admin/" + ctl + "/" + act + "/" + id + "/" + status;
		$.ajax({
			url: urlDele,
			success: function (data) {
				alert(data);
			}
		})
	}

	$(function () {
		$('td.btn-act input.trash-record').change(function () {
			idAct = $(this).attr('alt');
			idAct = idAct.split('&');
			if (idAct[1] == 1) {
				var isTrash = confirm("Are you sure off this record?");
				if (isTrash) {
					trashRecord(idAct[0], "trash", idAct[1]);
				}
			} else {
				var isTrash = confirm("Are you sure on this record?");
				if (isTrash) {
					trashRecord(idAct[0], "trash", idAct[1]);
				}
			}
		});
	});

	$('tbody.records').on('click', 'td.btn-act button.del-record', function () {
		var isDel = confirm("Are you sure to delete this record?");
		if (isDel) {
			idAct = $(this).attr('alt');
			delRecord(idAct, 'del');
		}
	});

	$('table.dataTable').on('click', '.checkAll input', function () {
		if ($(this).prop('checked')) {
			listChecked = [];
			$('.checkboxRecord input').each(function () {
				listChecked.push($(this).attr('alt'));
				$(this).prop('checked', true);
			});
			$('.checkAll input').prop('checked', true);
		} else {
			$('.checkboxRecord input').each(function () {
				listChecked = [];
				$(this).prop('checked', false);
			});
			$('.checkAll input').prop('checked', false);
		}
	});

	//Check to delete
	$('table.dataTable').on('click', '.checkboxRecord input', function () {
		var idCheckBox = $(this).attr('alt');
		if ($(this).prop('checked')) {
			listChecked.push(idCheckBox);
		} else {
			listChecked.splice($.inArray(idCheckBox, listChecked), 1);
			$('.checkAll input').prop('checked', false);
		}
	});

	//Click To Send To Trash Record
	$('#trash-records').on('click', function () {
		if (listChecked.length > 0) {
			var isDel = confirm("Are you sure to move those records to trash!");
			if (isDel) {
				var ids = listChecked.toString();
				urlDel = rootUrl + "admin/" + ctl + "/trashmany/ids=" + ids;
				$.ajax({
					url: urlDel,
					success: function (data) {
						if (data != 'error') {
							$.each(listChecked, function (k, v) {
								$('#row' + v).remove();
							});
							listChecked = [];
							/*
							var isReload = confirm("Do you want reload this page?");
							if(isReload){
								location.reload();
							}
							*/
						}
					}
				})
			}
		} else {
			alert("No rerord(s) selected tp send to trash!");
		}
	});

	//Click To Delete Record
	$('#delete-records').on('click', function () {
		if (listChecked.length > 0) {
			var isDel = confirm("Are you sure delete those records!");
			if (isDel) {
				var ids = listChecked.toString();
				urlDel = rootUrl + "admin/" + ctl + "/delmany/ids=" + ids;
				$.ajax({
					url: urlDel,
					success: function (data) {
						if (data != 'error') {
							$.each(listChecked, function (k, v) {
								$('#row' + v).remove();
							});
							listChecked = [];
							/*
							var isReload = confirm("Do you want reload this page?");
							if(isReload){
								location.reload();
							}
							*/
						}
					}
				})
			}
		} else {
			alert("No record(s) selected for deletion!");
		}
	});

	//Table Filter
	$('#table_filter input').on('keyup', function (e) {
		if (e.which == 13) {
			strFil = $(this).val().trim();
		}
	})
	$('#submit-search').off('click').on('click', function () {

	});

	// filter form 
	$('#btn_filter_' + ctl + '_table').on('click', function () {
		status = $('#select_list_' + ctl + '_status').val();
		type = $('#select_list_' + ctl + '_type').val();
		position = $('#select_list_' + ctl + '_position').val();
		page = $('#select_list_' + ctl + '_page').val();
		type = $('#select_list_' + ctl + '_type').val();
		category = $('#select_list_' + ctl + '_category').val();
		content = '';
		if (status && status != 'all') content += '/status=' + status;
		if (type && type != 'all') content += '/type=' + type;
		if (position && position != 'all') content += '/position=' + position;
		if (page && page != 'all') content += '/page=' + page;
		if (type && type != 'all') content += '/type=' + type;
		if (category && category != 'all') content += '/category=' + category;
		var url = rootUrl + 'admin/' + ctl + '/index' + content;
		window.location.replace(url);
	});

	$('#statusCheckboxTop,#statusCheckboxBottom').change(function (e) {
		let url = window.location.href;
		let checkv = $(this).prop('checked') ? '1' : '0';
		let ov = 1 - checkv;
		if (url.indexOf('status') == -1) {
			url += (url.indexOf('?') == -1) ? "?" : "&";
			url += 'status=' + checkv;
		}
		else url = url.replace('status=' + ov, 'status=' + checkv);
		window.location.replace(url);
	});

	// search form
	$('#form-' + ctl + '-search').submit(function (e) {
		e.preventDefault();
		var content = $('#form-' + ctl + '-search').find('input[name="search"]').val();
		if (content === '') {
			window.location.replace(rootUrl + 'admin/' + ctl + '');
		} else {
			var arr = window.location.href.split('/')
			var arr2 = window.location.href.split('/p=')
			var last = arr[arr.length - 1].split('=');
			if (last[0] == 'p') {
				var url = arr2[0] + '/search=' + content;//+'/p='+arr2[1];
			} else {
				var url = window.location.href + '/search=' + content;
			}
			window.location.replace(url);
		}
	});
});