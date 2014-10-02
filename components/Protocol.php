<?php
namespace app\components;

/**
 *
 * @author Mihail Kornilov <fix-06 at yandex.ru>
 */
interface Protocol
{
	const COMM_STOP   = 'stop';

	public function load($data);
	
	public function pack($msg = '');

	public function getVersion();
	
	public function getCommand();
	
	public function getText();
	
	public function getSender();
	
	public function getReceiver();
}
