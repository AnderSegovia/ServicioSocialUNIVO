<?php

namespace app\controllers;

use app\models\TblCarrera;
use app\models\TblCarreraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblCarreraController implements the CRUD actions for TblCarrera model.
 */
class TblCarreraController extends BaseController
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
     * Lists all TblCarrera models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblCarreraSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblCarrera model.
     * @param int $id_carrera Id Carrera
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_carrera)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_carrera),
        ]);
    }

    /**
     * Creates a new TblCarrera model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblCarrera();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_carrera' => $model->id_carrera]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblCarrera model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_carrera Id Carrera
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_carrera)
    {
        $model = $this->findModel($id_carrera);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_carrera' => $model->id_carrera]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblCarrera model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_carrera Id Carrera
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_carrera)
    {
        $this->findModel($id_carrera)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblCarrera model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_carrera Id Carrera
     * @return TblCarrera the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_carrera)
    {
        if (($model = TblCarrera::findOne(['id_carrera' => $id_carrera])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
