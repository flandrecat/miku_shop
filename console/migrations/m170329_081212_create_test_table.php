<?php

use yii\db\Migration;

/**
 * Handles the creation of table `test`.
 */
class m170329_081212_create_test_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('test', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('test');
    }
}
