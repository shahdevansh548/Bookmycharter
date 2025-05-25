<?php
namespace app\models;

use Yii;
use yii\base\Model;

class PasswordResetForm extends Model
{
    public $username;
    public $new_password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['username', 'new_password', 'confirm_password'], 'required'],
            ['username', 'string', 'max' => 50],
            ['new_password', 'string', 'min' => 4, 'max' => 10],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match."],
            ['username', 'validateUsernameExists'],
        ];
    }

    public function validateUsernameExists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Login::findOne(['username' => $this->username]);
            if (!$user) {
                $this->addError($attribute, 'Username not found.');
            }
        }
    }

    public function resetPassword()
    {
        $user = Login::findOne(['username' => $this->username]);
        if (!$user) {
            return false;
        }

        // Since no hashing, directly update password field
        $user->password = $this->new_password;
        return $user->save(false); // skip validation for simplicity
    }
}
