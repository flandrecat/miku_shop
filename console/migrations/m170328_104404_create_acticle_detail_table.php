<?php

use yii\db\Migration;

/**
 * Handles the creation of table `acticle_detail`.
 */
class m170328_104404_create_acticle_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('acticle_detail', [
            'id' => $this->primaryKey(),
            'content'=>$this->text()->comment('文章类容'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('acticle_detail');
    }
}
