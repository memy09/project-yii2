<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "auth_assign".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $role_name
 * @property mixed $role_id
 * @property mixed $created_at
 */
class AuthAssign extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['config', 'auth_assign'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'role_name',
            'role_id',
            'created_at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name', 'role_id', 'created_at'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'role_name' => Yii::t('app', 'Role Name'),
            'role_id' => Yii::t('app', 'Role ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
