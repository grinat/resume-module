<?php
namespace app\modules\resume\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\resume\models\CompetenceSuggestion;

class CompetenceSuggestionController extends Controller{
    
    public function actionIndex(){
        
        $model = new CompetenceSuggestion();
        
        $model->load(Yii::$app->request->get(), '');
        
        if(!$model->validate()){
            Yii::$app->getResponse()->setStatusCode(422);
            return $model->getErrors();
        }
        
        return $model->getSuggestionsList(); 
    }
    
}
