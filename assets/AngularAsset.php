<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Description of AngularAsset
 *
 * @created 16.09.2014 22:23:51
 * @author Mihail Kornilov <fix-06 at yandex.ru>
 */
class AngularAsset extends AssetBundle
{
	public $sourcePath = '@vendor/components/angular.js';
	
	public $js = [
		'angular.min.js',
	];

}
