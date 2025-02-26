<?php

namespace app\controllers;

use app\models\TblNames;
use app\models\TblNamesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblNamesController implements the CRUD actions for TblNames model.
 */
class TblNamesController extends Controller
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
     * Lists all TblNames models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblNamesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblNames model.
     * @param int $id_names Id Names
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_names)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_names),
        ]);
    }

    /**
     * Creates a new TblNames model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblNames();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_names' => $model->id_names]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblNames model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_names Id Names
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_names)
    {
        $model = $this->findModel($id_names);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_names' => $model->id_names]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblNames model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_names Id Names
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_names)
    {
        $this->findModel($id_names)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblNames model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_names Id Names
     * @return TblNames the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_names)
    {
        if (($model = TblNames::findOne(['id_names' => $id_names])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
