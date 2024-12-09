<?php

use yii\db\Migration;

/**
 * Class m241205_154722_create_fulltext_index_on_video
 */
class m241205_154722_create_fulltext_index_on_video extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%products}} ADD FULLTEXT(name,description,price))");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241205_154722_create_fulltext_index_on_video cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241205_154722_create_fulltext_index_on_video cannot be reverted.\n";

        return false;
    }
    */
}
