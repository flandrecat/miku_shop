<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170406_031844_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->unique()->comment('名称'),
            'parent_id'=>$this->integer()->notNull()->defaultValue(0)->comment('上级ID'),
            'url'=>$this->string()->comment('路由'),
            'intro'=>$this->text()->comment('描述'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
