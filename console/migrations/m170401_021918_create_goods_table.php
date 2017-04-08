<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170401_021918_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey()->unsigned(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'sn'=>$this->string(30)->notNull()->comment('货号'),
            'logo'=>$this->string()->notNull()->comment('商品logo'),
            'goods_category_id'=>$this->integer(5)->unsigned()->notNull()->comment('商品分类'),
            'brand_id'=>$this->integer(5)->unsigned()->unsigned()->comment('品牌'),
            'market_price'=>$this->decimal(10,2)->unsigned()->unsigned()->defaultValue(0.00)->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->unsigned()->unsigned()->defaultValue(0.00)->comment('本店价格'),
            'stock'=>$this->integer(11)->notNull()->defaultValue(0)->comment('库存'),
            'in_on_sale'=>$this->integer(4)->notNull()->defaultValue(1)->comment('是否上架1是 0否'),
            'status'=>$this->integer(4)->notNull()->defaultValue(1)->comment('1正常 0回收站'),
            'sort'=>$this->integer(4)->notNull()->defaultValue(20)->comment('排序'),
            'inputtime'=>$this->integer(20)->notNull()->defaultValue(0)->comment('录入时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
