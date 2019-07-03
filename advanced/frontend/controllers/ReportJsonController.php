<?php

namespace frontend\information\controllers;


use Yii;
use yii\web\Controller;
use yii\web\Response;

class ReportJsonController extends Controller
{
    public function actionAverageGrade()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = [];
        $dataProvider = [];
        if(Yii::$app->request->get()){
            $model = Yii::$app->request->get();
            $sql = "
            SELECT
            MIN(c.ClassName) AS ClassName,
            COUNT(CASE WHEN (CONVERT(float,GPA) < 1) THEN PersonID ELSE NULL END) AS cnt1,
            COUNT(CASE WHEN (CONVERT(float,GPA) BETWEEN 1.00 AND 1.49) THEN PersonID ELSE NULL END) AS cnt2,
            COUNT(CASE WHEN (CONVERT(float,GPA) BETWEEN 1.50 AND 1.99) THEN PersonID ELSE NULL END) AS cnt3,
            COUNT(CASE WHEN (CONVERT(float,GPA) BETWEEN 2.00 AND 2.49) THEN PersonID ELSE NULL END) AS cnt4,
            COUNT(CASE WHEN (CONVERT(float,GPA) BETWEEN 2.50 AND 2.99) THEN PersonID ELSE NULL END) AS cnt5,
            COUNT(CASE WHEN (CONVERT(float,GPA) BETWEEN 3.00 AND 3.49) THEN PersonID ELSE NULL END) AS cnt6,
            COUNT(CASE WHEN (CONVERT(float,GPA) BETWEEN 3.50 AND 3.99) THEN PersonID ELSE NULL END) AS cnt7,
            COUNT(CASE WHEN (CONVERT(float,GPA) = 4.00) THEN PersonID ELSE NULL END) AS cnt8

            FROM VRegGPATermClass gpa
            LEFT JOIN RegBClass c ON c.ClassID = gpa.ClassID
            WHERE gpa.CurriculumID = :CurriculumID
            AND AcademicYear = :AcademicYear
            AND TermID = :TermID
            GROUP BY c.ClassID
            ORDER BY c.ClassID
            ";
            $c = Yii::$app->db->createCommand($sql);
            $c->bindValues([
                'CurriculumID' => $model['CurriculumID'],
                'AcademicYear' => $model['AcademicYear'],
                'TermID' => $model['TermID']
            ]);
            $data = $c->queryAll();
            return $data;

        }

    }
}
