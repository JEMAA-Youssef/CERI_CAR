<?php
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $pseudo;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['pseudo', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }


    //Vérifie que le pseudo existe et que le mot de passe saisi correspond.
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Pseudo ou mot de passe incorrect.');
            }
        }
    }



    // Connecte l'utilisateur si les informations sont valides
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }



    // Récupère l'utilisateur correspondant au pseudo saisi
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Internaute::getUserByIdentifiant($this->pseudo);
        }
        return $this->_user;
    }
}
