<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

/**
 * Description of EchoSocketServer
 * @created 02.10.2014 11:21:01
 * @author Mihail Kornilov <fix-06 at yandex.ru>
 */
class EchoSocketServer extends SocketServer
{

	public function __construct($bindAddress = null)
	{
		parent::__construct(new EchoProtocol(), $bindAddress);
	}

	public function run()
	{
		$this->write($this->getProtocol()->getText());
	}
}
