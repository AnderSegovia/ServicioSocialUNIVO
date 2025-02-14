<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_instituciones".
 *
 * @property int $id_institucion
 * @property string $nombre_institucion
 * @property int $fk_actividad
 * @property string|null $nombre_encargado
 * @property string|null $titulo
 * @property string|null $cargo
 * @property string|null $saludo
 * @property string|null $telefono_encargado
 * @property string|null $correo_encargado
 * @property int $fk_distritoInst
 *
 * @property TblActividad $fkActividad
 * @property TblDistritos $fkDistritoInst
 * @property TblArchivos[] $tblArchivos
 * @property TblProyecto[] $tblProyectos
 */
class TblInstituciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_instituciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_institucion'], 'required'],
            [['fk_actividad', 'fk_distritoInst'], 'integer'],
            [['nombre_institucion', 'nombre_encargado', 'cargo', 'saludo'], 'string', 'max' => 200],
            [['titulo', 'correo_encargado'], 'string', 'max' => 100],
            [['telefono_encargado'], 'string', 'max' => 10],
            [['fk_actividad'], 'exist', 'skipOnError' => true, 'targetClass' => TblActividad::class, 'targetAttribute' => ['fk_actividad' => 'id_actividad']],
            [['fk_distritoInst'], 'exist', 'skipOnError' => true, 'targetClass' => TblDistritos::class, 'targetAttribute' => ['fk_distritoInst' => 'id_distrito']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_institucion' => 'Id Institucion',
            'nombre_institucion' => 'Nombre Institucion',
            'fk_actividad' => 'Actividad',
            'nombre_encargado' => 'Nombre Encargado',
            'titulo' => 'Titulo',
            'cargo' => 'Cargo',
            'saludo' => 'Saludo',
            'telefono_encargado' => 'Telefono Encargado',
            'correo_encargado' => 'Correo Encargado',
            'fk_distritoInst' => 'Distrito',
        ];
    }

    /**
     * Gets query for [[FkActividad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkActividad()
    {
        return $this->hasOne(TblActividad::class, ['id_actividad' => 'fk_actividad']);
    }

    /**
     * Gets query for [[FkDistritoInst]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkDistritoInst()
    {
        return $this->hasOne(TblDistritos::class, ['id_distrito' => 'fk_distritoInst']);
    }

    /**
     * Gets query for [[TblArchivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblArchivos()
    {
        return $this->hasMany(TblArchivos::class, ['fk_institucionArchivo' => 'id_institucion']);
    }

    /**
     * Gets query for [[TblProyectos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblProyectos()
    {
        return $this->hasMany(TblProyecto::class, ['fk_institucion' => 'id_institucion']);
    }
}
