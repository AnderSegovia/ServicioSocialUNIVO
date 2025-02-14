<?php

namespace app\controllers;

use app\models\TblFacultad;
use app\models\TblFacultadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblFacultadController implements the CRUD actions for TblFacultad model.
 */
class TblFacultadController extends BaseController
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
     * Lists all TblFacultad models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblFacultadSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblFacultad model.
     * @param int $id_facultad Id Facultad
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_facultad)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_facultad),
        ]);
    }

    /**
     * Creates a new TblFacultad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblFacultad();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_facultad' => $model->id_facultad]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblFacultad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_facultad Id Facultad
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_facultad)
    {
        $model = $this->findModel($id_facultad);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_facultad' => $model->id_facultad]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblFacultad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_facultad Id Facultad
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_facultad)
    {
        $this->findModel($id_facultad)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblFacultad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_facultad Id Facultad
     * @return TblFacultad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_facultad)
    {
        if (($model = TblFacultad::findOne(['id_facultad' => $id_facultad])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
