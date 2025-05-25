<?php

namespace app\controllers;
use yii;
use app\models\Doctor;
use app\models\Login;
use app\models\Hospital;
use yii\helpers\ArrayHelper;
use app\models\DoctorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DoctorController implements the CRUD actions for Doctor model.
 */
class DoctorController extends Controller
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
     * Lists all Doctor models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DoctorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Doctor model.
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
     * Creates a new Doctor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Doctor();
        $loginmodel = new Login();
        $hospital_ids = ArrayHelper::map(Hospital::find()->select(['id','name'])->orderBy('name')->asArray()->all(),'id','name');
        if ($this->request->isPost) {
           if ($model->load(Yii::$app->request->post()) && $loginmodel->load(Yii::$app->request->post())) {

            // Set additional values for login model
            $loginmodel->role = 2;
            $loginmodel->created_at = date('Y-m-d H:i:s');
            $loginmodel->update_at = date('Y-m-d H:i:s');

            if ($loginmodel->save()) {

                // Link login to main model
                $model->login_id = $loginmodel->id;

                // Convert hospital IDs to comma-separated string if it's an array
                if (is_array($model->hospital_ids)) {
                    $model->hospital_ids = implode(",", $model->hospital_ids);
                }

                if (is_array($model->working_days)) {
                    $model->working_days = implode(",", $model->working_days);
                }

                // Combine working hours
                $model->working_hours = $model->working_hours_from . ' ' . $model->working_hours_to;
                if ($model->save()) {
                    return $this->redirect(['index']);
                } else {
                    echo "<pre>"; print_r($model->getErrors()); die;
                }

            } else {
                echo "<pre>"; print_r($loginmodel->getErrors()); die;
            }
        }

        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'loginmodel' => $loginmodel,
            'hospital_ids' => $hospital_ids
        ]);
    }

    /**
     * Updates an existing Doctor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Doctor model.
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
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Doctor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doctor::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
