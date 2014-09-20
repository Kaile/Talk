function Request(params) {
	this.uri = params.uri;
	this.data = params.data;
	this.method = params.method;
	
	var dfd = new $.Deferred();
	
	this.success = function(data) {
		console.info('I get data: ' + data);
		dfd.resolve();
		return data;
	};
	
	this.error = function(errorMsg) {
		dfd.reject();
		console.error('I get error: ' + errorMsg);
	};
	
	$.ajax({
		url: this.uri,
		data: this.data,
		type: this.method,
		success: function (data, textStatus, jqXHR) {
			this.success();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			this.error();
		}
	});
	
	return dfd.promise();
}

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

function get(params) {
	return $.get(params.url, params.data, params.success);
}