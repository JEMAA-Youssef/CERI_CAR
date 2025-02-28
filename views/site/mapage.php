<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$produit = $model->produits;
$tableProduit = ArrayHelper::map($produit, 'id', 'produit');
?>

<p><?= Html::dropDownList('tableau', null, $tableProduit); ?></p>