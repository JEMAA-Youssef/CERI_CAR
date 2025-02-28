<?php

namespace app\models;

use yii\db\ActiveRecord;

class Trajet extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.trajet';
    }

    
    public static function getInfotrajet($villeDep, $villeArr) {
        return self::find()->where(['depart' => $villeDep, 'arrivee' => $villeArr])->one();
    }
    




}
