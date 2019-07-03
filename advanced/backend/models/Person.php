<?php

namespace app\models;

use Yii;

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
 */
class Person extends \yii\mongodb\ActiveRecord
{
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fname', 'lname', 'address', 'tel', 'img'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'user_id' => 'User ID',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'address' => 'Address',
            'tel' => 'Tel',
            'img' => 'Img',
        ];
    }
}
