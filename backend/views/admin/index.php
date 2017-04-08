<?php
echo '<h3>管理员</h3>';
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/3/27
 * Time: 9:30
 */
echo \yii\bootstrap\Html::a('增加用户',['admin/add'],['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a('注销',['admin/logout'],['class'=>'btn btn-warning']);
?>
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>最后登录时间</th>
            <th>最后登录IP</th>
            <th>操作</th>
        </tr>
        <?php foreach($admins as $admin):?>
            <tr>
                <td><?=$admin->id?></td>
                <td><?=$admin->username?></td>
                <td><?=$admin->email?></td>
                <td><?=date('Y-m-d h:i:s',$admin->last_login_time)?></td>
                <td><?=$admin->last_login_ip?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('修改',['admin/edit','id'=>$admin->id],['class'=>'btn btn-success'])?>
                    <?=\yii\bootstrap\Html::a('删除',['admin/delete','id'=>$admin->id],['class'=>'btn btn-danger'])?></td>
            </tr>
        <?php endforeach;?>
    </table>
<?php
echo    \yii\widgets\LinkPager::widget([
    'pagination'=>$pages,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);

