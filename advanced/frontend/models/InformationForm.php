<?php
/**
 * User: Manop Kongoon
 * Date: 4/7/2018
 * Time: 10:44 PM
 */
namespace frontend\information\models;

class InformationForm extends \yii\base\Model
{
    public $AcademicYear;
    public $CurriculumID;
    public $TermID;
    public $ClassID;

    public function rules()
    {
        return [
            [['AcademicYear', 'CurriculumID', 'ClassID', 'TermID'], 'required'],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['average_grade'] = ['AcademicYear','CurriculumID', 'TermID'];
        $scenarios['summary_class'] = ['AcademicYear','ClassID', 'TermID'];
        return $scenarios;
    }

    public function attributeLabels()
    {
        return [
            'AcademicYear' => 'ปีการศึกษา',
            'CurriculumID' => 'ระดับการศึกษา',
            'TermID' => 'เทอม',
            'ClassID' => 'ชั้น'
        ];
    }
}
