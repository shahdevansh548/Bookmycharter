<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Appointments;

/**
 * AppointmentsSearch represents the model behind the search form of `app\models\Appointments`.
 */
class AppointmentsSearch extends Appointments
{
    public $date_filter; // virtual attribute for filter

    public function rules()
    {
        return [
            [['id', 'login_id', 'doctor_id', 'amount'], 'integer'],
            [['start', 'end', 'created_at', 'created_by', 'updated_at', 'updated_by', 'date_filter'], 'safe'],
        ];
    }

    public function search($params, $formName = null)
    {
        $query = Appointments::find();
        if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 2){
            $query = $query->where(['doctor_id' => Yii::$app->user->identity->id]);
        }else if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 3){
            $query = $query->where(['login_id' => Yii::$app->user->identity->id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'login_id' => $this->login_id,
            'doctor_id' => $this->doctor_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'created_by', $this->created_by])
              ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        // Date filter logic
        $today = date('Y-m-d');

        switch ($this->date_filter) {
            case 'past':
                $query->andWhere(['<', 'DATE(start)', $today]);
                break;
            case 'future':
                $query->andWhere(['>', 'DATE(start)', $today]);
                break;
            case 'today':
            default:
                $query->andWhere(['=', 'DATE(start)', $today]);
                break;
        }

        return $dataProvider;
    }
}