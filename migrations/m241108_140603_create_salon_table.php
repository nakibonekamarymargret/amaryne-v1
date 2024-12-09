<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%salon}}`.
 */
class m241108_140603_create_salon_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE {{%salon}} (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            owner_id INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
            status VARCHAR(20) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
            type VARCHAR(20),
            address VARCHAR(255),
            description TEXT,
            image VARCHAR(255),
            working_days JSONB,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    }

    public function safeDown()
    {
        $this->dropTable('{{%salon}}');
    }
}
