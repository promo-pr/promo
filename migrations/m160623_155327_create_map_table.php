<?php

use yii\db\Migration;

class m160623_155327_create_map_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%map}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'preset' => $this->string(),
            'body' => $this->text(),
            'point' => $this->string(),
            'zoom' => $this->smallInteger(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%map}}');
    }
}
