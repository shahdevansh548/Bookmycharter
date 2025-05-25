<?php

use app\models\Doctor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DoctorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Doctors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 1){ ?>
        <p>
            <?= Html::a('Create Doctor', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Name',
                'attribute' => 'login.name',
                'value' => function($model) {
                    return $model->login->name ?? null;
                }
            ],
            [
                'label' => 'Email',
                'attribute' => 'login.email',
                'value' => function($model) {
                    return $model->login->email ?? null;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Doctor $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                    'delete' => function () {
                        return Yii::$app->user->identity->role == 1;
                    },
                ],
            ],

        ],
    ]); ?>

</div>
