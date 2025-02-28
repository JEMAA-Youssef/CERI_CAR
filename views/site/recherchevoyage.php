    <?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    ?>

    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow p-4">
                <h1 class="mb-4">Recherche de Voyages</h1>

                
                <?php $form = ActiveForm::begin([
                    'id' => 'recherche-form', 
                    'method' => 'post',
                    'action' => \yii\helpers\Url::to(['site/recherchevoyage']),
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
            ],
                ]); ?>


               
                <div class="row mb-3">
                    <div class="col-md-6">
                        <?= $form->field($model, 'villeDepart')->textInput(['placeholder' => 'Ville de départ']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'villeArrivee')->textInput(['placeholder' => 'Ville d\'arrivée']) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-3">
                        <?= $form->field($model, 'nombrePersonnes')->input('number', ['min' => 1, 'value' => 1]) ?>
                    </div>
                </div>

                
                <div class="form-group">
                    <?= Html::submitButton('Rechercher', ['class' => 'btn btn-primary px-4']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            
            <div id="resultats-container" class="mt-4"></div>
            <div id="detail-container" class="mt-4"></div>
        </div>
    </div>
