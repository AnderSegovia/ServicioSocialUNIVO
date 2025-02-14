<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_ocupacion".
 *
 * @property int $id_ocupacion
 * @property string $nombre_ocupacion
 *
 * @property TblF1[] $tblF1s
 */
class TblOcupacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_ocupacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_ocupacion'], 'required'],
            [['nombre_ocupacion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ocupacion' => 'Id Ocupacion',
            'nombre_ocupacion' => 'Nombre Ocupacion',
        ];
    }

    /**
     * Gets query for [[TblF1s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblF1s()
    {
        return $this->hasMany(TblF1::class, ['fk_ocupacion' => 'id_ocupacion']);
    }
}
