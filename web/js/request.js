function post(uri, data) {
	this.uri = uri;
	this.data = data;
	var dfd = new $.Deferred();
	
	$.ajax({
		url: uri,
		data: data,
		type: 'POST',
		success: function (data, textStatus, jqXHR) {
			if (data === 1) {
				dfd.resolve();
			} else {
				dfd.reject();
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			dfd.reject();
		}
	});
	
	return dfd.promise();
}

function get(uri, data) {
	data = data || {};
	
	var dfd = $.Deffered();
	
	$.ajax({
		url: uri,
		type: 'GET',
		data: data,
		success: function (data, textStatus, jqXHR) {
			dfd.resolve(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			dfd.reject();
		}
	});
}