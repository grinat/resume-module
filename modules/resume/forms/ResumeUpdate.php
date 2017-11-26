<?php

namespace app\modules\resume\forms;

use yii\base\Model;
use app\modules\resume\models\Resume;
use app\modules\resume\models\ResumeCompetence;
use yii\base\InvalidCallException;

/**
 * Форма добавления/обновления резюме
 * обрабатывающая связанные модели
 */
class ResumeUpdate{
    
    /**
     *  \app\modules\resume\models\ResumeCompetence[]
     */
    public $resumeCompetencies = null;
    
    /**
     *  \app\modules\resume\models\Resume
     */
    public $resume = null;
    
    public $validationFailed = false;

    /**
     * Преобразует
     * 'form' => [
     *  'id' => [
     *      0 => ''
     *      1 => ''
     *  ]
     *   'title' => [
     *      0 => '1'
     *      1 => '2'
     *  ]
     *  ...
     * ] в 
     * 'form' => [
     *  '0' => [
     *      'id' => ''
     *      'title' => '1'
     * ]
     * '1' => [
     *      'id' => ''
     *      'title' => '2'
     * ]
     * ...
     * ]
     * 
     * @return array
     */
    public function convertInputData($inputData, $formName){
        $convertedArr = [];
        if(isset($inputData[$formName]) && is_array($inputData[$formName])){
            foreach($inputData[$formName] as $attr => $valArr){
                if(is_array($valArr)){
                    foreach($valArr as $key => $val){
                        $convertedArr[$key][$attr] = $val;
                    } 
                }
            }
        } 
        return $convertedArr;
    }
    
    /**
     * @param type $inputData
     * @param type $formName
     * @return boolean
     */
    public function loadResumeCompetencies($inputData, $formName){
        $convertedArr = $this->convertInputData($inputData, $formName);
                
        $resumeCompetencies = ResumeCompetence::find()
                ->where(['resume_id' => $this->resume->id])
                ->indexBy('id')
                ->all();
        
        $this->resumeCompetencies = [];
        foreach ($convertedArr as $data){
            if(isset($data['id']) && isset($resumeCompetencies[$data['id']])){
                /* @var $model \app\modules\resume\models\ResumeCompetence */
                $model = $resumeCompetencies[$data['id']];
            }else{
                $model = new ResumeCompetence;
            }
            
            $model->load($data, '');
            $this->resumeCompetencies[] = $model;
        }
        
        return true;
    }

    public function save(){
        
        if(is_array($this->resumeCompetencies) === false || ($this->resume instanceof Resume) === false){
            throw new InvalidCallException('resumeCompetencies must be an array, resume must be instanceof Resume');
        }
        
        if(!($this->resume->validate() & Model::validateMultiple($this->resumeCompetencies))){
            $this->validationFailed = true;
            return false;
        }
        
        $transaction = Resume::getDB()->beginTransaction();
        
        $this->resume->save(false);
        
        $competenceIds = [];
        foreach ($this->resumeCompetencies as $competence) {
            $competence->resume_id = $this->resume->id;
            $competence->save(false);
            $competenceIds[] = $competence->id;
        }
        
        ResumeCompetence::deleteAll(['AND',
            ['=', 'resume_id', $this->resume->id],
            ['NOT IN', 'id', $competenceIds]
        ]);

        $transaction->commit();
        return true;
    }
}
