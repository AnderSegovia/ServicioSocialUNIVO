<?php

namespace app\controllers;

use app\models\TblInstituciones;
use app\models\TblInstitucionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TbllInstitucionesController implements the CRUD actions for TblInstituciones model.
 */
class TbllInstitucionesController extends BaseController
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
     * Lists all TblInstituciones models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblInstitucionesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblInstituciones model.
     * @param int $id_institucion Id Institucion
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_institucion)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_institucion),
        ]);
    }

    /**
     * Creates a new TblInstituciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblInstituciones();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_institucion' => $model->id_institucion]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblInstituciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_institucion Id Institucion
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_institucion)
    {
        $model = $this->findModel($id_institucion);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_institucion' => $model->id_institucion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblInstituciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_institucion Id Institucion
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_institucion)
    {
        $this->findModel($id_institucion)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblInstituciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_institucion Id Institucion
     * @return TblInstituciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_institucion)
    {
        if (($model = TblInstituciones::findOne(['id_institucion' => $id_institucion])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
