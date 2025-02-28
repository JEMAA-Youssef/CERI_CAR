<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class MyUsers extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'fredouil.my_users'; 
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id); 
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        
        return null; 
    }

    public function getAuthKey()
    {
        return null; 
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey; 
    }

    public function validatePassword($password)
    {
        return sha1($password) === $this->motpasse;
    }

    public function getUsername()
    {
        return $this->identifiant;
    }

    
}
