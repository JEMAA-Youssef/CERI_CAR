<?php

namespace app\models;

use yii\db\ActiveRecord;

class Voyage extends ActiveRecord
{


    public $depart;
    public $arrivee;

    public static function tableName()
    {
        return 'fredouil.voyage';
    }

    public  function getInfoconducteur()
    {
        return $this->hasOne(Internaute::class, ['id' => 'conducteur']);
    }
    public function getInfotrajet()
    {
        return $this->hasOne(Trajet::class, ['id' => 'trajet']);
    }
    public function getInforeservations()
    {
        return $this->hasMany(Reservation::class, ['voyage' => 'id']);
    }

    // Calcule et retourne le nombre de places disponibles pour le voyage
    public function getNombrePlacesDisponible()
    {
        $nbPlaceReserve = $this->getInforeservations()->sum('nbplaceresa');
        return $this->nbplacedispo - $nbPlaceReserve;
    }

    //récupérer tous les voyages correspondant à un trajet donné
    public static function getVoyagesByTrajet($idTrajet){
        return self::find()->where(['trajet'=>$idTrajet])->all();
    }
    
    //Calcule le tarif total pour un certain nombre de passagers
    public function getTotaltarif($numberOfPassengers)
    {
        $distance = $this->infotrajet->distance; 
        return $distance * $this->tarif * $numberOfPassengers;
    }

    // Vérifie la disponibilité d'un voyage en fonction de son ID et du nombre de places demandées
    public static function getAvailableVoyage($id, $nbplaceresa)
{
    $voyage = self::find()->where(['id' => $id])->one();

    // Vérification de l'existence du voyage et du nombre de places disponibles
    if ($voyage && $voyage->getNombrePlacesDisponible() >= $nbplaceresa) {
        return $voyage;
    }

    return null; // Retourne null si le voyage n'existe pas ou si les places sont insuffisantes
}


public function rules()
{
    return [
        [['depart', 'arrivee', 'typevehicule', 'marque', 'tarif', 'nbplacedispo', 'nbbagage', 'heuredepart'], 'required'],
        [['depart', 'arrivee', 'typevehicule', 'marque'], 'string', 'max' => 255],
        [['nbplacedispo', 'nbbagage'], 'integer', 'min' => 1],
        ['tarif', 'number', 'min' => 0],
        ['heuredepart', 'string', 'max' => 5],
        ['contraintes', 'string', 'max' => 500],
    ];
}

public function saveVoyage($userId)
{
    // Rechercher le trajet correspondant aux villes saisies
    $trajet = Trajet::getInfotrajet($this->depart, $this->arrivee);

    if ($trajet) {
        // Associer le trajet existant au voyage
        $this->trajet = $trajet->id;
        $this->conducteur = $userId; 

        
        if ($this->validate()) {
            if ($this->save(false)) {
                return true; 
            }
        }
    }

    return false;
}


}
