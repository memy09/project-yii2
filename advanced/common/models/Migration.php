<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "migration".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $version
 * @property mixed $apply_time
 */
class Migration extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'migration'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'version',
            'apply_time',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['version', 'apply_time'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'version' => Yii::t('app', 'Version'),
            'apply_time' => Yii::t('app', 'Apply Time'),
        ];
    }
}
