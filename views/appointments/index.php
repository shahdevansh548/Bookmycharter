<?php
use app\models\Appointments;
use app\models\Doctor;
use app\models\Login;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap5\ButtonGroup;

/** @var yii\web\View $this */
/** @var app\models\AppointmentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Appointments';
$this->params['breadcrumbs'][] = $this->title;
$currentFilter = Yii::$app->request->get('AppointmentsSearch')['date_filter'] ?? 'today';
// Fetch dropdown filter data
$userList = ArrayHelper::map(Login::find()->all(), 'id', 'username'); // or 'email'
$doctorList = ArrayHelper::map(Doctor::find()->all(), 'id', 'name');  // assumes 'name' field exists
?>

<div class="appointments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(Yii::$app->user->identity->role != 1){ ?>
        <div class="mb-3">
            <?= Html::a('Create Appointment', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?>

    <div class="mb-4">
        <?= ButtonGroup::widget([
            'options' => ['class' => 'btn-group'],
            'buttons' => [
                Html::a('Today', ['index', 'AppointmentsSearch[date_filter]' => 'today'], [
                    'class' => 'btn btn-outline-primary' . ($currentFilter === 'today' ? ' active' : '')
                ]),
                Html::a('Past', ['index', 'AppointmentsSearch[date_filter]' => 'past'], [
                    'class' => 'btn btn-outline-secondary' . ($currentFilter === 'past' ? ' active' : '')
                ]),
                Html::a('Future', ['index', 'AppointmentsSearch[date_filter]' => 'future'], [
                    'class' => 'btn btn-outline-secondary' . ($currentFilter === 'future' ? ' active' : '')
                ]),
            ]
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',

            // Show user (from login_id)
            [
                'attribute' => 'login_id',
                'label' => 'User',
                'value' => function ($model) {
                    return $model->login->username ? $model->login->username : 'N/A'; // or ->email
                },
                'filter' => $userList,
            ],
            [
                'attribute' => 'login_id',
                'label' => 'Email',
                'value' => function ($model) {
                    return $model->login->email ? $model->login->email : 'N/A'; // or ->email
                },
                'filter' => $userList,
            ],
            [
                'attribute' => 'login_id',
                'label' => 'Number',
                'value' => function ($model) {
                    return $model->login->phone ? $model->login->phone : 'N/A'; // or ->email
                },
                'filter' => $userList,
            ],
            'start',
            'end',
            'amount',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Appointments $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                    'update' => function () {
                        return Yii::$app->user->identity->role != 1;
                    },
                    'delete' => function () {
                        return Yii::$app->user->identity->role != 1;
                    },
                ],
            ],

        ],
    ]); ?>
</div>
