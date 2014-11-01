<?php
/* @var $this yii\web\View */
/* @var $user app\models\Users */
$this->title = Yii::t('app', 'The Talk');
?>
<div class="site-index">
    <div class="body-content">
		<div class="chat-window">
			<div ng-controller="ReceiveTextCtrl">
				<div class="text-output" id="outputText"></div>
				<div class="message-window"></div>
			</div>

			<div class="row" ng-controller="SendTextCtrl">
				<textarea
					autofocus="true"
					class="text-input"
					ng-model="inputText"
					ng-change="storeText()"
				></textarea>

			</div>
		</div>
		<div class="contact-list">
			<div id="contact-title">
				<?=Yii::t('app', 'Contact list')?>
			</div>
			<?php foreach ($users as $user): ?>
				<?php $user = (object) $user; ?>
				<div contact_id="<?=$user->id?>" class="contact">
					<span class="contact-login" title="<?=$user->registered?>" >
						<?=$user->login?>
					</span>
				</div>
			<?php endforeach ?>
		</div>
    </div>


</div>
