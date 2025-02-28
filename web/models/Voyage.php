<?php

namespace app\models;

use yii\db\ActiveRecord;

class Voyage extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.voyage';
    }

    public  function getConducteur()
    {
        return $this->hasOne(Voyage::class, ['id' => 'conducteur']);
    }
    public function getTrajet()
    {
        return $this->hasOne(Voyage::class, ['id' => 'trajet']);
    }
    public function getReservations()
    {
        return $this->hasMany(voyage::class, ['voyage' => 'id']);
    }
    public function getNombrePlacesDisponible()
    {
        $nbPlaceReserve = $this->getReservations()->sum('nbplaceresa');
        return $this->nbplacedispo - $nbPlaceReserve;
    }
}
