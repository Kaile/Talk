<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app>
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::t('app', 'The Talk'),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top title-font',
                ],
            ]);
			
			// Формирование списка элементов навигационной панели 
			$items = [];
			$items[] = ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']];
			if (Yii::$app->user->isGuest) {
				// Опции доступные гостю
				$items[] = ['label' => Yii::t('app', 'Log In'), 'url' => ['/site/login']];
			} else {
				// Опции доступные авторизованному пользователю
				$items[] = ['label' => Yii::t('app', 'Log Out ({login})', ['login' => Yii::$app->user->identity->login]),
						 'url' => ['/site/logout'],
						 'linkOptions' => ['data-method' => 'post']];
				// Опции доступные администравтору
				if (Yii::$app->user->identity->login === 'admin') {
					$items[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/users/index']];
					$items[] = ['label' => Yii::t('app', 'User Infos'), 'url' => ['/user-info/index']];
				}
			} 
			
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => $items,
			]);
			NavBar::end();
        ?>

        <div class="container content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
