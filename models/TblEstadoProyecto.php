<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_estado_proyecto".
 *
 * @property int $id_estado_proyecto
 * @property string $estado_proyecto
 *
 * @property TblProyecto[] $tblProyectos
 */
class TblEstadoProyecto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_estado_proyecto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_proyecto'], 'required'],
            [['estado_proyecto'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_estado_proyecto' => 'Id Estado Proyecto',
            'estado_proyecto' => 'Estado Proyecto',
        ];
    }

    /**
     * Gets query for [[TblProyectos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblProyectos()
    {
        return $this->hasMany(TblProyecto::class, ['fk_estado_proyecto' => 'id_estado_proyecto']);
    }
}
