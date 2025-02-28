<?php

namespace app\models;

use yii\db\ActiveRecord;

class Internaute extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.internaute';
    }



    public function getVoyagesProposes()
    {
        return $this->hasMany(Voyage::class, ['conducteur' => 'id']);
    }
    public function getReservationsProposes()
    {
        return $this->hasMany(Reservation::class, ['voyageur' => 'id']);
    }
}
