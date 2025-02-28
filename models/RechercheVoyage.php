<?php
namespace app\models;

use yii\base\Model;

class RechercheVoyage extends Model
{
    public $villeDepart;
    public $villeArrivee;
    public $nombrePersonnes;

    public function rules()
    {
        return [
            [['villeDepart', 'villeArrivee', 'nombrePersonnes'], 'required'],
            [['villeDepart', 'villeArrivee'], 'string', 'max' => 255],
            ['nombrePersonnes', 'integer', 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'villeDepart' => 'Ville de départ',
            'villeArrivee' => 'Ville d\'arrivée',
            'nombrePersonnes' => 'Nombre de personnes',
        ];
    }
}
?>