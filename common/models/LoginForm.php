<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\components\LoginThrottle;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
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
            // Tahan dulu bila IP ini sudah terlalu sering gagal.
            // Dicek sebelum sandi diperiksa, supaya penebakan sandi
            // benar-benar berhenti, bukan sekadar diperlambat.
            if (LoginThrottle::terblokir($this->username)) {
                $this->addError($attribute, 'Terlalu banyak percobaan login yang gagal. '
                    . 'Silakan coba lagi sekitar ' . LoginThrottle::sisaMenit($this->username) . ' menit lagi.');
                return;
            }

            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                LoginThrottle::catatGagal($this->username);
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            // Login berhasil: nolkan penghitung supaya pengguna sah yang
            // sempat salah ketik tidak terbawa hitungan berikutnya.
            LoginThrottle::bersihkan($this->username);

            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
