<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<ul class="list-group text-start">
        <?php foreach ($voyages as $voyage): ?>
            <li class="list-group-item">
                <strong>Voyage :</strong> <?= "{$voyage->infotrajet->depart} à {$voyage->infotrajet->arrivee}" ?><br>
                <strong>Conducteur :</strong> <?= $voyage->infoconducteur->pseudo ?><br>
                <strong>Type de véhicule :</strong> <?= $voyage->typevehicule ?><br>
                <strong>Tarif :</strong> <?= $voyage->getTotaltarif($model->nombrePersonnes) ?> €<br>
                <strong>Places disponibles :</strong> <?= $voyage->getNombrePlacesDisponible() ?><br>
                <strong>Heure de départ :</strong> <?= $voyage->heuredepart ?><br>
                <?php if (!empty($voyage->contraintes)): ?>
                    <strong>Contraintes :</strong> <?= $voyage->contraintes ?><br>
                <?php endif; ?>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <button class="btn btn-primary mt-2 btn-reserver" data-id="<?= $voyage->id ?>" data-nombre-personnes="<?= $model->nombrePersonnes ?>">Réserver
                    </button>


                <?php else: ?>
                    <button class="btn btn-secondary mt-2" disabled>Réserver (Connectez-vous)</button>
                <?php endif; ?>





            </li>
        <?php endforeach; ?>
    </ul>

