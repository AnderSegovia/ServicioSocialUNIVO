<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_turnos".
 *
 * @property int $id_turno
 * @property string $nombre_turno
 *
 * @property TblPivotef1[] $tblPivotef1s
 */
class TblTurnos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_turnos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_turno'], 'required'],
            [['nombre_turno'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_turno' => 'Id Turno',
            'nombre_turno' => 'Nombre Turno',
        ];
    }

    /**
     * Gets query for [[TblPivotef1s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblPivotef1s()
    {
        return $this->hasMany(TblPivotef1::class, ['fk_turno' => 'id_turno']);
    }
}
