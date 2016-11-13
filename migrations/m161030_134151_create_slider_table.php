<?php

use yii\db\Migration;

/**
 * Handles the creation of table `slider`.
 */
class m161030_134151_create_slider_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%slider}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'title' => $this->string()->notNull(),
            'body' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%slider_item}}', [
            'id' => $this->primaryKey(),
            'slider_id' => $this->integer(),
            'fid' => $this->integer(),
            'title' => $this->string(),
            'body' => $this->text(),
            'sort_order' => $this->smallInteger(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%slider}}');
        $this->dropTable('{{%slider_item}}');
    }
}
