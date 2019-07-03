<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
//use devgroup\dropzone\DropZone;
/* @var $this yii\web\View */
/* @var $model common\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(
  ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

<!--    --><?php
//
//    echo "<pre>";
//    print_r($listUsers);
//    echo "</pre>";
//
//    ?>



    <?= $form->field($model, 'user_id')->dropDownList([$listUsers], ['prompt' => '---- SELECT ME ------','id'=>'username']) ?>

    <?= $form->field($model, 'fname')->textInput() ?>

    <?= $form->field($model, 'lname')->textInput() ?>

    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'tel')->textInput() ?>




<?= $form->field($model, 'img')->widget(FileInput::classname(), [
        'options' => [
            //'accept' => 'image/*',


            'multiple' => true
        ],
       'pluginOptions' => ['initialPreview'=>$model->initialPreview($model->img,'img','file'),
            'initialPreviewConfig'=>$model->initialPreview($model->img,'img','config'),
         //  'allowedFileExtensions'=>['pdf','doc','docx','xls','xlsx'],
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => true,

        ]
    ]) ; ?>

    <?= $form->field($model, 'dept')->textInput()  ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
