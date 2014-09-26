<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div ng-controller="ReceiveTextCtrl">
        <div  class="text-placeholder" id="outputText"></div>
    </div>


    <div class="body-content" style="margin: auto;">

        <div class="row" ng-controller="SendTextCtrl">
            <textarea class="text-placeholder"
				ng-model="inputText"
				ng-change="storeText()"
			></textarea>

        </div>

    </div>
</div>
