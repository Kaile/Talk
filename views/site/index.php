<?php
/**
 * Created by PhpStorm.
 * User: Mihail Kornilov
 * Date: 16.11.2014
 * Time: 0:16
 */

/* @var $this Yii\web\View */

$this->title = 'Welcome to the Talk';
?>

<div class="site-index center-center">
	<h1 class="shadow"><?=Yii::t('app', 'Welcome to the Talk messenger')?></h1>
	<?=$this->render('register', ['registration' => $registration]);?>
</div>