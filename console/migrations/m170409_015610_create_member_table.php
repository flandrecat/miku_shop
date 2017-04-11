<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170409_015610_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),
            'tel'=>$this->char(11)->notNull()->unique()->comment('手机号码'),
            'last_login_ip'=>$this->integer(),
            'last_login_time'=>$this->integer(),
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
