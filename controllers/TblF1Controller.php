<?php

namespace app\controllers;

use app\models\TblDepartamentos;
use app\models\TblDias;
use app\models\TblDistritos;
use app\models\TblF1;
use app\models\TblF1Search;
use app\models\TblMunicipios;
use app\models\TblPivotef1;
use app\models\TblTurnos;
use GuzzleHttp\Psr7\Response;
use Yii;
use yii\bootstrap5\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response as WebResponse;

/**
 * TblF1Controller implements the CRUD actions for TblF1 model.
 */
class TblF1Controller extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TblF1 models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblF1Search();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblF1 model.
     * @param int $id_f1 Id F1
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_f1)
    {
        $pivotRecords = TblPivotef1::find()
            ->where(['fk_f1' => $id_f1])
            ->all();
    
        return $this->render('view', [
            'model' => $this->findModel($id_f1),
            'pivotRecords' => $pivotRecords,
        ]);
    }

    /**
     * Creates a new TblF1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_alumno = null)
    {
        $model = new TblF1();
    
        // Si se pasó un ID de alumno, establecerlo en el modelo
        if ($id_alumno !== null) {
            $model->fk_alumnof1 = $id_alumno;
        }
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Capturar el ID del F1 recién creado
            $f1Id = $model->id_f1;
    
            // Obtener los días y turnos seleccionados desde la solicitud POST
            $diasSeleccionados = Yii::$app->request->post('dias', []);
            $turnosPorDia = Yii::$app->request->post('turno-dia', []);
    
            // Procesar los datos y guardar en tbl_pivotef1
            foreach ($diasSeleccionados as $diaId) {
                // Revisar si hay turnos seleccionados para el día
                if (!empty($turnosPorDia[$diaId])) {
                    foreach ($turnosPorDia[$diaId] as $turnoId) {
                        // Crear un nuevo registro en la tabla pivot
                        $pivot = new TblPivotef1();
                        $pivot->fk_f1 = $f1Id;
                        $pivot->fk_dia = $diaId;
                        $pivot->fk_turno = $turnoId;
                        // Guardar el registro
                        if (!$pivot->save()) {
                            // Manejar el error de guardado si ocurre
                            Yii::error("Error al guardar TblPivotef1: " . json_encode($pivot->errors));
                        }
                    }
                } else {
                    Yii::warning("No se seleccionaron turnos para el día con ID: $diaId", __METHOD__);
                }
            }
    
            // Si la solicitud es AJAX, devolver una respuesta JSON
            if (Yii::$app->request->isAjax) {
                return [
                    'success' => true,
                    'message' => 'Los datos han sido guardados exitosamente.',
                ];
            } else {
                return $this->redirect(['view', 'id_f1' => $model->id_f1]);
            }
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionFinal()
    {
    
        return $this->render('final', []);
    }

    public function actionCreate2($id_alumno = null)
    {
        $model = new TblF1();
    
        // Si se pasó un ID de alumno, establecerlo en el modelo
        if ($id_alumno !== null) {
            $model->fk_alumnof1 = $id_alumno;
        }
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Capturar el ID del F1 recién creado
            $f1Id = $model->id_f1;
    
            // Obtener los días y turnos seleccionados desde la solicitud POST
            $diasSeleccionados = Yii::$app->request->post('dias', []);
            $turnosPorDia = Yii::$app->request->post('turno-dia', []);
    
            // Procesar los datos y guardar en tbl_pivotef1
            foreach ($diasSeleccionados as $diaId) {
                // Revisar si hay turnos seleccionados para el día
                if (!empty($turnosPorDia[$diaId])) {
                    foreach ($turnosPorDia[$diaId] as $turnoId) {
                        // Crear un nuevo registro en la tabla pivot
                        $pivot = new TblPivotef1();
                        $pivot->fk_f1 = $f1Id;
                        $pivot->fk_dia = $diaId;
                        $pivot->fk_turno = $turnoId;
                        // Guardar el registro
                        if (!$pivot->save()) {
                            // Manejar el error de guardado si ocurre
                            Yii::error("Error al guardar TblPivotef1: " . json_encode($pivot->errors));
                        }
                    }
                } else {
                    Yii::warning("No se seleccionaron turnos para el día con ID: $diaId", __METHOD__);
                }
            }
    
            // Si la solicitud es AJAX, devolver una respuesta JSON
            if (Yii::$app->request->isAjax) {
                return [
                    'success' => true,
                    'message' => 'Los datos han sido guardados exitosamente.',
                ];
            } else {
                return $this->redirect(['final']);
            }
        }
    
        return $this->render('create2', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing TblF1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_f1 Id F1
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_f1)
    {
        $model = $this->findModel($id_f1);
        
        // Recuperar registros pivote existentes para el id_f1
        $pivotRecords = TblPivotef1::find()
            ->where(['fk_f1' => $id_f1])
            ->all();
        
        // Si el formulario es enviado, procesar la actualización
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                // Eliminar registros pivote existentes para el id_f1
                TblPivotef1::deleteAll(['fk_f1' => $id_f1]);
        
                // Obtener datos de checkboxes seleccionados
                $selectedDiasTurnos = Yii::$app->request->post('turno-dia');
        
                // Guardar nuevos registros pivote
                foreach ($selectedDiasTurnos as $diaId => $turnos) {
                    foreach ($turnos as $turnoId) {
                        $pivotRecord = new TblPivotef1();
                        $pivotRecord->fk_f1 = $model->id_f1;
                        $pivotRecord->fk_dia = $diaId;
                        $pivotRecord->fk_turno = $turnoId;
                        $pivotRecord->save();
                    }
                }
        
                return $this->redirect(['view', 'id_f1' => $model->id_f1]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'pivotRecords' => $pivotRecords,
        ]);
    }
    

    /**
     * Deletes an existing TblF1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_f1 Id F1
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_f1)
    {
        $this->findModel($id_f1)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblF1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_f1 Id F1
     * @return TblF1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_f1)
    {
        if (($model = TblF1::findOne(['id_f1' => $id_f1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCargar()
    {
        Yii::$app->response->format = WebResponse::FORMAT_JSON;
    
        $distritoId = Yii::$app->request->post('distritoId');
        $municipioId = null;
        $departamentoId = null;
    
        if ($distritoId) {
            $distrito = TblDistritos::findOne($distritoId);
            if ($distrito) {
                $municipio = TblMunicipios::findOne($distrito->fk_municipio);
                if ($municipio) {
                    $municipioId = $municipio->id_municipio;
                    $departamento = TblDepartamentos::findOne($municipio->fk_departamento);
                    if ($departamento) {
                        $departamentoId = $departamento->id_departamento;
                    }
                }
            }
        }
    
        if ($municipioId === null || $departamentoId === null) {
            Yii::warning("No se encontró el municipio o departamento para el distrito ID: $distritoId");
        }
    
        return [
            'municipio_id' => $municipioId,
            'departamento_id' => $departamentoId,
        ];
    }
    public function actionCargarMunicipios()
{
    Yii::$app->response->format = WebResponse::FORMAT_JSON;
    $departamentoId = Yii::$app->request->post('departamentoId');

    $municipios = TblMunicipios::find()
        ->where(['fk_departamento' => $departamentoId])
        ->orderBy('nombre_municipio')
        ->all();

    $data = [];
    foreach ($municipios as $municipio) {
        $data[$municipio->id_municipio] = $municipio->nombre_municipio;
    }

    return $data;
}

public function actionCargarDistritos()
{
    Yii::$app->response->format = WebResponse::FORMAT_JSON;
    $municipioId = Yii::$app->request->post('municipioId');

    $distritos = TblDistritos::find()
        ->where(['fk_municipio' => $municipioId])
        ->orderBy('nombre_distrito')
        ->all();

    $data = [];
    foreach ($distritos as $distrito) {
        $data[$distrito->id_distrito] = $distrito->nombre_distrito;
    }

    return $data;
}

    
}
