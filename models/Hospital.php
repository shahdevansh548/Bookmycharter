<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hospital".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $phone
 * @property string $created_at
 * @property string $updated_at
 */
class Hospital extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hospital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'created_at', 'updated_at'], 'required'],
            [['phone'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
