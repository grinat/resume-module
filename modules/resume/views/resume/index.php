<?php

/* @var $this yii\web\View */
/* @var $model \app\modules\resume\models\Resume */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use app\modules\resume\ModuleAsset;

ModuleAsset::register($this);

$this->title = 'Список резюме';
?>

<?= $this->render('breadcrumbBlock') ?>

<div class="resume-index">
    <?= Html::a('Добавить резюме', ['/resume/resume/create'], ['class'=>'btn btn-default pull-right']) ?>
    
    <h1><?= $this->title ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'description',
            'actions' => [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'actions'],
                'headerOptions' => ['class' => 'actions'],
                'header' => 'Действия',
                'template' => '{view} {update} {delete}',
            ]
        ],
    ]) ?>
</div>    