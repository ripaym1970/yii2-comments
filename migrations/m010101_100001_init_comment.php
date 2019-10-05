<?php

use yii\db\Migration;

/**
 * Class m010101_100001_init_comment
 */
class m010101_100001_init_comment extends Migration {

    public $newTableName = 'comment';

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            //ALTER TABLE project_value_company_type CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        }

        // Создание таблицы
        $newTableName = $this->newTableName;
        if ($this->db->driverName === 'pgsql') {
            $newTableName = Yii::$app->params['schema'] . '.' . $newTableName;
        }
        $this->createTable($newTableName, [
            'id' => $this->primaryKey(),

            'entity'     => $this->char(10)->notNull(),
            'entity_id'  => $this->integer()->notNull(),
            'content'    => $this->text()->notNull(),
            'parent_id'  => $this->integer()->null(),
            'level'      => $this->smallInteger()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'related_to' => $this->string(500)->notNull(),
            'url'        => $this->text(),
            'status'     => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-'.$newTableName.'-entity', $newTableName, 'entity');
        $this->createIndex('idx-'.$newTableName.'-status', $newTableName, 'status');
    }

    /**
     * Drop table
     */
    public function safeDown() {
        // Удаление таблицы
        $newTableName = $this->newTableName;
        if ($this->db->driverName === 'pgsql') {
            $newTableName = Yii::$app->params['schema'] . '.'. $newTableName;
        }
        $this->dropTable($newTableName);
    }
}
