<?php

namespace app\models;

use yii\db\ActiveRecord;

class Trajet extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.trajet';
    }

    public function getVoyages()
    {
        return $this->hasMany(Voyage::class, ['trajet' => 'id']);
    }
}
