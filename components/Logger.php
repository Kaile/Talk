<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use \SplObserver;
use \SplSubject;

/**
 * Description of Logger
 * @created 02.10.2014 11:53:16
 * @author Mihail Kornilov <fix-06 at yandex.ru>
 */
class Logger implements SplObserver
{

	public function __construct(SplSubject $subject)
	{
		$subject->attach($this);
	}

	public function update(SplSubject $subject)
	{
		echo $subject->getStatus();
	}
}
