<?php

namespace app\controllers;

use app\models\TblAlumno;
use app\models\TblAlumnoSearch;
use app\models\TblExpediente;

use app\models\TblDepartamentos;
use app\models\TblDias;
use app\models\TblDistritos;
use app\models\TblF1;
use app\models\TblF1Search;
use app\models\TblMunicipios;
use app\models\TblPivotef1;
use app\models\TblTurnos;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblAlumnoController implements the CRUD actions for TblAlumno model.
 */
class TblAlumnoController extends BaseController
{ 
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors(); // Hereda los comportamientos del controlador base

        // Agregar una regla específica para la acción "create"
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create2'], // Especifica que esto aplica a la acción "create"
            'roles' => ['?'], // Permite el acceso a usuarios no autenticados
        ];

        return array_merge(
            $behaviors,
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
     * Lists all TblAlumno models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblAlumnoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblAlumno model.
     * @param int $id_alumno Id Alumno
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_alumno)
    {
        $expedientes = TblExpediente::find()
            ->where(['fk_alumnoExpediente' => $id_alumno])
            ->all();
    
        // Organiza los expedientes por tipo
        $expedientesPorTipo = [];
        foreach ($expedientes as $expediente) {
            $expedientesPorTipo[$expediente->fk_tipoExpediente][] = $expediente;
        }
    
        // Obtener el modelo de TblF1 relacionado con el alumno
        $f1Model = TblF1::find()
            ->where(['fk_alumnof1' => $id_alumno])
            ->one(); // Cambia column() por one() para obtener el objeto completo
    
        $pivotRecords = [];
        if ($f1Model) {
            $pivotRecords = TblPivotef1::find()
                ->where(['fk_f1' => $f1Model->id_f1])
                ->all();
        }
    
        return $this->render('view', [
            'model' => $this->findModel($id_alumno),
            'expedientesPorTipo' => $expedientesPorTipo,
            'f1Model' => $f1Model, // Enviar el modelo a la vista
            'pivotRecords' => $pivotRecords,
        ]);
    }
    

    /**
     * Creates a new TblAlumno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblAlumno();
        $model->scenario = TblAlumno::SCENARIO_CREATE;
	$model->fk_estado_alumno = 5; 


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['tbl-f1/create', 'id_alumno' => $model->id_alumno]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionCreate2()
    {
        $model = new TblAlumno();
        $model->scenario = TblAlumno::SCENARIO_CREATE;
	$model->fk_estado_alumno = 5; 


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['tbl-f1/create2', 'id_alumno' => $model->id_alumno]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create2', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblAlumno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_alumno Id Alumno
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_alumno)
    {
        $model = $this->findModel($id_alumno);
        $model->scenario = TblAlumno::SCENARIO_UPDATE;


        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_alumno' => $model->id_alumno]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblAlumno model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_alumno Id Alumno
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_alumno)
    {
        $this->findModel($id_alumno)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblAlumno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_alumno Id Alumno
     * @return TblAlumno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_alumno)
    {
        if (($model = TblAlumno::findOne(['id_alumno' => $id_alumno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
