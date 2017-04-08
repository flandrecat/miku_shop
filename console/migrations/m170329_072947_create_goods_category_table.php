<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170329_072947_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'tree' => $this->integer()->notNull()->comment('树'),
            'parent_id'=>$this->integer(3)->unsigned()->notNull()->comment('父分类'),
            'lft'=>$this->smallInteger(5)->unsigned()->notNull()->comment('左边界'),
            'rgt'=>$this->smallInteger(5)->unsigned()->notNull()->comment('右边界'),
            'depth' => $this->integer()->unsigned()->notNull()->comment('级别'),
            'intro'=>$this->text()->comment('简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
