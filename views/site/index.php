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
			<div id="contact-title" class="title-font">
				<?=Yii::t('app', 'Contact list')?>
			</div>
			<?php foreach ($items as $id => $ulogin): ?>
				<div class="contact">
					<span contact_id="<?=$id?>" style="display: none"></span>
					<span class="contact-login">
						<?=$ulogin?>
					</span>
				</div>
			<?php endforeach ?>
		</div>
    </div>


</div>
