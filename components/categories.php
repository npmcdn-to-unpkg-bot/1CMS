<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\modules\admin\models\Categories;
use yii\helpers\Url;

AppAsset::register($this);
?>

<div>
    <?php
    $categories = Categories::find()->all();
    foreach ($categories as $category):
        ?>
        <p>
            <a href="<?= Url::to(['/blog/default/by-categories', 'id' => $category->id]) ?>"><?= $category->title ?></a>
        </p>
    <? endforeach; ?>
</div>