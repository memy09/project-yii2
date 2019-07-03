<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "doc".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $date_start
 * @property mixed $date_end
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $position_id
 * @property mixed $user_id
 * @property mixed $status
 */
class Doc extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'doc'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'title',
            'description',
            'date_start',
            'date_end',
            'created_at',
            'updated_at',
            'position_id',
            'user_id',
            'status',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'date_start', 'date_end', 'created_at', 'updated_at', 'position_id', 'user_id', 'status'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'date_start' => Yii::t('app', 'Date Start'),
            'date_end' => Yii::t('app', 'Date End'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'position_id' => Yii::t('app', 'Position ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

}
