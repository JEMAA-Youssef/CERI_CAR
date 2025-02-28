<?php

namespace app\models;

use yii\db\ActiveRecord;

class Reservation extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.reservation';
    }
    public function getInfovoyage()
    {
        return $this->hasOne(Voyage::class, ['id' => 'voyage']);
    }
    public function getInfovoyageur()
    {
        return $this->hasOne(Internaute::class, ['id' => 'voyageur']);
    }

    // Récupère toutes les réservations associées à un voyage donné
    public static function getReservationByVoyage($idVoyage){
        return self::find()->where(['voyage'=>$idVoyage])->all();
    }

    public function rules()
    {
        return [
            [['voyage', 'voyageur', 'nbplaceresa'], 'required'],
            [['voyage', 'voyageur', 'nbplaceresa'], 'integer'],
        ];
    }


    // Sauvegarde la réservation dans la base de données
    public function saveReservation()
{
    return $this->save(); // Sauvegarde la réservation dans la base de données
}



}
