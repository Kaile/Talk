<?php
/* @var $this yii\web\View */
/* @var $user app\models\Users */
$this->title = Yii::t('app', 'The Talk');
?>
<div class="site-index">

    <div ng-controller="ReceiveTextCtrl">
        <div  class="text-placeholder" id="outputText"></div>
    </div>


    <div class="body-content" style="margin: auto;">

        <div class="row" ng-controller="SendTextCtrl">
            <div id="list">
				<?php
				echo yii\helpers\Html::dropDownList(
					'users-list', 
					'', 
					$items,
					[
						'id' => 'users-list',
					]
					);
				?>
			</div>
            <textarea class="text-placeholder"
				ng-model="inputText"
				ng-change="storeText()"
			></textarea>

        </div>

    </div>
</div>
