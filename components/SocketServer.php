<?php

namespace app\components;

/**
 * Класс для организации работы с сокетами в удобной форме
 * @created 01.10.2014 17:25:31
 * @author Mihail Kornilov <fix-06 at yandex.ru>
 */
abstract class SocketServer implements \SplSubject
{
	
	const HANDSHAKE = 
<<<HANDSHAKE
	HTTP/1.1 101 WebSocket Protocol Handshake\n
	Date: Fri, 10 Feb 2012 17:38:18 GMT\n
	Connection: Upgrade\n
	Server: Kaazing Gateway\n
	Upgrade: WebSocket\n
	Access-Control-Allow-Origin: http://websocket.org\n
	Access-Control-Allow-Credentials: true\n
	Sec-WebSocket-Accept: rLHCkw/SKsO9GAH/ZSFhBATDKrU=\n
	Access-Control-Allow-Headers: content-type
HANDSHAKE;
	/**
	 * Объект для хранения объектов наблюдателей для регистрации событий
	 * @var \SplObjectStorage
	 */
	private $_storage;

	/**
	 * Дескриптор сокет соединения
	 * @var int
	 */
	private $_socket = false;

	/**
	 * Реализация интерфейса для работы с передаваемыми сообщениями
	 * @var Protocol
	 */
	private $_protocol;
	
	/**
	 *
	 * @var int
	 */
	private $_msgsock;

	/**
	 * Статус сервера на момент проверки
	 * @var string
	 */
	private $_status = '';

	/**
	 * Адрес для прослушивания сокета
	 * @var string 
	 */
	public $bindAddress = 'localhost:8089';

	/**
	 * Возвращает строковое описание ошибки
	 * @return string
	 */
	private function getErrorString($sock = null) 
	{
		return socket_strerror(socket_last_error($sock));
	}

	/**
	 * Создание сокета
	 * @return \app\components\WebSocket
	 * @throws SocketServerException
	 */
	protected function create() 
	{
		$this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		
		if ($this->_socket === false) {
			throw new SocketServerException('Error when socket created: ' . $this->getErrorString());
		}
		
		$this->changeStatus("Socket has been created: {$this->_socket}" . PHP_EOL);
		
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
		$this->changeStatus("Set server socket option: level = $level, optname = $optname, optval = $optval" . PHP_EOL);
		return socket_set_option($this->_socket, $level, $optname, $optval);
	}
	
	/**
	 * Смена статуса и оповещение всех наблюдателей
	 * @param string $msg
	 */
	protected function changeStatus($msg)
	{
		$this->_status = $msg;
		$this->notify();
	}

	/**
	 * Конструктор
	 * @param type $bindAddress
	 */
	public function __construct(Protocol $protocol, $bindAddress = null)
	{
		$this->_protocol = $protocol;
		$this->_storage = new \SplObjectStorage();
		if ( ! empty($bindAddress) ) {
			$this->bindAddress = $bindAddress;
		}
	}
	
	/**
	 * Деструктор, очищает ошибки сокета и закрывает соединение
	 */
	public function __destruct()
	{
		if ($this->_socket !== false) {
			socket_clear_error($this->_socket);
			socket_shutdown($this->_socket);
			socket_close($this->_socket);
		}
		$this->changeStatus("Close socket ... " . PHP_EOL);
	}
	
	public function getProtocol()
	{
		return $this->_protocol;
	}

	public function getMsgsock()
	{
		return $this->_msgsock;
	}

	public function setMsgsock($_msgsock)
	{
		$this->_msgsock = $_msgsock;
	}

	public function getStatus()
	{
		return $this->_status;
	}
	
	/**
	 * Привязка сокета к адресу на котором ведется прослуживание
	 * @param string $bindAddress
	 * @return \app\components\WebSocket
	 * @throws SocketServerException
	 */
	public function bind()
	{
		$addrArr = explode(':', $this->bindAddress);
		
		if ( socket_bind($this->_socket, $addrArr[0], $addrArr[1]) === false ) {
			throw new SocketServerException('Error when socket bind to address ' . $this->bindAddress . ': ' . $this->getErrorString());
		}
		
		$this->changeStatus("Bind to address {$this->bindAddress}" . PHP_EOL);
		
		// Разрешаем использовать один порт для нескольких соединений
		$this->setOption(SOL_SOCKET, SO_REUSEADDR, 1);
		
		return $this;
	}
	
	
	/**
	 * Прослушка сокета
	 * @return \app\components\WebSocket
	 * @throws SocketServerException
	 */
	public function listen()
	{
		if ( socket_listen($this->_socket) === false ) {
			throw new SocketServerException('Error when socket listen connection: ' . $this->getErrorString());
		}
		
		$this->changeStatus("Listen socket ... " . PHP_EOL);
		
		return $this;
	}
	
	/**
	 * Подключение клиента
	 * @return int
	 * @throws SocketServerException
	 */
	public function accept() 
	{
		if ( ($msgsock = socket_accept($this->_socket) === false) ) {
			throw new SocketServerException('Error when socket accept: ' . $this->getErrorString());
		}
		
		$this->changeStatus("Accept socket : {$msgsock}" . PHP_EOL);
		
		$this->setMsgsock($msgsock);
		$this->read();
		$this->write(self::HANDSHAKE);
		
		return $this;
	}

	/**
	 * Читает данные из сокета
	 * @param int $msgsocket
	 * @return string
	 * @throws SocketServerException
	 */
	public function read()
	{
		do {
			if ( false === ($buf = socket_read($this->getMsgsock(), 2048)) ) {
				throw new SocketServerException('Error when socket read: ' . $this->getErrorString($this->getMsgsock()));
			}
		} while('' === trim($buf));
		
		$this->changeStatus("Read from socket : $buf" . PHP_EOL);
		
		return $buf;
	}
	
	/**
	 * Запись данных в сокет
	 * @param int $msgsock
	 * @param string $data
	 * @return \app\components\SocketServer
	 * @throws SocketServerException
	 */
	public function write($data) 
	{
		if (false === socket_write($this->getMsgsock(), $data, strlen($data))) {
			throw new SocketServerException('Error when socket write: ' . $this->getErrorString($this->getMsgsock()));
		}
		
		$this->changeStatus("Write to socket : $data" . PHP_EOL);
		
		return $this;
	}

	/**
	 * Запуск сервера сокета
	 */
	public function start()
	{
		$this->changeStatus(" ... Begining start server ..." . PHP_EOL);
		
		$this->create();
		$this->bind();
		$this->listen();
		
		$this->changeStatus(" ... Server is starts ..." . PHP_EOL);	
		$this->accept();
		
		do {
			$data = $this->read();
			
			$this->getProtocol()->load($data);
			
			$this->run();
			
		} while ($this->getProtocol()->getCommand() !== Protocol::COMM_STOP);
	}
	
	/**
	 * Для работы с данными полученными от клиента надо реализовать эту функцию
	 */
	public abstract function run();

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
class SocketServerException extends \Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
	}
}