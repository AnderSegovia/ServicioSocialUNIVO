<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_dias".
 *
 * @property int $id_dia
 * @property string $nombre_dia
 *
 * @property TblPivotef1[] $tblPivotef1s
 */
class TblDias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_dias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_dia'], 'required'],
            [['nombre_dia'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dia' => 'Id Dia',
            'nombre_dia' => 'Nombre Dia',
        ];
    }

    /**
     * Gets query for [[TblPivotef1s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblPivotef1s()
    {
        return $this->hasMany(TblPivotef1::class, ['fk_dia' => 'id_dia']);
    }
}
