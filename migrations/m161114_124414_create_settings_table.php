<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `settings`.
 */
class m161114_124414_create_settings_table extends Migration
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

        $this->createTable('{{%settings}}', [
            'id' => Schema::TYPE_PK,
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_STRING,
            'label' => Schema::TYPE_STRING,
            'permanent' => Schema::TYPE_BOOLEAN . ' DEFAULT false',
        ], $tableOptions);

        $this->batchInsert('{{%settings}}', ['key','value', 'label', 'permanent'], [
            ['app_email', '1@promo-pr.ru', 'Email для отправки уведомлений', true],
            ['sms_tel', '', 'Номер телефона для отправки СМС', true],
            ['sms_key', '', 'Секретный ключ СМС-сервиса', true],
            ['org_name', 'Фабрика сайтов', 'Название организации', true],
            ['org_address', 'г.Тольятти', 'Адрес организации', true],
            ['org_email', '', 'Email организации', true],
            ['org_tel', '', 'Номер телефона организации', true],
        ]);

        $this->createIndex('idx-settings-key', '{{%settings}}', 'key', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%settings}}');
    }
}
