<?php

use yii\db\Migration;

/**
 * Class m180505_134841_create_table_uploadedfiles
 */
class m180505_134841_create_table_uploadedfiles extends Migration
{
    /**
     * {@inheritdoc}
     */
    /*
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     
    public function safeDown()
    {
        echo "m180502_153853_create_table_fichiers cannot be reverted.\n";

        return false;
    }

    */
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

       $this->createTable('uploadedfiles', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->string(4)->notNull(),
            'url' => $this->string(500)->notNull(),
            'etat' => $this->tinyInteger(1)->notNull()->defaultValue(0)
        ]);
       
       $this->createIndex('idx_uploadedfiles_user_user_id', 'uploadedfiles', 'user_id');
       $this->addForeignKey('fk_uploadedfiles_user_user_id', 'uploadedfiles','user_id' , 'user', 'id', 'restrict', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_uploadedfiles_user_user_id', 'uploadedfiles');
        $this->dropIndex('idx_uploadedfiles_user_user_id', 'uploadedfiles');
        
        $this->dropTable('uploadedfiles');
    
}
}
