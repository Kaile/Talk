<?php
/**
 * Created by PhpStorm.
 * User: Mihail Kornilov
 * Date: 16.11.2014
 * Time: 0:46
 */

use Yii\helpers\Html;
use yii\helpers\Url;

?>

<?php /* @var $this yii\web\view */ ?>
<?php /* @var $registration app\models\RegistrationModel */ ?>


<div id="register-module">
	<span class="header"><?=Yii::t('app', 'Registration')?></span>

	<?php $form = \yii\bootstrap\ActiveForm::begin(['action' => Url::to(['site/register'])]); ?>

	<?= $form->field($registration, 'login')->textInput(); ?>

	<?= $form->field($registration, 'password')->passwordInput(); ?>

	<?= $form->field($registration, 'password2')->passwordInput(); ?>

	<?= $form->field($registration, 'email')->textInput(); ?>

	<?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary']); ?>

	<?php \yii\bootstrap\ActiveForm::end() ?>
</div>
