<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\file */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="file-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => (string)$model->_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => (string)$model->_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'คำนำหน้า',
                'value' => function($model){
                    return $model[0][0];
                }
            ],
            [
                'label' => 'ชื่อ นามสกุล',
                'value' => function($model){
                    return $model[0][1];
                }
            ],
            [
                'label' => 'หมายเลขบัตรประชาชน',
                'value' => function($model){
                    return $model[0][2];
                }
            ],
            [
                'label' => 'เพศ',
                'value' => function($model){
                    return $model[0][3];
                }
            ],
            [
                'label' => 'อายุ',
                'value' => function($model){
                    return $model[0][4];
                }
            ],
            [
                'label' => 'หน่วยอายุ(ปีเดือนวัน)',
                'value' => function($model){
                    return $model[0][5];
                }
            ],
            [
                'label' => 'HN',
                'value' => function($model){
                    return $model[0][6];
                }
            ],
            [
                'label' => 'AN',
                'value' => function($model){
                    return $model[0][7];
                }
            ],
            [
                'label' => 'Doctor',
                'value' => function($model){
                    return $model[0][8];
                }
            ],
            [
                'label' => 'Clinical Diagnosis',
                'value' => function($model){
                    return $model[0][9];
                }
            ],
        ]
    ]) ?>

</div>