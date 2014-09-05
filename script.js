/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function send(char) {
	$.post(
		'server.php', 
		{'command' : 'send', 'message': char}, 
		function(data) {
			char = data;
		}
	).done(function() {
		$('#output-field').append(char);
	});
}

$().ready(function(){
	$('#input-field').on('keydown', function(e) {
		if ((e.keyCode === 8) ||
			(e.keyCode === 46)) {
			return false;
		}
	});
	
	value = '';
	
    $('#input-field').on('input', function(e) {
		
        var newValue = $(this).val();
		
		if (newValue.length !== value.length) {
			for (var i = value.length; i < newValue.length; ++i) {
				value += newValue[i];
				send(newValue[i]);
			}
		}
    });
	
	$('#send-button').on('click', function() {
		$.post(
			'server.php', 
			{'command' : 'save', 'message' : value}, 
			function(data) {
				$('#error').html(data);
			}
		).done(function() {
			delete value;
			value = '';
			$('#input-field').val('');
			$('#output-field').html('');
		});
	});
});