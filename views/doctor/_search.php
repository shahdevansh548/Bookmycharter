<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DoctorSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="doctor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'login_id') ?>

    <?= $form->field($model, 'hospital_ids') ?>

    <?= $form->field($model, 'working_days') ?>

    <?= $form->field($model, 'working_hours') ?>

    <?php // echo $form->field($model, 'holiday_to') ?>

    <?php // echo $form->field($model, 'holiday_from') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
