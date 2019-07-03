<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for collection "file".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $file
 */
class File extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'file'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'file',
        ];
    }

    /**
     * {@inheritdoc}
     */

    public $uploadPath = 'uploads/docfile/file';
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'xls,xlsx', 'skipOnEmpty' => true]
        ];
    }
    public function uploadFile($model, $attribute)
    {
        $file = UploadedFile::getInstance($model, $attribute);

        if($file){
            if($this->isNewRecord){
                $fileName = time().'_'.$file->baseName.'.'.$file->extension;
            }else{
                $fileName = $this->getOldAttribute($attribute);
            }
            $file->saveAs(Yii::getAlias('@webroot').'/'.$this->uploadPath.'/'.$fileName);

            return $fileName;
        }
        return $this->isNewRecord ? false : $this->getOldAttribute($attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'file' => 'File',
        ];
    }
}
