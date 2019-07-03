<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "dept".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $dept_name
 */
class Dept extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'dept'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'dept_name',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_name'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'dept_name' => Yii::t('app', 'Dept Name'),
        ];
    }
}
