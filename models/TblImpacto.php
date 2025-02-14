<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_impacto".
 *
 * @property int $id_impacto
 * @property string $nombre_impacto
 *
 * @property TblProyecto[] $tblProyectos
 */
class TblImpacto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_impacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_impacto'], 'required'],
            [['nombre_impacto'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_impacto' => 'Id Impacto',
            'nombre_impacto' => 'Nombre Impacto',
        ];
    }

    /**
     * Gets query for [[TblProyectos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblProyectos()
    {
        return $this->hasMany(TblProyecto::class, ['fk_impacto' => 'id_impacto']);
    }
}
