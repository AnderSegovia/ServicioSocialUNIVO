<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_pivotef1".
 *
 * @property int $id_pivotef1
 * @property int $fk_f1
 * @property int $fk_dia
 * @property int $fk_turno
 *
 * @property TblDias $fkDia
 * @property TblF1 $fkF1
 * @property TblTurnos $fkTurno
 */
class TblPivotef1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pivotef1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_f1', 'fk_dia', 'fk_turno'], 'required'],
            [['fk_f1', 'fk_dia', 'fk_turno'], 'integer'],
            [['fk_dia'], 'exist', 'skipOnError' => true, 'targetClass' => TblDias::class, 'targetAttribute' => ['fk_dia' => 'id_dia']],
            [['fk_f1'], 'exist', 'skipOnError' => true, 'targetClass' => TblF1::class, 'targetAttribute' => ['fk_f1' => 'id_f1']],
            [['fk_turno'], 'exist', 'skipOnError' => true, 'targetClass' => TblTurnos::class, 'targetAttribute' => ['fk_turno' => 'id_turno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pivotef1' => 'Id Pivotef1',
            'fk_f1' => 'Fk F1',
            'fk_dia' => 'Fk Dia',
            'fk_turno' => 'Fk Turno',
        ];
    }

    /**
     * Gets query for [[FkDia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkDia()
    {
        return $this->hasOne(TblDias::class, ['id_dia' => 'fk_dia']);
    }

    /**
     * Gets query for [[FkF1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkF1()
    {
        return $this->hasOne(TblF1::class, ['id_f1' => 'fk_f1']);
    }

    /**
     * Gets query for [[FkTurno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkTurno()
    {
        return $this->hasOne(TblTurnos::class, ['id_turno' => 'fk_turno']);
    }
}
