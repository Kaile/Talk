<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content" style="margin: auto;">

        <div class="row" ng-controller="SendTextCtrl" style="margin: auto;">
            <textarea class="text-placeholder"
				ng-model="inputText"
				ng-change="storeText()"
			>
					
			</textarea>
			<textarea ng-model="outputText" class="text-placeholder" style="float: right;"></textarea>
        </div>

    </div>
</div>
