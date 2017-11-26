<?php

/* @var $this yii\web\View */
/* @var $model \app\modules\resume\models\Resume */
use app\modules\resume\ModuleAsset;

ModuleAsset::register($this);

$this->title = 'Резюме '.$model->title;
?>

<?= $this->render('breadcrumbBlock') ?>

<div class="resume-view">
    <h1><?= $model->title ?></h1>
    <p><?= $model->description ?></p>

    <?php if (is_array($model->resumeCompetencies) && count($model->resumeCompetencies) > 0): ?>
        <h3>Компетенции</h3>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Навык</th>
                <th class="raiting">Оценка</th>
            </tr>
            <?php foreach ($model->resumeCompetencies as $resumeCompetence) { ?>
                <tr>
                    <td><?= $resumeCompetence->title ?></td>
                    <td class="raiting"><?= $resumeCompetence->raiting ?></td>
                </tr>
            <?php } ?>
        </table>
   <?php endif; ?>
</div>   