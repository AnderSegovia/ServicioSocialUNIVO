<?php

namespace app\controllers;

use app\models\TblPivote;
use app\models\TblPivoteSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblPivoteController implements the CRUD actions for TblPivote model.
 */
class TblPivoteController extends BaseController
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
     * Lists all TblPivote models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblPivoteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblPivote model.
     * @param int $id_pivote Id Pivote
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_pivote)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_pivote),
        ]);
    }

    /**
     * Creates a new TblPivote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblPivote();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_pivote' => $model->id_pivote]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblPivote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_pivote Id Pivote
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_pivote)
    {
        $model = $this->findModel($id_pivote);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_pivote' => $model->id_pivote]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblPivote model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_pivote Id Pivote
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_pivote)
    {
        $this->findModel($id_pivote)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblPivote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_pivote Id Pivote
     * @return TblPivote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_pivote)
    {
        if (($model = TblPivote::findOne(['id_pivote' => $id_pivote])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
