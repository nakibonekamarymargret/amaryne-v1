<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m241106_092213_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),  // Primary key (auto-increment in PostgreSQL)
            'name' => $this->string(255)->notNull(),  // NOT NULL constraint for name
            'email' => $this->string(100)->notNull()->unique(),  // NOT NULL and unique for email
            'password' => $this->string(255)->notNull(),  // NOT NULL for password
            'role' => $this->string(20)->notNull(),  // NOT NULL for role
            'status' => $this->string(20)->defaultValue('active'),  // Default value for status
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'profileimage' => $this->string(255)->null(),  // Nullable field for profileimage
            'contact' => $this->string(20)->null(),  // Nullable field for contact
            'username' => $this->string(255)->notNull()->unique(),

        ]);

        // Add CHECK constraints for 'role' and 'status' fields
        $this->execute("ALTER TABLE {{%users}} ADD CONSTRAINT chk_role CHECK (role IN ('Admin', 'Customer', 'Salon Owner'))");
        $this->execute("ALTER TABLE {{%users}} ADD CONSTRAINT chk_status CHECK (status IN ('active', 'inactive'))");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
