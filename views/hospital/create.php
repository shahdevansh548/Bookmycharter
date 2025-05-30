<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Hospital $model */

$this->title = 'Create Hospital';
$this->params['breadcrumbs'][] = ['label' => 'Hospitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hospital-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
