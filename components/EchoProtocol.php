<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

/**
 * Description of EchoProtocol
 * @created 02.10.2014 11:31:23
 * @author Mihail Kornilov <fix-06 at yandex.ru>
 */
class EchoProtocol implements Protocol
{
	
	const COMM_RUN = 'run';
	
	private  $_data;
	
	function getData()
	{
		return $this->_data;
	}

	function setData($data)
	{
		$this->_data = $data;
	}

		
	public function getCommand()
	{
		return self::COMM_RUN;
	}

	public function getReceiver()
	{
		
	}

	public function getSender()
	{
		
	}

	public function getText()
	{
		return $this->getData();
	}

	public function getVersion()
	{
		
	}

	public function load($data)
	{
		$this->setData($data);
	}

	public function pack($msg = '')
	{
		
	}

}
