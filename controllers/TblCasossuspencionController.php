<?php

namespace app\controllers;

use app\models\TblCasossuspencion;
use app\models\TblCasossuspencionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblCasossuspencionController implements the CRUD actions for TblCasossuspencion model.
 */
class TblCasossuspencionController extends Controller
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
     * Lists all TblCasossuspencion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblCasossuspencionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblCasossuspencion model.
     * @param int $id_casos Id Casos
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_casos)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_casos),
        ]);
    }

    /**
     * Creates a new TblCasossuspencion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblCasossuspencion();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_casos' => $model->id_casos]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblCasossuspencion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_casos Id Casos
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_casos)
    {
        $model = $this->findModel($id_casos);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_casos' => $model->id_casos]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblCasossuspencion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_casos Id Casos
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_casos)
    {
        $this->findModel($id_casos)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblCasossuspencion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_casos Id Casos
     * @return TblCasossuspencion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_casos)
    {
        if (($model = TblCasossuspencion::findOne(['id_casos' => $id_casos])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
