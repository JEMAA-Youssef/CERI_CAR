<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
?>

<div class="site-register main-content">
    <h1 class="text-center">Inscription</h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div id="notification" class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('error')): ?>
        <div id="notification" class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'method' => 'post',
        'action' => ['site/registerpage'],
        'options' => ['class' => 'custom-bg'],
    ]); ?>

    <?= $form->field($model, 'pseudo')->textInput(['placeholder' => 'Pseudo', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'mail')->input('email', ['placeholder' => 'Email', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'nom')->textInput(['placeholder' => 'Nom', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'prenom')->textInput(['placeholder' => 'Prénom', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'pass')->passwordInput(['placeholder' => 'Mot de passe', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'photo')->textInput(['placeholder' => 'Lien vers la photo de profil', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'permis')->textInput(['placeholder' => 'Numéro du permis de conduire', 'class' => 'form-control']) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('S\'inscrire', ['class' => 'btn btn-success']) ?>
    </div>

    <p class="text-center">Déjà inscrit ? <?= Html::a('Se connecter', ['site/login']) ?></p>

    <?php ActiveForm::end(); ?>
</div>
