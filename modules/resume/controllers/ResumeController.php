<?php
namespace app\modules\resume\controllers;

use Yii;
use yii\web\Controller;
use app\modules\resume\models\Resume;
use app\modules\resume\forms\ResumeUpdate;
use app\modules\resume\models\ResumeCompetence;
use yii\web\NotFoundHttpException;

class ResumeController extends Controller{

    public function actionDelete($id){
        $model = Resume::findOne($id);
        if($model === null){
            throw new NotFoundHttpException('Запись не найдена');
        }
        
        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Удалено');
        }
        
        return Yii::$app->getResponse()->redirect([
            '/resume/resume/index'
        ]);
    }

    public function actionCreate(){
        
        $form = new ResumeUpdate();
        $form->resume = new Resume();
        $blankResumeCompetence = new ResumeCompetence();
        
        if ($form->resume->load(Yii::$app->request->post()) 
                && $form->loadResumeCompetencies(Yii::$app->request->post(), $blankResumeCompetence->formName()) 
                && $form->save()) {
            Yii::$app->session->setFlash('success', 'Добавлено');
            return Yii::$app->getResponse()->redirect([
                '/resume/resume/view', 'id' => $form->resume->id
            ]);
        } else if ($form->validationFailed) {
            Yii::$app->session->setFlash('error', 'Исправьте ошибки');
        } 

        return $this->render('update', [
            'resume' => $form->resume,
            'resumeCompetencies' => $form->resumeCompetencies,
            'blankResumeCompetence' => $blankResumeCompetence
        ]);
    }
    
    public function actionUpdate($id){
        
        $form = new ResumeUpdate();
        $form->resume = Resume::findOne($id);
        if($form->resume === null){
            throw new NotFoundHttpException('Запись не найдена');
        }
        
        $blankResumeCompetence = new ResumeCompetence();
        
        if ($form->resume->load(Yii::$app->request->post()) 
                && $form->loadResumeCompetencies(Yii::$app->request->post(), $blankResumeCompetence->formName()) 
                && $form->save()) {
            Yii::$app->session->setFlash('success', 'Обновлено');
            return Yii::$app->getResponse()->redirect([
                '/resume/resume/view', 'id' => $form->resume->id
            ]);
        } else if ($form->validationFailed) {
            Yii::$app->session->setFlash('error', 'Исправьте ошибки');
        } else {
            $form->resumeCompetencies = $form->resume->resumeCompetencies;
        }


        return $this->render('update', [
            'resume' => $form->resume,
            'resumeCompetencies' => $form->resumeCompetencies,
            'blankResumeCompetence' => $blankResumeCompetence
        ]);
    }
    
    public function actionIndex(){
        
        $model = new Resume();

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $model->search()
        ]);
    }
    
    public function actionView($id){
        
        $model = Resume::findOne($id);
        if($model === null){
            throw new NotFoundHttpException('Запись не найдена');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
}
