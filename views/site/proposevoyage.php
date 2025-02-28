<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Voyage */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Proposer un Voyage';
?>
<div class="main-content">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <p class="text-center">Veuillez remplir les champs ci-dessous pour proposer un voyage.</p>

    <div id="recherche-form">
        <?php $form = ActiveForm::begin([
            'id' => 'propose-voyage-form',  // ID du formulaire
            'action' => ['site/proposevoyage'], // URL d'action vers la méthode correspondante
            'method' => 'post',
        ]); ?>

        <?= $form->field($model, 'depart')->textInput([
            'maxlength' => true, 
            'placeholder' => 'Ville de départ',
        ])->label('Départ*') ?>

        <?= $form->field($model, 'arrivee')->textInput([
            'maxlength' => true, 
            'placeholder' => 'Ville d\'arrivée',
        ])->label('Arrivée*') ?>

        <?= $form->field($model, 'typevehicule')->textInput([
            'maxlength' => true, 
            'placeholder' => 'Type de véhicule (ex: Berline compacte)',
        ])->label('Type de Véhicule*') ?>

        <?= $form->field($model, 'marque')->textInput([
            'maxlength' => true, 
            'placeholder' => 'Marque du véhicule (ex: Peugeot)',
        ])->label('Marque de Véhicule*') ?>

        <?= $form->field($model, 'tarif')->input('number', [
            'min' => 0, 
            'step' => '0.01', 
            'placeholder' => 'Tarif par voyageur (en €)',
        ])->label('Tarif* (par voyageur, en €)') ?>

        <?= $form->field($model, 'nbplacedispo')->input('number', [
            'min' => 1, 
            'placeholder' => 'Nombre de places disponibles',
        ])->label('Nombre de Places Disponibles*') ?>

        <?= $form->field($model, 'nbbagage')->input('number', [
            'min' => 0, 
            'placeholder' => 'Nombre de bagages autorisés',
        ])->label('Nombre de Bagages Autorisés*') ?>

        <?= $form->field($model, 'heuredepart')->input('number', [
            'min' => 0, 
            'placeholder' => 'Heure de Départ',
        ])->label('Heure de Départ*') ?>

        <?= $form->field($model, 'contraintes')->textarea([
            'rows' => 4, 
            'placeholder' => 'Contraintes particulières (ex: non-fumeur, animaux acceptés, etc.)',
        ])->label('Contraintes (facultatif)') ?>

        <div class="form-group text-center">
            <?= Html::button('Proposer le Voyage', [
                'class' => 'btn btn-primary', 
                'id' => 'ajax-propose-btn',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
