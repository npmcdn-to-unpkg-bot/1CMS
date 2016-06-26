<?php
use yii\helpers\Url;
use app\modules\blog\models\Posts;
use app\modules\admin\models\Categories;
use app\modules\admin\models\Users;
?>

<div class="admin-default-index">
    <h1 style="text-align: center;" ">Administrator zone</h1><hr>

    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <a href="<?= Url::to(['/admin/users']); ?>" style="text-decoration: none;"><button type="button" class="btn btn-default">USERS</button></a>
        </div>
        <div class="btn-group" role="group">
            <a href="<?= Url::to(['/admin/categories']); ?>" style="text-decoration: none;"><button type="button" class="btn btn-default">CATEGORIES</button></a>
        </div>
        <div class="btn-group" role="group">
            <a href="<?= Url::to(['/admin/comments']); ?>" style="text-decoration: none;"><button type="button" class="btn btn-default">COMMENTS</button></a>
        </div>
        <div class="btn-group" role="group">
            <a href="<?= Url::to(['/admin/default/settings']); ?>" style="text-decoration: none;"><button type="button" class="btn btn-default">SETTINGS</button></a>
        </div>
    </div>
    <hr>
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <a href="<?= Url::to(['/admin/mediafiles/index']); ?>" style="text-decoration: none;"><button type="button" class="btn btn-default">MEDIA UPLOADS</button></a>
        </div>
        <div class="btn-group" role="group">
            <a href="<?= Url::to(['/admin/mainmenu/mainmenu']); ?>" style="text-decoration: none;"><button type="button" class="btn btn-default">MENU SETUP</button></a>
        </div>
        <div class="btn-group" role="group">
            <a href="<?= Url::to(['/admin/widgetus/create']); ?>" style="text-decoration: none;"><button type="button" class="btn btn-default">WIDGETS</button></a>
        </div>
    </div>
</div>
<div style="text-align: center">
    <hr>
    <br>
    <h1 style="text-align: center;" ">Site statistic: </h1><hr>
    <h5 style="text-decoration: underline"><b> Web site contains:</b></h5> <b><?=Posts::find()->count(); ?></b> articles in <b><?= Categories::find()->count(); ?> </b>categories.<br>
    <h5 style="text-decoration: underline"><b> In user database:</b></h5> <b><?=Users::find()->count(); ?> </b> users registered.


</div>
