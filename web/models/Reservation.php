<?php

namespace app\models;

use yii\db\ActiveRecord;

class Reservation extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.reservation';
    }
    public function getVoyage()
    {
        return $this->hasOne(Reservation::class, ['id' => 'voyage']);
    }
    public function getVoyageur()
    {
        return $this->hasOne(Reservation::class, ['id' => 'voyageur']);
    }
}
