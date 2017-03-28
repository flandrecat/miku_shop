<?php

use yii\db\Migration;

/**
 * Handles the creation of table `acticle_category`.
 */
class m170328_104731_create_acticle_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('acticle_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->integer(4)->notNull()->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer(4)->notNull()->defaultValue(20)->comment('排序'),
            'is_help'=>$this->integer(4)->notNull()->defaultValue(1)->comment('是否是帮助相关的分类'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('acticle_category');
    }
}
