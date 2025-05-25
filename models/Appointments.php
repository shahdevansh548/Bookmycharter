<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appointments".
 *
 * @property int $id
 * @property int $login_id
 * @property int $doctor_id
 * @property string $start
 * @property string $end
 * @property int $amount
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Appointments extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login_id', 'doctor_id', 'start', 'end', 'amount', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['login_id', 'doctor_id', 'amount'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login_id' => 'Login ID',
            'doctor_id' => 'Doctor ID',
            'start' => 'Start',
            'end' => 'End',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['id' => 'doctor_id']);
    }
    
    public function getLogin()
    {
        return $this->hasOne(Login::class, ['id' => 'login_id']); // Adjust class name if it's User or Auth
    }


}
