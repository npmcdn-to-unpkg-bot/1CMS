<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Mainmenu;
use yii\web\Controller;
use app\modules\admin\models\Settings;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

class MainmenuController extends Controller
{

    public function behaviors()
    {
        return [
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


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMainmenu()
    {
        $model = new Mainmenu();

        if ($model->load(\Yii::$app->request->post())) {
            Yii::$app->db->createCommand()->truncateTable('mainmenu')->execute();
            Yii::$app->db->createCommand()->batchInsert('mainmenu', ['title', 'url', 'number'],
                $_POST["Mainmenu"])->execute();
            return $this->refresh();
        }
        return $this->render('mainmenu', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $id = $data['id'];
            $template = '<div class="row">
                <div class="col-xs-4"><div class="form-group field-mainmenu-' . $id . '-title required has-success">
                <label class="control-label" for="mainmenu-' . $id . '-title">Title</label>
                <input type="text" id="mainmenu-' . $id . '-title" class="form-control" name="Mainmenu[' . $id . '][title]">
               
                <div class="help-block"></div>
                </div></div>
                <div class="col-xs-4"><div class="form-group field-mainmenu-' . $id . '-url required">
                <label class="control-label" for="mainmenu-' . $id . '-url">Url</label>
                <input type="text" id="mainmenu-' . $id . '-url" class="form-control" name="Mainmenu[' . $id . '][url]">
                
                <div class="help-block"></div>
                </div></div>
                    <div class="col-xs-4"><div class="form-group field-mainmenu-' . $id . '-number">
                <label class="control-label" for="mainmenu-' . $id . '-number">Number</label>
                <input type="text" id="mainmenu-' . $id . '-number" class="form-control" name="Mainmenu[' . $id . '][number]">
                
                <div class="help-block"></div>
                </div></div>
                </div>';
            return $template;
        }
    }

    static function navbar()
    {
        $site_title = Settings::findOne(1)->site_title;

        if (Yii::$app->user->can('admin')):
            $items[] = ['label' => 'Admin Panel', 'url' => ['/admin']];
//            $items[] = ['label' => 'Media Uploads', 'url' => ['/admin/mediafiles/index']];
//            $items[] = ['label' => 'Menu Setup', 'url' => ['/admin/mainmenu/mainmenu']];
//            $items[] = ['label' => 'Widgets', 'url' => ['/admin/widgetus/create']];
        endif;  

        $menu_items = Mainmenu::find()->orderBy('number ASC')->all();
        foreach ($menu_items as $menu_item) {
            $items[] = ['label' => $menu_item->title, 'url' => [$menu_item->url]];
        }

        if (!Yii::$app->user->isGuest):
            $items[] = ['label' => 'LogOut (' . Yii::$app->user->identity['username'] . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        else:
            $items[] = ['label' => 'SignUp', 'url' => ['/site/signup']];
            $items[] = ['label' => 'LogIn', 'url' => ['/site/login']];
        endif;

        NavBar::begin([
            'brandLabel' => $site_title,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $items,
        ]);
        NavBar::end();
    }
}
