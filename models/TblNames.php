<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_names".
 *
 * @property int $id_names
 * @property string $baseform
 * @property string $accentsnames
 * @property string $create_at
 */
class TblNames extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_names';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['baseform', 'accentsnames'], 'required'],
            [['create_at'], 'safe'],
            [['baseform', 'accentsnames'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_names' => 'Id Names',
            'baseform' => 'Baseform',
            'accentsnames' => 'Accentsnames',
            'create_at' => 'Create At',
        ];
    }
}
