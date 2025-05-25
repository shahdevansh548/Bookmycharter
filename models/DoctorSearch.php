<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Doctor;

/**
 * DoctorSearch represents the model behind the search form of `app\models\Doctor`.
 */
class DoctorSearch extends Doctor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'login_id', 'working_hours'], 'integer'],
            [['hospital_ids', 'working_days', 'holiday_to', 'holiday_from', 'created_at', 'updated_at', 'name', 'email'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Doctor::find();
        if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 2){
            $query = $query->where(['login_id' => Yii::$app->user->identity->id]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['login']);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'login_id' => $this->login_id,
            'working_hours' => $this->working_hours,
            'holiday_to' => $this->holiday_to,
            'holiday_from' => $this->holiday_from,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'hospital_ids', $this->hospital_ids])
            ->andFilterWhere(['like', 'working_days', $this->working_days]);

        return $dataProvider;
    }
}
