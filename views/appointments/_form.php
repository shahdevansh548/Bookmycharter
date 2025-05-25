<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Appointments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(Yii::$app->user->identity->role == 3){
        echo $form->field($model, 'doctor_id')->dropDownList($doctor_ids, ['prompt' => 'Select Doctor', 'id' => 'doctor-id']);
    }else{
        $form->field($model, 'end')->input('datetime-local', ['id' => 'doctor-id']);
        echo $form->field($model, 'login_id')->dropDownList($doctor_ids, ['prompt' => 'Select User', 'id' => 'user-id']);
    } ?>

    <?= $form->field($model, 'start')->input('datetime-local', ['id' => 'start-time']) ?>

    <?= $form->field($model, 'end')->input('datetime-local', ['id' => 'end-time']) ?>

    <?= $form->field($model, 'amount')->textInput(['readonly' => true, 'id' => 'amount']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$calculateUrl = Url::to(['appointments/calculate-amount']);

$js = <<<JS
function calculateAmount() {
    const start = new Date($('#start-time').val());
    const end = new Date($('#end-time').val());
    const doctorId = $('#doctor-id').val();

    if (start && end && doctorId && !isNaN(start) && !isNaN(end)) {
        const duration = (end - start) / (1000 * 60); // duration in minutes

        if (duration <= 0 || duration % 10 !== 0) {
            $('#amount').val('');
            $('#submit-btn').prop('disabled', true);
            alert('Duration must be in multiples of 10 minutes.');
            return;
        } else {
            $('#submit-btn').prop('disabled', false);
        }

        $.post('$calculateUrl', {
            start: $('#start-time').val(),
            end: $('#end-time').val(),
            doctor_id: doctorId
        }, function(response) {
            if (response.success) {
                $('#amount').val(response.amount);
            } else {
                $('#amount').val('');
                alert(response.message);
            }
        });
    }
}

$('#start-time, #end-time, #doctor-id').on('change', calculateAmount);
JS;

$this->registerJs($js);
?>
