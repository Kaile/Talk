<?php
$command = post('command');
if ($command) {
	$message = post('message');
		
	call_user_func($command . 'Message', $message);
	
	echo strlen($message);
}

function saveMessage($message) {
	$db = mysql_connect('localhost', 'root', 'root');
	mysql_set_charset('utf-8');
	mysql_select_db('talk');
	mysql_query('INSERT INTO messages(message, date) VALUES ("'. $message .'", NOW())');
	echo mysql_error();
}

function sendMessage($message) {
	return $message;
}

function post($index = null) {
	if ($index === null) {
		return $_POST;
	}
	
	if (isset($_POST[$index])) {
		return $_POST[$index];
	} else {
		return false;
	}
}