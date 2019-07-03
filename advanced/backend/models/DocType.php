<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "doc_type".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $type_name
 * @property mixed $description
 */
class DocType extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'doc_type'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'type_name',
            'description',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_name', 'description'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'type_name' => Yii::t('app', 'Type Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
