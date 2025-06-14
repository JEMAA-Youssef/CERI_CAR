 <?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);



$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php
$this->registerJsFile('@web/js/site.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <div id="notification" class="alert alert-info text-center" style="display: none;"></div>
    
    <header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => "CERI CAR",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Internaute', 'url' => ['/site/internaute']],
            ['label' => 'Recherche Voyage', 'url' => ['/site/recherchevoyage']],
            Yii::$app->user->isGuest || (Yii::$app->user->identity && empty(Yii::$app->user->identity->permis))
                ? ['label' => 'Proposition', 'url' => '#', 'linkOptions' => ['class' => 'disabled', 'aria-disabled' => 'true']]
                : ['label' => 'Proposition', 'url' => ['/site/proposevoyage']],
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::a(
                    'Logout (' . Yii::$app->user->identity->pseudo . ')',
                    '#',
                    ['class' => 'nav-link logout-button']
                )
                . '</li>',
        ],
    ]);
    
    
    
    
    NavBar::end();

    ?>
</header>



    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>


    <div id="notification" class="alert alert-info text-center" 
    style="display: none; position: fixed; top: 0; left: 50%; transform: translateX(-50%); z-index: 1000; width: 50%;">
    </div>

    
    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>
                
    <?php $this->endBody() ?>
</body> 

</html>
<?php $this->endPage() ?>