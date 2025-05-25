<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property int|null $login_id
 * @property string|null $hospital_ids
 * @property string|null $working_days
 * @property int|null $working_hours
 * @property string|null $holiday_to
 * @property string|null $holiday_from
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Doctor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public $working_hours_from;
    public $working_hours_to;
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login_id', 'holiday_to', 'holiday_from', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['login_id', 'hospital_ids'], 'integer'],
            [['holiday_to', 'holiday_from', 'created_at', 'updated_at','working_hours_to','working_hours_from','working_days', 'working_hours',], 'safe'],
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
            'hospital_ids' => 'Hospital Ids',
            'working_days' => 'Working Days',
            'working_hours' => 'Working Hours',
            'holiday_to' => 'Holiday To',
            'holiday_from' => 'Holiday From',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getLogin()
    {
        return $this->hasOne(Login::class, ['id' => 'login_id']);
    }

}
