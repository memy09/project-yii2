<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Person;
use common\models\User;

/* @var $this yii\web\View */


?>
<header id="page-header">
    <h1></h1>
    <ol class="breadcrumb">
        <li><a href="#"></a></li>
        <li><a href="#"></a></li>
        <li class="active"></li>
    </ol>
</header>
<div class="project-view">

    <p>
    <center><?= Html::a('img', ['project-insert/create'], ['class' => 'btn btn-success']) ?></center>
    </p>

    <div class="panel-body">

        <?php /* @var $row common\models\Person */
        foreach ($persons as $row) { ?>

            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">

                <thead>

                <tr>

                    <th><img src="<?php echo Yii::getAlias('@web').'/'.$row->img;?>" />

                        <?php
                        echo $row->fname;
                        echo '  &nbsp  &nbsp   &nbsp;';
                        echo $row->lname;


                        ?></th>
                    <th>

                    </th>
                </tr>

                </thead>

            </table>

        <?php } ?>
    </div>

    <!-- /panel content -->


</div>


