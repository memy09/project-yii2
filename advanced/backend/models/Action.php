<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "action".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $order_id
 * @property mixed $doc_id
 */
class Action extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'action'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'order_id',
            'doc_id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'doc_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'doc_id' => Yii::t('app', 'Doc ID'),
        ];
    }
}
