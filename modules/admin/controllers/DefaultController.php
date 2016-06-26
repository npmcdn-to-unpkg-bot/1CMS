<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\modules\admin\models\Settings;


/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public function behaviors() {
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

    public function actionSettings()
    {
        $model = Settings::findOne(1);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }

        return $this->render('settings', [
            'model' => $model,
        ]);
    }


}
