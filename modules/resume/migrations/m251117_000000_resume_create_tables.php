<?php

use yii\db\Migration;

class m251117_000000_resume_create_tables extends Migration
{

    /**
     * `php /var/www/html/yii migrate --migrationPath=@app/modules/resume/migrations`
     */
    
    public function safeUp()
    {
        $this->createTable('{{%resume}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200),
            'description' => $this->text(),
        ]);
        
        $this->createTable('{{%resume_competence}}', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer()->unsigned(),
            'raiting' =>  $this->integer(),
            'title' => $this->string(200)
        ]);
        $this->createIndex('idx-'.$this->quoteTableNameForIndex('{{%resume_competence}}').'-resume_id', '{{%resume_competence}}', 'resume_id');
        $this->addForeignKey(
            'fk-'.$this->quoteTableNameForIndex('{{%resume_competence}}').'-'.$this->quoteTableNameForIndex('{{%resume}}'),
            '{{%resume_competence}}', 'resume_id',
            '{{%resume}}', 'id',
            'CASCADE', 'CASCADE'
        );
    }
    
    public function quoteTableNameForIndex($tableName){
        return $this->db->getSchema()->getRawTableName($tableName);
    }

    public function safeDown()
    {
        echo "m251117_000000_resume_create_tables reverted.\n";

        return true;
    }

}