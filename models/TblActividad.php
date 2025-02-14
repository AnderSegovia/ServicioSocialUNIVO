<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_actividad".
 *
 * @property int $id_actividad
 * @property string $nombre_actividad
 * @property int $fk_lineamiento
 *
 * @property TblLineamiento $fkLineamiento
 * @property TblInstituciones[] $tblInstituciones
 */
class TblActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_actividad', 'fk_lineamiento'], 'required'],
            [['fk_lineamiento'], 'integer'],
            [['nombre_actividad'], 'string', 'max' => 200],
            [['fk_lineamiento'], 'exist', 'skipOnError' => true, 'targetClass' => TblLineamiento::class, 'targetAttribute' => ['fk_lineamiento' => 'id_lineamiento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_actividad' => 'Id Actividad',
            'nombre_actividad' => 'Nombre Actividad',
            'fk_lineamiento' => 'Lineamiento',
        ];
    }

    /**
     * Gets query for [[FkLineamiento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkLineamiento()
    {
        return $this->hasOne(TblLineamiento::class, ['id_lineamiento' => 'fk_lineamiento']);
    }

    /**
     * Gets query for [[TblInstituciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblInstituciones()
    {
        return $this->hasMany(TblInstituciones::class, ['fk_actividad' => 'id_actividad']);
    }
}
