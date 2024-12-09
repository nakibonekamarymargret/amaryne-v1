<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services}}`.
 */
class m241108_142550_create_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE {{%services}} (
            id SERIAL PRIMARY KEY,
            salon_id INTEGER NOT NULL REFERENCES {{%salon}}(id) ON DELETE CASCADE, -- Updated table name
            name VARCHAR(100) NOT NULL,
            description TEXT,
            price DECIMAL(10, 2) NOT NULL,
            status VARCHAR(20) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
            image VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%services}}');
    }
}
