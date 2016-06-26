<?php

namespace app\modules\blog\controllers;

use Yii;
use app\modules\blog\models\Posts;
use app\modules\blog\models\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use app\modules\admin\models\Comments;
use app\models\User;
use app\modules\admin\models\Settings;

/**
 * DefaultController implements the CRUD actions for Posts model.
 */
class DefaultController extends Controller
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
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $keywords = Settings::findOne(1)->keywords;
        $description = Settings::findOne(1)->site_description;
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $description,
        ]);

        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $keywords,
        ]);


        $AllPosts = Posts::find()->orderBy('date_create DESC');
        $pagination = Settings::findOne(1)->pagination;
        if ($AllPosts) {
            $pages = new Pagination(['totalCount' => $AllPosts->count(), 'pageSize' => $pagination]);
            $posts = $AllPosts->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            return $this->render('index', ['posts' => $posts, 'pages' => $pages]);
        }
    }

    public function actionByCategories($id)
    {
        $AllPosts = Posts::find()->where(['categories_id' => $id]);

        if ($AllPosts) {
            $pagination = Settings::findOne(1)->pagination;
            $pages = new Pagination(['totalCount' => $AllPosts->count(), 'pageSize' => $pagination]);
            $posts = $AllPosts->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            return $this->render('index', ['posts' => $posts, 'pages' => $pages]);
        }
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $comments = Comments::find()->where(['post_id' => $id])->all();
        $model = $this->findModel($id);
        $comments1 = new Comments();
        if ($comments1->load(Yii::$app->request->post()) && $comments1->save()) {
            $comments1->status = false;
            $comments1->save();
            return $this->refresh();
        }
        return $this->render('view', [
            'model' => $model,
            'comments' => $comments,
        ]);
    }

    public function actionActivate($id){
        $status = Comments::findOne($id);
        $status->status=true;
        $status->save();
        return $this->redirect(['/blog/default/view', 'id'=>$status->post_id]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Posts model.
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
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
