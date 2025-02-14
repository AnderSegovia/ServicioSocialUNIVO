<?php

namespace app\controllers;

use app\models\TblActividad;
use app\models\TblActividadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblActividadController implements the CRUD actions for TblActividad model.
 */
class TblActividadController extends BaseController
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
     * Lists all TblActividad models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblActividadSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblActividad model.
     * @param int $id_actividad Id Actividad
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_actividad)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_actividad),
        ]);
    }

    /**
     * Creates a new TblActividad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblActividad();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_actividad' => $model->id_actividad]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblActividad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_actividad Id Actividad
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_actividad)
    {
        $model = $this->findModel($id_actividad);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_actividad' => $model->id_actividad]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblActividad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_actividad Id Actividad
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_actividad)
    {
        $this->findModel($id_actividad)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblActividad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_actividad Id Actividad
     * @return TblActividad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_actividad)
    {
        if (($model = TblActividad::findOne(['id_actividad' => $id_actividad])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
