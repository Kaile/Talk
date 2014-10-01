<?php

namespace app\components;

/**
 * Класс для организации работы с сокетами в удобной форме
 * @created 01.10.2014 17:25:31
 * @author Mihail Kornilov <fix-06 at yandex.ru>
 */
abstract class WebSocket implements \SplSubject
{
	/**
	 * Объект для хранения объектов наблюдателей для регистрации событий
	 * @var \SplObjectStorage
	 */
	private $_storage;

	/**
	 * Дескриптор сокет соединения
	 * @var int
	 */
	private $_socket;
	
	/**
	 * Индикатор работы соединения
	 * @var bool
	 */
	private $_isStart = false;

	/**
	 * Адрес для прослушивания сокета
	 * @var string 
	 */
	public $bindAddress = 'localhost:8089';

	/**
	 * Возвращает строковое описание ошибки
	 * @return string
	 */
	private function getErrorString() 
	{
		return socket_strerror(socket_last_error($this->_socket));
	}

	/**
	 * Создание сокета
	 * @return \app\components\WebSocket
	 * @throws WebSocketException
	 */
	protected function create() 
	{
		$this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		
		if ($this->_socket === false) {
			throw new WebSocketException('Error when socket created: ' . $this->getErrorString());
		}
		
		return $this;
	}
	
	/**
	 * Установка параметров сокет соединения
	 * @param int $level
	 * @param int $optname
	 * @param int $optval
	 * @return bool - результат применения опции
	 */
	protected function setOption($level, $optname, $optval)
	{
		return socket_set_option($this->_socket, $level, $optname, $optval);
	}
	
	/**
	 * Конструктор
	 * @param type $bindAddress
	 */
	public function __construct($bindAddress = null)
	{
		$this->_storage = new \SplObjectStorage();
	}
	
	/**
	 * Деструктор, очищает ошибки сокета и закрывает соединение
	 */
	public function __destruct()
	{
		socket_clear_error($this->_socket);
		socket_shutdown($this->_socket);
		socket_close($this->_socket);
	}

	/**
	 * Привязка сокета к адресу на котором ведется прослуживание
	 * @param string $bindAddress
	 * @return \app\components\WebSocket
	 * @throws WebSocketException
	 */
	public function bind($bindAddress = null)
	{
		if ( ! empty($bindAddress) ) {
			$this->bindAddress = $bindAddress;
		}
		
		$addrArr = explode(':', $this->bindAddress);
		
		if ( ! socket_bind($this->_socket, $addrArr[0], $addrArr[1]) ) {
			throw new WebSocketException('Error when socket bind to address ' . $this->bindAddress . ': ' . $this->getErrorString());
		}
		
		// Разрешаем использовать один порт для нескольких соединений
		$this->setOption(SOL_SOCKET, SO_REUSEADDR, 1);
		
		return $this;
	}
	
	
	/**
	 * Прослушка сокета
	 * @return \app\components\WebSocket
	 * @throws WebSocketException
	 */
	public function listen()
	{
		if ( ! socket_listen($this->_socket) ) {
			throw new WebSocketException('Error when socket listen connection: ' . $this->getErrorString());
		}
		
		return $this;
	}
	
	
	public function start()
	{
		$this->_isStart = true;
		
		while ($this->_isStart) {
			socket_recvmsg($socket, $message);
		}
	}

	/**
	 * @inheritdoc
	 * @param \SplObserver $observer
	 */
	public function attach(\SplObserver $observer)
	{
		$this->_storage->attach($observer);
	}

	/**
	 * @inheritdoc
	 * @param \SplObserver $observer
	 */
	public function detach(\SplObserver $observer)
	{
		$this->_storage->detach($observer);
	}

	/**
	 * @inheritdoc
	 */
	public function notify()
	{
		/**
		 * @var \SplObserver $observer
		 */
		foreach ($this->_storage as $observer) {
			$observer->update($this);
		}
	}

}

/**
 * Класс исключения для работы с сокетом
 */
class WebSocketException extends \Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
	}
}