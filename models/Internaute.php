<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Internaute extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'fredouil.internaute';
    }
    //Récupère un utilisateur à partir de son pseudo
    public static function getUserByIdentifiant($pseudo)
    {
        return self::find()->where(['pseudo' => $pseudo])->one();
    }

    public function getVoyagesproposes()
    {
        return $this->hasMany(Voyage::class, ['conducteur' => 'id']);
    }
    public function getReservationsproposes()
    {
        return $this->hasMany(Reservation::class, ['voyageur' => 'id']);
    }

    //Vérifie si l'utilisateur est un conducteur
    public function isConducteur(){
        return !empty($this->permis);
    }

    //Récupère l'utilisateur par son identifiant
    public static function findIdentity($id){
        return self::findOne($id);
    }

    // Recherche par pseudo (au lieu de "username")
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // Pas utilisé ici
    }

    // Retourne l'ID de l'utilisateur
    public function getId()
    {
        return $this->id;
    }

    // Clé d'authentification non utilisée
    public function getAuthKey()
    {
        return null;
    }

    // Clé d'authentification non utilisée
    public function validateAuthKey($authKey)
    {
        return true;
    }
    //Vérifie si un pseudo est déjà pris
    public static function isPseudoTaken($pseudo)
{
    return self::find()->where(['pseudo' => $pseudo])->exists();
}
//Vérifie si une adresse email est déjà prise
public static function isEmailTaken($email)
{
    return self::find()->where(['mail' => $email])->exists();
}


    public function rules()
{
    return [
        [['pseudo', 'mail', 'nom', 'prenom', 'pass'], 'required'],
        ['mail', 'email'],
        [['photo'], 'string', 'max' => 255],
        [['permis'],'integer'],
        [['pass'], 'string', 'min' => 6],
    ];
}


    //Sauvegarde l'internaute dans la base de données après avoir haché le mot de passe
    public function saveInternaute()
{
    $this->setPassword($this->pass); 
    return $this->save(); 
}

    //Hache le mot de passe avant la sauvegarde en base de données
    public function setPassword($password)
    {
        $this->pass = sha1($password);
    }

    //alide un mot de passe en comparant le mot de passe saisi avec le hachage stocké
    public function validatePassword($password)
{
    return $this->pass === sha1($password);
}

}