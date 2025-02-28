<?php
/** @var $internaute app\models\Internaute */
/** @var $voyages app\models\Voyage[] */
/** @var $reservations app\models\Reservation[] */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<h1>Profil de l'internaute</h1>

<div class="custom-bg p-4 mb-4">
    <p><strong>Nom :</strong> <?= htmlspecialchars($internaute->nom) ?></p>
    <p><strong>Pseudo :</strong> <?= htmlspecialchars($internaute->pseudo) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($internaute->mail) ?></p>
    <p><strong>Photo :</strong><img src="<?= htmlspecialchars($internaute->photo) ?>" alt="Photo de l'internaute" width="100" height="100"/></p>
    <p><strong>Statut :</strong> <?= $internaute->isConducteur() ? 'Conducteur' : 'Passager' ?></p>
</div>

<?php if (!empty($voyages)): ?>
    <h2>Voyages proposés</h2>
    <ul class="list-group text-start">
        <?php foreach ($voyages as $voyage): ?>
            <li class="list-group-item">
                <strong>Trajet :</strong> <?= "{$voyage->infotrajet->depart} à {$voyage->infotrajet->arrivee}" ?><br>
                <strong>Distance :</strong> <?= $voyage->infotrajet->distance ?> km<br>
                <strong>Conducteur :</strong> <?= $voyage->infoconducteur->pseudo ?><br>
                <strong>Tarif :</strong> <?= $voyage->tarif ?> €/km<br>
                <strong>Places disponibles :</strong> <?= $voyage->getNombrePlacesDisponible() ?><br>
                <strong>Heure de départ :</strong> <?= $voyage->heuredepart ?><br>
                <?php if (!empty($voyage->contraintes)): ?>
                    <strong>Contraintes :</strong> <?= $voyage->contraintes ?><br>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun voyage proposé.</p>
<?php endif; ?>

<?php if (!empty($reservations)): ?>
    <h2>Réservations</h2>
    <ul class="list-group text-start">
        <?php foreach ($reservations as $reservation): ?>
            <li class="list-group-item">
                <strong>Voyage :</strong> <?= "{$reservation->infovoyage->infotrajet->depart} à {$reservation->infovoyage->infotrajet->arrivee}" ?><br>
                <strong>Distance :</strong> <?= $reservation->infovoyage->infotrajet->distance ?> km<br>
                <strong>Voyageur :</strong> <?= $reservation->infovoyageur->pseudo ?><br>
                <strong>Places réservées :</strong> <?= $reservation->nbplaceresa ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucune réservation effectuée.</p>
<?php endif; ?>
