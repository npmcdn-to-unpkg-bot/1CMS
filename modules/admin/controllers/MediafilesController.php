<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Mediafiles;
use app\modules\admin\models\MediafilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * MediafilesController implements the CRUD actions for Mediafiles model.
 */
class MediafilesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['viewAdminPage']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Mediafiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MediafilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mediafiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mediafiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new Mediafiles();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $file = UploadedFile::getInstance($model, 'murl');
            if ($file) {
                $rand = \Yii::$app->security->generateRandomString(1);
                $strlen = strlen($file->baseName);
                if ($strlen > 10) {
                    $name = substr($file->baseName, 0, 10);
                    $name2 = substr($file->baseName, 0, 20);
                } else {
                    $name = $file->baseName;
                    $name2 = $file->baseName;
                }
                $file_name = $name . '_' . $rand . '.' . $file->extension;
                $path = \Yii::getAlias('@webroot/uploads/media/') . $file_name;
                $model->ext = $file->extension;
                $model->type = $file->type;
                $model->title = $name2;
                $file->saveAs($path);
                $model->murl = Url::home(true) . 'site/download?file=' . $file_name;
                $model->save(false);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mediafiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        return $this->redirect(['create', 'id' => $model->id]);
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Mediafiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mediafiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mediafiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mediafiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
