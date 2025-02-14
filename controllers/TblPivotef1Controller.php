<?php

namespace app\controllers;

use app\models\TblPivotef1;
use app\models\TblPivotef1Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblPivotef1Controller implements the CRUD actions for TblPivotef1 model.
 */
class TblPivotef1Controller extends BaseController
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
     * Lists all TblPivotef1 models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblPivotef1Search();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblPivotef1 model.
     * @param int $id_pivotef1 Id Pivotef1
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_pivotef1)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_pivotef1),
        ]);
    }

    /**
     * Creates a new TblPivotef1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblPivotef1();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_pivotef1' => $model->id_pivotef1]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblPivotef1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_pivotef1 Id Pivotef1
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_pivotef1)
    {
        $model = $this->findModel($id_pivotef1);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_pivotef1' => $model->id_pivotef1]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblPivotef1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_pivotef1 Id Pivotef1
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_pivotef1)
    {
        $this->findModel($id_pivotef1)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblPivotef1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_pivotef1 Id Pivotef1
     * @return TblPivotef1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_pivotef1)
    {
        if (($model = TblPivotef1::findOne(['id_pivotef1' => $id_pivotef1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
