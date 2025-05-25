<?php

namespace app\controllers;
use yii;
use app\models\Appointments;
use app\models\Login;
use app\models\Doctor;
use app\models\AppointmentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * AppointmentsController implements the CRUD actions for Appointments model.
 */
class AppointmentsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Appointments models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AppointmentsSearch();
        $params = Yii::$app->request->queryParams;

        // Default to today if not set
        if (!isset($params['AppointmentsSearch']['date_filter'])) {
            $params['AppointmentsSearch']['date_filter'] = 'today';
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Appointments model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Appointments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $model = new Appointments();
        if(Yii::$app->user->identity->role == 3){
            $model->login_id = Yii::$app->user->identity->id;
            $doctor_ids = ArrayHelper::map(Login::find()->select(['id','name'])->where(['role' => 2])->all(),'id','name');
        }else{
            $model->doctor_id = Yii::$app->user->identity->id;
            $doctor_ids = ArrayHelper::map(Login::find()->select(['id','name'])->where(['role' => 3])->all(),'id','name');
        }
        $model->created_by = Yii::$app->user->identity->name;
        $model->updated_by = Yii::$app->user->identity->name;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Convert string time to timestamps for comparison
            $start = strtotime($model->start);
            $end = strtotime($model->end);
            $duration = ($end - $start) / 60;

            if ($duration <= 0 || $duration % 10 !== 0) {
                $model->addError('start', 'Time must be in multiples of 10 minutes and valid.');
            } else {
                $doctor = Doctor::findOne($model->doctor_id);
                $startTime = strtotime(date('Y-m-d') . ' ' . $doctor->working_hours_from);
                $endTime = strtotime(date('Y-m-d') . ' ' . $doctor->working_hours_to);

                // Determine rate
                $isWorkingHours = ($start >= $startTime && $end <= $endTime);
                $ratePer10Min = $isWorkingHours ? 100 : 300;
                $model->amount = ($duration / 10) * $ratePer10Min;

                // Check for overlap
                $conflict = Appointments::find()
                    ->where(['doctor_id' => $model->doctor_id])
                    ->andWhere(['<', 'start', $model->end])
                    ->andWhere(['>', 'end', $model->start])
                    ->exists();

                if ($conflict) {
                    $model->addError('start', 'This time slot is already booked.');
                } else {
                    if ($model->save()) {
                        $this->generateEmailHtmlFile($model->id);
                        return $this->redirect(['index', 'id' => $model->id]);
                    }else{
                        print_r($model->getErrors());die;
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'doctor_ids' => $doctor_ids,
        ]);
    }

    public function actionCalculateAmount()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $start = Yii::$app->request->post('start');
        $end = Yii::$app->request->post('end');
        $doctorId = Yii::$app->request->post('doctor_id');
        if (!$start || !$end || !$doctorId) {
            return ['success' => false, 'message' => 'Invalid input'];
        }
        $startTs = strtotime($start);
        $endTs = strtotime($end);
        $duration = ($endTs - $startTs) / 60;

        if ($duration <= 0 || $duration % 10 !== 0) {
            return ['success' => false, 'message' => 'Duration must be in multiples of 10 minutes'];
        }

        $doctor = Doctor::findOne($doctorId);
        if (!$doctor) {
            return ['success' => false, 'message' => 'Doctor not found'];
        }

        $workStart = strtotime(date('Y-m-d', $startTs) . ' ' . $doctor->working_hours_from);
        $workEnd = strtotime(date('Y-m-d', $startTs) . ' ' . $doctor->working_hours_to);

        $isWorkingHours = ($startTs >= $workStart && $endTs <= $workEnd);
        $rate = $isWorkingHours ? 100 : 300;
        $amount = ($duration / 10) * $rate;

        return ['success' => true, 'amount' => $amount];
    }


    /**
     * Updates an existing Appointments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_by = Yii::$app->user->identity->name;
        $model->updated_at = date('Y-m-d H:i:s');
        if(Yii::$app->user->identity->role == 3){
            $doctor_ids = ArrayHelper::map(Login::find()->select(['id','name'])->where(['role' => 2])->all(),'id','name');
        }else{
            $doctor_ids = ArrayHelper::map(Login::find()->select(['id','name'])->where(['role' => 3])->all(),'id','name');
        }
        if ($this->request->isPost && $model->load($this->request->post())) {
            $start = strtotime($model->start);
            $end = strtotime($model->end);
            $duration = ($end - $start) / 60;

            if ($duration <= 0 || $duration % 10 !== 0) {
                $model->addError('start', 'Time must be valid and in multiples of 10 minutes.');
            } else {
                $doctor = Doctor::findOne($model->doctor_id);

                $date = date('Y-m-d', $start); // use correct date
                $workingStart = strtotime("$date {$doctor->working_hours_from}");
                $workingEnd   = strtotime("$date {$doctor->working_hours_to}");

                $isWorkingHours = ($start >= $workingStart && $end <= $workingEnd);
                $ratePer10Min = $isWorkingHours ? 100 : 300;
                $model->amount = ($duration / 10) * $ratePer10Min;

                // Check for overlapping appointments (excluding current one)
                $conflict = Appointments::find()
                    ->where(['doctor_id' => $model->doctor_id])
                    ->andWhere(['<', 'start', $model->end])
                    ->andWhere(['>', 'end', $model->start])
                    ->andWhere(['<>', 'id', $model->id]) // <-- Exclude current record
                    ->exists();

                if ($conflict) {
                    $model->addError('start', 'This time slot is already booked for this doctor.');
                } else {
                    if ($model->save()) {
                        $this->generateEmailHtmlFile($model->id);
                        return $this->redirect(['index']);
                    } else {
                        Yii::error($model->getErrors(), 'appointments.update');
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'doctor_ids' => $doctor_ids,
        ]);
    }


    /**
     * Deletes an existing Appointments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Appointments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Appointments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Appointments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function generateEmailHtmlFile($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->user->identity->role == 2){
            $data['name'] = Login::find()->where(['id' => $model->login_id])->one()->name;
            $data['doc_name'] = Yii::$app->user->identity->name;
        }else{
            $data['name'] = Yii::$app->user->identity->name;
            $data['doc_name'] = Login::find()->where(['id' => $model->doctor_id])->one()->name;
        }
        $data['start'] = $model->start;
        $data['end'] = $model->end;
        $data['amount'] = $model->amount;
        // Render the email HTML content
        $html = \Yii::$app->controller->renderPartial('_email', [
            'data' => $data,
        ]);

        // Ensure directory exists
        $emailDir = \Yii::getAlias('@webroot/emails');
        if (!is_dir($emailDir)) {
            mkdir($emailDir, 0755, true);
        }

        // Save file
        $filename = $emailDir . '/appointment_' . $model->id . '.html';
        file_put_contents($filename, $html);

        return $filename;
    }

}
