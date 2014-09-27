
/**
 * 
 * @param {jQuery} selector - селектор области куда выводится текст
 * @param {String} text - выводимый текст
 * @param {int} intervalLoad - интервал загрузки данных с сервера
 * @param {int} freq - частота посимвольного появления текста
 */
function softOutput(selector, text, intervalLoad, freq) {
	var intervalLoad = Number(intervalLoad) || 300;
    var freq   = Number(freq) || 50;
	var textPortion = intervalLoad / freq;
	var amount = (text.length > textPortion) ? text.length / textPortion : 1;

	var intervalId = setInterval(function() {
		if (text.length > 1) {
			$(selector).text($(selector).text() + text.substr(0, amount));
			text = text.substr(amount);
		} else {
			$(selector).text($(selector).text() + text);
			clearInterval(intervalId);
		}
	}, freq);
}