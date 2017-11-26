<?php
namespace app\modules\resume\models;

use yii\base\Model;
use app\modules\resume\models\ResumeCompetence;

/**
 * Model autocomplite
 * 
 */
class CompetenceSuggestion extends Model{
    
    const MAX_SUGGESTIONS = 50;
    const QUERY_MIN_LEN = 2;
    const QUERY_MAX_LEN = 20;

    /**
     * Строка поиска соответсвий
     * @var string
     */
    public $q;
    
    public function rules() {
        return [
            ['q', 'trim'], 
            ['q', 'required'],
            ['q', 'app\modules\resume\validators\PurifyFilter'],
            ['q', 'string', 'min' => static::QUERY_MIN_LEN, 'max' => static::QUERY_MAX_LEN]
        ];
    }
    
    /**
     * Возвращает массив подсказок
     * @return array|null
     */
    public function getSuggestionsList(){
        $list = ResumeCompetence::find()
                ->select('title')
                ->where(['like', 'title', $this->q.'%', false])
                ->groupBy('title')
                ->limit(static::MAX_SUGGESTIONS)
                ->asArray()
                ->all();
        
        return $list;       
    }
}
