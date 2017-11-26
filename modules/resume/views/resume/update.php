<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $resume \app\modules\resume\models\Resume */
/* @var $resumeCompetencies \app\modules\resume\models\ResumeCompetence[] */
/* @var $blankResumeCompetence \app\modules\resume\models\ResumeCompetence */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\resume\ModuleAsset;
use yii\helpers\Url;
use app\modules\resume\models\CompetenceSuggestion;

ModuleAsset::register($this);

$this->title = ($resume->id > 0 ? 'Редактирование резюме' : 'Добавление резюме');
?>

<?= $this->render('breadcrumbBlock') ?>

<div class="resume-update">
    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'resume-update', 'enableClientValidation' => true]); ?>

    <?= $form->field($resume, 'title')->textInput() ?>

    <?= $form->field($resume, 'description')->textarea() ?>
    
    <div class="resume-competencies">
        <?php
        if(is_array($resumeCompetencies)){
            foreach ($resumeCompetencies as $resumeCompetence) {
                echo $this->render('updateResumeCompetenceBlock', [
                    'form' => $form,
                    'resumeCompetence' => $resumeCompetence,
                ]);
            }
        }
        ?>
    </div>
    
    <div class="form-group">
        <?= Html::a('Добавить компетенцию', '#', ['class' => 'add-competence-to-resume']) ?>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton('Сохранить резюме', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <div class="blank-competence-form">
        <?= $this->render('updateResumeCompetenceBlock', [
                'form' => $form,
                'resumeCompetence' => $blankResumeCompetence,
            ]) ?>
    </div>
</div>
<?php
$this->registerJs('moduleResume.initCompetenceListeners();', $this::POS_READY);
$this->registerJs('moduleResume.configureSuggestion("'.Url::to(['/resume/competence-suggestion/index']).'", '.CompetenceSuggestion::QUERY_MIN_LEN.', '.CompetenceSuggestion::QUERY_MAX_LEN.');', $this::POS_READY);
