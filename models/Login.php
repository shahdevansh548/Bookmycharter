<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Login extends ActiveRecord implements IdentityInterface
{
    public $rememberMe;

    private $_user = false;

    public static function tableName()
    {
        return 'login';
    }

    public function rules()
    {
        return [
            [['phone', 'role'], 'integer'],
            [['created_at', 'update_at'], 'safe'],
            [['name', 'email', 'username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['rememberMe'], 'boolean'],
            [['email', 'username'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'username' => 'Username',
            'phone' => 'Phone',
            'password' => 'Password',
            'role' => 'Role',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user && $user->validatePassword($this->password)) {
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }else{
            print_r($this->getErrors());die;
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = self::findOne(['username' => $this->username]);
        }
        return $this->_user;
    }

    // IdentityInterface methods

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null; // Not using auth key
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }
}
