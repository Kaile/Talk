<?php
$command = post('command');
if ($command) {
	$message = post('message');
		
	call_user_func($command . 'Message', $message);
}

function saveMessage($message) {
	mysql_connect('localhost', 'root', 'root');
	mysql_set_charset('utf-8');
	mysql_select_db('talk');
	mysql_query('INSERT INTO messages(message, date) VALUES ("'. $message .'", NOW())');
	return mysql_error();
}

function sendMessage($message) {
	mysql_connect('localhost', 'root', 'root');
	mysql_set_charset('utf-8');
	mysql_select_db('talk');
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