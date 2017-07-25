<?php

namespace app\api\modules\v3\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email_address;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email_address', 'password'], 'required'],
            //filter
        	[['email_address','password'], 'filter', 'filter' => 'trim'],
      		// email has to be a valid email address
            ['email_address', 'email', 'message' => 'Email Address is not valid'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Login Failed! Please check your Email and Password');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmailPassword($this->email_address,md5($this->password));
        }

        return $this->_user;
    }
}
