<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\i18n\Formatter;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\personal\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'People';
$this->params['breadcrumbs'][] = $this->title;
$data = new Spreadsheet_Excel_Reader("example.xls");
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Person', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div>

      <?= HTML::img([Url::base().'/backend/uploads/person/1.jpg']) ?>

    </div>

    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'user_id',
            'fname',
            'lname',
            'address',
            [
                'label' => 'รูป',
                'format' => 'html',
                'attribute' => 'img',

                'value' => function ($model) {
                   $content = '';


//
//                      foreach ($model->img as $item) {
//                          $content = $content . Html::img('@web/uploads/person/' . $item, ['width' => '150', 'height' => '200']) ;
//
//                      }
//                      return $content;


                       foreach ($model->img as $item) {
                      $content = $content . Html::a($item, '@web/uploads/person/' . $item,
                      ['class' => 'btn btn-primary','target' => '_blank',],['width' => '150', 'height' => '200']);
                      }
                      return $content;
                  }



            ],

            //'dept',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php echo $data->dump(true,true); ?>
</div>
