<!DOCTYPE html>
<html lang="ru_RU">
	<head>
		<meta charset="utf-8"/>
		
		<title>The Talk</title>
		
		<script src="jquery.min.js"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<h1>Talk</h1>
		<div>
			<hr />
		</div>
		<div>
			<input name="source" id="input-field" type="text" /> 
		</div>
		<div style="width: 222px; overflow: auto;" id="output-field">
		</div>
		<input type="button" value="Фиксировать" id="send-button" />
		<p id="error"></p>
	</body>
</html>