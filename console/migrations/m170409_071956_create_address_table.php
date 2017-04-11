<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170409_071956_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('收货人'),
            'area_name'=>$this->string()->notNull()->comment('所在地区'),
            'address'=>$this->string()->notNull()->comment('详细地址'),
            'tel'=>$this->char(11)->notNull()->comment('手机号码'),
            'status'=>$this->integer(1)->comment('状态'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
