<?php

namespace app\controllers;

use app\models\TblCargos;
use app\models\TblCargosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblCargosController implements the CRUD actions for TblCargos model.
 */
class TblCargosController extends Controller
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
     * Lists all TblCargos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblCargosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblCargos model.
     * @param int $id_cargos Id Cargos
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_cargos)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_cargos),
        ]);
    }

    /**
     * Creates a new TblCargos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblCargos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_cargos' => $model->id_cargos]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblCargos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_cargos Id Cargos
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_cargos)
    {
        $model = $this->findModel($id_cargos);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_cargos' => $model->id_cargos]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblCargos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_cargos Id Cargos
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_cargos)
    {
        $this->findModel($id_cargos)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblCargos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_cargos Id Cargos
     * @return TblCargos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_cargos)
    {
        if (($model = TblCargos::findOne(['id_cargos' => $id_cargos])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
