<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public $tableOptions;

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // databases
        $this->createTable('{{%databases}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'dsn' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'dbname' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'dbms_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'username' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'password' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'title' => Schema::TYPE_STRING . " NULL COMMENT ''",
        ], $this->tableOptions);

// dbms
        $this->createTable('{{%dbms}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
        ], $this->tableOptions);

// events
        $this->createTable('{{%events}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'trigger_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'time_to_start' => Schema::TYPE_TIME . " NULL COMMENT ''",
            'is_show' => Schema::TYPE_INTEGER . " NULL DEFAULT '0' COMMENT ''",
            'success_result' => Schema::TYPE_STRING . "(255) NULL DEFAULT '0' COMMENT ''",
            'compare_exp' => Schema::TYPE_INTEGER . " NULL COMMENT ''",
        ], $this->tableOptions);

// events_result_expressions
        $this->createTable('{{%events_result_expressions}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'expression' => Schema::TYPE_STRING . "(50) NOT NULL COMMENT ''",
            'php_equal' => Schema::TYPE_STRING . "(255) NULL COMMENT ''",
        ], $this->tableOptions);

// messages
        $this->createTable('{{%messages}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'message' => Schema::TYPE_STRING . " NULL COMMENT ''",
            'trigger_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'created_date' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT now() COMMENT ''",
            'event_id' => Schema::TYPE_INTEGER . " NULL COMMENT ''",
            'message_type' => Schema::TYPE_STRING . "(100) NULL COMMENT ''",
            'result_value' => Schema::TYPE_STRING . " NULL COMMENT ''",
        ], $this->tableOptions);

// projects
        $this->createTable('{{%projects}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'title' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'description' => Schema::TYPE_TEXT . " NOT NULL COMMENT ''",
            'logo' => Schema::TYPE_STRING . "(255) NULL COMMENT ''",
        ], $this->tableOptions);

// sections
        $this->createTable('{{%sections}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'title' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'project_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
        ], $this->tableOptions);

// settings
        $this->createTable('{{%settings}}', [
            'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'value' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'title' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT '' COMMENT ''",
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

// triggers
        $this->createTable('{{%triggers}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'title' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'description' => Schema::TYPE_TEXT . " NOT NULL COMMENT ''",
            'importance' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'last_launch' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT now() COMMENT ''",
            'db_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'section_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'user_create' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'is_active' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'trigger_type' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'code' => Schema::TYPE_TEXT . " NOT NULL COMMENT ''",
            'success_result' => Schema::TYPE_STRING . "(255) NULL COMMENT ''",
        ], $this->tableOptions);

// triggers_importance
        $this->createTable('{{%triggers_importance}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'title' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'color' => Schema::TYPE_STRING . " NULL COMMENT ''",
        ], $this->tableOptions);

// triggers_observers
        $this->createTable('{{%triggers_observers}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'trigger_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'email' => Schema::TYPE_STRING . "(100) NOT NULL COMMENT ''",
        ], $this->tableOptions);

// triggers_types
        $this->createTable('{{%triggers_types}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'title' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
        ], $this->tableOptions);

// user
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK . " COMMENT ''",
            'username' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'auth_key' => Schema::TYPE_STRING . "(32) NOT NULL COMMENT ''",
            'password_hash' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'password_reset_token' => Schema::TYPE_STRING . "(255) NULL COMMENT ''",
            'email' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT ''",
            'status' => Schema::TYPE_SMALLINT . " NOT NULL DEFAULT '10' COMMENT ''",
            'created_at' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'updated_at' => Schema::TYPE_INTEGER . " NOT NULL COMMENT ''",
            'role' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT 'observer' COMMENT ''",
        ], $this->tableOptions);

// fk: databases
        $this->addForeignKey('fk_databases_dbms_id', '{{%databases}}', 'dbms_id', '{{%dbms}}', 'id');

// fk: events
        $this->addForeignKey('fk_events_compare_exp', '{{%events}}', 'compare_exp', '{{%events_result_expressions}}', 'id');
        $this->addForeignKey('fk_events_trigger_id', '{{%events}}', 'trigger_id', '{{%triggers}}', 'id');

// fk: messages
        $this->addForeignKey('fk_messages_event_id', '{{%messages}}', 'event_id', '{{%events}}', 'id');
        $this->addForeignKey('fk_messages_trigger_id', '{{%messages}}', 'trigger_id', '{{%triggers}}', 'id');

// fk: sections
        $this->addForeignKey('fk_sections_project_id', '{{%sections}}', 'project_id', '{{%projects}}', 'id');

// fk: triggers
        $this->addForeignKey('fk_triggers_db_id', '{{%triggers}}', 'db_id', '{{%databases}}', 'id');
        $this->addForeignKey('fk_triggers_section_id', '{{%triggers}}', 'section_id', '{{%sections}}', 'id');


        // Заполнение справочников
        $this->batchInsert('dbms', ['id', 'name'], [
            [1, 'MySQL'],
            [2, 'PostgreSQL'],
            [3, 'MSSQL-server'],
            [4, 'Oracle']
        ]);

        $this->batchInsert('events_result_expressions', ['id', 'expression', 'php_equal'], [
            [1, '>', '>'],
            [2, '>=', '>='],
            [3, '<', '<'],
            [4, '<=', '<='],
            [5, '=', '=='],
            [6, '<>', '!='],
        ]);

        $this->batchInsert('triggers_importance', ['id', 'title', 'color'], [
            [2, 'Обычный', '#20A01A'],
            [3, 'Важный', '#D0B41D'],
            [4, 'Очень важный', '#D07B1D'],
            [5, 'Критический', '#D01D1D'],
        ]);

        $this->batchInsert('triggers_types', ['id', 'title'], [
            [1, 'SQL-код (скалярное значение)'],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
