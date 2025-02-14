<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_alumno".
 *
 * @property int $id_alumno
 * @property string $nombre_alumno
 * @property string $codigo
 * @property string $telefono
 * @property string|null $correo
 * @property int $fk_carrera
 * @property int $fk_estado_alumno
 * @property int|null $numero_materias
 *
 * @property TblCarrera $fkCarrera
 * @property TblEstadoAlumno $fkEstadoAlumno
 * @property TblPivote[] $tblPivotes
 */
class TblAlumno extends \yii\db\ActiveRecord
{
    public $campoNumerico;
    public $pdfFile1;
    public $pdfFile2;
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_alumno', 'codigo', 'telefono', 'fk_carrera', 'fk_estado_alumno'], 'required'],
            [['fk_carrera', 'fk_estado_alumno', 'numero_materias'], 'integer'],
            [['nombre_alumno'], 'string', 'max' => 255],
            [['codigo', 'telefono'], 'string', 'max' => 9],
            [['correo'], 'string', 'max' => 200],
            [['fk_carrera'], 'exist', 'skipOnError' => true, 'targetClass' => TblCarrera::class, 'targetAttribute' => ['fk_carrera' => 'id_carrera']],
            [['fk_estado_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => TblEstadoAlumno::class, 'targetAttribute' => ['fk_estado_alumno' => 'id_estado_alumno']],
            [['pdfFile1', 'pdfFile2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
            ['codigo', 'validateCodigo', 'on' => self::SCENARIO_CREATE],
            ['nombre_alumno', 'validateNombre', 'on' => self::SCENARIO_CREATE],


        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['nombre_alumno', 'codigo', 'telefono', 'fk_carrera', 'fk_estado_alumno', 'numero_materias', 'correo']; // Campos para creación
        $scenarios[self::SCENARIO_UPDATE] = ['nombre_alumno', 'codigo', 'telefono', 'fk_carrera', 'fk_estado_alumno', 'numero_materias', 'correo']; // Campos para actualización
        return $scenarios;
    }

    public function validateCodigo($attribute, $params, $validator)
    {
        if (self::find()->where(['codigo' => $this->codigo])->exists()) {
            $this->addError($attribute, 'El código ingresado ya existe.');
        }
    }

    public function validateNombre($attribute, $params, $validator)
    {
        if (self::find()->where(['nombre_alumno' => $this->nombre_alumno])->exists()) {
            $this->addError($attribute, 'El nombre ingresado ya existe.');
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_alumno' => 'Id Alumno',
            'nombre_alumno' => 'Nombre Alumno',
            'codigo' => 'Codigo',
            'telefono' => 'Telefono',
            'correo' => 'Correo',
            'fk_carrera' => 'Carrera',
            'fk_estado_alumno' => 'Estado Alumno',
            'numero_materias' => 'Materias Probadas',
        ];
    }

    /**
     * Gets query for [[FkCarrera]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkCarrera()
    {
        return $this->hasOne(TblCarrera::class, ['id_carrera' => 'fk_carrera']);
    }

    /**
     * Gets query for [[FkEstadoAlumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkEstadoAlumno()
    {
        return $this->hasOne(TblEstadoAlumno::class, ['id_estado_alumno' => 'fk_estado_alumno']);
    }

    /**
     * Gets query for [[TblPivotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblPivotes()
    {
        return $this->hasMany(TblPivote::class, ['fk_alumno' => 'id_alumno']);
    }
    public function getProyectosAsignados()
    {
        return $this->hasMany(TblProyecto::class, ['id_proyecto' => 'fk_proyecto'])
            ->viaTable('tbl_pivote', ['fk_alumno' => 'id_alumno']);
    }
    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . $this->pdfFile->baseName . '.' . $this->pdfFile->extension;
            Yii::info("Attempting to save file to: $filePath", __METHOD__);
            if ($this->pdfFile->saveAs($filePath)) {
                Yii::info("File successfully saved to: $filePath", __METHOD__);
                return true;
            } else {
                Yii::error("Failed to save file to: $filePath", __METHOD__);
                return false;
            }
        } else {
            Yii::error("File validation failed: " . json_encode($this->errors), __METHOD__);
            return false;
        }
    }
}
 