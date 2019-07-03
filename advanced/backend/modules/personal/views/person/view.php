<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\modeles\Person;

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = $model->fname.''.$model->lname;
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="person-view">

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
    <div class="text-center">

    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            '_id',

            'user_id',
            'fname',
            'lname',
            'address',
            'tel',

            'dept',
            [
                'label' => 'รูป',
                'format' => 'raw',
                'attribute' => 'img',

                'value' => function ($model) {
                    $content = '';


                    foreach ($model->img as $item){
                        $content = $content.Html::img('@web/uploads/person/'.$item,['width'=>'350','height'=>'200']);
                    }
                    return $content;

                }
            ]
        ],
    ]) ?>

</div>
