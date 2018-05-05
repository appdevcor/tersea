<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "uploadedfiles".
 *
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $url
 * @property int $etat
 */
class Uploadedfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $image;
    public static function tableName()
    {
        return 'uploadedfiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'url'], 'required'],
            [['type'], 'string', 'max' => 4],
            [['url'], 'string', 'max' => 500],
            [['etat'], 'integer'],
            [['image'],'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'url' => Yii::t('app', 'Url'),
            'etat' => Yii::t('app', 'Etat'),
        ];
    }
    
   
}


