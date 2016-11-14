<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `config`.
 */
class m161114_124414_create_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%config}}', [
            'id' => Schema::TYPE_PK,
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_STRING,
            'default_value' => Schema::TYPE_STRING,
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
