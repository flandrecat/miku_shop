<?php

use yii\db\Migration;

/**
 * Handles the creation of table `acticle`.
 */
class m170328_103509_create_acticle_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('acticle', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'article_category_id'=>$this->integer(3)->unsigned()->notNull()->defaultValue(0)->comment('文章分类'),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->integer(4)->notNull()->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer(4)->notNull()->defaultValue(20)->comment('排序'),
            'inputtime'=>$this->integer(10)->unsigned()->notNull()->comment('录入时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('acticle');
    }
}
