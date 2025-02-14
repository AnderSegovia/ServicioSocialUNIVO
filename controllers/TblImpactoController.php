<?php

namespace app\controllers;

use app\models\TblImpacto;
use app\models\TblImpactoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblImpactoController implements the CRUD actions for TblImpacto model.
 */
class TblImpactoController extends BaseController
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
     * Lists all TblImpacto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblImpactoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblImpacto model.
     * @param int $id_impacto Id Impacto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_impacto)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_impacto),
        ]);
    }

    /**
     * Creates a new TblImpacto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblImpacto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_impacto' => $model->id_impacto]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblImpacto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_impacto Id Impacto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_impacto)
    {
        $model = $this->findModel($id_impacto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_impacto' => $model->id_impacto]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblImpacto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_impacto Id Impacto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_impacto)
    {
        $this->findModel($id_impacto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblImpacto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_impacto Id Impacto
     * @return TblImpacto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_impacto)
    {
        if (($model = TblImpacto::findOne(['id_impacto' => $id_impacto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
