<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Réserver un Voyage';
$this->params['breadcrumbs'][] = ['label' => 'Recherche de Voyages', 'url' => ['site/recherchevoyage']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container mt-5">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="card shadow p-4 mt-4">
        <h3 class="mb-3">Détails du Voyage</h3>
        <p><strong>Départ :</strong> <?= Html::encode($voyage->infotrajet->depart) ?></p>
        <p><strong>Arrivée :</strong> <?= Html::encode($voyage->infotrajet->arrivee) ?></p>
        <p><strong>Conducteur :</strong> <?= Html::encode($voyage->infoconducteur->pseudo) ?></p>
        <p><strong>Type de véhicule :</strong> <?= Html::encode($voyage->typevehicule) ?></p>
        <p><strong>Tarif :</strong> <?= Html::encode($voyage->tarif) ?> €</p>
        <p><strong>Places disponibles :</strong> <?= Html::encode($voyage->getNombrePlacesDisponible()) ?></p>
        <p><strong>Heure de départ :</strong> <?= Html::encode($voyage->heuredepart) ?></p>

        <?php if (!empty($voyage->contraintes)): ?>
            <p><strong>Contraintes :</strong> <?= Html::encode($voyage->contraintes) ?></p>
        <?php endif; ?>

        <!-- Bouton pour confirmer la réservation -->
        <?= Html::a(
            'Réserver',
            ['site/reservervoyage', 'id' => $voyage->id, 'nbplaceresa' => $model->nombrePersonnes],
            ['class' => 'btn btn-primary mt-2']
        ) ?>

    </div>
</div>
