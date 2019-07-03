<?php

namespace common\models;

use Yii;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
/**
 * This is the model class for collection "person".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $user_id
 * @property mixed $fname
 * @property mixed $lname
 * @property mixed $address
 * @property mixed $tel
 * @property mixed $img
 * @property mixed $dept
 */
class Person extends \yii\mongodb\ActiveRecord
{
    const UPLOAD_FOLDER = 'person';
    public static function tableName()
    {
        return 'person';
    }
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'person'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'user_id',
            'fname',
            'lname',
            'address',
            'tel',
            'img',
            'dept',

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fname', 'lname', 'address', 'tel', 'img', 'dept'], 'required'],
            [['img'], 'file','maxFiles'=>10, ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'fname' => Yii::t('app', 'Fname'),
            'lname' => Yii::t('app', 'Lname'),
            'address' => Yii::t('app', 'Address'),
            'tel' => Yii::t('app', 'Tel'),
            'img' => Yii::t('app', 'Img'),
            'dept' => Yii::t('app', 'Dept'),

        ];
    }
    public static function getUploadPath(){
        return Yii::getAlias('@webroot').'/'.self::UPLOAD_FOLDER.'/';
    }
    public static function getUploadUrl(){
        return Url::base(true).'/'.self::UPLOAD_FOLDER.'/';
    }
    public function listDownloadFiles($type){
    $docs_file = '';
    if(in_array($type, ['img'])){
        $data = $this->img;
//        $files = Json::decode($data);
  //    $files = json_decode($data, true);
        $files{''} = $data;
        if(is_array($files)){
            $docs_file ='<ul>';
            foreach ($files as $key => $value) {
                $docs_file .= '<li>'.Html::a($value,['/person/download','_id'=>$this->user_id,'file'=>$key,'file_name'=>$value]).'</li>';
            }
            $docs_file .='</ul>';
        }
    }

    return $docs_file;

}

    public function initialPreview($data,$field,$type='file'){
        $initial = [];
////        $files = Json::decode($data);
  //     $files = json_decode($data, true);
       $files{''} = $data;
        if(is_array($files)){
            foreach ($files as $key => $value) {
                if($type=='file'){
                    $initial[] = "<div class='file-preview-other'><h2><i class='glyphicon glyphicon-file'></i></h2></div>";
                }elseif($type=='config'){
                    $initial[] = [
                        'caption'=> $value,
                        'width'  => '120px',
                        'url'    => Url::to(['/person/deletefile','_id'=>$this->user_id,'fileName'=>$key,'field'=>$field]),
                        'key'    => $key
                    ];
                }
                else{
                    $initial[] = Html::img(self::getUploadUrl().$this->img.'/'.$value,['class'=>'file-preview-image', 'alt'=>$model->_id, 'title'=>$model->_id]);
                }
            }
        }
        return $initial;
    }
    public function actionDownload($id,$file,$file_name){
        $model = $this->findModel($id);
        if(!empty($model->img) && !empty($model->img)){
            Yii::$app->response->sendFile($model->getUploadPath().'/'.$model->img.'/'.$file,$file_name);
        }else{
            $this->redirect(['/person/view','_id'=>$id]);
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */


    public function getViewer($fliename){
        $name = '';
        $path = 'uploads/person/';
        $i = 0;
        foreach ($fliename as  $flienames) {
            $name.= ' '.Html::img($path.$flienames, ['class' => 'img-thumbnail', 'style' => 'width:200px;']).'<br><br>';
            $i++;
        }
        return $name;
    }
}
