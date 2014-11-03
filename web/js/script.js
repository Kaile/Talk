var DEBUG_DEV = 'develop';
var DEBUG_PROD = 'production';

var DEBUG_LEVEL = DEBUG_DEV;

function logInfo(text) {
    if (DEBUG_LEVEL === DEBUG_DEV) {
        console.info(text);
    }
}

function logError(text) {
    if (DEBUG_LEVEL === DEBUG_PROD) {
        console.error(text);
    }
}

function urlHelper(action, ctrl) {
    var ctrl = ctrl || 'site';
    var prefix = '?r=';

    return prefix + ctrl + '/' + action;
}
/**
 * 
 * @param {jQuery} selector - селектор области куда выводится текст
 * @param {String} text - выводимый текст
 * @param {Number} intervalLoad - интервал загрузки данных с сервера
 * @param {Number} freq - частота посимвольного появления текста
 */
function softOutput(selector, text, intervalLoad, freq) {
	var intervalLoad = Number(intervalLoad) || 300;
    var freq   = Number(freq) || 50;
	
	/**
	 * Переменная определяющая количество символов, которые успеют появиться
	 * до начала следующей загрузки текста с сервера
	 * @type Number
	 */
	var textPortion = intervalLoad / freq;
	
	/**
	 * Переменная определяющая количество символов, одновременно выводящихся 
	 * на экран при плавном появлении
	 * @type Number
	 */
	var amount = (text.length > textPortion) ? text.length / textPortion : 1;

	var intervalId = setInterval(function() {
		if (text.length > 1) {
			selector.text(selector.text() + text.substr(0, amount));
			text = text.substr(amount);
		} else {
			selector.text(selector.text() + text);
			clearInterval(intervalId);
		}
	}, freq);
}

/**
 * Функция выполняет добавление данных пользователей в место выбранное через селектор
 * @param selector - jQuery селектор для вставки внутрь данных
 */
function loadUsersList(selector) {
    get(urlHelper('get-users-list'))
        .done(function(users) {
            users = JSON.parse(users);
            //TODO: Здесь надо сделать создание выпадающего списка и вставку по селектору
            var dropList = new DropList('users');

            users.forEach(function(data) {
                dropList.addElement(data.id, data.login);
            });

            selector.html(dropList.getContent());
        })
        .fail(function() {
           console.log('Can\'t load users data');
        });
}

/**
 * Функция возвращает объект с информацией о выделенных контактах в контакт-листе
 * @param {String} сLSelector - селектор для контакт-листа
 * @return {Object} - информация о выделенных контактах
 */
function getContacts() {
    var cl = $('.contact-list');

    if (typeof cl === 'undefined') {
        throw new Error('Contact list selector is not found');
    }

    var contacts = cl.children('.contact-selected');
    var res = [];
    var len = contacts.length;

    for (var i = 0; i < len; ++i) {
        res.push(contacts.attr('contact_id'));
        contacts = contacts.next();
    }

    return res;
}