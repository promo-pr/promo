<?php

use yii\db\Migration;

/**
 * Handles the creation for table `files_table`.
 */
class m160612_193004_create_files_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%files}}', [
            'fid' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'uri' => $this->string(),
            'model_name' => $this->string(),
            'model_id' => $this->integer(),
            'attribute' => $this->string(),
            'mime' => $this->string(),
            'size' => $this->integer(),
            'created_at' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions);
        
        $this->createIndex('idx-files-uri', '{{%files}}', 'uri');
    }

    public function down()
    {
        $this->dropTable('{{%files}}');
    }
}
