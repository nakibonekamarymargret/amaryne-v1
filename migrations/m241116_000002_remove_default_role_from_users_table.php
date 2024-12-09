<?php

use yii\db\Migration;

class m241116_000002_remove_default_role_from_users_table extends Migration
{
    public function up()
    {
        $this->alterColumn('users', 'role', $this->string()->notNull());
    }

    public function down()
    {
        $this->alterColumn('users', 'role', $this->string()->notNull()->defaultValue('admin'));
    }
}
