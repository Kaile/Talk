<div class="message">
    <span class="<?=(isset($userName)) ? 'user-name' : 'sender-name'?>">
        <?=(isset($userName)) ? $userName : Yii::$app->user->identity->login?>
    </span>
    <span class="time">
        (<?=date('h:i:s')?>):
    </span>
    <span class="text-of-message">
        <?=$message?>
    </span>
</div>
