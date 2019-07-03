<?php

namespace frontend\controllers;

use frontendmodels\InformationForm;
use Yii;

class ReportController extends \yii\web\Controller
{
    public function actionAverageGrade()
    {
        $model = new InformationForm(['scenario' => 'average_grade']);

        if($model->load(Yii::$app->request->post())){

        }
        return $this->render('average-grade', [
            'model' => $model
        ]);
    }



}
