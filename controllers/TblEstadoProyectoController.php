<?php

namespace app\controllers;

use app\models\TblEstadoProyecto;
use app\models\TblEstadoProyectoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblEstadoProyectoController implements the CRUD actions for TblEstadoProyecto model.
 */
class TblEstadoProyectoController extends BaseController
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
     * Lists all TblEstadoProyecto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblEstadoProyectoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblEstadoProyecto model.
     * @param int $id_estado_proyecto Id Estado Proyecto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_estado_proyecto)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_estado_proyecto),
        ]);
    }

    /**
     * Creates a new TblEstadoProyecto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblEstadoProyecto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_estado_proyecto' => $model->id_estado_proyecto]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblEstadoProyecto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_estado_proyecto Id Estado Proyecto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_estado_proyecto)
    {
        $model = $this->findModel($id_estado_proyecto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_estado_proyecto' => $model->id_estado_proyecto]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblEstadoProyecto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_estado_proyecto Id Estado Proyecto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_estado_proyecto)
    {
        $this->findModel($id_estado_proyecto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblEstadoProyecto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_estado_proyecto Id Estado Proyecto
     * @return TblEstadoProyecto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_estado_proyecto)
    {
        if (($model = TblEstadoProyecto::findOne(['id_estado_proyecto' => $id_estado_proyecto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
