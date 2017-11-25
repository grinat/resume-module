<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $resume \app\modules\resume\forms\Resume */
/* @var $resumeCompetencies \app\modules\resume\models\ResumeCompetence[] */
/* @var $blankResumeCompetence \app\modules\resume\models\ResumeCompetence */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\resume\ModuleAsset;
use yii\helpers\Json;
use app\modules\resume\widgets\topMenu\TopMenuWidget;

ModuleAsset::register($this);

$this->title = ($resume->id > 0 ? 'Редактирование резюме' : 'Добавление резюме');
?>

<?= TopMenuWidget::widget() ?>

<div class="resume-update">
    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'resume-update', 'enableClientValidation' => false]); ?>

    <?= $form->field($resume, 'title')->textInput() ?>

    <?= $form->field($resume, 'description')->textInput() ?>

    <div class="resume-competencies">
        <?php
        $last = count($resumeCompetencies);
        $resumeCompetencies[] = $blankResumeCompetence;
        $i = 0;
        foreach ($resumeCompetencies as $resumeCompetence) {
            $htmlOfResumeCompetence = '<div class="resume-competence-item">';
            $htmlOfResumeCompetence .= $form->field($resumeCompetence, 'title')->textInput([
                'name' => $resumeCompetence->formName() . '[title][]',
                'autocomplete' => 'off'
            ]);
            $htmlOfResumeCompetence .= $form->field($resumeCompetence, 'raiting')->dropDownList($resumeCompetence->getRaitingList(), [
                'prompt' => ' - ',
                'name' => $resumeCompetence->formName() . '[raiting][]'
            ]);
            $htmlOfResumeCompetence .= $form->field($resumeCompetence, 'id')->hiddenInput([
                        'name' => $resumeCompetence->formName() . '[id][]'
                    ])->label(false);

            $htmlOfResumeCompetence .= Html::a('Удалить', null, ['class' => 'btn btn-sm btn-default remove-competence-from-resume']);
            $htmlOfResumeCompetence .= '</div>';

            if ($i < $last) {
                echo $htmlOfResumeCompetence;
            }
            $i++;
        }
        ?>
    </div>

    <?= Html::a('Добавить компетенцию', null, ['class' => 'btn btn-sm btn-default add-competence-to-resume']) ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block', 'name' => 'resume-update-button']) ?>

    <?php ActiveForm::end(); ?>
    
    <div class="blank-competence-form">
        <?= $htmlOfResumeCompetence ?>
    </div>
</div>
<?php
$this->registerJs('moduleResume.initCompetenceListeners();', $this::POS_READY);
$this->registerJs('moduleResume.compentenceAutoCompliterList = '.Json::encode($blankResumeCompetence->getSuggestionsList()).';', $this::POS_READY);
