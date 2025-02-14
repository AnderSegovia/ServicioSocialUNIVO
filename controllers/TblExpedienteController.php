<?php

namespace app\controllers;

use app\models\TblExpediente;
use app\models\TblExpendienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblExpedienteController implements the CRUD actions for TblExpediente model.
 */
class TblExpedienteController extends BaseController
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
     * Lists all TblExpediente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblExpendienteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblExpediente model.
     * @param int $id_expediente Id Expediente
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_expediente)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_expediente),
        ]);
    }

    /**
     * Creates a new TblExpediente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblExpediente();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_expediente' => $model->id_expediente]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblExpediente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_expediente Id Expediente
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_expediente)
    {
        $model = $this->findModel($id_expediente);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_expediente' => $model->id_expediente]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblExpediente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_expediente Id Expediente
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_expediente)
    {
        $this->findModel($id_expediente)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblExpediente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_expediente Id Expediente
     * @return TblExpediente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_expediente)
    {
        if (($model = TblExpediente::findOne(['id_expediente' => $id_expediente])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
