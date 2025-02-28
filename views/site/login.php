<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\Internaute;
?>
<div class="site-login main-content">
    <h1 class="text-center">Connexion</h1>

    <!-- Div pour les notifications -->
    <div id="notification" class="alert text-center" style="display: none;"></div>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'method' => 'post',
        'options' => ['class' => 'custom-bg'],
    ]); ?>

    <?= $form->field($model, 'pseudo')->textInput(['placeholder' => 'Pseudo', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mot de passe', 'class' => 'form-control']) ?>
    <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'form-check-input']) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Connexion', ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="text-center">
        <?= Html::a('Créer un compte', ['site/registerpage'], ['class' => 'btn btn-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>