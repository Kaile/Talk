function post(uri, data) {
	var uri = uri;
	var data = data;
	var dfd = new $.Deferred();
	
	$.ajax({
		url: uri,
		data: data,
		type: 'POST',
		success: function (data, textStatus, jqXHR) {
			if (data === '1') {
				dfd.resolve();
			} else {
				dfd.reject(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			dfd.reject();
		}
	});
	
	return dfd.promise();
}

function get(uri, data) {
	var data = data || {};
	
	var dfd = new $.Deferred();
	
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
	
	return dfd.promise();
}