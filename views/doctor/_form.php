<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Doctor $model */
/** @var yii\widgets\ActiveForm $form */
$days = [
    '1' => 'Monday',
    '2' => 'Tuesday',
    '3' => 'Wednesday',
    '4' => 'Thursday',
    '5' => 'Friday',
    '6' => 'Saturday',
    '7' => 'Sunday',
];
?>

<div class="doctor-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($loginmodel, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($loginmodel, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($loginmodel, 'phone')->textInput() ?>

    <?= $form->field($loginmodel, 'username')->textInput() ?>

    <?= $form->field($loginmodel, 'password')->textInput() ?>

    <?= $form->field($model, 'hospital_ids')->dropDownList($hospital_ids,['multiple' => false,'class' => 'form-control','prompt' => 'Select Hospital(s)',]); ?>

    <?= $form->field($model, 'working_days')->checkboxList($days, [
        'itemOptions' => ['class' => 'form-check-input'],
    ]) ?>

    <?= $form->field($model, 'working_hours_from')->input('time') ?>

    <?= $form->field($model, 'working_hours_to')->input('time') ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
