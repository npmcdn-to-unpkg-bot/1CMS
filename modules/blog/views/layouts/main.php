<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\admin\models\Widgetus;
use app\modules\admin\controllers\MainmenuController;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php
    MainmenuController::navbar();
    ?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="col-xs-8">
            <?php
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
            }
            ?>
            <?= $content ?></div>

        <div class="col-xs-4">
            <hr>
            <?php
            $dir = Yii::$app->basePath . '/components/';
            $widgets = Widgetus::find()->all();
            foreach ($widgets as $widget):
                if ($widget->zone == 'rsb') {
                    echo "<h4>" . $widget->name . ": </h4>";
                    include $dir . $widget->name . '.php';
                    echo "<hr>";
                }
            endforeach; ?>
        </div>
    </div>
</div>

<footer class="footer" style="height: auto; ">
    <div class="container" style="display: inline-block; width: 1490px; ">
        <div class="pull-left" style="float: left; margin-right: 15px">&copy;  SoftGroup PHP Academy <?= date('Y'); ?></div>
        <div>
            <?php
            $widgets = Widgetus::find()->all();
            foreach ($widgets as $widget):
                if ($widget->zone == 'foo') { ?>
                    <div style="float: left; margin-right: 15px"> <?php echo "<h4>" . $widget->name . ": </h4>";
                        include $dir . $widget->name . '.php'; ?>
                    </div>
                <?php }
            endforeach; ?>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
