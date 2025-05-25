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
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    // Define the navigation items
    $items = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if(isset(Yii::$app->user->identity->id)){
        if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 1){
            $items = [
                ['label' => 'View Doctor', 'url' => ['/doctor/index']],
                ['label' => 'Appointment', 'url' => ['/appointments/index']],
                ['label' => 'Users', 'url' => ['/user/index']],
                ['label' => 'Hospital', 'url' => ['/hospital/index']],
            ];      
        }else if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 2){
            $items = [
                ['label' => 'View Doctor', 'url' => ['/doctor/index']],
                ['label' => 'Appointment', 'url' => ['/appointments/index']],
            ];
        }else if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 3){
            $items = [
                ['label' => 'Appointment', 'url' => ['/appointments/index']],
            ];
        }
    }else{
        $items = [
                ['label' => 'Register', 'url' => ['/user/register']],
            ];
    }
    // Add Login or Logout based on user status
    if (Yii::$app->user->isGuest) {
        $items[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $items[] = '<li class="nav-item">'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->name . ')',
            ['class' => 'nav-link btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
    }

    // Render the nav
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $items,
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

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Devansh Shah <?= date('Y') ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
