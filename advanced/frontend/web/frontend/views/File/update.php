<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\file */

$this->title = 'Update File: ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="file-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
